@extends('/app/layouts.app')

@section('content')
<!--信用卡验证插件-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>-->
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
        <style type="text/css">
            .float_left{
            		float: left;
            }
            .float_right{
            		float: right;
            		}
             .clearfloat:after{display:block;clear:both;content:"";visibility:hidden;height:0}
  			 .clearfloat{zoom:1}
  			 .d{
  			 	width: 18px;
  			 	height: 18px;
  			 	border: 1px solid gray;
  			 	border-radius: 50%;
  			 	overflow: hidden;
  			 }
  			 .activeId{
  			 	background: #f14067;
  			 }
	        .towline{
	            overflow: hidden;
	            text-overflow: ellipsis;
	            display: -webkit-box !important;
	            -webkit-line-clamp: 2;
	            -webkit-box-orient: vertical;
	        }
	        .icon_height{
	        	height: 28px;
	        }
	        #information .modal-dialog {
	        	max-height: 550px;
	        	overflow: scroll;
	        }
        </style><!--信用卡样式-->
		<style>
			body {
				margin: 0;
				padding: 0;
				background-color: #f9f9f9;
				display: -webkit-box;
				display: -ms-flexbox;
				display: flex;
				-ms-flex-line-pack: center;
				align-content: center;
				-webkit-box-align: center;
				-ms-flex-align: center;
				align-items: center;
				-webkit-box-pack: center;
				-ms-flex-pack: center;
				justify-content: center;
				min-height: 100vh;
				-ms-flex-wrap: wrap;
				flex-wrap: wrap;
				font-family: 'Raleway';
			}
			
			.payment-title {
				width: 100%;
				text-align: center;
			}
			
			.form-container .field-container:first-of-type {
				grid-area: name;
			}
			
			.form-container .field-container:nth-of-type(2) {
				grid-area: number;
			}
			
			.form-container .field-container:nth-of-type(3) {
				grid-area: expiration;
			}
			
			.form-container .field-container:nth-of-type(4) {
				grid-area: security;
			}
			
			.field-container input {
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
			}
			
			.field-container {
				position: relative;
			}
			
			.form-container {
				display: grid;
				grid-column-gap: 10px;
				grid-template-columns: auto auto;
				grid-template-rows:60px 60px 60px;
				grid-template-areas: "name name""number number""expiration security";
				/*grid-template-areas: "number number""expiration security";*/
				max-width: 400px;
				padding: 20px;
				padding-bottom: 0;
				color: #707070;
			}
			
			.form-container label {
				/*padding-bottom: 5px;*/
				font-size: 13px;
			}
			
			.form-container input {
				/*margin-top: 3px;*/
				/*padding: 10px;*/
    				padding: 2px 10px;
				font-size: 16px;
				width: 100%;
				border-radius: 3px;
				border: 1px solid #dcdcdc;
			}
			
			.ccicon {
				height: 38px;
				position: absolute;
				right: 6px;
				top: calc(50% - 17px);
				width: 60px;
			}
			/* CREDIT CARD IMAGE STYLING */
			
			.preload * {
				-webkit-transition: none !important;
				-moz-transition: none !important;
				-ms-transition: none !important;
				-o-transition: none !important;
			}
			
			.container1 {
				width: 100%;
				max-width: 400px;
				max-height: 251px;
				height: 54vw;
				padding: 20px;
			}
			
			#ccsingle {
				position: absolute;
				right: 15px;
				top: 20px;
			}
			
			#ccsingle svg {
				width: 100px;
				max-height: 60px;
			}
			
			.creditcard svg#cardfront,
			.creditcard svg#cardback {
				width: 100%;
				-webkit-box-shadow: 1px 5px 6px 0px black;
				box-shadow: 1px 5px 6px 0px black;
				border-radius: 22px;
			}
			
			#generatecard {
				cursor: pointer;
				float: right;
				font-size: 12px;
				color: #fff;
				padding: 2px 4px;
				background-color: #909090;
				border-radius: 4px;
				cursor: pointer;
				float: right;
			}
			/* CHANGEABLE CARD ELEMENTS */
			
			.creditcard .lightcolor,
			.creditcard .darkcolor {
				-webkit-transition: fill .5s;
				transition: fill .5s;
			}
			
			.creditcard .lightblue {
				fill: #03A9F4;
			}
			
			.creditcard .lightbluedark {
				fill: #0288D1;
			}
			
			.creditcard .red {
				fill: #ef5350;
			}
			
			.creditcard .reddark {
				fill: #d32f2f;
			}
			
			.creditcard .purple {
				fill: #ab47bc;
			}
			
			.creditcard .purpledark {
				fill: #7b1fa2;
			}
			
			.creditcard .cyan {
				fill: #26c6da;
			}
			
			.creditcard .cyandark {
				fill: #0097a7;
			}
			
			.creditcard .green {
				fill: #66bb6a;
			}
			
			.creditcard .greendark {
				fill: #388e3c;
			}
			
			.creditcard .lime {
				fill: #d4e157;
			}
			
			.creditcard .limedark {
				fill: #afb42b;
			}
			
			.creditcard .yellow {
				fill: #ffeb3b;
			}
			
			.creditcard .yellowdark {
				fill: #f9a825;
			}
			
			.creditcard .orange {
				fill: #ff9800;
			}
			
			.creditcard .orangedark {
				fill: #ef6c00;
			}
			
			.creditcard .grey {
				fill: #bdbdbd;
			}
			
			.creditcard .greydark {
				fill: #616161;
			}
			/* FRONT OF CARD */
			
			#svgname {
				text-transform: uppercase;
			}
			
			#cardfront .st2 {
				fill: #FFFFFF;
			}
			
			#cardfront .st3 {
				font-family: 'Source Code Pro', monospace;
				font-weight: 600;
			}
			
			#cardfront .st4 {
				font-size: 54.7817px;
			}
			
			#cardfront .st5 {
				font-family: 'Source Code Pro', monospace;
				font-weight: 400;
			}
			
			#cardfront .st6 {
				font-size: 33.1112px;
			}
			
			#cardfront .st7 {
				opacity: 0.6;
				fill: #FFFFFF;
			}
			
			#cardfront .st8 {
				font-size: 24px;
			}
			
			#cardfront .st9 {
				font-size: 36.5498px;
			}
			
			#cardfront .st10 {
				font-family: 'Source Code Pro', monospace;
				font-weight: 300;
			}
			
			#cardfront .st11 {
				font-size: 16.1716px;
			}
			
			#cardfront .st12 {
				fill: #4C4C4C;
			}
			/* BACK OF CARD */
			
			#cardback .st0 {
				fill: none;
				stroke: #0F0F0F;
				stroke-miterlimit: 10;
			}
			
			#cardback .st2 {
				fill: #111111;
			}
			
			#cardback .st3 {
				fill: #F2F2F2;
			}
			
			#cardback .st4 {
				fill: #D8D2DB;
			}
			
			#cardback .st5 {
				fill: #C4C4C4;
			}
			
			#cardback .st6 {
				font-family: 'Source Code Pro', monospace;
				font-weight: 400;
			}
			
			#cardback .st7 {
				font-size: 27px;
			}
			
			#cardback .st8 {
				opacity: 0.6;
			}
			
			#cardback .st9 {
				fill: #FFFFFF;
			}
			
			#cardback .st10 {
				font-size: 24px;
			}
			
			#cardback .st11 {
				fill: #EAEAEA;
			}
			
			#cardback .st12 {
				font-family: 'Rock Salt', cursive;
			}
			
			#cardback .st13 {
				font-size: 37.769px;
			}
			/* FLIP ANIMATION */
			
			.container1 {
				perspective: 1000px;
			}
			
			.creditcard {
				width: 100%;
				max-width: 400px;
				-webkit-transform-style: preserve-3d;
				transform-style: preserve-3d;
				transition: -webkit-transform 0.6s;
				-webkit-transition: -webkit-transform 0.6s;
				transition: transform 0.6s;
				transition: transform 0.6s, -webkit-transform 0.6s;
				cursor: pointer;
			}
			
			.creditcard .front,
			.creditcard .back {
				position: absolute;
				width: 100%;
				max-width: 400px;
				-webkit-backface-visibility: hidden;
				backface-visibility: hidden;
				-webkit-font-smoothing: antialiased;
				color: #47525d;
			}
			
			.creditcard .back {
				-webkit-transform: rotateY(180deg);
				transform: rotateY(180deg);
			}
			
			.creditcard.flipped {
				-webkit-transform: rotateY(180deg);
				transform: rotateY(180deg);
			}
			#paidAddress input{
				line-height: 30px;
			}
		</style>
