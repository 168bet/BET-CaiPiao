$(function(){
	
	var gid = decodeURIComponent(CP.Util.getParaHash("gid"));
	var pid = decodeURIComponent(CP.Util.getParaHash("pid"));
	//对应期数开奖详情
	$.ajax({
		url : "/trade/detail.go",
		dataType:"xml",
		data:"gid="+gid+"&pid="+pid,
		success : function(xml){
			var R = $(xml).find("rows");
			var code = R.attr("acode");//开奖号码
			var gsale = R.attr("gsale");//本期销量
			gsale = addCommas(gsale);
			var ginfo = R.attr("ginfo");//单注奖金
			var ninfo = R.attr("ninfo");//中奖注数
			var gpool = R.attr("gpool");//奖池滚存
			gpool = addCommas(gpool);
			var atime = R.attr("atime");//开奖日期
			var ginfo1 = ginfo.split(',');
			var ninfo1 = ninfo.split(',');
			
			var pub="历史开奖详情";
			var html = '';
			var rank = {'0':'一等奖','1':'二等奖','2':'三等奖','3':'四等奖','4':'五等奖','5':'六等奖','6':'二等奖加奖'};

			var str = anyName(gid,$_sys.lot);
			$(".tzHeader .fixed2 .kjHeader h1").html(str+pub);
			html += '<p class="pdTop04 pdLeft04"><span class="fontSize1">第'+pid+'期</span><cite class="gray pdLeft04">'+atime+'</cite></p>';
			//html += '<div class="kjBall pdLeft04">'+anyCodeKJ(code)+'</div>';
			html += anyCodeKJ(code);

			html += '<ul class="kjList">';
			html += '<li class="gray"><em>奖项</em><cite>注数</cite><span>每注金额</span></li>';
				if(gid == '01' || gid == '07' || gid == '51'){
					if(code.split("|").length==3){//双色球幸运嘉奖
						for(var n = 0; n<7; n++){
							html += '<li><em>'+rank[n]+'</em><cite>'+(ninfo1[n]?ninfo1[n]:"--")+'</cite><span>'+(ginfo1[n]?ginfo1[n]:"--")+'</span></li>';
						}
					}else{
						for(var n = 0; n<6; n++){
							html += '<li><em>'+rank[n]+'</em><cite>'+(ninfo1[n]?ninfo1[n]:"--")+'</cite><span>'+(ginfo1[n]?ginfo1[n]:"--")+'</span></li>';
						}
					}
					
				}else if(gid == '50'){
					for(var i=0;i<ginfo1.length;i++){
						if(ginfo1[i] != "--"){
							html+='<li>';
							html+='<em>'+level[i+1]+'</em>';
							html+='<cite>'+ninfo1[i]+'</cite>';
							html+='<span>'+ginfo1[i]+'</span>';
							html+='</li>';
						}else{
							html+='<li>';
								html+='<em>'+level[i+1]+'</em>';
								html+='<cite>--</cite>';
								html+='<span>--</span>';
								html+='</li>';
							}
					}
				}else if(gid == '03'){
					for(var n = 0; n<3; n++){
						html += '<li><em>'+rank[n]+'</em><cite>'+(ninfo1[n]?ninfo1[n]:"--")+'</cite><span>'+(ginfo1[n]?ginfo1[n]:"--")+'</span></li>';
					}
				}else if(gid == '52'){
					html += '<li><em>一等奖</em><cite>'+(ninfo1[n]?ninfo1[n]:"--")+'</cite><span>'+(ginfo1[n]?ginfo1[n]:"--")+'</span></li>';
				}
			html += '</ul>';
			html += '<div class="gray pdTop06"><p>本期销量'+gsale+'元</p>';
			if(gid == '01' || gid == '50' || gid == '51'){
				html += '<p class="pdTop03">奖池滚存：<cite class="yellow">'+gpool+'元</cite></p>';
			}
			html += '</div>';
			$("#newinfo").html(html);
		}
	});
});
function anyCodeKJ(str){
	var html="";
	
	var arr=new Array();
	if(str){
		if(str.indexOf("|")!=-1){
			arr = str.split("|");
			if(arr.length==2){
				html += '<div class="kjBall pdLeft04">'
				var arr0 = arr[0];
				var arr1 = arr[1];
				var prearr = arr0.split(",");
				var nextarr = arr1.split(",");
				if(nextarr.length==1){
					for(var i=0;i<prearr.length;i++){
						html+='<cite>'+prearr[i]+'</cite>';
					}
					html+='<cite class="blueBall">'+nextarr[0]+'</cite>';
				}else if(nextarr.length==2){
					for(var i=0;i<prearr.length;i++){
						html+='<cite>'+prearr[i]+'</cite>';
					}
					html+='<cite class="blueBall">'+nextarr[0]+'</cite>';
					html+='<cite class="blueBall">'+nextarr[1]+'</cite>';
				}
				html+='</div>';
				
			}else if(arr.length==3){//双色球嘉奖
				html += '<div class="kjBall pdLeft04">'
				var arr0 = arr[0];
				var arr1 = arr[1];
				var arr2 = arr[2];
				var prearr = arr0.split(",");
				//var nextarr = arr1.split(",");
				
				for(var i=0;i<prearr.length;i++){
					html+='<cite>'+prearr[i]+'</cite>';
				}
				html+='<cite class="blueBall">'+arr1+'</cite>';
				html+='</div>';
				html += '<div class="kjBall pdLeft04 pdTop03"><span style="margin-right:.5rem; font-size:1rem">幸运蓝球：</span><cite class="blueBall">'+arr2+'</cite></div>';
			}
			
		}else{
			html += '<div class="kjBall pdLeft04">'
			arr = str.split(",");
			for(var i=0;i<arr.length;i++){
				html+='<cite>'+arr[i]+'</cite>';
			}
			html+='</div>';
		}
	}
	
	
	return html;
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