<?php
require ("../include/config.inc.php");
require ('../include/curl_http.php');
require ("../include/traditional.zh-tw.inc.php");

$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$sid=$row['Uid_tw'];
$site=$row['datasite_tw'];
$settime=$row['udp_bk_score'];
$time=$row['udp_bk_results'];
$list_date=date('Y-m-d',time()-$time*60*60);


$mysql= "update match_sports set type='BK' where type='BU' AND  M_Start<now()";
mysql_query($mysql);

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/BK_index.php?uid=$sid&langx=zh-tw&mtype=3");
$html_date=$curl->fetch_url("".$site."/app/member/result/result.php?game_type=BK&list_date=$list_date&uid=$sid&langx=zh-tw");

$a = array(
"<script>",
"</script>",
'"',
"\n\n",
"<br>",
" ",
'</b></font>',
"<td>",
"<tdalign=left>",
"<fontcolor=#cc0000>",
"<fontcolor=red>",
"<b>",
"</b>",
"</a>",
"</font>"
);
$b = array(
"",
"",
"",
"",
"-",
"",
'',
"",
"",
"",
"",
"",
"",
""
);

$msg = str_replace($a,$b,$html_date);
//echo $msg;
$data1=explode("</div>",$msg);
$m=0;
$data=explode("<trclass=b_cen>",strtolower($msg));
for ($i=1;$i<sizeof($data);$i++){
     $abcde=explode("</tr>",$data[$i]);
     for ($j=0;$j<sizeof($abcde)-1;$j++){
         $score=explode("</td>",$abcde[$j]);
         //print_r($score);
         if (sizeof($score)==12){
            $mid=explode("-",$score[1]);
            $mb_mid=$mid[0];
            $tg_mid=$mid[1];
			
			$oscore=explode("-",$score[3]);						
			$tscore=explode("-",$score[4]);						
			$sscore=explode("-",$score[5]);
			$fscore=explode("-",$score[6]);
			$ascore=explode("-",$score[7]);
			$bscore=explode("-",$score[8]);
			$mscore=explode("-",$score[10]);
						
			$mb_inball1=trim(strip_tags($oscore[0]));
			$tg_inball1=trim(strip_tags($oscore[1]));
						
		    $mb_inball2=trim(strip_tags($tscore[0]));
			$tg_inball2=trim(strip_tags($tscore[1]));
						
			$mb_inball3=trim(strip_tags($sscore[0]));
			$tg_inball3=trim(strip_tags($sscore[1]));
						
			$mb_inball4=trim(strip_tags($fscore[0]));
			$tg_inball4=trim(strip_tags($fscore[1]));
                        
		    $mb_inball_hr=trim(strip_tags($ascore[0]));
			$tg_inball_hr=trim(strip_tags($ascore[1]));
                        
			$mb_inball_xb=trim(strip_tags($bscore[0]));
			$tg_inball_xb=trim(strip_tags($bscore[1]));
						
			$mb_inball=trim(strip_tags($mscore[0]));
			$tg_inball=trim(strip_tags($mscore[1]));
						
			if ($tg_inball==$Score1){
				$mb_inball1='-1';
				$tg_inball1='-1';
				$mb_inball2='-1';
				$tg_inball2='-1';
				$mb_inball3='-1';
				$tg_inball3='-1';
				$mb_inball4='-1';
				$tg_inball4='-1';
				$mb_inball_hr='-1';
				$tg_inball_hr='-1';
				$mb_inball_xb='-1';
				$tg_inball_xb='-1';
				$mb_inball='-1';
				$tg_inball='-1';
			}else if ($tg_inball==$Score2){
				$mb_inball1='-2';
				$tg_inball1='-2';
				$mb_inball2='-2';
				$tg_inball2='-2';
				$mb_inball3='-2';
				$tg_inball3='-2';
				$mb_inball4='-2';
				$tg_inball4='-2';
				$mb_inball_hr='-2';
				$tg_inball_hr='-2';
				$mb_inball_xb='-2';
				$tg_inball_xb='-2';
				$mb_inball='-2';
				$tg_inball='-2';
			}else if ($tg_inball==$Score3){
				$mb_inball1='-3';
				$tg_inball1='-3';
				$mb_inball2='-3';
				$tg_inball2='-3';
				$mb_inball3='-3';
				$tg_inball3='-3';
				$mb_inball4='-3';
				$tg_inball4='-3';
				$mb_inball_hr='-3';
				$tg_inball_hr='-3';
				$mb_inball_xb='-3';
				$tg_inball_xb='-3';
				$mb_inball='-3';
				$tg_inball='-3';
			}else if ($tg_inball==$Score4){
				$mb_inball1='-4';
				$tg_inball1='-4';
				$mb_inball2='-4';
				$tg_inball2='-4';
				$mb_inball3='-4';
				$tg_inball3='-4';
				$mb_inball4='-4';
				$tg_inball4='-4';
				$mb_inball_hr='-4';
				$tg_inball_hr='-4';
				$mb_inball_xb='-4';
				$tg_inball_xb='-4';
				$mb_inball='-4';
				$tg_inball='-4';
			}else if ($tg_inball==$Score5){
				$mb_inball1='-5';
				$tg_inball1='-5';
				$mb_inball2='-5';
				$tg_inball2='-5';
				$mb_inball3='-5';
				$tg_inball3='-5';
				$mb_inball4='-5';
				$tg_inball4='-5';
				$mb_inball_hr='-5';
				$tg_inball_hr='-5';
				$mb_inball_xb='-5';
				$tg_inball_xb='-5';	
				$mb_inball='-5';
				$tg_inball='-5';
			}else if ($tg_inball==$Score6){
				$mb_inball1='-6';
				$tg_inball1='-6';
				$mb_inball2='-6';
				$tg_inball2='-6';
				$mb_inball3='-6';
				$tg_inball3='-6';
				$mb_inball4='-6';
				$tg_inball4='-6';
				$mb_inball_hr='-6';
				$tg_inball_hr='-6';
				$mb_inball_xb='-6';
				$tg_inball_xb='-6';
				$mb_inball='-6';
				$tg_inball='-6';
			}else if ($tg_inball==$Score7){
				$mb_inball1='-7';
				$tg_inball1='-7';
				$mb_inball2='-7';
				$tg_inball2='-7';
				$mb_inball3='-7';
				$tg_inball3='-7';
				$mb_inball4='-7';
				$tg_inball4='-7';
				$mb_inball_hr='-7';
				$tg_inball_hr='-7';
				$mb_inball_xb='-7';
				$tg_inball_xb='-7';
				$mb_inball='-7';
				$tg_inball='-7';
			}else if ($tg_inball==$Score8){
				$mb_inball1='-8';
				$tg_inball1='-8';
				$mb_inball2='-8';
				$tg_inball2='-8';
				$mb_inball3='-8';
				$tg_inball3='-8';
				$mb_inball4='-8';
				$tg_inball4='-8';
				$mb_inball_hr='-8';
				$tg_inball_hr='-8';
				$mb_inball_xb='-8';
				$tg_inball_xb='-8';
				$mb_inball='-8';
				$tg_inball='-8';
			}else if ($tg_inball==$Score9){
				$mb_inball1='-9';
				$tg_inball1='-9';
				$mb_inball2='-9';
				$tg_inball2='-9';
				$mb_inball3='-9';
				$tg_inball3='-9';
				$mb_inball4='-9';
				$tg_inball4='-9';
				$mb_inball_hr='-9';
				$tg_inball_hr='-9';
				$mb_inball_xb='-9';
				$tg_inball_xb='-9';
				$mb_inball='-9';
				$tg_inball='-9';
			}else if ($tg_inball==$Score10){
				$mb_inball1='-10';
				$tg_inball1='-10';
				$mb_inball2='-10';
				$tg_inball2='-10';
				$mb_inball3='-10';
				$tg_inball3='-10';
				$mb_inball4='-10';
				$tg_inball4='-10';
				$mb_inball_hr='-10';
				$tg_inball_hr='-10';
				$mb_inball_xb='-10';
				$tg_inball_xb='-10';
				$mb_inball='-10';
				$tg_inball='-10';
			}else if ($tg_inball==$Score11){
				$mb_inball1='-11';
				$tg_inball1='-11';
				$mb_inball2='-11';
				$tg_inball2='-11';
				$mb_inball3='-11';
				$tg_inball3='-11';
				$mb_inball4='-11';
				$tg_inball4='-11';
				$mb_inball_hr='-11';
				$tg_inball_hr='-11';
				$mb_inball_xb='-11';
				$tg_inball_xb='-11';
				$mb_inball='-11';
				$tg_inball='-11';
			}else if ($tg_inball==$Score12){
				$mb_inball1='-12';
				$tg_inball1='-12';
				$mb_inball2='-12';
				$tg_inball2='-12';
				$mb_inball3='-12';
				$tg_inball3='-12';
				$mb_inball4='-12';
				$tg_inball4='-12';
				$mb_inball_hr='-12';
				$tg_inball_hr='-12';
				$mb_inball_xb='-12';
				$tg_inball_xb='-12';
				$mb_inball='-12';
				$tg_inball='-12';
			}else if ($tg_inball=='聯賽安稱錯誤'){
				$mb_inball1='-13';
				$tg_inball1='-13';
				$mb_inball2='-13';
				$tg_inball2='-13';
				$mb_inball3='-13';
				$tg_inball3='-13';
				$mb_inball4='-13';
				$tg_inball4='-13';
				$mb_inball_hr='-13';
				$tg_inball_hr='-13';
				$mb_inball_xb='-13';
				$tg_inball_xb='-13';
				$mb_inball='-13';
				$tg_inball='-13';
			}else if ($tg_inball==$Score14){
				$mb_inball1='-14';
				$tg_inball1='-14';
				$mb_inball2='-14';
				$tg_inball2='-14';
				$mb_inball3='-14';
				$tg_inball3='-14';
				$mb_inball4='-14';
				$tg_inball4='-14';
				$mb_inball_hr='-14';
				$tg_inball_hr='-14';
				$mb_inball_xb='-14';
				$tg_inball_xb='-14';
				$mb_inball='-14';
				$tg_inball='-14';
			}else if ($tg_inball==$Score15){
				$mb_inball1='-15';
				$tg_inball1='-15';
				$mb_inball2='-15';
				$tg_inball2='-15';
				$mb_inball3='-15';
				$tg_inball3='-15';
				$mb_inball4='-15';
				$tg_inball4='-15';
				$mb_inball_hr='-15';
				$tg_inball_hr='-15';
				$mb_inball_xb='-15';
				$tg_inball_xb='-15';
				$mb_inball='-15';
				$tg_inball='-15';
			}else if ($tg_inball==$Score16){
				$mb_inball1='-16';
				$tg_inball1='-16';
				$mb_inball2='-16';
				$tg_inball2='-16';
				$mb_inball3='-16';
				$tg_inball3='-16';
				$mb_inball4='-16';
				$tg_inball4='-16';
				$mb_inball_hr='-16';
				$tg_inball_hr='-16';
				$mb_inball_xb='-16';
				$tg_inball_xb='-16';
				$mb_inball='-16';
				$tg_inball='-16';
			}else if ($tg_inball==$Score17){
				$mb_inball1='-17';
				$tg_inball1='-17';
				$mb_inball2='-17';
				$tg_inball2='-17';
				$mb_inball3='-17';
				$tg_inball3='-17';
				$mb_inball4='-17';
				$tg_inball4='-17';
				$mb_inball_hr='-17';
				$tg_inball_hr='-17';
				$mb_inball_xb='-17';
				$tg_inball_xb='-17';
				$mb_inball='-17';
				$tg_inball='-17';
			}else if ($tg_inball==$Score18){
				$mb_inball1='-18';
				$tg_inball1='-18';
				$mb_inball2='-18';
				$tg_inball2='-18';
				$mb_inball3='-18';
				$tg_inball3='-18';
				$mb_inball4='-18';
				$tg_inball4='-18';
				$mb_inball_hr='-18';
				$tg_inball_hr='-18';
				$mb_inball_xb='-18';
				$tg_inball_xb='-18';
				$mb_inball='-18';
				$tg_inball='-18';
			}else if ($tg_inball==$Score19){
				$mb_inball1='-19';
				$tg_inball1='-19';
				$mb_inball2='-19';
				$tg_inball2='-19';
				$mb_inball3='-19';
				$tg_inball3='-19';
				$mb_inball4='-19';
				$tg_inball4='-19';
				$mb_inball_hr='-19';
				$tg_inball_hr='-19';
				$mb_inball_xb='-19';
				$tg_inball_xb='-19';
				$mb_inball='-19';
				$tg_inball='-19';
			}
			if ($tg_inball_hr=='不顯示賽程' or $tg_inball_xb=='不顯示賽程'){
				$mb_inball1=$mb_inball1;
				$tg_inball1=$tg_inball1;
				$mb_inball2=$mb_inball2;
				$tg_inball2=$tg_inball2;
				$mb_inball3=$mb_inball3;
				$tg_inball3=$tg_inball3;
				$mb_inball4=$mb_inball4;
				$tg_inball4=$tg_inball4;
				$mb_inball_hr='-1';
				$tg_inball_hr='-1';
				$mb_inball_xb='-1';
				$tg_inball_xb='-1';
				$mb_inball=$mb_inball;
				$tg_inball=$tg_inball;
			}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~						
            $mb_mid1=$mb_mid+300000;
            $tg_mid1=$tg_mid+300000;
            $sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid1." and M_Date='$list_date'";
            $result = mysql_query( $sql);
            $cou=mysql_num_rows($result);
            $row = mysql_fetch_array($result);
            if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid1." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];
			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball1',TG_Inball='$tg_inball1',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball1!=0 or $tg_inball1!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abc1');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball1',TG_Inball='$tg_inball1',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball1!=0 or $tg_inball1!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abc1');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball1).trim($tg_inball1);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball1',TG_Inball='$tg_inball1',TG_Inball_HR=0,MB_Inball_HR=0,Checked='$check'  where Type='BK' and ($mb_inball1!=0 or $tg_inball1!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc1');
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball1',TG_Inball='$tg_inball1',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball1!=0 or $tg_inball1!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc1');
				}
			}	
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~						
			$mb_mid2=$mb_mid+400000;
            $tg_mid2=$tg_mid+400000;
            $sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid2." and M_Date='$list_date'";
            $result = mysql_query( $sql);
            $cou=mysql_num_rows($result);
            $row = mysql_fetch_array($result);
            if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid2." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];
			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball2',TG_Inball='$tg_inball2',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball2!=0 or $tg_inball2!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query( $mysql) or die('abc2');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball2',TG_Inball='$tg_inball2',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball2!=0 or $tg_inball2!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abc2');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball2).trim($tg_inball2);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball2',TG_Inball='$tg_inball2',TG_Inball_HR=0,MB_Inball_HR=0,Checked='$check'  where Type='BK' and ($mb_inball2!=0 or $tg_inball2!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc2');
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball2',TG_Inball='$tg_inball2',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball2!=0 or $tg_inball2!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc2');
				}
			}
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~								
			$mb_mid3=$mb_mid+500000;
            $tg_mid3=$tg_mid+500000;
            $sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid3." and M_Date='$list_date'";
            $result = mysql_query( $sql);
            $cou=mysql_num_rows($result);
            $row = mysql_fetch_array($result);
            if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid3." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];

			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball3',TG_Inball='$tg_inball3',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball3!=0 or $tg_inball3!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query( $mysql) or die('abc3');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball3',TG_Inball='$tg_inball3',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball3!=0 or $tg_inball3!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abc3');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball3).trim($tg_inball3);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball3',TG_Inball='$tg_inball3',TG_Inball_HR=0,MB_Inball_HR=0,Checked='$check'  where Type='BK' and ($mb_inball3!=0 or $tg_inball3!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc3');
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball3',TG_Inball='$tg_inball3',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball3!=0 or $tg_inball3!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc3');
				}
			}
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~								
            $mb_mid4=$mb_mid+600000;
            $tg_mid4=$tg_mid+600000;
            $sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid4." and M_Date='$list_date'";
            $result = mysql_query( $sql);
            $cou=mysql_num_rows($result);
            $row = mysql_fetch_array($result);
            if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid4." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];

			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball4',TG_Inball='$tg_inball4',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball4!=0 or $tg_inball4!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query( $mysql) or die('abc4');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball4',TG_Inball='$tg_inball4',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball4!=0 or $tg_inball4!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abc4');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball4).trim($tg_inball4);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball4',TG_Inball='$tg_inball4',TG_Inball_HR=0,MB_Inball_HR=0,Checked='$check'  where Type='BK' and ($mb_inball4!=0 or $tg_inball4!=0) and M_Date='$list_date' and MID=".(int)$mid;
				    mysql_query( $mysql) or die('abc4');
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball4',TG_Inball='$tg_inball4',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball4!=0 or $tg_inball4!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abc4');
				}
			}
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	
            $mb_mid5=$mb_mid+800000;
            $tg_mid5=$tg_mid+800000;
            $sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid5." and M_Date='$list_date'";
            $result = mysql_query( $sql);
            $cou=mysql_num_rows($result);
            $row = mysql_fetch_array($result);
            if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid5." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];
			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball_hr',TG_Inball='$tg_inball_hr',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball_hr!=0 or $tg_inball_hr!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query( $mysql) or die('abchr');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball_hr',TG_Inball='$tg_inball_hr',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball_hr!=0 or $tg_inball_hr!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abchr');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball_hr).trim($tg_inball_hr);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball_hr',TG_Inball='$tg_inball_hr',TG_Inball_HR=0,MB_Inball_HR=0,Checked='$check'  where Type='BK' and ($mb_inball_hr!=0 or $tg_inball_hr!=0) and M_Date='$list_date' and MID=".(int)$mid;
				    mysql_query( $mysql) or die('abchr');
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball_hr',TG_Inball='$tg_inball_hr',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball_hr!=0 or $tg_inball_hr!=0) and M_Date='$list_date' and MID=".(int)$mid;
					mysql_query( $mysql) or die('abchr');
				}
			}
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	
            $mb_mid6=$mb_mid+900000;
            $tg_mid6=$tg_mid+900000;
            $sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid6." and M_Date='$list_date'";
            $result = mysql_query( $sql);
            $cou=mysql_num_rows($result);
            $row = mysql_fetch_array($result);
            if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid6." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];
			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball_xb',TG_Inball='$tg_inball_xb',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball_xb!=0 or $tg_inball_xb!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query( $mysql) or die('abcxb');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball_xb',TG_Inball='$tg_inball_xb',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball_xb!=0 or $tg_inball_xb!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abcxb');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball_xb).trim($tg_inball_xb);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball_xb',TG_Inball='$tg_inball_xb',TG_Inball_HR=0,MB_Inball_HR=0,Checked='$check'  where Type='BK' and ($mb_inball_xb!=0 or $tg_inball_xb!=0) and M_Date='$list_date' and MID=".(int)$mid;
				    mysql_query( $mysql) or die('abcxb');
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball_xb',TG_Inball='$tg_inball_xb',TG_Inball_HR=0,MB_Inball_HR=0 where Type='BK' and ($mb_inball_xb!=0 or $tg_inball_xb!=0) and M_Date='$list_date' and MID=".(int)$mid;
				    mysql_query( $mysql) or die('abcxb');
				}
			}
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~				
			$sql="select MID,MB_Inball from match_sports where Type='BK' and TG_MID=".(int)$mb_mid." and M_Date='$list_date'";
			$result = mysql_query( $sql);
			$cou=mysql_num_rows($result);
			$row = mysql_fetch_array($result);
			if ($cou==0){
                $sql="select MID,MB_Inball from match_sports where Type='BK' and MB_MID=".(int)$mb_mid." and M_Date='$list_date'";
                $result = mysql_query( $sql);
                $row = mysql_fetch_array($result);
            }
            $mid=$row['MID'];
			if ($row['MB_Inball']==""){
                $mysql="update match_sports set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr' where Type='BK' and ($mb_inball!=0 or $tg_inball!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query( $mysql) or die('abc');
			}else if ($row['MB_Inball']<0){
                $mysql="update match_sports set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='BK' and ($mb_inball!=0 or $tg_inball!=0) and M_Date='$list_date' and MID=".(int)$mid;
				mysql_query($mysql) or die('abc');
			}else{
				$a_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='BK' and MID='".(int)$mid."' and M_Date='$list_date'";
				$a_result = mysql_query($a_sql);
				$a_row = mysql_fetch_array($a_result);
				$a=	$a_row['MB_Inball'].$a_row['TG_Inball'];
				$b=	trim($mb_inball).trim($tg_inball);
				if ($a!=$b){
				    $check=1;
				    $mysql="update match_sports set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Checked='$check'  where Type='BK' and ($mb_inball!=0 or $tg_inball!=0) and M_Date='$list_date' and MID=".(int)$mid;
				    mysql_query( $mysql) or die('abc');				
				}else{
				    $mysql="update match_sports set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr' where Type='BK' and ($mb_inball!=0 or $tg_inball!=0) and M_Date='$list_date' and MID=".(int)$mid;
				    mysql_query( $mysql) or die('abc');
				}
			}
            $m=$m+1;
            }

        }

}

echo '<br>目前比分以结算出'.$m;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>篮球接比分</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
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
                curtime=curmin+"秒后自动本页获取最新数据！"
        else
                curtime=cursec+"秒后自动本页获取最新数据！"
                timeinfo.innerText=curtime
                setTimeout("beginrefresh()",1000)
        }
}

window.onload=beginrefresh
file://-->
</script>
<body>
<table width="100" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="70" align="center"><br><?=$list_date?><br><br><span id="timeinfo"></span><br>
      <input type=button name=button value="篮球更新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
