<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");

$uid=$_REQUEST["uid"]; 
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$gtype=$_REQUEST['gtype'];//项目
$ptype=$_REQUEST['ptype'];//类型
include ("../include/online.php");

$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
    $web='web_agents_data';
}
$mysql = "select ID,UserName from $web where Oid='$uid' and LoginName='$loginname' and Status<2";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
?>
<html>
<head>
<title>Football_Control</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
var gtype = '<?=$gtype?>';
</script>
<script>
/**
 * 選擇多盤口時 轉換成該選擇賠率
 * @param odd_type 	選擇盤口
 * @param iorH		主賠率
 * @param iorC		客賠率
 * @param show		顯示位數
 * @return		回傳陣列 0-->H  ,1-->C
 */
function  get_other_ioratio(odd_type, iorH, iorC , showior){
	var out=new Array();
	if(iorH!="" ||iorC!=""){
		out =chg_ior(odd_type,iorH,iorC,showior);
	}else{
		out[0]=iorH;
		out[1]=iorC;
	}
	return out;
}
/**
 * 轉換賠率
 * @param odd_f
 * @param H_ratio
 * @param C_ratio
 * @param showior
 * @return
 */
function chg_ior(odd_f,iorH,iorC,showior){
	var ior=new Array();
	if(iorH < 3) iorH *=1000;
	if(iorC < 3) iorC *=1000;
	iorH=parseFloat(iorH);
	iorC=parseFloat(iorC);
	switch(odd_f){
	case "H":	//香港變盤(輸水盤)
		ior = get_HK_ior(iorH,iorC);
		break;
	case "M":	//馬來盤
		ior = get_MA_ior(iorH,iorC);
		break;
	case "I" :	//印尼盤
		ior = get_IND_ior(iorH,iorC);
		break;
	case "E":	//歐洲盤
		ior = get_EU_ior(iorH,iorC);
		break;
	default:	//香港盤
		ior[0]=iorH ;
		ior[1]=iorC ;
	}
	ior[0]/=1000;
	ior[1]/=1000;
	
	ior[0]=printf(Decimal_point(ior[0],showior),iorpoints);
	ior[1]=printf(Decimal_point(ior[1],showior),iorpoints);
	//alert("odd_f="+odd_f+",iorH="+iorH+",iorC="+iorC+",ouH="+ior[0]+",ouC="+ior[1]);
	return ior;
}
 
