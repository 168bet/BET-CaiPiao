var start_ev = ("ontouchstart" in window) ? "touchstart" : "mousedown";
var end_ev = ("ontouchend" in window) ? "touchend" : "mouseup";
var move_ev = ("ontouchend" in window) ? "touchmove" : "mousemove";


String.prototype.getParam = function(n) {
	var r = new RegExp("[\?\&]" + n + "=([^&?]*)(\\s||$)", "gi");
	var r1 = new RegExp(n + "=", "gi");
	var m = this.match(r);
	if (m == null) {
		return "";
	} else {
		return typeof (m[0].split(r1)[1]) == 'undefined' ? ''
				: decodeURIComponent(m[0].split(r1)[1]);
	}
};

function sendMessage(){
	WeixinJSBridge.call('hideOptionMenu');    
}
//这个属性表示页面是否应该初始化，
//$.mobile.autoInitializePage = false;

var zhezhao = '<div class="show" id="invite_friend_c1"><img width="100%" src="/word_weixin/img/invite.png"></div>'+
			  '<div class="zhezhao" id="invite_friend_c2"></div>';
var transparent = '<div class="tx_c" id="invite_friend_t"></div>';
var WW = {
	zhezhao:function(){
		if($('#invite_friend_c1').html() != undefined){
			$('#invite_friend_c1').show();
			$('#invite_friend_c2').show();
		}else{
			$('body').append(zhezhao);
		}
		
		$('#invite_friend_c1,#invite_friend_c2').bind('click',function(){
			$('#invite_friend_c1').hide();
			$('#invite_friend_c2').hide();
		});
	},
	tx:function(msg){
		if($('#invite_friend_t').html() != undefined){
			$('#invite_friend_t').show();
		}else{
			$('body').append(transparent);
		}
		
		$('#tx_c').html('&nbsp;&nbsp;'+msg+'&nbsp;&nbsp;');
		$('#tx_c').show();
		
		$('#tx_c').css({left:'50%',marginLeft:'-8rem'});
		setTimeout(function(){
		  	$('#tx_c').hide();
	    },5000);
		$('#tx_c ,#invite_friend_t').click(function(){
			$('#tx_c').hide();
			$('#invite_friend_t').hide();
		});
	}
};

$.fn.Touch = function(a) {
    var b = move_ev;
    this.each(function() {
        var c = $(this).eq(0);
        var d = false;
        var e = 0;
        c.on(b, function() {
            d = true;
            clearTimeout(e);
            e = setTimeout(function() {
                d = false
            }, 250)
        });
        if (a.children) {
            c.on(end_ev, a.children, function(f) {
                if (d && end_ev == "touchend") {
                    d = false;
                    f.stopPropagation();
                    return false
                }
                a.fun.call(this, this)
            })
        } else {
            c.on(end_ev, function(f) {
                if (d && end_ev == "touchend") {
                    d = false;
                    f.stopPropagation();
                    return 0
                }
                a.apply(this, [this, f])
            })
        }
    })
};