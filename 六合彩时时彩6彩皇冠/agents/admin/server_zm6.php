<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

$result=mysql_query("select * from adad order by id"); 
$row=mysql_fetch_array($result);

$best=$row['best'];	
	$zm=$row['zm'];
	$zm6=$row['zm6'];
	$lm=$row['lm'];	
	$zlm=$row['zlm'];
	$ys=$row['ys'];
	$ls=$row['ls'];
	$dx=$row['dx'];
	$tm=$row['tm'];
	$spx=$row['spx'];
	$bb=$row['bb'];
	$zmt=$row['zmt'];
	$ws=$row['ws'];
	$zm1=$row['zm1'];
	$zm61=$row['zm61'];
	$lm1=$row['lm1'];	
	$zlm1=$row['zlm1'];
	$ys1=$row['ys1'];
	$ls1=$row['ls1'];
	$dx1=$row['dx1'];
	$tm1=$row['tm1'];
	$spx1=$row['spx1'];
	$bb1=$row['bb1'];
	$zmt1=$row['zmt1'];
	$ws1=$row['ws1'];
	$ps1=$row['ps1'];
	$ps=$row['ps'];	
$ztm_tm=$zm6;

$class1=$_GET['class1'];
$class2=$_GET['class2'];

if ($_GET['kithe']!=""){$kithe=$_GET['kithe'];}else{$kithe=$Current_Kithe_Num;}



$z_re=0;
$z_sum=0;
$z_suma=0;
$z_sumb=0;
$z_ds=0;
$z_xx=0;
$z_pz=0;

$z7_sum=0;
$z7_ds=0;

//大小
$z_re_dx=0;
$z_sum_dx=0;
$z_suma_dx=0;
$z_sumb_dx=0;
$z_ds_dx=0;
$z_xx_dx=0;
$z_pz_dx=0;

$z7_sum_dx=0;
$z7_ds_dx=0;
//单双
$z_re_ds=0;
$z_sum_ds=0;
$z_suma_ds=0;
$z_sumb_ds=0;
$z_ds_ds=0;
$z_xx_ds=0;
$z_pz_ds=0;

$z7_sum_ds=0;
$z7_ds_ds=0;
//经绿蓝
$z_re_bs=0;
$z_sum_bs=0;
$z_suma_bs=0;
$z_sumb_bs=0;
$z_ds_bs=0;
$z_xx_bs=0;
$z_pz_bs=0;

$z7_sum_bs=0;
$z7_ds_bs=0;
//合大合小
$z_re_hdx=0;
$z_sum_hdx=0;
$z_suma_hdx=0;
$z_sumb_hdx=0;
$z_ds_hdx=0;
$z_xx_hdx=0;
$z_pz_hdx=0;

$z7_sum_hdx=0;
$z7_ds_hdx=0;
//合单合双
$z_re_hds=0;
$z_sum_hds=0;
$z_suma_hds=0;
$z_sumb_hds=0;
$z_ds_hds=0;
$z_xx_hds=0;
$z_pz_hds=0;

$z7_sum_hdx=0;
$z7_ds_hdx=0;
//尾大尾小
$z_re_wdx=0;
$z_sum_wdx=0;
$z_suma_wdx=0;
$z_sumb_wdx=0;
$z_ds_wdx=0;
$z_xx_wdx=0;
$z_pz_wdx=0;

$z7_sum_wdx=0;
$z7_ds_wdx=0;



$result = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='".$class1."'  and class2='".$class2."'  order by class3 desc");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and lx=0 and  class1='".$rs['class1']."' and  class2='".$rs['class2']."'  and class3='".$rs['class3']."'");
$Rs5 = mysql_fetch_array($result1);

