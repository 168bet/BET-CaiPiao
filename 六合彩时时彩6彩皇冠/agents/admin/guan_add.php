<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}
//修改信息
if ($_GET['act']=="添加") {
if (empty($_POST['kauser'])) {
       
  echo "<script>alert('用户名不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
if (empty($_POST['kapassword'])) {
       
  echo "<script>alert('密码不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
if ($_POST['cs']>2000000000) {
       
  echo "<script>alert('信用额度超过可用信用额!');window.history.go(-1);</script>"; 
  exit;
    }
if (($_POST['sf']+$_POST['sj'])>100) {
       
  echo "<script>alert('对不起,请正确设置占成!');window.history.go(-1);</script>"; 
  exit;
    }

if ($_POST['tv5']=="是") {$pz=0; }else{$pz=1;  }
if ($_POST['tv6']=="是") {$stat=0;}else{$stat=1;  }

$result = mysql_query("select count(*) from ka_guan  where kauser='".$_POST['kauser']."'  order by id desc");   
$num = mysql_result($result,"0");

if($num!=0){
   echo "<script>alert('这一用户名称已被占用，请得新输入！!');window.history.go(-1);</script>"; 
  exit;
}
$result = mysql_query("select count(*) from ka_mem  where kauser='".$_POST['kauser']."'  order by id desc");   
$num = mysql_result($result,"0");

if($num!=0){
   echo "<script>alert('这一用户名称已被占用，请得新输入！!');window.history.go(-1);</script>"; 
  exit;
}

$result = mysql_query("select count(*) from ka_zi  where kauser='".$_POST['kauser']."'  order by id desc");   
$num = mysql_result($result,"0");

if($num!=0){
   echo "<script>alert('这一用户名称已被占用，请得新输入！!');window.history.go(-1);</script>"; 
  exit;
}

  
	
		
			 



 $pass = md5($_POST['kapassword']);
 $text=date("Y-m-d H:i:s");
 $ip=$_SERVER["REMOTE_ADDR"];

 
 $sj=$_POST['sj'];
 
	$sql="INSERT INTO  ka_guan set kapassword='".$pass."',kauser='".$_POST['kauser']."',xm='".$_POST['xm']."',rs='".$_POST['rs']."',cs='".$_POST['cs']."',ts='".$_POST['cs']."',tmb='".$_POST['tmb']."',sj='".$sj."',sf='".$_POST['sf']."',guan='".$_POST['kauser']."',zong='".$_POST['kauser']."',tm=500000,zm=50000,zt=50000,zm6=50000,lm=50000,gg=50000,xx=50000,sx=50000,bb=50000,ws=50000,guanid=0,zongid=0,lx=1,look=0,pz='".$pz."',ztws=0,stat='".$stat."',adddate='".$text."',slogin='".$text."',zlogin='".$text."',sip='".$ip."',zip='".$ip."'   ";
	
$exe=mysql_query($sql) or  die("数据库修改出错");

$result=mysql_query("select * from ka_guan where  kauser='".$_POST['kauser']."'  order by id desc"); 
$row=mysql_fetch_array($result);
$SoftID=$row['id'];



//股东设置

//$ygid=$_POST['ygid'];
$yg=$_POST['m'];
$ygb=$_POST['ygb'];
$ygc=$_POST['ygc'];
$ygd=$_POST['ygd'];
$xx=$_POST['mm'];
$xxx=$_POST['mmm'];
$ds=$_POST['ds'];
$style=$_POST['style'];

for ($I=0; $I<count($yg); $I=$I+1)
{

$exe=mysql_query("INSERT INTO ka_quota Set yg='".$yg[$I]."',ygb='".$ygb[$I]."',ygc='".$ygc[$I]."',ygd='".$ygd[$I]."',xx='".$xx[$I]."',xxx='".$xxx[$I]."',username='".$_POST['kauser']."',userid='".$SoftID."',lx=0,flag=0,guanid=0,zongid=0,danid=0,memid=0,ds='".$ds[$I]."',style='".$style[$I]."' ");

} 

	


	echo "<script>alert('股东添加成功!');window.location.href='index.php?action=guan_add';</script>"; 
exit;
	


}

?>


<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>

<style type="text/css">
<!--
.style1 {
	color: #666666;
	font-weight: bold;
}
.style2 {color: #FF0000}
.STYLE3 {color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script src="inc/forms.js"></script>
<script language="JavaScript" type="text/JavaScript">
function SelectAllPub() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
function SelectAllAdm() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
</script>
<SCRIPT>
function LoadBody(){

}
function SubChk()
{
	
 	if(document.all.kapassword.value=='')
 		{ document.all.kapassword.focus(); alert("密码请务必输入!!"); return false; }
		
		if(document.all.xm.value=='')
 		{ document.all.xm.focus(); alert("姓名请务必输入!!"); return false; }
  	
 	
 	if(document.all.kauser.value=='')
 		{ document.all.alias.focus(); alert("用户名请务必输入!!"); return false; }
		
		
  	if(document.all.cs.value=='')
		{ document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }
 	
	if(!confirm("是否确定写入股东?")){
  		return false;
 	}
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.ag_count.innerHTML
	if (s!=''){
		switch(w){
			//case 0:document.all.ag_count.innerHTML = s+org_str.substr(1,4);break;
			case 1:document.all.ag_count.innerHTML = org_str.substr(0,0)+s+org_str.substr(1,7);break;
			case 2:document.all.ag_count.innerHTML = org_str.substr(0,1)+s+org_str.substr(2,7);break;
			case 3:document.all.ag_count.innerHTML = org_str.substr(0,2)+s+org_str.substr(3,7);break;
			case 4:document.all.ag_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,7);break; 
			case 5:document.all.ag_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,7);break;
			case 6:document.all.ag_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,7);break;
			case 7:document.all.ag_count.innerHTML = org_str.substr(0,6)+s+org_str.substr(7,7);break; }
	}
}
function changelocation(locationid,result)
{
var onecount;
subcat = new Array();
   
    document.testFrm.zc.length = 1; 
	    var locationid=locationid;
    var i;
		var k
	   for (j=10;j.toFixed(3)<=(result-locationid).toFixed(3);j=j+10)
   {
   		document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
	}
    
}
function changep(pid)
{
	var pp=pid.split(",");
	document.testFrm.pagentid.value = pp[0];
	document.testFrm.kyx.value = pp[2];
	t=parseInt(pp[1]);
    document.testFrm.zc.length = 1; 
	for (j=10;j.toFixed(3)<=(t).toFixed(3);j=j+10)
   {
   		document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
	}
    document.testFrm.fei_max.length = 1; 
	for (j=10;j.toFixed(3)<=(t).toFixed(3);j=j+10)
   {
   		document.testFrm.fei_max.options[document.testFrm.fei_max.length] = new Option((j).toFixed(0)+"%");
	}
}

function changep1(pid)
{
var pp=pid.split(",");

	document.testFrm.winloss.value = pp[0];
	document.testFrm.bank.value = pp[1];
document.all.ag_count.innerHTML =pp[1];
}
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="29%"><span class="STYLE3">添加股东用户</span></td>
    <td width="34%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>



<?
$maxnum=2000000000;

 $istar=0;

$iend=100;

  
  ?>

 
        
				
				 
                  <table width="99%"  border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
                   <form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=guan_add&act=添加"> <tr>
                      <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">账号：</td>
                      <td width="27%" bordercolor="#CCCCCC"><input name="kauser" type="text" class="input1"  id="kauser">
                        <span class="STYLE2">                        *</span></td>
                      <td width="9%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">姓名：</td>
                      <td width="53%" bordercolor="#CCCCCC"><input name="xm" type="text" class="input1"  id="xm" />
                        <span class="STYLE2">*</span> </td>
                    </tr>
                    <tr>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">密码：</td>
                      <td bordercolor="#CCCCCC"><input name="kapassword" type="password" class="input1"  id="kapassword" />
                        <span class="STYLE2">*</span> </td>
                      <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总信用额：</td>
                      <td bordercolor="#CCCCCC"><input name="cs" type="text" class="input1"  id="cs" value="0" />
                        可用信用额度：
                        <input type="text" name="kyx" class="input1"  readonly="readonly" value="<?=$maxnum?>" /></td>
                    </tr>
                    
                    <tr>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">走飞：</td>
                      <td bordercolor="#CCCCCC"><input type="hidden" name="tv5" value="是" >
              <img name="tv5_b" src="images/icon_21x21_selectboxon.gif" class="cursor" align="absmiddle" onclick="javascript:ra_select('tv5')">(充许走飞/禁止走飞)<span class="STYLE2">*</span></td>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">状态：</td>
                      <td bordercolor="#CCCCCC"><input type="hidden" name="tv6" value="是">
                          <img src="images/icon_21x21_selectboxon.gif" name="tv6_b" align="absmiddle" class="cursor" id="tv6_b" onclick="javascript:ra_select('tv6')" />(开启/禁止)<span class="STYLE2">*</span></td>
                    </tr>
                    <tr>
                      <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">公司占成：</td>
                      <td bordercolor="#CCCCCC"><select class="za_select_02" name="sj"  id="zc">
                          <? for ($bb=$istar; $bb<=$iend; $bb=$bb+10)
{
?>
                          <option value="<?   echo $bb; ?>">
                          <?   switch ($bb)
  {
    case 0:
      print "不占成";
      break;
    default:

      print $bb."%";
      break;
  } ?>
                          </option>
                          <? 
} ?>
                        </select>
                          <span class="STYLE2">*</span></td>
                      <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">股东占成：</td>
                      <td bordercolor="#CCCCCC"><select class="za_select_02" name="sf"  id="zc">
                          <? for ($bb=$istar; $bb<=$iend; $bb=$bb+10)
{
?>
                          <option value="<?   echo $bb; ?>">
                          <?   switch ($bb)
  {
    case 0:
      print "不占成";
      break;
    default:

      print $bb."%";
      break;
  } ?>
                          </option>
                          <? 
} ?>
                        </select>
                          <span class="STYLE2">*</span></td>
                    </tr>
                    <tr>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自否允许特B：</td>
                      <td height="30" bordercolor="#CCCCCC"><select name="tmb" id="tmb">
                        <option value="0" selected="selected">允许</option>
                        <option value="1">不允许</option>
                      </select>                      </td>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">会员人数：</td>
                      <td bordercolor="#CCCCCC"><input name="rs" type="text" class="input1"  id="rs" value="1000" size="10" /></td>
                    </tr>
                    <tr>
                      <td height="30" colspan="4" bordercolor="#CCCCCC"><table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
                        <tr>
                          <td width="90" height="25" align="center" bgcolor="#FDF4CA"><span class="STYLE2">类型</span> </td>
                          <td align="center" bgcolor="#FDF4CA">佣金%A</td>
                          <td align="center" bgcolor="#FDF4CA" >佣金%B</td>
                          <td align="center" bgcolor="#FDF4CA" >佣金%C</td>
                          <td align="center" bgcolor="#FDF4CA" >佣金%D</td>
                          <td align="center" bgcolor="#FDF4CA" >单注限额</td>
                          <td align="center" bgcolor="#FDF4CA" >单项(号)限额</td>
                        </tr>
                       <? $result = mysql_query("select * from  ka_guands where lx=0 order by id");  
					   $t=0;
while($image = mysql_fetch_array($result)){
    //if ($image['ds'] == "五行") continue;

?>
					    
                        <tr>
                          <td height="20" align="center" bgcolor="#FDF4CA"><?=$image['ds']?>
                              <input name="ds[]" type="hidden" id="ds[]" value="<?=$image['ds']?>" />
							  <input name="style[]" type="hidden" id="style[]" value="<?=$image['style']?>" /></td>
                          <td align="center" bgcolor="#FEFBE9"><input name="m[]" class="input1" id="m[]" value='<?=$image['yg']?>' size="10" /></td>
                          <td align="center" bgcolor="#FEFBE9"><input name="ygb[]" class="input1" id="mm[]" value='<?=$image['ygb']?>' size="10" /></td>
                          <td align="center" bgcolor="#FEFBE9"><input name="ygc[]" class="input1" id="ygc[]" value='<?=$image['ygc']?>' size="10" /></td>
                          <td align="center" bgcolor="#FEFBE9"><input name="ygd[]" class="input1" id="ygd[]" value='<?=$image['ygd']?>' size="10" /></td>
                          <td align="center" bgcolor="#FEFBE9"><input name="mm[]" class="input1" id="mm[]" value='<?=$image['xx']?>' size="10" /></td>
                          <td align="center" bgcolor="#FEFBE9"><input name="mmm[]" class="input1" id="mmm[]" value='<?=$image['xxx']?>' size="10" /></td>
                        </tr>
                        <?
						$t++;
								  //if($t==35){echo "<tr><td>福彩</td></tr>";}
								  //if($t==54){echo "<tr><td>体彩</td></tr>";}
						 }?>
                       
                        
                       
                      </table></td>
                     </tr>
                    
                    <tr>
                      <td height="30" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td>
                      <td colspan="3" bordercolor="#CCCCCC"><br>
                        <table width="100" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="6"></td>
                          </tr>
                        </table>
                                      
                                         <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存股东" />
                                  
                
                        <br>
                        <table width="100" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="10"></td>
                          </tr>
                        </table></td>
                     </tr>
				    </form>
                  </table>
</div>
                
           
