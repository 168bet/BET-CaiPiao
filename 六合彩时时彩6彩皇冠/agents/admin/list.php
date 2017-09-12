<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}
?>
<link rel="stylesheet" href="images/xp.css" type="text/css">


<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>



 <style type="text/css">
<!--
.STYLE2 {color: #FFFFFF}
.STYLE4 {color: #FFFFFF; font-weight: bold; }
-->
 </style>
<body >
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">


<table  width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>
      
          <table width="760"   border="0" cellpadding="2" cellspacing="1" bordercolor="#cccccc" bordercolordark="#f9f9f9" bgcolor="#cccccc">
            <form target="mem_order" name="lt_form"  method="post" action="n1.asp?class2=<%=ids%>"> 
              <tr class="tbtitle">
                <td height="28" colspan="10" align="center" nowrap="nowrap">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><font color=ffffff><font color=ffff00><?=$_GET['kithe']?>期下注状况</font>&nbsp;&nbsp;</font></td>
    <td ><font color=ffffff><div align="right">       
<a href="#" onclick=document.execCommand('saveAs')><b>保&nbsp;存</b></a>(右击，目标另存为)</div></font></td>
    <td ><div align="right"> 
                <button onClick="javascript:location.href='index.php?action=l';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff6600;'>返回</span></button>
			              
              </div></td>
  </tr>
</table>				</td>
              </tr>
              <tr class="tbtitle">
                <td width="30" align="center" nowrap="nowrap"><span class="STYLE2">序号</span></td>
              <td width="60" height="28" align="center" nowrap="nowrap"><span class="STYLE2"> 下注单号 </span></td>
              <td width="80" align="center" nowrap="nowrap" ><span class="STYLE2">下注时间</span></td>
              <td width="80" align="center" nowrap="nowrap" ><span class="STYLE2">期数</span></td>
              <td height="28" align="center" nowrap="nowrap" ><span class="STYLE2"> 内容</span></td>
              <td align="center" nowrap="nowrap" ><span class="STYLE2">赔率</span></td>
              <td width="60" align="center" nowrap="nowrap" ><span class="STYLE2">金额</span></td>
              <td width="60" align="center" nowrap="nowrap"><span class="STYLE2">佣金</span></td>
              <td width="60" align="center" nowrap="nowrap"><span class="STYLE2">会员收付</span></td>
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
			
		 $result = mysql_query("select *  from   ka_tan where  kithe='".$_GET['kithe']."' order by id desc");   
$ii=0;
while($rs = mysql_fetch_array($result)){




$ii++;
$z_re++;






$z_sum+=$rs['sum_m'];

	
	if ($rs['bm']==1){
	?>
	
			  <tr bgColor="#FFFF99" onMouseOver="javascript:this.bgColor='ffffff'" onMouseOut="javascript:this.bgColor='#FFFF99'">
			  <? }else{?>
			    <tr bgColor="#FFFFF4" onMouseOver="javascript:this.bgColor='ffffff'" onMouseOut="javascript:this.bgColor='#FFFFF4'">
			  <? }?>
			  
			  
			    <td align="center" nowrap="nowrap" ><?=$ii?></td>
                <td height="28" align="center" ><?=$rs['num']?></td>
                <td align="center" ><?=$rs['adddate']?></td>
                <td align="center" ><font color=ff0000><?=$rs['kithe']?>期</font></td>
                <td height="28" align="center" nowrap="nowrap"  >
				
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
                <td align="center" nowrap="nowrap" ><? if ($rs['bm']==2){echo 0;}elseif($rs['bm']==1){echo $rs['sum_m']*$rs['rate']-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;$z_user+=$rs['sum_m']*$rs['rate']-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;}else{echo -$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;$z_user+=-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;}?></td>
              </tr>
			     <? }?>
			  
              <tr class="tbtitle">
                <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
                <td align="center" nowrap="nowrap" >&nbsp;</td>
                <td align="center" nowrap="nowrap" >&nbsp;</td>
                <td align="center" nowrap="nowrap" ><span class="STYLE4">小计</span></td>
                <td height="28" align="center" nowrap="nowrap" ><span class="STYLE4">共下注《
                <?=$z_re?>
      注》</span></td>
                <td align="center" nowrap="nowrap" >&nbsp;</td>
                <td align="center" nowrap="nowrap" ><span class="STYLE4">
                <?=$z_sum?>
                </span></td>
                <td align="center" nowrap="nowrap"><span class="STYLE4">
                <?=$z_userds?>
                </span></td>
                <td align="center" nowrap="nowrap"><span class="STYLE4">
                <?=$z_user?>
                </span></td>
              </tr>
			</form>
      </table>
      
      <div align="center"><br>
        <br>
      </div>    </td>
  </tr>
</table>
