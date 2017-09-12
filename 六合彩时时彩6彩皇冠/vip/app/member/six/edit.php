<?

if(!defined('PHPYOU_VER')) {

	exit('非法进入');

}

//修改信息

if ($_GET['act']=="添加") {



if ($_POST['kapassword']!="" && $_POST['kapassword_old']!=""){

  $pass = md5($_POST['kapassword']);
  $sql="select id from  ka_mem  where id='".$_GET['id']."' and kapassword=md5(".$_POST['kapassword_old'].")";
  $exe=mysql_query($sql) or  die("数据库修改出错");
  if(mysql_num_rows($exe)>0){


  $sql="update  ka_mem set kapassword='".$pass."' where id='".$_GET['id']."'  order by id desc";	

  $exe=mysql_query($sql) or  die("数据库修改出错");
//$sql="update  ka_mem set xm='".$_POST['xm']."' where id='".$_GET['id']."'  order by id desc";	
//$exe=mysql_query($sql) or  die("数据库修改出错");
	echo "<script>alert('密码修改成功!');window.location.href='index.php?action=edit&id=".$_GET['id']."';</script>"; 
	exit;
   }else{
	echo "<script>alert('旧密码有误!');window.location.href='index.php?action=edit&id=".$_GET['id']."';</script>"; 
	exit;
  }
		
}



	



	


	

	

}

	

	

	

	

$result2=mysql_query("select *  from ka_mem where  id=".ka_memuser("id")." order by id"); 

$row2=mysql_fetch_array($result2);

	

	?>





<html>
<head>
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css">

<style type="text/css">

<!--

.style1 {

	color: #666666;

	font-weight: bold;

}

.style2 {color: #FF0000}

.STYLE3 {	color: #FFFFFF;

	font-weight: bold;

}
.STYLE4 {color: #FFFFFF; font-weight: bold; }
.STYLE5 {color: #FFFFFF}
-->

</style>
    <script>
    function SubChk(){
	    if(document.all.kapassword_old.value.length == ""){
		    alert("请输入原密码！");
		    document.all.kapassword_old.focus();
		    return false;
	    }
		
	    if(document.all.kapassword.value.length < 6 || document.all.kapassword.value.length > 20){
		    alert("新密码 请填写 6 位或以上（最长20位）！");
		    document.all.kapassword.focus();
		    return false;
	    }
	    if(document.all.kapassword.value != document.all.kapassword1.value){
		    alert("新密码 和 新密码确认 不一样！(确认大小写是否相同)");
		    document.all.kapassword.focus();
		    return false;
	    }
	    if(document.all.kapassword.value == document.all.kapassword_old.value){
		    alert("新密码 不能使用 原密码 请修改");
		    document.all.kapassword.focus();
		    return false;
	    }	
	    if(!confirm("是否确定要修改密码？")){return false;}
    }
    </script>
</head>
<body>


<form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=edit&act=添加&id=<?=$row2['id']?>"> 
        <table bgcolor="#999999" border="0" cellpadding="2" cellspacing="1" class="t_list" width="605">

            <tr>
                <td class="t_list_bottom" colspan="3"><strong>个人资料</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td" width="22%">会员帐号</td>
                <td align="left" class="t_Edit_td" colspan="2" valign="middle" width="78%">
                 <?=$row2['kauser']?>

      			<input name="danid" type="hidden" value="<?=$row2['danid']?>" />
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    开放赌盘</td>
                <td class="t_Edit_td" colspan="2"><?=$row2['abcd']?>盘</td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    交收货币</td>
                <td class="t_Edit_td" colspan="2">RMB(人民币)</td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    信用额度</td>
                <td align="left" class="t_Edit_td" colspan="2"><?=$row2['cs']?>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    可用金额</td>
                <td align="left" class="t_Edit_td" colspan="2"><?=ka_memuser("ts")?></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    已用金额</td>
                <td align="left" class="t_Edit_td" colspan="2">
<? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
￥<? echo $mkmk;?>                
                </td>
            </tr>

            <tr valign="middle">
                <td class="t_list_bottom" colspan="3">
                    <strong>修改密码</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    原密码</td>
                <td align="left" class="t_Edit_td">
                    <input class="inp1" maxlength="20" name="kapassword_old" id="kapassword_old" onBlur="this.className='inp1'" onFocus="this.className='inp1m'" size="20" type="password" value=""></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    新密码</td>
                <td align="left" class="t_Edit_td">
                    <input class="inp1" maxlength="20" name="kapassword" id="kapassword" onBlur="this.className='inp1'" onFocus="this.className='inp1m'" size="20" type="password" value=""></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    确认密码</td>
                <td align="left" class="t_Edit_td">
                    <input class="inp1" maxlength="20" name="kapassword1" id="kapassword1" onBlur="this.className='inp1'" onFocus="this.className='inp1m'" size="20" type="password" value="">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="修改密码" /></td>
            </tr> 
        </table>

        <br>
        <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="605">
            <tr><td class='t_list_caption' colspan='6'><strong>香港㈥合彩—退水、限额</strong></td></tr>
                <tr>
                    <td class="t_list_caption">下注类型</td>
                    <td class="t_list_caption">佣金%</td>
                    <td class="t_list_caption">单注限额</td>
                    <td class="t_list_caption">单期限额</td>
                </tr>
            
      <?

	  $userid=ka_memuser("id");

	  

	   $result = mysql_query("select * from  ka_quota where lx=0 and userid=".$userid." and flag=1 order by id ");   

					  $t=0;

while($image = mysql_fetch_array($result)){



					  

?>
            
           
            <tr class="t_list_tr_1" onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#FFFFA2'">
                <td><?=$image['ds']?></td>
                <td><?=$image['yg']?></td>
                <td class="f_right"><?=$image['xx']?>&nbsp;</td>
                <td class="f_right"><?=$image['xxx']?>&nbsp;</td>
            </tr>
            
						  
<?
						   }?>           
            
        </table>

<br>
</form>

</body>
</html>
