<? if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}




if ($_GET['kithe']!="" or $_POST['kithe']!="" ){

if ($_GET['kithe']!=""){
$kithe=$_GET['kithe'];}else{$kithe=$_POST['kithe'];}


}

$username=$_GET['username'];

if ($_GET['save']=="save"){

if ($_POST['Submit']=="�޸�"){

//if ($_POST['kithe1']!=$Current_Kithe_Num){
//echo "<script>alert('�����Ѿ�������,�벻Ҫ�޸�!');window.history.go(-1);</script>"; 
//exit;
//}



$exe=mysql_query("update ka_tan set class1='".$_POST['class11']."',class2='".$_POST['class22']."',class3='".$_POST['class33']."',sum_m='".$_POST['sum_m']."',user_ds='".$_POST['user_ds']."',adddate='".$_POST['adddate']."' where id=".$_GET['id']);


}

if ($_POST['Submit']=="ɾ��"){

mysql_query("Delete from ka_tan where id=".$_GET['id']);

}




}

if ($_GET['del']=="del"){


	
	
 }


 // ��ҳ
function cpmulti($num, $perpage, $curpage, $mpurl) {
	$multipage = '';
	$mpurl .= '&';
	if($num > $perpage) {
		$page = 10;
		$offset = 5;
		$pages = @ceil($num / $perpage);
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $curpage - $pages + $to;
				$to = $pages;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$from = $pages - $page + 1;
				}
			}
		}


$multipage= ($curpage >= 0 ? '<a href="'.$mpurl.'page=1" class="p_redirect"><img src="images/prev_top.gif" border="0" align="absmiddle"></a>&nbsp;' : '');
		$multipage.= ( $curpage<=1 ? '<a href="'.$mpurl.'page=1" class="p_redirect"><img src="images/prev.gif"  border="0" align="absmiddle"></a>&nbsp;' : '').($curpage > 1 ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="p_redirect"><img src="images/prev.gif"  border="0" align="absmiddle"></a>&nbsp;' : '');
		
		
		
		$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="p_redirect"><img src="images/next.gif" align="absmiddle" border="0" ></a>&nbsp;' : '').($to == $curpage ? '<a href="'.$mpurl.'page='.$pages.'" class="p_redirect"><img src="images/next.gif" align="absmiddle" border="0" ></a>&nbsp;' : '');
		
		$multipage .=  ($curpage >= 0 ? '<a href="'.$mpurl.'page='.$to.'" class="p_redirect"><img border="0" src="images/prev_end.gif" align="absmiddle"></a>' : '');
		
		
		$multipage = $multipage ? '�ܼ�:'.$num.'��&nbsp;&nbsp;��'.$to.'ҳ&nbsp;&nbsp;��ǰ:<font color=ff0000>'.$curpage.'ҳ</font>  &nbsp;&nbsp;'.$multipage.'&nbsp; ' : '';
	}
	return $multipage;
}

?>

<link rel="stylesheet" href="images/xp.css" type="text/css">

<script language="javascript" type="text/javascript" src="js_admin.js"></script>






