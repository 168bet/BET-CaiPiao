var TouchSlide=function(a){a=a||{};var b={slideCell:a.slideCell||'#touchSlide',titCell:a.titCell||'.hd li',mainCell:a.mainCell||'.bd',effect:a.effect||'left',autoPlay:a.autoPlay||!1,delayTime:a.delayTime||200,interTime:a.interTime||2500,defaultIndex:a.defaultIndex||0,titOnClassName:a.titOnClassName||'cur',autoPage:a.autoPage||!1,prevCell:a.prevCell||'.prev',nextCell:a.nextCell||'.next',pageStateCell:a.pageStateCell||'.pageState',pnLoop:'undefined '==a.pnLoop?!0:a.pnLoop,startFun:a.startFun||null,endFun:a.endFun||null,switchLoad:a.switchLoad||null},c=document.getElementById(b.slideCell.replace('#',''));if(!c)return!1;var d=function(a,b){a=a.split(' ');var c=[];b=b||document;var d=[b];for(var e in a)0!=a[e].length&&c.push(a[e]);for(var e in c){if(0==d.length)return!1;var f=[];for(var g in d)if('#'==c[e][0])f.push(document.getElementById(c[e].replace('#','')));else if('.'==c[e][0])for(var h=d[g].getElementsByTagName('*'),i=0;i<h.length;i++){var j=h[i].className;j&&-1!=j.search(new RegExp('\\b'+c[e].replace('.','')+'\\b'))&&f.push(h[i])}else for(var h=d[g].getElementsByTagName(c[e]),i=0;i<h.length;i++)f.push(h[i]);d=f}return 0==d.length||d[0]==b?!1:d},e=function(a,b){var c=document.createElement('div');c.innerHTML=b,c=c.children[0];var d=a.cloneNode(!0);return c.appendChild(d),a.parentNode.replaceChild(c,a),m=d,c},g=function(a,b){!a||!b||a.className&&-1!=a.className.search(new RegExp('\\b'+b+'\\b'))||(a.className+=(a.className?' ':'')+b)},h=function(a,b){!a||!b||a.className&&-1==a.className.search(new RegExp('\\b'+b+'\\b'))||(a.className=a.className.replace(new RegExp('\\s*\\b'+b+'\\b','g'),''))},i=b.effect,j=d(b.prevCell,c)[0],k=d(b.nextCell,c)[0],l=d(b.pageStateCell)[0],m=d(b.mainCell,c)[0];if(!m)return!1;var N,O,n=m.children.length,o=d(b.titCell,c),p=o?o.length:n,q=b.switchLoad,r=parseInt(b.defaultIndex),s=parseInt(b.delayTime),t=parseInt(b.interTime),u='false'==b.autoPlay||0==b.autoPlay?!1:!0,v='false'==b.autoPage||0==b.autoPage?!1:!0,w='false'==b.pnLoop||0==b.pnLoop?!1:!0,x=r,y=null,z=null,A=null,B=0,C=0,D=0,E=0,G=/hp-tablet/gi.test(navigator.appVersion),H='ontouchstart'in window&&!G,I=H?'touchstart':'mousedown',J=H?'touchmove':'',K=H?'touchend':'mouseup',M=m.parentNode.clientWidth,P=n;if(0==p&&(p=n),v){p=n,o=o[0],o.innerHTML='';var Q='';if(1==b.autoPage||'true'==b.autoPage)for(var R=0;p>R;R++)Q+='<li></li>';else for(var R=0;p>R;R++)Q+=b.autoPage.replace('$',R+1);o.innerHTML=Q,o=o.children}'leftLoop'==i&&(P+=2,m.appendChild(m.children[0].cloneNode(!0)),m.insertBefore(m.children[n-1].cloneNode(!0),m.children[0])),N=e(m,'<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'),m.style.cssText='width:'+P*M+'px;'+'position:relative;overflow:hidden;padding:0;margin:0;';for(var R=0;P>R;R++)m.children[R].style.cssText='display:table-cell;vertical-align:top;width:'+M+'px';var S=function(){'function'==typeof b.startFun&&b.startFun(r,p)},T=function(){'function'==typeof b.endFun&&b.endFun(r,p)},U=function(a){var b=('leftLoop'==i?r+1:r)+a,c=function(a){for(var b=m.children[a].getElementsByTagName('img'),c=0;c<b.length;c++)b[c].getAttribute(q)&&(b[c].setAttribute('src',b[c].getAttribute(q)),b[c].removeAttribute(q))};if(c(b),'leftLoop'==i)switch(b){case 0:c(n);break;case 1:c(n+1);break;case n:c(0);break;case n+1:c(1)}},V=function(){M=N.clientWidth,m.style.width=P*M+'px';for(var a=0;P>a;a++)m.children[a].style.width=M+'px';var b='leftLoop'==i?r+1:r;W(-b*M,0)};var W=function(a,b,c){c=c?c.style:m.style,c.webkitTransitionDuration=c.MozTransitionDuration=c.msTransitionDuration=c.OTransitionDuration=c.transitionDuration=b+'ms',c.webkitTransform='translate('+a+'px,0)'+'translateZ(0)',c.msTransform=c.MozTransform=c.OTransform='translateX('+a+'px)'},X=function(a){switch(i){case'left':r>=p?r=a?r-1:0:0>r&&(r=a?0:p-1),null!=q&&U(0),W(-r*M,s),x=r;break;case'leftLoop':null!=q&&U(0),W(-(r+1)*M,s),-1==r?(z=setTimeout(function(){W(-p*M,0)},s),r=p-1):r==p&&(z=setTimeout(function(){W(-M,0)},s),r=0),x=r}S(),A=setTimeout(function(){T()},s);for(var c=0;p>c;c++)h(o[c],b.titOnClassName),c==r&&g(o[c],b.titOnClassName);0==w&&(h(k,'nextStop'),h(j,'prevStop'),0==r?g(j,'prevStop'):r==p-1&&g(k,'nextStop')),l&&(l.innerHTML='<span>'+(r+1)+'</span>/'+p)};if(X(),u&&(y=setInterval(function(){r++,X()},t)),o)for(var R=0;p>R;R++)!function(){var a=R;o[a].addEventListener('click',function(){clearTimeout(z),clearTimeout(A),r=a,X()})}();k&&k.addEventListener('click',function(){(1==w||r!=p-1)&&(clearTimeout(z),clearTimeout(A),r++,X())}),j&&j.addEventListener('click',function(){(1==w||0!=r)&&(clearTimeout(z),clearTimeout(A),r--,X())});var Y=function(a){clearTimeout(z),clearTimeout(A),O=void 0,D=0;var b=H?a.touches[0]:a;B=b.pageX,C=b.pageY,m.addEventListener(J,Z,!1),m.addEventListener(K,$,!1)},Z=function(a){if(!H||!(a.touches.length>1||a.scale&&1!==a.scale)){var b=H?a.touches[0]:a;if(D=b.pageX-B,E=b.pageY-C,'undefined'==typeof O&&(O=!!(O||Math.abs(D)<Math.abs(E))),!O){switch(a.preventDefault(),u&&clearInterval(y),i){case'left':(0==r&&D>0||r>=p-1&&0>D)&&(D=0.4*D),W(-r*M+D,0);break;case'leftLoop':W(-(r+1)*M+D,0)}null!=q&&Math.abs(D)>M/3&&U(D>-0?-1:1)}}},$=function(a){0!=D&&(a.preventDefault(),O||(Math.abs(D)>M/10&&(D>0?r--:r++),X(!0),u&&(y=setInterval(function(){r++,X()},t))),m.removeEventListener(J,Z,!1),m.removeEventListener(K,$,!1))};m.addEventListener(I,Y,!1)};
/**
 * 定义全局事件
 */
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var end_ev = ('ontouchend' in window ) ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';

/**
 * @description 把Number设置为指定小数位数的数字, 主要用于金额截取(不进行四舍五入,直接截取)
 * @param {String|Number} n 小数位数
 * @return {String}
 * @example
 var i='123.45678'
 i.toFixed();//123.45
 i.toFixed(3);//123.456
 */
Number.prototype.fix = function (n) {
	var val = String(this);
	n = Math.abs(n);
	val = val.split('.');
	val[1] = val[1] || '';
	var m = val[1].length;
	if (m < n) { // 小数位数少于要截取的位数
		m = n - m;
		while (m > 0) {
			val[1] += '0';
			m--;
		}
	}
	return val[0] + ((n > 0) ? ('.' + val[1].substr(0, n)) : '');
};
/**
 * @namespace 彩票类
 * @name CP
 */
//http://apps.h5.9188.com 
//http://zlk.h5.9188.com 
//http://news.h5.9188.com 
//http://data.h5.9188.com 
var CP = {};
CP.Data = {
		source : '3002',//投注source值
		pid : '',//首页双色球大乐透的当前期号
		apps:'',//动态接口
		zlk:'',//资料库
		news:'',//新闻
		data:''//xml
		
};
/**
 * @description 获取当前渠道
 * @author classyuan
 * @return {String}
 * @memberOf CP
 */
