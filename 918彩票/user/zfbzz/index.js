var CP = {};
CP.MobileVer = function($) {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false
	};
	obj.android = u.indexOf("Android") > -1 || u.indexOf("Linux") > -1;
	obj.ios = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
	obj.ipad = u.indexOf("iPad") > -1;
	if (obj.ios) {
		if (u.indexOf("7_") > -1) {
			obj.ios7 = true
		}
	}
	return obj
} ();
String.prototype.getParam = function(n) {
	var r = new RegExp("[?&]" + n + "=([^&?]*)(\\s||$)", "gi");
	var r1 = new RegExp(n + "=", "gi");
	var m = this.match(r);
	if (m == null) {
		return ""
	} else {
		return typeof m[0].split(r1)[1] == "undefined" ? "": decodeURIComponent(m[0].split(r1)[1])
	}
};
var win_alert = alert;
window["alert"] = function(msg) {
	if ($(".alertBox").length) {
		document.body.removeChild($(".alertBox"))
	}
	clearTimeout(window.alert.time);
	var el = document.createElement("div");
	el.innerHTML = msg;
	el.setAttribute("class", "alertBox");
	document.body.appendChild(el);
	window.alert.time = setTimeout(function() {
		document.body.removeChild(el)
	},
	1e3)
};
function $(dom) {
	var querySelectorAll = document.querySelectorAll(dom),
	aa;
	if (querySelectorAll.length == 1) {
		aa = querySelectorAll[0];
		aa.length = 1
	} else {
		aa = querySelectorAll
	}
	return aa
}
var g = {
	money: 0,
	source: "",
	alipayId: "",
	orderId: "",
	userName: ""
};
Array.prototype.each = function(callback) {
	for (var i = 0; i < this.length; i++) {
		callback.call(this, this[i])
	}
};
var xmlhttp;
function loadXMLDoc(url, type, func, data) {
	xmlhttp = null;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest
	} else if (window.ActiveXObject) {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
	}
	if (xmlhttp != null) {
		xmlhttp.overrideMimeType("text/xml");
		if (func) {
			xmlhttp.onreadystatechange = func
		}
		xmlhttp.open(type, url, false);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		if (data) {
			xmlhttp.send(data)
		} else {
			xmlhttp.send(null)
		}
	} else {
		alert("您的浏览器不支持XMLHTTP.")
	}
}
function getUser() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var Resp = xmlhttp.responseXML.getElementsByTagName("Resp");
			var code = Resp[0].getAttribute("code");
			var desc = Resp[0].getAttribute("desc");
			if (code != 0) {
				return alert(desc)
			}
			var row = xmlhttp.responseXML.getElementsByTagName("row");
			var uid = row[0].getAttribute("nickid");
			$("#name").innerHTML = uid;
			$("#userName").value = uid
		} else {
			alert("请求服务器失败！")
		}
	}
}
function Callback() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var Resp = xmlhttp.responseXML.getElementsByTagName("Resp");
			var code = Resp[0].getAttribute("code");
			var desc = Resp[0].getAttribute("desc");
			alert(CP.MobileVer.android);
			if (CP.MobileVer.android) {
				return alert(desc)
			}
			$("#popup2 h4").innerHTML = desc;
			$("#popup2").style.display = "block";
			$(".zhezhao").style.display = "block"
		} else {
			alert("请求服务器失败！")
		}
	}
	setTimeout(function() {
		$(".btn2").innerHTML = "提交审核"
	},
	6e4)
}
function Callback2() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var Resp = xmlhttp.responseXML.getElementsByTagName("Resp");
			var code = Resp[0].getAttribute("code");
			var desc = Resp[0].getAttribute("desc");
			if (code != 0) {
				return alert(desc)
			}
			if (CP.MobileVer.android) {
				window.location.href = "https://ds.alipay.com/?from=mobilecodec&scheme=alipayqr%3A%2F%2Fplatformapi%2Fstartapp%3FsaId%3D10000007%26clientVersion%3D3.7.0.0718%26qrcode%3Dhttps%253A%252F%252Fqr.alipay.com%252Fapx06138bfovie5ys9rj44a%253F_s%253Dweb-other"
			} else if (CP.MobileVer.ios || CP.MobileVer.ipad) {
				window.location.href = "https://ds.alipay.com/?plg_nld=1&scheme=alipayqr%3A%2F%2Fplatformapi%2Fstartapp%3FsaId%3D10000007%26clientVersion%3D3.7.0.0718%26qrcode%3Dhttps%253A%252F%252Fqr.alipay.com%252Fapx06138bfovie5ys9rj44a%253F_s%253Dweb-other"
			}
		} else {
			alert("请求服务器失败！")
		}
	}
}
function bindEvent() {
	$("#selectMoney").addEventListener("touchend",
	function(e) {
		if (e.target.tagName == "LI") {
			$("#selectMoney .cur").length > 0 ? $("#selectMoney .cur").setAttribute("class", "") : "";
			e.target.setAttribute("class", "cur");
			$("#payMoney").value = e.target.getAttribute("value");
			$(".btn").setAttribute("class", "btn btncur")
		}
	});
	$("#payMoney").addEventListener("keyup",
	function() {
		var money = $("#payMoney").value;
		if (money > 0) {
			$(".btn").setAttribute("class", "btn btncur");
			$("#selectMoney .cur").length > 0 ? $("#selectMoney .cur").setAttribute("class", "") : "";
			if ($('#selectMoney li[value="' + money + '"]').length > 0) {
				$('#selectMoney li[value="' + money + '"]').setAttribute("class", "cur")
			}
		} else {
			$(".btn").setAttribute("class", "btn");
			$("#selectMoney .cur").length > 0 ? $("#selectMoney .cur").setAttribute("class", "") : ""
		}
	});
	$(".btn").addEventListener("touchend",
	function() {
		if ($("#selectMoney .btncur").length < 1) {
			return false
		}
		if (!$("#payMoney").value) {
			return alert("请输入转账金额!")
		}
		if ($("#payMoney").value > 5e4) {
			$("#payMoney").value = 5e4;
			return alert("支付宝转账每次最多50000元")
		}
		if ($("#payMoney").value < 10) {
			$("#payMoney").value = 10;
			$('#selectMoney li[value="10"]').setAttribute("class", "cur");
			return alert("支付宝转账每次最少10元")
		}
		$("#popup").style.display = "block";
		$(".zhezhao").style.display = "block"
	});
	$("#gotIt").addEventListener("touchend",
	function() {
		$("#popup").style.display = "none";
		$(".zhezhao").style.display = "none";
		g.userName = $("#name").innerHTML;
		g.money = $("#payMoney").value;
		var data = "addmoney=" + g.money + "&bankid=" + g.source + "&handleflag=1&accesstoken=" + g.token + "&appid=" + g.appid + "&logintype=1";
		loadXMLDoc("http://5.9188.com /user/addmoney.go", "POST", Callback2, data)
	});
	$(".notAccount").addEventListener("touchend",
	function() {
		$("#account").style.display = "none";
		$("#notAccount").style.display = "block"
	});
	document.getElementById('alipayId').addEventListener("input", bindTrigger, false);
	document.getElementById('orderId').addEventListener("input", bindTrigger, false);
	document.getElementById('payMoney2').addEventListener("input", bindTrigger, false);
	//$("#notAccount").addEventListener("keyup",bindTrigger);
	$(".btn2").addEventListener("touchend",
	function() {
		if ($(".btn2cur").length < 1) {
			return false
		}
		if ($(".btn2").innerHTML == "补单请求已提交") {
			return alert("补单请求已提交，请一分钟后重试！")
		}
		g.userName = $("#userName").value ? $("#userName").value: "";
		g.alipayId = $("#alipayId").value ? $("#alipayId").value: "";
		g.orderId = $("#orderId").value ? $("#orderId").value: "";
		g.money = $("#payMoney2").value ? $("#payMoney2").value: "";
		if (!g.userName) {
			return alert("请输入您的9188用户名")
		}
		if (!g.alipayId) {
			return alert("请输入您的支付宝账户名")
		}
		if (!g.orderId) {
			return alert("请输入您的转账订单号")
		}
		if (!g.money) {
			return alert("请输入您的转账金额")
		}
		if (!/^[+-]?\d+(\.\d+)?$/.test(g.money)) {
			return alert("您输入的转账金额有误")
		}
		if (g.money > 5e4) {
			g.money = 5e4;
			$("#payMoney2").value = 5e4;
			return alert("支付宝转账每次最多50000元")
		}
		if (g.money < 1) {
			g.money = 1;
			$("#payMoney2").value = 1;
			return alert("支付宝转账每次最少1元")
		}
		var data = "addmoney=" + g.money + "&bankid=" + g.source + "&handleflag=2&tradeno=" + g.orderId + "&dealid=" + g.alipayId + "&accesstoken=" + g.token + "&appid=" + g.appid + "&logintype=1";
		$(".btn2").innerHTML = "补单请求已提交";
		g.alipayId = $("#alipayId").value = "";
		g.orderId = $("#orderId").value = "";
		g.money = $("#payMoney2").value = "";
		$(".btn2").setAttribute("class", "btn2");
		loadXMLDoc("http://5.9188.com /user/addmoney.go", "POST", Callback, data)
	});
	$(".zhezhao").addEventListener("touchend",
	function() {
		$("#popup").style.display = "none";
		$("#popup2").style.display = "none";
		$(".zhezhao").style.display = "none"
	});
	$("#idKonw").addEventListener("touchend",
	function() {
		$("#popup2").style.display = "none";
		$(".zhezhao").style.display = "none"
	});
	$("#btn_prev").addEventListener("touchend",
	function() {
		if (CP.MobileVer.android) {
			try {
				window.location.href = "caiyi://mobilelottery"
			} catch(e) {}
		} else if (CP.MobileVer.ios || CP.MobileVer.ipad) {
			try {
				window.location.href = "caiyi9188Lottery15697game://"
			} catch(e) {}
		}
	});
	$("#iKonw").addEventListener("touchend",
	function() {
		$("#popup2").style.display = "none";
		$(".zhezhao").style.display = "none";
		if (CP.MobileVer.android) {
			try {
				window.location.href = "caiyi://mobilelottery"
			} catch(e) {}
		} else if (CP.MobileVer.ios || CP.MobileVer.ipad) {
			try {
				window.location.href = "caiyi9188Lottery15697game://"
			} catch(e) {}
		}
	})
}
function bindTrigger() {
	if ($("#userName").value && $("#alipayId").value && $("#orderId").value && $("#payMoney2").value) {
		$(".btn2").setAttribute("class", "btn2 btn2cur")
	} else {
		$(".btn2").setAttribute("class", "btn2")
	}
}
var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars = new Array( - 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
function base64decode(str) {
	var c1, c2, c3, c4;
	var i, len, out;
	len = str.length;
	i = 0;
	out = "";
	while (i < len) {
		do {
			c1 = base64DecodeChars[str.charCodeAt(i++) & 255]
		} while ( i < len && c1 == - 1 );
		if (c1 == -1) break;
		do {
			c2 = base64DecodeChars[str.charCodeAt(i++) & 255]
		} while ( i < len && c2 == - 1 );
		if (c2 == -1) break;
		out += String.fromCharCode(c1 << 2 | (c2 & 48) >> 4);
		do {
			c3 = str.charCodeAt(i++) & 255;
			if (c3 == 61) return out;
			c3 = base64DecodeChars[c3]
		} while ( i < len && c3 == - 1 );
		if (c3 == -1) break;
		out += String.fromCharCode((c2 & 15) << 4 | (c3 & 60) >> 2);
		do {
			c4 = str.charCodeAt(i++) & 255;
			if (c4 == 61) return out;
			c4 = base64DecodeChars[c4]
		} while ( i < len && c4 == - 1 );
		if (c4 == -1) break;
		out += String.fromCharCode((c3 & 3) << 6 | c4)
	}
	return out
}
function utf8to16(str) {
	var out, i, len, c;
	var char2, char3;
	out = "";
	len = str.length;
	i = 0;
	while (i < len) {
		c = str.charCodeAt(i++);
		switch (c >> 4) {
		case 0:
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
			out += str.charAt(i - 1);
			break;
		case 12:
		case 13:
			char2 = str.charCodeAt(i++);
			out += String.fromCharCode((c & 31) << 6 | char2 & 63);
			break;
		case 14:
			char2 = str.charCodeAt(i++);
			char3 = str.charCodeAt(i++);
			out += String.fromCharCode((c & 15) << 12 | (char2 & 63) << 6 | (char3 & 63) << 0);
			break
		}
	}
	return out
}
function init() {
	if (CP.MobileVer.android) {
		$("#box_header").style.display = "none"
	}
	var appversion = location.search.getParam("appversion").replace(/\./g,"");
	if(appversion >= 433){//版本小于4.3.3
		$('#box_header').style.display = "none";
	}else{
		$('#popup').innerHTML = '<h4>转账说明</h4>\
		    <p>在支付宝页面备注处请填写\
		    	<span id="name"></span>\
		    	<cite>(您的9188彩票用户名)</cite>\
		    	否则将无法自动到账\
		    </p>\
			<a href="javascript:;" id="gotIt">知道了</a>';
	$('#popup').setAttribute("class", "popup popup4");
	}
	bindEvent();
	g.money = location.search.getParam("money");
	var source = location.search.getParam("source");
	if (g.money > 0) {
		$(".btn").setAttribute("class", "btn btncur");
		$("#payMoney").value = g.money;
		if ($('#selectMoney li[value="' + g.money + '"]').length > 0) {
			$('#selectMoney li[value="' + g.money + '"]').setAttribute("class", "cur")
		}
	}
	if (source > 999 && source < 2001) {
		g.source = "24"
	} else if (source > 2e3 && source < 3001) {
		g.source = "25"
	}
	var token = location.search.getParam("TOKEN");
	var appid = location.search.getParam("APPID");
	token = base64decode(token);
	appid = base64decode(appid);
	var allcookies = document.cookie;
	if (token && appid) {
		g.token = escape(token).replace(/\+/g, "%2B");
		g.appid = appid;
		var data = "flag=6&accesstoken=" + g.token + "&appid=" + g.appid + "&logintype=1";
		loadXMLDoc("http://5.9188.com /user/query.go", "POST", getUser, data)
	} else if (allcookies.indexOf("TOKEN") != "-1") {
		allcookies = allcookies.split("&");
		allcookies.each(function(val) {
			if (val.indexOf("TOKEN=") >= 0) {
				g.token = val.split("TOKEN=")[1];
				g.token = escape(g.token).replace(/\+/g, "%2B")
			}
			if (val.indexOf("APPID=") >= 0) {
				g.appid = val.split("APPID=")[1]
			}
		});
		var data = "flag=6&accesstoken=" + g.token + "&appid=" + g.appid + "&logintype=1";
		loadXMLDoc("http://5.9188.com /user/query.go", "POST", getUser, data)
	} else {
		if (CP.MobileVer.android) {
			try {
				window.caiyiandroid.clickAndroid(3, "")
			} catch(e) {}
		} else if (CP.MobileVer.ios || CP.MobileVer.ipad) {
			try {
				WebViewJavascriptBridge.callHandler("clickIosLogin")
			} catch(e) {}
		} else {}
	}
}
init();