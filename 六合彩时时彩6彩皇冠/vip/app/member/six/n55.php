<? 
if(!defined('PHPYOU')) {
	exit('非法进入');
}


if ($_GET['class2']==""){echo "<script>alert('非法进入!');parent.parent.mem_order.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>"; 
exit;}
?>

 <link href="imgs/loto_lb.css" rel="stylesheet" type="text/css">
<LINK href="imgs/left.css" type=text/css rel=stylesheet>
<SCRIPT type=text/javascript>window.history.forward(1); //禁止后退</SCRIPT>
<SCRIPT src="imgs/L_ShortcutJeu_n5.js" type=text/javascript></SCRIPT>
</head>

<body>
<?


$ids=@iconv("utf-8","gbk//IGNORE",$_GET['ids']);
if ($ids==""){$ids="特A";}
switch($ids){
	case "特A":
		$Purl="index.php?action=n5&class2=$ids";
	break;	
	case "特B":
		$Purl="index.php?action=n5&class2=$ids";
	break;
	case "正A":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正B":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正1特":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正2特":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正3特":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正4特":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正5特":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	case "正6特":
		$Purl="index.php?action=n4&class2=$ids";
	break;
	default:
		$Purl="index.php?action=n5&class2=$ids";
	break;										
}

?>
<form action="<?=$Purl ?>" method="post" name="L_JeuForm"  id="L_JeuForm"  onSubmit="return Check_Submit(this);" >
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>
  <TBODY>
  <TR>
    <TD class="Left_Place"  vAlign=top height=400 >
      <TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
        <TBODY>
			<TR>
          <TD class=t_td_caption_1 width=64>帐户名称</TD>
          <TD class=t_td_text width=137><?=ka_memuser("kauser") ?>(<?=ka_memuser("abcd")?>盘)</TD></TR>
        <TR>
          <TD class=t_td_caption_1>信用额度</TD>
          <TD class=t_td_text><?=ka_memuser("cs")?> (RMB)</TD></TR>
        <TR>
          <TD class=t_td_caption_1>可用金额</TD>
          <TD class=t_td_text id=Money_KY><?=ka_memuser("ts")?></TD></TR>
        <TR>
         <TR>
          <TD  colspan=2> <table width="100%" border="0" cellpadding="4" cellspacing="1" bordercolor="#cccccc" bgcolor="#cccccc">
          <tr>
            <td height="20" align="center" bgcolor="#5A79C6"><font color="#FFFFFF"><b>快速投注</b></font></td>
          </tr>
        </table></TD> 
        <TR>
       
          <TD class=t_td_odd_1 colSpan=2 height=200>
            <TABLE class=s_list cellSpacing=1 cellPadding=0 width="100%" 
            border=1>
              <TBODY>
              <TR>
                <TD class=s_td_0 id=S_1>&nbsp; </TD>
                <TD class=s_td_0 id=S_11>&nbsp; </TD>
                <TD class=s_td_0 id=S_21>&nbsp; </TD>
                <TD class=s_td_0 id=S_31>&nbsp; </TD>
                <TD class=s_td_0 id=S_41>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_2>&nbsp; </TD>
                <TD class=s_td_0 id=S_12>&nbsp; </TD>
                <TD class=s_td_0 id=S_22>&nbsp; </TD>
                <TD class=s_td_0 id=S_32>&nbsp; </TD>
                <TD class=s_td_0 id=S_42>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_3>&nbsp; </TD>
                <TD class=s_td_0 id=S_13>&nbsp; </TD>
                <TD class=s_td_0 id=S_23>&nbsp; </TD>
                <TD class=s_td_0 id=S_33>&nbsp; </TD>
                <TD class=s_td_0 id=S_43>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_4>&nbsp; </TD>
                <TD class=s_td_0 id=S_14>&nbsp; </TD>
                <TD class=s_td_0 id=S_24>&nbsp; </TD>
                <TD class=s_td_0 id=S_34>&nbsp; </TD>
                <TD class=s_td_0 id=S_44>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_5>&nbsp; </TD>
                <TD class=s_td_0 id=S_15>&nbsp; </TD>
                <TD class=s_td_0 id=S_25>&nbsp; </TD>
                <TD class=s_td_0 id=S_35>&nbsp; </TD>
                <TD class=s_td_0 id=S_45>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_6>&nbsp; </TD>
                <TD class=s_td_0 id=S_16>&nbsp; </TD>
                <TD class=s_td_0 id=S_26>&nbsp; </TD>
                <TD class=s_td_0 id=S_36>&nbsp; </TD>
                <TD class=s_td_0 id=S_46>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_7>&nbsp; </TD>
                <TD class=s_td_0 id=S_17>&nbsp; </TD>
                <TD class=s_td_0 id=S_27>&nbsp; </TD>
                <TD class=s_td_0 id=S_37>&nbsp; </TD>
                <TD class=s_td_0 id=S_47>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_8>&nbsp; </TD>
                <TD class=s_td_0 id=S_18>&nbsp; </TD>
                <TD class=s_td_0 id=S_28>&nbsp; </TD>
                <TD class=s_td_0 id=S_38>&nbsp; </TD>
                <TD class=s_td_0 id=S_48>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_9>&nbsp; </TD>
                <TD class=s_td_0 id=S_19>&nbsp; </TD>
                <TD class=s_td_0 id=S_29>&nbsp; </TD>
                <TD class=s_td_0 id=S_39>&nbsp; </TD>
                <TD class=s_td_0 id=S_49>&nbsp; </TD></TR>
              <TR>
                <TD class=s_td_0 id=S_10>&nbsp; </TD>
                <TD class=s_td_0 id=S_20>&nbsp; </TD>
                <TD class=s_td_0 id=S_30>&nbsp; </TD>
                <TD class=s_td_0 id=S_40>&nbsp; </TD>
                <TD class=s_td_0>&nbsp; </TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD class=t_td_odd_1 colSpan=2><A onclick=ChoiceNO_S(0) 
            href="javascript:void(0)"><SPAN 
            class=Font_R>红波</SPAN></A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(1) 
            href="javascript:void(0)"><SPAN 
            class=Font_B>蓝波</SPAN></A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(2) 
            href="javascript:void(0)"><SPAN 
            class=Font_G>绿波</SPAN></A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(3) 
            href="javascript:void(0)">单</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(4) 
            href="javascript:void(0)">双</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(5) 
            href="javascript:void(0)">大</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(6) 
            href="javascript:void(0)">小</A><BR><A onclick=ChoiceNO_S(7) 
            href="javascript:void(0)">合数单</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(8) 
            href="javascript:void(0)">合数双</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_IR() 
            href="javascript:void(0)"><B>反选</B></A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_C() href="javascript:void(0)"><B>取消</B></A><BR><A 
            onclick=ChoiceNO_S(23) 
            href="javascript:void(0)">大单</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(24) 
            href="javascript:void(0)">小单</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(25) 
            href="javascript:void(0)">大双</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(26) href="javascript:void(0)">小双</A><BR><A 
            onclick=ChoiceNO_S(9) 
            href="javascript:void(0)">鼠</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(10) 
            href="javascript:void(0)">牛</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(11) 
            href="javascript:void(0)">虎</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(12) 
            href="javascript:void(0)">兔</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(13) 
            href="javascript:void(0)">龙</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(14) href="javascript:void(0)">蛇</A><BR><A 
            onclick=ChoiceNO_S(15) 
            href="javascript:void(0)">马</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(16) 
            href="javascript:void(0)">羊</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(17) 
            href="javascript:void(0)">猴</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(18) 
            href="javascript:void(0)">鸡</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(19) 
            href="javascript:void(0)">狗</A>&nbsp;&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(20) href="javascript:void(0)">猪</A><BR><A 
            onclick=ChoiceNO_S(39) 
            href="javascript:void(0)">尾大</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(40) 
            href="javascript:void(0)">尾小</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(21) 
            href="javascript:void(0)">家禽</A>&nbsp;&nbsp;<A 
            onclick=ChoiceNO_S(22) 
            href="javascript:void(0)">野兽</A>&nbsp;&nbsp;<A onclick=But_MoreSet() 
            href="javascript:void(0)"><B><SPAN class=Font_R>更多</SPAN></B></A> 
            <DIV id=MoreSet style="DISPLAY: none"><A onclick=ChoiceNO_S(27) 
            href="javascript:void(0)"><SPAN 
            class=Font_R>红</SPAN>大</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(28) 
            href="javascript:void(0)"><SPAN 
            class=Font_R>红</SPAN>小</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(29) 
            href="javascript:void(0)"><SPAN 
            class=Font_R>红</SPAN>单</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(30) 
            href="javascript:void(0)"><SPAN class=Font_R>红</SPAN>双</A><BR><A 
            onclick=ChoiceNO_S(31) href="javascript:void(0)"><SPAN 
            class=Font_B>蓝</SPAN>大</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(32) 
            href="javascript:void(0)"><SPAN 
            class=Font_B>蓝</SPAN>小</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(33) 
            href="javascript:void(0)"><SPAN 
            class=Font_B>蓝</SPAN>单</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(34) 
            href="javascript:void(0)"><SPAN class=Font_B>蓝</SPAN>双</A><BR><A 
            onclick=ChoiceNO_S(35) href="javascript:void(0)"><SPAN 
            class=Font_G>绿</SPAN>大</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(36) 
            href="javascript:void(0)"><SPAN 
            class=Font_G>绿</SPAN>小</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(37) 
            href="javascript:void(0)"><SPAN 
            class=Font_G>绿</SPAN>单</A>&nbsp;&nbsp;<A onclick=ChoiceNO_S(38) 
            href="javascript:void(0)"><SPAN 
          class=Font_G>绿</SPAN>双</A><BR></DIV></TD></TR>
        <TR>
          <TD class=t_td_caption_1>下注金额</TD>
          <TD class=t_td_text><INPUT class=inp1 onkeypress=digitOnly(event) 
            onblur="this.className='inp1';Ref_JeuInfo();" style="LEFT: 1px; POSITION: relative" 
            onfocus="this.className='inp1m'" maxLength=14 size=9 
            name=JeuMoney></TD></TR>
        <TR>
          <TD class=t_td_caption_1>总下注额</TD>
          <TD class="t_td_text font_r"><SPAN 
            id=Sum_Jeu_XZ>0</SPAN>&nbsp;/&nbsp;<SPAN 
            id=Count_Jeu_XZ>0</SPAN>&nbsp;笔</TD></TR>
        <TR>
          <TD class="t_td_caption_1 Font_B" id=confirm_clew colSpan=2 height=32><INPUT onClick="window.open('index.php?action=left','_self')" type=button value="退 出" name=reset>&nbsp;&nbsp;<INPUT style="COLOR: #ff0000" type=submit value=确定下注 name=confirm></TD></TR>
        
