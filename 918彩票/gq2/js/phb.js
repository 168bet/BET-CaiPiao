var XHC={}


var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="100%"></figure><p>暂无排行榜数据</p></article>';


XHC.JCZQ=(function(){
	
	var bindEvent=function(){
		
		
		var urlArr={
				"0":"bkbc.html",
				"1":"phb.html",
				"2":"fx.html",
				"3":"myjc.html",
		};
		
		$(".kcfooter li").bind("click",function(){
			
			var index=$(this).index();
			
			window.location.href=urlArr[index];
		})
		
		$("#phb_nav li").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");

			if(index==2){
				$("#changeDate").addClass("phscroll2")
			}else{
				$("#changeDate").removeClass("phscroll2")
			}
			
			initDate(new Date());
			$(".prov").hide();
			
			var t = $("#changeDate b").html();
			phbParam.date1=t
			
			if($(".kctab span:eq(0)").hasClass("cur")){//篮球
				l_list(index);
				$(".first").show();
			}else{
				z_list(index);
				$(".first").show();
			}
			
		});
		
		
		$(".kctab span").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur");
			var index = $("#phb_nav li.cur").index();
			
			if($(this).index()==0){//篮球
				l_list(index);
				$(".first").show();
			}else{//足球
				z_list(index);
				$(".first").show();
			}
		});
		
		
		//切换时间---调用方法
		
		$("#changeDate .prev").bind("click",function(){
			var mid_time = $("#changeDate b").html();
			
			var index = $("#phb_nav li.cur").index();
			if(index==0){//日榜
				changeDate(mid_time,"d",0);
			}else if(index==2){//月榜
				changeDate(mid_time,"m",0);
			}else{
				$(".prov").hide();
				changeDate(mid_time,"week",0);
			}
			if($(".kctab span:eq(0)").hasClass("cur")){//篮球
				
				l_list(index)
				$(".first").show();
			}else{
				z_list(index)
				$(".first").show();
			}
		})
		
		
		$("#changeDate .prov").bind("click",function(){
			var mid_time = $("#changeDate b").html();
			changeDate(mid_time,"d",0);
			var index = $("#phb_nav li.cur").index();
			if(index==0){//日榜
				changeDate(mid_time,"d",1);
			}else if(index==2){//月榜
				changeDate(mid_time,"m",1);
			}else{
				$(".prov").hide();
				changeDate(mid_time,"week",1);
			}
			if($(".kctab span:eq(0)").hasClass("cur")){//篮球
				l_list(index)
				$(".first").show();
			}else{
				z_list(index)
				$(".first").show();
			}
		})
		
		$("#help").bind("click",function(){		
			$(".popup").show();
			$(".zhezhao").show();
			
		})
		
		$("#ture").bind("click",function(){		
			$(".popup").hide();
			$(".zhezhao").hide();
			
		})
		
	};
	
	//查询排行榜所需参数
	var phbParam = {
			flag:"0",
			qtype:"4",
			phtype:"d",//默认日榜
			date1:"2015-06-11",
			psize:40
	}
	var ios_date = function(time){
		var t = {},
			UA = navigator.userAgent;
		time = time.split("~") || [];
		var time1 = time[0];
		var time2 = time[1];
		if(/Ios/.test(UA)){
			t.t0 = new Date('2015-'+time1);
			t.t1 = new Date('2015-'+time2);
		}else{
			t.t0 = new Date('2015',time1.split('-')[0]-1, time1.split('-')[1]);
			t.t1 = new Date('2015',time2.split('-')[0]-1, time2.split('-')[1]);
		}
		return t;
	};
	//改变时间
	var changeDate=function(time,type,flag){
		var cur_timeStr="";
		var prev_timeStr="";
		var next_timeStr="";
		var d="";
		
		var pt,nt;
		if(type=="d"){
			var t = new Date(time);
			if(flag==1){//加时间
				d = t.getDate()+1;//获取某天的后一天
				
			}else{//减
				//var t = new Date(time);
				d = t.getDate()-1;//获取某天的前一天
			}
			
			var cur_temp = new Date(t.setDate(d))
			cur_timeStr=cur_temp.getFullYear()+"-"+((cur_temp.getMonth()+1)<10?"0"+(cur_temp.getMonth()+1):(cur_temp.getMonth()+1))+"-"+(cur_temp.getDate()<10?"0"+cur_temp.getDate():cur_temp.getDate());
			
			
			var next_temp = new Date(cur_temp.setDate(cur_temp.getDate()+1))
			next_timeStr=((next_temp.getMonth()+1)<10?"0"+(next_temp.getMonth()+1):(next_temp.getMonth()+1))+"-"+(next_temp.getDate()<10?"0"+next_temp.getDate():next_temp.getDate());
			
			
			var prev_temp = new Date(cur_temp.setDate(cur_temp.getDate()-2))
			prev_timeStr=((prev_temp.getMonth()+1)<10?"0"+(prev_temp.getMonth()+1):(prev_temp.getMonth()+1))+"-"+(prev_temp.getDate()<10?"0"+prev_temp.getDate():prev_temp.getDate());
			
			
			var D = new Date()
			var y = D.getFullYear();
			var m = D.getMonth()+1;
			m = m<10?"0"+m:m;
			var day = D.getDate();
			day=day<10?"0"+day:day;
			var tmp = y+"-"+m+"-"+day;
			if(tmp==cur_timeStr){
				$("#changeDate .prov").hide();
			}else{
				$("#changeDate .prov").show();
			}
		}else if(type=="m"){
			var t = new Date(time);
			if(flag==1){//加时间
				m = (t.getMonth())+1;//获取某月的后一个月
			}else{//减
				m = (t.getMonth())-1;//获取某月的前一个月
			}
			var cur_temp = new Date(t.setMonth(m))
			//alert(cur_temp)
			cur_timeStr=cur_temp.getFullYear()+"-"+((cur_temp.getMonth()+1)<10?"0"+(cur_temp.getMonth()+1):(cur_temp.getMonth()+1))
			
			
			var next_temp = new Date(cur_temp.setMonth(cur_temp.getMonth()+1))
			next_timeStr=next_temp.getFullYear()+"-"+((next_temp.getMonth()+1)<10?"0"+(next_temp.getMonth()+1):(next_temp.getMonth()+1))
			
			
			var prev_temp = new Date(cur_temp.setMonth(cur_temp.getMonth()-2))
			prev_timeStr=prev_temp.getFullYear()+"-"+((prev_temp.getMonth()+1)<10?"0"+(prev_temp.getMonth()+1):(prev_temp.getMonth()+1))
			
			//alert(cur_timeStr+"~~"+next_temp+"~~"+prev_timeStr)
			
			var D = new Date()
			var y = D.getFullYear();
			var m = D.getMonth()+1;
			m = m<10?"0"+m:m;
			var day = D.getDate();
			day=day<10?"0"+day:day;
			var tmp = y+"-"+m;
			if(tmp==cur_timeStr){
				$("#changeDate .prov").hide();
			}else{
				$("#changeDate .prov").show();
			}
		}else{
			var iosDate = ios_date(time);
			var t0 = iosDate.t0;
			var t1 = iosDate.t1;
			
			var prev_new_time="";
			var last_new_time="";
			
			if(flag==1){//加时间
				prev_new_time = (t0.getDate())+7;//获取某月的后一个月
				last_new_time = (t1.getDate())+7;
			}else{//减
				prev_new_time = (t0.getDate())-7;//获取某月的前一个月
				last_new_time = (t1.getDate())-7;
			}
			var cur_temp0 = new Date(t0.setDate(prev_new_time))
			var cur_temp1 = new Date(t1.setDate(last_new_time))
			//alert(cur_temp)
			var cur_timeStr0=((cur_temp0.getMonth()+1)<10?"0"+(cur_temp0.getMonth()+1):(cur_temp0.getMonth()+1))+"-"+((cur_temp0.getDate())<10?"0"+(cur_temp0.getDate()):(cur_temp0.getDate()));
			var cur_timeStr1=((cur_temp1.getMonth()+1)<10?"0"+(cur_temp1.getMonth()+1):(cur_temp1.getMonth()+1))+"-"+((cur_temp1.getDate())<10?"0"+(cur_temp1.getDate()):(cur_temp1.getDate()))
			
			var nowDate = new Date();
			var now_local=(((nowDate.getMonth()+1)>10)?((nowDate.getMonth()+1).toString()):("0"+(nowDate.getMonth()+1)))+((nowDate.getDate()>10)?(nowDate.getDate().toString()):("0"+nowDate.getDate()));
			
			
			
			
			var now_last=parseInt(cur_timeStr0.replace("-",""));
			var now_next=parseInt(cur_timeStr1.replace("-",""));
			
			if(now_last<=parseInt(now_local) && now_next>=parseInt(now_local)){				
				$(".prov").hide();
			}else{
				$(".prov").show();
			}
			
			
			
			cur_timeStr=cur_timeStr0+"~"+cur_timeStr1
			prev_timeStr="上&nbsp;&nbsp;周";
			next_timeStr="下&nbsp;&nbsp;周";
			
			/**
			var D = new Date()
			var y = D.getFullYear();
			var m = D.getMonth()+1;
			m = m<10?"0"+m:m;
			var day = D.getDate();
			day=day<10?"0"+day:day;
			var tmp = y+"-"+m;
			if(tmp==cur_timeStr){
				$("#changeDate .prov").hide();
			}else{
			***/
			//	$("#changeDate .prov").show();
			//}
			
		}
		
		
		
		
		//设置前中后的内容
			$("#changeDate .prev").html(prev_timeStr)
			$("#changeDate b").html(cur_timeStr)
			$("#changeDate .prov").html(next_timeStr)
			
		var tmp = 0;
		if(cur_timeStr.indexOf("~")<0){

			
			tmp = parseInt(cur_timeStr.replace(/-/g, ""));
			if(type=="d"){
				if(tmp<20150724){
					$("#ul_header li:last").html("红包奖励");
				}else{
					$("#ul_header li:last").html("奖券奖励");
				}
			}else if(type=="m"){
				if(tmp<201508){
					$("#ul_header li:last").html("红包奖励");
				}else{
					$("#ul_header li:last").html("奖券奖励");
				}
			}
		}else{
			$("#ul_header li:last").html("奖券奖励");
		}
		
	}
	
	
	var initDate=function(now){
		var next_timeStr,prev_timeStr;
		var date = new Date(now);
		var cur_timeStr;
		if($("#phb_nav li:eq(0)").hasClass("cur")){//日榜
			cur_timeStr = date.getFullYear()+"-"+((date.getMonth()+1)<10?"0"+(date.getMonth()+1):(date.getMonth()+1))+"-"+(date.getDate()<10?"0"+date.getDate():date.getDate());
			
			var next_temp = new Date(date.setDate(date.getDate()+1))
			var next_timeStr=((next_temp.getMonth()+1)<10?"0"+(next_temp.getMonth()+1):(next_temp.getMonth()+1))+"-"+(next_temp.getDate()<10?"0"+next_temp.getDate():next_temp.getDate());
			
			
			var prev_temp = new Date(date.setDate(date.getDate()-2))
			prev_timeStr=((prev_temp.getMonth()+1)<10?"0"+(prev_temp.getMonth()+1):(prev_temp.getMonth()+1))+"-"+(prev_temp.getDate()<10?"0"+prev_temp.getDate():prev_temp.getDate());
			
			
			//设置前中后的内容
			$("#changeDate .prev").html(prev_timeStr)
			$("#changeDate b").html(cur_timeStr)
			$("#changeDate .prov").html(next_timeStr)
			
			$("#changeDate .prov").hide();
			
		}else if($("#phb_nav li:eq(2)").hasClass("cur")){
			cur_timeStr = date.getFullYear()+"-"+((date.getMonth()+1)<10?"0"+(date.getMonth()+1):(date.getMonth()+1));
			
			var next_temp = new Date(date.setMonth(date.getMonth()+1))
			next_timeStr=next_temp.getFullYear()+"-"+((next_temp.getMonth()+1)<10?"0"+(next_temp.getMonth()+1):(next_temp.getMonth()+1))
			
			
			var prev_temp = new Date(date.setMonth(date.getMonth()-2))
			prev_timeStr=prev_temp.getFullYear()+"-"+((prev_temp.getMonth()+1)<10?"0"+(prev_temp.getMonth()+1):(prev_temp.getMonth()+1))
			
			//设置前中后的内容
			$("#changeDate .prev").html(prev_timeStr)
			$("#changeDate b").html(cur_timeStr)
			$("#changeDate .prov").html(next_timeStr)
			
			$("#changeDate .prov").hide();
			
		}else if($("#phb_nav li:eq(1)").hasClass("cur")){
			var d = date.getDay()
			d=d==0?7:d;
			
			var dist_first_d = d-1;
			var dist_last_d = 7-d;
			
			var first_d = new Date(new Date().setDate(date.getDate()-dist_first_d));
			var last_d = new Date(new Date().setDate(date.getDate()+dist_last_d));
			
			var first_cur_timeStr=((first_d.getMonth()+1)<10?"0"+(first_d.getMonth()+1):(first_d.getMonth()+1))+"-"+((first_d.getDate()<10?"0"+first_d.getDate():first_d.getDate()))
			var last_cur_timeStr=((last_d.getMonth()+1)<10?"0"+(last_d.getMonth()+1):(last_d.getMonth()+1))+"-"+((last_d.getDate()<10?"0"+last_d.getDate():last_d.getDate()))
			
				cur_timeStr=first_cur_timeStr+"~"+last_cur_timeStr;
			
			//var prev_first_cur_timeStr=new Date(new Date().setDate(date.getDate()-dist_first_d));
			
			//设置前中后的内容
			
			
			$("#changeDate .prev").html("上&nbsp;&nbsp;周");
			$("#changeDate b").html(cur_timeStr);
			$("#changeDate .prov").html("下&nbsp;&nbsp;周");
			
			$("#changeDate .prov").show();
			
		}
		
		
		var tmp = 0;
		if(cur_timeStr.indexOf("~")<0){
			tmp = parseInt(cur_timeStr.replace(/-/g, ""));
			if($("#phb_nav li:eq(0)").hasClass("cur")){
				if(tmp<20150724){
					$("#ul_header li:last").html("红包奖励");
				}else{
					$("#ul_header li:last").html("奖券奖励");
				}
			}else if($("#phb_nav li:eq(2)").hasClass("cur")){
				if(tmp<201508){
					$("#ul_header li:last").html("红包奖励");
				}else{
					$("#ul_header li:last").html("奖券奖励");
				}
			}
		}else{
			$("#ul_header li:last").html("奖券奖励");
		}
		//设置前中后的内容
		/**
		$("#changeDate .prev").html(prev_timeStr)
		$("#changeDate b").html(cur_timeStr)
		$("#changeDate .prov").html(next_timeStr)
		
		$("#changeDate .prov").hide();
		***/
		
	}
	//http://t2015.9188.com /grounder/fgoldenbeanaccount.go?flag=0&qtype=4&phtype=d&date1=2015-06-11
	
	
	var myzArr=[];
	var dyzArr=[];
	
	//加载足球排行榜
	var z_list=function(index){
		$("#z_list").html("");
		$(".first").hide();
		var html="";
		if(index==0){//日榜
			phbParam.phtype="d";
			phbParam.date1=$("#changeDate b").html();
		}else if(index==2){//月榜
			phbParam.phtype="m";
			//phbParam.date1="2015-06";
			phbParam.date1=$("#changeDate b").html();
		}else if(index==1){
			phbParam.phtype="week";
			var wtimeArr;
			var wtime = $("#changeDate b").html()
			if(wtime.indexOf("~")!=-1){
				wtimeArr = wtime.split(",");
			}
			phbParam.date1="2015-"+wtimeArr[0]
		}
		
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go",
			dataType:'xml',
			data:phbParam,
			cache:true,
			success: function(xml){
				dyzArr=[];
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");

				
				if(code==0){//查询成功
					var phrecords = R.find("phrecords");
					var ylphinfo = R.find("ylphinfo");
					
					var ycode = ylphinfo.attr("code");
					var ydesc = ylphinfo.attr("desc");
					var daward = ylphinfo.attr("daward");//日盈利
					var dpm = parseInt(ylphinfo.attr("dpm"));
					var maward = ylphinfo.attr("maward");
					var waward = ylphinfo.attr("waward");
					var mpm = ylphinfo.attr("mpm");
					var wpm = ylphinfo.attr("wpm");
					var jdtr = ylphinfo.attr("jdtr");
					var jdjl = ylphinfo.attr("jdjl");
					var isreward = phrecords .attr("isreward");
			

					
					if(ycode==0){
						$("#yl_info").parent().show();
						if(phbParam.phtype=="d"){
							$("#yl_info").html("<span>&nbsp;&nbsp;您本日足球盈利<em>"+(daward>0?(daward+"</em>金豆，排名<em>"+dpm+"</em></span>"):"0</em>金豆"));
						}else if(phbParam.phtype=="m"){
							$("#yl_info").html("<span>&nbsp;&nbsp;您本月足球盈利<em>"+(maward>0?(maward+"</em>金豆，排名<em>"+mpm+"</em></span>"):"0</em>金豆"));
						}else if(phbParam.phtype=="week"){
							$("#yl_info").html("<span>&nbsp;&nbsp;您本周足球盈利<em>"+(waward>0?(waward+"</em>金豆，排名<em>"+wpm+"</em></span>"):"0</em>金豆"));
							//$("#yl_info").parent().hide();

						}
					}else{
						$("#yl_info").parent().show();
						var wcy=phbParam.phtype=="d"?"本日":phbParam.phtype=="m"?"本月":phbParam.phtype=="week"?"本周":"&nbsp;";
						$("#yl_info").html("<span>&nbsp;&nbsp;您"+wcy+"未参与竞猜</span>");

					}
					
					
					var source = phrecords.attr("source");
					var total = phrecords.attr("total");
					var tpage = phrecords.attr("tpage");
					
					var row = phrecords.find("row");
					
					if(row.length>0){
						row.each(function(i){
							var rank = $(this).attr("rank");
							var uname = $(this).attr("uname");
							var jdtr = $(this).attr("jdtr");
							var jdjl = $(this).attr("jdjl");
							var jdyl = $(this).attr("jdyl");
							var jccs = $(this).attr("jccs");
							var mzcs = $(this).attr("mzcs");
							var hbjl = $(this).attr("hbjl");
							var ispj = $(this).attr("ispj");
							var extra = $(this).attr("extra");

							
							
							var week_split=phbParam.date1.split("-");
							week_split[1]=parseInt(week_split[1])-1;
							var ifweek=new Date(week_split[0],week_split[1],week_split[2]);
						//	alert(ifweek.getDay());
							
							tmp2 = parseInt(phbParam.date1.replace(/-/g, ""));
						//	if(tmp2>=20150815 && (ifweek.getDay()==0 || ifweek.getDay()==6 )){//if(tmp2>=20150815 && (tmp2-20150815)%7<2)
						//		hbjl=parseInt(hbjl)/2+"*2";
						//	}
							
							hbjl=(hbjl=="0*2"?"&nbsp;":hbjl);
							if(isreward==0){
								hbjl="&nbsp;";
							}
							
							if(ispj==1){
								dyzArr.push(ispj);
							}
							
							var c = i%2==0?"graybg":"";
							
							if(extra!=0){
								html += '<ul style="color:orange" class="'+c+'">';
							}else{
								html += '<ul class="'+c+'">';
							}
							
							if(rank==1 || rank==2 || rank==3){
								if(extra!=0){
									html+='<li class="vip"><em>'+rank+'</em></li>';
								}else{
									html+='<li><em>'+rank+'</em></li>';
								}
							}else{
								if(extra!=0){
									html+='<li class="vip">'+rank+'</li>';
								}else{
									html+='<li>'+rank+'</li>';
								}
							}

								html += '<li>'+uname+'</li>';
							html += '<li>'+jdyl+'</li>';
							
							if(extra!=0){
								html += '<li >'+hbjl+'+'+extra+'</li>';
							}else{
								html += '<li>'+hbjl+'</li>';
							}
							
							html += '</ul>';
						})
						
						
						//alert(dyzArr.length)
						if(dyzArr.length>=10){
							$("#dyz").show();
						}else{
							$("#dyz").hide();
						}
						
						$("#z_list").html(html);
						$(".first").show();
					}else{
						$("#z_list").html(nodata);
						$(".first").hide();
						$("#dyz").hide();
					}
					
				}else{
					alert(desc)
				}
			}
		})
	};
	
	//加载篮球排行榜
	var l_list=function(index){
		$("#z_list").html("");
		$(".first").hide();
		var html="";
		if(index==0){//日榜
			phbParam.phtype="d";
			phbParam.date1=$("#changeDate b").html();
			//phbParam.date1="2015-06-11";
		}else if(index==2){//月榜
			phbParam.phtype="m";
			phbParam.date1=$("#changeDate b").html();
			//phbParam.date1="2015-06";
			
		}else if(index==1){

			phbParam.phtype="week";
			var wtimeArr;
			var wtime = $("#changeDate b").html();
			if(wtime.indexOf("~")!=-1){
				wtimeArr = wtime.split(",");
			}
			phbParam.date1="2015-"+wtimeArr[0]
		}
		
		
		
		//phbParam.date1=$("#changeDate b").html();
		$.ajax({
			url:"/grounder/goldenbeanaccount.go",
			dataType:'xml',
			data:phbParam,
			cache:true,
			success: function(xml){
				dyzArr=[];
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");

				if(code==0){//查询成功
					var phrecords = R.find("phrecords");
					var ylphinfo = R.find("ylphinfo");
					
					var ycode = ylphinfo.attr("code");
					var ydesc = ylphinfo.attr("desc");
					var daward = ylphinfo.attr("daward");//日盈利
					var dpm = parseInt(ylphinfo.attr("dpm"));
					var maward = ylphinfo.attr("maward");
					var mpm = ylphinfo.attr("mpm");
					var jdtr = ylphinfo.attr("jdtr");
					var jdjl = ylphinfo.attr("jdjl");
					var isreward = phrecords .attr("isreward");

					

					
					if(ycode==0){
						$("#yl_info").parent().show();
						if(phbParam.phtype=="d"){
							$("#yl_info").html("<span>&nbsp;&nbsp;您本日篮球盈利<em>"+(daward>0?(daward+"</em>金豆，排名<em>"+dpm+"</em></span>"):"0</em>金豆"));
						}else if(phbParam.phtype=="m"){
							$("#yl_info").html("<span>&nbsp;&nbsp;您本月篮球盈利<em>"+(daward>0?(daward+"</em>金豆，排名<em>"+dpm+"</em></span>"):"0</em>金豆"));
						}else if(phbParam.phtype=="week"){
							$("#yl_info").html("<span>&nbsp;&nbsp;您本周篮球盈利<em>"+(daward>0?(daward+"</em>金豆，排名<em>"+dpm+"</em></span>"):"0</em>金豆"));
						}
					}else{
						$("#yl_info").parent().show();
						var wcy=phbParam.phtype=="d"?"本日":phbParam.phtype=="m"?"本月":phbParam.phtype=="week"?"本周":"&nbsp;";
						$("#yl_info").html("<span>&nbsp;&nbsp;您"+wcy+"未参与竞猜</span>");
					}
					
					
					var source = phrecords.attr("source");
					var total = phrecords.attr("total");
					var tpage = phrecords.attr("tpage");
					
					var row = phrecords.find("row");
					
					if(row.length>0){
						row.each(function(i){
							var rank = $(this).attr("rank");
							var uname = $(this).attr("uname");
							var jdtr = $(this).attr("jdtr");
							var jdjl = $(this).attr("jdjl");
							var jdyl = $(this).attr("jdyl");
							var jccs = $(this).attr("jccs");
							var mzcs = $(this).attr("mzcs");
							var hbjl = $(this).attr("hbjl");
							var ispj = $(this).attr("ispj");

							var extra = $(this).attr("extra");

							var tmp2 = parseInt(phbParam.date1.replace(/-/g, ""));
							if(tmp2<20150724&&phbParam.phtype=="d"){
								hbjl="&nbsp;";
							}
							hbjl=(hbjl=="0"?"&nbsp;":hbjl);

							if(ispj==1){
								dyzArr.push(ispj);
							}
							
							var c = i%2==0?"graybg":"";
							
							if(isreward==0){
								hbjl="&nbsp;";
							}
							
							html += '<ul class="'+c+'">';
							if(rank==1 || rank==2 || rank==3){
								if(extra!=0){
									html+='<li class="vip"><em>'+rank+'</em></li>';
								}else{
									html+='<li><em>'+rank+'</em></li>';
								}
								
							}else{
								if(extra!=0){
									html+='<li class="vip">'+rank+'</li>';
								}else{
									html+='<li>'+rank+'</li>';
								}
							}
							
							if(extra!=0){
								html += '<li style="color:red">'+uname+'</li>';
							}else{
								html += '<li>'+uname+'</li>';
							}
							
							html += '<li>'+jdyl+'</li>';
							/***
							if(phbParam.phtype=="d"){
								html += '<li>&nbsp;</li>';
							}else{
								
							}
							***/
							html += '<li>'+hbjl+'</li>';
							html += '</ul>';
						})
						
						if(dyzArr.length>=10){
							$("#dyz").show();
						}else{
							$("#dyz").hide();
						}
						$("#z_list").html(html);
						
						if(phbParam.phtype!="d"){
							$("#ul_header li:last").show();
							$("#z_list ul").find("li:last").show();
							$("#phb_list").removeClass("list2");
						}else{
							$("#ul_header li:last").show();
							$("#z_list ul").find("li:last").show();
							$("#phb_list").removeClass("list2");
						}
						
						$(".first").show();
					}else{
						$("#dyz").hide();
						$("#z_list").html(nodata);
						$(".first").hide();

					}
					
				}else{
					$("#z_list").html(nodata);
					$(".first").hide();

				}
			},
			error:function(){
				$("#z_list").html(nodata);
				$(".first").hide();

			}
		})
	}
	
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	//初始化
	var init = function(){
		remove_header();
		initDate(new Date())
		//changeDate("2015-06-08","m",0);
		z_list(0);
		//l_list(0)
		
		bindEvent();
	};
	
	
	
	return {
		init:init
	}
})()

$(function(){
	XHC.JCZQ.init();
});