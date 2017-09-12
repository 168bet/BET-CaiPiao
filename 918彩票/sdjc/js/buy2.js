var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p').html(msg);
			tag && $('#dAlert a.bfb').html(tag) || $('#dAlert a.bfb').html('知道了');
			$("#dAlert").show();
			$(".zhezhao").show();
			$('#dAlert a.bfb').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$(".zhezhao").hide();
			});
		},
		confirm:function(msg, fn, tag){
			$('#dConfirm p').html(msg);
			tag && $('#dConfirm div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			$('#dConfirm').show();
			$(".zhezhao").show();
			$('#dConfirm a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
			});
			$('#dConfirm a:eq(1)').one('click',function(){//确定
				//if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
		},
		
		confirm_login:function(msg,fn,fn1,tag,tag1){
			$('#dConfirm_login p').html(msg);
			tag && $('#dConfirm_login div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			tag1 && $('#dConfirm_login div.zfTrue a:eq(1)').html(tag1) || $('#dConfirm div.zfTrue a:eq(0)').html('取消');
			$('#dConfirm_login').show();
			$(".zhezhao").show()
			$('#dConfirm_login a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
			$('#dConfirm_login a:eq(1)').one('click',function(){//确定
				if(typeof(fn1) == "function"){fn1();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
		},
		getParam:function(name){
		     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		     var r = window.location.search.substr(1).match(reg);
		     if(r!=null)return  unescape(r[2]); return null;
		}
};


var SDJC={}
var hid = D.getParam("hid")
var lotid = hid.substring(0,2);
SDJC.buy=(function(){
	var init=function(){
		var n = removeKey("HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95");
		console.log(n)
		//render();
		bindEvent();
	}
	var bindEvent=function(){
		$("#reduce").bind("click",function(){
			var val = $("#bs").val();
			val--;
			if(val<0){
				val=0
			}
			$("#bs").val(val);
			$("#pMoney").html(10*parseInt(val)+"元")
		})
		
		$("#plus").bind("click",function(){
			var val = $("#bs").val();
			val++;
			if(val>999){
				val=999
			}
			$("#bs").val(val);
			$("#pMoney").html(10*parseInt(val)+"元")
		})
	}
	
	
	var render=function(){
		var html="";
		$.ajax({
			url:"/trade/godShareDetail.go?hid=70DG2016102162722740",
			//data:"",
			dataType:"XML",
			success:function(xml){
				var R = $(xml).find("Resp");
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
				var imgUrl = godDetail.attr("imgUrl");//用户头像信息
				var isGod = godDetail.attr("isGod");//是否为大神
				
				
				$("#wrate").html(wrate||"");
				$("#endtime").html(endtime+"截止");
				$("#tmoney").html(tmoney||"");
				$("#averageMoney").html(averageMoney||"");
				$("#imgUrl").attr("src",imgUrl);
				$("#nickid").html(nickid);
				
				
				//发单人战绩信息区域隐藏显示
				if(isGod && isGod==1){//大神
					$("#nickidContent").show();//如果为大神显示战绩区域
				}else{
					$("#nickidContent").hide();
				}
				
				var rows = R.find("rows");
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
				var row = rows.find("row");
				
				
				//根据方案状态判断进心中，已截止
				if(projState=="0"){//方案进心中
					$("#buy_box").show();
				}else{//方案已截止
					$("#buy_box").hide();
				}
				
				/***
				 *  有这个字段，表示该单为神单
					 如果没有这个参数，或者参数值为"true"则显示投注信息
					 如果为false,则不显示投注信息
				 */
				html+='<div class="table_title clearfix"><span class="span8">编号</span><span class="span9">主队VS客队/投注</span><span class="span10">比分/彩果</span></div>'
				html+='<table class="table" style=" display:table;">'//<!--显示 只能用 diaplay:table 不能用 display:block;-->
				html+='<tbody id="">'
				
				if(row.length>0){
					row.each(function(i){
						var id= $(this).attr("id");
						var name= $(this).attr("name");
						var hn= $(this).attr("hn");
						var gn= $(this).attr("gn");
						var hs= $(this).attr("hs");
						var gs= $(this).attr("gs");
						var hhs= $(this).attr("hhs");
						var hgs= $(this).attr("hgs");
						var lose= $(this).attr("lose");
						var isdan= $(this).attr("isdan");//1是  0否
						var jsbf= $(this).attr("jsbf");
						var ccodes= $(this).attr("ccodes");
						var danstr="";
						if(isdan==1){
							danstr='<span class="span14">胆</span>';
						}
						
						
						//ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95"
						var rq = '';//让球样式
						if(lose!=0 && lose !=""){
							if(lose.indexOf('-')!=-1){
								rq="(<font color='green'>"+lose+"</font>)";
							}else{
								rq="(<font color='red'>"+lose+"</font>)";
							}
						}
						
						var rthtml=''
							var rt = hs-gs;
							if(rt>0){
								rthtml='<label>主胜</label>'
							}else if(rt==0){
								rthtml='<label>平</label>'
							}else{
								rthtml='<label>主负</label>'
							}
						
						var cctz = [];
					
						var cctz = ccodes.split('|')[1].split(',');
						
						var tmp=removeKey(ccodes);
						
						var danhtml="";
						if(isdan==1){
							danhtml='<span class="span14">胆</span>'
						}
						
						//<!--一场-->
						html+='<tr>'
						html+='<td class="width1" rowspan="'+(len+1)+'"><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length-1)+'</p></td>'
						html+='<td class="width2"><p class="c_gray">'+hn+rq+' VS '+gn+danhtml+'</p></td>'
						html+='<td class="width3">半'+hhs+':'+hgs+'/全'+hs+':'+gs+'</td>'
						html+='</tr>'
							
						html+=	removeKey
					
						
					})
					html+='<tr><td colspan="3"  class="width4"><p>过关方式：2串1、3串1</p><a href="#" class="table_a">出票明细</a></td></tr>'
					html+='</tbody>'
					html+='</table>'
					$("#info").html(html);
					
					$("#gk").bind("click",function(){
						D.alert("方案中，最晚一场比赛开赛后，将公开发单人投注内容")
					})
				}
			}
		})
	}
	//ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95"
	var len;
	var removeKey=function(str){
		var t=[];
		var arr=str.split("|")[1].split(",")
		var arr1=[],arr2=[],arr3=[],arr4=[],arr5=[];
		for(var i=0;i<arr.length;i++){
			if(arr[i].indexOf("SPF")){
				arr1.push(arr[i])
			}else if(arr[i].indexOf("RQSPF")){
				arr2.push(arr[i])
			}else if(arr[i].indexOf("BQC")){
				arr3.push(arr[i])
			}else if(arr[i].indexOf("CBF")){
				arr4.push(arr[i])
			}else if(arr[i].indexOf("JQS")){
				arr5.push(arr[i])
			};
		}
		if(arr1.length>0){
			t.push(arr1)
		}
		if(arr2.length>0){
			t.push(arr2)
		}
		if(arr3.length>0){
			t.push(arr3)
		}
		if(arr4.length>0){
			t.push(arr4)
		}
		if(arr5.length>0){
			t.push(arr5)
		}
		len = t.length;
		
		html+='<tr>'
		html+='<td align="left">'
		html+='<span>主胜(2.00)</span><span>平(2.00)</span><br><span>'
		html+='</td>'
		html+='<td>'
		html+=rthtml
		html+='</td>'//彩果
		html+='</tr>'
			
		return html;
		
	}
	
	
	return {
		init:init
	}
})()

$(function(){
	SDJC.buy.init();
})