CP.Channel = function () {
	var name = '';
	/**
	 * @description 返回当前渠道
	 * @return {String}
	 * @example CP.Channel.get();
	 * @memberOf CP.Channel
	 */
	var getName = function () {
		if (name === '') {
			var pathname = window.location.pathname || '/';
			pathname = pathname.split('/');
			name = pathname[1];
		}
		return ('/' + name + '/');
	};
	return {get: getName};
}();
var hostUrl = '';
/**
 * @description 获取手机系统
 * @return {object}
 * @example CP.MobileVer.android;
 * @memberOf CP
 */
CP.MobileVer = (function () {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();
/**
 * @description 转时区
 * @param {Date} d 时间
 * @param {String} offset 时区
 * @return {Number} 毫秒
 * @example
 var d= new Date()本地时间&无论他是哪个时区
 calcTime(d, '+8'); 返回当前北京时间 */
CP.calcTime = function (d, offset) {
	utc = d.getTime() + (d.getTimezoneOffset() * 60000);
	var nd = new Date(utc + (3600000*offset));
	return nd;
};
/**
 * @description 获取数据类型
 * @author lilian
 * @return {String} 如：null
 */
CP.getType = function (o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
};
/**
 * @namespace 数学计算类
 * @name math
 * @memberOf CP
 */
CP.math = {
	/**
	 * @description 排列总数
	 * @param {Int} n 总数
	 * @param {Int} m 组合位数
	 * @return {Int}
	 * @example CP.math.C(6,5);
	 * @memberOf CP.math
	 */
	C: function (n, m) {
		var n1 = 1, n2 = 1;
		for (var i = n, j = 1; j <= m; n1 *= i--, n2 *= j++) {
		}
		return n1 / n2;
	},
	/**
	 * @description 组合总数
	 * @param {Int} n 总数
	 * @param {Int} m 组合位数
	 * @return {Int}
	 * @example CP.math.P(5,3); 60
	 * @memberOf CP.math
	 */
	P: function (n, m) {
		var n1 = 1, n2 = 1;
		for (var i = n, j = 1; j <= m; n1 *= i--, n2 *= j++) {
		}
		return n1;
	},
	/**
	 * @description 枚举数组算法
	 * @param {Int} n 数组长度
	 * @param {Int|Array} m 枚举位数
	 * @return {Int}
	 * @example CP.math.Cs(4,3);  [[1,2,3],[1,2,4],[1,3,4],[2,3,4]]
	 * @memberOf CP.math
	 */
	Cs: function (len, num) {
		var arr = [];
		if (typeof(len) == 'number') {
			for (var i = 0; i < len; i++) {
				arr.push(i + 1);
			}
		} else {
			arr = len;
		}
		var r = [];
		(function f(t, a, n) {
			if (n == 0) return r.push(t);
			for (var i = 0, l = a.length; i <= l - n; i++) {
				f(t.concat(a[i]), a.slice(i + 1), n - 1);
			}
		})([], arr, num);
		return r;
	},
	/**
	 * @description 获取竞彩N串1注数
	 * @param {Array} spArr [2,2,1] 每一场选中的个数
	 * @param {Int} n n串1
	 * @return {Int}
	 * @example CP.math.N1([2,2,1],3);
	 * @memberOf CP.math
	 */
	N1: function (spArr, n) {
		var zhushu = 0;
		var m = spArr.length;//场次
		var arr = CP.math.Cs(m, n);
		for (var i = 0; i < arr.length; i++) {
			var iTotal = 1;//每场注数
			for (var j = 0; j < arr[i].length; j++) {
				iTotal *= spArr[arr[i][j] - 1]
			}
			zhushu += iTotal
		}
		return zhushu;
	},
	/**
	 * @description 获取竞彩N串1胆拖注数
	 * @param {Array} spArrd [[3,3,3,1,2],[1,1,1,1,0]] 选中5场，4场胆拖
	 * @param {Int} n n串1
	 * @return {Int}
	 * @example CP.math.N1d([[3,3,3,1,2],[1,1,1,1,0]],5); 选中5场，4场胆拖，5串1玩法  return 54
	 * @example CP.math.N1d([[3,3,3,1,2],[1,0,0,0,0]],3); 选中5场，1场胆拖，3串1玩法  return 87
	 * @memberOf CP.math
	 */
	N1d: function (spArrd, n) {
		var nArr = [], dArr = [];
		try {
			for (var i = 0; i < spArrd[1].length; i++) {
				if (spArrd[1][i] == 1) {
					dArr.push(spArrd[0][i]);
				} else {
					nArr.push(spArrd[0][i]);
				}
			}
		} catch (e) {
			return 0;
		}
		if (dArr.length <= n) {
			return CP.math.N1(nArr, n - dArr.length) * CP.math.N1(dArr, dArr.length);
		} else {
			return 0;
		}
	},
	/**
	 * @description 机选号码
	 * @param {Int} startNum   起始值
	 * @param {Int} totalNum   总数长度
	 * @param {Int} len        机选个数或者数组
	 * @param {Int} a          是否重复，缺省不重复
	 * @param {Array} rep      删除不需要的元素，定胆机选用
	 * @param {String} con     幸运选号类型'彩种+玩法+类型+值'例如：dlcr5xz1
	 * @param {String} hour    幸运选好保留时间
	 * @return {Array}
	 * @example CP.math.random(1,35,5); 机选1-35之间5不重复个数字 return [4,12,16,8,34,9]
	 * @example CP.math.random(1,12,2,true); 机选 return [4,4]
	 * @example CP.math.random(1,11,5,null,[],'dlcr5xz1') 幸运选号
	 * @memberOf CP.math   1 10 5
	 */
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
};

/**
 * @namespace 工具辅助
 * @name Util
 * @memberOf CP
 */
CP.Util = {
	/**
	 * @description 过滤文本内容中含有的脚本等危险信息
	 * @param {String} str 需要过滤的字符串
	 * @return {String}
	 * @example
	 CP.Util.filterScript('123<script src="a.js"></script>456');
	 结果：123456
	 * @memberOf CP.Util
	 */
	filterScript: function (str) {
		str = str || '';
		str = decodeURIComponent(str);
		str = str.replace(/<.*>/g, ''); // 过滤标签注入
		str = str.replace(/(java|vb|action)script/gi, ''); // 过滤脚本注入
		str = str.replace(/[\"\'][\s ]*([^=\"\'\s ]+[\s ]*=[\s ]*[\"\']?[^\"\']+[\"\']?)+/gi, ''); // 过滤HTML属性注入
		str = str.replace(/[\s ]/g, '&nbsp;'); // 替换空格
		return str;
	},
	/**
	 * @description 获取地址栏参数（注意:该方法会经filterScript处理过）
	 * @param {String} name 需要获取的参数如bc_tag
	 * @param {String} url 缺省：window.location.href
	 * @param {Number} num 当url存在多个？时，num设置取第几个？后面的参数  (add by lilian)
	 * @return {String}
	 * @example
	 CP.Util.getPara('bc_tag');

	 当前地址:http://888.qq.com/static/ssq/?bc_tag=70018.1.38
	 返回值:70018.1.38
	 * @memberOf CP.Util
	 */
	getPara: function (name, url, num) {
		var para = (typeof url == 'undefined') ? window.location.search : url;
		para = para.split('?');
		if (!!num) {
			para = (para[num] ? para[num] : para[para.length - 1]);
		} else {
			para = (typeof para[1] == 'undefined') ? para[0] : para[1];
		}
		para = para.split('&');
		for (var i = 0; para[i]; i++) {
			para[i] = para[i].split('=');
			if (para[i][0] == name) {
				try { // 防止FF等decodeURIComponent异常
					return this.filterScript(para[i][1]);
				} catch (e) {
				}
			}
		}
		return '';
	},
	/**
	 * @description 获取地址栏hash参数（注意:该方法会经filterScript处理过）
	 * @param {String} name 需要获取的参数如bc_tag
	 * @param {String} url 缺省：window.location.href
	 * @return {String}
	 * @example
	 CP.Util.getParaHash('bc_tag');

	 当前地址:http://888.qq.com/static/ssq/?bc_tag=70018.1.38
	 返回值:70018.1.38
	 * @memberOf CP.Util
	 */
	getParaHash: function (name, url) {
		var para = (typeof url == 'undefined') ? window.location.href : url;
		para = para.split('#');

		para = (typeof para[1] == 'undefined') ? para[0] : para[1];
		para = para.split('&');
		for (var i = 0; para[i]; i++) {
			para[i] = para[i].split('=');
			if (para[i][0] == name) {
				try { // 防止FF等decodeURIComponent异常
					return this.filterScript(para[i][1]);
				} catch (e) {
				}
			}
		}
		return '';
	},
	/**
	 * @description 获取地址栏hash后面的完整url值
	 * @param {String} url 缺省：window.location.href
	 * @return {String}
	 * @example
	 CP.Util.getParaUrlHash();

	 返回值:buy/ssq.shtml?234
	 * @memberOf CP.Util
	 */
	getParaUrlHash: function (url) {	//专门针对#后面的url获取包括参数在内的完整地址
		var para = (typeof url == 'undefined') ? window.location.href : url;
		para = para.split('#')[1];
		return para ? para.substring(para.indexOf("&url=") + 5) : '';
	},
	/**
	 * @description 小于10的数字前补0
	 * @param {String|Nubmer|Array} obj 需要获取的参数如bc_tag
	 * @return {String}
	 * @example
	 CP.Util.padArray([1,5,10,11]);//['01','05','10','11']
	 CP.Util.padArray(5);//'05'
	 CP.Util.padArray(5,3);//'005'

	 * @memberOf CP.Util
	 */
	padArray: function (obj, length) {
		if (obj instanceof Array) {
			for (var j = 0, _max = obj.length; j < _max; j++) {
				var i = Number(obj[j]);
				obj[j] = CP.Util.pad(i, length || 2);
			}
		}
		return obj;
	},

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
	 * @description 获取唯一key值
	 * @example CP.Util.key();return '108ed532eef'
	 * @memberOf CP.Util
	 */
	key: function () {
		return parseInt(new Date().getTime() * Math.random()).toString(16);
	},
	/**
	 * @description url参数转object
	 * @example CP.Util.paramToObj('name=class&age=19');return {name:class,age:19}
	 * @memberOf CP.Util
	 */
	paramToObj: function (str) {
		var a = str.split('&');
		var obj = {};
		for (var i = 0, n = null, l = a.length; i < l; i++) {
			n = a[i].split('=');
			obj[n[0]] = n[1];
		}
		return obj;
	},
	/**
	 * @description 获取两个时间相差的天数
	 * @param {Date} sDate1/sDate2 时间 yyyy-MM-dd格式
	 * @return {Number} 返回相差天数
	 */
	dateDiff: function(sDate1, sDate2) {  //sDate1和sDate2是yyyy-MM-dd格式
	    var aDate, oDate1, oDate2, iDays;
	    aDate = sDate1.split("-");
	    oDate1 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);  //转换为yyyy-MM-dd格式
	    aDate = sDate2.split("-");
	    oDate2 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);
	    iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24); //把相差的毫秒数转换为天数
	    return iDays;  
	},
	/**
	 * @description 深度克隆
	 * @return {object}
	 */
	CloneObj : function (destination, source) {
		for (var p in source) {
			if (CP.getType(source[p]) == "array" || CP.getType(source[p]) == "object") {
				destination[p] = CP.getType(source[p]) == "array" ? [] : {};
				arguments.callee(destination[p], source[p]);
			} else {
				destination[p] = source[p];
			}
		}
		return destination;
	},
	/**
	 * @description 根据彩种id 获取信息
	 * @param {number} n 彩种id 不可空
	 * @param {number} m 为空默认0( 0-彩种名 1-彩种位置 2-彩种对应合买里面的索引)
	 * @example CP.Util.lot(1,1);return ssq
	 * @return {str} 返回需要的信息
	 */
	lot: function (n, m){
		m = m || '0';
		n = parseInt(n);
		var lot = {
				'1': ['双色球', 'ssq', '6'],
				'3': ['福彩3D', '3d', '7'],
				'4': ['时时彩', 'ssc', ''],
				'5': ['新快3', 'k3', ''],
				'6': ['快3', 'ahk3', ''],
				'7': ['七乐彩', 'qlc', '8'],
				'8': ['福彩快3', 'nmk3', ''],
				'9': ['江苏快3', 'k3', ''],
				'20':['新时时彩', 'jxssc', ''],
				'50':['大乐透', 'dlt', '9'],
				'51':['七星彩', 'qxc', '10'],
				'52':['排列五', 'p5', '12'],
				'53':['排列三', 'p3', '11'],
				'54':['11选5', '11x5', ''],
				'55':['广东11选5', 'gd11x5', ''],
				'56':['11运夺金', '11ydj', ''],
				'57':['上海11选5', 'sh11x5', ''],
				'58':['快乐扑克3', 'pk3', ''],
				'80':['胜负彩', 'sfc', '3'],
				'81':['任选九', 'r9', '4'],
				'82':['进球彩', 'jq', ''],
				'83':['半全场', 'bq', ''],
				'84':['单场-胜负过关', 'sfgg', '5'],
				'85':['单场-胜平负', 'bjdc', '5'],
				'86':['单场-比分', 'bjdc', '5'],
				'87':['单场-半全场', 'bjdc', '5'],
				'88':['单场-上下单双', 'bjdc', '5'],
				'89':['单场-总进球', 'bjdc', '5'],
				'90':['竞彩-让球', 'jczq', '1'],
				'91':['竞彩-比分', 'jczq', '1'],
				'92':['竞彩-半全场', 'jczq', '1'],
				'93':['竞彩-总进球', 'jczq', '1'],
				'70':['竞彩-混投', 'jczq', '1'],
				'72':['竞彩-胜平负', 'jczq', '1'],
				'94':['篮彩-胜负', 'jclq', '2'],
				'95':['篮彩-让分', 'jclq', '2'],
				'96':['篮彩-胜分差', 'jclq', '2'],
				'97':['篮彩-大小分', 'jclq', '2'],
				'71':['篮彩-混投', 'jclq', '2']
		};
		return lot[n][m];
	},
	/**
	 * @description 根据彩种id 获取信息
	 * @param {String} gid 彩种id required
	 * @param {String} opt 投注号码 required
	 * @example CP.Util.joinString(01, '01,05,07,15,23,32|04;01,12,16,20,22,26|05'); return 01,05,07,15,23,32|04:1:1;01,12,16,20,22,26|05:1:1
	 * @return {str} 返回投注需求的code值
	 */
	joinString : function (gid, opt){
		var g = {
				'54' : {'0':'01:01','1':'02:01','2':'03:01','3':'04:01','4':'05:01','5':'06:01','6':'07:01','7':'08:01','8':'09:01','9':'10:01','10':'11:01','11':'12:01'},
				'06' : {'0':'1:4','1':'3:1','2':'7:1','3':'4:1','4':'8:1','5':'2:1','6':'6:1','7':'5:1'},
				'20' : {'0':'11:1','1':'1:1','2':'2:1','3':'3:1','4':'5:1','5':'12:1','6':'10:3','7':'15:3','8':'16:1','9':'10:4'},
				'03' : {'0':'1:1','1':'2:1','2':'1:4','3':'2:3','4':'3:1'}
		};
		var opt_ = opt.split(';');
		opt_ = $.map(opt_, function (item) {
			if (gid == '01' || gid == '50' || gid == '07' || gid=="51" || gid=="52") {//双色球 & 大乐透 & 七乐彩 & 七星彩 & 排列五
				return item += ':1:1';
			}else if(gid == '03' || gid == '53'){//3D & 排三
				gid = '03';
				var Q = item.split('_');
				if(Q[0] == '4' && Q[1].split(',').length>3){
					return Q[1] += ':3:3';
				}else{
					return Q[1] += (':'+g[gid][Q[0]]);
				}
			}else if(gid == '54' || gid == '56'){//11选5 & 十一运夺金
				gid = '54';
				var Q = item.split('_');
				return Q[1] += (':'+g[gid][Q[0]]);
			}else if(gid == '06'){//安徽快3
				var Q = item.split('_');
				var Q1 = '';
				if(Q[0] == '1'){//三同号单选
					var Q2 = Q[1].split(',');
					Q2 = $.map(Q2, function(a){
						return a.split('').join(',')+':'+g[gid][Q[0]];
					});
					Q1 = Q2.join(';');
				}else if(Q[0] == '2'){//二同号单选
					33,44|5
					var Q2 = Q[1].split('|');
					var Q3 = Q2[0].split(',');
					Q3 = $.map(Q3, function(a){
						return a.substr(0,1);
					});
					Q1 = Q3+'|'+Q2[1]+':'+g[gid][Q[0]];
				}else if(Q[0] == '5' || Q[0] == '7'){//三同号通选 & 三不同号通选
					Q1 = '0,0,0:'+g[gid][Q[0]];
				}else if(Q[0] == '6'){//二同号复选
					var Q2 = Q[1].split(',');
					Q2 = $.map(Q2, function(a){
						return a.substr(0,1);
					});
					Q1 = Q2 += (':'+g[gid][Q[0]]);
				}else{
					Q1 = Q[1] += (':'+g[gid][Q[0]]);
				}
				return Q1;
			}else if(gid == '20'){//新时时彩
				var Q1 = '';
				var Q = item.split('_');
				if(Q[0] == '0'){//大小单双
					Q1 = Q[1].replace(/大/g,'2').replace(/小/g,'1').replace(/单/g,'5').replace(/双/g,'4');
				}else if(Q[0] == '1'){//一星直选
					Q1 = Q[1].replace(/,/g,'');
				}else{
					Q1 = Q[1];
				}
				return Q1+':'+g[gid][Q[0]];
			}
		});
		return opt_.join(';');
	},
	/**
	 * @description int型转成金额 
	 * @param {Int} nStr 金额
	 * @example addCommas('12345') 12,345
	 * @return {Sting} 金额
	 */
	addCommas : function (nStr){
		if (!!nStr) {
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		} else {
			return 0;
		}
	},
	/**
	 * @description 接口里面返回的开奖号码美化
	 * @param {Str} lotid 彩种id 
	 * @param {Str} ccodes 开奖号码
	 * @param {Str} oc 可空
	 */
	showcode : function (lotid, ccodes){
		var html="";
		var codes = ccodes.split(";");
		for ( var i = 0, l = codes.length; i < l; i++) {
			if(lotid==90 ||lotid==91 ||lotid==92 ||lotid==93 ||lotid==72 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89){
				tmpCode = codes[i].split("|");
				html += '[' + CP.Util.getplayname(lotid, lotid, lotid) + ']|' + tmpCode[1]+'|'+tmpCode[2].replaceAll("\\*","串");
			}else{
				tmpCode = codes[i].split(":");
				pm = tmpCode[1];
				cm = tmpCode[2];
				if (lotid=="01" || lotid=="50"){
					html += CP.Util.matchopencode(lotid, pm, cm, tmpCode[0]);
				}else if (lotid=="54" || lotid=="55" || lotid=="03" || lotid=="53" || lotid=="56" || lotid=="57"){
					if(tmpCode[0].indexOf('$') != '-1'){
						var arr = tmpCode[0].split('$');
						tmpCode[0] = ' 胆:'+arr[0]+' 拖:'+arr[1];
					}
					html += '【'+ CP.Util.getplayname(lotid, pm, cm) +'】' + tmpCode[0].replace(/,/g,' ')+'<br>';
				}else if (lotid=="07" || lotid=="51" || lotid=="52"){
					html += '【普通】' + tmpCode[0].replace(/,/g,' ') +'';
				}else if (lotid=="04"){
					html += '[' + CP.Util.getplayname(lotid, pm, cm) + ']';
					if(parseInt(pm,10)==6){
						var tc = tmpCode[0].split(",");
						for(var ii=0; ii<tc.length; ii++){
							html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
						}
					}else{
						html +=tmpCode[0];
					}
				}else if (lotid=="20"){
					html += '[' + CP.Util.getplayname(lotid, pm, cm) + ']';
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
					html += '[' + CP.Util.getplayname(lotid, pm, cm) + ']' + tmpCode[0] + '<br>';
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
					html += '[' + CP.Util.getplayname(lotid, pm, cm) + ']&nbsp;' + tmp +'<br>';
				}else{
					html += tmpCode[0];
				}
			}	
		}
		return html;
	},
	matchopencode : function (lotid, pm, cm, cd){//专门为双色球大乐透服务的
		var rc = "",html = "";
		var wf = CP.Util.getplayname(lotid, pm, cm, 0);
		if(lotid=="50"){
					var cdstr = cd.split("|");
					var qq = cdstr[0];
					var hq = cdstr[1];
					if(qq.indexOf("$")!=-1){
						rc += '<label class="red">(' + qq.split("$")[0].replace(/,/g," ") + ')&nbsp;' +qq.split("$")[1].replace(/,/g," ")+ '</label>&nbsp;';
					}else{
						rc += '<label class="red">' + qq.replace(/,/g,' ') + '</label>&nbsp;';
					}
					if(hq.indexOf("$")!=-1){
						rc += '<label class="blue">(' + hq.split("$")[0].replace(/,/g," ") + ')&nbsp;' +hq.split("$")[1].replace(/,/g," ")+ '</label>&nbsp;';
					}else{
						rc += '<label class="blue">' + hq.replace(/,/g,' ') + '</label>';
					}
		}else{
				var red = cd.split("|")[0];
				var blue = cd.split("|")[1];
				if(cd.indexOf("$")!=-1){
					var dt = red.split("$");
					rc += '<label class="red">(' + dt[0].replace(/,/g," ") + ')&nbsp;' +dt[1].replace(/,/g," ")+ '</label>&nbsp;';
					rc += '<label class="blue">' + blue.replace(/,/g,' ') + '</label>';
				}else{
					rc += '<label class="red">' + red.replace(/,/g," ") + '</label>&nbsp;';
					rc += '<label class="blue">' + blue.replace(/,/g,' ') + '</label>';
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
	},
	/**
	 * @description 获取投注玩法名
	 * @param {Str} lotid 彩种id 
	 * @param {Str} playid 开奖号码
	 * @param {Str} cm 
	 * @param {} castdef
	 * @example CP.Util.getplayname()
	 */
	getplayname : function(lotid, playid, cm, castdef) {
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
	},
	DateDiff : function (sDate1, sDate2) {  //sDate1和sDate2是yyyy-MM-dd格式
	    var aDate, oDate1, oDate2, iDays;
	    aDate = sDate1.split("-");
	    oDate1 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);  //转换为yyyy-MM-dd格式
	    aDate = sDate2.split("-");
	    oDate2 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);
	    iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24); //把相差的毫秒数转换为天数
	    return iDays;  //返回相差天数
	}
};
/*
 * 用户状态、信息
 */
