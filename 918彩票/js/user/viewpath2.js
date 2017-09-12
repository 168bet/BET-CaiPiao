CP.Viewpath = (function () {
	var $_hid = CP.Util.getPara('hid', window.location.href, 2);//方案编号
	var $_gid = $_hid.substr(0, 2);//彩种id
	var $dom = {
			hemai : $('#hemai'),//合买层
			zigou : $('#zigou')//代购层
	};
	var myScroll;
	var allUser = {//跟单用户翻页 初始化
			cPage : '1',//初始化的时候显示第一页
			total : '1'//默认总页数为1
	};
	var g = {
			rnickid : '',//方案的发起人 ---这个是没有屏蔽手机号的哟
			cnickid : '',//方案的发起人  --- 带星星的
			myName : '',//当前用户
			iopen : ['公开','截止后公开','对跟单用户公开','截止后对跟单用户公开'],
			gdUser : true,//跟单用户 默认true 要加载 第二遍不加载
			myRecord : true,//我的认购记录 同上
			content : true,//合买内容 同上
			grade_def : {
				'80' : "一等奖,二等奖",
				'81' : "一等奖",
				'82' : "一等奖",
				'83' : "一等奖",
				'01' : "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖",
				'03' : "直选,组选三,组选六",
				'04' : "五星奖,三星奖,二星奖,一星奖,大小单双,二星组选,五星通选一等奖,五星通选二等奖,五星通选三等奖",
				'05' : "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号",
				'06' : "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号",
				'07' : "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,七等奖",
				'08' : "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号",
				'09' : "和值,三同号通选,三同号单选,三不同号,三连号通选,二同号复选,二同号单选,二不同号",
				'20' : "五星奖,四星一等奖,四星二等奖,三星奖,二星奖,一星奖,大小单双,二星组选,五星通选一等奖,五星通选二等奖,五星通选三等奖,任选一,任选二,三星组三,三星组六",
				'50' : "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,七等奖,八等奖,生肖乐,追加一等奖,追加二等奖,追加三等奖,追加四等奖,追加五等奖,追加六等奖,追加七等奖,,宝钻一等奖,宝钻二等奖,宝钻三等奖,宝钻四等奖",
				'501' : "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,追加一等奖,追加二等奖,追加三等奖,追加四等奖,追加五等奖,,,,,,",
				'51' : "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖",
				'52' : "一等奖",
				'53' : "直选,组三,组六",
				'54' : "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选",
				'55' : "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选",
				'56' : "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选",
				'57' : "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选",
				'58' : "任选一,任选二,任选三,任选四,任选五,任选六,同花,同花顺,顺子,豹子,对子,同花包选,同花顺包选,顺子包选,豹子包选,对子包选"
			}
	
			
	};
	var againstData = {};//pinfo接口里面的参数
	var u = {
			getwininfo : function(lotid, wininfo,pid) {
				var tmp = [];
				var lotid_be = ['70','71','72','84','85','86','87','88','89','90','91','92','93','94','95','96','97','98','99'];
				if (lotid_be.indexOf(lotid) != '-1'){		
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
						var grade = g.grade_def[aa].split(',');
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
			},
			kjcode:function(acode,gid){
				if(gid == '01' || gid == '50'){
					acode = '<cite class="red">'+acode.split("|")[0].replace(/,/g," ")+'</cite>&nbsp;<cite class="blue">'+acode.split("|")[1].replace(/,/g," ")+'</cite>';
				}else{
					acode = '<cite class="red">'+acode.replace(/,/g," ")+'</cite>';
				}
				return acode;
			},
			code_58 : function(c) {//快乐扑克3开奖号码
				var kjcode = c.split(',');
				var ncode = '';
				if(kjcode != ''){
					for(var j=0;j<kjcode.length;j++){
						var aa = kjcode[j].substr(0,1);
						var bb = parseInt(kjcode[j].substr(1));
						aa = {'1':'黑桃','2':'红桃','3':'梅花','4':'方片'}[aa];
						bb = {'1':'A','2':'J','3':'Q','4':'K'}[bb] || bb;
						ncode += aa+bb;
						if(j != (kjcode.length-1)){
							ncode +=',';
						}
					}
				}
				return ncode;
			}
	};
	var o = {
			//页面跳转
	        pageGo: {
	            goBack: function () {
	            	var title = '';
	            	if(againstData.itype == '1'){
	            		if(parseInt(CP.Data.white_list_grade)>0){
	            			title = '预约详情';
	            		}else{
	            			title = '合买详情';
	            		}
	            			
	            	}else if(againstData.itype == '0'){
	            		if(parseInt(CP.Data.white_list_grade)>0){
	            			title = '预约详情';
	            		}else{
	            			title = '自购详情';
	            		}
	            	}
	            	CP.Data.grade(function(){
	            		TopAnch.init({
		            		title:title,
		            		prevShow:true,
		            		prevFun:function(){//左侧按钮绑定事件
		            			if(history.length >1){
		            				window.history.back();
		            			}else{
		            				location.href='/';
		            			}
		            		},
		            		isBack:true,
		            		nextShow:true,
							nextText:function(){
								return parseInt(CP.Data.white_list_grade)>0?"继续预约":"去投注"
							},
							nextFun:function(){
								if($_gid=="98"||$_gid=="99"){
									location.href='/activity/ozb/';
								}else{
									location.href='#type=url&p=list/'+CP.Util.lot($_gid,1)+'.html';
								}
							}
		            	});
	            	})
	            }
	        },
	        //合买的时候 判断是不是本人
	        ww_bdi : function (istate, pnum, lnum){
	        	$.ajax({
	                url: CP.Data.apps+'/user/query.go?flag=6',
	                dataType : "xml",
	                success:function (data){
	                	var R = $(data).find("Resp");
	                	var U = R.find("row");
	                	g.myName = U.attr("nickid");
	                	var baodi = '';
	    				if(g.myName == g.rnickid && istate == 1){
	    					$('.buyFooter a').html('继续购买');
	    					$('#cancelD').show();
	    					if(istate > 0 && istate < 2){
	    						if((g.myName == g.rnickid) && istate != 0){
	    							if(pnum == 0){
	    								baodi = '<a class="fqhm" href="javascript:;" onclick=\'baodi('+lnum+')\'>追加保底</a>';
	    							}else{
	    								baodi = '<a class="fqhm" href="javascript:;" onclick=\'torg()\'>保底转认购</a>';
	    							}
	    						}
	    					}
	    				}
	    				$('#ww_bdi').append(baodi);
	                }
	        	});
	        },
	        //方案状态优化显示
	        slide : function (option) {
	        	var Q = option || {};
	        	var node = Q.attr('node');//1
	        	var percent = Q.attr('percent');//70
	        	var pai_ = Q.attr('paint');//等待出票
	        	var Q2 = .8*$('#em_em').width()+$('#i_i').width();//一个节点的长度 单位px
	        	var Q3 = Q2*(parseInt(node)-1) + Q2*percent/100;//一共要滑的路程
	        	if(percent == '100'){
	        		Q3 += .9*$('#em_em').width();
	        	}
	        	var paint = $('#f_paint');
	        	var paint_ = $('#s_paint');
	        	if(againstData.itype != '1'){
	        		paint = $('#f_paint_zg');
	        		paint_ = $('#s_paint_zg');
	        		
	        	}
	        	paint_.html(pai_);
	        	var Q6 = paint_.width()/2;//箭头的位置是 需要Q3减去Q6的一半
	        	paint.animate({width:Q3+'px'}, 1e3);
	        	paint_.animate({left:(Q3-Q6-3)+'px'}, 1e3);
	        	if(pai_ == '处理中'){
	        		setTimeout(function(){
	        			window.location.reload();
	        		},2e3);
	        	}
	        },
			//渲染
			render : function (option) {
				var t = option || {};
				console.log("aaa")
				o.slide(t.jindu_);
				if (t.itype == '1') {//合买方案
					$dom.hemai.show();
					/*填充基本信息*/
					$("#lot_title").html('合买详情');
					$('#authority cite').html(g.iopen[parseInt(t.iopen,10)]);
					$('#gType').html(CP.Util.lot(t.gid));
					$('#expect').html(t.pid+'期');
					$('#uName').html(g.cnickid);
					$('#rank').html('L'+t.aunum);
					$('#rg').html(t.jindu+'%');
					$('#bd').html('保&nbsp;'+Math.floor(t.pnum/t.tmoney*100)+'%');//向下取整 避免出现保底+认购大于100%显示未满员
					$('#rgDetail').html('总额<em class="yellow">'+t.tmoney+'元</em>(保底'+t.pnum+'元，提成'+t.wrate+'%)');
					$('#surplus').html('剩余<em class="yellow">'+t.lnum+'元</em>');
					$('#tDetail').html('<p>编号 :'+t.hid+'</p><p>时间 : '+t.btime+'</p>');
					$('#cdesc').html(t.cdesc = t.cdesc == "null" ? "快乐购彩" : "方案宣言:"+t.cdesc);
					$('#views').html(t.views+'人');
					$("#bd").val(t.pnum);
					
					/*是否保 底[[*/
					o.ww_bdi(t.istate, t.pnum, t.lnum);
					/*]]是否保底*/
					kj = parseInt(t.award,10) >= 2 ? 1:0;//1已记奖 0未记奖
					/* 1  撤单
					 * 2 出票中
					 * 3等待出票
					 * 5出票成功
					 * 6已开奖
					 * 7已计奖
					 * 8派奖中
					 * 12已派奖
					 * 13未支付
					 * 14自动跟单中
					 * else 发起
					 * */
					var isflg = 0;
					if(t.istate>0){
						isflg = (t.icast == 3) ? (t.istate > 2 ? 1 : 5) : (t.istate > 2 && t.istate<6) ? 1 : (t.icast == 2) ? 2 : 3; //出票状态5
						isflg = (kj == 1) ? ((isflg == 5) ? 6 : isflg ) : isflg; //开奖状态6
						isflg = (t.award == 2) ? ((isflg == 6) ? 7 : isflg ) : isflg;//计奖状态7
						isflg = (t.ireturn == 2) ? ((isflg == 7) ? 12 : isflg) : (t.ireturn == 1) ? ((isflg == 7)? 8 : isflg) : isflg; // 派奖中、已派奖
					}else{
						if(t.istate=="0"){
							isflg = 14;
						}else{
							isflg = 13;
						}
					}
					if(t.lnum >0){
						if (isflg == '2' || isflg == '3' || isflg == '5') {
							$('.buyFooter').show();
						}
					}
					/*开奖号码的显示[[*/
					$('#kjCodes').show();
					var kj_ = t.acode;
					if(t.acode == undefined){
						$('#kjCodes').hide();
					}else{
						if(isflg == 1){
							if(t.acode == ''){
								kj_ = '未开奖';
							}
						}else{
							if(t.acode != ''){
								kj_ = u.kjcode(t.acode,t.gid);
							}else{
								if(t.gid == '01' || t.gid == '07'||t.gid == '50' || t.gid == '03' || t.gid == '53' || t.gid == '51' || t.gid == '52'){
									kj_ += '<cite class="gray fontSize07 pdLeft06"> '+t.jindu_.attr('kjtime')+'开奖</cite>';
								}else{
									kj_ = '等待开奖';
								}
							}
						}
						$('#kjCodes span').html(kj_);
					}
					/*]]开奖号码的显示*/
					
					/*中奖情况的显示[[*/
					if (t.award == "2") {//合买中奖情况
						var wininfostr = "";
						if (t.rmoney > 0) {
							if (t.istate == 3 || t.istate == 4) {
								wininfostr = "<font class='yellow'>该撤单方案中奖"+parseFloat(t.rmoney)+"元</font>";
							} else {
								wininfostr = "<font class='yellow'>此方案共中奖"+t.rmoney+"元</font>";
							}
							wininfostr += "<br/>("
								+ "税前<font class='yellow'>"
								+ parseFloat(t.rmoney)
								+ "元</font>,税后<font class='yellow'>"
								+ parseFloat(t.tax)+"元</font>)";
							var zj = u.getwininfo(t.gid, t.wininfo, t.pid);
							for ( var i = 0; i < zj.length; i++) {
								wininfostr += "<br/>" + zj[i][0]
										+ " " + zj[i][1] + "注";
							}
							if (t.itype == 1 && t.istate != 3&& t.istate != 4) {
								wininfostr += "<br />发起人提成:"
										+ parseFloat(t.owins)
										+ "元,每元中"
										+ parseFloat(t.avg)
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
					/*]]中奖情况的显示*/
				} else {//代购方案
					$("#lot_title").html('自购详情');
					$dom.zigou.show();
					console.log("bbb")
					if(t.acode == undefined){
						console.log(t.gid)
						if(t.gid==84 ||t.gid==85 ||t.gid==86 ||t.gid==87 ||t.gid==88 ||t.gid==89){
							console.log("ccc")
							$('#zigou p').eq(0).html(CP.Util.lot(t.gid)+'&nbsp;<cite class="fontSize07 pdLeft06">第'+t.pid+'期</cite>');
						}else{
							$('#zigou p').eq(0).html(CP.Util.lot(t.gid));
							console.log("ccc")
						}
					}else{
						
						$('#zigou p').eq(0).html(CP.Util.lot(t.gid)+'&nbsp;<cite class="fontSize07 pdLeft06">第'+t.pid+'期</cite>');
					}
					$('#zgDetail p:eq(0) em').html(t.hid);
					$('#zgDetail p:eq(1) em').html(t.btime);
					
					/*方案金额[[*/
					var hb = '';
					if(t.rpmoney>0){
						hb = '含'+t.rpmoney+'元红包 ';
					}
					$('#faje span').html(t.tmoney+'元&nbsp;('+hb+t.mulity+'倍 )');//含'+t.rpmoney+'元红包  
					/*]]方案金额*/
					
					/*开奖号码的显示[[*/
					var isflg = 0; //出票状态5
					if(t.istate>0){
						isflg = (t.icast == 3) ? (t.istate > 2 ? 1 : 5) : (t.istate > 2 && t.istate<6) ? 1 : (t.icast == 2) ? 2 : 3;
					}
					var kj_ = '';
					if(t.acode == undefined){
						$('#zgCode').hide();
					}else{
						if(isflg == 1){
							if(t.acode == ''){
								$('#zgCode').hide();
							}
						}else{
							$('#zgCode').show();
							if(t.acode != ''){
								if(t.gid=='58'){
									kj_ = u.code_58(t.acode);
								}else{
									kj_ = u.kjcode(t.acode,t.gid);
								}
							}else{
								if(t.gid == '01' || t.gid == '07'||t.gid == '50' || t.gid == '03' || t.gid == '53' || t.gid == '51' || t.gid == '52'){
									kj_ += '<cite class="gray fontSize07 pdLeft06"> '+t.jindu_.attr('kjtime')+'开奖</cite>';
								}else{
									kj_ = '等待开奖';
								}
							}
							$('#zgCode span').html(kj_);
						}
					}
					/*]]开奖号码的显示*/
					
					/*中奖情况的显示[[*/
					if (t.award == "2") {//自购中奖情况
						var wininfostr = "";
						if (t.rmoney > 0) {
							if (t.istate == 3 || t.istate == 4) {
								wininfostr = "<font class='yellow'>该撤单方案中奖"+parseFloat(t.rmoney)+"元</font>";
							} else {
								wininfostr = "<font class='yellow'>已中奖</font>";
							}
							wininfostr += "<br/>("
								+ "税前<font class='yellow'>"
								+ parseFloat(t.rmoney)
								+ "元,</font>税后<font class='yellow'>"
								+ parseFloat(t.tax)+"元</font>)";
							var zj = u.getwininfo(t.gid, t.wininfo, t.pid);
							for ( var i = 0; i < zj.length; i++) {
								wininfostr += "<br/>" + zj[i][0]
										+ " " + zj[i][1] + "注";
							}
							if (t.gid == 90&& t.addmoney > 0) {
								wininfostr += "发起人加奖金额：<font color=red>"
										+ parseFloat(t.addmoney).rmb(true)
										+ "</font>.";
							}18621835181
							if (t.itype == 1 && t.istate != 3&& t.istate != 4) {
								wininfostr += "发起人提成：<font color=red>"
										+ parseFloat(t.owins).rmb(true)
										+ "</font>,每元派送<font color=red>"
										+ parseFloat((t.tax - t.owins)/ t.nums).rmb(true)
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
					/*]]中奖情况的显示*/
					
					/*自购投注内容[[*/
					if (t.visible == 'false' && t.shareGod == '2'){
						$('#zgContent div').html('暂无法查看 ');
					} else if (t.ifile=="0"){
						if(t.source == 9){//旋转矩阵
							var gid = t.gid;
							var _out = [];
							var code = t.ccodes.split(';');
							$.each(code, function(index, val){
								var xzjzCode = val.split(':')[0];
								var val = val.split('-');
								var c = val[0].split('|');//开奖号码
								var redBall = c[0].split(',').join(' ');
								var blueBall = '';
								if(c[1]){
									blueBall = c[1].split(',').join(' ');
								}
								var xzjz = val[1];//旋转矩阵
								_out.push('<p class="pdTop06">&nbsp;[旋转矩阵(中'+xzjz.substr(xzjz.indexOf('S')+1,1)+'保'+xzjz.substr(xzjz.indexOf('E')+1,1)+')]</p>');
								_out.push('<p class="gray"><label class="red">&nbsp;'+redBall+'</label>&nbsp;<label class="blue">'+blueBall+'</label><label class="blue right" gid='+gid+' xzjz='+xzjzCode+'>查看详情</label></p>');
								
							});
							$("#zgContent div").html(_out.join(''));
							$('#zgContent .right').off().bind('click', function(){
								var data = {
										gid : $(this).attr('gid'),
										codes : decodeURIComponent($(this).attr('xzjz'))
								};
								$.ajax({
									url:'/trade/matrixinfos.go?'+$.param(data),
									type:'POST',
									dataType:'text',
									success: function(txt){
										D.alert('<div style="overflow-x:hidden;overflow-y:scroll">'+txt+'</div>');
										if($('#dAlert div').height()>100){
											$('#dAlert div').css({
												height:'100px'
											});
										}
									}
								});
							});
						}else{
							//北单竞彩显示对阵 篮彩显示对阵
							if(t.gid==84 || t.gid==85 ||t.gid==86 ||t.gid==87 ||t.gid==88 ||t.gid==89 || t.gid==90 ||t.gid==91 ||t.gid==92 
									||t.gid==93 || t.gid == 70 || t.gid == 72||t.gid==94 ||t.gid==95 ||t.gid==96 ||t.gid==97 || t.gid==71){
								$("#zgCode").hide();
								$("#zgContent").hide();
								$('#clasli').show();
								Against.bd_jc_clasli(t.gid, t.pid, t.hid, t.ccodes, t.source);
							}
							//老足彩显示对阵
							else if(t.gid==80 ||t.gid==81 ||t.gid==82 ||t.gid==83){
								$("#zgCode").hide();
								$("#zgContent").hide();
								$('#clasli').show();
								Against.lzc_clasli(t.gid, t.pid, t.ccodes);
							}
							//冠亚军
							else if(t.gid == "99" || t.gid == "98"){
								console.log("aaa")
								$("#zgCode").hide();
								$("#zgContent").hide();
								$('#clasli').show();
								console.log(t.gid+"~~"+t.pid+"~~"+t.hid+"~~"+t.ccodes)
								Against.gyj_clasli(t.gid, t.pid, t.hid, t.ccodes);
							}
							else{
								//待开发
								$('#clasli').hide();
								var html = CP.Util.showcode(t.gid, t.ccodes);
								html = html.replace(/pdTop06/g,'');
								$('#zgContent div').html(html);
								if(t.gid=="01" || t.gid=="50" || t.gid=="03" || t.gid=="53"){
								}			
							}
						}
					}else if(t.ifile=="1"){
						$("#zgCode").hide();
						if(t.source == 6 || t.source == 7){//奖金优化
							$("#zgContent div").html('奖金优化方案&nbsp;<a href="#class=url&xo=viewpath/content.html&lotid='+t.gid+'&projid='+t.hid+'">点击查看</a>');
							$('#clasli').show();
							Against.jjyh(t.gid, t.pid, t.hid, t.ccodes);
						}
						else{
							$("#zgContent div").html('单式上传方案&nbsp;<a href="#class=url&xo=viewpath/content.html&lotid='+t.gid+'&projid='+t.hid+'">点击查看</a>');
						}
					}
					/*]]自购投注内容*/
				}
			},
			//调用pinfo.go 接口 获取方案的基本信息
			basic : function () {
				
				
				var data = {
						gid : $_gid,
						hid : $_hid,
						state : 1
				};
				$.ajax({
					url : CP.Data.apps+'/trade/pinfo.go?'+jQuery.param(data),
					dataType:'xml',
					type:'POST',
					success: function (xml) {
						$('#initLoad').hide();//接口调用成功的时候把菊花收起来
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if (code == '0') {//返回成功
							var r = R.find("row");
							var cnickid = r.attr("cnickid");// 发起人 屏蔽手机号
							var rnickid = r.attr("rnickid");
							g.cnickid = cnickid;
							g.rnickid = rnickid;
							var t = {};
							t.gid = r.attr("gid");// 游戏编号
							t.hid = r.attr("hid") ;// 方案编号
							t.itype = r.attr("type");// 方案类型（0 自购 1 合买）
							t.icast = r.attr("cast");// 出票标志（0 未出票 1 可以出票 2 已拆票 3 已出票）
							t.award = r.attr("award");// 计奖标志（0 未计奖 1 正在计奖 2 已计奖)
							t.pid = r.attr("pid");// 期次
							t.ireturn = r.attr("return");//是否派奖（0 未派奖 1 正在派 2 已派奖）
							t.wininfo = r.attr("wininfo");// 中奖信息（中奖注数用逗号隔开）
							t.visible = r.attr("visible");// 是否显示方案
							t.shareGod = r.attr("shareGod");//
							t.owins = r.attr("owins");// 发起人提成奖金
							t.rmoney = r.attr("rmoney");// 认购派奖金额（税前）
							t.mulity = r.attr("mulity");// 倍数
							t.lnum = parseInt(r.attr("lnum"));// 剩余份数
							t.pnum = parseInt(r.attr("pnum"));// 发起人保底份数
							t.aunum = r.attr("aunum");// 等级（战绩）
							t.jindu = r.attr("jindu");// 发单人认购的进度
							t.views = r.attr("views");// 跟单人数
							t.cdesc = r.attr("cdesc");// 方案宣言
							t.ccodes = r.attr("ccodes");// 投注号码
							t.etime = r.attr("etime");// 截止时间
							t.ifile = r.attr("ifile");// 是否文件投注（0不是 1 是）
							t.iplay = r.attr('iplay');
							t.tmoney = r.attr("tmoney");// 总金额
							t.iopen = r.attr("iopen");// 是否保密 （0 对所有人公开 1 截止后公开 2 对参与人员公开 3 截止后对参与人公开）
							t.wrate = r.attr("wrate");// 发起人盈利提成
							t.istate = r.attr("istate");//状态  0该方案自动跟单中，请等待 1认购中 2已满员  3系统已撤单 4发起人已撤单 5系统已撤单 -1未支付
							t.rpmoney = r.attr("rpmoney");//红包认购金额
							t.avg = r.attr("avg");//每元派奖金额
							t.tax = r.attr("tax");//税后奖金
							t.btime = r.attr("btime");//发单时间
							t.source = r.attr("source");//奖金优化6  单关配7  混投合买2串1 8
							t.addmoney = r.attr("addmoney");
							var q = R.find("qcode");
							t.acode = q.attr("acode");// 开奖号码
							t.myjoins = R.find("myjoins");//发起人的的认购记录
							t.jindu_ = R.find("jindu");
							t.chedan = (t.istate==3||t.istate==4||t.istate==5)? 3:1;
							againstData = t;
							console.log(t)
							o.render(t);
							
							$('#iNum').KeyBoard({
								val : 1,
								max : againstData.lnum,
								min : 1,
								num : 1,
								tag : '元',
								fn  : function(){
								}
							});
						} else {
							alert(desc);
							setTimeout(function () {
								window.location.replace('#type=index');
							}, 2000);
						}
					},
					error : function () {
						alert('获取信息失败 请刷新重试');
					}
				});
			},
			//初始化入口
			init : function () {
				o.basic();//首先通过gid和pojid获取 方案的基本信息
				o.bind();//初始化时候的一些个绑定事件
			},
			bind : function () {
				//发起人撤单
				$('#cancelD').bind(end_ev, function () {
					$.ajax({
						url : CP.Data.apps+'/trade/pcancel.go',
						type : "POST",
						dataType : "xml",
						data : {
							gid : $_gid,
							hid : $_hid
						},
						success : function(xml) {
							var R = $(xml).find("Resp");
							var code = R.attr("code");
							var desc = R.attr("desc");
							if (code == "0") {
								alert(desc);
								setTimeout(function() {
									location.reload();
								}, 2000);
							} else {
								alert(desc);
								if(desc == '用户未登录'){
									setTimeout(function () {
										window.location.replace('#type=fun&fun=CP.Home.openLogin');
									},2000);
								}
							}
						}
					});
				});
				//跟单购买
				$('#iPay').click(function(){
					var buy = $('#iNum').val().replace(/(\s*$)/g,'');
					var param = {//投注参数
							payUrl:    '/trade/pjoin.go',//投注接口
							gid:       $_gid,//彩种id
							hid:       $_hid,//期号
							countMoney:buy//方案金额
					};
					var data = {//支付弹框参数
							gid:     $_gid,//彩种id
							cMoney:  buy,//需支付金额
							payPara: param//jQuery.param(param)
					};
					CP.User.info(function(options){
						if (options) {
							jQuery.extend(data, options);
						}
						CP.Popup.buybox(data);
					});
				});
				//查看合买投注内容
				$('#authority').Touch(function(){
					if(againstData.iopen == 0){
						if(againstData.ifile == 0 || (againstData.ifile != 0 && againstData.ccodes != '')){
							window.location.href = '#type=fun&fun=CP.Viewpath.content';
						}else{
							alert('方案未上传，无法查看');
						}
					}else{
						var myleng = againstData.myjoins.find('myjoin').length;
						if(againstData.ccodes != ''){
							window.location.href = '#type=fun&fun=CP.Viewpath.content';
						}else{
							if(againstData.iopen == 2){
								if(myleng != 0 && againstData.ifile =='1'){
									alert('方案未上传，无法查看');
								}else{
									alert('您不是跟单用户，无法查看此方案');
								}
							}else if(againstData.iopen == 3){
								if(myleng != 0){
									alert('方案未截止，无法查看');
								}else{
									alert('您不是跟单用户，无法查看此方案');
								}
							}else if(againstData.iopen == 1){
								alert('方案未截止，无法查看');
							}
						}
					}
				});
				//跟单用户
				$('#gdUser').Touch(function () {
					window.location.href = '#type=fun&fun=CP.Viewpath.gdUser';
				});
				//我的认购记录
				$('#myRecord').Touch(function () {
					window.location.href = '#type=fun&fun=CP.Viewpath.myRecord';
				});
			},
			//获取跟单人列表
			loadOneLottery : function (cPage) {
				if(cPage<=allUser.total){
					$.ajax({
						url: CP.Data.apps+'/trade/jlist.go',
						type: "POST",
						data: {
							hid : $_hid,
							gid : $_gid,
							state : againstData.chedan,
							pn : cPage,
							ps : 20
						},
						success: function(data) {
							$("#joinLoad").hide();
							var R = $(data).find("Resp");
							var code = R.attr("code");
							var desc = R.attr("desc");
							var count = R.find("count");
							allUser.total = count.attr("tp");//一共多少页
							if (code == "0") {
								var r = R.find("row");
								var c = R.find('count');
								var rs = c.attr('rc');
								zys = c.attr('tp');
								var _out=[];
								_out.push($('#join_user .inUser').html());
								if(cPage == 1){
									_out.push('<li><span class="inFirst">用户('+rs+')</span><span>认购金额(元)</span><span style="border-right:none;width:26%">购买时间</span></li>');
								}
								r.each(function(a,b){
									var nickid = $(this).attr("nickid");//用户名 
									var bmoney = $(this).attr("bmoney");//认购金额
									var buydate = $(this).attr("buydate");//认购时间
									_out.push('<li><span class="inFirst">'+nickid+'</span><span class="red">'+bmoney+'</span><span class="inLast"><em>'+buydate.substring(2,10)+'</em><cite>'+buydate.substring(11,19)+'</cite></span></li>');
								});
								$('#join_user .inUser').html(_out.join(''));
								if(allUser.cPage<allUser.total){
									$("#pullUp").show();	
								}else{
									$("#pullUp").hide();	
								}
								myScroll.refresh();
							}else{
								$("#joinLoad").hide();
								alert(desc);
								return;
							}
						},
					});
				}
			},
			//切换到跟单用户
			gdUser : function () {
				$('#main').hide();
				$('#join_user').show();
				TopAnch.init({
            		title: '参与用户',
            		prevShow:true,
            		prevFun:function(){//左侧按钮绑定事件
            			window.history.back();
            		},
            		isBack:true
            	});
				if(g.gdUser){
					o.loadOneLottery(allUser.cPage);
					o.layOut();
					g.gdUser = false;
				}
			},
			// 我的认购记录
			myRecord : function () {
				$('#main').hide();
				$('#inuser').show();
				TopAnch.init({
            		title: '我的认购',
            		prevShow:true,
            		prevFun:function(){//左侧按钮绑定事件
            			window.history.back();
            		},
            		isBack:true
            	});
				
				if(g.myRecord){
					var _out = [];
					if(againstData.chedan == '3'){//接口限制   如果是撤单的方案 必须state传3 得再访问一次pinfo.go接口
						var data = {
								gid : $_gid,
								hid : $_hid,
								state : againstData.chedan
						};
						$.ajax({
							url: CP.Data.apps+'/trade/pinfo.go?'+jQuery.param(data),
							type: "POST",
							dataType : "xml",
							success: function(xml) {
								$('#inuserLoad').hide();
								var R = $(xml).find("Resp");
								var code = R.attr("code");
								var desc = R.attr("desc");
								if (code == "0") {
									var M = R.find("myjoins");//发起人的的认购记录
									var m = M.find("myjoin");
									_out.push('<li><span>认购金额(元)</span><span>奖金(元)</span><span style="border-right:none">购买时间</span></li>');
									var Q = m.length;
									if(Q == 0){
										_out.push('<li class="yellow" style="text-align:center;border-bottom:none;">亲!木有你的认购记录耶</li>');
									}else{
										m.each(function(a){
											var buydate = $(this).attr("buydate");// 认购时间
											var bmoney = $(this).attr("bmoney");// 认购金额
											var rmoney = $(this).attr("rmoney");// 认购派奖金额
											var rpmoney = $(this).attr("rpmoney")||0;//红包认购金额
											_out.push('<li style="'+((a+1) == Q? "border-bottom:none;" : "")+'"><span class="yellow">'+bmoney+(rpmoney == '0'? "":"(含红包"+rpmoney+"元)" )+'</span><span class="yellow">'+rmoney+'</span><span class="inLast"><em>'+buydate.substring(2,10)+'</em><cite>'+buydate.substring(11,19)+'</cite></span></li>');
										});
									}
									$('#inuser .inUser').html(_out.join(''));
								}else{
									alert(desc);
									$('#inuserLoad').hide();
									return;
								}
							},
						});
					}else{
						var award = againstData.award;
						_out.push('<li><span>认购金额(元)</span><span>奖金(元)</span><span style="border-right:none">购买时间</span></li>');
						var myjoin = againstData.myjoins.find('myjoin');
						if(myjoin.length){
							myjoin.each(function (a) {
								var buydate = $(this).attr("buydate");// 认购时间
								var bmoney = $(this).attr("bmoney");// 认购金额
								var rmoney = $(this).attr("rmoney");// 认购派奖金额
								var rpmoney = $(this).attr("rpmoney") || 0;//红包认购金额
								_out.push('<li style="'+((a+1) == myjoin.length? "border-bottom:none;" : "")+'"><span class="yellow">'+bmoney+(rpmoney == '0'? "":"(含红包"+rpmoney+"元)" )+'</span><span class="yellow">'+(award=='2'?rmoney:'-')+'</span><span class="inLast"><em>'+buydate.substring(2,10)+'</em><cite>'+buydate.substring(11,19)+'</cite></span></li>');
							});
						}else{
							_out.push('<li class="yellow" style="text-align:center;border-bottom:none;">亲!木有你的认购记录耶</li>');
						}
						$('#inuser .inUser').html(_out.join(''));
						$('#inuserLoad').hide();
					}
					g.myRecord = false;
				}
			},
			//合买投注内容
			content : function (){
				$('#main').hide();
				$('#cHm').show();
				TopAnch.init({
            		title: '查看',
            		prevShow:true,
            		prevFun:function(){//左侧按钮绑定事件
            			window.history.back();
            		},
            		isBack:true
            	});
				
				if (g.content) {
					var opt_ = againstData;
					if(opt_.ifile == '1'){
						if(opt_.source == 6 || opt_.source == 7){//奖金优化
							Against.jjyh(opt_.gid, opt_.pid, opt_.hid, opt_.ccodes, true);
						}else{
							if(opt_.ccodes.indexOf('txt')>0){
								var request=null;
						        if(window.XMLHttpRequest)
						        {
						            request=new XMLHttpRequest();
						        }else if(window.ActiveXObject)
						        {
						            request=new ActiveXObject("Microsoft.XMLHTTP");
						        }
						        if(request)
						        {
						            request.open("GET",'/data/pupload/'+opt_.gid+'/'+opt_.pid+'/'+opt_.ccodes,true);
						            request.onreadystatechange=function()
						            {
						                if(request.readyState===4)
						                {
						                    if (request.status == 200 || request.status == 0)
						                    {
						                    	var t = request.responseText;
						                    	t = t.split(';');
						                    	if(t[0].indexOf(':')>=0){
						                    		t = $.map(t,function(val,index){
						                    			return val.split(':')[0];
						                    		});
						                    	}
						                    	t = t.join('<br>');
						                       document.getElementById("hmContent").innerHTML=t;
						                       $('#hmContent').show();
						                    }
						                }
						            };
						            request.send(null);
						        }else{
						        	$('#hmContent').html('单式上传方案');
					            }
							}
						}
					}else{
						if(opt_.source == 9){//旋转
							Against.xzjz(opt_.gid, opt_.ccodes, opt_.pid);
						}else{
							if(opt_.gid == '01' || opt_.gid == '50' || opt_.gid == '03' || opt_.gid == '53' || opt_.gid == '07' || opt_.gid == '51' || opt_.gid == '52'){
								Against.showszc(opt_.gid, opt_.ccodes, opt_.pid, opt_.iplay);
							}
							else if(opt_.gid==84 || opt_.gid==85 ||opt_.gid==86 ||opt_.gid==87 ||opt_.gid==88 ||opt_.gid==89 || opt_.gid==90 
									||opt_.gid==91 ||opt_.gid==92 ||opt_.gid==93 || opt_.gid == 70 || opt_.gid == 72
									||opt_.gid==94 ||opt_.gid==95 ||opt_.gid==96 ||opt_.gid==97 || opt_.gid==71){
								if(opt_.gid==84 || opt_.gid==85 ||opt_.gid==86 ||opt_.gid==87 ||opt_.gid==88 ||opt_.gid==89){
									
								}else{
									$('#jcts2').show();
								}
								Against.bd_jc_clasli(opt_.gid, opt_.pid, opt_.hid, opt_.ccodes, opt_.source, true );
							}
							else if(opt_.gid==80 ||opt_.gid==81 ||opt_.gid==82 ||opt_.gid==83){
								Against.lzc_clasli(opt_.gid, opt_.pid, opt_.ccodes, true);
							}
							else if(opt_.gid == "99" || opt_.gid == "98"){//冠亚军
								Against.gyj_clasli(opt_.gid, opt_.pid, opt_.hid, opt_.ccodes, true);
							}
							else{
								Against.showszc(opt_.gid, opt_.ccodes, opt_.pid, opt_.iplay);
							}
						}
					}
					g.content = false;
				}
			},
			layOut : function(){
				var w = window.innerHeight;
				$("#join_user").height(w - 55);//94是下面加载更多的高度
				window.onresize = function(){	
					var w = window.innerHeight;
					$("#join_user").height(w - 55);
					window.myScroll&&myScroll.refresh&&myScroll.refresh();	
				};
				o.loadScroll();
			},
			//滚动条
			loadScroll:function(){
					var pullUpEl = document.getElementById('pullUp');	
					var pullUpOffset = pullUpEl.offsetHeight;
					myScroll = new iScroll('join_user', {
						onRefresh: function () {
							if (pullUpEl.className.match('loading')) {
								pullUpEl.className = '';
								pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉查看更多';
							}
						},
						onScrollMove: function () {
							if (this.y < (this.maxScrollY - 20) && !pullUpEl.className.match('flip')) {
								pullUpEl.className = 'flip';
								pullUpEl.querySelector('.pullUpLabel').innerHTML = '松开加载数据';
							} else if (this.y > (this.maxScrollY) && pullUpEl.className.match('flip')) {
								pullUpEl.className = '';
								pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉查看更多';
							}
						},
						onScrollEnd: function () {
							if (pullUpEl.className.match('flip')) {
								pullUpEl.className = 'loading';
								pullUpEl.querySelector('.pullUpLabel').innerHTML = '正在加载';
								o.loadOneLottery(++allUser.cPage);
							}
						}
					});					
			}
	};
	//填充对阵内容
	var Against = {
			xzjz : function(gid, ccodes, pid){//旋转矩阵
				$('#hmContent').show();
				$('#hmContent p').eq(0).html(CP.Util.lot(gid)+"&nbsp;"+pid+"期");
				var _out = [];
				var code = ccodes.split(';');
				$.each(code, function(index, val){
					var xzjzCode = val.split(':')[0];
					var val = val.split('-');
					var c = val[0].split('|');//开奖号码
					var redBall = c[0].split(',').join(' ');
					var blueBall = '';
					if(c[1]){
						blueBall = c[1].split(',').join(' ');
					}
					var xzjz = val[1];//旋转矩阵
					_out.push('<p class="pdTop06">&nbsp;[旋转矩阵(中'+xzjz.substr(xzjz.indexOf('S')+1,1)+'保'+xzjz.substr(xzjz.indexOf('E')+1,1)+')]</p>');
					_out.push('<p class="gray"><label class="red">&nbsp;'+redBall+'</label>&nbsp;<label class="blue">'+blueBall+'</label><label class="blue right" gid='+gid+' xzjz='+xzjzCode+'>查看详情</label></p>');
					
				});
				$("#hmContent div").html(_out.join(''));
				$('#hmContent .right').off().bind(start_ev, function(){
					var data = {
							gid : $(this).attr('gid'),
							codes : decodeURIComponent($(this).attr('xzjz'))
					};
					$.ajax({
						url:'/trade/matrixinfos.go?'+$.param(data),
						type:'POST',
						dataType:'text',
						success: function(txt){
							D.alert('<div style="overflow-x:hidden;overflow-y:scroll">'+txt+'</div>');
							if($('#dAlert div').height()>100){
								$('#dAlert div').css({
									height:'100px'
								});
							}
						}
					});
				});
			},
			showszc:function(gid, ccodes, pid, iplay){
				$('#hmContent').show();
				if(iplay == 1){
					$('#hmContent p').eq(0).html(CP.Util.lot(gid)+"&nbsp;"+pid+"期");
					var html = CP.Util.showcode(gid, ccodes);
					$("#hmContent div").html(html);
				}else if(iplay == 0){
					$('#hmContent p').eq(0).html(CP.Util.lot(gid)+"&nbsp;"+pid+"期");
					$('#hmContent p').eq(0).html('单式方案');
				}
			},
			/*lotid 彩种id
			expect 当前期次
			projid 方案编号
			type 
			codes 投注号码*/
			bd_jc_clasli:function(lotid, expect, projid, codes, source, isHm){
				if(source == '11'){//固定单关
					$.ajax({
						url : CP.Data.apps+'/trade/qview.go',
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
								var quan = '--',ban = '';
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
							if(isHm){
								$('#hmContent').html(html).show();
							}else{
								$("#zgContent").hide();
								$('#clasli').html(html);
							}
						}
					});
				}else{
					$.ajax({
						url : CP.Data.data+"/data/guoguan/" + lotid + "/" + expect + "/proj/" + projid.toLowerCase() + ".xml",
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
									var quan = '--',ban = '';
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
									var dcode = [];
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
															var rt=(parseInt(hs)+parseInt(vs))*1;
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
								if(isHm){
									$('#hmContent').html(html).show();
								}else{
									$("#zgContent").hide();
									$('#clasli').html(html);
								}
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
												rq = "<span style='color:red'>("+lose.split('|')[1]+")</span>";
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
										if(hs == '-1'){
											bfen = '延时';
										}else{
											bfen = vs+':'+hs;
										}
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
								if(isHm){
									$('#hmContent').html(html).show();
								}else{
									$("#zgContent").hide();
									$('#clasli').html(html);
								}
							}else if(lotid == "90"||lotid == "93"||lotid == "91"||lotid == "92"||lotid == "94"||lotid == "95"||lotid == "97"||lotid == "96" || lotid == "72"){//竞彩足球  篮球 
								r.each(function(aa){
									var hs = $(this).attr("hs");//
									var vs = $(this).attr("vs");//
									var hhs = $(this).attr("hhs");//
									var hvs = $(this).attr("hvs");//
									var quan = '--',ban = '';
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
									var BF = ['1:0','2:0','2:1','3:0','3:1','3:2','4:0','4:1','4:2','5:0','5:1','5:2','9:0',//胜其它
									    		'0:0','1:1','2:2','3:3','9:9',//平其它
									    		'0:1','0:2','1:2','0:3','1:3','2:3','0:4','1:4','2:4','0:5','1:5','2:5','0:9'//负其它
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
													var oracle2 = oracle[j].replace(/9:0/g,"胜其它").replace(/9:9/g,"平其它").replace(/0:9/g,"负其它");
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
								if(isHm){
									$('#hmContent').html(html).show();
								}else{
									$("#zgContent").hide();
									$('#clasli').html(html);
								}
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
									var id = $(this).attr("id");
									var hn = $(this).attr("hn");//主队
									var vn = $(this).attr("vn");//客队
									var hs = $(this).attr("hs");
								    var vs = $(this).attr("vs");
								    var hhs = $(this).attr("hhs");
									var hvs = $(this).attr("hvs");
									var quan = '--',ban = '';
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
															html += '<span><em class="yellow">'+oracle2.replace(/9:0/g,"胜其它").replace(/9:9/g,"平其它").replace(/0:9/g,"负其它")+'</em>'+jjsp+'</span>';
														}else{
															html += '<span>'+oracle2.replace(/9:0/g,"胜其它").replace(/9:9/g,"平其它").replace(/0:9/g,"负其它")+'</span>';
														}
													}else{
														html += '<span>'+oracle2.replace(/9:0/g,"胜其它").replace(/9:9/g,"平其它").replace(/0:9/g,"负其它")+'</span>';
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
									if(isHm){
										$('#hmContent').html(html).show();
									}else{
										$('#clasli').html(html);
									}
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
			lzc_clasli:function(lotid, expect, ccodes, isHm){//胜负彩/r9/半全场/进球彩
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
					url : CP.Data.apps+"/trade/m.go",
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
						if(isHm){
							$('#hmContent').html(html).show();
						}else{
							$('#clasli').html(html);
						}
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
			
			
			
			gyj_clasli:function(lotid, pid, projid, codes, isHm){
				console.log(lotid);
				$.ajax({
					url : CP.Data.data+"/data/guoguan/" + lotid + "/" + pid + "/proj/" + projid.toLowerCase() + ".xml",
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
						if(lotid == 98||lotid == 99){
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
							if(isHm){
								$('#hmContent').html(html).show();
							}else{
								$('#clasli').html(html);
							}
							
						}else{
							html += '<tr><td>'+codes+'&nbsp;&nbsp;&nbsp;待开发</td></tr></table>';
							if(isHm){
								$('#hmContent').html(html).show();
							}else{
								$('#clasli').html(html);
							}
						}
							
					}
				});	
				
			},
			jjyh:function(lotid, expect, projid, codes, isHm){
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
								url : CP.Data.data+"/data/guoguan/" + lotid + "/" + expect + "/proj/" + projid.toLowerCase() + ".xml",
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
										var quan = '--',ban = '';
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
															             ,'0:1','0:2','1:2','0:3','1:3','2:3','0:4','1:4','2:4','0:5','1:5','2:5','0:9'];
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
									
									if(isHm){
										$('#hmContent').html(html+html2).show();
									}else{
										$("#zgContent").hide();
										$('#clasli').html(html+html2);
									}
								}
							});
						}
					});
					} catch (e) {
						
					}
				}
			}
	};
	return {
		init : o.init,
		pageGo : o.pageGo,
		gid : $_gid,
		hid : $_hid,
		authority : o.authority,//投注记录
		gdUser : o.gdUser,//跟单人
		myRecord : o.myRecord,//我的认购
		content : o.content//投注内容
		};
})();

//追加保底弹窗
function baodi(lnum) {
	$("#zj_bd, #mask_view").show();
	$('#zj_bd').css({left:parseInt(document.documentElement.clientWidth/2-$("#zj_bd").width()/2),top:parseInt(document.documentElement.clientHeight/2-$("#zj_bd").height())});
	$("#zj_bd input").select();
	$("#zj_bd input").val('1');
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
	$('#qx_bd').click(function(){
		$('#mask_view, #zj_bd').hide();
	});
};
//追加保底
function qdbaodi(){
	$("#mask_view, #zj_bd").hide();
	var rg = $('#zj_bd input').val();
	var lotid = CP.Viewpath.gid;
	var projid = CP.Viewpath.hid;
	$.ajax({
		url : CP.Data.apps+"/trade/pshbd.go",
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
				alert('保底成功');
				setTimeout(function () {
					window.location.reload();
				},2000);
			} else {
				alert(desc);
				if(desc == '用户未登录'){
					setTimeout(function () {
						window.location.replace('#type=fun&fun=CP.Home.openLogin');
					},2000);
				}
			}
		}
	});
};
//保底转认购
function torg(){
	var baodinum = $("#bd").val();;    
    $.ajax({
		url : CP.Data.apps+"/trade/pb2g.go",
		type : 'POST',
		dataType : "xml",
		data : {
			gid : CP.Viewpath.gid,
			hid : CP.Viewpath.hid,
			bnum : baodinum
		},
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				alert('保底转认购成功');
				setTimeout(function () {
					window.location.reload();
				},2000);
			} else {
				alert(desc);
				if(desc == '用户未登录'){
					setTimeout(function () {
						window.location.replace('#type=fun&fun=CP.Home.openLogin');
					},2000);
				}
			}
		}
	});
};

function resetPage(){
	$('#content_home').show();//登录完之后显示投注层
	CP.Viewpath.pageGo.goBack();
	$('#main').show();
	$('#inuser, #join_user, #cHm').hide();
}
$(function () {
	CP.Viewpath.init();
	CP.Viewpath.pageGo.goBack();
});