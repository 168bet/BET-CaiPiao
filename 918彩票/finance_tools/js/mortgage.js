
window.alert = function(msg){
	clearTimeout(window.alert.time);
	var obj = $('<div class="alertBox">' + msg + '</div>');
	$('body').append(obj);
	window.alert.time = setTimeout(function () {
		$(".alertBox").remove();
	}, 2e3);
}
var isEmpty = function(obj){
    for(var key in obj){
        return false;
    }
    return true;
}
var W = {};

//方案对比的时候 需要的一些数据
//【赋值】 点击计算的时候 存入local里面
//【清空】 切换tab的时候
W.g = {
		type:'0',//贷款类型（0商业贷 1公积金 2组合贷）
		dyze:'',//贷款总额
		sdqe:'',//商贷全额
		sdll:'',//商贷利率
		sdnx:'',//商贷年限
		gjjqe:'',//公积金全额
		gjjll:'',//公积金利率
		gjjnx:'',//公积金年限
		hkfs:'',//还款方式（0等额本息 1等额本金）
		syhk:'',//首月还款
		lxze:'',//利息总额
		pjhk:''//平均还款
}
W.modify = false;//添加对比的时候 是否是修改
W.pr = 'dy';//默认前缀
W.rate = ''//年利率
//计算要用到的公式
W.formula = {
	//等额本息
	x:function(money, term, rate){
		//公式   每月还款额 = （本金 * 月利率 * (1+月利率)^还款月数 ）/ （(1+月利率)^还款月数 - 1）
		var yll = (rate/12)/100,//月利率
			yll_1 = yll+1,
			bj = money * 10000,
			ys = term*12;
		var money = (bj * yll * Math.pow(yll_1, ys)) / (Math.pow(yll_1, ys)-1)
		return {money:money, interest: money*ys-bj}
	},
	//等额本金
	j:function(money, term, rate){
		//每月还款额 = 每月本金 + 每月本息
		//每月本金 = 本金/还款月数
		//每月本息 = （本金-累计还款总额）* 月利率
		var yll = (rate/12)/100,
			ys = term*12,
			bj = money * 10000,
			mybj, mybx, zlx;
		mybj = bj/ys;
		mybx = bj * yll;
		zlx = yll * bj * (ys+1)/2
		return {money:(mybj + mybx), decrease:mybj*yll, interest:zlx}//每月还款 递减
	}
		
}
W.add = function(index){
	if(index == '3')return;
	var a = {'0':'等额本息','1':'等额本金'}
	if(index == '0'){
		$('#dy_money').val(W.g.sdqe)
		$('#dy_term').html(W.g.sdnx+'年').data('t', W.g.sdnx)
		$('#dy_rate').html(W.g.sdll+'%').data('t', W.g.sdll)
		$('#dy_type').html(a[W.g.hkfs]).data('t', W.g.hkfs)
		
		W.count.dy()
	}
	if(index == '1'){
		$('#gjj_money').val(W.g.gjjqe)
		$('#gjj_term').html(W.g.gjjnx+'年').data('t', W.g.gjjnx)
		$('#gjj_rate').html(W.g.gjjll+'%').data('t', W.g.gjjll)
		$('#gjj_type').html(a[W.g.hkfs]).data('t', W.g.hkfs)
		
		W.count.gjj()
	}
	if(index == '2'){
		$('#zh_dy_money').val(W.g.sdqe)
		$('#zh_dy_term').html(W.g.sdnx+'年').data('t', W.g.sdnx)
		$('#zh_dy_rate').html(W.g.sdll+'%').data('t', W.g.sdll)
		$('#zh_gjj_money').val(W.g.gjjqe)
		$('#zh_gjj_term').html(W.g.gjjnx+'年').data('t', W.g.gjjnx)
		$('#zh_gjj_rate').html(W.g.gjjll+'%').data('t', W.g.gjjll)
		$('#zh_type').html(a[W.g.hkfs]).data('t', W.g.hkfs)
		
		W.count.zh()
	}
	
}
W.clear = function(index){
	W.g.type = index
	if(index == '3')return; 
//	W.pr = {'0':'dy', '1':'gjj', '2':'zh'}[index]
	$('.txt-money').hide()
	if(index == '2'){
		$('#zh_dy_money').val('')
		$('#zh_dy_term').html('30年').data('t', '30')
		W.rate && $('#zh_dy_rate').html('基准利率('+W.rate.syd[1]+'％)').data('rate',W.rate.syd[1]).data('t',W.rate.syd[1])
		$('#zh_gjj_money').val('')
		$('#zh_gjj_term').html('30年').data('t', '30')
		W.rate && $('#zh_gjj_rate').html('基准利率('+W.rate.gjj+'％)').data('rate',W.rate.gjj).data('t',W.rate.gjj)
	}else{
		$('#'+W.pr+'_money').val('')
		$('#'+W.pr+'_term').html('30年').data('t', '30')
		W.rate && $('#'+W.pr+'_rate').html('基准利率('+(W.pr == 'dy'? W.rate.syd[1]:W.rate.gjj)+'％)').data('rate',(W.pr == 'dy'? W.rate.syd[1]:W.rate.gjj)).data('t',(W.pr == 'dy'? W.rate.syd[1]:W.rate.gjj))
	}
	$('#'+W.pr+'_type').html('等额本息').data('t', '0')
}
W.contrast = function(){
	var contrast = localStorage.getItem('contrast')
	if(!contrast || contrast == '' || contrast == '[]'){
		$('#contrast .list-fa, #contrast .edit, #contrast .nav-fa').hide();
		$('#contrast .no').show();
		return;
	}
	contrast = JSON.parse(contrast)
	var count1 = 0;
	for(var s = 0; s<contrast.length; s++ ){
		if(isEmpty(contrast[s])){
			count1++
		}
	}
	if(contrast.length == count1){
		$('#contrast .list-fa, #contrast .edit, #contrast .nav-fa').hide();
		$('#contrast .no').show();
		return;
	}
	
	$('#contrast .list-fa, #contrast .edit, #contrast .nav-fa').show();
	$('#contrast .no').hide();
	
	
	
	$('#contrast .list-fa ul').each(function(i, v){
		var c1 = contrast[0],
			c2 = contrast[1],
			c3 = contrast[2];
		var t = {'0':'dyze',
				'1':'sdqe',
				'2':'sdll',
				'3':'sdnx',
				'4':'gjjqe',
				'5':'gjjll',
				'6':'gjjnx',
				'7':'hkfs',
				'8':'syhk',
				'9':'lxze',
				'10':'pjhk'}[i]
		var d = {'0':'万',
				'1':'万',
				'2':'%',
				'3':'年',
				'4':'万',
				'5':'%',
				'6':'年',
				'7':'',
				'8':'元',
				'9':'元',
				'10':'元'}[i]
		
		var dom = $(v).find('li')
		var a = {'0':'等额本息','1':'等额本金'}
		$(dom[1]).html(!c1||isEmpty(c1) ?'&nbsp;':(c1[t] === ''?'-':(i != '7'? c1[t]+d: a[c1[t]])));
		$(dom[2]).html(!c2||isEmpty(c2) ?'&nbsp;':(c2[t] === ''?'-':(i != '7'? c2[t]+d: a[c2[t]])));
		$(dom[3]).html(!c3||isEmpty(c3) ?'&nbsp;':(c3[t] === ''?'-':(i != '7'? c3[t]+d: a[c3[t]])));
	})
}
//【切换导航】
W.tab = function(){
	W.tabOn('0')
	$('#navMenu a').tap(function(){
		if($(this).hasClass('cur'))return;
		var index = $(this).index()
		if(W.modify){
			if(!confirm('你要退出修改吗？'))return;
		}
		W.tabOn(index)
	})
}
//js控制切换
W.tabOn = function(index, flag){
	W.modify = false;
	W.pr = {'0':'dy', '1':'gjj', '2':'zh'}[index]
	$($('#navMenu a')[index]).addClass('cur').siblings().removeClass('cur')
	flag ? W.add(index) : W.clear(index)
	index == '3' && W.contrast()
	$('#daikuan, #gjj, #zh, #contrast').each(function(i){
		arguments[1].style.display = (index == i? 'block':'none');
	})
}
W.gain = function(){
	if(arguments[0] == '0'){
		W.g = {
				type:'0',//贷款类型（0商业贷 1公积金 2组合贷）
				dyze:'',//贷款总额
				sdqe: +$('#dy_money').val(),//商贷全额
				sdll: +$('#dy_rate').data('t'),//商贷利率
				sdnx: +$('#dy_term').data('t'),//商贷年限
				gjjqe:'',//公积金全额
				gjjll:'',//公积金利率
				gjjnx:'',//公积金年限
				hkfs: +$('#dy_type').data('t'),//还款方式（0等额本息 1等额本金）
				syhk:'',//首月还款
				lxze:'',//利息总额
				pjhk:''//平均还款
		}
	}
	if(arguments[0] == '1'){
		W.g = {
				type:'1',//贷款类型（0商业贷 1公积金 2组合贷）
				dyze:'',//贷款总额
				sdqe:'',//商贷全额
				sdll:'',//商贷利率
				sdnx:'',//商贷年限
				gjjqe:+$('#gjj_money').val(),//公积金全额
				gjjll:+$('#gjj_rate').data('t'),//公积金利率
				gjjnx:+$('#gjj_term').data('t'),//公积金年限
				hkfs: +$('#gjj_type').data('t'),//还款方式（0等额本息 1等额本金）
				syhk:'',//首月还款
				lxze:'',//利息总额
				pjhk:''//平均还款
		}
	}
	if(arguments[0] == '2'){
		W.g = {
				type:'2',//贷款类型（0商业贷 1公积金 2组合贷）
				dyze:+$('#zh_dy_money').val()+(+$('#zh_gjj_money').val()),//贷款总额
				sdqe:+$('#zh_dy_money').val(),//商贷全额
				sdll:+$('#zh_dy_rate').data('t'),//商贷利率
				sdnx:+$('#zh_dy_term').data('t'),//商贷年限
				gjjqe:+$('#zh_gjj_money').val(),//公积金全额
				gjjll:+$('#zh_gjj_rate').data('t'),//公积金利率
				gjjnx:+$('#zh_gjj_term').data('t'),//公积金年限
				hkfs: +$('#zh_type').data('t'),//还款方式（0等额本息 1等额本金）
				syhk:'',//首月还款
				lxze:'',//利息总额
				pjhk:''//平均还款
		}
	}
}
W.count = {
		dy:function(){
			if(!$('#dy_money').val() || isNaN($('#dy_money').val())){
				return alert('请输入贷款金额')
			}
			if($('#dy_money').val()<1 || $('#dy_money').val()>1e4){
				return alert('贷款金额范围：1万-1亿')
			}
			W.gain('0');
			var txt_money = $('#daikuan .txt-money'), txt_money_div = txt_money.find('div');
			txt_money.show()
			var refund = W.formula[!W.g.hkfs ?  'x':'j'](W.g.sdqe, W.g.sdnx, W.g.sdll)//每月还款额

			//对比的时候需要的一些参数
			W.g.dyze = W.g.sdqe
			W.g.syhk = refund.money.toFixed(2)
			W.g.lxze = refund.interest.toFixed(2)
			W.g.pjhk = ((refund.interest+W.g.dyze*1e4)/(W.g.sdnx*12)).toFixed(2)
				
			$(txt_money_div[0]).html('<i></i>每月还款：<cite>'+W.g.syhk+'</cite>元');
			$(txt_money_div[1]).html(!W.g.hkfs? '' :'<i></i>每月递减：<cite>'+refund.decrease.toFixed(2)+'</cite>元');
			$(txt_money_div[2]).html('<i class="red"></i>支付利息：<cite>'+W.g.lxze+'</cite>元');
			
			
		},
		gjj:function(){
			if(!$('#gjj_money').val() || isNaN($('#gjj_money').val())){
				return alert('请输入贷款金额')
			}
			if($('#gjj_money').val()<1 || $('#gjj_money').val()>1e4){
				return alert('贷款金额范围：1万-1亿')
			}
			W.gain('1');
			var txt_money = $('#gjj .txt-money'), txt_money_div = txt_money.find('div');
			txt_money.show()
			var refund = W.formula[!W.g.hkfs ?  'x':'j'](W.g.gjjqe, W.g.gjjnx, W.g.gjjll)//每月还款额

			//对比的时候需要的一些参数
			W.g.dyze = W.g.gjjqe
			W.g.syhk = refund.money.toFixed(2)
			W.g.lxze = refund.interest.toFixed(2)
			W.g.pjhk = ((refund.interest+W.g.dyze*1e4)/(W.g.gjjnx*12)).toFixed(2)
			
			$(txt_money_div[0]).html('<i></i>每月还款：<cite>'+W.g.syhk+'</cite>元');
			$(txt_money_div[1]).html(!W.g.hkfs? '' :'<i></i>每月递减：<cite>'+refund.decrease.toFixed(2)+'</cite>元');
			$(txt_money_div[2]).html('<i class="red"></i>支付利息：<cite>'+W.g.lxze+'</cite>元');
		},
		zh:function(){
			if(!$('#zh_dy_money' || isNaN($('#zh_dy_money').val())).val()){
				return alert('请输入商贷贷款金额')
			}
			if(!$('#zh_gjj_money').val() || isNaN($('#zh_gjj_money').val())){
				return alert('请输入公积金贷款金额')
			}
			if($('#zh_dy_money').val()<1 || $('#zh_dy_money').val()>1e4){
				return alert('商贷贷款金额范围：1万-1亿')
			}
			if($('#zh_gjj_money').val()<1 || $('#zh_gjj_money').val()>1e4){
				return alert('公积金贷款金额范围：1万-1亿')
			}
			W.gain('2');
			var txt_money = $('#zh .txt-money'), txt_money_div = txt_money.find('div');
			txt_money.show()
			var refund_dy = W.formula[!W.g.hkfs ?  'x':'j'](W.g.sdqe, W.g.sdnx, W.g.sdll)//每月还款额
			var refund_gjj = W.formula[!W.g.hkfs ?  'x':'j'](W.g.gjjqe, W.g.gjjnx, W.g.gjjll)//每月还款额
			
			W.g.syhk = (refund_dy.money+refund_gjj.money).toFixed(2)
			W.g.lxze = (refund_dy.interest+refund_gjj.interest).toFixed(2)
			W.g.pjhk = ((W.g.lxze+W.g.dyze*1e4)/(Math.max(W.g.gjjnx, W.g.sdnx)*12)).toFixed(2)
			if(W.g.sdnx == W.g.gjjnx){
				$(txt_money_div[0]).html('<i></i>每月还款：<cite>'+W.g.syhk+'</cite>元');
				$(txt_money_div[1]).html(!W.g.hkfs? '' :'<i></i>每月递减：<cite>'+(refund_dy.decrease+refund_gjj.decrease).toFixed(2)+'</cite>元');
				$(txt_money_div[2]).html('<i class="red"></i>支付利息：<cite>'+W.g.lxze+'</cite>元');
				$(txt_money_div[3]).html('');
				$(txt_money_div[4]).html('');
			}else{
				var min = Math.min(W.g.sdnx, W.g.gjjnx),  flag = W.g.sdnx>W.g.gjjnx;
				$(txt_money_div[0]).html('<i></i>前'+min+'年月供：<cite>'+W.g.syhk+'</cite>元');
				$(txt_money_div[1]).html(!W.g.hkfs? '' :'<i></i>每月递减：<cite>'+(refund_dy.decrease+refund_gjj.decrease).toFixed(2)+'</cite>元');
				var yg = !W.g.hkfs?(flag?refund_dy.money:refund_gjj.money):(flag?refund_dy.money-refund_dy.decrease*min*12 : refund_gjj.money-refund_gjj.decrease*min*12)
				$(txt_money_div[2]).html('<i></i>'+min+'年之后月供：<cite>'+yg.toFixed(2)+'</cite>元');
				$(txt_money_div[3]).html(!W.g.hkfs? '' :'<i></i>每月递减：<cite>'+(flag?refund_dy.decrease:refund_gjj.decrease).toFixed(2)+'</cite>元');
				$(txt_money_div[4]).html('<i class="red"></i>支付利息：<cite>'+W.g.lxze+'</cite>元');
			}
		}
		
}
W.fn = (function(){
	
	var o = {
		bind: function(){
			//【商业贷】计算
			$('#dy_btn').tap(W.count.dy)
			//【公积金贷】计算
			$('#gjj_btn').tap(W.count.gjj)
			//【组合贷】计算
			$('#zh_btn').tap(W.count.zh)
			//【还款方式】
			$('#dy_type, #gjj_type, #zh_type').click(function(){
				$('#select_mode, .mask').show()
				$($('#select_mode li')[$(this).data('t')]).addClass('cur').siblings().removeClass('cur')
			})
			$('#select_mode li').tap(function(){
				//先区分是什么贷
				$('#'+W.pr+'_type').html(!$(this).index() ? '等额本息' : '等额本金').data('t', $(this).index())
				$('#select_mode, .mask').hide()
			})
			//【年限】
			$('#dy_term, #gjj_term, #zh_dy_term, #zh_gjj_term').click(function(){
				$('#select_deadline,.mask').show()
				var t = {'30':'0','25':'1','20':'2','15':'3','10':'4','5':'5'}[$(this).data('t')]
				$($('#select_deadline li')[t]).addClass('cur').siblings().removeClass('cur')
				$('#select_deadline').data('t', event.target.id)
			})
			$('#select_deadline li').tap(function(){
				var t = {'0':'30','1':'25','2':'20','3':'15','4':'10','5':'5'}[$(this).index()]
				var id = $('#select_deadline').data('t')
				if(/dy_term/.test(id)){//商业贷 5年以内利率 不一样 单独处理
					if(t == '5' &&  $('#'+id).data('t') == '5'){
						
					}else{
						t == '5' && $('#dy_rate, #zh_dy_rate').html('基准利率('+W.rate.syd[0]+'％)').data('rate', W.rate.syd[0]).data('t', W.rate.syd[0])
						$('#'+id).data('t') == '5' && $('#dy_rate, #zh_dy_rate').html('基准利率('+W.rate.syd[1]+'％)').data('rate', W.rate.syd[1]).data('t', W.rate.syd[1])
					}
				}
				$('#'+id).html(t+'年').data('t', t)
				$('#select_deadline, .mask').hide()
				
			})
			//【利率】
//			#gjj_rate
//			#zh_gjj_rate
			$('#dy_rate, #zh_dy_rate').click(function(){
				var prompt = $('#select_rate .prompt'),id = event.target.id, ra = $(this).data('t'),rate;
				
				if(W.g.type == '0'){
					rate = $('#dy_term').data('t') == '5' ? W.rate.syd[0] : W.rate.syd[1]
					prompt.html($('#dy_term').data('t') == '5' ? '2015年10月五年以内最新商贷基准率 : '+rate+'%':'2015年10月五年以上最新商贷基准率 : '+rate+'%')
				}
				if(W.g.type == '1'){
					rate = W.rate.gjj
					prompt.html('2015年10月最新公积金贷基准率 : '+rate+'%')
				}
				if(W.g.type == '2'){
					if(id == 'zh_dy_rate'){
						rate = $('#zh_dy_term').data('t') == '5' ? W.rate.syd[0] : W.rate.syd[1]
						prompt.html($('#zh_dy_term').data('t') == '5' ? '2015年10月五年以内最新商贷基准率 : '+rate+'%':'2015年10月五年以上最新商贷基准率 : '+rate+'%')
					}else{
						rate = W.rate.gjj
						prompt.html('2015年10月最新公积金贷基准率 : '+W.rate.gjj+'%')
					}
				}
				
				$('#select_rate li').each(function(i, v){
					if(i != '0' && i != ($('#select_rate li').length-1)){
						var t = $(v).attr('t'),
						r = Math.round(rate*t*100)/100
						$(v).html(function(){return arguments[1].replace(/(（.*）)/, '（'+r.toFixed(2)+'%）')}).data('t', r)
						r == ra && $(v).addClass('cur').siblings().removeClass('cur')
					}
				})
				$('#select_rate,.mask').show()
				$('#select_rate').data('t', id)
			})
			$('#select_rate li').click(function(){
				if(!$(this).index())return;//第一个
				$('#select_rate, .mask').hide()
				if($(this).index() == ($('#select_rate li').length-1)){//最后一个
					$('#userDefined_rate,.mask').show()//打开自定义利率弹框
					$('#userDefined_rate input').val('')
					return;
				}
				var r = $(this).data('t'),t = (+r).toFixed(2)+'%'
				$('#'+$('#select_rate').data('t')).html($(this).index() == '1'?'基准利率('+t+')':t).data('t', r)
			})
			//【自定义利率】
			$('#userDefined_rate i').click(function(){
				$('#userDefined_rate, .mask').hide()
			})
			$('#userDefined_rate button').click(function(){
				
				var input = $('#userDefined_rate input')
				if(!input.val() || input.val()<1 || input.val()>20 || isNaN(input.val())){
					return alert('定义范围: 1%-20%')
				}
				$('#userDefined_rate, .mask').hide()
				$('#'+$('#select_rate').data('t')).html(input.val()+'%').data('t', input.val())
			})
			//【加入对比】
			$('#dy_contrast, #gjj_contrast, #zh_contrast').click(function(){
				var t = localStorage.getItem('contrast')
				if(W.modify){
					var contrast = JSON.parse(t)
					contrast.splice(W.modify,1, W.g)
					localStorage.setItem('contrast', JSON.stringify(contrast))
					W.modify = false;
					alert('修改成功')
					W.tabOn('3')
				}else{
					if(!t || t==''){//啥都没有的时候进来
						t = []
						t.push(W.g)
						localStorage.setItem('contrast', JSON.stringify(t))
						alert('加入成功')
					}else{
						t = JSON.parse(t)
						if(t.length < 3){
							for(var q=0; q<t.length; q++){
								if(isEmpty(t[q])){
									t.splice(q, 1, W.g)
									localStorage.setItem('contrast', JSON.stringify(t))
									return alert('加入成功')
								}
							}
							t.push(W.g)
							localStorage.setItem('contrast', JSON.stringify(t))
							alert('加入成功')
						}else{
							//下面好乱 不忍直视
							var flag = true;
							for(var i=0;i<3;i++){
								if(isEmpty(t[i])){
									t.splice(i,1, W.g)
									localStorage.setItem('contrast', JSON.stringify(t))
									alert('加入成功')
									return;//不禁跳出了for 下面也不会执行了  
								}
							}
							$('#add_project,.mask').show()
							$('#add_project .cur').removeClass('cur')
							$($('#add_project .check')[0]).addClass('cur')
							$('#add_project li').each(function(i, v){
								var obj = t[i]
								$($(v).find('span')[0]).html(function(){
									var term = obj.type == '0' ?  obj.sdnx : (obj.type == '1' ? obj.gjjnx : Math.max(obj.sdnx, obj.gjjnx))
									return arguments[1].replace(/^(.*（).*(）)/, '$1'+obj.dyze+'万/'+term+'年/'+{'0':'商贷','1':'公积金','2':'组合贷'}[obj.type]+'$2')
								})
							})
							
						}
					}
				}
			})
			$('#add_project i').tap(function(){
				$('#add_project, .mask').hide()
			})
			$('#add_project li').tap(function(){
				if($(this).find('.cur').length){
					return;
				}
				$('#add_project .cur').removeClass('cur')
				$(this).find('.check').addClass('cur')
			})
			$('#add_project button').tap(function(){
				var t = localStorage.getItem('contrast')
				t = JSON.parse(t)
				t.splice($('#add_project .cur').attr('t'), 1, W.g)
				localStorage.setItem('contrast', JSON.stringify(t))
				$('#add_project, .mask').hide()
				alert('替换成功')
			})
			//【方案对比页面】
			$('#contrast .btn-add').tap(function(){
				W.tabOn('0')
			})
			//编辑
			$('#contrast .edit').click(function(){
				var contrast = JSON.parse(localStorage.getItem('contrast'))
				$('#contrast_amend ul').each(function(i, v){
					$(v)[i>=contrast.length?'hide':(isEmpty(contrast[i])?'hide':'show')]()
				})
				
				$('#contrast_amend, .mask').show()
				$(this).hide()
			})
			$('#contrast_amend i').tap(function(){
				$('#contrast .edit').show()
				$('#contrast_amend, .mask').hide()
				
			})
			//删除
			$('#contrast_amend .del').tap(function(){
				var contrast = JSON.parse(localStorage.getItem('contrast'))
				contrast.splice($(this).attr('t'),1,{})
				localStorage.setItem('contrast', JSON.stringify(contrast))
				$('#contrast .edit').show()
				$('#contrast_amend, .mask').hide()
				
				W.contrast()
				alert('删除成功')
			})
			//修改
			$('#contrast_amend .mod').tap(function(){
				var index = $(this).attr('t')
				var contrast = JSON.parse(localStorage.getItem('contrast'))
				W.g = contrast[index]
				W.tabOn(W.g.type, true)
				W.modify = index
				$('#contrast_amend, .mask').hide()
			})
			
			$('.mask').click(function(){
				$('#select_rate, #select_deadline, #select_mode, #contrast_amend, .other_wrap, .mask').hide()
				W.g.type == '3' && $('.edit').show()
			})
		},
		init: function(){
			W.tab()
			this.bind()
			
			
			W.rate = {
					//基准利率[五年内 , 五年外]
					syd:['4.75' , '4.90'],
					gjj:'3.25'
			}
			$('#dy_rate').html('基准利率('+W.rate.syd[1]+'％)').data('rate',W.rate.syd[1]).data('t',W.rate.syd[1])
//			$.ajax({
//				url:'rate.js',
//				dataType:'script',
//				success : function(){
//					W.rate = eval('(' + arguments[0].substr(9)+ ')');
//					$('#dy_rate').html('基准利率('+W.rate.syd[1]+'％)').data('rate',W.rate.syd[1]).data('t',W.rate.syd[1])
//				}
//			})
		}
	}
	o.init()
})()



