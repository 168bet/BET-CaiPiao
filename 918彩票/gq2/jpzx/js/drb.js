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


	
	var query_list_Dist=function(){
		var html = $("#jlCont").html();
		$.ajax({
			 url: "/zqjc/data/app/ticketrank/ticketRank.xml",
			type: 'GET',
			dataType: 'xml',
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var code = R.attr("code");
	        	var desc = R.attr("desc");
	        	
	        	var rows = R.find("rows");

	        	var row = rows.find("row");
	        	var num=0
	        	var html=""
				if(code==200){//投注成功
					if(row.length){
						var rank=0;
						row.each(function(i){
							if(num<30){//控制显示条数
								num++;
								var c = i%2==0?"graybg":"";
								var cnickid = $(this).attr("cnickid").substr(0,6);
								var dhcs = $(this).attr("dhcs");
								var totalTicket = $(this).attr("totalTicket");
								var zhf = $(this).attr("zhf");
								rank++;
								
								html+='<ul class="'+c+'">';
								if(rank==1 || rank==2 || rank==3){
									html+='<li><em>'+rank+'</em></li>';
								}else{
									html+='<li>'+rank+'</li>';
								}
								html+='<li>'+cnickid+'</li>';
								html+='<li>'+totalTicket+'</li>';
								html+='<li style="color:red">'+zhf+'&nbsp;元</li>';
								html+='</ul>';	
							}

						});
						$("#z_list").html(html);
						

					}else{
						$("#z_list").html(noGame);
					}
				}else{
					alert(desc);
				}
	        	
	        }
		})
	};
	




var remove_header=function(){
	var arg = localStorage.getItem("from");
	if(arg){
		$(".tzHeader").hide();
	}else{
		$(".tzHeader").show();
	}
}
remove_header();
query_list_Dist();


