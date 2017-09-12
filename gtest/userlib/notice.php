<?php 
define('Copyright', '作者QQ:914190123');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/cheCookie.php';
$db=new DB();
$total = $db->query("SELECT * FROM g_news", 3);
$pageNum = 5;
$page = new Page($total, $pageNum);
$result = $db->query("SELECT * FROM g_news  ".base64_decode($_GET['date'])."  ORDER BY g_id DESC {$page->limit} ", 1);

$css=$_GET['skin'];

markPos("前台-公告详情-us");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link	href="/webssc/css/all_f.css" type="text/css" rel="stylesheet">
</link>
</head>
<body class="<?php echo $css;?>" style="background-image:none;">
<div class="mains_corll"  >
  <table class="t1 dataArea struct_table_center more_announcement w100" style="top:10px; position:absolute">
    <tbody>
      <tr class="">
        <th style="width:110px">时间</th>
        <th>公告详情</th>
      </tr>
    </tbody>
    <tbody class="more_ann_box">
	<?php if(!$result){echo'<td align="center" colspan="2">暫無記錄</td>';}else{
				                	for ($i=0; $i<count($result); $i++){
				                	?>
            <tr class="">
        <td><?php echo$result[$i]['g_date']?></td>
        <td style="text-align:left;text-indent:2em;"><?php echo$result[$i]['g_text']?></td>
      </tr>
	   <?php }}?>
	    <tr class="">
        <td style="text-align:right;text-indent:2em;" colspan="2"><?php echo $page->fpage(array(0,1, 3,4,5,6,7))?></td>
      </tr>
          </tbody>
  </table>
</div>
<script src="/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">  
$('.more_announcement tbody').find('tr').bind({
	'mouseenter':function(){$(this).addClass('bc');},
	'mouseleave':function(){$(this).removeClass('bc');}
}) 
</script>
</body>
</html>
   
