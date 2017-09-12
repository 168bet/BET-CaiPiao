<table cellpadding="0" cellspacing="0" width="320" class="layout">
<input type="hidden" value="<?=$this->user['username']?>" />
	<tr>
		<th>选择充值：</th>
		<td><label>用户名<input type="radio" name="user" value="2" checked="checked" /></label> <label>UserID<input type="radio" name="user" value="1" /></label></td>
	</tr>
	<tr>
		<th>用户名或UID:</th>
		<td><input type="text" name="uid" /></td>
	</tr>
	<tr>
		<th>充值金额：</th>
		<td><input type="text" name="amount" min="100" /><span style="color:#F00">负数为扣款！</span></td>
	</tr>
	<tr>
		<th><span class="spn9">提示：</span></th>
		<td><span class="spn9">第一栏填写用户名 或 用户ID均可充值</td></span>
	</tr>
</table>
