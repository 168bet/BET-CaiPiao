<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $Users, $LoginId,$userModel;
if ($LoginId ==89) exit;
$db=new DB();
$sql = "SELECT `g_type`, `g_a_limit`, `g_b_limit`, `g_c_limit`, `g_d_limit`, `g_e_limit`  
FROM g_send_back WHERE g_name = '{$Users[0]['g_name']}' ORDER BY g_id DESC";
$result = $db->query($sql, 1);
if (!$result) exit(back('帳號信息錯誤！'));
if ($LoginId ==48)
	$yes_money = $Users[0]['g_money'] - $userModel->SumMoney($Users[0]['g_nid'], true);
else 
	$yes_money = $Users[0]['g_money'] - $userModel->SumMoney($Users[0]['g_nid'].UserModel::Like());
	markPos("后台-信用资料");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<title></title>
</head>
<body>
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
                        <td background="/Manage/temp/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/Manage/temp/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;信用信息</td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<th colspan="2">基本信息</th>
                                </tr>
                                <tr onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td class="ball_3" style="height:28px;text-align:right">帳&nbsp;&nbsp;&nbsp;&nbsp;號&nbsp;&nbsp;</td>
                                    <td class="left_p5" width="80%"><?php echo $Users[0]['g_name']?>（<?php echo $Users[0]['g_Lnid'][0]?>）</td>
                                </tr>
                                <tr onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td class="ball_3" style="height:28px;text-align:right">信用額度&nbsp;&nbsp;</td>
                                    <td class="left_p5"><?php echo $Users[0]['g_money']?></td>
                                </tr>
                                <tr onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td class="ball_3" style="height:28px;text-align:right">可用額度&nbsp;&nbsp;</td>
                                    <td class="left_p5"><?php echo$yes_money?></td>
                                </tr>
                                <tr class="tr_top">
                                	<th colspan="2">廣東快樂十分</th>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<table border="0" cellspacing="0" class="t_odds" width="50%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=0; $i<13; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <table border="0" cellspacing="0" class="t_odds" width="49%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=13; $i<26; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                    </td>
                               </tr>
                               <tr class="tr_top">
                                	<th colspan="2">重慶時時彩</th>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<table border="0" cellspacing="0" class="t_odds" width="50%">
                                        	<tr class="tr_top" >
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=26; $i<33; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <table border="0" cellspacing="0" class="t_odds" width="49%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=33; $i<39; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                              </tr>
                                              <?php }?>
                                        </table>
                                    </td>
                               </tr>
                            </table>
							
							<table border="0" cellspacing="0" class="conter" style="display:none">
                            	<tr class="tr_top">
                                	<th colspan="6">廣西快樂十分</th>
                                </tr>
                            	<tr>
                                	<td>
                                    	<table border="0" cellspacing="0" width="100%" class="conter">
                                        	<tr class="tr_top">
                                                <td width="110">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單註限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=39; $i<50; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                                <td class="caption_11"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo  $result[$i]['g_a_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_b_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_c_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_d_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_e_limit'] ?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                    </td>
                                    <td>
                                    	<table border="0" cellspacing="0" class="conter">
                                        	<tr class="tr_top">
                                                <td width="110">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單註限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=50; $i<60; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                                <td class="caption_11"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo  $result[$i]['g_a_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_b_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_c_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_d_limit'] ?></td>
                                                <td><?php echo  $result[$i]['g_e_limit'] ?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
							
							<table border="0" cellspacing="0" class="conter" style="display:none">
                               <tr class="tr_top">
                                	<th colspan="2">江西時時彩</th>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<table border="0" cellspacing="0" class="t_odds" width="50%">
                                        	<tr class="tr_top" >
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=60; $i<67; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <table border="0" cellspacing="0" class="t_odds" width="49%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=67; $i<73; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                              </tr>
                                              <?php }?>
                                        </table>
                                    </td>
                               </tr>
                            </table>
							
							<table border="0" cellspacing="0" class="conter" style="display:none">
                               <tr class="tr_top">
                                	<th colspan="2">幸运农场</th>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<table border="0" cellspacing="0" class="t_odds" width="50%">
                                        	<tr class="tr_top" >
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=73; $i<86; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <table border="0" cellspacing="0" class="t_odds" width="49%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=86; $i<99; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                              </tr>
                                              <?php }?>
                                        </table>
                                    </td>
                               </tr>
                            </table>
							
							
								
							<table border="0" cellspacing="0" class="conter">
                               <tr class="tr_top">
                                	<th colspan="2">北京赛车(PK10)</th>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<table border="0" cellspacing="0" class="t_odds" width="50%">
                                        	<tr class="tr_top" >
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=99; $i<107; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <table border="0" cellspacing="0" class="t_odds" width="49%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=107; $i<115; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                              </tr>
                                              <?php }?>
                                        </table>
                                    </td>
                               </tr>
                            </table>
							
							
							<table border="0" cellspacing="0" class="conter">
                               <tr class="tr_top">
                                	<th colspan="2">江苏骰寶(快3)</th>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<table border="0" cellspacing="0" class="t_odds" width="50%">
                                        	<tr class="tr_top" >
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=115; $i<118; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <table border="0" cellspacing="0" class="t_odds" width="49%">
                                        	<tr class="tr_top">
                                            	<td width="120">交易類型</td>
                                                <td>A盤</td>
                                                <td>B盤</td>
                                                <td>C盤</td>
                                                <td>單注限額</td>
                                                <td>單期限額</td>
                                            </tr>
                                            <?php for ($i=118; $i<121; $i++){?>
                                            <tr align="center" style="height:25px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                            	<td class="ball_3"><?php echo $result[$i]['g_type']?></td>
                                                <td><?php echo $result[$i]['g_a_limit']?></td>
                                                <td><?php echo $result[$i]['g_b_limit']?></td>
                                                <td><?php echo $result[$i]['g_c_limit']?></td>
                                                <td><?php echo $result[$i]['g_d_limit']?></td>
                                                <td><?php echo $result[$i]['g_e_limit']?></td>
                                              </tr>
                                              <?php }?>
                                        </table>
                                    </td>
                               </tr>
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center"></td>
                        <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"> </td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"> </td>
        </tr>
    </table>
</body>
</html>