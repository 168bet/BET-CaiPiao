<?php
require_once 'conjunction.php';
require_once 'config.php';
if (ka_config("opwww")==1){
echo "<script>alert('对不起,系统维护中!');top.location.href='op.php';</script>"; 
exit;}
if(!defined('PHPYOU')) {
	exit('非法进入');
}




?>



<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #11BEF5;
	background-color: #FFFFFF;
	background-image:  url(imgs/inda_bk.gif);
}
body, td, th {
	font-size: 9pt;
}
.STYLE3 {
	color: #FFFFFF
}
a:link {
	color: #C67C01;
	text-decoration :none;
}
a:visited {
	color: #BC7501;
	text-decoration :none;
}
-->
</style>
</head>
<body text="#000000">
<table width="770" height="80" border="0" align="center" cellpadding="0" cellspacing="0" background="imgs/topbg.jpg">
  <tr>
    <td height="100">&nbsp;</td>
  </tr>
</table>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td align="center"><table bordercolor="#663300" cellspacing="2" cellpadding="2" width="85%" align="center" border="0">
        <tbody>
          <tr class="normal" bgcolor="#ffffff">
            <td style="LINE-HEIGHT: 23px"><TABLE cellSpacing=0 width="90%" align=center border=0 cellpading="0">
<TBODY>
<TR class=normal>
<TD vAlign=middle style="LINE-HEIGHT: 23px"><?=ka_config('a3')?></TD>
</TBODY>
</TABLE>
<TABLE class=ok-tab cellSpacing=0 cellPadding=0 width=90% align=center border=0>
<TBODY>

</TR>
</TBODY>
</TABLE>                                                                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center"><input name="submit" type="submit" style="width:80px" value="我不同意" onclick="javascript:location.href='index.php?action=logout'" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="submit2" type="submit" style="width:80px" value="我同意" onclick="javascript:location.href=''" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </tbody>
      </table>
  </tr>
</table>
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="35" align="center" bgcolor="#82B313"><font color="#1E4C97">版权所有 建议您以 IE6.0 1024*768 以上高彩模式浏览本站</font></td>
  </tr>
</table>


</BODY>
</HTML>