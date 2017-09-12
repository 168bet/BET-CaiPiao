
window['alert'] = function (msg) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);

};
//获取url参数
var getParam = function(name){
	var reg = new RegExp(name + "=([^&]*)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[1]); return null; 
}

var $$ = function(x){
	var dom = document.querySelectorAll(x)
	if(dom.length == 1){
		dom = dom[0]
		dom.length = 1
	}
	return dom;
}
Array.prototype.each=function(callback)
{
	for (var i=0;i<this.length;i++)
	{
		callback.call(this,this[i]);
	}
}


var convert = function(){
	var g = {
			type:1,
			scale:1,//彩金与宝币
			yue:0//余额
	}



	var o = {
			yue:function(){
				if(g.type == '1'){
					$.ajax({
						url:'/user/yydbbalance.go',
						type:'get',
						success: function(xml){
							var R = $(xml).find('Resp');
							var c = R.attr('code')
							var credit = 0,money = 0,handsel = 0;
							if(c == 0){
								var r = R.find('row');
								credit = r.attr('credit')||'0';
								money = r.attr('money')||'0';//得宝币
								handsel = r.attr('handsel')||'0';//彩金
								
								g.yue = +credit/100 || 0;
								
							}
							$('#money cite')[0].innerHTML = +credit/100
							$('#money cite')[1].innerHTML = +money/100
							$('#money cite')[2].innerHTML = +handsel/100
						}
					})
				}
				
				if(g.type == '2'){
					$.ajax({
						url:'/user/mlottery.go?flag=40',
						type:'get',
						success: function(xml){
							var R = $(xml).find('Resp');
							g.yue = R.attr('usermoeny')||0;
							
							$('#money').html('彩金余额<cite>'+g.yue+'元</cite>')
						}
					})
	
	
				}
			},
			render: function(){
				var text = {'1':'宝币','2':'彩币'}[g.type]

				var lion = Array.prototype.slice.call($$('#lion li'));
				lion.each(function(e){
					var m = e.innerHTML;
					var v = e.getAttribute('value');
					if(g.type == 1){
						e.innerHTML = m.replace(/>\d+.*(<\/strong>)/, ">"+v*g.scale+"宝币$1").replace(/(兑:).*/, "$1"+v+"彩金");
					}else{
						e.innerHTML = m.replace(/>(\d+).*(<\/strong>)/, ">"+v+"彩金$2").replace(/(兑:).*/, "$1"+v*g.scale+"宝币");
					}

				})
				if(g.type == '1'){
					$$('#cut').innerHTML = '宝币兑换购彩金'
					$$('.fcHeader h1').innerHTML = '宝币兑换彩金'
//						$$('#money').innerHTML = $$('#money').innerHTML.replace(/(.*)<cite>/,'宝币余额<cite>')
						$$('#semoney').setAttribute('placeholder', '手动输入兑换宝币数量')
				}
				if(g.type == '2'){
					$$('.tzHeader .cancel').style.display = 'block';
					$$('.fcHeader h1').innerHTML = '彩金兑换宝币';
//					$$('#money').innerHTML = $$('#money').innerHTML.replace(/(.*)<cite>/,'彩金余额<cite>');
					$$('#semoney').setAttribute('placeholder', '手动输入兑换彩金数量');

					$$('.tzHeader .cancel').addEventListener('touchend', function(e){
						location.href='/#type=url&p=user/detail.html'
					}, false);
				}
				o.yue()

			},
			dchange: function(){
				var vel = $$('#semoney').value;
				$$('#dhmoney').innerHTML = ':'+(g.type==1?(vel/g.scale).toFixed('2'):vel*g.scale)+({'1':'彩金','2':'宝币'}[g.type])
				
			},
			bind: function(){
				$$('.fcbackIco2').addEventListener('click', function(){
					location.href='/#type=url&p=user/index.html'
				}, false)

				$$('#semoney').onkeyup = function(el){
					this.value = this.value.replace(/[^\d]/, '')
					var val = this.value;
					var lion = Array.prototype.slice.call($$('#lion li'));
					lion.each(function(e){
						if((val == e.getAttribute('value')*g.scale && g.type == '1') || (g.type == '2'&&val == e.getAttribute('value'))){
							e.setAttribute('class','on')
						}else{
							e.setAttribute('class','')
						}
					})
					o.dchange()
					
				}

				$$('#lion').addEventListener('touchend', function(e){
					if(e.target.tagName != 'LI'&& e.target.tagName != 'STRONG')return;
					$$('#lion .on').length && $$('#lion .on').setAttribute('class','');
					var m = 0;
					if(e.target.tagName == 'STRONG'){
						e.target.parentElement.setAttribute('class','on')
						m = e.target.parentElement.getAttribute('value')
					}else{
						e.target.setAttribute('class','on')
						m = e.target.getAttribute('value')
					}
					$$('#semoney').value = g.type == 2 ? m :m*g.scale;
					o.dchange()
				}, false);
				
				$('#btn').on('touchend', function(){
					var val = $$('#semoney').value;
					if(!val){
						return alert('请输入兑换的金额');
					}

					if(g.type == 1){
						if(val*g.scale>g.yue){
							return alert('余额不足兑换');
						}
					}
					if(g.type == 2){
						if(val/g.scale>g.yue){
							return alert('余额不足兑换');
						}
					}

					var url = '/user/yydbconvert.go'//得宝币兑换彩金 
					if(g.type == 2){
						url = '/user/yydbconverse.go'//彩金兑换得宝币
					}

					if(!/gray/.test($$('#btn').getAttribute('class'))){
						$$('#btn').innerHTML = '订单提交中...';
						$$('#btn').setAttribute('class','btn btncur gray')
						
						$.ajax({
							url:url,
							type:'POST',
							data:{
								gopaymoney:val
							},
							success: function(xml){
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								var d = R.attr('desc');
								$$('#btn').innerHTML = '立即兑换';
								$$('#btn').setAttribute('class','btn btncur')
								if(c == '0'){
									o.yue()
									alert('兑换成功')
									return;
								}
								alert(d)
							},error: function(){
								$$('#btn').innerHTML = '立即兑换';
								$$('#btn').setAttribute('class','btn btncur')
								alert("请求服务器失败！");
							}
						})
					}
					
				})
			},
			init: function(){
				g.type = getParam('type') || '1';//这里定义一下  1：宝币兑换彩币  2彩币兑换宝币

				this.render();
				this.bind();
			}

	}
	return o;
}();
convert.init()