<div id="ppp" style="display: none;"></div>
	<div class="container py-2 bg-light fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="javascript:history.back(-1);"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("订单详情","Order Details")
                </script></h6>
			<a href="/apps/user/{{ Auth::guard("pc")->user()->id }}" class="top-nav-item"><i class="fa fa-user"></i></a>
		</div>
	</div>

	<div class="top-fix"></div>

	<div class="container main-container cartBox " style="padding-bottom: 100px;">
		<!-- shangpin -->
						<div class="row border-bottom bg-white pt-2 pl-3 bg-white"style="padding: 0;"><p class="text-muted my-0 pb-1">
                	<script type="text/javascript">
                	Language("收货地址","Shipping Address")
                </script></p></div>
							<div class="row py-2 bg-white">
								<div class="col-9">
							        <div class="line-normal-wrapper clearfloat row bg-white">
							            <small class="float_left py-1 px-3 text-muted"style="padding: 0 3%;"id="name"></small>
							            <small class="float_left py-1 px-3 text-muted" style="text-align: right;padding: 0 3%;"id="mobile"></small>
							            <small class="float_left py-1 px-3 text-muted twoLine" style="width: 100%;padding: 0 3%;"id="addressDetail"></small>
							        </div>
								</div>
								<div class="col-3 bg-white">
									<!-- <div class="line-normal-wrapper clearfloat row bg-white">
							            <small class="px-2 py-3 text-muted addAddress" ><a>
                	<script type="text/javascript">
                	Language("修改地址","Edit Address ")
                </script></a></small>
									</div> -->
								</div>
							</div>
						</div>

	<!-- 结算 Container -->
    <div class="container">
      <div class="row checkout-bar align-items-center" style="z-index: ;">
        <div class="col-3 pl-5">
        </div>
        <div class="col-5 text-right">
        	<a class="text-dark" id="total_btn"ef="##">
        		<i class="fa fa-angle-up"></i>
	        	<small id="orderId">
                	<script type="text/javascript">
                	Language("订单号 :","Order Number :")
                </script><span></span> </small>
	        	<small class="text-red total" id="totalPrice">$ <span>00.00</span></small>
	        </a>
        </div>
        <div class="col-4 h-100 w-100">
        	<button class="btn btn-red rounded-0 btn-check-out Settlement"></i> 
                	<script type="text/javascript">
                	Language("结算","Check out")
                </script></button>


        </div>

      </div>
    </div><!-- End 结算 Container -->
	    	<!--支付模态框-->
	        <div class="modal fade bs-example-modal-sm "id="showx" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content py-4"id="show_text"style="padding: 2% 5%">
			    		<!--<input id="paypal" class="btn btn btn-block btn-primary my-2" value="paypal支付" type="button"/>-->
			    		<a class="btn  btn-primary shaddow-dark my-2 text-white" id="paypal" ><img class="icon_height mr-2" src="https://png.icons8.com/color/50/000000/paypal.png">
                	<script type="text/javascript">
                	Language("paypal支付","Pay with PayPal")
                </script></a>
			    		<a class="btn  shaddow-dark my-2 bg-muted" id="wechatpay" style="display" ><img class="icon_height mr-2" src="https://png.icons8.com/color/50/000000/weixing.png">
                	<script type="text/javascript">
                	Language("微信支付"," Pay with WeChat Pay")
                </script></a>
			    		<a class="btn  btn-primary  shaddow-dark my-2 text-white" id="alipay" ><img class="icon_height mr-2" src="{{ asset('image/ali.png') }}">
                	<script type="text/javascript">
                	Language("支付宝支付","Pay with Alipay ")
                </script></a>
			    		<a class="btn  btn-primary shaddow-dark my-2 text-white" id="credit_card" ><img class="icon_height mr-2"  src="https://png.icons8.com/color/50/000000/bank-cards.png">
                	<script type="text/javascript">
                	Language("信用卡支付","Pay with Credit Card")
                </script></a>
			    		<!--<img class="icon_height" src="https://png.icons8.com/color/50/000000/weixing.png">
			    			<img class="icon_height" src="https://png.icons8.com/color/50/000000/bank-cards.png">-->
			    		<!--<input id="alipay" class="btn btn btn-block btn-primary my-2" value="支付宝" type="button"/>
			    		<input id="wechatpay" class="btn btn btn-block  my-2" value="微信" type="button"/>
			    		<input id="credit_card" class="btn btn btn-block btn-primary my-2" value="信用卡支付" type="button"/>-->
			    </div>
			  </div>
			</div>
		<!--信用卡填写信息模态框-->
	        <div class="modal fade bs-example-modal-sm "id="credit_card_show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content py-4"id=""style="padding: 2% 5%;">    
                        
                        <!--信用卡html-->
                        
		<div class="container1 preload">
			<div class="creditcard">
				<div class="front">
					<div id="ccsingle"></div>
					<svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
						<g id="Front">
							<g id="CardBackground">
								<g id="Page-1_1_">
									<g id="amex_1_">
										<path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                            C0,17.9,17.9,0,40,0z" />
									</g>
								</g>
								<path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
							</g>
							<text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4">0123 4567 8910 1112</text>
							<text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6">JOHN DOE</text>
							<text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
							<text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
							<text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
							<g>
								<text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9">01/23</text>
								<text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
								<text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
								<polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
							</g>
							<g id="cchip">
								<g>
									<path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                        c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
								</g>
								<g>
									<g>
										<rect x="82" y="70" class="st12" width="1.5" height="60" />
									</g>
									<g>
										<rect x="167.4" y="70" class="st12" width="1.5" height="60" />
									</g>
									<g>
										<path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                            c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                            C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                            c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                            c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
									</g>
									<g>
										<rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
									</g>
									<g>
										<rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
									</g>
									<g>
										<rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
									</g>
									<g>
										<rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
									</g>
								</g>
							</g>
						</g>
						<g id="Back">
						</g>
					</svg>
				</div>
				<div class="back">
					<svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
						<g id="Front">
							<line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
						</g>
						<g id="Back">
							<g id="Page-1_2_">
								<g id="amex_2_">
									<path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                        C0,17.9,17.9,0,40,0z" />
								</g>
							</g>
							<rect y="61.6" class="st2" width="750" height="78" />
							<g>
								<path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                    C707.1,246.4,704.4,249.1,701.1,249.1z" />
								<rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
								<rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
								<path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
							</g>
							<text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">985</text>
							<g class="st8">
								<text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">security code</text>
							</g>
							<rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
							<rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
							<text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13">John Doe</text>
						</g>
					</svg>
				</div>
			</div>
		</div>
		<div class="form-container">
			<div class="field-container">
				<label for="name">
				<script>
					Language("姓名","Name")
				</script>
				</label>
				<input id="name1" maxlength="20" type="text">
			</div>
			<div class="field-container">
				<label for="cardnumber">
				<script>
					Language("卡号","Card Number")
				</script>
				</label>
				<span id="generatecard" style="display: none;">generate random</span>
				<input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric">
				<svg style="display: none;" id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

				</svg>
			</div>
			<div class="field-container">
				<label for="expirationdate">
				<script>
					Language("截止日期","Expiration Date ")
				</script>
				(mm/yy)
				</label>
				<input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric">
			</div>
			<div class="field-container">
				<label for="securitycode">
				<script>
					Language("卡号安全码","Security Code ")
				</script>
				</label>
				<input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric">
			</div>
		</div>
	<!--</body>-->
	<script type="text/javascript">
		window.onload = function () {

const name = document.getElementById('name1');
const cardnumber = document.getElementById('cardnumber');
const expirationdate = document.getElementById('expirationdate');
const securitycode = document.getElementById('securitycode');
const output = document.getElementById('output');
const ccicon = document.getElementById('ccicon');
const ccsingle = document.getElementById('ccsingle');
const generatecard = document.getElementById('generatecard');


let cctype = null;

//Mask the Credit Card Number Input
var cardnumber_mask = new IMask(cardnumber, {
    mask: [
        {
            mask: '0000 000000 00000',
            regex: '^3[47]\\d{0,13}',
            cardtype: 'american express'
        },
        {
            mask: '0000 0000 0000 0000',
            regex: '^(?:6011|65\\d{0,2}|64[4-9]\\d?)\\d{0,12}',
            cardtype: 'discover'
        },
        {
            mask: '0000 000000 0000',
            regex: '^3(?:0([0-5]|9)|[689]\\d?)\\d{0,11}',
            cardtype: 'diners'
        },
        {
            mask: '0000 0000 0000 0000',
            regex: '^(5[1-5]\\d{0,2}|22[2-9]\\d{0,1}|2[3-7]\\d{0,2})\\d{0,12}',
            cardtype: 'mastercard'
        },
        // {
        //     mask: '0000-0000-0000-0000',
        //     regex: '^(5019|4175|4571)\\d{0,12}',
        //     cardtype: 'dankort'
        // },
        // {
        //     mask: '0000-0000-0000-0000',
        //     regex: '^63[7-9]\\d{0,13}',
        //     cardtype: 'instapayment'
        // },
        {
            mask: '0000 000000 00000',
            regex: '^(?:2131|1800)\\d{0,11}',
            cardtype: 'jcb15'
        },
        {
            mask: '0000 0000 0000 0000',
            regex: '^(?:35\\d{0,2})\\d{0,12}',
            cardtype: 'jcb'
        },
        {
            mask: '0000 0000 0000 0000',
            regex: '^(?:5[0678]\\d{0,2}|6304|67\\d{0,2})\\d{0,12}',
            cardtype: 'maestro'
        },
        // {
        //     mask: '0000-0000-0000-0000',
        //     regex: '^220[0-4]\\d{0,12}',
        //     cardtype: 'mir'
        // },
        {
            mask: '0000 0000 0000 0000',
            regex: '^4\\d{0,15}',
            cardtype: 'visa'
        },
        {
            mask: '0000 0000 0000 0000',
            regex: '^62\\d{0,14}',
            cardtype: 'unionpay'
        },
        {
            mask: '0000 0000 0000 0000',
            cardtype: 'Unknown'
        }
    ],
    dispatch: function (appended, dynamicMasked) {
        var number = (dynamicMasked.value + appended).replace(/\D/g, '');

        for (var i = 0; i < dynamicMasked.compiledMasks.length; i++) {
            let re = new RegExp(dynamicMasked.compiledMasks[i].regex);
            if (number.match(re) != null) {
                return dynamicMasked.compiledMasks[i];
            }
        }
    }
});

//Mask the Expiration Date
var expirationdate_mask = new IMask(expirationdate, {
    mask: 'MM{/}YY',
    groups: {
        YY: new IMask.MaskedPattern.Group.Range([0, 99]),
        MM: new IMask.MaskedPattern.Group.Range([1, 12]),
    }
});

//Mask the security code
var securitycode_mask = new IMask(securitycode, {
    mask: '0000',
});

// SVGICONS
let amex = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="amex" fill-rule="nonzero"> <rect id="Rectangle-1" fill="#2557D6" x="0" y="0" width="750" height="471" rx="40"></rect> <path d="M0.002688,221.18508 L36.026849,221.18508 L44.149579,201.67506 L62.334596,201.67506 L70.436042,221.18508 L141.31637,221.18508 L141.31637,206.26909 L147.64322,221.24866 L184.43894,221.24866 L190.76579,206.04654 L190.76579,221.18508 L366.91701,221.18508 L366.83451,189.15941 L370.2427,189.15941 C372.62924,189.24161 373.3263,189.46144 373.3263,193.38516 L373.3263,221.18508 L464.43232,221.18508 L464.43232,213.72973 C471.78082,217.6508 483.21064,221.18508 498.25086,221.18508 L536.57908,221.18508 L544.78163,201.67506 L562.96664,201.67506 L570.98828,221.18508 L644.84844,221.18508 L644.84844,202.65269 L656.0335,221.18508 L715.22061,221.18508 L715.22061,98.67789 L656.64543,98.67789 L656.64543,113.14614 L648.44288,98.67789 L588.33787,98.67789 L588.33787,113.14614 L580.80579,98.67789 L499.61839,98.67789 C486.02818,98.67789 474.08221,100.5669 464.43232,105.83121 L464.43232,98.67789 L408.40596,98.67789 L408.40596,105.83121 C402.26536,100.40529 393.89786,98.67789 384.59383,98.67789 L179.90796,98.67789 L166.17407,130.3194 L152.07037,98.67789 L87.59937,98.67789 L87.59937,113.14614 L80.516924,98.67789 L25.533518,98.67789 L-2.99999999e-06,156.92445 L-2.99999999e-06,221.18508 L0.002597,221.18508 L0.002688,221.18508 Z M227.39957,203.51436 L205.78472,203.51436 L205.70492,134.72064 L175.13228,203.51436 L156.62,203.51436 L125.96754,134.6597 L125.96754,203.51436 L83.084427,203.51436 L74.982981,183.92222 L31.083524,183.92222 L22.8996,203.51436 L4.7e-05,203.51436 L37.756241,115.67692 L69.08183,115.67692 L104.94103,198.84086 L104.94103,115.67692 L139.35289,115.67692 L166.94569,175.26406 L192.29297,115.67692 L227.39657,115.67692 L227.39657,203.51436 L227.39957,203.51436 Z M67.777214,165.69287 L53.346265,130.67606 L38.997794,165.69287 L67.777214,165.69287 Z M313.41947,203.51436 L242.98611,203.51436 L242.98611,115.67692 L313.41947,115.67692 L313.41947,133.96821 L264.07116,133.96821 L264.07116,149.8009 L312.23551,149.8009 L312.23551,167.80606 L264.07116,167.80606 L264.07116,185.34759 L313.41947,185.34759 L313.41947,203.51436 Z M412.67528,139.33321 C412.67528,153.33782 403.28877,160.57326 397.81863,162.74575 C402.43206,164.49434 406.37237,167.58351 408.24808,170.14281 C411.22525,174.51164 411.73875,178.41416 411.73875,186.25897 L411.73875,203.51436 L390.47278,203.51436 L390.39298,192.43732 C390.39298,187.1518 390.90115,179.55074 387.0646,175.32499 C383.98366,172.23581 379.28774,171.56552 371.69714,171.56552 L349.06363,171.56552 L349.06363,203.51436 L327.98125,203.51436 L327.98125,115.67692 L376.47552,115.67692 C387.25084,115.67692 395.18999,115.9604 402.00639,119.88413 C408.67644,123.80786 412.67529,129.53581 412.67529,139.33321 L412.67528,139.33321 Z M386.02277,152.37632 C383.1254,154.12756 379.69859,154.18584 375.59333,154.18584 L349.97998,154.18584 L349.97998,134.67583 L375.94186,134.67583 C379.61611,134.67583 383.44999,134.8401 385.94029,136.26016 C388.67536,137.53981 390.36749,140.26337 390.36749,144.02548 C390.36749,147.86443 388.75784,150.95361 386.02277,152.37632 Z M446.48908,203.51436 L424.97569,203.51436 L424.97569,115.67692 L446.48908,115.67692 L446.48908,203.51436 Z M696.22856,203.51436 L666.35032,203.51436 L626.38585,137.58727 L626.38585,203.51436 L583.44687,203.51436 L575.24166,183.92222 L531.44331,183.92222 L523.48287,203.51436 L498.81137,203.51436 C488.56284,203.51436 475.58722,201.25709 468.23872,193.79909 C460.82903,186.3411 456.97386,176.23903 456.97386,160.26593 C456.97386,147.23895 459.27791,135.33 468.33983,125.91941 C475.15621,118.90916 485.83044,115.67692 500.35982,115.67692 L520.77174,115.67692 L520.77174,134.49809 L500.78818,134.49809 C493.0938,134.49809 488.74909,135.63733 484.564,139.70147 C480.96957,143.4 478.50322,150.39171 478.50322,159.59829 C478.50322,169.00887 480.38158,175.79393 484.30061,180.22633 C487.5465,183.70232 493.445,184.75677 498.99495,184.75677 L508.46393,184.75677 L538.17987,115.67957 L569.77152,115.67957 L605.46843,198.76138 L605.46843,115.67957 L637.5709,115.67957 L674.6327,176.85368 L674.6327,115.67957 L696.22856,115.67957 L696.22856,203.51436 Z M568.07051,165.69287 L553.47993,130.67606 L538.96916,165.69287 L568.07051,165.69287 Z" id="Path" fill="#FFFFFF"></path> <path d="M749.95644,343.76716 C744.83485,351.22516 734.85504,355.00582 721.34464,355.00582 L680.62723,355.00582 L680.62723,336.1661 L721.17969,336.1661 C725.20248,336.1661 728.01736,335.63887 729.71215,333.99096 C731.18079,332.63183 732.2051,330.65804 732.2051,328.26036 C732.2051,325.70107 731.18079,323.66899 729.62967,322.45028 C728.09984,321.10969 725.87294,320.50033 722.20135,320.50033 C702.40402,319.83005 677.70592,321.10969 677.70592,293.30714 C677.70592,280.56363 685.83131,267.14983 707.95664,267.14983 L749.95379,267.14983 L749.95644,249.66925 L710.93382,249.66925 C699.15812,249.66925 690.60438,252.47759 684.54626,256.84375 L684.54626,249.66925 L626.83044,249.66925 C617.60091,249.66925 606.76706,251.94771 601.64279,256.84375 L601.64279,249.66925 L498.57751,249.66925 L498.57751,256.84375 C490.37496,250.95154 476.53466,249.66925 470.14663,249.66925 L402.16366,249.66925 L402.16366,256.84375 C395.67452,250.58593 381.24357,249.66925 372.44772,249.66925 L296.3633,249.66925 L278.95252,268.43213 L262.64586,249.66925 L148.99149,249.66925 L148.99149,372.26121 L260.50676,372.26121 L278.447,353.20159 L295.34697,372.26121 L364.08554,372.32211 L364.08554,343.48364 L370.84339,343.48364 C379.96384,343.62405 390.72054,343.25845 400.21079,339.17311 L400.21079,372.25852 L456.90762,372.25852 L456.90762,340.30704 L459.64268,340.30704 C463.13336,340.30704 463.47657,340.45011 463.47657,343.92344 L463.47657,372.25587 L635.71144,372.25587 C646.64639,372.25587 658.07621,369.46873 664.40571,364.41107 L664.40571,372.25587 L719.03792,372.25587 C730.40656,372.25587 741.50913,370.66889 749.95644,366.60475 L749.95644,343.76712 L749.95644,343.76716 Z M408.45301,296.61266 C408.45301,321.01872 390.16689,326.05784 371.7371,326.05784 L345.42935,326.05784 L345.42935,355.52685 L304.44855,355.52685 L278.48667,326.44199 L251.5058,355.52685 L167.9904,355.52685 L167.9904,267.66822 L252.79086,267.66822 L278.73144,296.46694 L305.55002,267.66822 L372.92106,267.66822 C389.6534,267.66822 408.45301,272.28078 408.45301,296.61266 Z M240.82781,337.04655 L188.9892,337.04655 L188.9892,319.56596 L235.27785,319.56596 L235.27785,301.64028 L188.9892,301.64028 L188.9892,285.66718 L241.84947,285.66718 L264.91132,311.27077 L240.82781,337.04655 Z M324.3545,347.10668 L291.9833,311.3189 L324.3545,276.6677 L324.3545,347.10668 Z M372.2272,308.04117 L344.98027,308.04117 L344.98027,285.66718 L372.47197,285.66718 C380.08388,285.66718 385.36777,288.75636 385.36777,296.43956 C385.36777,304.03796 380.32865,308.04117 372.2272,308.04117 Z M514.97053,267.66815 L585.34004,267.66815 L585.34004,285.83764 L535.96778,285.83764 L535.96778,301.81074 L584.1348,301.81074 L584.1348,319.73642 L535.96778,319.73642 L535.96778,337.21701 L585.34004,337.29641 L585.34004,355.52678 L514.97053,355.52678 L514.97053,267.66815 Z M487.91724,314.6973 C492.61049,316.42205 496.44703,319.51387 498.24559,322.07317 C501.22276,326.36251 501.65378,330.36571 501.73891,338.10985 L501.73891,355.52685 L480.5714,355.52685 L480.5714,344.53458 C480.5714,339.24908 481.08223,331.42282 477.1632,327.33748 C474.08226,324.19002 469.38635,323.4376 461.69463,323.4376 L439.16223,323.4376 L439.16223,355.52685 L417.97609,355.52685 L417.97609,267.66822 L466.65393,267.66822 C477.32816,267.66822 485.10236,268.13716 492.02251,271.81449 C498.6766,275.8177 502.86168,281.30191 502.86168,291.3245 C502.85868,305.34765 493.46719,312.50362 487.91724,314.6973 Z M475.99899,303.59022 C473.17879,305.25668 469.69077,305.39975 465.58817,305.39975 L439.97483,305.39975 L439.97483,285.66718 L465.9367,285.66718 C469.69077,285.66718 473.4475,285.74658 475.99899,287.25416 C478.7314,288.67687 480.36499,291.39779 480.36499,295.15725 C480.36499,298.91672 478.7314,301.94496 475.99899,303.59022 Z M666.33539,309.1866 C670.44067,313.41766 672.64095,318.7588 672.64095,327.80112 C672.64095,346.70178 660.78278,355.5242 639.51948,355.5242 L598.45353,355.5242 L598.45353,336.68449 L639.35453,336.68449 C643.35337,336.68449 646.18954,336.15726 647.9668,334.50934 C649.41681,333.15021 650.45709,331.17643 650.45709,328.77875 C650.45709,326.21944 649.33167,324.18738 647.88433,322.96866 C646.27201,321.62807 644.04778,321.01872 640.37619,321.01872 C620.65868,320.34843 595.9659,321.62807 595.9659,293.82551 C595.9659,281.08201 604.00615,267.66822 626.11019,267.66822 L668.37872,267.66822 L668.37872,286.36752 L629.70196,286.36752 C625.86809,286.36752 623.37512,286.51059 621.25464,287.9545 C618.94527,289.37721 618.08856,291.48876 618.08856,294.2759 C618.08856,297.59028 620.04941,299.8449 622.702,300.81987 C624.92624,301.59084 627.31543,301.81603 630.9072,301.81603 L642.25722,302.12071 C653.703,302.39889 661.55967,304.37003 666.33539,309.1866 Z M750,285.66718 L711.57335,285.66718 C707.7368,285.66718 705.18797,285.81025 703.04088,287.25416 C700.81665,288.67687 699.95995,290.78843 699.95995,293.57558 C699.95995,296.88994 701.83831,299.14456 704.57071,300.11953 C706.79495,300.8905 709.18415,301.1157 712.6961,301.1157 L724.12327,301.42038 C735.65419,301.70387 743.35123,303.67765 748.04448,308.49157 C748.89852,309.16186 749.41202,309.91428 750,310.6667 L750,285.66718 Z" id="path13" fill="#FFFFFF"></path> </g> </g>`;
let visa = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="visa" fill-rule="nonzero"> <rect id="Rectangle-1" fill="#0E4595" x="0" y="0" width="750" height="471" rx="40"></rect> <polygon id="Shape" fill="#FFFFFF" points="278.1975 334.2275 311.5585 138.4655 364.9175 138.4655 331.5335 334.2275"></polygon> <path d="M524.3075,142.6875 C513.7355,138.7215 497.1715,134.4655 476.4845,134.4655 C423.7605,134.4655 386.6205,161.0165 386.3045,199.0695 C386.0075,227.1985 412.8185,242.8905 433.0585,252.2545 C453.8275,261.8495 460.8105,267.9695 460.7115,276.5375 C460.5795,289.6595 444.1255,295.6545 428.7885,295.6545 C407.4315,295.6545 396.0855,292.6875 378.5625,285.3785 L371.6865,282.2665 L364.1975,326.0905 C376.6605,331.5545 399.7065,336.2895 423.6355,336.5345 C479.7245,336.5345 516.1365,310.2875 516.5505,269.6525 C516.7515,247.3835 502.5355,230.4355 471.7515,216.4645 C453.1005,207.4085 441.6785,201.3655 441.7995,192.1955 C441.7995,184.0585 451.4675,175.3575 472.3565,175.3575 C489.8055,175.0865 502.4445,178.8915 512.2925,182.8575 L517.0745,185.1165 L524.3075,142.6875" id="path13" fill="#FFFFFF"></path> <path d="M661.6145,138.4655 L620.3835,138.4655 C607.6105,138.4655 598.0525,141.9515 592.4425,154.6995 L513.1975,334.1025 L569.2285,334.1025 C569.2285,334.1025 578.3905,309.9805 580.4625,304.6845 C586.5855,304.6845 641.0165,304.7685 648.7985,304.7685 C650.3945,311.6215 655.2905,334.1025 655.2905,334.1025 L704.8025,334.1025 L661.6145,138.4655 Z M596.1975,264.8725 C600.6105,253.5935 617.4565,210.1495 617.4565,210.1495 C617.1415,210.6705 621.8365,198.8155 624.5315,191.4655 L628.1385,208.3435 C628.1385,208.3435 638.3555,255.0725 640.4905,264.8715 L596.1975,264.8715 L596.1975,264.8725 Z" id="Path" fill="#FFFFFF"></path> <path d="M232.9025,138.4655 L180.6625,271.9605 L175.0965,244.8315 C165.3715,213.5575 135.0715,179.6755 101.1975,162.7125 L148.9645,333.9155 L205.4195,333.8505 L289.4235,138.4655 L232.9025,138.4655" id="path16" fill="#FFFFFF"></path> <path d="M131.9195,138.4655 L45.8785,138.4655 L45.1975,142.5385 C112.1365,158.7425 156.4295,197.9015 174.8155,244.9525 L156.1065,154.9925 C152.8765,142.5965 143.5085,138.8975 131.9195,138.4655" id="path18" fill="#F2AE14"></path> </g> </g>`;
let diners = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="diners" fill-rule="nonzero"> <rect id="rectangle" fill="#0079BE" x="0" y="0" width="750" height="471" rx="40"></rect> <path d="M584.933911,237.947339 C584.933911,138.53154 501.952976,69.8140806 411.038924,69.8471464 L332.79674,69.8471464 C240.793699,69.8140806 165.066089,138.552041 165.066089,237.947339 C165.066089,328.877778 240.793699,403.587432 332.79674,403.150963 L411.038924,403.150963 C501.952976,403.586771 584.933911,328.857939 584.933911,237.947339 Z" id="Shape-path" fill="#FFFFFF"></path> <path d="M333.280302,83.9308394 C249.210378,83.9572921 181.085889,152.238282 181.066089,236.510581 C181.085889,320.768331 249.209719,389.042708 333.280302,389.069161 C417.370025,389.042708 485.508375,320.768331 485.520254,236.510581 C485.507715,152.238282 417.370025,83.9572921 333.280302,83.9308394 Z" id="Shape-path" fill="#0079BE"></path> <path d="M237.066089,236.09774 C237.145288,194.917524 262.812421,159.801587 299.006443,145.847134 L299.006443,326.327183 C262.812421,312.380667 237.144628,277.283907 237.066089,236.09774 Z M368.066089,326.372814 L368.066089,145.847134 C404.273312,159.767859 429.980043,194.903637 430.046043,236.103692 C429.980043,277.316312 404.273312,312.425636 368.066089,326.372814 Z" id="Path" fill="#FFFFFF"></path> </g> </g>`;
let discover = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="discover" fill-rule="nonzero"> <path d="M52.8771038,0 C23.6793894,0 -4.55476115e-15,23.1545612 0,51.7102589 L0,419.289737 C0,447.850829 23.671801,471 52.8771038,471 L697.122894,471 C726.320615,471 750,447.845433 750,419.289737 L750,252.475404 L750,51.7102589 C750,23.1491677 726.328202,-4.4533018e-15 697.122894,0 L52.8771038,0 Z" id="Shape" fill="#4D4D4D"></path> <path d="M314.569558,152.198414 C323.06625,152.198414 330.192577,153.9309 338.865308,158.110254 L338.865308,180.197198 C330.650269,172.563549 323.523875,169.368926 314.100058,169.368926 C295.577115,169.368926 281.009615,183.944539 281.009615,202.424438 C281.009615,221.911997 295.126279,235.620254 315.018404,235.620254 C323.972798,235.620254 330.967135,232.591128 338.865308,225.080186 L338.865308,247.178497 C329.883538,251.197965 322.604577,252.785079 314.100058,252.785079 C284.025202,252.785079 260.655798,230.849701 260.655798,202.560947 C260.655798,174.577103 284.647269,152.198414 314.569558,152.198414 Z M221.191404,152.807038 C232.293048,152.807038 242.451462,156.418802 250.944635,163.479831 L240.609981,176.340655 C235.465019,170.859895 230.599394,168.547945 224.682615,168.547945 C216.169885,168.547936 209.970327,173.154235 209.970327,179.215049 C209.970327,184.413218 213.450798,187.164422 225.302356,191.332621 C247.768529,199.141028 254.426462,206.064868 254.426462,221.354473 C254.426462,239.986821 240.026981,252.955721 219.503077,252.955721 C204.47426,252.955721 193.548154,247.330452 184.44824,234.636213 L197.205529,222.956624 C201.754702,231.315341 209.342452,235.792799 218.763144,235.792799 C227.573971,235.792799 234.097058,230.014421 234.097058,222.217168 C234.097058,218.175392 232.121269,214.709536 228.175702,212.259183 C226.189231,211.099073 222.254519,209.369382 214.522615,206.777734 C195.973058,200.43062 189.609,193.646221 189.609,180.386799 C189.609,164.636126 203.275981,152.807038 221.191404,152.807038 Z M446.886269,154.485036 L468.460788,154.485036 L495.464615,219.130417 L522.815885,154.485036 L544.22701,154.485036 L500.482644,253.198414 L489.855019,253.198414 L446.886269,154.485036 Z M64.8212135,154.632923 L93.811974,154.632923 C125.842394,154.632923 148.170827,174.418596 148.170827,202.822609 C148.170827,216.985567 141.340038,230.679389 129.788913,239.766893 C120.068962,247.437722 108.994192,250.877669 93.6598558,250.877669 L64.8212135,250.877669 L64.8212135,154.632923 Z M157.25849,154.632923 L177.009462,154.632923 L177.009462,250.877669 L157.25849,250.877669 L157.25849,154.632923 Z M553.156923,154.632923 L609.168423,154.632923 L609.168423,170.940741 L572.892875,170.940741 L572.892875,192.303392 L607.831279,192.303392 L607.831279,208.603619 L572.892875,208.603619 L572.892875,234.583122 L609.168423,234.583122 L609.168423,250.877669 L553.156923,250.877669 L553.156923,154.632923 Z M622.250596,154.632923 L651.534327,154.632923 C674.313452,154.632923 687.366663,165.030007 687.366663,183.048838 C687.366663,197.784414 679.179923,207.454847 664.302885,210.332805 L696.176385,250.877669 L671.888144,250.877669 L644.551904,212.213673 L641.977163,212.213673 L641.977163,250.877669 L622.250596,250.877669 L622.250596,154.632923 Z M641.977163,169.791736 L641.977163,198.939525 L647.748269,198.939525 C660.360308,198.939525 667.044769,193.734406 667.044769,184.05942 C667.044769,174.693052 660.359106,169.791736 648.060019,169.791736 L641.977163,169.791736 Z M84.5571663,170.940741 L84.5571663,234.583122 L89.8568962,234.583122 C102.619538,234.583122 110.679663,232.259105 116.885144,226.934514 C123.71575,221.152572 127.824519,211.920423 127.824519,202.684197 C127.824519,193.462833 123.71575,184.505917 116.885144,178.723975 C110.361615,173.113074 102.619538,170.940741 89.8568962,170.940741 L84.5571663,170.940741 Z" id="Shape" fill="#FFFFFF"></path> <path d="M399.164288,151.559424 C428.914452,151.559424 453.031096,173.727429 453.031096,201.112187 L453.031096,201.143399 C453.031096,228.528147 428.914452,250.727374 399.164288,250.727374 C369.414125,250.727374 345.297481,228.528147 345.297481,201.143399 L345.297481,201.112187 C345.297481,173.727429 369.414125,151.559424 399.164288,151.559424 Z M749.982612,271.093939 C724.934651,288.327133 537.408564,411.490963 212.719237,470.985071 L697.105507,470.985071 C726.303228,470.985071 749.982612,447.830504 749.982612,419.274807 L749.982612,271.093939 Z" id="Shape" fill="#F47216"></path> </g> </g>`;
let jcb = `<defs> <linearGradient x1="0.031607858%" y1="49.9998574%" x2="99.9743153%" y2="49.9998574%" id="linearGradient-1"> <stop stop-color="#007B40" offset="0%"></stop> <stop stop-color="#55B330" offset="100%"></stop> </linearGradient> <linearGradient x1="0.471693172%" y1="49.999826%" x2="99.9860086%" y2="49.999826%" id="linearGradient-2"> <stop stop-color="#1D2970" offset="0%"></stop> <stop stop-color="#006DBA" offset="100%"></stop> </linearGradient> <linearGradient x1="0.113880772%" y1="50.0008964%" x2="99.9860003%" y2="50.0008964%" id="linearGradient-3"> <stop stop-color="#6E2B2F" offset="0%"></stop> <stop stop-color="#E30138" offset="100%"></stop> </linearGradient> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="jcb" fill-rule="nonzero"> <rect id="Rectangle-1" fill="#0E4C96" x="0" y="0" width="750" height="471" rx="40"></rect> <path d="M617.243183,346.766281 C617.243183,388.380887 583.514892,422.125974 541.88349,422.125974 L132.756823,422.125974 L132.756823,124.244916 C132.756823,82.6186826 166.489851,48.8744567 208.121683,48.8744567 L617.243183,48.874026 L617.242752,346.766281 L617.243183,346.766281 Z" id="path3494" fill="#FFFFFF"></path> <path d="M483.858874,242.044797 C495.542699,242.298285 507.296188,241.528806 518.936004,242.444883 C530.723244,244.645678 533.563915,262.487874 523.09234,268.332511 C515.950746,272.182115 507.459496,269.764696 499.713328,270.446208 L483.858874,270.446208 L483.858874,242.044797 Z M525.691826,209.900487 C528.288491,219.064679 519.453903,227.292118 510.625917,226.030566 L483.858874,226.030566 C484.043758,217.388441 483.491345,208.008973 484.131053,199.821663 C494.854942,200.123386 505.679576,199.205849 516.340394,200.301853 C520.921799,201.451558 524.753935,205.217712 525.691826,209.900487 Z M590.120412,73.9972254 C590.617872,91.498454 590.191471,109.92365 590.33359,127.780192 C590.299137,200.376358 590.405942,272.974174 590.278896,345.569303 C589.81042,372.776592 565.696524,396.413678 538.678749,396.956694 C511.63292,397.068451 484.584297,396.972628 457.537396,397.004497 L457.537396,287.253291 C487.007,287.099803 516.49604,287.561 545.953521,287.021594 C559.62072,286.162769 574.586027,277.145695 575.22328,262.107374 C576.833661,247.005483 562.592128,236.557185 549.071096,234.905684 C543.872773,234.770542 544.027132,233.390846 549.071096,232.788972 C561.96307,230.002483 572.090675,216.655787 568.296786,203.290229 C565.06052,189.232374 549.523839,183.79142 536.600366,183.817768 C510.248548,183.638612 483.891299,183.792359 457.537396,183.74111 C457.708585,163.252408 457.182916,142.740653 457.82271,122.267364 C459.910361,95.5513766 484.628603,73.5195319 511.269759,73.997656 C537.553166,73.9973692 563.837737,73.9982301 590.120412,73.9972254 Z" id="path3496" fill="url(#linearGradient-1)"></path> <path d="M159.740429,125.040498 C160.413689,97.8766592 184.628619,74.4290299 211.614797,74.0325398 C238.559493,73.9499686 265.506204,74.0209119 292.451671,73.9972254 C292.37764,164.882488 292.599905,255.773672 292.340301,346.655222 C291.302298,373.488802 267.350548,396.488661 240.661356,396.962292 C213.665015,397.060957 186.666275,396.976074 159.669012,397.004497 L159.669012,283.550875 C185.891623,289.745491 213.391138,292.382518 240.142406,288.272242 C256.134509,285.697368 273.629935,277.848026 279.044261,261.257567 C283.030122,247.066267 280.785723,232.131602 281.378027,217.566465 L281.378027,183.741541 L235.081246,183.741541 C234.873106,206.112145 235.507258,228.522447 234.746146,250.867107 C233.49785,264.601214 219.900147,273.326996 206.946428,272.861801 C190.879747,273.030535 159.04755,261.221796 159.04755,261.221796 C158.967492,219.3048 159.514314,166.814385 159.740429,125.040498 Z" id="path3498" fill="url(#linearGradient-2)"></path> <path d="M309.719995,197.390136 C307.285788,197.90738 309.229141,189.089459 308.606298,185.743964 C308.772233,164.593637 308.260045,143.420951 308.889718,122.285827 C310.972541,95.4570827 335.881262,73.3701105 362.628748,73.997656 L441.39456,73.997656 C441.320658,164.882346 441.542493,255.77294 441.283406,346.653934 C440.244412,373.488027 416.291344,396.487102 389.602087,396.962292 C362.604605,397.061991 335.604707,396.976504 308.606298,397.004928 L308.606298,272.707624 C327.04641,287.835846 352.105738,290.192248 375.077953,290.233484 C392.39501,290.227455 409.611861,287.557865 426.428143,283.562934 L426.428143,260.790297 C407.474658,270.236609 385.194808,276.235815 364.184745,270.807966 C349.529051,267.157367 338.89089,252.996683 339.128513,237.872204 C337.43001,222.143684 346.652631,205.536885 362.110237,200.860855 C381.300923,194.852545 402.217787,199.448454 420.206344,207.258795 C424.060526,209.27695 427.97066,211.780342 426.428143,205.338044 L426.428143,187.438358 C396.343581,180.280951 364.326644,177.646405 334.099438,185.433619 C325.351193,187.901774 316.82819,191.644647 309.719995,197.390136 Z" id="path3500" fill="url(#linearGradient-3)"></path> </g> </g>`;
let maestro = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="maestro" fill-rule="nonzero"> <rect id="Rectangle-1" fill="#000000" x="0" y="0" width="750" height="471" rx="40"></rect> <g id="Group" transform="translate(133.000000, 48.000000)"> <path d="M146.8,373.77 L146.8,349 C146.8,339.65 140.8,333.36 131.25,333.28 C126.25,333.2 120.99,334.77 117.35,340.28 C114.62,335.9 110.35,333.28 104.28,333.28 C99.6528149,333.047729 95.2479974,335.280568 92.7,339.15 L92.7,334.27 L84.09,334.27 L84.09,373.82 L92.78,373.82 L92.78,351.85 C92.78,344.98 96.59,341.34 102.46,341.34 C108.17,341.34 111.07,345.06 111.07,351.76 L111.07,373.76 L119.76,373.76 L119.76,351.85 C119.76,344.98 123.76,341.34 129.44,341.34 C135.31,341.34 138.13,345.06 138.13,351.76 L138.13,373.76 L146.8,373.77 Z M195.28,354 L195.28,334.23 L186.67,334.23 L186.67,339 C183.94,335.44 179.8,333.21 174.18,333.21 C163.09,333.21 154.41,341.9 154.41,353.98 C154.41,366.06 163.1,374.75 174.18,374.75 C179.81,374.75 183.94,372.52 186.67,368.96 L186.67,373.76 L195.28,373.76 L195.28,354 Z M163.28,354 C163.28,347.05 167.83,341.34 175.28,341.34 C182.4,341.34 187.19,346.8 187.19,354 C187.19,361.2 182.39,366.66 175.28,366.66 C167.81,366.66 163.26,360.95 163.26,354 L163.28,354 Z M379.4,333.19 C382.306602,333.161358 385.190743,333.701498 387.89,334.78 C390.404719,335.784654 392.697997,337.272736 394.64,339.16 C396.553063,341.035758 398.069744,343.276773 399.1,345.75 C401.246003,351.047587 401.246003,356.972413 399.1,362.27 C398.069744,364.743227 396.553063,366.984242 394.64,368.86 C392.698322,370.747671 390.404958,372.235809 387.89,373.24 C382.423165,375.368264 376.356835,375.368264 370.89,373.24 C368.379501,372.23863 366.092168,370.749994 364.16,368.86 C362.258485,366.978798 360.749319,364.738843 359.72,362.27 C357.573997,356.972413 357.573997,351.047587 359.72,345.75 C360.749788,343.28141 362.258895,341.041542 364.16,339.16 C366.092334,337.270213 368.379623,335.781606 370.89,334.78 C373.595493,333.69893 376.486681,333.158743 379.4,333.19 Z M379.4,341.33 C377.718221,341.315441 376.049964,341.631425 374.49,342.26 C373.019746,342.850363 371.685751,343.735156 370.57,344.86 C369.447092,346.008077 368.563336,347.367702 367.97,348.86 C366.704271,352.169784 366.704271,355.830216 367.97,359.14 C368.562861,360.632544 369.446675,361.992258 370.57,363.14 C371.685751,364.264844 373.019746,365.149637 374.49,365.74 C377.649488,366.979283 381.160512,366.979283 384.32,365.74 C385.794284,365.146098 387.134154,364.26192 388.26,363.14 C389.392829,361.995929 390.283848,360.635594 390.88,359.14 C392.145729,355.830216 392.145729,352.169784 390.88,348.86 C390.283848,347.364406 389.392829,346.004071 388.26,344.86 C387.134154,343.73808 385.794284,342.853902 384.32,342.26 C382.757613,341.626714 381.085807,341.307304 379.4,341.32 L379.4,341.33 Z M242.1,354 C242.02,341.67 234.41,333.23 223.32,333.23 C211.74,333.23 203.63,341.67 203.63,354 C203.63,366.58 212.07,374.77 223.9,374.77 C229.9,374.77 235.32,373.28 240.12,369.23 L235.9,362.86 C232.633262,365.479648 228.586894,366.936341 224.4,367 C218.86,367 213.81,364.44 212.57,357.32 L241.94,357.32 C242,356.23 242.1,355.16 242.1,354 Z M212.65,350.53 C213.56,344.82 217.03,340.93 223.16,340.93 C228.7,340.93 232.26,344.4 233.16,350.53 L212.65,350.53 Z M278.34,344.33 C274.582803,342.165547 270.335565,340.995319 266,340.93 C261.28,340.93 258.47,342.67 258.47,345.56 C258.47,348.21 261.47,348.95 265.17,349.45 L269.22,350.03 C277.83,351.27 283.04,354.91 283.04,361.86 C283.04,369.39 276.42,374.77 265.04,374.77 C258.59,374.77 252.63,373.11 247.91,369.64 L251.96,362.94 C255.757785,365.757702 260.39304,367.215905 265.12,367.08 C270.99,367.08 274.12,365.34 274.12,362.28 C274.12,360.05 271.89,358.81 267.17,358.14 L263.12,357.56 C254.27,356.32 249.47,352.35 249.47,345.89 C249.47,338.03 255.92,333.23 265.93,333.23 C272.22,333.23 277.93,334.64 282.06,337.37 L278.34,344.33 Z M319.69,342.1 L305.62,342.1 L305.62,360 C305.62,364 307.03,366.62 311.33,366.62 C314.014365,366.531754 316.632562,365.76453 318.94,364.39 L321.42,371.75 C318.192475,373.761602 314.463066,374.822196 310.66,374.81 C300.48,374.81 296.93,369.35 296.93,360.16 L296.93,342.16 L288.93,342.16 L288.93,334.3 L296.93,334.3 L296.93,322.3 L305.62,322.3 L305.62,334.3 L319.68,334.3 L319.69,342.1 Z M349.47,333.25 C351.556514,333.260012 353.62609,333.625232 355.59,334.33 L352.94,342.44 C351.229904,341.756022 349.401653,341.416198 347.56,341.44 C341.93,341.44 339.12,345.08 339.12,351.62 L339.12,373.79 L330.52,373.79 L330.52,334.23 L339,334.23 L339,339 C341.149726,335.306198 345.148028,333.084492 349.42,333.21 L349.47,333.25 Z" id="Shape" fill="#FFFFFF"></path> <g id="_Group_"> <rect id="Rectangle-path" fill="#7673C0" x="176.95" y="32.39" width="130.5" height="234.51"></rect> <path d="M185.24,149.64 C185.20514,103.86954 206.225386,60.6268374 242.24,32.38 C181.092968,-15.6818249 93.2777189,-8.68578574 40.5116372,48.4512353 C-12.2544445,105.588256 -12.2544445,193.681744 40.5116372,250.818765 C93.2777189,307.955786 181.092968,314.951825 242.24,266.89 C206.228151,238.645328 185.208215,195.406951 185.24,149.64 Z" id="_Path_" fill="#EB001B"></path> <path d="M483.5,149.64 C483.501034,206.73874 450.90156,258.826356 399.545558,283.782862 C348.189556,308.739368 287.092343,302.183759 242.2,266.9 C278.166584,238.620187 299.164715,195.398065 299.164715,149.645 C299.164715,103.891935 278.166584,60.669813 242.2,32.39 C287.090924,-2.89264477 348.185845,-9.44904288 399.541061,15.5049525 C450.896277,40.4589479 483.497206,92.543064 483.5,149.64 Z" id="Shape" fill="#00A1DF"></path> </g> </g> </g> </g>`;
let mastercard = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="mastercard" fill-rule="nonzero"> <rect id="Rectangle-1" fill="#000000" x="0" y="0" width="750" height="471" rx="40"></rect> <g id="Group" transform="translate(133.000000, 48.000000)"> <path d="M88.13,373.67 L88.13,348.82 C88.13,339.29 82.33,333.08 72.81,333.08 C67.81,333.08 62.46,334.74 58.73,340.08 C55.83,335.52 51.73,333.08 45.48,333.08 C40.7599149,332.876008 36.2525337,335.054575 33.48,338.88 L33.48,333.88 L25.61,333.88 L25.61,373.64 L33.48,373.64 L33.48,350.89 C33.48,343.89 37.62,340.54 43.42,340.54 C49.22,340.54 52.53,344.27 52.53,350.89 L52.53,373.67 L60.4,373.67 L60.4,350.89 C60.4,343.89 64.54,340.54 70.34,340.54 C76.14,340.54 79.45,344.27 79.45,350.89 L79.45,373.67 L88.13,373.67 Z M217.35,334.32 L202.85,334.32 L202.85,322.32 L195,322.32 L195,334.32 L186.72,334.32 L186.72,341.32 L195,341.32 L195,360 C195,369.11 198.31,374.5 208.25,374.5 C212.015784,374.421483 215.705651,373.426077 219,371.6 L216.51,364.6 C214.275685,365.996557 211.684475,366.715565 209.05,366.67 C204.91,366.67 202.84,364.18 202.84,360.04 L202.84,341 L217.34,341 L217.34,334.37 L217.35,334.32 Z M291.07,333.08 C286.709355,332.982846 282.618836,335.185726 280.3,338.88 L280.3,333.88 L272.43,333.88 L272.43,373.64 L280.3,373.64 L280.3,351.31 C280.3,344.68 283.61,340.54 289,340.54 C290.818809,340.613783 292.62352,340.892205 294.38,341.37 L296.87,333.91 C294.971013,333.43126 293.02704,333.153071 291.07,333.08 Z M179.66,337.22 C175.52,334.32 169.72,333.08 163.51,333.08 C153.57,333.08 147.36,337.64 147.36,345.51 C147.36,352.14 151.92,355.86 160.61,357.11 L164.75,357.52 C169.31,358.35 172.21,360.01 172.21,362.08 C172.21,364.98 168.9,367.08 162.68,367.08 C157.930627,367.177716 153.278889,365.724267 149.43,362.94 L145.29,369.15 C151.09,373.29 158.13,374.15 162.29,374.15 C173.89,374.15 180.1,368.77 180.1,361.31 C180.1,354.31 175.1,350.96 166.43,349.71 L162.29,349.3 C158.56,348.89 155.29,347.64 155.29,345.16 C155.29,342.26 158.6,340.16 163.16,340.16 C168.16,340.16 173.1,342.23 175.59,343.47 L179.66,337.22 Z M299.77,353.79 C299.77,365.79 307.64,374.5 320.48,374.5 C326.28,374.5 330.42,373.26 334.56,369.94 L330.42,363.73 C327.488758,366.10388 323.841703,367.41823 320.07,367.46 C313.07,367.46 307.64,362.08 307.64,354.21 C307.64,346.34 313,341 320.07,341 C323.841703,341.04177 327.488758,342.35612 330.42,344.73 L334.56,338.52 C330.42,335.21 326.28,333.96 320.48,333.96 C308.05,333.13 299.77,341.83 299.77,353.84 L299.77,353.79 Z M244.27,333.08 C232.67,333.08 224.8,341.36 224.8,353.79 C224.8,366.22 233.08,374.5 245.09,374.5 C250.932775,374.623408 256.638486,372.722682 261.24,369.12 L257.1,363.32 C253.772132,365.898743 249.708598,367.349004 245.5,367.46 C240.12,367.46 234.32,364.15 233.5,357.11 L262.91,357.11 L262.91,353.8 C262.91,341.37 255.45,333.09 244.27,333.09 L244.27,333.08 Z M243.86,340.54 C249.66,340.54 253.8,344.27 254.21,350.48 L232.68,350.48 C233.92,344.68 237.68,340.54 243.86,340.54 Z M136.59,353.79 L136.59,333.91 L128.72,333.91 L128.72,338.91 C125.82,335.18 121.72,333.11 115.88,333.11 C104.7,333.11 96.41,341.81 96.41,353.82 C96.41,365.83 104.69,374.53 115.88,374.53 C121.68,374.53 125.82,372.46 128.72,368.73 L128.72,373.73 L136.59,373.73 L136.59,353.79 Z M104.7,353.79 C104.7,346.33 109.26,340.54 117.13,340.54 C124.59,340.54 129.13,346.34 129.13,353.79 C129.13,361.66 124.13,367.04 117.13,367.04 C109.26,367.45 104.7,361.24 104.7,353.79 Z M410.78,333.08 C406.419355,332.982846 402.328836,335.185726 400.01,338.88 L400.01,333.88 L392.14,333.88 L392.14,373.64 L400,373.64 L400,351.31 C400,344.68 403.31,340.54 408.7,340.54 C410.518809,340.613783 412.32352,340.892205 414.08,341.37 L416.57,333.91 C414.671013,333.43126 412.72704,333.153071 410.77,333.08 L410.78,333.08 Z M380.13,353.79 L380.13,333.91 L372.26,333.91 L372.26,338.91 C369.36,335.18 365.26,333.11 359.42,333.11 C348.24,333.11 339.95,341.81 339.95,353.82 C339.95,365.83 348.23,374.53 359.42,374.53 C365.22,374.53 369.36,372.46 372.26,368.73 L372.26,373.73 L380.13,373.73 L380.13,353.79 Z M348.24,353.79 C348.24,346.33 352.8,340.54 360.67,340.54 C368.13,340.54 372.67,346.34 372.67,353.79 C372.67,361.66 367.67,367.04 360.67,367.04 C352.8,367.45 348.24,361.24 348.24,353.79 Z M460.07,353.79 L460.07,318.17 L452.2,318.17 L452.2,338.88 C449.3,335.15 445.2,333.08 439.36,333.08 C428.18,333.08 419.89,341.78 419.89,353.79 C419.89,365.8 428.17,374.5 439.36,374.5 C445.16,374.5 449.3,372.43 452.2,368.7 L452.2,373.7 L460.07,373.7 L460.07,353.79 Z M428.18,353.79 C428.18,346.33 432.74,340.54 440.61,340.54 C448.07,340.54 452.61,346.34 452.61,353.79 C452.61,361.66 447.61,367.04 440.61,367.04 C432.73,367.46 428.17,361.25 428.17,353.79 L428.18,353.79 Z" id="Shape" fill="#FFFFFF"></path> <g> <rect id="Rectangle-path" fill="#FF5F00" x="170.55" y="32.39" width="143.72" height="234.42"></rect> <path d="M185.05,149.6 C185.05997,103.912554 205.96046,60.7376085 241.79,32.39 C180.662018,-15.6713968 92.8620037,-8.68523415 40.103462,48.4380037 C-12.6550796,105.561241 -12.6550796,193.638759 40.103462,250.761996 C92.8620037,307.885234 180.662018,314.871397 241.79,266.81 C205.96046,238.462391 185.05997,195.287446 185.05,149.6 Z" id="Shape" fill="#EB001B"></path> <path d="M483.26,149.6 C483.30134,206.646679 450.756789,258.706022 399.455617,283.656273 C348.154445,308.606523 287.109181,302.064451 242.26,266.81 C278.098424,238.46936 299.001593,195.290092 299.001593,149.6 C299.001593,103.909908 278.098424,60.7306402 242.26,32.39 C287.109181,-2.86445052 348.154445,-9.40652324 399.455617,15.5437274 C450.756789,40.493978 483.30134,92.5533211 483.26,149.6 Z" id="Shape" fill="#F79E1B"></path> </g> </g> </g> </g>`;
let unionpay = `<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="unionpay" fill-rule="nonzero"> <rect id="Rectangle-path" fill="#FFFFFF" x="0" y="0" width="750" height="471" rx="40"></rect> <path d="M201.809581,55 L344.203266,55 C364.072152,55 376.490206,71.4063861 371.833436,91.4702467 L305.500331,378.94775 C300.843561,399.011611 280.871191,415.417997 261.002305,415.417997 L118.60862,415.417997 C98.7397339,415.417997 86.32168,399.011611 90.9784502,378.94775 L157.311555,91.4702467 C161.968325,71.3018868 181.837211,55 201.706097,55 L201.809581,55 Z" id="Shape" fill="#D10429"></path> <path d="M331.750074,55 L495.564902,55 C515.433788,55 506.430699,71.4063861 501.773929,91.4702467 L435.440824,378.94775 C430.784054,399.011611 432.232827,415.417997 412.363941,415.417997 L248.549113,415.417997 C228.576743,415.417997 216.262173,399.011611 221.022427,378.94775 L287.355531,91.4702467 C292.012302,71.3018868 311.881188,55 331.853558,55 L331.750074,55 Z" id="Shape" fill="#022E64"></path> <path d="M489.814981,55 L632.208666,55 C652.077552,55 664.495606,71.4063861 659.838836,91.4702467 L593.505731,378.94775 C588.848961,399.011611 568.876591,415.417997 549.007705,415.417997 L406.61402,415.417997 C386.64165,415.417997 374.32708,399.011611 378.98385,378.94775 L445.316955,91.4702467 C449.973725,71.3018868 469.842611,55 489.711498,55 L489.814981,55 Z" id="Shape" fill="#076F74"></path> <path d="M465.904754,326.014514 L479.357645,326.014514 L483.186545,312.952104 L469.837137,312.952104 L465.904754,326.014514 Z M476.667067,290.066763 L472.010297,305.532656 C472.010297,305.532656 477.081002,302.920174 479.875064,302.08418 C482.669126,301.457184 486.808478,300.934688 486.808478,300.934688 L490.016475,290.171263 L476.563583,290.171263 L476.667067,290.066763 Z M483.393513,267.912917 L478.94371,282.751814 C478.94371,282.751814 483.910932,280.45283 486.704994,279.721335 C489.499056,278.98984 493.638407,278.780842 493.638407,278.780842 L496.846405,268.017417 L483.496997,268.017417 L483.393513,267.912917 Z M513.093359,267.912917 L495.708083,325.910015 L500.364853,325.910015 L496.742921,337.927431 L492.086151,337.927431 L490.947829,341.584906 L474.390424,341.584906 L475.528745,337.927431 L442,337.927431 L445.311481,326.850508 L448.726446,326.850508 L466.318689,267.912917 L469.837137,256 L486.704994,256 L484.94577,261.956459 C484.94577,261.956459 489.395572,258.716981 493.741891,257.567489 C497.984726,256.417997 522.406899,256 522.406899,256 L518.784967,267.808418 L512.989875,267.808418 L513.093359,267.912917 Z" id="Shape" fill="#FEFEFE"></path> <path d="M520,256 L538.006178,256 L538.213146,262.792453 C538.109662,263.941945 539.041016,264.464441 541.214175,264.464441 L544.836108,264.464441 L541.524627,275.645864 L531.797151,275.645864 C523.414965,276.272859 520.206968,272.615385 520.413935,268.539913 L520.103484,256.104499 L520,256 Z M522.216235,309.20029 L505.037927,309.20029 L507.935473,299.272859 L527.597391,299.272859 L530.391454,290.181422 L511.039986,290.181422 L514.351467,279 L568.163034,279 L564.851553,290.181422 L546.741891,290.181422 L543.947829,299.272859 L562.057491,299.272859 L559.056461,309.20029 L539.498026,309.20029 L535.979578,313.380261 L543.947829,313.380261 L545.914021,325.920174 C546.120989,327.174165 546.120989,328.01016 546.534924,328.532656 C546.948859,328.950653 549.328986,329.159652 550.674275,329.159652 L553.054402,329.159652 L549.328986,341.386067 L543.223443,341.386067 C542.292089,341.386067 540.843316,341.281567 538.877124,341.281567 C537.014416,341.072569 535.77261,340.027576 534.530805,339.400581 C533.392483,338.878084 531.736743,337.519594 531.322808,335.11611 L529.4601,322.576197 L520.560494,334.907112 C517.766432,338.773585 513.937532,341.804064 507.418054,341.804064 L495,341.804064 L498.311481,330.936139 L503.071735,330.936139 C504.417024,330.936139 505.65883,330.413643 506.590184,329.891147 C507.521538,329.473149 508.349408,329.055152 509.177278,327.696662 L522.216235,309.20029 Z M334.31354,282 L379.742921,282 L376.43144,292.972424 L358.321778,292.972424 L355.527716,302.272859 L374.154797,302.272859 L370.739832,313.558781 L352.216235,313.558781 L347.662948,328.711176 C347.145529,330.383164 352.112751,330.592163 353.871975,330.592163 L363.185516,329.338171 L359.4601,341.878084 L338.556375,341.878084 C336.900635,341.878084 335.65883,341.669086 333.796122,341.251089 C332.036897,340.833091 331.209027,339.997097 330.48464,338.847605 C329.760254,337.593614 328.518449,336.65312 329.346319,333.936139 L335.348378,313.872279 L325,313.872279 L328.414965,302.377358 L338.763343,302.377358 L341.557405,293.076923 L331.209027,293.076923 L334.520508,282.104499 L334.31354,282 Z M365.700875,262.165457 L384.327956,262.165457 L380.912991,273.555878 L355.455981,273.555878 L352.661919,275.959361 C351.420113,277.108853 351.109662,276.690856 349.557405,277.526851 C348.108632,278.258345 345.107603,279.721335 341.175219,279.721335 L333,279.721335 L336.311481,268.748911 L338.795092,268.748911 C340.864767,268.748911 342.31354,268.539913 343.037927,268.121916 C343.865797,267.599419 344.797151,266.449927 345.728505,264.56894 L350.385275,256 L368.908872,256 L365.700875,262.269956 L365.700875,262.165457 Z M400.808726,280.975327 C400.808726,280.975327 405.879431,276.272859 414.572069,274.809869 C416.538261,274.391872 428.956314,274.600871 428.956314,274.600871 L430.819023,268.330914 L404.637626,268.330914 L400.808726,281.079826 L400.808726,280.975327 Z M425.437866,285.782293 L399.463436,285.782293 L397.91118,291.111756 L420.470644,291.111756 C423.161223,290.798258 423.678642,291.216255 423.885609,291.007257 L425.54135,285.782293 L425.437866,285.782293 Z M391.702153,256.104499 L407.535171,256.104499 L405.258528,264.150943 C405.258528,264.150943 410.22575,260.075472 413.744198,258.612482 C417.262647,257.358491 425.127414,256.104499 425.127414,256.104499 L450.791393,256 L441.995271,285.468795 C440.546498,290.484761 438.787274,293.724238 437.752436,295.291727 C436.821082,296.754717 435.68276,298.113208 433.406117,299.367199 C431.232958,300.516691 429.266766,301.248186 427.404058,301.352685 C425.748317,301.457184 423.057739,301.561684 419.53929,301.561684 L394.806666,301.561684 L387.873253,324.865022 C387.25235,327.164006 386.941899,328.313498 387.355834,328.940493 C387.666285,329.46299 388.597639,330.089985 389.735961,330.089985 L400.601758,329.044993 L396.876342,341.793904 L384.665256,341.793904 C380.732872,341.793904 377.93881,341.689405 375.972618,341.584906 C374.10991,341.375907 372.143718,341.584906 370.798429,340.539913 C369.660107,339.49492 367.900883,338.13643 368.004367,336.777939 C368.10785,335.523948 368.625269,333.433962 369.45314,330.507983 L391.702153,256.104499 Z" id="Shape" fill="#FEFEFE"></path> <path d="M437.840227,303 L436.391454,310.105951 C435.770551,312.300435 435.253132,313.972424 433.597391,315.435414 C431.838167,316.898403 429.871975,318.465893 425.111721,318.465893 L416.3156,318.88389 L416.212116,326.825835 C416.108632,329.020319 416.729535,328.811321 417.039986,329.229318 C417.453921,329.647315 417.764373,329.751814 418.178308,329.960813 L420.97237,329.751814 L429.354556,329.333817 L425.836108,341.037736 L416.212116,341.037736 C409.48567,341.037736 404.414965,340.828737 402.862708,339.574746 C401.206968,338.529753 401,337.275762 401,334.976778 L401.620903,303.835994 L417.039986,303.835994 L416.833019,310.21045 L420.558435,310.21045 C421.80024,310.21045 422.731594,310.105951 423.249013,309.792453 C423.766432,309.478955 424.076883,308.956459 424.283851,308.224964 L425.836108,303.208999 L437.94371,303.208999 L437.840227,303 Z M218.470396,147 C217.952978,149.507983 208.018534,195.592163 208.018534,195.592163 C205.845375,204.892598 204.293118,211.580552 199.118929,215.865022 C196.117899,218.373004 192.599451,219.522496 188.563583,219.522496 C182.044105,219.522496 178.318689,216.283019 177.697786,210.117562 L177.594302,208.027576 C177.594302,208.027576 179.560494,195.592163 179.560494,195.487663 C179.560494,195.487663 189.908872,153.478955 191.771581,147.940493 C191.875064,147.626996 191.875064,147.417997 191.875064,147.313498 C171.695727,147.522496 168.073794,147.313498 167.866827,147 C167.763343,147.417997 167.245924,150.030479 167.245924,150.030479 L156.690578,197.36865 L155.759224,201.339623 L154,214.506531 C154,218.373004 154.724386,221.612482 156.276643,224.224964 C161.140381,232.793904 174.903724,234.047896 182.665008,234.047896 C192.702935,234.047896 202.119959,231.853411 208.43247,227.986938 C219.505234,221.403483 222.40278,211.058055 224.886391,201.966618 L226.128196,197.264151 C226.128196,197.264151 236.787026,153.687954 238.649734,148.044993 C238.753218,147.731495 238.753218,147.522496 238.856702,147.417997 C224.162004,147.522496 219.919169,147.417997 218.470396,147.104499 L218.470396,147 Z M277.499056,233.622642 C270.358675,233.518142 267.771581,233.518142 259.389394,233.936139 L259.078943,233.309144 C259.803329,230.069666 260.6312,226.934688 261.252102,223.69521 L262.28694,219.306241 C263.839197,212.513788 265.28797,204.467344 265.494937,202.063861 C265.701905,200.600871 266.11584,196.943396 261.976489,196.943396 C260.217264,196.943396 258.45804,197.77939 256.595332,198.615385 C255.560494,202.272859 253.594302,212.513788 252.559465,217.111756 C250.489789,226.934688 250.386305,228.08418 249.454951,232.891147 L248.834048,233.518142 C241.4867,233.413643 238.899605,233.413643 230.413935,233.83164 L230,233.100145 C231.448773,227.248186 232.794062,221.396226 234.139351,215.544267 C237.6578,199.764877 238.589154,193.703919 239.520508,185.657475 L240.244894,185.239478 C248.523597,184.089985 250.489789,183.776488 259.492878,182 L260.217264,182.835994 L258.871975,187.851959 C260.424232,186.911466 261.873005,185.970972 263.425262,185.239478 C267.668097,183.149492 272.324867,182.522496 274.911962,182.522496 C278.844345,182.522496 283.190664,183.671988 284.949888,188.269956 C286.605629,192.345428 285.570791,197.361393 283.294148,207.288824 L282.155826,212.30479 C279.879183,223.381713 279.465248,225.367199 278.223443,232.891147 L277.395572,233.518142 L277.499056,233.622642 Z M306.558435,233.650218 C302.212116,233.650218 299.418054,233.545718 296.727476,233.650218 C294.036897,233.650218 291.449803,233.859216 287.413935,233.963716 L287.206968,233.650218 L287,233.232221 C288.138322,229.05225 288.655741,227.58926 289.276643,226.12627 C289.794062,224.66328 290.311481,223.20029 291.346319,218.91582 C292.588124,213.377358 293.415995,209.510885 293.933413,206.062409 C294.554316,202.822932 294.864767,200.001451 295.278703,196.761974 L295.589154,196.552975 L295.899605,196.239478 C300.245924,195.612482 302.936502,195.194485 305.730565,194.776488 C308.524627,194.358491 311.422173,193.835994 315.871975,193 L316.078943,193.417997 L316.182427,193.835994 C315.354556,197.28447 314.526686,200.732946 313.698816,204.181422 C312.870946,207.629898 312.043075,211.078374 311.318689,214.526851 C309.766432,221.8418 309.042046,224.558781 308.731594,226.544267 C308.317659,228.425254 308.214175,229.365747 307.593273,233.127721 L307.179338,233.441219 L306.765402,233.754717 L306.558435,233.650218 Z M352.499319,207.975327 C352.188868,209.856313 350.533127,216.857765 348.359968,219.783745 C346.807711,221.978229 345.048487,223.33672 342.978811,223.33672 C342.357909,223.33672 338.83946,223.33672 338.735976,218.007257 C338.735976,215.394775 339.253395,212.677794 339.874298,209.751814 C341.737006,201.287373 344.013649,194.285922 349.705257,194.285922 C354.15506,194.285922 354.465511,199.510885 352.499319,207.975327 Z M371.229884,208.811321 C373.713495,197.734398 371.747303,192.509434 369.367176,189.374456 C365.64176,184.567489 359.018798,183 352.188868,183 C348.049517,183 338.322041,183.417997 330.664241,190.523948 C325.179601,195.644412 322.592506,202.645864 321.143733,209.333817 C319.591476,216.12627 317.832252,228.352685 329.008501,232.950653 C332.423466,234.413643 337.390687,234.83164 340.598684,234.83164 C348.773903,234.83164 357.156089,232.532656 363.4686,225.844702 C368.332338,220.41074 370.505497,212.259797 371.333368,208.811321 L371.229884,208.811321 Z M545.661919,234.891147 C536.969281,234.786647 534.48567,234.786647 526.517419,235.204644 L526,234.577649 C528.173159,226.322206 530.346319,217.962264 532.312511,209.602322 C534.796122,198.734398 535.417024,194.13643 536.244894,187.761974 L536.865797,187.239478 C545.454951,185.985486 547.835078,185.671988 556.838167,184 L557.045135,184.731495 C555.389394,191.628447 553.837137,198.4209 552.181397,205.213353 C548.869916,219.529753 547.731594,226.844702 546.489789,234.36865 L545.661919,234.995646 L545.661919,234.891147 Z" id="Shape" fill="#FEFEFE"></path> <path d="M533.159909,209.373777 C532.745974,211.150265 531.090233,218.256216 528.917074,221.182195 C527.468301,223.272181 523.949852,224.630672 521.983661,224.630672 C521.362758,224.630672 517.947793,224.630672 517.740826,219.405708 C517.740826,216.793226 518.258244,214.076245 518.879147,211.150265 C520.741855,202.894822 523.018498,195.893371 528.710106,195.893371 C533.159909,195.893371 535.126101,201.013836 533.159909,209.478277 L533.159909,209.373777 Z M550.234733,210.209772 C552.718344,199.132849 542.576933,209.269278 541.024677,205.611804 C538.541066,199.864344 540.093322,188.369423 530.158879,184.50295 C526.329979,182.935461 517.32689,184.920947 509.66909,192.026898 C504.287934,197.042863 501.597355,204.044315 500.148582,210.732268 C498.596326,217.420222 496.837101,229.751136 507.909866,234.035606 C511.428315,235.603095 514.636312,236.021092 517.844309,235.812094 C529.020558,235.185098 537.506228,218.151717 543.818739,211.463763 C548.682476,206.1343 549.510347,213.449249 550.234733,210.209772 Z M420.292089,233.622642 C413.151708,233.518142 410.668097,233.518142 402.28591,233.936139 L401.975459,233.309144 C402.699846,230.069666 403.527716,226.934688 404.252102,223.69521 L405.183456,219.306241 C406.735713,212.513788 408.28797,204.467344 408.391454,202.063861 C408.598421,200.600871 409.012356,196.943396 404.976489,196.943396 C403.217264,196.943396 401.354556,197.77939 399.595332,198.615385 C398.663978,202.272859 396.594302,212.513788 395.559465,217.111756 C393.593273,226.934688 393.386305,228.08418 392.454951,232.891147 L391.834048,233.518142 C384.4867,233.413643 381.899605,233.413643 373.413935,233.83164 L373,233.100145 C374.448773,227.248186 375.794062,221.396226 377.139351,215.544267 C380.6578,199.764877 381.48567,193.703919 382.520508,185.657475 L383.141411,185.239478 C391.420113,184.089985 393.489789,183.776488 402.389394,182 L403.113781,182.835994 L401.871975,187.851959 C403.320748,186.911466 404.873005,185.970972 406.321778,185.239478 C410.564613,183.149492 415.221383,182.522496 417.808478,182.522496 C421.740862,182.522496 425.983697,183.671988 427.846405,188.269956 C429.502145,192.345428 428.363824,197.361393 426.08718,207.288824 L424.948859,212.30479 C422.568732,223.381713 422.25828,225.367199 421.016475,232.891147 L420.188605,233.518142 L420.292089,233.622642 Z M482.293118,147.104499 L476.291059,147.208999 C460.768492,147.417997 454.559465,147.313498 452.075854,147 C451.868886,148.149492 451.454951,150.134978 451.454951,150.134978 C451.454951,150.134978 445.866827,176.050798 445.866827,176.155298 C445.866827,176.155298 432.620903,231.330914 432,233.943396 C445.556375,233.734398 451.041016,233.734398 453.421143,234.047896 C453.938562,231.435414 457.043075,216.07402 457.146559,216.07402 C457.146559,216.07402 459.837137,204.788099 459.940621,204.370102 C459.940621,204.370102 460.768492,203.22061 461.596362,202.698113 L462.838167,202.698113 C474.531835,202.698113 487.674275,202.698113 498.022653,195.069666 C505.05955,189.844702 509.819804,182.007257 511.992964,172.602322 C512.510383,170.303338 512.924318,167.586357 512.924318,164.764877 C512.924318,161.107402 512.199931,157.554427 510.130256,154.732946 C504.852583,147.313498 494.400721,147.208999 482.293118,147.104499 Z M490.054402,174.169811 C488.812597,179.917271 485.08718,184.828737 480.326926,187.127721 C476.394543,189.113208 471.634289,189.322206 466.667067,189.322206 L463.45907,189.322206 L463.666037,188.068215 C463.666037,188.068215 469.564613,162.152395 469.564613,162.256894 L469.771581,160.898403 L469.875064,159.853411 L472.255191,160.062409 C472.255191,160.062409 484.466278,161.107402 484.673245,161.107402 C489.433499,162.988389 491.503175,167.795356 490.054402,174.169811 Z M617.261369,182.835994 L616.536983,182 C607.740862,183.776488 606.085121,184.089985 598.013386,185.239478 L597.392483,185.866473 C597.392483,185.970972 597.288999,186.075472 597.288999,186.28447 L597.288999,186.179971 C591.28694,200.287373 591.390424,197.256894 586.526686,208.333817 C586.526686,207.811321 586.526686,207.497823 586.423202,206.975327 L585.181397,182.940493 L584.45701,182.104499 C575.14347,183.880987 574.936502,184.194485 566.450832,185.343977 L565.82993,185.970972 C565.726446,186.28447 565.726446,186.597968 565.726446,186.911466 L565.82993,187.015965 C566.864767,192.554427 566.6578,191.300435 567.692638,199.973875 C568.210057,204.258345 568.830959,208.542816 569.348378,212.722787 C570.176248,219.828737 570.693667,223.277213 571.728505,234.040639 C565.933413,243.654572 564.588124,247.312046 559,255.776488 L559.310451,256.612482 C567.692638,256.298984 569.555346,256.298984 575.764373,256.298984 L577.109662,254.731495 C581.766432,244.595065 617.364853,182.940493 617.364853,182.940493 L617.261369,182.835994 Z M314.543608,189.75837 C319.303862,186.414394 319.924765,181.816425 315.888897,179.412942 C311.85303,177.009459 304.712649,177.740954 299.952395,181.084931 C295.192141,184.324408 294.674722,188.922376 298.71059,191.430359 C302.642973,193.729343 309.783354,193.102347 314.543608,189.75837 Z" id="Shape" fill="#FEFEFE"></path> <path d="M575.734683,256.104499 L568.80127,268.121916 C566.628111,272.197388 562.488759,275.332366 556.072765,275.332366 L545,275.123367 L548.207997,264.255443 L550.381157,264.255443 C551.519478,264.255443 552.347349,264.150943 552.968251,263.837446 C553.589154,263.628447 553.899605,263.21045 554.417024,262.583454 L558.556375,256 L575.838167,256 L575.734683,256.104499 Z" id="Shape" fill="#FEFEFE"></path> </g> </g>`;

let amex_single = `<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="750" height="471" viewBox="0 0 750 471" enable-background="new 0 0 752 471" xml:space="preserve"><title>Slice 1</title><desc>Created with Sketch.</desc><g><g><path fill="#2557D6" d="M554.594,130.608l-14.521,35.039h29.121L554.594,130.608z M387.03,152.321c2.738-1.422,4.349-4.515,4.349-8.356c0-3.764-1.693-6.49-4.431-7.771c-2.492-1.42-6.328-1.584-10.006-1.584h-25.978v19.523h25.63C380.7,154.134,384.131,154.074,387.03,152.321z M54.142,130.608l-14.357,35.039h28.8L54.142,130.608z M722.565,355.08h-40.742v-18.852h40.578c4.023,0,6.84-0.525,8.537-2.177c1.471-1.358,2.494-3.336,2.494-5.733c0-2.562-1.023-4.596-2.578-5.813c-1.529-1.342-3.76-1.953-7.434-1.953c-19.81-0.67-44.523,0.609-44.523-27.211c0-12.75,8.131-26.172,30.27-26.172h42.025v-17.492h-39.045c-11.783,0-20.344,2.81-26.406,7.181v-7.181h-57.752c-9.233,0-20.074,2.279-25.201,7.181v-7.181H499.655v7.181c-8.207-5.898-22.057-7.181-28.447-7.181H403.18v7.181c-6.492-6.262-20.935-7.181-29.734-7.181h-76.134l-17.42,18.775l-16.318-18.775H149.847v122.675h111.586l17.95-19.076l16.91,19.076l68.78,0.059v-28.859h6.764c9.125,0.145,19.889-0.223,29.387-4.311v33.107h56.731v-31.976h2.736c3.492,0,3.838,0.146,3.838,3.621v28.348h172.344c10.941,0,22.38-2.786,28.712-7.853v7.853h54.668c11.375,0,22.485-1.588,30.938-5.653v-22.853C746.069,351.297,736.079,355.08,722.565,355.08z M372.734,326.113h-26.325v29.488h-41.006L279.425,326.5l-26.997,29.102h-83.569v-87.914h84.855l25.955,28.818l26.835-28.818h67.414c16.743,0,35.555,4.617,35.555,28.963C409.473,321.072,391.176,326.113,372.734,326.113z M499.323,322.127c2.98,4.291,3.41,8.297,3.496,16.047v17.428h-21.182v-10.998c0-5.289,0.512-13.121-3.41-17.209c-3.08-3.149-7.781-3.901-15.48-3.901h-22.545v32.108h-21.198v-87.914h48.706c10.685,0,18.462,0.472,25.386,4.148c6.658,4.006,10.848,9.494,10.848,19.523c-0.002,14.031-9.399,21.19-14.953,23.389C493.684,316.473,497.522,319.566,499.323,322.127z M586.473,285.869h-49.404v15.982h48.197v17.938h-48.197v17.492l49.404,0.078v18.242h-70.414v-87.914h70.414V285.869z M640.686,355.6h-41.09v-18.852h40.926c4.002,0,6.84-0.527,8.619-2.178c1.449-1.359,2.492-3.336,2.492-5.73c0-2.564-1.129-4.598-2.574-5.818c-1.615-1.34-3.842-1.948-7.514-1.948c-19.73-0.673-44.439,0.606-44.439-27.212c0-12.752,8.047-26.174,30.164-26.174h42.297v18.709h-38.703c-3.836,0-6.33,0.146-8.451,1.592c-2.313,1.423-3.17,3.535-3.17,6.322c0,3.316,1.963,5.574,4.615,6.549c2.228,0.771,4.617,0.996,8.211,0.996l11.359,0.308c11.449,0.274,19.313,2.25,24.092,7.069c4.105,4.232,6.311,9.578,6.311,18.625C673.829,346.771,661.963,355.6,640.686,355.6z M751.192,343.838L751.192,343.838L751.192,343.838L751.192,343.838z M477.061,287.287c-2.549-1.508-6.311-1.588-10.066-1.588h-25.979v19.744h25.631c4.104,0,7.594-0.144,10.414-1.812c2.734-1.646,4.371-4.678,4.371-8.438C481.432,291.434,479.795,288.711,477.061,287.287z M712.784,285.697c-3.838,0-6.389,0.145-8.537,1.588c-2.227,1.426-3.081,3.537-3.081,6.326c0,3.315,1.879,5.572,4.612,6.549c2.228,0.771,4.615,0.996,8.129,0.996l11.437,0.303c11.537,0.285,19.242,2.262,23.938,7.08c0.855,0.668,1.369,1.42,1.957,2.174v-25.014h-38.453L712.784,285.697L712.784,285.697z M373.47,285.697h-27.509v22.391h27.265c8.105,0,13.146-4.006,13.149-11.611C386.372,288.789,381.086,285.697,373.47,285.697z M189.872,285.697v15.984h46.315v17.938h-46.315v17.49h51.87l24.1-25.791l-23.076-25.621H189.872L189.872,285.697z M325.321,347.176v-70.482l-32.391,34.673L325.321,347.176z M191.649,206.025v15.148h176.263l-0.082-32.046h3.411c2.39,0.083,3.084,0.302,3.084,4.229v27.818h91.164v-7.461c7.353,3.924,18.789,7.461,33.838,7.461h38.353l8.209-19.522h18.197l8.026,19.522h73.906V202.63l11.189,18.543h59.227V98.59h-58.611v14.477l-8.207-14.477h-60.143v14.477l-7.537-14.477h-81.24c-13.6,0-25.551,1.89-35.207,7.158V98.59h-56.063v7.158c-6.146-5.43-14.519-7.158-23.826-7.158H180.784l-13.742,31.662L152.928,98.59H88.417v14.477L81.329,98.59H26.312L0.763,156.874v46.621l37.779-87.894h31.346l35.88,83.217v-83.217h34.435l27.61,59.625l25.365-59.625h35.126v87.894h-21.625l-0.079-68.837l-30.593,68.837h-18.524l-30.671-68.898v68.898H83.899l-8.106-19.605H31.865l-8.19,19.605H0.762v17.682h36.049l8.128-19.523h18.198l8.106,19.523h70.925V206.25l6.33,14.989h36.819L191.649,206.025z M469.401,125.849c6.818-7.015,17.5-10.25,32.039-10.25h20.424v18.833h-19.996c-7.696,0-12.047,1.14-16.233,5.208c-3.599,3.7-6.066,10.696-6.066,19.908c0,9.417,1.881,16.206,5.801,20.641c3.248,3.478,9.152,4.533,14.705,4.533h9.478l29.733-69.12h31.611l35.719,83.134v-83.133h32.123l37.086,61.213v-61.213h21.611v87.891h-29.898l-39.989-65.968v65.968h-42.968l-8.209-19.605h-43.827l-7.966,19.605h-24.688c-10.254,0-23.238-2.258-30.59-9.722c-7.416-7.462-11.271-17.571-11.271-33.553C458.026,147.182,460.329,135.266,469.401,125.849z M426.006,115.6h21.526v87.894h-21.526V115.6z M328.951,115.6h48.525c10.779,0,18.727,0.285,25.547,4.21c6.674,3.926,10.676,9.658,10.676,19.46c0,14.015-9.393,21.254-14.864,23.429c4.614,1.75,8.559,4.841,10.438,7.401c2.979,4.372,3.492,8.277,3.492,16.126v17.267h-21.279l-0.08-11.084c0-5.29,0.508-12.896-3.33-17.122c-3.082-3.09-7.782-3.763-15.379-3.763H350.05v31.97h-21.098L328.951,115.6L328.951,115.6z M243.902,115.6h70.479v18.303h-49.379v15.843h48.193v18.017h-48.193v17.553h49.379v18.177h-70.479V115.6L243.902,115.6z"/></g></g></svg>`;
let visa_single = `<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="750px" height="471px" viewBox="0 0 750 471" enable-background="new 0 0 750 471" xml:space="preserve"><title>Slice 1</title><desc>Created with Sketch.</desc><g id="visa" sketch:type="MSLayerGroup"><path id="Shape" sketch:type="MSShapeGroup" fill="#0E4595" d="M278.198,334.228l33.36-195.763h53.358l-33.384,195.763H278.198L278.198,334.228z"/><path id="path13" sketch:type="MSShapeGroup" fill="#0E4595" d="M524.307,142.687c-10.57-3.966-27.135-8.222-47.822-8.222c-52.725,0-89.863,26.551-90.18,64.604c-0.297,28.129,26.514,43.821,46.754,53.185c20.77,9.597,27.752,15.716,27.652,24.283c-0.133,13.123-16.586,19.116-31.924,19.116c-21.355,0-32.701-2.967-50.225-10.274l-6.877-3.112l-7.488,43.823c12.463,5.466,35.508,10.199,59.438,10.445c56.09,0,92.502-26.248,92.916-66.884c0.199-22.27-14.016-39.216-44.801-53.188c-18.65-9.056-30.072-15.099-29.951-24.269c0-8.137,9.668-16.838,30.559-16.838c17.447-0.271,30.088,3.534,39.936,7.5l4.781,2.259L524.307,142.687"/><path id="Path" sketch:type="MSShapeGroup" fill="#0E4595" d="M661.615,138.464h-41.23c-12.773,0-22.332,3.486-27.941,16.234l-79.244,179.402h56.031c0,0,9.16-24.121,11.232-29.418c6.123,0,60.555,0.084,68.336,0.084c1.596,6.854,6.492,29.334,6.492,29.334h49.512L661.615,138.464L661.615,138.464z M596.198,264.872c4.414-11.279,21.26-54.724,21.26-54.724c-0.314,0.521,4.381-11.334,7.074-18.684l3.607,16.878c0,0,10.217,46.729,12.352,56.527h-44.293V264.872L596.198,264.872z"/><path id="path16" sketch:type="MSShapeGroup" fill="#0E4595" d="M232.903,138.464L180.664,271.96l-5.565-27.129c-9.726-31.274-40.025-65.157-73.898-82.12l47.767,171.204l56.455-0.064l84.004-195.386L232.903,138.464"/><path id="path18" sketch:type="MSShapeGroup" fill="#F2AE14" d="M131.92,138.464H45.879l-0.682,4.073c66.939,16.204,111.232,55.363,129.618,102.415l-18.709-89.96C152.877,142.596,143.509,138.896,131.92,138.464"/></g></svg>`;
let diners_single = `<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="750" height="471" viewBox="0 0 750 471" enable-background="new 0 0 750 471" xml:space="preserve"><title>diners</title><desc>Created with Sketch.</desc><g id="diners" sketch:type="MSLayerGroup"><path id="Shape-path" sketch:type="MSShapeGroup" fill="#0079BE" d="M584.934,236.947c0-99.416-82.98-168.133-173.896-168.1h-78.241c-92.003-0.033-167.73,68.705-167.73,168.1c0,90.931,75.729,165.641,167.73,165.203h78.241C501.951,402.587,584.934,327.857,584.934,236.947L584.934,236.947z"/><path id="Shape-path_1_" sketch:type="MSShapeGroup" fill="#FFFFFF" d="M333.281,82.932c-84.069,0.026-152.193,68.308-152.215,152.58c0.021,84.258,68.145,152.532,152.215,152.559c84.088-0.026,152.229-68.301,152.239-152.559C485.508,151.238,417.369,82.958,333.281,82.932L333.281,82.932z"/><path id="Path" sketch:type="MSShapeGroup" fill="#0079BE" d="M237.066,235.098c0.08-41.18,25.747-76.296,61.94-90.25v180.479C262.813,311.381,237.145,276.283,237.066,235.098z M368.066,325.373V144.848c36.208,13.921,61.915,49.057,61.981,90.256C429.981,276.316,404.274,311.426,368.066,325.373z"/></g></svg>`;
let discover_single = `<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="780px" height="501px" viewBox="0 0 780 501" enable-background="new 0 0 780 501" xml:space="preserve"><title>discover</title><desc>Created with Sketch.</desc><g id="Page-1" sketch:type="MSPage"><g id="discover" sketch:type="MSLayerGroup"><path fill="#F47216" d="M409.412,197.758c30.938,0,56.02,23.58,56.02,52.709v0.033c0,29.129-25.082,52.742-56.02,52.742c-30.941,0-56.022-23.613-56.022-52.742v-0.033C353.39,221.338,378.471,197.758,409.412,197.758L409.412,197.758z"/><path d="M321.433,198.438c8.836,0,16.247,1.785,25.269,6.09v22.752c-8.544-7.863-15.955-11.154-25.757-11.154c-19.265,0-34.413,15.015-34.413,34.051c0,20.074,14.681,34.195,35.368,34.195c9.313,0,16.586-3.12,24.802-10.856v22.764c-9.343,4.141-16.912,5.775-25.757,5.775c-31.277,0-55.581-22.597-55.581-51.737C265.363,221.49,290.314,198.438,321.433,198.438L321.433,198.438z"/><path d="M224.32,199.064c11.546,0,22.109,3.721,30.942,10.994l-10.748,13.248c-5.351-5.646-10.411-8.027-16.563-8.027c-8.854,0-15.301,4.745-15.301,10.988c0,5.354,3.618,8.188,15.944,12.482c23.364,8.043,30.289,15.176,30.289,30.926c0,19.193-14.976,32.554-36.319,32.554c-15.631,0-26.993-5.795-36.457-18.871l13.268-12.031c4.73,8.609,12.622,13.223,22.42,13.223c9.163,0,15.947-5.951,15.947-13.984c0-4.164-2.056-7.733-6.158-10.258c-2.066-1.195-6.158-2.977-14.199-5.646c-19.292-6.538-25.91-13.527-25.91-27.186C191.474,211.25,205.688,199.064,224.32,199.064L224.32,199.064z"/><polygon points="459.043,200.793 481.479,200.793 509.563,267.385 538.01,200.793 560.276,200.793 514.783,302.479 503.729,302.479 "/><polygon points="157.83,200.945 178.371,200.945 178.371,300.088 157.83,300.088 "/><polygon points="569.563,200.945 627.815,200.945 627.815,217.744 590.09,217.744 590.09,239.75 626.426,239.75 626.426,256.541 590.09,256.541 590.09,283.303 627.815,283.303 627.815,300.088 569.563,300.088 "/><path d="M685.156,258.322c15.471-2.965,23.984-12.926,23.984-28.105c0-18.562-13.576-29.271-37.266-29.271H641.42v99.143h20.516V260.26h2.68l28.43,39.828h25.26L685.156,258.322z M667.938,246.586h-6.002v-30.025h6.326c12.791,0,19.744,5.049,19.744,14.697C688.008,241.224,681.055,246.586,667.938,246.586z"/><path d="M91.845,200.945H61.696v99.143h29.992c15.946,0,27.465-3.543,37.573-11.445c12.014-9.36,19.117-23.467,19.117-38.057C148.379,221.327,125.157,200.945,91.845,200.945z M115.842,275.424c-6.454,5.484-14.837,7.879-28.108,7.879H82.22v-65.559h5.513c13.271,0,21.323,2.238,28.108,8.018c7.104,5.956,11.377,15.183,11.377,24.682C127.219,259.957,122.945,269.468,115.842,275.424z"/></g></g></svg>`;
let jcb_single = `<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="750px" height="471px" viewBox="0 0 750 471" enable-background="new 0 0 750 471" xml:space="preserve"><title>Slice 1</title><desc>Created with Sketch.</desc><g><path id="path3494" sketch:type="MSShapeGroup" fill="#FFFFFF" d="M617.242,346.766c0,41.615-33.729,75.36-75.357,75.36H132.759V124.245c0-41.626,33.73-75.371,75.364-75.371h409.12V346.766L617.242,346.766L617.242,346.766z"/><linearGradient id="path3496_1_" gradientUnits="userSpaceOnUse" x1="824.7424" y1="333.7813" x2="825.7424" y2="333.7813" gradientTransform="matrix(132.8743 0 0 -323.0226 -109129.5313 108054.6016)"><stop offset="0" style="stop-color:#007B40"/><stop offset="1" style="stop-color:#55B330"/></linearGradient><path id="path3496" sketch:type="MSShapeGroup" fill="url(#path3496_1_)" d="M483.86,242.045c11.686,0.254,23.439-0.516,35.078,0.4c11.787,2.199,14.627,20.043,4.156,25.887c-7.145,3.85-15.633,1.434-23.379,2.113H483.86V242.045L483.86,242.045z M525.694,209.9c2.596,9.164-6.238,17.392-15.064,16.13h-26.77c0.188-8.642-0.367-18.022,0.273-26.209c10.723,0.302,21.547-0.616,32.209,0.48C520.922,201.452,524.756,205.218,525.694,209.9L525.694,209.9z M590.119,73.997c0.498,17.501,0.072,35.927,0.215,53.783c-0.033,72.596,0.07,145.195-0.057,217.789c-0.469,27.207-24.582,50.847-51.6,51.39c-27.045,0.11-54.094,0.017-81.143,0.047v-109.75c29.471-0.153,58.957,0.308,88.416-0.231c13.666-0.858,28.635-9.875,29.271-24.914c1.609-15.103-12.631-25.551-26.152-27.201c-5.197-0.135-5.045-1.515,0-2.117c12.895-2.787,23.021-16.133,19.227-29.499c-3.234-14.058-18.771-19.499-31.695-19.472c-26.352-0.179-52.709-0.025-79.063-0.077c0.17-20.489-0.355-41,0.283-61.474c2.088-26.716,26.807-48.748,53.447-48.27C537.555,73.998,563.838,73.998,590.119,73.997L590.119,73.997z"/><linearGradient id="path3498_1_" gradientUnits="userSpaceOnUse" x1="824.7551" y1="333.7822" x2="825.7484" y2="333.7822" gradientTransform="matrix(133.4307 0 0 -323.0203 -109887.6875 108053.8203)"><stop offset="0" style="stop-color:#1D2970"/><stop offset="1" style="stop-color:#006DBA"/></linearGradient><path id="path3498" sketch:type="MSShapeGroup" fill="url(#path3498_1_)" d="M159.742,125.041c0.673-27.164,24.888-50.611,51.872-51.008c26.945-0.083,53.894-0.012,80.839-0.036c-0.074,90.885,0.146,181.776-0.111,272.657c-1.038,26.834-24.989,49.834-51.679,50.309c-26.996,0.098-53.995,0.014-80.992,0.041V283.551c26.223,6.195,53.722,8.832,80.474,4.723c15.991-2.574,33.487-10.426,38.901-27.016c3.984-14.191,1.741-29.126,2.334-43.691v-33.825h-46.297c-0.208,22.371,0.426,44.781-0.335,67.125c-1.248,13.734-14.849,22.46-27.802,21.994c-16.064,0.17-47.897-11.641-47.897-11.641C158.969,219.305,159.515,166.814,159.742,125.041L159.742,125.041z"/><linearGradient id="path3500_1_" gradientUnits="userSpaceOnUse" x1="824.7424" y1="333.7813" x2="825.741" y2="333.7813" gradientTransform="matrix(132.9583 0 0 -323.0276 -109347.9219 108056.2656)"><stop offset="0" style="stop-color:#6E2B2F"/><stop offset="1" style="stop-color:#E30138"/></linearGradient><path id="path3500" sketch:type="MSShapeGroup" fill="url(#path3500_1_)" d="M309.721,197.39c-2.437,0.517-0.491-8.301-1.114-11.646c0.166-21.15-0.346-42.323,0.284-63.458c2.082-26.829,26.991-48.916,53.738-48.288h78.767c-0.074,90.885,0.145,181.775-0.111,272.657c-1.039,26.834-24.992,49.833-51.682,50.309c-26.998,0.101-53.998,0.015-80.997,0.042V272.707c18.44,15.129,43.5,17.484,66.472,17.525c17.318-0.006,34.535-2.676,51.353-6.67V260.79c-18.953,9.446-41.234,15.446-62.244,10.019c-14.656-3.649-25.294-17.813-25.057-32.937c-1.698-15.729,7.522-32.335,22.979-37.011c19.192-6.008,40.108-1.413,58.096,6.398c3.855,2.018,7.766,4.521,6.225-1.921v-17.899c-30.086-7.158-62.104-9.792-92.33-2.005C325.352,187.902,316.828,191.645,309.721,197.39L309.721,197.39z"/></g></svg>`;
let maestro_single = `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="482.6" height="374.31" viewBox="0 0 482.6 374.31"> <title>maestro</title> <g> <path d="M278.8,421.77V397c0-9.35-6-15.64-15.55-15.72-5-.08-10.26,1.49-13.9,7-2.73-4.38-7-7-13.07-7a13.08,13.08,0,0,0-11.58,5.87v-4.88h-8.61v39.55h8.69V399.85c0-6.87,3.81-10.51,9.68-10.51,5.71,0,8.61,3.72,8.61,10.42v22h8.69V399.85c0-6.87,4-10.51,9.68-10.51,5.87,0,8.69,3.72,8.69,10.42v22ZM327.28,402V382.23h-8.61V387c-2.73-3.56-6.87-5.79-12.49-5.79-11.09,0-19.77,8.69-19.77,20.77s8.69,20.77,19.77,20.77c5.63,0,9.76-2.23,12.49-5.79v4.8h8.61Zm-32,0c0-6.95,4.55-12.66,12-12.66,7.12,0,11.91,5.46,11.91,12.66s-4.8,12.66-11.91,12.66C299.81,414.66,295.26,408.95,295.26,402ZM511.4,381.19a22.29,22.29,0,0,1,8.49,1.59,20.71,20.71,0,0,1,6.75,4.38,20,20,0,0,1,4.46,6.59,22,22,0,0,1,0,16.52,20,20,0,0,1-4.46,6.59,20.69,20.69,0,0,1-6.75,4.38,23.43,23.43,0,0,1-17,0,20.47,20.47,0,0,1-6.73-4.38,20.21,20.21,0,0,1-4.44-6.59,22,22,0,0,1,0-16.52,20.23,20.23,0,0,1,4.44-6.59,20.48,20.48,0,0,1,6.73-4.38A22.29,22.29,0,0,1,511.4,381.19Zm0,8.14a12.84,12.84,0,0,0-4.91.93,11.62,11.62,0,0,0-3.92,2.6,12.13,12.13,0,0,0-2.6,4,14.39,14.39,0,0,0,0,10.28,12.11,12.11,0,0,0,2.6,4,11.62,11.62,0,0,0,3.92,2.6,13.46,13.46,0,0,0,9.83,0,11.86,11.86,0,0,0,3.94-2.6,12,12,0,0,0,2.62-4,14.39,14.39,0,0,0,0-10.28,12,12,0,0,0-2.62-4,11.86,11.86,0,0,0-3.94-2.6A12.84,12.84,0,0,0,511.4,389.32ZM374.1,402c-.08-12.33-7.69-20.77-18.78-20.77-11.58,0-19.69,8.44-19.69,20.77,0,12.58,8.44,20.77,20.27,20.77,6,0,11.42-1.49,16.22-5.54l-4.22-6.37A18.84,18.84,0,0,1,356.4,415c-5.54,0-10.59-2.56-11.83-9.68h29.37C374,404.23,374.1,403.16,374.1,402Zm-29.45-3.47c.91-5.71,4.38-9.6,10.51-9.6,5.54,0,9.1,3.47,10,9.6Zm65.69-6.2A25.49,25.49,0,0,0,398,388.93c-4.72,0-7.53,1.74-7.53,4.63,0,2.65,3,3.39,6.7,3.89l4.05.58c8.61,1.24,13.82,4.88,13.82,11.83,0,7.53-6.62,12.91-18,12.91-6.45,0-12.41-1.66-17.13-5.13l4.05-6.7a21.07,21.07,0,0,0,13.16,4.14c5.87,0,9-1.74,9-4.8,0-2.23-2.23-3.47-6.95-4.14l-4.05-.58c-8.85-1.24-13.65-5.21-13.65-11.67,0-7.86,6.45-12.66,16.46-12.66,6.29,0,12,1.41,16.13,4.14Zm41.35-2.23H437.62V408c0,4,1.41,6.62,5.71,6.62a15.89,15.89,0,0,0,7.61-2.23l2.48,7.36a20.22,20.22,0,0,1-10.76,3.06c-10.18,0-13.73-5.46-13.73-14.65v-18h-8v-7.86h8v-12h8.69v12h14.06Zm29.78-8.85a18.38,18.38,0,0,1,6.12,1.08l-2.65,8.11a14,14,0,0,0-5.38-1c-5.63,0-8.44,3.64-8.44,10.18v22.17h-8.6V382.23H471V387a11.66,11.66,0,0,1,10.42-5.79Z" transform="translate(-132.9 -48.5)"/> <g id="_Group_" data-name="&lt;Group&gt;"> <rect x="176.05" y="31.89" width="130.5" height="234.51" fill="#7673c0"/> <path id="_Path_" data-name="&lt;Path&gt;" d="M317.24,197.64a148.88,148.88,0,0,1,57-117.26,149.14,149.14,0,1,0,0,234.51A148.88,148.88,0,0,1,317.24,197.64Z" transform="translate(-132.9 -48.5)" fill="#eb001b"/> <path d="M615.5,197.64A149.14,149.14,0,0,1,374.2,314.9a149.16,149.16,0,0,0,0-234.51A149.14,149.14,0,0,1,615.5,197.64Z" transform="translate(-132.9 -48.5)" fill="#00a1df"/> </g> </g></svg>`;
let mastercard_single = `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="482.51" height="374" viewBox="0 0 482.51 374"> <title>mastercard</title> <g> <path d="M220.13,421.67V396.82c0-9.53-5.8-15.74-15.32-15.74-5,0-10.35,1.66-14.08,7-2.9-4.56-7-7-13.25-7a14.07,14.07,0,0,0-12,5.8v-5h-7.87v39.76h7.87V398.89c0-7,4.14-10.35,9.94-10.35s9.11,3.73,9.11,10.35v22.78h7.87V398.89c0-7,4.14-10.35,9.94-10.35s9.11,3.73,9.11,10.35v22.78Zm129.22-39.35h-14.5v-12H327v12h-8.28v7H327V408c0,9.11,3.31,14.5,13.25,14.5A23.17,23.17,0,0,0,351,419.6l-2.49-7a13.63,13.63,0,0,1-7.46,2.07c-4.14,0-6.21-2.49-6.21-6.63V389h14.5v-6.63Zm73.72-1.24a12.39,12.39,0,0,0-10.77,5.8v-5h-7.87v39.76h7.87V399.31c0-6.63,3.31-10.77,8.7-10.77a24.24,24.24,0,0,1,5.38.83l2.49-7.46a28,28,0,0,0-5.8-.83Zm-111.41,4.14c-4.14-2.9-9.94-4.14-16.15-4.14-9.94,0-16.15,4.56-16.15,12.43,0,6.63,4.56,10.35,13.25,11.6l4.14.41c4.56.83,7.46,2.49,7.46,4.56,0,2.9-3.31,5-9.53,5a21.84,21.84,0,0,1-13.25-4.14l-4.14,6.21c5.8,4.14,12.84,5,17,5,11.6,0,17.81-5.38,17.81-12.84,0-7-5-10.35-13.67-11.6l-4.14-.41c-3.73-.41-7-1.66-7-4.14,0-2.9,3.31-5,7.87-5,5,0,9.94,2.07,12.43,3.31Zm120.11,16.57c0,12,7.87,20.71,20.71,20.71,5.8,0,9.94-1.24,14.08-4.56l-4.14-6.21a16.74,16.74,0,0,1-10.35,3.73c-7,0-12.43-5.38-12.43-13.25S445,389,452.07,389a16.74,16.74,0,0,1,10.35,3.73l4.14-6.21c-4.14-3.31-8.28-4.56-14.08-4.56-12.43-.83-20.71,7.87-20.71,19.88h0Zm-55.5-20.71c-11.6,0-19.47,8.28-19.47,20.71s8.28,20.71,20.29,20.71a25.33,25.33,0,0,0,16.15-5.38l-4.14-5.8a19.79,19.79,0,0,1-11.6,4.14c-5.38,0-11.18-3.31-12-10.35h29.41v-3.31c0-12.43-7.46-20.71-18.64-20.71h0Zm-.41,7.46c5.8,0,9.94,3.73,10.35,9.94H364.68c1.24-5.8,5-9.94,11.18-9.94ZM268.59,401.79V381.91h-7.87v5c-2.9-3.73-7-5.8-12.84-5.8-11.18,0-19.47,8.7-19.47,20.71s8.28,20.71,19.47,20.71c5.8,0,9.94-2.07,12.84-5.8v5h7.87V401.79Zm-31.89,0c0-7.46,4.56-13.25,12.43-13.25,7.46,0,12,5.8,12,13.25,0,7.87-5,13.25-12,13.25-7.87.41-12.43-5.8-12.43-13.25Zm306.08-20.71a12.39,12.39,0,0,0-10.77,5.8v-5h-7.87v39.76H532V399.31c0-6.63,3.31-10.77,8.7-10.77a24.24,24.24,0,0,1,5.38.83l2.49-7.46a28,28,0,0,0-5.8-.83Zm-30.65,20.71V381.91h-7.87v5c-2.9-3.73-7-5.8-12.84-5.8-11.18,0-19.47,8.7-19.47,20.71s8.28,20.71,19.47,20.71c5.8,0,9.94-2.07,12.84-5.8v5h7.87V401.79Zm-31.89,0c0-7.46,4.56-13.25,12.43-13.25,7.46,0,12,5.8,12,13.25,0,7.87-5,13.25-12,13.25-7.87.41-12.43-5.8-12.43-13.25Zm111.83,0V366.17h-7.87v20.71c-2.9-3.73-7-5.8-12.84-5.8-11.18,0-19.47,8.7-19.47,20.71s8.28,20.71,19.47,20.71c5.8,0,9.94-2.07,12.84-5.8v5h7.87V401.79Zm-31.89,0c0-7.46,4.56-13.25,12.43-13.25,7.46,0,12,5.8,12,13.25,0,7.87-5,13.25-12,13.25C564.73,415.46,560.17,409.25,560.17,401.79Z" transform="translate(-132.74 -48.5)"/> <g> <rect x="169.81" y="31.89" width="143.72" height="234.42" fill="#ff5f00"/> <path d="M317.05,197.6A149.5,149.5,0,0,1,373.79,80.39a149.1,149.1,0,1,0,0,234.42A149.5,149.5,0,0,1,317.05,197.6Z" transform="translate(-132.74 -48.5)" fill="#eb001b"/> <path d="M615.26,197.6a148.95,148.95,0,0,1-241,117.21,149.43,149.43,0,0,0,0-234.42,148.95,148.95,0,0,1,241,117.21Z" transform="translate(-132.74 -48.5)" fill="#f79e1b"/> </g> </g></svg>`;
let unionpay_single = `<svg xmlns="http://www.w3.org/2000/svg" width="750" height="471" viewBox="0 0 750 471"> <g fill="none" fill-rule="evenodd"> <rect width="750" height="471" rx="40"/> <path fill="#D10429" d="M201.809581,55 L344.203266,55 C364.072152,55 376.490206,71.4063861 371.833436,91.4702467 L305.500331,378.94775 C300.843561,399.011611 280.871191,415.417997 261.002305,415.417997 L118.60862,415.417997 C98.7397339,415.417997 86.32168,399.011611 90.9784502,378.94775 L157.311555,91.4702467 C161.968325,71.3018868 181.837211,55 201.706097,55 L201.809581,55 Z"/> <path fill="#022E64" d="M331.750074,55 L495.564902,55 C515.433788,55 506.430699,71.4063861 501.773929,91.4702467 L435.440824,378.94775 C430.784054,399.011611 432.232827,415.417997 412.363941,415.417997 L248.549113,415.417997 C228.576743,415.417997 216.262173,399.011611 221.022427,378.94775 L287.355531,91.4702467 C292.012302,71.3018868 311.881188,55 331.853558,55 L331.750074,55 Z"/> <path fill="#076F74" d="M489.814981,55 L632.208666,55 C652.077552,55 664.495606,71.4063861 659.838836,91.4702467 L593.505731,378.94775 C588.848961,399.011611 568.876591,415.417997 549.007705,415.417997 L406.61402,415.417997 C386.64165,415.417997 374.32708,399.011611 378.98385,378.94775 L445.316955,91.4702467 C449.973725,71.3018868 469.842611,55 489.711498,55 L489.814981,55 Z"/> <path fill="#FEFEFE" d="M465.904754,326.014514 L479.357645,326.014514 L483.186545,312.952104 L469.837137,312.952104 L465.904754,326.014514 L465.904754,326.014514 Z M476.667067,290.066763 L476.667067,290.066763 L472.010297,305.532656 C472.010297,305.532656 477.081002,302.920174 479.875064,302.08418 C482.669126,301.457184 486.808478,300.934688 486.808478,300.934688 L490.016475,290.171263 L476.563583,290.171263 L476.667067,290.066763 Z M483.393513,267.912917 L483.393513,267.912917 L478.94371,282.751814 C478.94371,282.751814 483.910932,280.45283 486.704994,279.721335 C489.499056,278.98984 493.638407,278.780842 493.638407,278.780842 L496.846405,268.017417 L483.496997,268.017417 L483.393513,267.912917 Z M513.093359,267.912917 L513.093359,267.912917 L495.708083,325.910015 L500.364853,325.910015 L496.742921,337.927431 L492.086151,337.927431 L490.947829,341.584906 L474.390424,341.584906 L475.528745,337.927431 L442,337.927431 L445.311481,326.850508 L448.726446,326.850508 L466.318689,267.912917 L469.837137,256 L486.704994,256 L484.94577,261.956459 C484.94577,261.956459 489.395572,258.716981 493.741891,257.567489 C497.984726,256.417997 522.406899,256 522.406899,256 L518.784967,267.808418 L512.989875,267.808418 L513.093359,267.912917 Z"/> <path fill="#FEFEFE" d="M520 256L538.006178 256 538.213146 262.792453C538.109662 263.941945 539.041016 264.464441 541.214175 264.464441L544.836108 264.464441 541.524627 275.645864 531.797151 275.645864C523.414965 276.272859 520.206968 272.615385 520.413935 268.539913L520.103484 256.104499 520 256zM522.216235 309.20029L505.037927 309.20029 507.935473 299.272859 527.597391 299.272859 530.391454 290.181422 511.039986 290.181422 514.351467 279 568.163034 279 564.851553 290.181422 546.741891 290.181422 543.947829 299.272859 562.057491 299.272859 559.056461 309.20029 539.498026 309.20029 535.979578 313.380261 543.947829 313.380261 545.914021 325.920174C546.120989 327.174165 546.120989 328.01016 546.534924 328.532656 546.948859 328.950653 549.328986 329.159652 550.674275 329.159652L553.054402 329.159652 549.328986 341.386067 543.223443 341.386067C542.292089 341.386067 540.843316 341.281567 538.877124 341.281567 537.014416 341.072569 535.77261 340.027576 534.530805 339.400581 533.392483 338.878084 531.736743 337.519594 531.322808 335.11611L529.4601 322.576197 520.560494 334.907112C517.766432 338.773585 513.937532 341.804064 507.418054 341.804064L495 341.804064 498.311481 330.936139 503.071735 330.936139C504.417024 330.936139 505.65883 330.413643 506.590184 329.891147 507.521538 329.473149 508.349408 329.055152 509.177278 327.696662L522.216235 309.20029 522.216235 309.20029zM334.31354 282L379.742921 282 376.43144 292.972424 358.321778 292.972424 355.527716 302.272859 374.154797 302.272859 370.739832 313.558781 352.216235 313.558781 347.662948 328.711176C347.145529 330.383164 352.112751 330.592163 353.871975 330.592163L363.185516 329.338171 359.4601 341.878084 338.556375 341.878084C336.900635 341.878084 335.65883 341.669086 333.796122 341.251089 332.036897 340.833091 331.209027 339.997097 330.48464 338.847605 329.760254 337.593614 328.518449 336.65312 329.346319 333.936139L335.348378 313.872279 325 313.872279 328.414965 302.377358 338.763343 302.377358 341.557405 293.076923 331.209027 293.076923 334.520508 282.104499 334.31354 282zM365.700875 262.165457L384.327956 262.165457 380.912991 273.555878 355.455981 273.555878 352.661919 275.959361C351.420113 277.108853 351.109662 276.690856 349.557405 277.526851 348.108632 278.258345 345.107603 279.721335 341.175219 279.721335L333 279.721335 336.311481 268.748911 338.795092 268.748911C340.864767 268.748911 342.31354 268.539913 343.037927 268.121916 343.865797 267.599419 344.797151 266.449927 345.728505 264.56894L350.385275 256 368.908872 256 365.700875 262.269956 365.700875 262.165457zM400.808726 280.975327C400.808726 280.975327 405.879431 276.272859 414.572069 274.809869 416.538261 274.391872 428.956314 274.600871 428.956314 274.600871L430.819023 268.330914 404.637626 268.330914 400.808726 281.079826 400.808726 280.975327zM425.437866 285.782293L425.437866 285.782293 399.463436 285.782293 397.91118 291.111756 420.470644 291.111756C423.161223 290.798258 423.678642 291.216255 423.885609 291.007257L425.54135 285.782293 425.437866 285.782293zM391.702153 256.104499L391.702153 256.104499 407.535171 256.104499 405.258528 264.150943C405.258528 264.150943 410.22575 260.075472 413.744198 258.612482 417.262647 257.358491 425.127414 256.104499 425.127414 256.104499L450.791393 256 441.995271 285.468795C440.546498 290.484761 438.787274 293.724238 437.752436 295.291727 436.821082 296.754717 435.68276 298.113208 433.406117 299.367199 431.232958 300.516691 429.266766 301.248186 427.404058 301.352685 425.748317 301.457184 423.057739 301.561684 419.53929 301.561684L394.806666 301.561684 387.873253 324.865022C387.25235 327.164006 386.941899 328.313498 387.355834 328.940493 387.666285 329.46299 388.597639 330.089985 389.735961 330.089985L400.601758 329.044993 396.876342 341.793904 384.665256 341.793904C380.732872 341.793904 377.93881 341.689405 375.972618 341.584906 374.10991 341.375907 372.143718 341.584906 370.798429 340.539913 369.660107 339.49492 367.900883 338.13643 368.004367 336.777939 368.10785 335.523948 368.625269 333.433962 369.45314 330.507983L391.702153 256.104499 391.702153 256.104499z"/> <path fill="#FEFEFE" d="M437.840227 303L436.391454 310.105951C435.770551 312.300435 435.253132 313.972424 433.597391 315.435414 431.838167 316.898403 429.871975 318.465893 425.111721 318.465893L416.3156 318.88389 416.212116 326.825835C416.108632 329.020319 416.729535 328.811321 417.039986 329.229318 417.453921 329.647315 417.764373 329.751814 418.178308 329.960813L420.97237 329.751814 429.354556 329.333817 425.836108 341.037736 416.212116 341.037736C409.48567 341.037736 404.414965 340.828737 402.862708 339.574746 401.206968 338.529753 401 337.275762 401 334.976778L401.620903 303.835994 417.039986 303.835994 416.833019 310.21045 420.558435 310.21045C421.80024 310.21045 422.731594 310.105951 423.249013 309.792453 423.766432 309.478955 424.076883 308.956459 424.283851 308.224964L425.836108 303.208999 437.94371 303.208999 437.840227 303zM218.470396 147C217.952978 149.507983 208.018534 195.592163 208.018534 195.592163 205.845375 204.892598 204.293118 211.580552 199.118929 215.865022 196.117899 218.373004 192.599451 219.522496 188.563583 219.522496 182.044105 219.522496 178.318689 216.283019 177.697786 210.117562L177.594302 208.027576C177.594302 208.027576 179.560494 195.592163 179.560494 195.487663 179.560494 195.487663 189.908872 153.478955 191.771581 147.940493 191.875064 147.626996 191.875064 147.417997 191.875064 147.313498 171.695727 147.522496 168.073794 147.313498 167.866827 147 167.763343 147.417997 167.245924 150.030479 167.245924 150.030479L156.690578 197.36865 155.759224 201.339623 154 214.506531C154 218.373004 154.724386 221.612482 156.276643 224.224964 161.140381 232.793904 174.903724 234.047896 182.665008 234.047896 192.702935 234.047896 202.119959 231.853411 208.43247 227.986938 219.505234 221.403483 222.40278 211.058055 224.886391 201.966618L226.128196 197.264151C226.128196 197.264151 236.787026 153.687954 238.649734 148.044993 238.753218 147.731495 238.753218 147.522496 238.856702 147.417997 224.162004 147.522496 219.919169 147.417997 218.470396 147.104499L218.470396 147zM277.499056 233.622642C270.358675 233.518142 267.771581 233.518142 259.389394 233.936139L259.078943 233.309144C259.803329 230.069666 260.6312 226.934688 261.252102 223.69521L262.28694 219.306241C263.839197 212.513788 265.28797 204.467344 265.494937 202.063861 265.701905 200.600871 266.11584 196.943396 261.976489 196.943396 260.217264 196.943396 258.45804 197.77939 256.595332 198.615385 255.560494 202.272859 253.594302 212.513788 252.559465 217.111756 250.489789 226.934688 250.386305 228.08418 249.454951 232.891147L248.834048 233.518142C241.4867 233.413643 238.899605 233.413643 230.413935 233.83164L230 233.100145C231.448773 227.248186 232.794062 221.396226 234.139351 215.544267 237.6578 199.764877 238.589154 193.703919 239.520508 185.657475L240.244894 185.239478C248.523597 184.089985 250.489789 183.776488 259.492878 182L260.217264 182.835994 258.871975 187.851959C260.424232 186.911466 261.873005 185.970972 263.425262 185.239478 267.668097 183.149492 272.324867 182.522496 274.911962 182.522496 278.844345 182.522496 283.190664 183.671988 284.949888 188.269956 286.605629 192.345428 285.570791 197.361393 283.294148 207.288824L282.155826 212.30479C279.879183 223.381713 279.465248 225.367199 278.223443 232.891147L277.395572 233.518142 277.499056 233.622642zM306.558435 233.650218C302.212116 233.650218 299.418054 233.545718 296.727476 233.650218 294.036897 233.650218 291.449803 233.859216 287.413935 233.963716L287.206968 233.650218 287 233.232221C288.138322 229.05225 288.655741 227.58926 289.276643 226.12627 289.794062 224.66328 290.311481 223.20029 291.346319 218.91582 292.588124 213.377358 293.415995 209.510885 293.933413 206.062409 294.554316 202.822932 294.864767 200.001451 295.278703 196.761974L295.589154 196.552975 295.899605 196.239478C300.245924 195.612482 302.936502 195.194485 305.730565 194.776488 308.524627 194.358491 311.422173 193.835994 315.871975 193L316.078943 193.417997 316.182427 193.835994C315.354556 197.28447 314.526686 200.732946 313.698816 204.181422 312.870946 207.629898 312.043075 211.078374 311.318689 214.526851 309.766432 221.8418 309.042046 224.558781 308.731594 226.544267 308.317659 228.425254 308.214175 229.365747 307.593273 233.127721L307.179338 233.441219 306.765402 233.754717 306.558435 233.650218zM352.499319 207.975327C352.188868 209.856313 350.533127 216.857765 348.359968 219.783745 346.807711 221.978229 345.048487 223.33672 342.978811 223.33672 342.357909 223.33672 338.83946 223.33672 338.735976 218.007257 338.735976 215.394775 339.253395 212.677794 339.874298 209.751814 341.737006 201.287373 344.013649 194.285922 349.705257 194.285922 354.15506 194.285922 354.465511 199.510885 352.499319 207.975327L352.499319 207.975327zM371.229884 208.811321L371.229884 208.811321C373.713495 197.734398 371.747303 192.509434 369.367176 189.374456 365.64176 184.567489 359.018798 183 352.188868 183 348.049517 183 338.322041 183.417997 330.664241 190.523948 325.179601 195.644412 322.592506 202.645864 321.143733 209.333817 319.591476 216.12627 317.832252 228.352685 329.008501 232.950653 332.423466 234.413643 337.390687 234.83164 340.598684 234.83164 348.773903 234.83164 357.156089 232.532656 363.4686 225.844702 368.332338 220.41074 370.505497 212.259797 371.333368 208.811321L371.229884 208.811321zM545.661919 234.891147C536.969281 234.786647 534.48567 234.786647 526.517419 235.204644L526 234.577649C528.173159 226.322206 530.346319 217.962264 532.312511 209.602322 534.796122 198.734398 535.417024 194.13643 536.244894 187.761974L536.865797 187.239478C545.454951 185.985486 547.835078 185.671988 556.838167 184L557.045135 184.731495C555.389394 191.628447 553.837137 198.4209 552.181397 205.213353 548.869916 219.529753 547.731594 226.844702 546.489789 234.36865L545.661919 234.995646 545.661919 234.891147z"/> <path fill="#FEFEFE" d="M533.159909 209.373777C532.745974 211.150265 531.090233 218.256216 528.917074 221.182195 527.468301 223.272181 523.949852 224.630672 521.983661 224.630672 521.362758 224.630672 517.947793 224.630672 517.740826 219.405708 517.740826 216.793226 518.258244 214.076245 518.879147 211.150265 520.741855 202.894822 523.018498 195.893371 528.710106 195.893371 533.159909 195.893371 535.126101 201.013836 533.159909 209.478277L533.159909 209.373777zM550.234733 210.209772L550.234733 210.209772C552.718344 199.132849 542.576933 209.269278 541.024677 205.611804 538.541066 199.864344 540.093322 188.369423 530.158879 184.50295 526.329979 182.935461 517.32689 184.920947 509.66909 192.026898 504.287934 197.042863 501.597355 204.044315 500.148582 210.732268 498.596326 217.420222 496.837101 229.751136 507.909866 234.035606 511.428315 235.603095 514.636312 236.021092 517.844309 235.812094 529.020558 235.185098 537.506228 218.151717 543.818739 211.463763 548.682476 206.1343 549.510347 213.449249 550.234733 210.209772L550.234733 210.209772zM420.292089 233.622642C413.151708 233.518142 410.668097 233.518142 402.28591 233.936139L401.975459 233.309144C402.699846 230.069666 403.527716 226.934688 404.252102 223.69521L405.183456 219.306241C406.735713 212.513788 408.28797 204.467344 408.391454 202.063861 408.598421 200.600871 409.012356 196.943396 404.976489 196.943396 403.217264 196.943396 401.354556 197.77939 399.595332 198.615385 398.663978 202.272859 396.594302 212.513788 395.559465 217.111756 393.593273 226.934688 393.386305 228.08418 392.454951 232.891147L391.834048 233.518142C384.4867 233.413643 381.899605 233.413643 373.413935 233.83164L373 233.100145C374.448773 227.248186 375.794062 221.396226 377.139351 215.544267 380.6578 199.764877 381.48567 193.703919 382.520508 185.657475L383.141411 185.239478C391.420113 184.089985 393.489789 183.776488 402.389394 182L403.113781 182.835994 401.871975 187.851959C403.320748 186.911466 404.873005 185.970972 406.321778 185.239478 410.564613 183.149492 415.221383 182.522496 417.808478 182.522496 421.740862 182.522496 425.983697 183.671988 427.846405 188.269956 429.502145 192.345428 428.363824 197.361393 426.08718 207.288824L424.948859 212.30479C422.568732 223.381713 422.25828 225.367199 421.016475 232.891147L420.188605 233.518142 420.292089 233.622642zM482.293118 147.104499L476.291059 147.208999C460.768492 147.417997 454.559465 147.313498 452.075854 147 451.868886 148.149492 451.454951 150.134978 451.454951 150.134978 451.454951 150.134978 445.866827 176.050798 445.866827 176.155298 445.866827 176.155298 432.620903 231.330914 432 233.943396 445.556375 233.734398 451.041016 233.734398 453.421143 234.047896 453.938562 231.435414 457.043075 216.07402 457.146559 216.07402 457.146559 216.07402 459.837137 204.788099 459.940621 204.370102 459.940621 204.370102 460.768492 203.22061 461.596362 202.698113L462.838167 202.698113C474.531835 202.698113 487.674275 202.698113 498.022653 195.069666 505.05955 189.844702 509.819804 182.007257 511.992964 172.602322 512.510383 170.303338 512.924318 167.586357 512.924318 164.764877 512.924318 161.107402 512.199931 157.554427 510.130256 154.732946 504.852583 147.313498 494.400721 147.208999 482.293118 147.104499L482.293118 147.104499zM490.054402 174.169811L490.054402 174.169811C488.812597 179.917271 485.08718 184.828737 480.326926 187.127721 476.394543 189.113208 471.634289 189.322206 466.667067 189.322206L463.45907 189.322206 463.666037 188.068215C463.666037 188.068215 469.564613 162.152395 469.564613 162.256894L469.771581 160.898403 469.875064 159.853411 472.255191 160.062409C472.255191 160.062409 484.466278 161.107402 484.673245 161.107402 489.433499 162.988389 491.503175 167.795356 490.054402 174.169811L490.054402 174.169811zM617.261369 182.835994L616.536983 182C607.740862 183.776488 606.085121 184.089985 598.013386 185.239478L597.392483 185.866473C597.392483 185.970972 597.288999 186.075472 597.288999 186.28447L597.288999 186.179971C591.28694 200.287373 591.390424 197.256894 586.526686 208.333817 586.526686 207.811321 586.526686 207.497823 586.423202 206.975327L585.181397 182.940493 584.45701 182.104499C575.14347 183.880987 574.936502 184.194485 566.450832 185.343977L565.82993 185.970972C565.726446 186.28447 565.726446 186.597968 565.726446 186.911466L565.82993 187.015965C566.864767 192.554427 566.6578 191.300435 567.692638 199.973875 568.210057 204.258345 568.830959 208.542816 569.348378 212.722787 570.176248 219.828737 570.693667 223.277213 571.728505 234.040639 565.933413 243.654572 564.588124 247.312046 559 255.776488L559.310451 256.612482C567.692638 256.298984 569.555346 256.298984 575.764373 256.298984L577.109662 254.731495C581.766432 244.595065 617.364853 182.940493 617.364853 182.940493L617.261369 182.835994zM314.543608 189.75837C319.303862 186.414394 319.924765 181.816425 315.888897 179.412942 311.85303 177.009459 304.712649 177.740954 299.952395 181.084931 295.192141 184.324408 294.674722 188.922376 298.71059 191.430359 302.642973 193.729343 309.783354 193.102347 314.543608 189.75837L314.543608 189.75837z"/> <path fill="#FEFEFE" d="M575.734683,256.104499 L568.80127,268.121916 C566.628111,272.197388 562.488759,275.332366 556.072765,275.332366 L545,275.123367 L548.207997,264.255443 L550.381157,264.255443 C551.519478,264.255443 552.347349,264.150943 552.968251,263.837446 C553.589154,263.628447 553.899605,263.21045 554.417024,262.583454 L558.556375,256 L575.838167,256 L575.734683,256.104499 Z"/> </g></svg>`;

//define the color swap function
const swapColor = function (basecolor) {
    document.querySelectorAll('.lightcolor')
        .forEach(function (input) {
            input.setAttribute('class', '');
            input.setAttribute('class', 'lightcolor ' + basecolor);
        });
    document.querySelectorAll('.darkcolor')
        .forEach(function (input) {
            input.setAttribute('class', '');
            input.setAttribute('class', 'darkcolor ' + basecolor + 'dark');
        });
};


//pop in the appropriate card icon when detected
cardnumber_mask.on("accept", function () {
    console.log(cardnumber_mask.masked.currentMask.cardtype);
    switch (cardnumber_mask.masked.currentMask.cardtype) {
        case 'american express':
            ccicon.innerHTML = amex;
            ccsingle.innerHTML = amex_single;
            swapColor('green');
            break;
        case 'visa':
            ccicon.innerHTML = visa;
            ccsingle.innerHTML = visa_single;
            swapColor('lime');
            break;
        case 'diners':
            ccicon.innerHTML = diners;
            ccsingle.innerHTML = diners_single;
            swapColor('orange');
            break;
        case 'discover':
            ccicon.innerHTML = discover;
            ccsingle.innerHTML = discover_single;
            swapColor('purple');
            break;
        case ('jcb' || 'jcb15'):
            ccicon.innerHTML = jcb;
            ccsingle.innerHTML = jcb_single;
            swapColor('red');
            break;
        case 'maestro':
            ccicon.innerHTML = maestro;
            ccsingle.innerHTML = maestro_single;
            swapColor('yellow');
            break;
        case 'mastercard':
            ccicon.innerHTML = mastercard;
            ccsingle.innerHTML = mastercard_single;
            swapColor('lightblue');

            break;
        case 'unionpay':
            ccicon.innerHTML = unionpay;
            ccsingle.innerHTML = unionpay_single;
            swapColor('cyan');
            break;
        default:
            ccicon.innerHTML = '';
            ccsingle.innerHTML = '';
            swapColor('grey');
            break;
    }

});



//Generate random card number from list of known test numbers
const randomCard = function () {
    let testCards = [
        '4000056655665556',
        '5200828282828210',
        '371449635398431',
        '6011000990139424',
        '30569309025904',
        '3566002020360505',
        '6200000000000005',
        '6759649826438453',
    ];
    let randomNumber = Math.floor(Math.random() * testCards.length);
    cardnumber_mask.unmaskedValue = testCards[randomNumber];
}
generatecard.addEventListener('click', function () {
    randomCard();
});


// CREDIT CARD IMAGE JS
 document.querySelector('.preload').classList.remove('preload');
document.querySelector('.creditcard').addEventListener('click', function () {
    if (this.classList.contains('flipped')) {
        this.classList.remove('flipped');
    } else {
        this.classList.add('flipped');
    }
})

//On Input Change Events
name.addEventListener('input', function () {
    if (name.value.length == 0) {
        document.getElementById('svgname').innerHTML = 'John Doe';
        document.getElementById('svgnameback').innerHTML = 'John Doe';
    } else {
        document.getElementById('svgname').innerHTML = this.value;
        document.getElementById('svgnameback').innerHTML = this.value;
    }
});

cardnumber_mask.on('accept', function () {
    if (cardnumber_mask.value.length == 0) {
        document.getElementById('svgnumber').innerHTML = '0123 4567 8910 1112';
    } else {
        document.getElementById('svgnumber').innerHTML = cardnumber_mask.value;
    }
});

expirationdate_mask.on('accept', function () {
    if (expirationdate_mask.value.length == 0) {
        document.getElementById('svgexpire').innerHTML = '01/23';
    } else {
        document.getElementById('svgexpire').innerHTML = expirationdate_mask.value;
    }
});

securitycode_mask.on('accept', function () {
    if (securitycode_mask.value.length == 0) {
        document.getElementById('svgsecurity').innerHTML = '985';
    } else {
        document.getElementById('svgsecurity').innerHTML = securitycode_mask.value;
    }
});

//On Focus Events
name.addEventListener('focus', function () {
    document.querySelector('.creditcard').classList.remove('flipped');
});

cardnumber.addEventListener('focus', function () {
    document.querySelector('.creditcard').classList.remove('flipped');
});

expirationdate.addEventListener('focus', function () {
    document.querySelector('.creditcard').classList.remove('flipped');
});

securitycode.addEventListener('focus', function () {
    document.querySelector('.creditcard').classList.add('flipped');
});
};
</script>
                        <!--end信用卡html-->
					    
					    	<!--使用收货地址作为账单地址-->
					 	<div class="input-group py-3 px-5">
						      <div class="input-group-prepend">
							        <div class="input-group-text  border-0 bg-white" >
							         	 <input type="checkbox" id="clause-1" clause="false" > 
							        </div>
						      </div>
							 	
                	<script type="text/javascript">
                	Language(`<small class="pt-1">使用收货地址作为账单地址</small>`,
                		`<small class="pt-1">Billing address is same as shipping address</small>`)
                </script></label>
					    </div>
					    
			    			<div class="row px-4">
                	<script type="text/javascript">
                	Language(`<input id="credit_card_show_but" class="btn btn btn-block btn-primary " value="提交" type="button"/>`,
                		`<input id="credit_card_show_but" class="btn btn btn-block btn-primary " value="Confirm" type="button"/>`)
                </script>
			    			</div>
			    		
			    </div>
			  </div>
			</div>
			
			<!--账单地址模态框-->
	        <div class="modal fade bs-example-modal-sm "id="billingAddress" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm mt-5" role="document">
			    <div class="modal-content py-4"id="billingAddressPro"style="padding: 2% 5%;">    
			    	
					    	<div class="row pb-4">
					    		<h4  style="margin: 0 auto ;"> 
                	<script type="text/javascript">
                	Language("账单地址","Billing Address")
                </script></h1>
					    	</div>    
					    	
					    <div class="modal-body" style="height: 310px;overflow-y:scroll ;">
						    	<div class=" row px-2">
	                            <label for="firstName_1" class="col-md-4 col-form-label text-md-right">
	                            		<small class="text-muted">
                	<script type="text/javascript">
                	Language("名字","First name")
                </script>
	                            		</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="firstName_1" name="" type="text" class="form-control" value="" required="" placeholder="Enter First Name">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="lastName_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
                	<script type="text/javascript">
                	Language("姓氏","Last name")
                </script>
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="lastName_1" name="" type="text" class="form-control" value="" required="" placeholder="Enter Last Name">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="company_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
	                            		
                	<script type="text/javascript">
                	Language("公司","Company")
                </script>
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="company_1" name="" type="text" class="form-control" value="" required="" placeholder="company">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="address_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
	                            		
                	<script type="text/javascript">
                	Language("地址","address")
                </script>
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="address_1" name="" type="text" class="form-control" value="" required="" placeholder="Enter Address">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="city_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
	                            		
                	<script type="text/javascript">
                	Language("城市","City")
                </script>
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="city_1" name="" type="text" class="form-control" value="" required="" placeholder=" Enter City">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="state_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
	                            		
                	<script type="text/javascript">
                	Language("州","State")
                </script>
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <!--<input id="state_1" name="" type="text" class="form-control" value="" required="" placeholder="State">-->
	                                
					                <select id="state_1" class="custom-select mr-sm-2 bg-white" id="exampleFormControlSelect1" aria-label="" aria-describedby="">
					                    <option>California</option>
					                    <option>New York</option>
					                </select>
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="country_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
                	<script type="text/javascript">
                	Language("国家","country")
                </script>
	                            		
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="country_1" name="" type="text" class="form-control" value="" required="" placeholder="country">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="mobile_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
                	<script type="text/javascript">
                	Language("电话号码","Phone number")
                </script>
	                            		
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="mobile_1" name="" type="text" class="form-control" value="" required="" placeholder="Enter Phone Number">
	                            </div>
	                        </div>
							<div class=" row px-2">
	                            <label for="zip_1" class="col-md-4 col-form-label text-md-right">
	                            	<small class="text-muted">
                	<script type="text/javascript">
                	Language("邮编","Zip code")
                </script>
	                            		
	                            	</small></label>
	                            <div class="col-md-6 input-group-sm">
	                                <input id="zip_1" name="" type="text" class="form-control" value="" required="" placeholder="Enter Zip Code ">
	                            </div>
	                        </div>
					    </div>
						
			    		<div class="row px-2 d-flex justify-content-center">
			    			<script>
                				Language(`<input id="billingAddress_btn" class="btn btn-primary mr-4 w-30 " value="提交" type="button"/>
				    					<input id="billingAddress_btn_2" class="btn btn-primary mr-4 w-30 " value="返回" type="button"/>`,
                					`<input id="billingAddress_btn" class="btn btn-primary mr-4 w-30 " value="Confirm" type="button"/>
				    					<input id="billingAddress_btn_2" class="btn btn-primary mr-4 w-30 " value="Back" type="button"/>`)
			    			</script>
			    		</div>
			    		</div>

			    </div>
			  </div>
			
	    	<!--修改地址模态框-->
	        <div class="modal fade bs-example-modal-sm "id="Address" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content py-4"id="address_text"style="padding: 2% 5%;">
			    	<div class="row pb-4">
			    		<h4 class=""  style="margin: 0 auto ;"> 
                	<script type="text/javascript">
                	Language("选择收货地址","Confirm Shipping Address ")
                </script></h1>
			    	</div>
			    	<div class="addressBox container px-1" style="max-height: 300px;overflow-y: scroll;overflow-x: hidden;">
			    	</div>
			    	
			    	<div class="row px-4 mt-3">
			    		<a href="{{ route('address') }}" class="d-block text-muted  m-auto">
                	<script type="text/javascript">
                	Language("修改地址","Edit Address")
                </script></a>
			    	</div>
			    	<div class="row px-4 mt-3">
			    		<a href="##"class="btn btn-block btn-red" id="address_btn">
                	<script type="text/javascript">
                	Language("确认","Confirm")
                </script></a>
			    	</div>
			    </div>
			  </div>
			</div>
			<!--总价详情模态框-->
			<div class="modal fade bs-example-modal-sm "id="total_detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content py-3"id="total_text"style="padding: 2% 5%;">
			    </div>
			  </div>
			</div>
			<div id="pp" style="display: none;"></div>
				<iframe id="qrcode-iframe" class="container"style="position: absolute;z-index: 999;top:0;left:0; display: none;" name="submitIframe" src="about:blank" width="100%" height="750px" frameborder="no" border="0" marginwidth="0" marginheight="0"  >   		
					<!--<form  id = 'send_hptoken'  action = ''  method = 'post' target = 'load_payment'>
				   	 	<input id = 'send_hptoken_token'  type = 'hidden'  name = 'token'  value ='' />
				        <input id = 'send_hptoken_btn' type="submit" value="立即支付" class="sbtn4" />
					</form>	-->
				</iframe>

            
