
	
	var getstrtime=function(data,flag){//格式化时间对象，flag=1带年份，flag=0不带年份
		var str= (data.getFullYear()+"-"+((data.getMonth()+1)<10?("0"+(data.getMonth()+1)):(data.getMonth()+1))+"-"+(data.getDate()<10?("0"+data.getDate()):data.getDate()))	
		
		if(flag==1){
			return str;
		}else{
			return str.substr(5,5);

		}
	
	}


	var load=function(time){
		$('.pdtop3').hide();
		$.ajax({
			url:"/grounder/kpgoldbeanaccout.go?flag=0&qtype=1&date1="+time+"&cgameid=3&psize=20",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");

				var  p  = R.find("phrecords");
				var  row  = R.find("row");
				var abc=0;
				var  oli='';
				if(code==0){
					if(row.length>0){
						var ispj_all="";
						row.each(function(i){
							abc++;
							var rank  = $(this).attr("rank");
							var uname  = $(this).attr("uname");
							var jdyl  = $(this).attr("jdyl");
							var hbjl  = $(this).attr("hbjl");
							
							var ispj  = $(this).attr("ispj");
							ispj_all=ispj_all+ispj+",";
							
							
							
							if(i<10)
							{
								var one_list='<ul><li>'+rank+'</li><li>'+uname+'</li><li>'+jdyl+'</li><li style="color:red">'+hbjl+'</li></ul>';
								oli=oli+one_list; 

							}

						})
						if(ispj_all.split("1").length-1==10){
							$("#dyz").show();
						}else{
							$("#dyz").hide();
						}
					}
					
			/**		
					if(row.length<1){
						oli=oli+'<ul><li>1;'+'</li><li>&nbsp;'+'</li><li>&nbsp;'+'</li><li style="color:red">'+288+'</li></ul>';
					}
					if(row.length<2){
						oli=oli+'<ul><li>2;'+'</li><li>&nbsp;'+'</li><li>&nbsp;'+'</li><li style="color:red">'+128+'</li></ul>';
					}
					if(row.length<3){
						oli=oli+'<ul><li>3'+'</li><li>&nbsp;'+'</li><li>&nbsp;'+'</li><li style="color:red">'+88+'</li></ul>';
					}
					if(row.length<10){
						for(var ii=0;ii<10-row.length;ii++){
							oli=oli+'<ul><li>'+(row.length+ii)+'</li><li>&nbsp;'+'</li><li>&nbsp;'+'</li><li style="color:red">'+38+'</li></ul>';
						}
						
					}
				**/	
					
					$("#z_list").html(oli);
					//获取当前登录用户在当前类型榜单下的金豆盈利和排名
					var jdyl=R.attr('jdyl');
					var rank=R.attr('rank');
					//如果盈利是负数的时候让它显示0
					var tem=parseInt(jdyl);
					if(tem<0){
						jdyl=0;
					}
					var odiv='';
					var two_list='<span>您今日盈利<em>'+jdyl+'</em>金豆，排名<em>'+rank+'</em></span>';
					odiv=odiv+two_list;
					if(tem>0){
						$('#yl_info').html(odiv);
						$('.pdtop3').show();
					}else{
						$('.pdtop3').hide();

					}
					$(".wu").hide();
					//有数据时div里面ul偶数的背景为灰色
					$('#z_list ul:even').css('background-color','#f7f7f7');
				}else if(code==1){
					$(".wu").show();
					//无数据时div里面ul偶数的背景为灰色
					$('#z_list ul').css('background-color','#fff');
				}
					
			}
		})

	
	}
	
	
	
	//初始化日期
	var curtime=new Date();	
	var pretime=new Date((curtime/1000-24*3600)*1000);	
	var nexttime=new Date((curtime/1000+24*3600)*1000);
	
	$("#tab1").html(getstrtime(pretime,0));
	$("#tab2").html(getstrtime(curtime,0));
	$("#tab3").html(getstrtime(nexttime,0));
	

	load(getstrtime(curtime,1));


		
	$("#tab1").bind("click",function(){	
		nexttime=curtime;
		$("#tab3").html(getstrtime(nexttime,0));

		curtime=pretime;
		$("#tab2").html(getstrtime(curtime,0));
	
		pretime = new Date((pretime/1000-24*3600)*1000);
		$("#tab1").html(getstrtime(pretime,0));
		
		load(getstrtime(curtime,1));
		$("#tab3").show();//此处可以控制开始时间
		$(".right").show();	
		
	})
	
	$("#tab3").bind("click",function(){
		
		 pretime=curtime;
		$("#tab1").html(getstrtime(pretime,0));

		 curtime=nexttime
		$("#tab2").html(getstrtime(curtime,0));

		 nexttime = new Date((nexttime/1000+24*3600)*1000); 
		$("#tab3").html(getstrtime(nexttime,0));

		load(getstrtime(curtime,1));
		
		var now=new Date();
		if(curtime.getMonth()==now.getMonth() && curtime.getDate()==now.getDate()){
			$("#tab3").hide();
			$(".right").hide();
		}else{
			$("#tab3").show();
			$(".right").show();		
		}
	})	
	
	
	
	
	
	
