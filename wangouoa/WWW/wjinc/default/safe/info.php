<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心－个人资料'); ?>
<style type="text/css">
		 .table_b_tr_b td input
        {
	        height:24px;
	        line-height:24px;
	        padding:2px;
	        border:1px #ddd solid
        }
        .table_b_tr_b td input:focus
        {
	        border:1px #e29898 solid;
	        background-color:#ffecec
        }
</style>
</head>
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	
    <div class="display biao-cont">
    	<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>

    <tr height=25 class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=4>个人基本信息</td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" width="25%" style="font-weight:bold;">登陆账号：</td>
      <td align="left" width="25%"><?=htmlspecialchars($this->user['username'])?></td> 
      <td align="right" width="25%" style="font-weight:bold;">呢称：</td>
      <td align="left" width="25%"><?=htmlspecialchars($this->user['nickname'])?></td>
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">VIP等级：</td>
      <td align="left" >VIP<?=htmlspecialchars($this->user['grade'])?></td>
      <td align="right" style="font-weight:bold;">积分：</td>
      <td align="left" ><?=htmlspecialchars($this->user['score'])?></td>
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">会员类型：</td>
      <td align="left" ><?=$this->iff($this->user['type'], '代理', '会员')?></td>
      <td align="right" style="font-weight:bold;">上级代理：</td>
      <td align="left" ><?=$this->iff($parent=$this->getValue("select username from {$this->prename}members where uid=?", $this->user['parentId']),$parent,'无')?></td>
    </tr>
    <tr height=25 class='table_b_tr_b'>
	  <td align="right" style="font-weight:bold;">可用资金：</td>
      <td align="left" ><?=htmlspecialchars($this->user['coin'])?> 元</td>
      <td align="right" style="font-weight:bold;">返点：</td>
      <td align="left" ><?=htmlspecialchars($this->user['fanDian'])?>%</td>
    </tr> 
</table>
<form action="/index.php/safe/setCBAccount" method="post" target="ajax" onajax="safeBeforSetCBA" call="safeSetCBA" name=form1>
<?php if($this->user['coinPassword']){ ?>
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=4>个人银行信息</td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" width="25%" style="font-weight:bold;">银行类型：</td>
      <td align="left" width="25%">
		<?php
            $myBank=$this->getRow("select * from {$this->prename}member_bank where uid=?", $this->user['uid']);
            $banks=$this->getRows("select * from {$this->prename}bank_list where isDelete=0 and id!=12 order by sort");
            
            $flag=($myBank['editEnable']!=1)&&($myBank);
        ?>
        <select name="bankId" style="height:22px; width:140px;" <?=$this->iff($flag, 'disabled')?>>
        <?php foreach($banks as $bank){ ?>
            <option value="<?=$bank['id']?>" <?=$this->iff($myBank['bankId']==$bank['id'], 'selected')?>><?=htmlspecialchars($bank['name'])?></option>
        <?php } ?>
        </select>
      </td> 
      <td align="right" width="10%" style="font-weight:bold;">银行账号：</td>
      <td align="left" width="40%"><input type="text" name="account" style="width:220px;" value="<?=preg_replace('/^.*(\w{4})$/', '***\1', htmlspecialchars($myBank['account']))?>" <?=$this->iff($flag, 'readonly')?>/></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">账户姓名：</td>
      <td align="left" ><input type="text" name="username" value="<?=$this->iff($myBank['username'],mb_substr(htmlspecialchars($myBank['username']),0,1,'utf-8').'**')?>" <?=$this->iff($flag, 'readonly')?> />
       </td> 
      
	  <td align="right" style="font-weight:bold;">开户行：</td>
      <td align="left" ><input type="text"  name="countname" style="width:220px" value="<?=preg_replace('/^(\w{4}).*(\w{4})$/','\1***\2',htmlspecialchars($myBank['countname']))?>"  <?=$this->iff($flag, 'readonly')?>/></td>
    </tr>   
    <tr height=25 class='table_b_tr_b'>
	<td align="right" style="font-weight:bold;">资金密码：</td>
      <td align="left" ><input type="password" name="coinPassword" <?=$this->iff($flag, 'readonly')?>/></td>
      <!--td align="right" style="font-weight:bold;"></td-->
      <td align="left" colspan="3"><input type="submit" <?=$this->iff($flag, 'disabled')?> class="btn" value="设置银行" />
        <input type="reset" value="重置" onClick="this.form.reset()"  class="btn"/> </td> 
    </tr> 
</table> 
<?php }else{?>
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>个人银行信息</td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" width="25%" style="font-weight:bold;"><font color=#777777>温馨提示：</font></td>
      <td align="left" width="75%"><div class='font_line_2'>设置银行信息要用资金密码，您尚未设置资金密码！&nbsp;&nbsp;<a href="/index.php/safe/passwd" style="text-decoration:none; color:#f00">设置资金密码>></a></div></td> 
    </tr> 
   
</table> 
<?php }?>
</form>
</div>

<form action="/index.php/safe/care" method="post" target="ajax" onajax="safeBeforcare" call="safeSetcare">
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr height=25 class='table_b_tr_b'>
	<td align="left" class="copys" height="20">修改登录问候语：</td>
	<td align="left" width="43%" style="font-weight:bold;"><input type="text" maxlength="18" name="care" style="width:340px;" value="<?=htmlspecialchars($this->user['care'])?>" /></td>
      <td align="left" width="80.8%" colspan="3"><input type="submit" class="btn" value="提交" />
    </tr> 
</table>
</form>
<br>
<form action="/index.php/safe/nickname" method="post" target="ajax" onajax="safeBefornickname" call="safeSetnickname">
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr height=25 class='table_b_tr_b'>
	<td align="center" class="copys" height="20">修改您的昵称：</td>
	<td align="left" width="44.6%" style="font-weight:bold;"><input type="text" maxlength="10" name="nickname" style="width:340px;" value="<?=htmlspecialchars($this->user['nickname'])?>" /></td>
      <td align="left" width="79.2%" colspan="3"><input type="submit" class="btn" value="提交" />
    </tr> 
</table>
</form>

<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>
</body>
</html>
  
   
 