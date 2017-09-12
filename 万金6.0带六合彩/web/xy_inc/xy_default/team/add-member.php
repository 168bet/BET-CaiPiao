<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '添加会员－代理中心'); ?>
<script type="text/javascript">
function khao(fanDian){
	$('input[name=fanDian]').val(fanDian);
	return false;
}
</script>
</head> 
 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>添加会员</span></div>
 <div class="body">
 <div class="mima1">
	<form action="/index.php/team/insertMember" method="post" target="ajax" onajax="teamBeforeAddMember" call="teamAddMember">
 	<h2>新增成员：</h2>
    <ul>
     <li><span>账号类型：</span><label><input type="radio" name="type" value="1" title="代理" checked="checked" />代理</label>&nbsp;&nbsp;<label><input name="type" type="radio" value="0" title="会员" />会员</label></li>
     <li><span>用户名：</span><input type="text" name="username" class="text4" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" /></li>
     <li><span>密码：</span><input type="password" name="password" class="text4" /></li>
     <li><span>确认密码：</span><input type="password" id="cpasswd" class="text4" /></li>
     <li><span>联系QQ：</span><input type="text" name="qq" class="text4" /></li>
	 <li><span>返点：</span><input type="text" name="fanDian" class="text4" max="<?=$this->user['fanDian']?>" value=""  fanDianDiff=<?=$this->settings['fanDianDiff']?> onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" />0-<?=$this->iff(($this->user['fanDian']-$this->settings['fanDianDiff'])<=0,0,$this->user['fanDian']-$this->settings['fanDianDiff'])?>%</li>
	 <li><span>验证码：</span><input name="vcode" type="text" style="width:142px; height:22px; vertical-align:middle;"/><img width="58" height="24" border="0" style="cursor:pointer;margin-bottom:0px;" id="vcode" alt="看不清？点击更换" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></li>
     <li class="tijiao"><input id="addmenber" class="an" type="submit" value="增加成员" ><input type="reset" id="resetmenber" class="an" value="重置" onClick="this.form.reset()" /></li>
    </ul>
    </form>
    <div class="table_b">
						<?php
						$sql="select s.*, (select count(*) from {$this->prename}members m where m.parentId={$this->user['uid']} and m.fanDian=s.fanDian) registerUserCount from {$this->prename}params_fandianset s where s.fanDian<{$this->user['fanDian']}  order by s.fanDian desc";
						//echo $sql;
						if($data=$this->getRows($sql)){ ?>
                    	<table width="100%">
                        	<tr class="table_b_th">
								<td>返点</td>
								<!--td>不定位返点</td-->
								<td>注册人数</td>
								<td>剩余人数</td>
								<td>操作</td>
                            </tr>
							<?php foreach($data as $var){ if($var['userCount']-$var['registerUserCount']){?>
							<tr class="table_b_tr">
								<td><?=$var['fanDian']?></td>
								<!--td><?=$var['bFanDian']?></td-->
								<td><?=$var['registerUserCount']?></td>
								<td><?=$var['userCount']-$var['registerUserCount']?></td>
								<td>
									<?php if($var['userCount']-$var['registerUserCount']>0 or true){ ?>
										<a href="javascript:;" onclick="khao(<?=$var['fanDian']?>)">开号</a>
									<?php }else{ ?>
										--
									<?php } ?>
								</td>
							</tr>
							<?php } }?>
                        </table>
						
						<?php } ?>

                    </div>
</div>					
<div class="bank"></div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html> 