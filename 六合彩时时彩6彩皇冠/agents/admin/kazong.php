<?
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}
 if (strpos($_SESSION['flag'],'06') ){}else{ 
echo "<center>��û�и�Ȩ�޹���!</center>";
exit;}

if ($_POST['sdel']!=""){
    $del_num=count($_POST['sdel']); 
   for($i=0;$i<$del_num;$i++){ 
    mysql_query("Delete from ka_guan where id='$sdel[$i]'");
	mysql_query("Delete from ka_guan where zongid='$sdel[$i]'");
	mysql_query("Delete from ka_zi where guanid='$sdel[$i]'");
	mysql_query("Delete from ka_tan where zongid='$sdel[$i]'");
	mysql_query("Delete from ka_mem where zongid='$sdel[$i]'");
	mysql_query("Delete from ka_quota where flag=0  and userid='$sdel[$i]'");
	mysql_query("Delete from ka_quota where zongid='$sdel[$i]'");
	 
             }  
    echo("<script type='text/javascript'>alert('ɾ���ɹ���');history.back();</script>"); 
 }
 
 if ($_GET['sdel']!=""){
   $dell=$_GET['sdel'];
    mysql_query("Delete from ka_guan where id='$sdel'");
	 mysql_query("Delete from ka_guan where zongid='$sdel'");
	mysql_query("Delete from ka_zi where guanid='$sdel'");
	mysql_query("Delete from ka_tan where zongid='$sdel'");
	mysql_query("Delete from ka_mem where zongid='$sdel'");
	mysql_query("Delete from ka_quota where flag=0  and userid='$sdel'");
	mysql_query("Delete from ka_quota where zongid='$sdel'");
	
    
    echo("<script type='text/javascript'>alert('ɾ���ɹ���');history.back();</script>"); 
 }
 //״̬
 if ($_GET['t0']=="��") {
 
$sql="update ka_guan set pz=0 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
echo "<script>alert('�޸��û�[<".$_GET['name'].">]Ϊ�����߷ɣ�!');history.back();</script>"; 
exit;

}
if ($_GET['t0']=="��") {
$sql="update ka_guan set pz=1 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
echo "<script>alert('�޸��û�[<".$_GET['name'].">]Ϊ��ֹ�߷�!');history.back();</script>"; 
exit;

}



