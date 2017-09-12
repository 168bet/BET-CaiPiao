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

$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$g_date=$_REQUEST['g_date'];
$showtype=$_REQUEST['showtype'];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}

$date=date("Y-m-d");
$date1=date('Y-m-d',time()+24*60*60);
$date2=date('Y-m-d',time()+2*24*60*60);
$date3=date('Y-m-d',time()+3*24*60*60);
$date4=date('Y-m-d',time()+4*24*60*60);
$date5=date('Y-m-d',time()+5*24*60*60);
$date6=date('Y-m-d',time()+6*24*60*60);
$date7=date('Y-m-d',time()+7*24*60*60);
$date8=date('Y-m-d',time()+8*24*60*60);
$date9=date('Y-m-d',time()+9*24*60*60);
$date10=date('Y-m-d',time()+10*24*60*60);

if ($rtype!='p3'){
    $tab_id="id=game_table";
    $tab="id=box";
}else{
    $tab_id="id=p3";
    $tab="id=P3box";
}
switch ($rtype){
case "r":
	$caption=$Straight;
	$show="OU";
	$table='<tr> 
		    <th rowspan="2" class="time">'.$Times.'</th>
		    <th rowspan="2" class="team">'.$Home_Away.'</th>
		    <th colspan="4">'.$Full.'</th>
		    <th colspan="3" class="1st">'.$Half_1st.'</th>
		    </tr>
		    <tr>
		    <th>'.$WIN.'</th> 
		    <th>'.$HDP.'</th>
		    <th>'.$OU.'</th>
		    <th>'.$OE.'</th>
		    <th class="1st">'.$WIN.'</th>
		    <th class="1st">'.$HDP.'</th>
		    <th class="1st">'.$OU.'</th>
		    </tr>';
    break;
case "hr":
	$caption=$half_1st;
	$show="HR";
	$table='<tr>
            <th class="time" >'.$Times.'</th>
            <th class="team">'.$Home_Away.'</th>
            <th width="7%">'.$WIN.'</th>
            <th width="20%">'.$Handicap.'</th>
            <th width="20%">'.$Over_Under.'</th>
            </tr>';
	break;
case "pd":
	$caption=$Correct_Score;
	$show="PD";
	$upd_msg=$Correct_Score_maximum_FT;
	$table='<tr>
			<th class="time">'.$Times.'</th>
			<th >'.$Home_Away.'</th>
			<th >1:0</th>
			<th >2:0</th>
			<th >2:1</th>
			<th >3:0</th>
			<th >3:1</th>
			<th >3:2</th>
			<th >4:0</th>
			<th >4:1</th>
			<th >4:2</th>
			<th >4:3</th>
			<th >0:0</th>
			<th >1:1</th>
			<th >2:2</th>
			<th >3:3</th>
			<th >4:4</th>
			<th >'.$Others.'</th>
		    <tr>';
	break;
case "hpd":
	$caption=$Half_1st_Correct_Score;
	$show="PD";
	$upd_msg=$Correct_Score_maximum_FT;
	$table='<tr>
			<th class="time">'.$Times.'</th>
			<th >'.$Home_Away.'</th>
			<th >1:0</th>
			<th >2:0</th>
			<th >2:1</th>
			<th >3:0</th>
			<th >3:1</th>
			<th >3:2</th>
			<th >4:0</th>
			<th >4:1</th>
			<th >4:2</th>
			<th >4:3</th>
			<th >0:0</th>
			<th >1:1</th>
			<th >2:2</th>
			<th >3:3</th>
			<th >4:4</th>
			<th >'.$Others.'</th>
		    <tr>';
	break;
case "t":
	$caption=$Total_Goals;
	$show="EO";
	$upd_msg=$Total_Goals_maximum;
	$table='<tr>
			<th class="time">'.$Times.'</th>
			<th >'.$Home_Away.'</th>
			<th width="7%">'.$WIN.'</th>
			<th width="7%">0~1</th>
			<th width="7%">2~3</th>
			<th width="7%">4~6</th>
			<th width="7%">7up</th>
		    <tr>';
	break;
case "f":
	$caption=$Half_Full_Time;
	$show="F";
	$upd_msg=$Half_Full_Time_maximum;
	$table='<tr>
			<th class="time">'.$Times.'</th>
			<th >'.$Home_Away.'</th>
			<th>'.$HH.'</th>
			<th>'.$HD.'</th>
			<th>'.$HA.'</th>
			<th>'.$DH.'</th>
			<th>'.$DD.'</th>
			<th>'.$DA.'</th>
			<th>'.$AH.'</th>
			<th>'.$AD.'</th>
			<th>'.$AA.'</th>
		    <tr>';
	break;
case "p3":
	$caption=$Mix_Parlay;
	$show="P3";
	$upd_msg=$Mix_Parlay_maximum;
	$table='<tr> 
			<th rowspan="2" class="time">'.$Times.'</th>
			<th rowspan="2" class="num">'.$NO.'</th>
			<th rowspan="2" class="team">'.$Home_Away.'</th>
			<th colspan="4">'.$Full.'</th>
			<th colspan="3" class="1st">'.$Half_1st.'</th>
            </tr>
            <tr>
			<th class="pm">'.$WIN.'</th> 
			<th class="pr">'.$HDP.'</th>
			<th class="ou">'.$OU.'</th>
			<th class="eo">'.$OE.'</th>
			<th class="hpm">'.$WIN.'</th>
			<th class="1st">'.$HDP.'</th>
			<th class="1st2">'.$OU.'</th>
            </tr>';
	break;	
}
?>
<script> 
var DateAry = new Array('<?=$date1?>','<?=$date2?>','<?=$date3?>','<?=$date4?>','<?=$date5?>','<?=$date6?>','<?=$date7?>','<?=$date8?>','<?=$date9?>');
var rtype = '<?=$rtype?>';
var odd_f_str = 'H,M,I,E';
var lid_arr=new Array();
<? if ($showtype=='hgfu'){ ?>
lid_arr[0]=new Array('103420','世界盃2010','世界盃2010');
lid_arr[1]=new Array('103819','世界盃2010特別投注','世界盃2010特別投注');
lid_arr[2]=new Array('103820','世界盃2010特定15分鐘大小','世界盃特定15分');
lid_arr[3]=new Array('103824','世界盃2010延時','世界盃2010延時');
lid_arr[4]=new Array('103825','世界盃2010PK(讓球盤)','世界盃PK(讓球盤)');
lid_arr[5]=new Array('103826','世界盃2010PK(大小盤)','世界盃2010PK(大小盤)');
lid_arr[6]=new Array('103828','世界盃2010入圍八強賽隊伍','世界盃入圍八強賽隊伍');
lid_arr[7]=new Array('103829','世界盃2010 G組冠軍','世界盃2010 G組冠軍');
lid_arr[8]=new Array('103833','世界盃入圍4強賽隊伍','世界盃入圍4強賽隊伍');
lid_arr[9]=new Array('103834','世界盃2010延時特別投注','世界盃延時特別投注');
<? } ?>
top.lid_arr=lid_arr;
top.today_gmt = '<?=$date?>';
top.showtype = '<?=$showtype?>';
var Format=new Array();
Format[0]=new Array( 'H','<?=$HK_Odds?>','Y');
Format[1]=new Array( 'M','<?=$Malay_Odds?>','Y');
Format[2]=new Array( 'I','<?=$Indo_Odds?>','Y');
Format[3]=new Array( 'E','<?=$Euro_Odds?>','Y');
</script>
<script> 
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
top.S_EM="<?=$S_EM?>";
top.alldata="<?=$ALL?>";
top.webset="資訊網";
top.str_renew="更新";
top.outright="冠軍";
top.financial="金融";
 
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
top.str_RB = "<?=$Running_Ball?>";
 
 
 
