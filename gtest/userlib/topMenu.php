<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
global $user;
$ConfigModel = configModel("`g_mix_money`");
if($_SESSION['gameType']!=$_GET['gameType'])
$gameType=$_GET['gameType'];
else
$gameType=$_SESSION['gameType'];
markPos("前台-{$gameType}信用资料-us");
$db = new DB();
$sql = "SELECT `g_type`, `g_panlu_a`,`g_panlu_b`,`g_panlu_c`, `g_danzhu`, `g_danxiang` FROM `g_panbiao` WHERE `g_nid` = '{$user[0]['g_name']}'  ".base64_decode($_GET['date'])."  ORDER BY g_id DESC ";
$result = $db->query($sql, 1);


if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=infop class=dataArea tmp="infop">
<DIV style="HEIGHT: 4px; VISIBILITY: hidden; FONT-SIZE: 0px"></DIV>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single>
<COL>
<COL class=col_single>
<COL>
<COL class=col_single>
<COL></COLGROUP>
<THEAD>
<TR>
<TH colSpan=6>
<DIV class=t>基本信息</DIV></TH></TR></THEAD>
<TBODY>
<TR>
<TD>账号<input type="hidden" value="<?php echo base64_encode(ROOT_PATH)?>"/></TD>
<TD id=account><?php echo $user[0]['g_name']?></TD>
<TD>会员名称</TD>
<TD id=name><?php echo $user[0]['g_f_name']?></TD>
<TD>信用额度</TD>
<TD id=credit><?php echo $user[0]['g_money_yes']?></TD></TR>
<TR>
<TD>账号状态</TD>
<TD id=status><?php if($user[0]['g_look']==1) echo "啟用";if($user[0]['g_look']==2) echo "凍結";if($user[0]['g_look']==3) echo "停用";?></TD>
<TD>所属盘口</TD>
<TD id=odds_set><?php echo str_replace(',','',strtoupper($user[0]['g_panlus']))?>盤</TD>
<TD></TD>
<TD></TD></TR></TBODY></TABLE>
<DIV id=infop_klc>
<DIV id=infoklcl class=game-left>

<?php 
if($gameType=='gd'){

?>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>
<?php 
	        			for ($i=0; $i<15; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
				</TBODY>
				</TABLE></DIV>
<DIV id=infoklcr class=game-right>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>

<?php 
	        			for ($i=15; $i<31; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
					</TBODY></TABLE></DIV></DIV></DIV></DIV></DIV>
<?php 
}
if($gameType=='cq'){
?>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>
<?php 
	        			for ($i=31; $i<38; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
				</TBODY>
				</TABLE></DIV>
<DIV id=infoklcr class=game-right>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>

<?php 
	        			for ($i=38; $i<44; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
					</TBODY></TABLE></DIV></DIV></DIV></DIV></DIV>
<?php 
}
if($gameType=='nc'){

?>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>
<?php 
	        			for ($i=78; $i<94; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
				</TBODY>
				</TABLE></DIV>
<DIV id=infoklcr class=game-right>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>

<?php 
	        			for ($i=94; $i<109; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
					</TBODY></TABLE></DIV></DIV></DIV></DIV></DIV>

<?php 
}
if($gameType=='pk10'){

?>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>
<?php 
	        			for ($i=109; $i<117; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
				</TBODY>
				</TABLE></DIV>
<DIV id=infoklcr class=game-right>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>

<?php 
	        			for ($i=117; $i<125; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
					</TBODY></TABLE></DIV></DIV></DIV></DIV></DIV>

<?php 
}
if($gameType=='ks'){

?>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>
<?php 
	        			for ($i=125; $i<128; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
				</TBODY>
				</TABLE></DIV>
<DIV id=infoklcr class=game-right>
<TABLE class="t1 w100">
<COLGROUP>
<COL class=col_single></COLGROUP>
<THEAD>
<TR>
<TH>&nbsp;</TH>
<TH>单注最低</TH>
<TH>单注最高</TH>
<TH>单项最高</TH>
<TH>退水(%)</TH></TR></THEAD>
<TBODY>

<?php 
	        			for ($i=128; $i<131; $i++) {
						$str='<TR><TH>'.$result[$i]['g_type'].'</TH>';
						$str.="<TD>".$ConfigModel['g_mix_money']."</TD>";
	        			
						$str.='<td>'.$result[$i]['g_danzhu'].'</td><td>'.$result[$i]['g_danxiang'].'</td>';
						$P = $user[0]['g_panlus'];
                        if(strstr($P,'A')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_a'])),2)."%</td></tr>";}
						if(strstr($P,'B')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_b'])),2)."%</td></tr>";}
						if(strstr($P,'C')!=''){$str.="<td>".number_format((100-floatval($result[$i]['g_panlu_c'])),2)."%</td></tr>";}
						echo $str;
	        			}
        			?>
					</TBODY></TABLE></DIV></DIV></DIV></DIV></DIV>

<?php

}
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"   >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script language="javascript">
var win = window.parent.document;   
$('td',win).bind({ 
 'mouseenter':function(){$(this).addClass('bc');},  
 'mouseleave':function(){$(this).removeClass('bc');}, 
 })
 </script>
</head>
<body>
</body>
</html>
<?php }?>
