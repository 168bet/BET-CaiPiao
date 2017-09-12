<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
$langx='zh-cn';
include "./include/address.mem.php";
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");
require ("./include/curl_http.php");
require ("./include/traditional.$langx.inc.php");

$mysql = "select datasite,datasite_tw,datasite_en,Uid,Uid_tw,Uid_en from web_system_data where ID=1";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
switch($langx)	{
case "zh-tw":
	$suid=$row['Uid_tw'];
	$site=$row['datasite_tw'];
	break;
case "zh-cn":
	$suid=$row['Uid'];
	$site=$row['datasite'];
	break;
case "en-us":
	$suid=$row['Uid_en'];
	$site=$row['datasite_en'];
	break;
case "th-tis":
	$suid=$row['Uid_en'];
	$site=$row['datasite_en'];
	break;
}
$m_date=date('Y-m-d');
$date=date('m-d');

//**********************足球*********************/
	//R
	$mysql="select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `S_Show`=1 and `Open`=1 order by M_Start,$m_league,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
	//HR
	$mysql = "select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `H_Show`=1 and `Open`=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
	//RE
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");	
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];
	//PD
	$mysql = "select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and `MB2TG1`!=0 and `Open`=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//HPD
	$mysql = "select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date`='$m_date' and `HPD_Show`=1 and `MB2TG1H`!=0 and `Open`=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//T
	$mysql = "select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `T_Show`=1 and `Open`=1 order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//F
	$mysql = "select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `F_Show`=1 and `Open`=1 order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P3
	$mysql = "select MID from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date`='$m_date' and `P3_Show`=1 and `Open`=1 order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	


//**********************足球早餐*********************/

	//R
	$mysql = "select MID from `match_sports` where `Type`='FU' and `M_Date` >'$m_date' and `S_Show`=1  and `Open`=1 order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
	//HR
	$mysql = "select MID from `match_sports` where `Type`='FU' and `M_Date` >'$m_date' and `H_Show`=1  and `Open`=1 order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
	//PD
	$mysql = "select MID from `match_sports` where `Type`='FU' and  `M_Date` >'$m_date' and `PD_Show`=1 and `MB2TG1`!=0  and `Open`=1 order by m_start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//HPD
	$mysql = "select MID from `match_sports` where `Type`='FU' and `M_Date` >'$m_date' and `HPD_Show`=1 and `MB2TG1H`!=0  and `Open`=1 order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//T
	$mysql = "select MID from `match_sports` where `Type`='FU' and `M_Date` >'$m_date' and `T_Show`=1 and `Open`=1 order by m_start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//F
	$mysql = "select MID from `match_sports` where `Type`='FU' and `M_Date` >'$m_date' and `F_Show`=1 and `MBMB`>0 and `Open`=1 order by m_start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P3
	$mysql = "select MID from `match_sports` where `Type`='FU' and `M_Date` >'$m_date' and `P3_Show`=1 and `Open`=1 order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
//14
//**********************篮球*********************/
	//ALL
	$mysql = "select MID from `match_sports` where Type='BK' and  `M_Start` > now( ) AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//R
	$mysql = "select MID from `match_sports` where Type='BK' and  `M_Start` > now( ) AND `M_Date` ='$m_date' and S_Show=1 and RQ_Show!=1 and $mb_team!='' order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//RQ4
	$mysql = "select MID from `match_sports` where Type='BK' and  `M_Start` > now( ) AND `M_Date` ='$m_date' and RQ_Show=1 and $mb_team!='' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//RE
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/BK_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/BK_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];	
	//PR
	$mysql = "select MID from `match_sports` where Type='BK' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PR_Show=1 and $mb_team<>'' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
//19
//**********************篮球早餐*********************/
	//ALL
	$mysql = "select MID, from `match_sports` where Type='BU' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' order by M_Start,$mb_team,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//R
	$mysql = "select MID from `match_sports` where Type='BU' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' order by M_Start,$mb_team,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//RQ4
	$mysql = "select MID from `match_sports` where Type='BU' and `M_Date` >'$m_date' and RQ_Show=1 and $mb_team!='' order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//PR
	$mysql = "select MID from `match_sports` where Type='BU' and `M_Date` >'$m_date' and PR_Show=1 and $mb_team<>'' order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
//23
//**********************棒球*********************/
	//R
	$mysql="select MID from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//HR
	$mysql = "select MID from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and $mb_team<>'' and H_Show=1  and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//RE
	$curl = &new Curl_HTTP_Client();
    $curl->store_cookies("cookies.txt"); 
    $curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
    $curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/BS_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");	
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];		
	//PD
	$mysql = "select MIDfrom `match_sports` where Type='BS' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and MBPDH1!=0 and $mb_team<>''  and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//T
	$mysql = "select MID from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and T_Show=1 and Open=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//P
	$mysql = "select MID from `match_sports` where Type='BS' and  `M_Start` > now() AND `M_Date` ='$m_date' and P_Show=1 and $mb_team<>'' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//PR
	$mysql = "select MID from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and PR_Show=1 and $mb_team<>'' and Open=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	

