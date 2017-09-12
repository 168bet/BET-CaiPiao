<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-7
*/

/***
 * 彈出並返回上一頁
 */
function back($str)
{
	echo '<script>alert("'.$str.'");history.back();</script>';
}

function go($str, $int)
{
	echo '<script>alert("'.$str.'");history.go(-'.$int.')</script>';
}
/***
 * 頁面跳轉
 */
function href ($url)
{
	echo '<script>location.href = "'.$url.'"</script>';
}

function href_parent ($url)
{
	echo '<script>parent.location.href = "'.$url.'"</script>';
}

function href_parent_ext ($url)
{
	echo '<script>history.back(-1);parent.location.href = "'.$url.'";</script>';
	exit;
}


function alert_href ($str,$url)
{
	echo '<script>alert("'.$str.'");location.href = "'.$url.'"</script>';
}

function alert($str)
{
	echo '<script>alert("'.$str.'")</script>';
}

function showAlert_href ($str,$url)
{
	echo '<script>function go_url(){parent.location.href = "'.$url.'";}
	parent.showAlert("'.$str.'",go_url);
	</script>';
}
function showAlert ($str)
{
	echo '<script>parent.showAlert("'.$str.'")</script>';
}

?>