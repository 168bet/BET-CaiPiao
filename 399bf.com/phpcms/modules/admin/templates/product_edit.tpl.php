<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=admin&c=product&a=edit" method="post" id="myform">
	<input type="hidden" name="info[productid]" id="productid" value="<?php echo $data['productid']?>">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<th><?php echo L('name')?>：</th>
			<td><input type="text" name="info[name]" id="name" class="input-text" value="<?php echo $data['name'];?>"></td>
		</tr>
		<tr>
			<th><?php echo L('price')?>：</th>
			<td><input type="text" name="info[price]" id="price" class="input-text" value="<?php echo $data['price'];?>"></td>
		</tr>
		<tr>
			<th width="80"> <?php echo L('description');?>	  </th>
			<td>
				<textarea name="info[description]" id="description"><?php echo $data['description'];?></textarea>
				<?php echo form::editor('description','full','','','',1,1)?>
			</td>
		</tr>
		<tr>
			<th><?php echo L('picurl')?>：</th>
			<td><?php echo form::images('info[picurl]', 'picurl', $data['picurl'], 'content');?></td>
		</tr>
	</table>
</fieldset>
<div class="bk15"></div>
    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>