top.str_ShowMyFavorite="我的最愛";
top.str_ShowAllGame="全部賽事";
top.str_delShowLoveI="移出";
</script>
 
<script> 
//盤口選擇 DIV
function ChkOddfDiv(tmpvalue){
	//判斷會員本身多盤口選擇是否為空值
	var obj = document.getElementById("odd_f_window");
	
	if(odd_f_str==""){
		alert("No Data");
	}else{
		obj.style.display = (obj.style.display == "none")? "block": "none";
		chkoddf("");
		document.getElementById("odd_f_window").style.top=document.body.scrollTop+event.clientY+10;
		document.getElementById("odd_f_window").style.left=document.body.scrollLeft+event.clientX+50;
		
	}
}
//盤口onclick事件
function chkoddf(value){
	var odd_show="";
	
	for (i = 0; i < Format.length; i++) {
		var tmp_check="";
		//沒盤口選擇時，預設為H(香港變盤)
		if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){
			if(value ==""&&top.odd_f_type==Format[i][0])tmp_check=" checked ";
			else if(value==Format[i][0])tmp_check=" checked ";
			odd_show+= "&nbsp;<input type='radio' name ='lineData["+Format[i][0]+"]' value='"+Format[i][0]+"'' onClick=\"chkoddf(this.value);\"  "+tmp_check+">"+Format[i][1]+"&nbsp;&nbsp;&nbsp;<br>";
		}
	}
	document.getElementById("show_odd_f").innerHTML = odd_show;	
	if(value !=""){
		top.odd_f_type=value;
		document.getElementById("odd_f_window").style.display = "none";	
		reload_var();
	}
}
 
