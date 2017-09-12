<meta content="IE=EmulateIE8" http-equiv="X-UA-Compatible" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=”renderer” content=”webkit” />
<title><?=$this->settings['webName']?></title>
<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="/skin/css/wjstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/skin/js/jquery.SuperSlide.2.1.1.js"></script>
<script>var TIP=true;</script>
<script type="text/javascript" src="/skin/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/skin/js/Array.ext.js"></script>
<script type="text/javascript" src="/skin/js/onload.js"></script>
<script type="text/javascript" src="/skin/js/function.js"></script>
<script type="text/javascript" src="/skin/js/jquery.simplemodal.src.js"></script>

<link type="text/css" rel="stylesheet" href="/skin/js/jqueryui/jquery-ui-1.8.23.custom.css" />
<script type="text/javascript" src="/skin/js/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">window.onerror=function(){return true;}</script>

<link type="text/css" rel="stylesheet" href="/skin/jqueryui/jquery-ui-1.8.23.custom.css" />
<script type="text/javascript" src="/skin/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">window.onerror=function(){return true;}</script>
<style>#bg{background:#<?=$this->iff($_COOKIE['pagepg'],$_COOKIE['pagepg'],'d2e5f2 url(/skin/images/bg/bg1.jpg) no-repeat top center')?>;}</style>

<script type="text/javascript">

$(document).ready(function(){

////{{{系统提示 setInterval
	if(typeof(TIP)!='undefined' && TIP){
	setTimeout(function(){ //提款
		
		$.getJSON('/index.php/Tip/getTKTip', function(tip){
			if(tip){
				
				if(!tip.flag) return;
				playVoice('/skin/sound/backcash.wav', 'backcash-voice');
				$("<div>").append(tip.message).dialog({
						position:['right','bottom'],
						minHeight:40,
						title:'系统提示',
						buttons:''
					});
				
			}
		})
	}, 3000);
	
	setTimeout(function(){ //充值
		
		$.getJSON('/index.php/Tip/getCZTip', function(tip){
			if(tip){
				
				if(!tip.flag) return;
				playVoice('/skin/sound/cash.wav', 'cash-voice');
				$("<div>").append(tip.message).dialog({
						position:['right','bottom'],
						minHeight:40,
						title:'系统提示',
						buttons:''
					});
				
			}
		})
	}, 2000);
	//}}}
	
	}
	
});
</script>



