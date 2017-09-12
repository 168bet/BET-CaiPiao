var arrItemid = JSON.parse(localStorage.getItem("jsbf"));
var strItemid = arrItemid.join(",");
$(function(){
	$('.backIco2').bind('click',function(){
		if (history.length == 0) {
			return false;
		} else {
			history.go(-1);
		}
	});
	XX.init_info();
});

var XX = {
		flag:false,
		serverId:"",
		relTimeId:[],
		arrType:[],
		init_info:function(){
			//XX.loadCont();
			XX.bindEvent();
		},
		//绑定事件
		bindEvent:function(){
			var jxzhtml="";
			var kstime;
			//for(var i = 0;i<arrItemid.length;i++){
				$.ajax({
					url:'/zlk-spider-1-SNAPSHOT/roundInfo?ids='+strItemid,
					type:'GET',
					DataType:'XML',
					success: function(xml){
						var xmldoc = $.parseXML(xml);
						var Rows = $(xmldoc).find("Rows");
						var row = Rows.find("row");
						
						jxzhtml += '<section>';
						jxzhtml += '<div class="jsbjList">';
						row.each(function(){
							var ln = $(this).attr("ln");//赛事级别
							var jn = $(this).attr("jn");//周三001
							jn = jn.substr(-3);
							var hn = $(this).attr("hn");//主队名称
							var gn = $(this).attr("gn");//客队名称
							var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
							var htime = $(this).attr("htime");//上半场和下半场的开赛时间
							kstime = htime?htime.substring(11,16):time.substring(11,16);
							var hsc = $(this).attr("hsc");//主队得分
							var asc = $(this).attr("asc");//客队得分
							var halfsc = $(this).attr("halfsc");//半场得分
							var csid = $(this).attr("sid");
							/***
							var tmptime = new Date(time);
							var tmpHours = tmptime.getHours();
							var tmpMinutes = tmptime.getMinutes();
							tmpMinutes = tmpMinutes<10?"0"+tmpMinutes:tmpMinutes;
							var tmp = tmpHours+":"+tmpMinutes;
							var timestr = htime?(new Date(htime).getHours()+":"+new Date(htime).getMinutes()):tmp;
							***/
							var type = $(this).attr("type");
							var roundItemId = $(this).attr("roundItemId");
							//根绝对应roundItemId,把其相应的csid防盗relTimeId数组中
							for(var i=0;i<arrItemid.length;i++){
								if(arrItemid[i]==roundItemId){
									XX.relTimeId.push(csid);
								}
							}
							XX.arrType.push(type);
							var qc = $(this).attr("qc");
							var type = $(this).attr("type");
							var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
							
							
							
							
							//jxzhtml += '<a href="dzxq.html?itemid='+roundItemId+'&qc='+qc+'">';
							jxzhtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'">';
							jxzhtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+kstime+'</span></p>';
							jxzhtml += '<p>'+hn+'</p>';
							jxzhtml += '<p class="jsbfli"><cite class="red" id="up_'+csid+'">'+hsc+':'+asc+'</cite><span class="green" id="tid_'+csid+'"><cite>加载</cite><img src="/img/in.gif" width="12" height="12" id="img"'+csid+'></span></p>';
							jxzhtml += '<p>'+gn+'</p>';
							jxzhtml += '<em class="hmArrow"></em>';
							jxzhtml += '</a>';
						})
						
						jxzhtml += '</div>';
						jxzhtml += '</section>';
						$("#progress").html(jxzhtml);
						XX.update(XX.relTimeId,XX.arrType)
					}
				})
			//}
			//alert(jxzhtml)
			
		},
		loadCont:function(){},
		
		//实时更新正在进行中的对阵
		//实时更新正在进行中的对阵
		update:function(arrsid,arrType){
			var st
			XX.serverId=window.setInterval(function(){
				$.ajax({
					url:'/zlk/jsbf/jc/changerounddata/changeRound.xml',
					type:'GET',
					DataType:'XML',
					success: function(xml){
						var rows = $(xml).find("rows");
						var serverTime = new Date(rows.attr("time"));//服务器时间
						var row = rows.find("row");
						row.each(function(){
							var type = $(this).attr("type");
							var sid = $(this).attr("sid");
							var hg = $(this).attr("hg");
							var ag = $(this).attr("ag");
							var time = new Date($(this).attr("time"));
							st = parseInt((serverTime-time)/60000);
							/***
							if(type==1 || type==2 || type==3){
								var hg = $(this).attr("hg");
								var ag = $(this).attr("ag");
								var time = new Date($(this).attr("time"));
								st = parseInt((serverTime-time)/60000);
								if(type==1){
									if(st<=45){
										st = parseInt((serverTime-time)/60000);
									}else{
										st = "45+";
									}
								}else if(type==2){
									st="中";
								}else if(type==3){
									if(st<=45){
										st = 45+parseInt((serverTime-time)/60000);
									}else{
										st = "90+";
									}
								}
								***/
								for(var i=0;i<arrsid.length;i++){
									if(sid==arrsid[i]){
										if(type==1 || type==2 || type==3){
											if(type==1){
												if(st<=45){
													st = parseInt((serverTime-time)/60000);
												}else{
													st = "45+";
												}
											}else if(type==2){
												st="中";
											}else if(type==3){
												if(st<=45){
													st = 45+parseInt((serverTime-time)/60000);
												}else{
													st = "90+";
												}
											}
											$("#up_"+sid).html(hg+":"+ag);
											$("#tid_"+sid).find("cite").html(st);
										}
									}else{
										//$("#tid_"+arrsid[i]).html("已完赛");
										if(arrType[i]==17){
											$("#tid_"+arrsid[i]).html("未开赛");
										}else if(arrType[i]==4){
											$("#tid_"+arrsid[i]).html("已完赛");
										}
									}
								}
								XX.dist(arrsid,sid);
								if(!XX.flag){
									window.clearInterval(XX.serverId);
								}
						})
					}
				})
			},2000)
		},
		dist:function(arrid,id){
			//var flag=false;
			for(var i=0;i<arrid.length;i++){
				if(arrid[i]==id){
					XX.flag=true;
				}
			}
		}
}