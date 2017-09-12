var User ={
	initial:function(){
		$.ajax({
	        url: $_user.url.base,
	    	dataType : "xml",
	        success:function (data){
	        	var R = $(data).find("Resp");
	        	var c = R.attr('code');
	        	var d = R.attr('desc');
	        	if(c == '0'){
	        		var U = R.find("row");
		        	var rb = U.attr("ipacketmoney");//红包
		        	var n = U.attr("nickid");//用户名
		        	var m = U.attr("usermoeny");//账户余额
		        	var s = U.attr("safe");
		        	var isdl = U.attr("isdl");//返利标识
		        	var isagent = U.attr("isagent");
		        	var vlevel = U.attr('vlevel');
		        	var vmoney = U.attr("vmoney");//返利金钱
		        	if(isagent=="1" && (vlevel=="3" || vlevel=="4" || vlevel=="5" || vlevel=="6")){
                    	if(isdl=="1"){
                    	}else{
                    		$("#rebate").show();
                		}
                	 }
		        	var dj = '';
		        	if (s =="0"){
		        		dj = '差';
		        		}else if (s =="1"){
		        		dj = '低';
		        		}else if (s =="2"){
		        		dj = '中低';
		        		}else if (s =="3"){
		        		dj = '中';
		        		}else if (s =="4"){
		        		dj = '中高';
		        		}else if (s =="5"){
		        		dj = '高';
	        		}
		        	
		        	$("#rebateMoney").text(vmoney);
		        	$('#uName').html('<i class="centerAdmi"></i>'+n);
		        	$('#mSale em').html(dj);
		        	$('#remaining').html(m);
		        	$('#redPacket').html(rb);
	        	}else if(c == '1'){
	        		if(d.indexOf('未登录') != -1){
						D.tx('请先登录',function(){
							/**
							 * 微信进来的
							 */
							var fromMenu = localStorage.getItem('fromMenu');   
							var agent = localStorage.getItem('from');
			 				if(agent == 'azcp'){
			 					window.location.href="http://4g.9188.com/user/allylogin.go?type=10";
			 				}else if(fromMenu == 'wxfw'){
			 					window.location.href="/wxbind/";
			 				}else{
			 					window.location.href='#class=url&xo=login/index.html';
			 				}
						});
					}else{
	        			D.alert(d);
	        		}
	        	}
	        }
		});
	}
};
$(function(){
	User.initial();
	
	var arrTy = new Array();
	arrTy.push("自购");
	arrTy.push("发起合买");
	arrTy.push("合买跟单");
	var istate = new Array();
	istate.push("该方案自动跟单中，请等待");
	istate.push("认购中");
	istate.push("已满员 ");
	istate.push("系统已撤单");
	istate.push("发起人已撤单");
	istate.push("系统已撤单");
	istate.push("未支付");
	
	var st = new Array();
	//0 未完成 1  已完成  2 中奖停止 3 用户手工停止
	st.push("未完成");
	st.push("已完成");
	st.push("中奖后停止");
	st.push("用户手动停止");
	
	var cancelArr = new Array();
	cancelArr.push("未撤销");
	cancelArr.push("本人撤销");
	cancelArr.push("系统撤销");
	
	gcjl(40);
	
	$("#gcjl").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjl(40);
	});
	
	$("#zhjl").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjl(43);
	});
	$("#tcjl").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjl("43&limit=1");
	});
	function gcjl(flag){
		if(flag==40){
			
			$.ajax({
				url:"/user/mlottery.go",
				data : "flag="+flag,
				success  : function (xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				if(code=="0"){
					var r = R.find("row");
						var html="";
						var tmp={},arr2=[];
						r.each(function(i){
								var time = $(this).attr("buydate").substring(0,10);
								if(!tmp[time])
								tmp[time]=[];
								tmp[time].push(r[i]);
						});
						for(var i in tmp){arr2.push(tmp[i]);}
						for(var j=0;j<arr2.length;j++){
							if(arr2[j].length>1){
								var buydate = $(arr2[j][0]).attr("buydate");
								html+='<div class="clearfix myToday">';
								html+=anyTime(buydate);
							    html+='<div class="left w86">';
								for(var k=0;k<arr2[j].length;k++){
									var ty=$(arr2[j][k]).attr("ty");
									var ist=$(arr2[j][k]).attr("istate");
									var money=$(arr2[j][k]).attr("money");
									var rmoney=$(arr2[j][k]).attr("rmoney");
									var pid=$(arr2[j][k]).attr("pid");
									var gid=$(arr2[j][k]).attr("gid");
									var projid=$(arr2[j][k]).attr("projid");
									var status=$(arr2[j][k]).attr("state");
									var cancel=$(arr2[j][k]).attr("cancel");
									
									html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+projid+'" style="">'
									html+='<div class="myCz">';
									html+='<p><em class="fontSize092">'+$_sys.getlotname($(arr2[j][k]).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+arrTy[ty]+'</em></p>';
									html+='<cite>'+money+'元</cite>';
									html+='</div>';
									html+='<div class="myQs">';
									html+='<p>第'+pid+'期</p>';
									//html+='<cite>'+status+'</cite>';
									 if(rmoney>0){
							            	html+='<cite class="yellow">已中奖'+rmoney+'元</cite>'
							            }else{
							            	html+='<cite>'+status+'</cite>'
							            }
									html+='</div>';
									html+='<i class="hmArrow"></i>';
									html+='</a>';
								}
								html+=' </div>';
								html+=' </div>';
							}else{
								var ty=$(arr2[j][0]).attr("ty");
								var pid=$(arr2[j][0]).attr("pid");
								var money=$(arr2[j][0]).attr("money");
								var ist=$(arr2[j][0]).attr("istate");
								var buydate = $(arr2[j][0]).attr("buydate");
								var money = $(arr2[j][0]).attr("money");
								var gid=$(arr2[j][0]).attr("gid");
								var projid=$(arr2[j][0]).attr("projid");
								var status=$(arr2[j][0]).attr("state");
								var cancel=$(arr2[j][0]).attr("cancel");
								var rmoney=$(arr2[j][0]).attr("rmoney");

								html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+projid+'" style="">';
								//html+='<span>'
								//html+='<em>11月</em>'
								//html+='<cite>07</cite>'

								html+=anyTime(buydate);
								html+='<div class="myCz">';
								html+='<p><em class="fontSize092">'+$_sys.getlotname($(arr2[j][0]).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+arrTy[ty]+'</em></p>'
								html+='<cite>'+money+'元</cite>';
								html+='</div>';
								html+='<div class="myQs">';
								html+='<p>第'+pid+'期</p>';
								//html+='<cite>'+status+'</cite>';
								 if(rmoney>0){
						            	html+='<cite class="yellow">已中奖'+rmoney+'元</cite>'
						            }else{
						            	html+='<cite>'+status+'</cite>'
						            }
								html+='</div>';
								html+='<i class="hmArrow"></i>';
								html+='</a>';
							}
						}
						html+='<a href="#class=url&xo=useraccount/gcjl.html" class="myMore">查看更多</a>';
						$(".myRecord").html(html);
						$( ".myRecord a:last-child" ).css("border-bottom","none");
				}else{
					$(".myRecord").html("暂无记录");
				}
			}
			});
			
			$( ".myRecord a:last-child" ).css("border-bottom","none");
		}else if(flag==43){
			$.ajax({
				url:"/user/mlottery.go",
				data : "flag="+flag,
				success  : function (xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				if(code=="0"){
					var r = R.find("row");
					
						var html="";
						var tmp={},arr2=[];
						r.each(function(i){
								var time = $(this).attr("adddate").substring(0,10);
								if(!tmp[time])
								tmp[time]=[];
								tmp[time].push(r[i]);
						});
						for(var i in tmp){arr2.push(tmp[i]);}
				        html+='<div class="myRecord2">';    
				       
						for(var j=0;j<arr2.length;j++){
							if(arr2[j].length>1){
								var adddate = $(arr2[j][0]).attr("adddate");
								
								html+='<div class="clearfix myToday myToday2">';
								html+=anyTime(adddate);
								html+='<div class="left w86">';
								for(var k=0;k<arr2[j].length;k++){
									var tmoney = $(arr2[j][k]).attr("tmoney");
									var pnums = $(arr2[j][k]).attr("pnums");
									var success = $(arr2[j][k]).attr("success");
									var reason = $(arr2[j][k]).attr("reason");
									var gid = $(arr2[j][k]).attr("gid");
									var tid = $(arr2[j][k]).attr("zhid");
									html+='<a href="/useraccount/zhxq.html?gid='+gid+'&tid='+tid+'" style="">'
									html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(arr2[j][k]).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+$(arr2[j][k]).attr("adddate")+' 起</em></p>'
									html+='<div class="myCz">'
									html+='<cite>'+tmoney+'元</cite>'
									html+='<p>总额</p>'
									html+='</div>'
									html+='<div class="myQs">'
									html+='<cite>'+pnums+'期/'+success+'期</cite>'
									html+='<p>总/已追</p>'
									html+='</div>'
									html+='<div class="myZt">'
									html+='<cite>'+st[reason]+'</cite>'
									html+='<p>状态</p>'
									html+='</div>'
									html+='<i class="hmArrow"></i>'
									html+='</a>'
								}
							    	html+='</div>';
							    	html+='</div>';
							}else{
								var adddate = $(arr2[j][0]).attr("adddate");
								var tmoney = $(arr2[j][0]).attr("tmoney");
								var pnums = $(arr2[j][0]).attr("pnums");
								var success = $(arr2[j][0]).attr("success");
								var reason = $(arr2[j][0]).attr("reason");
								var gid = $(arr2[j][0]).attr("gid");
								var tid = $(arr2[j][0]).attr("zhid");
								html+='<a href="/useraccount/zhxq.html?flag=39&gid='+gid+'&tid='+tid+'" style="">'
								html+=anyTime(adddate);
								html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(arr2[j][0]).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>';
								html+='<div class="myCz">';
								html+='<cite>'+tmoney+'元</cite>';
								html+='<p>总额</p>';
								html+='</div>';
								html+='<div class="myQs">';
								html+='<cite>'+pnums+'期/'+success+'期</cite>';
								html+='<p>总/已追</p>';
								html+='</div>';
								html+='<div class="myZt">';
								html+='<cite>'+st[reason]+'</cite>';
								html+='<p>状态</p>';
								html+='</div>';
								html+='<i class="hmArrow"></i>';
								html+='</a>';
							}
						}
						html+='<a href="/useraccount/zhjl.html" class="myMore">查看更多</a>';
						html+='</div>';
						$(".myRecord").html(html);
						$( ".myRecord a:last-child" ).css("border-bottom","none");
				}else{
					$(".myRecord").html("暂无记录");
				}
			}
			});
			$( ".myRecord a:last-child" ).css("border-bottom","none");
		}else{
			$.ajax({
				url:"/user/mlottery.go",
				data : "flag="+flag,
				success  : function (xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				if(code=="0"){
					var r = R.find("row");
						var html="";
						var tmp={},arr2=[];
						r.each(function(i){
								var time = $(this).attr("adddate").substring(0,10);
								if(!tmp[time])
								tmp[time]=[];
								tmp[time].push(r[i]);
						});
						for(var i in tmp){arr2.push(tmp[i])};
				        html+='<div class="myRecord2">';    
				       
						for(var j=0;j<arr2.length;j++){
							if(arr2[j].length>1){
								var adddate = $(arr2[j][0]).attr("adddate");
								
								html+='<div class="clearfix myToday myToday2">';
								html+=anyTime(adddate);
								html+='<div class="left w86">';
								for(var k=0;k<arr2[j].length;k++){
									
									var tmoney = $(arr2[j][k]).attr("tmoney");
									var pnums = $(arr2[j][k]).attr("pnums");
									var success = $(arr2[j][k]).attr("success");
									var reason = $(arr2[j][k]).attr("reason");
									var gid = $(arr2[j][k]).attr("gid");
									var tid = $(arr2[j][k]).attr("zhid");

									html+='<a href="/useraccount/tcxq.html?gid='+gid+'&tid='+tid+'" style="">'
									html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(arr2[j][k]).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+$(arr2[j][k]).attr("adddate")+' 起</em></p>'
									html+='<div class="myCz">'
									html+='<cite>'+tmoney+'元</cite>'
									html+='<p>总额</p>'
									html+='</div>'
									html+='<div class="myQs">'
									html+='<cite>'+pnums+'期/'+success+'期</cite>'
									html+='<p>总/已追</p>'
									html+='</div>'
									html+='<div class="myZt">'
									html+='<cite>'+st[reason]+'</cite>'
									html+='<p>状态</p>'
									html+='</div>'
									html+='<i class="hmArrow"></i>'
									html+='</a>'

								}
							    	html+='</div>';
							    	html+='</div>';
							}else{
								var adddate = $(arr2[j][0]).attr("adddate");
								var tmoney = $(arr2[j][0]).attr("tmoney");
								var pnums = $(arr2[j][0]).attr("pnums");
								var success = $(arr2[j][0]).attr("success");
								var reason = $(arr2[j][0]).attr("reason");
								var gid = $(arr2[j][0]).attr("gid");
								var tid = $(arr2[j][0]).attr("zhid");
								html+='<a href="/useraccount/tcxq.html?gid='+gid+'&tid='+tid+'" style="">'
								html+=anyTime(adddate);
								html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(arr2[j][0]).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+'  起</em></p>';
								html+='<div class="myCz">';
								html+='<cite>'+tmoney+'元</cite>';
								html+='<p>总额</p>';
								html+='</div>';
								html+='<div class="myQs">';
								html+='<cite>'+pnums+'期/'+success+'期</cite>';
								html+='<p>总/已追</p>';
								html+='</div>';
								html+='<div class="myZt">';
								html+='<cite>'+st[reason]+'</cite>';
								html+='<p>状态</p>';
								html+='</div>';
								html+='<i class="hmArrow"></i>';
								html+='</a>';
							}
							
						}
						html+='<a href="/useraccount/tcjl.html" class="myMore">查看更多</a>';
						html+='</div>';
						$(".myRecord").html(html);
						$( ".myRecord a:last-child" ).css("border-bottom","none");
					
				}else{
					$(".myRecord").html("暂无记录");
				}
			}
			});
			$( ".myRecord a:last-child" ).css("border-bottom","none");
		}
	}
	$("#withdrawal").bind("click",function(){
		$.ajax({
	        url: "/user/querybind.go",
	        success:function (data){
	        	
	        	var R = $(data).find("Resp");
	        	var r = $(R).find("row");
	        	var idcard = $(r).attr("idcard");//身份证号码
	        	var rname = $(r).attr("rname");//真实姓名
	        	var card = $(r).attr("card");
	        	if(!idcard){
	        		D.alert("请先绑定身份信息",function(){
	        			//绑定身份证页面
		        		window.location.href="/useraccount/setup/idbin.html";
	        		});
	        	}else{
	        		if(!card){
	        			D.alert("请先绑定银行卡",function(){
	        				//绑定银行卡页面
		        			window.location.href="/useraccount/setup/bcardbin.html";
	        			});
	        		}else{
	        			//直接跳到提款页面
	        			window.location.href="#class=url&xo=useraccount/withdrawal.html";
	        		}
	        	}
	        	
	        }
		});
	})	;
});

function createToArr(arr1){
	var tmp={},arr2=[];
	for(var i=0;i<arr1.length;i++){
		if(!tmp[arr1[i]])
		tmp[arr1[i]]=[];
		tmp[arr1[i]].push(arr1[i]);
		};
	for(var i in tmp){arr2.push(tmp[i]);}
	 return arr2;
}


function anyTime(str){
	var today="";
	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth()+1;
	var day = date.getDate();
	if(month<10){
		month="0"+month;
	}
	
	if(day<10){
		day="0"+day;
	}
	
	str = str.substring(0,10);
	var tarr = str.split("-");
	if(tarr[0]==year && tarr[1]==month && tarr[2]==day){
		today+='<span class="left">今<br>天</span>';
		
	}else{
		today+='<span>';
		today+='<em>'+tarr[1]+'月</em>';
		today+='<cite>'+tarr[2]+'</cite>';
		today+='</span>';
	}
	return today;
	
}

//根据id判断是哪个彩种
function anyName(gid,arr){
	for(var i=0;i<arr.length;i++){
		if(arr[i][0]==gid){
			var str = arr[i][1];
			return str;
		}
	}
}
