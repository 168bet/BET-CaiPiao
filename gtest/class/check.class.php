<?php
//dump("aa");
function magic($str){
//	alert(get_magic_quotes_gpc());
	if(!get_magic_quotes_gpc()){
//		alert(addslashes(trim($str)));
		return addslashes(trim($str));
	}
	return $str;
}
function checkId($str){
	if(!is_numeric($str)){
		return false;
	}
	return magic($str);
}
function checkStr($str){
//	alert($str);
	if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9]*$/u",$str)){
//		alert(1);
		return false;
	}
	return magic($str);
}
function checkNum($str,$num1,$num2){
	if(mb_strlen($str,"utf-8")<$num1||mb_strlen($str,"utf-8")>$num2){
		return false;
	}
	return magic($str);
}
function checkStrByArr($str,array $arr){
	if(!in_array($str,$arr)){
		return false;
	}
	return magic($str);
}
function checkEmal($str){
	if(!preg_match("/^[a-z0-9A-Z_]{1,255}@[a-z0-9A-Z.]{1,25}$/",$str)){
		return false;
	}
	return magic($str);
}
function alert1($str){
	echo "<script>alert('".$str."');history.back(-1);</script>";
	exit;
}

//echo "aa";
?>