CP.User = {
		//检测是否登录
		checkLogin : function(){
			
		},
		//查询用户登录名、用户余额、冻结款、用户类型
		info : function(fn){
			var t = {};
			$.ajax({
				url:CP.Data.apps+'/user/query.go?flag=6',
				type:'GET',
				success:function(xml){
					var R = $(xml).find('Resp');
					var c = R.attr('code');
					if(c == '0'){
						var r = R.find('row');
						t.usermoney = r.attr('usermoeny');//余额
						t.ipacketmoney = r.attr('ipacketmoney');//红包余额
						fn(t);
					}else{
					     var agent = localStorage.getItem('agent');
					     if(agent == '3012'){
		                 	window.location.href="http://lifepage.api.niuwan.cc/lotteryjump?addfrom=login&rnd=" + Math.random();//牛玩测试地址
		                 }else{
							remove_alert();
							location.href = '#type=fun&fun=CP.Home.openLogin';
							alert('请先登录');
					     }
					}
				},error : function () {
					remove_alert();
					alert('网络异常请刷新重试');
				}
			});
		}
}
//h5本地存储
CP.Storage = {
	/**
	 * @description 是否支持localStorage
	 * @example CP.Storage.is();
	 * @memberOf CP.Storage
	 */
	is: function () {
		return !!window.localStorage;
	},
	/**
	 * @description 设置localStorage
	 * @param {String} name 名称
	 * @param {String} value 值
	 * @example CP.Storage.set('cp_pagetype', 'page');
	 * @memberOf CP.Storage
	 */
	set: function (name, value, type) {
		if (!CP.Storage.is()) {
			if (typeof(value) != "object") {
				CP.Cookie.set(name, value);
			}
			return;
		}
		var Storage = type ? "sessionStorage" : "localStorage";
		switch (jQuery.type(value)) {
			case 'object':
				value = 'object:' + JSON.stringify(value);
				break;
			case 'string':
				value = 'string:' + value;
				break;
		}
		try {
			window[Storage].setItem(name, value);
		} catch (e) {
			if (e == 'QUOTA_EXCEEDED_ERR' && (navigator.userAgent.indexOf('iPhone') > -1 || navigator.userAgent.indexOf('iPad') > -1))confirm('为了正常运行网站，请关闭您终端的：设置?Safari?秘密浏览')
		}
	},
	/**
	 * @description 获取localStorage
	 * @param {String} name 名称
	 * @example CP.Storage.get('cp_pagetype');
	 * @memberOf CP.Storage
	 */
	get: function (name, type) {
		if (!CP.Storage.is()) {
			return CP.Cookie.get(name);
		}
		var Storage = type ? "sessionStorage" : "localStorage";
		var value = window[Storage].getItem(name);
		if (/^object:/.test(value)) {
			value = JSON.parse(value.replace(/^object\:/, ''));
		} else if (/^string:/.test(value)) {
			value = value.replace(/^string\:/, '');
		}
		return value;
	},

	remove: function (name, type) {
		if (!CP.Storage.is()) {
			return CP.Cookie.get(name);
		}
		var Storage = type ? "sessionStorage" : "localStorage";
		window[Storage].removeItem(name);
	}

}
/**
 * @namespace Cookie类
 * @name Cookie
 * @memberOf CP
 */
