<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
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

<html>
<head>
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
  <style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
}
.STYLE1 {color: #FFFFFF}
-->
 </style>
 </head>



<body  oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()" >
    <table border="0" cellpadding="0" cellspacing="0" width="630">
        <tr>
            <td width="10%">
                香港㈥合彩
            </td>
            <td width="90%">&nbsp;—&nbsp;开奖结果查询</td>
        </tr>
    </table>
 <form name="form1" method="post" action="index.php?action=kakithe" style="height:610px;">
  <table border="0" cellpadding="0" cellspacing="1"  class="t_list">
      
     
        <tr>
            <td class="t_list_caption F_bold" colspan="10">香港㈥合彩</td>
            <td class="t_list_caption F_bold" >正码</td>
            <td class="t_list_caption F_bold" colspan="4">特码</td>
            <td class="t_list_caption F_bold">特合</td>
            <td class="t_list_caption F_bold" colspan="3">总数</td>
        </tr>
        <tr>
            <td class="t_list_caption" width="50">期号</td>
            <td class="t_list_caption" width="75">开奖日期</td>
            <td class="t_list_caption" colspan="8" width="206">开奖号码</td>
             <td class="t_list_caption">正码生肖</td>
            <td class="t_list_caption" width="35">
                生肖
            </td>
            <td class="t_list_caption" width="35">单双</td>
            <td class="t_list_caption" width="35">大小</td>
            <td class="t_list_caption" width="35">尾数</td>
            <td class="t_list_caption" width="35">单双</td>
            <td class="t_list_caption" width="40">总和</td>
            <td class="t_list_caption" width="35">单双</td>
            <td class="t_list_caption" width="35">大小</td>
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
$nn=1; 
while($image = mysql_fetch_array($result)){
?>
        <tr class="Ball_tr_H" onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#FFFFA2'">
            <td><b><?=$image['nn']?></b></td>
            <td><?=date("y-m-d",strtotime($image['nd']))?></td>
            <td class="No_05" width="27"><img src="images/num<?=$image['n1']?>.gif" />
            </td>
            <td class="No_32" width="27"><img src="images/num<?=$image['n2']?>.gif" />
            </td>
            <td class="No_48" width="27"><img src="images/num<?=$image['n3']?>.gif" />
            </td>
            <td class="No_20" width="27"><img src="images/num<?=$image['n4']?>.gif" />
            </td>
            <td class="No_15" width="27"><img src="images/num<?=$image['n5']?>.gif" />
            </td>
            <td class="No_06" width="27"><img src="images/num<?=$image['n6']?>.gif" />
            </td>
            <td width="17">
                <b>＋</b></td>
            <td class="No_22" width="27"><img src="images/num<?=$image['na']?>.gif" />
            </td>
             <td>
            <?=$image['x1']?>&nbsp;<?=$image['x2']?>&nbsp;<?=$image['x3']?>&nbsp;<?=$image['x4']?>&nbsp;<?=$image['x5']?>&nbsp;<?=$image['x6']?>
            </td>
            <td>
            <?=$image['sx']?>
            
            </td>
            <td>
               
                 <? if ($image['na']%2==1){echo "<span class='Font_B'>单</span>";}else{echo "<span class='Font_R'>双</span>";}?>
               
            </td>
            <td>
              <? if ($image['na']>=25){echo "<span class='Font_B'>大</span>";}else{echo "<span class='Font_R'>小</span>";}?>
               
            </td>
            <td>
             <? if (substr($image['na'],-1,1)>=5){echo "<span class='Font_B'>大</span>";}else{echo "<span class='Font_R'>小</span>";}?>
               
            </td>
            <td>
             <? if (($image['na']%10+intval($image['na'])/10)%2==1){echo "<span class='Font_B'>单</span>";}else{echo "<span class='Font_R'>双</span>";}?>
              
            </td>
            <td>
               <?  $zh=($image['na']+$image['n1']+$image['n2']+$image['n3']+$image['n4']+$image['n5']+$image['n6']); echo $zh; ?>
            </td>
            <td>
                  <? if ($zh%2==1){echo "<span class='Font_B'>单</span>";}else{echo "<span class='Font_R'>双</span>";}?>
              
            </td>
            <td>

                    <? if ($zh>=175){echo "<span class='Font_B'>大</span>";}else{echo "<span class='Font_R'>小</span>";}?>
            </td>
            
        </tr>


      <?php
	  $nn++;
}
?>
      <tr>
        <td height="25" colspan="19" class="t_list_bottom"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
            <tr>
              <td width="180" height="26" nowrap="nowrap"><div align="left">
                  <input type="hidden" name="idtxt" />
                  <input name="id" type="hidden" id="id" value="<%=id%>" />
                  <? if ($_POST['username']<>"") {?>
                  <input name="username" type="hidden" id="username" value="<?=$_POST['username']?>" />
                  <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc']?>" />
                  <? }?>
                  <button onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button>
              </div></td>
              <td height="26"><div align="center"> <?php echo $multipage;?>&nbsp;</div></td>
              <td height="26" width="60"><div align="center">
                  <select name="page" onChange="location.href='index.php?action=kakithe&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
                    <? for($i =1; $i <= $pagesa; $i++) {?>
                    <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第
                      <?=$i?>
                      页</option>
                    <? }?>
                  </select>
              </div></td>
            </tr>
          </table>        </td>
      </tr>  
  </table>

</form>


</body>
</html>
