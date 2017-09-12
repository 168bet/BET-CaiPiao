<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
include_once ROOT_PATH.'class/Page_us.php';
markPos("前台-报表明细-us");
if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{
global $user;
if ($_GET['gid'] == null) exit;
$date = base64_decode($_GET['gid']);
$startDate = $date.' 02:00';
$endDate = dayMorning($date, (60*60*24)).' 02:00';
$date = " `g_date` > '{$startDate}' AND `g_date` < '{$endDate}' ";
$db = new DB();

	if(!isset($_GET['type']) || $_GET['type']==0)
	$g_type=" ";
	if($_GET['type']==1)
	$g_type=" and g_type='廣東快樂十分' ";
	if($_GET['type']==2)
	$g_type=" and g_type='重慶時時彩' ";
	if($_GET['type']==3)
	$g_type=" and g_type='廣西快樂十分' ";
	if($_GET['type']==4)
	$g_type=" and g_type='江西時時彩' ";
	if($_GET['type']==5)
	$g_type=" and g_type='幸运农场' ";
	if($_GET['type']==6)
	$g_type=" and g_type='北京赛车PK10' ";
	if($_GET['type']==7)
	$g_type=" and g_type='江苏骰寶(快3)' ";
	
	if($_GET['type']==1)
	$show_type="廣東快樂十分";
	if($_GET['type']==2)
	$show_type="重慶時時彩";
	if($_GET['type']==3)
	$show_type="廣西快樂十分";
	if($_GET['type']==4)
	$show_type="江西時時彩";
	if($_GET['type']==5)
	$show_type="幸运农场";
	if($_GET['type']==6)
	$show_type="北京赛车PK10";
	if($_GET['type']==7)
	$show_type="江苏骰寶(快3)";
	
$sql = "SELECT `g_id` FROM `g_zhudan` WHERE {$date} AND `g_nid` = '{$user[0]['g_name']}' AND `g_win` is not null {$g_type}";

$total = $db->query($sql, 3);
$pageNum = 15;
$page = new Page_us($total, $pageNum);
$sql = "SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` 
WHERE {$date} AND `g_nid` = '{$user[0]['g_name']}' AND `g_win` is not null {$g_type} ORDER BY g_date DESC {$page->limit} ";
$result = $db->query($sql, 1);
$sql1 = "SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` 
WHERE {$date} AND `g_nid` = '{$user[0]['g_name']}' AND `g_win` is not null {$g_type}";
$results = $db->query($sql1, 1);
$countBNum = 0;
$countTNum = 0;
$countSNum = 0;
if ($results)
{
	for ($i=0; $i<count($results); $i++)
	{
		$countMoney = sumCountMoney ($user, $results[$i]);
		$countBNum += $countMoney['Num'];
		$countTNum += $countMoney['Money'];
		$countSNum += $countMoney['Win'];
	}
}
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=status class="page status status-module" tmp="status">
<DIV id=status class="page status status-module history " tmp="status">
<DIV style="HEIGHT: 4px; VISIBILITY: hidden; FONT-SIZE: 0px"></DIV>
<DIV class=status-xg></DIV>
<DIV style="MARGIN-TOP: 0px" class="title h_title"><SPAN class=sub_title_color>账户历史</SPAN>&nbsp;&nbsp;<SPAN id=date post_date="cdate="><?php echo base64_decode($_GET['gid'])." ".GetWeekDay(base64_decode($_GET['gid']), 1)." ".$show_type; ?></SPAN>&nbsp;&nbsp;&nbsp;&nbsp;<A id=reback class="btn_m elem_btn" href="javascript:void(0)">返回</A></DIV>

<DIV id=history_pager class="elem_pager pager" ajax_json="get_all" pager="true"><?php echo $page->fpage(array(0,1,2,3,4,5,6,7))?><INPUT value="repors.php?loadhtml=1&amp;gid=MjAxMy0xMi0yNg==&amp;type=1&amp;rnd=Fri Dec 27 19:32:44 UTC 0800 2013&amp;" type=hidden name=pageurl><INPUT value=1 type=hidden name=curpage> 
</DIV>

<DIV class=clear></DIV>
<DIV class=dataArea>
<TABLE id=result_su class="t1 tc h1 status report" width="100%">
<THEAD>
<TR>
<TH>註單號</TD> 
<TH>下注时间</TH>
<TH>期數</TH>
<TH>玩法</TD> 
<TH>下註金額</TD> 
<TH>賠率</TD> 
<TH>退水%</TD> 
<TH>盈虧</TD> </TR></TR></THEAD>
<TBODY>
        <?php 
        if (count($result) <1) {echo '<tr class="t_td_text" align="center"><td colspan="5">當前沒有任何記錄</td></tr>';} 
        else {for ($i=0; $i<count($result); $i++) {
        $SumNum = sumCountMoney ($user, $result[$i]);
        if ($result[$i]['g_mingxi_1_str'] == null) {
       		if ($result[$i]['g_mingxi_1'] == '總和、龍虎' || $result[$i]['g_mingxi_1'] == '總和、龍虎和'){
        		$n = $result[$i]['g_mingxi_2'];
        	}else {
					$n = $result[$i]['g_mingxi_1'].'&nbsp;&nbsp;'.$result[$i]['g_mingxi_2'];
        	}
        	//$n = $result[$i]['g_mingxi_1'] == '總和、龍虎' ? $result[$i]['g_mingxi_2'] : $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
        	$html = '<span class="bluer">'.$n.'</span>';
        }
			else {
        	$_xMoney = $result[$i]['g_mingxi_1_str'] * $result[$i]['g_jiner'];
        	$SumNum['Money'] = '<font color="#009933">'.$result[$i]['g_mingxi_1_str'].'</font> x <font color="#0066FF">'.$result[$i]['g_jiner'].'</font><br />'.$_xMoney;
        	$html = '<font color="#0066FF">'.$result[$i]['g_mingxi_1'].'</font>'.
        				'<span style="line-height:23px">  復式  『 '.$result[$i]['g_mingxi_1_str'].' 組 』</span><br/><span>'.$result[$i]['g_mingxi_2'].'</span>';
        }
        ?>
        <tr class="t_td_text" align="center" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
        	<td>
        	<SPAN class=green><?php echo$result[$i]['g_id']?></span>
        	</td>
			<td>
        	<span style="font-size:104%;">
        	<?php 
        	$a = explode('-', $result[$i]['g_date']);
        	echo $a[1].'-'.$a[2].' '.$a[3].' '.GetWeekDay($result[$i]['g_date'], 1)
        	?></span>
        	</td>
        	<td><font color="#000000"><?php echo$result[$i]['g_qishu']?>期</font></td>
        	<td class=td_autoline><?php echo$html?></td>
			
        	<td><?php echo $SumNum['Money']?></td>
			<td><?php echo $result[$i]['g_odds']?></td>
			<td><?php echo number_format((100-floatval($result[$i]['g_tueishui'])),2) ?></td>
        	<td <?php echo is_Number($SumNum['Win'], 1)<0? ' class=red':''?>><?php echo is_Number($SumNum['Win'], 1)?></td>
        </tr>
        <?php }}?>
		</TBODY>
<TFOOT class=bg_g1>
<TR id=s_alltotal class="alltotal bold">
       
        	<td></td><td></td>
        	<td><b>閤計</b></td>
            <td><b><?php echo$countBNum?>筆</b></td>
            <td><b><?php echo number_format($countTNum, 1)?></b></td><td></td><td></td>
            <td><b><?php echo number_format($countSNum, 1)?></b></td>
        </tr>
		
</TFOOT></TABLE></DIV></DIV></DIV></DIV></DIV>
<INPUT value="<?php echo $_GET['gid']?>" type="hidden" name="gid"> 

<?php

}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"   >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script language="javascript">
var win = window.parent.document;  
 $('#result_su',win).find('tbody').find('tr').bind({  
 'mouseenter':function(){$(this).addClass('bc');},  
 'mouseleave':function(){$(this).removeClass('bc');} }) 
 $('.td_pages',win).find('a').bind('click',function(){ 
  parent.loadMainHtml( $(this).attr('href'),'Repors' ); 
   return false; }) 
   $('#reback',win).bind('click',function(){ 
    parent.loadMainHtml('Repore1.php?loadhtml=1&gid='+$('input[name=gid]',win).val(),'Repore1' ); })
	 $('#history_pager',win).find('a').bind('click',function(){ 
	  parent.loadMainHtml( $(this).attr('rel')+"&rnd="+escape(new Date()),'repors' );  
	  return false; }) 
	  $('#current_page',win).keydown(function(event) { 
	     if (event.keyCode == 13) {   
		     if($(this).val()!=''){  
			    var pageurl = $('input[name=pageurl]',win).val(); 
				    pageurl+='page='+$(this).val();   
					     if( parseInt($(this).val()) > parseInt($('#total_page',win).text()) ||  parseInt($(this).val()) < 1 ){  
						    $(this).val( $('input[name=curpage]',win).val() )      
							      }else{    
								    parent.loadMainHtml( pageurl,'Repors' );   
									  }   }   
									   return false;  }    });
									   </script>
</head>
<body>
</body>
</html>
<?php }?>