@endsection                    
@section('scripts')




<script>
	
	var optiontxt = '';
	var allplace = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"];
	for(let i = 0; i < allplace.length; i++ ){
		optiontxt +=`<option>${allplace[i]}</option>`
	};
	document.querySelector("#state_1").innerHTML = optiontxt;
	//是否使用默认地址作为账单地址
		$("#clause-1").click(function(){
			var clauseNum= $("#clause-1").attr("clause");
			if (clauseNum=="true") {
				$("#clause-1").attr("clause","false");
			} else{
				$("#clause-1").attr("clause","true");
			}
		});
</script>


<script type="text/javascript">
	//获取当前路由
	var Http=window.location.href;
	//获取订单id
	var Http=Http.split("?id=");
	$.ajax({
		        url: '/api/business/order/details',
                method: 'get',
                //async: false,
                //dataType: "jsonp",
                //jsonp: "callbackparam",
                data: {
                    'id':Http[1]
                },
                //crossDomain: true,//是否跨域:是
                //cache: false,//是否缓存：否
                //jsonpCallback: "my",
                success: function (data) {
                	//订单所有商品
                	var cart=data.products;
        			var cartText=""
					for(var i=0;i<cart.length;i++){
						var sl=cart[i].number;
						cartText +=`<div class="row my-2 p-3 bg-white cartPro">
						<div class="col-3 d-flex align-items-center">
							<img class="cart-img" src="${cart[i].products.product_image}" alt="">
						</div>
						<div class="col-5">
							<span class="d-block"><p class="p-0 tow-line">${LanguageHtml(cart[i].products.zn_name,cart[i].products.en_name)}</p></span>
							<span class="d-block"><small class="text-red cartProPrice">$ <span>${Sprice1(cart[i].products.distributor.level_four_price,cart[i].products.distributor.level_two_price,cart[i].products.distributor.level_one_price,cart[i].products.distributor.level_three_price)}</span></small></span>
						</div>
						<div class="col-4 p-0 d-flex align-items-end">
							<div class="input-group">
							    <div class="input-group-prepend">
							    		<small class="py-1 text-muted" >数量</small>	
							    	</div>
							    <input	value="${cart[i].count}" class="form-control border-0 cartProNumber bg-white"disabled="disabled" id="pi${i}"style="padding:0;text-align:center" >
							 </div>
						</div>
					</div>`
					}
					$(".cartBox").append( cartText);
					//绑定默认收货地址
                	var Address= JSON.parse(data.details.snap_address);
                	//console.log(Address.name)
                	//console.log(JSON.stringify(Address))
                	$("#name").html(Address.name);
                	$("#mobile").html(Address.mobile);
                	$("#addressDetail ").html(Address.detail+" "+Address.country+" "+Address.city+" "+Address.province);
                	//点击修改地址弹出模态框
                	$(".addAddress").click(function(){
                		$("#Address").modal("show");
                	});
                	//绑定订单和总价	
                	var OrderId=data.details;
//              	绑定总价详情
                	$("#total_text").html(	LanguageHtml(`<span>本次商品总额：$${((data.details.total_price-data.details.freight)/(data.details.tax*1+1)).toFixed(2)}<br />运费：$${OrderId.freight}<br />税金：$${((data.details.total_price-data.details.freight)/(data.details.tax*1+1)*data.details.tax).toFixed(2)}</span>`,
                		`<span>Total:：$${((data.details.total_price-data.details.freight)/(data.details.tax*1+1)).toFixed(2)}<br />Shipping: $${OrderId.freight}<br />Tax：$${((data.details.total_price-data.details.freight)/(data.details.tax*1+1)*data.details.tax).toFixed(2)}</span>`));

                	$("#orderId span").html(OrderId.order_no);
                	$("#totalPrice span").html(data.details.total_price);
                	$("#pp").click(function(){
						// $(".Settlement").click(function(){
                	//加载paypal支付按钮组件
                		$("#pp").html(`
															<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypal">
												
															    <input type="hidden" name="cmd" value="_xclick">
												
															    <input type="hidden" name="business" value="account@12buy.com">
												
															    <input type="hidden" name="item_name" value="${cart[0].products[0].zn_name}">
												
															    <input type="hidden" name="item_number" value="${OrderId.order_no}">
												
															    {{--取消支付返回url--}}
															    {{--<input type="hidden" name="cancel_return" value="http://shop.buy.com/dashboard">--}}
															    <input type="hidden" name="cancel_return" value="https://12buy.com/apps">
												
															    <input type="hidden" name="notify_url" value="https://12buy.com/api/pal/notify">
												
															    {{--<input type="hidden" name="notify_url" value="http://shop.buy.com/api/pal/notify">--}}
												
															    {{--成功后返回--}}
															    <input type="hidden" name="return" value="https://12buy.com/apps">
															    <!-- 货币种类，USD为美元 -->
															    <input type="hidden" name="currency_code" value="USD">
															    <!-- 支付金额 -->
															    <input type="hidden" name="amount" value="${OrderId.total_price}">
															    <input type="submit" value="立即支付" id="btn4" />
															</form>
						`);
						//显示模态框
						$("#showx").modal("show");
						//点击paypal支付执行
						$("#paypal").click(function(){
							//执行paypal支付
							$("#btn4").click();
						})
						//点击支付宝支付
						$("#alipay").click(function(){
							$.ajax({
								url: '/api/citon/pay',
					                method: 'get',
					                data: {
					                    'vendor':'alipay',
					                    'callback_url':"https://12buy.com/apps/user/{{Auth()->guard('pc')->user()->id}}",
					                    'reference':OrderId.order_no,
					                    'terminal' : 'WAP',
					                },
					                 success: function (data){
					                 	if(data.status){

											$('#ppp').html(data.data);
//					                 		window.location.href=data.data;
//					                 		window.open(data.data ,'_system')
					                 	}

					                 },
									error:function(){
										swal({
											title:"请求错误！",
											type: 'warning',
											showConfirmButton: true,
							
										})
									}
							})
						})
						//点击微信支付
						$("#wechatpay").click(function(){
//							$.ajax({
//								url: '/api/citon/pay',
//					                method: 'get',
//					                data: {
//					                    'vendor':'wechatpay',
//					                    'callback_url':'http://buy.yn-pulse.com/apps/user/{{Auth()->guard('pc')->user()->id}}',
//					                    'reference':OrderId.order_no
//					                },
//					                 success: function (data){
//					                 	if(data.status){
//					                 		window.location.href=data.data;
//					                 	}
//					                 	console.log(data)
//					                 }
//							})
						})
						//点击信用卡支付
						$("#credit_card").click(function(){
//							隐藏当前模态框
							$("#showx").modal("hide");
//							显示信用卡模态框
							$("#credit_card_show").modal("show");
						});
						//点击信用卡模态框确认按钮
						var CreditCardNum=false;
						$("#credit_card_show_but").click(function(){
//							输入框不能为空 
							if($("#cardnumber").val().replace(/\s/g,"").length<16){
			                    swal({
			                        title: '信用卡卡号格式错误',
			                        type: 'info',
			                        showConfirmButton: true,
			                    })
			                    return false
							}else if($("#expirationdate").val().length<5){
			                    swal({
			                        title: '截止日期格式错误',
			                        type: 'info',
			                        showConfirmButton: true,
			                    })
			                    return false
							}else if($("#securitycode").val().length<3){
			                    swal({
			                        title: 'CVV格式错误',
			                        type: 'info',
			                        showConfirmButton: true,
			                    })
			                    return false
							};
//							判断是否使用默认地址作为计费信息
						if($("#clause-1").attr("clause")=="true"){
							
							CreditCard(OrderId.total_price,OrderId.order_no)
//						if	(onClick==1){
////									alert("支付")
//							onClick=2
//					             }
						}else{
//							隐藏信用卡模态框
							$("#credit_card_show").modal("hide");
//							显示账单地址模态框
							$("#billingAddress").modal("show");
						}	
							
							
						$("#billingAddress_btn").click(function(){
//								if(onClick==1){
////									alert("支付")
//									onClick=2
//								}
									CreditCard(OrderId.total_price,OrderId.order_no)
								})
								$("#billingAddress_btn_2").click(function(){
									$("#billingAddress").modal("hide");
		//							信用卡模态框
									$("#credit_card_show").modal("show");
									
								})
						})
                	});



                },
                error: function () {
                    swal({
                        title: '请求失败',
                        type: 'info',
                        showConfirmButton: true,
                    })

                }
                    
	})
	var onClick=1
	var CreditCard=function(aa,bb){
								$.ajax({
									url:'/api/authorize/invoice',
									method: 'post',
									data:{
										'userId': {{Auth()->guard('pc')->user()->id}},
										'orderId': bb,
										'status': $("#clause-1").attr("clause")=="true"?2:1,
		                                'firstName':$("#firstName_1").val(),
		                                'lastName':$("#lastName_1").val(),
		                                'company':$("#company_1").val(),
		                                'address':$("#address_1").val(),
		                                'state':$("#state_1").val(),
		                                'city':$("#city_1").val(),
		                                'country':$("#country_1").val(),
		                                'mobile':$("#mobile_1").val() ,
		                                'zip':$("#zip_1").val(),
									},
									success:function(data){
						                		onClick=1
										if(data.status){
											CreditCardPal(aa,bb)
										}else{
						                    swal({
						                        title: data.message,
						                        type: 'info',
						                        showConfirmButton: true,
						                    })
										}
									},
						                error: function (data) {
						                		onClick=1
						                    swal({
						                        title: data.message ,
						                        type: 'info',
						                        showConfirmButton: true,
						
						                    })
						                		return false;
						
						                }
								})
								var CreditCardPal=function(cc,dd){
						    		 $.ajax({
						    	 		url: '/api/pal/authorize',
						                method: 'get',
						                data: {
						                		'id':{{Auth()->guard('pc')->user()->id}},
	                                        'card': $("#cardnumber").val().replace(/\s/g,""),
	                                        'money':cc,
	                                        'order':dd,
	                                        'date':$("#expirationdate").val(),
	                                        'code':$("#securitycode").val(),
	                                        'status':$("#clause-1").attr("clause")=="true"?1:2,
	                                        'firstName':$("#firstName_1").val(),
	                                        'lastName':$("#lastName_1").val(),
	                                        'company':$("#company_1").val(),
	                                        'address':$("#address_1").val(),
	                                        'state':$("#state_1").val(),
	                                        'city':$("#city_1").val(),
	                                        'country':$("#country_1").val(),
		                                	'mobile':$("#mobile_1").val() ,
	                                        'zip':$("#zip_1").val(),
						                },
						                success: function (data){
						                		onClick=1
					                		if(data.status){
								            swal({
								                title: LanguageHtml('支付成功','Thank You For Your Order'),
								                text: LanguageHtml("返回首页或个人中心",' Back to Home or My Account '),
								                type: 'success',
								                showCancelButton: true,
								                confirmButtonColor: '#3085d6',
								                cancelButtonColor: '#d33',
								                cancelButtonText: LanguageHtml('取消','Cancel'),
								                confirmButtonText: LanguageHtml('返回首页','Back to Home'),
								            }).then(function (isConfirm) {
								                if (isConfirm.value == true) {
								                		window.location.href="/apps"
								                }else{
								                		window.location.href=`/apps/user/{{Auth()->guard('pc')->user()->id}}`
								                }
								            })
								            setTimeout(function(){window.location.href=`/apps/user/{{Auth()->guard('pc')->user()->id}}`},10000)
						                    console.log(456)
						                		}else{
							                    swal({
							                        title: data.message,
							                        type: 'info',
							                        showConfirmButton: true,
							                    })
						                		}
						                		return false;
						                },
						                error: function (data) {
						                		onClick=1
						                    swal({
						                        title: LanguageHtml('信用卡讯息错误' ,' Card Information Incorrect'),
//						                        title:data.message,
						                        type: 'info',
						                        showConfirmButton: true,
						
						                    })
						                		return false;
						
						                }
						                
						             });
									
								}
	}
	$('#modal_id').modal({backdrop: 'static', keyboard: false});
