<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
global $user;
$db = new DB();
$sql = "SELECT `g_type`, `g_panlu_a`,`g_panlu_b`,`g_panlu_c`, `g_danzhu`, `g_danxiang` FROM `g_panbiao` WHERE `g_nid` = '{$user[0]['g_name']}' ORDER BY g_id DESC ";
$result = $db->query($sql, 1);
markPos("前台-信用资料");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/left.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/sc.js"></script>
<title>PHP</title>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="900">
        <tr>
            <td class="t_list_caption" colspan="2">信用資料<input type="hidden" value="<?php echo base64_encode(ROOT_PATH)?>"/></td>
        </tr>
        <tr>
            <td class="t_td_caption_1" width="150">會員帳號</td>
            <td class="t_td_text"><?php echo $user[0]['g_name']?>（<?php echo strtoupper($user[0]['g_panlus'])?>盤）</td>
        </tr>
        <tr>
            <td class="t_td_caption_1">信用額度</td>
            <td class="t_td_text"><?php echo $user[0]['g_money']?></td>
        </tr>
        <tr>
            <td class="t_td_caption_1">可用金額</td>
            <td class="t_td_text"><?php echo $user[0]['g_money_yes']?></td>
        </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">廣東快樂十分</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
						 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=0; $i<16; $i++) {
						$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
						if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
						if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
						echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td valign="top">
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=16; $i<31; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">重慶時時彩</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=31; $i<38; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td valign="top">
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=38; $i<44; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>

<!--
<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">廣西快樂十分</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
						 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=39; $i<50; $i++) {
						$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
						if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
						if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
						echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td>
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=50; $i<60; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>


<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">江西時時彩</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=60; $i<67; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td valign="top">
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=67; $i<73; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>
-->

<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">幸运农场</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
						 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=78; $i<94; $i++) {
						$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
						if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
						if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
						echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td valign="top">
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=94; $i<109; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">北京赛车PK10</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型<input type="hidden" value="<?php echo base64_encode(ROOT_PATH)?>"/></td>
						 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=109; $i<117; $i++) {
						$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
						if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
						if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
						echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td>
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=117; $i<125; $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="t_list" width="901">
        <tr>
            <td class="t_list_caption" colspan="8">江苏骰寶(快3)</td>
        </tr>
        <tr class="t_td_text">
        	<td>
        		<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型<input type="hidden" value="<?php echo base64_encode(ROOT_PATH)?>"/></td>
						 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=125; $i<128; $i++) {
						$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
						if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
						if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
						echo $str;
	        			}
        			?>
        		</table>
			</td>
            <td>
            	<table border="0" cellpadding="0" cellspacing="1" class="t_list_1" width="100%">
        			<tr class="t_list_caption_1">
        				<td width="110">交易類型</td>
        				 <?php $P = $user[0]['g_panlus'];?>
                         <?php if(strstr($P,'A')!=''){echo "<td width='60'>A盤</td>";}?>
						 <?php if(strstr($P,'B')!=''){echo "<td width='60'>B盤</td>";}?>
						 <?php if(strstr($P,'C')!=''){echo "<td width='60'>C盤</td>";}?>
        				<td>單註限額</td>
        				<td>單期限額</td>
        			</tr>
        			<?php 
	        			for ($i=128; $i<count($result); $i++) {
	        				$str='<tr class="t_td_text" align="center"><td class="t_td_caption_1">'.$result[$i]['g_type'].'</td>';
							$P = $user[0]['g_panlus'];
                       		if(strstr($P,'A')!=''){$str.="<td>".$result[$i]['g_panlu_a']."</td>";}
							if(strstr($P,'B')!=''){$str.="<td>".$result[$i]['g_panlu_b']."</td>";}
							if(strstr($P,'C')!=''){$str.="<td>".$result[$i]['g_panlu_c']."</td>";}
							$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td></tr>';
							echo $str;
	        			}
        			?>
        		</table>
			</td>
        </tr>
</table>
</body>
</html>