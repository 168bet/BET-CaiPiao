<?php 
define('Copyright', '作者QQ:914190123');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';

$db=new DB();
$total = $db->query("SELECT * FROM g_news", 3);
$pageNum = 5;
$page = new Page($total, $pageNum);
$result = $db->query("SELECT * FROM g_news ORDER BY g_id DESC {$page->limit} ", 1);

$css=$_GET['skin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE></TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<LINK rel=stylesheet type=text/css href="/userlib/css/left.css">
</head>
<body>
 <TABLE class="t_list t_result" cellSpacing=1 cellPadding=0 width=700>
<TBODY>
<TR class="t_list_caption_1 tbheader">
<TD>时间</TD>
<TD>公告详情</TD></TR>

<?php if(!$result){echo'<TR class=t_td_caption_1><td align="center" colspan="2">暫無記錄</td></tr>';}else{
				                	for ($i=0; $i<count($result); $i++){
				                	?>
	<TR class=t_td_caption_1>
<TD width="20%"><?php echo$result[$i]['g_date']?></TD>
<TD><?php echo$result[$i]['g_text']?></TD>
 </tr>
	   <?php }}?>
	   <tr class="">
        <td style="text-align:right;text-indent:2em; background-color:#fdf8f2" colspan="2"><?php echo $page->fpage(array(0,1, 3,4,5,6,7))?></td>
      </tr>
</TBODY></TABLE>
<STYLE type=text/css>.t_list {
	MARGIN: 15px 5px
}
</STYLE>

</body>
</html>
   
   
  