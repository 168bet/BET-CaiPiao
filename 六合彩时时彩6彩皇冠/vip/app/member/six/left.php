<?
session_start();
echo "<script language=\"javascript\">";
echo "location.href='../select.php?uid=".$_SESSION['Oid']."&langx=zh-cn';";
echo "</script>";
exit;
?>