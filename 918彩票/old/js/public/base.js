//----------------------------------------------------------base.js----1200r--login.js
var $_base_s = {};// ----处理函数
var $_user = {}; // ---用户
var $_trade = {}; // ---交易
var $_sys = {}; // 系统相关

$_user.key = {
		uid : "uid",
		pwd : "pwd",
		upwd : "upwd",
		realName : "realName",
		idCardNo : "idCardNo",
		idCardNoPosiUrl : "idCardNoPosiUrl", //身份证正面上传图片URL
		idCardNoNegaUrl : "idCardNoNegaUrl", //身份证反面上传图片URL
		mailAddr : "mailAddr",
		rid : "rid",// 问题编号
		aid : "aid",// 答案
		tid : "tid",// 交易
		gid : "gid",// 彩种
		gender : "gender",// 性别
		provid : "provid",// 省份
		cityid : "cityid",// 城市
		imNo : "imNo",// 即时通信
		mobileNo : "mobileNo",// 电话号码
		stime : "stime",// 开始时间
		etime : "etime",// 结束时间
		newValue : "newValue",// 新的值
		bankCode : "bankCode",// 银行代码
		bankCard : "bankCard",// 银行卡号
		bankName : "bankName",// 银行名称
		subbankName : "subbankName",//支行名称
		bankCardPosiUrl : "bankCardPosiUrl",//银行卡正面上传图片UR
		pn : "pn",// 页码
		ps : "ps",// 页面大小
		tp : "tp",// 总页数
		tr : "tr",// 总记录数
		tkMoney:"tkMoney", //提款金额
		qtype:"qtype",
		tkType:"tkType"//提款方式
		
};

//用户修改配置
$_user.modify = {
	info : "/user/modify.go?flag=1", // 修改用户基本信息
	pwd : "/user/modify.go?flag=2", // 修改密码
	protect : "/user/modify.go?flag=3",// 修改密保
	card : "/user/modify.go?flag=4", // 修改设置银行卡信息
	name : "/user/modify.go?flag=7", // 用户实名身份证绑定
	autostate : "/user/modify.go?flag=8" // 自动跟单状态
		
};

$_trade.url = {
		zcancel: "/trade/zcancel.go",//追号撤销
		cachematch : "/trade/m.go",// 对阵列表   1 胜平负任九 2 进球彩 3 半全场 4北单 5竟彩足球 6竟彩蓝球
		pcast : "/trade/pcast.go",// 发起方案
		jcast : "/trade/jcast.go",// 发起方案
		pjoin:"/trade/pjoin.go",//参与方案
		zcast: "/trade/zcast.go",//发起追号
		pinfo:"/trade/pinfo.go",//查询方案信息
		jlist:"/trade/jlist.go",//查询方案合买信息
		pcancel:"/trade/pcancel.go",//发起人撤单
		cacheperiod:"/trade/list.go"
};

$_user.url = {
		login : "/user/mlogin.go",// 登录
		loginout : "/user/loginout.go", // 退出登陆
		checklogin : '/user/chklogin.go',// 检测用户是否登录
		checkexist : "/user/checkexist.go", // 查询用户名是否可用
		mregister : "/user/mregister.go", // 注册
		base : "/user/query.go?flag=6", // 查询用户登录名、用户余额、冻结款、用户类型
		touzhu : "/user/query.go?flag=10",// 购彩记录
		chase : "/user/query.go?flag=11",// 追号记录
		tc_xchase : "/user/query.go?flag=36",// 套餐明细记录
		systime : "/trade/time.go",// 获取服务器时间	
		xchase : "/user/query.go?flag=19",// 追号明细记录
		safe : "/user/query.go?flag=2", // 查询安全资料
		bind : "/user/userbind.go",// 用户手机绑定提交
		bindyz : "/user/userbindyz.go",// 用户手机绑定验证
		account : "/user/query.go?flag=13",// 账户明细
		drawlist : "/user/query.go?flag=15",//提款记录	
		addmoneylist : "/user/query.go?flag=14",// 充值记录
		card : "/user/query.go?flag=4",// 查询银行卡信息
		ktkmoney : "/user/query.go?flag=23",// 查询可提款金额
		drawmoney:"/user/drawmoney.go", //提款	
		addmoney : "/user/addmoney.go", // 充值
		redpacketlist:"/user/queryRedPacket.go?flag=5",//查询用户可用红包记录
		tcxq_xchase : "/user/query.go?flag=39"// 套餐明细记录
};