CP.Cookie = {
	/**
	 * @description 设置cookie
	 * @param {String} name 名称
	 * @param {String} value 值
	 * @param {String} [domain:tenpay.com] 域
	 * @param {String} [path:/] 路径
	 * @param {String} [hour] 小时
	 * @example CP.Cookie.set('cp_pagetype', 'page', 'tenpay.com');
	 * @memberOf CP.Cookie
	 */
	set: function (name, value, domain, path, hour) {
		if (hour) {
			var now = new Date();
			var expire = new Date();
			expire.setTime(parseFloat(now.getTime()) + 3600000 * hour);
		}
		document.cookie = name + '=' + value + '; ' + (hour ? ('expires=' + expire.toUTCString() + '; ') : '');
	},
	/**
	 * @description 设置cookie
	 * @param {String} name 名称
	 * @example CP.Cookie.get('cp_pagetype'); "page"
	 * @memberOf CP.Cookie
	 */
	get: function (name) {
		var re = new RegExp('(?:^|;+|\\s+)' + name + '=([^;]*)');
		var result = document.cookie.match(re);
		return (!result ? '' : result[1]);
	},
	/**
	 * @description 删除cookie
	 * @param {String} name 名称
	 * @param {String} [domain:tenpay_com] 域
	 * @param {String} [path:/] 路径
	 * @example CP.Cookie.del('cp_pagetype');
	 * @memberOf CP.Cookie
	 */
	del: function (name, domain, path) {
		if (domain === null) {
			document.cookie = name + '=; expires=Mon, 2 Mar 2009 19:00:00 UTC; path=' + (path || '/');
		} else {
			document.cookie = name + '=; expires=Mon, 2 Mar 2009 19:00:00 UTC; path=' + (path || '/') + '; domain=' + (domain || 'qq.com') + ';';
		}
	}
};


