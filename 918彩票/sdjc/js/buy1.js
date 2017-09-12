var getParam=function(name){
	     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	     var r = window.location.search.substr(1).match(reg);
	     if(r!=null)return  unescape(r[2]); return null;
	}

//玩法类型
var playType={
		"SPF":"胜平负",
		"RQSPF":"让球",
		"JQS":"总进球",
		"CBF":"猜比分",
		"BQC":"半全场"
}

//玩法结果
var results={
		"3":"胜","1":"平","0":"负",
}

//投注需要参数
var g = {
       hid:"",
       gid:"",
       money:"",
       muli:"",
       cupacketid:"",
       redpacket_money:""
    };
var hid = getParam("hid");

var SD = (function(){
	var o = {
			length:function(jsonObj) {
			    var Length = 0;
			    for (var item in jsonObj) {
			      Length++;
			    }
			    return Length;
		    },
			gain: function(){
				
				$.ajax({
					url:'/trade/godShareDetail.go?hid=70DG2016102562722892',
					type:'POST',
					success: function(xml){
						var R = $(xml).find('Resp');
						var code = R.attr("code");
						var desc = R.attr("desc");
						
						var itemdetail = R.find("itemdetail");
						var gameid = itemdetail.attr("gameid");//游戏id
						var projid = itemdetail.attr("projid");//方案编号
						var wrate = itemdetail.attr("wrate")||"";//打赏比例
						var endtime = itemdetail.attr("endtime")||"";//截止时间
						var tmoney = itemdetail.attr("tmoney")||"";//发起人投注金额
						var averageMoney = itemdetail.attr("averageMoney")||"";//起投金额
						var userNum = itemdetail.attr("userNum");//跟投人数
						var projState = itemdetail.attr("projState");//方案状态
						
						
						var godDetail = R.find("godDetail");
						var nickid = godDetail.attr("nickid");//分享人
						var uptype = godDetail.attr("uptype");//上榜几日类型
						var rank = godDetail.attr("rank");//排名
						var allnum = godDetail.attr("allnum");//发单总数
						var rednum = godDetail.attr("rednum");//红单数
						var shootrate = godDetail.attr("shootrate");// 命中率
						var returnrate = godDetail.attr("returnrate");//回报率
						var buymoney = godDetail.attr("buymoney");// 购买金额
						var winmoney = godDetail.attr("winmoney");//累积中奖金额
						var winrate = godDetail.attr("winrate");// 战胜人数比例
						var imgUrl = godDetail.attr("imgUrl")||"";//用户头像信息
						var isGod = godDetail.attr("isGod");//是否为大神
						
						$("#tmoney").html(tmoney);//发起人投注金额
						$("#endtime").html(endtime);//截止时间
						$("#averageMoney").html(averageMoney+"元");//起投金额
						$("#wrate").html(wrate)//打赏比例
						$("#nickid").html(nickid)//发起人名称
						$("#imgUrl").attr("src",imgUrl);
						
						$("#pMoney").html(tmoney+"元");
						$("#fdwrate").html(wrate);
						var rows = R.find('rows')
						var showCode = rows.attr("showCode");
						var cast = rows.attr("cast");
						var istate = rows.attr("istate");
						var mulity = rows.attr("mulity");
						var money = rows.attr("tmoney");
						var rmoney = rows.attr("rmoney");
						var tax = rows.attr("tax");
						var award = rows.attr("award");
						var rpmoney = rows.attr("rpmoney");
						var btime = rows.attr("btime");
						var imoneyrange = rows.attr("imoneyrange");
						var source = rows.attr("source");
						var gg = rows.attr("gg");//过关方式
						var minRatio = rows.attr("minRatio");
						var ipay = rows.attr("ipay");
						var upay = rows.attr("upay");
						var shareGod = rows.attr("shareGod");
						var sharedNickid = rows.attr("sharedNickid");
						var hideSharedNickid = rows.attr("hideSharedNickid");
						var visible = rows.attr("visible");
				
						var jindu = rows.find("jindu");
						
						
						var row = rows.find('row')
						var html = '';
						row.each(function(i ,v ){
//							id="161025001" name="周二001" hn="墨尔本胜利" 
//							gn="墨尔本城" hs="" gs="" hhs="" hgs="" 
//							lose="1" isdan="0" jsbf="" 
//						ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95"
							var id = $(this).attr('id');//
							var name = $(this).attr('name');//
							var hn = $(this).attr('hn');//
							var gn = $(this).attr('gn');//
							var hs = $(this).attr('hs');//
							var gs = $(this).attr('gs');//
							
							var hhs = $(this).attr('hhs');//
							var hgs = $(this).attr('hgs');//
							var lose = $(this).attr('lose');//
							var isdan = $(this).attr('isdan');//
							var jsbf = $(this).attr('jsbf');//
							var ccodes = $(this).attr('ccodes');//
							
							var rq = '';//让球样式
							if(lose!=0 && lose !=""){
								if(lose.indexOf('-')!=-1){
									rq="(<font color='green'>"+lose+"</font>)";
								}else{
									rq="(<font color='red'>"+lose+"</font>)";
								}
							}
							
							//是否设胆
							var dan="";
							if(isdan==1){
								dan='<span class="span14">胆</span>'
							}
						
							
							
							
							//showCode=false;
							
							if(showCode && showCode=="true"){
								var ccodes2 = ccodes.split('|')[1] || '',
								ccodes3 = ccodes2.split(',');
								var obj = {}
								for(var i = 0, l = ccodes3.length; i<l; i++){
									if(obj[ccodes3[i].split('=')[0]]){
										var arr = obj[ccodes3[i].split('=')[0]]
										arr.push(ccodes3[i].split('=')[1])
										obj[ccodes3[i].split('=')[0]] = arr
									}else{
										obj[ccodes3[i].split('=')[0]] = [ccodes3[i].split('=')[1]]
									}
									
								}
								
								html += '<tr>\
									<td class="width1" rowspan="'+(o.length(obj)+1)+'"><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length)+'</p></td>\
									<td class="width2"><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>\
									<td class="width3">半'+((hhs==""&&hgs=="")?"--":hhs+':'+hgs)+'/全'+((hs==""&&gs=="")?"--":hs+':'+gs)+'</td>\
									</tr>'
								for(var i in obj){
									var obj2 = obj[i]
									html+='<tr>'
									if(obj2.length>1){
										html += '<td align="left">'
										for(var j = 0; j<obj2.length; j++){
											var type = obj2[j].split('_')[0]
											html+='<span>'+playType[i]+':'+type+'('+obj2[j].split('_')[1]+')</span><br />'
										}
										html += '</td>'
									}else{
										var type=obj2[0].split('_')[0]
										html+='<td align="left"><span>'+playType[i]+':'+type+'('+obj2[0].split('_')[1]+')</span></td>'
									}
									console.log(i)
									html+='<td><label>主胜</label></td></tr>'
								}
							}else{//未开赛
								if(i==0){
									html+='<tr>'
									html+='<td class="width1"><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length)+'</p></td>'
									html+='<td class="width2"><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>'
									html+='<td class="width3" rowspan="'+row.length+'"><p>开赛后</p> <p>公开</p><img src="img/table.png" class="table_icon"></td>'
									html+='</tr>'
								}else{
									html+='<tr>'
									html+='<td><p>周一</p><p>001</p></td>'
									html+='<td><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>'
									html+='</tr>'
								}
							}
							
						})
						$('#bettingInfo').html(html);
					}
					
					
				})
			},
			checkResult:function(type,hs,gs,hhs,hgs,lose){
				var str='';
				switch (type) {
				case 'SPF':
					if(hs && gs && hs>gs){
						str='<label>主胜</label>'
					}else if(hs && gs && hs==gs){
						str='<label>平</label>'
					}else if(hs && gs && hs<gs){
						str='<label>客胜</label>'
					}
					break;
				case 'RQSPF':
					if(hs && gs && hs!="" && gs!=""){
						if(lose>0){
							if(hs+lose>gs){
								str='<label>让胜</label>'
							}else if(hs+lose==gs){
								str='<label>让平</label>'
							}else if(hs+lose<gs){
								str='<label>让负</label>'
							}else{
								str='<label>--</label>'
							}
						}else if(lose<0){
							
						}
						str='<label>主胜</label>'
					}else{
						
					}
					break;
				//胜胜，胜平，胜负,平胜，平平，平负，负胜，负平，负负
				case 'BQC':
					if(hhs && hgs && hhs!="" && hgs!="" && hs && gs && hs!="" && gs!=""){
						str='<label>'+hhs+':'+hgs+'</label>'
					}else{
						str='<label>--</label>'
					}
					break;
				case 'JQS':
					if(hs && gs && hs!="" && gs!=""){
						str='<label>'+(hs+gs)+'</label>'
					}else{
						str='<label>--</label>'
					}
					break;
				case 'JQS':
					if(hs && gs && hs!="" && gs!=""){
						str='<label>'+(hs+gs)+'</label>'
					}else{
						str='<label>--</label>'
					}
					break;
				}
			},
			//跟买用户列表
			followUser:function(){
				var html="";
				var data={
						"newValue":"70DG2016102562722892",
						"pn":1,
						"ps":5,
				};
				$.ajax({
					url:"/user/queryGodFollowList.go",
					data:data,
					dataType:"xml",
					success:function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						
						var baseInfo = R.find("baseInfo");
						var tmoney = baseInfo.attr("tmoney");
						var followNum = baseInfo.attr("followNum");
						$("#followInfo").html('当前'+followNum+'人已跟买，累计跟买'+tmoney+'元')
						$("#btn2").html("跟买用户("+followNum+")");
						
						var followlist = R.find("followlist");
						
						
						var followUser  = followlist.find("followUser ");
						if(followUser.length){
							followUser.each(function(i,v){
								var uid = $(this).attr("uid");
								var buymoney = $(this).attr("buymoney");
								var addtime = $(this).attr("addtime");
								var imgUrl = $(this).attr("imgUrl");
								html+='<li class="line_gray">'
								html+='<div class="div1"><img src="'+imgUrl+'"><span>'+uid+'</span></div>'
								html+='<div class="div2">'+buymoney+'元</div><div class="div3">'+addtime+'</div>'
								html+='</li>'
							})
							$("#user_list").html(html)
						}else{
							$("#user_list").html("暂无记录")
						}
					}
				})
			},
			bindEvent:function(){
				$("#reduce").bind("click",function(){
					//获取起头金额
					var averageMoney = parseInt($("#averageMoney").html());
					var val = $("#bs").val();
					val--;
					if(val<0){
						val=0
					}
					$("#bs").val(val);
					$("#pMoney").html(averageMoney*parseInt(val)+"元")
				});
				
				$("#plus").bind("click",function(){
					//获取起头金额
					var averageMoney = parseInt($("#averageMoney").html());
					var val = $("#bs").val();
					val++;
					if(val>999){
						val=999
					}
					$("#bs").val(val);
					$("#pMoney").html(averageMoney*parseInt(val)+"元")
				});
				
				
			},
			
			init: function(){
				this.gain();
				this.followUser();
				this.bindEvent();
			}
	}
	
	return o
})()

