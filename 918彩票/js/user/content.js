/*
* Author: weige
* Date : 2014-04-28
*/ 
var lotid = decodeURIComponent(CP.Util.getParaHash('lotid'));
var projid = decodeURIComponent(CP.Util.getParaHash('projid'));
console.log(lotid)





$(".backIco2").click(function(){
	if(/ipad|iphone|mac/i.test(navigator.userAgent)){
		window.location.href="#class=url&xo=useraccount/index.html";
		}
		else{
			window.history.go(-1);
	}
});

function goTo(){
	history.go(-1);
}
$(function(){
	
	var VC ={
			content:function(lotid,projid){
				var data = '';
				data = "gid=" + encodeURIComponent(lotid) + "&hid=" + encodeURIComponent(projid) + "&state=1&rnd=" + Math.random();
				//console.log($_trade.url.pinfo)
				$.ajax({
					//url : $_trade.url.pinfo,
					url : '/trade/pinfo.go',
					type : "POST",
					dataType : "xml",
					data : data,
					success : function(xml) {
						console.log(data+lotid+projid)
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if (code == "0") {
							var r = R.find("row");
							
							var gid = r.attr("gid");// 游戏编号
							var pid = r.attr("pid");// 期次
							var ccodes = r.attr("ccodes");// 投注号码
							var iplay = r.attr("iplay");// 玩法（0单式 1复式）
							var ifile = r.attr('ifile');//是否文件
							var source = r.attr('source');//7单关配 6奖金优化 13单关
							if(ifile == '1'){
								if(source == 6 || source == 7){//奖金优化
									VC.jjyh(lotid,pid,projid,ccodes);
								}else{
									if(ccodes.indexOf('txt')>0){
										$('.buyHeader').find('h1').html('单式上传详情');
										$('#loading').hide();
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
								            request.open("GET",'/data/pupload/'+gid+'/'+pid+'/'+ccodes,true);
								            request.onreadystatechange=function()
								            {
								                if(request.readyState===4)
								                {
								                    if (request.status == 200 || request.status == 0)
								                    {
								                    	var tstr=""
								                       
								                       var d = request.responseText.split(";");
								                       for(var i=0;i<d.length;i++){
								                    	   var tm = d[i].substring(0,d[i].indexOf(":"))
								                    	   
								                    	   
								                    	   tstr += '<div style="color:#8e8e8e;">【普通】' + tm.replace(/,/g,' ')+'</div>';
								                       }
								                       document.getElementById("content").innerHTML=tstr;
								                       $('#content').show();
								                    }
								                }
								            };
								            request.send(null);
								        }else{
								        	$('#content').html('单式上传方案');
							            }
									}
								}
							}else{
								if(gid == '01' || gid == '50' || gid == '03' || gid == '53' || gid == '07' || gid == '51' || gid == '52'){
									VC.showszc(gid,ccodes,pid,iplay);
								}
								else if(lotid==84 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89 || lotid==90 ||lotid==91 ||lotid==92 ||lotid==93 || lotid == 70 || lotid == 72
										||lotid==94 ||lotid==95 ||lotid==96 ||lotid==97 || lotid==71){
									if(lotid==84 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89){
										
									}else{
										$('#jcts').show();
									}
									VC.bd_jc_clasli(lotid,pid,projid,"1",ccodes,source);
								}
								else if(lotid==80 ||lotid==81 ||lotid==82 ||lotid==83){
									VC.lzc_clasli(lotid,pid,ccodes);
								}
								else if(lotid == "99" || lotid == "98"){//冠亚军
									VC.gyj_clasli(lotid,pid,projid,ccodes);
								}
								else{
									VC.showszc(gid,ccodes,pid,iplay);
								}
							}
						}else{
							$('#loading').hide();
							D.alert(desc);
						}
					}
				});
			},
			jjyh:function(lotid,expect,projid,codes){
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
									$('#content').html(html+html2).show();
									$('#loading').hide();
								}
							});
						}
					});
					} catch (e) {
						
					}
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
								html += '<tr><td '+(a==0?"width='15%'":"")+'>'+ id +'</td>';
						  		html += '<td '+(a==0?"width='70%'":"")+'>'+ hn+sp +'</td>';
					  			html += '<td '+(a==0?"width='15%'":"")+' calss="r9last">'+ result +'</td></tr>';
							});
							html += '</table>';
							html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetFooter"><tr><td>过关方式:  单关</td></tr></table>';
							$('#content').html(html).show();
							$('#loading').hide();
							
						}else{
							html += '<tr><td>'+codes+'&nbsp;&nbsp;&nbsp;待开发</td>';
							html += '</tr></table>';
							$('#content').html(html).show();
							$('#loading').hide();
						}
							
					}
				});	
				
			},
			showszc:function(gid,ccodes,pid,iplay){
				$('#content').show();
				$('#loading').hide();
				if(iplay == 1){
					$('#content p').eq(0).html($_sys.getlotname(gid)+"&nbsp;"+pid+"期");
					var html = $_sys.showcode(gid,ccodes);
					$("#content div").html(html);
				}else if(iplay == 0){
					$('#content p').eq(0).html($_sys.getlotname(gid)+"&nbsp;"+pid+"期");
					$('#content p').eq(0).html('单式方案');
				}
			},
			bd_jc_clasli:function(lotid,expect,projid,type,codes,source){
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
							$('#content').html(html).show();
							$('#loading').hide();
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
							var wk=["日","一","二","三","四","五","六"];
							var r = R.find("item");
							var chuan = '';
							if(source == '13'){
								chuan = '单关';
							}else{
								chuan = codes.split('|')[2].replace(/\*/g, "串").replace(/1串1/g, "单关");
							}
							var html='';
							html = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTitle mgTop06"><tr>';
							if(lotid == "94"||lotid == "95"||lotid == "96"||lotid == "97"||lotid == "71"){//篮彩
								html += '<td width="15%">场次</td><td width="70%">客队VS主队/投注选项</td><td width="15%" style="border-right:none">比分</td>';
							}else{
								html += '<td width="15%">场次</td><td width="70%">主队VS客队/投注选项</td><td width="15%" style="border-right:none">比分</td>';
							}
							html += '</tr></table>';
							html += '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="lcbetTable">';
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
									var spvalue2 = $(this).attr("spvalue");// 出票参考SP
									var spvalues = spvalue2.split("|");
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
//									var dcode = 
									
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
											html += '<tr><td '+(a==0?"width='15%'":"")+' rowspan="'+(cctzLength2+1)+'">'+wk2+'<br>'+id2+'</td>';
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
								$('#content').html(html).show();
								$('#loading').hide();
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
									
									html += '<tr><td '+(a==0?"width='15%'":"")+' rowspan="'+(cctzLength2+1)+'">'+wk2+'<br>'+id2+'</td>';
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
								$('#content').html(html).show();
								$('#loading').hide();
							}else if(lotid == "90"||lotid == "93"||lotid == "91"||lotid == "92"||lotid == "94"||lotid == "95"||lotid == "97"||lotid == "96" || lotid == "72"){//竞彩足球  篮球 
								r.each(function(aa){
//									var bt = $(this).attr("bt");//比赛时间
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
//									var tDATE=bt.substring('0','10'); //年月日
									tDATE = new Date(tDATE);
									var wk2 = '周'+wk[tDATE.getDay()];
									
									html += '<tr><td '+(aa==0?"width='15%'":"")+' rowspan="2">'+wk2+'<br>'+id2+'</td>';
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
								$('#content').html(html).show();
								$('#loading').hide();
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
									var hn = $(this).attr("hn");//主队
									var vn = $(this).attr("vn");//客队
									var hs = $(this).attr("hs");
								    var vs = $(this).attr("vs");
								    var hhs = $(this).attr("hhs");
									var hvs = $(this).attr("hvs");
//									var b3 = $(this).attr("bet3");//胜
//									var b1 = $(this).attr("bet1");//平
//									var b0 = $(this).attr("bet0");//负
									
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
									if(lose==0||lose==""){
										lose = "";
									}else{
										if(lose.indexOf('-')!=-1){
											lose="(<font color='green'>"+(lotid == "84"?lose+ball2[ball.indexOf(cup)]:lose)+"</font>)";
										}else{
											lose="(<font color='red'>"+(lotid == "84"?lose+ball2[ball.indexOf(cup)]:lose)+"</font>)";
										}
									}
									
								
									html += '<tr><td width="15%" rowspan="2" class="">'+id+(cup==''?"":"<br/><font color=#222222>"+cup+"</font>")+'</td>';
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
									$('#content').html(html).show();
									$('#loading').hide();
									var code = codes.split('|');
									if(code[1].indexOf("$")!=-1){
										var dcode =code[1].split('$');
										var dcode1 =dcode[0].split(',');
										for(var ji =0;ji<dcode1.length;ji++){
											var mid=dcode1[ji].split('=')[0];
											$("#dan"+mid).html("(胆)");
										}
									}
							}
						}
					});	
				}
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
						
						var html = '<p class="pdLeft04 pdTop03">'+$_sys.getlotname(lotid)+'</p>';//
						html += '<table class="lcbetTitle" width="100%" border="0" cellspacing="0" cellpadding="0">';
						html += '<tbody><tr>';
						html += '<td width="13%">场次</td><td width="51%">主客队</td><td width="18%">投注</td><td width="18%" style="border-right:none">比分</td>';
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
						$('#content').html(html).show();
						$('#loading').hide();
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
			}
	};
	
	
	if (lotid == "" || projid == "") {
		if (history.length == 0) {
			window.opener = "";
			window.close();
		} else {
			history.go(-1);
		}
		return false;
	}
	VC.content(lotid,projid);
});