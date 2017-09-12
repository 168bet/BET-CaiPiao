<?php
/**
 * �x���P�ڕr �D�Q��ԓ�x���r��

 * @param odd_type 	�x��P��
 * @param iorH		���r��
 * @param iorC		���r��
 * @param show		�@ʾλ��
 * @return		�؂���� 0-->H  ,1-->C
 */
function  get_other_ioratio($odd_type,$iorH,$iorC,$showior){
	$out=Array();
	if($iorH!="" ||$iorC!=""){
		$out =chg_ior($odd_type,$iorH,$iorC,$showior);
	}else{
		$out[0]=$iorH;
		$out[1]=$iorC;
	}
	return $out;
}
/**
 * �D�Q�r��
 * @param odd_f
 * @param H_ratio
 * @param C_ratio
 * @param showior
 * @return
 */
function chg_ior($odd_f,$iorH,$iorC,$showior){
	$ior=Array();
	if($iorH < 3) $iorH *=1000;
	if($iorC < 3) $iorC *=1000;
	$iorH=$iorH;
	$iorC=$iorC;
	switch($odd_f){
	case "H":	//���׃�P(ݔˮ�P)
		$ior = get_HK_ior($iorH,$iorC);
		break;
	case "M":	//�R��P
		$ior = get_MA_ior($iorH,$iorC);
		break;
	case "I" :	//ӡ��P
		$ior = get_IND_ior($iorH,$iorC);
		break;
	case "E":	//�W�ޱP
		$ior = get_EU_ior($iorH,$iorC);
		break;
	default:	//��۱P
		$ior[0]=$iorH ;
		$ior[1]=$iorC ;
	}
	$ior[0]/=1000;
	$ior[1]/=1000;
	$ior[0]=number(Decimal_point($ior[0],$showior),3);
	$ior[1]=number(Decimal_point($ior[1],$showior),3);
	$ior[0]=number_format($ior[0],3,'.','');
	$ior[1]=number_format($ior[1],3,'.','');
	return $ior;
}
/**
 * �Q���ݔˮ�P�r��
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_HK_ior($H_ratio,$C_ratio){
	$out_ior=Array();
	$line="";
	$lowRatio="";
	$nowRatio="";
	$highRatio="";
    $nowType="";
	if ($H_ratio <= 1000 && $C_ratio <= 1000){
		$out_ior[0]=$H_ratio;
		$out_ior[1]=$C_ratio;
		return $out_ior;
	}
	$line=2000 - ( $H_ratio + $C_ratio );
	if ($H_ratio > $C_ratio){ 
		$lowRatio=$C_ratio;
		$nowType = "C";
	}else{
		$lowRatio = $H_ratio;
		$nowType = "H";
	}
	if (((2000 - $line) - $lowRatio) > 1000){
		//���P�R��P
		$nowRatio = ($lowRatio + $line) * (-1);
	}else{
		//���P��۱P
		$nowRatio=(2000 - $line) - $lowRatio;	
	}
	if ($nowRatio < 0){
		$highRatio = (abs(1000 / $nowRatio) * 1000) ;
	}else{
		$highRatio = (2000 - $line - $nowRatio) ;
	}
	if ($nowType == "H"){
		$out_ior[0]=$lowRatio;
		$out_ior[1]=$highRatio;
	}else{
		$out_ior[0]=$highRatio;
		$out_ior[1]=$lowRatio;
	}
	return $out_ior;
}
/**
 * �Q����R��P�r��
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_MA_ior( $H_ratio, $C_ratio){
	$out_ior=Array();
	$line="";
	$lowRatio="";
	$highRatio="";
    $nowType="";
	if (($H_ratio <= 1000 && $C_ratio <= 1000)){
		$out_ior[0]=$H_ratio;
		$out_ior[1]=$C_ratio;
		return $out_ior;
	}
	$line=2000 - ( $H_ratio + $C_ratio );
	if ($H_ratio > $C_ratio){ 
		$lowRatio = $C_ratio;
		$nowType = "C";
	}else{
		$lowRatio = $H_ratio;
		$nowType = "H";
	}
	$highRatio = ($lowRatio + $line) * (-1);
	if ($nowType == "H"){
		$out_ior[0]=$lowRatio;
		$out_ior[1]=$highRatio;
	}else{
		$out_ior[0]=$highRatio;
		$out_ior[1]=$lowRatio;
	}
	return $out_ior;
}
/**
 * �Q���ӡ��P�r��
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_IND_ior( $H_ratio, $C_ratio){
	$out_ior=Array();
	$out_ior = get_HK_ior($H_ratio,$C_ratio);
	$H_ratio=$out_ior[0];
	$C_ratio=$out_ior[1];
	$H_ratio /= 1000;
	$C_ratio /= 1000;
	if($H_ratio < 1){
		$H_ratio=(-1) / $H_ratio;
	}
	if($C_ratio < 1){
		$C_ratio=(-1) / $C_ratio;
	}
	$out_ior[0]=$H_ratio*1000;
	$out_ior[1]=$C_ratio*1000;
	return $out_ior;
}
/**
 * �Q��ɚW�ޱP�r��
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_EU_ior($H_ratio, $C_ratio){
	$out_ior=Array();
	$out_ior = get_HK_ior($H_ratio,$C_ratio);
	$H_ratio=$out_ior[0];
	$C_ratio=$out_ior[1];       
	$out_ior[0]=$H_ratio+1000;
	$out_ior[1]=$C_ratio+1000;
	return $out_ior;
}
/*
ȥ��̖ؓ��С���ڎ�λ��ȥ
�M���ֵ��С��ֵ
*/
function Decimal_point($tmpior,$show){
	$sign="";
	$sign =(($tmpior < 0)?"Y":"N");
	$tmpior = (floor(abs($tmpior) * $show + 1 / $show )) / $show;
	return ($tmpior * (($sign =="Y")? -1:1));
}
 
 
/*
 ���� FUNC
*/
function number($vals,$points){ //С���cλ��
	$cmd=Array();
	$cmd=split(".",$vals);
	$length=strlen($cmd[1]);
	if (count($cmd)>1){
		for ($ii=0;$ii<($points-$length);$ii++) $vals=$vals."0";
	}else{
		$vals=$vals+".";
		for ($ii=0;$ii<$points;$ii++) $vals=$vals."0";
	}
	return $vals;
}
?>