/*
 * 触屏版touch插件
 * @param {Object} [children:".ball",fun:function(){}];
 $("body").Touch(function(){
 $('#lot_title').html('你好')
 })
 */
$.fn.Touch = function (obj) {
	var moveEvent = move_ev;
	if (CP.getType(obj) == 'function') {
		obj.fun = obj;
	}

	this.each(function () {
		var $dom = $(this).eq(0);//转为dom对象
		var ifMove = false;
		var t = 0;
		$dom.on(moveEvent, function () {
			ifMove = true;
			clearTimeout(t);
			t = setTimeout(function () {
				ifMove = false
			}, 250);
		})
		if (obj.children) {
			$dom.on(end_ev, obj.children, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return false;
				}
				obj.fun.call(this, this);
			})
		}
		else {
			$dom.on(end_ev, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return 0;
				}
				obj.fun.apply(this, [this, e]);
			})
		}
	});
};
/*
 * 数字输入框
 * @param {Object} o,new numInput({max,ipt,up,down,checkMax,fn});
 */
$.fn.NumInput = function (options) {
	if (m = window.navigator.userAgent.match(/iPhone OS (\d)_\d(_\d)? like/) || window.navigator.userAgent.indexOf("opera|iPhone") > -1) {
		start_ev = 'mousedown';
	}
	this.each(function () {
		var o = {
			max: 999999999,//最大值
			min: 1,//最小值
			val: 1,//默认值
			up: '.qplus',//上点击dom
			down: '.qminus',//下点击dom
			num: 1,//加减间隔
			"float": 0,
			"pad": 1,//补零位数
			ts: this,
			fn: function () {
			}//回调函数
		};
		if (options) {
			jQuery.extend(o, options);
		} else {
			o.val = $(this).val() || 1;
		}
		var $ipt = $(this);
		var $up = $ipt.siblings(o.up);
		var $down = $ipt.siblings(o.down);
		$ipt.val(o.val);
		//加法
		var doAdd = function () {
			var n1 = parseFloat($ipt.val());//原数字
			if (!n1) {
				n1 = 1;
			}
			var n2 = n1 + o.num;//新数字
			$ipt.val(parseFloat((n2 > o.max ? n1 : n2).toFixed(o['float'])));
			o.fn();
		};
		var doMinus = function () {
			var n1 = parseFloat($ipt.val());//原数字
			if (!n1) {
				n1 = 1;
			}
			var n2 = n1 - o.num;//新数字
			$ipt.val(parseFloat((n2 < o.min ? n1 : n2).toFixed(o['float'])));
			o.fn();
		};
		$ipt.on(start_ev,function (event) {
			event.stopPropagation();
		}).blur(function () {
			if ($ipt.val() == '') {
				$ipt.val(o.val);
			}
			isPad();
			o.fn();
		}).on("keyup", function () {
			var str = $ipt.val().match(/\d{1,}(\.\d{0,}){0,1}/);
			str = (str && str[0]) || '';
			if (str != '') {
				$ipt.val(parseFloat(parseFloat(str).toFixed(o['float'])));
				if ($ipt.val() > o.max) {
					$ipt.val(o.max);
				} else if ($ipt.val() < o.min) {
					$ipt.val(o.min);
				}
				if (isNaN($ipt.val())) {
					$ipt.val(o.val);
				}
			} else {
				$ipt.val('');
			}
			isPad();
			o.fn();
		});

		$up.length > 0 && $up.on(start_ev, function () {
			doAdd();
		});
		$down.length > 0 && $down.on(start_ev, function () {
			doMinus();
		});
		var isPad = function () {
			if (o.pad > 1) {
				$ipt.val(CP.Util.pad($ipt.val(), o.pad));
			}
		};
	});
	return this;
};
/*
 * 虚拟数字键盘
 */
var KeyBoard_ = $('<div class="keyboard" style="top:-5rem"><o style="left:50%"></o><div><u v="vku">1</u><u v="vku">2</u><u v="vku">3</u><u v="vku">4</u><u v="vku">5</u><u v="vku">6</u></div>'+
'<div><u v="vku">7</u><u v="vku">8</u><u v="vku">9</u><u v="vku">0</u><u v=vkClear><del></del></u><u v=vkOK>确认</u></div></div>');
$.fn.KeyBoard = function (options) {
	if (m = window.navigator.userAgent.match(/iPhone OS (\d)_\d(_\d)? like/) || window.navigator.userAgent.indexOf("opera|iPhone") > -1) {
		start_ev = 'mousedown';
	}
	this.each(function () {
		var o = {
			max: 999999999,//最大值
			min: 1,//最小值
			val: 1,//默认值
			num: 1,//加减间隔
			tag: '',
			ts: this,
			fn: function () {
			}//回调函数
		};
		if (options) {
			jQuery.extend(o, options);
		} else {
			o.val = $(this).val() || 1;
		}
		var $ipt = $(this);
		$ipt.val(o.val);
		$ipt.Touch({fun:function (event) {
			if($(this).parent().find('.keyboard').length){
				if($ipt.val() == '' || $ipt.val() == '0'){
					alert('不可为空哟！');
					$ipt.val('1');
					o.fn();
				}
				$('.keyboard').remove();
			}else{
				$('.keyboard').remove();
				$ipt.parent().append(KeyBoard_);
				//键盘初始化
				$(".keyboard u").each(function(i) {
					if(!CP.MobileVer.ios){//ios下很慢 暂时没想到办法解决
						$(this).on(start_ev, function(){
							$(this).css({
								"background-color" : "#333"
							});
						}).on(end_ev, function(){
							$(this).css({
								"background-color" : "#5d5f6b"
							});
						});
					}
				});
				var l = $(this).offset().left+$(this).width()/2-5;
				//调整键盘下面箭头的位置
				$(".keyboard o").animate({'left':l});
				//点击数字
				$ipt.parent().off();
				$ipt.parent().Touch({children:'u[v=vku]', fun:function() {
					var Q = ($ipt.val() != '0') && ($ipt.val() + "" + $(this).html()) || $(this).html();
					$ipt.val(Q);
					if ($ipt.val() > o.max) {
						alert('最大'+o.max+''+o.tag);
						$ipt.val(o.max);
					} else if ($ipt.val() < o.min) {
						alert('最小'+o.min+''+o.tag);
						$ipt.val(o.min);
					}
					if (isNaN($ipt.val())) {
						$ipt.val(o.val);
					}
					o.fn();
				}});
				$ipt.parent().Touch({children:'u[v=vkClear]',fun:function(){
					var val_ = $ipt.val();
					val_ = (val_+'').substr(0,val_.length-1);
					$ipt.val(val_);
					o.fn();
				}});
				$ipt.parent().find('u[v=vkOK]').bind('click',function(){
					if($ipt.val() == '' || $ipt.val() == '0'){
						alert('不可为空哟！');
						$ipt.val('1');
						o.fn();
					}
					$('.keyboard').remove();
				});
			}
		}});
	});
	return this;
};
/*
 * 弹窗类
 */
