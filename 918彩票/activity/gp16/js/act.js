//球体适配
resizeqiu();
window.onresize = resizeqiu;
function resizeqiu(){
	var oQiu = document.getElementById("gq_qiu")
	var aI = oQiu.getElementsByTagName("i");
	var co1 = document.getElementsByClassName("ssqBall")[0];
	var c1 = co1.getElementsByTagName("cite");
	var co2 = document.getElementsByClassName("ssqBall")[1];
	var c2 = co2.getElementsByTagName("cite");
	for(var i=0; i<aI.length;i++){
		var w = aI[i].clientWidth;
		aI[i].style.height = w + "px";
		aI[i].style.lineHeight = w + "px";
	}
	for(var j=0;j<c1.length;j++){
		var wc = c1[j].clientWidth;
		c1[j].style.height = wc + "px";
		c1[j].style.lineHeight = wc + "px";
	}
	for(var k=0;k<c2.length;k++){
		var wc = c2[k].clientWidth;
		c2[k].style.height = wc + "px";
		c2[k].style.lineHeight = wc + "px";
	}
	
}
//双色球和大乐透套餐基本一致，同时使用act.js文件
var t = location.href.split('?')[1].split('=')[1];
t == "ssq"? g.loty_id = '01' : g.loty_id = '50';
t == "ssq"? g.comboid ='81' : g.comboid ='82' ;
g.baishu = 1 ;
g.buyType=1;//追号、合买、自购
g.zhushu = 30 ;
g.totalMoney = 58;
//套餐组件
CP.math = {
	random: function (startNum, totalNum, len, a, rep, con, hour) {
		var absNum = Math.abs(startNum - totalNum) + 1;
		var repL = 0;
		var luckCon = con && con.split('') || [];
		if (typeof(rep) == 'object') {
			repL = rep.length;
		}
		if (typeof len == "undefined" || len > absNum || len < 1 || len > absNum - repL) {
			return [];
		}

		var o = {}, _r = new Array(len), i = 0, s, j = 1;
		if (luckCon.length > 0 && CP.Cookie.get(con) !== '') {
			return CP.Cookie.get(con).split(',');
		} else {
			while (i < len) {
				s = parseInt(Math.random() * absNum + startNum);
				if (!a) {
					s = function (a, s) {
						for (var i = 0; i < a.length;) {
							if (a[i++] == s)return null;
							if (typeof(rep) == 'object') {
								for (var j = 0; j < repL; j++) {
									if (s == rep[j])return null;
								}
							}
						}
						return s
					}(_r, s);
					s !== null && (_r[i++] = s);
				} else {
					_r[i++] = s;
				}
			}
			if (luckCon.length > 0) {
				hour = (hour || 1) - (new Date().getMinutes()) / 60;
				CP.Cookie.set(con, _r.join(','), null, null, hour);
			}
		}
		return _r;
	}
}
CP.Util = {
	/**
	 * @description 是否补零
	 * @param {String} source 数值
	 * @param {Int} [length:true] 长度
	 * @example CP.Util.pad(9,2);return 09
	 * @example CP.Util.pad(9,3);return 009
	 * @memberOf CP.Util
	 */
	pad: function (source, length) {
		var pre = "",
			negative = (source < 0),
			string = String(Math.abs(source));
		if (string.length < length) {
			pre = (new Array(length - string.length + 1)).join('0');
		}
		return (negative ? "-" : "") + pre + string;
	},
	 /**
		 * @description 根据彩种id 获取信息
		 * @param {String} gid 彩种id required
		 * @param {String} opt 投注号码 required
		 * @example CP.Util.joinString(01, '01,05,07,15,23,32|04;01,12,16,20,22,26|05'); return 01,05,07,15,23,32|04:1:1;01,12,16,20,22,26|05:1:1
		 * @return {str} 返回投注需求的code值
		 */
	joinString : function (gid, opt){
		var opt_ = opt.split(';');
		opt_ = $.map(opt_, function (item) {
			if (gid == '01' || gid == '50' || gid == '07' || gid=="51" || gid=="52") {//双色球 & 大乐透 & 七乐彩 & 七星彩 & 排列五
				return item += ':1:1';
			}
		})
		return opt_.join(';');
	}
}

