/*

	表单验证脚本文件 
*/

//验证规则
var rules = {
		username: {
			required: true,
			remote: {

					//后台处理程序
					url:APP_PATH + 'index.php?m=member&c=index&a=public_validate',

					// 数据发送方式
					type: 'post',

					// 接收数据格式
					dataType:'json',

					// 传递的数据
					data:{

						username:function(){
							return $('[name="username"]').val();
						},
						field: 'username'
					},

					dataFilter: function (data, type) {
						return data ? true : false;
					}
				},
			minlength: 4,
			maxlength: 20
		},
		password: {
			required: true,
			minlength: 6
		},
		confirm_password: {
			required: true,
			equalTo: '#password'
		},
		mobile: {
			required: true,
			phone: true,
			remote: {

				//后台处理程序
				url:APP_PATH + 'index.php?m=member&c=index&a=public_validate',

				// 数据发送方式
				type: 'post',

				// 接收数据格式
				dataType:'json',

				// 传递的数据
				data:{

					mobile:function(){
						return $('[name="mobile"]').val();
					},
					field: 'mobile'
				},

				dataFilter: function (data, type) {
					return data ? true : false;
				}
			}
		},
		phone:{
			required: true,
			phone:true
		},
		tel: {
			telphone: true
		},
		number:{
			number:true
		},
		street: {
			zh_char: true
		},
		//captcha:{
		//	required:true
		//},
		email: {
			remote: {

				//后台处理程序
				url:APP_PATH + 'index.php?m=member&c=index&a=public_validate',

				// 数据发送方式
				type: 'post',

				// 接收数据格式
				dataType:'json',

				// 传递的数据
				data:{

					email:function(){
						return $('[name="email"]').val();
					},
					field: 'email'
				},

				dataFilter: function (data, type) {
					return data ? true : false;
				}
			}
		},

		agree:'required'
	},
	// 错误信息
	messages = {

		username: {
			required: '请输入用户名',
			minlength: '字符不能少于4位',
			maxlength: '字符不能大于20位',
			remote: '该用户名已注册'
		},
		password: {
			required: '请输入密码',
			minlength: '字符不能少于6位'
		},
		confrim_password: {
			required: '请再次确认密码',
			equalTo: '两次密码不一致'
		},
		mobile: {
			required: '请输入手机号',
			remote: '该手机号已被人使用'
		},
		
		agree:{
			required:'请务必同意协议'
		},
		email: {
			remote: '该邮箱已被人使用'
		}

	};



//自定义验证规则

$.validator.addMethod('phone', function(value, elem, param) {

	var phone = /^0?1(3|4|5|7|8)\d{9}$/;

	return this.optional(elem) || (phone.test(value));


}, '请输入正确的手机号码');

$.validator.addMethod('telphone', function(value, elem, param) {

	var telphone = /^((0(10|2[1-3]|[3-9]\d{2}))?[1-9]\d{6,7})$/;

	return this.optional(elem) || (telphone.test(value));


}, '请输入正确的固定电话');

$.validator.addMethod('zh_char', function(value, elem, param) {

	var zh_char = /([\u4e00-\u9fa5]{2,4})/;

	return this.optional(elem) || (zh_char.test(value));


}, '请确保地址中有汉字');

$.validator.addMethod('number', function(value, elem, param) {

	var isnumber = /^[0-9]$/;

	return this.optional(elem) || (isnumber.test(value));


}, '请输入数字');