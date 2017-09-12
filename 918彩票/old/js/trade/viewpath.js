/*
* viewpath.js v0.1
* based on jquery-1.9.1
* Author: weige
* Date : 2014-04-10
*/ 

$_sys.grade_def = [];
$_sys.grade_def.push([ 80, "一等奖,二等奖" ]);
$_sys.grade_def.push([ 81, "一等奖" ]);
$_sys.grade_def.push([ 82, "一等奖" ]);
$_sys.grade_def.push([ 83, "一等奖" ]);

$_sys.grade_def.push([ 01, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖" ]);
$_sys.grade_def.push([ 03, "直选,组选三,组选六" ]);
$_sys.grade_def.push([ 04, "五星奖,三星奖,二星奖,一星奖,大小单双,二星组选,五星通选一等奖,五星通选二等奖,五星通选三等奖" ]);
$_sys.grade_def.push([ 05, "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号" ]);
$_sys.grade_def.push([ 06, "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号" ]);
$_sys.grade_def.push([ 07, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,七等奖" ]);
$_sys.grade_def.push([ 08, "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号" ]);
$_sys.grade_def.push([ 09, "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号" ]);
$_sys.grade_def.push([ 20, "五星奖,四星一等奖,四星二等奖,三星奖,二星奖,一星奖,大小单双,二星组选,五星通选一等奖,五星通选二等奖,五星通选三等奖,任选一,任选二,三星组三,三星组六" ]);

$_sys.grade_def.push([ 50, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,七等奖,八等奖,生肖乐,追加一等奖,追加二等奖,追加三等奖,追加四等奖,追加五等奖,追加六等奖,追加七等奖,,宝钻一等奖,宝钻二等奖,宝钻三等奖,宝钻四等奖"]);
$_sys.grade_def.push([ 501, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,追加一等奖,追加二等奖,追加三等奖,追加四等奖,追加五等奖,,,,,,"]);

$_sys.grade_def.push([ 51, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖" ]);
$_sys.grade_def.push([ 52, "一等奖" ]);
$_sys.grade_def.push([ 53, "直选,组三,组六" ]);
$_sys.grade_def.push([ 54, "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选" ]);
$_sys.grade_def.push([ 55, "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选" ]);
$_sys.grade_def.push([ 56, "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选" ]);
$_sys.grade_def.push([ 57, "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选" ]);
$_sys.grade_def.push([ 58, "任选一,任选二,任选三,任选四,任选五,任选六,同花,同花顺,顺子,豹子,对子,同花包选,同花顺包选,顺子包选,豹子包选,对子包选" ]);

$_sys.getgrade = function(f, n) {
	if (typeof (n) == 'undefined') {
		n = 1;
	};
	for ( var i = 0; i < $_sys.grade_def.length; i++) {
		if ($_sys.grade_def[i][0] == f) {
			return $_sys.grade_def[i][n].split(",");
		}
	}
};
$_sys_getwininfo = function(lotid, wininfo,pid) {
	var tmp = [];
	if (lotid==85||lotid==86||lotid==87||lotid==88||lotid==89 || lotid == 84
			||lotid==90
			||lotid==91
			||lotid==92
			||lotid==93||lotid==94||lotid==95||lotid==96||lotid==97||lotid==70||lotid==71||lotid==72||lotid==99||lotid==98
			){		
		wininfo = wininfo.split("|");
		if (wininfo.length>=3){
			tmp.push([ "", "共"+wininfo[1]+"场, "+(lotid==99||lotid==98 ? '单关':wininfo[2].replace(/\*/g, "串").replace(/1串1/g,"单场"))+", 中"+wininfo[0]]);
		}		
	}else{
		if(wininfo.length > 0){
			wininfo = wininfo.split(",");
			var aa = lotid;
			if(lotid == 50 && parseInt(pid)>=2014052){
				aa = 501;
			}
			var grade = $_sys.getgrade(aa);
			if (wininfo.length > 0 && wininfo.length <= grade.length) {
				for ( var i = 0; i < wininfo.length; i++) {
					if (wininfo[i] > 0) {
						tmp.push([ grade[i], wininfo[i] ]);
					}
				}
			}
		}
	}	
	return tmp;
};

var $_lotid = decodeURIComponent(CP.Util.getParaHash("lotid"));
var $_projid = decodeURIComponent(CP.Util.getParaHash("projid"));
var $_cnickid = '';//发起人
var $_nickid = '';//当前用户
var chedan = '1';//是否是撤单方案
var arrItemid=[];
$(function(){
	$("#payment").attr("href",'#class=url&xo='+$_sys.getlotdir($_lotid).substr(1)+'index.html');
	if(document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
		bodyTag = document.getElementsByTagName('body')[0];
		bodyTag.style.height = document.documentElement.clientWidth / screen.width * screen.height + 'px';
	}
	setTimeout(function() {
		window.scrollTo(0, 1);
	}, 0);
	if ($_lotid == "" || $_projid == "") {
		if (history.length == 0) {
			window.opener = "";
			window.close();
		} else {
			window.location.href='/';
		}
		return false;
	}
	$('.backIco2').bind('click',function(){
		var cf=location.search.getParam('share');
		if (cf=="Android" || cf=="ios") {
			window.location.href='/';
		} else {
			history.go(-1);
		}
	});
	$.ajax({
        url: $_user.url.base+"&rnd=" + Math.random(),
        dataType : "xml",
        success:function (data){
        	var R = $(data).find("Resp");
        	var U = R.find("row");
        	$_nickid = U.attr("nickid");
			WW.showview($_lotid,$_projid);
        }
	});
	share();
	
	if($_lotid==70||$_lotid==72||$_lotid==80||$_lotid==81||$_lotid==82||$_lotid==83||$_lotid==85||$_lotid==86||$_lotid==87||$_lotid==88||$_lotid==89||$_lotid==90||$_lotid==91||$_lotid==92||$_lotid==93){
		$("#bf").show()
	}else{
		$("#bf").hide()
	}
});
function share(){
	$('.share').click(function(){
		if(localStorage.getItem('from') == 'wxfw'){
			$('#invite_friend_xy,#invite3').show();
		}else{
			$('#ww_share').css({left:parseInt(document.documentElement.clientWidth/2-$("#ww_share").width()/2),top:parseInt(document.documentElement.clientHeight/2-$("#ww_share").height())});
			$('#ww_share').show();
			$('#zhezhao').show();
		}
	});
	$('#ww_ok,#zhezhao').click(function(){
		$('#ww_share').hide();
		$('#zhezhao').hide();
	});
	$('#invite_friend_xy,#invite3').click(function(){
		$('#invite_friend_xy,#invite3').hide();
	});
	
	$("#bf").bind("click",function(){
		
		if($_lotid==83||$_lotid==84||$_lotid==85||$_lotid==86||$_lotid==87||$_lotid==88||$_lotid==89){
			var $tr = $("#tcont tbody tr:even");
			var pid = $tr.eq(0).attr("pid");
			$tr.each(function(){
				var id = $(this).attr("id");
				arrItemid.push(id);
			})
			
			arrItemid.unshift(pid);
			localStorage.setItem("bdjsbf", JSON.stringify(arrItemid));
			window.location.href="/bdjsbf/pub.html";
		}else if($_lotid==70||$_lotid==72||$_lotid==90||$_lotid==91||$_lotid==92||$_lotid==93){
			//var $tr = $("#clasli div:eq(0) table.lcbetTable tbody tr:even");
			var $tr = $("#tcont tbody tr:even");
			$tr.each(function(){
				var id = $(this).attr("id");
				arrItemid.push(id);
			})
			localStorage.setItem("jsbf", JSON.stringify(arrItemid));
			window.location.href="/jsbf/pub.html";
		}else{
			return;
		}
	})
}
var WW = {
		showview:function(lotid,projid){
			var data = '';
			data = "gid=" + encodeURIComponent(lotid) + "&hid=" + encodeURIComponent(projid) + "&state=1&rnd=" + Math.random();
			$.ajax({
				url : $_trade.url.pinfo,
				type : "POST",
				dataType : "xml",
				data : data,
				success : function(xml) {
					$('.loading').hide();
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if (code == "0") {
						var r = R.find("row");
						var q = R.find("qcode");
						var J = R.find("jindu");
						var myjoins = R.find("myjoins");//发起人的的认购记录
						var myjoin = myjoins.find("myjoin");
						var myleng = myjoin.length;
						var kjtime = J.attr("kjtime");// 预计开奖时间
						var gid = r.attr("gid");// 游戏编号
						var hid = r.attr("hid") ;// 方案编号
						var itype = r.attr("type");// 方案类型（0 自购 1 合买）
						var icast = r.attr("cast");// 出票标志（0 未出票 1 可以出票 2 已拆票 3 已出票）
						var award = r.attr("award");// 计奖标志（0 未计奖 1 正在计奖 2 已计奖)
						var pid = r.attr("pid");// 期次
						var ireturn = r.attr("return");//是否派奖（0 未派奖 1 正在派 2 已派奖）
						var wininfo = r.attr("wininfo");// 中奖信息（中奖注数用逗号隔开）
						var owins = r.attr("owins");// 发起人提成奖金
						var rmoney = r.attr("rmoney");// 认购派奖金额（税前）
						var cnickid = r.attr("cnickid");// 发起人 屏蔽手机号
						var rnickid = r.attr("rnickid");
						$_cnickid=rnickid; 
						var mulity = r.attr("mulity");// 倍数
						var lnum = parseInt(r.attr("lnum"));// 剩余份数
						var pnum = parseInt(r.attr("pnum"));// 发起人保底份数
						var aunum = r.attr("aunum");// 等级（战绩）
//						var iorder = r.attr("iorder");// 置顶标志
						var jindu = r.attr("jindu");// 发单人认购的进度
						var views = r.attr("views");// 跟单人数
//						var cname = r.attr("cname");// 合买名称
						var cdesc = r.attr("cdesc");// 方案宣言
						var ccodes = r.attr("ccodes");// 投注号码
						var acode = q.attr("acode");// 开奖号码
						var etime = r.attr("etime");// 截止时间
//						var play = r.attr("iplay");// 玩法（0单式 1复式）
						var ifile = r.attr("ifile");// 是否文件投注（0不是 1 是）
						var tmoney = r.attr("tmoney");// 总金额
						var iopen = r.attr("iopen");// 是否保密 （0 对所有人公开 1 截止后公开 2 对参与人员公开 3 截止后对参与人公开）
						var wrate = r.attr("wrate");// 发起人盈利提成
						var istate = r.attr("istate");//状态  0该方案自动跟单中，请等待 1认购中 2已满员  3系统已撤单 4发起人已撤单 5系统已撤单 -1未支付
//						var jiesuan = r.attr("jiesuan");//结算标志 0 未结算 1正在结算 2 已结算
						var rpmoney = r.attr("rpmoney");//红包认购金额
//						var rprgmoney = r.attr("rprgmoney");//红包认购关联金额
//						var wininfostr = r.attr("wininfostr");//投注描述
						var avg = r.attr("avg");//每元派奖金额
						var tax = r.attr("tax");//税后奖金
						var btime = r.attr("btime");//发单时间
						var source = r.attr("source");//奖金优化6  单关配7  混投合买2串1 8  
//						var addmoney = r.attr("addmoney");//发起人加奖金额
						if(itype == 1){//合买
							$("#bf").hide();
							chedan = (istate==3||istate==4||istate==5)? 3:1;
							$("#hemai").show();
							$("#zigou").hide();
							$("#pType").html('合买详情');
							document.title = '彩票合买详情'
							$('#authority cite').html($_sys.iopen[parseInt(iopen,10)]);
							$('#gType').html($_sys.getlotname(gid));
							$('#gType').html($_sys.getlotname(gid));
							$('#expect').html(pid+'期');
							$('#uName').html(cnickid);
							$('#rank').html('L'+aunum);
							$('#rg').html(jindu+'%');
							$('#bd').html('保&nbsp;'+Math.floor(pnum/tmoney*100)+'%');//向下取整 避免出现保底+认购大于100%显示未满员
							$('#rgDetail').html('总额<em class="yellow">'+tmoney+'元</em>(保底'+pnum+'元，提成'+wrate+'%)');
							$('#surplus').html('剩余<em class="yellow">'+lnum+'元</em>');
							$('#tDetail').html('<p>编号 :'+hid+'</p><p>时间 : '+btime+'</p>');
							$('#cdesc').html(cdesc = cdesc == "null" ? "快乐购彩" : "方案宣言:"+cdesc);
							$('#views').html(views+'人');
							$("#bd").val(pnum);
							var baodi = '';
							if($_nickid == $_cnickid && istate == 1){
								$('.buyFooter a').html('继续购买');
								$('#cancelD').show();
								if(itype == 1){
									if(istate > 0 && istate < 2){
										if(($_nickid == $_cnickid) && istate != 0){
											if(pnum == 0){
												baodi = '<a class="fqhm" href="javascript:;" onclick=\'baodi('+lnum+')\'>追加保底</a>';
											}else{
												baodi = '<a class="fqhm" href="javascript:;" onclick=\'torg()\'>保底转认购</a>';
											}
										}
									}
								}
							}
							$('#ww_bdi').append(baodi);
							$('.hmbuyInput').keyup(function(){
								var val = $('.hmbuyInput').val();
								//this.value=this.value.replace(/\D/g,'');
								if($(this).val()>lnum){
									$(this).val(lnum);
								}
								var reg = /^\d*$/;
								if( !reg.test(val)){
									$('.hmbuyInput').val("1");
						        }
								if(val.indexOf("0")==0){
									$('.hmbuyInput').val("1");
								}
							});
							$('.hmbuyInput').blur(function(){
								if($(this).val()==''||$(this).val()=='0'){
									$(this).val(1);
								}
							});
							$('#iPay').click(function(){
								var buy = $('.hmbuyInput').val().replace(/(\s*$)/g,'');
								if(buy != '' && buy != undefined){
									checkLogin(function(){
										location.href = '#class=url&xo=viewpath/payment.html&hid='+$_projid+'&rm='+buy;
									},'#class=url&xo=viewpath/payment.html&hid='+$_projid+'&rm='+buy);
								}
							});
							var kj = 0;
							kj = WW.isKj(award, btime);
							var isflg = 0;
							if(istate>0){
								isflg = (icast == 3) ? (istate > 2 ? 1 : 5) : (istate > 2 && istate<6) ? 1 : (icast == 2) ? 2 : 3; //出票状态5
								isflg = (kj == 1) ? ((isflg == 5) ? 6 : isflg ) : isflg; //开奖状态6
								isflg = (award == 2) ? ((isflg == 6) ? 7 : isflg ) : isflg;//计奖状态7
								isflg = (ireturn == 2) ? ((isflg == 7) ? 12 : isflg) : (ireturn == 1) ? ((isflg == 7)? 8 : isflg) : isflg; // 派奖中、已派奖
							}else{
								if(istate=="0"){
									isflg = 14;
								}else{
									isflg = 13;
								}
							}
							$('.buyFooter').hide();
							$('.buyFooter1').show();
							switch (isflg) {
								case 1://撤单
									$("#s_paint").show();
									$("#f_paint").css("width","2.2rem");
									$("#s_paint").html("已撤单");
									$("#s_paint").css("left","1rem");
									break;
								case 2://出票中2
									$("#s_paint").show();
									$("#f_paint").css("width","4.5rem");
									$("#s_paint").html("出票中");
									$("#s_paint").css("left","3rem");
									$('.buyFooter').show();
									$('.buyFooter1').hide();
									break;
								case 3://等待出票3
									$("#s_paint").show();
									$("#f_paint").css("width","3.5rem");
									$("#s_paint").html("等待出票");
									$("#s_paint").css("left","2rem");
									$('.buyFooter').show();
									$('.buyFooter1').hide();
									break;
								case 5://出票成功5
									$("#f_paint").css("width","6.9rem");
									if(lnum >0 ){
										$('.buyFooter').show();
										$('.buyFooter1').hide();
									}
									break;
								case 6://已开奖6
									$("#f_paint").css("width","12.9rem");
									break;
								case 7://已计奖7
									$("#s_paint").show();
									$("#f_paint").css("width","15.5rem");
									$("#s_paint").html("已计奖");
									$("#s_paint").css("left","14rem");
									break;
								case 8://派奖中8
									$("#s_paint").show();
									$("#f_paint").css("width","16.5rem");
									$("#s_paint").html("派奖中");
									$("#s_paint").css("left","15rem");
									break;
								case 12://已派奖12
									$("#f_paint").css("width","18.9rem");
									break;
								case 13://未支付
									$("#s_paint").show();
									$("#f_paint").css("width","1.5rem");
									$("#s_paint").html("未支付");
									$("#s_paint").css("left","0rem");
									break;
								case 14://自动跟单中
									$("#s_paint").show();
									$('.buyFooter').hide();
									$('.buyFooter1').show();
									$("#f_paint").css("width","1.5rem");
									$("#s_paint").html("处理中");
									$("#s_paint").css("left","0rem");
									break;
								default://发起0
									$("#s_paint").show();
									$("#f_paint").css("width","2.5rem");
									$("#s_paint").html("已发起");
									$("#s_paint").css("left","1rem");
									break;
							}
							$('#kjCodes').show();
							if(acode == undefined){
								$('#kjCodes').hide();
							}else{
								if(isflg == 1){
									if(acode == ''){
										acode = '未开奖';
									}
								}else{
									if(acode != ''){
										acode = WW.kjcode(acode,gid);
									}else{
										if(gid == '01' || gid == '07'||gid == '50' || gid == '03' || gid == '53' || gid == '51' || gid == '52'){
											acode += '<cite class="gray fontSize07 pdLeft06"> '+kjtime+'开奖</cite>';
										}else{
											acode = '等待开奖';
										}
									}
								}
								$('#kjCodes span').html(acode);
							}
						 if (award == "2") {//合买中奖情况
							var wininfostr = "";
							if (rmoney > 0) {
								if (istate == 3 || istate == 4) {
									wininfostr = "<font class='yellow'>该撤单方案中奖"+parseFloat(rmoney)+"元</font>";
								} else {
									wininfostr = "<font class='yellow'>此方案共中奖"+rmoney+"元</font>";
								}
								wininfostr += "<br/>("
									+ "税前<font class='yellow'>"
									+ parseFloat(rmoney)
									+ "元</font>,税后<font class='yellow'>"
									+ parseFloat(tax)+"元</font>)";
								var zj = $_sys_getwininfo(gid,wininfo,pid);
								for ( var i = 0; i < zj.length; i++) {
									wininfostr += "<br/>" + zj[i][0]
											+ " " + zj[i][1] + "注";
								}
								if (itype == 1 && istate != 3&& istate != 4) {
									wininfostr += "<br />发起人提成:"
											+ parseFloat(owins)
											+ "元,每元中"
											+ parseFloat(avg)
											+ "元";
								}
							} else {
								wininfostr += "未中奖";
							}
							$("#zjSituation").show();
							$('#zjSituation span').html(wininfostr);
						} else {
							$("#zjSituation").hide();
						} 
							$('#authority').bind('click',function(){
								if(iopen == 0){
									if(ifile == 0){
										window.location.href = '#class=url&xo=viewpath/content.html&lotid='+gid+'&projid='+hid;
									}else{
										if(ccodes != ''){
											window.location.href = '#class=url&xo=viewpath/content.html&lotid='+gid+'&projid='+hid;
										}else{
											D.alert('方案未上传，无法查看');
										}
									}
								}else{
									if(ccodes != ''){
										window.location.href = '#class=url&xo=viewpath/content.html&lotid='+gid+'&projid='+hid;
									}else{
										if(iopen == 2){
											if(myleng != 0 && ifile =='1'){
												D.alert('方案未上传，无法查看');
											}else{
												D.alert('您不是跟单用户，无法查看此方案');
											}
										}else if(iopen == 3){
											if(myleng != 0){
												D.alert('方案未截止，无法查看');
											}else{
												D.alert('您不是跟单用户，无法查看此方案');
											}
										}else if(iopen == 1){
											D.alert('方案未截止，无法查看');
										}
									}
								}
							});
						}else{//代购
							$("#pType").html('自购详情');
							document.title = '彩票自购详情'
							$("#hemai").hide();
							$("#zigou").show();
							if(acode == undefined){
								if(lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89){
									$('#zigou p').eq(1).html($_sys.getlotname(gid)+'&nbsp;<cite class="fontSize07 pdLeft06">第'+pid+'期</cite>');
								}else{
									$('#zigou p').eq(1).html($_sys.getlotname(gid));
								}
							}else{
								$('#zigou p').eq(1).html($_sys.getlotname(gid)+'&nbsp;<cite class="fontSize07 pdLeft06">第'+pid+'期</cite>');
							}
							$('#zgDetail p:eq(0) em').html(hid);
							$('#zgDetail p:eq(1) em').html(btime);
							var hb = '';
							if(rpmoney>0){
								hb = '含'+rpmoney+'元红包 ';
							}
							$('#faje span').html(tmoney+'元&nbsp;('+hb+mulity+'倍 )');//含'+rpmoney+'元红包  
							
							var kj = 0;
							kj = WW.isKj(award, btime);
							var isflg = 0;
							if(istate>0){
								isflg = (icast == 3) ? (istate > 2 ? 1 : 5) : (istate > 2 && istate<6) ? 1 : (icast == 2) ? 2 : 3; //出票状态5
								isflg = (kj == 1) ? ((isflg == 5) ? 6 : isflg ) : isflg; //开奖状态6
								isflg = (award == 2) ? ((isflg == 6) ? 7 : isflg ) : isflg;//计奖状态7
								isflg = (ireturn == 2) ? ((isflg == 7) ? 12 : isflg) : (ireturn == 1) ? ((isflg == 7)? 8 : isflg) : isflg; // 派奖中、已派奖
							}else{
								if(istate=="0"){
									isflg = 14;
								}else{
									isflg = 13;
								}
							}
							$('#s_paint_zg').hide();
							switch (isflg) {
								case 1://撤单
									$('#s_paint_zg').css("left","0.7rem");
									$('#s_paint_zg').html('撤单');
									$('#s_paint_zg').show();
									$("#f_paint_zg").css("width","2.2rem");
									break;
								case 2://出票中2
									$('#s_paint_zg').css("left","3rem");
									$('#s_paint_zg').html('出票中');
									$('#s_paint_zg').show();
									$("#f_paint_zg").css("width","4.5rem");
									break;
								case 3://等待出票3
									$('#s_paint_zg').css("left","2rem");
									$('#s_paint_zg').html('等待出票');
									$('#s_paint_zg').show();
									$("#f_paint_zg").css("width","3.5rem");
									break;
								case 5://出票成功5
									$("#f_paint_zg").css("width","6.9rem");
									break;
								case 6://已开奖6
									$("#f_paint_zg").css("width","12.9rem");
									break;
								case 7://已计奖7
									$("#f_paint_zg").css("width","15.5rem");
									break;
								case 8://派奖中8
									$('#s_paint_zg').css("left","15rem");
									$('#s_paint_zg').html('派奖中');
									$('#s_paint_zg').show();
									$("#f_paint_zg").css("width","16.5rem");
									break;
								case 12://已派奖12
									$("#f_paint_zg").css("width","18.9rem");
									break;
								case 13://未支付
									$('#s_paint_zg').css("left","0rem");
									$('#s_paint_zg').html('未支付');
									$('#s_paint_zg').show();
									$("#f_paint_zg").css("width","1.5rem");
									break;
								case 14://自动跟单中
									$("#f_paint_zg").css("width","1.5rem");
									break;
								default://发起0
									$("#f_paint_zg").css("width","2.5rem");
									break;
							}
							if(acode == undefined){
								$('#zgCode').hide();
							}else{
								if(isflg == 1){
									if(acode == ''){
										$('#zgCode').hide();
									}
								}else{
									$('#zgCode').show();
									
									
									if(acode != ''){
										if(lotid=='58'){
											acode = code_58(acode);
										}else{
											acode = WW.kjcode(acode,lotid);
										}
									}else{
										if(gid == '01' || gid == '07'||gid == '50' || gid == '03' || gid == '53' || gid == '51' || gid == '52'){
											acode += '<cite class="gray fontSize07 pdLeft06"> '+kjtime+'开奖</cite>';
										}else{
											acode = '等待开奖';
										}
									}
									
									$('#zgCode span').html(acode);
								}
							}
							if (award == "2") {//自购中奖情况
								var wininfostr = "";
								if (rmoney > 0) {
									if (istate == 3 || istate == 4) {
										wininfostr = "<font class='yellow'>该撤单方案中奖"+parseFloat(rmoney)+"元</font>";
									} else {
										wininfostr = "<font class='yellow'>已中奖</font>";
									}
									wininfostr += "<br/>("
										+ "税前<font class='yellow'>"
										+ parseFloat(rmoney)
										+ "元,</font>税后<font class='yellow'>"
										+ parseFloat(tax)+"元</font>)";
									var zj = $_sys_getwininfo(gid,wininfo,pid);
									for ( var i = 0; i < zj.length; i++) {
										wininfostr += "<br/>" + zj[i][0]
												+ " " + zj[i][1] + "注";
									}
									if (lotid == 90&& r.attr("addmoney") > 0) {
										wininfostr += "发起人加奖金额：<font color=red>"
												+ parseFloat(r.attr("addmoney")).rmb(true)
												+ "</font>.";
									}
									if (itype == 1 && istate != 3&& istate != 4) {
										wininfostr += "发起人提成：<font color=red>"
												+ parseFloat(owins).rmb(true)
												+ "</font>,每元派送<font color=red>"
												+ parseFloat((tax - owins)/ nums).rmb(true)
												+ "</font>.";
									}
								} else {
									wininfostr += "未中奖";
								}
								$("#zgzjSituation").show();
								$('#zgzjSituation span').html(wininfostr);
							} else {
								$("#zgzjSituation").hide();
							}
							var lo = ['01','50','81','80','54','20','56','58','06','84','70','72',
							          '90','91','71','94','95','97','85','86','89'];
							if(lo.indexOf($_lotid) >= 0){
								$('.buyFooter1').show();//自购去投注
							}
							if (ifile=="0"){
								//北单竞彩显示对阵 篮彩显示对阵
								if(lotid==84 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89 || lotid==90 ||lotid==91 ||lotid==92 ||lotid==93 || lotid == 70 || lotid == 72
										||lotid==94 ||lotid==95 ||lotid==96 ||lotid==97 || lotid==71
								
								){
									$("#zgCode").hide();
									$("#zgContent").hide();
									$('#clasli').show();
									WW.bd_jc_clasli(lotid,pid,hid,ccodes,source);
								}
								//老足彩显示对阵
								else if(lotid==80 ||lotid==81 ||lotid==82 ||lotid==83){
									$("#zgCode").hide();
									$("#zgContent").hide();
									$('#clasli').show();
									WW.lzc_clasli(lotid,pid,ccodes);
								}
								//冠亚军
								else if(lotid == "99" || lotid == "98"){
									$("#zgCode").hide();
									$("#zgContent").hide();
									$('#clasli').show();
									WW.gyj_clasli(lotid,pid,hid,ccodes);
								}
								else{
									$('#clasli').hide();
									var html = $_sys.showcode(gid,ccodes);
									html = html.replace(/pdTop06/g,'');
									$('#zgContent div').html(html);
									if(lotid=="01" || lotid=="50" || lotid=="03" || lotid=="53"){
									}			
								}
							}else if(ifile=="1"){
								$("#zgCode").hide();
								
								if(source == 6 || source == 7){//奖金优化
									$("#zgContent div").html('奖金优化方案&nbsp;<a href="#class=url&xo=viewpath/content.html&lotid='+lotid+'&projid='+hid+'">点击查看</a>');
									$('#clasli').show();
									WW.jjyh(lotid,pid,hid,ccodes);
								}
								else{
									$("#zgContent div").html('单式上传方案&nbsp;<a href="#class=url&xo=viewpath/content.html&lotid='+lotid+'&projid='+hid+'">点击查看</a>');
								}
							}
						}
					}else{
						D.alert(desc);
						history.go(-1);
					}
				}
			});
		},
		jjyh:function(lotid,expect,projid,codes){
			$('.buyFooter1').hide();
			if((lotid==90 || lotid==70 || lotid==72 || lotid==91 || lotid==92 || lotid==93) && parseInt(expect)>=20130514){
				var yhfile = codes.replace("_n.txt","_yh.xml");
				try {
				var data = "gid=" + lotid + "&hid="+projid;
				$.ajax({
					type : 'GET',
					data : data,
					dataType : "xml",
					url : '/data/pupload/'+lotid+'/'+expect+'/'+yhfile,
					success : function(data) {
						var X = $(data).find("xml");
						var row = X.find('row');
						var mx = row.attr('code');//投注明细
						var matchs = row.attr('matchs');//投注选项
						$.ajax({
							url : "/data/guoguan/" + lotid + "/" + expect + "/proj/" + projid.toLowerCase() + ".xml",
							type : "GET",
							dataType : "xml",
							cache : false,
							success : function(xml) {
								var R = $(xml).find("items");
								var wk=["日","一","二","三","四","五","六"];
								var r = R.find("item");
								var html = '';
								var html2 = '';
								html = '<div><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTitle mgTop06"><tr>';
								html += '<td width="15%">场次</td><td width="70%">主队VS客队/投注选项</td><td width="15%" style="border-right:none">比分</td>';
								html += '</tr></table>';
								html += '<table id="tcont" width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTable">';
								var num = [];
								var name = [];
								r.each(function(aa){
									var hs = $(this).attr("hs");//
									var vs = $(this).attr("vs");//
									var hhs = $(this).attr("hhs");//
									var hvs = $(this).attr("hvs");//
									var quan = '',ban = '';
									if(hs != '' && vs != ''){
										quan = '全'+hs+':'+vs;
									}
									if(hs != '' && vs != ''){
										ban = '半'+hhs+':'+hvs;
									}
									var hsstr =  $(this).attr("hs").trim();
									var c = $(this).attr("cancel");
								    var spvalue = $(this).attr("spvalue");// 出票参考SP
								    var spvalues = spvalue.split("|");
								    rqspvalue = spvalues.length==1 ? spvalue:spvalues[0];
								    bfspvalue = spvalues.length==1 ? spvalue:spvalues[1];
								    bqcspvalue = spvalues.length==1 ? spvalue:spvalues[2];
								    jqsspvalue = spvalues.length==1 ? spvalue:spvalues[3];
								    spfspvalue = spvalues.length==1 ? spvalue:spvalues[4];
								    
								    rqspvalue = rqspvalue.split(',');//让球胜平负
								    bfspvalue = bfspvalue.split(',');
								    bqcspvalue = bqcspvalue.split(',');
								    jqsspvalue = jqsspvalue.split(',');
								    spfspvalue = spfspvalue.split(',');
									var hn="";
									var vn="";
									hn = $(this).attr("hn");//主队
									vn = $(this).attr("vn");//客队
									var lose = $(this).attr("lose");//让分
									var id = $(this).attr("id");//id
									var id2 = id.substring('6','9'); //场次
									var tDATE="20"+id.substr(0,2)+"-"+id.substr(2,2)+"-"+id.substr(4,2);
									tDATE = new Date(tDATE);
									var wk2 = '周'+wk[tDATE.getDay()];
									var rq = '';
									if(lose!=0 && lose!="" && (lotid == "90" || (lotid == "70"&&matchs.indexOf("RQSPF")>=0))){
										if(lose.indexOf('-')!=-1){
											rq="(<font color='green'>"+lose+"</font>)";
										}else{
											rq="(<font color='red'>"+lose+"</font>)";
										}
									}
									html += '<tr id="'+id+'"><td '+(aa==0?"width='15%'":"")+' rowspan="2">'+wk2+'<br>'+id2+'</td>';
									html += '<td '+(aa==0?"width='70%'":"")+'>'+hn+rq+'<em class="fontSize07">VS</em>'+vn+'</td>';
									html += '<td '+(aa==0?"width='15%'":"")+' rowspan="2" class="r9last">'+ban+'<br/>'+quan+'</td></tr>';
									num[aa] = id;
									name[aa] = hn;
									var result = '',rqresult = '',jqresult = "",bqcresult = "",bfresult = "";
									if(c == 0){
										hs = parseInt(hs);
										vs = parseInt(vs);
										if(hsstr.length > 0){//胜平负
											var rt=(hs-vs)*1;
											if(rt*1>0){result="3";}else if(rt*1==0){result="1";}else{result="0";}
										}else{
											result = "";
										}
										if(hsstr.length > 0){//让球胜平负
											var rt=(hs-vs)*1+(lose)*1;
											if(rt*1>0){rqresult="3";}else if(rt*1==0){rqresult="1";}else{rqresult="0";}
										}else{
											rqresult = "";
										}
										if(hsstr.length>0){//jqs
											var rt=(hs+vs)*1;
											if(rt>=7){jqresult=7;}else{jqresult=rt;}
										}else{
											jqresult = "";
										}
										if(hsstr.length>0){//bqc
											var hrt=(hhs-hvs)*1;
											var rt=(hs-vs)*1;
											if(hrt*1>0){bqcresult="3";}else if(hrt*1==0){bqcresult="1";}else{bqcresult="0";}
											if(rt*1>0){bqcresult=bqcresult+"-3";}else if(rt*1==0){bqcresult=bqcresult+"-1";}else{bqcresult=bqcresult+"-0";}
										}else{
											bqcresult = "";
										}
										if(hsstr.length>0){//cbf
											bfresult = hs+":"+vs;
										}else{
											bfresult = "";
										}
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									var code = '';
									if(matchs.indexOf('|')>=0){//混投
										code = matchs.split('|')[1].split(',');
										for(var i=0;i<code.length;i++){
											var cc = code[i].split(">");
											if( id == cc[0]){
												
												var dd = cc[1].split('+');
												for(var q = 0; q<dd.length; q++){
													var ee = dd[q].split('=');
													var touzhu = '';
													if(ee[0] == 'SPF'){
														touzhu = ee[1].split('/');
														for(var j=0;j<touzhu.length;j++){
															var oracle2 = touzhu[j].replace("3","胜").replace("1","平").replace("0","负");
															var ii = touzhu[j].replace("0","2").replace("3","0");
															if(result != ""){
																if(touzhu[j] == result){
																	html += '<span><em class="yellow">'+oracle2+'</em>('+spfspvalue[ii]+')</span>';
																}else{
																	html += '<span>'+oracle2+'('+spfspvalue[ii]+')</span>';
																}
															}else{
																html += '<span>'+oracle2+'('+spfspvalue[ii]+')</span>';
															}
														}
													}else{
														touzhu = ee[1].split('/');
														for(var j=0;j<touzhu.length;j++){
															var oracle2 = touzhu[j].replace("3","让胜").replace("1","让平").replace("0","让负");
															var ii = touzhu[j].replace("0","2").replace("3","0");
															if(result != ""){
																if(touzhu[j] == rqresult){
																	html += '<span><em class="yellow">'+oracle2+'</em>('+rqspvalue[ii]+')</span>';
																}else{
																	html += '<span>'+oracle2+'('+rqspvalue[ii]+')</span>';
																}
															}else{
																html += '<span>'+oracle2+'('+rqspvalue[ii]+')</span>';
															}
														}
														
													}
												}
											}
										}
									}else{
										var wf = mx.split('|')[0];
										code = matchs.split('/');
										if(wf == "SPF"){//胜平负
											for(var i=0;i<code.length;i++){
												var cc = code[i].split("[");
												if( id == cc[0]){
													var touzhu = cc[1].substr(0,(cc[1].length-1)).split(',');
													for(var j=0;j<touzhu.length;j++){
														var oracle2 = touzhu[j].replace("3","胜").replace("1","平").replace("0","负");
														var ii = touzhu[j].replace("0","2").replace("3","0");
														if(result != ""){
															if(touzhu[j] == result){
																html += '<span><em class="yellow">'+oracle2+'</em>('+spfspvalue[ii]+')</span>';
															}else{
																html += '<span>'+oracle2+'('+spfspvalue[ii]+')</span>';
															}
														}else{
															html += '<span>'+oracle2+'('+spfspvalue[ii]+')</span>';
														}
													}
												}
											}
										}else if(wf == 'RQSPF'){//让球胜平负
											for(var i=0;i<code.length;i++){
												var cc = code[i].split("[");
												if( id == cc[0]){
													var touzhu = cc[1].substr(0,(cc[1].length-1)).split(',');
													for(var j=0;j<touzhu.length;j++){
														var oracle2 = touzhu[j].replace("3","让胜").replace("1","让平").replace("0","让负");
														var ii = touzhu[j].replace("0","2").replace("3","0");
														if(rqresult != ""){
															if(touzhu[j] == rqresult){
																html += '<span><em class="yellow">'+oracle2+'</em>('+rqspvalue[ii]+')</span>';
															}else{
																html += '<span>'+oracle2+'('+rqspvalue[ii]+')</span>';
															}
														}else{
															html += '<span>'+oracle2+'('+rqspvalue[ii]+')</span>';
														}
													}
												}
											}
										}else if(wf == 'JQS'){//让球胜平负
											for(var i=0;i<code.length;i++){
												var cc = code[i].split("[");
												if( id == cc[0]){
													var touzhu = cc[1].substr(0,(cc[1].length-1)).split(',');
													for(var j=0;j<touzhu.length;j++){
														var oracle2 = touzhu[j];
														var ii = touzhu[j];
														if(jqresult != ""){
															if(touzhu[j] == jqresult){
																html += '<span><em class="yellow">'+oracle2+'</em>('+jqsspvalue[ii]+')</span>';
															}else{
																html += '<span>'+oracle2+'('+jqsspvalue[ii]+')</span>';
															}
														}else{
															html += '<span>'+oracle2+'('+jqsspvalue[ii]+')</span>';
														}
													}
												}
											}
										}else if(wf == 'BQC'){//半全场
											for(var i=0;i<code.length;i++){
												var cc = code[i].split("[");
												if( id == cc[0]){
													var touzhu = cc[1].substr(0,(cc[1].length-1)).split(',');
													for(var j=0;j<touzhu.length;j++){
														var oracle2 = touzhu[j].replace(/3/g,"胜").replace(/1/g,"平").replace(/0/g,"负");
														var bqc_i = ['3-3','3-1','3-0','1-3','1-1','1-0','0-3','0-1','0-0'];
														var ii = bqc_i.indexOf(touzhu[j]);
														if(bqcresult != ""){
															if(touzhu[j] == bqcresult){
																html += '<span><em class="yellow">'+oracle2+'</em>('+bqcspvalue[ii]+')</span>';
															}else{
																html += '<span>'+oracle2+'('+bqcspvalue[ii]+')</span>';
															}
														}else{
															html += '<span>'+oracle2+'('+bqcspvalue[ii]+')</span>';
														}
													}
												}
											}
										}else if(wf == 'CBF'){//半全场
											for(var i=0;i<code.length;i++){
												var cc = code[i].split("[");
												if( id == cc[0]){
													var touzhu = cc[1].substr(0,(cc[1].length-1)).split(',');
													for(var j=0;j<touzhu.length;j++){
														var oracle2 = touzhu[j].replace('9:0',"胜其它").replace('9:9',"平其它").replace('0:9',"负其它");
														var bqc_i = ['1:0','2:0','2:1','3:0','3:1','3:2','4:0','4:1','4:2','5:0','5:1','5:2','9:0'
														             ,'0:0','1:1','2:2','3:3','9:9'
														             ,'0:1','0:2','1:2','0:3','1:3','2:3','0:4','1:4','2:4','0:5','1:5','2:5','0:9']
														var ii = bqc_i.indexOf(touzhu[j]);
														if(bfresult != ""){
															if(touzhu[j] == bfresult){
																html += '<span><em class="yellow">'+oracle2+'</em>('+bfspvalue[ii]+')</span>';
															}else{
																html += '<span>'+oracle2+'('+bfspvalue[ii]+')</span>';
															}
														}else{
															html += '<span>'+oracle2+'('+bfspvalue[ii]+')</span>';
														}
													}
												}
											}
										}
									}
									html += '</div></td></tr>';
								});
								html += '</table></div>';
								html2 = '<div><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTitle mgTop06"><tr>';
								html2 += '<td width="40%">奖金优化组合</td><td width="30%">过关方式</td><td width="30%" style="border-right:none">倍数</td>';
								html2 += '</tr></table>';
								html2 += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTable">';
								var c = mx.split(';');
								for(var i=0;i<c.length;i++){
									var cc = c[i].split('|');
									var bs = cc[2].split('_')[1];
									var chuan = cc[2].split('_')[0];
									
									chuan = chuan.replace(/\*/g, "串").replace(/1串1/g, "单关");
									
									var ct = cc[1].split(',');
									
									
									var op = '';
									for(var j = 0; j<ct.length; j++){
										var k = ct[j].split('=');
										if(cc[0] == "HH"){
											var ff = k[0].split('>');
											if(ff[1] == 'SPF'){
												op += name[num.indexOf(ff[0])]+'('+k[1].replace("3","胜").replace("1","平").replace("0","负")+')<br/>';
											}else{
												op += name[num.indexOf(ff[0])]+'('+k[1].replace("3","让胜").replace("1","让平").replace("0","让负")+')<br/>';
											}
										}else if(cc[0] == "SPF"){
											op += name[num.indexOf(k[0])]+'('+k[1].replace("3","胜").replace("1","平").replace("0","负")+')<br/>';
										}else if(cc[0] == "RQSPF"){
											op += name[num.indexOf(k[0])]+'('+k[1].replace("3","让胜").replace("1","让平").replace("0","让负")+')<br/>';
										}else if(cc[0] == "CBF"){
											op += name[num.indexOf(k[0])]+'('+k[1].replace("9:0","胜其它").replace("9:9","平其它").replace("0:9","负其它")+')<br/>';
										}else if(cc[0] == "JQS"){
											op += name[num.indexOf(k[0])]+'('+k[1].replace("7","7+")+')<br/>';
										}else if(cc[0] == "BQC"){
											op += name[num.indexOf(k[0])]+'('+k[1].replace(/3/g,"胜").replace(/1/g,"平").replace(/0/g,"负")+')<br/>';
										}
									}
									html2 += '<tr><td '+(i==0?"width='40%'":"")+'>'+op+'</td>';
									html2 += '<td '+(i==0?"width='30%'":"")+'>'+chuan+'</td>';
									html2 += '<td '+(i==0?"width='30%'":"")+' class="r9last">'+bs+'倍</td></tr>';
									
								}
								html += '</table></div>';
								$("#zgContent").hide();
								$('#clasli').html(html+html2);
							}
						});
					}
				});
				} catch (e) {
					
				}
			}
		},
		/*lotid 彩种id
		expect 当前期次
		projid 方案编号
		type 
		codes 投注号码*/
		bd_jc_clasli:function(lotid,expect,projid,codes,source){
			if(source == '11'){//固定单关
				$.ajax({
					url : '/trade/qview.go',
					type : "GET",
					data: {
						hid : projid,
						gid : lotid
					},
					dataType : "xml",
					cache : false,
					success : function(xml) {
						var R = $(xml).find('rows');
						var gg = R.attr('gg');
						html = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTitle mgTop06"><tr>';
						html += '<td width="15%">场次</td><td width="70%">主队VS客队/投注选项</td><td width="15%" style="border-right:none">比分</td>';
						html += '</tr></table>';
						html += '<table id="tcont" width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTable">';
						
						var r = R.find('row');
						r.each(function(aa){
							var id = $(this).attr('id');//编号
							var name = $(this).attr('name');//周几
							var hn = $(this).attr('hn');//主队
							var gn = $(this).attr('gn');//客队
							var hs = $(this).attr('hs');//
							var gs = $(this).attr('gs');
							var hhs = $(this).attr('hhs');
							var hgs = $(this).attr('hgs');
							var isdan = $(this).attr('isdan');
							var lose = $(this).attr('lose');
							var ccodes = $(this).attr('ccodes');
							var quan = '',ban = '';
							if(hs != '' && gs != ''){
								quan = '全'+hs+':'+gs;
								ban = '半'+hhs+':'+hgs;
							}
							ccodes = ccodes.split('|')[1].split(',');
							html += '<tr id='+id+'><td '+(aa==0?"width='15%'":"")+' rowspan="2">'+name+'</td>';
							html += '<td '+(aa==0?"width='70%'":"")+'>'+hn+'<em class="fontSize07">VS</em>'+gn+'<span id = dan'+id+' style="color:red"></span></td>';
							html += '<td '+(aa==0?"width='15%'":"")+' rowspan="2" class="r9last">'+ban+'<br/>'+quan+'</td></tr>';
							html += '<tr><td><div class="tdleft gray">&nbsp;';
							for(var i=0;i<ccodes.length;i++){
								var c1 = ccodes[i].split('_');
								var c2 = c1[1];
								if(lotid == '92'){//半全场
									c1 = c1[0].replace(/3/g,'胜').replace(/1/g,'平').replace(/0/g,'负');
								}else if(lotid == '91'){//比分
									c1 = c1[0].replace('9:0','胜其它').replace('9:9','平其它').replace('0:9','负其它');
								}else if(lotid == '90' || lotid == '72'){//
									c1 = c1[0].replace('3','胜').replace('1','平').replace('0','负');
								}else{
									c1 = c1[0];
								}
								html += '<span>'+c1+'('+c2+')</span>';
							}
							html += '</div></td></tr>';
					});
						html += '</table>';
						html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:   '+gg+'</td></tr></table>';
						$('#clasli').html(html);
						$('#jcts').show();
					}
				});
			}else{
				$.ajax({
					url : "/data/guoguan/" + lotid + "/" + expect + "/proj/" + projid.toLowerCase() + ".xml",
					type : "GET",
					dataType : "xml",
					cache : false,
					success : function(xml) {
						var R = $(xml).find("items");
						var pid= R.attr("pid");
						var wk=["日","一","二","三","四","五","六"];
						var r = R.find("item");
						var chuan = '';
						chuan = codes.split('|')[2];
						if(chuan.indexOf('_')>=0){//固定单关 1*1_1
							chuan = '单关';
						}else{
							chuan = chuan.replace(/\*/g, "串").replace(/1串1/g, "单关");
						}
						var html='';
						html = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTitle mgTop06"><tr>';
						if(lotid == "94"||lotid == "95"||lotid == "96"||lotid == "97"||lotid == "71"){//
							html += '<td width="15%">场次</td><td width="70%">客队VS主队/投注选项</td><td width="15%" style="border-right:none">比分</td>';
						}else{
							html += '<td width="15%">场次</td><td width="70%">主队VS客队/投注选项</td><td width="15%" style="border-right:none">比分</td>';
						}
						html += '</tr></table>';
						html += '<table id="tcont" width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTable">';
						if(lotid == 70){//竞彩足球  混合投注
							var cbfstr=["1:0","2:0","2:1","3:0","3:1","3:2","4:0","4:1","4:2","5:0","5:1","5:2","9:0","0:0","1:1","2:2","3:3","9:9","0:1","0:2","1:2","0:3","1:3","2:3","0:4","1:4","2:4","0:5","1:5","2:5","0:9"];
							var spfstr=["3", "1", "0"];
							var jqsstr=["0", "1", "2","3","4","5","6","7"];
							var bqcstr=["3-3","3-1","3-0","1-3","1-1","1-0","0-3","0-1","0-0"];
							r.each(function(a){
								var hn=$(this).attr("hn");//主队
								var vn=$(this).attr("vn");//客队
								var lose = $(this).attr("lose");//让分
								var c = parseInt($(this).attr("cancel"));
								var hs = $(this).attr("hs");// 全场主队进球
								var vs = $(this).attr("vs");// 全场客队进球
								var hhs = $(this).attr("hhs");// 半场主队进球
								var hvs = $(this).attr("hvs");// 半场客队进球
								var spvalue = $(this).attr("spvalue");// 出票参考SP
								var spvalues = spvalue.split("|");
								var quan = '',ban = '';
								if(hs != '' && vs != ''){
									quan = '全'+hs+':'+vs;
								}
								if(hs != '' && vs != ''){
									ban = '半'+hhs+':'+hvs;
								}
								var rq = '';
								if(lose!=0 && lose !=""){
									if(lose.indexOf('-')!=-1){
										rq="(<font color='green'>"+lose+"</font>)";
									}else{
										rq="(<font color='red'>"+lose+"</font>)";
									}
								}
								var hsstr =  $(this).attr("hs").trim();
								var result = "";
								var lose1 = parseFloat(lose);
								var id = $(this).attr("id");
								var tDATE="20"+id.substr(0,2)+"-"+id.substr(2,2)+"-"+id.substr(4,2);
								tDATE = new Date(tDATE); 
								var wk2 = '周'+wk[tDATE.getDay()];
								var id2 = id.substr(6,3);
								var tz = codes.split('|')[1];
								var dcode = [];
								if(tz.indexOf("$")!=-1){
									dcode = tz.split('$');
									tz=dcode[0]+","+dcode[1];
								}
								var cctz = tz.split(',');
								for(var i=0;i<cctz.length;i++){
									var cctzLength = cctz[i].split('>')[1].split('+').length;
									if(id == cctz[i].split('>')[0]){
										var dan = '';
										if(dcode != ''){
											if(dcode[0].indexOf(id) != '-1'){
												dan = '<font color="red">(胆)</font>';
											}
										}
										var cctzLength2 = cctz[i].split('>')[1].split('+').length;
										html += '<tr id="'+id+'"><td '+(a==0?"width='15%'":"")+' rowspan="'+(cctzLength2+1)+'">'+wk2+'<br>'+id2+'</td>';
								  		html += '<td '+(a==0?"width='70%'":"")+'>'+hn+rq+'<em class="fontSize07">VS</em>'+vn+dan+'</td>';
							  			html += '<td '+(a==0?"width='15%'":"")+' calss="r9last" rowspan="'+(cctzLength2+1)+'">'+ban+'<br/>'+quan+'</td></tr>';
							  			
										for(var j=0;j<cctzLength;j++){
											var wwc  =  cctz[i].split('>')[1].split('+')[j].split('=')[1].split('/');
											if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "RQSPF"){
												var spvalue = spvalues[0].split(",");
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs-vs)*1+(lose1)*1;
														if(rt*1>0){result="3";}else if(rt*1==0){result="1";}else{result="0";}
													}else{
														result = "";
													}
												}else{
													result = "";
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("3","让胜").replace("1","让平").replace("0","让负")+'</em>('+spvalue[spfstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("3","让胜").replace("1","让平").replace("0","让负")+'('+spvalue[spfstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("3","让胜").replace("1","让平").replace("0","让负")+'('+spvalue[spfstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "SPF"){
												var spvalue = spvalues[4].split(",");
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs-vs)*1;
														if(rt*1>0){result="3";}else if(rt*1==0){result="1";}else{result="0";}
													}else{
														result = "";
													}
												}else{
													result = "";
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("3","胜").replace("1","平").replace("0","负")+'</em>('+spvalue[spfstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("3","胜").replace("1","平").replace("0","负")+'('+spvalue[spfstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("3","胜").replace("1","平").replace("0","负")+'('+spvalue[spfstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "CBF"){
												var spvalue = spvalues[1].split(",");
												if(c==0){
													if(hsstr.length>0){
														result = hs+":"+vs;
													}else{
														result = "";
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("9:0","胜其它").replace("9:9","平其它").replace("0:9","负其它")+'</em>('+spvalue[cbfstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("9:0","胜其它").replace("9:9","平其它").replace("0:9","负其它")+'('+spvalue[cbfstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("9:0","胜其它").replace("9:9","平其它").replace("0:9","负其它")+'('+spvalue[cbfstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "JQS"){
												var spvalue = spvalues[3].split(",");
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs+vs)*1;
														if(rt>=7){result=7;}else{result=rt;}
													}else{
														result = "";
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n]+'球</em>('+spvalue[jqsstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n]+'球('+spvalue[jqsstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n]+'球('+spvalue[jqsstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "BQC"){
												var spvalue = spvalues[2].split(",");
												if(c==0){
													if(hsstr.length>0){
														var hrt=(hhs-hvs)*1;
														var rt=(hs-vs)*1;
														if(hrt*1>0){result="3";}else if(hrt*1==0){result="1";}else{result="0";}
														if(rt*1>0){result=result+"-3";}else if(rt*1==0){result=result+"-1";}else{result=result+"-0";}
													}else{
														result = "";
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("3-3","胜-胜").replace("3-1","胜-平").replace("3-0","胜-负").replace("1-3","平-胜").replace("1-1","平-平").replace("1-0","平-负").replace("0-3","负-胜").replace("0-1","负-平").replace("0-0","负-负")+'</em>('+spvalue[bqcstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("3-3","胜-胜").replace("3-1","胜-平").replace("3-0","胜-负").replace("1-3","平-胜").replace("1-1","平-平").replace("1-0","平-负").replace("0-3","负-胜").replace("0-1","负-平").replace("0-0","负-负")+'('+spvalue[bqcstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("3-3","胜-胜").replace("3-1","胜-平").replace("3-0","胜-负").replace("1-3","平-胜").replace("1-1","平-平").replace("1-0","平-负").replace("0-3","负-胜").replace("0-1","负-平").replace("0-0","负-负")+'('+spvalue[bqcstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}
										}
										
									}
								}
							});
							html += '</table>';
							html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:   '+chuan+'</td></tr></table>';
							$('#clasli').html(html);
							$('#jcts').show();
						}else if(lotid == "71"){//竞彩蓝球  混合投注
							var sfstr=["0","3"];
							var rfsfstr=["0", "3"];
							var dxfstr=["3", "0"];
							var sfcstr=["11","12","13","14","15","16","01","02","03","04","05","06"];
							r.each(function(a){
								var hn=$(this).attr("hn");//主队
								var vn=$(this).attr("vn");//客队
								var lose = $(this).attr("lose");//让分
								var rq = '';
								if(lose != "" && codes.indexOf('RFSF') != -1){
									if(lose.split('|')[1] == 0){
										rq = "";
									}else{
										if(lose.split('|')[1].indexOf('-') != -1){
											rq = "<span style='color:blue'>("+lose.split('|')[1]+")</span>";
										}else{
											rq = "<span style='color:red'>(+"+lose.split('|')[1]+")</span>";
										}
									}
								}
								var c = parseInt($(this).attr("cancel"));
								var hs = $(this).attr("hs");// 全场主队进球
								var vs = $(this).attr("vs");// 全场客队进球
								var spvalue = $(this).attr("spvalue");// 出票参考SP
								var spvalues = spvalue.split("|");
								var bfen = '';
								if(hs != '' && vs != ''){
									bfen = vs+':'+hs;
									hs = parseFloat(hs);
									vs = parseFloat(vs);
								}
								var hsstr =  $(this).attr("hs").trim();
								var result = "";
								var id = $(this).attr("id");
								var tDATE="20"+id.substr(0,2)+"-"+id.substr(2,2)+"-"+id.substr(4,2);
								tDATE = new Date(tDATE);
								var wk2 = '周'+wk[tDATE.getDay()];
								var id2 = id.substr(6,3);
								var cctz = [];
								if(codes.indexOf(';')>0){
									cctz = $.map(codes.split(';'),function(val, index){
										if(index == '0'){
											return val.split('|')[1];
										}else{
											return val.split('|')[1].split('>')[1];
										}
									});
									cctz = cctz.join('+').split(',');
								}else{
									cctz = codes.split('|')[1].split(',');
								}
								bflose = lose.split('|')[3];
								if(bflose > 0){
									bfen ='<em class="gray fontSize07">预设</em><br>'+bflose+'<br>'+bfen;
								}
								var cctzLength2 = cctz[a].split('>')[1].split('+').length;
								html += '<tr id="'+id+'"><td '+(a==0?"width='15%'":"")+' rowspan="'+(cctzLength2+1)+'">'+wk2+'<br>'+id2+'</td>';
						  		html += '<td '+(a==0?"width='70%'":"")+'>'+vn+'<em class="fontSize07">VS</em>'+hn+rq+'</td>';
					  			html += '<td '+(a==0?"width='15%'":"")+' class="r9last" rowspan="'+(cctzLength2+1)+'">'+bfen+'</td></tr>';
								for(var i=0;i<cctz.length;i++){
									if(id == cctz[i].split('>')[0]){
										var cctzLength = cctz[i].split('>')[1].split('+').length;
										for(var j=0;j<cctzLength;j++){
											var wwc  =  cctz[i].split('>')[1].split('+')[j].split('=')[1].split('/');
											if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "SF"){
												spvalue = spvalues[0].split(",");
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs-vs)*1;
														if(rt*1>0){result="3";}else{result="0";}
													}else{
														result = "";
													}
												}else{
													result = "";
												}
												var loses = lose;
												if(loses != ""){
													if(loses.split('|')[0] == 0){
														loses = "";
													}else{
														loses = '('+loses.split('|')[0]+')';
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("3","主胜").replace("0","主负")+'</em>('+spvalue[sfstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("3","主胜").replace("0","主负")+'('+spvalue[sfstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("3","主胜").replace("0","主负")+'('+spvalue[sfstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "RFSF"){
												spvalue = spvalues[1].split(",");
												var loses = lose;
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs-vs)*1+(loses.split('|')[1])*1;
														if(rt*1>0){result="3";}else{result="0";}
													}else{
														result = "";
													}
												}
												if(loses != ""){
													if(loses.split('|')[1] == 0){
														loses = "";
													}else{
														loses = '('+loses.split('|')[1]+')';
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("3","让分主胜").replace("0","让分主负")+'</em>('+spvalue[rfsfstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("3","让分主胜").replace("0","让分主负")+'('+spvalue[rfsfstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("3","让分主胜").replace("0","让分主负")+'('+spvalue[rfsfstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "DXF"){
												spvalue = spvalues[3].split(",");
												var loses = lose;
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs+vs)*1-(loses.split('|')[3])*1;
														if(rt*1>0){result="3";}else{result="0";}
													}else{
														result = "";
													}
												}
												if(loses != ""){
													if(loses.split('|')[3] == 0){
														loses = "";
													}else{
														loses = '('+loses.split('|')[3]+')';
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("3","大分").replace("0","小分")+'</em>('+spvalue[dxfstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("3","大分").replace("0","小分")+'('+spvalue[dxfstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("3","大分").replace("0","小分")+'('+spvalue[dxfstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}else if(cctz[i].split('>')[1].split('+')[j].split('=')[0] == "SFC"){
												spvalue = spvalues[2].split(",");
												if(c==0){
													if(hsstr.length>0){
														var rt=(hs-vs)*1;
														if(rt>0&&rt<6){result="01";}
														else if(rt>5&&rt<11){result="02";}
														else if(rt>10&&rt<16){result="03";}
														else if(rt>15&&rt<21){result="04";}
														else if(rt>20&&rt<26){result="05";}
														else if(rt>25){result="06";}
														else if(rt>-6&&rt<0){result="11";}
														else if(rt>-11&&rt<-5){result="12";}
														else if(rt<-10&&rt>-16){result="13";}
														else if(rt<-15&&rt>-21){result="14";}
														else if(rt<-20&&rt>-26){result="15";}
														else if(rt<-25){result="16";}
													}else{
														result = "";
													}
												}
												var loses = lose;
												if(loses != ""){
													if(loses.split('|')[2] == 0){
														loses = "";
													}else{
														loses = '('+loses.split('|')[2]+')';
													}
												}
												html += '<tr><td><div class="tdleft gray">&nbsp;';
												if(result!=""){
													for(var n = 0;n<wwc.length;n++){
														if(result == wwc[n]){
															html += '<span><em class="yellow">'+wwc[n].replace("01","主a").replace("02","主h").replace("03","主k").replace("04","主m").replace("05","主s").replace("06","主g").replace("11","客a").replace("12","客h").replace("13","客k").replace("14","客m").replace("15","客s").replace("16","客g").replace("a","1-5").replace("h","6-10").replace("k","11-15").replace("m","16-20").replace("s","21-25").replace("g","26+")+'</em>('+spvalue[sfcstr.indexOf(wwc[n])]+')</span>';
														}else{
															html += '<span>'+wwc[n].replace("01","主a").replace("02","主h").replace("03","主k").replace("04","主m").replace("05","主s").replace("06","主g").replace("11","客a").replace("12","客h").replace("13","客k").replace("14","客m").replace("15","客s").replace("16","客g").replace("a","1-5").replace("h","6-10").replace("k","11-15").replace("m","16-20").replace("s","21-25").replace("g","26+")+'('+spvalue[sfcstr.indexOf(wwc[n])]+')</span>';
														}
													}
													html += '</div></td></tr>';
												}else{
													html += "<div class='hunheItem'>&nbsp;";
													for(var n = 0;n<wwc.length;n++){
														html += '<span>'+wwc[n].replace("01","主a").replace("02","主h").replace("03","主k").replace("04","主m").replace("05","主s").replace("06","主g").replace("11","客a").replace("12","客h").replace("13","客k").replace("14","客m").replace("15","客s").replace("16","客g").replace("a","1-5").replace("h","6-10").replace("k","11-15").replace("m","16-20").replace("s","21-25").replace("g","26+")+'('+spvalue[sfcstr.indexOf(wwc[n])]+')</span>';
													}
													html += '</div></td></tr>';
												}
											}
										}
									}
								}
							});
							html += '</table>';
							html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:   '+chuan+'</td></tr></table>';
							$('#clasli').html(html);
							$('#jcts').show();
						}else if(lotid == "90"||lotid == "93"||lotid == "91"||lotid == "92"||lotid == "94"||lotid == "95"||lotid == "97"||lotid == "96" || lotid == "72"){//竞彩足球  篮球 
							r.each(function(aa){
								var hs = $(this).attr("hs");//
								var vs = $(this).attr("vs");//
								var hhs = $(this).attr("hhs");//
								var hvs = $(this).attr("hvs");//
								var quan = '',ban = '';
								if(hs != '' && vs != ''){
									quan = '全'+hs+':'+vs;
								}
								if(hs != '' && vs != ''){
									ban = '半'+hhs+':'+hvs;
								}
								var hsstr =  $(this).attr("hs").trim();
								var c = $(this).attr("cancel");
							    var spvalue = $(this).attr("spvalue");// 出票参考SP
							    var spvalues = spvalue.split("|");
							    if(lotid==90){//竞彩胜平负
								    spvalue = spvalues.length==1 ? spvalue:spvalues[0];
							    }else if(lotid==91){//竞彩比分
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[1];
							    }else if(lotid==92){//竞彩半全场
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[2];
							    }else if(lotid==93){//竞彩总进球数
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[3];
							    }else if(lotid==72){//竞彩spf
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[4];
							    }else if(lotid==94){//篮彩 sf
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[0];
							    }else if(lotid==95){//篮彩 rfsf
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[1];
							    }else if(lotid==96){//篮彩sfc
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[2];
							    }else if(lotid==97){//篮彩 dxf
							    	spvalue = spvalues.length==1 ? spvalue:spvalues[3];
							    }
							    spvalue = spvalue.split(',');
								var hn="";
								var vn="";
								hn = $(this).attr("hn");//主队
								vn = $(this).attr("vn");//客队
								
								var lose2 = $(this).attr("lose");//让分
								var lose = lose2;
								var loses = lose.split("|");
								if(lotid == "94"){
									if(parseInt(loses[0])==0){
										lose="";
									}else{
										lose=loses[0];
									}
								}else if(lotid == "95"){
									if(parseInt(loses[1])==0){
										lose="";
									}else{
										lose=loses[1];
									}
								}else if(lotid == "97"){
									if(parseInt(loses[3])==0){
										lose="";
									}else{
										lose=loses[3];
									}
								}else if(lotid == "96"){
									if(parseInt(loses[2])==0){
										lose="";
									}else{
										lose=loses[2];
									}
								}else{
									if(lose2 == 0){
										lose="";
									}
								}
								var rq = '';
								if(lose!=0 && lose!="" && (lotid == "90"||lotid == "95")){
									if(lose.indexOf('-')!=-1){
										rq="(<font color='green'>"+lose+"</font>)";
									}else{
										rq="(<font color='red'>"+lose+"</font>)";
									}
								}
								var id = $(this).attr("id");//id
								var id2 = id.substring('6','9'); //场次
								var tDATE="20"+id.substr(0,2)+"-"+id.substr(2,2)+"-"+id.substr(4,2);
								tDATE = new Date(tDATE);
								var wk2 = '周'+wk[tDATE.getDay()];
								
								html += '<tr id='+id+'><td '+(aa==0?"width='15%'":"")+' rowspan="2">'+wk2+'<br>'+id2+'</td>';
								if(lotid == "94"||lotid == "95"||lotid == "96"||lotid == "97"){//
									if(hs != '' && vs != ''){
										quan = vs+':'+hs;
									}
									if(lotid == "97"){
										if(lose > 0){
											quan ='<em class="gray fontSize07">预设</em><br>'+lose+'<br>'+quan;
										}
									}
									html += '<td '+(aa==0?"width='70%'":"")+'>'+vn+rq+'<em class="fontSize07">VS</em>'+hn+'<span id = dan'+id+' style="color:red"></span></td>';
									html += '<td '+(aa==0?"width='15%'":"")+' rowspan="2" class="r9last">'+quan+'</td></tr>';
								}else{
									html += '<td '+(aa==0?"width='70%'":"")+'>'+hn+rq+'<em class="fontSize07">VS</em>'+vn+'<span id = dan'+id+' style="color:red"></span></td>';
									html += '<td '+(aa==0?"width='15%'":"")+' rowspan="2" class="r9last">'+ban+'<br/>'+quan+'</td></tr>';
								}
							var code = '',code1 = '';
							if(source == '13'){
								var q = codes.split('|')[0];
								codes = codes.split(';');
								var t = [];
								for(var i=0;i<codes.length;i++){
									t.push(codes[i].split('|')[1]);
								}
								codes = q +'|'+ t;
							}
							code = codes.split('|');
							code1 =code[1];
							if(code[1].indexOf("$")!=-1){
								var dcode =code[1].split('$');
								code1=dcode[0]+","+dcode[1];
							}
							code1=code1.split(",");
							if(code[0]=="RQSPF"){//jczq 让球胜平负 90
								if(c == 0){
									if(hsstr.length > 0){
										var rt=(hs-vs)*1+(lose)*1;
										if(rt*1>0){result="3";}else if(rt*1==0){result="1";}else{result="0";}
									}else{
										result = "";
									}
								}else{
									result = "";
								}
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j].replace("3","胜").replace("1","平").replace("0","负");
												var ii = oracle[j].replace("0","2").replace("3","0");
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">让'+oracle2+'</em>('+spvalue[ii]+')</span>';
													}else{
														html += '<span>让'+oracle2+'('+spvalue[ii]+')</span>';
													}
												}else{
													html += '<span>让'+oracle2+'('+spvalue[ii]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
							}else if(code[0]=="SPF"){//jczq 胜平负 72
								if(c == 0){
									if(hsstr.length > 0){
										var rt=(hs-vs)*1;
										if(rt*1>0){result="3";}else if(rt*1==0){result="1";}else{result="0";}
									}else{
										result = "";
									}
								}else{
									result = "";
								}
								
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j].replace("3","胜").replace("1","平").replace("0","负");
												var ii = oracle[j].replace("0","2").replace("3","0");
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2+'</em>('+spvalue[ii]+')</span>';
													}else{
														html += '<span>'+oracle2+'('+spvalue[ii]+')</span>';
													}
												}else{
													html += '<span>'+oracle2+'('+spvalue[ii]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
							}else if(code[0]=="BQC"){//jczq 半全场92
								var BQC = ['3-3','3-1','3-0','1-3','1-1','1-0','0-3','0-1','0-0'];
								if(c == 0){
									if(hsstr.length > 0){
										var hrt=(hhs-hvs)*1;
										var rt=(hs-vs)*1;
										if(hrt*1>0){result="3";}else if(hrt*1==0){result="1";}else{result="0";}
										if(rt*1>0){result=result+"-3";}else if(rt*1==0){result=result+"-1";}else{result=result+"-0";}
									}else{
										result = "";
									}
								}else{
									result = "";
								}
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j].replace(/3/g,"胜").replace(/1/g,"平").replace(/0/g,"负");
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2+'</em>('+spvalue[BQC.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2+'('+spvalue[BQC.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2+'('+spvalue[BQC.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									
									html += '</div></td></tr>';
							}else if(code[0]=="JQS"){//jczq 进球数 93
								var JQS = ['0','1','2','3','4','5','6','7'];
								if(c == 0){
									if(hsstr.length > 0){
										var rt=(parseFloat(hs)+parseFloat(vs))*1;
										if(rt>=7){result=7;}else{result=rt;}
									}else{
										result = "";
									}
								}else{ 
									result = "";
								}
								
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2+'</em>('+spvalue[JQS.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2+'('+spvalue[JQS.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2+'('+spvalue[JQS.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
							}else if(code[0]=="CBF"){//jczq 比分91
								var BF = ['1:0','2:0','2:1','3:0','3:1','3:2','4:0','4:1','4:2','5:0','5:1','5:2','9:0',//胜其他
								    		'0:0','1:1','2:2','3:3','9:9',//平其他
								    		'0:1','0:2','1:2','0:3','1:3','2:3','0:4','1:4','2:4','0:5','1:5','2:5','0:9'//负其他
								    ];
								if(c == 0){
									if(hsstr.length > 0){
										var rt=hs+""+vs;
										result=hs+":"+vs;
										var bfstr=["10","20","21","30","31","32","40","41","42","50","51","52","90","00","11","22","33","99","01","02","12","03","13","23","04","14","24","05","15","25","09"];
										var ii=100;
										for(var i=0;i<31;i++){
											if(bfstr[i]==rt){ii=i;}
										}
										if(ii==12){
											result="胜其它";
										}else if(ii==17){
											result="平其它";
										}else if(ii==30){
											result="负其它";
										}else if(ii==100){
											if(hs>vs){result="胜其它";ii=12;}else if(hs==vs){result="平其它";ii=17;}else{result="负其它";ii=30;}
										}
									}else{
										result = "";
									}
								}else{
									result = "";
								}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j].replace(/9:0/g,"胜其他").replace(/9:9/g,"平其他").replace(/0:9/g,"负其他");
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2+'</em>('+spvalue[BF.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2+'('+spvalue[BF.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2+'('+spvalue[BF.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
							}else if(code[0]=="SF"){//jclq sf
								var SF = ['0','3'];
								if(c==0){
									if(hsstr.length>0){
										var rt=(hs-vs)*1;
										if(rt*1>0){result="3";}else{result="0";}
									}else{
										result = "";
									}
								}
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2.replace(/3/g,"主胜").replace(/0/g,"主负")+'</em>('+spvalue[SF.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2.replace(/3/g,"主胜").replace(/0/g,"主负")+'('+spvalue[SF.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/3/g,"主胜").replace(/0/g,"主负")+'('+spvalue[SF.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
							}else if(code[0]=="RFSF"){//jclq 让分胜负95
								var RFSF = ['0','3'];
								var loses2 = lose2;
								if(c==0){
									if(hsstr.length>0){
										var rt=(hs-vs)*1+(loses2.split('|')[1])*1;
										if(rt*1>0){result="3";}else{result="0";}
									}else{
										result = "";
									}
								}
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2.replace(/3/g,"主胜").replace(/0/g,"主负")+'</em>('+spvalue[RFSF.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2.replace(/3/g,"主胜").replace(/0/g,"主负")+'('+spvalue[RFSF.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/3/g,"主胜").replace(/0/g,"主负")+'('+spvalue[RFSF.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
							}else if(code[0]=="DXF"){//jclq 大小分
								var DXF = ['3','0'];
								var loses2 = lose2;
								if(c==0){
									if(hsstr.length>0){
										var rt=(parseFloat(hs)+parseFloat(vs))*1-(loses2.split('|')[3])*1;
										if(rt*1>0){result="3";}else{result="0";}
									}else{
										result = "";
									}
								}
								html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2.replace(/3/g,"大分").replace(/0/g,"小分")+'</em>('+spvalue[DXF.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2.replace(/3/g,"大分").replace(/0/g,"小分")+'('+spvalue[DXF.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/3/g,"大分").replace(/0/g,"小分")+'('+spvalue[DXF.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}else if(code[0]=="SFC"){//jclq 胜分差96
									var SFC = ['11','12','13','14','15','16','01','02','03','04','05','06'];
									if(c==0){
										if(hsstr.length>0){
											var rt=(hs-vs)*1;
											if(rt>0&&rt<6){result="01";}
											else if(rt>5&&rt<11){result="02";}
											else if(rt>10&&rt<16){result="03";}
											else if(rt>15&&rt<21){result="04";}
											else if(rt>20&&rt<26){result="05";}
											else if(rt>25){result="06";}
											else if(rt>-6&&rt<0){result="11";}
											else if(rt>-11&&rt<-5){result="12";}
											else if(rt<-10&&rt>-16){result="13";}
											else if(rt<-15&&rt>-21){result="14";}
											else if(rt<-20&&rt>-26){result="15";}
											else if(rt<-25){result="16";}
										}else{
											result = "";
										}
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2.replace(/01/g,"主胜1-5").replace(/02/g,"主胜6-10").replace(/03/g,"主胜1/1-1/5").replace(/04/g,"主胜1/6-20").replace(/05/g,"主胜21-25").replace(/06/g,"主胜26+").replace(/11/g,"主负1-5").replace(/12/g,"主负6-10").replace(/13/g,"主负1/1-1/5").replace(/14/g,"主负1/6-20").replace(/15/g,"主负21-25").replace(/16/g,"主负26+").replace(/\//g,"")+'</em>('+spvalue[SFC.indexOf(oracle[j])]+')</span>';
													}else{
														html += '<span>'+oracle2.replace(/01/g,"主胜1-5").replace(/02/g,"主胜6-10").replace(/03/g,"主胜1/1-1/5").replace(/04/g,"主胜1/6-20").replace(/05/g,"主胜21-25").replace(/06/g,"主胜26+").replace(/11/g,"主负1-5").replace(/12/g,"主负6-10").replace(/13/g,"主负1/1-1/5").replace(/14/g,"主负1/6-20").replace(/15/g,"主负21-25").replace(/16/g,"主负26+").replace(/\//g,"")+'('+spvalue[SFC.indexOf(oracle[j])]+')</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/01/g,"主胜1-5").replace(/02/g,"主胜6-10").replace(/03/g,"主胜1/1-1/5").replace(/04/g,"主胜1/6-20").replace(/05/g,"主胜21-25").replace(/06/g,"主胜26+").replace(/11/g,"主负1-5").replace(/12/g,"主负6-10").replace(/13/g,"主负1/1-1/5").replace(/14/g,"主负1/6-20").replace(/15/g,"主负21-25").replace(/16/g,"主负26+").replace(/\//g,"")+'('+spvalue[SFC.indexOf(oracle[j])]+')</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}
							});
							html += '</table>';
							html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:   '+chuan+'</td></tr></table>';
							$('#clasli').html(html);
							$('#jcts').show();
							var code = codes.split('|');
							if(code[1].indexOf("$")!=-1){
								var dcode =code[1].split('$');
								var dcode1 =dcode[0].split(',');
								for(var ji =0;ji<dcode1.length;ji++){
									var mid=dcode1[ji].split('=')[0];
									$("#dan"+mid).html("(胆)");
								}
							}
						}else if(lotid == "84"||lotid == "85"||lotid == "89"||lotid == "86"||lotid == "87"||lotid == "88"){//北单
							r.each(function(){
								var id = $(this).attr("id")
								var hn = $(this).attr("hn");//主队
								var vn = $(this).attr("vn");//客队
								var hs = $(this).attr("hs");
							    var vs = $(this).attr("vs");
							    var hhs = $(this).attr("hhs");
								var hvs = $(this).attr("hvs");
								var quan = '',ban = '';
								if(hs != '' && vs != ''){
									quan = (lotid==84?'':'全')+hs+':'+vs;
								}
								if(hs != '' && vs != ''){
									ban = '半'+hhs+':'+hvs;
								}
								var id = $(this).attr("id");//id
								var result = $(this).attr("result");// 开奖结果
								var ststr = '';
								if(result!=""){
									ststr=result.split(";");
								}
								var cup = '';
								if(lotid == 84){cup = $(this).attr("cup");}
								var ball = ["足球","篮球","冰球","网球","羽毛球","排球","橄榄球","曲棍球","乒乓球","沙滩排球","手球","水球"];
								var ball2 = ["球","分","球","局","局","局","分","球","局","局","球","球"];
								var lose = $(this).attr("lose");//让球
								if(lose==0||lose==""||lotid==89){
									lose = "";
								}else{
									if(lose.indexOf('-')!=-1){
										lose="(<font color='green'>"+(lotid == "84"?lose+ball2[ball.indexOf(cup)]:lose)+"</font>)";
									}else{
										lose="(<font color='red'>"+(lotid == "84"?lose+ball2[ball.indexOf(cup)]:lose)+"</font>)";
									}
								}
								
							
								html += '<tr id="'+id+'" pid="'+pid+'"><td width="15%" rowspan="2" class="">'+id+(cup==''?"":"<br/><font color=#222222>"+cup+"</font>")+'</td>';
								html += '<td width="70%">'+hn+lose+'<em class="fontSize07">VS</em>'+vn+'<span id = dan'+id+' style="color:red"></span></td>';
								html += '<td width="15%" rowspan="2">'+(lotid==84?'':ban+"<br/>")+quan+'</td></tr>';
							
								var code = codes.split('|');
								var code1 =code[1];
								if(code1.indexOf("$")!=-1){
									var dcode =code1.split('$');
									code1=dcode[0]+","+dcode[1];
								}
								code1=code1.split(",");
								var jjsp = '';
								if(code[0]=="SF"){//84胜负过关
									if(ststr==""){
										result="";
									}else{
										result=ststr[0].split(":")[0];
										jjsp='('+ststr[0].split(":")[1]+')';
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle2 == result){
														html += '<span><em class="yellow">'+oracle2.replace(/3/g,"胜").replace(/0/g,"负")+'</em>'+jjsp+'</span>';
													}else{
														html += '<span>'+oracle2.replace(/3/g,"胜").replace(/0/g,"负")+'</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/3/g,"胜").replace(/0/g,"负")+'</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}else if(code[0]=="SPF"){//85
									if(ststr==""){
										result="";
									}else{
										result=ststr[0].split(":")[0];
										jjsp='('+ststr[0].split(":")[1]+')';
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle2 == result){
														html += '<span><em class="yellow">'+oracle2.replace(/3/g,"胜").replace(/1/g,"平").replace(/0/g,"负")+'</em>'+jjsp+'</span>';
													}else{
														html += '<span>'+oracle2.replace(/3/g,"胜").replace(/1/g,"平").replace(/0/g,"负")+'</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/3/g,"胜").replace(/1/g,"平").replace(/0/g,"负")+'</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}else if(code[0]=="JQS"){//89
									if(ststr==""){
										result="";
									}else{
										result=ststr[4].split(":")[0];
										jjsp='('+ststr[4].split(":")[1]+')';
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2+'球</em>'+jjsp+'</span>';
													}else{
														html += '<span>'+oracle2+'球</span>';
													}
												}else{
													html += '<span>'+oracle2+'球</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}else if(code[0]=="CBF"){//86
									if(ststr==""){
										result="";
									}else{
										result=ststr[1].split(":")[0];
										jjsp='('+ststr[1].split(":")[1]+')';
										if(result=="90"){
											result="胜其它";
										}else if(result=="99"){
											result="平其它";
										}else if(result=="09"){
											result="负其它";
										}else {
											result=result.substr(0,1)+":"+result.substr(1,1);
										}
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2.replace(/9:0/g,"胜其他").replace(/9:9/g,"平其他").replace(/0:9/g,"负其他")+'</em>'+jjsp+'</span>';
													}else{
														html += '<span>'+oracle2.replace(/9:0/g,"胜其他").replace(/9:9/g,"平其他").replace(/0:9/g,"负其他")+'</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/9:0/g,"胜其他").replace(/9:9/g,"平其他").replace(/0:9/g,"负其他")+'</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}else if(code[0]=="BQC"){//87
									if(ststr==""){
										result="";
									}else{
										result=ststr[2].split(":")[0];
										result=result.substr(0,1)+"-"+result.substr(1,1);
										jjsp='('+ststr[2].split(":")[1]+')';
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j] == result){
														html += '<span><em class="yellow">'+oracle2.replace("3-3","胜-胜").replace("3-1","胜-平").replace("3-0","胜-负").replace("1-3","平-胜").replace("1-1","平-平").replace("1-0","平-负").replace("0-3","负-胜").replace("0-1","负-平").replace("0-0","负-负")+'</em>'+jjsp+'</span>';
													}else{
														html += '<span>'+oracle2.replace("3-3","胜-胜").replace("3-1","胜-平").replace("3-0","胜-负").replace("1-3","平-胜").replace("1-1","平-平").replace("1-0","平-负").replace("0-3","负-胜").replace("0-1","负-平").replace("0-0","负-负")+'</span>';
													}
												}else{
													html += '<span>'+oracle2.replace("3-3","胜-胜").replace("3-1","胜-平").replace("3-0","胜-负").replace("1-3","平-胜").replace("1-1","平-平").replace("1-0","平-负").replace("0-3","负-胜").replace("0-1","负-平").replace("0-0","负-负")+'</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}else if(code[0]=="SXP"){
									if(result != ""){
										var sx=[];
										  sx[0]="下双";
										  sx[1]="下单";
										  sx[2]="上双";
										  sx[3]="上单";
										result=ststr[3].split(":")[0];
										jjsp='('+ststr[3].split(":")[1]+')';
										result=sx[result*1];
									}
									html += '<tr><td><div class="tdleft gray">&nbsp;';
									for(var i=0;i<code1.length;i++){
										if( id == code1[i].split("=")[0]){
											var oracle = code1[i].split("=")[1].split('/');
											for(var j=0;j<oracle.length;j++){
												var oracle2 = oracle[j];
												if(result != ""){
													if(oracle[j].replace(/0/g,"下双").replace(/1/g,"下单").replace(/2/g,"上双").replace(/3/g,"上单") == result){
														html += '<span><em class="yellow">'+oracle2.replace(/0/g,"下双").replace(/1/g,"下单").replace(/2/g,"上双").replace(/3/g,"上单")+'</em>'+jjsp+'</span>';
													}else{
														html += '<span>'+oracle2.replace(/0/g,"下双").replace(/1/g,"下单").replace(/2/g,"上双").replace(/3/g,"上单")+'</span>';
													}
												}else{
													html += '<span>'+oracle2.replace(/0/g,"下双").replace(/1/g,"下单").replace(/2/g,"上双").replace(/3/g,"上单")+'</span>';
												}
											}
										}
									}
									html += '</div></td></tr>';
								}
								});	
								html += '</table>';
								html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:   '+chuan+'</td></tr></table>';
								$('#clasli').html(html);
								var code = codes.split('|');
								if(code[1].indexOf("$")!=-1){
									var dcode =code[1].split('$');
									var dcode1 =dcode[0].split(',');
									for(var ji =0;ji<dcode1.length;ji++){
										var mid=dcode1[ji].split('=')[0];
										$("#dan"+mid).html("胆");
									}
								}
						}
					}
				});	
			}
		},
		gyj_clasli:function(lotid,pid,projid,codes){
			$.ajax({
				url : "/data/guoguan/" + lotid + "/" + pid + "/proj/" + projid.toLowerCase() + ".xml",
				type : "GET",
				dataType : "xml",
				cache : false,
				success : function(xml) {
					var R = $(xml).find("items");
					var r = R.find("item");
					var html='';
					html = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTitle mgTop06"><tr>';
					html += '<td width="15%">编号</td><td width="70%">投注选项</td><td width="15%" style="border-right:none">状态</td>';
					html += '</tr></table>';
					html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTable">';
					if(lotid == 98){
						r.each(function(a){
							var id = $(this).attr("id");// 场次编号
							var hn = $(this).attr("name");// 主队
							var audit = $(this).attr("audit");// 审核
							var spvalue = $(this).attr("spvalue");// 出票参考SP
							var result = $(this).attr("result");// 开奖结果
							var c = parseInt($(this).attr("cancel"));// 场次是否取消 
							 if(c==""){c=0;}
							 var sp="";
							 if(c!=0){
								 result="取消";
								 sp="1.00";
							 }else{
								 if(audit==1 && result !=""){
									 if(result==3){
										 result="<font color=red>胜出</font>";
									 }else{
										 result="出局";
									 }
								 }else{
									 result="未开奖";
								 }
								 sp=spvalue;
							 }
							html += '<tr id="'+id+'"><td '+(a==0?"width='15%'":"")+'>'+ id +'</td>';
					  		html += '<td '+(a==0?"width='70%'":"")+'>'+ hn+sp +'</td>';
				  			html += '<td '+(a==0?"width='15%'":"")+' calss="r9last">'+ result +'</td></tr>';
						});
						html += '</table>';
						html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:  单关</td></tr></table>';
						$('#clasli').html(html);
						
					}else{
						html += '<tr><td>'+codes+'&nbsp;&nbsp;&nbsp;待开发</td></tr></table>';
						$('#clasli').html(html);
					}
						
				}
			});	
			
		},
		lzc_clasli:function(lotid,expect,ccodes){//胜负彩/r9/半全场/进球彩
			var gid="";
			var exp = expect;
			switch (lotid+""){
			case "80":
			case "81":
				gid=1;
				break;
			case "82"://进球
				gid=2;
				break;
			case "83":
				gid=3;
				break;
			default:
				break;
			}
			$.ajax({
				url : "/trade/m.go",
				type : "POST",
				dataType : "xml",
				data:{
		            	gid:gid,
		            	pid:exp
		        },
				success : function(xml) {
					var R = $(xml).find("Resp");
					var rr = R.find("row");
					var aar =  new Array();
					var i=0;
					var html = '';
					html += '<table class="lcbetTitle" width="100%" border="0" cellspacing="0" cellpadding="0">';
					html += '<tbody><tr>';
					html += '<td width="13%">场次</td><td width="51%">主队vs客队</td><td width="18%">投注</td><td width="18%" style="border-right:none">比分</td>';
					html += '</tr></tbody></table>';
					html += '<table class="lcbetTable lcbetTable2" width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>';
					var n = '1';
					var bb = rr.length;
					rr.each(function(aa){
						var mid = $(this).attr("mid");//场次
						var hn = $(this).attr("hn");//主队
						var gn = $(this).attr("gn");//客队
						var result = $(this).attr("rs");
						var ms = $(this).attr("ms");
						var ss = $(this).attr("ss");
						var bf = '--';
						if(ms != '' && ss != ''){
							bf = ms+':'+ss;
						}
						aar[i] = result;
						i++;
						
						if(lotid == '80'){//胜负彩
							html += '<tr><td '+(aa==0?"width='13%'":"")+'>'+mid+'</td><td '+(aa==0?"width='51%'":"")+'>'+hn+'<em class="fontSize07">VS</em>'+gn+'</td><td '+(aa==0?"width='18%'":"")+' id = id'+(mid-1)+'>0</td><td '+(aa==0?"width='18%'":"")+'>'+bf+'</td></tr>';
						}else if(lotid == '81'){
							html += '<tr><td width="13%">'+mid+'</td><td width="51%">'+hn+'<em class="fontSize07">VS</em>'+gn+'</td><td width="18%" id = id'+(mid-1)+'>0</td><td width="18%" class="r9last">'+bf+'</td></tr>';
						}else if(lotid == '82'){
							html += '<tr><td class="'+(aa==(bb-1)?"r9Tr":"")+'" rowspan="2" '+(aa==0?"width='13%'":"")+'>'+mid+'</td><td '+(aa==0?"width='51%'":"")+'>(主)&nbsp;'+hn+'</td><td '+(aa==0?"width='18%'":"")+' id = id82z'+(mid-1)+'>0</td><td '+(aa==0?"width='18%'":"")+' rowspan="2" class="r9last '+(aa==(bb-1)?"r9Tr":"")+'">'+bf+'</td></tr>';
							html += '<tr><td '+(aa==0?"width='51%'":"")+'>(客)&nbsp;'+gn+'</td><td '+(aa==0?"width='18%'":"")+' id = id82k'+(mid-1)+'>0</td></tr>';
						}else if(lotid == '83'){//半全场
							hn = hn.substring(3);
							if(mid%2 != 0){
								html += '<tr><td '+(aa==0?"width='13%'":"")+' rowspan="2">'+n+'</td><td rowspan="2" '+(aa==0?"width='51%'":"")+'>'+hn+'<em class="fontSize07">VS</em>'+gn+'</td><td '+(aa==0?"width='18%'":"")+'><em id = id'+(mid-1)+'></em>&nbsp;(半)</td><td '+(aa==0?"width='18%'":"")+'>'+(bf == '--' ? bf : bf+'&nbsp;(全)')+'</td></tr>';
								n++;
							}else{
								html += '<tr><td '+(aa==0?"width='18%'":"")+'><em id = id'+(mid-1)+'></em>&nbsp;(全)</td><td '+(aa==0?"width='18%'":"")+'>'+(bf == '--' ? bf : bf+'&nbsp;(全)')+'</td></tr>';
							} 
						}
					});
					html += '</tbody></table>';
					$('#clasli').html(html);
							var code = ccodes.split(':');
							var code1 = code[0];
							var danstr="";
							var arr_bet="";
							var dan="";
							if(code1.indexOf("$")!=-1){
								danstr=code1.split("$")[0].split(",");
								arr_bet=code1.split("$")[1].split(",");
							}else{
								arr_bet=code1.split(",");
							}
							for(var i=0;i<arr_bet.length;i++){
								var bet_str="";
								if(danstr.length>0){
									if(danstr[i]!="#"){
										bet_str=danstr[i];
										dan='(胆)';
									}else{
										bet_str=arr_bet[i];
										dan='';
									}
								}else{
									bet_str=arr_bet[i];
									if(lotid==82){
										var zhu = '';
										var ke = '';
										if(i<4){
											if(aar[i] != ""){
												zhu = arr_bet[i*2].replace(aar[i].split(',')[0],"<font color='red'><b>"+aar[i].split(',')[0]+"</b></font>");
												ke = arr_bet[i*2+1].replace(aar[i].split(',')[1],"<font color='red'><b>"+aar[i].split(',')[1]);
											}else{
												zhu = arr_bet[i*2];
												ke = arr_bet[i*2+1];
											}
											$("#id82z"+i).html(zhu);
											$("#id82k"+i).html(ke);
										}
									}
								}
								if(bet_str=="#"){
									bet_str="";
									if(lotid == '81'){
										$("#id"+i).parent().hide();
									}
								}
								if(aar[i] != ""&& lotid!=82){
									bet_str = bet_str.replace(aar[i],"<font color='red'><b>"+aar[i]+"</b></font>");
								}
								$("#id"+i).html(bet_str+dan);
							}
				}
		     });
		},
		isKj:function(aw, ft){ //彩种、截止时间
			var kj = 0;
			var ad = aw;
			kj = parseInt(ad,10) >= 2 ? 1:0;
			return kj; 
		},
		kjcode:function(acode,gid){
			if(gid == '01' || gid == '50'){
				acode = '<cite class="red">'+acode.split("|")[0].replace(/,/g," ")+'</cite>&nbsp;<cite class="blue">'+acode.split("|")[1].replace(/,/g," ")+'</cite>';
			}else{
				acode = '<cite class="red">'+acode.replace(/,/g," ")+'</cite>';
			}
			return acode;
		}
};
function partake(){
	window.location.href = '#class=url&xo=viewpath/inuser.html&lotid='+$_lotid+'&projid='+$_projid+'&chedan='+chedan+'&title=partake';
}
function record(){
	window.location.href = '#class=url&xo=viewpath/inuser.html&lotid='+$_lotid+'&projid='+$_projid+'&chedan='+chedan+'&title=myRecord';
}
var main_return_confirm = function() {
	checkLogin(function(){
		$.ajax({
			url : $_trade.url.pcancel,
			type : "POST",
			dataType : "xml",
			data : {
				gid : $_lotid,
				hid : $_projid
			},
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					D.alert(desc);
					setTimeout(function() {
						location.reload();
					}, 3000);
				} else {
					D.alert(desc);
				}
			}
		});
	});
};
function torg(){
	checkLogin(function(){
		var baodinum = $("#bd").val();;    
	    $.ajax({
			url : "/trade/pb2g.go",
			type : 'POST',
			dataType : "xml",
			data : {
				gid : $_lotid,
				hid : $_projid,
				bnum : baodinum
			},
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					D.alert('保底转认购成功',function(){window.location.reload();});
				} else {
					D.alert(desc,function(){window.location.reload();});
				}
			}
		});
	});
};
function baodi(lnum) {
	checkLogin(function(){
		$("#zj_bd").show();
		$('#zhezhao').show();
		$('#zj_bd').css({left:parseInt(document.documentElement.clientWidth/2-$("#zj_bd").width()/2),top:parseInt(document.documentElement.clientHeight/2-$("#zj_bd").height())});
		$("#zj_bd input").select();
		$("#zj_bd input").val('1');
	});
	$('#zj_bd input').keyup(function(){
		this.value=this.value.replace(/\D/g,'');
		if($(this).val()>lnum){
			$(this).val(lnum);
		}
	});
	$('#zj_bd input').blur(function(){
		if($(this).val()==''||$(this).val()=='0'){
			$(this).val(1);
		}
	});
	$('#qx_bd,#zhezhao').click(function(){
		$('#zhezhao').hide();
		$('#zj_bd').hide();
	});
}; 
function qdbaodi(){
	$("#zj_bd").hide();
	var rg = $('#zj_bd input').val();
	var lotid = $_lotid;
	var projid = $_projid;
	$.ajax({
		url : "/trade/pshbd.go",
		type : 'POST',
		dataType : "xml",
		data : {
			gid : lotid,
			hid : projid,
			bnum : rg
		},
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				D.alert("保底成功！",function(){
					window.location.reload();
				});
			} else {
				D.alert(desc);
			}
		}
	});
}
var confirmDiv_ = "";
function JQConfirm(msg, eventHdl) {
    if (confirmDiv_ == "") {
        confirmDiv_ = '<div class="confirmClass"><div id="confirmDiv_" style="padding:5px 0px 5px 0px">' + msg + '</div><div><input type=button value="确定" onclick="'+eventHdl.replace(/'/gi,"\"")+';hideConform();" class="btn001" /><input type=button value="取消" onclick="hideConform()" class="btn001" /></div></div>';
        $('body').append(confirmDiv_);
    }
    else {
        byID("confirmDiv_").innerHTML = msg;
    }
    $('div.confirmClass').css({
        'top': ($(window).height() / 2 + $(window).scrollTop()) + 'px',
        'left': ($(window).width() - 245) / 2 + "px",
        'border': '2px solid #528ADF',
        'position': 'absolute',
        'padding': '5px',
        'background': '#pink',
        'margin': '0 auto',
        'line-height': '25px',
        'z-index': '100',
        'text-align': 'center',
        'width': '250px',
        'color': '#6D270A',
        'opacity': '0.95'
    });
    $('div.confirmClass').addClass("Fillet");
    $('div.confirmClass').show();
}
function hideConform(){$('div.confirmClass').hide();}