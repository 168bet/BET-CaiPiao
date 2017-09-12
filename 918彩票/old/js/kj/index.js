function anyCode(str){
	var html="";
	var arr=new Array();
	if(str){
		if(str.indexOf("|")!=-1){
			arr = str.split("|");
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
		}else{
			arr = str.split(",");
			for(var i=0;i<arr.length;i++){
				html+='<cite>'+arr[i]+'</cite>';
			}
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

$(function(){
	$('.loading').hide();
	D.load();
	$.ajax({
		url:"/data/app/lottery_results2.xml",
		success: function(data) {
			D.load(close);
			var R = $(data).find("rows");
			var r = R.find("row");
			var html="";
			r.each(function(a,b){
				var gid = $(this).attr("gid");
				var code = $(this).attr("code");
				var pid = $(this).attr("pid");
				var awardtime = $(this).attr("awardtime").substr(0,10);
				var trycode = $(this).attr("trycode");
				if(gid==01 || gid==50  || gid==53 || gid==51 || gid==52 || gid==07 || gid==04 || gid==54
						|| gid==56 || gid==57 || gid==20 || gid==06 || gid==08 || gid==09){
					html+='<a href="#class=url&xo=kj/r.html&gid='+gid+'&pid='+pid+'">';
	            	html+='<div class="clearfix kjTit"><h2>'+anyName(gid,$_sys.lot)+'</h2><span>第'+pid+'期 </span></div>';
	            	html+='<div class="kjBall">'+anyCode(code)+'</div>';
	            	html+='<i class="rightArrow"></i>';
	            	html+='</a>';
				}else if(gid==03){
					html+='<a href="#class=url&xo=kj/r.html&gid='+gid+'&pid='+pid+'">';
	            	html+='<div class="clearfix kjTit"><h2>'+anyName(gid,$_sys.lot)+'</h2><span>第'+pid+'期 </span></div>';
	            	html+='<div class="kjBall">'+anyCode(code)+'<span class="gray pdLeft08">试机号：'+trycode+'</span></div>';
	            	html+='<i class="rightArrow"></i>';
	            	html+='</a>';
				}else if(gid==80){
					html+='<a href="#class=url&xo=kj/r.html&gid='+gid+'&pid='+pid+'">';
	            	html+='<div class="clearfix kjTit"><h2>'+anyName(gid,$_sys.lot)+'</h2><span>第'+pid+'期 </span></div>';
	            	html+='<div class="kjBox">'+anyCode(code)+'</div>';
	            	html+='<i class="rightArrow"></i>';
	            	html+='</a>';
				}else if(gid==81){
					html+='<a href="#class=url&xo=kj/r.html&gid='+gid+'&pid='+pid+'">';
	            	html+='<div class="clearfix kjTit"><h2>'+anyName(gid,$_sys.lot)+'</h2><span>第'+pid+'期 </span></div>';
	            	html+='<div class="kjBox">'+anyCode(code)+'</div>';
	            	html+='<i class="rightArrow"></i>';
	            	html+='</a>';
				}else if(gid==58){
					html+='<a href="#class=url&xo=kj/r.html&gid='+gid+'&pid='+pid+'">';
	            	html+='<div class="clearfix kjTit"><h2>'+anyName(gid,$_sys.lot)+'</h2><span>第'+pid+'期 </span></div>';
	            	html+='<div class="kjdice">';
	            	code = code.split(',');
	            	for(var n=0; n<code.length; n++){
	            		var co = code[n],co1,co2;
	            		co1 = co.substr(0,1);
	            		co1 = {'1':'spade','2':'heart','3':'club','4':'box'}[co1];//黑红梅方
	            		co2 = co.substring(1);
	            		co2 = {'01':'A','11':'J','12':'Q','13':'K'}[co2]||parseInt(co2);
	            		html+='<span><cite class='+co1+'></cite><em '+(co1 == 'heart' || co1 == 'box' ?'class=red':'')+'>'+co2+'</em></span>';
	            	}
	            	html+='</div>';
	            	html+='<i class="rightArrow"></i>';
	            	html+='</a>';
					
				}else if(gid==70){
					code = code.split('|');
					var co = code[0].split('VS');
					html+='<a href="/jczq/kj/">';
					html+='<div class="clearfix kjTit"><h2>竞彩足球</h2><span>'+awardtime+'</span></div>';
					html+='<div class="kjDz"><em>'+co[0]+'</em><em>'+code[1]+'</em><em>'+co[1]+'</em></div>';
					html+='<i class="rightArrow"></i></a>';
				}else if(gid==71){
					code = code.split('|');
					var co = code[0].split('VS');
					html+='<a href="/jclq/kj/">';
					html+='<div class="clearfix kjTit"><h2>竞彩篮球</h2><span>'+awardtime+'</span></div>';
					html+='<div class="kjDz"><em>'+co[0]+'</em><em>'+code[1]+'</em><em>'+co[1]+'</em></div>';
					html+='<i class="rightArrow"></i></a>';
				}else if(gid==85){
					code = code.split('|');
					var co = code[0].split('VS');
					html+='<a href="#class=url&xo=bjdc/kj/index.html">';
					html+='<div class="clearfix kjTit"><h2>北京单场</h2><span>'+awardtime+'</span></div>';
					html+='<div class="kjDz"><em>'+co[0]+'</em><em>'+code[1]+'</em><em>'+co[1]+'</em></div>';
					html+='<i class="rightArrow"></i></a>';
				}
			})
			$(".all").html(html);
		}
	})
	
})
