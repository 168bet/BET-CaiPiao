var logo={'01':'ssq',
'50':'dlt',
'70':'jczq',
'71':'jclq',
'80':'sfc',
'85':'bjdc',
'03':'sd',
'53':'p3'	
};
var pn=1;
var content='';

	$.ajax({
				url:'/trade/forecast.go?name=yuce',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var list = $(xml).find('row');

					var html ='';
					
					list.each(function()
					{
						var name =$(this).attr("name");
						var gid=$(this).attr("gid");
						var title=$(this).attr("title").substr(0,14)+'...';
						var logo123="icoLogo "+logo[gid]+'Logo';
					var	tmp="<a href=\""+"/yuce/yclb.html?gid="+gid+"\""+"><dl><dt class=\""+logo123+"\"></dt><dd><h2>"+name+"</h2><cite>"+title+"</cite></dd></dl></a>"
						
						
						
					//	var tmp="<a href=/yuce/yclb.html?gid="+gid+">"+"<dl> <dt class="+logo123+"></dt><dd><h2>"+name+"</h2><cite>"+title+"</cite></dd></dl></a>"	
					//	alert(name+  "       "+  gid   + "      "+title   );
						html=html+tmp;
					})
					jQuery('.yuceList').html(html);
				//	jQuery('.yuceList').hide();
			
				}
			}
			)

	var yuceindex={
			initial:function(){
			yuceindex.i_add();
				},
			i_add:function(){	$.ajax({
							url:'/trade/apphotnews.go?pn='+pn,
							type:'GET',
							DataType:'XML',
							success: function(xml){
								var list = $(xml).find('row');

								
								list.each(function()
								{
									var local=window.location.href.split("/");
									
									var arcurl ="http:\/\/mobile.9188.com  "+$(this).attr("arcurl")+"?phone=4g&url="+local[0]+"//"+local[1]+local[2]+"\/";
									
									var time_b=arcurl.split('/')[6];
									time_a=time_b.substr(0,2)+"-"+time_b.substr(2,4);
									var ntitle =$(this).attr("ntitle");
									var description =$(this).attr("description").substr(0,20)+'...';
									
								var	tmp="<a href=\""+arcurl+"\""+"><cite>"+ntitle+"</cite><p><span class=\"left\""+">"+description+"</span><em class=\"right\">"+time_a+"</em></p>";				
									
									
								//	var tmp="<a href=/yuce/yclb.html?gid="+gid+">"+"<dl> <dt class="+logo123+"></dt><dd><h2>"+name+"</h2><cite>"+title+"</cite></dd></dl></a>"	
								//	alert(name+  "       "+  gid   + "      "+title   );
									content=content+tmp;
								}
									)
								jQuery('.yuceList3').html(content);
							if(pn==1)
								jQuery('.yuceList3').hide();
						
							}
						}
					)},
						
			more_click:$("#moresult1").Touch(function(){
							pn++;
				yuceindex.i_add();}
					)
					}	
yuceindex.initial();	


				$(".clearfix li:eq(0)").Touch(
				function(){
				$(".clearfix li:eq(0)").addClass('cur');
				$(".clearfix li:eq(1)").removeClass
				//yuceindex.initial();
				jQuery('.yuceList').hide();
				jQuery('#jindu2').hide();
				jQuery('.yuceList3').show();
				jQuery('#jindu1').show();
				$("#moresult1").show();
				})
				
					$(".clearfix li:eq(1)").Touch(
				function(){
				$(".clearfix li:eq(1)").addClass('cur');
				$(".clearfix li:eq(0)").removeClass
				jQuery('.yuceList').show();
				jQuery('#jindu2').show();
				jQuery('.yuceList3').hide();
				jQuery('#jindu1').hide();
				$("#moresult1").hide();
				})			
