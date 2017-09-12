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
$_sys.lot.push([ 92, "竞彩-半全场"]);
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
$_sys.addmoneytype.push([19,"建行支付"]);
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
$_sys.addmoneytype.push([3000,"微信支付(4g&触屏)"]);
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
$_sys.lotfordetail.push([ 87, "/bjdc/bqc/" ]);
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
//
var fonL_ = new Array();
var Count = {
	c: function(n,m){//n 过关方式    m 投注内容（每一排选了多少个号）
		var noteCount = 0;
		var passModeArray = n.split(',');
		 for (var i = 0; i < passModeArray.length; i++) {
			 noteCount += Count.d(passModeArray[i], m);
		 }
		return noteCount;
	},
	d: function(N, list){//单个过关方式的金额计算
		var count = 0;
		var paiList = list.split(',');
		fonL_ = new Array();
		Count.FastGroupNums("", 1, 1, N, paiList.length);
		for ( var m = 0; m < fonL_.length; m++) {
			var changciList = fonL_[m].split(',');
			var one = 1;
			for ( var k = 0; k < changciList.length; k++) {
				one *= paiList[parseInt(changciList[k], 10) - 1];
			}
			count += one;
		}
		return count; 
	},
	FastGroupNums: function(s, i, d, NumberLen, Numbers){
		for ( var n = i; n < Numbers - NumberLen + d + 1; n++) {
			if (d == NumberLen) {
				fonL_.push(s + n);
			} else {
				Count.FastGroupNums(s + n + ",", n + 1, d + 1, NumberLen, Numbers);
			}
		} 
	},
	division: function(p,info){//info?(max):(min) 
		p.sort(function(a,b){return a-b;});
		var i = (info && p[p.length-1])||p[0];
		return i;
	},
	prix: function(data,n){//data(sp) n(过关方式)
		var gg_ = n,min_pl=[],max_pl=[],
		d_min=[], d_max=[];
		data.map(function(sp) {
//			if (o.dan) {
//				d_max.push(+o.max);// 胆pl
//				d_min.push(+o.min);
//			} else {
				max_pl.push(+sp.max);
				min_pl.push(+sp.min);
//			}
		});
		if (!max_pl.length || !gg_) {
			return {
                min: 0,
                max: 0
                };
		} else {
            var pz = Count.max_prize(max_pl, gg_, d_max);
            var minpz = 1;
            	minpz = Count.min_prize(min_pl, gg_, d_min);
            return {
                min: minpz,
                max: pz
            };   
		}
	},
	max_prize: function(max_sp, gg_name, dan_sp){
		var max_prize = 0, hasDan = dan_sp && dan_sp.length > 0;
		gg_name = gg_name.split(',');
        $.each(gg_name,function(n,value) {
			var _n = parseInt(value)||1;
            if (hasDan) {
            	Math.dtl(dan_sp, max_sp, _n).each( function(sp) {
                	max_prize += sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
                }, this );
            }else{
            	var cl = Count.cl(max_sp, _n);
            	$.each(cl,function(a,b){
            		var x=1;
            		$.each(b,function(c,d){
            			x *= d;
            			
            		});
            		max_prize += x;
            	});
            }
		});
		max_prize *= 2;
		return max_prize = (+max_prize).toFixed(8);
	},
	min_prize: function(min_sp, gg_name, dan_sp){
		var min_prize = 0, hasDan = dan_sp && dan_sp.length > 0;
		gg_name = gg_name.split(',');
		$.each(gg_name, function(n,value) {
			var _n = parseInt(value)||1;
            if (hasDan) {
            	Math.dtl(dan_sp, min_sp, _n).each( function(sp) {
            		var prize = sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000;} );
                    if(prize<min_prize || min_prize==0){
                    	min_prize=prize;
                    }
                }, this );                        
            }else{
            	var cl = Count.cl(min_sp, _n);
            	$.each(cl,function(a,b){
            		var x=1;
            		$.each(b,function(c,d){
            			x *= d;
            			
            		});
            		if(x<min_prize || min_prize==0){
                    	min_prize=x;
                    }
            	});
            }
		});
		min_prize *= 2;
		return min_prize = (+min_prize).toFixed(8);
	},
	cl: function(arr, n, z) { // z is max count
		var r = [];
		fn([], arr, n);
		return r;
		function fn(t, a, n) {
			if (n === 0 || z && r.length == z) {
				return r[r.length] = t
			}
			for (var i = 0, l = a.length - n; i <= l; i++) {
				if (!z || r.length < z) {
					fn(t.concat(a[i]), a.slice(i + 1), n - 1);
				}
			}
		}
	},
	n: function(n){
		var t = '';
		t = {'亚特兰大梦想':'梦想',
				'芝加哥天空':'天空',
				'康涅狄格太阳':'太阳',
				'纽约自由':'自由人',
				'印第安纳狂热':'狂热',
				'华盛顿神秘人':'神秘人',
				'洛杉矶火花':'火花',
				'菲尼克斯水星':'水星',
				'明尼苏达天猫':'天猫',
				'西雅图风暴':'风暴',
				'塔尔萨震动':'震动',
				'圣安东尼奥银星':'银星',}[n]||n.substr(0,5);
		return t;
	}
};