</TBODY></TABLE></TD></TR></TBODY></TABLE>
                              <?
		for ($i=1;$i<=49;$i=$i+1){
		
		if ($i<=9) {$p=$i;}else{$p=$i;}?>
		 <input name="t<?=$p?>" type="hidden" id="t<?=$p?>" value="">
		<? } ?>
                              <input name="tnumber" type="hidden" id="tnumber2" value="a">
                              <input name="sred" type="hidden" id="sred" />
                              <input name="sgreen" type="hidden" id="sgreen" />
                              <input name="sblue" type="hidden" id="sblue" />
                              <input name="sblue8" type="hidden" id="sblue8" />
                              <input name="sblue9" type="hidden" id="sblue9" />
                              <input name="sblue10" type="hidden" id="sblue10" />
                              <input name="sblue11" type="hidden" id="sblue11" />
                              <input name="sgreen12" type="hidden" id="sgreen12" />
                              <input name="sgreen13" type="hidden" id="sgreen13" />
                              <input name="sgreen14" type="hidden" id="sgreen14" />
                              <input name="sgreen15" type="hidden" id="sgreen15" />
                              <input name="sred4" type="hidden" id="sred4" />
                              <input name="sred5" type="hidden" id="sred5" />
                              <input name="sred6" type="hidden" id="sred6" />
                              <input name="sred7" type="hidden" id="sred7" />
                              <input name="s1" type="hidden" id="s1" />
                              <input name="n2" type="hidden" id="n2" />
                              <input name="h3" type="hidden" id="h3" />
                              <input name="l5" type="hidden" id="l5" />
                              <input name="c6" type="hidden" id="c6" />
                              <input name="m7" type="hidden" id="m7" />
                              <input name="y8" type="hidden" id="y8" />
                              <input name="h9" type="hidden" id="h9" />
                              <input name="j10" type="hidden" id="j10" />
                              <input name="g11" type="hidden" id="g11" />
                              <input name="z12" type="hidden" id="z12" />
                              <input name="ns" type="hidden" id="ns" value="0" />

</form>
<SCRIPT language=javascript>
t_LT = "1";
t_GT = "2";
inceptMID =50;

//alert("ff");
//var tNO_s[];//后加
//var tNO_s=new Array();
tNO_s[9]=new String('04,16,28,40').split(',');
 tNO_s[10]=new String('03,15,27,39').split(',');
 tNO_s[11]=new String('02,14,26,38').split(',');
 tNO_s[12]=new String('01,13,25,37,49').split(',');
 tNO_s[13]=new String('12,24,36,48').split(',');
 tNO_s[14]=new String('11,23,35,47').split(',');
 tNO_s[15]=new String('10,22,34,46').split(',');
 tNO_s[16]=new String('09,21,33,45').split(',');
 tNO_s[17]=new String('08,20,32,44').split(',');
 tNO_s[18]=new String('07,19,31,43').split(',');
 tNO_s[19]=new String('06,18,30,42').split(',');
 tNO_s[20]=new String('05,17,29,41').split(',');


LoadJeuTab();
</SCRIPT>
</script>

</body>
</html>
