var XHC={};

var noGame  = '<div style="text-align: center; padding: 50px;">暂无已兑换的奖品</div>';
//公用弹出层和加载层

var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};

var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};


XHC.ZLK=(function(){
	var name = localStorage.getItem("username")||"";
	var init = function(){
		bindEvent();
		query_list_Dist("");
	}
	
	
	
	var bindEvent=function(){
		$(".jptab li").bind("click",function(){
			data.pageNo=1;
			var index = $(this).index();
			$("#jlCont").html("");
			$(this).addClass("cur").siblings().removeClass("cur");
			if(index==0){
				query_list_Dist("");
			}else{
				if(index==2){
					query_list_Dist(5);
				}else{
					query_list_Dist(index)	
				}
			}
			
		})
		
		
		$(".more").bind("click",function(){
			var index = $(".jptab li.cur").index();
			if(index==0){
				query_list_Dist("");
			}else{
				query_list_Dist(index);
			}
			
		});
	};
	var status = {
			"0":"未兑换",
			"1":"兑换中",
			"2":"兑换完成",
			"3":"兑换撤销"
	};
	
	
	
	var data = {
			flag:3,
			pageNo:1,//当前页页数
			cnickid:name,
			visit:3000,
			pageSize:10,
			cgtype:""
	};
	
	
	var type = {
			1:"话费",
			2:"Q币",
			3:"红包",
			4:"实物",
			5:"现金"
	}
	
	
	var query_list_Dist=function(tag){
		data.cgtype=tag;
		var html = $("#jlCont").html();
		$.ajax({
			 url: "/activity/ticket.go",
	        type: "POST",
	        data:data,
	        dataType:"xml",
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var code = R.attr("code");
	        	var desc = R.attr("desc");
	        	
	        	var rows = R.find("rows");
	        	var pageTotal = rows.attr("pageTotal");//总页数
	        	var pageSize = rows.attr("pageSize");//页长度
	        	var pageNo = rows.attr("pageNo");//当前页页数
	        	var countTotal = rows.attr("countTotal");//总条数
	        	
	        	var row = rows.find("row");
	        	if(pageTotal==0||!pageTotal){
	        		$("#jlCont").html(noGame);
	        		$(".more").hide();
	        	}else{
	        		if(data.pageNo<=pageTotal){
	        			if(row.length){
			        		row.each(function(){
			        			var itemRemark = $(this).attr("itemRemark");
			        			var consticket = $(this).attr("consticket");
			        			var cgtype = $(this).attr("cgtype");
			        			var contact = $(this).attr("contact");
			        			var itemcash = $(this).attr("itemcash");
			        			var sdstate = $(this).attr("sdstate");//兑换状态
			        			var time = $(this).attr("createTime");
			        			var sdpeopertime = $(this).attr("sdpeopertime");

			        			var D = new Date(time)
			        			
			        			var str_time = "";
			        			var m = D.getMonth()+1;
			        			m=m<10?"0"+m:m
			        			
			        			var d = D.getDate();
			        			d=d<10?"0"+d:d
			        			
			        			var H = D.getHours();
			        			H=H<10?"0"+H:H
			        			
			        			var M = D.getMinutes();
			        			M=M<10?"0"+M:M
			        			
			        			var S = D.getSeconds();
			        			S=S<10?"0"+S:S;
			        			
			        			str_time=m+"-"+d+"&nbsp;"+H+":"+M+":"+S;
			        			
			        			
			        			
			        			
			        			
			        			if (sdpeopertime) {
                                    sdpeopertime = sdpeopertime.replace(/-/g,'/').substr(0,19).replace(/(T)/g,' ')
                                };
                                sdpeopertime = new Date(sdpeopertime);
                                var Month1 = 1+sdpeopertime.getMonth()
                                if(Month1<10)
                                    Month1 = "0"+Month1
                                var Day1 = sdpeopertime.getDate()
                                if(Day1<10)
                                    Day1 = "0"+Day1
                                var Hour1 = sdpeopertime.getHours()
                                if(Hour1<10)
                                    Hour1 = "0"+Hour1
                                var Minut1 = sdpeopertime.getMinutes()
                                if(Minut1<10)
                                    Minut1 = "0"+Minut1
                                    time = time.replace(/-/g,'/').substr(0,19).replace(/(T)/g,' ')
                                time = new Date(time);
                                var Month = 1+time.getMonth()
                                if(Month<10)
                                    Month = "0"+Month
                                var Day = time.getDate()
                                if(Day<10)
                                    Day = "0"+Day
                                var Hour = time.getHours()
                                if(Hour<10)
                                    Hour = "0"+Hour
                                var Minut = time.getMinutes()
                                if(Minut<10)
                                    Minut = "0"+Minut
                                var Secon = time.getSeconds()
                                if(Secon<10)
                                    Secon = "0"+Secon
                                time = Month+"-"+Day+" "+Hour+":"+Minut+":"+Secon;
                                var status_new = ""
                                var kindof = ""
                                if(cgtype == 1){
                                    kindof = "话费"
                                    contact = ''
                                }else if(cgtype == 2){
                                    kindof = "Q币"
                                    contact = ""+contact
                                }else if(cgtype == 3){
                                    kindof = "红包"
                                    contact = ''
                                }else if(cgtype == 4){
                                    kindof = "实物"
                                }else if(cgtype == 5){
                                    kindof = "现金"
                                }
                                
                                if(sdstate == 0 || sdstate == 1){
                                    status_new = Month+"-"+Day+" 12:00 前发货"
                                }
                                if(sdstate == 2){
                                    status_new = Month1+"-"+Day1+" "+Hour1+":"+Minut1+" 已发货"
                                }
                                if(sdstate == 3){
                                    status_new = "已撤销"
                                }
                                if(cgtype == 1 || cgtype == 2|| cgtype == 5){
                                    if(sdstate == 0 || sdstate == 1){
                                    	
                                    	var DDD = parseInt(Day)+1
                                        if(DDD<10)
                                           DDD = "0"+DDD
                                    	
                                        status_new = Month+"-"+DDD+" 12:00 前发货"
                                    }else if(sdstate == 2){
                                        status_new = Month1+"-"+Day1+" "+Hour1+":"+Minut1+" 已发货"
                                    }else if(sdstate == 3){
                                        status_new = "已撤销"
                                    }
                                }else if(cgtype == 3  ){
                                    if(sdstate == 0 || sdstate == 1){
                                        var MinutMinut = 00
                                        if((parseInt(Minut)+5) >= 59){
                                            MinutMinut =  59
                                        }else if((parseInt(Minut)+5) < 10){
                                            MinutMinut =  "0"+(parseInt(Minut)+5)
                                        }else{
                                            MinutMinut = parseInt(Minut)+5
                                        }
                                        status_new = Month+"-"+Day+" "+Hour+":"+MinutMinut+" 前发货"
                                    }else if(sdstate == 2){
                                        status_new = Month1+"-"+Day1+" "+Hour1+":"+Minut1+" 已发货"
                                    }else if(sdstate == 3){
                                        status_new = "已撤销"
                                    }
                                }
			        			
			        			
			        			
			        			
			        			
			        			
			        			
			        			
			        			if(tag==2){//Q币
			        				html += '<dl>'
		    	        			html += '<dt>'
		    	        			html += '<p><em>'+itemRemark+'</em>'+type[cgtype]+'</p>'
		    	        			html += '<p>奖券花费：'+consticket+'</p>'
		    	        			html += '<p>发货状态：'+status_new+'</p>'
		    	        			html += '<p>充值号码：'+contact+'</p>'
		    	        			html += '</dt>'
		    	        			html += '<dd>'+str_time+'</dd>'
		    	        			html += '</dl>'
			        			}else{//红包
			        				html += '<dl>'
		    	        			html += '<dt>'
		    	        			html += '<p><em>'+itemRemark+'</em>'+type[cgtype]+'</p>'
		    	        			html += '<p>奖券花费：'+consticket+'</p>'
		    	        			html += '<p>发货状态：'+status_new+'</p>'
		    	        			html += '</dt>'
		    	        			html += '<dd>'+str_time+'</dd>'
		    	        			html += '</dl>';
			        			}
			        		});
			        		$("#jlCont").html(html);
			        	}
	        			if(pageTotal==data.pageNo){
							$(".more").hide()
						}else{
							$(".more").show().css("display","block");
						}
	        			data.pageNo++;
	        		}else{
	        			$(".more").hide();
						return;
	        		}
	        	}
	        }
		})
	};
	
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})

var remove_header=function(){
	var arg = localStorage.getItem("from");
	if(arg){
		$(".tzHeader").hide();
	}else{
		$(".tzHeader").show();
	}
}
remove_header();