CP.Popup = {
		/*
		 * 购买弹窗
		 */
		buybox : function(options){
			var o = {//弹窗的参数初始化
					gid:           '',//彩种id 不可空
					cMoney:        '',//需支付金额 不可空
					bonus:         '',//理论奖金
					usermoney:     '',//账户余额 不可空
					ipacketmoney:  '',//红包余额
					payPara:       '', //投注参数
					cupacketid:    '',//红包id
					redpacket_money: ''//使用红包金额
			};
			if (options) {
				jQuery.extend(o, options);
			} else {
				alert('参数获取异常！');
				return
			}
			if(!o.gid || !o.cMoney || !o.usermoney){
				alert('参数获取失败请刷新重试');
				return
			}
			var tag = true;//是否充值的标识 默认去充值
			o.usermoney = parseFloat(o.usermoney);
			o.cMoney = parseFloat(o.cMoney);
			if (o.usermoney>=o.cMoney) {//余额不足的时候显示去充值
				tag = false;
				$('#buy_box .zfTrue a:eq(1)').hide().siblings().show();
			} else {
				$('#buy_box .zfTrue a:eq(2)').hide().siblings().show();
			}
			$('#buy_box').removeClass('zfpopCur');//默认隐藏红包列表层
			$('#buy_reveal p:eq(0) cite').html(o.cMoney+'元');//初始化投注金额
			if(o.bonus){//如果是竞彩显示奖金范围
				$('#buy_reveal p:eq(1) cite').html(o.bonus+'元');
			}else{
				$('#buy_reveal p:eq(1)').hide();
			}
			if(o.ipacketmoney == '0' || o.payPara.orderType == 'zh'){//木有红包的时候隐藏红包按钮
				$('#buy_reveal .popuseRed span').hide();
			}else{
				$('#buy_reveal .popuseRed span').show();
			}
			$('#buy_reveal p:eq(2) cite').html(o.usermoney+'元');//初始化余额
			$('#buy_box,#mask').show();//弹支付框
			$('#buy_hide').html('');//清空红包列表
			$('#buy_box').animate({'margin-top':'-'+$('#buy_box').height()/2+'px'});//使层垂直居中
			$('#buy_box').off('click.pop').on('click.pop','.zfTrue a:eq(0)',function(){//取消按钮
				$('#buy_box,#mask').hide();
			}).on('click.pop','.zfTrue a:eq(1)',function(){//充值按钮
				window.location.href='#type=url&p=user/charge.html';
				$('#buy_box,#mask').hide();
			}).on('click.pop','.zfTrue a:eq(2)',function(){//确定按钮
				o.cupacketid = '';o.redpacket_money = '';
				if ($('#buy_hide').is(':visible') && $('#buy_hide div.cur').length) {
					if($('#buy_hide div.cur').attr('kymoney') != '0'){
						o.cupacketid = $('#buy_hide div.cur').attr('cptid');
						o.redpacket_money = $('#buy_hide div.cur').attr('kymoney');
					}
				}
				$('#buy_box,#mask').hide();
				if(!o.fun){
					CP.Pay.init(o);
				}else{
					var fun = o.fun.split('.');
					window[fun[0]][fun[1]][fun[2]](o);
				}
			}).on('click.pop','#buy_reveal div span',function(){//使用红包按钮
				$('#buy_box').toggleClass('zfpopCur');
				if($('#buy_box').hasClass('zfpopCur')){
					$('#buy_hide').html('<div style="padding:8px;"><em class="rotate_load" style="margin:auto"></em></div>');
					$.ajax({
						url:CP.Data.apps+'/user/queryRpinfo.go',
						type:'post',
						dataType:'xml',
						data:{
							trade_gameid : o.gid,
							trade_imoney : o.cMoney,
							trade_isource:'0'
						},
						success:function(xml){
							var R = $(xml).find('rows');
							var r = R.find('row');
							if(r.length){//判断有木有红包可使用
								var html = '';
								r.each(function(i){
									var cptid = $(this).attr('cptid');//红包编号
									var crpname = $(this).attr('crpname');//红包名
									var irmoney = $(this).attr('irmoney');//红包余额
									var cddate = $(this).attr('cddate');//红包过期时间
									var kymoney = $(this).attr('kymoney');//可用红包
									kymoney = kymoney||'0';
									html += '<div kymoney="'+kymoney+'" cptid="'+cptid+'" class="clearfix pdLeft1 '+(i==0? 'cur' : 'pdTop1' )+'"><em class="left nocheck"></em><div class="redText">';
									html += '<p>【'+crpname+'】余额'+irmoney+'元，本次可用<cite class="red">'+kymoney+'元</cite></p><p class="pdTop03">过期时间：'+(cddate == '' ? '无限制':cddate)+'</p></div></div>';
								});
								$('#buy_hide').html(html);
								var rPack = parseFloat($('#buy_hide .cur').attr('kymoney'));
								if(tag){
									if((rPack + o.usermoney)>=o.cMoney){
										$('#buy_box .zfTrue a:eq(1)').hide().siblings().show();
									}
								}
							}else{
								$('#buy_hide').html('<div style="text-align:center;">您本次无红包可以使用</div>');
							}
						}
					});
				} else {
					if(tag){
						$('#buy_box .zfTrue a:eq(2)').hide().siblings().show();
					}
				}
				$('#buy_box').animate({'margin-top':'-'+$('#buy_box').height()/2+'px'});
			}).delegate('#buy_hide .pdLeft1','click.pop',function(){//选择红包
				$(this).toggleClass('cur').siblings().removeClass('cur');
				var rPack = $('#buy_hide .cur').attr('kymoney');
				if(tag){
					if(rPack && (parseFloat(rPack) + o.usermoney)>=o.cMoney){
						$('#buy_box .zfTrue a:eq(1)').hide().siblings().show();
					}else{
						$('#buy_box .zfTrue a:eq(2)').hide().siblings().show();
					}
				}
			});
		}
};

//支付
CP.Pay = function () {
	var init = function (opt) {
		var opt_ = opt.payPara || {};
		var data = {};
		if (opt_.hid) {//合买跟单
			data = {
					gid:     opt_.gid,//彩种编号
					hid:     opt_.hid,//方案编号
					bnum:    opt_.countMoney//跟单金额
			};
		} else {
			if (opt_.orderType == 'dg') {//代购
				data = {
						gid:     opt.gid,//彩种编号
						pid:     opt_.pid,//期号
						play:    '1',//玩法 复式1   单式0
						codes:   opt_.codes,//投注内容
						muli:    opt_.muli,//方案倍数
						fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
						type:    '0 ',//方案类型0 代购   1合买
						name:    '自购',//方案宣传标题
						desc:    '自购',//方案宣传内容
						money:   opt_.countMoney,//方案金额
						tnum:    '1',//方案总份数
						bnum:    '1',//购买份数
						pnum:    '0',//保底份数
						oflag:   '0',//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
						wrate:   '0',//提成比例
						comeFrom:'',//用户来源
						source:  CP.Data.source,//方案来源 
						endTime: '',//方案截止时间
						upay:    '',//是否订单支付
						cupacketid: opt.cupacketid,//红包id
						redpacket_money: opt.redpacket_money//使用红包金额
				};
			}else if(opt.payPara.orderType == 'hm'){//合买
				data = {
						gid:     opt.gid,//彩种编号
						pid:     opt_.pid,//期号
						play:    '1',//玩法 复式1   单式0
						codes:   opt_.codes,//投注内容
						muli:    opt_.muli,//方案倍数
						fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
						type:    '1',//方案类型0 代购   1合买
						name:    '合买',//方案宣传标题
						desc:    opt_.desc,//方案宣传内容
						money:   opt_.countMoney,//方案金额
						tnum:    opt_.countMoney,//方案总份数
						bnum:    opt_.bnum,//购买份数
						pnum:    opt_.pnum,//保底份数
						oflag:   opt_.oflag,//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
						wrate:   opt_.wrate,//提成比例
						comeFrom:'',//用户来源
						source:  CP.Data.source,//方案来源
						endTime: '',//方案截止时间
						upay:    '',//是否订单支付
						cupacketid: opt.cupacketid,//红包id
						redpacket_money: opt.redpacket_money//使用红包金额
				};
			}else if(opt.payPara.orderType == 'zh'){//追号
				data = {
						gid:     opt.gid,//彩种编号
		             	pid:     opt_.pid,//期号
		             	codes:   opt_.codes,//投注内容
		             	mulitys: opt_.muli,//方案倍数
		             	zflag:   opt.payPara.zflag,//中奖是否停止0  中奖不停止  1  中奖停止  3 盈利停止
		             	ischase: '1',//追号标志1 追号
		             	money:   opt_.countMoney,//方案金额
		             	source:  CP.Data.source,//方案来源
		             	upay:    ''//是否订单支付
				};
			}
		}
		$.ajax({
			url: CP.Data.apps+opt_.payUrl,
			type:'POST',
			data: data,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					var projid = '';
					if(opt_.hid){
						projid = opt_.hid;
					}else{
						var r;
						if(opt.payPara.orderType == 'zh'){
							r = R.find('zhuihao');
							projid = r.attr('id');//方案编号
						}else{
							r = R.find('result');
							projid = r.attr('projid');//方案编号
						}
					}
					window.location.replace('#type=url&p=user/success.html?projid='+projid);
				} else {
					alert(desc);
				}
			}
		});
	};
	return {
		init: init
	};
}();

//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};

var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};


var pageLoading = {
		show: function () {
			if ($("#loadpop").length) {
				$("#loadpop").show();
			} else {
				$(document.body).append($('<div class="loadpop" id="loadpop"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>'));
			}
		},
		hide: function () {
			setTimeout(function () {
				$("#loadpop").fadeOut();
			}, 150);
		}
};

var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p.center').html(msg);
			tag && $('#dAlert a.tureBtn').html(tag) || $('#dAlert a.tureBtn').html('确定');
			$('#mask, #dAlert').show();
			$('#dAlert a.tureBtn').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert,#mask').hide();
			});
		},
		confirm:function(msg, fn, tag){
			$('#dConfirm div.center').html(msg);
			tag && $('#dAlert a:eq(1)').html(tag) || $('#dAlert a:eq(1)').html('确定');
			$('#mask, #dConfirm').show();
			$('#dConfirm a:eq(0)').one('click',function(){//取消
				$('#dConfirm,#mask').hide();
			});
			$('#dConfirm a:eq(1)').one('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm,#mask').hide();
			});
		}
};
try {
    if (window.console && window.console.log) {
        if (!!window.ActiveXObject || 'ActiveXObject' in window) {
            console.log('如果你能把这个页面做得更好，Come on！');
        } else {
            console.log('如果你能把这个页面做得更好，%cCome on！', 'color:#347be4;font-size:50px;-webkit-text-fill-color:#347be4;-webkit-text-stroke: 1px black;');
        }
        console.log('\n');
    }
} catch (b) {
}
/*
 * @namespace 摇一摇
 * @name Shake
 * @author classyuan
 */
