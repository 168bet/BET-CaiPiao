<?php
require_once 'conjunction.php';
require_once 'config.php';

//前台登陆验证
if (submitcheck('islogin') == 'yes' && empty($admin_info2)) {
	
	$user = addslashes(trim($user));
	$pass = trim($pass);
	

	if(empty($user) || empty($pass)){
       
  echo "<script>alert('用户名或密码不能为空,请反回重新输入11!');window.history.go(-1);</script>"; 
  exit;
    }

    $pass = md5($pass);

	
	 $ip=$_SERVER["REMOTE_ADDR"];
	
	$result = mysql_query("select count(*) from ka_guan  where kauser='".$user."'  order by id desc");   
$num = mysql_result($result,"0");
if($num!=0){
  $vip=0;
}else{
 $vip=1;
}
	
	
	if ($vip==0) {
	
	$result=mysql_query("select * from ka_guan where kauser='$user' and kapassword='$pass'"); 
$row=mysql_fetch_array($result); 
	$pass1=$row['kapassword'];
	if ($pass1!=$pass ){
	echo "<script>alert('您输入的帐号或密码错误，请重新输入".$user.$pass."!');window.history.go(-1);</script>"; 
	exit;
	}
	$text=date("Y-m-d H:i:s"); 
$sql="update ka_guan set slogin='".$row['slogin']."',sip='".$row['sip']."',zlogin='".$text."',zip='".$ip."',look=look+1 where kauser='".$user."'";
$exe=mysql_query($sql) or die ($sql);	

	$_SESSION['kauser']= $user;
	$_SESSION['lx'] = $row['lx'];
	$_SESSION['vip'] = 0;
	
	}else{
	
	
		$result=mysql_query("select * from ka_zi where kauser='$user' and kapassword='$pass'"); 
$row=mysql_fetch_array($result); 
	$pass1=$row['kapassword'];
	if ($pass1!=$pass ){
	echo "<script>alert('您输入的帐号或密码错误，请重新输入!');window.history.go(-1);</script>"; 
	exit;
	}

$_SESSION['kazi']= $user;
$_SESSION['kaziid']= $row['id'];

	$_SESSION['kauserid']= $row['guanid'];
	$_SESSION['kauser']= $row['guan'];
	$_SESSION['lx'] = $row['lx'];
	$_SESSION['vip'] = 1;
	
	} 

  
	
	echo "<meta http-equiv=refresh content=\"0;URL=index.php\">";exit;
}
?>
<HTML>
<HEAD>


<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="images/ico.ico" rel="shortcut icon">
<title><?=ka_config(1)?>===<?=ka_config(2)?>--代理平台</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
.dndn {
	BORDER-RIGHT: #d6d3ce 0px outset; BORDER-TOP: #d6d3ce 0px outset; FONT-SIZE: 9pt; BACKGROUND: #d6d3ce; BORDER-LEFT: #d6d3ce 0px outset; BORDER-BOTTOM: #d6d3ce 0px outset
}
body,td,th {
	font-size: 12px;
	color: #333333;
}
-->
</style></HEAD>
<?
//已登陆
if($_SESSION['username']){
    if (in_array($action, array('kithe', 'logout', 'top','kakithe','kithe_add','kithe_edit','kaguan','kazong','kadan','kamem','kazi','admin_main','admin_add','editadmin','modify_pass','tj','right','sm','guan_add','guan_edit','zong_add','zong_edit','dan_add','dan_edit','mem_add','mem_edit','rake_tm','server','rake_update','rake_zm','rake_ztm','rake_zm6','rake_gg','rake_lm','rake_sx','rake_wx','rake_bb','rake_ws','look','pz_tm','server_tm','pz_zm','server_zm','pz_zt','server_zt','pz_zm6','server_zm6','pz_sx','server_sx','pz_dd','server_dd','pz_lm','server_lm','pz_bb','server_bb','pz_ws','server_ws','pz_gg','server_gg','x1','x2','x3','x4','x5','re_pb','re_all','re_guan','re_zong','re_dai','re_mem','ka_del','ka_xxx','kawin','xt_abcd','xt_stds','xt_ds','xt_kk','xt_copy','xt_bak','pz_wx','server_wx','edit','ziedit','k_bbb','3dk_yzggsave'))) {
	
	//if ($action!="logout" and $action!="top" ){
	//require_once 'login.php';}
	
	
		 require_once $action .'.php';
		 
	     
		 
	exit;
    } 
?>


<script language="JavaScript">
function show(i){
a1.style.display = "none"; 
a4.style.display = "none"; 
a5.style.display = "none"; 
a2.style.display = "none"; 
a3.style.display = "none"; 
i.style.display = "";  
     
}	
function re_re1(bb){

re1.style.color="494949"
re2.style.color="494949"
re3.style.color="494949"
re4.style.color="494949"
re5.style.color="494949"
re6.style.color="494949"
re7.style.color="494949"
re8.style.color="494949"
re9.style.color="494949"
re10.style.color="494949"
bb.style.color="ff0000"	
	
}

function rm_rm1(bb){

rm1.style.color="494949"
rm2.style.color="494949"
rm3.style.color="494949"
rm4.style.color="494949"
rm5.style.color="494949"
rm6.style.color="494949"
rm7.style.color="494949"

bb.style.color="ff0000"	
	
}    
function rb_rb1(bb){
rb1.style.color="494949"
rb2.style.color="494949"
rb3.style.color="494949"
rb4.style.color="494949"
rb5.style.color="494949"
rb6.style.color="494949"
rb7.style.color="494949"

rb8.style.color="494949"
rb9.style.color="494949"
rb10.style.color="494949"
rb11.style.color="494949"
rb12.style.color="494949"
rb13.style.color="494949"


bb.style.color="ff0000"	
}     
 
 function rl_rl1(bb){
rl1.style.color="494949"
rl2.style.color="494949"
rl3.style.color="494949"
rl4.style.color="494949"
rl5.style.color="494949"
rl6.style.color="494949"
rl7.style.color="494949"

rl8.style.color="494949"

bb.style.color="ff0000"	
}     

function rmn_rmn1(bb){
 rmn1.style.color="494949"
rmn2.style.color="494949"
rmn3.style.color="494949"
bb.style.color="ff0000"	
}     

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
</script>
<body scroll="no" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellspacing="0" border="0" cellpadding="0" height="100%">
  <tr>
    <td valign="top" height="120px"><iframe id=frmRight 
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 120px;" 
      name=right src="index.php?action=top" frameborder=0></iframe></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table id=tblTotal height="100%" cellspacing=0 cellpadding=0 width="100%" 
border=0 name="tblTotal">
        <tbody> 
        <tr>
    
          <td width="100%" valign="top">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
              <tr>
                <td height="100%" valign="top">
			
				<iframe id=frmRight 
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 100%" 
      name=right src="index.php?action=kakithe" scrolling="yes" frameborder=0></iframe></td>
              </tr>
            </table>           </td>
        </tr>
        </tbody> 
      </table>
    </td>
  </tr>
</table>

<?php
}
else {


?>

<?php
}
?>
