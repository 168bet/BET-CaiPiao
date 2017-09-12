<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_JB/loadgame_R.php?langx=zh-tw&uid=$uid";
$html_data=$curl->fetch_url("".$site."/app/member/browse_JB/reloadgame_R.php?langx=zh-tw&uid=$uid&LegGame=ALL";
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$a = array(
"if(self == top)",
"<script>",
"</script>",
"\n\n"
);
$b = array(
"",
"",
"",
""
);
unset($matches);
unset($datainfo);
$msg = str_replace($a,$b,$html_data);
preg_match_all("/new Array\(\'(.+?)\);/is",$msg,$matches);
//echo $msg;
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$messages = iconv("BIG5","UTF-8",$messages);
	$datainfo=explode(",",$messages);
	$mDate=explode(' ',strtoupper($datainfo[1]));
	$m_Date=$mDate[0];
	$m_Time=date("h:ia",strtotime($datainfo[1]));
	$m_Time=str_replace("m","",$m_Time);
	//echo $m_Time;	
	if (sizeof($mDate)>2){
		$m_Type=1;
	}else{
		$m_Type=0;
	}

	$mb_dime=str_replace('15+100','O14.5',$datainfo[13]);
	$mb_dime=str_replace('15+75','O15+75',$mb_dime);
	$mb_dime=str_replace('15-50','O15/15.5',$mb_dime);
	$mb_dime=str_replace('15+25','O15+25',$mb_dime);
	$mb_dime=str_replace('15+0','O15',$mb_dime);
	$mb_dime=str_replace('15-75','O15-75',$mb_dime);
	$mb_dime=str_replace('15+50','O14.5/15',$mb_dime);
	$mb_dime=str_replace('15-25','O15-25',$mb_dime);
	
	$mb_dime=str_replace('14+100','O13.5',$mb_dime);
	$mb_dime=str_replace('14+75','O14+75',$mb_dime);
	$mb_dime=str_replace('14-50','O14/14.5',$mb_dime);
	$mb_dime=str_replace('14+25','O14+25',$mb_dime);
	$mb_dime=str_replace('14+0','O14',$mb_dime);
	$mb_dime=str_replace('14-75','O14-75',$mb_dime);
	$mb_dime=str_replace('14+50','O13.5/14',$mb_dime);
	$mb_dime=str_replace('14-25','O14-25',$mb_dime);
	
	$mb_dime=str_replace('13+100','O12.5',$mb_dime);
	$mb_dime=str_replace('13+75','O13+75',$mb_dime);
	$mb_dime=str_replace('13-50','O13/13.5',$mb_dime);
	$mb_dime=str_replace('13+25','O13+25',$mb_dime);
	$mb_dime=str_replace('13+0','O13',$mb_dime);
	$mb_dime=str_replace('13-75','O13-75',$mb_dime);
	$mb_dime=str_replace('13+50','O12.5/13',$mb_dime);
	$mb_dime=str_replace('13-25','O13-25',$mb_dime);
		
	$mb_dime=str_replace('12+100','O11.5',$mb_dime);
	$mb_dime=str_replace('12+75','O12+75',$mb_dime);
	$mb_dime=str_replace('12-50','O12/12.5',$mb_dime);
	$mb_dime=str_replace('12+25','O12+25',$mb_dime);
	$mb_dime=str_replace('12+0','O12',$mb_dime);
	$mb_dime=str_replace('12-75','O12-75',$mb_dime);
	$mb_dime=str_replace('12+50','O11.5/12',$mb_dime);
	$mb_dime=str_replace('12-25','O12-25',$mb_dime);
		
	$mb_dime=str_replace('11+100','O10.5',$mb_dime);
	$mb_dime=str_replace('11+75','O11+75',$mb_dime);
	$mb_dime=str_replace('11-50','O11/11.5',$mb_dime);
	$mb_dime=str_replace('11+25','O11+25',$mb_dime);
	$mb_dime=str_replace('11+0','O11',$mb_dime);
	$mb_dime=str_replace('11-75','O11-75',$mb_dime);
	$mb_dime=str_replace('11+50','O10.5/11',$mb_dime);
	$mb_dime=str_replace('11-25','O11-25',$mb_dime);
	
	$mb_dime=str_replace('10+100','O9.5',$mb_dime);
	$mb_dime=str_replace('10+75','O10+75',$mb_dime);
	$mb_dime=str_replace('10-50','O10/10.5',$mb_dime);
	$mb_dime=str_replace('10+25','O10+25',$mb_dime);
	$mb_dime=str_replace('10+0','O10',$mb_dime);
	$mb_dime=str_replace('10-75','O10-75',$mb_dime);
	$mb_dime=str_replace('10+50','O9.5/10',$mb_dime);
	$mb_dime=str_replace('10-25','O10-25',$mb_dime);
	
	$mb_dime=str_replace('9+100','O8.5',$mb_dime);
	$mb_dime=str_replace('9+75','O9+75',$mb_dime);
	$mb_dime=str_replace('9-50','O9/9.5',$mb_dime);
	$mb_dime=str_replace('9+25','O9+25',$mb_dime);
	$mb_dime=str_replace('9+0','O9',$mb_dime);
	$mb_dime=str_replace('9-75','O9-75',$mb_dime);
	$mb_dime=str_replace('9+50','O8.5/9',$mb_dime);
	$mb_dime=str_replace('9-25','O9-25',$mb_dime);
	
	$mb_dime=str_replace('8+100','O7.5',$mb_dime);
	$mb_dime=str_replace('8+75','O8+75',$mb_dime);
	$mb_dime=str_replace('8-50','O8/8.5',$mb_dime);
	$mb_dime=str_replace('8+25','O8+25',$mb_dime);
	$mb_dime=str_replace('8+0','O8',$mb_dime);
	$mb_dime=str_replace('8-75','O8-75',$mb_dime);
	$mb_dime=str_replace('8+50','O7.5/8',$mb_dime);
	$mb_dime=str_replace('8-25','O8-25',$mb_dime);
	
	$mb_dime=str_replace('7+100','O6.5',$mb_dime);
	$mb_dime=str_replace('7+75','O7+75',$mb_dime);
	$mb_dime=str_replace('7-50','O7/7.5',$mb_dime);
	$mb_dime=str_replace('7+25','O7+25',$mb_dime);
	$mb_dime=str_replace('7+0','O7',$mb_dime);
	$mb_dime=str_replace('7-75','O7-75',$mb_dime);
	$mb_dime=str_replace('7+50','O6.5/7',$mb_dime);
	$mb_dime=str_replace('7-25','O7-25',$mb_dime);
	
	$mb_dime=str_replace('6+100','O5.5',$mb_dime);
	$mb_dime=str_replace('6+75','O6+75',$mb_dime);
	$mb_dime=str_replace('6-50','O6/6.5',$mb_dime);
	$mb_dime=str_replace('6+25','O6+25',$mb_dime);
	$mb_dime=str_replace('6+0','O6',$mb_dime);
	$mb_dime=str_replace('6-75','O6-75',$mb_dime);
	$mb_dime=str_replace('6+50','O5.5/6',$mb_dime);
	$mb_dime=str_replace('6-25','O6-25',$mb_dime);
	
	$mb_dime=str_replace('5+100','O4.5',$mb_dime);
	$mb_dime=str_replace('5+75','O5+75',$mb_dime);
	$mb_dime=str_replace('5-50','O5/5.5',$mb_dime);
	$mb_dime=str_replace('5+25','O5+25',$mb_dime);
	$mb_dime=str_replace('5+0','O5',$mb_dime);
	$mb_dime=str_replace('5-75','O5-75',$mb_dime);
	$mb_dime=str_replace('5+50','O4.5/5',$mb_dime);
	$mb_dime=str_replace('5-25','O5-25',$mb_dime);
	
	$mb_dime=str_replace('4+100','O3.5',$mb_dime);
	$mb_dime=str_replace('4+75','O4+75',$mb_dime);
	$mb_dime=str_replace('4-50','O4/4.5',$mb_dime);
	$mb_dime=str_replace('4+25','O4+25',$mb_dime);
	$mb_dime=str_replace('4+0','O4',$mb_dime);
	$mb_dime=str_replace('4-75','O4-75',$mb_dime);
	$mb_dime=str_replace('4+50','O3.5/4',$mb_dime);
	$mb_dime=str_replace('4-25','O4-25',$mb_dime);
	
	$mb_dime=str_replace('3+100','O2.5',$mb_dime);
	$mb_dime=str_replace('3+75','O3+75',$mb_dime);
	$mb_dime=str_replace('3-50','O3/3.5',$mb_dime);
	$mb_dime=str_replace('3+25','O3+25',$mb_dime);
	$mb_dime=str_replace('3+0','O3',$mb_dime);
	$mb_dime=str_replace('3-75','O3-75',$mb_dime);
	$mb_dime=str_replace('3+50','O2.5/3',$mb_dime);
	$mb_dime=str_replace('3-25','O3-25',$mb_dime);
	
	$mb_dime=str_replace('2+100','O1.5',$mb_dime);
	$mb_dime=str_replace('2+75','O2+75',$mb_dime);
	$mb_dime=str_replace('2-50','O2/2.5',$mb_dime);
	$mb_dime=str_replace('2+25','O2+25',$mb_dime);
	$mb_dime=str_replace('2+0','O2',$mb_dime);
	$mb_dime=str_replace('2-75','O2-75',$mb_dime);
	$mb_dime=str_replace('2+50','O1.5/2',$mb_dime);
	$mb_dime=str_replace('2-25','O2-25',$mb_dime);
	
	$mb_dime=str_replace('1+100','O0.5',$mb_dime);
	$mb_dime=str_replace('1+75','O1+75',$mb_dime);
	$mb_dime=str_replace('1-50','O1/1.5',$mb_dime);
	$mb_dime=str_replace('1+25','O1+25',$mb_dime);
	$mb_dime=str_replace('1+0','O1',$mb_dime);
	$mb_dime=str_replace('1-75','O1-75',$mb_dime);
	$mb_dime=str_replace('1+50','O0.5/1',$mb_dime);
	$mb_dime=str_replace('1-25','O1-25',$mb_dime);

	
	$tg_dime=str_replace('15+100','U14.5',$datainfo[13]);
	$tg_dime=str_replace('15+75','U15+75',$tg_dime);
	$tg_dime=str_replace('15+50','U15/15.5',$tg_dime);
	$tg_dime=str_replace('15+25','U15+25',$tg_dime);
	$tg_dime=str_replace('15+0','U15',$tg_dime);
	$tg_dime=str_replace('15-75','U15-75',$tg_dime);
	$tg_dime=str_replace('15-50','U14.5/15',$tg_dime);
	$tg_dime=str_replace('15-25','U15-25',$tg_dime);
	
	$tg_dime=str_replace('14+100','U13.5',$tg_dime);
	$tg_dime=str_replace('14+75','U14+75',$tg_dime);
	$tg_dime=str_replace('14+50','U14/14.5',$tg_dime);
	$tg_dime=str_replace('14+25','U14+25',$tg_dime);
	$tg_dime=str_replace('14+0','U14',$tg_dime);
	$tg_dime=str_replace('14-75','U14-75',$tg_dime);
	$tg_dime=str_replace('14-50','U13.5/14',$tg_dime);
	$tg_dime=str_replace('14-25','U14-25',$tg_dime);
	
	$tg_dime=str_replace('13+100','U12.5',$tg_dime);
	$tg_dime=str_replace('13+75','U13+75',$tg_dime);
	$tg_dime=str_replace('13+50','U13/13.5',$tg_dime);
	$tg_dime=str_replace('13+25','U13+25',$tg_dime);
	$tg_dime=str_replace('13+0','U13',$tg_dime);
	$tg_dime=str_replace('13-75','U13-75',$tg_dime);
	$tg_dime=str_replace('13-50','U12.5/13',$tg_dime);
	$tg_dime=str_replace('13-25','U13-25',$tg_dime);
		
	$tg_dime=str_replace('12+100','U11.5',$tg_dime);
	$tg_dime=str_replace('12+75','U12+75',$tg_dime);
	$tg_dime=str_replace('12+50','U12/12.5',$tg_dime);
	$tg_dime=str_replace('12+25','U12+25',$tg_dime);
	$tg_dime=str_replace('12+0','U12',$tg_dime);
	$tg_dime=str_replace('12-75','U12-75',$tg_dime);
	$tg_dime=str_replace('12-50','U11.5/12',$tg_dime);
	$tg_dime=str_replace('12-25','U12-25',$tg_dime);
		
	$tg_dime=str_replace('11+100','U10.5',$tg_dime);
	$tg_dime=str_replace('11+75','U11+75',$tg_dime);
	$tg_dime=str_replace('11+50','U11/11.5',$tg_dime);
	$tg_dime=str_replace('11+25','U11+25',$tg_dime);
	$tg_dime=str_replace('11+0','U11',$tg_dime);
	$tg_dime=str_replace('11-75','U11-75',$tg_dime);
	$tg_dime=str_replace('11-50','U10.5/11',$tg_dime);
	$tg_dime=str_replace('11-25','U11-25',$tg_dime);
	
	$tg_dime=str_replace('10+100','U9.5',$tg_dime);
	$tg_dime=str_replace('10+75','U10+75',$tg_dime);
	$tg_dime=str_replace('10+50','U10/10.5',$tg_dime);
	$tg_dime=str_replace('10+25','U10+25',$tg_dime);
	$tg_dime=str_replace('10+0','U10',$tg_dime);
	$tg_dime=str_replace('10-75','U10-75',$tg_dime);
	$tg_dime=str_replace('10-50','U9.5/10',$tg_dime);
	$tg_dime=str_replace('10-25','U10-25',$tg_dime);
	
	$tg_dime=str_replace('9+100','U8.5',$tg_dime);
	$tg_dime=str_replace('9+75','U9+75',$tg_dime);
	$tg_dime=str_replace('9+50','U9/9.5',$tg_dime);
	$tg_dime=str_replace('9+25','U9+25',$tg_dime);
	$tg_dime=str_replace('9+0','U9',$tg_dime);
	$tg_dime=str_replace('9-75','U9-75',$tg_dime);
	$tg_dime=str_replace('9-50','U8.5/9',$tg_dime);
	$tg_dime=str_replace('9-25','U9-25',$tg_dime);
	
	$tg_dime=str_replace('8+100','U7.5',$tg_dime);
	$tg_dime=str_replace('8+75','U8+75',$tg_dime);
	$tg_dime=str_replace('8+50','U8/8.5',$tg_dime);
	$tg_dime=str_replace('8+25','U8+25',$tg_dime);
	$tg_dime=str_replace('8+0','U8',$tg_dime);
	$tg_dime=str_replace('8-75','U8-75',$tg_dime);
	$tg_dime=str_replace('8-50','U7.5/8',$tg_dime);
	$tg_dime=str_replace('8-25','U8-25',$tg_dime);
	
	$tg_dime=str_replace('7+100','U6.5',$tg_dime);
	$tg_dime=str_replace('7+75','U7+75',$tg_dime);
	$tg_dime=str_replace('7+50','U7/7.5',$tg_dime);
	$tg_dime=str_replace('7+25','U7+25',$tg_dime);
	$tg_dime=str_replace('7+0','U7',$tg_dime);
	$tg_dime=str_replace('7-75','U7-75',$tg_dime);
	$tg_dime=str_replace('7-50','U6.5/7',$tg_dime);
	$tg_dime=str_replace('7-25','U7-25',$tg_dime);
	
	$tg_dime=str_replace('6+100','U5.5',$tg_dime);
	$tg_dime=str_replace('6+75','U6+75',$tg_dime);
	$tg_dime=str_replace('6+50','U6/6.5',$tg_dime);
	$tg_dime=str_replace('6+25','U6+25',$tg_dime);
	$tg_dime=str_replace('6+0','U6',$tg_dime);
	$tg_dime=str_replace('6-75','U6-75',$tg_dime);
	$tg_dime=str_replace('6-50','U5.5/6',$tg_dime);
	$tg_dime=str_replace('6-25','U6-25',$tg_dime);
	
	$tg_dime=str_replace('5+100','U4.5',$tg_dime);
	$tg_dime=str_replace('5+75','U5+75',$tg_dime);
	$tg_dime=str_replace('5+50','U5/5.5',$tg_dime);
	$tg_dime=str_replace('5+25','U5+25',$tg_dime);
	$tg_dime=str_replace('5+0','U5',$tg_dime);
	$tg_dime=str_replace('5-75','U5-75',$tg_dime);
	$tg_dime=str_replace('5-50','U4.5/5',$tg_dime);
	$tg_dime=str_replace('5-25','U5-25',$tg_dime);
	
	$tg_dime=str_replace('4+100','U3.5',$tg_dime);
	$tg_dime=str_replace('4+75','U4+75',$tg_dime);
	$tg_dime=str_replace('4+50','U4/4.5',$tg_dime);
	$tg_dime=str_replace('4+25','U4+25',$tg_dime);
	$tg_dime=str_replace('4+0','U4',$tg_dime);
	$tg_dime=str_replace('4-75','U4-75',$tg_dime);
	$tg_dime=str_replace('4-50','U3.5/4',$tg_dime);
	$tg_dime=str_replace('4-25','U4-25',$tg_dime);
	
	$tg_dime=str_replace('3+100','U2.5',$tg_dime);
	$tg_dime=str_replace('3+75','U3+75',$tg_dime);
	$tg_dime=str_replace('3+50','U3/3.5',$tg_dime);
	$tg_dime=str_replace('3+25','U3+25',$tg_dime);
	$tg_dime=str_replace('3+0','U3',$tg_dime);
	$tg_dime=str_replace('3-75','U3-75',$tg_dime);
	$tg_dime=str_replace('3-50','U2.5/3',$tg_dime);
	$tg_dime=str_replace('3-25','U3-25',$tg_dime);
	
	$tg_dime=str_replace('2+100','U1.5',$tg_dime);
	$tg_dime=str_replace('2+75','U2+75',$tg_dime);
	$tg_dime=str_replace('2+50','U2/2.5',$tg_dime);
	$tg_dime=str_replace('2+25','U2+25',$tg_dime);
	$tg_dime=str_replace('2+0','U2',$tg_dime);
	$tg_dime=str_replace('2-75','U2-75',$tg_dime);
	$tg_dime=str_replace('2-50','U1.5/2',$tg_dime);
	$tg_dime=str_replace('2-25','U2-25',$tg_dime);
	
	$tg_dime=str_replace('1+100','U0.5',$tg_dime);
	$tg_dime=str_replace('1+75','U1+75',$tg_dime);
	$tg_dime=str_replace('1+50','U1/1.5',$tg_dime);
	$tg_dime=str_replace('1+25','U1+25',$tg_dime);
	$tg_dime=str_replace('1+0','U1',$tg_dime);
	$tg_dime=str_replace('1-75','U1-75',$tg_dime);
	$tg_dime=str_replace('1-50','U0.5/1',$tg_dime);
	$tg_dime=str_replace('1-25','U1-25',$tg_dime);
	
	$m_Letb=str_replace('10+0','10',$datainfo[10]);
	$m_Letb=str_replace('9+0','9',$m_Letb);
	$m_Letb=str_replace('8+0','8',$m_Letb);
	$m_Letb=str_replace('7+0','7',$m_Letb);
	$m_Letb=str_replace('6+0','6',$m_Letb);
	$m_Letb=str_replace('5+0','5',$m_Letb);
	$m_Letb=str_replace('4+0','4',$m_Letb);
	$m_Letb=str_replace('3+0','3',$m_Letb);
	$m_Letb=str_replace('2+0','2',$m_Letb);
	$m_Letb=str_replace('1+0','1',$m_Letb);
	$m_Letb=str_replace('0+0','0',$m_Letb);
	
	
	$MB_MID=$datainfo[3];
	$TG_MID=$datainfo[3]+1;
	
    $datainfo[4]=str_replace('H','主',$datainfo[4]);
	$datainfo[21]=str_replace('R','右',$datainfo[21]);
	$datainfo[21]=str_replace('L','左',$datainfo[21]);
	$datainfo[22]=str_replace('L','左',$datainfo[22]);
	$datainfo[22]=str_replace('R','右',$datainfo[22]);
	
	if($datainfo[18]=='' or $datainfo[19]=='' or $datainfo[18]==0 or $datainfo[19]==0){
	   $mb_win=$datainfo[18];
	   $tg_win=$datainfo[19];
	}else{
	   $mb_win=$datainfo[18]+1;
	   $tg_win=$datainfo[19]+1;	
	}	
	
	$checksql = "select MID from match_sports where `MID` =$datainfo[0]";
	$checkresult = mysql_query($checksql);	
	$check=mysql_num_rows($checkresult);
	if ($check==0){
		$sql = "INSERT INTO match_sports(MID,M_Start,M_Date,M_Time,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,M_Type,S_Show) VALUES ('$datainfo[0]','$datainfo[1]','$m_Date','$m_Time','$datainfo[4]','$datainfo[5]','$datainfo[2]','$MB_MID','$TG_MID','$m_Type','1')";
	}else{
		$sql = "update match_sports set MB_Team_tw='$datainfo[4]',TG_Team_tw='$datainfo[5]',MB_Team_Name_tw='$datainfo[21]',TG_Team_Name_tw='$datainfo[22]',M_Start='$datainfo[1]',M_Date='$m_Date',M_Time='$m_Time',M_League_tw='$datainfo[2]',ShowType='$datainfo[6]',M_LetB='$m_Letb',MB_LetB_Rate='$datainfo[11]',TG_LetB_Rate='$datainfo[12]',MB_Dime='$mb_dime',TG_Dime='$tg_dime',TG_Dime_Rate='$datainfo[14]',MB_Dime_Rate='$datainfo[15]',MB_Win='$mb_win',TG_Win='$tg_win',M_OneTwo='1.5',MB_OneTwo_Rate='$datainfo[16]',TG_OneTwo_Rate='$datainfo[17]',S_Show=1,M_Type='$m_Type' where MID=$datainfo[0]";
		//echo $sql;
	}
		mysql_query($sql) or die ("操作失敗!!");
	
}
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<body>
<script> 
<!-- 
var limit="<?=$settime?>" 
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒後自動獲取!" 
	else 
		curtime=cursec+"秒後自動獲取!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<table width="100" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" align="center">
      單式數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
