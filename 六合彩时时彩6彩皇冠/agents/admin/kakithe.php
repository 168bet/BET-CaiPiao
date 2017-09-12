<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}

if ($_POST['sdel']!=""){
    $del_num=count($_POST['sdel']); 
   for($i=0;$i<$del_num;$i++){ 
    mysql_query("Delete from ka_kithe where id='$sdel[$i]'"); 
             }  
    echo("<script type='text/javascript'>alert('删除成功！');history.back();</script>"); 
 }
 
 if ($_GET['sdel']!=""){
   $dell=$_GET['sdel'];
    mysql_query("Delete from ka_kithe where id='$dell'"); 
    echo("<script type='text/javascript'>alert('删除成功！');history.back();</script>"); 
 }
 //状态
 if ($_GET['t0']=="是") {
$sql="update ka_kithe set lx=1 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("数据库修改出错");
echo "<script>alert('修改第[<".$_GET['name'].">]期为显示，让会员代理可以查看数据！!');history.back();</script>"; 
exit;

}
if ($_GET['t0']=="否") {
$sql="update ka_kithe set lx=0 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("数据库修改出错");
echo "<script>alert('修改第[<".$_GET['name'].">]期为隐藏，让会员代理查看不到数据!');history.back();</script>"; 
exit;

}



 // 分页
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
		
		
		$multipage = $multipage ? '总计:'.$num.'期&nbsp;&nbsp;共'.$to.'页&nbsp;&nbsp;当前:<font color=ff0000>'.$curpage.'页</font>  &nbsp;&nbsp;'.$multipage.'&nbsp; ' : '';
	}
	return $multipage;
}
if ($_GET['id']!=""){$id=$_GET['id'];}else{$id=0;}

?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>

<div align="center"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="23%"><? require_once '1top.php';?></td>
	<td width="29%"><table>
      <form  action="index.php?action=kakithe&amp;id=0" method="post" name="regstep1" id="regstep1">
        <tr>
          <td colspan="2" align="center" nowrap="nowrap"><p align="right"><font color="#FFFFFF">期数：</font></p></td>
          <td align="center" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="key" type="text" class="input1" id="key" size="20" /></td>
                <td width="80" align="center"><input type="submit" value="确定搜索" name="B1"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;></td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </form>
	  </table><td width="20%">&nbsp;</td><td width="1%"></td>
	<td width="27%"><div align="right">
      <button onclick="javascript:location.href='index.php?action=kakithe&amp;id=0'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <? if ($id==0) {?>color=ff0000<? }else{?>color=000000<? }?>>所有期数</font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=kakithe&amp;id=2'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <? if ($id==2) {?>color=ff0000<? }else{?>color=000000<? }?>>显示</font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=kakithe&amp;id=1'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <? if ($id==1) {?>color=ff0000<? }else{?>color=000000<? }?>>隐藏</font></button>&nbsp;</div></td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
    </tr>
</table>

 
  
    <table width="99%" height="83" border="1" align="center" cellpadding="5" cellspacing="1"  bordercolor="f1f1f1" bgcolor="ffffff">
       <tr>
	     <td colspan="2" align="center" bgcolor="#FDF4CA">六合彩</td>
	   </tr>
      <form name="form1" method="post" action="index.php?action=kakithe">
      <tr >
        <td width="50" height="28" rowspan="2" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">
          <input type="checkbox" name="sele" value="checkbox" onclick="javascript:checksel(this.form);" />
        </div></td>
        <td width="60" rowspan="2" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">期数</div></td>
        <td width="135" rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">开奖时间</td>
        <td colspan="7" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">开奖球号</td>
        <td width="95" rowspan="2" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">生肖</td>
        <td width="80" rowspan="2" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">是否开奖 </td>
        <td width="50" rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">状态</td>
        <td width="150" rowspan="2" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">操作</div></td>
      </tr>
      <tr >
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平1</td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平2</td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平3</td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平4</td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平5</td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平6</td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">特码</td>
      </tr>
      <?php

$xc=$_POST['xc'];
$key=$_POST['key'];
if ($xc==""){$xc=$_GET['xc'];}
if ($key==""){$xc=$_GET['key'];}

$vvv=" where na<>0 ";
$vvvv="&id=".$id."";
if ($key<>""){$vvv.=" and nn LIKE '%$key%'  ";

$vvvv.="&key=".$key."";}

if ($id==1){$vvv.=" and lx=0  ";}
if ($id==2){$vvv.=" and lx=1  ";}




