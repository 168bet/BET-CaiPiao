<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/curl_http.php");
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$gtype=$_REQUEST['game_type'];
$list_date=empty($_REQUEST['today'])?$_REQUEST['list_date']:$_REQUEST['today'];

if ($list_date==""){
  	$today=$_REQUEST['today'];
  	if (empty($today)){
  		$today 					= 	date("Y-m-d");
  		$tomorrow 			=		"";
  		$lastday 				= 	date("Y-m-d",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
  	}else{
  		$date_list_1		=		explode("-",$today);
  		$d1							=		mktime(0,0,0,$date_list_1[1],$date_list_1[2],$date_list_1[0]);
  		$tomorrow				=		date('Y-m-d',$d1+24*60*60);
  		$lastday				=		date('Y-m-d',$d1-24*60*60);

  		if ($today>=date('Y-m-d')){
  			$tomorrow='';
  		}
  	}
  	$list_date=$today;
  }else{
  	$today = $list_date;
  	$date_list=mktime(0,0,0,substr($list_date,5,2),substr($list_date,8,2),substr($list_date,0,4));
  	$tomorrow = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)+1,date("Y",$date_list)));
  	$lastday  = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)-1,date("Y",$date_list)));
  	if (strcmp($tomorrow,date("Y-m-d"))>0){
  		$tomorrow="";
  	}
  }

  if($gtype == 'NFS' || $gtype == 'FI')
  {
	  
		$yesterday='<a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&today='.$lastday.'&uid='.$uid.'">昨天</a>';
		if (!empty($tomorrow)){
			$tomorrow='  / <a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&today='.$tomorrow.'&uid='.$uid.'">明天</a>';
		}
  }
  else
  {
		$yesterday='<a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&list_date='.$lastday.'&uid='.$uid.'">昨天</a>';
		if (!empty($tomorrow)){
			$tomorrow='  / <a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&list_date='.$tomorrow.'&uid='.$uid.'">明天</a>';
		}
  }

  $date_search=$yesterday.$tomorrow;



$sql = "select Language from web_member_data where oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	setcookie('login_uid','');
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");

	$mysql = "select datasite,datasite_en,datasite_tw,uid,uid_tw,uid_en from web_system_data where ID=1";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	switch($langx)	{
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		break;
	case "zh-cn":
		$suid=$row['uid'];
		$site=$row['datasite'];
		break;
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "th-tis":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	}
	

	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("/tmp/cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/result/result.php?game_type=$gtype&uid=$suid&langx=$langx&list_date=$list_date");
	//echo "".$site."/app/member/result/result.php?game_type=$gtype&uid=$suid&langx=$langx&list_date=$list_date";exit;
	//echo "".$site."/app/member/result/result.php?game_type=$gtype&uid=$suid&langx=$langx&list_date=$list_date";
	$html_data=str_replace($suid,$uid,$html_data);
	$html_data=str_replace('版权所有 建议您以 IE 5.0 800 X 600 以上高彩模式浏览本站&nbsp;&nbsp;<a id=download title="下载" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下载IE</a>','',$html_data);

			$res=split('<td class="mem">',$html_data);	
?>
<html>
<head>
<title>FT_result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body.css" type="text/css">
<SCRIPT language="javascript" src="/js/result.js"></SCRIPT>
<script>var langx='<?=$langx?>';</script>
<script language="JavaScript" type="text/JavaScript">
function onLoad(){
    var game_type = document.getElementById('game_type');
    game_type.value = '<?=$gtype ?>';
}
</script>
</head>

<body id="MFT"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false" onLoad="onLoad();">
<table border="0" cellpadding="0" cellspacing="0" id="box">
    <tr>
    <td id="ad">
			<span id="real_msg"><marquee scrolldelay="120"><?=$msg_member_tw ?></marquee></span>
			<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>

</td>
  </tr>
  <tr>
    <td class="top">
      <form name="game_result" action="result.php?uid=<?=$uid ?>" method=POST>
      
        <h1><em><select name="game_type" class="za_select">
            <option value="FT" >足球</option>
            <option value="BK">篮球</option>
            <option value="BS">棒球</option>
            <option value="TN">网球</option>
            <option value="VB">排球</option>
            <option value="OP">其它</option>
            <option value="NFS">冠军</option>
          </select>&nbsp;赛事结果</em>
  	      <span class="rig"><?=$date_search?>
		  <input id="today_gmt" type=TEXT name="today" value="<?=$today;?>" size="9" maxlength="10" class="txt">
  	      <input type="submit" value="查询" name="submit"></span>
        </h1>
	  </form>
	</td>
  </tr>
  <tr>
    <td class="mem">
    	<?=$res[1]?>
