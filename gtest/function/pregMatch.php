<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-22
*/

/**
 * 驗證字符串 0-9
 * Enter description here ...
 * @param string $string
 */
function isString ($string)
{
	if (preg_match('/^[0-9]*$/', $string))
		return true;
	else 
		return false;
}

/**
 * 格式化數字
 * Enter description here ...
 * @param int $number
 * @param int $index
 */
function is_Number ($number, $index=0)
{
	if (stristr($number, '.'))
	{
		$a = explode('.', $number);
		if (mb_strlen($a[1]) == 1)
			return number_format($number, 1);
		else
			return number_format($number, 2);
	}
	return number_format($number);
}

function is_Number2 ($number, $index=0)
{
	if (stristr($number, '.'))
	{
		$a = explode('.', $number);
		if (mb_strlen($a[1]) == 1)
			return $number;
		else
			return $number;
	}
	return $number;
}



function toCNcap($data){
$capnum=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖");
$capdigit=array("","拾","佰","仟");
$subdata=explode(".",$data);
$yuan=$subdata[0];
$j=0; $nonzero=0;
for($i=0;$i<strlen($subdata[0]);$i++){
if(0==$i){ //确定个位 
if($subdata[1]){ 
$cncap=(substr($subdata[0],-1,1)!=0)?"元":"元零";
}else{
$cncap="元";
}
} 
if(4==$i){ $j=0; $nonzero=0; $cncap="万".$cncap; } //确定万位
if(8==$i){ $j=0; $nonzero=0; $cncap="亿".$cncap; } //确定亿位
$numb=substr($yuan,-1,1); //截取尾数
$cncap=($numb)?$capnum[$numb].$capdigit[$j].$cncap:(($nonzero)?"零".$cncap:$cncap);
$nonzero=($numb)?1:$nonzero;
$yuan=substr($yuan,0,strlen($yuan)-1); //截去尾数 
$j++;
}

if($subdata[1]){
$chiao=(substr($subdata[1],0,1))?$capnum[substr($subdata[1],0,1)]."角":"零";
$cent=(substr($subdata[1],1,1))?$capnum[substr($subdata[1],1,1)]."分":"零分";
}
$cncap .= $chiao.$cent."整";
$cncap=preg_replace("/(零)+/","零",$cncap); //合并连续“零”
return $cncap;
}









?>