/**
 * 換算成輸水盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_HK_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	var line,lowRatio,nowRatio,highRatio;
	var nowType="";
	if (H_ratio <= 1000 && C_ratio <= 1000){
		out_ior[0]=H_ratio;
		out_ior[1]=C_ratio;
		return out_ior;
	}
	line=2000 - ( H_ratio + C_ratio );
	if (H_ratio > C_ratio){ 
		lowRatio=C_ratio;
		nowType = "C";
	}else{
		lowRatio = H_ratio;
		nowType = "H";
	}
	if (((2000 - line) - lowRatio) > 1000){
		//對盤馬來盤
		nowRatio = (lowRatio + line) * (-1);
	}else{
		//對盤香港盤
		nowRatio=(2000 - line) - lowRatio;	
	}
	if (nowRatio < 0){
		highRatio = Math.floor(Math.abs(1000 / nowRatio) * 1000) ;
	}else{
		highRatio = (2000 - line - nowRatio) ;
	}
	if (nowType == "H"){
		out_ior[0]=lowRatio;
		out_ior[1]=highRatio;
	}else{
		out_ior[0]=highRatio;
		out_ior[1]=lowRatio;
	}
	return out_ior;
}
/**
 * 換算成馬來盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_MA_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	var line,lowRatio,highRatio;
	var nowType="";
	if ((H_ratio <= 1000 && C_ratio <= 1000)){
		out_ior[0]=H_ratio;
		out_ior[1]=C_ratio;
		return out_ior;
	}
	line=2000 - ( H_ratio + C_ratio );
	if (H_ratio > C_ratio){ 
		lowRatio = C_ratio;
		nowType = "C";
	}else{
		lowRatio = H_ratio;
		nowType = "H";
	}
	highRatio = (lowRatio + line) * (-1);
	if (nowType == "H"){
		out_ior[0]=lowRatio;
		out_ior[1]=highRatio;
	}else{
		out_ior[0]=highRatio;
		out_ior[1]=lowRatio;
	}
	return out_ior;
}
/**
 * 換算成印尼盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_IND_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	out_ior = get_HK_ior(H_ratio,C_ratio);
	H_ratio=out_ior[0];
	C_ratio=out_ior[1];
	H_ratio /= 1000;
	C_ratio /= 1000;
	if(H_ratio < 1){
		H_ratio=(-1) / H_ratio;
	}
	if(C_ratio < 1){
		C_ratio=(-1) / C_ratio;
	}
	out_ior[0]=H_ratio*1000;
	out_ior[1]=C_ratio*1000;
	return out_ior;
}
/**
 * 換算成歐洲盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_EU_ior(H_ratio, C_ratio){
	var out_ior=new Array();
	out_ior = get_HK_ior(H_ratio,C_ratio);
	H_ratio=out_ior[0];
	C_ratio=out_ior[1];       
	out_ior[0]=H_ratio+1000;
	out_ior[1]=C_ratio+1000;
	return out_ior;
}
/*
去正負號做小數第幾位捨去
進來的值是小數值
*/
function Decimal_point(tmpior,show){
	var sign="";
	sign =((tmpior < 0)?"Y":"N");
	tmpior = (Math.floor(Math.abs(tmpior) * show + 1 / show )) / show;
	return (tmpior * ((sign =="Y")? -1:1)) ;
}
 
 
/*
 公用 FUNC
*/
function printf(vals,points){ //小數點位數
	vals=""+vals;
	var cmd=new Array();
	cmd=vals.split(".");
	if (cmd.length>1){
		for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
	}else{
		vals=vals+".";
		for (ii=0;ii<points;ii++)vals=vals+"0";
	}
	return vals;
}</script>
<script>
var gdate = "";
var totaldata = "";
var GameTimerID = "";
var set_account = 0;
//告知 clien 需重整畫面
function ReloadTimerStart(Timer,msg) {
	body_browse.document.getElementById("ltype").value = ltype;
	body_browse.document.getElementById("set_account").value = set_account;
	if (body_browse.document.getElementById("sel_lid") != null) {
		body_browse.document.getElementById("sel_lid").value = sel_league;
	}
	if (body_browse.document.getElementById("gdate") != null) {
		body_browse.document.getElementById("gdate").value = gdate;
	}
	ShowGameList();
	if(GameTimerID)	clearInterval(GameTimerID);
	GameTimerID = setInterval("ReloadMsg('"+msg+"')",Timer*1000);
}
function ReloadMsg(msg){
	if(GameTimerID)	clearInterval(GameTimerID);
	alert(msg);
}
 