//-----------------------------------------------------------------------------------------login.js
var start_ev = ("ontouchstart" in window) ? "touchstart" : "mousedown";
var end_ev = ("ontouchend" in window) ? "touchend" : "mouseup";
var move_ev = ("ontouchend" in window) ? "touchmove" : "mousemove";

/**
 * @namespace 彩票类
 * @name CP
 */
var CP = {};

/**
 * @namespace 数据类
 * @name Data
 * memberOf CP 
 */
CP.Data = {
		source : '3000'
};

CP.Util = {
		filterScript: function(str) {
		    str = str || "";
		    str = decodeURIComponent(str);
		    str = str.replace(/<.*>/g, "");
		    str = str.replace(/(java|vb|action)script/gi, "");
		    str = str.replace(/[\"\'][\s ]*([^=\"\'\s ]+[\s ]*=[\s ]*[\"\']?[^\"\']+[\"\']?)+/gi, "");
		    str = str.replace(/[\s ]/g, "&nbsp;");
		    return str;
		},getPara: function(name, url, num) {
		    var para = (typeof url == "undefined") ? window.location.search : url;
		    para = para.split("?");
		    if (!!num) {
		        para = (para[num] ? para[num] : para[para.length - 1]);
		    } else {
		        para = (typeof para[1] == "undefined") ? para[0] : para[1];
		    }
		    para = para.split("&");
		    for (var i = 0; para[i]; i++) {
		        para[i] = para[i].split("=");
		        if (para[i][0] == name) {
		            try {
		                return this.filterScript(para[i][1]);
		            } catch (e) {
		            }
		        }
		    }
		    return "";
		},getParaHash: function(name, url) {
		    var para = (typeof url == "undefined") ? window.location.href : url;
		    para = para.split("#");
		    para = (typeof para[1] == "undefined") ? para[0] : para[1];
		    para = para.split("&");
		    for (var i = 0; para[i]; i++) {
		        para[i] = para[i].split("=");
		        if (para[i][0] == name) {
		            try {
		                return this.filterScript(para[i][1]);
		            } catch (e) {
		            }
		        }
		    }
		    return "";
		}
};
CP.Storage = {
		set: function(name, value, type) {//名字  值  类型
		    var Storage = type ? "sessionStorage" : "localStorage";
		    switch (jQuery.type(value)) {
		        case "object":
		            value = "object:" + JSON.stringify(value);
		            break;
		        case "string":
		            value = "string:" + value;
		            break;
		    }
		    try {
		        window[Storage].setItem(name, value);
		    } catch (e) {
		        if (e == "QUOTA_EXCEEDED_ERR" && (navigator.userAgent.indexOf("iPhone") > -1 || navigator.userAgent.indexOf("iPad") > -1)) {
		            D.alert("为了正常运行网站，请关闭您终端的：设置?Safari?秘密浏览");
		        }
		    }
		},get: function(name, type) {
		    var Storage = type ? "sessionStorage" : "localStorage";
		    var value = window[Storage].getItem(name);
		    if (/^object:/.test(value)) {
		        value = JSON.parse(value.replace(/^object\:/, ""));
		    } else {
		        if (/^string:/.test(value)) {
		            value = value.replace(/^string\:/, "");
		        }
		    }
		    return value
		},remove: function(name, type) {
		    var Storage = type ? "sessionStorage" : "localStorage";
		    window[Storage].removeItem(name);
		}
};
//function pathname(){
//	if(window.location.pathname == '/m/'){
//		return true;
//	}else{
//		return false;
//	}
//}
$(function(){
	var ua = navigator.userAgent.toLowerCase();  
    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
    	CP.Data.source = '3001';
    }
	//微信进来的
	var fromMenu = location.search.getParam('fromMenu');
	fromMenu && localStorage.setItem('fromMenu',fromMenu);
    //from 代理商通常是有独立注册接口的
	var from = location.search.getParam('from');
	from && localStorage.setItem('from',from);
	//comeFrom 代理商通常是注册的时候直接可以其他的参数一起POST过去的
	var comeFrom = location.search.getParam('comeFrom');
	comeFrom && localStorage.setItem('comeFrom',comeFrom);
	
	if (!!from || !!comeFrom){//避免他之前有过代理
		!from && localStorage.removeItem('from');
		!comeFrom && localStorage.removeItem('comeFrom');
	}
//	$('.backHome').click(function(){
//		if(pathname()){
//			location.href='#class=home';
//		}else{
//			location.href='/';
//		}
//	});
	
});
		//登录方法
		function MiniLogin() {
			var go = localStorage.getItem('callback');
		    var uname = $("#username").val();
		    var upwd = $("#password").val();
		    if (uname == "") { 
		    	$("#username").focus();
		        D.alert('请输入合法的用户名!');
		        return false;
		    }else if (upwd == "") {
		    	$("#password").focus();
		        return false;
		    }
		    else{
			var data = "uid=" + encodeURIComponent(uname)+ "&pwd=" + encodeURIComponent(upwd);
		    $.ajax({
		    	url: '/user/login.go',
		        type: "POST",
		        dataType : "xml",
		        data: data,
		        cache: false,
		        success:function (data){
		        	var R = $(data).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if (code == "0") {
						localStorage.setItem("username", uname);
						D.tx(desc);
						setTimeout(function(){
							if(!!go){
								window.location.replace(go);
								localStorage.removeItem('callback');
							} else{
								
								if(/ipad|iphone|mac/i.test(navigator.userAgent)){
									window.location.href="#class=url&xo=useraccount/index.html";
								}
								else{
									window.history.back(-1);
								}
							}
						},1000);
					}else{
						D.tx(desc);
					}
					$("#auth_userId").val("");
					$("#auth_passwd").val("");
		          }		        
		    });
		    }
		}
	//检查是否登录-weige
	function checkLogin(fn,u) {//u 当登录完不是回到上一个页面的时候 用u来指定回跳位置
		$.ajax({
	        url: "/user/mchklogin.go",
	        type: "POST",
	        success:function (data){
	     	    var R = $(data).find("Resp");
	 			var code = R.attr("code");
	 			if (code == "10001") {
	 				if(fn != undefined){
	 					fn();
	 				}
	 			}else{
	 				var agent = localStorage.getItem('from');
	 				var fromMenu = localStorage.getItem('fromMenu');
	 				if(agent == 'azcp'){
	 					window.location.href="http://4g.9188.com/user/allylogin.go?type=10";
	 				}else if(agent == 'dianhua'){
	 					window.location.href="http://4g.9188.com/user/touchlogin.go?type=14";
	 				}else if(agent == 'cib'){
	 					window.location.href="http://4g.9188.com/user/touchlogin.go?type=15";
	 				}else if(fromMenu == 'wxfw'){
	 					window.location.href="/wxbind/";
	 				}else{
	 					if(!!u){
	 						localStorage.setItem('callback', u);
	 					}else{
	 						localStorage.removeItem('callback');
	 					}
 						window.location.href="/#class=url&xo=login/index.html";
	 				}
	 			}
	        }
		});

	}
	String.prototype.getParam = function(n){
		var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
		var r1=new RegExp(n+"=","gi");
		var m=this.match(r);
		if(m==null){
			return "";
		}else{
			return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
		}
	};
var alert1 =  '<section id="dAlert" class="zfPop weige_" style="position: fixed;z-index: 1000">'+
		'<h4>提示</h4><p class="pdTop03 center"></p>'+
		'<a href="javascript:;" class="tureBtn">确定</a></section>';

var confirm1 = '<section id="dConfirm" class="zfPop weige_" style="position: fixed;z-index: 1000">'+
		'<h4>提示</h4><div class="clearfix pdLeft08 center"></div>'+
		'<div class="zfTrue clearfix"><a href="javascript:;" class="zfqx">取 消</a><a href="javascript:;">确 定</a></div></section>';
	
var Mask1 = '<div id="Mask" style="position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;"></div>';

//<!-- 菊花台 -->
var load1 = '<div class="loadpop" id="rotate_load"><em class="rotate_load"></em></div><div class="zhezhao3"></div>';

var D = {//吊
		load : function (close) {
			if(close){
				$('#rotate_load,.zhezhao3').hide();
			}else{
				if($('#rotate_load').html() != undefined){
					$('#rotate_load,.zhezhao3').show();
				}else{
					$('body').append(load1);
				}
			}
		},
		alert:function(msg,fn,tag){
			if($('#dAlert').html() != undefined){
				$('#Mask').show();
				$('#dAlert').show();
			}else{
				$('body').append(alert1);
				if($('#Mask').html() != undefined){
					$('#Mask').show();
				}else{
					$('body').append(Mask1);
				}
			}
			if(tag != undefined){
				$('#dAlert a.tureBtn').html(tag);
			}else{
				$('#dAlert a.tureBtn').html('确定');
			}
			$('#dAlert p.center').html(msg);
			
			
			$('#dAlert').css({left:'50%',top:'50%',marginLeft:'-9rem',marginTop:'-'+($("#dAlert").height()/2)+'px'});
			$('#dAlert a.tureBtn,#Mask').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$('#Mask').hide();
			});
		},
		confirm:function(msg,fn){
			if($('#dConfirm').html() != undefined){
				$('#Mask').show();
				$('#dConfirm').show();
			}else{
				$('body').append(confirm1);
				if($('#Mask').html() != undefined){
					$('#Mask').show();
				}else{
					$('body').append(Mask1);
				}
			}
			$('#dConfirm div.center').html(msg);
			$('#dConfirm').css({left:parseInt(document.documentElement.clientWidth/2-$(".zfPop").width()/2),top:parseInt(document.documentElement.clientHeight/2-$(".zfPop").height())});
			$('#dConfirm a:eq(0)').click(function(){
				$('#dConfirm').hide();
				$('#Mask').hide();
			});
			$('#dConfirm a:eq(1)').click(function(){
				if(typeof(fn) == "function"){
					fn();
					$('#Mask').hide();
					$('#dConfirm').hide();
				}else{
					$('#Mask').hide();
					$('#dConfirm').hide();
				}
			});
		},
		msg:function(msg){
			clearTimeout(window.alert.time);
		    var obj = $('<div class="alertBox">'+msg+'</div>');
		    $("body").append(obj);
		    window.alert.time = setTimeout(function() {
		        $(".alertBox").remove();
		    }, 2000);
		},
		tx:function(msg){
			var tx_speed =  '1500';
			var tx_ml = '-5rem';
			if(msg.length>8){
				$('#tx_c').css({width:'16rem'});
				tx_speed = '2500';
				tx_ml = '-8rem';
			}
			
			$('#tx_c').html('&nbsp;&nbsp;'+msg+'&nbsp;&nbsp;');
			$('#tx_c').show();
			
			$('#tx_c').css({left:'50%',marginLeft:tx_ml});
			setTimeout(function(){
			  	$('#tx_c').slideUp();
		    },tx_speed);
		}
};

function stealth(){
	try{
		localStorage.setItem('stealth','stealth');
	}catch(e){
		alert('由于您可能开启了"无痕浏览"模式，导致无法正常访问，请检查浏览器设置后再试，如有问题请致电客服：400-673-9188');
		return false;
	};
}
$.fn.Touch = function(a) {
    var b = move_ev;
    this.each(function() {
        var c = $(this).eq(0);
        var d = false;
        var e = 0;
        c.on(b, function() {
            d = true;
            clearTimeout(e);
            e = setTimeout(function() {
                d = false;
            }, 250);
        });
        if (a.children) {
            c.on(end_ev, a.children, function(f) {
                if (d && end_ev == "touchend") {
                    d = false;
                    f.stopPropagation();
                    return false;
                }
                a.fun.call(this, this);
            });
        } else {
            c.on(end_ev, function(f) {
                if (d && end_ev == "touchend") {
                    d = false;
                    f.stopPropagation();
                    return 0;
                }
                a.apply(this, [this, f]);
            });
        }
    });
};
