<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=admin&c=point_setting&a=add" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<th><?php echo L('name_cn')?>：</th>
			<td><input type="text" name="info[name_cn]" id="name_cn" class="input-text" value=""></td>
		</tr>
		<tr>
			<th><?php echo L('name_en')?>：</th>
			<td><input type="text" name="info[name_en]" id="name_en" class="input-text" value=""></td>
		</tr>
		<tr>
			<th><?php echo L('value')?>：</th>
			<td><input type="text" name="info[value]" id="value" class="input-text" value=""></td>
		</tr>
		<tr>
			<th><?php echo L('note')?>：</th>
			<td>
				<textarea name="info[note]" maxlength="255" style="width:300px;height:60px;"><?php echo $data['note'];?></textarea>
			</td>
		</tr>
	</table>
</fieldset>
<div class="bk15"></div>
    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>