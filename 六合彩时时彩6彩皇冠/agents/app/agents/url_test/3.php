<?php
function fun(&$mp,$m,$l)
{
	//print_r($mp);
	$mp[$m-1]=$mp[$m-1]+1;
	for($i=$m-1;$i>=0;$i--)
	{
		echo "<br>";
		echo $mp[$i]."--1<br>";
		echo $l-$m+1+$i-1;
		echo "--2<br>";
		echo "=============";
		if($mp[$i]>($l-$m+$i))
		{
			if($i==0)
			{
				return false;
			}
			$mp[$i-1]=$mp[$i-1]+1;
			for($j=$i;$j<$m;$j++)
			{
				$mp[$j]=$mp[$j-1]+1;
			}
		}
	}
	//print_r($mp);
	return true;
}

$a=array(1,2,3,4,5,6);
$m=4;

$l=count($a);

if($m>$l+1)
{
	echo "不能超过$L";
}

$nsp=1;
for($i=0;$i<$m;$i++)
{
	$nsp=$nsp*($l+2-$i);
	$nsp=$nsp/($m+1-$i);
}
//echo $nsp+1;
$s=array();
$mp=array();
for($i=0;$i<$m;$i++)
{
	$mp[]=$i;
	$s[0]=$s[0].$a[$mp[$i]];
}
//echo count($mp);
$sp=1;
$tt=fun(&$mp,$m,$l);
while($tt)
{
	for($i=0;$i<$m;$i++)
	{
		$s[$sp]=$s[$sp].$a[$mp[$i]];
		//echo $a[$mp[$i]]."-";
	}
	$sp=$sp+1;
	$tt=fun($mp,$m,$l);
}
print_r($s);

?>