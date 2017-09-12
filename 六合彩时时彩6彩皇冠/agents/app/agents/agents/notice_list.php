<?
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];
$uid=$_REQUEST["uid"];
$sql = "select id,level,agname from web_sytnet where uid='$uid' and status=1";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
else{

	$row = mysql_fetch_array($result);
	$agname=$row['Agname'];
	$agid=$row['ID'];
	$langx='zh-tw';
	require ("../../member/include/traditional.$langx.inc.php");
	$enable=$_REQUEST["enable"];
	$enabled=$_REQUEST["enabled"];
	$sort=$_REQUEST["sort"];
	$orderby=$_REQUEST["orderby"];
	$mid=$_REQUEST["id"];
	$sel_agents=$_REQUEST['super_agents_id'];
	$page=$_REQUEST["page"];
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$msg_1 = $_POST['Msg_1'];
	$msg_0 = $_POST['Msg_0'];
	if(!empty($msg_1)) {
		foreach ($msg_1 as $v) {
			mysql_query("delete from web_notices where id = ".$v);
		}
		
	}
	if(!empty($msg_0)) {
		foreach ($msg_0 as $v) {
			mysql_query("delete from web_notices where id = ".$v);
		}
		
	}
}
//userlog($memname);


$showtype=$_REQUEST['showtype'];
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];
$act = $_GET['act']?$_GET['act']:1;


$page = $_GET['page']?$_GET['page']:1;
$page_rows = 10;
$start = ($page-1)*$page_rows;
$act = $act?$act:1;

switch ($act) {
	case 1: //全部信息
	$mysql = "select * from web_notices";



	break;
	case 2://未
	$mysql = "select * from web_notices where type=3 and (reply_id=0 or curr_reply=0)";

	break;
	case 3://已
	$mysql = "select * from web_notices where type=3 and reply_id!=0 and curr_reply=1";

	break;
	case 4://公告
	$mysql = "select * from web_notices as a  where (type=1)";
	break;
	default:
	$mysql = "select * from web_notices";

}

?>


<html>
<head><title></title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<link rel="stylesheet" href="/style/Lotto.css" type="text/css">
<SCRIPT>
// JScript 文件

function ChenkAll(isCheck){
	var inputs = document.getElementsByTagName('input');
	for (var i = 0; i < inputs.length; i++)
	{
		if (inputs[i].type == "checkbox" && inputs[i].id.indexOf("Msg_") >= 0)
		{
			//?置此复?框的checked与全?复?框相同
			inputs[i].checked = isCheck;
		}
	}
}

function ChenkOhter(){
	var inputs = document.getElementsByTagName('input');
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].type == "checkbox" && inputs[i].id.indexOf("Msg_") >= 0){
			if(inputs[i].checked==true)
			inputs[i].checked = false;
			else
			inputs[i].checked = true;
		}
	}
}

function ChenkIsRead(IsR){
	var inputs = document.getElementsByTagName('input');
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].type == "checkbox" && inputs[i].id.indexOf("Msg_") >= 0){
			if(inputs[i].name == 'Msg_'+IsR+'[]' )
			inputs[i].checked = true;
			else
			inputs[i].checked = false;
		}
	}
}

function SubDel(){
	var strDel='';
	var inputs = document.getElementsByTagName('input');
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].type == "checkbox" && inputs[i].id.indexOf("Msg_") >= 0){
			if(inputs[i].checked == true ){
				strDel += inputs[i].id.substring(4)+'|';
			}
		}
	}
	if(strDel!=''){
		$('strID').value=strDel;
		if(!confirm("確定刪除信息?")){return false;}
		$('delFrom').submit();
	}else{
		alert('請選擇要刪除的信息。');
	}
}

var $ = function(Id){
	return document.getElementById(Id);
}

function getPageCount()
{
	var page = Number($('Page').value);
	var icount = Number($('IndexPage').value);
	var strPage = '';
	if(page <= 1)
	{
		strPage+= '[ <span class="font-hhblack">首?</span> | <span class="font-hhblack">上一?</span> | <span class="font-hhblack">下一?</span> | <span class="font-hhblack">末?</span> ]';
	}
	else
	{
		if(icount==1)
		{
			strPage+= '[ <span class="font-hhblack">首?</span> | <span class="font-hhblack">上一?</span> | <span class="pointer" onclick="loadData('+ (icount+1) +');">下一?</span> | <span class="pointer" onclick="loadData('+ page +');">末?</span> ]';
		}
		else if(icount==page)
		{
			strPage+= '[ <span class="pointer" onclick="loadData(1);">首?</span> | <span class="pointer" onclick="loadData('+ (icount-1) +');">上一?</span> | <span class="font-hhblack">下一?</span> | <span class="font-hhblack">末?</span> ]';
		}
		else
		{
			strPage+= '[ <span class="pointer" onclick="loadData(1);">首?</span> | <span class="pointer" onclick="loadData('+ (icount-1) +');">上一?</span> | <span class="pointer" onclick="loadData('+ (icount+1) +');">下一?</span> | <span class="pointer" onclick="loadData('+ page +');">末?</span> ]';
		}
	}
	strPage+=' ????:<select name="showIndex" id="showIndex" size="1" onchange="loadData(this.value)">'
	for(var i=1;i<=page;i++){
		strPage += '<option value='+i+'>第'+i+'?</option>';
	}
	strPage+='</select>';

	$('showPage').innerHTML=strPage;
	$('showIndex').options[icount-1].selected = 'selected';
}

