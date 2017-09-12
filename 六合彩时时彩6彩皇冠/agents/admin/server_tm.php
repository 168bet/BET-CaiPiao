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
$ztm_tm=$tm;

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

$z_re1=0;
$z_sum1=0;
$z_suma1=0;
$z_sumb1=0;
$z_ds1=0;
$z_xx1=0;
$z_pz1=0;





$result = mysql_query("select class3,class1   from   ka_bl where   class1='".$class1."' and class2='特A'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and lx=0 and  class1='".$rs['class1']."' and class3='".$rs['class3']."'");
$Rs5 = mysql_fetch_array($result1);

$result2 = mysql_query("Select sum(sum_m*rate+sum_m*(user_ds/100)) as sum_money,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m) as sum_m3 from ka_tan   where   Kithe='".$kithe."' and  lx=1 and  class1='".$rs['class1']."' and class3='".$rs['class3']."'");
$Rs7 = mysql_fetch_array($result2);

$result3 = mysql_query("Select sum(sum_m*dagu_zc/10) as sum_moneya from ka_tan   where  Kithe='".$kithe."' and  lx=0 and  class1='".$rs['class1']."' and  class3='".$rs['class3']."'");
$RsA = mysql_fetch_array($result3);
$result4 = mysql_query("Select sum(sum_m*dagu_zc/10) as sum_moneyb from ka_tan   where  Kithe='".$kithe."' and  lx=0 and  class1='".$rs['class1']."' and class2='特1B' and class3='".$rs['class3']."'");
//$RsB = mysql_fetch_array($result4);

$result5 = mysql_query("Select * from ka_bl   where   class1='".$rs['class1']."' and class2='特A' and class3='".$rs['class3']."'");
$Rsbl = mysql_fetch_array($result5);


//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);

if ($rskf['color']=="r") {
$sum_color[$ii]="ee0000";

}else if ($rskf['color']=="b"){$sum_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sum_color[$ii]="008800";}
}else{

$sum_color[$ii]="ee0000";

}




$sum_tm[$ii]=$rs['class3'];
$sum_re[$ii]=$Rs5['re'];
if ($Rs5['sum_m']!=""){
$sum_m[$ii] = round($Rs5['sum_m'],0);}else{$sum_m[$ii] =0;}


if ($RsA['sum_moneya']!=""){$sum_ma[$ii] =$RsA['sum_moneya'];}else{$sum_ma[$ii] =0;}
if ($RsB['sum_moneyb']!=""){$sum_mb[$ii] =$RsB['sum_moneyb'];}else{$sum_mb[$ii] =0;}

$sum_ds[$ii]=$Rs5['sum_ds'];

$sum_xx[$ii]=$Rs5['sum_m3'];
$sum_xx_7[$ii]=$Rs7['sum_m3'];


if ($ii<49){
if ($Rsbl['rate']!=""){
$sum_bl[$ii]="<a style=\"cursor:hand\" onClick=\"UpdateRate('MODIFYRATE','lm','bl".$ii."','class1=特码&ids=特A&sqq=sqq&lxlx=0&qtqt=0.5&class3=".$rs['class3']."');\"><font color=0000ff>-</font></a><a style=\"cursor:hand\" onClick=\"UpdateRate('MODIFYRATE','lm','bl".$ii."','class1=特码&ids=特A&sqq=sqq&lxlx=0&qtqt=0.1&class3=".$rs['class3']."');\"><font color=0000ff>↓</font></a><span id=bl".$ii.">".$Rsbl['rate']."</span><a style=\"cursor:hand\" onClick=\"UpdateRate('MODIFYRATE','lm','bl".$ii."','class1=特码&ids=特A&sqq=sqq&lxlx=1&qtqt=0.1&class3=".$rs['class3']."');\"><font color=ff0000>↑</font><a style=\"cursor:hand\" onClick=\"UpdateRate('MODIFYRATE','lm','bl".$ii."','class1=特码&ids=特A&sqq=sqq&lxlx=1&qtqt=0.5&class3=".$rs['class3']."');\"><font color=ff0000>+</font></a>";
}else{
$sum_bl[$ii]=0;
}
}else{
if ($Rsbl['rate']!=""){
$sum_bl[$ii]="<a style=\"cursor:hand\" onClick=\"UpdateRate('MODIFYRATE','lm','bl".$ii."','class1=特码&ids=特A&sqq=sqq&lxlx=0&qtqt=0.01&class3=".$rs['class3']."');\"><font color=0000ff>↓</font></a><span id=bl".$ii.">".$Rsbl['rate']."</span><a style=\"cursor:hand\" onClick=\"UpdateRate('MODIFYRATE','lm','bl".$ii."','class1=特码&ids=特A&sqq=sqq&lxlx=1&qtqt=0.01&class3=".$rs['class3']."');\"><font color=ff0000>↑</font></a>";
}else{
$sum_bl[$ii]=0;
}

}//$ii<49



