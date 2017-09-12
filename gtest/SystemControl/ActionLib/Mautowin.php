<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';

$db=new DB();
$total = $db->query("SELECT g_nid,g_name,g_count_time,g_state FROM g_user ", 3);
$pageNum = 20;
$page = new Page($total, $pageNum);
$result = $db->query("SELECT g_id,g_name,g_count_time,g_autowin FROM g_user ORDER BY g_count_time DESC {$page->limit} ", 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<title></title>
<script type="text/javascript">
<!--
	function showNews(){
		var show = document.getElementById("show");
		if (show.style.display == "none")
			show.style.display = "";
		else 
			show.style.display = "none";
	}
//-->
</script>
<script>
function setauto(zdid,title)
	{
	
		$.ajax({
			type : "POST",
			data : {zid : zdid,type:title},
			url : "Mautowine.php",
			dataType : "json",
			error : function(XMLHttpRequest, textStatus, errorThrown){
				if (XMLHttpRequest.readyState == 4){
					if (XMLHttpRequest.status == 500){
						setauto();
						return false;
					}
				}
			},
			success:function(data){
				if(data==1){
				$("#"+zdid).html("还原");
				$("#"+zdid).attr("title","no");
				}else{
				 $("#"+zdid).html("必中");
				 $("#"+zdid).attr("title","yes");
				}
			}
		});
	}
</script>
</head>
<body>
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
                        <td colspan="2" background="/SystemControl/ActionLib/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/SystemControl/ActionLib/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;会员必中设置</td>
                                  </tr>
                            </table>                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td colspan="2" class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<td>会员名</td>
                                    <td>设置状态</td>
                                </tr>
                                <?php if(!$result){echo'<td align="center" colspan="3">暫無会员</td>';}else{
				                	for ($i=0; $i<count($result); $i++){
									$gname=$result[$i]['g_name'];
									?>
                                <tr style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td align="center"><?php echo$result[$i]['g_name']?></td>
                                    <td class="left_p6"><img src="images/onlie.gif"/>
									<a id='<?php echo $result[$i]['g_id']?>' title="<?php echo $result[$i]['g_autowin']==1? 'no':'yes'?>" href="javascript:void(0)" onclick="setauto(this.id,this.title)"><?php echo $result[$i]['g_autowin']==0? "必中":"还原"?></a>
									&nbsp;</td>
                                </tr>
                                <?php }}?>
                            </table>
                        <!-- end -->                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="right"><a href="/SystemControl/ActionLib/CrystalInfo.php">返回单注设置</a></td>
                        <td class="f" align="right"><?php echo $page->fpage(array(0,1, 3,4,5,6,7))?></td>
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