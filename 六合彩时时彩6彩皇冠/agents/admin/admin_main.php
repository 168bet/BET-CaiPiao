<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

if (strpos($_SESSION['flag'],'13') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}

if ($_POST['sdel']!=""){
    $del_num=count($_POST['sdel']); 
   for($i=0;$i<$del_num;$i++){ 
    mysql_query("Delete from ka_admin where id='$sdel[$i]'");
		 
             }  
    echo("<script type='text/javascript'>alert('删除成功！');history.back();</script>"); 
 }
 
 if ($_GET['sdel']!=""){
   $dell=$_GET['sdel'];
    mysql_query("Delete from ka_admin where id='$sdel'");
	    
    echo("<script type='text/javascript'>alert('删除成功！');history.back();</script>"); 
 }
 
 $iszd=0;
 //echo $iszd;
 if ($_GET['szd']=="1"){
    $zd=$_POST["iszhudan"];
	if($zd!="")$iszd=1;else $zd=0;
	$sql="Update config set iszhudan='$zd'";
    mysql_query($sql);
 }
 //echo $iszd;
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
		
		
		$multipage = $multipage ? '总计:'.$num.'个&nbsp;&nbsp;共'.$to.'页&nbsp;&nbsp;当前:<font color=ff0000>'.$curpage.'页</font>  &nbsp;&nbsp;'.$multipage.'&nbsp; ' : '';
	}
	return $multipage;
}

?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>
<div align="center">
 
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr class="tbtitle">
        <td width="91%"><? require_once '4top.php';?></td>
        <td width="9%"><div align="right">
          <button onclick="javascript:location.href='index.php?action=admin_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" />添加用户</button>
        </div></td>
      </tr>
      <tr >
        <td height="5" colspan="2"></td>
      </tr>
    </table>
    <table border="1" align="center" cellspacing="1" height="84" cellpadding="5" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
       <form name="form1" method="post" action="index.php?action=admin_main"><tr>
        <td width="50" height="28" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">
          <input type="checkbox" name="sele" value="checkbox" onclick="javascript:checksel(this.form);" />
        </div></td>
        <td bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">用户名</div></td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">登录次数</td>
        <td nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">操作</div></td>
      </tr>
      <?php

$xc=$_POST['xc'];
$key=$_POST['key'];
if ($xc==""){$xc=$_GET['xc'];}
if ($key==""){$xc=$_GET['key'];}

$vvv=" where lx=3 ";
$vvvv="&id=".$id."";
if ($key<>""){$vvv.=" and kauser LIKE '%$key%'  ";

$vvvv.="&key=".$key."";}

if ($id==1){$vvv.=" and stat=1  ";}
if ($id==2){$vvv.=" and stat=0  ";}

if ($ids<>0){$vvv.=" and guanid=".$ids."  ";
$vvvv.="&ids=".$ids."";
}
if ($ids1<>0){$vvv.=" and zongid=".$ids1."  ";
$vvvv.="&ids1=".$ids1."";
}




$result = mysql_query("select count(*) from ka_admin   order by id desc");   
$num = mysql_result($result,"0");
if(!$num){
     //cpmsg("目前没有可编辑的图片");
	// exit;
	echo "<tr align=center><td colspan=16>暂无数据</td></tr>";
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

$multipage = cpmulti($num, $perpage, $curpage, "?action=admin_main");
?>
      <?php
$result = mysql_query("select * from ka_admin    order by id desc limit $start_limit, $perpage");   
while($image = mysql_fetch_array($result)){ ?>
      <tr>
        <td height="25" bordercolor="cccccc"><div align="center">
          <input name="sdel[]" type="checkbox" id="sdel" value="<?=$image['id']?> " />
        </div></td>
        <td height="25" bordercolor="cccccc"><div align="left">
          <?=$image['username']?>
        </div></td>
        <td height="25" align="center" bordercolor="cccccc"><?=$image['look']?></td>
        <td nowrap="nowrap" bordercolor="cccccc"><div align="center">
            <button onclick="javascript:location.href='index.php?action=editadmin&amp;id=<?=$image['id']?> '"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_edit01.gif" align="absmiddle" />设置权限</button>
          <button onclick="javascript:location.href='index.php?action=admin_main&amp;act=删除&amp;page=<?=$curpage?>&amp;id=<?=$image['id']?>&amp;sdel=<?=$image['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" ;><img src="images/icon_21x21_del.gif" align="absmiddle" />删除</button>
        </div></td>
      </tr>
      <? }?>
      <tr>
        <td height="25" colspan="4" bordercolor="cccccc"><table width="99%" border="0" align="center" cellpadding="1" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888">
            <tr>
              <td width="200" height="26" nowrap="nowrap"><div align="left">
                  <input type="hidden" name="idtxt" />
                  <input name="id" type="hidden" id="id" value="<?=$image['id']?>" />
                  <? if ($_POST['username']<>"") {?>
                  <input name="username" type="hidden" id="username" value="<?=$_POST['username']?>" />
                  <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc']?>" />
                  <? }?>
                  <button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:95;height:22" ;><img src="images/icon_21x21_del.gif" align="absmiddle" />删除选定会员</button>&nbsp;<button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button>
              </div></td>
              <td height="26" ><div align="center"> <?php echo $multipage;?>&nbsp;</div></td>
              <td height="26" width="60"><div align="center">
                  <select name="page" onchange="location.href='index.php?action=kadan&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
                    <? for($i =1; $i <= $pagesa; $i++) {?>
                    <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第
                      <?=$i?>
                      页</option>
                    <? }?>
                  </select>
              </div></td>
            </tr>
        </table></td>
      </tr>  </form>
    </table>
    <br />

    <br />
    <div align="center">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="221"><div align="left"><form id="fzd" method="post" action="index.php?action=admin_main&amp;page=<?=$curpage?>&szd=1"><input name="iszhudan" <? if($iszd==1) echo "checked";?> type="checkbox" value="1" /> 
          前台注单查询控制 <button onclick="javascript:document.all.fzd.submit();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;>保存</button>
          </form></div></td>
          <td width="673"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 提示：会员修改</div></td>
        </tr>
      </table>
    </div>

</div>