$result2 = mysql_query("Select sum(sum_m*rate+sum_m*(user_ds/100)) as sum_money,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m) as sum_m3 from ka_tan   where   Kithe='".$kithe."' and  lx=1 and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."'");
$Rs7 = mysql_fetch_array($result2);

$result3 = mysql_query("Select sum(sum_m*dagu_zc/10) as sum_moneya from ka_tan   where  Kithe='".$kithe."' and  lx=0 and  class1='".$rs['class1']."' and   class2='".$rs['class2']."' and class3='".$rs['class3']."'");
$RsA = mysql_fetch_array($result3);
$result4 = mysql_query("Select sum(sum_m*dagu_zc/10) as sum_moneyb from ka_tan   where  Kithe='".$kithe."' and  lx=0 and  class1='".$rs['class1']."' and class2='正B' and class3='".$rs['class3']."'");
$RsB = mysql_fetch_array($result4);

$result5 = mysql_query("Select * from ka_bl   where   class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."'");
$Rsbl = mysql_fetch_array($result5);


//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.



if ($rs['class2']=="红波") {
$sum_color[$ii]="ff0000";

}else if ($rs['class3']=="蓝波"){$sum_color[$ii]="0000FF";}else if ($rs['class3']=="绿波"){$sum_color[$ii]="00FF00";}else if ($rs['class3']=="大"){$sum_color[$ii]="FF9900";}else if ($rs['class3']=="小"){$sum_color[$ii]="FF9900";}else if ($rs['class3']=="单"){$sum_color[$ii]="FF0066";}else if ($rs['class3']=="双"){$sum_color[$ii]="FF0066";}

else{$sum_color[$ii]="333333";}




$sum_tm[$ii]=$rs['class3'];
$sum_re[$ii]=$Rs5['re'];
if ($Rs5['sum_m']!=""){
$sum_m[$ii] = $Rs5['sum_m'];}else{$sum_m[$ii] =0;}


if ($RsA['sum_moneya']!=""){$sum_ma[$ii] =$RsA['sum_moneya'];}else{$sum_ma[$ii] =0;}
if ($RsB['sum_moneyb']!=""){$sum_mb[$ii] =$RsB['sum_moneyb'];}else{$sum_mb[$ii] =0;}

$sum_ds[$ii]=$Rs5['sum_ds'];

$sum_xx[$ii]=$Rs5['sum_m3'];

if ($Rsbl['rate']!=""){
$sum_bl[$ii]=$Rsbl['rate'];
}else{
$sum_bl[$ii]=0;
}
if($sum_tm[$ii]=="大"||$sum_tm[$ii]=="小"){
    $z_re_dx+=$Rs5['re'];

$z_sum_dx+=$Rs5['sum_m'];

$z_suma_dx+=$RsA['sum_moneya'];
$z_sumb_dx+=$RsB['sum_moneyb'];
$z_ds_dx+=$Rs5['sum_ds'];
$z_xx_dx+=$Rs5['sum_m3'];
$z_pz_dx+=$Rs7['sum_m3'];
}elseif($sum_tm[$ii]=="单"||$sum_tm[$ii]=="双"){
    $z_re_ds+=$Rs5['re'];

$z_sum_ds+=$Rs5['sum_m'];

$z_suma_ds+=$RsA['sum_moneya'];
$z_sumb_ds+=$RsB['sum_moneyb'];
$z_ds_ds+=$Rs5['sum_ds'];
$z_xx_ds+=$Rs5['sum_m3'];
$z_pz_ds+=$Rs7['sum_m3'];
}elseif($sum_tm[$ii]=="红波"||$sum_tm[$ii]=="绿波"||$sum_tm[$ii]=="蓝波"){
     $z_re_bs+=$Rs5['re'];

$z_sum_bs+=$Rs5['sum_m'];

$z_suma_bs+=$RsA['sum_moneya'];
$z_sumb_bs+=$RsB['sum_moneyb'];
$z_ds_bs+=$Rs5['sum_ds'];
$z_xx_bs+=$Rs5['sum_m3'];
$z_pz_bs+=$Rs7['sum_m3'];
}elseif($sum_tm[$ii]=="合大"||$sum_tm[$ii]=="合小"){
    $z_re_hdx+=$Rs5['re'];

$z_sum_hdx+=$Rs5['sum_m'];

$z_suma_hdx+=$RsA['sum_moneya'];
$z_sumb_hdx+=$RsB['sum_moneyb'];
$z_ds_hdx+=$Rs5['sum_ds'];
$z_xx_hdx+=$Rs5['sum_m3'];
$z_pz_hdx+=$Rs7['sum_m3'];
}elseif($sum_tm[$ii]=="合单"||$sum_tm[$ii]=="合双"){
    $z_re_hds+=$Rs5['re'];

$z_sum_hds+=$Rs5['sum_m'];

$z_suma_hds+=$RsA['sum_moneya'];
$z_sumb_hds+=$RsB['sum_moneyb'];
$z_ds_hds+=$Rs5['sum_ds'];
$z_xx_hds+=$Rs5['sum_m3'];
$z_pz_hds+=$Rs7['sum_m3'];
}elseif($sum_tm[$ii]=="尾大"||$sum_tm[$ii]=="尾小"){
    $z_re_wdx+=$Rs5['re'];

$z_sum_wdx+=$Rs5['sum_m'];

$z_suma_wdx+=$RsA['sum_moneya'];
$z_sumb_wdx+=$RsB['sum_moneyb'];
$z_ds_wdx+=$Rs5['sum_ds'];
$z_xx_wdx+=$Rs5['sum_m3'];
$z_pz_wdx+=$Rs7['sum_m3'];
}
$z_re+=$Rs5['re'];

$z_sum+=$Rs5['sum_m'];

$z_suma+=$RsA['sum_moneya'];
$z_sumb+=$RsB['sum_moneyb'];
$z_ds+=$Rs5['sum_ds'];
$z_xx+=$Rs5['sum_m3'];
$z_pz+=$Rs7['sum_m3'];
$sum_sx1[$ii]=$Rs7['sum_money'];
if ($Rs7['sum_m3']!=""){$sum_pz1[$ii]=$Rs7['sum_m3'];}else{
$sum_pz1[$ii]=0;}

$ii++;
}

for($i=0;$i<$ii;$i++)
{
//if ($i==0){
//$sum_sx[0]=($z_suma+$z_sumb+$z_ds)+$sum_xx[0]-$sum_sx1[0];
//}else{
//$sum_sx[$i]=($z_suma+$z_sumb+$z_ds)+$sum_xx[$i]-$sum_sx1[$i];}
if($sum_tm[$i]=="大"||$sum_tm[$i]=="小"){
$sum_sx[$i]=$z_suma_dx-$z_ds_dx-$z_pz_dx*((1-$zm61/100))-($sum_ma[$i]-$sum_pz1[$i])*$sum_bl[$i];
}elseif($sum_tm[$i]=="单"||$sum_tm[$i]=="双"){
$sum_sx[$i]=$z_suma_ds-$z_ds_ds-$z_pz_ds*((1-$zm61/100))-($sum_ma[$i]-$sum_pz1[$i])*$sum_bl[$i];
}elseif($sum_tm[$i]=="红波"||$sum_tm[$i]=="绿波"||$sum_tm[$i]=="蓝波"){
$sum_sx[$i]=$z_suma_bs-$z_ds_bs-$z_pz_bs*((1-$zm61/100))-($sum_ma[$i]-$sum_pz1[$i])*$sum_bl[$i];
}elseif($sum_tm[$i]=="合大"||$sum_tm[$i]=="合小"){
$sum_sx[$i]=$z_suma_hdx-$z_ds_hdx-$z_pz_hdx*((1-$zm61/100))-($sum_ma[$i]-$sum_pz1[$i])*$sum_bl[$i];
}elseif($sum_tm[$i]=="合单"||$sum_tm[$i]=="合双"){
$sum_sx[$i]=$z_suma_hds-$z_ds_hds-$z_pz_hds*((1-$zm61/100))-($sum_ma[$i]-$sum_pz1[$i])*$sum_bl[$i];
}elseif($sum_tm[$i]=="尾大"||$sum_tm[$i]=="尾小"){
$sum_sx[$i]=$z_suma_wdx-$z_ds_wdx-$z_pz_wdx*((1-$zm61/100))-($sum_ma[$i]-$sum_pz1[$i])*$sum_bl[$i];
}
}


$b=0;

for($b=0;$b<$ii;$b++)
{
$i=0;
for($i=0;$i<$ii-1;$i++)
{
if($sum_sx[$i]>$sum_sx[$i+1]){

         $tmp=$sum_tm[$i+1];
	$sum_tm[$i+1]=$sum_tm[$i];
		 $sum_tm[$i]=$tmp;
		 
		   $tmp=$sum_m[$i+1];
	$sum_m[$i+1]=$sum_m[$i];
		 $sum_m[$i]=$tmp;
		 
		  $tmp=$sum_re[$i+1];
	$sum_re[$i+1]=$sum_re[$i];
		 $sum_re[$i]=$tmp;
		 
		 $tmp=$sum_ma[$i+1];
	$sum_ma[$i+1]=$sum_ma[$i];
		 $sum_ma[$i]=$tmp;
		 
		  $tmp=$sum_mb[$i+1];
	$sum_mb[$i+1]=$sum_mb[$i];
		 $sum_mb[$i]=$tmp;
		 
		 $tmp=$sum_ds[$i+1];
	$sum_ds[$i+1]=$sum_ds[$i];
		 $sum_ds[$i]=$tmp;
		 
		 $tmp=$sum_xx[$i+1];
	$sum_xx[$i+1]=$sum_xx[$i];
		 $sum_xx[$i]=$tmp;
		 
		 $tmp=$sum_bl[$i+1];
	$sum_bl[$i+1]=$sum_bl[$i];
		 $sum_bl[$i]=$tmp;
		 
		 $tmp=$sum_sx[$i+1];
	$sum_sx[$i+1]=$sum_sx[$i];
		 $sum_sx[$i]=$tmp;

  $tmp=$sum_pz1[$i+1];
	$sum_pz1[$i+1]=$sum_pz1[$i];
		 $sum_pz1[$i]=$tmp;


 $tmp=$sum_color[$i+1];
	$sum_color[$i+1]=$sum_color[$i];
		 $sum_color[$i]=$tmp;
   



}


}


}


$fg=0;

$i=0;
for($i=0;$i<$ii;$i++)
{
if(($sum_sx[$i]+$ztm_tm)>=0 || $sum_bl[$i]==0 ){
$ffxx=0;}else{
//(波色走总-最大亏-波色预计赢利)/(赔率-1+用户的退水/100)
if($sum_tm[$i]=="大"||$sum_tm[$i]=="小"){
$ffxx=(-$sum_sx[$i]-$ztm_tm)/($sum_bl[$i]+$zm61/100-1);
}elseif($sum_tm[$i]=="单"||$sum_tm[$i]=="双"){
$ffxx=(-$sum_sx[$i]-$ztm_tm)/($sum_bl[$i]+$zm61/100-1);
}elseif($sum_tm[$i]=="红波"||$sum_tm[$i]=="绿波"||$sum_tm[$i]=="蓝波"){
$ffxx=(-$sum_sx[$i]-$ztm_tm)/($sum_bl[$i]+$zm61/100-1);
}elseif($sum_tm[$i]=="合大"||$sum_tm[$i]=="合小"){
$ffxx=(-$sum_sx[$i]-$ztm_tm)/($sum_bl[$i]+$zm61/100-1);
}elseif($sum_tm[$i]=="合单"||$sum_tm[$i]=="合双"){
$ffxx=(-$sum_sx[$i]-$ztm_tm)/($sum_bl[$i]+$zm61/100-1);
}elseif($sum_tm[$i]=="尾大"||$sum_tm[$i]=="尾小"){
$ffxx=(-$sum_sx[$i]-$ztm_tm)/($sum_bl[$i]+$zm61/100-1);
}
/*
if ($i==0){
if(((0-$sum_sx[0])-$ztm_tm)==0 or $sum_bl[0]==0 ){
$ffxx=0;
}else{$ffxx=(((0-$sum_sx[0])-$ztm_tm)/$sum_bl[0]);}

}else{
if(((0-$sum_sx[$i])-$ztm_tm)==0 or $sum_bl[$i]==0 ){
$ffxx=0;}else{$ffxx=(((0-$sum_sx[$i])-$ztm_tm)/$sum_bl[$i]);}
*/


}
$bl=round($ffxx,0);//intval($ffxx);
 if($ffxx>=1){
$fg=$fg+1;


if ($i==0){
$sum_pz[0]="<button class=headtd4  onmouseover=this.className='headtd3';window.status='正特'; return true; onMouseOut=this.className='headtd4';window.status='正特';return true; onclick=show_win('".$sum_tm[0]."','".$bl."','".$sum_bl[0]."','".$class1."','".$class2."')    ><font color=ff6600>走飞</font>  ".$bl."</button>";

}else{
$sum_pz[$i]="<button class=headtd4  onmouseover=this.className='headtd3';window.status='正特'; return true; onMouseOut=this.className='headtd4';window.status='正特';return true; onclick=show_win('".$sum_tm[$i]."','".$bl."','".$sum_bl[$i]."','".$class1."','".$class2."')    ><font color=ff6600>走飞</font>  ".$bl."</button>";}



}else{
$sum_pz[$i]="0";
$sum_pz[$i]="<button class=headtd4  onmouseover=this.className='headtd3';window.status='正特'; return true; onMouseOut=this.className='headtd4';window.status='正特';return true; onclick=show_win('".$sum_tm[$i]."','".$bl."','".$sum_bl[$i]."','".$class1."','".$class2."')    ><font color=ff6600>走飞</font>  ".$bl."</button>";
}
}


$i=0;
for($i=0;$i<$ii;$i++)
{



$blbl.=$class2." ".$sum_tm[$i]."@@@". $sum_re[$i]. "注@@@" . $sum_m[$i]. "@@@" . $sum_ma[$i]. "@@@" .$sum_mb[$i]. "@@@" . round($sum_ds[$i],2). "@@@" .round($sum_xx[$i],2). "@@@" . round($sum_sx[$i],2). "@@@" . $sum_pz[$i]. "@@@" . $sum_pz1[$i]. "@@@" .$sum_bl[$i]. "@@@" .$fg."@@@".$sum_tm[$i]."@@@".$sum_color[$i]."###";
}
$blbl.= "0@@@<font color=ff6600>".$z_re."注</font>@@@<font color=ff6600>".$z_sum."</font>@@@<font color=ff6600>".$z_suma."</font>@@@<font color=ff6600>".$z_sumb."</font>@@@<font color=ff6600>".$z_ds."</font>@@@<font color=ff6600>".$z_xx."</font>@@@&nbsp;@@@&nbsp;@@@<font color=ff6600>".$z_pz."</font>@@@<b><font color=ff0000>".$ztm_tm."</font></b>@@@".$fg."###";



echo $blbl;


?>
