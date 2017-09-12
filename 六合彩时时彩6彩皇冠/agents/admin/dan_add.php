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
if ($_POST['cs']>$_POST['kyx']) {
       
  echo "<script>alert('信用额度超过可用信用额!');window.history.go(-1);</script>"; 
  exit;
    }
if (($_POST['sf']+$_POST['sj'])>$_POST['sff']) {
       
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


$result=mysql_query("select * from ka_guan where id=".$_POST['zongid']."  order by id"); 
$row=mysql_fetch_array($result);
$guan=$row['guan'];
$zong=$row['kauser'];
$guanid=$row['guanid'];
$zongid=$row['id'];
$sj=$_POST['sj'];


 
	$sql="INSERT INTO  ka_guan set kapassword='".$pass."',kauser='".$_POST['kauser']."',xm='".$_POST['xm']."',cs='".$_POST['cs']."',rs='".$_POST['rs']."',ts='".$_POST['cs']."',tmb='".$_POST['tmb']."',sj='".$sj."',sf='".$_POST['sf']."',guan='".$guan."',zong='".$zong."',tm=500000,zm=50000,zt=50000,zm6=50000,lm=50000,gg=50000,xx=50000,sx=50000,bb=50000,ws=50000,guanid='".$guanid."',zongid='".$zongid."',lx=3,look=0,pz='".$pz."',ztws=0,stat='".$stat."',adddate='".$text."',slogin='".$text."',zlogin='".$text."',sip='".$ip."',zip='".$ip."'   ";
	
$exe=mysql_query($sql) or  die("数据库修改出错");

if ($_POST['tmb']==1){
$exe=mysql_query("update ka_guan set tmb=1 where  tmb=0 and  daiid=".$_GET['id']);
$exe=mysql_query("update ka_mem set tmb=1 where  tmb=0 and  daiid=".$_GET['id']);
}

$result=mysql_query("select * from ka_guan where  kauser='".$_POST['kauser']."'  order by id desc"); 
$row=mysql_fetch_array($result);
$SoftID=$row['id'];



//总代设置






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

$exe=mysql_query("INSERT INTO ka_quota Set yg='".$yg[$I]."',ygb='".$ygb[$I]."',ygc='".$ygc[$I]."',ygd='".$ygd[$I]."',xx='".$xx[$I]."',xxx='".$xxx[$I]."',username='".$_POST['kauser']."',userid='".$SoftID."',lx=0,flag=0,guanid='".$guanid."',zongid='".$zongid."',danid=0,memid=0,ds='".$ds[$I]."',style='".$style[$I]."' ");

} 

	


	echo "<script>alert('代理添加成功!');window.location.href='index.php?action=dan_add';</script>"; 
exit;
	


}