function loadData(count)
{
	icount=Number(count);
	window.location.href='notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>act=<?=$act?>&page='+icount;
}

</SCRIPT>
</head>
<body>
<form id="delFrom" method="POST" action="notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>&act=<?=$_GET['act']?>">
<div style="margin-top: 5px;margin-left: 5px; padding-bottom: 0px;" class="jiyizk">
	      <div class="jiyizk jiyizk-meniu margint0">
		       <div class="jiyizk-meniuleft floatleft"></div>
			   <div class="jiyizk-meniucenter floatleft font-hblue">
			       <ul>
		               
		               <li class="floatleft font-bblack">&nbsp;</li>
			           <li class="floatleft font-bblack"><a id="mmm" href="notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>">信息回查</a></li>
			           
			     </ul>
		    </div>
			   <div class="jiyizk-meniuright floatlright"></div>
		  </div>          
          <table cellspacing="1" cellpadding="3" border="0" bgcolor="#cccccc" align="center" width="100%" class="floatleft">
            <tbody><tr>
              <td bgcolor="#f6f6f6" align="center" valign="bottom" colspan="6">
              <table cellspacing="1" cellpadding="0" border="0" align="left" width="100%" class="font-blue">
                  <tbody><tr>
                    <td height="27" bgcolor="#ffffff" align="center" width="89" valign="middle" onClick="javascript:window.location.href='memberList.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>'" class="font-bblue tlbgcolor5 pointer"><img height="19" width="18" alt="" src="../images/writting.jpg"> 寫短信</td>
                    <td height="27" bgcolor="#d8ebf5" align="center" width="92" valign="middle" class="font-bblue tlbgcolor5 pointer">&nbsp;</td>
                    <td bgcolor="#ffffff" align="right" width="601" valign="bottom" class="font-black tlbgcolor5"><span onClick="javascript:window.location.href='notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>&act=1'" class="font-bbblue pointer"><img height="10" width="13" alt="" src="../images/mail.jpg"> 查看全部</span> | <span onClick="javascript:window.location.href='notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>&act=2'" class="font-bbblack pointer"><img height="10" width="13" alt="" src="../images/mail.jpg"> 未回複信息</span> | <span onClick="javascript:window.location.href='notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>&act=3'" class="font-bbblack pointer"><img height="10" width="13" alt="" src="../images/mail.jpg"> 已回複信息</span> |  <span onClick="javascript:window.location.href='notice_list.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>&act=4'" class="font-bbblack pointer"><img height="10" width="10" alt="" src="../images/gif-0002.jpg"> 查看公告</span></td>
                  </tr>
              </tbody></table></td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" align="center" width="6%" valign="middle" class="font-bblack">選擇</td>
              <td bgcolor="#ffffff" align="center" width="7%" class="font-bblack">序號</td>
              <td bgcolor="#ffffff" align="center" width="13%" valign="middle" class="font-bblack">發件人</td>
              <td bgcolor="#ffffff" align="left" width="50%" valign="middle" class="font-bblack">&nbsp;&nbsp;&nbsp;標 題</td>
              <td bgcolor="#ffffff" align="center" width="16%" valign="middle" class="font-bblack">日 期</td>
              <td bgcolor="#ffffff" align="center" width="7%" valign="middle" class="font-bblack">類 型</td>
             
            </tr>
             <?
             
             $r = mysql_query($mysql);
             $yushu = mysql_num_rows($r)%$page_rows;
             $pagetotal = $yushu==0?(mysql_num_rows($r)/$page_rows):((mysql_num_rows($r)/$page_rows)+1);
             $mysql.=" limit $start,$page_rows";
             $r = mysql_query($mysql);

             if(mysql_num_rows($r)>0) {
             	while($row = mysql_fetch_array($r)) {
              ?>
               	
             <? $pno = ++$start;?>
                                <tr><td bgcolor="#ffffff" align="center" valign="middle" class="font-black"><input type="checkbox" value="<?=$row['id']?>" <?
                            if(strpos($row['view_ids'],'{'.$agname.'}')!== false) {
                            	echo 'name="Msg_1[]"';
                            	$is_view = 1;
                            }else {
                            	echo 'name="Msg_0[]"';
                            	$is_view = 0;
                            }?> id="Msg_834473"></td><td bgcolor="#ffffff" align="center" class="font-hhblack"><?=($pno)?> </td><td bgcolor="#ffffff" align="center" class="font-bbred">
                                <?
                                if($row['type']==1) echo 'Welcome';
                                else if($row['type']==2) echo "Welcome";
                                else if($row['type']==3){
                                	$rrr = mysql_query("select * from web_member where id='".$row['addpople']."'");


                                	if(mysql_num_rows($rrr)) {
                                		$a = mysql_fetch_array($rrr);
                                		echo $a['Alias'].'('.$a['Memname'].')';
                                	}


                                }else if($row['type']==4){
                                	$rrr = mysql_query("select * from web_notices where id='".$row['reply_id']."'");
                                	if(mysql_num_rows($rrr)) {
                                		$a = mysql_fetch_array($rrr);
                                		if($a['type']==3) {
                                			echo 'Welcome';
                                		}else {
                                			$rrr = mysql_query("select * from web_member where id='".$row['addpople']."'");
                                			


                                			if(mysql_num_rows($rrr)) {
                                				$a = mysql_fetch_array($rrr);
                                				echo $a['Alias'].'('.$a['Memname'].')';
                                			}
                                		}
                                	}

                                }

                                ?></td><td bgcolor="#ffffff" align="left" class="font-bbblue">&nbsp;<a class="<?=($is_view?'font-bbblue':'font-bblue')?>" href="notice_detail.php?id=<?=$row['id']?>&uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>"><?=$row['title']?></a></td><td bgcolor="#ffffff" align="center" valign="middle" class="font-black"><?=date('Y-m-d H:i:s',$row['addtime'])?></td><td bgcolor="#ffffff" align="center" class="font-bbred"><?=($row['type']==1?('公告'):'信息')?></td></tr> 
                                 <?}
             }else {
               	?>
               	<td height="100" bgcolor="#fffef4" align="center" style="color: Red;" class="blank" colspan="6">暫無信息</td>
               	<?
             }
                                 ?>


            <tr>
              <!--<td colspan="3" align="center" valign="middle" bgcolor="#FFFFFF" class="font-bblack">??:<span class="font-black"><span onclick="ChenkAll(true);" class="pointer">全部</span> - <span onclick="ChenkIsRead(0);" class="pointer">未?</span> - <span onclick="ChenkIsRead(1);" class="pointer">已?</span> - <span onclick="ChenkOhter();" class="pointer">反?</span> - <span onclick="ChenkAll(false);" class="pointer">不?</span> </span></td>
              <td colspan="3" align="right" valign="middle" bgcolor="#FFFFFF" class="font-black" id="showPage">
              </td>-->
			  
			  <td bgcolor="#ffffff" align="left" valign="middle" class="font-bblack" colspan="6">
			        <div style="float: left; line-height: 25px;">
			            <table>
			                <tbody><tr>
			                    <td><span class="font-black">選擇:<span class="pointer" onClick="ChenkAll(true);">佺蔀</span> - <span class="pointer" onClick="ChenkIsRead(0);">未讀</span> - <span class="pointer" onClick="ChenkIsRead(1);">已讀</span> - <span class="pointer" onClick="ChenkOhter();">反選</span> - <span class="pointer" onClick="ChenkAll(false);">不選</span> </span></td>
			                    <td><input name="del" type="image" src="../images/button-sc.jpg" style="margin-left: 20px; border: 0px none; cursor: pointer;" value="刪除" onClick="return confirm('確認刪除？');"/></td>
			                </tr>
			            </tbody></table>
			        </div>
              <div style="float: right; line-height: 25px;" id="showPage" class="font-black">[ <span class="pointer"  onclick="loadData(1);">首頁</span> | <span class="pointer" onClick="loadData(<?=($page-1<1?1:$page-1)?>);">上一頁</span> | <span onClick="loadData(<?=($page+1>$pagetotal?$pagetotal:$page+1)?>);" class="pointer">下一頁</span> | <span onClick="loadData(<?=$pagetotal?>);" class="pointer">末頁</span> ] 選擇頁數:<select onChange="loadData(this.value)" size="1" id="showIndex" name="showIndex"><?

              for ($i = 1;$i<$pagetotal;$i++) {
              	echo '<option value="'.$i.'">第'.$i.'頁</option>';
              }
              ?></select></div>
			  </td>
            </tr>
          </tbody></table>
  </div>
  </form>
</body>
</html>