//大乐透，双色球套餐
CP.Home = function () {
	var j_ = '';
	var n_ = new Date();//本地时间
	var tag = 'ssq';
	var url_ = '';
	var a = {
			jxNum: function(obj, tag){
				if(tag == 'ssq'){//机选双色球
					var ssq = CP.math.random(1,33,6),i;
					ssq = ssq.slice(0,6).sort(function(a,b){return a-b;});
					for(i=0; i<6; i++){
						obj[i].innerHTML=CP.Util.pad(ssq[i],2);
					}
					var ssq_b = CP.math.random(1,
							16,1);//蓝球
					obj[6].innerHTML=CP.Util.pad(ssq_b[0],2);
				}else{//大乐透
					var dlt = CP.math.random(1,35,5),i;
					dlt = dlt.slice(0,5).sort(function(a,b){return a-b;});
					for(i=0; i<5; i++){
						obj[i].innerHTML=CP.Util.pad(dlt[i],2);
					}
					var dlt_b = CP.math.random(1,12,2);
					dlt_b = dlt_b.slice(0,2).sort(function(a,b){return a-b;});
					obj[5].innerHTML=CP.Util.pad(dlt_b[0],2);
					obj[6].innerHTML=CP.Util.pad(dlt_b[1],2);
				}
			},
			setJx: function () {//机选一注
                clearInterval(j_);
                var g = 0,
                q = 100;
                $('.gq_qiu i').addClass('rotate_jx');
                //$('#ball em input').addClass('rotate_jx');
                if(t =="ssq"){
                	document.title="双色球套餐";
                }else{
                	document.title="大乐透套餐";
                }
                a.jxNum($('.gq_qiu i'),t);
                j_ = setInterval(function () {
                    /*  $('#ball em:eq(' + g + ')' ).removeClass('rotate_jx');//给每个球添加动画效果*/
                    $('.gq_qiu i:eq(' + g + ')' ).removeClass('rotate_jx');
                    g++;
                    if (g > 6) {return false;}
                }, q);
			},
	}
	var oclick ={
			/*点击球[[*/
			clickBall : function(_this,on){
				$(_this).is('.'+on)?$(_this).removeClass():$(_this).addClass(on).addClass('ball_scale');//添加类名
			},
			/*清楚所有选号[[*/
			clear : function(dom){
				dom.each(function(){$(this).removeClass();});
			},
	}
	
    var getArgument = function(t){
		var buy = {};
		var code = CP.Util.joinString(g.loty_id, g.codes);//code值拼接
		g.codes = code
		switch(t){
			/* 1:自购 2:合买 3:追号 */
			case 1:
				buy = {//投注参数
						
						payUrl:    '/trade/buyDiscountCombo.go',//投注接口
						comboid:   g.comboid,//套餐id
						gid:       g.loty_id,//彩种id
						//pid:       g.qihao_id,//期号
						codes:     g.codes,//投注内容
						//muli:      g.beishu,//倍数
						//countMoney:g.totalMoney,//方案金额
						//orderType:'dg'//代购
				};
				break;
		}
		return buy;
	}
	
	var sjcode = function(){//得到所选的号码
		var codes=[];
		var ab='';
		var cod=[]
		if(t=='ssq'){//0-5||6
			for(var i=0;i<$(".gq_qiu i").length-1;i++){
				codes.push($(".gq_qiu i").eq(i).html());
			}
			var cod = $(".gq_qiu i").eq(6).html();
			var ab = codes.join(',')+'|'+cod;
		}else{//0-4||5-6
			for(var i=0;i<$(".gq_qiu i").length-2;i++){
				codes.push($(".gq_qiu i").eq(i).html());
			}
			for(var i=$(".gq_qiu i").length-2;i<$(".gq_qiu i").length;i++){
				cod.push($(".gq_qiu i").eq(i).html());
			}
			var ab = codes.join(',')+'|'+cod.join(',');
		}
		g.codes = ab ;
	}
	
	//自选后的数值sNum(6,7)||sNum(5,7)
	var sNum = function(a,b){
		var ss = $(".ssqBall .cur");
		var ssArr=[];
		for(var i=0;i<ss.length;i++){
			ssArr.push($(".ssqBall .cur").eq(i).html());
		}
		for(var x=0;x<a;x++){
			$(".gq_qiu i:eq("+x+")").html(ssArr[x]);
		}
		for(var y=a;y<b;y++){
			$(".gq_qiu i:eq("+y+")").html(ssArr[y]);
		}
	}
	
	/*购买验证[[*/
	var dobuy= function(t){
		var info = '';
		if(g.zhushu<1){//投注列表没有内容
			info = '请至少选择一注彩票';
		}else if(!g.qishu){
			info = '请输入期数';
		}else if(!g.beishu){
			info = '请输入倍数';
		}
		if(info!=''){alert(info);return}
		if(t){window.location.href = "#type=fun&fun=CP.SZC.doHm";}else{dopay();}
	}
	
	/*拼凑购买弹窗需要的参数[[*/
	var dopay=function(a){
		t=="ssq"? g.loty_id = '01' : g.loty_id = '50'
		var _obj = getArgument(g.buyType);
		var cMoney = '';
		a ? cMoney = g.hmMoney : cMoney = g.totalMoney;
		var data = {//支付弹框参数
				comboid: g.comboid,//套餐
				gid:     g.loty_id,//彩种id
				codes:     g.codes,//投注内容
				cMoney:  cMoney,//需支付金额
				payPara: _obj//jQuery.param(param)
		};
		alert('提交中，请稍后！','loading');
		CP.info(function(options){
			remove_alert();
			if (options) {jQuery.extend(data, options);}
			CP.Popup.buybox(data);
		});
		/* sessionStorage.removeItem(lotteryType); */
	}
	
	var panduan = function(){
		$.ajax({
			url:'/activity/buyComboStatus.go',
			type:'GET',
			data:{
				fflag:g.comboid 
			},
			success:function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var d = R.attr('desc');
				if(c == '1000'){
					alert(d);
					return false;
				}else{
					return true;
				}
			},error : function () {
				remove_alert();
				alert('网络异常请刷新重试');
			}
		});
	}
	
	
	var que_an=function(){ //点击确认按钮后成功的变化
		$("#click_bg").hide();
		$(".ssqText").hide();
		$("#ball").find("div").show();
		$(".ssqText").find("cite").removeClass();
	}
	/* 初始化 */
	var init=function(){
		
		$(".ssqText").hide();
		$('#ball_red').find('div:eq(0) cite').Touch({fun:function(el){ oclick.clickBall(el,'cur');}});
		$('#ball_blue').find('div:eq(0) cite').Touch({fun:function(el){ oclick.clickBall(el,'cur');}});
		$(".gq_xhbtn").bind(start_ev,function(){sjcode();dobuy();});
		a.setJx();//双色球、大乐透机选
//		sjcode();//每次的号码保存在g.condes中
		$('.gq_huan').on('click',function(){//机选一注
			a.setJx();
		});
		$('.gq_shouxuan').on('click',function(){//自选
			$(".ssqText").show()
			resizeqiu();
			$("#click_bg").show();
		});
		$('#click_an').on('click','span:eq(0)' ,function(){
			$("#click_bg").hide();
			$(".ssqText").find("cite").removeClass();
			$(".ssqText").hide();
			$("#ball").find("div").show();
		})
		$('#click_an').on('click','span:eq(1)' ,function(){
			var sr =$(".ssqre .cur").length;//红球个数
			var sb =$(".ssqbl .cur").length;//绿球个数
			if(t == 'ssq'){ //双色球
				if(sr !=6 || sb!=1){
					alert("红球六个 蓝球最多只能一个")
				}else{
					sNum(6,7);
					que_an();
				}
			}else{//大乐透
				if(sr != 5 || sb != 2){
					alert("红球五个 蓝球最多只能二个")
				}else{
					sNum(5,7);
					que_an();
				}
			}
		})
	}
	init();
}()