var Shake = function () {
	var SHAKE_THRESHOLD = 1500;
	var last_update = 0;
	var x, y, z, last_x, last_y, last_z;
	var callBack = null;

	function deviceMotionHandler(eventData) {
		var acceleration = eventData.accelerationIncludingGravity;

		var curTime = new Date().getTime();

		if ((curTime - last_update) > 100) {

			var diffTime = curTime - last_update;
			last_update = curTime;

			x = acceleration.x;
			y = acceleration.y;
			z = acceleration.z;

			var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;
			if (speed > SHAKE_THRESHOLD) {
				callBack && callBack();
			}
			last_x = x;
			last_y = y;
			last_z = z;
		}
	}

	var run = function (call) {
		callBack = call;
	};
	var init = function () {
		if (window.DeviceMotionEvent) {
			window.addEventListener('devicemotion', deviceMotionHandler, false);
		}
	}
	init();
	return {
		run: run
	}
}();
/**
 * @namespace 页头导航设置
 */
var TopAnch = function () {
	var $dom = {
		aside: $('#box_header'),//页头
		prev: $('#btn_prev'),//左边按钮
		next: $('#btn_next'),//右边按钮(帮助)
		title: $('#lot_title'),//中间标题
		score: $('#box_header .zbico')//比分直播按钮
	};
	var conf = {
		prevHref: null,//左侧按钮链接
		prevFun: function () {//左侧按钮绑定事件
			window.history.back();
		},
		prevShow: false,//左侧按钮是否显示
		nextText: '',//右侧按钮文本
		nextHref: 'javascript:void(0);',//右侧按钮链接
		nextFun: null,//右侧按钮绑定事件
		nextShow: false,//右侧按钮是否显示
		isBack: false,//是否显示后退按钮
		isScore: false,//是否显示比分直播
		menu: false,//是否显示右边菜单
		title: '9188彩票',//中间标题显示
		headerSelect: null//头部下拉选择
	};
	var confTemp = conf;
	var init = function (obj) {
//		setTimeout(function () {//加上之后别的页面初始化的时候就改变不了页头的内容了
			if (!obj) {
				$dom.prev.hide();
				$dom.title.html(conf.title);
				$dom.next.hide();
			} else {
				confTemp = conf;
				if (!obj.prevFun) {	//如果没有设置则默认为后退事件
					obj.prevFun = function () {
						window.history.back();
					}
				}
				if (obj.isBack) {
					$dom.prev.attr('class','fcbackIco2');
				} else {
					$dom.prev.attr('class','fcbackHome');
				}
				jQuery.extend(confTemp, obj);
				$dom.title.off().html(confTemp.title);
				document.title=confTemp.title;
				$dom.prev[!confTemp.prevShow ? 'hide' : 'show']();
				$dom.next[!obj.nextShow ? 'hide' : 'show']();
				if(obj.isScore){//比分直播
					$dom.score.show();
					$dom.score.off().on(end_ev, function(){location.href = confTemp.isScore;});
				}else{
					$dom.score.hide();
				}
				if (confTemp.prevHref) {
					$dom.prev.attr('href', confTemp.prevHref).off();
					confTemp.prevFun == null;
				} else {
					$dom.prev.attr('href', 'javascript:void(0);');
				}
				if (confTemp.nextHref) {
					$dom.next.html(obj.nextText).attr('href', confTemp.nextHref).off();
					confTemp.nextFun == null;
				} else {
					$dom.next.attr('href', 'javascript:void(0);');
				}
				if (jQuery.type(confTemp.prevFun) === "function") {
					$dom.prev.off().on('click', confTemp.prevFun);
				}
				if (jQuery.type(confTemp.nextFun) === "function") {
					$dom.next.off().html(obj.nextText).on(end_ev, confTemp.nextFun)
				}
				if(obj.menu){
					$('#fcHeader').removeClass('pullHover');
					var a_ = '';
					for (var i = 0, l = confTemp.menu.length; i < l; i++) {
						a_ += '<a href="'+ confTemp.menu[i].url +'" class="'+ (confTemp.menu[i].cur ? 'cur' : '') +'">'+ confTemp.menu[i].name +'</a>';
					}
					$('#btn_menu').show().find('div').html(a_);
					
					$('#btn_menu').off().bind(end_ev, function () {
						$('#fcHeader').toggleClass('pullHover');
						obj.headerSelect && $('#fcHeader').removeClass('h1Down');
					});
				}else{
					$('#btn_menu').hide().find('div').html('');
				}
				if (obj.headerSelect) {
					$('#box_header').addClass('hmHeader');
					$('#fcHeader').removeClass('h1Down');
					var li = '';
					var cur = obj.headerSelect[0].cur || 0;
					for (var i = 0, l = obj.headerSelect.length; i < l; i++) {
						li += '<a' + (i == cur ? ' class="cur"' : '') + ' href="javascript:;">' + obj.headerSelect[i].name + '</a>';
					}
					$('#list_subNav').html(li);
					$('#lot_title').off().bind(end_ev, function () {
						$(this).parent().toggleClass('h1Down');
						obj.menu && $('#fcHeader').removeClass('pullHover');
					});
					$('#list_subNav a').off().bind('click', function () {
						if($(this).hasClass('cur')){
							return
						}
						$(this).addClass('cur').siblings().removeClass('cur');
						obj.headerSelect[0].fun($(this).index());//回调函数
					});
				} else {
					$('#box_header').removeClass('hmHeader');//去掉下拉箭头
				}
			}
//		}, 100)
	}
	return {init: init}
}();
/**
 * @namespace 首页类
 * @name Home
 * @memberOf CP
 */