//״̬
 if ($_GET['t1']=="��") {
 
$sql="update ka_guan set stat=0 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
echo "<script>alert('�޸��û�[<".$_GET['name'].">]Ϊ������!');history.back();</script>"; 
exit;

}
if ($_GET['t1']=="��") {
$sql="update ka_guan set stat=1 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
echo "<script>alert('�޸��û�[<".$_GET['name'].">]Ϊ��ֹ!');history.back();</script>"; 
exit;

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

if ($_GET['id']!=""){$id=$_GET['id'];}else{$id=0;}


if ($_GET['ids']!=""){$ids=$_GET['ids'];}else{$ids=0;}
if ($ids==0){

if ($_POST['ids']!=0){$ids=$_POST['ids'];}else{$ids=0;}
}


$result=mysql_query("select * from ka_guan where id=".$ids." and lx=1 order by id"); 
$row11=mysql_fetch_array($result);
if ($row11!=""){
$guan="[".$row11['kauser']."]";

}




 
?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>

<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
-->
</style>
<div align="center">

    
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr class="tbtitle">
           <form name="form3" method="post" action="index.php?action=kazong"> <td width="23%"><font color=ffffff>�ɶ�</font><SELECT name=ids class=zaselect_ste id="ids" 
            onchange=self.form3.submit()>
            
			 <option value="0" <? if ($ids==0) {?>selected="selected"<? }?>>ȫ��</option>  
			<? $result = mysql_query("select * from ka_guan where lx=1  order by id desc");   
while($image = mysql_fetch_array($result)){
?> 
			 
			  <option value="<?=$image['id']?>" <? if ($ids==$image['id']) {?>selected="selected"<? }?>><?=$image['kauser']?></option>
			    <? }?>
				
			
			</SELECT></td></form>
            <td width="28%"><table>
              <form  action="index.php?action=kazong&amp;id=0" method="post" name="regstep1" id="regstep1">
                <tr>
                  <td colspan="2" align="center" nowrap="nowrap"><p align="right" class="STYLE1">�ܴ����˺ţ�</p></td>
                  <td align="center" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input name="key" type="text" class="input1" id="key" size="10" /></td>
                        <td width="80" align="center"><input type="submit" value="ȷ������" name="B1"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;></td>
                        <td>&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
              </form>
            </table></td>
            <td width="49%"><div align="right">
              <button onclick="javascript:location.href='index.php?action=kazong&amp;id=0'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <? if ($id==0) {?>color=ff0000<? }else{?>color=000000<? }?>>�����ܴ���</font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=kazong&amp;id=2'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <? if ($id==2) {?>color=ff0000<? }else{?>color=000000<? }?>>����
               
                </font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=kazong&amp;id=1'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <? if ($id==1) {?>color=ff0000<? }else{?>color=000000<? }?>>
                <??>
                ��ֹ
                
                </font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=zong_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" />����ܴ���</button>
            </div></td>
          </tr>
          <tr >
            <td height="5" colspan="3"></td>
          </tr>
        </table>
        <table border="1" align="center" cellspacing="1" height="84" cellpadding="5" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
           <form name="form1" method="post" action="index.php?action=kazong"> <tr > 
            <td width="50" height="28" bordercolor="cccccc" bgcolor="#FDF4CA"> 
              <div align="center"><input type="checkbox" name="sele" value="checkbox" onclick="javascript:checksel(this.form);"></div>            </td>
            <td bordercolor="cccccc" bgcolor="#FDF4CA"> 
              <div align="center">�˺�</div>            </td>
            <td width="50" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">����</td>
            <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">���ö��/�������</td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">�ɶ�</td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">��/�� </td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">��%</td>
            <td width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">��%</td>
            <td width="40" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">��˾%</td>
            <td width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">�߷�</td>
            <td width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">״��</td>
            <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">ע��ʱ��</td>
            <td width="50" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">��¼����</td>
            <td nowrap bordercolor="cccccc" bgcolor="#FDF4CA"> 
              <div align="center">����</div>            </td>
          </tr>
		  <?php

$xc=$_POST['xc'];
$key=$_POST['key'];
if ($xc==""){$xc=$_GET['xc'];}
if ($key==""){$xc=$_GET['key'];}

$vvv=" where lx=2 ";
$vvvv="&id=".$id."";
if ($key<>""){$vvv.=" and kauser LIKE '%$key%'  ";

$vvvv.="&key=".$key."";}

if ($id==1){$vvv.=" and stat=1  ";}
if ($id==2){$vvv.=" and stat=0  ";}

if ($ids<>0){$vvv.=" and guanid=".$ids."  ";
$vvvv.="&ids=".$ids."";
}




$result = mysql_query("select count(*) from ka_guan  ".$vvv."  order by id desc");   
$num = mysql_result($result,"0");
if(!$num){
     //cpmsg("Ŀǰû�пɱ༭��ͼƬ");
	// exit;
	echo "<tr align=center><td colspan=14>��������</td></tr>";
}
$curpage = intval($page);
$perpage = 10;
$pagesa = @ceil($num / $perpage);
if($curpage) {
	$start_limit = ($curpage - 1) * $perpage;
} else {
	$start_limit = 0;
	$curpage = 1;
}

$multipage = cpmulti($num, $perpage, $curpage, "?action=kazong".$vvvv."");
?>
<?php
$result = mysql_query("select * from ka_guan  ".$vvv."  order by id desc limit $start_limit, $perpage");   
while($image = mysql_fetch_array($result)){


$mumu=0;
  
 $result1 = mysql_query("Select SUM(cs) As sum_m  From ka_guan Where lx=3 and   zongid=".$image['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mumu=$rsw[0];}
	
	 $result2 = mysql_query("Select SUM(sum_m) As sum_m   From ka_tan Where kithe=".$Current_Kithe_Num." and   username='".$image['kauser']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	
	 
	 
	 
	  $memnum=0;
	  $memnum1=0;
	  	  $memnum2=0;
		  
		  
	$result1 = mysql_query("Select Count(ID) As memnum1 From ka_guan Where lx=3 and zongid=".$image['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$memnum1=$rsw[0];}else{$memnum1=0;}
	$result1 = mysql_query("Select Count(ID) As memnum2 From ka_mem Where zongid=".$image['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$memnum2=$rsw[0];}else{$memnum2=0;}
	
	
	  

	 
 

	
	
	
	
	 
	


?>

<tr> 
            <td height="25" bordercolor="cccccc"> 
              <div align="center"><input name="sdel[]" type="checkbox" id="sdel[]" value="<?=$image['id']?>">
              </div>            </td>
            <td height="25" align="center" bordercolor="cccccc"> 
             <button onclick="javascript:location.href='index.php?action=kadan&amp;id=<?=$image['id']?>&amp;ids1=<?=$image['id']?>'"  class="headtd4" style="width:80;height:22" ;><font color="ff6600"> <?=$image['kauser']?> </font></button>			  </td>
            <td height="25" align="center" bordercolor="cccccc"><?=$image['xm']?></td>
            <td height="25" align="center" bordercolor="cccccc"><?=$image['cs']?>/<font color=ff0000><?=$image['cs']-$mumu-$mkmk?></font></td>
			<td height="25" align="center" bordercolor="cccccc">
			<button class=headtd4  onmouseover="this.className='headtd3';window.status='�ܴ�����'; return true;" onMouseOut="this.className='headtd4';window.status='�ܴ�����';return true;"  onClick="javascript:location.href='index.php?action=kazong&ids=<?=$image['guanid']?>'"><?=$image['guan']?></button>			</td>
            <td height="25" align="center" bordercolor="cccccc"><?=$memnum1?>/<?=$memnum2?></td>
            <td height="25" align="center" bordercolor="cccccc"><?=$image['sf']?>%</td>
			 <td height="25" align="center" bordercolor="cccccc"><?=$image['sj']?>%</td>
            <td height="25" align="center" bordercolor="cccccc"><?=100-$image['sf']-$image['sj']?>%</td>
			
            <td height="25" align="center" bordercolor="cccccc">
			
			<a href="index.php?action=kazong&newsid=<?=$image['id']?>&amp;t0=<? if($image['pz']==0){ ?>��<? }else{?>��<? }?>&amp;id=<?=$image['id']?>&amp;ids=<?=$ids?>&amp;page=<?=$curpage?>&amp;name=<?=$image['kauser']?>&amp;key=<?=$_POST['key']?>"><img src="images/<? if ($image['pz']==0){ ?>icon_21x21_selectboxon.gif<? }else{ ?>icon_21x21_selectboxoff.gif<? }?>" name="test_b<?=$image['id']?>" width="21" height="21" border="0" id="test_b<?=$image['id']?>"  value="<? if($image['pz']==0){ ?>True<? }else{?>False<? }?>" ></a>			</td>
            <td height="25" align="center" bordercolor="cccccc">
			<a href="index.php?action=kazong&newsid=<?=$image['id']?>&amp;t1=<? if($image['stat']==0){ ?>��<? }else{?>��<? }?>&amp;id=<?=$image['id']?>&amp;ids=<?=$ids?>&amp;page=<?=$curpage?>&amp;name=<?=$image['kauser']?>&amp;key=<?=$_POST['key']?>"><img src="images/<? if ($image['stat']==0){ ?>icon_21x21_selectboxon.gif<? }else{ ?>icon_21x21_selectboxoff.gif<? }?>" name="test_b<?=$image['id']?>" width="21" height="21" border="0" id="test_b<?=$image['id']?>"  value="<? if($image['stat']==0){ ?>True<? }else{?>False<? }?>" ></a>			</td>
            <td height="25" align="center" bordercolor="cccccc"><?=$image['adddate']?></td>
            <td height="25" align="center" bordercolor="cccccc"><?=$image['look']?></td>
            <td nowrap bordercolor="cccccc"> 
              <div align="center">
			
			   <button onClick="javascript:location.href='index.php?action=zong_edit&id=<?=$image['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" ;><img src="images/icon_21x21_edit01.gif" align="absmiddle">�޸�</button>
			    <button onClick="javascript:location.href='index.php?action=dan_add&id=<?=$image['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle">���</button>
				 <button onClick="javascript:location.href='index.php?action=kazi&ids=<?=$image['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle">���˺�</button>
				  
			      <button onClick="javascript:location.href='index.php?action=kazong&act=ɾ��&page=<?=$curpage?>&id=<?=$image['id']?>&sdel=<?=$image['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" ;><img src="images/icon_21x21_del.gif" align="absmiddle">ɾ��</button>
</div>            </td>
          </tr>


<?php
}
?><tr>
  <td height="25" colspan="14" bordercolor="cccccc"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888">
    <tr>
      <td height="26"><div align="left">
          <input type="hidden" name="idtxt" />
          <input name="id" type="hidden" id="id" value="<?=$image['id']?>" />
          <? if ($_POST['username']<>"") {?>
          <input name="username" type="hidden" id="username" value="<?=$_POST['username']?>" />
          <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc']?>" />
          <? }?>
          <button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:95;height:22" ;><img src="images/icon_21x21_del.gif" align="absmiddle" />ɾ��ѡ����Ա</button>
        &nbsp;
        <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />ˢ��</button>
      </div></td>
      <td height="26" ><div align="center"> <?php echo $multipage;?>&nbsp;</div></td>
      <td height="26" width="60"><div align="center">
          <select name="page" onchange="location.href='index.php?action=kadan&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
            <? for($i =1; $i <= $pagesa; $i++) {?>
            <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>��
              <?=$i?>
              ҳ</option>
            <? }?>
          </select>
      </div></td>
    </tr>
  </table></td>
  </tr></form>
        </table>
		
</div>

