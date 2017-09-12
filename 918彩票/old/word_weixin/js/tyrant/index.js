var matchtype = location.search.getParam('matchtype');//0足球
var openid = localStorage.getItem("openid");
//openid = 'oxRU4uNaBxtX41qP_cnNWH_hYnZo';
//openid = 'oxRU4uCbsozcg98pVjH4FVoiv4cc';//东亚

$(function(){
	//隐藏微信右上角分享图标
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', sendMessage, false);  
	}else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady'   , sendMessage);	
		document.attachEvent('onWeixinJSBridgeReady' , sendMessage);  
	}
	WX.init();
	
});

var WX = {

		init:function(){
			WX.bind();
			$.ajax({
				url:'/wechat/queryDatas.go?func=activematch',
				type:'post',
				dataType:'xml',
				success:function(xml){
					$('#option').show();
					
					var R = $(xml).find('Resp');
					var code = R.attr('code');
					var desc = R.attr('desc');
					if(code == "0"){//查询成功
						var r = R.find('row');
						r.each(function(aa){
							var imatchid = $(this).attr('imatchid');//比赛对阵id
							var imatchtype = $(this).attr('imatchtype');//场次类型
							var cleftteam = $(this).attr('cleftteam');//主队
							var crightteam = $(this).attr('crightteam');//客队
							var cdesc = $(this).attr('cdesc');//场次描述
							var cleftimg = $(this).attr('cleftimg');//主队图标
							var crgihtimg = $(this).attr('crgihtimg');//客队图标
							var cadddate = $(this).attr('cadddate');//添加时间
							var cbegindate = $(this).attr('cbegindate');//比赛时间
							var copendate = $(this).attr('copendate');//开启时间
							var iminnum = $(this).attr('iminnum');//最少参与人数
							var imostnum = $(this).attr('imostnum');//最多参与人数
							var imostteam = $(this).attr('imostteam');//最多团数（不包括土豪）
							var ipermoney = $(this).attr('ipermoney');//每人送奖金
							var iteammost_money = $(this).attr('iteammost_money');//每团最多派送奖金
							var istate = $(this).attr('istate');//开启状态
							var cscore = $(this).attr('cscore');//最终比分
							var iresult = $(this).attr('iresult');//比赛结果
							var ireturn = $(this).attr('ireturn');//派奖状态
							var ibossteam_num = $(this).attr('ibossteam_num');//土豪团数
							var ibossteam_join_num = $(this).attr('ibossteam_join_num');//土豪团参与人数
							var iourteam_num = $(this).attr('iourteam_num');//9188团数
							var iourteam_join_snum = $(this).attr('iourteam_join_snum');//9188团参与人数
							var ifailteam_num = $(this).attr('ifailteam_num');//失败团数
							var ifaiperson_num = $(this).attr('ifaiperson_num');//失败人数
							var iourmoney = $(this).attr('iourmoney');//9188总派送奖金
							var ibossmoney = $(this).attr('ibossmoney');//土豪总派送奖金
							var coperator = $(this).attr('coperator');//操作人
							var successteam = $(this).attr('successteam');//已成功参与该场次的竞猜团数
							var ideuce = $(this).attr('ideuce');//0  无平局  1有平局
							
							
							if(ideuce == 0){
								$('#option span').eq(1).hide();
							}
							
							var html = '';
							html += '<div class="flagLeft left"><div class="flagBg">';
							html += '<img alt="主队" src="/word_weixin/img/flag_ys/'+cleftimg+'"></div><span>'+cleftteam+'</span></div><span class="left flagVs">VS</span>';
							html += '<div class="flagLeft right"><div class="flagBg">';
							html +=	'<img src="/word_weixin/img/flag_ys/'+crgihtimg+'" alt="客队"></div><span>'+crightteam+'</span></div>';
							$('#duizhen').html(html);
							$('#iminnum').html(iminnum);
							$('#ipermoney').html(ipermoney);
							M = parseInt(cbegindate.substr(5,2));//月
							D = parseInt(cbegindate.substr(8,2));//日
							hm = cbegindate.substr(11,5);//时分
							$('#cdesc_cbegindate').html(cdesc+'&nbsp;'+M+'月'+D+'日'+hm);
							
							$('#option_one').html(cleftteam);
							$('#option_two').html(crightteam);
							$('#option').attr('imatchid', imatchid);
							$('#imostteam').html(imostteam);
							$('#successteam').html(successteam);
							$('#option span').Touch(function(){
								if($(this).hasClass('cur')){
									$(this).removeClass('cur');
									if(!$('#isOk').hasClass('payment2')){
										$('#isOk').addClass('payment2');
									}
									return;
								}
								$(this).addClass('cur').siblings().removeClass('cur');
								if(!isNaN(parseInt($('#money').val())) && parseInt($('#money').val()) != '0' && $('#isOk').hasClass('payment2')){
									$('#isOk').removeClass('payment2');
								}
							});
							
							if(aa==0)return false;
						});
					}else{
						WW.tx(desc);
					}
				}
			});
		},
		bind:function(){
			$.ajax({
				url:'/wechat/drawUserInfo.go',
				dataTpye:'xml',
				type:'POST',
				data:{
					openid:openid
				},
				success:function(xml){
					 var R = $(xml).find('Resp');
					 var code = R.attr('code');
					 var desc = R.attr('desc');
					 if(code == '0'){
						 var r = R.find('row');
						 var isbind = r.attr('isbind');//0 未绑定1已绑定
						 var wxname = r.attr('wxname');//微信昵称
						 var bonus = r.attr('bonus');//奖金或用户余额
						 $('#yue').html(bonus);
					 }else{
						 WW.tx(desc);
					 }
				}
			});
			
			$('#money').keyup(function(){
				this.value=this.value.replace(/\D/g,'');
				if($(this).val() > parseInt($('#yue').html())){
					$('#czhi').show();
					$('#isOk').addClass('payment2');
					return;
				}else{
					$('#czhi').hide();
				}
				if($(this).val() != '' && parseInt($(this).val()) != '0'){
					if($('#option span').hasClass('cur')){
						$('#isOk').removeClass('payment2');
					}else{
						!$('#isOk').hasClass('payment2') && $('#isOk').addClass('payment2');
					}
				}else{
					!$('#isOk').hasClass('payment2') && $('#isOk').addClass('payment2');
				}
				
				
			});
			$('#recharge').click(function(){
				$('#go_cz').css({left:'50%',top:'50%',marginLeft:'-10rem',marginTop:'-'+$('#go_cz').height()+'px'});
				$('#go_cz').show();
				$('#invite3').show();
			});
			$('#go_cz a:eq(1) ,#pwd_c a:eq(1) ,#invite3').click(function(){
				$('#go_cz').hide();
				$('#invite3').hide();
				$('#pwd_c').hide();
				
				$('#money').val('');
				!$('#isOk').hasClass('payment2') && $('#isOk').addClass('payment2');
			});
			//发起按钮		
			$('#isOk').bind('click',function(){
				var codes = $('#option .cur').attr('tz');
				var matchid = $('#option').attr('imatchid');
				var money = $('#money').val();
				
				if(openid == '' || openid == undefined){//
					WW.tx('网络不给力,请刷新页面');//openid获取失败
				}else if(money == '0'){
					WW.tx('送出金额不能为0');
				}else if(money == ''){
					WW.tx('请输入送出金额');
				}else if(money > parseInt($('#yue').html())){
					
				}else if(codes == '' || codes == undefined){
					WW.tx('请选择一个比赛结果');
				}else if(matchid == '' || matchid == undefined){
					WW.tx('比赛对阵id获取失败');
				}else{
					
					$('#pwd_c').css({left:'50%',top:'50%',marginLeft:'-8.75rem',marginTop:'-'+$('#pwd_c').height()/2+'px'});
					$('#pwd_c').show();
					$('#invite3').show();
					$('#pwd').focus();
				}
				
			});
			$('#pwd_c a:eq(0)').click(function(){
				
				WX.faqi();
				
			});
			$('#pwd').focus(function(){
				$('#error').hide();
			});
			
			
		},
		faqi:function(){
			var codes = $('#option .cur').attr('tz');
			var matchid = $('#option').attr('imatchid');
			var money = $('#money').val();
			var pwd = $('#pwd').val();
			
			if(pwd == '' || pwd == undefined){
				$('#error').show();
				$('#error').html('请输入密码');
			}else{
				var data = {
						openid: openid,//oxRU4uNaBxtX41qP_cnNWH_hYnZooxRU4uNaBxtX41qP_cnNWH_hYnZo
						codes: codes,
						matchid : matchid,
						money: money,
						pwd: pwd
				};
				
				$.ajax({
					url:'/wechat/joinMatch.go',
					type:'POST',
					dataType:'xml',
					data:data,
					success:function(xml){
						var R = $(xml).find('Resp');
						var code = R.attr('code');
						var desc = R.attr('desc');
						if(code == '0'){
							var r = R.find('row');
							var teamid = r.attr('teamid');
							var openid1 = r.attr('openid');
	//						var cguessscale = r.attr('cguessscale');
							window.location.replace('/word_weixin/free/success.html?teamid='+teamid+'&openid='+openid1);
						}else if(code == '-3000'){
							$('#error').show();
							$('#error').html(desc);
						}else{
							WW.tx(desc);
						}
					}
				});
			}
		}
};