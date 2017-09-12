;$(function(){
	var chat = {
		rid: 686660,
		room: null,
		today: null,
		cnickid: '_test_',
		lastTime: 0,
		msgCount: 0,
		roomId: '5575f1cde4b06a320970e7f2',
		app_id: 'zttp1hzf8hcu7ghofbyckz9npj8btalfbyq5e1rf4v1ulmp6',
		
		init: function() {
			this.today = new Date();
			this.today.setHours(0);
			this.today.setMinutes(0);
			this.today.setSeconds(0);
			
			//var mtime = new Date(cur_match.mtime.replace(/-/g, '/'));
			
			$.ajax({
				url:'/user/query.go?flag=63',
				type : 'post',
				dataType : "xml",
				success : function(xml){
					chat.cnickid = $(xml).find('row').attr('cnickid');
					chat.initCore();
				}
			});
		},
		initCore: function() {
			var rt;
			if (this.rt) {
				rt = this.rt;rt.open();
			} else {
				this.rt = rt = AV.realtime({
					appId: this.app_id,
					clientId: this.cnickid,
					encodeHTML: true
				});
			}

			// 实时通信服务连接成功
			
			rt.on('open', function() {
				rt.room(chat.roomId, function(room) {
					chat.room = room;
					if(chat.room){
						room.join(function() {
							// 获取历史
							room.log({t: new Date().getTime()}, function(data) {
								/***
								$('.zq-lq-ul').empty();
								chat.lastTime = data[0].timestamp;//获取更多用
								***/
								$.each(data, function() {
									chat.addMsg(this);
								});
							});
							
							// 接收消息
							room.receive(chat.addMsg);
						});
					}
				});
			});
		},
		bindEvent: function() {
		
			// 加载聊天室选项
			$('body').bind('initChat', function(){
				/***
				$('.zq-dlq').hide();
				$('.bf_d_div>.bkbl').hide();
				$('.zq-lq-o').children().hide();
				***/
				chat.room && chat.room.leave();
				chat.rt && chat.rt.close();
				$.ajax({
					type: 'post',
					async: false,
//					url: 'http://mobile.9188.com  /trade/chathomepage.go',
					url: '/trade/chathomepage.go',
					dataType: 'xml',
					data:{itemid: cur_match.itemId, bdStage: null,sort: null},
					success : function(xml) {
						var row = $(xml).find('row');
						
						chat.rid = row.attr('rid');
						chat.roomId = row.attr('convid');
						/***
						if (chat.roomId) {
							$('.bf_d_div>.bkbl').show();
						}
						***/
					}
				});
			});
			// 切换到聊天室
			/***
			$('.bf_d_div>.bkbl').click(function() {
				if ($('#loginbtn').is(':visible')) {
					Y.postMsg('jc_msg_login',function(){
						chat.init();
					});
				} else {
					chat.init();
				}
			});
			***/
			
			$(".gqnav span:eq(1)").bind("click",function(){
				chat.init();
			})
			$('#talk_info').bind('keyup keydown paste',function(){
				chat.countChar();
			});
			// 发表
			$('#talk_info').keypress(function(event) {
				chat.countChar();
				if(event.which == 13) {
					event.preventDefault();
					chat.sendMsg();
				}
			});
			$('.csy button').click(function() {
				chat.sendMsg();
			});
			//读消息
			//$('.zq-lq-p1').click(chat.readMsg);
			
			
		},
		readMsg: function() {
			$(this).hide();
			$('.zq-lq-ul').scrollTop(chat.msgCount = 0);
		},
		sendMsg: function() {
			$.ajax({
				type: 'post',
				async: false,
				url: 'http://t2015.9188.com /trade/sendnocheckmessage.go',
				//url: 'http://mobile.9188.com  /trade/sendmessage.go',
				dataType: 'xml',
				data: {
					rid: chat.rid,
					convid: chat.roomId,
					uid: chat.cnickid,
					message: $('#talk_info').val()
				},
				success : function(xml) {
					if($(xml).find('Resp').attr('code') == 0){
						$('#talk_info').val('');
					}
				}
			});
		},
		addMsg: function(data) {
			//data.time = chat.makeDate(data.timestamp, '');
			
			
			//var time = talk.makeDate(data.timestamp, '')
			
			$("#talk").prepend('<dl><dt>'+data.fromPeerId+'</dt><dd>'+data.msg+'</dd><dd><cite>13分钟</cite></dd></dl>')
		},
		formatDate: function(date,format){
			var paddNum = function(num){
				num += "";
				return num.replace(/^(\d)$/,"0$1");
			};
			//指定格式字符
			var cfg = {
				yyyy : date.getFullYear(), //年 : 4位
				yy : date.getFullYear().toString().substring(2),//年 : 2位
				M  : date.getMonth() + 1,  //月 : 如果1位的时候不补0
				MM : paddNum(date.getMonth() + 1), //月 : 如果1位的时候补0
				d  : date.getDate(),   //日 : 如果1位的时候不补0
				dd : paddNum(date.getDate()),//日 : 如果1位的时候补0
				hh : paddNum(date.getHours()),  //时
				mm : paddNum(date.getMinutes()), //分
				ss : paddNum(date.getSeconds()) //秒
			};
			format || (format = "yyyy-MM-dd hh:mm:ss");
			return format.replace(/([a-z])(\1)*/ig,function(m){return cfg[m];});
		},
		makeDate: function(time, temp){
			if(time >= this.today.getTime()){
				temp = this.formatDate(new Date(time), 'hh:mm:ss');
			}else{//1000 * 60 * 60 * 24
				temp = '昨天';
			}
			return temp;
		},
		countChar: function(){
			var content = $('#talk_info').val();
			var num = this.getStrLen(content);
			if (num > 140) {
				$('.csy article p').empty().append('还可以输入<cite class="red">0</cite>个字');
				$('#talk_info').val(this.lastContent);
			} else {
				$('.csy article p').empty().append('还可以输入<cite class="red">'+(100-num)+'</cite>个字');
				this.lastContent = $('#talk_info').val();
			}
		},
		getStrLen:function(str) {// 含中文的字符串长度
			var len = 0;
			var cnstrCount = 0;
			for ( var i = 0; i < str.length; i++) {
				if (str.charCodeAt(i) > 255)
					cnstrCount = cnstrCount + 1;
			}
			len = str.length + cnstrCount;
			return len;
		}
	};
	
	chat.bindEvent();
});