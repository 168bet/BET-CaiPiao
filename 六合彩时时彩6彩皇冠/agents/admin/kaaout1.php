

<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}





?>


	<?
	$nana=1;
	$result=mysql_query("select * from ka_kithe  order by nn desc LIMIT 1"); 
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


$na=$row['na'];
$n1=$row['n1'];
$n2=$row['n2'];
$n3=$row['n3'];
$n4=$row['n4'];
$n5=$row['n5'];
$n6=$row['n6'];

$zfb=$row['zfb'];
?>

 <?
	function getContent ( $sourceStr,$star,$end,$flag )
{
  switch ($flag) {
    case 0:  //取指定字符前面的
        echo strrpos( $sourceStr, $end );
        echo '-----'.strlen( $end );
        $content = substr( $sourceStr, 0, strrpos( $sourceStr, $end ) + strlen( $end ) );
        break;
    case 1:  //取指定字符之间的,不包括指定字符
        $content = substr( $sourceStr, strrpos( $sourceStr,$star)+ strlen( $star ));
        $content = substr( $content, 0, strrpos( $content, $end ) );
        break;
    case 2:  //取指定字符之间的，包括指定字符
        $content =strstr( $sourceStr, $star );
        $content = substr( $content, 0, strrpos( $content, $end ) + strlen( $end ) );
        break;
    case 3:  //取指定字符之后的，不包括指定字符
        $content = substr( $sourceStr, strrpos( $sourceStr,$star)+ strlen( $star ));
        break;
    case 4:  //取指定字符之后的，包括指定字符
        $content =strstr( $sourceStr, $star );
        break;
  }
    
        return $content;
}



  $ch = curl_init() or die (curl_error());
  //设置URL参数
  curl_setopt($ch,CURLOPT_URL,"http://ball1.91813.com/vdata.htm");
  //要求CURL返回数据
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  //执行请求
  $sourceStr = curl_exec($ch) or die (curl_error());
$returnStr = getContent( $sourceStr,'parent.ltime=','</script>',2);
$xxmm=explode("'",$returnStr);
$kithe1=$xxmm[1];
$nn1=$xxmm[3];
$nn2=$xxmm[5];
$nn3=$xxmm[7];
$nn4=$xxmm[9];
$nn5=$xxmm[11];
$nn6=$xxmm[13];
$nn7=$xxmm[15];
$nn8=0;
if ($kithe1!=$nn){
$nn8=1;
}else{
if (!empty($nn1) and $nn1!=0 ){
$sql="update ka_kithe set n1='".$nn1."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");
}
if (!empty($nn2) and $nn2!=0 ){
$sql="update ka_kithe set n2='".$nn2."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");
}
if (!empty($nn3) and $nn3!=0 ){
$sql="update ka_kithe set n3='".$nn3."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");
}

if (!empty($nn4) and $nn4!=0 ){
$sql="update ka_kithe set n4='".$nn4."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");
}

if (!empty($nn5) and $nn5!=0 ){
$sql="update ka_kithe set n5='".$nn5."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");
}
if (!empty($nn6) and $nn6!=0 ){
$sql="update ka_kithe set n6='".$nn6."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");
}


if (!empty($nn7) and $nn7!=0 ){
$na=$nn7;

if ($nn7<10) {
				  $vv="0".$nn7;
				  }else{
				  $vv=$nn7;
				  }
$sx=Get_sx_Color($vv);

$sql="update ka_kithe set na='".$nn7."',sx='".$sx."' where id=".$id;
$exe=mysql_query($sql) or  die("数据库修改出错1");

$sql22="update ka_bl set gold=0";
$exe=mysql_query($sql22) or  die("数据库修改出错1");



$resultf = mysql_query("select * from ya_kithe order by nn LIMIT 1");   
while($imagef = mysql_fetch_array($resultf)){
//添加新
$ykaid=$imagef['id'];
$nn=$imagef['nn']+3;

$sqlrr="INSERT INTO  ka_kithe set best='".$imagef['best']."',nn='".$imagef['nn']."',nd='".$imagef['nd']."',kitm='".$imagef['kitm']."',kizt='".$imagef['kizt']."',kizm='".$imagef['kizm']."',kizm6='".$imagef['kizm6']."',kigg='".$imagef['kigg']."',kilm='".$imagef['kilm']."',kisx='".$imagef['kisx']."',kibb='".$imagef['kibb']."',kiws='".$imagef['kiws']."',zfbdate='".$imagef['zfbdate']."',kitm1='".$imagef['kitm1']."',kizt1='".$imagef['kizt1']."',kizm1='".$imagef['kizm1']."',kizm61='".$imagef['kizm61']."',kigg1='".$imagef['kigg1']."',kilm1='".$imagef['kilm1']."',kisx1='".$imagef['kisx1']."',kibb1='".$imagef['kibb1']."',kiws1='".$imagef['kiws1']."',zfbdate1='".$imagef['zfbdate1']."',n1=0,n2=0,n3=0,n4=0,n5=0,n6=0,na=0,lx=0 ";
$exe=mysql_query($sqlrr) or  die("数据库修改出错");

$sqlzz="update ya_kithe set nn='".$nn."' where id=".$ykaid;
$exe=mysql_query($sqlzz) or  die("数据库修改出错1");

}
}

}
echo "@@@".$kithe1."@@@".$nn1."@@@".$nn2."@@@".$nn3."@@@".$nn4."@@@".$nn5."@@@".$nn6."@@@".$nn7."@@@".$nn8."@@@".$na."###";
 echo curl_error($ch);
  //关闭CURL
  curl_close($ch);
  ?>