//**********************棒球早餐*********************/
	//R
	$mysql="select MID from `match_sports` where Type='BE' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//HR
	$mysql = "select MID from `match_sports` where Type='BE' and `M_Date` >'$m_date' and $mb_team<>'' and H_Show=1 and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//PD
	$mysql = "select MID from `match_sports` where Type='BE' and `M_Date` >'$m_date' and PD_Show=1 and MBPDH1!=0 and $mb_team<>'' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//T
	$mysql = "select MID from `match_sports` where Type='BE' and `M_Date` >'$m_date' and T_Show=1 and Open=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//P
	$mysql = "select MID from `match_sports` where Type='BE' and `M_Date` >'$m_date' and P_Show=1 and $mb_team<>'' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//PR
	$mysql = "select MID from `match_sports` where Type='BE' and `M_Date` >'$m_date' and PR_Show=1 and $mb_team<>'' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
//**********************网球*********************/
	//R
	$mysql = "select MID from `match_sports` where Type='TN' and `M_Start` > now( ) AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//RE
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/TN_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/TN_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");	
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];		
	//PD
	$mysql = "select MID from `match_sports` where Type='TN' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and MB2TG0!=0 and $mb_team!='' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P
	$mysql = "select MID from `match_sports` where Type='TN' and `M_Start` > now( ) AND `M_Date` ='$m_date' and P_Show=1 and $mb_team!='' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//PR
	$mysql = "select MID from `match_sports` where Type='TN' and `m_start` > now( ) AND `M_Date` ='$m_date'  and PR_Show=1 and $mb_team!='' order by M_Start,MB_MID desc";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
//**********************网球早餐*********************/
	//R
	$mysql = "select MID from `match_sports` where Type='TU' and `M_Date` >'$m_date' and S_Show=1 and $mb_team<>'' order by m_start,mid";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//PD
	$mysql = "select MID from `match_sports` where Type='TU' and `M_Date` >'$m_date' and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by m_start,mid";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P
	$mysql = "select MID from `match_sports` where Type='TU' and `M_Date` >'$m_date' and P_Show=1 and $mb_team<>'' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//PR
	$mysql = "select MID from `match_sports` where Type='TU' and `M_Date` >'$m_date' and PR_Show=1 and $mb_team<>'' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));

//**********************排球*********************/
	//R
	$mysql = "select MID from `match_sports` where Type='VB' and `M_Start` > now( ) AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' order by M_Start,$mb_team,MB_MID desc";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//RE
	$curl = &new Curl_HTTP_Client();
    $curl->store_cookies("cookies.txt"); 
    $curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
    $curl->set_referrer("".$site."/app/member/VB_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/VB_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");	
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];		
	//PD
	$mysql = "select MID from `match_sports` where Type='VB' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P
	$mysql = "select MID from `match_sports` where Type='VB' and `M_Start` > now( ) AND `M_Date` ='$m_date' and P_Show=1 and $mb_team<>'' order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//PR
	$mysql = "select MID from `match_sports` where Type='VB' and  `M_Start` > now( ) AND `M_Date` ='$m_date' and PR_Show=1 and $mb_team<>'' order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));

//**********************排球早餐*********************/
	//R
	$mysql = "select MID from `match_sports` where Type='VU' and `M_Date` >'$m_date' and S_Show=1 and $mb_team<>''  order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));		
	//PD
	$mysql = "select MID from `match_sports` where Type='VU' and `M_Date` >'$m_date'  and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by m_start,mid";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P
	$mysql = "select MID from `match_sports` where Type='VU' and `M_Date` >'$m_date' and P_Show=1 and $mb_team<>'' order by m_start,mid";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//PR
	$mysql = "select MID from `match_sports` where Type='VU' and `M_Date` >'$m_date' and PR_Show=1 and $mb_team<>'' order by m_start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));

//**********************其它*********************/
	//R
	$mysql = "select MID from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' and Open=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//HR
	$mysql = "select MID from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date' and $mb_team!='' and H_Show=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//RE
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/OP_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/OP_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");	
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];	
	//PD
	$mysql = "select MID from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//HPD
	$mysql = "select MID from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date' and HPD_Show=1 and MB2TG1!=0 and $mb_team<>''  order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//T
	$mysql = "select MID from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date' and T_Show=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//F
	$mysql = "select MID from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date' and F_Show=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P3
	$mysql = "select MID, from `match_sports` where Type='OP' and `M_Start` > now( ) AND `M_Date` ='$m_date'  and P3_Show=1 and $mb_team!='' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));
	
//**********************其它早餐*********************/
	//R
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//HR
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Date` >'$m_date' and $mb_team<>'' and H_Show=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//PD
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Date` >'$m_date' and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//HPD
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Date` >'$m_date' and HPD_Show=1 and MB2TG1H!=0 and $mb_team<>'' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//T
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Date` >'$m_date' and T_Show=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//F
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Date` >'$m_date' and F_Show=1  order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));	
	//P3
	$mysql = "select MID from `match_sports` where Type='OM' and `M_Start` > now( ) AND `M_Date` ='$m_date' and P3_Show=1 and $mb_team!='' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num[]=intval(mysql_num_rows($result));

//**********************冠军*********************/
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/browse_FS/loadgame_R.php?rtype=fs&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/browse_FS/reloadgame_R.php?uid=$suid&langx=$langx&rtype=fs");
	preg_match_all("/parent.gamount=(.+?);/is",$html_data,$matches);
	$cou_num[]=$matches[1][0];	

	echo trim(implode(",",$cou_num));
?>