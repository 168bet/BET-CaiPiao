/*
* Author: weige
* Date : 2014-04-28
*/ 
(function(){
	$('#iName').keyup(function(){
		if($(this).val().length >0 ){
			$('.error').show();
		}else{
			$('.error').hide();
		}
	});
	$('.error').click(function(){
		$('#iName').val('');
		$('.error').hide();
	});
	var agent = localStorage.getItem('from');
	if(agent == 'azcp' || agent == 'k360'){
		$('#titel_').html('完善购彩信息');
		$('#bott_').html('开始购彩');
		
		var uid = location.search.getParam('uid');
		if(agent == 'k360' && uid){
			$('#iName').val(uid);
			$('#iName').next().show();
		}else{
			$('#iName').attr('placeholder','请输入4-16位字符的购彩昵称');
		}
		$('#iCode').attr('placeholder','请填写6-20位字符购买密码');
		if(agent == 'azcp'){
			$('#cans_').click(function(){
				window.location.href="http://4g.9188.com/user/allylogin.go?type=10";
			});
		}else{
			$('#cans_').hide();
		}
		
	}else{
		$('#cans_').click(function(){
			location.href="#class=url&xo=login/index.html";
		});
	}
	$('#iName').blur(function(e, Y) {
//		var ln = $.trim($(this).val());
//		var len = $_base_s.getStrLen(ln);
//		if (len < 4 && len != 0) {
//			alert('对不起，用户名长度至少应该为4个字符');
//			return false;
//		} else if (len > 16) {
//			alert('对不起，用户名长度不要超过16个字符');
//			return false;
//		}
//		if (ln.indexOf("习近平") >= 0 || ln.indexOf("李克强") >= 0
//				|| ln.indexOf("法轮功") >= 0 || ln.indexOf("9188") >= 0) {
//			alert('用户名含有禁用词语，请重新填写');
//			return false;
//		}
//		var rn = ln.replace(/[\d\w\\u4e00-\u9fa5]/gi, "");
//		if (rn != "") {
//			alert('用户名不合法，可由中英文、数字、下划线组成');
//			return false;
//		}
//		$.ajax({
//			url : $_user.url.checkexist,
//			type : "POST",
//			dataType : "xml",
//			data : $_user.key.uid + "=" + encodeURIComponent(ln) + "&rnd="
//					+ Math.random(),
//			success : function(xml) {
//				var R = $(xml).find('Resp');
//				var d = R.attr('desc');
//				var c = R.attr('code');
//				if(c == 0){
//					alert('该用户名可以使用');return false;
//				}else{
//					alert(d);return false;
//				}
//			}
//		});
	});
	
	$(".zhuceOpen2").bind("click",function(){
		$(this).hide();
		$(".zhuceOpen").show();
		$("#iCode").attr("type","text");
	})
	
	$(".zhuceOpen").bind("click",function(){
		$(this).hide();
		$(".zhuceOpen2").show();
		$("#iCode").attr("type","password");
	})
	
})();
function reg(){
	var iName = $.trim($("#iName").val());
	var iCode = $.trim($("#iCode").val());
	var len = iCode.length;
	var cat = /^[\x20-\x7f]+$/;
	if(iName == "" && len == 0){
		D.alert('请输入用户名和密码');
		return false;
	}else if(iName == ""){
		D.alert('请输入用户名');
		return false;
	}else if (len == 0) {
		D.alert("请输入密码");
		return false;
	} else if (len < 6) {
		D.alert('您输入的密码不能低于6位');
		return false;
	} else if (len > 20) {
		D.alert('您输入的密码不能超过20位');
		return false;
	} else if (iCode == iName) {
		D.alert('密码不能够与用户名一致！请重新输入');
		return false;
	}else if (!(cat.test(iCode))) {
		D.alert('密码请勿包含中文');
		return false;
	}else{
		var url = '';
		var data = $_user.key.uid
		+ "="
		+ encodeURIComponent($.trim(iName))
		+ "&"
		+ $_user.key.pwd
		+ "="
		+ encodeURIComponent($.trim(iCode));
		var agent = localStorage.getItem('from');
		var agent1 = localStorage.getItem('comeFrom')||'';
		var agent2 = localStorage.getItem('fromMenu');
		if(agent == 'azcp'){
			url='http://4g.9188.com/user/azwap_bind.go';
		}else if(agent2 == 'wxfw'){
			url='/wechat/wxRegister.go';
		}else if(agent == 'k360'){
			url='http://test-4g.9188.com:38080/user/wapcdbind.go';
		}else{
			url = $_user.url.mregister;
			var t = location.host;
			if(t == 'm.cp.dbw.cn'){
				agent1 = 'dbwcp';
			} else if(t == 'm.cp.eastday.com'){
				agent1 = 'eastday';
			} else if(t == 'mcp.dzwww.com'){
				agent1 = 'dzwcp';
			} else if(t == 'm.cp.enorth.com.cn'){
				agent1 = 'bfwcp';
			}
			data += '&source=3000&comeFrom='+agent1;
			
		}
		
		$.ajax({
	     	type: 'POST',
	         data: data,
	         url: url,
	         success:function (data){                 
	        	var R = $(data).find("Resp");
	   			var code = R.attr("code");
	   			var desc = R.attr("desc");
	   			   if (code == "0"){
	   				if(agent == 'azcp'){
	   					D.alert('注册成功',function(){
	   						if(desc == ''){
	   							desc = '/';
	   						}
		   					location.href=desc;
	   				    });
	   				}else{
	   					D.alert('注册成功',function(){
		   					history.go(-1);
	   				    });
	   				}
	   				   
				   }else{
					   D.alert(desc);
				   }
	          },
	          error:function(){
	        	  D.alert('网络异常');
	          }
	     });
	}
}

function bind() {
	var uid = $("#iName").val();
	var nuid = location.search.getParam('nuid');		
	if(uid==""){
		D.alert("用户名不能为空！");
		return false;
	}
	var r = uid.match(/(\d{7,})/);
	if (r != null && r != "" && r != undefined){
		showErr("username_err", "用户名里面不能包含6个以上连续的数字，请重新填写!");
		return false;
	}
	var pwd = $("#iCode").val();
	if(pwd==""){
		D.alert("密码不能为空！");
		return false;
	}
	var data = $_user.key.uid + "=" + encodeURIComponent(uid) + "&" + $_user.key.pwd + "=" + encodeURIComponent(pwd)+"&mobileNo="+ nuid;
	$.ajax({
		type : 'POST',
		data : data,
		url : '/user/touchpubbind.go',
		success : function(res) {

			var obj = eval("(" + res + ")");
	//		alert("obj e---:"+obj.e);
			if(obj.c==0&&obj.t==14){
				window.location.href = obj.p;
			}else if(obj.c != 0){
				D.alert(obj.e);
			}
		},
		error : function(){
			alert("系统错误！");
		}
	});

};