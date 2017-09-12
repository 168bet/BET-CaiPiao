<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}
?>
<html>
<head>
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css">

 </head>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>




 <body  oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()">
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>



<table border="0" cellpadding="0" cellspacing="0" width="660">
<tr>
  <td width="10%">
     香港㈥合彩
  </td>
  <td width="50%">&nbsp;—&nbsp;<?=$_GET['kithe']?>期下注状况</td>
  <td align="right" width="40%">
      <input class="but_c1" name="print" onClick="window.print()" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="button" value="打 印"></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="760">
              <tr>
                <td width="30" class="t_list_caption" align="center" nowrap="nowrap">序号</td>
              <td  class="t_list_caption" height="28" align="center">下注单号</td>
              <td class="t_list_caption" align="center" nowrap="nowrap" >下注时间</td>
              <td height="28" class="t_list_caption" align="center" nowrap="nowrap" >内容</td>
              <td align="center" class="t_list_caption" nowrap="nowrap" >赔率</td>
              <td width="60" class="t_list_caption" align="center" nowrap="nowrap" >金额</td>
              <td width="60" class="t_list_caption" align="center" nowrap="nowrap">佣金</td>
              <td width="60" class="t_list_caption" align="center" nowrap="nowrap">会员收付</td>
              </tr>
              
			 <?
			 $z_re=0;
		$z_sum=0;
		$z_dagu=0;
		$z_guan=0;
		$z_zong=0;
		$z_dai=0;
		$re=0;
		$z_user=0;
		$z_userds=0;
		$z_daids=0;
			
		 $result = mysql_query("select *  from   ka_tan where  username='".$_SESSION['username']."' and kithe='".$_GET['kithe']."' order by id desc");   
$ii=0;
while($rs = mysql_fetch_array($result)){




$ii++;
$z_re++;






$z_sum+=$rs['sum_m'];

	
	?>
	
<tr  <? if($ii%2==1){ ?>class="t_list_tr_0"<? }else{ ?>class="t_list_tr_1"<? } ?> onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#FFFFA2'">
			  
			  
			    <td height="23" align="center" nowrap="nowrap" ><?=$ii?></td>
                <td align="center" ><?=$rs['num']?></td>
                <td align="center" ><?=$rs['adddate']?></td>
                <td align="center" nowrap="nowrap"  >
				
				<? if ($rs['class1']=="过关"){
				
				$show1=explode(",",$rs['class2']);
				$show2=explode(",",$rs['class3']);
				$z=count($show1);
				
			$k=0;
			for ($j=0; $j<count($show1)-1; $j=$j+1){
			
			?>
                        <span 
      style="COLOR: ff0000"><?=$show1[$j]?> &nbsp;<?=$show2[$k]?></span> @ &nbsp;<span 
      style="COLOR: ff6600"><b><?=$show2[$k+1]?></b></span><br>
                        <?
						
						$k=k+2;
						
						 }
						}else{?>
							
							<font color=ff0000><?=$rs['class2']?>:</font><font color=ff6600><?=$rs['class3']?></font>
							
							<? }?>				</td>
                <td align="center" nowrap="nowrap"  ><font color=ff6600><b><?=$rs['rate']?></b></font></td>
                <td align="center" nowrap="nowrap" ><b><font color=ff0000><?=$rs['sum_m']?></font></b></td>
                <td align="center" nowrap="nowrap" ><? if ($rs['bm']==2){echo 0;}else{echo $rs['sum_m']*abs($rs['user_ds'])/100;$z_userds+=$rs['sum_m']*abs($rs['user_ds'])/100;}?> </td>
                <td align="center" nowrap="nowrap" ><? if ($rs['bm']==2){echo 0;}elseif($rs['bm']==1){echo $rs['sum_m']*$rs['rate']+$rs['sum_m']*abs($rs['user_ds'])/100;$z_user+=$rs['sum_m']*$rs['rate']+$rs['sum_m']*abs($rs['user_ds'])/100;}else{echo -$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;$z_user+=-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;}?></td>
              </tr>
			     <? }?>
			  
              <tr class="t_list_tr_sum" height="23">
                <td align="center" nowrap="nowrap" colspan="2"><span class="STYLE4">小计</span></td>
                <td align="center" nowrap="nowrap" colspan="3"><span class="STYLE4">当前页共&nbsp;<?=$z_re?>&nbsp;笔</span></td>
                <td align="center" nowrap="nowrap" ><span class="STYLE4">
                <?=$z_sum?>
                </span></td>
                <td align="center" nowrap="nowrap"><span class="STYLE4">
                <?=$z_userds?>
                </span></td>
                <td align="center" nowrap="nowrap"><span class="STYLE4">
                <?=number_format($z_user,2)?>
                </span></td>
              </tr>
			</form>
      </table>
      
      <div align="center"><br>
        <br>
      </div>    </td>
  </tr>
</table>
</body>
</html>