//分頁
function show_page(){
	var temp = "";
	var pg_str = "";
	bodyP = body_browse.document.getElementById("bodyP");
	pg_txt = body_browse.document.getElementById("pg_txt");
	if (sel_league == "") {
		for (var i = 0; i < t_page; i++) {
			if (pg != i) {
				pg_str = pg_str+"<a href=# onclick='chg_pg("+i+");'><font color='#000099'>"+(i+1)+"</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
			}else{
				pg_str = pg_str+"<B><font color='#FF0000'>"+(i+1)+"</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		txt_bodyP = bodyP.innerHTML;
		txt_bodyP = txt_bodyP.replace("*SHOW_P*",pg_str);
	 	pg_txt.innerHTML = txt_bodyP;
	} else { pg_txt.innerHTML = ""; }
}
 
// 選擇聯盟
function ShowLeague(lid) {
	bowling_data = "";
	var temp = "";
	var temparray = new Array();
	bowling = body_browse.document.getElementById("bowling");
	bodyH = body_browse.document.getElementById("bodyH");
	show_h = body_browse.document.getElementById("show_h");
	var tempbowling = bowling.innerHTML;
	txt_bodyH = bodyH.innerHTML;
	if (totaldata != "") {
		bowling_data = totaldata.split(",");
		for (i = 1; i < bowling_data.length; i++) {
			temparray = bowling_data[i].split("*");
			txt_bowling = tempbowling.replace("*LEAGUE_ID*",temparray[0]);
			if(lid == temparray[0]) txt_bowling = txt_bowling.replace("*SELECT*","SELECTED");
			else                    txt_bowling = txt_bowling.replace("*SELECT*","");
			txt_bowling = txt_bowling.replace("*LEAGUE_NAME*",temparray[1]);
			temp += txt_bowling;
		}
		txt_bodyH = txt_bodyH.replace("*SHOW_H*",temp);
  	}else{
	  	txt_bodyH = txt_bodyH.replace("*SHOW_H*","");
  	}
  	show_h.innerHTML = txt_bodyH;
}
 
//判斷目前應顯示頁面並顯示
function ShowGameList() {
	if(loading == "Y") return;
	body_browse.document.getElementById("LoadLayer").style.display = "none";
	ltype_obj = body_browse.document.getElementById("ltype");
	ltype_obj.value  = ltype;
	dt_obj = body_browse.document.getElementById("dt_now");
	dt_obj.innerText = "--"+gmt_str+":"+dt_now;
	show_table = body_browse.document.getElementById("glist_table");
	switch(ShowType) {
		case "S":	//單式
			ShowData_S(show_table,GameFT,gamount);
			break;
		case "H":	//上半場
			ShowData_H(show_table,GameFT,gamount);
			break;
		case "RB":	//走地
			ShowData_RB(show_table,GameFT,gamount);
			break;
		case "PD":	//波膽
			ShowData_PD(show_table,GameFT,gamount);
			break;
		case "HPD":	//波膽
			ShowData_HPD(show_table,GameFT,gamount);
			break;
		case "T":	//總入球
			ShowData_T(show_table,GameFT,gamount);
			break;
		case "F":	//半全場
			ShowData_F(show_table,GameFT,gamount);
			break;
		case "P":	//過關
			ShowData_P(show_table,GameFT,gamount);
			break;
		case "PL":	//已開賽
			ShowData_PL(show_table,GameFT,gamount);
			break;
	}
}
 
//顯示單式畫面資料
function ShowData_S(obj_table,GameData,data_amount){
	var R_ior =Array();
	var OU_ior =Array();
	
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i = 0; i < data_amount; i++) {
			R_ior  = get_other_ioratio(odd_f_type, GameData[i][11], GameData[i][12] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][18], GameData[i][19] , show_ior);
			
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			nowTR = insertRow();
			if (GameData[i][8] == "Y") {
				nowTR.className = "m_cen_top";
			}else{
				nowTR.className = "m_cen_top_close";
			}
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball",top.str_RB);
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = "<BR>"+GameData[i][2];
				//場次
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][3]+"<BR>"+GameData[i][4];
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
				//獨贏/注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"30%\" align=\"left\">'+GameData[i][24]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=MH&wtype=M\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][25]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=MC&wtype=M\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][28]+'/'+GameData[i][31]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][26]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=MN&wtype=M\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][29]+'/'+GameData[i][32]+'</font></a></td></tr></table>';
				//讓球/注單
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
					'<tr align=\"right\">';
				//開始寫入賠率
				if (GameData[i][7] == "H") {	//強隊是主隊
					ratio_h = GameData[i][9];
					ratio_c = "&nbsp";
					ioratio_h = R_ior[0];
					ioratio_c = R_ior[1];
				} else {	//強隊是客隊
					ratio_h = "&nbsp";
					ratio_c = GameData[i][10];
					ioratio_h = R_ior[0];
					ioratio_c = R_ior[1];
				}
				tmpStr += '<td width=\"52%\">'+ratio_h+'&nbsp'+ioratio_h+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RH&wtype=R\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
					'<tr align=\"right\">'+
					'<td>'+ratio_c+'&nbsp'+ioratio_c+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RC&wtype=R\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
				tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
				nowTD.innerHTML = tmpStr;
				//上下盤/注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"52%\">'+GameData[i][17]+'&nbsp'+OU_ior[1]+'<BR>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=OUH&wtype=OU\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></a></td></tr>'+
						'<tr align=\"right\"><td>'+OU_ior[0]+'<BR>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=OUC&wtype=OU\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></a></td></tr>'+
	 					'<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
				//單雙/注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"30%\" align=\"left\">'+GameData[i][33]+'&nbsp;'+GameData[i][35]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=ODD&wtype=EO\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][37]+'/'+GameData[i][39]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][34]+'&nbsp;'+GameData[i][36]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=EVEN&wtype=EO\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][38]+'/'+GameData[i][40]+'</font></a></td></tr></table>';
			}//with(TR)
		}
	}//with(obj_table);
}
 