if ($Rsbl['rate']!=""){
$sum_mbl[$ii]=$Rsbl['rate'];
}else{
$sum_mbl[$ii]=0;
}

if ($ii<49){
$z_re+=$Rs5['re'];
$z_sum+=$Rs5['sum_m'];
$z_suma+=$RsA['sum_moneya'];
$z_sumb+=$RsB['sum_moneyb'];
$z_ds+=$Rs5['sum_ds'];
$z_xx+=$Rs5['sum_m3'];
$z_pz+=$Rs7['sum_m3'];}else{

$z_re1+=$Rs5['re'];
$z_sum1+=$Rs5['sum_m'];
$z_suma1+=$RsA['sum_moneya'];
$z_sumb1+=$RsB['sum_moneyb'];
$z_ds1+=$Rs5['sum_ds'];
$z_xx1+=$Rs5['sum_m3'];
$z_pz1+=$Rs7['sum_m3'];

}

$sum_sx1[$ii]=$Rs7['sum_money'];

if ($Rs7['sum_m3']!=""){$sum_pz1[$ii]=$Rs7['sum_m3'];}else{
$sum_pz1[$ii]=0;}

$ii++;
}

for($i=0;$i<66;$i++)
{
if ($i<49){
//总占$z_suma
//总走$z_pz
//单占$sum_ma[$i]
//单走$sum_pz1[$i]
//赔率$sum_mbl[$i]
//(总占-总走)*90% - (单占-单走)*赔率
//$sum_sx[$i]=(($z_suma)*0.9+$z_sumb+$z_ds)+$sum_xx[$i]-$sum_sx1[$i]-$z_pz+$z_suma*0.13;
$sum_sx[$i]=($z_suma-$z_pz)*(1-$tm1/100)-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}else{

if($sum_tm[$i]=="单"||$sum_tm[$i]=="双"){
   $sum_sx[$i]=(($sum_ma[49]+$sum_ma[50])-($sum_xx_7[49]+$sum_xx_7[50]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];  
}elseif($sum_tm[$i]=="大"||$sum_tm[$i]=="小"){
   $sum_sx[$i]=(($sum_ma[51]+$sum_ma[52])-($sum_xx_7[51]+$sum_xx_7[52]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}elseif($sum_tm[$i]=="合单"||$sum_tm[$i]=="合双"){
   $sum_sx[$i]=(($sum_ma[53]+$sum_ma[54])-($sum_xx_7[53]+$sum_xx_7[54]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}elseif($sum_tm[$i]=="红波"||$sum_tm[$i]=="绿波"||$sum_tm[$i]=="蓝波"){
   $sum_sx[$i]=(($sum_ma[55]+$sum_ma[56]+$sum_ma[57])-($sum_xx_7[55]+$sum_xx_7[56]+$sum_xx_7[57]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}elseif($sum_tm[$i]=="家禽"||$sum_tm[$i]=="野兽"){
   $sum_sx[$i]=(($sum_ma[58]+$sum_ma[59])-($sum_xx_7[58]+$sum_xx_7[59]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}elseif($sum_tm[$i]=="尾大"||$sum_tm[$i]=="尾小"){
   $sum_sx[$i]=(($sum_ma[60]+$sum_ma[61])-($sum_xx_7[60]+$sum_xx_7[61]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}elseif($sum_tm[$i]=="大单"||$sum_tm[$i]=="小单"||$sum_tm[$i]=="大双"||$sum_tm[$i]=="小双"){
   $sum_sx[$i]=(($sum_ma[62]+$sum_ma[63]+$sum_ma[64]+$sum_ma[65])-($sum_xx_7[62]+$sum_xx_7[63]+$sum_xx_7[64]+$sum_xx_7[65]))*0.97-($sum_ma[$i]-$sum_pz1[$i])*$sum_mbl[$i];
}


}

}//$ii<49


$b=0;

for($b=0;$b<66;$b++)
{
$i=0;
for($i=0;$i<48;$i++)
{
if ($sum_sx[$i]!=0){
$bbs=$sum_sx[$i];
$bbs1=$sum_sx[$i+1];
}else{
$bbs=$sum_m[$i+1];
$bbs1=$sum_m[$i];
}
if($bbs>$bbs1){

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
		 
		 
		  $tmp=$sum_mbl[$i+1];
	$sum_mbl[$i+1]=$sum_mbl[$i];
		 $sum_mbl[$i]=$tmp;
		 
		 
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
for($i=0;$i<66;$i++)
{

if(($sum_sx[$i]+$ztm_tm)>=0 || $sum_mbl[$i]==0 ){
$ffxx=0;}else{
  if ($i<49){
    $ffxx=((($z_pz-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+$tm1/100-1));
  }else{
	
	if($sum_tm[$i]=="单"||$sum_tm[$i]=="双"){
	$ffxx=(((($sum_xx_7[49]+$sum_xx_7[50])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
	  
}elseif($sum_tm[$i]=="大"||$sum_tm[$i]=="小"){
   $ffxx=(((($sum_xx_7[51]+$sum_xx_7[52])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
}elseif($sum_tm[$i]=="合单"||$sum_tm[$i]=="合双"){
   $ffxx=(((($sum_xx_7[53]+$sum_xx_7[54])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
}elseif($sum_tm[$i]=="红波"||$sum_tm[$i]=="绿波"||$sum_tm[$i]=="蓝波"){
   $ffxx=(((($sum_xx_7[55]+$sum_xx_7[56]+$sum_xx_7[57])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
}elseif($sum_tm[$i]=="家禽"||$sum_tm[$i]=="野兽"){
   $ffxx=(((($sum_xx_7[58]+$sum_xx_7[59])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
}elseif($sum_tm[$i]=="尾大"||$sum_tm[$i]=="尾小"){
   $ffxx=(((($sum_xx_7[60]+$sum_xx_7[61])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
}elseif($sum_tm[$i]=="大单"||$sum_tm[$i]=="小单"||$sum_tm[$i]=="大双"||$sum_tm[$i]=="小双"){
   $ffxx=(((($sum_xx_7[62]+$sum_xx_7[63]+$sum_xx_7[64]+$sum_xx_7[65])-$sum_sx[$i])-$ztm_tm)/($sum_mbl[$i]+3/100-1));
}
	
	
	
	
  }
}


$bl=round($ffxx,0);//intval($ffxx);
 if($ffxx>=1){
$fg=$fg+1;


//if ($i==0){
//$sum_pz[0]="<button class=headtd4  onmouseover=this.className='headtd3';window.status='特码'; return true; onMouseOut=this.className='headtd4';window.status='特码';return true; onclick=show_win('".$sum_tm[0]."','".$bl."','".$sum_mbl[0]."','".$class1."','".$class2."')    ><font color=ff6600>补</font>  ".$bl."</button>";

//}else{
$sum_pz[$i]="<button class=headtd4  onmouseover=this.className='headtd3';window.status='特码'; return true; onMouseOut=this.className='headtd4';window.status='特码';return true; onclick=show_win('".$sum_tm[$i]."','".$bl."','".$sum_mbl[$i]."','".$class1."','".$class2."')    ><font color=ff6600>补</font>  ".$bl."</button>";//}



}else{
$sum_pz[$i]="<button class=headtd4  onmouseover=this.className='headtd3';window.status='特码'; return true; onMouseOut=this.className='headtd4';window.status='特码';return true; onclick=show_win('".$sum_tm[$i]."','".$bl."','".$sum_mbl[$i]."','".$class1."','".$class2."')    ><font color=ff6600>补</font>  ".$bl."</button>";
//$sum_pz[$i]="0";

}
}
$i=0;
$my_bl="";
for($i=0;$i<$ii;$i++)
{
if($i<15){
if($my_bl==""){
$my_bl=$sum_tm[$i];
}else{
$my_bl.=",".$sum_tm[$i];
}}
//if ($sum_m[$i]==0)$sum_sx[$i]=0;

$blbl.=$sum_tm[$i]."@@@". $sum_re[$i]. "@@@" . round($sum_m[$i],0). "@@@" . round($sum_ma[$i],0). "@@@" .$sum_mb[$i]. "@@@" . round($sum_ds[$i],0). "@@@" .round($sum_xx[$i],0). "@@@" . round($sum_sx[$i],0). "@@@" . $sum_pz[$i]. "@@@" . $sum_pz1[$i]. "@@@" .$sum_bl[$i]. "@@@" .$fg."@@@".$sum_tm[$i]."@@@".$sum_color[$i]."###";
}
$blbl.= "0@@@<font color=ff6600>".$z_re."注</font>@@@<font color=ff6600>".$z_sum."</font>@@@<font color=ff6600>".$z_suma."</font>@@@<font color=ff6600>".$z_sumb."</font>@@@<font color=ff6600>".$z_ds."</font>@@@<font color=ff6600>".$z_xx."</font>@@@&nbsp;@@@&nbsp;@@@<font color=ff6600>".$z_pz."</font>@@@<b><font color=ff0000>".$ztm_tm."</font></b>@@@".$fg."###";
$blbl.= "0@@@<font color=ff6600>".$z_re1."注</font>@@@<font color=ff6600>".($z_sum+$z_sum1)."</font>@@@<font color=ff6600>".($z_suma+$z_suma1)."</font>@@@<font color=ff6600>".($z_sumb+$z_sumb1)."</font>@@@<font color=ff6600>".($z_ds+$z_ds1)."</font>@@@<font color=ff6600>".$z_xx1."</font>@@@&nbsp;@@@&nbsp;@@@<font color=ff6600>".($z_pz+$z_pz1)."</font>@@@<b><font color=ff0000>".$ztm_tm."</font></b>@@@".$my_bl."###";



echo $blbl;


?>