</script>
<script type="text/javascript">
    $(".cartPro:last").addClass("clearfix");
    $(".cartPro:last").after('<div style="width:100%;height:150px;background: #FFFFFF;"></div>')
    
	//模态框上下剧中
	var boxHeight=$(document).height();
	$(".modal-dialog").css("margin-top",(boxHeight/3));
	$("#Address .modal-dialog,#billingAddress .modal-dialog").css("margin-top","20%");
	$("#credit_card_show .modal-dialog").css("margin-top","20px");
	
	//绑定所有地址选项
    		 $.ajax({
    	 		url: '/api/apps/order/address',
                method: 'get',
                data: {
                    'id':{{Auth()->guard('pc')->user()->id}}
                },
                success: function (data){
                	var Address=data
                	var address_json_text=""
                	var address_json_top_text=""
                	for (var i = 0; i<data.length ; i++) {
                		if(Address[i].default=="1"){
                			address_json_top_text+=`
			    		<div class="row oderId" >
				    		<div class="col-2">
				    			<div class="pt-3">
				    				<p class=" d my-0 "oder_id="${Address[i].id}" ></p>
				    			</div>
				    		</div>
				    		<div class="col-10 text-muted pl-0">
				    			<small>${Address[i].name}</small><small class="px-4">${Address[i].mobile}</small>
				    			<p><small class="towline pr-2">${Address[i].detail+" "+Address[i].country+" "+Address[i].city+" "+Address[i].province }</small></p>
				    		</div>
				    	</div>`
                		}else{
                			address_json_text+=`<div class="row oderId" >
				    		<div class="col-2">
				    			<div class="pt-3">
				    				<p class=" d my-0" oder_id="${Address[i].id}" ></p>
				    			</div>
				    		</div>
				    		<div class="col-10 text-muted pl-0">
				    			<small>${Address[i].name}</small><small class="px-4">${Address[i].mobile}</small>
				    			<p><small class="towline pr-2">${Address[i].detail+" "+Address[i].country+" "+Address[i].city+" "+Address[i].province }</small></p>
				    		</div>
				    	</div>`
                		}
                		$(".addressBox").html(address_json_top_text+address_json_text);
                		//修改地址选项切换
						$(".d").eq(0).addClass("activeId");
						$(".d").click(function(){
							$(".d").removeClass("activeId");
							$(this).addClass("activeId")
						});

                	}
						//修改地址点击确认执行ajax
					    $("#address_btn").click(function(){
					    	console.log($(".activeId").attr("oder_id"))
					    	$.ajax({
					    		url: '/api/edit/user/editAddress',
					            method: 'get',
					            data: {
					                'id':{{Auth()->guard('pc')->user()->id}},
					                'order_id':Http[1],
					                'address_id':$(".activeId").attr("oder_id")
					            },
					            success: function (data){
					            	window.location.reload()
					            }
					    	})
					     })
                }
    	 	})
	
</script>
<script>
	//点击显示总价详情模态框
	
		$("#total_btn").click(function(){
			$("#total_detail").modal("show");
		});
	
</script>
<style type="text/css">
	.clearfix:before, .clearfix:after { display: table; content: " ";}
	.clearfix:after { clear: both;}
</style>

@endsection