//顯示上半場畫面資料
function ShowData_H(obj_table,GameData,data_amount){
	var HR_ior =Array();
	var HOU_ior =Array();
		
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i = 0; i < data_amount; i++) {
			HR_ior = get_other_ioratio(odd_f_type, GameData[i][11], GameData[i][12] , show_ior);
			HOU_ior= get_other_ioratio(odd_f_type, GameData[i][18], GameData[i][19] , show_ior);
			
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			nowTR = insertRow();
			if (GameData[i][8] == "Y") {
				nowTR.className = "m_cen_top";
			}else{
				nowTR.className = "m_cen_top_close";
			}
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball",top.str_RB);
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = "<BR>"+GameData[i][2];
				//場次
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][3]+"<BR>"+GameData[i][4];
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
				//獨贏/注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"30%\" align=\"left\">'+GameData[i][24]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VMH&wtype=VM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][25]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VMC&wtype=VM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][28]+'/'+GameData[i][31]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][26]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VMN&wtype=VM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][29]+'/'+GameData[i][32]+'</font></a></td></tr></table>';
				//讓球/注單
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
					'<tr align=\"right\">';
				//開始寫入賠率
				if (GameData[i][7] == "H") {	//強隊是主隊
					ratio_h = GameData[i][9];
					ratio_c = "&nbsp";
					ioratio_h = HR_ior[0];
					ioratio_c = HR_ior[1];
				} else {	//強隊是客隊
					ratio_h = "&nbsp";
					ratio_c = GameData[i][10];
					ioratio_h = HR_ior[0];
					ioratio_c = HR_ior[1];
				}
				tmpStr += '<td width=\"52%\">'+ratio_h+'&nbsp'+ioratio_h+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VRH&wtype=VR\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
					'<tr align=\"right\">'+
					'<td>'+ratio_c+'&nbsp'+ioratio_c+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VRC&wtype=VR\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
				tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
				nowTD.innerHTML = tmpStr;
				//上下盤/注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"52%\">'+GameData[i][17]+'&nbsp'+HOU_ior[1]+'<BR>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VOUH&wtype=VOU\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></a></td></tr>'+
						'<tr align=\"right\"><td>'+HOU_ior[0]+'<BR>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=VOUC&wtype=VOU\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></a></td></tr>'+
	 					'<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
			}//with(TR)
		}
	}//with(obj_table);
}
 
