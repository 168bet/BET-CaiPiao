<?
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];

$sql = "select id,level,agname from web_sytnet where uid='$uid' and status=1";

$result = mysql_query($sql);

$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
else{

	$row = mysql_fetch_array($result);
	$agname=$row['agname'];
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

//userlog($memname);


$showtype=$_REQUEST['showtype'];
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];
$id = $_GET['id'];

$mr = mysql_query("select * from web_notices where id=$id and view_ids like '%{".$agname."}%'");
if(mysql_num_rows($mr)<1) {
	$mr = mysql_query("select * from web_notices where id=$id");
	$mmr = mysql_fetch_array($mr);
	$view_ids = $mmr['view_ids'].'{'.$agname.'}';

	mysql_query("update web_notices set view_ids='$view_ids' where id = $id");

}

if($_SERVER['REQUEST_METHOD']== "POST")
{
	if($_POST['dell']=='�R��') {
		mysql_query("delete from web_notices where id = ".$id);

		$msg =  "<script>alert('�R�����\');</script>";
	}
	if($_POST['reply']=='�^��') {
		$mysql="insert into web_notices_reply(title,content,addtime,reply_uid,role,reply_id) values ('(�^��:)".$_POST['noticetitle']."','".$_POST['reply_content']."','".time()."','".$agid."','1',$id)";


		mysql_query($mysql) or die ("�ƾڮw���~!");
		$ro = mysql_query("select last_insert_id()");
		$ro1= mysql_fetch_array($ro);
		$mysql="update web_notices set curr_reply='1',reply_id='".$ro1[0]."' where id = ".$id;
		mysql_query($mysql) or die ("�ƾڮw���~!");
		//echo "<script languag='JavaScript'>alert('�ާ@���\');</script>";
		$msg =  "<script>alert('�^�`���\');</script>";
	}
}





?>


<html>
<head><title></title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<link rel="stylesheet" href="/style/Lotto.css" type="text/css">

</head>
<body>
<style>
body,TD{font-size:12px;}
</style>
<?=$msg?>
<form method="POST" action="notice_detail.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>&id=<?=$_GET['id']?>">
<div style="margin-top: 5px;margin-left: 5px; padding-bottom: 0px;" class="jiyizk">
	      <div class="jiyizk jiyizk-meniu margint0">
		       <div class="jiyizk-meniuleft floatleft"></div>
			   <div class="jiyizk-meniucenter floatleft font-hblue">
			       <ul>
		               
		               <li class="floatleft font-bblack"><a id="mmm" href="notice_detail.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>">�d�ݫH��</a></li>
			          
			           
			     </ul>
		    </div>
			   <div class="jiyizk-meniuright floatlright"></div>
		  </div>          
          <table cellspacing="1" cellpadding="3" border="0" bgcolor="#cccccc" align="center" width="100%" class="floatleft">
            <tbody>
            <?

            $r = mysql_query("select * from web_notices where id = ".$id);

            if(mysql_num_rows($r)) {
            	$row = mysql_fetch_array($r);
            	if($row['type']==1 or $row['type']==2) {
            ?>
            <tr>
              <td  bgcolor="#FFFFFF">���D</td>
              <td  bgcolor="#FFFFFF"><?=$row['title']?></td>
             
            </tr>
            <tr>
             <td  bgcolor="#FFFFFF">���e</td><td height="150" bgcolor="#FFFFFF"><?=$row['content']?></td>
            </tr>
             <tr>
             <td  bgcolor="#FFFFFF" colspan="2" align="center"><input name="dell" type="submit" value="�R��" onclick="return confirm('�T�{�R���H');"/></td>
            </tr>
            <?

            $rr = mysql_query("select * from web_notices where reply_id = ".$row['id']);
            if(mysql_num_rows($rr)) {
            	$f = mysql_fetch_array($rr);
             	?>
             	<tr><td bgcolor="#FFFFFF">�^�Ƥ��e</td>
             	<td bgcolor="#FFFFFF"><?=$f['content']?></td>
             	</tr>
             	<?
            }


            ?>
            <?
            	}
            	if($row['type']==3) {
            	?>
             <tr>
              <td  bgcolor="#FFFFFF">���D</td>
              <td  bgcolor="#FFFFFF"><?=$row['title']?></td>
             
            </tr>
            <tr>
             <td  bgcolor="#FFFFFF">���e</td><td height="150" bgcolor="#FFFFFF"><?=$row['content']?></td>
            </tr>
            <?
            	}
            }else {?>
            </tr>
            <td height="100" bgcolor="#fffef4" align="center" style="color: Red;" class="blank" colspan="2">�ȵL�H��</td>
            </tr>
            <?}?>
            
            
          </tbody></table>
  </div>
  <?
  if($row['type']==3) {
  	$rr = mysql_query("select * from web_notices_reply where reply_id = ".$row['id']." order by addtime asc");
  	if(mysql_num_rows($rr)) {
  		echo "<div style='border:1px solid #929292;clear:both;margin-left:5px;margin-top:20px; width:760px;'><div style='border:2px solid #000000;width:760px;padding:0 10px'><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"   style='width:740px'>";
  		while($f = mysql_fetch_array($rr)){
          	?>
          	 <tr><td><br><? if($f['role']==1) echo "<span style='color:red'>�޲z��</span>";else {
          	 	$cr = mysql_query("select * from web_member where ID = ".$row['addpople']);

          	 	if(mysql_num_rows($cr)) {
          	 		$ccr = mysql_fetch_array($cr);
          	 		echo "<span style='color:#95BA00'>".$ccr['Alias']."(".$ccr['Memname'].")"."</span>";
          	 	}
          	 }?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#cccccc"><?=date('Y-m-d H:i:s',$f['addtime'])?></span></td></tr>

          	 <tr><td style="padding-left:20px;color:#417DA8;padding-bottom:15px;margin-bottom:20px;border-bottom:1px dashed #CCCCCC">���e:<?=$f['content']?></td></tr>
          	 
          	<?

  		}
  		echo "</table></div></div>";
  	}
          ?>
          <div style='border:1px solid #929292;clear:both;margin-left:5px;margin-top:20px; width:760px;'><div style='border:2px solid #000000;width:760px;padding:0 10px'>
          <table cellspacing="0" cellpadding="0" border="0"   style='width:740px'>
          <tr><td style="border-bottom:1px solid #999999;font-size:16px;"><B>�^�ƫH��</B></td></tr>
          <tr><td><textarea name="reply_content" id="reply_content" cols="100"  rows="6"></textarea></td></tr>
          <tr><td align="center"> <input name="reply" type="submit" value="�^��" onclick="if(document.getElementById('reply_content').val=='') {alert('�ж�g�^�Ƥ��e');return false;}else return true;"/>&nbsp;&nbsp;<input name="dell" type="submit" value="��^" onclick="history.go(-1);return false;"/><input name="noticetitle" type="hidden" value="<?=$row['title']?>"/></td></tr>
         
          </div></div>
          <?}?>
  </form>
</body>
</html>
