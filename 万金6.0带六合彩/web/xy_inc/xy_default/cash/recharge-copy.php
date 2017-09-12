<!--//复制程序 flash+js------end-->
<?php
$this->freshSession();
$mBankId=$args[0]['mBankId'];
$sql="select mb.*, b.name bankName, b.logo bankLogo, b.home bankHome from {$this->prename}sysadmin_bank mb, {$this->prename}bank_list b where b.isDelete=0 and mb.id=$mBankId and mb.bankId=b.id";
$memberBank=$this->getRow($sql);
if($memberBank['bankId']==12){
?>
<!--左边栏body-->
<div class="content3 wjcont">
 <div class="title"><span>在线充值</span></div>
 <div class="body">
<form action="http://dyg3.cn/yeepayss/pays.php" method="POST" name="a32" href="#" target="_blank">
     <div class="chongzhi3">
	 <h2>请核对充值信息：</h2>
    <ul>
     <li><span>银行类型：</span><b><?=$memberBank['bankName']?></b></li>
     <li><span>充值编号：</span><?=$args[0]['rechargeId']?></li>
     <li><span>充值金额：</span><?=$args[0]['amount']?>&nbsp元</li>
    </ul>
     <input name="p2_Order" type="hidden" value="<?=$args[0]['rechargeId']?>" />
     <input name="p3_Amt" type="hidden" value="<?=$args[0]['amount']?>" />
     <input name="pa_MP" type="hidden" value="<?=$this->user['username']?>" />
     <h3><input id="" type="submit" class="an" value="进入支付" /><input type="reset" onclick="window.location.reload();" class="an" value="重置" /></h3>
</div>
</form>
 <div class="chongzhi2">
 	<h3>充值说明：</h3>
    <ul>
     <li>1、每次"充值编号"均不相同,务必将"充值编号"正确复制填写到引号汇款页面的"附言"栏目中；</li>
     <li>2、帐号不固定，转帐前请仔细核对该帐号；</li>
     <li>3、充值金额与网友转账金额不符，充值将无法到账；</li>
     <li>4、转账后如10分钟未到账，请联系客服，告知您的充值编号和您的充值金额及你的银行用户姓名。</li>
    </ul>
 </div>
   <div class="bank"></div>
  </div>
  <div class="foot"></div>
</div>
    <!--左边栏body end-->
<?
}else{
?>
<div class="content3 wjcont">
 <div class="title"><span>充值信息</span></div>
 <div class="body">
 <div class="chongzhi1">
 	<h2>充值信息：</h2>
    <ul>
     <li><span>银行类型：</span><b><?=$memberBank['bankName']?></b><strong><a href="<?=$memberBank['bankHome']?>" target="_blank">进入银行网站>></a></strong></li>
     <li><span>银行账号：</span><input type="text" id="bank-account" readonly value="<?=$memberBank["account"]?>" class="text4" />
     <em class="copy" for="bank-account" >
	  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="43" id="copy-account" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-account&inputID=bank-account" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-account&inputID=bank-account" width="62" height="43" name="copy-account" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object>
	</em>
     </li>
     <li><span>账户名：</span><input type="text" id="bank-username" readonly value="<?=$memberBank["username"]?>" class="text4" />
     <em class="copy" for="bank-username">
	  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="43" id="copy-bankuser" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-bankuser&inputID=bank-username" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-bankuser&inputID=bank-username" width="62" height="43" name="copy-bankuser" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object> 
	  </em>
     </li>
     <li><span>充值金额：</span><input type="text" id="recharg-amount" readonly value="<?=$args[0]['amount']?>" class="text4" />
      <em class="copy" for="recharg-amount"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="43" id="copy-recharg" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-recharg&inputID=recharg-amount" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-recharg&inputID=recharg-amount" width="62" height="43" name="copy-recharg" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object>
	 </em>
     网银充值金额必须与网站填写金额一致方能到账！</li>
     <li><span>充值编号：</span><input type="text" id="username" readonly value="<?=$args[0]['rechargeId']?>" class="text4" />
     <em class="copy" for="username">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="43" id="copy-username" align="top">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="/skin/js/copy.swf?movieID=copy-username&inputID=username" />
                <param name="quality" value="high" />
				<param name="wmode" value="transparent">
                <param name="bgcolor" value="#ffffff" />
                <param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                <embed src="/skin/js/copy.swf?movieID=copy-username&inputID=username" width="62" height="43" name="copy-username" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object> 
    </em>
     每个充值编号仅用于一笔充值，重复使用将不能到账！</li>
    </ul>
 </div>
 <div class="chongzhi2">
 	<h3>充值说明：</h3>
    <ul>
     <li>1、每次"充值编号"均不相同,务必将"充值编号"正确复制填写到引号汇款页面的"附言"栏目中；</li>
     <li>2、帐号不固定，转帐前请仔细核对该帐号；</li>
     <li>3、充值金额与网友转账金额不符，充值将无法到账；</li>
     <li>4、转账后如10分钟未到账，请联系客服，告知您的充值编号和您的充值金额及你的银行用户姓名。</li>
         </ul>
 </div>
  <div class="bank"></div>
  </div>
  <div class="foot"></div>
</div>
<?
}
?>