//顯示走地畫面資料
function ShowData_RB(obj_table,GameData,data_amount){
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	
	winset = "";
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i = 0; i < data_amount; i++) {
			R_ior  = get_other_ioratio(odd_f_type, GameData[i][11], GameData[i][12] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][18], GameData[i][19] , show_ior);
			HR_ior = get_other_ioratio(odd_f_type, GameData[i][30], GameData[i][31] , show_ior);
			HOU_ior= get_other_ioratio(odd_f_type, GameData[i][37], GameData[i][38] , show_ior);
			
			var game_wager = GameData[i][13]*1+GameData[i][14]*1+GameData[i][20]*1+GameData[i][21]*1+GameData[i][32]*1+
			                 GameData[i][33]*1+GameData[i][39]*1+GameData[i][40]*1+GameData[i][46]*1+GameData[i][48]*1+
			                 GameData[i][50]*1+GameData[i][55]*1+GameData[i][57]*1+GameData[i][59]*1;
			if (game_wager == 0){
				continue;
			}
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			nowTR = insertRow();
			if (GameData[i][8] == "Y") {
				nowTR.className = "m_cen_top";
			}else{
				nowTR.className = "m_cen_top_close";
			}
 
			with(nowTR) {
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = "<BR>"+GameData[i][2];
				//場次
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][3]+"<BR>"+GameData[i][4];
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = '<font style=\"background-color:#FFFF00\">'+GameData[i][5]+"&nbsp;&nbsp;"+GameData[i][24]+'<BR>'+GameData[i][6]+"&nbsp;&nbsp;"+GameData[i][25]+'&nbsp;&nbsp;</font><div align=right><font color=\"#009900\">'+draw+'</font></div>';
 
				// 全場獨贏 / 注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"30%\" align=\"left\">'+GameData[i][43]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RMH&wtype=RM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][46]+'/'+GameData[i][47]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][44]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RMC&wtype=RM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][48]+'/'+GameData[i][49]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][45]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RMN&wtype=RM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][50]+'/'+GameData[i][51]+'</font></a></td></tr></table>';
				//讓球/注單
				R_rtype = "RE";
				OU_rtype = "ROU";
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
					'<tr align=\"right\">';
				//開始寫入賠率
				if (GameData[i][7] == "H") {	//強隊是主隊
					ratio_h = GameData[i][9];
					ratio_c = "&nbsp";
					ioratio_h = R_ior[0];
					ioratio_c = R_ior[1];
				} else {	//強隊是客隊
					ratio_h = "&nbsp";
					ratio_c = GameData[i][10];
					ioratio_h = R_ior[0];
					ioratio_c = R_ior[1];
				}
 
				tmpStr += '<td width=\"62%\">'+ratio_h+'&nbsp'+ioratio_h+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RRH&wtype='+R_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
					'<tr align=\"right\">'+
					'<td>'+ratio_c+'&nbsp'+ioratio_c+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RRC&wtype='+R_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
				tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
				nowTD.innerHTML = tmpStr;
				//上下盤/注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"62%\">'+GameData[i][17]+'&nbsp'+OU_ior[1]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=ROUH&wtype='+OU_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></a></td></tr>'+
						'<tr align=\"right\"><td>&nbsp'+OU_ior[0]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=ROUC&wtype='+OU_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></a></td></tr>'+
	 					'<tr><td colspan=\"2\">&nbsp;</td></tr></table>';
				// 半場獨贏 / 注單
				nowTD = insertCell();
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"30%\" align=\"left\">'+GameData[i][52]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VRMH&wtype=VRM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][55]+'/'+GameData[i][56]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][53]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VRMC&wtype=VRM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][57]+'/'+GameData[i][58]+'</font></a></td></tr>'+
						'<tr align=\"right\">'+
						'<td align=\"left\">'+GameData[i][54]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VRMN&wtype=VRM\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][59]+'/'+GameData[i][60]+'</font></a></td></tr></table>';
				//上半讓球/注單
				R_rtype="VRE";
				OU_rtype="VROU";
				nowTD = insertCell();
				nowTD.className = 'm_cen_top_one';
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
					'<tr align=\"right\">';
				//開始寫入賠率
				if(GameData[i][27] == "H") {	//強隊是主隊
					ratio_h = GameData[i][28];
					ratio_c = "&nbsp";
					ioratio_h = HR_ior[0];
					ioratio_c = HR_ior[1];
				} else {	//強隊是客隊
					ratio_h = "&nbsp";
					ratio_c = GameData[i][29];
					ioratio_h = HR_ior[0];
					ioratio_c = HR_ior[1];
				}
				// 半場讓球 / 注單
				tmpStr += '<td width=\"62%\">'+ratio_h+'&nbsp'+ioratio_h+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VRRH&wtype='+R_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][32]+'/'+GameData[i][34]+'</font></a></td></tr>'+
					'<tr align=\"right\">'+
					'<td>'+ratio_c+'&nbsp'+ioratio_c+'</td>'+
					'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VRRC&wtype='+R_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][33]+'/'+GameData[i][35]+'</font></a></td></tr>';
				tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
				nowTD.innerHTML = tmpStr;
 
				//上下盤/注單
				nowTD = insertCell();
				nowTD.className = 'm_cen_top_one';
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"62%\">'+GameData[i][36]+'&nbsp'+HOU_ior[1]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VROUH&wtype='+OU_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][40]+'/'+GameData[i][42]+'</font></a></td></tr>'+
						'<tr align=\"right\"><td>&nbsp'+HOU_ior[0]+'<BR></td>'+
						'<td><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][26]+'&type=VROUC&wtype='+OU_rtype+'\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][39]+'/'+GameData[i][41]+'</font></a></td></tr>'+
						'<tr><td colspan=\"2\">&nbsp;</td></tr></table>';
			}//with(TR)
		}
	}//with(obj_table);
}
 
