<?
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$rtype=ltrim(strtolower($_REQUEST['rtype']));
$league_id=$_REQUEST['league_id'];
$showtype=$_REQUEST['showtype'];
require ("../include/traditional.$langx.inc.php");

if ($rtype==""){
	$rtype="r";
}
$sql = "select UserName,Status from web_member_data where Oid='$uid' and Status<2";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$Status=$row['Status'];
if ($Status==1){
exit;
}
$memname=$row['UserName'];
$msql = "select $message as Message from web_message_data where UserName='$memname'";
$mresult = mysql_db_query($dbname,$msql);
$mrow = mysql_fetch_array($mresult);
$mcou=mysql_num_rows($mresult);
$mem_message=$mrow['Message'];
?>
<?
if ($mcou==0){
?>
<!--<script>if (top.game_alert.indexOf('FT')==-1){alert("<?=$mem_msg?>"); top.game_alert+='FT,'}</script>-->
<?
}else if($mcou==1){
?>
<script>if (top.game_alert.indexOf('Message')==-1){alert("<?=$mem_message?>"); top.game_alert+='Message,'}</script>
<?
}
?>

<script> 
var show_ior = '100';
</script>
<html>
<head>
<title>下注分割畫面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script> 
var keepGameData=new Array();
var gidData=new Array();
parent.gamecount=0;
//判斷賠率是否變動
//包td
 
function checkRatio(rec,index){
 //alert(flash_ior_set);
	//return true;
	if (flash_ior_set =='Y'){
 
		if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
			keepGameData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//判斷gid是否相同
		if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
			keepGameData[rec]=new Array();
			gidData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
			gidData[rec][0]=GameFT[rec][0];
		}
 
		if (""+keepGameData[rec][index]=="undefined" ||keepGameData[rec][index]==""){
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//alert("aaa==>"+keepGameData[rec][index]+"bbb==>"+GameFT[rec][index]);
		if (keepGameData[rec][index]!=GameFT[rec][index]&& keepGameData[rec][index] !=""&&GameFT[rec][index]!=""){
	    	//keepGameData[rec][index]=GameFT[rec][index];
	    	keepGameData[rec][index] = "";
	    	//keepGameData[rec]="";
			return " bgcolor=yellow ";
		}
		return true;
	}
}
//包font
function checkRatio_font(rec,index){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
			keepGameData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//判斷gid是否相同
		if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
			keepGameData[rec]=new Array();
			gidData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
			gidData[rec][0]=GameFT[rec][0];
		}
		if (""+keepGameData[rec][index]=="undefined"||keepGameData[rec][index] ==""){
			keepGameData[rec][index]=GameFT[rec][index];
		}
 
		//alert("ccc==>"+keepGameData[rec][index]+"ddd==>"+GameFT[rec][index]);
		if (keepGameData[rec][index]!=GameFT[rec][index] && keepGameData[rec][index] !=""&&GameFT[rec][index]!="") {
	    	//keepGameData[rec][index]=GameFT[rec][index];
	    	keepGameData[rec][index] = "";
	    	//keepGameData[rec]="";
			return '  style=\"background-color : yellow\" ';
		}
		return true;
	}
}
function gethighlight(){
	return " style=\"color:red\" style=\"font-weight:bolder\" ";
}
//滑鼠移動帶出索引
//function showMsg(msg, type) {
//	var showHelpMsg = body_browse.document.getElementById("showHelpMsg");
////	var showHelpMsg = parent.body_browse.document.getElementById('showHelpMsg');
//	var helpMsg = body_browse.document.getElementById('helpMsg').innerHTML;
//	var tmpHTML = "";
//	if(type == 1) {
//		tmpHTML = helpMsg;
//		tmpHTML = tmpHTML.replace("*SHOWMSG*", msg);
//		showHelpMsg.innerHTML = tmpHTML;
//		showHelpMsg.style.display = "block";
//		showHelpMsg.style.top = body_browse.document.body.scrollTop+body_browse.event.clientY-10;
//		showHelpMsg.style.left = body_browse.document.body.scrollLeft+body_browse.event.clientX+10;
//	} else showHelpMsg.style.display = "none";
//}
 
//====== 加入現場轉播功能 2009-04-09
// 開啟轉播
function OpenLive(eventid, gtype){
	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}
	window.open("../live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid+"&eventid="+eventid+"&gtype="+gtype,"Live","width=780,height=585,top=0,left=0,status=no,toolbar=no,scrollbars=no,resizable=no,personalbar=no");
}
 
function VideoFun(eventid, hot, play, gtype) {
	var tmpStr = "";
	if (play == "Y") {
		tmpStr+= "<img lowsrc=\"/images/member/video_1.gif\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\" style=\"cursor:hand\">";
	} else {
		tmpStr+= "<img lowsrc=\"/images/member/video_2.gif\">";
	}
	return tmpStr;
}
 
function MM_ShowLoveI(gid,getDateTime,getLid,team_h,team_c){
	var txtout="";
	if(!top.swShowLoveI){
		if(!chkRepeat(gid)){	
			txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img id='"+MM_imgId(getDateTime,gid)+"' lowsrc=\"/images/member/icon_X2.gif\" vspace=\"0\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></span>";
		}else{
			txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></span>";
		}
	}else{
		txtout = "<img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \">";
	}
	return txtout;
}
 
function chkRepeat(gid){
	var getGtype =getGtypeShowLoveI();
	var sw =false;
	for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
		if(top.ShowLoveIarray[getGtype][i][0]==gid)
			sw =true;
	}
	return sw;
}
 