//切換盤口
function chg_odd_type(){
	for (i = 0; i < Format.length; i++) {
		if(document.all("lineData["+Format[i][0]+"]")!= null)
		if(document.all("lineData["+Format[i][0]+"]").checked){
			top.odd_f_type=document.all("lineData["+Format[i][0]+"]").value;
		}
	}
	document.getElementById("odd_f_window").style.display = "none";	
	reload_var();
}
 
function show_oddf(){
	for (i = 0; i < Format.length; i++) {
		if(Format[i][0]==top.odd_f_type){
			document.getElementById("oddftext").innerHTML=Format[i][1];
		}
	}
	
}
 
</script>
 
<script>
 
// new array{球類 , new array {gid ,data time ,聯盟,H,C,sw}}
 
function addShowLoveI(gid,getDateTime,getLid,team_h,team_c){
	var getGtype =getGtypeShowLoveI();
	var getnum =top.ShowLoveIarray[getGtype].length;
	var sw =true;
	for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
		if(top.ShowLoveIarray[getGtype][i][0]==gid)
			sw = false;
	}
	if(sw){
		top.ShowLoveIarray[getGtype]= arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c));	
		//top.ShowLoveIarray[getGtype].push(new Array(gid,getDateTime,getLid,team_h,team_c));
		chkOKshowLoveI();
	}
	document.getElementById("sp_"+MM_imgId(getDateTime,gid)).innerHTML ="<img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \">";
	//parent.ShowGameList();
	parent.parent.header.showTable();
	futureShowGtypeTable()
	//chktdGtypeShowLoveI();
}
function arraySort(array ,data){
	var outarray =new Array();
	var newarray =new Array();
	for(var i=0;i < array.length ;i++){
		if(array[i][1]<= data[1]){
			outarray.push(array[i]);
		}else{
			newarray.push(array[i]);
		}
	}
	outarray.push(data);
	for(var i=0;i < newarray.length ;i++){
		outarray.push(newarray[i]);		
	}
	return  outarray;
}
 
function ShowBlankData(){
	var txt_data = trShowBlankData.innerHTML;
	var getGtype = getGtypeShowLoveI();
	var tmp_data ="";
	var Max =4;
	var tmplength = Max- top.ShowLoveIarray[getGtype].length ;
	for (var i=0 ; i < tmplength;  i++){
		tmp_data+=txt_data;
		tmp_time = "<BR><BR>";
		tmp_Team = (i==0 &&tmplength ==Max)?top.str_ShowDataGame:"";
		tmp_data = tmp_data.replace(/\*CHKNUM\*/g, i);		
		tmp_data = tmp_data.replace("*DATATIME*", tmp_time);
		tmp_data = tmp_data.replace("*HOOMEVSAWAY*", tmp_Team);	
	}
	return tmp_data;
}
function getGtypeShowLoveI(){
	var Gtype;
	var getGtype =parent.sel_gtype;
	
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
function chkOKshowLoveI(){
	var getGtype = getGtypeShowLoveI();
	var getnum =top.ShowLoveIOKarray[getGtype].length ;
	var ibj="" ;
	top.ShowLoveIOKarray[getGtype]="";
	for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
		tmp = top.ShowLoveIarray[getGtype][i][1].split("<br>")[0];
		top.ShowLoveIOKarray[getGtype]+=tmp+top.ShowLoveIarray[getGtype][i][0]+",";
	}
}
 
 
function chkDelshowLoveI(data2,data){
 
	var getGtype = getGtypeShowLoveI();	
	var tmpdata = data2.split("<br>")[0]+data;
	var tmpdata1 ="";
	var ary = new Array();
	var tmp = new Array();
	tmp = top.ShowLoveIarray[getGtype];
	top.ShowLoveIarray[getGtype]= new Array();
	for (var i=0 ; i < tmp.length ; i++){
		tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
		if(tmpdata1 == tmpdata){
			ary = tmp[i];
			continue;
		}
		top.ShowLoveIarray[getGtype].push(tmp[i]);
	}
	chkOKshowLoveI();
	if(top.swShowLoveI){
		var tmpArray= StatisticsGty(top.today_gmt,getGtypeShowLoveI());
		var tmp =top.today_gmt.split("-");
		var newtoday =tmp[1]+"-"+tmp[2];
		var sw=false;
		var day ='';
		var tmpgday = tmpday.split("-");
		if(++tmpgday[0] < tmp[1]){
			day = 1;
		}else{
			day = (newtoday >= data2.split("<br>")[0])?0:1;
		}
		if(tmpArray[day]==0)sw =true;
		if(sw){
			top.swShowLoveI=false;
			eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
			reload_var();
		}else{
			parent.ShowGameList();
		}
	}else{ 
		document.getElementById("sp_"+MM_imgId(ary[1],ary[0])).innerHTML ="<img id='"+MM_imgId(ary[1],ary[0])+"' lowsrc=\"/images/member/icon_X2.gif\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+ary[0]+"','"+ary[1]+"','"+ary[2]+"','"+ary[3]+"','"+ary[4]+"'); \">";	
	}
	parent.parent.header.showTable();
	futureShowGtypeTable();
}
 
