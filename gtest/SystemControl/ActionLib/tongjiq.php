<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $Users;



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<title><?php echo$number[0][0]?> - 取款统计</title>

</head>
<body onload="isReady=true;window.focus()">
<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
                        <td background="/SystemControl/ActionLib/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/SystemControl/ActionLib/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;取款统计</td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
	
                        <!-- end -->
						
						  <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<td colspan="4">充提记录</td>
									
                                </tr>
								<tr class="tr_top">
                                	<td >会员账号</td>
									<td >总取款笔数</td>
									<td >总取款金额</td>
									<td >状态</td>
                                </tr>
								<?php 
								
								$sql = "SELECT *,sum(g_money) s,count(g_name) c  FROM `g_qdetail` where g_type=1 and g_state='取款已支付' group by g_name order by g_id desc";
								$total=$db->query($sql, 3);								
								$pageNum = 20;
								$page = new Page($total, $pageNum);
 								$sql = "SELECT *,sum(g_money) s,count(g_name) c  FROM `g_qdetail` where g_type=1  and g_state='取款已支付' group by g_name order by g_id desc {$page->limit}";
								if($resultqd=$db->query($sql, 1)){
								for($i=0;$i<count($resultqd);$i++){
								
								?>
								<tr>
								 <td class="left_p6" align="center"><?php echo$resultqd[$i]['g_name']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['c']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['s']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['s']<0? '扣除金额':'取款'?></td>
								</tr>
								<?php 
								
								}
								}
								?>
						</table>
						
                        </td>
                        <td class="r"></td>
                    </tr>
					<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="right"><?php echo $page->fpage(array(0,1, 3,4,5,6,7))?></td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"></td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"></td>
        </tr>
    </table>
</body>
</html>