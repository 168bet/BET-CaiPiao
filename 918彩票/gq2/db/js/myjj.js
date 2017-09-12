
var CP={};
CP.Util={
	pad:function(source, length) {
		var pre = "",
		negative = (source < 0),
		string = String(Math.abs(source));
		if (string.length < length) {
			pre = (new Array(length - string.length + 1)).join('0');
		}
		return (negative ? "-" : "") + pre + string;
	}	
};

var username = localStorage.getItem("username");//获取用户名
var tmp_data = JSON.parse(localStorage.getItem("tmp_data"));

var d= new Date();
var y = d.getFullYear();
var m = d.getMonth()+1;
m=m<10?"0"+m:m;

var day = d.setDate(d.getDate()+1);
day = new Date(day).getDate();
day=day<10?"0"+day:day;

var time_str=y+"-"+m+"-"+day;

var XHC={};
XHC.DB=(function(){
	var init=function(){
		integral_balance();
		news_cont();
		bindEvent();
	};
	
	var bindEvent=function(){
		$(".btn span").bind("click",function(){
			var index = $(this).index();
			if(index==0){
				window.location.href="/user/jfcz.html";
			}else{
				window.location.href="/gq2/jpzx/";
			}
		});
		
		
		$(".jq span:eq(0)").bind("click",function(){

				window.location.href="/#type=url&p=user/jfmx.html";
		});
		
		$(".jq span:eq(1)").bind("click",function(){

			window.location.href="/gq2/jpzx/jqmx.html";
		});		
		
		
		
		
		$(".main_mj").delegate("li","click",function(){
			var itype = $(this).attr("itype");
			var periodid = $(this).find("em.qc").html();
			
			window.location.href="dbxj.html?itype="+itype+"&periodid="+periodid;
		});
		
		
		$(".more").bind("click",function(){
			news_cont();
		});
		
	};
	
	
	
	//积分余额
	var integral_balance=function(){
		$.ajax({
			url : '/user/mlottery.go?flag=40',
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp");
				var point = R.attr("point");//积分
				var nickid = R.attr("nickid");//用户名
				username = username||nickid;
				$(".name").html(nickid);
				$("#jf").html(point);
				//奖券余额
				$.ajax({
					url : '/activity/ticket.go?flag=2&visit=3000',
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var R=$(xml).find("Resp");
						var award = R.attr("balance");
						$("#jq").html(award);
					}
				});
			}
		});
	}
	
	var myjj_param={
			flag:"3",
			cnickid:username,
			//periodid:"",
			psize:10,
			pnum:1,
			date1:"2015-10-01",
			date2:time_str
	};
	var news_cont=function(){
		var html=$(".main_mj").html();;
		$.ajax({
			url : '/grounder/takeinaccout.go',
			data:myjj_param,
			dataType:'xml',
			cache:true,
			success:function(xml){
				var R = $(xml).find("Resp");
				var desc = R.attr("desc");
				var code = R.attr("code");
				var tpage = R.attr("tpage");
				var total = R.attr("total");
				
				
				var row = R.find("row");

				if(row.length){
					$(".lqend").hide();
					row.each(function(){
						  var periodid  = $(this).attr("periodid");     //剩余筹码
						   var stype  = $(this).attr("stype");       //竞猜次数
						   var chipnum  = $(this).attr("chipnum");    //剩余筹码
						   var quiznum  = $(this).attr("quiznum");       //竞猜次数
						   var tzmoney  = $(this).attr("tzmoney");       //消费筹码
						   var bonus    = $(this).attr("bonus");       //中奖筹码
						   var profmoney   = $(this).attr("profmoney");    //盈利筹码
						   var ranking    = $(this).attr("ranking");     //排名
						   var rewardticket  = $(this).attr("rewardticket");  //奖励奖券
						   var jctime    = $(this).attr("jctime").substr(5,11);      //参与时间/报名时间
						   var currentnum    = $(this).attr("currentnum");  //当前参与人数
						   var itype    = $(this).attr("itype");      //期次类别（1-足球 2-篮球）
						   var istate    = $(this).attr("istate");      //是否派奖(0-未派奖 1-已派奖)
							html+='<li itype="'+itype+'">';
							html+='<div>';
							html+='<span>';
							html+='<em>猜球夺宝</em>';
							html+='<em class="qc">'+periodid+'</em>';
							html+='<em>('+currentnum+')</em>';
							html+='<em>'+jctime+'</em>';
							html+='</span>';
							html+='<span>';
							html+='<em>剩余筹码：<i>'+chipnum+'</i></em>';
							html+='<em>奖励<i>'+rewardticket+'</i>奖券  <cite>'+ranking+'名</cite></em>';
							html+='</span>';
							html+='</div>';
							html+='</li>';
						});
				
				}else{
					$(".lqend").show();
					$(".more").hide();

				}

				$(".main_mj").html(html);
			}
		});
	};
	
	return {
		init:init
	};
})();


$(function(){
	XHC.DB.init();
})