function mouseEnter_pointer(tmp){
	try{
	document.getElementById(tmp.split("_")[1]).style.display ="block";
	}catch(E){}
}
 
function mouseOut_pointer(tmp){
	try{
	document.getElementById(tmp.split("_")[1]).style.display ="none";
	}catch(E){}
}
 
function chkLookShowLoveI(){
	var tmpArray= StatisticsGty(top.today_gmt,getGtypeShowLoveI());
	if(tmpArray[1] == 0)return;	
	top.swShowLoveI =true;
	//parent.ShowGameList();
	eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
	parent.pg =0;
	reload_var();
}
 
 
 
 
function futureShowGtypeTable(){
	var getGtype = getGtypeShowLoveI();
	var tmpArray= StatisticsGty(top.today_gmt,getGtype);
	var gtypenum =(tmpArray[1] == 0)?"_2":"";
	try{
		
		//img_ShowLoveI.innerHTML ='<div onMouseOver="mouseEnter_pointer(\'imp_imp'+parent.sel_gtype+'\');" onMouseOut="mouseOut_pointer(\'imp_imp'+parent.sel_gtype+'\');">';
		img_ShowLoveI.innerHTML='<img src="/images/member/head_L'+getGtype+'U'+gtypenum+'.gif"  onClick="chkLookShowLoveI();" style="cursor:'+((tmpArray[1] == 0)?"":"hand")+'" >';
		//img_ShowLoveI.innerHTML+='<img id="imp'+parent.sel_gtype+'" src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('+parent.sel_gtype+');" style="cursor:hand;">';
		//img_ShowLoveI.innerHTML+='</div>';
		//alert(img_ShowLoveI.innerHTML);
	}catch(E){}
}
 
function StatisticsGty(today,gtype){
	var array =new Array(0,0);
	var tmp =today.split("-");
	var newtoday =tmp[1]+"-"+tmp[2];
	var tmpgday = new Array(0,0);
	var bf = false;
	for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
		tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];
		tmpgday = tmpday.split("-");
		if(++tmpgday[0] < tmp[1]){ 
			bf = true;
		}else{
			bf = false;
		}
		if(bf){
			array[1]++;
		}else{
			if(newtoday >= tmpday ){
				array[0]++;	//單式	
			}else if(newtoday < tmpday){
				array[1]++;	//早餐
			}
		}
	}
	return array;
}
 
function MM_imgId(time,gid){	
	var tmp = time.split("<br>")[0];
	//alert(tmp+gid);
	return tmp+gid;
}</script>
 
<html>
<head>
<title>body_football_<?=$rtype?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
<?
if ($rtype=='p3'){
?>
<SCRIPT language="javascript" src="/js/ft_mem_p3<?=$js?>.js"></SCRIPT>
<SCRIPT language="javascript" src="/js/key_even.js"></SCRIPT>
<?
}else{
?>
<SCRIPT language="javascript" src="/js/future.js"></SCRIPT>
<?
}
?>
</head> 
<body id="MFU" onLoad="onLoad();" >
<div id="LoadLayer">loading...............................................................................</div>
<table border="0" cellpadding="0" cellspacing="0" <?=$tab?>>
  <tr>
    <td id="ad">
      <span id="real_msg"></span>
	  <p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>
	</td>
  </tr>
	<tr>
		<td class="top">
			<h1><em><?=$Early_Market?><?=$caption?></em><input type="button" name="Submit323" value="<?=$Refresh?>" class="new" onClick="javascript:reload_var()">
				<span id="hr_info"><?=$upd_msg?></span>
				<? if ($rtype=='r' or $rtype=='hr'){ ?>
				<span class="rig">						
					<a href="javascript:" onClick=ChkOddfDiv();><?=$Odds_type?></a>
				</span>
				<? } ?>
			</h1>
		</td>
	</tr>
