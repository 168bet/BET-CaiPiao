var matchtype = location.search.getParam('matchtype');//0足球
var openid = localStorage.getItem("openid");
//openid = 'oxRU4uNaBxtX41qP_cnNWH_hYnZooxRU4uNaBxtX41qP_cnNWH_hYnZo';
$(function(){
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
//发起按钮		
		$('#isOk').click(function(){
			WX.faqi();
		});
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
						var joinnum = $(this).attr('joinnum');//参与人数
						$('#num_rs_').html(joinnum);
						var html = '';
						html += '<div class="flagLeft left"><div class="flagBg">';
						html += '<img alt="主队" src="/word_weixin/img/flag_ys/'+cleftimg+'"></div><span>'+cleftteam+'</span></div><span class="left flagVs">VS</span>';
						html += '<div class="flagLeft right"><div class="flagBg">';
						html +=	'<img src="/word_weixin/img/flag_ys/'+crgihtimg+'" alt="客队"></div><span>'+crightteam+'</span></div>';
						$('#duizhen').html(html);
						$('#iminnum').html(iminnum);
						$('#ipermoney').html(ipermoney);
						M = parseInt(cbegindate.substr(5,2),10);//月
						D = parseInt(cbegindate.substr(8,2),10);//日
						hm = cbegindate.substr(11,5);//时分
						$('#cdesc_cbegindate').html(cdesc+'&nbsp;'+M+'月'+D+'日'+hm);
						
						
						if(ideuce == 0){
							$('#option span').eq(1).hide();
						}
						
						$('#option_one').html(cleftteam);
						$('#option_two').html(crightteam);
						$('#option').attr('imatchid', imatchid);
						$('#imostteam').html(imostteam);
						$('#successteam').html(successteam);
						$('#option span').Touch(function(){
							if($(this).hasClass('cur')){
								$('#isOk').attr('class','payment payment2');
								$(this).removeClass('cur');
								return;
							}
							$(this).addClass('cur').siblings().removeClass('cur');
							$('#isOk').attr('class','payment');
						});
						if(aa==0)return false;
					});
				}else{
					WW.tx(desc);
				}
			}
		});
	},
	faqi:function(){
		var codes = $('#option .cur').attr('tz');
		var matchid = $('#option').attr('imatchid');
		if(openid == '' || openid == undefined){//
			WW.tx('网络不给力,请刷新页面');//openid获取失败
		}else if(codes == '' || codes == undefined){
			WW.tx('请选择一个比赛结果');
		}else if(matchid == '' || matchid == undefined){
			WW.tx('比赛对阵id获取失败');
		}else{
			var data = {
					openid: openid,//oxRU4uNaBxtX41qP_cnNWH_hYnZooxRU4uNaBxtX41qP_cnNWH_hYnZo
					codes: codes,
					matchid : matchid
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
					}else{
						WW.tx(desc);
					}
				}
			});
		}
	}
};
