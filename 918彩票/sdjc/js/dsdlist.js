
var agentFrom = location.search.getParam("agentFrom");
var SDJC ={
		init:function(){
			
			this.dataList(0,oflag);
			this.bindEvent();
		},
		
		 cuter2 : function( str ){//abcd  
	        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
		 },
		
		dataList:function(idx,flag){//无back向上，有back向下
			
			if(!(SDJC.more)){
				$("#swheight section:eq("+idx+") ul").html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>')
			}
			$.ajax({
				url:'/trade/god_proj_list.go',
				type:'POST',
				data:data,
				dataType:'xml',
				success: function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					var rows=R.find("rows");
					var tr = rows.attr("tr");//总条数
					var tp = rows.attr("tp");//总页数
					var ps = rows.attr("ps");//条数
					var pn = rows.attr("pn");//当前页
					
					var row = rows.find("row");
					var html='';
					
					if(data["pn"] >1){
						html=$("#swheight section:eq("+idx+") ul").html();
					}
					if(row.length){
						row.each(function(){
							var projid = $(this).attr("projid");
							var nickid = $(this).attr("nickid");
							var userphoto = $(this).attr("userphoto");
							var tmoney = $(this).attr("tmoney");
							var mintmoney = $(this).attr("mintmoney");
							var projallnum = $(this).attr("projallnum");//投注总单数
							var projrednum = $(this).attr("projrednum");//命中数
							var wrate = $(this).attr("wrate");
							var matchnum = $(this).attr("matchnum");
							var guoguan = $(this).attr("guoguan");
							
							if(guoguan.indexOf("*")!=-1){
								guoguan = guoguan.replace(/\*/g, "串").replace(/1串1/g, "单关").replace(/\,/," ");
							}
							
							var follownums = $(this).attr("follownums");
							var endtime = $(this).attr("endtime");
							
							
							 html+='<li class="clearfix" projid="'+projid+'">'
							 html+='<div class="jcds_dsblit clearfix">'
							 html+='<p class="jcds_dsbp1 clearfix"><img src="'+(userphoto?userphoto:"img/zwtp.png")+'"/><span>'+nickid+'</span></p>'
							
							 
							 if(!projallnum && !projrednum){
								 //shareHTML+='<p class="jcds_dsbp2">'+allnum+'中'+rednum+'</p>'
								 html+="";
							 }else{
								 html+='<p class="jcds_dsbp2">'+projallnum+'中'+projrednum+'</p>'
							 }
							 
							 html+='<p class="jcds_dsbp3">'+endtime+'截止</p>'
							 html+='</div>'
							 html+='<div class="jcds_dsblic clearfix">'
							 html+='<p class="jcds_dsbp4">'+SDJC.cuter2(tmoney)+'元</p>'
							 html+='<p class="jcds_dsbp5 clearfix"><em>起投</em><span>'+SDJC.cuter2(mintmoney)+'元</span><i>打赏 '+wrate+'</i></p>'
	  
							 html+='</div>'
							 html+='<div class="jcds_dsblib clearfix">'
							 html+='<p class="jcds_dsbp6">发单人购买</p>'
							 html+='<p class="jcds_dsbp7">'+matchnum+'场 '+guoguan+'</p>'
							 if(follownums!="0"){
								 html+='<p class="jcds_dsbp8">'+follownums+'人跟买</p>'
							 }
							 html+='</div>'
							 html+='</li>'
						})
						
						$("#swheight section:eq("+idx+") ul").html(html)
						if(data["pn"] < tp){
							data["pn"]++;
							$(".jcdsdsb_more").show();
						}else{
							$(".jcdsdsb_more").hide();
						}
					}else{
						$("#swheight section:eq("+idx+") ul").html('<div class="empty_user"><p>暂无内容</p></div>')
						$(".jcdsdsb_more").hide();
					}
					var h1 = 0;
					h1 = $("#swheight section:eq("+idx+")").height();
					$('#swheight').css({'height':h1});
					SDJC.more = ''
					$(".jcdsdsb_more").removeAttr('add');
				},
			})
		},
		bindEvent:function(){
			
			$(".jcdsdsb_more").bind("click",function(){
				SDJC.more = 1;//点击时SDJC.more不为空，判断点击加载更多或导航栏
				var add = $(this).attr('add');
				if(!add){
					$(this).attr('add','add');
					var index = $("#tab h3.on").index();
					 SDJC.dataList(index,data["oflag"]);
				}
			});
			
			$("#swheight section ul").delegate("li","click",function(){
				var projid = $(this).attr("projid");
				//var godUid = $(this).attr("godUid")
				if(agentFrom){
					window.location.href="/sdjc/buy.html?hid="+projid+"&agentFrom="+agentFrom;
				}else{
					window.location.href="/sdjc/buy.html?hid="+projid;
				}
				
			});
		}
}
var oflag=1;
var pn=1;
var ps=10;

