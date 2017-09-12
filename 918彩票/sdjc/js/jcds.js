

var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p').html(msg);
			tag && $('#dAlert a.bfb').html(tag) || $('#dAlert a.bfb').html('知道了');
			$("#dAlert").show();
			$(".zhezhao").show();
			$('#dAlert a.bfb').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$(".zhezhao").hide();
			});
		}
}

var agentFrom = location.search.getParam("agentFrom")||""
var SD = (function(){
	var o = {
			cuter2 : function( str ){//abcd  
		        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
			 },
			gain: function(){
				var bannerHTML="";
				var godHTML="";
				var shareHTML="";
				$.ajax({
					url:'/trade/godShareItem.go',//70DG2016102662723016  70DG2016102562722892  70DG201s6102762723104
					type:'POST',
					success: function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						
						var bannerlist = R.find("bannerlist");//banner节点
						var banner = bannerlist.find("banner");
						
						var godlist = R.find("godlist");
						var goddata = godlist.find("goddata");
						
						
						var sharelist = R.find("sharelist");
						var shareItem = sharelist.find("shareItem");
						
						var len = banner.length;
						if(len){
							var t = true;
							
							if(len==1){
								t=false
							}
							
							banner.each(function(){
								var forwardUrl = $(this).attr("forwardUrl");
								var dsc = $(this).attr("desc");
								var imgurlad = $(this).attr("imgurlad");
								var imgurliOS5 = $(this).attr("imgurliOS5");
								var imgurliOS6 = $(this).attr("imgurliOS6");
								var imguriOS6P = $(this).attr("imguriOS6P");
								var imgurlh5 = $(this).attr("imgurlh5")||"";
								var h5url = $(this).attr("h5url")||"";

								bannerHTML+='<a href="'+h5url +'"><img src="'+(imgurlh5?imgurlh5:imgurlad)+'" class="swiper-slide"/></a>'

							})
							
							$("#swapBanner").html(bannerHTML);
							
							var tabswiper = new Swiper('#tab', {
								pagination: '.swiper-pagination',
								loop : t,
								autoplay : 3000,
								speed:300,
							});
						}else{
							$("#swapBanner").html('<div class="empty_user"><p>暂无内容</p></div>');
						}
						if(goddata.length){
							goddata.each(function(){
								var realUid = $(this).attr("realUid");
								var godUid = $(this).attr("godUid");//大神uid
								var rank = $(this).attr("rank");//大神排名
								var remainNum = $(this).attr("remainNum");//大神进行中的单子
								var imgUrl = $(this).attr("imgUrl");//大神头像
								
								godHTML+='<li class="swiper-slide" realUid="'+realUid+'" godUid="'+godUid+'">'
								godHTML+='<div class="jcdsdsb_headimg"><img src="'+(imgUrl?imgUrl:"img/zwtp.png")+'"/>'+((remainNum&&remainNum!=0)?('<em>'+remainNum+'</em>'):"")+'</div>'
								godHTML+='<div class="jcdsdsb_name">'+(godUid.length>7?(godUid.substring(0,4)+'...'):godUid)+'</div>'
								godHTML+='<div class="jcdsdsb_pm">'
									if(rank==1){
										godHTML+='<img src="img/medal.png"/>'
									}else if(rank==2){
										godHTML+='<img src="img/medal1.png"/>'
									}else if(rank==3){
										godHTML+='<img src="img/medal2.png"/>'
									}else{
										godHTML+=rank;
									}
								
								godHTML+='</div>'
								godHTML+='</li>'
								
							})
							$("#winDS").html(godHTML);
						}else{
							$("#winDS").html('<div class="empty_user"><p>暂无内容</p></div>');
							$("#jcdsdsb_more2").hide();
						}
						if(shareItem.length){
							shareItem.each(function(){
								var realUid = $(this).attr("realUid")
								var projid = $(this).attr("projid")
								var endtime = $(this).attr("endtime")
								var tmoney = $(this).attr("tmoney")
								var averageMoney = $(this).attr("averageMoney")
								var wrate = $(this).attr("wrate")
								var matchNum = $(this).attr("matchNum")
								var guoguan = $(this).attr("guoguan")
								var usernum = $(this).attr("usernum")
								var userphoto = $(this).attr("userphoto")
								var nickid = $(this).attr("nickid")
								var rednum = $(this).attr("rednum")
								var allnum = $(this).attr("allnum")
								
								
								if(guoguan.indexOf("*")!=-1){
									guoguan = guoguan.replace(/\*/g, "串").replace(/1串1/g, "单关").replace(/\,/g," ");
									if(guoguan.indexOf(",")!=-1){
										console.log(guoguan)
										guoguan = guoguan.replaceAll(","," ")
									}
								}else{
									guoguan = guoguan.replace(/\*/g, "串").replace(/1串1/g, "单关").replace(/\,/g," ");
									
								}
								
								 shareHTML+='<li class="clearfix" projid="'+projid+'">'
								 shareHTML+='<div class="jcds_dsblit clearfix">'
								 shareHTML+='<p class="jcds_dsbp1 clearfix"><img src="'+(userphoto?userphoto:"img/zwtp.png")+'"/><span>'+nickid+'</span></p>'
								 if(allnum && rednum){
									 shareHTML+='<p class="jcds_dsbp2">'+allnum+'中'+rednum+'</p>'
								 }
								 shareHTML+='<p class="jcds_dsbp3">'+endtime+'截止</p>'
								 shareHTML+=' </div>'
								 shareHTML+='<div class="jcds_dsblic clearfix">'
								 shareHTML+='<p class="jcds_dsbp4">'+o.cuter2(tmoney)+'元</p>'
								 shareHTML+='<p class="jcds_dsbp5 clearfix"><em>起投</em><span>'+o.cuter2(averageMoney)+'元</span><i>打赏 '+wrate+'</i></p>'
						          
								 shareHTML+='</div>'
								 shareHTML+='<div class="jcds_dsblib clearfix">'
								 shareHTML+='<p class="jcds_dsbp6">发单人购买</p>'
								 shareHTML+='<p class="jcds_dsbp7">'+matchNum+'场 '+guoguan+'</p>'
								 if(usernum != '0' && usernum){
									 shareHTML+='<p class="jcds_dsbp8">'+usernum+'人跟买</p>'
								 }
								 shareHTML+='</div>'
								 shareHTML+='</li>'
								
							})
							$("#DSDList").html(shareHTML);
						}else{
							$("#DSDList").html('<div class="empty_user"><p>暂无内容</p></div>');
							$("#jcdsdsb_more2").hide()
						}

						var swiper = new Swiper('.swiper-container', {
						    slidesPerView: 3,
						    paginationClickable: true,
						    spaceBetween: 30,
						    freeMode: true
						});
					},
					error:function(){
						alert("网络异常")
					}
				})
			},
			checkLogin:function(){
				$.ajax({
					url : '/user/query.go?flag=6',
					type : "GET",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						remove_alert();
						if (code == "0") {
							var r= R.find("row");
							var nickid = r.attr("nickid");
							localStorage.getItem('username',nickid);
							location.href="/sdjc/details.html?loc="+encodeURIComponent(nickid)+'&ent=me'; 
						}else{
							if(agentFrom){
								location.href="login.html?agentFrom="+agentFrom;
							}else{
								location.href="login.html";
							}
						}
					}
				});
			},
			bindEvent:function(){
				$("#jcdsdsb_more1").bind("click",function(){
					if(agentFrom){
						//window.location.href="/sdjc/details.html?loc="+realUid+"&agentFrom="+agentFrom;
						window.location.href="/sdjc/dsblist.html?agentFrom="+agentFrom;
					}else{
						window.location.href="/sdjc/dsblist.html";
					}
				});
				
				$("#jcdsdsb_more2").bind("click",function(){
					
					if(agentFrom){
						//window.location.href="/sdjc/details.html?loc="+realUid+"&agentFrom="+agentFrom;
						window.location.href="/sdjc/dsdlist.html?agentFrom"+agentFrom;;
					}else{
						window.location.href="/sdjc/dsdlist.html";
					}
					
				});
				
				/*$("#winDS").delegate("li","click",function(){
					var realUid = $(this).attr("realUid");
					var godUid = $(this).attr("godUid");
					SD.checkUser(realUid);
				});*/
				
				$("#DSDList").delegate("li","click",function(){
					var projid = $(this).attr("projid");
					//var godUid = $(this).attr("godUid")
					if(agentFrom){
						window.location.href="/sdjc/buy.html?hid="+projid+"&agentFrom="+agentFrom;
					}else{
						window.location.href="/sdjc/buy.html?hid="+projid;
					}
				});
				$('#user_details').bind('click', function(){
					o.checkLogin()
				})
			},
			
			init: function(){
				this.gain();
				this.bindEvent();
			}
	}
	return o
})()

