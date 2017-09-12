$(function(){

	//{{{ HTML标签扩展部分
	// A链接扩展
	/**
	 * AJAX链接
	 * target="ajax"：AJAX请求
	 * onajax：AJAX调用前触发，返回false时阻止
	 * call：AJAX完后触发，callback(err, data, xhr) this指向当前html元素，err当出错的时间有值，data为服务器返回值(解析过)，xhr为HttpRequest对象
	 * dataType：默认html，服务器响应类型，可用json，xml
	 */
	$('a[target=ajax]').live('click', function(){
		var $this	= $(this),
		self		= this,
		onajax		= window[$this.attr('onajax')],
		title		= $this.attr('title'),
		call		= window[$this.attr('call')];
		
		if(title && !confirm(title))
		 return false;
		
		if(typeof call!='function'){
			// 设置一个默认的响应回调
			call=function(){}
		}
		
		if('function'==typeof onajax){
			// 如果ajax请求前事件处理返回false
			// 则阻止后继事件
			try{
				if(onajax.call(this)===false) return false;
			}catch(err){
				call.call(self, err);
				return false;
			}
		}

		$.ajax({
			url:$this.attr('href'),
			
			// 异步请求
			async:true,
			
			// 把当前存储的数据做为参数传递
			data:$this.data(),
			
			// 默认用GET请求，也可以用method属性设置
			type:$this.attr('method')||'get',
			
			// dataType属性用于设置响应数据格式，默认html，可选json和xml
			dataType:$this.attr('dataType')||'html',
			
			error:function(xhr, textStatus, errThrow){
				// 据jQuery官方说，textStatus和errThrow中只有一个包括错误信息
				call.call(self, errThrow||textStatus);
			},
			
			success:function(data, textStatus, xhr, headers){
				var errorMessage=xhr.getResponseHeader('X-Error-Message');
				if(errorMessage){
					call.call(self, decodeURIComponent(errorMessage), data);
				}else{
					call.call(self, null, data);
				}
			}
		});
		
		return false;
	});
	
	// A弹出层打开链接
	/**
	 * target="modal"
	 * title="弹出层标题"
	 * width="弹出宽度"
	 * heigth=""
	 * modal=false
	 * buttons="确定:onsure|取消:oncancel"
	 * method="get"
	 */
	$('a[target=modal]').live('click', function(){
		var self=this,
		$self=$(self),
		title=$self.attr('title')||'',
		width=$self.attr('width')||'auto',
		heigth=$self.attr('heigth')||'auto',
		modal=($self.attr('modal')),
		method=$self.attr('method')||'get',
		buttons=$self.attr('button')||null;

		if(buttons) buttons=buttons.split('|').map(function(b){
			b=b.split(':');
			return {text:b[0], click:window[b[1]]};
		});
		
		$[method]($self.attr('href'), function(html){
			$(html).dialog({
				title:title,
				width:width,
				height:heigth,
				modal:modal,
				buttons:buttons
			});
		});
		
		return false;
	});
	
	// form扩展
	/**
	 * 简单AJAX表单
	 * target="ajax"：AJAX提交
	 * onajax：AJAX调用前触发，this指向from元素，返回false时阻止
	 * call：AJAX完后触发，callback(err, data, xhr) this指向当前html元素，err当出错的时间有值，data为服务器返回值(解析过)，xhr为HttpRequest对象
	 * 服务器响应类型为json
	 */
	$('form[target=ajax]').live('submit', function(){
		var data	= [], 
		$this		= $(this),
		self		= this,
		onajax		= window[$this.attr('onajax')],
		call		= window[$this.attr('call')];
		
		if(typeof call!='function'){
			// 设置一个默认的响应回调
			call=function(){}
		}
		
		if('function'==typeof onajax){
			// 如果ajax请求前事件处理返回false
			// 则阻止后继事件
			try{
				if(onajax.call(this)===false) return false;
			}catch(err){
				call.call(self, err);
				return false;
			}
		}

		$(':input[name]', this).each(function(){
			var $this=$(this),
			value=$this.data('value'),
			name=$this.attr('name');
			
			if($this.is(':radio, :checkbox') && this.checked==false) return true;
			
			if(value===undefined) value=this.value;
			
			data.push({name:name, value:value});
		});
		
		$.ajax({
			url:$this.attr('action'),
			
			// 异步请求
			async:true,

			data:data,
			
			// 默认用GET请求，也可以用method属性设置
			type:$this.attr('method')||'get',
			
			// dataType属性用于设置响应数据格式，默认json，可选html、json和xml
			dataType:$this.attr('dataType')||'json',
			
			headers:{"x-form-call":1},
			
			error:function(xhr, textStatus, errThrow){
				// 据jQuery官方说，textStatus和errThrow中只有一个包括错误信息
				call.call(self, errThrow||textStatus);
			},
			
			success:function(data, textStatus, xhr, headers){
				var errorMessage=xhr.getResponseHeader('X-Error-Message');
				if(errorMessage){
					call.call(self, decodeURIComponent(errorMessage), data);
				}else{
					call.call(self, null, data);
				}
			}
		});
		
		return false;
	});
	
	// 登录按Enter进入
	if(!$.browser.opera && !$.browser.mozilla){
		$('input[name=vcode]').live('keypress', function(event){
			if(event.keyCode==13){
				$(this.form).trigger('submit');
			}
		});
	}
	
	// 弹出层分页
	$('.ui-dialog .bottompage a').live('click', function(){
		var $this=$(this);
		$this.closest('.ui-dialog-content').load($this.attr('href'));
		return false;
	});
	////{{{系统提示 setInterval
	if(typeof(TIP)!='undefined' && TIP){
	setInterval(function(){
		reloadMemberInfo();
		$.getJSON('/index.php/Tip/getTKTip', function(tip){
			if(tip){
				if(!tip.flag) return;
				$("<div>").append(tip.message).dialog({
						position:['right','bottom'],
						minHeight:40,
						title:'系统提示',
						buttons:''
					});
			}
		})
	}, 10000);
	setInterval(function(){
		reloadMemberInfo();
		$.getJSON('/index.php/Tip/getCZTip', function(tip){
			if(tip){
				if(!tip.flag) return;
				$("<div>").append(tip.message).dialog({
						position:['right','bottom'],
						minHeight:40,
						title:'系统提示',
						buttons:''
					});
			}
		})
	}, 8000);
	}
});

