var logo={'01':'双色球',
'50':'大乐透',
'70':'竞彩足球',
'71':'竞彩篮球',
'80':'足彩',
'85':'北京单场',
'03':'福彩3D',
'53':'排列三'	
};

var url={'01':'/\#class=url&xo=ssq/index.html',
'50':'/#class=url&xo=dlt/index.html',
'70':'/#class=url&xo=jczq/index.html',
'71':'/#class=url&xo=jclq/index.html',
'80':'/#class=url&xo=sfc/index.html',
'85':'/#class=url&xo=bjdc/index.html',
'03':'/#class=url&xo=3d/index.html',
'53':'/#class=url&xo=p3/index.html'	
};



$("#moresult1").hide();
var pn=1;
var html='';

var gid = location.search.getParam('gid');
$(".tzHeader .fcHeader").find("h1").html(logo[gid]+"预测");
var yuce={
		initial: function(){
			yuce.add();
		
		},
		add:function(){
			
			$.ajax({
						url:'/trade/forecast.go?gid='+gid+"&pn="+pn,
						type:'GET',
						DataType:'XML',
						success: function(xml){
							var list = $(xml).find('row');

							
							list.each(function()
							{
								var local=window.location.href.split("/");
								
								var arcurl ="http:\/\/mobile.9188.com  "+$(this).attr("arcurl")+"?phone=4g&url="+local[0]+"//"+local[1]+local[2]+url[gid];
								var time_b=arcurl.split('/')[7];
								time_a=time_b.substr(0,2)+"-"+time_b.substr(2,4);
								var ntitle =$(this).attr("ntitle");
								var description =$(this).attr("description").substr(0,20)+'...';
								var tmp='';
								tmp="<a href=\""+arcurl+"\""+"><cite>"+ntitle+"</cite><p><span class=\"left\""+">"+description+"</span><em class=\"right\">"+time_a+"</em></p>";				
								
								
							//	var tmp="<a href=/yuce/yclb.html?gid="+gid+">"+"<dl> <dt class="+logo123+"></dt><dd><h2>"+name+"</h2><cite>"+title+"</cite></dd></dl></a>"	
							//	alert(name+  "       "+  gid   + "      "+title   );
								html=html+tmp;
							})
							jQuery('.yuceList3').html(html);
						$("#moresult1").show();
						$(".loading").hide();
						}
					}
					)
			},
	
			aaa:$("#moresult1").Touch(function(){
				pn++;
			yuce.add();}
				)	
	
			}
			
yuce.initial();


//$(".fcHeader").find("h1").html(logo[gid]+"Ô¤²â");


