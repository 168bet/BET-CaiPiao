<?
 $text=date("Y-m-d H:i:s");
 $class11=ka_bl($rate_id,"class1");
 $class22=ka_bl($rate_id,"class2");
 if ($class22=="二肖"||$class22=="三肖"||$class22=="五肖" || $class22=="六肖" || $class22=="四肖"){
  $class33=ka_bl($rate_id,"class3");}

 
 switch (ka_bl($rate_id,"class1")){
case "特码":

 switch (ka_bl($rate_id,"class3")){

case "单":
$ztm1=ka_config(4);
break;

case "家禽":
$ztm1=ka_config(4);
break;
case "野兽":
$ztm1=ka_config(4);
break;


case "双":
$ztm1=ka_config(4);
break;
case "合单":
$ztm1=ka_config(4);
break;
case "合双":
$ztm1=ka_config(4);
break;
case "大":

$ztm1=ka_config(4);
break;
case "小":
$ztm1=ka_config(4);
break;
case "红波":
$ztm1=ka_config(5);
break;

case "蓝波":
$ztm1=ka_config(5);
break;
case "绿波":
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
$low_drop=$image['low_drop']; //最小值
if (ka_bl($rate_id,"class2")=="特B"){$low_drop=$image['low_drop']+$zmt1;}
$sql="update ka_bl set gold='".$num1."' where class1='".$class11."' and class2='".$class22."' and class3='".$class33."'";

$exe=mysql_query($sql);// or die ($sql);
if ((ka_bl($rate_id,"rate")-$drop)>$low_drop){
$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='特A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='特B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
}else{
$sql="update ka_bl set adddate='". $text."',rate=".$zpm1." where class1='".$class11."' and class2='特A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=".$zpm2." where class1='".$class11."' and class2='特B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
}
				
break;			
case "正码":
switch (ka_bl($rate_id,"class3")){
case "总单":
$ztm1=ka_config(7);
break;
case "总双":
$ztm1=ka_config(7);
break;


case "总大":
$ztm1=ka_config(7);
break;
case "总小":
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
$low_drop=$image['low_drop']; //最小值


if (ka_bl($rate_id,"class2")=="正B"){$low_drop=$image['low_drop']+$zmt1;}

$sql="update ka_bl set gold='".$num1."' where class1='".$class11."' and class2='".$class22."' and class3='".$class33."'";

$exe=mysql_query($sql);// or die ($sql);	

if ((ka_bl($rate_id,"rate")-$drop)>$low_drop){

$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='正A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=rate-".$drop." where class1='".$class11."' and class2='正B' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);

}else{
	
$sql="update ka_bl set adddate='". $text."',rate=".$zpm1." where class1='".$class11."' and class2='正A' and class3='".$class33."'";
$exe=mysql_query($sql) or die ($sql);
$sql="update ka_bl set adddate='". $text."',rate=".$zpm2." where class1='".$class11."' and class2='正B' and class3='".$class33."'";
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
$low_drop=$image['low_drop']; //最小值

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