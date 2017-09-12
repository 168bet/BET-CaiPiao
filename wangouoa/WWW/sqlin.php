<?php
if (!get_magic_quotes_gpc()) {
	!empty($_POST)	 && antixss(Add_S($_POST));
	!empty($_GET)	 && antixss(Add_S($_GET));
	!empty($_COOKIE) && antixss(Add_S($_COOKIE));
	!empty($_SESSION) && antixss(Add_S($_SESSION));
}
!empty($_FILES) && antixss(Add_S($_FILES));

function Add_S(&$array){
	if (is_array($array)) {
		foreach ($array as $key => $value) {
			if (!is_array($value)) {
				$array[$key] = addslashes($value);
			} else {
				Add_S($array[$key]);
			}
		}
	}
}

function antixss(&$arr) {
		$ra=Array('/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/','/src/','/alert/','/&#/','/u003c/','/u003e/');
		if (is_array($arr)){
			foreach ($arr as $key => $value) {
				if (!is_array($value)){
					if (!is_numeric($value)){
						if (!get_magic_quotes_gpc()) {
							$value=@addslashes($value);
						}
						$value = preg_replace($ra,'',$value);
						$arr[$key] =  @htmlspecialchars(strip_tags($value),ENT_NOQUOTES);
					}
				}else{
					$this->antixss($arr[$key]);
				}
			}
		}
}

/* 过滤所有GET过来变量------------------------------------------------------------- */
foreach ($_GET as $get_key=>$get_var) 
{ 
if (is_numeric($get_var)) { 
$get[strtolower($get_key)] = get_int($get_var); 
} else { 
$get[strtolower($get_key)] = get_str($get_var); 
} 
} 
    
/* 过滤所有POST过来的变量 */
foreach ($_POST as $post_key=>$post_var) 
{ 
if (is_numeric($post_var)) { 
$post[strtolower($post_key)] = get_int($post_var); 
} else { 
$post[strtolower($post_key)] = get_str($post_var); 
} 
} 
    
/* 过滤函数 */
//整型过滤函数 
function get_int($number) 
{ 
return intval($number); 
} 
//字符串型过滤函数 
function get_str($string) 
{ 
if (!get_magic_quotes_gpc()) { 
return addslashes($string); 
} 
return $string; 
}

function wjStrFilter($str,$pi_Def="",$pi_iType=1){

 if ( isset($_GET[$str]) )
    $str = trim($_GET[$str]);
  else if ( isset($_POST[$str]))
    $str = trim($_POST[$str]);
  else if ($str)
    $str = trim($str);
  else
    return $pi_Def;
	// INT
  if ($pi_iType==0)
  {
    if (is_numeric($str))
      return $str;
    else
      return $pi_Def;
  }
  
 // String
if($str){
	$str=str_replace("chr(9)","&nbsp;",$str);
	$str=str_replace("chr(10)chr(13)","<br />",$str);
	$str=str_replace("chr(10)","<br />",$str);
	$str=str_replace("chr(13)","<br />",$str);
	$str=str_replace("chr(32)","&nbsp;",$str);
	$str=str_replace("chr(34)","&quot;",$str);
	$str=str_replace("chr(39)","&#39;",$str);
	$str=str_replace("script", "&#115cript",$str);
	$str=str_replace("&","&amp;",$str);
	$str=str_replace(";","&#59;",$str);
	$str=str_replace("'","&#39;",$str);
	$str=str_replace("<","&lt;",$str);
	$str=str_replace("u003c","&lt;",$str);
	$str=str_replace(">","&gt;",$str);
	$str=str_replace("u003e","&gt;",$str);
	$str=str_replace("#","&#40;",$str);
	$str=str_replace("*","&#42;",$str);
	$str=str_replace("--","&#45;&#45;",$str);
	
	$str=preg_replace("/insert/i", "",$str);
	$str=preg_replace("/update/i", "",$str);
	$str=preg_replace("/delete/i", "",$str);
	$str=preg_replace("/select/i", "",$str);
	$str=preg_replace("/drop/i", "",$str);
	$str=preg_replace("/load_file/i", "",$str);
	$str=preg_replace("/outfile/i", "",$str);
	$str=preg_replace("/into/i", "",$str);
	$str=preg_replace("/exec/i", "",$str);
	$str=preg_replace("/eval/i", "",$str);
	$str=preg_replace("/assert/i", "",$str);
    $str=preg_replace("/system/i", "",$str);
	$str=preg_replace("/shell_exec/i", "",$str);
	$str=preg_replace("/file_get_contents/i", "",$str);
	$str=preg_replace("/cmd/i", "",$str);
	$str=preg_replace("/replace/i", "",$str);
	$str=preg_replace("/ssc_/i", "",$str);
	$str=preg_replace("/union/i", "",$str);
	$str=preg_replace("/%/i", "",$str);
	
	if (get_magic_quotes_gpc()){
		$str = str_replace("\\\"", "&quot;",$str);
		$str = str_replace("\\''", "&#039;",$str);
	}else{
		$str = addslashes($str);
		$str = str_replace("\"", "&quot;",$str);
		$str = str_replace("'", "&#039;",$str);
		
	}
	$str=mysql_escape_string($str);
}
return $str;
}
?>