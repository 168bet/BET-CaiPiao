<?
require_once dirname(__FILE__).'/conjunction.php';
if ($admin_info!="1"){
echo "<script>alert('请先登录!');top.location.href='index.php';</script>"; 
exit;
}
$nana=1;
	$result=mysql_query("select * from ka_kithe order by nn desc LIMIT 1"); 
$row=mysql_fetch_array($result);
$id=$row['id'];
$nn=$row['nn'];
$nd=$row['nd'];
$zfbdate=$row['zfbdate'];
$zfbdate1=$row['zfbdate1'];
$kitm1=$row['kitm1'];
$kizt1=$row['kizt1'];
$kizm1=$row['kizm1'];
$kizm61=$row['kizm61'];
$kigg1=$row['kigg1'];
$kilm1=$row['kilm1'];
$kisx1=$row['kisx1'];
$kibb1=$row['kibb1'];
$kiws1=$row['kiws1'];
$nana=$row['na'];

if ($row['zfb']==0){
?>
<button onClick="javascript:location.href='index.php?action=top&ids=特码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm1 STYLE='color:ff0000;'>特码已封盘</span></button>&nbsp;<button onClick="javascript:location.href='index.php?action=top&ids=正码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:ff0000;'>正码已封盘</span></button>
<? }else{

if ($row['kitm']==0){
?>

<button onClick="javascript:location.href='index.php?action=top&ids=特码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm1 STYLE='color:ff0000;'>特码已封盘</span></button>&nbsp;
<? }else{?><button onClick="javascript:location.href='index.php?action=top&ids=特码&fen=fen&fid=0';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm1 STYLE='color:0000ff;'>特码已开盘</span></button>&nbsp;<? }
if ($row['kizt']==0  && $row['kizm']==0  && $row['kibb']==0  && $row['kiws']==0  && $row['kizm6']==0  && $row['kisx']==0  && $row['kigg']==0  && $row['kilm']==0){
?>
<button onClick="javascript:location.href='index.php?action=top&ids=正码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:ff0000;'>正码已封盘</span></button>
<? }else{?>
<button onClick="javascript:location.href='index.php?action=top&ids=正码&fen=fen&fid=0';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:0000ff;'>正码已开盘</span></button>
<? }?>

<? }?>
@@@1###";