Number.prototype.round=Number.prototype.toFixed;


function changeMoneyToChinese( money )
{
var cnNums = new Array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"); //汉字的数字
var cnIntRadice = new Array("","拾","佰","仟"); //基本单位
var cnIntUnits = new Array("","万","亿","兆"); //对应整数部分扩展单位
var cnDecUnits = new Array("角","分","毫","厘"); //对应小数部分单位
var cnInteger = "整"; //整数金额时后面跟的字符
var cnIntLast = "元"; //整型完以后的单位
var maxNum = 999999999999999.9999; //最大处理的数字

var IntegerNum; //金额整数部分
var DecimalNum; //金额小数部分
var ChineseStr=""; //输出的中文金额字符串
var parts; //分离金额后用的数组，预定义

if( money == "" ){
return "";
}

money = parseFloat(money);
//alert(money);
if( money >= maxNum ){
$.alert('超出最大处理数字');
return "";
}
if( money == 0 ){
ChineseStr = cnNums[0]+cnIntLast+cnInteger;
//document.getElementById("show").value=ChineseStr;
return ChineseStr;
}
money = money.toString(); //转换为字符串
if( money.indexOf(".") == -1 ){
IntegerNum = money;
DecimalNum = '';
}else{
parts = money.split(".");
IntegerNum = parts[0];
DecimalNum = parts[1].substr(0,4);
}
if( parseInt(IntegerNum,10) > 0 ){//获取整型部分转换
zeroCount = 0;
IntLen = IntegerNum.length;
for( i=0;i<IntLen;i++ ){
n = IntegerNum.substr(i,1);
p = IntLen - i - 1;
q = p / 4;
m = p % 4;
if( n == "0" ){
zeroCount++;
}else{
if( zeroCount > 0 ){
ChineseStr += cnNums[0];
}
zeroCount = 0; //归零
ChineseStr += cnNums[parseInt(n)]+cnIntRadice[m];
}
if( m==0 && zeroCount<4 ){
ChineseStr += cnIntUnits[q];
}
}
ChineseStr += cnIntLast;
//整型部分处理完毕
}
if( DecimalNum!= '' ){//小数部分
decLen = DecimalNum.length;
for( i=0; i<decLen; i++ ){
n = DecimalNum.substr(i,1);
if( n != '0' ){
ChineseStr += cnNums[Number(n)]+cnDecUnits[i];
}
}
}
if( ChineseStr == '' ){
ChineseStr += cnNums[0]+cnIntLast+cnInteger;
}
else if( DecimalNum == '' ){
ChineseStr += cnInteger;
}
return ChineseStr;

}