CP.Home = function () {
	var j_ = '';
	var n_ = new Date();//本地时间
	var tag = 'ssq';
	var url_ = '';
	var a = {
			jxNum: function(obj, tag){
				if(tag == 'ssq'){
					var ssq = CP.math.random(1,33,6),i;
					ssq = ssq.slice(0,6).sort(function(a,b){return a-b;});
					for(i=0; i<6; i++){
						obj[i].innerHTML=CP.Util.pad(ssq[i],2);
					}
					var ssq_b = CP.math.random(1,16,1);
					obj[6].innerHTML=CP.Util.pad(ssq_b[0],2);
				}else{
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
                $('#ball em').addClass('rotate_jx');
                a.jxNum($('#ball em'),tag);
                j_ = setInterval(function () {
                    $('#ball em:eq(' + g + ')').removeClass('rotate_jx');
                    g++;
                    if (g > 6) {return false;}
                }, q);
			},
	};
	var b = {
			init: function(){
				var wk = n_.getDay();
				if(wk == '2' || wk == '4' || wk == '0' || wk == '5'){//
					$('#handy strong').html('双色球');
					(wk != '5') && $('#tag_01').find('em').eq(0).addClass('jrkjico');//今日开奖
				}else{
					tag = 'dlt';
					$('#handy strong').html('大乐透');
					$('#handy div:eq(1)').find('em').eq(5).addClass('blue');
					$('#tag_50').find('em').eq(0).addClass('jrkjico');
				}
				$.ajax({
					url: '/data/info/config/sysexp/gameconfig.xml',
					type:'GET',
					dateType:'xml',
					success : function(xml){
						var R = $(xml).find('rows');
						var r = R.find('row');
						r.each(function(){
							var gid = $(this).attr('gid');
							var isale = $(this).attr('isale');
							if(isale == '0'){
								if(gid == '70'){
									$('#tag_jcdg').find('em').addClass('stopico');
								}
								$('#tag_'+gid).find('em').addClass('stopico');
							}
						});
					}
				});
				a.setJx();
				$('#handy').on('click','div:eq(0)',function(){//机选一注
					a.setJx();
				});
				$('#ball').on('click','a',function(){//购买
					var lot_ = {'ssq':'01','dlt':'50'}[tag],code='';
					if(tag == 'ssq'){
						$('#ball').find('em').each(function(a){
							if(a<5){
								code += $(this).html()+',';
							}
							if(a == 5){
								code += $(this).html()+'|';
							}
							if(a==6){
								code += $(this).html();
							}
						});
					}else{
						$('#ball').find('em').each(function(a){
							if(a<4){
								code += $(this).html()+',';
							}
							if(a == 4){
								code += $(this).html()+'|';
							}
							if(a>4){
								code += $(this).html()+',';
							}
						});
						code = code.substr(0,code.length-1);
					}
					var param = {//投注参数
							payUrl:    '/trade/pcast.go',//投注接口
							gid:       lot_,//彩种id
							pid:       CP.Data.pid,//期号
							codes:     CP.Util.joinString(lot_, code),//投注内容
							muli:      '1',//倍数
							countMoney:'2',//方案金额
							orderType:      'dg'//代购合买追号
					};
					var data = {//支付弹框参数
							gid:     lot_,//彩种id
							cMoney:  '2',//需支付金额
							payPara: param//jQuery.param(param)
					};
					alert('提交中，请稍后！','loading');
					CP.User.info(function(options){
						if (options) {
							jQuery.extend(data, options);
						}
						if(!CP.Data.pid){//木有期号 调接口获取
							$.ajax({
								url:CP.Data.apps+'/trade/info.go?gid='+lot_,
								dataType:'xml',
								cache:true,
								success: function(xml) {
									var R = $(xml).find('rows');
									CP.Data.pid = R.attr('pid');
									remove_alert();
									data.payPara.pid = CP.Data.pid;
									CP.Popup.buybox(data);
								},
								error:function(){
									remove_alert();
									alert('期号获取失败,请刷新重试');
								}
							});
						} else {
							remove_alert();
							CP.Popup.buybox(data);
						}
					});
				});
				$(window).scroll(function () {
				    if ($('.fllist')) {
				        var n = $('.index_nav_').offset().top;
				        $(this).scrollTop() > n + 70 ? $('.fllist').show()  : $('.fllist').hide();
				    }
				});
			},
			login_bind : function () {
				$('#login .s3').bind('click', function(){
					$(this).find('input').focus();
					$(this).addClass('s3cur').siblings().removeClass('s3cur');
				});
				$('#loginBtn').bind(start_ev, function(){b.MiniLogin();});
			},
			MiniLogin : function () {//提交登录
			    var uname = $("#username").val();
			    var upwd = $("#password").val();
			    if (uname == "") {
			        alert('请输入合法的用户名');
			        return false;
			    }else if (upwd == "") {
			    	alert('密码不能为空');
			        return false;
			    }else{
			    	alert('登录中，请稍后！','loading');
					var data = "uid=" + encodeURIComponent(uname)+ "&pwd=" + encodeURIComponent(upwd);
				    $.ajax({
				    	url: '/user/login.go',
				        type: "POST",
				        dataType : "xml",
				        data: data,
				        success : function (xml) {
				        	remove_alert();
				        	var R = $(xml).find("Resp");
							var code = R.attr("code");
							var desc = R.attr("desc");
							if (code == "0") {
								localStorage.setItem("username", uname);
								$('#say_hi em').html(uname+',');
								alert(desc);
								setTimeout(function(){
									CP.Home.re();
								},1000);
							}else{
								alert(desc);
							}
							$("#auth_userId").val("");
							$("#auth_passwd").val("");
				        },error : function (){
				        	remove_alert();alert('网络异常请刷新重试');
				        	return
				        }		        
				    });
			    }
			}
	};
	var openLogin = function (xo) {//打开登录层
		!xo && ( url_ = false )||( url_ = xo );
		pageLoading.hide();//隐藏讨厌的菊花
		$("body").removeClass("home");//保证页头显示出来
		$('#home_page, #content_home').hide();$('#login').show();//切换到登录层
		var user_name = localStorage.getItem("username");
		!!user_name && $('#username').val(user_name).next().show();//填装用户名
		TopAnch.init({//初始化页头
			title: '登录',
			prevShow: true,
			prevFun:function(){//左侧按钮绑定事件
				if($('#mylottery').length || $('#operation').length){//我的彩票和 设置页面的时候去首页
					window.location.replace('/');
				}else{
					reLogin();
				}
			},
			nextShow: true,
			nextText: '注册',
			nextFun: function(){
				window.location.replace('/alone/register.html');
			},
			isBack:true
		});
		$("#login").off().keydown(function(e){
			if(e.which == 13){//按回车的时候提交登录
				b.MiniLogin();
				return false;
			}
		});
		$('#login .s3 input').off().bind('keyup', function(){$(this).val() != '' && $(this).next().show() || $(this).next().hide();});
		$('#login .s3 em').off().bind('click', function(){$(this).hide().prev().val('');});
	};
	var reLogin = function(){
		if(url_){
			window.location.replace('#type=url&p='+url_);
		}else{
			window.history.back();
		}
		$('#login').hide();
	};
	b.login_bind();
	return {init: b.init, openLogin: openLogin, re: reLogin};
}();

/**
 * @namespace url跳转类
 */
var hashchange = function () {
	var _G_hash = null;
	var $domContent = $('#content_home');
	var $domBox = $domContent;
	window.pageRoute = decodeURIComponent(CP.Cookie.get('pageRoute')) || '';//记录当前页面路径
	//加载页面
	var getPage = function (url) {
		remove_alert();
		if (url.indexOf('?') > -1) {
			url = url.substring(0, url.indexOf('?'));
		}
		if ($("#home_page").length && url == 'index.html') {
			$("#content_home").hide().html('');
			$("#home_page").show();
			$('#login').hide();//防止浏览器放回按钮 打开首页的时候隐藏登录
			window.homeFun && homeFun();
		} else {
			if(url.indexOf('jczq')>0 || url.indexOf('jcdg')>0 || url.indexOf('jclq')>0 || url.indexOf('bjdc')>0 || url.indexOf('sfgg')>0
					 || url.indexOf('r9')>=0 || url.indexOf('sfc')>=0 || url.indexOf('gddg')>=0){
				$('#box_header').addClass('zcHeader');
			}else{
				$('#box_header').removeClass('zcHeader');
			}
			if(url.indexOf('viewpath')>0 || url.indexOf('chase')>0){
				$('#content_home').css({'background-color':'white'});
			}else{
				$('#content_home').css({'background-color':'#f7f7f7'});
			}
			//检测本地缓存
			if (CP.Storage.get(url) && CP.Storage.get(url) != '') {//  false
				success(CP.Storage.get(url));
				return;
			}
			$.ajaxSetup({global: false,cache: true});
			jQuery.ajax({
				type: 'GET',
				dataType: 'text',
				cache: true,
				url: url,
				success: function (html) {
					if (!CP.Storage.get(url)) {
						CP.Storage.set(url, html);
					}
					success(html);
				},
				error: function (e) {
					if (e.status == 404) {
						window.location.href = '#type=index';
						return;
					}
				}
			})
		}

		function success(html_) {
			$("body").removeClass("home");
			$domBox.html(html_);
			$("#home_page").hide();
			$("#content_home").show();
			window.scrollTo(0, 1);
			pageLoading.hide();
		}
	};

	var change = function () {
		var type = CP.Util.getParaHash('type') || 'index';
		var page = decodeURIComponent(CP.Util.getParaHash('p'));
		if (type.indexOf("index") > -1) {
			type = 'index';
		}
		switch (type) {
			case 'index':
			case 'url':
				//有些页面我就是要他重新打开一次 而不是因为pageRoute == page 结果进resetPage了  而这些页面目前都是通过？后面的参数控制ui的
				if (pageRoute == page && page.indexOf('?in')<0) {
					try {
						resetPage();
						return false;
					} catch (e) {
					}
				} else if (type == 'url') {
					$("#home_page").hide();
					$domBox.html('<div style="height: 32px;margin: 100px auto;text-align: center;width: 32px;"><em class="rotate_load"></em><div>').show();
				}
				pageRoute = page || 'index.html';
				page = pageRoute;
				CP.Cookie.set('pageRoute', encodeURIComponent(page));
				getPage(page);
				return false;
				break;
			case 'fun':
				$('#content_home').show();
				$('#login').hide();
				var fun = CP.Util.getParaHash('fun');
				if (!/CP./.test(fun)) {
					window.location.replace(hostUrl + '#type=index');
					return;
				}
				var para = CP.Util.getParaHash('in');
				if (/\,/.test(para)) {
					para = para.split(',');
				}
				if (para.length == 1)para = para[0];
				try {
					$('#box_header').removeClass('zcHeader');
					fun = fun.split('.');
					switch (fun.length) {
						case 1:
							window[fun[0]](para);
							break;
						case 2:
							window[fun[0]][fun[1]](para);
							break;
						case 3:
							window[fun[0]][fun[1]][fun[2]](para);
							break;
						case 4:
							window[fun[0]][fun[1]][fun[2]][fun[3]](para);
							break;
					}
				} catch (e) {
					pageRoute ? window.location.replace(hostUrl + '#type=url&p=' + pageRoute) : window.location.replace(hostUrl + '#type=index');
				}
				break;
			default:
				window.location.replace('#type=index');
			break;
		}
	};
	//初始化
	var init = function (o) {
		/*agent_ 代理商通常是注册的时候直接可以其他的参数一起POST过去的
		 * 3002 5.9188.com 
		 * 3004 陆慧明
		 * 3001 微信
		 * */
		var agent_ = CP.Util.getPara('agent');
		if(agent_){
			localStorage.setItem('agent',agent_);
			CP.Data.source = agent_;
		}
		if ("onhashchange" in window) {
			window.addEventListener ? window.addEventListener("hashchange", change, false) : window.attachEvent("onhashchange", change);
		} else {
			setInterval(function () {
				if (_G_hash != window.location.hash) {
					_G_hash = window.location.hash;
					change();
				}
			}, 500);
		}
		if (window.location.hash == '') {
			window.location.replace('#type=index');
		} else {
			change();
		}
	};
	init();
}();