var CP = {};
var t = {}
$(".buy_btn").bind("click",function(){
	CP.Checked();	
})

var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};

var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};
/*拼凑购买弹窗需要的参数[[*/
var dopay = function(a){
				var data = {//支付弹框参数
						comboid: '70DG2016102162722740',//套餐
						gid:     70,//彩种id
						cMoney:  30,//需支付金额
						muli: $('#bs').val(),
						payUrl: '/trade/fgpcast.go'
				};
				alert('提交中，请稍后！','loading');
				CP.Popup.buybox(data);
			}
CP.Checked = function(){
	$.ajax({
		url:'/user/query.go?flag=2',
		type:'GET',
		dataType:'xml',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var isBindIdCard = R.find('row').attr('idcard');
			var isBindMobile = R.find('row').attr('mobbind');
			if(c == '0'){
				if(!isBindIdCard){
					location.href = '/alone/idcard.html';
				}else if(isBindMobile != '1'){
					location.href = '/alone/phone.html';
				}else{
					dopay();
				}
			}else{
				alert("购买套餐前请先登录账户")
				location.href = '/#type=fun&fun=CP.Home.openLogin'
			}
		},error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}

CP.info=function(){
	$.ajax({
		url:'/user/query.go?flag=6',
		type:'GET',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			if(c == '0'){
				var r = R.find('row');
				t.usermoney = r.attr('usermoeny');//余额
				t.ipacketmoney = r.attr('ipacketmoney');//红包余额
			}
		},
		error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	});
}()
/*
 * 弹窗类
 */