$(function(){
	SD.init();
	var browser={
		    versions:function(){
		        var u = navigator.userAgent, app = navigator.appVersion;
		        return {
		        	trident: u.indexOf('Trident') > -1, //IE内核
		            presto: u.indexOf('Presto') > -1, //opera内核
		            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
		            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
		            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
		            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
		            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1 || u.indexOf('Linux') > -1, //android终端
		        };
		    }(),
	}
	var showDownload=function(){
	    if(!$("#downloadDiv").length){	
	    	var ua = navigator.userAgent;
	        var _d = document;
	        var _b = _d.body;
	        
	        var downloadDiv = _d.createElement("div");
	        downloadDiv.setAttribute("id","downloadDiv");
	        _b.appendChild(downloadDiv);
	        
	        $(downloadDiv).addClass("download_android");
	        
	       if(ua.indexOf('Android') > -1 || ua.indexOf('Linux') > -1){ //android
	    	   $(downloadDiv).addClass("download_android");
	        } else if(ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1 || ua.indexOf('iPod') > -1){ // ios
	        	 $(downloadDiv).addClass("download_iphone");
	        }
	        
	    }
	    $("#downloadDiv").fadeIn(function(){
	        $(this).bind("click touchstart",function(){
	            $(this).fadeOut();
	        });
	    });
	}
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
//	    alert(typefrom +' '+ browser.versions.ios + " "+(location.search.getParam("page")));
//	    if(browser.versions.android && typefrom == 'android'){
//	    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else if(browser.versions.ios && typefrom == 'ios'){
//	    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else if(typefrom == 'android' && browser.versions.ios){
//	    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid)
//	    }else if(typefrom == 'ios' && browser.versions.android){
//	    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else 
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
	
	if(!(location.search.getParam("source"))){
		if(document.domain == "zccp.eastday.com" || document.domain == "ttcp.eastday.com"){//判断头条
			$('#heah_h').removeClass('height_h');
			$('.head_load').hide();
		}else{
			$('#heah_h').addClass('height_h');
			$('.head_load').show();
		}
	}
	$('.head_close').bind('click' ,function(){
		$('#heah_h').removeClass('height_h');
		$('.head_load').hide();
		$('.jcds_head').css({'top':0})
	})
	$('.head_btn').bind('click' , function(){
		try{
			var page = location.search.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	appRet(page,30);
            }
		}catch(e){}
	})
})



