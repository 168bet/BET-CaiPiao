/*
* Author: weige
* Date : 2014.8.20
*/ 
/*
 * @description : 投注支付页面  目的，把所有彩种支付的页面整合在这里面
 * @author : wangwei
 */

//合买?notes=23&multiple=1&issue=1&countMoney=46&pattern=1&gid=03      &isPublic=0&rg=3&bd=1&xyText=aaaaaaaaa&wrate=5
//代购?notes=2&multiple=1&issue=1&countMoney=4&pattern=0&gid=03
//追号?notes=3&multiple=1&issue=2&countMoney=12&pattern=2gid=03        &zflag=1&
var pattern = decodeURIComponent(CP.Util.getParaHash("pattern"));//pattern 0自购   1合买 2追号
var gid = decodeURIComponent(CP.Util.getParaHash("gid"));
var pid = decodeURIComponent(CP.Util.getParaHash("pid"));
var local_gid = {'06':'ahk3','56':'11ydj','58':'pk3','20':'jxssc','54':'11x5',//快频
		'01':'ssq','50':'dlt','03':'sd','07':'qlc','51':'qxc','52':'plw','53':'pls',//慢频
		'80':'zc_sfc','81':'zc_r9'}[gid];//老足彩
/**
 * @namespace 彩种支付类
 * @name Pay
 * @author wangwei
 * @memberOf CP
 */


