<?php 
exit;
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
markPos("后台-重庆賠率設置");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/SystemControl/ActionLib/js/oddsInfo3.js"></script>
<title></title>
</head>
<body>
<input type="hidden" id="s_odds" value="2" />
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
                                    <td width="145">&nbsp;賠率設置--重慶時時彩</td>
                                    <td width="55"><a href="/templates_r/Manage/oddsInfo3.html">1-5賠率</a></td>
                                    <td width="125"><a href="/templates_r/Manage/oddsInfo4.html">總分龍虎和連碼賠率</a></td>
                                    <td width="60">升降總值：</td>
                                    <td><input type="text" id="Ho" class="texta" value="0.001" /></td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<td>號</td>
                                	<td>賠率</td>
                                    <td>設置</td>
                                    <td>號</td>
                                	<td>賠率</td>
                                    <td>設置</td>
                                    <td>號</td>
                                	<td>賠率</td>
                                    <td>設置</td>
                                    <td>號</td>
                                	<td>賠率</td>
                                    <td>設置</td>
                                    <td>號</td>
                                	<td>賠率</td>
                                    <td>設置</td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball">總和大</td>
                                	<td id="ah1" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah1','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah1','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">總和小</td>
                                	<td id="ah2" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah2','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah2','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">總和單</td>
                                	<td id="ah3" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah3','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah3','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">總和雙</td>
                                	<td id="ah4" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah4','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah4','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">龍</td>
                                	<td id="ah5" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah5','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah5','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball">虎</td>
                                	<td id="ah6" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah6','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah6','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">和</td>
                                	<td id="ah7" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('ah7','Ball_6',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('ah7','Ball_6',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">前三</td>
                                	<td id="bh1" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('bh1','Ball_7',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('bh1','Ball_7',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">中三</td>
                                	<td id="bh2" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('bh2','Ball_7',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('bh2','Ball_7',this)" class="aase aase_b" name="0" />
	                                </td>
                                    <td class="ball">后三</td>
                                	<td id="bh3" style="font-size:14px;color:blueviolet"></td>
                                    <td>
                                    	<input type="button" onclick="setodds('bh3','Ball_7',this)" class="aase aase_a" name="1" />&nbsp;
	                                    <input type="button" onclick="setodds('bh3','Ball_7',this)" class="aase aase_b" name="0" />
	                                </td>
                                </tr>
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center">默認賠率表更變不會即時影響正在開盤中的賠率。</td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_20.gif" alt="" /></td>
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