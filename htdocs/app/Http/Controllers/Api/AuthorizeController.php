<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2018/7/2
 * Time: 16:18
 */

namespace App\Http\Controllers\Api;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Http\Request;
use App\Rules\AuthorizeRule;
use App\Exceptions\ParamsException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Common;
use App\Http\Model\UsersAddressModel;
use App\Rules\CardRule;
use App\Http\Model\OrderModel;
use App\Http\Model\ProductModel;
use App\Http\Model\UsersModel;
use App\Rules\InvoiceRule;

require_once(app_path() . DIRECTORY_SEPARATOR . 'Authorize' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

//define("AUTHORIZENET_LOG_FILE","phplog");

class AuthorizeController
{

    public function pay (Request $request)
    {

        (new AuthorizeRule)->goCheck(200);

        $params = $request->all();

//         $number = 4833160127655006;
//        $number = 5424000000000015;

        $customerAddress = new AnetAPI\CustomerAddressType();
        //填写信息
        $invoice = json_decode(OrderModel::where('order_no', '=', $params['order'])->first(['snap_address'])->snap_address);


        if (!empty($invoice->name)) {
            $customerAddress->setFirstName($invoice->name);
            $customerAddress->setLastName('');
            $customerAddress->setAddress($invoice->country . $invoice->detail);
            $customerAddress->setState($invoice->province);
            $customerAddress->setCountry('');
        } else {
            $customerAddress->setFirstName($invoice->firstName);
            $customerAddress->setLastName($invoice->lastName);
            $customerAddress->setAddress($invoice->address);
            $customerAddress->setState($invoice->state);
            $customerAddress->setCountry($invoice->country);
        }

        $customerAddress->setCompany(!empty($invoice->company) ? $invoice->company : '');
        $customerAddress->setCity($invoice->city);
        $customerAddress->setZip($invoice->zip);

//        if ($params['status'] != 1) {
//
//            (new CardRule)->goCheck(200);
//
//            $customerAddress->setFirstName($params['firstName']);
//            $customerAddress->setLastName($params['lastName']);
//            $customerAddress->setCompany(!empty($params['company']) ? $params['company'] : '');
//            $customerAddress->setAddress($params['address']);
//            $customerAddress->setCity($params['city']);
//            $customerAddress->setState($params['state']);
//            $customerAddress->setZip($params['zip']);
//            $customerAddress->setCountry($params['country']);
//        } else {
//
//            //默认地址
//            $user = UsersAddressModel::getUserAddress($params['id']);
//            $customerAddress->setFirstName($user->name);
//            $customerAddress->setLastName('');
//            $customerAddress->setCompany('');
//            $customerAddress->setAddress($user->country . $user->detail);
//            $customerAddress->setCity($user->city);
//            $customerAddress->setState($user->province);
//            $customerAddress->setZip($user->zip);
//            $customerAddress->setCountry('');
//        }
//
        $host = config('custom.authorize_status') != 'YES' ? \net\authorize\api\constants\ANetEnvironment::SANDBOX : \net\authorize\api\constants\ANetEnvironment::PRODUCTION;

        // API证书的通用设置
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();

        //设置新名称
        $merchantAuthentication->setName(config('custom.Authorize_login_id'));
        //设置一个新的事务密钥
        $merchantAuthentication->setTransactionKey(config('custom.Authorize_key'));

        $refId = 'ref' . time();

// 创建信用卡支付数据
        $creditCard = new AnetAPI\CreditCardType();
        //设置新的卡号
        $creditCard->setCardNumber($params['card']);
        //设置新的到期日期
        $creditCard->setExpirationDate($params['date']);
        //CardCode 卡代码
        $creditCard->setcardCode($params['code']);
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // 将客户帐单设置为地址 银行地址
//        $customerAddress = new AnetAPI\CustomerAddressType();
//        $customerAddress->setFirstName("Ellen");
//        $customerAddress->setLastName("Johnson");
//        $customerAddress->setCompany("Souveniropolis");
//        $customerAddress->setAddress("14 Main Street");
//        $customerAddress->setCity("Pecan Springs");
//        $customerAddress->setState("TX");
//        $customerAddress->setZip("44628");
//        $customerAddress->setCountry("USA");

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        //id
        $customerData->setId($params['id']);
        //email
//        $customerData->setEmail("EllenJohnson@example.com");


        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($params['order']);
        $order->setDescription("pay");

        // Add values for transaction settings
        $duplicateWindowSetting = new AnetAPI\SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("60");

// 创建事务
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        //设置事务类型
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        //设定金额
        $transactionRequestType->setAmount($params['money']);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
        $transactionRequestType->setOrder($order);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

//        dd($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
//        dd($controller);
        $response = $controller->executeWithApiResponse($host);
//        dd($response);
        if ($response != null) {
            $tresponse = $response->getTransactionResponse();

            if (($tresponse != null) && ($tresponse->getResponseCode() == "1")) {
////                dd($tresponse);
//                echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
//                echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
//                echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
//                echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
//                echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";

                $this->NotifyProcess($params['order']);

                return Common::successData();

            } else {
                //收费信用卡错误：无效响应
                Log::error($params['card'] . '收费信用卡错误：无效响应');

                throw new ParamsException([
                    'message' => '收费信用卡错误：无效响应',
                    'errorCode' => 7001
                ]);

            }
        } else {
            //费用信用卡无效应答返回
            Log::error($params['card'] . '费用信用卡无效应答返回');

            throw new ParamsException([
                'message' => '费用信用卡无效应答返回',
                'errorCode' => 7001
            ]);

        }
    }

    //获取authorize token 用于表单形式
    public function authorizeToken (Request $request)
    {

//        (new AuthorizeRule)->goCheck(200);

//        $params = $request->all();
        $params['id'] = $params['order'] = 124234;
        $params['money'] = 0.01;
        //沙盒
        if (config('custom.authorize_status') != 'YES') {

            $host = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
            $requestUrl = config('custom.authorize_sandbox_url');
        } else {

            $host = \net\authorize\api\constants\ANetEnvironment::PRODUCTION;
            $requestUrl = config('custom.authorize_accept_url');
        }

        $url = config('custom.img_url') . config('custom.DIRECTORY_SEPARATOR') . 'apps' . $params['order'];

        $cancelUrl = config('custom.img_url') . config('custom.DIRECTORY_SEPARATOR') . 'apps/user/' . $params['id'];

        /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('custom.Authorize_login_id'));
        $merchantAuthentication->setTransactionKey(config('custom.Authorize_key'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        //create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($params['money']);

        //设置托管窗体选项
        $setting1 = new AnetAPI\SettingType();
        $setting1->setSettingName("hostedPaymentButtonOptions");
        $setting1->setSettingValue("{\"text\": \"Pay\"}");

        $setting2 = new AnetAPI\SettingType();
        $setting2->setSettingName("hostedPaymentOrderOptions");
        $setting2->setSettingValue("{\"show\": false}");

        //点击返回 cancelUrl 成功 url
        $setting3 = new AnetAPI\SettingType();
        $setting3->setSettingName("hostedPaymentReturnOptions");
        $setting3->setSettingValue(
//            "{\"url\": \"https://mysite.com/receipt\", \"cancelUrl\": \"https://mysite.com/cancel\", \"showReceipt\": true}"
            "{\"url\": \"$url\", \"cancelUrl\": \"$cancelUrl\", \"showReceipt\": true}"

        );

        // Build transaction request
        $request = new AnetAPI\GetHostedPaymentPageRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        $request->addToHostedPaymentSettings($setting1);
        $request->addToHostedPaymentSettings($setting2);
        $request->addToHostedPaymentSettings($setting3);


        //execute request
        $controller = new AnetController\GetHostedPaymentPageController($request);
        $response = $controller->executeWithApiResponse($host);


        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
//            dd($response->getToken());
//            return Common::successData(['token' => $response->getToken(),'requestUrl' => $requestUrl]);

            return view('admin.catch.catch-pay', ['token' => $response->getToken()]);
        } else {
            $err = [
                'message' => $response->getMessages()->getMessage(),
                'text' => $errorMessages[0]->getText(),
                'code' => $errorMessages[0]->getCode()
            ];
            Log::error('authorize未能获得托管支付页令牌', $err);

            throw new ParamsException([
                'message' => 'authorize未能获得托管支付页令牌'
            ]);
        }

    }


    //修改订单状态
    public function NotifyProcess ($orderNo)
    {


        $order = OrderModel::where('order_no', '=', $orderNo)->first();
        //未支付 修改相关表状态
        if ($order->status == 2) {

            ProductModel::updateProductStock($order->id);
            $res = OrderModel::where('id', '=', $order->id)->update(['status' => 1]);

            if (!$res) {

                Log::error('authorize订单状态修改失败', $params);

                return;
            }
            $userAddress = UsersAddressModel::getUserAddress($order->users_id);
            $userIfo = UsersModel::getUserInfo($order->users_id);

            $snapshootOrder = [
                'pStatus' => json_decode($order->snap_items, true),
                'snapshootAddress' => $order->snap_address,
                'orderPrice' => $order->total_price,
                'freight' => $order->freight,
                'allCount' => $order->total_count
            ];
            Common::sendEmail($userIfo->email, $userIfo->name, $userAddress->name, $userAddress->mobile, $order->order_no, $order->snap_name, $snapshootOrder);

        }
    }

    //authorize 账单上传接口
    public function authorizeInvoice (Request $request)
    {
        (new InvoiceRule)->goCheck(200);

        $params = $request->all();
        //status 1 : 填写信息 2 ：使用默认
        if ($params['status'] != 1) {
            //默认收货地址
            $data = UsersAddressModel::getUserAddress($params['userId']);

            if (is_null($data)) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '用户收货地址不存在或没设置默认地址',
                    'errorCode' => 6001
                ]);
            }

        } else {

            (new CardRule)->goCheck(200);

            $data = [];
            $data = [
                'firstName' => $params['firstName'],
                'lastName' => $params['lastName'],
                'company' => !empty($params['company']) ? $params['company'] : '',
                'address' => $params['address'],
                'city' => $params['city'],
                'state' => $params['state'],
                'zip' => $params['zip'],
                'mobile' => $params['mobile'],
                'country' => $params['country']
            ];
        }
        $res = OrderModel::where('order_no', '=', $params['orderId'])->update(['invoice_address' => json_encode($data)]);


        if (!$res) {
            throw new ParamsException([
                'code' => 200,
                'message' => '订单号查询不到'
            ]);
        }
        return Common::successData();
    }

}