
$(function(){
	
	
	$.ajax({
		url:'/wechat/queryDatas.go?func=activematch',
		type:'post',
		dataType:'xml',
		success:function(xml){
			$('#option').show();
			var R = $(xml).find('Resp');
			var code = R.attr('code');
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
					$('#min_r').html(iminnum);
					$('#jin_e').html(ipermoney);
					$('#min_r_2').html(iminnum);
					$('#min_f').html(imostteam);
					$('#min_f_r').html(imostnum);
					$('#min_f_max').html(iteammost_money);
				});
			}
		}
	});
});