function MM_IdentificationDisplay(time,gid){
	var getGtype = getGtypeShowLoveI();
	var txt_array = top.ShowLoveIOKarray[getGtype];
	if(top.swShowLoveI){
		var tmp = time.split("<br>")[0];
		if(txt_array.length==0)return true;
		if(txt_array.indexOf(tmp+gid +",",0)== -1)
			return true;
	}
}
function getGtypeShowLoveI(){
	var Gtype;
	var getGtype =sel_gtype;
	
	if(getGtype =="FU"||getGtype=="FT"){
		Gtype ="FT";
	}else if(getGtype =="OM"||getGtype=="OP"){
		Gtype ="OP";
	}else if(getGtype =="BU"||getGtype=="BK"){
		Gtype ="BK";
	}else if(getGtype =="BSFU"||getGtype=="BS"){
		Gtype ="BS";
	}else if(getGtype =="VU"||getGtype=="VB"){
		Gtype ="VB";
	}else if(getGtype =="TU"||getGtype=="TN"){
		Gtype ="TN";
	}else {
		Gtype ="FT";
	}
	//alert("in==>"+parent.sel_gtype+",out==>"+Gtype);
	return Gtype;
}
function MM_imgId(time,gid){	
	var tmp = time.split("<br>")[0];
	//alert(tmp+gid);
	return tmp+gid;
}
 
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
<?
switch($rtype){
case 'r':
?>
<script> 
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	//只有 讓分/走地 才有更新時間
	hr_info = body_browse.document.getElementById('hr_info');
	if(retime)
		hr_info.innerHTML = retime+str_renew;
	else
		hr_info.innerHTML = str_renew;
//	if(body_browse.ReloadTimeID)
//		clearInterval(body_browse.ReloadTimeID);
//	if (retime_flag == 'Y')
//		body_browse.ReloadTimeID = setInterval("body_browse.reload_var()",retime*1000);
	//只有 讓分/走地 才有更新時間 End
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount);
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	ShowData_OU(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
		obj_sel = body_browse.document.getElementById('sel_league');
		obj_sel.style.display='none';
		try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
	}else{
		show_page();
	}
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	obj_pg.innerHTML = pg_str;
}
//------單式顯示------
function ShowData_OU(obj_table,GameData,data_amount,odd_f_type){
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
 
 
	//alert(eval(""+sel_gtype+'_lname_ary'));
	var nowLeague = '';
	var nowDate = '';
	with(obj_table){
		//alert(top.FT_lid_type);
		//清除table資料
		while(rows.length > 2)
			deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
 
		for(i=0; i<data_amount; i++){
			var open_hot = false;
			if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
			R_ior  = get_other_ioratio(odd_f_type, GameData[i] [9], GameData[i][10] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
			HR_ior = get_other_ioratio(odd_f_type, GameData[i][25], GameData[i][26] , show_ior);
			HOU_ior= get_other_ioratio(odd_f_type, GameData[i][29], GameData[i][30] , show_ior);
			//alert(R_ior[0]+","+R_ior[1]);
			if ((GameData[i][15]*1) <= 0 || (GameData[i][16]*1) <= 0) {
				GameData[i][15]='';
				GameData[i][16]='';
				GameData[i][17]='';
			}
			//判斷是否為精選賽事聯盟
			if(top.showtype=='hgft'||top.showtype=='hgfu'){
				for(j=0;j< top.lid_arr.length;j++){
					if((top.lid_arr[j][1])==GameData[i][2]){
						open_hot = true;
						break;	
					}
				}
				if(!open_hot)continue;
				hot_gdate(GameData[i][1].substr(0,5));
			}else{
				if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2]+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
			}
			//判斷聯盟是否相同不同加一列顯示聯盟
			if(GameData[i][9]<=0 || GameData[i][10]<=0)GameData[i][8]='';
			gdate = GameData[i][1].substr(0,5);
			if(nowLeague != GameData[i][2] || nowDate != gdate){
				nowLeague = GameData[i][2];
				nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.colSpan = 9;
					nowTD.className = 'b_hline';
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
			nowTR = insertRow();
			nowTR.id ="TR_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
			    //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball",top.str_RB);
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = GameData[i][1]+'<BR>';
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.rowSpan = 2;
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][5]+'&nbsp;&nbsp;<BR>'+GameData[i][6];
				tmp_data=(GameData[i][5].replace("<font style=background-color:#FFFF99>","")).replace("</font>","");

 
 
				//獨贏主隊
				nowTD = insertCell();
				if ((GameData[i][15]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_m.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\"><font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
				//讓球主隊
				nowTD = insertCell();
 
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'H') //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				tmpStr += '<td '+checkRatio(i,9)+'><a href=\"../FT_order/FT_order_r.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\">'+R_ior[0]+'</a></td>'+
				          '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(GameData[i][14]){
					if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
					nowTD.innerHTML = '<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>&nbsp;&nbsp;'+
						'<A href=\"../FT_order/FT_order_ou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML ='';
				}
				//單雙主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(GameData[i][20]){
					if(langx=="zh-tw"){
						title_str="單";
					}
					if(langx=="zh-cn"){
						title_str="单";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Odd";
					}
					nowTD.innerHTML = GameData[i][18]+'&nbsp;&nbsp;'+
						'<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=ODD\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,20)+'>'+GameData[i][20]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML ='';
				}
 
				//上半獨贏主隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				if ((GameData[i][31]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][22]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\"><font '+checkRatio_font(i,31)+'>'+GameData[i][31]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
				//上半讓球H
				nowTD = insertCell();
 
				nowTD.className = 'b_1st';
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][23] == "H"){ //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,24)+' align=\"center\" width=\"68%\">'+GameData[i][24]+'</td>';
				}else{  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				}
				tmpStr += '<td '+checkRatio(i,25)+'><a href=\"../FT_order/FT_order_hr.php?gid='+GameData[i][22]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\">'+HR_ior[0]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
 
				//大小盤主隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.align = "right";
				if(GameData[i][30]){
					if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
					nowTD.innerHTML = '<font '+checkRatio_font(i,27)+'>'+GameData[i][27]+'</font>&nbsp;&nbsp;'+
							'<A href=\"../FT_order/FT_order_hou.php?gid='+GameData[i][22]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,30)+'>'+HOU_ior[1]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = "";
				}
 
 
			}//主隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR1_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
				tmp_data=(GameData[i][6].replace("<font style=background-color:#FFFF99>","")).replace("</font>","");
 
				//獨贏客隊
				nowTD = insertCell();
				if ((GameData[i][16]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_m.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\"><font '+checkRatio_font(i,16)+'>'+GameData[i][16]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
				//讓球客隊
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'C') //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
//					if (checkRatio(i,10)){
//						tdcolor="";
//					}else{
//						tdcolor=gethighlight();
//					}
				        tmpStr += '<td '+checkRatio(i,10)+'><a href=\"../FT_order/FT_order_r.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\">'+R_ior[1]+'</a></td>'+
				          '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤客隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(GameData[i][13]){
					if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
					nowTD.innerHTML = '<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>&nbsp;&nbsp;'+
						'<A href=\"../FT_order/FT_order_ou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML ='';
				}
				//單雙客隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(GameData[i][21]){
					if(langx=="zh-tw"){
						title_str="雙";
					}
					if(langx=="zh-cn"){
						title_str="双";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Even";
					}
					nowTD.innerHTML = GameData[i][19]+'&nbsp;&nbsp;'+
						'<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=EVEN\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,21)+'>'+GameData[i][21]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML ='';
				}
 
				//上半獨贏客隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				if ((GameData[i][32]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][22]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\"title=\"'+tmp_data+'\"><font '+checkRatio_font(i,32)+'>'+GameData[i][32]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
				//1st讓球客隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][23] == "C"){ //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,24)+' align=\"center\" width=\"68%\">'+GameData[i][24]+'</td>';
				}else{  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				}
				tmpStr += '<td '+checkRatio(i,26)+'><a href=\"../FT_order/FT_order_hr.php?gid='+GameData[i][22]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\">'+HR_ior[1]+'</a></td>'+
				       '</tr></table>';
				nowTD.innerHTML = tmpStr;
 
				//1st大小盤客隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.align = "right";
				if(GameData[i][29]){
				     if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				     nowTD.innerHTML = '<font '+checkRatio_font(i,28)+'>'+GameData[i][28]+'</font>&nbsp;&nbsp;'+
						       '<A href=\"../FT_order/FT_order_hou.php?gid='+GameData[i][22]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,29)+'>'+HOU_ior[0]+'</A></font>&nbsp;';
				}else{
				     nowTD.innerHTML ="";
				}
 
			}//客隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR2_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
 
				nowTD = insertCell();
				nowTD.align = 'left';
				//nowTD.innerHTML = str_even;
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr = "<table width='100%'><tr><td align='left'>"+str_even+"</td>";				
				tmpStr+= "<td class='hot_td'>";
				tmpStr+= "<table><tr align='right' height='17'><td>";
				tmpStr+=MM_ShowLoveI(GameData[i][3],GameData[i][1],GameData[i][2],GameData[i][5],GameData[i][6]);
				tmpStr+= "</td><td>";
				if (top.casino == "SI2") {
					if (GameData[i][35] != "" && GameData[i][35] != "null" && GameData[i][35] != undefined) {	//判斷是否有轉播
						tmpStr+= VideoFun(GameData[i][35], GameData[i][36], GameData[i][37], "FT");
					}
				}
				tmpStr+= "</td></tr></table>";
				tmpStr+= "</td>";
				tmpStr+= "</tr></table>";
				nowTD.innerHTML = tmpStr;
 
				//獨贏和局
				nowTD = insertCell();
				if ((GameData[i][15]*1) > 0&&(GameData[i][16]*1) > 0&&(GameData[i][17]*1) > 0){
					nowTD.innerHTML = '<A href=\"../FT_order/FT_order_m.php?gid='+GameData[i][0]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\"   title=\"'+str_even+'\"><font '+checkRatio_font(i,17)+'>'+GameData[i][17]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
				nowTD = insertCell();
				nowTD.colSpan = 3;
				if(game_more=='0'||GameData[i][34]=='0') nowTD.innerHTML ='';
				else nowTD.innerHTML ='<A href=\"javascript:\" onClick=\"show_more(\''+GameData[i][0]+'\');\">'+str_more+'<font class=\'total_color\'>('+GameData[i][34]+')</font>'+'</A>' ;
				//if(game_more=='0') nowTD.innerHTML ='';
				//else nowTD.innerHTML ='<A href=\"javascript:\" onClick=\"show_more(\''+GameData[i][0]+'\');\">'+str_more+'</A>' ;
 
 
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.align = 'left';
				//獨贏和局
				if ((GameData[i][31]*1) > 0&&(GameData[i][32]*1) > 0&&(GameData[i][33]*1) > 0){
					nowTD.innerHTML = '<A href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][22]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\"   title=\"'+str_even+'\"><font '+checkRatio_font(i,33)+'>'+GameData[i][33]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.colSpan = 2;
 
			}//和局TR結束
 
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 9;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示單式結束
 
 
function ShowData_Other(show_team,show_pd,show_t,show_f,show_hpd,GameData,odd_f_type){
	var nowLeague = '';
	var nowDate = '';
 
	show_team.style.display='none';
	show_pd.style.display='none';
	show_hpd.style.display='none';
	show_t.style.display='none';
	show_f.style.display='none';
 
	with(show_team){
		//清除table資料
		while(rows.length >= 1)
		deleteRow(rows.length-1);
 
		if (GameData[34]!='0')show_team.style.display='block';
 
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			nowTD = insertCell();
			nowTD.align = 'left';
			nowTD.innerHTML = GameData[5]+'&nbsp;&nbsp;<font color="#ff8000">VS.</font>&nbsp;&nbsp;'+GameData[6];
		}
		nowTR = insertRow();
		with(nowTR){
			nowTD = insertCell();
			nowTD.colSpan = 18;
			nowTD.height = 1;
		}//分隔線TR
	}
 
	with(show_pd){//波膽
		//清除table資料
		while(rows.length > 1)
		deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
		var ar=0;
		flag = false;
		for(j=19; j<=45; j++){
			if(GameData[j] == '0'){
				//ar++;
				GameData[j]="";
			}
			if (GameData[j]=="")ar++;
		}
		if (ar!=27)show_pd.style.display='block';
 
 
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			//波膽
 
			nowTD = insertCell(); //H1C0
			if(GameData[19]=='') nowTD.innerHTML='&nbsp;';
			else nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C0\" target=\"mem_order\">'+GameData[19]+'</A>';
			nowTD = insertCell(); //H2C0
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C0\" target=\"mem_order\">'+GameData[20]+'</A>';
			nowTD = insertCell(); //H2C1
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C1\" target=\"mem_order\">'+GameData[21]+'</A>';
			nowTD = insertCell(); //H3C0
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C0\" target=\"mem_order\">'+GameData[22]+'</A>';
			nowTD = insertCell(); //H3C1
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C1\" target=\"mem_order\">'+GameData[23]+'</A>';
			nowTD = insertCell(); //H3C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C2\" target=\"mem_order\">'+GameData[24]+'</A>';
			nowTD = insertCell(); //H4C0
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C0\" target=\"mem_order\">'+GameData[25]+'</A>';
			nowTD = insertCell(); //H4C1
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C1\" target=\"mem_order\">'+GameData[26]+'</A>';
			nowTD = insertCell(); //H4C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C2\" target=\"mem_order\">'+GameData[27]+'</A>';
			nowTD = insertCell(); //H4C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C3\" target=\"mem_order\">'+GameData[28]+'</A>';
			nowTD = insertCell(); //H0C0
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C0\" target=\"mem_order\">'+GameData[29]+'</A>';
			nowTD = insertCell(); //H1C1
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C1\" target=\"mem_order\">'+GameData[30]+'</A>';
			nowTD = insertCell(); //H2C2
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C2\" target=\"mem_order\">'+GameData[31]+'</A>';
			nowTD = insertCell(); //H3C3
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C3\" target=\"mem_order\">'+GameData[32]+'</A>';
			nowTD = insertCell(); //H4C4
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C4\" target=\"mem_order\">'+GameData[33]+'</A>';
			nowTD = insertCell();  //OVH
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=OVH\" target=\"mem_order\">'+GameData[34]+'</A>';
		}//主隊TR結束
 
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			//波膽
			nowTD = insertCell(); //H0C1
			if(GameData[35]=='') nowTD.innerHTML='&nbsp;';
			else nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C1\" target=\"mem_order\">'+GameData[35]+'</A>';
			nowTD = insertCell(); //H0C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C2\" target=\"mem_order\">'+GameData[36]+'</A>';
			nowTD = insertCell(); //H1C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C2\" target=\"mem_order\">'+GameData[37]+'</A>';
			nowTD = insertCell(); //H0C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C3\" target=\"mem_order\">'+GameData[38]+'</A>';
			nowTD = insertCell(); //H1C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C3\" target=\"mem_order\">'+GameData[39]+'</A>';
			nowTD = insertCell(); //H2C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C3\" target=\"mem_order\">'+GameData[40]+'</A>';
			nowTD = insertCell(); //H0C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C4\" target=\"mem_order\">'+GameData[41]+'</A>';
			nowTD = insertCell(); //H1C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C4\" target=\"mem_order\">'+GameData[42]+'</A>';
			nowTD = insertCell(); //H2C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C4\" target=\"mem_order\">'+GameData[43]+'</A>';
			nowTD = insertCell(); //H3C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C4\" target=\"mem_order\">'+GameData[44]+'</A>';
//			nowTD = insertCell();  //OVC
//			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[18]+'&uid='+uid+'&rtype=OVC\" target=\"mem_order\">'+GameData[45]+'</A>';
		}//客隊TR結束
		nowTR = insertRow();
		with(nowTR){
			nowTD = insertCell();
			nowTD.colSpan = 18;
			nowTD.height = 1;
		}//分隔線TR
	}
 
	with(show_hpd){//波膽
		//清除table資料
		while(rows.length > 1)
		deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
		var ar=0;
		flag = false;
		for(j=59; j<=85; j++){
			if(GameData[j] == '0'){
				//ar++;
				GameData[j]="";
			}
			if (GameData[j]=="")ar++;
			}
		if (GameData[59]>0)show_hpd.style.display='block';
 
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			//波膽
			nowTD = insertCell(); //H1C0
			if(GameData[59]=='') nowTD.innerHTML='&nbsp;';
			else nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C0\" target=\"mem_order\">'+GameData[59]+'</A>';
			nowTD = insertCell(); //H2C0
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C0\" target=\"mem_order\">'+GameData[60]+'</A>';
			nowTD = insertCell(); //H2C1
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C1\" target=\"mem_order\">'+GameData[61]+'</A>';
			nowTD = insertCell(); //H3C0
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C0\" target=\"mem_order\">'+GameData[62]+'</A>';
			nowTD = insertCell(); //H3C1
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C1\" target=\"mem_order\">'+GameData[63]+'</A>';
			nowTD = insertCell(); //H3C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C2\" target=\"mem_order\">'+GameData[64]+'</A>';
			nowTD = insertCell(); //H4C0
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C0\" target=\"mem_order\">'+GameData[65]+'</A>';
			nowTD = insertCell(); //H4C1
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C1\" target=\"mem_order\">'+GameData[66]+'</A>';
			nowTD = insertCell(); //H4C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C2\" target=\"mem_order\">'+GameData[67]+'</A>';
			nowTD = insertCell(); //H4C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C3\" target=\"mem_order\">'+GameData[68]+'</A>';
			nowTD = insertCell(); //H0C0
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C0\" target=\"mem_order\">'+GameData[69]+'</A>';
			nowTD = insertCell(); //H1C1
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C1\" target=\"mem_order\">'+GameData[70]+'</A>';
			nowTD = insertCell(); //H2C2
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C2\" target=\"mem_order\">'+GameData[71]+'</A>';
			nowTD = insertCell(); //H3C3
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C3\" target=\"mem_order\">'+GameData[72]+'</A>';
			nowTD = insertCell(); //H4C4
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C4\" target=\"mem_order\">'+GameData[73]+'</A>';
			nowTD = insertCell();  //OVH
			nowTD.rowSpan = 2;
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=OVH\" target=\"mem_order\">'+GameData[74]+'</A>';
		}//主隊TR結束
 
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			//波膽
			nowTD = insertCell(); //H0C1
			if(GameData[75]=='') nowTD.innerHTML='&nbsp;';
			else nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C1\" target=\"mem_order\">'+GameData[75]+'</A>';
			nowTD = insertCell(); //H0C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C2\" target=\"mem_order\">'+GameData[76]+'</A>';
			nowTD = insertCell(); //H1C2
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C2\" target=\"mem_order\">'+GameData[77]+'</A>';
			nowTD = insertCell(); //H0C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C3\" target=\"mem_order\">'+GameData[78]+'</A>';
			nowTD = insertCell(); //H1C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C3\" target=\"mem_order\">'+GameData[79]+'</A>';
			nowTD = insertCell(); //H2C3
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C3\" target=\"mem_order\">'+GameData[80]+'</A>';
			nowTD = insertCell(); //H0C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C4\" target=\"mem_order\">'+GameData[81]+'</A>';
			nowTD = insertCell(); //H1C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C4\" target=\"mem_order\">'+GameData[82]+'</A>';
			nowTD = insertCell(); //H2C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C4\" target=\"mem_order\">'+GameData[83]+'</A>';
			nowTD = insertCell(); //H3C4
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C4\" target=\"mem_order\">'+GameData[84]+'</A>';
//			nowTD = insertCell();  //OVC
//			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[0]+'&uid='+uid+'&rtype=OVC\" target=\"mem_order\">'+GameData[85]+'</A>';
		}//客隊TR結束
		nowTR = insertRow();
		with(nowTR){
			nowTD = insertCell();
			nowTD.colSpan = 18;
			nowTD.height = 1;
		}//分隔線TR
	}
 
	with(show_t){
		//清除table資料
		while(rows.length > 1)
		deleteRow(rows.length-1);
		//開始顯示總入球賽程資料
		//判斷是否單雙或總入球都有賠率
		var ar=0;
		for(j=46; j<=49; j++){
			if(GameData[j] == '0'){
				//ar++;
				GameData[j]="";
			}
			if (GameData[j]=="")ar++;
		}
		if (ar!=4)show_t.style.display='block';
 
 
		//判斷聯盟是否相同不同加一列顯示聯盟
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			//0~1
			nowTD = insertCell();
			if(GameData[46]=='') nowTD.innerHTML='&nbsp;';
			else nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=0~1\" target=\"mem_order\">'+GameData[46]+'</A>';
			//2~3
			nowTD = insertCell();
			nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=2~3\" target=\"mem_order\">'+GameData[47]+'</A>';
			//4~6
			nowTD = insertCell();
			nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=4~6\" target=\"mem_order\">'+GameData[48]+'</A>';
			//OVER
			nowTD = insertCell();
			nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=OVER\" target=\"mem_order\">'+GameData[49]+'</A>';
		}
		nowTR = insertRow();
		with(nowTR){
			nowTD = insertCell();
			nowTD.colSpan = 4;
			nowTD.height = 1;
		}//分隔線TR
	}//with(obj_table);
 
	with(show_f){
		//清除table資料
		while(rows.length > 1)
		deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
		//判斷是否半全場都有賠率
		var ar=0;
		for(j=50; j<=58; j++){
			if(GameData[j] == '0'){
				//ar++;
				GameData[j]="";
			}
			if (GameData[j]=="")ar++;
		}
		if (ar!=9)show_f.style.display='block';
		//判斷聯盟是否相同不同加一列顯示聯盟
		nowTR = insertRow();
		nowTR.className = 'b_cen';
		with(nowTR){
			//半全場
			nowTD = insertCell(); //H0C1
			nowTD.align = 'center';
			if(GameData[50]=='') nowTD.innerHTML='&nbsp;';
			else nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FHH\" target=\"mem_order\">'+GameData[50]+'</A>';
			nowTD = insertCell(); //H0C2
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FHN\" target=\"mem_order\">'+GameData[51]+'</A>';
			nowTD = insertCell(); //H1C2
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FHC\" target=\"mem_order\">'+GameData[52]+'</A>';
			nowTD = insertCell(); //H0C3
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FNH\" target=\"mem_order\">'+GameData[53]+'</A>';
			nowTD = insertCell(); //H1C3
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FNN\" target=\"mem_order\">'+GameData[54]+'</A>';
			nowTD = insertCell(); //H2C3
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FNC\" target=\"mem_order\">'+GameData[55]+'</A>';
			nowTD = insertCell(); //H0C4
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FCH\" target=\"mem_order\">'+GameData[56]+'</A>';
			nowTD = insertCell(); //H1C4
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FCN\" target=\"mem_order\">'+GameData[57]+'</A>';
			nowTD = insertCell(); //H2C4
			nowTD.align = 'center';
			nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[18]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FCC\" target=\"mem_order\">'+GameData[58]+'</A>';
		}//主隊TR結束
 
		nowTR = insertRow();
		with(nowTR){
			nowTD = insertCell();
			nowTD.colSpan = 18;
			nowTD.height = 1;
		}//分隔線TR
  	}//with(obj_table);
}//顯示單式結束
</script>
<?
break;
case 'hr':
?>
<script> 
function ShowGameList(){
	if(loading == 'Y') {return;}
	obj_msg = body_browse.document.getElementById("real_msg");
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	//只有 讓分/走地 才有更新時間
	hr_info = body_browse.document.getElementById('hr_info');
	if(retime){
		hr_info.innerHTML = retime+str_renew;
	}else{
		hr_info.innerHTML = str_renew;
	}
//	if(body_browse.ReloadTimeID){
//		clearInterval(body_browse.ReloadTimeID);
//	}
//	if (retime_flag == 'Y'){
//		body_browse.ReloadTimeID = setInterval("body_browse.reload_var()",retime*1000);
//	}
	//只有 讓分/走地 才有更新時間 End
	game_table = body_browse.document.getElementById("game_table");
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";	
	ShowData_OU(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;	
	if(top.showtype=='hgft'||top.showtype=='hgfu'){       
                obj_sel = body_browse.document.getElementById('sel_league');
                obj_sel.style.display='none';
                try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
        }else{
		show_page();
	}
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	obj_pg.innerHTML = pg_str;
}
//------單式顯示------
function ShowData_OU(obj_table,GameData,data_amount,odd_f_type){
	var R_ior =Array();
	var OU_ior =Array();
	var nowLeague = "";
	var nowDate = "";
 
	with(obj_table){
		//清除table資料
		while(rows.length > 1) {deleteRow(rows.length-1);}
 
		//開始顯示開放中賽程資料
		for(i=0; i<data_amount; i++){
			var open_hot = false;
			if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
			R_ior  = get_other_ioratio(odd_f_type, GameData[i] [9], GameData[i][10] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
//                        if ((GameData[i][15]*1) <= 0 || (GameData[i][16]*1) <= 0 || (GameData[i][17]*1) <= 0) { 
//                                GameData[i][15]='';
//                                GameData[i][16]='';
//                                GameData[i][17]='';
//                        }	
                        if ((GameData[i][15]*1) <= 0 || (GameData[i][16]*1) <= 0 ) { 
                                GameData[i][15]='';
                                GameData[i][16]='';
                                GameData[i][17]='';
                        }	
						
			//判斷是否為精選賽事聯盟
                        if(top.showtype=='hgft'||top.showtype=='hgfu'){
                                for(j=0;j<top.lid_arr.length;j++){
                                        if((top.lid_arr[j][1])==GameData[i][2]){
                                                open_hot = true;
                                                break;
                                        }
                                }
                                if(!open_hot)continue;
                                hot_gdate(GameData[i][1].substr(0,5));
                        }else{	
            			if(("-"+eval("parent."+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2]+"-"),0)==-1&&eval("parent."+sel_gtype+'_lname_ary')!='ALL') continue;
			}			
			//if(("-"+GameData[i][2]+"-").indexOf("-"+eval('parent.'+sel_gtype+'_lname_ary'),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
			
			if(GameData[i][9]<=0 || GameData[i][10]<=0) {GameData[i][8]="";}
//			if(sel_league!=GameData[i][2] && sel_league) {continue;}
 
			//判斷聯盟是否相同不同加一列顯示聯盟
			gdate = GameData[i][1].substr(0,5);
			if(nowLeague != GameData[i][2] || nowDate != gdate){
				nowLeague = GameData[i][2];
				nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.colSpan = 5;
					nowTD.className = 'b_hline';
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
 
			nowTR = insertRow();
			nowTR.id ="TR_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = "b_cen";
			with(nowTR){
		                //滾球字眼
		                GameData[i][1]=GameData[i][1].replace("Running Ball",top.str_RB);
			    if(langx=="zh-tw"){
					tmp_data=GameData[i][5].replace("<font color=gray> - [上半]</font>","");
				}
				if(langx=="zh-cn"){
					tmp_data=GameData[i][5].replace("<font color=gray> - [上半]</font>","");
				}
				if(langx=="en-us"||langx=="th-tis"){
					tmp_data=GameData[i][5].replace("<font color=gray> - [1st Half]</font>","");
				}
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = GameData[i][1]+"<BR>";
                
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.rowSpan = 2;
				nowTD.align = "left";
				nowTD.innerHTML = GameData[i][5]+"&nbsp;&nbsp;<BR>"+GameData[i][6];
				
				
				//alert(tmp_data[0]);
				//獨贏主隊
				nowTD = insertCell();
				if ((GameData[i][15]*1) > 0){
					//nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'\" target=\"mem_order\" onMouseOver="parent.showMsg(\''+GameData[i][5]+'\'</font>, 1);" onMouseOut="parent.showMsg(\'\', 0);"> <font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</a></font>';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'\" target=\"mem_order\" title=\"'+tmp_data+'\"><font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</A></font>';	
				}else{
					nowTD.innerHTML = "&nbsp";
				}
				//讓球主隊
				nowTD = insertCell();
 
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == "H"){ //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				}else{  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				}
				tmpStr += '<td '+checkRatio(i,9)+'><a href=\"../FT_order/FT_order_hr.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'\" target=\"mem_order\" title=\"'+tmp_data+'\">'+R_ior[0]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
 
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = "right";
				if(GameData[i][14]){
					if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
					nowTD.innerHTML = '<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>&nbsp;&nbsp;'+
							'<A href=\"../FT_order/FT_order_hou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = "";
				}
			}//主隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR1_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = "b_cen";
			with(nowTR){
				//獨贏客隊
				if(langx=="zh-tw"){
					tmp_data=GameData[i][6].replace("<font color=gray> - [上半]</font>","");
				}
				if(langx=="zh-cn"){
					tmp_data=GameData[i][6].replace("<font color=gray> - [上半]</font>","");
				}
				if(langx=="en-us"||langx=="th-tis"){
					tmp_data=GameData[i][6].replace("<font color=gray> - [1st Half]</font>","");
				}
				nowTD = insertCell();
				if ((GameData[i][15]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\"><font '+checkRatio_font(i,16)+'>'+GameData[i][16]+'</A></font>';
				}else{
					nowTD.innerHTML = "&nbsp";
				}
				//讓球客隊
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == "C"){ //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				}else{  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				}
				tmpStr += '<td '+checkRatio(i,10)+'><a href=\"../FT_order/FT_order_hr.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+tmp_data+'\">'+R_ior[1]+'</a></td>'+
				       '</tr></table>';
				nowTD.innerHTML = tmpStr;
 
				//大小盤客隊
				nowTD = insertCell();
				nowTD.align = "right";
				if(GameData[i][13]){
				     if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				     nowTD.innerHTML = '<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>&nbsp;&nbsp;'+
						       '<A href=\"../FT_order/FT_order_hou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</A></font>&nbsp;';
				}else{
				     nowTD.innerHTML ="";
				}
			}//客隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR2_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = "b_cen";
			with(nowTR){
				nowTD = insertCell();
				nowTD.align = "left";
				//nowTD.innerHTML = str_even;
				tmpStr = "<table width='100%'><tr><td align='left'>"+str_even+"</td>";				
				tmpStr+= "<td class='hot_td'>";
				tmpStr+=MM_ShowLoveI(GameData[i][3],GameData[i][1],GameData[i][2],GameData[i][5],GameData[i][6]);
				tmpStr+= "</td>";
				tmpStr+= "</tr></table>";
				nowTD.innerHTML = tmpStr;
				//獨贏和局
				nowTD = insertCell();
				if ((GameData[i][15]*1) > 0&&(GameData[i][16]*1) > 0&&(GameData[i][17]*1) > 0){
					nowTD.innerHTML = '<A href=\"../FT_order/FT_order_hm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+str_even+'\"><font '+checkRatio_font(i,17)+'>'+GameData[i][17]+'</A></font>';
				}else{
					nowTD.innerHTML = "&nbsp";	
				}	
				nowTD = insertCell();
				nowTD.colSpan = 2;
				nowTD.innerHTML = "&nbsp";
 
			}//和局TR結束
 
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 5;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示單式結束
</script>
<?
break;
case 're':
?>
<script> 
function ShowGameList(){
	var obj_msg;
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"120\">'+msg+'</marquee>';
	//只有 讓分/走地 才有更新時間
	hr_info = body_browse.document.getElementById('hr_info');
	if(retime)
		hr_info.innerHTML = retime+str_renew;
	else
		hr_info.innerHTML = str_renew;
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	ShowData_RE(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;
}
 
 //------走地顯示------
function ShowData_RE(obj_table,GameData,data_amount,odd_f_type){
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	var nowLeague = '';
	//var nowDate = '';
	var half='';
	with(obj_table){
		//清除table資料
		while(rows.length > 2)
			deleteRow(rows.length-1);
		//開始顯示走地賽程資料
		for(i=0; i<data_amount; i++){
			if(MM_IdentificationDisplay(GameData[i][42],GameData[i][3]))continue;
			R_ior  = get_other_ioratio(odd_f_type, GameData[i][9], GameData[i][10] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
			HR_ior = get_other_ioratio(odd_f_type, GameData[i][23], GameData[i][24] , show_ior);
			HOU_ior= get_other_ioratio(odd_f_type, GameData[i][27], GameData[i][28] , show_ior);
			if ((GameData[i][33]*1) <= 0 || (GameData[i][34]*1) <= 0) {
				GameData[i][33]='';
				GameData[i][34]='';
				GameData[i][35]='';
			}
			if ((GameData[i][36]*1) <= 0 || (GameData[i][37]*1) <= 0) {
				GameData[i][36]='';
				GameData[i][37]='';
				GameData[i][38]='';
			}
			//if(top.FT_lname_ary_RE.indexOf(GameData[i][2]+"-",0)==-1&&top.FT_lname_ary_RE!='ALL') continue;
			if(("-"+parent.FT_lname_ary_RE).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)==-1&&parent.FT_lname_ary_RE!='ALL') continue;
//			if ((GameData[i][9] == "" || GameData[i][10] == "") && (GameData[i][13] == "" || GameData[i][14] == "")){
//				continue;
//			}
			//判斷聯盟是否相同不同加一列顯示聯盟
			//gdate = GameData[i][1].substr(0,5);
			if(nowLeague != GameData[i][2]){
				nowLeague = GameData[i][2];
			//	nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.className = 'b_hline';
					nowTD.colSpan = 9;
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
 
			if(chk_half(GameData[i][5])){
				half ='h'
			}else{
				half = '';
			}
			nowTR = insertRow();
			nowTR.id ="TR_"+MM_imgId(GameData[i][42],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			if(chk_half(GameData[i][5])){
				nowTR.className = 'b_1st';
			}else{
				nowTR.className = 'b_cen';
			}
			with(nowTR){
				//目前結果
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				//判斷入球是否變動
				if (flash_ior_set =='Y'){
					if(GameData[i][31]==""&&GameData[i][32]==""){
						tdcolorC="";
						tdcolorH="";
					}
					if (GameData[i][31]=="H"&&GameData[i][32]==""){
						tdcolorH=gethighlight();
					}else{
						tdcolorH="";
					}
					if (GameData[i][31]==""&&GameData[i][32]=="C"){
						tdcolorC=gethighlight();
					}else{
						tdcolorC="";
					}
				}else{
					tdcolorH="";
					tdcolorC="";
				}
				nowTD.innerHTML = "<table><tr><td "+tdcolorH+">"+GameData[i][18]+"</td><td>-</td><td "+tdcolorC+">"+GameData[i][19]+"</td></tr></table>";
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = GameData[i][1];
				//隊伍主隊
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				var tmp_red_card_h = "";
				//for (i=0;i < (GameData[i][29]*1);i++){
				//tmp_red_card_h+="<span class='card'></span><span class='card'></span>";
				for(var j=0; j < GameData[i][29]; j++){
					//紅卡
					tmp_red_card_h+= "<b class='card'><span class='R_card'> &#x2585;</span></b>";
				}
				//}
				nowTD.innerHTML = "<table><tr><td>"+GameData[i][5]+"</td><td>"+tmp_red_card_h+"</td></tr></table>";
 
				//獨贏主隊
				nowTD = insertCell();
				if ((GameData[i][33]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,33)+'>'+GameData[i][33]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
 
				//讓球主隊
				nowTD = insertCell();
 
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'H') //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				//tmpStr += '<td '+checkRatio(i,9)+'><a href=\"../FT_order/FT_order_'+half+'re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'\" target=\"mem_order\" onMouseOver="parent.showMsg(\''+GameData[i][5]+'\', 1);" onMouseOut="parent.showMsg(\'\', 0);">'+GameData[i][9]+'</a></td>'+
				tmpStr += '<td '+checkRatio(i,9)+'><a href=\"../FT_order/FT_order_'+half+'re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][5]+'\">'+R_ior[0]+'</a></td>'+
 
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>&nbsp;&nbsp;'+
						'&nbsp;&nbsp;<a href=\"../FT_order/FT_order_'+half+'rou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</A></font>&nbsp;';
 
				//上半主隊
				//上半獨贏主隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				if ((GameData[i][36]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,36)+'>'+GameData[i][36]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
 
				//上半讓球主隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][21] == 'H') //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,22)+' align=\"center\" width=\"68%\">'+GameData[i][22]+'</td>';
				else  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
					tmpStr += '<td '+checkRatio(i,23)+'><a href=\"../FT_order/FT_order_hre.php?gid='+GameData[i][20]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][5]+'\">'+HR_ior[0]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//上半大小盤主隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,25)+'>'+GameData[i][25]+'</font>&nbsp;&nbsp;'+
						'&nbsp;&nbsp;<a href=\"../FT_order/FT_order_hrou.php?gid='+GameData[i][20]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,28)+'>'+HOU_ior[1]+'</A></font>&nbsp;';
 
 
			}//主隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR1_"+MM_imgId(GameData[i][42],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			if(chk_half(GameData[i][5])){
				nowTR.className = 'b_1st';
			}else{
				nowTR.className = 'b_cen';
			}
			with(nowTR){
				//隊伍客隊
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				var tmp_red_card_c = "";
				for(var k = 0; k < GameData[i][30]; k++){
					tmp_red_card_c+= "<b class='card'><span class='R_card'> &#x2585;</span></b>";
				}
                nowTD.innerHTML = "<table><tr><td>"+GameData[i][6]+"</td><td>"+tmp_red_card_c+"</td></tr></table>";
 
                //獨贏客隊
				nowTD = insertCell();
				if ((GameData[i][34]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\"title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,34)+'>'+GameData[i][34]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
				//讓球客隊
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'C') //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp</td>';
				tmpStr += '<td '+checkRatio(i,10)+'><a href=\"../FT_order/FT_order_'+half+'re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][6]+'\">'+R_ior[1]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>&nbsp;&nbsp;'+
						'&nbsp;&nbsp;<a href=\"../FT_order/FT_order_'+half+'rou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</A></font>&nbsp;';
 
				//上半客隊
				//上半獨贏客隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				if ((GameData[i][37]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,37)+'>'+GameData[i][37]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
 
				//上半讓球客隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][21] == 'C') //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,22)+' align=\"center\" width=\"68%\">'+GameData[i][22]+'</td>';
				else  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp</td>';
				tmpStr += '<td '+checkRatio(i,24)+'><a href=\"../FT_order/FT_order_hre.php?gid='+GameData[i][20]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][6]+'\">'+HR_ior[1]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
 
 
				//上半大小盤客隊
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.align = 'right';
				if(langx=="zh-tw"){
					title_str="小";
				}
				if(langx=="zh-cn"){
					title_str="小";
				}
				if(langx=="en-us"||langx=="th-tis"){
					title_str="Under";
				}
				nowTD.innerHTML = '<font '+checkRatio_font(i,26)+'>'+GameData[i][26]+'</font>&nbsp;&nbsp;'+
						'&nbsp;&nbsp;<a href=\"../FT_order/FT_order_hrou.php?gid='+GameData[i][20]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,27)+'>'+HOU_ior[0]+'</A></font>&nbsp;';
 
 
			}//客隊TR結束
			nowTR = insertRow();
			nowTR.id ="TR2_"+MM_imgId(GameData[i][42],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
				nowTD = nowTR.insertCell();
				nowTD.align = "left";
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr = "<table width='100%'><tr><td align='left'>"+str_even+"</td>";
				tmpStr+= "<td class='hot_td'>";
				tmpStr+= "<table><tr align='right' height='17'><td>";
				tmpStr+=MM_ShowLoveI(GameData[i][3],GameData[i][42],GameData[i][2],GameData[i][5],GameData[i][6]);
				tmpStr+= "</td><td>";
				if (top.casino == "SI2") {
					if (GameData[i][39] != "" && GameData[i][39] != "null" && GameData[i][39] != undefined) {	//判斷是否有轉播
						tmpStr+= VideoFun(GameData[i][39], GameData[i][40], GameData[i][41], "FT");						
					}
				}
				tmpStr+= "</td></tr></table>";
				tmpStr+= "</td>";
				tmpStr+= "</tr></table>";
				nowTD.innerHTML = tmpStr;
 
				//獨贏和局
				nowTD = insertCell();
				if ((GameData[i][33]*1) > 0&&(GameData[i][34]*1) > 0&&(GameData[i][35]*1) > 0){
					nowTD.innerHTML = '<A href=\"../FT_order/FT_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+str_even+'\"><font '+checkRatio_font(i,35)+'>'+GameData[i][35]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = "&nbsp";
				}
				nowTD = insertCell();
				nowTD.colSpan = 2;
				nowTD.innerHTML = "&nbsp";
				//上半獨贏和局
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				if ((GameData[i][36]*1) > 0&&(GameData[i][37]*1) > 0&&(GameData[i][38]*1) > 0){
					nowTD.innerHTML = '<A href=\"../FT_order/FT_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+str_even+'\"><font '+checkRatio_font(i,38)+'>'+GameData[i][38]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = "&nbsp";
				}
				nowTD = insertCell();
				nowTD.className = 'b_1st';
				nowTD.colSpan = 2;
				nowTD.innerHTML = "&nbsp";
 
			}//和局TR結束
 
 
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 8;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示走地結束
 
function chk_half(str){
	if(str.indexOf("<font color=gray>") > -1) return true;
	return false;
}
</script>
<?
break;
case 'pd':
?>
<script> 
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	ShowData_PD(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;	
	
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
                obj_sel = body_browse.document.getElementById('sel_league');
                obj_sel.style.display='none';
                try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
        }else{
		show_page();
	}
}  
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	obj_pg.innerHTML = pg_str;
}
//------波膽顯示------ 
function ShowData_PD(obj_table,GameData,data_amount,odd_f_type){
  	var nowLeague = '';
	var nowDate = '';
 
	with(obj_table){
		//清除table資料
		while(rows.length > 1)
			deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
		for(i=0; i<data_amount; i++){
			var open_hot = false;
			if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
			//if(eval('top.'+top.sel_gtype+'_lname_ary').indexOf(GameData[i][2]+"-",0)==-1&&eval('top.'+top.sel_gtype+'_lname_ary')!='ALL') continue;
			//判斷是否為精選賽事聯盟
                        if(top.showtype=='hgft'||top.showtype=='hgfu'){
                                for(j=0;j<top.lid_arr.length;j++){
                                        if((top.lid_arr[j][1])==GameData[i][2]){
                                                open_hot = true;
                                                break;
                                        }
                                }
                                if(!open_hot)continue;
                                hot_gdate(GameData[i][1].substr(0,5));
                        }else{
				if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
			}
			var ar=0;
			flag = false;
			for(j=8; j<=34; j++)
				if(GameData[i][j] == '0'||GameData[i][j]==""){ ar++; 
					GameData[i][j]="";
				}
			if(ar=='27') continue			
			//判斷聯盟是否相同不同加一列顯示聯盟
			gdate = GameData[i][1].substr(0,5);
			if(nowLeague != GameData[i][2] || nowDate != gdate){
				nowLeague = GameData[i][2];
				nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.colSpan = 18;
					nowTD.className = 'b_hline';
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
			
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
			    //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
	
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 2;
				nowTD.innerHTML = GameData[i][1];
				//隊伍--主隊名
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][5];
				//波膽
				nowTD = insertCell(); //H1C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C0\" target=\"mem_order\" title="1:0"><font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C0\" target=\"mem_order\" title="2:0"><font '+checkRatio_font(i,9)+'>'+GameData[i][9]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C1\" target=\"mem_order\" title="2:1"><font '+checkRatio_font(i,10)+'>'+GameData[i][10]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C0\" target=\"mem_order\" title="3:0"><font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C1\" target=\"mem_order\" title="3:1"><font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C2\" target=\"mem_order\" title="3:2"><font '+checkRatio_font(i,13)+'>'+GameData[i][13]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C0\" target=\"mem_order\" title="4:0"><font '+checkRatio_font(i,14)+'>'+GameData[i][14]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C1\" target=\"mem_order\" title="4:1"><font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C2\" target=\"mem_order\" title="4:2"><font '+checkRatio_font(i,16)+'>'+GameData[i][16]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C3\" target=\"mem_order\" title="4:3"><font '+checkRatio_font(i,17)+'>'+GameData[i][17]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C0
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C0\" target=\"mem_order\" title="0:0"><font '+checkRatio_font(i,18)+'>'+GameData[i][18]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C1
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C1\" target=\"mem_order\" title="1:1"><font '+checkRatio_font(i,19)+'>'+GameData[i][19]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C2
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C2\" target=\"mem_order\" title="2:2"><font '+checkRatio_font(i,20)+'>'+GameData[i][20]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C3
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C3\" target=\"mem_order\" title="3:3"><font '+checkRatio_font(i,21)+'>'+GameData[i][21]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C4
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C4\" target=\"mem_order\" title="4:4"><font '+checkRatio_font(i,22)+'>'+GameData[i][22]+'</A></font>&nbsp;';
				nowTD = insertCell();  //OVH
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=OVH\" target=\"mem_order\" title="Other Score"><font '+checkRatio_font(i,23)+'>'+GameData[i][23]+'</A></font>&nbsp;';
			}//主隊TR結束
    
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
				//隊伍--客隊名
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][6];
				//波膽
				nowTD = insertCell(); //H0C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C1\" target=\"mem_order\" title="0:1"><font '+checkRatio_font(i,24)+'>'+GameData[i][24]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C2\" target=\"mem_order\" title="0:2"><font '+checkRatio_font(i,25)+'>'+GameData[i][25]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C2\" target=\"mem_order\" title="1:2"><font '+checkRatio_font(i,26)+'>'+GameData[i][26]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C3\" target=\"mem_order\" title="0:3"><font '+checkRatio_font(i,27)+'>'+GameData[i][27]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C3\" target=\"mem_order\" title="1:3"><font '+checkRatio_font(i,28)+'>'+GameData[i][28]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C3\" target=\"mem_order\" title="2:3"><font '+checkRatio_font(i,29)+'>'+GameData[i][29]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C4\" target=\"mem_order\" title="0:4"><font '+checkRatio_font(i,30)+'>'+GameData[i][30]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C4\" target=\"mem_order\" title="1:4"><font '+checkRatio_font(i,31)+'>'+GameData[i][31]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C4\" target=\"mem_order\" title="2:4"><font '+checkRatio_font(i,32)+'>'+GameData[i][32]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C4\" target=\"mem_order\" title="3:4"><font '+checkRatio_font(i,33)+'>'+GameData[i][33]+'</A></font>&nbsp;';
//				nowTD = insertCell();  //OVC
//				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_pd.php?gid='+GameData[i][0]+'&uid='+uid+'&rtype=OVC\" target=\"mem_order\">'+GameData[i][34]+'</A>';
			}//客隊TR結束
			
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 18;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示波膽結束
</script>
<?
break;
case 'hpd':
?>
<script> 
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}		
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	ShowData_PD(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;	
 
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
                obj_sel = body_browse.document.getElementById('sel_league');
                obj_sel.style.display='none';
                try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
        }else{
		show_page();
	}
}  
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	obj_pg.innerHTML = pg_str;
}
//------波膽顯示------ 
function ShowData_PD(obj_table,GameData,data_amount,odd_f_type){
  	var nowLeague = '';
	var nowDate = '';
 
	with(obj_table){
		//清除table資料
		while(rows.length > 1)
			deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
		for(i=0; i<data_amount; i++){
			var open_hot = false;
			if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
			//if(eval('top.'+top.sel_gtype+'_lname_ary').indexOf(GameData[i][2]+"-",0)==-1&&eval('top.'+top.sel_gtype+'_lname_ary')!='ALL') continue;
			//alert(eval('parent.'+sel_gtype+'_lname_ary')+"===>"+(GameData[i][2].replace(/&#/g,"+-")+"-")+"====>>"+(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)));
			//判斷是否為精選賽事聯盟
                        if(top.showtype=='hgft'||top.showtype=='hgfu'){
                                for(j=0;j<top.lid_arr.length;j++){
                                        if((top.lid_arr[j][1])==GameData[i][2]){
                                                open_hot = true;
                                                break;
                                        }
                                }
                                if(!open_hot)continue;
                                hot_gdate(GameData[i][1].substr(0,5));
                        }else{
				if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
			}
			var ar=0;
			flag = false;
			for(j=8; j<=34; j++)
				if(GameData[i][j] == '0'||GameData[i][j]==""){ ar++; 
					GameData[i][j]="";
				}
			if(ar=='27') continue
			//判斷聯盟是否相同不同加一列顯示聯盟
			gdate = GameData[i][1].substr(0,5);
			if(nowLeague != GameData[i][2] || nowDate != gdate){
				nowLeague = GameData[i][2];
				nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.colSpan = 18;
					nowTD.className = 'b_hline';
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
			
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
			    //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 2;
				nowTD.innerHTML = GameData[i][1];
				//隊伍--主隊名
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][5];
				//波膽
				nowTD = insertCell(); //H1C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C0\" target=\"mem_order\" title="1:0"><font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C0\" target=\"mem_order\" title="2:0"><font '+checkRatio_font(i,9)+'>'+GameData[i][9]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C1\" target=\"mem_order\" title="2:1"><font '+checkRatio_font(i,10)+'>'+GameData[i][10]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C0\" target=\"mem_order\" title="3:0"><font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C1\" target=\"mem_order\" title="3:1"><font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C2\" target=\"mem_order\" title="3:2"><font '+checkRatio_font(i,13)+'>'+GameData[i][13]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C0
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C0\" target=\"mem_order\" title="4:0"><font '+checkRatio_font(i,14)+'>'+GameData[i][14]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C1\" target=\"mem_order\" title="4:1"><font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C2\" target=\"mem_order\" title="4:2"><font '+checkRatio_font(i,16)+'>'+GameData[i][16]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C3\" target=\"mem_order\" title="4:3"><font '+checkRatio_font(i,17)+'>'+GameData[i][17]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C0
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C0\" target=\"mem_order\" title="0:0"><font '+checkRatio_font(i,18)+'>'+GameData[i][18]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C1
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C1\" target=\"mem_order\" title="1:1"><font '+checkRatio_font(i,19)+'>'+GameData[i][19]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C2
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C2\" target=\"mem_order\" title="2:2"><font '+checkRatio_font(i,20)+'>'+GameData[i][20]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C3
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C3\" target=\"mem_order\" title="3:3"><font '+checkRatio_font(i,21)+'>'+GameData[i][21]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H4C4
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H4C4\" target=\"mem_order\" title="4:4"><font '+checkRatio_font(i,22)+'>'+GameData[i][22]+'</A></font>&nbsp;';
				nowTD = insertCell();  //OVH
				nowTD.rowSpan = 2;
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=OVH\" target=\"mem_order\" title="Other Score"><font '+checkRatio_font(i,23)+'>'+GameData[i][23]+'</A></font>&nbsp;';
			}//主隊TR結束
    
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
				//隊伍--客隊名
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][6];
				//波膽
				nowTD = insertCell(); //H0C1
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C1\" target=\"mem_order\" title="0:1"><font '+checkRatio_font(i,24)+'>'+GameData[i][24]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C2\" target=\"mem_order\" title="0:2"><font '+checkRatio_font(i,25)+'>'+GameData[i][25]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C2
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C2\" target=\"mem_order\" title="1:2"><font '+checkRatio_font(i,26)+'>'+GameData[i][26]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C3\" target=\"mem_order\" title="0:3"><font '+checkRatio_font(i,27)+'>'+GameData[i][27]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C3\" target=\"mem_order\" title="1:3"><font '+checkRatio_font(i,28)+'>'+GameData[i][28]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C3
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C3\" target=\"mem_order\" title="2:3"><font '+checkRatio_font(i,29)+'>'+GameData[i][29]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H0C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H0C4\" target=\"mem_order\" title="0:4"><font '+checkRatio_font(i,30)+'>'+GameData[i][30]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H1C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H1C4\" target=\"mem_order\" title="1:4"><font '+checkRatio_font(i,31)+'>'+GameData[i][31]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H2C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H2C4\" target=\"mem_order\" title="2:4"><font '+checkRatio_font(i,32)+'>'+GameData[i][32]+'</A></font>&nbsp;';
				nowTD = insertCell(); //H3C4
				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=H3C4\" target=\"mem_order\" title="3:4"><font '+checkRatio_font(i,33)+'>'+GameData[i][33]+'</A></font>&nbsp;';
//				nowTD = insertCell();  //OVC
//				nowTD.innerHTML = '<a href=\"../FT_order/FT_order_hpd.php?gid='+GameData[i][0]+'&uid='+uid+'&rtype=OVC\" target=\"mem_order\">'+GameData[i][34]+'</A>';
			}//客隊TR結束
			
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 18;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示波膽結束
</script>
<?
break;
case 't':
?>
<script> 
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}	
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	ShowData_EO(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
                obj_sel = body_browse.document.getElementById('sel_league');
                obj_sel.style.display='none';
                try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
        }else{
		show_page();
	}
}
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	obj_pg.innerHTML = pg_str;
}
 //------總入球顯示------