CP.Pay = function () {
	var c = {
			initail : function () {
				if(pattern != '' && gid != ''){
					if(pid){//有期号的彩种 比如足球类彩种
						c.secondStep(pid);
					}else{//没传期号的先要去获取期号 如：数字彩 
						c.firstStep();
					}
				}else{
					history.go(-1);
				}
				$("#slideLoop").bind("click",function(){
					 $(this).toggleClass("downHover");
					 $("#updownContent").slideToggle(400);
				});
			},
			firstStep : function () {
				gid = zeroStr(gid,2);
				$.ajax({//获取当前期号
					url : '/trade/info.go?gid='+gid,
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var pid = '';
						if(gid == '58' || gid == '54' || gid == '56' || gid == '06' || gid == '20'){//快频
							var R = $(xml).find("rowc");
							pid = R.attr('p');
						}else{
							var R = $(xml).find("rows");
							pid = R.attr('pid');
						}
						
						c.secondStep(pid);
					},
					error : function() {
						return false;
					}
				});
			},
			secondStep : function (pid) {
				var notes = decodeURIComponent(CP.Util.getParaHash("notes"));//注数
				var issue = decodeURIComponent(CP.Util.getParaHash("issue"));//多少期
				var multiple = decodeURIComponent(CP.Util.getParaHash("multiple"));//倍数
				var cMoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));//方案总金额
				$('#slideLoop p:eq(0) cite:eq(0)').html($_sys.getlotname(gid));
				if(pattern == 0){// 自购
					$('#slideLoop p:eq(1) cite').html(cMoney);
					$('#slideLoop p:eq(0) cite:eq(1)').html('第'+pid+'期');
					$('#updownContent p:eq(0) cite').html(notes+'注'+multiple+'倍');
					c.kaigan(cMoney);//应付金额
				}else if(pattern == 1){//合买
					var rg = decodeURIComponent(CP.Util.getParaHash("rg"));//认购金额
					var bd = decodeURIComponent(CP.Util.getParaHash("bd"));//认购金额
					
					var z = parseInt(rg)+parseInt(bd);
					$('#slideLoop p:eq(1) cite').html(z);
					$('#slideLoop p:eq(0) cite:eq(1)').html('第'+pid+'期');
					$('#updownContent p:eq(0) cite').html('方案总额'+cMoney+'元,认购'+rg+'元,保底'+bd+'元('+notes+'注'+multiple+'倍)');
					c.kaigan(z);//
				}else if(pattern == 2){//追号
					$('.zfMoney').hide();
					var zflag = decodeURIComponent(CP.Util.getParaHash("zflag"));//追号标识
					$('#slideLoop p:eq(1) cite').html(cMoney);
					$('#slideLoop p:eq(0) cite:eq(1)').html('自'+pid+'期起追号'+issue+'期');
					$('#updownContent p:eq(0) cite').html(notes+'注'+multiple+'倍');
					c.kaigan(cMoney);//应付金额
				}
				c.thirdStep();
				$('#pay').click(function(){
					var rPay = parseInt($('#rPay').html());
					c.zhifu(rPay, pid);
				});
			},
			thirdStep : function () {//拼投注code
				var codes = '';
				var Item = local_gid+'_PollNum';
				var poll = localStorage.getItem(Item);
				if(gid == '03' || gid == '06' || gid == '20' || gid == '07' || gid == '51' || gid == '52' || gid == '53' || gid == '54' || gid == '56' || gid == '58'){//福彩3d 排列三 排列五 七星彩 七乐彩
					if(poll != ''){
						poll = poll.split(';');
						var h = '';
						for(var n=0; n<poll.length; n++){
							var m = poll[n].split('_');
							h += '<p><em class="error"></em><i>['+m[1]+']</i>&nbsp;<span class="dstz"><o>'+m[0]+'</o></span></p>';
						}
					}
					$("#content").html(h);
					codes = c.joinString(Item);
				}else if(gid=="01" || gid=="50"){//双色球 大乐透
					var tmp = localStorage.getItem(local_gid);
					var ssqArr = tmp.split("#");
					for(var i=0;i<ssqArr.length;i++){
						var tp = ssqArr[i].split("|");
						if(tp.length==2){
							codes+=ssqArr[i]+":1:1;";
							var rb0 = ssqArr[i].split("|")[0].replace(/,/g," ");
							var rb1 = ssqArr[i].split("|")[1].replace(/,/g," ");
							var obdiv = $('<p><span class="dstz"><o>'+rb0+'</o><cite>'+rb1+'</cite></span></p>');
							$("#content").append(obdiv);
						}else{
							codes+=ssqArr[i].replace("|","$")+":135:5;";
							var drb = ssqArr[i].split("|")[0].replace(/,/g," ");
							var trb = ssqArr[i].split("|")[1].replace(/,/g," ");
							var dtrb = ssqArr[i].split("|")[2].replace(/,/g," ");
							var obdiv = $('<p><span class="dstz"><o>('+drb+")&nbsp;"+trb+'</o><cite>'+dtrb+'</cite></span></p>');
							$("#content").append(obdiv);
						}
						
					}
					codes = codes.substring(0, (codes.length-1));
				}else{//足彩
					$('#updownContent div.clearfix').hide();
					var code_ = localStorage.getItem(local_gid+'_PollNum');
					codes = code_.split('|')[1]+':1:1';
				}
				$('#codes').val(codes);
			},
			joinString : function (Item){
//				poll格式 例：7,9,5_直选_1;1,7_组三包号_2
				var poll = localStorage.getItem(Item);
				var arr = new Array();
					if(poll){
						poll = poll.split(';');
						for(var n=0; n<poll.length; n++){
							var m = poll[n].split('_');
							var c = m[0];//投注号码
							var t = m[1],w='';//玩法
							var o = '';
							if(gid == '03' || gid == '53'){//福彩3d 排列三
								var p = {'直选':'1:1','组三':'2:1','和值':'1:4','组三包号':'2:3','组六包号':'3:1/3:3'}[t];
								if (t == '直选' || t == '组三' || t == '和值' || t == '组三包号') {
									w = c.replace(/ /g, '');
									o = w + ':' + p;
								}else if (t == '组六包号') {
									w = c.split(',').length;
									p = (w>3 && '3:3') || '3:1';
									o = c + ':' + p;
								}
							}else if(gid == '54' || gid == '56'){
								var p = {'前一直选':'01:01','任选二':'02:01','前二直选':'09:01','前二组选':'11:01',
										'任选三':'03:01','前三直选':'10:01','前三组选':'12:01','任选四':'04:01'
											,'任选五':'05:01','任选六':'06:01','任选七':'07:01','任选八':'08:01'}[t];
								o = c.replace(/ /g, ',') + ':' + p;
							}else if (gid == '58') {//扑克3
								var p = {'选一':'01:01','选二':'02:01','选三':'03:01','选四':'04:01','选五':'05:01','选六':'06:01','对子':'11:01','豹子':'10:01','顺子':'09:01','同花':'07:01','同花顺':'08:01'}[t];
								if(t.indexOf('选')>=0){
									w = c.replace('K','13').replace('Q','12').replace('J','11').replace('A','1').split(' ');
									for(var j = 0; j<w.length; j++){
										w[j] = zeroStr(w[j],2);
									}
									o = w + ':' +p;
								}else if(t == '对子'){
									w = c.replace('AA','01').replace('22','02').replace('33','03').replace('44','04').replace('55','05')
									.replace('66','06').replace('77','07').replace('88','08').replace('99','09').replace('1010','10')
									.replace('JJ','11').replace('QQ','12').replace('KK','13');
									if(c.indexOf('包选')>=0){
										arr.push('11:16:01');
										w = w.split(' ');
										var start = w.indexOf('包选');
										w.splice(start,1);
										!!w.length && (o = w + ':' +p);
									}else{
										w = w.split(' ');
										o = w + ':' +p;
									}
								}else if(t == '豹子'){
									w = c.replace('AAA','01').replace('222','02').replace('333','03').replace('444','04').replace('555','05')
									.replace('666','06').replace('777','07').replace('888','08').replace('999','09').replace('101010','10')
									.replace('JJJ','11').replace('QQQ','12').replace('KKK','13');
									if(c.indexOf('包选')>=0){
										arr.push('10:15:1');
										w = w.split(' ');
										var start = w.indexOf('包选');
										w.splice(start,1);
										!!w.length && (o = w + ':' +p);
									}else{
										w = w.split(' ');
										o = w + ':' +p;
									}
								}else if(t == '顺子'){
									w = c.replace('A23','01').replace('234','02').replace('345','03').replace('456','04').replace('567','05')
									.replace('678','06').replace('789','07').replace('8910','08').replace('910J','09').replace('10JQ','10')
									.replace('JQK','11').replace('QKA','12');
									if(c.indexOf('包选')>=0){
										arr.push('09:14:01');
										w = w.split(' ');
										var start = w.indexOf('包选');
										w.splice(start,1);
										!!w.length && (o = w + ':' +p);
									}else{
										w = w.split(' ');
										o = w + ':' +p;
									}
								}else if(t == '同花'){
									w = c.replace('黑桃','01').replace('红桃','02').replace('梅花','03').replace('方片','04');
									if(c.indexOf('包选')>=0){
										arr.push('07:12:01');
										w = w.split(' ');
										var start = w.indexOf('包选');
										w.splice(start,1);
										!!w.length && (o = w + ':' +p);
									}else{
										w = w.split(' ');
										o = w + ':' +p;
									}
								}else if(t == '同花顺'){
									w = c.replace('黑桃顺子','01').replace('红桃顺子','02').replace('梅花顺子','03').replace('方片顺子','04');
									if(c.indexOf('包选')>=0){
										arr.push('08:13:01');
										w = w.split(' ');
										var start = w.indexOf('包选');
										w.splice(start,1);
										!!w.length && (o = w + ':' +p);
									}else{
										w = w.split(' ');
										o = w + ':' +p;
									}
								}
							}else if(gid == '06'){//安徽快3
								w = c.replace(/ /g, ",");
								var p = {'和值':'1:4','三同号通选':'2:1','三同号单选':'3:1','三不同号':'4:1','三连号通选':'5:1','二同号复选':'6:1','二同号单选':'7:1','二不同号':'8:1'}[t];
								var o = '';
								if(p == '1:4'){
									var r = c.split(' ');
									if(r[0] == '3'){
										if(r[r.length-1] == '18'){
											r.splice(0,1);
											r.pop();
											if(r.length>=1){
												o = '1,1,1:3:1;'+ r + ':' + p +';6,6,6:3:1';
											}else{
												o = '1,1,1:3:1;6,6,6:3:1';
											}
										}else{
											r.splice(0,1);
											if(r.length>=1){
												o = '1,1,1:3:1;'+ r + ':' + p;
											}else{
												o = '1,1,1:3:1';
											}
										}
									}else if(r[r.length-1] == '18'){
										r.pop();
										if(r.length>=1){
											o = r + ':' + p +';6,6,6:3:1';
										}else{
											o = '6,6,6:3:1';
										}
									}else{
										o = w + ':' + p;
									}
								}else if(p == '2:1'){
									o = '0,0,0:'+ p;
								}else if(p == '3:1'){
									var r = c.split(' ');
									for(var j=0; j<r.length; j++){
										o += r[j].substr(-1) +','+ r[j].substr(-1) +','+ r[j].substr(-1) +':'+ p +(j == (r.length-1)?'':';');
									}
								}else if(p == '5:1'){
									o = '0,0,0:'+ p;
								}else if(p == '6:1'){
									var r = c.split(' ');
									for(var j=0; j<r.length; j++){
										o += r[j].substr(0,1) + (j == (r.length-1)?'':',');
									}
									o += ':'+ p;
								}else if(p == '7:1'){
									var r = c.split('|');
									var u = r[0].split(',');
									for(var j=0; j<u.length; j++){
										o += u[j].substr(0,1) + (j == (u.length-1)?'':',');
									}
									o = o +'|'+ r[1] +':'+ p;
								}else{
									o = w + ':' + p;
								}
							}else if(gid == '20'){//江西时时彩
								var o = '';
								var p = {'大小单双':'11','一星直选':'1','二星直选':'2','三星直选':'3','五星直选':'5','五星通选':'12','二星组选':'10:1','三星组三':'15','三星组六':'16','二星和值':'10:4'}[t];
								if(p == '11'){//11:1
									w = c.replace(/ /g, ",");
									w = w.replace(/大/g,'2').replace(/小/g,'1').replace(/单/g,'5').replace(/双/g,'4');
									o = w + ':' + p + ':1';
								}else if(p == '1'){//单式1：1复式1：2
									w = c.split(' ');
									var w1 = (w.length>1&&'2')||'1';
									w = w.join('');
									o = w + ':' + p +':'+ w1;
								}else if(p == '2' || p == '3' || p == '5'){//2(单式2：1复式 ) 3( 单式3：1复式3：2) 5(单式5：1复式5：2)
									w = c.replace(/ /g,',');
									var w1 = c.replace(/ /g,'');
									w1 = w1.split('').length;
									w1 = (w1>p&&'2')||'1';
									o = w + ':' + p +':'+ w1;
								}else if(p == '12'){//12:1
									w = c.replace(/ /g,',');
									o = w + ':' + p +':1';
								}else if(p == '10:1'){//单式10：1复式10：3
									w = c.replace(/ /g,',');
									var w1 = c.split(' ');
									w1 = (w1.length>2&&'10:3')||'10:1';
									o = w + ':' + w1;
								}else if(p == '15'){//单式15：1复式15：3(这版不做单式)
									w = c.replace(/ /g,',');
									o = w + ':' + p +':3';
								}else if(p == '16'){//单式16：1复式16：3
									w = c.replace(/ /g,',');
									var w1 = c.split(' ');
									w1 = (w1.length>3&&'16:3')||'16:1';
									o = w + ':' + w1;
								}else if(p == '10:4'){//10：4
									w = c.replace(/ /g,',');
									o = w + ':' + p;
								}
							}else{
								var p = {'52':'23:1'}[gid]||'1:1';
								o = c + ':' +p;
							}
							!!o && arr.push(o);
						}
					}
				var str = arr.join(";");
				return str;
			},
			diao : function(m, r, hb){//m用户余额 r应付金额 hb使用红包金额
				$('#rPay').html(hb);//红包支付
				$('#mPay').html(r-hb);//账户支付
				hb = parseFloat(hb);
				r = parseFloat(r);
				if((m+hb)<r){
					var ce = Math.ceil(r-(m+hb));
		    		$('#chae').parent().show();
		    		$('#chae').html(ce);//差额
		    		$('.moneyNum').val(ce);
		    		$('#cz').show();
		    		$('#pay').hide();
		    	}else{
		    		$('#chae').parent().hide();
		    		$('#pay').show();
		    		$('#cz').hide();
		    		$('#recharge').hide();
		    	}
			},
			kaigan : function (r) {//应付金额
				$.ajax({
			        url: $_user.url.base,
			        success:function (data){
			        	var R = $(data).find("Resp");
			        	var U = R.find("row");
			        	var rb = U.attr("ipacketmoney");
			        	if(rb>0 && pattern!=2){
			        		$('.zfMoney').show();
			        	}
			        	var m = parseFloat(U.attr("usermoeny"));
			        	$('#yue').html(m);//账户余额
			        	c.diao(m, r, 0);
			        }
				});
				
				$('#redPacket').click(function(){
					var m = parseFloat($('#yue').html());
					c.use_red(m,r);
				});
				$('#cz').click(function(){
					$(this).hide();
					$('#recharge').show();
				});
			},
			zhifu : function (rPay, pid) {
				if(pattern == 2){
					c.dozh(rPay,pid);//追号
				}else{
					c.dobuy(rPay,pid);//代购合买
				}
			},
			use_red : function (m, r) {
				if($('#packet div.zfRed').html() == ''){
					$.ajax({
						url:'/user/queryRpinfo.go',
						type:'post',
						dataType:'xml',
						data:{
							trade_gameid:gid,
							trade_imoney:parseInt($('#mPay').html()),
							trade_isource:'0'
						},
						success:function(xml){
							var R = $(xml).find('rows');
							var r = R.find('row');
							var html = '';
							r.each(function(i){
								var cptid = $(this).attr('cptid');//红包编号
								var crpname = $(this).attr('crpname');//红包名
								var irmoney = $(this).attr('irmoney');//红包余额
								var cddate = $(this).attr('cddate');//红包过期时间
								var kymoney = $(this).attr('kymoney');//可用红包
								if(kymoney == ''){
									kymoney ='0';
								}
								html += '<div class="clearfix pdLeft08">';
								html += '<em kymoney="'+kymoney+'" cptid="'+cptid+'" id="checkbtn" class="left '+(i==0? 'check' : 'nocheck' )+'"></em>';
								html += '<div class="left w15"><p>【'+crpname+'】余额'+irmoney+'元，本次可用<cite class="yellow">'+kymoney+'</cite>元</p><p class="pdTop03">过期时间：'+(cddate == '' ? '无限制':cddate)+'</p></div></div>';
							});
							$('#packet div.zfRed').html(html);
							$('#packet div.zfRed div.clearfix').click(function(){
								if($(this).find('em').attr('class').indexOf('nocheck') != '-1'){
									$('#packet div.zfRed div.clearfix em').attr('class','left nocheck');
									$(this).find('em').attr('class','left check');
								}else{
									$(this).find('em').attr('class','left nocheck');
								}
							});
						}
					});
				}
				$('#packet').show();
				$('#zhezhao').show();
				$('#packet').css({left:parseInt(document.documentElement.clientWidth/2-$("#packet").width()/2),top:parseInt(document.documentElement.clientHeight/2-$("#packet").height())});
			
				$('#packet div.zfTrue a:eq(0)').click(function(){//取消
					$('#packet').hide();
					$('#zhezhao').hide();
				});
				$('#packet div.zfTrue a:eq(1)').click(function(){//确定
					var rb = $(".zfRed em.check").attr('kymoney');
					var cptid = $(".zfRed em.check").attr('cptid');
					
					if(rb == undefined){
						rb = '0';
						cptid = '';
					}else{
						rb = parseFloat(rb);
					}
					$('#cptid').val(cptid);//红包编号存在隐藏域里面
					$('#packet').hide();
					$('#zhezhao').hide();
					c.diao(m, r, rb);
				});
			},
			dobuy : function (rPay, pid) {
				var cupacketid = $('#cptid').val();
				var codes = $('#codes').val();
				var muli = decodeURIComponent(CP.Util.getParaHash("multiple"));
				var countMoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));//方案总金额
				var data = {};
				gid = zeroStr(gid,2);
				if(pattern == 0){//代购
					data = {
			             	gid:     gid,//彩种编号
			             	pid:     pid,//期号
			             	play:    '1',//玩法 复式1   单式0
			             	codes:   codes,//投注内容
			             	muli:    muli,//方案倍数
			             	fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
			             	type:    '0 ',//方案类型0 代购   1合买
			             	name:    '自购',//方案宣传标题
			             	desc:    '自购',//方案宣传内容
			             	money:   countMoney,//方案金额
			             	tnum:    '1',//方案总份数
			             	bnum:    '1',//购买份数
			             	pnum:    '0',//保底份数
			             	oflag:   '0',//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
			             	wrate:   '0',//提成比例
			             	comeFrom:'',//用户来源
			             	source:  CP.Data.source,//方案来源
			             	endTime: '',//方案截止时间
			             	upay:    '',//是否订单支付
			             	cupacketid: cupacketid,//红包id
			             	redpacket_money: rPay//使用红包金额
			             };
				}else if(pattern == 1){//合买
					var oflag = decodeURIComponent(CP.Util.getParaHash("isPublic"));//方案查权限
					var xyText = decodeURIComponent(CP.Util.getParaHash("xyText"));//方案宣言
					var bd = decodeURIComponent(CP.Util.getParaHash("bd"));//保底金额
					var wrate = decodeURIComponent(CP.Util.getParaHash("wrate"));//提成
					
					var bnum = decodeURIComponent(CP.Util.getParaHash("rg"));//认购金额
					data = {
							gid:     gid,//彩种编号
			             	pid:     pid,//期号
			             	play:    '1',//玩法 复式1   单式0
			             	codes:   codes,//投注内容
			             	muli:    muli,//方案倍数
			             	fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
			             	type:    '1',//方案类型0 代购   1合买
			             	name:    '合买',//方案宣传标题
			             	desc:    xyText,//方案宣传内容
			             	money:   countMoney,//方案金额
			             	tnum:    countMoney,//方案总份数
			             	bnum:    bnum,//购买份数
			             	pnum:    bd,//保底份数
			             	oflag:   oflag,//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
			             	wrate:   wrate,//提成比例
			             	comeFrom:'',//用户来源
			             	source:  CP.Data.source,//方案来源
			             	endTime: '',//方案截止时间
			             	upay:    '',//是否订单支付
			             	cupacketid: cupacketid,//红包id
			             	redpacket_money: rPay//使用红包金额
				         };
				}
				 $.ajax({
		        	 url: $_trade.url.pcast,
		             type:'POST',
		             data: data,
		             success:function(xml){
		             	var R = $(xml).find("Resp");
		     			var code = R.attr("code");
		     			var desc = R.attr("desc");
		     			var r = R.find('result');
		     			if (code == "0") {
		 					if(gid == '01' || gid=="50"){
	        					localStorage.removeItem(local_gid);
			        		}else{
			        			localStorage.removeItem(local_gid+'_PollNum');
			 					localStorage.removeItem(local_gid+'_SelectNum');
			        		}
		     				var projid = r.attr('projid');
		     				window.location.replace('#class=url&xo=success/great.html&lotid='+gid+'&projid='+projid);
		     			} else {
		     				D.alert(desc);
		     			}
		            }
				 });
			},
			dozh : function (rPay, pid) {
				var codes = $('#codes').val();
				var muli = decodeURIComponent(CP.Util.getParaHash("multiple"));
				var countMoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));//方案总金额
				var zflag = decodeURIComponent(CP.Util.getParaHash("zflag"));
				var qs = parseInt(decodeURIComponent(CP.Util.getParaHash("issue")));
				var mulitys = '';
				for(var i=0;i<qs;i++){
					mulitys += muli+',';
					pid += ',';
				}
				pid = pid.substring(0, pid.length-1);
				mulitys = mulitys.substring(0, mulitys.length-1);
				var data = {};
				gid = zeroStr(gid,2);
				data = {
		             	gid:     gid,//彩种编号
		             	pid:     pid,//期号串
		             	codes:   codes,//投注内容
		             	mulitys: mulitys,//方案倍数串
		             	zflag:   zflag,//中奖是否停止0  中奖不停止  1  中奖停止  3 盈利停止
		             	ischase: '1',//追号标志1 追号
		             	money:   countMoney,//追号金额
		             	source:  CP.Data.source,//方案来源
		             	upay:    ''//是否订单支付
		             };
				 $.ajax({
		        	 url: $_trade.url.zcast,
		             type:'POST',
		             data: data,
		             success:function(xml){
		            	var R = $(xml).find("Resp");
		    			var code = R.attr("code");
		    			var desc = R.attr("desc");
		    			var z = R.find('zhuihao');
		    			if (code == "0") {
		 					if(gid == '01' || gid=="50"){
	        					localStorage.removeItem(local_gid);
			        		}else{
			        			localStorage.removeItem(local_gid+'_PollNum');
			 					localStorage.removeItem(local_gid+'_SelectNum');
			        		}
		    				var projid = z.attr('id');
	        				window.location.replace('#class=url&xo=success/great.html&lotid='+gid+'&tid='+projid);
		    			} else {
		    				D.alert(desc);
		    			}
		            }
				 });
			}
			
	};
	var d = function (){
		c.initail();
	};
	return {
		init : d
	};
}();
CP.Pay.init();