<style type="text/css">
<!--
.STYLE3 {color: #FF3300}
.STYLE4 {color: #FFFFFF}
-->
</style>
<body  >
<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>

<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">


<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="26%"><strong><font color="#FFFFFF"><? if( $username!="" and $kithe!="" ){?>[<?=$username?>]��Աע��[<?=$kithe?>��]��ѯ�б�<? }else{echo "ע����ѯ���";}?></font></strong></td>
    <td width="58%"><table border="0" align="center" cellspacing="0" cellpadding="1" bordercolor="888888" bordercolordark="#FFFFFF" width="100%">
      <tr>
        <td>&nbsp;<span class="STYLE4">��ǰ����-->>
            <? if( $kithe!=""){?>
          ���
            <?=$kithe?>
            ��
            <? }else{?>
          �������䣺
            <?=$_POST['txt8']?>
            -----
            <?=$_POST['txt9']?>
            
          <? }?>
&nbsp;&nbsp;&nbsp;&nbsp;ͶעƷ�֣�
            <? if ($_POST['class2']!=""){?>
            <?=$_POST['class2']?>
            <? }else{?>
            ȫ��
            <? }?>
            ��ѯ���ࣺ
              <? if ($_POST['class']!=""){?>
              (
              <?
		   
		 
			if ($_POST['class']=="1"){echo "��Ա�˺�";}
		if ($_POST['class']=="2"){echo "��ע����";}
		if ($_POST['class']=="3"){echo "��ע����";}
		
		
			?>
              :
              <?=$_POST['key']?>
              )
              <? }else{?>
              ȫ��
              <? }?>
          </span> </td>
      </tr>
    </table></td>
    <td width="16%"><div align="right">
      <button onClick="javascript:history.go(-1);"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<%=z1color%>;'>������һҳ</span></button>&nbsp;<button onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/asp.gif" width="16" height="16" align="absmiddle" />��ӡ</button>
    </div></td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table border="1" align="center" cellspacing="1" height="87" cellpadding="5" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">

    <tr>
      <td width="50" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">���</td>
      <TD width="60" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">��Ա</TD>
      <TD width="50" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">�µ�ʱ�� </TD>
      <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">����</TD>
      <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">��ע���</TD>
      <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">����</TD>
      <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">��Ӷ%</TD>
      <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">����1</TD>
      <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">����2</TD>
      <TD width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">���</TD>
      <TD width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">����</TD>
    </tr>
    <?php
$z_re=0;
		$z_sum=0;
		$z_dagu=0;
		$z_guan=0;
		$z_zong=0;
		$z_dai=0;
		$re=0;
		
		$vvv="where 1=1";
		if ($kithe!=""){
		$vvv.=" and kithe=".$kithe."";
		$vvvv.="&kithe=".$kithe."";
		}else{
		if ($_POST['txt8']!="" and $_POST['txt9']!="" ){
		
		$stime=$_POST['txt8']." 00:00:00";
   $etime=$_POST['txt9']." 23:59:59";
		 
		$vvv.=" and adddate>='".$stime."' and adddate<='".$etime."' ";
		$vvvv.="&txt8=".$txt8."";
		$vvvv.="&txt9=".$txt9."";
		}else{$vvv.=" and Kithe=".$kithe." ";
		$vvvv.="&kithe=".$kithe."";}
		
		}
		
	
		if ($username!=""){
		$vvv.=" and username='".$username."' ";
		$vvvv.="&username=".$username."";
		}
		
		if ($_POST['class']!=""){
		$vvvv.="&class1=".$_POST['class']."";
		$vvvv.="&key=".$_POST['key']."";
		if ($_POST['key']!=""){
		if ($_POST['class']=="1"){$vvv.=" and username='".$_POST['key']."' ";		}
		if ($_POST['class']=="2"){$vvv.=" and num='".$_POST['key']."' ";}
		if ($_POST['class']=="3"){$vvv.=" and abcd='".$_POST['key']."' ";}
		
		}		
		}
		if ($_POST['class2']!=""){
		$vvv.=" and class2='".$_POST['class2']."' ";
		$vvvv.="&class2=".$_POST['class2']."";
		}



$result = mysql_query("select count(*) from ka_tan  ".$vvv."  order by id desc");   
$num = mysql_result($result,"0");
if(!$num){
     //cpmsg("Ŀǰû�пɱ༭��ͼƬ");
	// exit;
	echo "<tr align=center><td colspan=16>��������</td></tr>";
}
$curpage = intval($page);
$perpage = 50;
$pagesa = @ceil($num / $perpage);
if($curpage) {
	$start_limit = ($curpage - 1) * $perpage;
} else {
	$start_limit = 0;
	$curpage = 1;
}

$multipage = cpmulti($num, $perpage, $curpage, "?action=xx5".$vvvv."");
?>
    <?php
$result = mysql_query("select id,kithe,username,adddate,sum_m,rate,user_ds,class1,class2,class3,abcd  from   ka_tan ".$vvv."  order by id desc limit $start_limit, $perpage");   
while($rs = mysql_fetch_array($result)){

$ii++;
$z_re++;






$z_sum+=$rs['sum_m'];
//$z_dagu+=$Rs5['dagu_zc'];
//$z_guan+=$Rs5['guan_zc'];
//$z_zong+=$Rs5['zong_zc'];
//$z_dai+=$Rs5['dai_zc'];

$result2=mysql_query("select * from ka_mem where  kauser='".$rs['username']."' order by id"); 
$row11=mysql_fetch_array($result2);


if ($row11!=""){$xm="<font color=ff6600> (".$row11['xm'].")</font>";}
	
	
 

	
	
	
	
	 
	


?>
    <form action="index.php?action=x5&save=save&id=<?=$rs['id']?>&kithe=<?=$kithe?>&username=<?=$rs['username']?>" method="post" name="form" id="form"> <tr >
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$ii?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['username']?>
          <?=$xm?>
        .
        <?=$rs['abcd']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="adddate" type="text" class="input1"  id="adddate" value="<?=$rs['adddate']?>" size="20"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><font color=ff6600>
        <?=$rs['kithe']?>
        ��</font></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="sum_m" type="text" class="input1"  id="sum_m" value="<?=$rs['sum_m']?>" size="10"></td>
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><input name="rate" type="text" class="input1"  id="rate" value="<?=$rs['rate']?>" size="4"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="user_ds" type="text" class="input1"  id="user_ds" value="<?=$rs['user_ds']?>" size="4"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="class11" type="text" class="input1"  id="class11" value="<?=$rs['class1']?>" size="10"></td>
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><input name="class22" type="text" class="input1"  id="class22" value="<?=$rs['class2']?>" size="10"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="class33" type="text" class="input1"  id="class33" value="<?=$rs['class3']?>" size="10">
          <input name="class" type="hidden" id="class" value="<?=$_POST['class']?>">
          <input name="key" type="hidden" id="key" value="<?=$_POST['key']?>">
          <input name="class2" type="hidden" id="class2" value="<?=$_POST['class2']?>">
          <input name="txt8" type="hidden" id="txt8" value="<?=$_POST['txt8']?>">
          <input name="txt9" type="hidden" id="txt9" value="<?=$_POST['txt9']?>">
          <input name="kithe1" type="hidden" id="kithe1" value="<?=$rs['kithe']?>"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="�޸�" />
          <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="ɾ��" ></td>
    </tr> </form>
    <?php
}
?>
    <tr>
      <td height="25" colspan="11" bordercolor="cccccc"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888">
        <tr>
          <td height="26"><div align="left">
            <input type="hidden" name="idtxt" />
            <input name="id" type="hidden" id="id" value="<?=$image['id']?>" />
            <? if ($_POST['username']<>"") {?>
            <input name="username" type="hidden" id="username" value="<?=$_POST['username']?>" />
            <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc']?>" />
            <? }?>
            
            <button onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />ˢ��</button>
          </div></td>
          <td height="26" ><div align="center"> <?php echo $multipage;?>&nbsp;</div></td>
          <td height="26" width="60"><div align="center">
            <select name="page" onChange="location.href='index.php?action=xx5&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
              <? for($i =1; $i <= $pagesa; $i++) {?>
              <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>��
                <?=$i?>
                ҳ</option>
              <? }?>
            </select>
          </div></td>
        </tr>
      </table></td>
    </tr>
</table>
<br>
<table border="1" align="center" cellspacing="0" cellpadding="2" bordercolor="f1f1f1" bordercolordark="#FFFFFF" width="99%">
  <tr>
    <form name=form55 action="index.php?action=xx5" method=post>
      <td><table width="100" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td nowrap>��ѯ���ࣺ</td>
          <td nowrap><select name="class" id="class">
            <option  value="" selected>-ȫ��-</option>
            <option value="1">��Ա�˺�</option>
            <option value="2">��ע����</option>
            <option value="3">��ע����</option>
          </select>
                <input name="key"  class="input1" type="text" id="key" size="8"></td>
          <td nowrap>ͶעƷ�֣�</td>
          <td nowrap><select name="class2" id="class2">
            <option value="" selected="selected">-----ȫ��-----</option>
        <option value="��A">���룺��A</option>
        <option value="��B">���룺��B</option>
        <option value="��A">���룺��A</option>
        <option value="��B">���룺��B</option>
        <option value="��1��">���أ���1��</option>
        <option value="��2��">���أ���2��</option>
        <option value="��3��">���أ���3��</option>
        <option value="��4��" >���أ���4��</option>
        <option value="��5��" >���أ���5��</option>
        <option value="��6��" >���أ���6��</option>
        <option value="����1" >��1-6������1</option>
        <option value="����2"  >��1-6������2</option>
        <option value="����3"  >��1-6������3</option>
        <option value="����4"  >��1-6������4</option>
        <option value="����5" >��1-6������5</option>
        <option value="����6" >��1-6������6</option>
        <option value="����" >����</option>
        <option value="��ȫ��" >���룺��ȫ��</option>
        <option value="���ж�" >���룺���ж�</option>
        <option value="��ȫ��" >���룺��ȫ��</option>
        <option value="������"  >���룺������</option>
        <option value="�ش�" >���룺�ش�</option>
        <option value="��Ф" >��Ф����Ф</option>
        <option value="��Ф"  >��Ф����Ф</option>
        <option value="��Ф" >��Ф����Ф</option>
        <option value="��Ф"  >��Ф����Ф</option>
		<option value="��Ф" >��Ф����Ф</option>
		<option value="��Ф" >��Ф����Ф</option>
        <option value="һФ" >��Ф��һФ</option>
        <option value="�벨" >�벨</option>
        <option value="��벨" >��벨</option>
        <option value="ͷ��">ͷ��</option>
        <option value="β��">β��</option>
        <option value="����β��">����β��</option>
        <option value="��Ф" >��Ф</option>
        <option value="��ɫ��" >��ɫ��</option>
          </select>
                <input name="ac2" type="hidden" id="ac" value="A" /></td>
          <td nowrap>�������䣺</td>
          <td><table cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr>
                <td><input name="txt8" type="text" class="input1" value="<?=date("Y-m-d")?>" size="12">
                </td>
                <td><img src="images/date.gif" align="absmiddle" class="cursor" onClick="javascript:popdate(txt8)"> </td>
                <td align="middle" width="20">~</td>
                <td><input name="txt9" type="text" class="input1" value="<?=date("Y-m-d")?>" size="12">
                </td>
                <td><img src="images/date.gif" align="absmiddle" class="cursor" onClick="javascript:popdate(txt9)"></td>
                <td align="right" width="200"></td>
              </tr>
            </tbody>
          </table></td>
          <td nowrap>ѡ��������</td>
          <td><select name="kithe" id="kithe">
            <option value="" selected="selected">��ʱ������</option>
            <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=".$image['nn'];
				echo ">��".$image['nn']."��</OPTION>";
			  }
		?>
          </select></td>
          <td><INPUT  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type=submit value=��ѯ name=SUBMIT></td>
        </tr>
      </table></td>
    </FORM>
  </tr>
</table>
