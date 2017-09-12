<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

require ("../agents/include/config.inc.php");

$id = intval($_GET['uid']);
if(!is_array($_SESSION['notice_idstic'])) {
	$_SESSION['notice_idstic'] = array();
}
if($_GET['act'] == 'add') {

	if(!in_array($id,$_SESSION['notice_idstic'])) {
		$_SESSION['notice_idstic'][] = $id;
		
	}

}
if($_GET['act'] == 'del') {

	if(!empty($_SESSION['notice_idstic'])) {
		foreach ($_SESSION['notice_idstic'] as $k => $v) {
			if($v == $id) {
				unset($_SESSION['notice_idstic'][$k]);
				
			}
		}
	}
}

?>