function ShowData_EO(obj_table,GameData,data_amount,odd_f_type){
	var nowLeague = '';
	var nowDate = '';
 
	with(obj_table){
		//清除table資料
		while(rows.length > 1)
			deleteRow(rows.length-1);
		//開始顯示總入球賽程資料
		for(i=0; i<data_amount; i++){
			var open_hot = false;
		    if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
			//if(eval('top.'+top.sel_gtype+'_lname_ary').indexOf(GameData[i][2]+"-",0)==-1&&eval('top.'+top.sel_gtype+'_lname_ary')!='ALL') continue;
			//判斷是否為精選賽事聯盟
                        if(top.showtype=='hgft'||top.showtype=='hgfu'){
                                for(j=0;j<top.lid_arr.length;j++){
                                        if((top.lid_arr[j][1])==GameData[i][2]){
                                                open_hot = true;
                                                break;
                                        }
                                }
                                if(!open_hot)continue;
                                hot_gdate(GameData[i][1].substr(0,5));
                        }else{
				if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
			}
			//判斷是否單雙或總入球都有賠率
			//if(!(GameData[i][8]&&GameData[i][9]) && (!GameData[i][10]&&!GameData[i][11]&&!GameData[i][12]&&!GameData[i][13]))
//			if ((GameData[i][14]*1) <= 0 || (GameData[i][15]*1) <= 0 || (GameData[i][16]*1) <= 0) {
//				GameData[i][14]='';
//				GameData[i][15]='';
//				GameData[i][16]='';
//			}
			if ((GameData[i][14]*1) <= 0 || (GameData[i][15]*1) <= 0) {
				GameData[i][14]='';
				GameData[i][15]='';
				GameData[i][16]='';
			}
			if((!GameData[i][10]&&!GameData[i][11]&&!GameData[i][12]&&!GameData[i][13]) && (!GameData[i][14]&&!GameData[i][15]&&!GameData[i][16]))
			continue;
//			if ((GameData[i][14]*1) <= 0 || (GameData[i][15]*1) <= 0 || (GameData[i][16]*1) <= 0) {
//				GameData[i][14]='&nbsp;';
//				GameData[i][15]='&nbsp;';
//				GameData[i][16]='&nbsp;';
//			}
			//判斷聯盟是否相同不同加一列顯示聯盟
			gdate = GameData[i][1].substr(0,5);
			if(nowLeague != GameData[i][2] || nowDate != gdate){
				nowLeague = GameData[i][2];
				nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.colSpan = 7;
					nowTD.className = 'b_hline';
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
 
 
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
			    //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
				//日期時間			
    			nowTD = insertCell();
    			nowTD.rowSpan = 3;
    			nowTD.innerHTML = GameData[i][1]+'<BR>';
				//隊伍
				nowTR.className = 'b_cen';
				nowTD = nowTR.insertCell();
				nowTD.rowSpan = 2;
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
				/*
				//單數
				nowTD = insertCell();
				nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&rtype=ODD\" target=\"mem_order\">'+GameData[i][8]+'</A>';
				//雙數
				nowTD = insertCell();
				nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&rtype=EVEN\" target=\"mem_order\">'+GameData[i][9]+'</A>';
				*/
				
				//獨贏主隊
				nowTD = insertCell();
				if ((GameData[i][14]*1) > 0){
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_m.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,14)+'>'+GameData[i][14]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
				//0~1
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=0~1\" target=\"mem_order\" title="0~1"><font '+checkRatio_font(i,10)+'>'+GameData[i][10]+'</A></font>&nbsp;';
				//2~3
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=2~3\" target=\"mem_order\" title="2~3"><font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</A></font>&nbsp;';
				//4~6
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=4~6\" target=\"mem_order\" title="4~6"><font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</A></font>&nbsp;';
				//OVER
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = '<A href=\"../FT_order/FT_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=OVER\" target=\"mem_order\" title="7up"><font '+checkRatio_font(i,13)+'>'+GameData[i][13]+'</A></font>&nbsp;';
			}
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
				nowTD = insertCell();
				if ((GameData[i][15]*1) > 0){	
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_m.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
			}
			nowTR = insertRow();
			nowTR.className = 'b_cen';
			with(nowTR){
				nowTD = insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = str_even;
				//獨贏和局
				nowTD = insertCell();
				if ((GameData[i][14]*1) > 0&&(GameData[i][15]*1) > 0&&(GameData[i][16]*1) > 0){
					nowTD.innerHTML = '<A href=\"../FT_order/FT_order_m.php?gid='+GameData[i][0]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\" target=\"mem_order\" title=\"'+str_even+'\"><font '+checkRatio_font(i,16)+'>'+GameData[i][16]+'</A></font>&nbsp;';
				}else{
					nowTD.innerHTML = '&nbsp;';
				}
				//nowTD = insertCell();
				//nowTD.colSpan = 2;
			}//和局TR結束
			
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 7;
				nowTD.height = 1;
			}//分隔線TR
 
		}
	}//with(obj_table);
}//顯示總入球結束
</script>
<?
break;
case 'f':
?>
<script> 
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}	
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	ShowData_F(game_table,GameFT,gamount,top.odd_f_type);
	parent.gamecount=gamount;	
 
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
                obj_sel = body_browse.document.getElementById('sel_league');
                obj_sel.style.display='none';
                try{
			var obj_date='';
			obj_date=body_browse.document.getElementById("g_date").value;
			body_browse.selgdate("",obj_date);
		}catch(E){}
        }else{
		show_page();
	}
}  
var hotgdateArr =new Array();
function hot_gdate(gdate){
	if((""+hotgdateArr).indexOf(gdate)==-1){
		hotgdateArr.push(gdate);
	}
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	obj_pg.innerHTML = pg_str;
}
//------半全場顯示------ 
function ShowData_F(obj_table,GameData,data_amount,odd_f_type){
	var nowLeague = '';
	var nowDate = '';
 
	with(obj_table){
		//清除table資料
		while(rows.length > 1)
			deleteRow(rows.length-1);
			//開始顯示開放中賽程資料
			for(i=0; i<data_amount; i++){
				var open_hot = false;
			    if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
				//判斷是否為精選賽事聯盟
                                if(top.showtype=='hgft'||top.showtype=='hgfu'){
                                        for(j=0;j<top.lid_arr.length;j++){
                                                if((top.lid_arr[j][1])==GameData[i][2]){
                                                        open_hot = true;
                                                        break;
                                                }
                                        }
                                        if(!open_hot)continue;
                                        hot_gdate(GameData[i][1].substr(0,5));
                                }else{
					if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2]+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
                                }
                                //判斷是否半全場都有賠率
                                flag = 0;
                                for(j=8; j<=16; j++)
                                        if(GameData[i][j] == '')
                                                { flag++;}
                                if(flag==9) continue;
                                
				//判斷聯盟是否相同不同加一列顯示聯盟
				gdate = GameData[i][1].substr(0,5);
				if(nowLeague != GameData[i][2] || nowDate != gdate){
					nowLeague = GameData[i][2];
					nowDate = gdate;
					nowTR = insertRow();
					with(nowTR){
						nowTD = insertCell();
						nowTD.colSpan = 18;
						nowTD.className = 'b_hline';
						nowTD.innerHTML = GameData[i][2];
						//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
						//"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
					}
				}
				
				nowTR = insertRow();
				nowTR.className = 'b_cen';
				with(nowTR){
    			    //滾球字眼
    			    GameData[i][1]=GameData[i][1].replace("Running Ball","");
    				//日期時間
					nowTD = insertCell();
					nowTD.align = 'center';
					nowTD.innerHTML = GameData[i][1];
					//隊伍--主隊名
					nowTD = nowTR.insertCell();
					nowTD.align = 'left';
					nowTD.innerHTML = GameData[i][5]+'<br>'+GameData[i][6];
					//半全場
					nowTD = insertCell(); //H0C1
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FHH\" target=\"mem_order\" title="H/H"><font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H0C2
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FHN\" target=\"mem_order\" title="H/D"><font '+checkRatio_font(i,9)+'>'+GameData[i][9]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H1C2
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FHC\" target=\"mem_order\" title="H/A"><font '+checkRatio_font(i,10)+'>'+GameData[i][10]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H0C3
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FNH\" target=\"mem_order\" title="D/H"><font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H1C3
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FNN\" target=\"mem_order\" title="D/D"><font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H2C3
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FNC\" target=\"mem_order\" title="D/A"><font '+checkRatio_font(i,13)+'>'+GameData[i][13]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H0C4
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FCH\" target=\"mem_order\" title="A/H"><font '+checkRatio_font(i,14)+'>'+GameData[i][14]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H1C4
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FCN\" target=\"mem_order\" title="A/D"><font '+checkRatio_font(i,15)+'>'+GameData[i][15]+'</A></font>&nbsp;';
					nowTD = insertCell(); //H2C4
					nowTD.align = 'center';
					nowTD.innerHTML = '<a href=\"../FT_order/FT_order_f.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=FCC\" target=\"mem_order\" title="A/A"><font '+checkRatio_font(i,16)+'>'+GameData[i][16]+'</A></font>&nbsp;';
				}//主隊TR結束
			nowTR = insertRow();
			with(nowTR){
				nowTD = insertCell();
				nowTD.colSpan = 18;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示半全場結束 
</script>
<?
break;
case 'p3':
?>
<script> 
var show_more_str="";
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}
  	ShowData_PR(game_table,GameFT,gamount);
	parent.gamecount=gamount;
	show_more_str="";
	if(top.showtype=='hgft'||top.showtype=='hgfu'){
                obj_sel = body_browse.document.getElementById('sel_league');
                obj_sel.style.display='none';
        }
}
 
//------讓球過關顯示------
function ShowData_PR(obj_div,GameData,data_amount){
   /*------------------------------------------------
   * 最後修改日期 --- 2005/7/19						*
   * 修改者   --- anson								*
   * 修改部份 --- function ShowData_PR ()			*
   -------------------------------------------------*/
 
/* GameFT Array		gid, gdate, league, gnum_h, gnum_c, team_h, team_c, strong, 讓球球頭, PRH賠率, PRC賠率, 大小球頭, POUH賠率, POUC賠率
					 0	   1	  2		  3		  4		  5		  6		  7			8		9		 10		  11,12		13			14
*/
	var nowLeague = '';
	var nowDate = '';
	var firstFlag = 1;
	var layers="";
	gcount = 0;
	gc = 0;
	//清除div資料
	obj_div.innerHTML = "";
//	more_DIV = body_browse.document.getElementById('show_play').innerHTML;
	//開始顯示讓球過關賽程資料
	for(i=0; i < data_amount; i++){
		var open_hot = false;
		if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
		//if(eval('top.'+top.sel_gtype+'_lname_ary').indexOf(GameData[i][2]+"-",0)==-1&&eval('top.'+top.sel_gtype+'_lname_ary')!='ALL') continue;
		//判斷是否為精選賽事聯盟
                if(top.showtype=='hgft'||top.showtype=='hgfu'){
                        for(j=0;j<top.lid_arr.length;j++){
                                if((top.lid_arr[j][1])==GameData[i][2]){
                                        open_hot = true;
                                        break;
                                }
                        }
                        if(!open_hot){gc++;continue;}
                }else{
			if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') {gc++;continue;}
		}
		//判斷是否讓球兩個賠率都有值,否則不顯示
		if((GameData[i][9]=='' || GameData[i][10]=='') && (GameData[i][12]=="" || GameData[i][13]== "")){
			gc++;
			continue;
		}
 
		//判斷聯盟是否相同不同加一列顯示聯盟
		//滾球字眼過關只秀時間
		GameData[i][1]=GameData[i][1].replace("<br><font color=red>Running Ball</font>","");
		gdate = GameData[i][1].substr(0,5);
		if(nowLeague != GameData[i][2] || nowDate != gdate){
			if(nowDate != gdate){
				if(!firstFlag){
					nowTR = obj_table.insertRow();
					nowTR.bgColor = '#FFFFFF';
					nowTR.align = 'center';
					nowTR.height = 30;
					nowTD = nowTR.insertCell();
					nowTD.colSpan = 10;
					if(gcount > 1){
						nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"teamcount\" VALUE=\"'+gcount+'\">'+
										  '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
										  '<input type=SUBMIT id=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"yes\">&nbsp;&nbsp;&nbsp;';
					}
 
					nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"no\" onClick=\"parent.ShowGameList();\">';
				}//if(!firstFlag)
				firstFlag = 0;
				nowDate = gdate;
				showDate = gdate.substr(0,2)+''+gdate.substr(3,2);
				gcount = 0;
				obj_div.innerHTML += '<TABLE ID=\"gtable'+showDate+'\" width=\"526\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"game\">'+
									 '<TR><TD><FORM ID=\"form'+showDate+'\" NAME=\"form'+showDate+'\" ACTION=\"/app/member/FT_order/FT_order_p3.php\" METHOD=POST onSubmit=\"return ChkSelect(\''+showDate+'\'); reload_var();\" target=\"mem_order\"></TD></TR>'+
									 '</TABLE><span id="more_sp_'+showDate+'\"></span></FORM>';
				obj_table = body_browse.document.getElementById('gtable'+showDate);
				//多種玩法
				more_span = body_browse.document.getElementById('more_sp_'+showDate);
				layers="";
			}//if(nowDate != gdate)
 
			nowLeague = GameData[i][2];
			nowTR = obj_table.insertRow();
			nowTD = nowTR.insertCell();
			nowTD.className = 'b_hline';
			nowTD.colSpan = 10;
			nowTD.innerHTML = GameData[i][2]+'&nbsp;&nbsp;'+nowDate;
			//nowTD.innerHTML = "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"&nbsp;&nbsp;"+nowDate+"</td>"+
			//				  "<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
			//nowTD.innerHTML = GameData[i][2]+'&nbsp;&nbsp;'+nowDate+'&nbsp;<img src=\"../../images/member/new_2.gif\" title=\"'+top.str_renew+'\" style=\"cursor:hand\" name=\"ReloadLeague'+i+'\" onClick=\"reload_var();\" class=\"div_right\">';
		}//if(nowLeague != GameData[i][2] || nowDate != gdate)
 
		gcount++;
		nowTR = obj_table.insertRow();
		nowTR.id="p3";
		nowTR.className = 'b_cen';
		with(nowTR){
			var tmp_team = "";
			//日期時間(過關只秀時間)
			nowTD = insertCell();
			nowTD.rowSpan = 3;
			//nowTD.width = "8%";
			nowTD.className ='time';
 
			nowTD.innerHTML = '<INPUT type=\"HIDDEN\" NAME=\"game_id'+gcount+'\" VALUE=\"'+GameData[i][0]+'\"><INPUT type=\"HIDDEN\" NAME=\"Hgame_id'+gcount+'\" VALUE=\"'+GameData[i][60]+'\">'+GameData[i][1].slice(-6,15);
 
			//場次
			nowTD = insertCell();
			nowTD.rowSpan = 3;
			//nowTD.width = "8%";
			nowTD.className ='num';
			nowTD.innerHTML = GameData[i][3]+"<BR>"+GameData[i][4];
			// 主客隊名
			nowTD = insertCell();
			//nowTD.width = "27%";
			nowTD.className ='team';
			nowTD.align = "left";
			nowTD.innerHTML = GameData[i][5]+"<BR>"+GameData[i][6];
 
			//獨贏
			nowTD = insertCell();
			nowTD.className ='pm';
			nowTD.align = "right";
 
			if ((GameData[i][17]*1>0) && (GameData[i][18]*1>0)&& (GameData[i][19]*1>0)){
				tmp_team  ="<font "+checkRatio_font(i,17)+" class=r_bold>"+GameData[i][17]+"</font>&nbsp;<input type='radio' name='game"+gcount+"' value='MH' class='za_dot' title=\""+GameData[i][5]+"\">&nbsp;";
				tmp_team += "<BR>";
				tmp_team +="<font "+checkRatio_font(i,18)+" class=r_bold>"+GameData[i][18]+"</font>&nbsp;<input type='radio' name='game"+gcount+"' value='MC' class='za_dot' title=\""+GameData[i][6]+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}else{
				tmp_team  ="&nbsp;";
				tmp_team += "<BR>";
				tmp_team +="&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
 
			//==== 讓球
			nowTD = insertCell();
			//nowTD.width = "17%";
			nowTD.className ='pr';
			nowTD.align = "right";
			//nowTD.width = 100;
			tmp_team="";
			if (GameData[i][9] != "" && GameData[i][10] != ""){
				//強隊讓球賠率
				if(GameData[i][7] == 'H') {tmp_team = "<font "+checkRatio_font(i,8)+" color='#000000'>"+GameData[i][8]+"</font>&nbsp;&nbsp;";}
				tmp_team += "<font "+checkRatio_font(i,9)+" class=r_bold>"+GameData[i][9]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='PRH' class='za_dot' title=\""+GameData[i][5]+"\">&nbsp;<BR>";
				//強隊是客隊
				if(GameData[i][7] == 'C') {tmp_team += "<font "+checkRatio_font(i,8)+" color='#000000'>"+GameData[i][8]+"</font>&nbsp;&nbsp;";}
				tmp_team += "<font "+checkRatio_font(i,10)+" class=r_bold>"+GameData[i][10]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='PRC' class='za_dot' title=\""+GameData[i][6]+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
 
			//==== 大小球
			nowTD = insertCell();
			//nowTD.width = "17%";
			nowTD.className ='ou';
			nowTD.align = "right";
			//nowTD.width = 90;
			if (GameData[i][13] != "" && GameData[i][14] != ""){
				if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
				tmp_team  = "<font "+checkRatio_font(i,11)+" color='#000000'>"+GameData[i][11]+"</font>&nbsp;&nbsp;";	//大
				tmp_team += "<font "+checkRatio_font(i,13)+" class=r_bold>"+GameData[i][13]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='POUC' class='za_dot' title=\""+title_str+"\">&nbsp;";
				tmp_team += "<BR>";
				 if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				tmp_team += "<font "+checkRatio_font(i,12)+" color='#000000'>"+GameData[i][12]+"</font>&nbsp;&nbsp;";	//小
				tmp_team += "<font "+checkRatio_font(i,14)+" class=r_bold>"+GameData[i][14]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='POUH' class='za_dot' title=\""+title_str+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
			//==== 單雙
			nowTD = insertCell();
			//nowTD.width = "9%";
			nowTD.className ='eo';
			nowTD.align = "right";
			//nowTD.width = 50;
			if (GameData[i][15] != "" && GameData[i][16] != ""){
				if(langx=="zh-tw"){
					var str_o="單";
					var str_e="雙";
				}
				if(langx=="zh-cn"){
					var str_o="单";
					var str_e="双";
				}
				if(langx=="en-us"||langx=="th-tis"){
					var str_o="o";
					var str_e="e";
				}
				tmp_team  = str_o+"&nbsp;&nbsp;<font "+checkRatio_font(i,15)+" class=r_bold>"+GameData[i][15]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='PO' class='za_dot' title=\""+str_o+"\">&nbsp;";
				tmp_team += "<BR>";
				tmp_team += str_e+"&nbsp;&nbsp;<font "+checkRatio_font(i,16)+" class=r_bold>"+GameData[i][16]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='PE' class='za_dot' title=\""+str_e+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
			
			//上半獨贏
			nowTD = insertCell();
			nowTD.className ='hpm2';
			nowTD.align = "right";
			tmp_team="";
			//alert("HPMH==>"+GameData[i][96]+"==HPMC===>"+GameData[i][97]+"===>HPMN===>"+GameData[i][98]);
			if ((GameData[i][96]*1>0) && (GameData[i][97]*1>0)&& (GameData[i][98]*1>0)){
				tmp_team  ="<font "+checkRatio_font(i,96)+" class=r_bold>"+GameData[i][96]+"</font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPMH' class='za_dot' title=\""+GameData[i][5]+"\">&nbsp;";
				tmp_team += "<BR>";
				tmp_team +="<font "+checkRatio_font(i,97)+" class=r_bold>"+GameData[i][97]+"</font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPMC' class='za_dot' title=\""+GameData[i][6]+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}else{
				tmp_team  ="&nbsp;";
				tmp_team += "<BR>";
				tmp_team +="&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
			
			//==== 上半讓球
			nowTD = insertCell();
			//nowTD.width = "14%";
 
			nowTD.className = 'b_1st_S';
			//nowTD.align = "right";
			//nowTD.width = 100;
			tmp_team="";
			if (GameData[i][63] != "" && GameData[i][64] != ""){
				//強隊讓球賠率
				if(GameData[i][61] == 'H') {tmp_team = "<font "+checkRatio_font(i,62)+" color='#000000'>"+GameData[i][62]+"</font>&nbsp;&nbsp;";}
				tmp_team += "<font "+checkRatio_font(i,63)+" class=r_bold>"+GameData[i][63]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPRH' class='za_dot' title=\""+GameData[i][5]+"\">&nbsp;<BR>";
				//強隊是客隊
				if(GameData[i][61] == 'C') {tmp_team += "<font "+checkRatio_font(i,62)+" color='#000000'>"+GameData[i][62]+"</font>&nbsp;&nbsp;";}
				tmp_team += "<font "+checkRatio_font(i,64)+" class=r_bold>"+GameData[i][64]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPRC' class='za_dot' title=\""+GameData[i][6]+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
 
			//==== 上半大小
			nowTD = insertCell();
			//nowTD.width = "14%";
			nowTD.className = 'b_1st_R';
			//nowTD.align = "right";
			//nowTD.width = 150;
			if (GameData[i][67] != "" && GameData[i][68] != ""){
				if(langx=="zh-tw"){
						title_str="大";
					}
				if(langx=="zh-cn"){
					title_str="大";
				}
				if(langx=="en-us"||langx=="th-tis"){
					title_str="Over";
				}
				tmp_team  = "<font "+checkRatio_font(i,65)+" color='#000000'>"+GameData[i][65]+"</font>&nbsp;&nbsp;";	//大
				tmp_team += "<font "+checkRatio_font(i,68)+" class=r_bold>"+GameData[i][68]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPOUC' class='za_dot' title=\""+title_str+"\">&nbsp;";
				tmp_team += "<BR>";
				if(langx=="zh-tw"){
					title_str="小";
				}
				if(langx=="zh-cn"){
					title_str="小";
				}
				if(langx=="en-us"||langx=="th-tis"){
					title_str="Under";
				}
				tmp_team += "<font "+checkRatio_font(i,66)+" color='#000000'>"+GameData[i][66]+"</font>&nbsp;&nbsp;";	//小
				tmp_team += "<font "+checkRatio_font(i,67)+" class=r_bold>"+GameData[i][67]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPOUH' class='za_dot' title=\""+title_str+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
		}
		nowTR =  obj_table.insertRow();
 
		nowTR.id="p3";
		nowTR.className = 'b_cen';
		with(nowTR){
			nowTD = insertCell();
			nowTD.align = 'left';
			nowTD.innerHTML = str_even;
			//獨贏和局
			nowTD = insertCell();
			nowTD.align = "right";
			if ((GameData[i][17]*1) > 0&&(GameData[i][18]*1) > 0&&(GameData[i][19]*1) > 0){
				nowTD.innerHTML = "<font "+checkRatio_font(i,19)+" class=r_bold>"+GameData[i][19]+"</font>&nbsp;<input type='radio' name='game"+gcount+"' value='MN' class='za_dot' title=\""+str_even+"\">&nbsp;";
			}else{
				nowTD.innerHTML = '&nbsp;';
			}
			nowTD = insertCell();
			nowTD.colSpan = 3;
 
			if(game_more=='0'||GameData[i][99]=="0") nowTD.innerHTML ='';
			else nowTD.innerHTML ='<A href=\"javascript:\" onClick=\"parent.show_more(\''+GameData[i][0]+'\',\''+i+'\',\''+gcount+'\',\''+showDate+'\');\">'+str_more+'('+GameData[i][99]+')'+'</A>' ;
			//if(game_more=='0') nowTD.innerHTML ='';
			//else nowTD.innerHTML ='<A href=\"javascript:\" onClick=\"parent.show_more(\''+GameData[i][0]+'\',\''+i+'\',\''+gcount+'\',\''+showDate+'\');\">'+str_more+'</A>' ;
				
			nowTD = insertCell();
			nowTD.className = 'hpm2';
			nowTD.align = "right";	
			//上半獨贏和局
			if ((GameData[i][96]*1) > 0&&(GameData[i][97]*1) > 0&&(GameData[i][98]*1) > 0){
				nowTD.innerHTML = "<font "+checkRatio_font(i,98)+" class=r_bold>"+GameData[i][98]+"</font>&nbsp;<input type='radio' name='game"+gcount+"' value='HPMN' class='za_dot' title=\""+str_even+"\">&nbsp;";
			}else{
				nowTD.innerHTML = '&nbsp;';
			}
			
			nowTD = insertCell();
			nowTD.className = 'hpm2';
			nowTD.colSpan = 2;
 
		}//和局TR結束
 
		nowTR =  obj_table.insertRow();
		with(nowTR){
			nowTD = insertCell();
			nowTD.colSpan = 10;
			nowTD.height = 1;
		}//分隔線TR
 
		//多種玩法
//		layers += layer_screen(GameData,i,more_DIV,gcount);
//		more_span.innerHTML=layers;
 
	}//with(nowTR)
	//判斷賽事數量兩場以上就顯示確認按鈕
	if((data_amount-gc)!=0){
		nowTR = obj_table.insertRow();
		nowTR .bgColor = '#FFFFFF';
		nowTR.align = 'center';
		nowTR.height = 30;
		nowTD = nowTR.insertCell();
		nowTD.colSpan = 10;
		if(gcount > 1){
			nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"teamcount\" VALUE=\"'+gcount+'\">'+
							  '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
							  '<input type=SUBMIT id=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"yes\">&nbsp;&nbsp;&nbsp;';
		}
		nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"no\" onClick=\"parent.ShowGameList();\">';
	}
	
}//讓球過關結束
 
function layer_screen(GameFT,index,layers,gcount){
	show_team = body_browse.document.getElementById('table_team');
	show_hpd = body_browse.document.getElementById('table_hpd');
	show_pd = body_browse.document.getElementById("table_pd");
	show_t = body_browse.document.getElementById("table_t");
	show_f = body_browse.document.getElementById("table_f");
	var tmp_stype="style=\"display:none;\"";
	gid=GameFT[index][0];
	Hgid=GameFT[index][60];
	layers=layers.replace("*GID*",GameFT[index][0]);
	
	//主客隊伍
	with(show_team){
		var tmp_team="";
		tmp_team=GameFT[index][5]+'&nbsp;&nbsp;<font color="#ff8000">VS.</font>&nbsp;&nbsp;'+GameFT[index][6];
		layers=layers.replace("*TEAM*",tmp_team);
		if (GameFT[index][99]=='0')layers=layers.replace("*table_team_sty*",tmp_stype);
	}
	
	//上半波膽
	with(show_hpd){
		var RM=new Array('HH1C0','HH2C0','HH2C1','HH3C0','HH3C1','HH3C2','HH4C0','HH4C1','HH4C2','HH4C3','HH0C0','HH1C1','HH2C2','HH3C3','HH4C4','HOVH','HH0C1','HH0C2','HH1C2','HH0C3','HH1C3','HH2C3','HH0C4','HH1C4','HH2C4','HH3C4');
		var vals=0;
		for (jj=0;jj< RM.length;jj++){
			if (GameFT[index][69+jj]*1>0){
				layers=layers.replace("*"+RM[jj]+"*",("<font class=r_bold>"+((GameFT[index][69+jj])*1)+"</font>&nbsp;<input type=radio value='"+RM[jj]+"' name='game"+gcount+"' class='za_dot'>&nbsp;"));
			}else{
				vals++;
				layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			}
		}
		if (vals==26)layers=layers.replace("*table_hpd_sty*",tmp_stype);
	}
 
	//波膽
	with(show_pd){
		var RM=new Array('H1C0','H2C0','H2C1','H3C0','H3C1','H3C2','H4C0','H4C1','H4C2','H4C3','H0C0','H1C1','H2C2','H3C3','H4C4','OVH','H0C1','H0C2','H1C2','H0C3','H1C3','H2C3','H0C4','H1C4','H2C4','H3C4');
		var vals=0;
		for (jj=0;jj< RM.length;jj++){
			if (GameFT[index][20+jj]*1>0){
				layers=layers.replace("*"+RM[jj]+"*",("<font class=r_bold>"+((GameFT[index][20+jj])*1)+"</font>&nbsp;<input type=radio value='"+RM[jj]+"' name='game"+gcount+"' class='za_dot'>&nbsp;"));
			}else{
				vals++;
				layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			}
		}
		if (vals==26)layers=layers.replace("*table_pd_sty*",tmp_stype);
	}
	
	//總入球
	with(show_t){
		var RM=new Array('0~1','2~3','4~6','OVER');
		var vals=0;
		for (jj=0;jj< RM.length;jj++){
			if (GameFT[index][47+jj]*1>0){
				layers=layers.replace("*"+RM[jj]+"*",("<font class=r_bold>"+((GameFT[index][47+jj])*1)+"</font>&nbsp;<input type=radio value='"+RM[jj]+"' name='game"+gcount+"' class='za_dot'>&nbsp;"));
			}else{
				vals++;
				layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			}
		}
		if (vals==4)layers=layers.replace("*table_t_sty*",tmp_stype);
	}
	
	//半全場
	with(show_f){
		var RM=new Array('FHH','FHN','FHC','FNH','FNN','FNC','FCH','FCN','FCC');
		var vals=0;
		for (jj=0;jj< RM.length;jj++){
			if (GameFT[index][51+jj]*1>0){
				layers=layers.replace("*"+RM[jj]+"*",("<font class=r_bold>"+((GameFT[index][51+jj])*1)+"</font>&nbsp;<input type=radio value='"+RM[jj]+"' name='game"+gcount+"' class='za_dot'>&nbsp;"));
			}else{
				vals++;
				layers=layers.replace("*"+RM[jj]+"*", "&nbsp;");
			}
		}
		if (vals==9)layers=layers.replace("*table_f_sty*",tmp_stype);
	}
 
 
	layers=layers.replace("*CLS*","onclick=\"document.all.Play"+GameFT[index][0]+".style.display='none'\"");
	return layers;
}
function show_more(gid,idx,gcount,showDate){
	var layers_str="";
	try{
		if(show_more_str.indexOf(","+idx+",",0)==-1){
			if (show_more_str==''){
				show_more_str=','+idx+',';
			}else{
				show_more_str+=idx+',';
			}
			more_DIV = body_browse.document.getElementById('show_play').innerHTML;
			more_span = body_browse.document.getElementById('more_sp_'+showDate);
			layers_str=more_span.innerHTML;
			layers_str+= layer_screen(GameFT,idx,more_DIV,gcount);
			more_span.innerHTML=layers_str;
		}
		try{
			var tmp_div_obj=eval("body_browse.document.all.Play"+parent.showgid);
			//var tmp_div_obj2=body_browse.document.all.show_play;
			tmp_div_obj.style.display='none';
			//tmp_div_obj2.style.display='none';
		}catch(E){}
		parent.showgid=gid;
		var div_obj=eval("body_browse.document.all.Play"+gid);
		div_obj.style.top=body_browse.document.body.scrollTop+body_browse.event.clientY;
		div_obj.style.left=body_browse.document.body.scrollLeft+7;
		div_obj.style.display='block';
		//tmp_div_obj2.style.display='block';
		div_obj.focus();
		//tmp_div_obj2.focus();
		//body_browse.document.all.show_play.focus();
 
	}catch(E){}
}
</script>
<?
break;
}
?>
<SCRIPT LANGUAGE="JAVASCRIPT"> 
<!--
//if(self == top) location='http://122.152.134.8/app/member/';
 
var username='';
var maxcredit='';
var code='';
var pg=0;
var sel_league='';	//選擇顯示聯盟
var uid='';		//user's session ID
var loading = 'Y';	//是否正在讀取瀏覽頁面
var loading_var = 'Y';	//是否正在讀取變數值頁面
var ShowType = '';	//目前顯示頁面
var ltype = 1;		//目前顯示line
var retime_flag = 'N';	//自動更新旗標
var retime = 0;		//自動更新時間
 
var str_even = '和局';
var str_renew = '秒自動更新';
var str_submit = '確認';
var str_reset = '重設';
 
var num_page = 20;	//設定20筆賽程一頁
var now_page = 1;	//目前顯示頁面
var pages = 1;		//總頁數
var msg = '';		//即時資訊
var gamount = 0;	//目前顯示一般賽程數
var GameFT = new Array(512); //最多設定顯示512筆開放賽程
var sel_gtype='FT';
var iorpoints=3;
// -->
</SCRIPT>
</head>
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0" style="height:510px;">
	<frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=3&delay=<?=$delay?>&league_id=<?=$league_id?>&showtype=<?=$showtype?>">
	<frame name="body_browse" src="body_browse.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=3&delay=<?=$delay?>&showtype=<?=$showtype?>">
</frameset>
<noframes><body bgcolor="#000000">
</body></noframes>
</html>