//viewpath.js need
$_base_s.getDate = function(date, def) {// 含中文的字符串长度
	var date = new Date(this.isString(date) ? date.replace(/-/g, '/') : date);
	return isNaN(date) ? def: date
};
Number.prototype.rmb = function(prevfix, n) {
	return (prevfix === false ? '' : '\uffe5') + this.toFixed(n === void 0 ? 2 : n).toString().replace(/(\d)(?=(\d{3})+($|\.))/g, '$1,');
};

$_sys.lot = [];
$_sys.lot.push([ 1, "双色球"]);
$_sys.lot.push([ 3, "福彩3D"]);
$_sys.lot.push([ 4, "时时彩"]);
$_sys.lot.push([ 5, "新快3"]);
$_sys.lot.push([ 6, "快3"]);
$_sys.lot.push([ 7, "七乐彩"]);
$_sys.lot.push([ 8, "福彩快3"]);
$_sys.lot.push([ 9, "江苏快3"]);
$_sys.lot.push([ 20, "新时时彩"]);

$_sys.lot.push([ 50, "大乐透"]);
$_sys.lot.push([ 51, "七星彩"]);
$_sys.lot.push([ 52, "排列五"]);
$_sys.lot.push([ 53, "排列三"]); 
$_sys.lot.push([ 54, "11选5"]);
$_sys.lot.push([ 55, "广东11选5"]);
$_sys.lot.push([ 56, "11运夺金"]);
$_sys.lot.push([ 57, "上海11选5"]);
$_sys.lot.push([ 58, "快乐扑克3"]);

$_sys.lot.push([ 80, "胜负彩"]);
$_sys.lot.push([ 81, "任选九"]);
$_sys.lot.push([ 82, "进球彩"]);
$_sys.lot.push([ 83, "半全场"]);

$_sys.lot.push([ 84, "单场-胜负过关"]);
$_sys.lot.push([ 85, "单场-胜平负"]);
$_sys.lot.push([ 86, "单场-比分"]);
$_sys.lot.push([ 87, "单场-半全场"]);
$_sys.lot.push([ 88, "单场-上下单双"]);
$_sys.lot.push([ 89, "单场-总进球"]);

$_sys.lot.push([ 90, "竞彩-让球"]);
$_sys.lot.push([ 91, "竞彩-比分"]);
$_sys.lot.push([ 92, "半全场"]);
$_sys.lot.push([ 93, "竞彩-总进球"]);
$_sys.lot.push([ 70, "竞彩-混投"]);
$_sys.lot.push([ 72, "竞彩-胜平负"]);

$_sys.lot.push([ 94, "篮彩-胜负"]);
$_sys.lot.push([ 95, "篮彩-让分"]);
$_sys.lot.push([ 96, "篮彩-胜分差"]);
$_sys.lot.push([ 97, "篮彩-大小分"]);
$_sys.lot.push([ 71, "篮彩-混投"]);
$_sys.lot.push([ 98, "冠军竞猜"]);
$_sys.lot.push([ 99, "冠亚军竞猜"]);
$_sys.getlotname = function(f,n) {
	if (typeof(n)=='undefined'){n=1;};
	for ( var i = 0; i < $_sys.lot.length; i++) {
		if ($_sys.lot[i][0] == f) {
			return $_sys.lot[i][n];
		}
	}
};

$_sys.addmoneytype = [];
$_sys.addmoneytype.push([1,"快钱支付"]);
$_sys.addmoneytype.push([2,"财付通支付"]);
$_sys.addmoneytype.push([3,"支付宝支付"]);
$_sys.addmoneytype.push([4,"百付宝支付"]);
$_sys.addmoneytype.push([5,"手机充值卡(易宝)"]);
$_sys.addmoneytype.push([6,"银联手机支付"]);
$_sys.addmoneytype.push([9,"19pay手机充值卡"]);
$_sys.addmoneytype.push([10,"支付宝快捷支付"]);
$_sys.addmoneytype.push([11,"盛付通支付"]);
$_sys.addmoneytype.push([12,"联动优势信用卡"]);
$_sys.addmoneytype.push([13,"上海导购预付卡"]);
$_sys.addmoneytype.push([14,"支付宝扫码"]);
$_sys.addmoneytype.push([15,"mo9先玩后付"]);
$_sys.addmoneytype.push([97,"提款失败转款"]);
$_sys.addmoneytype.push([98,"购彩返利"]);
$_sys.addmoneytype.push([99,"手工加款"]);
$_sys.addmoneytype.push([998,"红包派送"]);
$_sys.addmoneytype.push([999,"网吧充值"]);

