var curTime_ = new Date().getTime();
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
			//loadCode();
			//XX.bindEvent();
			var comeFrom = location.search.getParam("comeFrom");
			if(comeFrom){
				localStorage.setItem("comeFrom",comeFrom);
			}
			var callbacks = $.Callbacks();
			callbacks.add(loadCode);
			callbacks.add(XX.bindEvent);
			callbacks.fire();
		},
		bindEvent:function(){
			$(".ball cite").bind("click",function(){
				loadCode();
			});
			$("#obtain").bind("click",function(){
				var comeFrom = location.search.getParam("comeFrom");
				if(comeFrom){
					localStorage.setItem("comeFrom",comeFrom);
				}
				var redValue = $("#RedBallValue").val();
				var blueValue = $("#BlueBallValue").val();
				if(redValue && blueValue){
					var bankCode = redValue+"|"+blueValue+":1:1";
					localStorage.setItem("bankCode",bankCode);
				}
				window.location.href="/activity/wnl/wnl2.html";
			})
			$("#client").bind('click',function(){
				
				
				
				
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
		}
};

function red_scale(redNum_,selectlength_r){
	var redValue="";
	
	for(var i=0;i<selectlength_r;i++){
		redValue += (redNum_[i] < 10 ? "0" + redNum_[i].toString() : redNum_[i])+",";
	}
	if (redValue != ""){
		redValue = redValue.substring(0,redValue.length-1)
		$("#RedBallValue").val(redValue);
    }
	
	var maxlength_b = 16;
    var blueNum = Random(maxlength_b);
    $("#BlueBallValue").attr("value", "");
    var blueValue = ""; 
    blueValue += (blueNum[0] < 10 ? "0" + blueNum[0].toString() : blueNum[0]);
    $("#BlueBallValue").attr("value", blueValue);
}

//random
function machineSelect() {
    var selectlength_r = '6';//双色球红球必选6个
    var maxlength_r = '33';//双色球红球有33个
    var redNum = Random(maxlength_r);//打乱顺序之后的33个红球
	
    $("#RedBallValue").attr("value", "");
    var redNum_ = [];
    for (var i = 0; i < selectlength_r; i++) {
        redNum_[i] = redNum[i+i*2];
    }
    redNum_.sort(function(a,b){return a>b?1:-1;});
    red_scale(redNum_,parseInt(selectlength_r));
}

function loadCode(){
	machineSelect();
	var $b = $(".ball span:lt(6)");
	var redV = $("#RedBallValue").val();
	var redArr = redV.split(",");
	var blueV = $("#BlueBallValue").val();
	$b.each(function(i,o){
		$(this).text(redArr[i]);
	});
	$(".ball span:last").text(blueV);
	$(".ball span").addClass("rotate");
	var n = 0;
	stopRotate(n);
	
}
function stopRotate(n){
	
	if(n<7){
		setTimeout(function (){
			$(".ball span").eq(n).removeClass('rotate');
			n++;
			stopRotate(n);
		},100);
	}
}
//生成随机数
function Random(count) {
    var original = new Array; //原始数组 
    //给原始数组original赋值 
	for (var i = 0; i < count; i++) {
        original[i] = i + 1;
    }
    original.sort(function() { return 0.5 - Math.random(); });
    var arrayList = new Array();
    for (var i = 0; i < count; i++) {
        arrayList[i] = original[i];
    }
    return arrayList;
}