//顯示波膽畫面資料
function ShowData_PD(obj_table,GameData,data_amount,show_type) {
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		flag = 0;
		for(i = 0; i < data_amount; i++) {
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			if(GameData[i][8] == "Y") {
				tr_class = "m_cen";
				input_class = "za_text_pd";
			} else {
				tr_class = "m_cen_close";
				input_class = "za_text_pd_close";
			}
			nowTR = insertRow();
			nowTR.className = tr_class;
			//主隊波膽資料顯示
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][2];
				//隊伍
				nowTD = insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
 
				nowTD = insertCell();
				nowTD.align = "right";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=PD\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][10]+'</font></a>';
			}//with(TR)主隊
		}
	}//with(obj_table);
}
 
//顯示上半波膽畫面資料
function ShowData_HPD(obj_table,GameData,data_amount,show_type) {
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		flag = 0;
		for(i = 0; i < data_amount; i++) {
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			if(GameData[i][8] == "Y") {
				tr_class = "m_cen";
				input_class = "za_text_pd";
			} else {
				tr_class = "m_cen_close";
				input_class = "za_text_pd_close";
			}
			nowTR = insertRow();
			nowTR.className = tr_class;
			//主隊波膽資料顯示
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][2];
				//隊伍
				nowTD = insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
 
				nowTD = insertCell();
				nowTD.align = "right";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=VPD\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][10]+'</font></a>';
			}//with(TR)主隊
		}
	}//with(obj_table);
}
 
//顯示波膽畫面資料
function ShowData_F(obj_table,GameData,data_amount,show_type) {
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		flag = 0;
		for(i = 0; i < data_amount; i++) {
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			if(GameData[i][8] == "Y") {
				tr_class = "m_cen";
				input_class = "za_text_pd";
			} else {
				tr_class = "m_cen_close";
				input_class = "za_text_pd_close";
			}
			nowTR = insertRow();
			nowTR.className = tr_class;
			//主隊波膽資料顯示
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][2];
				//隊伍
				nowTD = insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
 
				nowTD = insertCell();
				nowTD.align = "right";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=F\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][10]+'</font></a>';
			}//with(TR)主隊
		}
	}//with(obj_table);
}
 
//顯示總入球畫面資料
function ShowData_T(obj_table,GameData,data_amount,show_type) {
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i = 0; i < data_amount; i++) {
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			nowTR = insertRow();
			if (GameData[i][8] == "Y") {
				nowTR.className = "m_cen_top";
			}else{
				nowTR.className = "m_cen_top_close";
			}
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間
				nowTD = insertCell();
				nowTD.align = "center";
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][2];
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+"<BR>"+GameData[i][6];
				/*//單數賠率
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][9]+'<BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=ODD&wtype=T\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][10]+'/'+GameData[i][11]+'</font></a></td>';
				//雙數賠率
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][12]+'<BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=EVEN&wtype=T\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][13]+'/'+GameData[i][14]+'</font></a></td>';*/
				//0~1賠率
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][15]+'<BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=0~1&wtype=T\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][16]+'/'+GameData[i][17]+'</font></a></td>';
				//2~3賠率
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][18]+'<BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=2~3&wtype=T\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][19]+'/'+GameData[i][20]+'</font></a></td>';
				//4~6賠率
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][21]+'<BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=4~6&wtype=T\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][22]+'/'+GameData[i][23]+'</font></a></td>';
				//7up賠率
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][24]+'<BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=OVER&wtype=T\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][25]+'/'+GameData[i][26]+'</font></a></td>';
			}//with(TR)
		}
	}//with(obj_table);
}
 
//顯示過關畫面資料
function ShowData_P(obj_table,GameData,data_amount,show_type) {
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i = 0; i < data_amount; i++) {
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			nowTR = insertRow();
			if (GameData[i][8] == "Y") {
				nowTR.className = "m_cen";
			}else{
				nowTR.className = "m_cen_close";
			}
			with(nowTR) {
                //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][2];
				//場次
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][3]+"<BR>"+GameData[i][4];
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+"<BR>"+GameData[i][6];
				//過關注單數量/金額
				nowTD = insertCell();
				nowTD.align = "right";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=MH&wtype=P\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][12]+'</font></a><BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=MC&wtype=P\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][10]+'/'+GameData[i][13]+'</font></a><BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=MN&wtype=P\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][11]+'/'+GameData[i][14]+'</font></a>';
				//總合過關注單數量/金額
				nowTD = insertCell();
				nowTD.align = "right";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=P3\" target=\"_blank\"><font color=\"#CC0000\">'+GameData[i][15]+'/'+GameData[i][16]+'</font></a><BR>';
			}//with(TR)
		}
	}//with(obj_table);
}
 
