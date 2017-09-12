$(function(){
	/***
	$("#rname").focus(function(){
		if($(this).val()==this.defaultValue){
			$(this).val("");
		}
	})
	
	$("#rname").bind("blur",function(){
		if($(this).val()==""){
			$(this).val(this.defaultValue);
		}
	})
	***/
	$.ajax({
        url: $_user.url.base,
        success:function (data){
        	var R = $(data).find("Resp");
        	var c = R.attr('code');
        	var d = R.attr('desc');
        	
        	if(c == '0'){
        		var U = R.find('row');
	        	var m = U.attr("usermoeny");//账户余额
	        	$("#usermoney").html(m);
	        	
        	}
        }
	})
	
	
	
	 $.ajax({
		 url : $_user.url.card,
		 type : "POST",
		 dataType : "xml",
		 success : function(xml) {
		 var R = $(xml).find("Resp");
		 var rows = $(R).find("rows");
		 var r = $(rows).find("row");
		 var code = r.attr("code");
		 var desc = R.attr("desc");
		 var card = r.attr("card");
		 
		 card = card.substr(-4);
		 var prov = r.attr("prov");
		 var city = r.attr("city");
		 var name = r.attr("name");
		 
		 var bname="";
		
		 switch (code){
				 case "1":
				 bname="招商银行";
				 break;
				 case "2":
				 bname="工商银行";
				 break;
				 case "3":
				 bname="建设银行";
				 break;
				 case "4":
				 bname="中国银行";
				 break;
				 case "5":
				 bname="中国人民银行";
				 break;
				 case "6":
				 bname="交通银行";
				 break;
				 case "8":
				 bname="中信银行";
				 break;
				 case "9":
				 bname="兴业银行";
				 break;
				 case "10":
				 bname="光大银行";
				 break;
				 case "12":
				 bname="中国民生银行";
				 break;
				 case "13":
				 bname="中国农业银行";
				 break;
				 case "15":
				 bname="农村信用合作社";
				 break;
				 case "25":
				 bname="中国邮政储蓄银行";
				 break;
				 case "1000":
				 bname="广东发展银行";
				 break;
				 case "1001":
				 bname="深圳发展银行";
				 break;
				 case "4000":
				 bname="上海浦东发展银行";
				 break;
				 case "4001":
				 bname="上海银行";
				 break;
				 default:
				 break;
			 }
			 if (bname != "") {
				 //提款银行：建设银行(尾号4843)
				 $("#bankname").html("提款银行:"+bname+"(尾号"+card+")");
			}else{
				 $("#bankname").html(prov+","+city+","+name);
			} 
		 }
	 })
	
	
	$("#tk").bind("click",function(){
		var rnameValue = $('#rname').val();
		var tkMoneyValue=$('#tkMoney').val();
		
		if(rnameValue==null){
			D.alert("请正确填写真实姓名");
			return false;
		}
		if(tkMoneyValue==null || tkMoneyValue<10){
			D.alert("请输入正确的金额");
			return false;
		}
		$.ajax({
			
	        url: $_user.url.drawmoney,
	        type:"post",
	        data:"realName="+encodeURIComponent($.trim($('#rname').val()))+"&tkMoney="+encodeURIComponent($.trim($('#tkMoney').val()))+"&tkType=0",
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var desc = R.attr("desc");
	        	if(desc.indexOf("成功")!=-1){
	        		window.location.href="#class=url&xo=useraccount/index.html";
	        	}else{
	        		D.alert(desc);
	        	}
	        	
	        }
		})
	})
})