if ($_GET['id']!="") {



$result=mysql_query("select id,kauser,sf,cs,tmb,rs   from ka_guan where  id=".$_GET['id']." and lx=2"); 
$row=mysql_fetch_array($result);
if ($row!=""){


$result1 = mysql_query("Select SUM(cs) As sum_m  From ka_guan Where lx=3 and   zongid=".$row['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mumu=$rsw[0];}else{$mumu=0;}
	
	 $result1 = mysql_query("Select SUM(sum_m) As sum_m   From ka_tan Where kithe=".$Current_Kithe_Num." and   username='".$row['kauser']."' order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	

	$result1 = mysql_query("Select SUM(rs) As memnum2 From ka_guan Where  lx=3 and zongid=".$row['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$rs1=$rsw[0];}else{$rs1=0;}
	

	
$rs1=$row['rs']-$rs1;

$zongid=$row['id'];
$maxnum=$row['cs']-$mumu-$mkmk;
$istar=0;
$iend=$row['sf'];
$tmb=$row['tmb'];

}else{
$maxnum=2000000000;
$istar=0;
$iend=100;
$tmb=0;
}







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
	
 	if(document.all.temppid.value=='')
 		{ document.all.temppid.focus(); alert("请选择上级!!"); return false; }
		
		if(document.all.kapassword.value=='')
 		{ document.all.kapassword.focus(); alert("密码请务必输入!!"); return false; }
		
		if(document.all.xm.value=='')
 		{ document.all.xm.focus(); alert("姓名请务必输入!!"); return false; }
  	
 	
 	if(document.all.kauser.value=='')
 		{ document.all.alias.focus(); alert("用户名请务必输入!!"); return false; }
		
		
  	if(document.all.cs.value=='')
		{ document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }
 	
	if(!confirm("是否确定写入代理商?")){
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
	document.testFrm.guanid.value = pp[0];
	document.testFrm.kyx.value = pp[2];
	t=parseInt(pp[1]);
    document.testFrm.zc.length = 1; 
	for (j=10;j<=(t).toFixed(3);j=j+10)
   {
   		document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
	}
    document.testFrm.fei_max.length = 1; 
	for (j=10;j<=(t).toFixed(3);j=j+10)
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



function CountGold(gold,type,rtype){

goldvalue = gold.value;

str1="kyx";
zmzm=document.all[str1].value;
if (goldvalue=='') goldvalue=0;

if (rtype=='SP' && (eval(goldvalue) > eval(zmzm))) {gold.focus(); alert("对不起,总代理总信用额度最高限制 : "+eval(zmzm)+"!!"); return false;}



}

function CountGold2(gold,type,rtype){
goldvalue = gold.value;
str1="rs1";
zmzm=document.all[str1].value;
if (goldvalue=='') goldvalue=0;
if (rtype=='SP' && (eval(goldvalue) > eval(zmzm))) {gold.focus(); alert("对不起,总代理人数最高限制 : "+eval(zmzm)+"!!"); return false;}
}


function CountGold1(gold,type,rtype,bb){

goldvalue = gold.value;


if (goldvalue=='') goldvalue=0;

if (rtype=='SP' && (eval(goldvalue) > eval(bb))) {gold.focus(); alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!"); return false;}



}
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="29%"><span class="STYLE3">添加代理用户</span></td>
    <td width="34%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
          <table border="1" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="98%">
          <form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=dan_add&act=添加&id=<?=$_GET['id']?>">  <tr> 
              <td> 
                <div align="left">
				
				 
                  <table width="99%"  border="1" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
                    <tr>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">上级用户：</td>
                      <td height="30" colspan="3" bordercolor="#CCCCCC">
					  <input name=zongid type=hidden value="<?=$zongid?>">
					  
					  <SELECT class=zaselect_ste name=temppid onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}"> 
			<OPTION value="" ></OPTION>
		
		<?
		$result = mysql_query("select id,kauser,sf,cs  from ka_guan  where lx=2");   
while($image = mysql_fetch_array($result)){


$result1 = mysql_query("Select SUM(cs) As sum_m  From ka_guan Where lx=3 and   zongid=".$image['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mumul=$rsw[0];}else{$mumul=0;}
	
	 $result1 = mysql_query("Select SUM(sum_m) As sum_m   From ka_tan Where kithe=".$Current_Kithe_Num." and   username=".$image['kauser']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mkmkl=$rsw[0];}else{$mkmkl=0;}
	
	$cscs=$image['cs']-$mumul-$mkmkl;
	
			   
			     echo "<OPTION value=index.php?action=dan_add&id=".$image['id'];
				
				
				 if ($zongid!="") {
				 if ($zongid==$image['id']) {
				  echo " selected=selected ";
				  }				
				}
				
				 echo ">".$image['kauser']."--".$cscs."</OPTION>";
				 
				 
			  }
		?>
		</SELECT>
					  <span class="STYLE2">*(请先选择好上级)<?=$zongid?>/<?=$_GET['id']?></span></td>
                      </tr>
                    <tr>
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
                      <td bordercolor="#CCCCCC"><input 
					  onBlur="return CountGold(this,'blur','SP');"
					    
					    onKeyUp="return CountGold(this,'keyup');" 
						
					  name="cs" type="text" class="input1"  id="cs" value="0" />
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
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总代占成：</td>
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
                        <span class="STYLE2">*
                        <input name="sff" type="hidden" id="sff" value="<?=$iend?>" />
                      </span></td>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">代理占成：</td>
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
                          <span class="STYLE2">*                        </span></td>
                    </tr>
                    <tr>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自否允许特B：</td>
                      <td height="30" bordercolor="#CCCCCC"><select name="tmb" id="tmb">
                          <? if ($tmb!=1){?>
                          <option value="0" selected="selected">允许</option>
                          <? }?>
                          <option value="1">不允许</option>
                        </select>                      </td>
                      <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">会员人数：</td>
                      <td bordercolor="#CCCCCC"><input onblur="return CountGold2(this,'blur','SP');"
					    
					    onkeyup="return CountGold2(this,'keyup');" 
						name="rs" type="text" class="input1"  id="rs" value="0" size="10" />
                          <span class="STYLE2">
                          <input name="rs1" type="hidden" id="rs1" value="<?=$rs1?>" />
                            最多：
  <?=$rs1?>
                          </span></td>
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
                       <? 
					   
					   if ($zongid!=""){
					      $result = mysql_query("select * from  ka_quota where userid=".$zongid." and  lx=0  and flag=0 order by id"); 
					   }else{
					   $result = mysql_query("select * from  ka_guands where lx=0 order by id"); }
					   
					   
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
                                      
                                         <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存代理" />
                                  
                
                        <br>
                        <table width="100" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="10"></td>
                          </tr>
                        </table></td>
                      </tr>
                  </table>
</div>
                
              </td>
            </tr> </form>
          </table>
          
