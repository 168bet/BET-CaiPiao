String.prototype.getParam = function(n){
		var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
		var r1=new RegExp(n+"=","gi");
		var m=this.match(r);
		if(m==null){
			return "";
		}else{
			return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
		}
	};
var rnd = location.search.getParam("rnd");
var can = 0;
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	HC.init_();
},false)
//成功以后调用微信支付方法
    					 
var HC = {
		oldPackageString:"",
		oldTimeStamp:"",//时间戳
		oldNonceStr:"",//随机串
		appid:"",
		appkey:"",
		partnerId:"",
		partnerKey:"",
		money:"",
		applyId:"",
		notifyUrl:"",
		//初始化方法
		init_:function(){
			$("#load").show();
			$.ajax({
				url : "/user/getWxzfInfo.go?rid="+rnd,
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var Resp = $(xml).find("Resp");
					var code = Resp.attr("code");
					var desc = Resp.attr("desc");
					if(code=="0"){
						var rows = Resp.find("rows");
    					var row = rows.find("row");
						var appid = row.attr("appid");
    					var appKey = row.attr("appKey");
    					var partnerId = row.attr("partnerId");
    					var partnerKey = row.attr("partnerKey");
    					var applyId = row.attr("applyId");
    					var notifyUrl = decodeURIComponent(row.attr("notifyUrl"));//对url进行解码
    					var money = row.attr("money");
    					HC.appid=appid;
    					HC.appkey=appKey;
    					HC.partnerId=partnerId;
    					HC.partnerKey=partnerKey;
    					HC.applyId=applyId;
    					HC.notifyUrl=notifyUrl;
    					HC.money=money;
    					
    					can = 1;
			           
				       	if(can == 1){
				    		WeixinJSBridge.invoke('getBrandWCPayRequest',{
				    	        "appId" : HC.appid, //公众号名称，由商户传入
				    	        "timeStamp" : HC.getTimeStamp(), //时间戳
				    	        "nonceStr" : HC.getNonceStr(), //随机串
				    	        "package" : HC.getPackage(notifyUrl,applyId,partnerId,partnerKey,money),//扩展包
				    	        "signType" : HC.getSignType(), //微信签名方式:1.sha1
				    	        "paySign" : HC.getSign(appid,appKey) //微信签名
				    	        },function(res){
				    	        if(res.err_msg == "get_brand_wcpay_request:ok" ) {
				    	        	//window.location.href="/useraccount/";
				    	        	window.location.href="/#type=url&p=user/index.html"
				    	        }else if(res.err_msg == "get_brand_wcpay_request:cancel"){
				    	        	//window.location.href="/useraccount/recharge.html";
				    	        	window.location.href="/#type=url&p=user/charge.html";
				    	        }else if(res.err_msg == "get_brand_wcpay_request:fail"){
				    	        	//window.location.href="/useraccount/recharge.html";
				    	        	window.location.href="/#type=url&p=user/charge.html";
				    	        }
				    	        // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
				    	        //因此微信团队建议，当收到ok返回时，向商户后台询问是否收到交易成功的通知，若收到通知，前端展示交易成功的界面；若此时未收到通知，商户后台主动调用查询订单接口，查询订单的当前状态，并反馈给前端展示相应的界面。
				    	    }); 
				    	}
				       	$("#load").hide();
					}else{
						alert("不成功");
					}
				},
				error : function() {
					alert('不支持的卡');
				}
			})
		},
		//获取时间戳
		getTimeStamp:function()
        {
            var timestamp=new Date().getTime();
            var timestampstring = timestamp.toString();//一定要转换字符串
            HC.oldTimeStamp = timestampstring;
            return timestampstring;
        },
        //生成随机串
       getNonceStr:function(){
        	var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        	var maxPos = $chars.length;
       		var noceStr = "";
        	for (i = 0; i < 32; i++) {
            	noceStr += $chars.charAt(Math.floor(Math.random() * maxPos));
        	}
       		HC.oldNonceStr = noceStr;
        	return noceStr;
       },
       //扩展包方法
       getPackage:function(notifyUrl,applyId,partnerId,partnerKey,money){
        var banktype = "WX";
        var body = "9188微信支付";//商品名称信息，这里由测试网页填入。
        var fee_type = 1;//费用类型，这里1为默认的人民币
        var input_charset = "UTF-8";//字符集，这里将统一使用GBK
        var notify_url = notifyUrl;//支付成功后将通知该地址
        var out_trade_no = applyId;//订单号，商户需要保证该字段对于本商户的唯一性
        var partner = partnerId;//测试商户号
        var spbill_create_ip = "127.0.0.1";//用户浏览器的ip，这个需要在前端获取。这里使用127.0.0.1测试值
        //var total_fee = money*100;//总金额。
        var total_fee = money*100;//总金额。
        var partnerKey = partnerKey;//这个值和以上其他值不一样是：签名需要它，而最后组成的传输字符串不能含有它。这个key是需要商户好好保存的。
        
        //首先第一步：对原串进行签名，注意这里不要对任何字段进行编码。这里是将参数按照key=value进行字典排序后组成下面的字符串,在这个字符串最后拼接上key=XXXX。由于这里的字段固定，因此只需要按照这个顺序进行排序即可。
        var signString = "bank_type="+banktype+"&body="+body+"&fee_type="+fee_type+"&input_charset="+input_charset+"&notify_url="+notify_url+"&out_trade_no="+out_trade_no+"&partner="+partner+"&spbill_create_ip="+spbill_create_ip+"&total_fee="+total_fee+"&key="+partnerKey;
        var md5SignValue =  ("" + CryptoJS.MD5(signString)).toUpperCase();
        //然后第二步，对每个参数进行url转码，如果您的程序是用js，那么需要使用encodeURIComponent函数进行编码。
        
        
        banktype = encodeURIComponent(banktype);
        body=encodeURIComponent(body);
        fee_type=encodeURIComponent(fee_type);
        input_charset = encodeURIComponent(input_charset);
        notify_url = encodeURIComponent(notify_url);
        out_trade_no = encodeURIComponent(out_trade_no);
        partner = encodeURIComponent(partner);
        spbill_create_ip = encodeURIComponent(spbill_create_ip);
        total_fee = encodeURIComponent(total_fee);
        
        //然后进行最后一步，这里按照key＝value除了sign外进行字典序排序后组成下列的字符串,最后再串接sign=value
        var completeString = "bank_type="+banktype+"&body="+body+"&fee_type="+fee_type+"&input_charset="+input_charset+"&notify_url="+notify_url+"&out_trade_no="+out_trade_no+"&partner="+partner+"&spbill_create_ip="+spbill_create_ip+"&total_fee="+total_fee;
        completeString = completeString + "&sign="+md5SignValue;
        
        
        HC.oldPackageString = completeString;//记住package，方便最后进行整体签名时取用
        
        return completeString;
    },
    getSignType:function(){
        return "SHA1";
    },
    
    getSign:function(appid,appKey){
        var app_id = appid;
        var app_key = appKey;
        var nonce_str = HC.oldNonceStr;
        var package_string = HC.oldPackageString;
        var time_stamp = HC.oldTimeStamp;
        //第一步，对所有需要传入的参数加上appkey作一次key＝value字典序的排序
        var keyvaluestring = "appid="+app_id+"&appkey="+app_key+"&noncestr="+nonce_str+"&package="+package_string+"&timestamp="+time_stamp;
        var sign = CryptoJS.SHA1(keyvaluestring).toString();
        return sign;
    }
}