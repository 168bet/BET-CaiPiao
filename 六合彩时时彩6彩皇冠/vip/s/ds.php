<?
 $text=date("Y-m-d H:i:s");
 $class11=ka_bl($rate_id,"class1");
 $class22=ka_bl($rate_id,"class2");
 if ($class22=="��Ф"||$class22=="��Ф"||$class22=="��Ф" || $class22=="��Ф" || $class22=="��Ф"){
  $class33=ka_bl($rate_id,"class3");}

 
 switch (ka_bl($rate_id,"class1")){
case "����":

 switch (ka_bl($rate_id,"class3")){

case "��":
$ztm1=ka_config(4);
break;

case "����":
$ztm1=ka_config(4);
break;
case "Ұ��":
$ztm1=ka_config(4);
break;


case "˫":
$ztm1=ka_config(4);
break;
case "�ϵ�":
$ztm1=ka_config(4);
break;
case "��˫":
$ztm1=ka_config(4);
break;
case "��":

$ztm1=ka_config(4);
break;
case "С":
$ztm1=ka_config(4);
break;
case "�첨":
$ztm1=ka_config(5);
break;

case "����":
$ztm1=ka_config(5);
break;
case "�̲�":
$ztm1=ka_config(5);
break;
    default:
$ztm1=ka_config(3);
break;
}


$result=mysql_query("Select drop_sort,drop_value,drop_unit,low_drop from ka_drop where drop_sort='".$drop_sort."' order by id");
$image = mysql_fetch_array($result);
@$drop=intval((ka_bl($rate_id,"gold")+$sum_m)/$image['drop_value'])*$image['drop_unit'];
@$num1=(ka_bl($rate_id,"gold")+$sum_m)%$image['drop_value'];
$zpm1=$image['low_drop'];
$zpm2=$image['low_drop']+$ztm1;
$low_drop=$image['low_drop']; //��Сֵ
if (ka_bl($rate_id,"class2")=="��B"){$low_drop=$image['low_drop']+$zmt1;}
$sql="update ka_bl set gold='".$num1."' where class1='".$class11."' and class2='".$class22."' and class3='".$class33."'";

$exe=mysql_query($sql);// or die ($sql);
if ((ka_bl($rate_id,"rate")-$drop)>$low_drop){
$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='��A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='��B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
}else{
$sql="update ka_bl set adddate='". $text."',rate=".$zpm1." where class1='".$class11."' and class2='��A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=".$zpm2." where class1='".$class11."' and class2='��B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
}
				
break;			
case "����":
switch (ka_bl($rate_id,"class3")){
case "�ܵ�":
$ztm1=ka_config(7);
break;
case "��˫":
$ztm1=ka_config(7);
break;


case "�ܴ�":
$ztm1=ka_config(7);
break;
case "��С":
$ztm1=ka_config(7);

break;
    default:
$ztm1=ka_config(6);
break;
}




$result=mysql_query("Select drop_sort,drop_value,drop_unit,low_drop from ka_drop where drop_sort='".$drop_sort."' order by id");
$image = mysql_fetch_array($result);

@$drop=intval((ka_bl($rate_id,"gold")+$sum_m)/$image['drop_value'])*$image['drop_unit'];
@$num1=(ka_bl($rate_id,"gold")+$sum_m)%$image['drop_value'];
$zpm1=$image['low_drop'];
$zpm2=$image['low_drop']+$ztm1;
$low_drop=$image['low_drop']; //��Сֵ


if (ka_bl($rate_id,"class2")=="��B"){$low_drop=$image['low_drop']+$zmt1;}

$sql="update ka_bl set gold='".$num1."' where class1='".$class11."' and class2='".$class22."' and class3='".$class33."'";

$exe=mysql_query($sql);// or die ($sql);	

if ((ka_bl($rate_id,"rate")-$drop)>$low_drop){

$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='��A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='��B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);

}else{
	
$sql="update ka_bl set adddate='". $text."',rate=".$zpm1." where class1='".$class11."' and class2='��A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=".$zpm2." where class1='".$class11."' and class2='��B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
			
}


break;




default:


$result=mysql_query("Select drop_sort,drop_value,drop_unit,low_drop from ka_drop where drop_sort='".$drop_sort."' order by id");
$image = mysql_fetch_array($result);
@$drop=intval((ka_bl($rate_id,"gold")+$sum_m)/$image['drop_value'])*$image['drop_unit'];
@$num1=(ka_bl($rate_id,"gold")+$sum_m)%$image['drop_value'];
$zpm1=$image['low_drop'];
$zpm2=$image['low_drop'];
$low_drop=$image['low_drop']; //��Сֵ

$sql="update ka_bl set gold='".$num1."' where class1='".$class11."' and class2='".$class22."' and class3='".$class33."'";

$exe=mysql_query($sql);// or die ($sql);	
if ((ka_bl($rate_id,"rate")-$drop)>$low_drop){

$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='".$class22."'  and class3='".$class33."'";

$exe=mysql_query($sql) or die ($sql);
}else{

$sql="update ka_bl set adddate='". $text."',rate=".$zpm1." where class1='".$class11."' and class2='".$class22."'  and class3='".$class33."'";

$exe=mysql_query($sql) or die ($sql);
}
break;

}?>