//顯示已開賽畫面資料
function ShowData_PL(obj_table,GameData,data_amount) {
	with(obj_table) {
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i = 0; i < data_amount; i++) {
			if(GameData[i][55] == "N") {
				tr_class = "m_cen";
				input_class = "za_text_pd";
			} else {
				tr_class = "m_cen_close";
				input_class = "za_text_pd_close";
			}
			if (leg_name != "" && leg_name != GameData[i][2]) continue;
			nowTR = insertRow();
			nowTR.align = "right";
			nowTR.className = tr_class;
			with(nowTR) {
				//滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball",top.str_RB);
				//日期時間
				nowTD = insertCell();
				nowTD.align = "center";
				nowTD.innerHTML = GameData[i][1];
				//聯盟
				nowTD = insertCell();
				nowTD.align = "center";
				nowTD.innerHTML = GameData[i][2];
				//場次
				nowTD = insertCell();
				nowTD.align = "center";
				nowTD.innerHTML = GameData[i][3]+"<BR>"+GameData[i][4];
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#006600\">'+draw+'</font></div>';
 
				//讓球/注單
				nowTD = insertCell();
				nowTD.vAlign = "top";
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right>';
				//開始寫入賠率
				if (GameData[i][7] == "H") {	//強隊是主隊
					ratio_RH = GameData[i][9];
					ratio_RC = "&nbsp";
				} else {	//強隊是客隊
					ratio_RH = "&nbsp";
					ratio_RC = GameData[i][10];
				}
				nowTD.innerHTML = '<table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right><td width=\"50\"><font color=#0000bb>'+ratio_RH+'</font>&nbsp;</td>'+
						'<td width=\"30\">'+GameData[i][11]+'&nbsp;</td>'+
						'<td ><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RH&wtype=R\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
						'<tr align=right><td width=\"50\"><font color=#0000bb>'+ratio_RC+'</font>&nbsp;</td>'+
						'<td width=\"30\">'+GameData[i][12]+'&nbsp;</td>'+
						'<td ><a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RC&wtype=R\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td>'+
						'</tr></table></td>';
				//上下盤/注單
				nowTD = insertCell();
				nowTD.vAlign = "top";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=OUH&wtype=OU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></a><BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=OUC&wtype=OU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][22]+'/'+GameData[i][24]+'</font></a>';
				//走地
				nowTD = insertCell();
				nowTD.vAlign = "top";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RRH&wtype=RE\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][17]+'/'+GameData[i][19]+'</font></a><BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=RRC&wtype=RE\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][18]+'/'+GameData[i][20]+'</font></a>';
 
				//走地大小/注單
				nowTD = insertCell();
				nowTD.vAlign = "top";
				nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=ROUH&wtype=ROU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][51]+'/'+GameData[i][53]+'</font></a><BR>'+
						'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=ROUC&wtype=ROU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[i][52]+'/'+GameData[i][54]+'</font></a>';
				//功能
				nowTD = insertCell();
				nowTD.align = "center";
				nowTD.innerHTML = '<A href=\"javascript:\" onClick=\"show_detail(\''+GameData[i][0]+'\');\">'+'more...'+'</a>' ;
			}//with(TR)
		}
	}//with(obj_table);
}
 