CP.Popup = {
		/*
		 * 购买弹窗
		 */
		buybox : function(options){
			var o = {//弹窗的参数初始化
					comboid:       '',
					gid:           '',//彩种id 不可空
					muli: 		   '',
					cMoney:        '',//需支付金额 不可空
					bonus:         '',//理论奖金
					usermoney:     '',//账户余额 不可空
					payPara:		'',
			};
			if (options) {
				o.usermoney = parseFloat(t.usermoney);
				jQuery.extend(o, options);//后面补充前面不足
			} else {
				alert('参数获取异常！');
				return
			}
			if(!o.gid || !o.cMoney || !o.usermoney){
				alert('参数获取失败请刷新重试');
				return
			}
			var main = function(o){
				var tag = true;//是否充值的标识 默认去充值
				o.cMoney = parseFloat(o.cMoney);
				if (o.usermoney>=o.cMoney) {//余额不足的时候显示去充值
					tag = false;
					$('#buy_box .zfTrue a:eq(1)').hide().siblings().show();
				} else {
					$('#buy_box .zfTrue a:eq(2)').hide().siblings().show();
				}
				$('#buy_reveal p:eq(0) cite').html(o.cMoney+'元');//初始化投注金额
				if(o.bonus){//如果是竞彩显示奖金范围
					$('#buy_reveal p:eq(1)').hide();
				}else{
					$('#buy_reveal p:eq(1)').hide();
				}
				remove_alert();
				$('#buy_reveal p:eq(2) cite').html(o.usermoney+'元');//初始化余额
				$('.zfpop,#mask').show();//弹支付框
				$('#buy_box').animate({'margin-top':'-'+$('#buy_box').height()/2+'px'});//使层垂直居中
				$('.zfTrue a:eq(0)').off('click').on('click',function(){//取消按钮
					$('.zfpop,#mask').hide();
				})
				$('.zfTrue a:eq(1)').off('click').on('click',function(){//充值按钮
					window.location.href='/#type=url&p=user/charge.html';
					$('.zfpop,#mask').hide();
				})
				$('.zfTrue a:eq(2)').off('click').on('click',function(){//确定按钮
					$('.zfpop,#mask').hide();
					CP.Pay.init(o);//支付方法
				})
			}
			main(o);
		}
};
//支付
CP.Pay = function () {
	var init = function (opt) {
		var data = {};
			data = {
					"hid":   opt.comboid,//套餐
					"gid":     opt.gid,//彩种编号
					"money":    opt.cMoney,//号码
					'muli':     opt.muli
			};
		$.ajax({
			url: opt.payUrl,
			type:'POST',
			data: data,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
						var projid = '';
						var r;
						r = R.find('row');
						projid = r.attr('tid');//方案编号
						location.href='/#type=url&p=user/success.html?projid='+projid;
				}else{
					alert(desc);
				}
			}
		});
	};
	return {
		init: init
	};
}();
SD.init();