$_sys.addmoneytype.push([9000,"支付宝(安卓)"]);
$_sys.addmoneytype.push([9001,"支付宝(苹果)"]);
$_sys.addmoneytype.push([9002,"支付宝wap(苹果)"]);

$_sys.addmoneytype.push([9003,"联动优势(苹果)"]);
$_sys.addmoneytype.push([9004,"联动优势(安卓)"]);
$_sys.addmoneytype.push([9005,"支付宝wap(安卓)"]);
$_sys.addmoneytype.push([9006,"银联手机(苹果)"]);
$_sys.addmoneytype.push([9007,"银联手机(安卓)"]);
$_sys.addmoneytype.push([9008,"手机充值卡(苹果)"]);
$_sys.addmoneytype.push([9009,"手机充值卡(安卓)"]);
$_sys.addmoneytype.push([9010,"联通华建(苹果)"]);
$_sys.addmoneytype.push([9011,"联通华建(安卓)"]);

$_sys.addmoneytype.push([2003,"支付宝(东方网)"]);
$_sys.addmoneytype.push([2010,"支付宝扫码(东方网)"]);
$_sys.addmoneytype.push([2014,"支付宝快捷(东方网)"]);

$_sys.addmoneytype.push([2015,"银联手机(3g触屏)"]);
$_sys.addmoneytype.push([2016,"19pay充值卡(3g触屏)"]);
$_sys.addmoneytype.push([2017,"支付宝(3g触屏)"]);
$_sys.addmoneytype.push([3014,"支付宝(4g&触屏)"]);

$_sys.getaddmoneyname=function(f){
	for ( var i = 0; i < $_sys.addmoneytype.length; i++) {
		if ($_sys.addmoneytype[i][0] == f) {
			return $_sys.addmoneytype[i][1];
		}
	}
};
//0 对所有人公开 1 截止后公开 2 对参与人员公开 3 截止后对参与人公开
$_sys.iopen=[];
$_sys.iopen.push(["公开"]);
$_sys.iopen.push(["截止后公开"]);
$_sys.iopen.push(["对跟单用户公开"]);
$_sys.iopen.push(["截止后对跟单用户公开"]);



