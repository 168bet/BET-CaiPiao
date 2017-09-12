<!--//复制程序 flash+js------end-->

<?php
$mBankId=$args[0]['mBankId'];
$sql="select mb.*, b.name bankName, b.logo bankLogo, b.home bankHome from {$this->prename}sysadmin_bank mb, {$this->prename}bank_list b where mb.id=$mBankId and b.isDelete=0 and mb.bankId=b.id";
$memberBank=$this->getRow($sql);
if($mBankId==267){
?>
<!--左边栏body-->
 <style>
#bankList{ padding:0px 0px 0px 0px;}
#bankList .li{ float:left; width:110px; height:20px; padding:5px 0px; margin:0px 3px 0px 3px; }
#bankList .li input { float:left; margin:2px 5px 0px; width:auto; padding:0px;}
#bankList .li span{ float:left; margin:3px 0px 0px 0px; width:60px;}
.banklogo input{height:15px; width:15px}
.banklogo{}
</style>  
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>充值信息</td> 
    </tr>
    
    <tr height=25 class='table_b_tr_b' >
      <td align="right" style="font-weight:bold;" height="80">银行类型：</td>
      <td align="left" ><img id="bank-type-icon" class="bankimg" src="/<?=$memberBank['bankLogo']?>" title="<?=$memberBank['bankName']?>" /></td> 
    </tr>
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">充值金额：</td>
      <td align="left" ><input id="recharg-amount" readonly value="<?=$args[0]['amount']?>" />
      </td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left" > <div class="spn12">*网银充值金额必须与网站填写金额一致方能到账！</div></td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"><div style="width:100px;">充值编号：</div></td>
      <td align="left"><input id="username" readonly value="<?=$args[0]['rechargeId']?>" />
			</td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold; padding-top:15px;" valign="top">选择付款银行：</td>
      <td align="left" >
      <form action="/epay/pays.php" method="POST" name="a32" href="#" target="_blank">
     <div class="chongzhi3">
	 <h2>请核对充值信息：</h2>
    <ul>
     <li><span>银行类型：</span><b><?=$memberBank['bankName']?></b></li>
     <li><span>充值编号：</span><?=$args[0]['rechargeId']?></li>
     <li><span>充值金额：</span><?=$args[0]['amount']?>&nbsp;元</li>
     <li style="height:auto;">
     	<span style="float:left;">付款银行：</span>
     	<div style="float:left; width:600px;" id="bankList">
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="ICBC" checked="checked" /><span>工商银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="ABC" /><span>农业银行</span></label></div>
    
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="CCB" /><span>建设银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="CEB" /><span>光大银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="CMB" /><span>招商银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="BCM" /><span>交通银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="CIB" /><span>兴业银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="CITIC" /><span>中信银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="GDB" /><span>广发银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="PAB" /><span>平安银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="PSBC" /><span>中国邮政</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="SPDB" /><span>浦发银行</span></label></div>
        <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="BOC" /><span>中国银行</span></label></div>
        
         <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="CMBC" /><span>民生银行</span></label></div>
         <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="BOS" /><span>上海银行</span></label></div>
         <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="HXB" /><span>华夏银行</span></label></div>
      <div class="li"><label><input type="radio" style="width:auto; padding:0px;" name="bankco" value="BCCB" /><span>北京银行</span></label></div>
        
        <div style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>
     </li>
    </ul>
    
     <input name="p2_Order" type="hidden" value="<?=$args[0]['rechargeId']?>" />
     <input name="p3_Amt" type="hidden" value="<?=$args[0]['amount']?>" />
     <input name="pa_MP" type="hidden" value="<?=$this->user['username']?>" />
     <h3><input id="" type="submit" class="an" value="进入支付" /><input type="reset" onClick="window.location.reload();" class="an" value="重置" /></h3>
</div>
</form>
      </td> 
    </tr>
    </table> 


<div class="tips">
	<dl>
        <dt>充值说明：</dt>
        <dd>1.每次"充值编号"均不相同,务必将"充值编号"正确复制填写到引号汇款页面的"附言"栏目中;</dd>
        <dd>2.帐号不固定，转帐前请仔细核对该帐号;</dd>
        <dd>3.充值金额与网友转账金额不符，充值将无法到账;</dd>
        <dd>4.转账后如10分钟未到账，请联系客服，告知您的充值编号和您的充值金额及你的银行用户姓名。</dd>
    </dl>
</div>
<?php
}else{
?>
<!--左边栏body-->
   
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>充值信息</td> 
    </tr>
    
    <tr height=25 class='table_b_tr_b' >
      <td align="right" style="font-weight:bold;" height="80">银行类型：</td>
      <td align="left" ><img id="bank-type-icon" class="bankimg" src="/<?=$memberBank['bankLogo']?>" title="<?=$memberBank['bankName']?>" />
            <a id="bank-link" target="_blank" href="<?=$memberBank['bankHome']?>" class="spn11" style="margin-left:50px;">进入银行网站>></a>
                            </td> 
    </tr>
    <tr height=25 class='table_b_tr_b' >
      <td align="right" style="font-weight:bold;" >银行账号：</td>
      <td align="left" ><input id="bank-account" readonly value="<?=$memberBank["account"]?>" />
	  <div class="btn-a copy" for="bank-account">
	  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-account" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-account&inputID=bank-account" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-account&inputID=bank-account" width="62" height="23" name="copy-account" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object>
		</div>
	  </td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">账户名：</td>
      <td align="left" ><input id="bank-username" readonly value="<?=$memberBank["username"]?>" />
	  <div class="btn-a copy" for="bank-username">
	  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-bankuser" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-bankuser&inputID=bank-username" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-bankuser&inputID=bank-username" width="62" height="23" name="copy-bankuser" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object> 
	  </div></td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">充值金额：</td>
      <td align="left" ><input id="recharg-amount" readonly value="<?=$args[0]['amount']?>" />
      <div class="btn-a copy" for="recharg-amount"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-recharg" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-recharg&inputID=recharg-amount" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-recharg&inputID=recharg-amount" width="62" height="23" name="copy-recharg" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object>
	 </div>
      </td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left" > <div class="spn12">*网银充值金额必须与网站填写金额一致方能到账！</div></td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">充值编号：</td>
      <td align="left"><input id="username" readonly value="<?=$args[0]['rechargeId']?>" />
         <div class="btn-a copy" for="username">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-username" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-username&inputID=username" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-username&inputID=username" width="62" height="23" name="copy-username" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object> 
            </div>
		
		
			</td> 
    </tr> 
<tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left" > <div class="spn12">*每个充值编号仅用于一笔充值，重复使用将不能到账！</div>	</td> 
    </tr>
   <?php if($memberBank["rechargeDemo"]){?>
   <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left" > <div class="example">充值图示：<div class="example2" rel="<?=$memberBank["rechargeDemo"]?>">查看</div></div></td> 
    </tr>
   <?php }?>
</table> 

</form>
<div class="tips">
	<dl>
        <dt>充值说明：</dt>
        <dd>1.每次"充值编号"均不相同,务必将"充值编号"正确复制填写到引号汇款页面的"附言"栏目中;</dd>
        <dd>2.帐号不固定，转帐前请仔细核对该帐号;</dd>
        <dd>3.充值金额与网友转账金额不符，充值将无法到账;</dd>
        <dd>4.转账后如10分钟未到账，请联系客服，告知您的充值编号和您的充值金额及你的银行用户姓名。</dd>
    </dl>
</div>
<?php
}
?>
