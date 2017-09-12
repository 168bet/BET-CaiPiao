var openid = localStorage.getItem("openid");
var bindstate = false;//是否绑定9188 
//openid = 'oxRU4uNaBxtX41qP_cnNWH_hYnZo';//me
//openid = 'oxRU4uCbsozcg98pVjH4FVoiv4cc'//dangye
//openid = 'oShA6uD6ywpqzwQc3qNReUf9-qE4'//华哥
//openid = 'oxRU4uBixqb0xpCRl5loeE82C2VA';//戈多
//localStorage.setItem("openid", openid);

(function(){
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', sendMessage, false);  
	}else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady'   , sendMessage);	
		document.attachEvent('onWeixinJSBridgeReady' , sendMessage);  
	}
	
	
	
	var init,bangding;
	bangding = function(){
		$('#invite').click(function(){
			$('#tx').hide();
			$('#gc').hide();
			$('#ceng_').hide();
			$('#invite').hide();
		});
		$('#tx  a,#gc a').click(function(){
			window.location.href='/word_weixin/myrecord/telbind.html';
		});
		
	};
	init = function(){
		bangding();
		if(openid != '' && openid != undefined && openid != null){
			var data = {
					openid:openid,
					func:'user_teamjoin'
			};
			$.ajax({
				url:'/wechat/queryDatas.go',
				dataTpye:'xml',
				type:'POST',
				data:data,
				success:function(xml){
					$('.loading').hide();
					 var R = $(xml).find('Resp');
					 var code = R.attr('code');
					 var desc = R.attr('desc');
					 if(code == '0'){
						 var r = R.find('row');
						 var html = '';
						 r.each(function(){
							 var iteamid = $(this).attr('iteamid');//团队id
							 var cname = $(this).attr('cname');//发起人昵称
							 var cadddate = $(this).attr('cadddate');//发起时间
							 var iselect = $(this).attr('iselect');//竞猜内容
							 var iwin = $(this).attr('iwin');//获得奖金
							 var iswin = $(this).attr('iswin');//是否中奖0未计奖1未中奖2已中奖
							 var ireturn = $(this).attr('ireturn');//领奖状态0未算奖   1已算奖(未领奖)  2 已领奖 3已派奖
							 var imatchid = $(this).attr('imatchid');//比赛对阵id
							 var itype = $(this).attr('itype');//类型  0 9188是土豪 1 我是土豪
							 var ijoinnum = $(this).attr('ijoinnum');//总参与人数
							 var iactive = $(this).attr('iactive');//状态 0召集中 1已成团可参加 2已满员 3组团失败 4组团成功
							 var cleftteam = $(this).attr('cleftteam');
							 var crightteam = $(this).attr('crightteam');
							 var iminnum = $(this).attr('iminnum');//最少参与人数
							 var headimg = $(this).attr('headimg');//用户头像
							 var ipermoney = $(this).attr('ipermoney');//每人送奖金
							 var fqr = $(this).attr('fqr');//发起人
							 var imostmoney = $(this).attr('imostmoney');//土豪送的金额
							 var iteammost_money = $(this).attr('iteammost_money');//每团最多派送奖金
							 var icorrectnum = $(this).attr('icorrectnum');//中奖人数
     						 var itcmoney = $(this).attr('itcmoney');//发起人提成奖金
     						 
							//发起人提成
     						var tc_ = '';
     						if(parseFloat(icorrectnum) >0){
     							tc_ = (itcmoney == '' ||itcmoney == '0')?'':parseFloat(itcmoney);
     						}
     						
							 var M = cadddate.substr(5,2)+'月';
							 var D = cadddate.substr(8,2)+'日';
							 var hm = cadddate.substr(11,5);
							 
							 var bl_ = false;
							 var zz = '';
							 if(fqr == cname){
								 if(itype == '1'){
									 zz = '<em class="nameIco">我是壕</em>';
								 }else{
									 zz = '<em class="nameIco">我发起</em>';
								 }
								 bl_ = true;
							 }else{
								 if(itype == '1'){
									 zz = '<em class="nameIco">土豪送</em>';
								 }
							 }
							 var tmoney = '';//团队奖金
							 if(itype == '1'){
								 tmoney = imostmoney;
							 }else{
								 
								 var zong_ = parseFloat(ipermoney) * parseFloat(ijoinnum);
								 tmoney = zong_>parseFloat(iteammost_money)?iteammost_money:zong_;
							 }
							 html +='<a href="/word_weixin/myrecord/convene.html?teamid='+iteamid+'">';
							 html +='<div class="teamname">';
							 html +='<p><cite>'+cleftteam+'</cite>  VS  <cite>'+crightteam+'</cite>'+zz+'</p>';
							 html +=' <span>'+M+D+hm+'</span>';
							 html +='</div>';
							 html +='<div class="status">';
							 
							 if(itype == '1'){
								 if(iactive == 4){
									 if(iwin>0){
										 var dy = iwin;
										 if(ireturn == 2||ireturn == 3){
											 dy = '奖金<em class="yellow">'+iwin+'</em>元';
										 }else{
											 dy = '<em class="yellow">等待领奖</em>';
										 }
										 html +='<p>团队奖金'+tmoney+'元</p>';
										 html +='<span class="gray2">'+dy+'</span>'; 
									 }else{
										 html +='<p>团队奖金'+tmoney+'元</p>';
										 var dy = '<em class="yellow">等待领奖</em>';
										 var coc = 'blue';
										 if(iswin == 0){
											 dy = '等待开奖';
										 }else if(iswin == 1){
											 dy = '未中奖';
											 coc = 'gray';
										 }
										 html +='<span class="'+coc+'">'+dy+'</span>';
									 }
								 }else if(iactive == 3){
									 html +='组团失败';
								 }
								 else{
									 html +='<p>团队奖金'+tmoney+'元</p>';
									 html +='<span class="blue">召集中</span>';
								 }
								 
							 }else{
								 if(iactive == 0){//状态 0召集中 1已成团可参加 2已满员 3已结束
									 html +='<p>还差'+(parseInt(iminnum)-parseInt(ijoinnum))+'人可成团</p>';
									 html +='<span class="blue">召集中('+ijoinnum+'/'+iminnum+')</span>';
									 
								 }else if(iactive == 1){
									 html +='<p>团队奖金'+tmoney+'元</p>';
									 html +='<span class="blue">召集中('+ijoinnum+'/'+iminnum+')</span>';
									 
								 }else if(iactive == 2){
									 html +='<p>团队奖金'+tmoney+'元</p>';
									 html +='<span class="blue">等待开奖</span>';
								 }else if(iactive == 3){
										 html +='组团失败('+ijoinnum+'/'+iminnum+')';
								 }else if(iactive == 4){
									 if(iwin>0){
										 var dy = iwin;
										 if(ireturn == 2||ireturn == 3){
											 if(bl_){
												 if(tc_){
													 iwin = parseFloat(iwin)+tc_;
													 iwin = iwin.toFixed(2);
													 dy = '抢得<em class="yellow">'+iwin+'</em>元';
												 }else{
													 dy = '抢得<em class="yellow">'+iwin+'</em>元';
												 }
											 }else{
												 dy = '抢得<em class="yellow">'+iwin+'</em>元';
											 }
										 }else{
											 dy = '<em class="yellow">等待领奖</em>';
										 }
										 html +='<p>团队奖金'+tmoney+'元</p>';
										 html +='<span class="gray2">'+dy+'</span>'; 
									 }else{
										 html +='<p>团队奖金'+tmoney+'元</p>';
										 var dy = '<em class="yellow">等待领奖</em>';
										 var coc = 'blue';
										 if(iswin == 0){
											 dy = '等待开奖';
										 }else if(iswin == 1){
											 dy = '未中奖';
											 coc = 'gray';
										 }
										 html +='<span class="'+coc+'">'+dy+'</span>';
									 }
								 }else{
									 html +='<span class="blue"></span>';
								 }
							 }
							 
							 
							 
							 html +='</div>';
							 html +='<em class="arrow"></em>';
							 html +='</a>';
						 });
						 
						 $('#list').html(html);
					 }else{
						 WW.tx(desc);
					 }
				}
			});
		}else{
			WW.tx('网络不给力,请刷新页面');//openid获取失败
		}
		
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
					 var imgsrc = r.attr('imgsrc');//头像
					 var uid = r.attr('uid');//9188用户名
					 var tcbonus = r.attr('tcbonus');//提成金额
					 
					 if(imgsrc != '' && imgsrc != undefined){
						 $('#portrait').attr('src',imgsrc);
					 }
					 if(uid != '' && uid != undefined){
						 $('#9188_name').html('9188用户名：'+uid).show();
					 }
					 if(isbind == 1){//已绑定
						 bindstate = true;
						 $('#user_mx p').html('账户余额: <em>'+bonus+'</em>元');
					 }else{
						 var a = parseFloat(bonus)+parseFloat(tcbonus);
						 a = a.toFixed(2);
						 $('#user_mx p').html('获得奖金: <em>'+a+'</em>元');
					 }
					 $('#user_mx h3').html(wxname);
					 
					
				 }else{
					 WW.tx(desc);
				 }
			}
		});
	};
	init();
	
})();
function bd(cc){
	if(bindstate){
		if(cc == 'tx'){
			$('#ceng_ p').html('请下载手机客户端进行提现');
		}else{
			$('#ceng_ p').html('请下载手机客户端使用奖金');
		}
		
		$('#ceng_').css({marginLeft:'-8.75rem',marginTop:'-'+$('#ceng_').height()/2+'px'});
		$('#ceng_').show();
		$('#invite').show();
	}else{
		$('#'+cc).css({left:parseInt(document.documentElement.clientWidth/2-$('#'+cc).width()/2),top:parseInt(document.documentElement.clientHeight/2-$('#'+cc).height())});
		$('#'+cc).show();
		$('#invite').show();
	}
}