<?
if($rtype!='p3'){
?>
	<tr>
		<td class="mem2">
			<h3>
                <span class="left"></span>
				<span class="rig"><?=$Date?>:<span id="show_date_opt"></span>
				</span>	
			</h3>
		</td>		
	</tr>
<?
}
?>    
	<tr>
    <td class="mem">
      <h2><span id="pg_txt"></span><span id="sel_league"><a href=# onClick="javascript:chg_league();"><?=$League?></a></span></h2>
      <table <?=$tab_id?> border="0" cellspacing="1" cellpadding="0" class="game">
        <?=$table?>
      </table>
<?
if ($rtype=='p3'){
?>
<DIV id="game_table"> </DIV>
<?
}
?>
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
<?
if ($rtype=='r'){
?>
<form name="line_form" id=line_form action="body_var_r_more.php" method="post" target=showdata>
  <div class="more" id="line_window" style="position: absolute; visibility: hidden;">
  <input type=hidden name='gid' value=''>
  <input type=hidden name='uid' value=''>
  <input type=hidden name='ltype' value=''>
  <input type="button" class="close" value="&nbsp;X&nbsp;" onClick="document.all.line_window.style.visibility='hidden';">
	<table id="table_team" width="100%" border="0" cellspacing="1" cellpadding="0" class="game">
		<caption><b><?=$Home_Away?></b></caption>
	</table>	
	<table id="table_pd" width="100%" border="0" cellspacing="1" cellpadding="0" class="game">
	  <caption><b><?=$Correct_Score?></b></caption>
      <tr>
        <th>1:0</th>
        <th>2:0</th>
        <th>2:1</th>
        <th>3:0</th>
        <th>3:1</th>
        <th>3:2</th>
        <th>4:0</th>
        <th>4:1</th>
        <th>4:2</th>
        <th>4:3</th>
        <th>0:0</th>
        <th>1:1</th>
        <th>2:2</th>
        <th>3:3</th>
        <th>4:4</th>
        <th><?=$Others?></th>
      </tr>
    </table>
	<table id="table_hpd" width="100%" border="0" cellspacing="1" cellpadding="0" class="game">
	  <caption><b><?=$Half_1st_Correct_Score?></b></caption>
      <tr>
        <th>1:0</th>
        <th>2:0</th>
        <th>2:1</th>
        <th>3:0</th>
        <th>3:1</th>
        <th>3:2</th>
        <th>4:0</th>
        <th>4:1</th>
        <th>4:2</th>
        <th>4:3</th>
        <th>0:0</th>
        <th>1:1</th>
        <th>2:2</th>
        <th>3:3</th>
        <th>4:4</th>
        <th><?=$Others?></th>
      </tr>
    </table>
    <table id="table_t" border="0" cellspacing="1" cellpadding="0" width="30%" class="game2">
	  <caption><b><?=$Total_Goals?></b></caption>
      <tr> 
        <th>0~1</th>
        <th>2~3</th>
        <th>4~6</th>
        <th>7up</th>
      </tr>
    </table>
    <table id="table_f" border="0" cellspacing="1" cellpadding="0" width="69%" style="margin-left:1%" class="game2">
      <caption><b><?=$Half_Full_Time?></b></caption>
      <tr>
        <th><?=$HH?></th>
        <th><?=$HD?></th>
        <th><?=$HA?></th>
        <th><?=$DH?></th>
        <th><?=$DD?></th>
        <th><?=$DA?></th>
        <th><?=$AH?></th>
        <th><?=$AD?></th>
        <th><?=$AA?></th>
      </tr>
    </table>
</div>
</form>
<?
}
?>
<iframe id=showdata name=showdata scrolling='no' width="0" height='0'></iframe>
</body>
</html>
<div id="copyright"><?=$Copyright?></div>
<!-- ------------------------------ 盤口選擇 ------------------------------ -->
<div  id=odd_f_window style="display: none;position:absolute">
<table id="odd_group" width="110" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td class="b_hline" ><?=$Odds_type?></td>
		</tr>
		<tr >
			<td class="b_cen" width="110">
				<span id="show_odd_f" ></span></td>
		</tr>
	</table>
</div>
<!-- ------------------------------ 盤口選擇 ------------------------------ -->
