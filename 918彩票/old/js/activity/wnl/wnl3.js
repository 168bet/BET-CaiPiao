$(function(){
	XX.init_info();
});

String.prototype.getParam = function(n){
	var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
	var r1=new RegExp(n+"=","gi");
	var m=this.match(r);
	if(m==null){
		return "";
	}else{
		return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
	}
};

var comeFrom = location.search.getParam('comeFrom');
comeFrom && localStorage.setItem('comeFrom',comeFrom);

var XX={
	init_info:function(){
		var comeFrom = location.search.getParam("comeFrom");
		if(comeFrom){
			localStorage.setItem("comeFrom",comeFrom);
		}
		var callbacks = $.Callbacks();
		callbacks.add(XX.bindEvent);
		callbacks.add(XX.loadCont);
		callbacks.fire();
	},
	bindEvent:function(){
		$("#client").on('click',function(){
			
			var ua = navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == "micromessenger") {
                $(".popup,.zhezhao2").show()
            }else{
          	
			var agent = localStorage.getItem('comeFrom');
			
			$.ajax({
				url:'/data/app/download.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var config=$(xml).find("config");
					var row=config.find("row");
					row.each(function(){
						if($(this).attr("downloadid")==agent)
						{	
							//alert($(this).attr("adurl"));
					    	if (/android/i.test(navigator.userAgent))
					    	{///android/i.test(navigator.userAgent)
								window.location.href=$(this).attr("adurl");
							}
					    	else if(/ipad|iphone|mac/i.test(navigator.userAgent))
							{
								window.location.href=$(this).attr("iosurl");
							}								
						}
					});
				}
			});

            }
		});
	},
	loadCont:function(){
		var bankCode = localStorage.getItem("bankCode");
		var t = bankCode.indexOf(":");
		bankCode = bankCode.substring(0,t);
		var bankCodeArr = bankCode.split("|");
		var redCodeArr = bankCodeArr[0].split(",");
		var blueCode = bankCodeArr[1];
		
		var $b = $(".ball span:lt(6)");
		$b.each(function(i,o){
			$(this).text(redCodeArr[i]);
		});
		$(".ball span:last").text(blueCode);
	}
};
