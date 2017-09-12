<?PHP
session_start();
session_register('SafeCode');
$type = 'png';
$width= 60;
$height= 20;
header("Content-type: image/".$type);
srand((double)microtime()*1000000);
$randval = randStr(4,"");
if($type!='png' && function_exists('imagecreatetruecolor')){
$im = @imagecreatetruecolor($width,$height);
}else{
$im = @imagecreate($width,$height);
}
$r = Array(200,150,180);
$g = Array(140,180,185);
$b = Array(200,190,160);

$rr = Array(255,240,0);
$gg = Array(100,0,0);
$bb = Array(0,0,205);

$key = rand(0,2);

$stringColor = ImageColorAllocate($im,200,0,0); //字体颜色
$backColor = ImageColorAllocate($im,$r[$key],$g[$key],$b[$key]);//背景色（随机）
$pointColor = ImageColorAllocate($im, 255,255,255);//点颜色

@imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);//背景位置


$Color = ImageColorAllocate($im,255,255,255);
for ($i=0;$i<8;$i++){	
    ImageLine($im,rand(1,50),rand(1,50),rand(1,40),rand(1,1),$Color);
}

/*for($i=0;$i<=200;$i++){
$pointX = rand(2,$width-2);
$pointY = rand(2,$height-2);
@imagesetpixel($im, $pointX, $pointY, $pointColor);//绘模糊作用的点
}*/

@imagestring($im, 5, 12, 3, $randval, $stringColor); //调整字型位置
$ImageFun='Image'.$type;
$ImageFun($im);
@ImageDestroy($im);
$_SESSION['SafeCode'] = $randval;
//产生随机字符串
function randStr($len=6,$format='ALL') {
$chars='ABCDEFGHIJKLMNPQRSTUVWXYZ123456789'; 
$string="";
while(strlen($string)<$len)
$string.=substr($chars,(mt_rand()%strlen($chars)),1);
return $string;
}
?>

