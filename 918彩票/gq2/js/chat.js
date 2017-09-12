var username = localStorage.getItem("username");
		var obtain={
				sid:"74250",//热火VS卡尔特人  mid
				uid:""
		}
		
		var p_data={
				tribeid:"",//群ID/聊天室ID  传入的比赛sid所对应的群ID/聊天室ID 
				tribename:"",//群名称
				nick:"",//im用户名所对应的昵称
				pwd:"",//im登录密码 用来登录im聊天服务器的登录密码(现在统一使用：chat123456) 
				uid:""//im用户名(登录名) 用来登录im聊天服务器的登录名，注：该登录名 = 传入的9188用户名的十六进制表现形式 
				
		}
		
		//获取聊天室ID
		var get_tribeid=function(){
			$.ajax({
				async:false,
				url:'/trade/tribeinfo.go',
				data:obtain,
				type: 'GET',
				dataType: 'xml',
				success:function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					var tribe = R.find("tribe")
					p_data.tribeid = tribe.attr("tribeid")
					p_data.tribename = tribe.attr("tribename")
					
					var imuser = R.find("imuser");
					p_data.uid = imuser.attr("uid")
					p_data.pwd = imuser.attr("pwd")
					p_data.nick = imuser.attr("nick")
					
				}
			})
		}
		
		
		get_tribeid();
		
		var sdk = new WSDK();
		 
		sdk.Base.login({
		    uid:p_data.uid,
		    appkey: 23253859,
		    credential: p_data.pwd,
		    timeout: 4000,
		    success: function(data){
		       // {code: 1000, resultText: 'SUCCESS'}
		       console.log('login success', data);
		    },
		    error: function(error){
		       // {code: 1002, resultText: 'TIMEOUT'}
		       console.log('login fail', error);
		    }
		});
		
		
		
		$(document).keydown(function(event){
			if(event.which==13){
				//群聊
				sdk.Tribe.sendMsg({
					   tid: p_data.tribeid,//群号
					   msg: '你好啊',
					   success: function(data){
					     console.log(data);
					   },
					   error: function(error){
					     console.log(error);
					   }
					});
			}
		});
	     
		
		
		var obj = {
			    text: 'wsdk'
			};
		sdk.Event.on('START_RECEIVE_ONE', function(data){
		    console.log(data);
		    console.log(this.text); // wsdk
		}, obj);
		
		WKIT.init({
			container: document.getElementById('J_demo'),
			//height:500,
			//width:$(document).width(),
			uid: p_data.uid,//登录用户名
			appkey: "23253859",
			credential:p_data.pwd,//登录密码
			touid: "测试账号",//聊天对方的用户名
			placeholder:'请大家文明，踊跃发言',
			welcomeMsg:'欢迎来到聊天室'
			});
		
		/***
		// 手动传入大小
		setTimeout(function(){
		    var demo = document.getElementById('J_demo');
		    demo.style.width = $(document).width();
		    demo.style.height = '250px';
		    
		    WKIT.resize({
		        width: 500,
		        height: 250
		    });
		}, 3000);
		***/
