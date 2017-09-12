<?php
if (!get_magic_quotes_gpc()) {
	!empty($_POST)	 && Add_S($_POST);
	!empty($_GET)	 && Add_S($_GET);
	!empty($_COOKIE) && Add_S($_COOKIE);
	!empty($_SESSION) && Add_S($_SESSION);
}
!empty($_FILES) && Add_S($_FILES);

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
  
 
?>