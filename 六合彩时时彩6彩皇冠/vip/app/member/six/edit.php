<?

if(!defined('PHPYOU_VER')) {

	exit('�Ƿ�����');

}

//�޸���Ϣ

if ($_GET['act']=="���") {



if ($_POST['kapassword']!="" && $_POST['kapassword_old']!=""){

  $pass = md5($_POST['kapassword']);
  $sql="select id from  ka_mem  where id='".$_GET['id']."' and kapassword=md5(".$_POST['kapassword_old'].")";
  $exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
  if(mysql_num_rows($exe)>0){


  $sql="update  ka_mem set kapassword='".$pass."' where id='".$_GET['id']."'  order by id desc";	

  $exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
//$sql="update  ka_mem set xm='".$_POST['xm']."' where id='".$_GET['id']."'  order by id desc";	
//$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
	echo "<script>alert('�����޸ĳɹ�!');window.location.href='index.php?action=edit&id=".$_GET['id']."';</script>"; 
	exit;
   }else{
	echo "<script>alert('����������!');window.location.href='index.php?action=edit&id=".$_GET['id']."';</script>"; 
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
		    alert("������ԭ���룡");
		    document.all.kapassword_old.focus();
		    return false;
	    }
		
	    if(document.all.kapassword.value.length < 6 || document.all.kapassword.value.length > 20){
		    alert("������ ����д 6 λ�����ϣ��20λ����");
		    document.all.kapassword.focus();
		    return false;
	    }
	    if(document.all.kapassword.value != document.all.kapassword1.value){
		    alert("������ �� ������ȷ�� ��һ����(ȷ�ϴ�Сд�Ƿ���ͬ)");
		    document.all.kapassword.focus();
		    return false;
	    }
	    if(document.all.kapassword.value == document.all.kapassword_old.value){
		    alert("������ ����ʹ�� ԭ���� ���޸�");
		    document.all.kapassword.focus();
		    return false;
	    }	
	    if(!confirm("�Ƿ�ȷ��Ҫ�޸����룿")){return false;}
    }
    </script>
</head>
<body>


<form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=edit&act=���&id=<?=$row2['id']?>"> 
        <table bgcolor="#999999" border="0" cellpadding="2" cellspacing="1" class="t_list" width="605">

            <tr>
                <td class="t_list_bottom" colspan="3"><strong>��������</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td" width="22%">��Ա�ʺ�</td>
                <td align="left" class="t_Edit_td" colspan="2" valign="middle" width="78%">
                 <?=$row2['kauser']?>

      			<input name="danid" type="hidden" value="<?=$row2['danid']?>" />
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ���Ŷ���</td>
                <td class="t_Edit_td" colspan="2"><?=$row2['abcd']?>��</td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ���ջ���</td>
                <td class="t_Edit_td" colspan="2">RMB(�����)</td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ���ö��</td>
                <td align="left" class="t_Edit_td" colspan="2"><?=$row2['cs']?>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ���ý��</td>
                <td align="left" class="t_Edit_td" colspan="2"><?=ka_memuser("ts")?></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ���ý��</td>
                <td align="left" class="t_Edit_td" colspan="2">
<? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
��<? echo $mkmk;?>                
                </td>
            </tr>

            <tr valign="middle">
                <td class="t_list_bottom" colspan="3">
                    <strong>�޸�����</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ԭ����</td>
                <td align="left" class="t_Edit_td">
                    <input class="inp1" maxlength="20" name="kapassword_old" id="kapassword_old" onBlur="this.className='inp1'" onFocus="this.className='inp1m'" size="20" type="password" value=""></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ������</td>
                <td align="left" class="t_Edit_td">
                    <input class="inp1" maxlength="20" name="kapassword" id="kapassword" onBlur="this.className='inp1'" onFocus="this.className='inp1m'" size="20" type="password" value=""></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_Edit_td">
                    ȷ������</td>
                <td align="left" class="t_Edit_td">
                    <input class="inp1" maxlength="20" name="kapassword1" id="kapassword1" onBlur="this.className='inp1'" onFocus="this.className='inp1m'" size="20" type="password" value="">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="�޸�����" /></td>
            </tr> 
        </table>

        <br>
        <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="605">
            <tr><td class='t_list_caption' colspan='6'><strong>��ۢ�ϲʡ���ˮ���޶�</strong></td></tr>
                <tr>
                    <td class="t_list_caption">��ע����</td>
                    <td class="t_list_caption">Ӷ��%</td>
                    <td class="t_list_caption">��ע�޶�</td>
                    <td class="t_list_caption">�����޶�</td>
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