$result = mysql_query("select count(*) from ka_kithe  ".$vvv."  order by id desc");   
$num = mysql_result($result,"0");
if(!$num){
     //cpmsg("目前没有可编辑的图片");
	// exit;
	echo "<tr align=center><td colspan=14>暂无数据</td></tr>";
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

$multipage = cpmulti($num, $perpage, $curpage, "?action=kakithe".$vvvv."");
?>
      <?php
$result = mysql_query("select * from ka_kithe  ".$vvv."  order by id desc limit $start_limit, $perpage");   
while($image = mysql_fetch_array($result)){
?>
      <tr>
        <td height="25" bordercolor="cccccc" bgcolor="#FFFFFF"><div align="center">
          <input name="sdel[]" type="checkbox" id="sdel[]" value="<?=$image['id']?>" <? if($image['score']==1){ ?>disabled="disabled"<? } ?> />
        </div></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$image['nn']?>        </td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$image['nd']?></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['n1']?>.gif" /></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['n2']?>.gif" /></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['n3']?>.gif" /></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['n4']?>.gif" /></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['n5']?>.gif" /></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['n6']?>.gif" /></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="f1f1f1"><img src="images/num<?=$image['na']?>.gif" /></td>
        <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$image['x1']?><?=$image['x2']?><?=$image['x3']?><?=$image['x4']?><?=$image['x5']?><?=$image['x6']?>+<?=$image['sx']?></td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?
			if ($image['na']<>0){
			 echo "已开奖";
			 }else{
			  echo "<font color=ff0000>未开奖</font>";
			 }?>        </td>
        <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?
			if ($image['n1']<>0){
			?>
            <a href="index.php?action=kakithe&amp;newsid=<?=$image['id']?>&amp;t0=<? if($image['lx']==1){ ?>否<? }else{?>是<? }?>&amp;id=<?=$image['id']?>&amp;ids=<?=$ids?>&amp;page=<?=$curpage?>&amp;name=<?=$image['nn']?>&amp;key=<?=$_POST['key']?>"><img src="images/<? if ($image['lx']==1){ ?>icon_21x21_selectboxon.gif<? }else{ ?>icon_21x21_selectboxoff.gif<? }?>" name="test_b<?=$image['id']?>" width="21" height="21" border="0" id="test_b<?=$image['id']?>"  value="<? if($image['lx']==1){ ?>True<? }else{?>False<? }?>"></a>
            <? }else{?>
            <font color="ff0000">未开奖</font>
            <? }?>        </td>
        <td nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF"><div align="center">
            <button onclick="javascript:location.href='index.php?action=kawin&amp;kithe=<?=$image['nn']?>'" <? if($image['score']==1){ ?>disabled="disabled"<? } ?>  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" ;><img src="images/banner.gif" width="16" height="16" align="absmiddle" />结算</button>&nbsp;<button onclick="javascript:location.href='index.php?action=kithe_edit&amp;id=<?=$image['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" <? if($image['score']==1){ ?>disabled="disabled"<? } ?>><img src="images/icon_21x21_edit01.gif" align="absmiddle" />修改</button>&nbsp;<button onclick="javascript:location.href='index.php?action=kakithe&amp;act=删除&amp;page=<?=$curpage?>&amp;id=<?=$image['id']?>&amp;sdel=<?=$image['id']?><? if ($username<>""){ ?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" <? if($image['score']==1){ ?>disabled="disabled"<? } ?>><img src="images/icon_21x21_del.gif" align="absmiddle" />删除</button>
        </div></td>
      </tr>
      <?php
}
?>
      <tr>
        <td height="25" colspan="14" bordercolor="cccccc" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888">
            <tr>
              <td width="180" height="26" nowrap="nowrap"><div align="left">
                  <input type="hidden" name="idtxt" />
                  <input name="id" type="hidden" id="id" value="<%=id%>" />
                  <? if ($_POST['username']<>"") {?>
                  <input name="username" type="hidden" id="username" value="<?=$_POST['username']?>" />
                  <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc']?>" />
                  <? }?>
                  <button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:95;height:22" ;><img src="images/icon_21x21_del.gif" align="absmiddle" />删除选定期数</button>&nbsp;<button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button>
              </div></td>
              <td height="26"><div align="center"> <?php echo $multipage;?>&nbsp;</div></td>
              <td height="26" width="60"><div align="center">
                  <select name="page" onchange="location.href='index.php?action=kakithe&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
                    <? for($i =1; $i <= $pagesa; $i++) {?>
                    <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第
                      <?=$i?>
                      页</option>
                    <? }?>
                  </select>
              </div></td>
            </tr>
          </table>
        </td>
      </tr>  </form>
  </table>

  <table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70"><div align="left"> </div></td>
    <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 提示：如果修改某一期的任何一个球号后请再重新结算该期！状态如果打上了勾前台会员代理才可以查看该期的数据否则无法查看!</div></td>
  </tr>
</table>
</div>

