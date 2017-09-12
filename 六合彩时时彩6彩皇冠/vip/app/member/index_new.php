<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
$str   = time();
$uid   = $_REQUEST['uid'];
$langx = $_REQUEST['langx'];
if ($uid==''){
	$uid=substr(md5($str),0,8);
}
if ($langx==''){
	$langx="zh-tw";
}
switch($langx){
case 'zh-tw':
	$a1="<img src=/images/member/zh-tw/index_tw.gif>";
	$a2="<a href=".BROWSER_IP."/app/member/translate.php?set=zh-cn&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image2','','/images/member/zh-cn/index_cn2.gif',1)><img name=Image2 border=0 src=/images/member/zh-cn/index_cn.gif></a>";
	$a3="<a href=".BROWSER_IP."/app/member/translate.php?set=en-us&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image3','','/images/member/en-us/index_us2.gif',1)><img name=Image3 border=0 src=/images/member/en-us/index_us.gif></a>";
	$a4="<a href=".BROWSER_IP."/app/member/translate.php?set=th-tis&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image4','','/images/member/th-tis/index_tis2.gif',1)><img name=Image4 border=0 src=/images/member/th-tis/index_tis.gif></a>";
	$size='250';
	break;
case 'zh-cn':
	$a1="<a href=".BROWSER_IP."/app/member/translate.php?set=zh-tw&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image1','','/images/member/zh-tw/index_tw2.gif',1)><img name=Image1 border=0 src=/images/member/zh-tw/index_tw.gif></a></td>";
	$a2="<img src=/images/member/zh-cn/index_cn.gif>";
	$a3="<a href=".BROWSER_IP."/app/member/translate.php?set=en-us&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image3','','/images/member/en-us/index_us2.gif',1)><img name=Image3 border=0 src=/images/member/en-us/index_us.gif></a>";
	$a4="<a href=".BROWSER_IP."/app/member/translate.php?set=th-tis&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image4','','/images/member/th-tis/index_tis2.gif',1)><img name=Image4 border=0 src=/images/member/th-tis/index_tis.gif></a>";
	$size='250';
	break;
case 'en-us':
	$a1="<a href=".BROWSER_IP."/app/member/translate.php?set=zh-tw&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image1','','/images/member/zh-tw/index_tw2.gif',1)><img name=Image1 border=0 src=/images/member/zh-tw/index_tw.gif></a>";
	$a2="<a href=".BROWSER_IP."/app/member/translate.php?set=zh-cn&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image2','','/images/member/zh-cn/index_cn2.gif',1)><img name=Image2 border=0 src=/images/member/zh-cn/index_cn.gif></a>";
	$a3="<img src=/images/member/en-us/index_us.gif>";
	$a4="<a href=".BROWSER_IP."/app/member/translate.php?set=th-tis&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image3','','/images/member/th-tis/index_tis2.gif',1)><img name=Image3 border=0 src=/images/member/th-tis/index_tis.gif></a>";
	$size='280';
	break;
case 'th-tis':
	$a1="<a href=".BROWSER_IP."/app/member/translate.php?set=zh-tw&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image1','','/images/member/zh-tw/index_tw2.gif',1)><img name=Image1 border=0 src=/images/member/zh-tw/index_tw.gif></a>";
	$a2="<a href=".BROWSER_IP."/app/member/translate.php?set=zh-cn&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image2','','/images/member/zh-cn/index_cn2.gif',1)><img name=Image2 border=0 src=/images/member/zh-cn/index_cn.gif></a>";
	$a3="<a href=".BROWSER_IP."/app/member/translate.php?set=en-us&url=".BROWSER_IP."/app/member/index.php&uid=$uid onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Image3','','/images/member/en-us/index_us2.gif',1)><img name=Image3 border=0 src=/images/member/en-us/index_us.gif></a>"; 
	$a4="<img src=/images/member/th-tis/index_tis.gif>";
	$size='280';
	break;
}