$_sys.getplayname = function(lotid, playid, cm, castdef) {
	var s = "";	
	lotid=parseInt(lotid,10);
	playid=parseInt(playid,10);
	castdef=parseInt(castdef,10);
	cm=parseInt(cm,10);
	switch (lotid) {
	case 1:
		switch (cm){
		case 1:
			s = "普通";
			break;
		case 5:
			s = "胆拖";
			break;
		}
		break;
	case 50:
		switch (cm){
		case 1:
			s = "普通";
			break;
		case 5:
			s = "胆拖";
			break;
		}
		break;
		break;
	case 85:
		s = "让球胜平负";
		break;
	case 86:
		s = "比分";
		break;
	case 87:
		s = "半全场";
		break;
	case 88:
		s = "上下单双";
		break;	
	case 89:
		s = "总进球数";
		break;			
	case 90:
		s = "让球胜平负";
		break;
	case 91:
		s = "比分";
		break;
	case 92:
		s = "半全场";
		break;
	case 93:
		s = "总进球数";
		break;
	case 72:
		s = "胜平负";
		break;
	case 4:
		switch (playid) {
		case 1:
			s = "五星";
			break;
		case 3:
			s = "三星";
			break;
		case 4:
			s = "两星";
			break;
		case 5:
			s = "一星";
			break;
		case 6:
			s = "大小单双";
			break;
		case 7:
			s = "二星组选";
			break;
		case 8:
			s = "三星组三";
			break;
		case 9:
			s = "三星组六";
			break;
		case 12:
			s = "五星通选";
			break;
		case 13:
			s = "五星复选";
			break;
		case 15:
			s = "三星复选";
			break;
		case 16:
			s = "两星复选";
			break;
		}
		break;
	case 6:		
	case 8:	
	case 9:
	case 5:
		switch(playid){
			case 1:
				s = "和值";
				break;
			case 2:
				s = "三同号通选";
				break;
			case 3:
				s = "三同号单选";
				break;
			case 4:
				if(castdef == 5){
					s = "三不同号胆拖";
				}else{
					s = "三不同号";
				}
				break;
			case 5:
				s = "三连号通选";
				break;
			case 6:
				s = "二同号复选";
				break;
			case 7:
				s = "二同号单选";
				break;
			case 8:
				if(castdef == 5){
					s = "二不同号胆拖";
				}else{
					s = "二不同号";
				}
				break;
		}
		break;
	case 20:
		switch (playid) {
		case 1:
			s = "一星直选";
			break;
		case 2:
			s = "二星直选";
			break;
		case 3:
			s = "三星直选";
			break;
		case 4:
			s = "四星直选";
			break;
		case 5:
			s = "五星直选";
			break;
		case 6:
			s = "二星组合";
			break;
		case 7:
			s = "三星组合";
			break;
		case 8:
			s = "四星组合";
			break;
		case 9:
			s = "五星组合";
			break;
		case 10:
			if(castdef=="1"){
				s = "二星组选单式";
			}else{
				s = "二星组选包号";
			}
			break;
		case 11:
			s = "大小单双";
			break;
		case 12:
			s = "五星通选";
			break;
		case 13:
			s = "任选一";
			break;
		case 14:
			s = "任选二";
			break;
		case 15:
			if(castdef=="1"){
				s = "三星组三单式";
			}else{
				s = "三星组三包号";
			}
			break;
		case 16:
			if(castdef=="1"){
				s = "三星组六单式";
			}else{
				s = "三星组六包号";
			}
			break;
		}
		break;
	case 3:
	case 53://castdef---playid
		switch (cm) {
		case 1:
			if(playid=="1"){
				s = "直选";
			}else if(playid=="2"){
				s = "组选三";
			}else if(playid=="3"){
				s = "组选六";
			}
			break;
		case 2:
		case 3:
			if(playid=="2"){
				s = "组三包号";
			}else if(playid=="3"){
				s = "组六包号";
			}
			break;
		case 5:
		case 4:
			if(playid=="1"){
				s = "直选和值";
			}else if(playid=="2"){
				s = "组三和值";
			}else if(playid=="3"){
				s = "组六和值";
			}
			break;
		}
		break;
	case 54:
	case 55:
	case 56:
		switch (playid) {
		case 1:
			s = "前一直选";
			break;
		case 2:
			s = "任选二";
			break;
		case 3:
			s = "任选三";
			break;
		case 4:
			s = "任选四";
			break;
		case 5:
			s = "任选五";
			break;
		case 6:
			s = "任选六";
			break;
		case 7:
			s = "任选七";
			break;
		case 8:
			s = "任选八";
			break;
		case 9:
			s = "前二直选";
			break;
		case 10:
			s = "前三直选";
			break;
		case 11:
			s = "前二组选";
			break;
		case 12:
			s = "前三组选";
			break;
		}
		break;
	case 57:
		switch (playid) {
		case 1:
			s = "前一直选";
			break;
		case 2:
			s = "任选二";
			break;
		case 3:
			s = "任选三";
			break;
		case 4:
			s = "任选四";
			break;
		case 5:
			s = "任选五";
			break;
		case 6:
			s = "任选六";
			break;
		case 7:
			s = "任选七";
			break;
		case 8:
			s = "任选八";
			break;
		case 9:
			s = "前二直选";
			break;
		case 10:
			s = "前三直选";
			break;
		case 11:
			s = "前二组选";
			break;
		case 12:
			s = "前三组选";
			break;
		}
		break;
	case 58:
		switch (playid) {
		case 1:
			s = "任选一";
			break;
		case 2:
			if(castdef == 5){
				s = "任选二胆拖";
			}else{
				s = "任选二";
			}
			break;
		case 3:
			if(castdef == 5){
				s = "任选三胆拖";
			}else{
				s = "任选三";
			}
			break;
		case 4:
			if(castdef == 5){
				s = "任选四胆拖";
			}else{
				s = "任选四";
			}
			break;
		case 5:
			if(castdef == 5){
				s = "任选五胆拖";
			}else{
				s = "任选五";
			}
			break;
		case 6:
			if(castdef == 5){
				s = "任选六胆拖";
			}else{
				s = "任选六";
			}
			break;
		case 7:
		case 12:
			s = "同花";
			break;
		case 8:
		case 13:
			s = "同花顺";
			break;
		case 9:
		case 14:
			s = "顺子";
			break;
		case 10:
		case 15:
			s = "豹子";
			break;
		case 11:
		case 16:
			s = "对子";
			break;
		}
		break;
	}
	return s;
};
$_sys.showcode = function (lotid,ccodes,oc){
	var html="";
	var codes = ccodes.split(";");
	for ( var i = 0; i < codes.length; i++) {
		if(lotid==90 ||lotid==91 ||lotid==92 ||lotid==93 ||lotid==72 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89){
			tmpCode = codes[i].split("|");
			html += '[' + $_sys.getplayname(lotid, lotid, lotid) + ']|' + tmpCode[1]+'|'+tmpCode[2].replaceAll("\\*","串");
		}else{
			tmpCode = codes[i].split(":");
			pm = tmpCode[1];
			cm = tmpCode[2];
			if (lotid=="01" || lotid=="50"){
				html += matchopencode(lotid, pm, cm, tmpCode[0], oc);
			}else if (lotid=="54" || lotid=="55" || lotid=="03" || lotid=="53" || lotid=="56" || lotid=="57"){
				if(tmpCode[0].indexOf('$') != '-1'){
					var arr = tmpCode[0].split('$');
					tmpCode[0] = ' 胆:'+arr[0]+' 拖:'+arr[1];
				}
				html += '<p class="gray pdTop06">【'+ $_sys.getplayname(lotid, pm, cm) +'】<cite class="red">' + tmpCode[0].replace(/,/g,' ') +'</cite></p>';
			}else if (lotid=="07" || lotid=="51" || lotid=="52"){
				html += '<p class="gray pdTop06">【普通】<cite class="red">' + tmpCode[0].replace(/,/g,' ') +'</cite></p>';
			}else if (lotid=="04"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']';
				if(parseInt(pm,10)==6){
					var tc = tmpCode[0].split(",");
					for(var ii=0; ii<tc.length; ii++){
						html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
					}
				}else{
					html +=tmpCode[0];
				}
			}else if (lotid=="20"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']';
				if(parseInt(pm,10)==11){
					var tc = tmpCode[0].split(",");
					for(var ii=0; ii<tc.length; ii++){
						html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
					}
					html +='<br>';
				}else{
					html +=tmpCode[0]+'<br>';
				}
			}else if (lotid=="05" || lotid=="06" || lotid=="08" || lotid=="09"){
				if(pm==2){//（快三）三同号通选在方案详情页面显示号码
					tmpCode[0]='111,222,333,444,555,666';
				}else if(pm==5){
					tmpCode[0]='123,234,345,456';
				}else if(pm=='7'){
					var cod = tmpCode[0].split("|");
					if (cod.length == 2) {
						var tn = cod[0].split(",");
						var tnstr = "";
						if (tn.length > 0) {
							for ( var j = 0; j < tn.length; j++) {
								tnstr += tn[j] + "" + tn[j] + ",";
							}
							tnstr = tnstr.substring(0, tnstr.length - 1);
							tmpCode[0] = tnstr + "|" + cod[1];
						}
					}
				} 
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']' + tmpCode[0] + '<br>';
			}else if (lotid=="58"){
				var tmp = tmpCode[0];
				switch (pm) {
				case "01":
				case "02":
				case "03":
				case "04":
				case "05":
				case "06":
					tmp = tmp.replace('11','J').replace('12','Q').replace('13','K').replace('01','A').replace('02','2').replace('03','3').replace('04','4').replace('05','5').replace('06','6').replace('07','7').replace('08','8').replace('09','9');
					break;
				case "07":
				case "08"://同花、顺单选
					tmp = tmp.replace('01','黑桃单选').replace('02','红桃单选').replace('03','梅花单选').replace('04','方片单选');
				case "09"://顺子单选
					tmp = tmp.replace('01', 'A23').replace('02', '234').replace('03', '345').replace('04', '456').replace('05', '567')
					.replace('06', '678').replace('07', '789').replace('08', '8910').replace('09', '910J').replace('10', '10JQ')
					.replace('11', 'JQK').replace('12', 'QKA');
					break;
				case "10"://豹子单选
					tmp = tmp.replace('01', 'AAA').replace('02', '222').replace('03', '333').replace('04', '444').replace('05', '555')
					.replace('06', '666').replace('07', '777').replace('08', '888').replace('09', '999').replace('10', '101010')
					.replace('11', 'JJJ').replace('12', 'QQQ').replace('13', 'KKK');
					break;
				case "11"://对子单选
					tmp = tmp.replace('01','AA').replace('02','22').replace('03','33').replace('04','44').replace('05','55')
					.replace('06','66').replace('07','77').replace('08','88').replace('09','99').replace('10','1010')
					.replace('11','JJ').replace('12','QQ').replace('13','KK');
					break;
				case "12":
					tmp = "同花包选";
					break;
				case "13":
					tmp = "同花顺包选";
					break;
				case "14":
					tmp = "顺子包选";
					break;
				case "15":
					tmp = "豹子包选";
					break;
				case "16":
					tmp = "对子包选";
					break;
				}
				if(tmp.indexOf('$') != '-1'){
					var arr = tmp.split('$');
					tmp = ' 胆:'+arr[0]+' 拖:'+arr[1];
				}
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']&nbsp;' + tmp +'<br>';
			}else{
				html += tmpCode[0];
			}
		}	
	}
	return html;
};

