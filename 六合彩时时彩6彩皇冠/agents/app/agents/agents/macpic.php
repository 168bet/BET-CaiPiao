<?PHP
session_start();
session_register('SafeCode');
$type = 'png';
$width= 40;
$height= 20;
header("Content-type: image/".$type);
srand((double)microtime()*1000000);
$randval = randStr(4,"");
if($type!='png' && function_exists('imagecreatetruecolor')){
$im = @imagecreatetruecolor($width,$height);
}else{
$im = @imagecreate($width,$height);
}
$r = Array(210,50,120);
$g = Array(240,225,235);
$b = Array(250,225,10);

$rr = Array(255,240,0);
$gg = Array(100,0,0);
$bb = Array(0,0,205);

$key = rand(0,2);

$stringColor = ImageColorAllocate($im,$rr[$key],$gg[$key],$bb[$key]); //������ɫ
$backColor = ImageColorAllocate($im,$r[$key],$g[$key],$b[$key]);//����ɫ�������
$borderColor = ImageColorAllocate($im, 0, 0, 0);//�߿�ɫ
$pointColor = ImageColorAllocate($im, 255,255,255);//����ɫ

@imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);//����λ��
@imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor); //�߿�λ��

for($i=0;$i<=200;$i++){
$pointX = rand(2,$width-2);
$pointY = rand(2,$height-2);
@imagesetpixel($im, $pointX, $pointY, $pointColor);//��ģ�����õĵ�
}

@imagestring($im, 5, 3, 2, $randval, $stringColor); //��������λ��
$ImageFun='Image'.$type;
$ImageFun($im);
@ImageDestroy($im);
$_SESSION['SafeCode'] = $randval;
//��������ַ���
function randStr($len=6,$format='ALL') {
switch($format) {
/*case 'ALL':
$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; break;
case 'CHAR':
$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; break;
case 'NUMBER':
$chars='0123456789'; break;*/
default :
$chars='0123456789';
break;
}
$string="";
while(strlen($string)<$len)
$string.=substr($chars,(mt_rand()%strlen($chars)),1);
return $string;
}
?>