var data={
		"oflag":oflag,
		"pn":pn,
		"ps":ps
}

$(function(){
	
	SDJC.init();
	var tabsSwiper = new Swiper('.swiper-container',{
		speed:300,
		autoHeight:true,
	    onSlideChangeStart: function(){
	      $("#tab h3").removeClass('on')
	      $("#tab h3").eq(tabsSwiper.activeIndex).addClass('on')  
	    }
	 })
	
	$("#tab h3").on('touchend mousedown',function(e){
		var that = $(this);
	    e.preventDefault()
	    $(".jcdsdsb_more").hide();
	    var index =$(this).index();
	    $("#tab h3").removeClass('on');
	    $(this).addClass('on')
	   
	    //var oflag=index+1;
	    data["pn"]=1;
	    if(index==0){
	    	if(data["oflag"]==1){
	    		data["oflag"]=2
	    		that.find("span").find("em").removeClass("back")
	    	}else{
	    		data["oflag"]=1;
	    		that.find("span").find("em").addClass("back")
	    	}
	    }else if(index==1){
	    	if(data["oflag"]==3){
	    		data["oflag"]=4
	    		that.find("span").find("em").removeClass("back")
	    	}else{
	    		data["oflag"]=3
	    		that.find("span").find("em").addClass("back")
	    	}
	    }else if(index==2){
	    	that.find("span").find("em").removeClass("back")
	    	that.find("span").find("em").removeClass("dsdpx")
	    	data["oflag"]=5
	    }else{
	    	data["oflag"]=1
	    	that.find("span").find("em").addClass("back")
	    }
	    SDJC.dataList(index,data["oflag"]);
	    
	    tabsSwiper.slideTo(index)
	    
	   
	})

var appRet = function(scheme,pageid){
	var config = {
			 /*scheme:必须*/
            scheme_IOS: 'caiyi9188Lotterynomal',
            scheme_Adr: 'lotterystartapp',
            download_url: 'http://t.9188.com  /',
            timeout: 1000
        };
	var now = Date.now();
    var ifr = $('.head_btn');
    var typefrom = location.search.getParam("type_from");
//    alert(typefrom +' '+ browser.versions.ios + " "+(location.search.getParam("page")));
//    if(browser.versions.android && typefrom == 'android'){
//    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
//    }else if(browser.versions.ios && typefrom == 'ios'){
//    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
//    }else if(typefrom == 'android' && browser.versions.ios){
//    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
//    }else if(typefrom == 'ios' && browser.versions.android){
//    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
//    }else 
    if(browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid)
    }else if(browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid)
    }
    var t = setTimeout(function() {
        var endTime = Date.now();
        if (Date.now() - now < config.timeout+800){
        		window.location.href= config.download_url; 
        }
    }, config.timeout);
}
	$('.head_btn').bind('click' , function(){
		try{
			var page = location.search.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	appRet(page,31);
            }
		}catch(e){}
	})
})