<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>简体接水</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css"> 
<script language="javascript"> 
<!-- 
var a="";
function createXMLHttpRequest(http) {
if(window.ActiveXObject) {
    eval(http+" = new ActiveXObject(\"Microsoft.XMLHTTP\")");
  }
  else if(window.XMLHttpRequest) {
    eval(http+" = new XMLHttpRequest()");
  }
}
function news(){
createXMLHttpRequest("cHttp");
    cHttp.onreadystatechange = cChange;
    cHttp.open("post", "test_cn.php", true);
    cHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	cHttp.setRequestHeader("Charset","GB2312");
    cHttp.send(null);
	//cDoc = cHttp.responseText;
	function cChange(){
  if(cHttp.readyState == 4) {
      if(cHttp.status == 200) {
          var cDoc = cHttp.responseText;
          //setTimes(timeDoc);
		  if (cDoc==1){
		  news_html.innerHTML="简体断水";
		  if (a!=cDoc){
		  sound.fileName = "back.mid";
		  }
		  a=cDoc;
		  }else{
		  sound.stop();
		  a="";
		  news_html.innerHTML=cDoc;
		  }
		  //alert(cDoc);
      }
      }
}
setTimeout("news()",30000);
}
</script>
<body onLoad="news()"> 
<div id=news_html></div>
</body>
</html>
<object classid=clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95 codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,1,5,217"
id="sound" type=application/x-oleobject width=0 height=0 standby="Loading Microsoft Windows Media Player components..." VIEWASTEXT align=MIDDLE>
<param name=AudioStream value=-1>
<param name=AutoSize value=0>
<param name=AutoStart value=1>
<param name=AnimationAtStart value=0>
<param name=AllowScan value=-1>
<param name=AllowChangeDisplaySize value=0>
<param name=AutoRewind value=0>
<param name=Balance value=0>
<param name=BaseURL value="">
<param name=BufferingTime value=5>
<param name=CaptioningID value="">
<param name=ClickToPlay value=0>
<param name=CursorType value=32512>
<param name=CurrentPosition value=-1>
<param name=CurrentMarker value=0>
<param name=DefaultFrame value=1>
<param name=DisplayBackColor value=0>
<param name=DisplayForeColor value=16777215>
<param name=DisplayMode value=0>
<param name=DisplaySize value=0>
<param name=Enabled value=-1>
<param name=EnableContextMenu value=-1>
<param name=EnablePositionControls value=0>
<param name=EnableFullScreenControls value=0>
<param name=EnableTracker value=1>
<param name=Filename value="">
<param name=InvokeURLs value=-1>
<param name=Language value=-1>
<param name=Mute value=0>
<param name=PlayCount value=0>
<param name=PreviewMode value=0>
<param name=Rate value=1>
<param name=SAMILang value="">
<param name=SAMIStyle value="">
<param name=SAMIFileName value="">
<param name=SelectionStart value=0>
<param name=SelectionEnd value=true>
<param name=SendOpenStateChangeEvents value=-1>
<param name=SendWarningEvents value=-1>
<param name=SendErrorEvents value=-1>
<param name=SendKeyboardEvents value=0>
<param name=SendMouseClickEvents value=0>
<param name=SendMouseMoveEvents value=0>
<param name=SendPlayStateChangeEvents value=-1>
<param name=ShowCaptioning value=0>
<param name=ShowControls value=0>
<param name=ShowAudioControls value=0>
<param name=ShowDisplay value=0>
<param name=ShowGotoBar value=0>
<param name=ShowPositionControls value=0>
<param name=ShowStatusBar value=0>
<param name=ShowTracker value=0>
<param name=TransparentAtStart value=0>
<param name=VideoBorderWidth value=0>
<param name=VideoBorderColor value=0>
<param name=VideoBorder3D value=0>
<param name=Volume value=-1070>
<param name=WindowlessVideo value=1>
</object>