require ("./include/traditional.$langx.inc.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../../../style/member/index_new3.css" rel="stylesheet" type="text/css">
<script>
if(self == top) location='';
top.game_alert='';
top.today_gmt = '2010-09-14';
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

var strChk_Number="";
function show(){
	//document.all.show_flash.style.position='absolute';
	//document.all.show_flash.style.visibility='visible';
	//window.setTimeout("close_flash()", 9000);
	//document.all.username.focus();
	//set_img();
}
function close_flash(){
	document.all.show_flash.style.visibility='hidden';
}
function chk_acc(){
	document.all.JE.value = navigator.javaEnabled();
	if(document.all.username.value==""){
		hr_info.innerHTML=top.account;
		document.all.username.focus();
		return false;
	}
	if(document.all.passwd.value==""){
		hr_info.innerHTML=top.password;
		document.all.passwd.focus();
		return false;
	}
	//document.all.mac.value=top.aps.mac;
	//document.all.ver.value=top.aps.ver;
	return true;
}
/*
function set_img(){
	strChk_Number = (""+Math.random()).substr(2,4);
	intImg.innerHTML=strChk_Number;
	intDa= (1*strChk_Number) % 3 + 1;
	eval("document.getElementById('img_pic').background ='/images/member/chk_img0"+intDa+".gif'");
}
*/
//--></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 "><script>
top.str_input_pwd = "密碼請務必輸入!!";
top.str_input_repwd = "確認密碼請務必輸入!!";
top.str_err_pwd = "密碼確認錯誤,請重新輸入!!";
top.str_pwd_limit = "您的密碼必須至少6個字元長，最多12個字元長，並只能是數字，英文字母等符號，其他的符號都不能使用!!";
top.str_pwd_limit2 = "您的密碼需使用字母加上數字!!";
top.str_pwd_NoChg = "您的密碼未做任何變更!!";
top.str_input_longin_id = "登錄帳號請務必輸入!!";
top.str_longin_limit1 = "登錄帳號最少必須有2個英文大小寫字母和數字(0~9)組合輸入限制(6~12字元)";
top.str_longin_limit2 = "您的登錄帳號需使用字母加上數字!!";
top.str_o="單";
top.str_e="雙";
top.str_checknum="驗證碼錯誤,請重新輸入";
top.str_irish_kiss="和局";
top.dPrivate="私域";
top.dPublic="公有";
top.grep="群組";
top.grepIP="群組IP";
top.IP_list="IP列表";
top.Group="組別";
top.choice="請選擇";
top.account="請輸入帳號!!";
top.password="請輸入密碼!!";
top.S_EM="特早";
top.alldata="全部";
top.webset="資訊網";
top.str_renew="更新";
top.outright="冠軍";
top.financial="金融";
top.str_HCN = new Array("主","客","無");

//====== Live TV
top.str_FT = "足球";
top.str_BK = "籃球";
top.str_TN = "網球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";
top.str_game_list = "所有球類";
top.str_second = "秒";
top.str_demo = "樣本播放";
top.str_alone = "獨立";
top.str_back = "返回";
top.str_RB = "滾球";

top.str_ShowMyFavorite="我的最愛";
top.str_ShowAllGame="全部賽事";
top.str_delShowLoveI="移出";


top.strRtypeSP = new Array();
top.strRtypeSP["PGF"]="最先進球";
top.strRtypeSP["OSF"]="最先越位";
top.strRtypeSP["STF"]="最先替補球員";
top.strRtypeSP["CNF"]="第一顆角球";
top.strRtypeSP["CDF"]="第一張卡";
top.strRtypeSP["RCF"]="會進球";
top.strRtypeSP["YCF"]="第一張黃卡";
top.strRtypeSP["GAF"]="有失球";
top.strRtypeSP["PGL"]="最後進球";
top.strRtypeSP["OSL"]="最後越位";
top.strRtypeSP["STL"]="最後替補球員";
top.strRtypeSP["CNL"]="最後一顆角球";
top.strRtypeSP["CDL"]="最後一張卡";
top.strRtypeSP["RCL"]="不會進球";
top.strRtypeSP["YCL"]="最後一張黃卡";
top.strRtypeSP["GAL"]="沒有失球";
top.strRtypeSP["PG"]="最先/最後進球球隊";
top.strRtypeSP["OS"]="最先/最後越位球隊";
top.strRtypeSP["ST"]="最先/最後替補球員球隊";
top.strRtypeSP["CN"]="第一顆/最後一顆角球";
top.strRtypeSP["CD"]="第一張/最後一張卡";
top.strRtypeSP["RC"]="會進球/不會進球";
top.strRtypeSP["YC"]="第一張/最後一張黃卡";
top.strRtypeSP["GA"]="有失球/沒有失球";


top.strOver="大";
top.strUnder="小";
top.strOdd="單";
top.strEven="雙";


//下注警語
top.message001="請輸入下注金額!!";
top.message002="只能輸入數字!!";
top.message003="下注金額不可小於最低下注金額!!";
top.message004="對不起,本場有下注金額最高: ";
top.message005=" 元限制!!";
top.message006="下注金額不可大於單注限額!!";
top.message007="下注金額已超過單場最高限額!!";
top.message008="本場累計下注共: ";
top.message009="\n下注金額已超過單場限額!!";
top.message010="下注金額不可大於可用額度!!";
top.message011="可贏金額：";
top.message012="<br>是否確定下注?";
top.message013="是否確定下注?<br>";
top.message014='未輸入下注金額!!!';
top.message015="下注金額僅能輸入數字!!";
top.message016="\n\n是否確定下注?";
top.message017="串1";
top.message018="隊聯碰";
top.message019="您必須選擇至少";
top.message020="個隊伍,否則不能下注!!";
top.message021="不接受";
top.message022="串過關投注!!";
top.message023="請輸入欲下注金額!!";
top.message024="已超過某場次之過關注單限額!!";
top.message025="下注金額不可大於信用額度!!";
top.message026="請選擇下注隊伍!!";
top.message027="單式投注請至單式下注頁面下注!!";
top.message028="僅接受";
top.message029="串投注!!";
</script>


</head>

<body onLoad="show();">
<div class="title" style="background-image:url(../../images/member/index_title_tw.png); height:63 ; background-repeat:no-repeat" >
  <table class="table" cellpadding="0" cellspacing="0" border="0"><tr>
      <td class="lang2"><a href='/app/member/translate.php?set=zh-tw&url=/app/member/index.php'>繁體版</a></td>
     <td class="lang"><a href='/app/member/translate.php?set=zh-cn&url=/app/member/index.php'>简体版</a></td>
      <td class="lang"><a href='/app/member/translate.php?set=en-us&url=/app/member/index.php'>English</a></td>
	  <td class="lang"><a href='/app/member/translate.php?set=th-tis&url=/app/member/index.php'>ภาษาไทย</a></td>
    </tr>
</table>
</div>
<div class="mem">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="596" height="506" hspace="0" vspace="0">
    <param name="movie" value="../../images/member/2010_tw.swf" />
    <param name="quality" value="high" />
    <param name="SCALE" value="noborder">
    <embed src="../../images/member/2010_tw.swf" width="596" height="506" hspace="0" vspace="0" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" scale="noborder"></embed>
</object></div>

<div class="log">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="<?=$size?>"  border="0" cellpadding="2" cellspacing="2" class="bord">
<form action="./login.php" method="post" name="LoginForm" onSubmit="return chk_acc();" >
                    <input type=HIDDEN name="uid" value="<?=$uid?>">
                    <input type=HIDDEN name="langx" value="<?=$langx?>">
		    <input type=HIDDEN name="mac" value="">
		    <input type=HIDDEN name="ver" value="">
                    <input type="hidden" name="JE" value="">
                    <tr>
                      <td height="40" colspan="3" align="left" ><!--font id="hr_info" color="#CC0000"--><img src="/images/member/index_logo2.png" width="134" height="31" /><span class="virus"><a href="/tpl/member/zh-tw/virus_site01.html" target="_blank">防毒軟件設置說明</a></span></td>
            </tr>
                    <tr>
                      <td colspan="2" align="center" class="txt"><font id="hr_info" color="#CC0000"></font><br>
            You must sign in to use our service.</td>
            </tr>
                    <tr>
                      <td width="35%" align="right"><li><?=$username?></li></td>
                      <td align="left"><input type="text" name="username" size="15" class="za_text"></td>
                    </tr>
                    <tr>
                      <td align="right"><li><?=$password?></li></td>
                      <td align="left"><input type="password" name="password" size="15" class="za_text"> </td>
                    </tr>
                    <tr>
                      <td height="27" align="right">&nbsp;</td>
                      <td align="left"><input type="submit" value="<?=$submitok?>" class="za_text" ></td>
                    </tr>
          </form>
          </table>
<br /><br />
          <table width="<?=$size?>" border="0" cellpadding="5" cellspacing="5" class="bord">
  <tr class="sub">
    <td colspan="2" align="center"><a href="#"><?=$index4?></a></td>
    </tr>
  <tr class="txt">
    <td align="center"><a href="#"><?=$index7?></a></td>
    <td align="center"><a href="#"><?=$index8?></a> </td>
  </tr>
</table>          </td>
  </tr>
</table>
</div>
<div class="foot"><?=$index9?> - <a href="#\"><?=$index10?></a> - <a href="#"><?=$index11?> </a>- <a href="#"><?=$index12?></a> - <a href="#"><?=$index13?></a>
</div>
</body>
</html>