var matchopencode = function (lotid, pm, cm, cd, win){
	var rc = "",html = "";
	var wf = $_sys.getplayname(lotid, pm, cm, 0);
	if(lotid=="50"){
				var cdstr = cd.split("|");
				var qq = cdstr[0];
				var hq = cdstr[1];
				if(qq.indexOf("$")!=-1){
					rc += '<cite class="red">(' + qq.split("$")[0].replace(/,/g," ") + ')&nbsp;' +qq.split("$")[1].replace(/,/g," ")+ '</cite>&nbsp;';
				}else{
					rc += '<cite class="red">' + qq.replace(/,/g,' ') + '</cite>&nbsp;';
				}
				if(hq.indexOf("$")!=-1){
					rc += '<cite class="blue">(' + hq.split("$")[0].replace(/,/g," ") + ')&nbsp;' +hq.split("$")[1].replace(/,/g," ")+ '</cite>&nbsp;';
				}else{
					rc += '<cite class="blue">' + hq.replace(/,/g,' ') + '</cite>';
				}
	}else{
			var red = cd.split("|")[0];
			var blue = cd.split("|")[1];
			if(cd.indexOf("$")!=-1){
				var dt = red.split("$");
				rc += '<cite class="red">(' + dt[0].replace(/,/g," ") + ')&nbsp;' +dt[1].replace(/,/g," ")+ '</cite>&nbsp;';
				rc += '<cite class="blue">' + blue.replace(/,/g,' ') + '</cite>';
			}else{
				rc += '<cite class="red">' + red.replace(/,/g," ") + '</cite>&nbsp;';
				rc += '<cite class="blue">' + blue.replace(/,/g,' ') + '</cite>';
			}
	}
	if(wf!=""){
		if(pm == 2){
			html = '<p class="gray pdTop06">【追加】【' + wf + '】' + rc + '</p>';
		}else{
			html = '<p class="gray pdTop06">【' + wf + '】' + rc + '</p>';
		}
	}
	
	return html;
}

