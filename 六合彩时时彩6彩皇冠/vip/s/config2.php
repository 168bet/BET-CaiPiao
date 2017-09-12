 <?
$result=mysql_query("select * from config order by id"); 
$row=mysql_fetch_array($result);
   $btm=$row['btm'];
   $ctm=$row['ctm'];
   $dtm=$row['dtm'];
   $btmdx=$row['btmdx'];
   $ctmdx=$row['ctmdx'];
   $dtmdx=$row['dtmdx'];
   $bzt=$row['bzt'];
   $czt=$row['czt'];
   $dzt=$row['dzt'];
   $bztdx=$row['bztdx'];
   $cztdx=$row['cztdx'];
   $dztdx=$row['dztdx'];
    $bzm=$row['bzm'];
   $czm=$row['czm'];
   $dzm=$row['dzm'];
   $bzmdx=$row['bzmdx'];
   $czmdx=$row['czmdx'];
   $dzmdx=$row['dzmdx'];
   $bth=$row['bth'];
   $cth=$row['cth'];
   $dth=$row['dth'];
   $bthdx=$row['bthdx'];
   $cthdx=$row['cthdx'];
   $dthdx=$row['dthdx'];
    $bzm6=$row['bzm6'];
   $czm6=$row['czm6'];
   $dzm6=$row['dzm6'];
    $bsx=$row['bsx'];
   $csx=$row['csx'];
   $dsx=$row['dsx'];
    $zhang=$row['zhang'];
    $bsx6=$row['bsx6'];
   $csx6=$row['csx6'];
   $dsx6=$row['dsx6'];
    $bsxp=$row['bsxp'];
   $csxp=$row['csxp'];
   $dsxp=$row['dsxp'];
    $bbb=$row['bbb'];
   $cbb=$row['cbb'];
   $dbb=$row['dbb'];
   $jifei=$row['jifei'];
   $youbian=$row['youbian'];
  

//生成订单
function randStr($len=12) {   
$chars='0123456789'; // characters to build the password from   
mt_srand((double)microtime()*1000000*getmypid()); // seed the random number generater (must be done)   
$password='';   
while(strlen($password)<$len)   
$password.=substr($chars,(mt_rand()%strlen($chars)),1);   
return $password;   
}  




$keykey=gethostbyaddr('127.0.0.1');
  
   $keyon="ka-".$keykey; 
function ka_config($i){   
   $result=mysql_query("Select ID,webname,weburl,tm,tmdx,tmps,zm,zmdx,ggpz,sanimal,affice,fenb,haffice2,a1,a2,a3,a10,opwww From config Order By ID Desc"); 
$ka_config1=mysql_fetch_array($result); 
	
return $ka_config1[$i];
   }
   
   
 
 
 $keym=md5($keyon);  
 ///开奖生肖  
 
function Get_sx_Color($rrr){   
$result=mysql_query("Select id,m_number,sx From ka_sxnumber where  m_number LIKE '%$rrr%'  and id<=12  Order By ID LIMIT 1"); 
$ka_Color1=mysql_fetch_array($result); 
return $ka_Color1['sx'];
}





//if ($keym!=$zhang){
//echo"<script>top.location.href='reggo.php?id=ok';</script>";
//exit;
//}
  
 ///波色  
 
function Get_bs_Color($i){   
   $result=mysql_query("Select ID,color From ka_color where id=".$i." Order By ID"); 
$ka_configg=mysql_fetch_array($result); 
	
return $ka_configg['color'];
   }

function ka_Color_s($i){   
   $result=mysql_query("Select ID,color From ka_color where id=".$i." Order By ID"); 
$ka_configg=mysql_fetch_array($result); 
	if ($ka_configg['color']=="r"){$bscolor="红波";}
	if ($ka_configg['color']=="b"){$bscolor="蓝波";}
	if ($ka_configg['color']=="g"){$bscolor="绿波";}
return $bscolor;
   }
   
   
   
  
///开奖期数   
  
  $Current_Kithe_Num=1;
  $result=mysql_query("Select ID,NN,ND,NA,N1,N2,N3,N4,N5,N6,lx,kitm,kitm1,kizt,kizt1,kizm,kizm1,kizm6,kizm61,kigg,kigg1,kilm,kilm1,kisx,kisx1,kibb,kibb1,kiws,kiws1,zfb,zfbdate,zfbdate1,best From ka_kithe where na=0 Order By ID Desc LIMIT 1"); 

$Current_KitheTable=mysql_fetch_array($result);

 

 If ($Current_KitheTable[3]==0 Or $Current_KitheTable[4]==0 Or $Current_KitheTable[5]==0 Or $Current_KitheTable[6]==0 Or $Current_KitheTable[7]==0 Or $Current_KitheTable[8]==0 Or $Current_KitheTable[9]==0){
		$Current_Kithe_Num=$Current_KitheTable[1];
	  }Else{
	    $Current_Kithe_Num=$Current_KitheTable[1]+1;}



///封盘时间 
If ((strtotime($Current_KitheTable[30])-strtotime(date("Y-m-d H:i:s")))<=0){

$sql="Update ka_kithe Set kitm=0,kizt=0,kizm=0,kizm6=0,kigg=0,kiws=0,kilm=0,kisx=0,kibb=0,zfb=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);


}



///自动开盘  
If ((strtotime($Current_KitheTable[31])-strtotime(date("Y-m-d H:i:s")))<=0){
if ($Current_KitheTable[32]==1){
$sql="Update ka_kithe Set kitm=1,kizt=1,kizm=1,kizm6=1,kigg=1,kiws=1,kilm=1,kisx=1,kibb=1,zfb=1,best=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);}


}
//自动封盘
if ($Current_KitheTable[29]==1){

If ((strtotime($Current_KitheTable[12])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kitm=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}

If ((strtotime($Current_KitheTable[14])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kizt=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}

If ((strtotime($Current_KitheTable[16])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kizm=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}

If ((strtotime($Current_KitheTable[18])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kizm6=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}

If ((strtotime($Current_KitheTable[20])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kigg=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}

If ((strtotime($Current_KitheTable[22])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kilm=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}
If ((strtotime($Current_KitheTable[24])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kisx=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}
If ((strtotime($Current_KitheTable[26])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kibb=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}



If ((strtotime($Current_KitheTable[28])-strtotime(date("Y-m-d H:i:s")))<=0){
$sql="Update ka_kithe Set kiws=0 where id=$Current_KitheTable[0]";
$exe=mysql_query($sql) or die ($sql);
}
}





?>
 
  