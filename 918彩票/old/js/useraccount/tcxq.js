$(function(){
	var gid=location.search.getParam("gid");
	var tid=location.search.getParam("tid");
	//var flag=location.search.getParam("flag");
	
	var finish = new Array();
	
	finish.push("未完成");
	finish.push("已完成");
	finish.push("中奖停止")
	finish.push("用户手工停止")
	
	$.ajax({
		url:$_user.url.tcxq_xchase,
		data:"gid="+gid+"&tid="+tid+"&pn=1&ps=50&tp=0&tr=0",
		success  : function (xml){
			var R = $(xml).find("Resp");
			if($(R).attr("code")==0){
				var rows = $(R).find("rows");
				var r = $(rows).find("row");
				r=r.sort(s);
				var r0 = r[0];
				var len = r.length;
				var cadddate = $(r0).attr("cadddate");//购买时间
				var czhid = $(r0).attr("czhid");//套餐编号
				var reason = parseInt($(r0).attr("reason"));//套餐编号
				var name = anyName(gid,$_sys.lot);
				var tr = $(rows).attr("tr")
				var html="";
				
				html+='<p>'+name+'  '+cadddate+ '发起</p>';
				html+='<div class="zhxqList mgTop06">'
				html+='<ul>'
				html+='<li><cite>套餐编号</cite><span>'+czhid+'</span></li>'
				html+='<li><cite>套餐期数</cite><span>'+tr+'期</span></li>'
				html+='<li><cite>套餐状态</cite><span>'+finish[reason]+'</span></li>'
				html+='</ul>'
				html+='<div class="zhxqTxt">'
				html+='<p class="gray pdTop06 fontSize092">套餐明细</p>'
				
				
				r.each(function(){
					var cperiodid=$(this).attr("cperiodid");
					var ccastdate=$(this).attr("ccastdate");
					var ccodes=$(this).attr("ccodes");
					var cawardcode=$(this).attr("awardcode");
					var icmoney=$(this).attr("icmoney");
					var itax=$(this).attr("itax");
					
					if(cawardcode){
						html+='<div class="zhmxList">'
						html+='<p>第'+cperiodid+'期 <em class="gray">'+ccastdate+'</em></p>'
						html+='<p class="zhmx"><cite>'+icmoney*len+'/'+icmoney+'元</cite><span>'+anyCodes(gid,ccodes,cawardcode)+'</span>'
						if(itax>0){
							html+='<em class="yellow">中奖'+itax+'元</em>'
						}else{
							html+='<em>未中奖</em>'
						}
						
						html+='</p>'
						html+='<p class="gray zhmx"><cite>累计<i class="accountLine"></i>当期</cite><span class="red">'+awardCodeShow(cawardcode)+'</span><em>状态</em></p>'
						html+='</div>'
					}
				})
				html+='</div>'
				html+='</div>'
				$(".pd063").html(html);
			}
			
		}
	})
})

//根据id判断是哪个彩种
//<i>03</i> <i>09</i> <i>22</i> <i>26</i> <i>20</i> <i>31</i> <i class="gray">|</i> <i>14</i>
function anyName(gid,arr){
	for(var i=0;i<arr.length;i++){
		if(arr[i][0]==gid){
			var str = arr[i][1];
			return str;
		}
	}
}



function anyCodes(gid,ccodes,cawardcode){
	//var tempRed=new Array();
	//var tempBlue=new Array();
	var html="";
	if(gid=="01"||gid=="50"){
		if(ccodes){
			var buycode = ccodes.substring(0,ccodes.indexOf(":"));//"08,09,12,13,14,30|04:1:1
			var buyCodeArr=buycode.split("|");
			var buyRedArr = buyCodeArr[0].split(",");
			var buyBlueArr;
				buyBlueArr = buyCodeArr[1].split(",");
			
			
			var awardcode = cawardcode.split("|");//03,09,15,23,25,30|07
			var awardRedCode=awardcode[0].split(",")
			var awardBlueCode;
				awardBlueCode = awardcode[1].split(",");
			
			
			
			for(var i=0;i<buyRedArr.length;i++){
				var ww = false;
				for(var j=0;j<awardRedCode.length;j++){
					if(buyRedArr[i]==awardRedCode[j]){
						html+='<i class="red">'+buyRedArr[i]+'</i>&nbsp;';
						ww = true;
						
					}
					
				}
				if(!ww){
					html+='<i>'+buyRedArr[i]+'</i>&nbsp;';
				}
				
				
			}
			html+='<i class="gray">|</i>';
			
			for(var i=0;i<buyBlueArr.length;i++){
				var ww = false;
				for(var j=0;j<awardBlueCode.length;j++){
					if(buyBlueArr[i]==awardBlueCode[j]){
						html+='<i class="blue">'+buyBlueArr[i]+'</i>&nbsp;'
						ww = true;
					}
				}
				if(!ww){
					html+='<i>'+buyBlueArr[i]+'</i>&nbsp;'
				}
				
			}
		}
	}
	return html;
}



function awardCodeShow(awardcode){
	var html="";
	if(awardcode.indexOf("|")>0){
		var awardcodeArr = awardcode.split("|");
		var awardRedCode = awardcodeArr[0];
		var awardBlueCode = awardcodeArr[1];
		var awardRedStr = awardRedCode.replace(/,/g," ");
		
		html+=awardRedStr+"&nbsp";
		
		if(awardBlueCode.indexOf(",")<0){
			html+='<i class="blue">'+awardBlueCode+'</i>';
		}else{
			html+='<i class="blue">'+awardBlueCode.replace(/,/g," ")+'</i>';
		}
	}
	
	return html;	
	
}

