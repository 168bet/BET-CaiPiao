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
require ("../include/traditional.$langx.inc.php");

$sql = "select ID from web_member_data where oid='$uid' and status=0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$date=date("Y-m-d");
if ($rtype=='pr'){
    $tab_id="id=pr";
}else{
    $tab_id="id=game_table";
}
switch ($rtype){
case "all":
	$caption=$Straight_All;
	$show="OU";
	$table='<tr>
		    <th class="time">'.$Times.'</th>
            <th width="33%">'.$Home_Away.'</th>
		    <th width="11%">'.$Odd_Even.'</th>
		    <th width="23%">'.$Handicap.'</th>
		    <th width="23%">'.$Over_Under.'</th>
		    </tr>';
    break;
case "r":
	$caption=$Straight;
	$show="OU";
	$table='<tr>
		    <th class="time">'.$Times.'</th>
		    <th width="33%">'.$Home_Away.'</th>
		    <th width="11%">'.$Odd_Even.'</th>
		    <th width="23%">'.$Handicap.'</th>
		    <th width="23%">'.$Over_Under.'</th>
			</tr>';
    break;
case "rq4":
	$caption=$Quarter;
	$show="OU";
	$table='<tr>
		    <th class="time">'.$Times.'</th>
		    <th width="33%">'.$Home_Away.'</th>
		    <th width="11%">'.$Odd_Even.'</th>
		    <th width="23%">'.$Handicap.'</th>
		    <th width="23%">'.$Over_Under.'</th>
			</tr>';
    break;
case "re":
	$caption=$Running_Ball;
	$show="RE";
	$table='<tr>
		    <th class="time">'.$Times.'</th>
		    <th width="39%">'.$Home_Away.'</th>
		    <th width="24%">'.$Handicap.'</th>
		    <th width="26%">'.$Over_Under.'</th>
			</tr>';
	break;
case "pr":
	$caption=$Handicap_Parlay;
	$show="PR";
	$width=55;
	$tab_id="";
	$upd_msg=$Mix_Parlay_maximum;
	$table='<tr>
		    <th width=40>'.$Times.'</td>
		    <th width=40>'.$NO.'</th>
		    <th width=205>'.$Home_Away.'</td>
		    <th width=130>'.$Handicap.'</td>
		    <th width=130>'.$Over_Under.'</td>
			</tr>';
	  break;
}
?>
<script> 
var minlimit='3';
var maxlimit='10';
</script>
<script> 
var rtype = '<?=$rtype?>';
var odd_f_str = 'H,M,I,E';
top.today_gmt = '<?=$date?>';
var Format=new Array();
Format[0]=new Array( 'H','<?=$HK_Odds?>','Y');
Format[1]=new Array( 'M','<?=$Malay_Odds?>','Y');
Format[2]=new Array( 'I','<?=$Indo_Odds?>','Y');
Format[3]=new Array( 'E','<?=$Euro_Odds?>','Y');
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
function StatisticsGty(today,gtype){
	var array =new Array(0,0);
	var tmp =today.split("-");
	var newtoday =tmp[1]+"-"+tmp[2];
	for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
		tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];	
		if(newtoday >= tmpday){
			array[0]++;		
		}else if(newtoday < tmpday){
			array[1]++;	
		}
	}
	return array;
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
		var day =(newtoday >= data2.split("<br>")[0])?0:1;
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
	for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
		tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];	
		if(newtoday >= tmpday){
			array[0]++;		
		}else if(newtoday < tmpday){
			array[1]++;	
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
<? if($rtype=='re'){ ?>
<script language="javascript" src="/js/bk_mem_re.js"></script>
<? }else if($rtype=='pr'){ ?>
<script language="javascript" src="/js/ft_mem_pr<?=$js?>.js"></script>
<? }else{ ?>
<script language="javascript" src="/js/bk_mem_r.js"></script>
<? } ?>
<SCRIPT language="javascript" src="/js/key_even.js"></SCRIPT>
</head>
 
<body id="MBK" onLoad="onLoad();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div id="LoadLayer">loading...............................................................................</div>
 
<table border="0" cellpadding="0" cellspacing="0" id="box">
	<tr>
		<td id="ad">
			<span id="real_msg"></span>
			<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>
		</td>
	</tr>
	<tr>
		<td class="top">
			<h1><em><?=$caption?></em><input type="button" name="Submit323" value="<?=$Refresh?>" class="new" onClick="javascript:reload_var()">
			<span id="hr_info"><?=$upd_msg?></span>
				<? if($rtype!='pr'){ ?>
				<span class="rig">						
					<a href="javascript:" onClick=ChkOddfDiv();><?=$Odds_type?></a>
				</span> 
				<? } ?> 
			</h1>
		</td>
	</tr>
	<tr>
		<td class="mem">
			<h2><span id="pg_txt"></span><a href="javascript:self.location='./body_var_lid.php?uid='+parent.uid+'&rtype='+parent.rtype+'&langx='+parent.langx+'&mtype='+parent.ltype;"><?=$League?></a></h2>
			<table <?=$tab_id?> border="0" cellspacing="1" cellpadding="0" class="game">
				<?=$table?>
			</table>
<?
if ($rtype=='pr'){
?>
<DIV id="game_table"></DIV>
<?
}
?>
		</td>
	</tr>
	<tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
</body>
</html><!--<div id="copyright">
    版權所有 皇冠 建議您以 IE 5.0 800 X 600 以上高彩模式瀏覽本站&nbsp;&nbsp;<a id=download title="下載" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下載IE</a>
</div>-->
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
