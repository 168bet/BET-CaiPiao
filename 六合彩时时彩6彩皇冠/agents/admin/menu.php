<?php
if(!defined('PHPYOU')) {
	exit('Access Denied');
}
echo PHPYOU;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PHPYou 导航栏</title>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<link rel="stylesheet" type="text/css" id="css" href="./css/admincp.css">
<script>
var is_ie = document.all ? true : false;
var is_ff = window.addEventListener ? true : false;
function refreshmainframe(e) {
	e = e ? e : window.event;
	actualCode = e.keyCode ? e.keyCode : e.charCode;
	if(actualCode == 116 && parent.main) {
		parent.main.location.reload();
		if(is_ie) {
			e.keyCode = 0;
			e.returnValue = false;
		} else {
			e.preventDefault();
		}
	}
}
function get_cookie(name) {
	cookiename = name + '=';
	cookiepos = document.cookie.indexOf(cookiename);
	if(cookiepos != -1) {
		cookiestart =cookiepos+cookiename.length;
		cookieend = document.cookie.indexOf(';', cookiestart);
		if(cookieend == -1) {
			cookieend = document.cookie.length;
		}
		return unescape(document.cookie.substring(cookiestart, cookieend));
	}
	return '';
}
function set_cookie(name, value) {
	expires = new Date();
	expires.setTime(expires.getTime() + 2592000);
	document.cookie = name + "=" + value + "; path=/; expires=" + expires.toGMTString();
}
function $(id) {
	return document.getElementById(id);
}
var collapsed=get_cookie('cdb_collapse');
function collapse_change(menucount) {
	if($('menu_' + menucount).style.display == 'none') {
		$('menu_' + menucount).style.display = '';collapsed = collapsed.replace('[' + menucount + ']' , '');
		$('menuimg_' + menucount).src = './css/menu_reduce.gif';
	} else {
		$('menu_' + menucount).style.display = 'none';collapsed += '[' + menucount + ']';
		$('menuimg_' + menucount).src = './css/menu_add.gif';
	}
	
}
</script>
</head>

<body onkeydown="refreshmainframe(event)" style="margin:5px!important;margin:3px;">

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;"><tr class="leftmenutext"><td><div align="center"><a href="../" target="_blank">网站首页</a>&nbsp;&nbsp;<a href="#"  onClick="parent.menu.location='admincp.php?action=menu'; parent.main.location='admincp.php?action=main';return false;">后台首页</a></div></td></tr></table>

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;">
<tr class="leftmenutext"><td><a href="###" onclick="collapse_change(1)">
<img id="menuimg_1" src="./css/menu_add.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change(1)">系统设置</a></td></tr>
<tbody id="menu_1" style="display:none"><tr class="leftmenutd"><td><table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
<tr><td><a href="admincp.php?action=webset" target="main">网站设置</a></td></tr>
<tr><td><a href="admincp.php?action=settings" target="main">图片设置</a></td></tr>
<tr><td><a href="admincp.php?action=adminpwd" target="main">修改密码</a></td></tr>
</table></td></tr></tbody></table>

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;">
<tr class="leftmenutext"><td><a href="###" onclick="collapse_change(2)">
<img id="menuimg_2" src="./css/menu_add.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change(2)">内容管理</a></td></tr>
<tbody id="menu_2" style="display:none"><tr class="leftmenutd"><td><table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
<tr><td><a href="admincp.php?action=edit" target="main">编辑修改</a></td></tr>
<tr><td><a href="admincp.php?action=addone" target="main">图片上传</a></td></tr>
<tr><td><a href="admincp.php?action=batchfile" target="main">批量导入</a></td></tr>
<tr><td><a href="admincp.php?action=unzip" target="main">解压缩包</a></td></tr>
</table></td></tr></tbody></table>

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;">
<tr class="leftmenutext"><td><a href="###" onclick="collapse_change(3)">
<img id="menuimg_3" src="./css/menu_add.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change(3)">分类管理</a></td></tr>
<tbody id="menu_3" style="display:none"><tr class="leftmenutd"><td><table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
<tr><td><a href="admincp.php?action=sort" target="main">分类管理</a></td></tr>
<tr><td><a href="admincp.php?action=sort&edit=add" target="main">添加根分类</a></td></tr>
</table></td></tr></tbody></table>

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;">
<tr class="leftmenutext"><td><a href="###" onclick="collapse_change(6)">
<img id="menuimg_6" src="./css/menu_add.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change(6)">留言管理</a></td></tr>
<tbody id="menu_6" style="display:none"><tr class="leftmenutd"><td><table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
<tr><td><a href="admincp.php?action=commentcheck" target="main">留言审核</a></td></tr>
<tr><td><a href="admincp.php?action=commentlist" target="main">留言列表</a></td></tr>
<tr><td><a href="admincp.php?action=commentsetting" target="main">留言设置</a></td></tr>
</table></td></tr></tbody></table>

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;">
<tr class="leftmenutext"><td><a href="###" onclick="collapse_change(5)">
<img id="menuimg_5" src="./css/menu_add.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change(5)">数据库</a></td></tr>
<tbody id="menu_5" style="display:none"><tr class="leftmenutd"><td><table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
<tr><td><a href="admincp.php?action=dbexport" target="main">资料备份</a></td></tr>
<tr><td><a href="admincp.php?action=dbimport" target="main">资料恢复</a></td></tr>
<tr><td><a href="admincp.php?action=dbquery" target="main">数据库升级</a></td></tr>
<tr><td><a href="admincp.php?action=dboptimize" target="main">数据表优化</a></td></tr>
</table></td></tr></tbody></table>

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;">
<tr class="leftmenutext"><td><a href="###" onclick="collapse_change(4)">
<img id="menuimg_4" src="./css/menu_add.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change(4)">清空缓存</a></td></tr>
<tbody id="menu_4" style="display:none"><tr class="leftmenutd"><td><table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
<tr><td><a href="admincp.php?action=delcache" target="main">清空缓存</a></td></tr>

</table></td></tr></tbody></table>



<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist"><tr class="leftmenutext"><td><div style="margin-left:48px;"><a href="admincp.php?action=logout" target="_top">退出</a></td></tr></table>
</body>
</html>