function ShowData_PL_DETAIL(obj_table,GameData){
	with(obj_table){
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
 
		nowTR = insertRow();
		nowTR.align = "right";
		(GameData[86]=='Y')?nowTR.bgColor = '#CCCCCC':nowTR.bgColor = '#FFFFFF';
 
		with(nowTR){
			//獨贏/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&type=H&wtype=M\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[32]+'/'+GameData[35]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&type=C&wtype=M\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[33]+'/'+GameData[36]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&type=N&wtype=M\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[34]+'/'+GameData[37]+'</font></a>';
				//滾球獨贏/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&type=H&wtype=RM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[99]+'/'+GameData[102]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&type=C&wtype=RM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[100]+'/'+GameData[103]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&type=N&wtype=RM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[101]+'/'+GameData[104]+'</font></a>';
			//波膽/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&wtype=PD&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[38]+'/'+GameData[39]+'</font></a>';
 
			//波膽/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&wtype=HPD&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[95]+'/'+GameData[96]+'</font></a>';
			//單雙/注單
			wargeEO = eval(GameData[40] + '+' + GameData[42]); //單雙注單加總
			goldEO = eval(GameData[41] + '+' + GameData[43]);
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&wtype=T&rtype=EO&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+wargeEO+'/'+goldEO+'</font></a>';
			//總入球/注單
			warge_A = eval(GameData[44] + '+' + GameData[46] + '+' + GameData[48] + '+' + GameData[50]);
			gold_A= eval(GameData[45] + '+' + GameData[47] + '+' + GameData[49] + '+' + GameData[51]);
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&wtype=T&rtype=T&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+warge_A+'/'+gold_A+'</font></a>';
			//半全場/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&wtype=F&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[65]+'/'+GameData[66]+'</font></a>';
			//過關/注單
			warge_RP = eval(GameData[52] + '+' + GameData[53] + '+' + GameData[54]); //主客隊注單加總
			gold_RP = eval(GameData[55] + '+' + GameData[56] + '+' + GameData[57]);
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&wtype=P&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+warge_RP+'/'+gold_RP+'</font></a>';
			//總合過關/注單
 
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[0]+'&wtype=P3&st=1\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[97]+'/'+GameData[98]+'</font></a>';
 
			//半場滾球讓球
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=H&wtype=HRE\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[87]+'/'+GameData[89]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=C&wtype=HRE\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[88]+'/'+GameData[90]+'</font></a>';
 
			//半場滾球大小
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=C&wtype=HROU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[91]+'/'+GameData[93]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=H&wtype=HROU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[92]+'/'+GameData[94]+'</font></a>';
			//半場滾球獨贏/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=H&wtype=HRM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[105]+'/'+GameData[108]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=C&wtype=HRM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[106]+'/'+GameData[109]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=N&wtype=HRM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[107]+'/'+GameData[110]+'</font></a>';
			//半場讓球
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=H&wtype=HR\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[67]+'/'+GameData[69]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=C&wtype=HR\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[68]+'/'+GameData[70]+'</font></a>';
			//半場上下盤/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=C&wtype=HOU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[71]+'/'+GameData[73]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=H&wtype=HOU\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[72]+'/'+GameData[74]+'</font></a>';
 
			//半場獨贏/注單
			nowTD = insertCell();
			nowTD.vAlign = "top";
			nowTD.innerHTML = '<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=H&wtype=HM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[75]+'/'+GameData[78]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=C&wtype=HM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[76]+'/'+GameData[79]+'</font></a><BR>'+
					'<a href=\"list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[81]+'&type=N&wtype=HM\" target=\"_blank\"><font color=\"#FF0000\">'+GameData[77]+'/'+GameData[80]+'</font></a>';
		}//with(TR)
	}//with(obj_table);
}</script>
<SCRIPT LANGUAGE="JAVASCRIPT"> 
<!--
if(self == top) location='/app/control/agents/';
var uid='<?=$uid?>';        //user's session ID
var loading = 'Y';              //是否正在讀取瀏覽頁面
var stype_var = '';             //目前讀取變數值頁面
var ShowType = '';              //目前顯示頁面
var ltype = 1;                  //目前顯示line
var spage = '';                 //目前顯示頁面
var dt_now = '';                //目前日期時間
var aid='';
//多語系用參數
var gmt_str = '美東時間';
var draw = '和局';
var sel_league='';
var t_page = "";
var retime = -1;
var gamount = 0;                //目前顯示賽程數
var GameFT = new Array(1024);   //最多設定顯示1024筆賽程
for(var i=0; i<1024; i++){
	GameFT[i] = new Array(37);  //為各賽程宣告 37 個欄位
}
var show_ior=1000;//顯示位數
var iorpoints=3;
var odd_f_type ="H";
//-->
</SCRIPT>
</head>
 
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
	<frame name="body_var" scrolling="NO" noresize src="real_wagers_var.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&ptype=<?=$ptype?>">
	<frame name="body_browse" src="real_wagers.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&ptype=<?=$ptype?>">
<frame src="UntitledFrame-9"></frameset>
<noframes><body bgcolor="#000000">
 
</body></noframes>
</html>