$_Y={
		getInt: function(val, def) {
			var d = parseInt(val, 10);
			return isNaN(d) ? (def || 0) : d
		}
}

function getcookie(name) {
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	return cookie_start == -1 ? '' : unescape(document.cookie.substring(
			cookie_start + name.length + 1,
			(cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}

function setcookie(name,value) {
	var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
};


function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

//排序方法
function s(obj1,obj2){
	if($(obj1).attr("cperiodid")>$(obj2).attr("cperiodid")){
		return -1;
	}else if($(obj1).attr("cperiodid")<$(obj2).attr("cperiodid")){
		return 1;
	}else{
		return 0;
	}
}
var code_58 = function(c) {//快乐扑克3开奖号码
	var kjcode = c.split(',');
	var ncode = '';
	if(kjcode != ''){
		for(var j=0;j<kjcode.length;j++){
			var aa = kjcode[j].substr(0,1);
			var bb = parseInt(kjcode[j].substr(1));
			switch (aa) {
			case "1":
				aa = "黑桃";
				break;
			case "2":
				aa = "红桃";
				break;
			case "3":
				aa = "梅花";
				break;
			case "4":
				aa = "方片";
				break;
			}
			switch (bb) {
			case 1:
				bb = "A";
				break;
			case 11:
				bb = "J";
				break;
			case 12:
				bb = "Q";
				break;
			case 13:
				bb = "K";
				break;
			}
			ncode += aa+bb;
			if(j != (kjcode.length-1)){
				ncode +=',';
			}
		}
	}
	return ncode;
};


function zeroStr(num, n) {
    var len = num.toString().length;
    while(len < n) {
        num = "0" + num;
        len++;
    }
    return num;
}

var level={
		1:"一等奖",
		2:"二等奖",
		3:"三等奖",
		4:"四等奖",
		5:"五等奖",
		6:"六等奖",
		7:"七等奖",
		8:"八等奖",
		9:"追加一等奖",
		10:"追加二等奖",
		11:"追加三等奖",
		12:"追加四等奖",
		13:"追加五等奖",
		14:"追加六等奖",
		15:"追加七等奖"
}

$_sys.lotpath = [];
$_sys.lotpath.push([ 1, "/ssq/" ]);
$_sys.lotpath.push([ 3, "/3d/" ]);
$_sys.lotpath.push([ 4, "/ssc/" ]);
$_sys.lotpath.push([ 5, "/k3/" ]);
$_sys.lotpath.push([ 6, "/ahk3/" ]);
$_sys.lotpath.push([ 7, "/qlc/" ]);
$_sys.lotpath.push([ 8, "/nmk3/" ]);
$_sys.lotpath.push([ 20, "/jxssc/" ]);

$_sys.lotpath.push([ 50, "/dlt/" ]);
$_sys.lotpath.push([ 51, "/qxc/" ]);

$_sys.lotpath.push([ 52, "/p5/" ]);
$_sys.lotpath.push([ 53, "/p3/" ]); 
$_sys.lotpath.push([ 54, "/11x5/" ]);
$_sys.lotpath.push([ 55, "/gd11x5/" ]);
$_sys.lotpath.push([ 56, "/11ydj/" ]);

$_sys.lotpath.push([ 80, "/sfc/" ]);
$_sys.lotpath.push([ 81, "/r9/" ]);
$_sys.lotpath.push([ 82, "/jq/" ]);
$_sys.lotpath.push([ 83, "/bq/" ]);

$_sys.lotpath.push([ 84, "/bjdc/" ]);
$_sys.lotpath.push([ 85, "/bjdc/" ]);
$_sys.lotpath.push([ 86, "/bjdc/" ]);
$_sys.lotpath.push([ 87, "/bjdc/" ]);
$_sys.lotpath.push([ 88, "/bjdc/" ]);
$_sys.lotpath.push([ 89, "/bjdc/" ]);

$_sys.lotpath.push([ 90, "/jczq/" ]);
$_sys.lotpath.push([ 91, "/jczq/" ]);
$_sys.lotpath.push([ 92, "/jczq/" ]);
$_sys.lotpath.push([ 93, "/jczq/" ]);
$_sys.lotpath.push([ 70, "/jczq/" ]);
$_sys.lotpath.push([ 72, "/jczq/" ]);

$_sys.lotpath.push([ 94, "/jclq/" ]);
$_sys.lotpath.push([ 95, "/jclq/" ]);
$_sys.lotpath.push([ 96, "/jclq/" ]);
$_sys.lotpath.push([ 97, "/jclq/" ]);
$_sys.lotpath.push([ 71, "/jclq/" ]);

$_sys.getlotpath = function(f,n) {
	if (typeof(n)=='undefined'){n=1;};
	for ( var i = 0; i < $_sys.lotpath.length; i++) {
		if ($_sys.lotpath[i][0] == $_Y.getInt(f)) {
			return $_sys.lotpath[i][n];
		}
	}
};

/**
 * 为方案详情提供目录匹配
 */
$_sys.lotfordetail = [];
$_sys.lotfordetail.push([ 1, "/ssq/" ]);
$_sys.lotfordetail.push([ 3, "/3d/" ]);
$_sys.lotfordetail.push([ 4, "/ssc/" ]);
$_sys.lotfordetail.push([ 7, "/qlc/" ]);
$_sys.lotfordetail.push([ 20, "/jxssc/" ]);
$_sys.lotfordetail.push([ 04, "/ssc/" ]);
$_sys.lotfordetail.push([ 05, "/k3/" ]);
$_sys.lotfordetail.push([ 06, "/ahk3/" ]);
$_sys.lotfordetail.push([ 08, "/nmk3/" ]);
$_sys.lotfordetail.push([ 09, "/jsk3/" ]);

$_sys.lotfordetail.push([ 50, "/dlt/" ]);
$_sys.lotfordetail.push([ 51, "/qxc/" ]);

$_sys.lotfordetail.push([ 52, "/p5/" ]);
$_sys.lotfordetail.push([ 53, "/p3/" ]); 
$_sys.lotfordetail.push([ 54, "/11x5/" ]);
$_sys.lotfordetail.push([ 55, "/gd11x5/" ]);
$_sys.lotfordetail.push([ 56, "/11ydj/" ]);
$_sys.lotfordetail.push([ 57, "/sh11x5/" ]);
$_sys.lotfordetail.push([ 58, "/pk3/" ]);

$_sys.lotfordetail.push([ 80, "/sfc/" ]);
$_sys.lotfordetail.push([ 81, "/r9/" ]);
$_sys.lotfordetail.push([ 82, "/jq/" ]);
$_sys.lotfordetail.push([ 83, "/bq/" ]);

$_sys.lotfordetail.push([ 84, "/sfgg/" ]);
$_sys.lotfordetail.push([ 85, "/bjdc/" ]);
$_sys.lotfordetail.push([ 86, "/bjdc/bf/" ]);
$_sys.lotfordetail.push([ 87, "/bjdc/bq/" ]);
$_sys.lotfordetail.push([ 88, "/bjdc/sx/" ]);
$_sys.lotfordetail.push([ 89, "/bjdc/jq/" ]);

$_sys.lotfordetail.push([ 90, "/jczq/rqspf/" ]);
$_sys.lotfordetail.push([ 91, "/jczq/bf/" ]);
$_sys.lotfordetail.push([ 92, "/jczq/bqc/" ]);
$_sys.lotfordetail.push([ 93, "/jczq/jq/" ]);
$_sys.lotfordetail.push([ 70, "/jczq/hh/" ]);
$_sys.lotfordetail.push([ 72, "/jczq/" ]);
$_sys.lotfordetail.push([ 98, "/jczq/gyj/" ]);
$_sys.lotfordetail.push([ 99, "/jczq/gyj/" ]);

$_sys.lotfordetail.push([ 71, "/jclq/hh/" ]);
$_sys.lotfordetail.push([ 94, "/jclq/sf/" ]);
$_sys.lotfordetail.push([ 95, "/jclq/" ]);
$_sys.lotfordetail.push([ 96, "/jclq/sfc/" ]);
$_sys.lotfordetail.push([ 97, "/jclq/dxf/" ]);

$_sys.getlotdir = function(f,n) {
	if (typeof(n)=='undefined'){n=1;};
	for ( var i = 0; i < $_sys.lotfordetail.length; i++) {
		if ($_sys.lotfordetail[i][0] == $_Y.getInt(f)) {
			return $_sys.lotfordetail[i][n];
		}
	}
};

//算注数 
$_sys.C = function(l, g) {
	var m = 1, n = 1;
	while (g >= 1) {
		m *= l;
		n *= g;
		l--;
		g--;
	}
	return m / n;
};

//生成随机数
function Random(count) {
    var original = new Array; //原始数组 
    //给原始数组original赋值 
	for (var i = 0; i < count; i++) {
        original[i] = i + 1;
    }
    original.sort(function() { return 0.5 - Math.random(); });
    var arrayList = new Array();
    for (var i = 0; i < count; i++) {
        arrayList[i] = original[i];
    }
    return arrayList;
}