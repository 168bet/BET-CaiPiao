<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_POST['sdel']!=""){
    $del_num=count($_POST['sdel']); 
   for($i=0;$i<$del_num;$i++){ 
   
	mysql_query("Delete from ka_zi where id='$sdel[$i]'");
	
	 
             }  
    echo("<script type='text/javascript'>alert('删除成功！');history.back();</script>"); 
 }
 
 if ($_GET['sdel']!=""){
   $dell=$_GET['sdel'];
  
	mysql_query("Delete from ka_zi where id='$sdel'");

	
    
    echo("<script type='text/javascript'>alert('删除成功！');history.back();</script>"); 
 }
 
 
 //修改信息
if ($_GET['act']=="修改") {
if (empty($_POST['kapassword1'])) {
       
  echo "<script>alert('密码不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
$pass1 = md5($_POST['kapassword1']);


$sql="update ka_zi set kapassword='".$pass1."' where id=".$_POST['id'];
	
$exe=mysql_query($sql) or  die("数据库修改出错");

echo "<script>alert('修改成功!');window.history.go(-1);</script>"; 
exit;
	}
	
	
	 //修改信息
if ($_GET['act']=="添加") {
if (empty($_POST['kauser1'])) {
       
  echo "<script>alert('用户不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
if (empty($_POST['kapassword'])) {
       
  echo "<script>alert('密码不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
	
	
	
$result1 = mysql_query("Select Count(ID) As memnum2 From ka_zi Where kauser='".$_POST['kauser1']."' order by id desc");
$rsw = mysql_fetch_array($result1);

if($rsw[0]!=0){
   echo "<script>alert('这一用户名称已被占用，请得新输入！!');window.history.go(-1);</script>"; 
  exit;
}

$result = mysql_query("select count(*) from ka_mem  where kauser='".$_POST['kauser1']."'  order by id desc");   
$num = mysql_result($result,"0");

if($num!=0){
   echo "<script>alert('这一用户名称已被占用，请得新输入！!');window.history.go(-1);</script>"; 
  exit;
}
$result = mysql_query("select count(*) from ka_guan  where kauser='".$_POST['kauser1']."'  order by id desc");   
$num = mysql_result($result,"0");

if($num!=0){
   echo "<script>alert('这一用户名称已被占用，请得新输入！!');window.history.go(-1);</script>"; 
  exit;
}
	

	
	$text=date("Y-m-d H:i:s"); 
 $pass = md5($_POST['kapassword']);
	$sql="INSERT INTO  ka_zi set kapassword='".$pass."',kauser='".$_POST['kauser1']."',guan='".$_POST['guan']."',guanid='".$_POST['guanid']."',adddate='".$text."',lx='".$_POST['lx']."'";
$exe=mysql_query($sql) or  die("数据库修改出错");
	echo "<script>alert('添加成功!');window.history.go(-1);</script>"; 
exit;
	}
	
	if ($_GET['ids']!=""){$ids=$_GET['ids'];}else{$ids=0;}
if ($ids==0){

if ($_POST['ids']!=0){$ids=$_POST['ids'];}else{$ids=0;}
}
 $result=mysql_query("select * from ka_guan where id=".$ids."  order by id"); 
$row11=mysql_fetch_array($result);
if ($row11!=""){
$glname="[".$row11['kauser']."]";

}
 ?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">

<script src="inc/forms.js"></script>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td><fieldset><legend><?=$glname?>子账号管理</legend> <br>
       
          <table border="1" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="98%">
            <form name="form1" method="post" action="index.php?action=kazi&act=添加&ids=<?=$ids?>">
			
			
			 <tr>
              <td>                <div align="right">
                <input name="lx" type="hidden" id="lx" value="<?=$row11['lx']?>" />
                <input name="guanid" type="hidden" id="guanid" value="<?=$row11['id']?>" />
                <input name="guan" type="hidden" id="guan" value="<?=$row11['kauser']?>" />
                用户名：
                    <input name="kauser1" type="text" class="input1" id="kauser1" value="" size="15" >
                密码：
                    <input name="kapassword" type="text"  class="input1" id="kapassword" value="" size="15" >
&nbsp; </div></td>
              <td width="100">
                <div align="center">
                  <button onClick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:110" ;><img src="images/add.gif" align="absmiddle">确认添加</button>
              </div></td>
            </tr>  </form> 
          </table>
       
        <br>
      <table border="1" align="center" cellspacing="0" height="55" cellpadding="5" bordercolordark="#FFFFFF" bordercolor="888888" width="98%">
        <tr class="tbtitle"> 
          <td height="28" width="50"> 
            <div align="center">编号</div>          </td>
          <td width="115"> 
            <div align="center">分类名称</div>          </td>
          <td width="191" align="center">密码</td>
          <td align="center">所属代理</td>
          <td align="center">加入时间</td>
          <td> 
            <div align="center">操作</div>          </td>
        </tr>
        
		<? $result = mysql_query("select * from ka_zi where guanid=".$ids."   order by id desc");   
while($image = mysql_fetch_array($result)){?>
		
		
        <form name="form1" method="post" action="index.php?action=kazi&act=修改&ids=<?=$ids?>"><tr> 
          <td height="25"> 
            <div align="center"><?=$image['id']?></div>          </td>
          <td height="25"> 
            <div align="center"><?=$image['kauser']?>
              <input name="id" type="hidden" id="id" value="<?=$image['id']?>">
</div>          </td>
          <td height="25" align="center"><input name="kapassword1" type="text"  class="input1" id="kapassword1" value="" size="15">
            <span class="STYLE1">不修改请留空</span></td>
          <td height="25" align="center"><?=$image['guan']?></td>
          <td height="25" align="center"><?=$image['adddate']?></td>
          <td width="140"> 
            <div align="center"> 
              <button onClick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:55;height:22" ;><img src="images/icon_21x21_edit01.gif" width="16" height="16" align="absmiddle">修改</button> <button onClick="javascript:location.href='index.php?action=kazi&sdel=<?=$image['id']?>&ids=<?=$ids?>'"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:55;height:22" ;><img src="images/icon_21x21_del.gif" width="16" height="16" align="absmiddle">删除</button>
            </div>          </td>
        </tr>
	  </form>
	  
	  
<? }?> 
      </table>
      <div align="center"><br>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="70"> 
              <div align="left"> 
                <button onClick="javascript:location.href='index.php?action=kazi&ids=<?=$ids?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle">刷新</button>
              </div>
            </td>
            <td> 
              <div align="right" disabled><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle"> 
              </div>
            </td>
          </tr>
        </table>
        <br>
      </div></fieldset>
    </td>
  </tr>
</table>

