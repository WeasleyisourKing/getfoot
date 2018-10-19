
/**
 * 前端验证
 * @param obj param 验证信息
 */

function check(param) {
    //用户名可以为汉字、数字、字母（大小写）、下划线最少3个字符
    //密码中必须包含字母、数字、特称字符，至少8个字符
    var rule = {
           'name' : '^[0-9a-zA-Z\u4e00-\u9fa5_]{3,16}$',
       // 'password' :'(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{8,30}'
            'password' : '[A-Za-z].*[0-9]|[0-9].*[A-Za-z]{8,15}'
    },
    	meg = {
    		     'name' : '用户名少于3个字符或者不是汉字、数字、字母（大小写）、下划线',
    		 'password' : '密码中必须包含字母、数字，8-15个字符'
    	},
    	res = {
            'status' : true,
            'data' : {}
        },
       regex ;
       for ( let key in param) {
        if (rule.hasOwnProperty(key)) {
                 regex = new RegExp(rule[key]);
                if (!regex.test(param[key])) {
                   res.data[key] = meg[key];
                } 
        }  
    }
    //判断是否是空对象
   for (let i in res.data) {
        res.status = false;
   }

    return res;
}
