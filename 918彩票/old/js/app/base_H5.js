var $ = function(obj){
	if(!obj){ return null; }
	
	if(typeof(obj) === "object"){
		return new B(obj);
	}
	else if(typeof(obj) === "string"){
		if(obj.indexOf("#") === 0){
			return new B(document.querySelector(obj));
		}
		else{
			return new B(document.querySelectorAll(obj));
		}
	}
}
var $$ = function(obj){
	if(obj.indexOf("#") == 0){
		return document.querySelector(obj);
	}
	else{
		return document.querySelectorAll(obj);
	}
}
var B = function(DOM){
	this.parent = function(){
		return new B(DOM.parentNode);
	}
	this.children = function(){
		return new B(DOM.children);
	}
	this.eq = function(i){
		return new B(DOM[i]);
	}
	this.length = function(){
		if(DOM){
			if(DOM.length){
				return DOM.length;
			}
			else{
				if(DOM.innerHTML || DOM.value || DOM.tagName){/*value for input tagName for empty element*/
					return 1;
				}
				else{
					return 0;
				}
			}
		}
		else{
			return 0;
		}
	}
	this.css = function(cssName,cssVal){
		/*$(dom).css({"":"","":""})->$(dom).css("","")->$(dom).css("")*/
		if(typeof(cssName) === "object"){
			for(var v in cssName){
				var x = v;/*临时记录*/
				var _split = v.indexOf("-");
				if(_split != -1){
					var a = v.substring(_split + 1,_split + 2);
					v = v.replace("-" + a,a.toUpperCase());
					console.log(v)
				}
				DOM.style[v] = cssName[x];
			}
			return this;
		}
		else{
			var _split = cssName.indexOf("-");
			if(_split != -1){
				var a = cssName.substring(_split + 1,_split + 2);
				cssName = cssName.replace("-" + a,a.toUpperCase());
			}
			if(cssName && !cssVal){
				return DOM.style[cssName];
			}
			else{/*background-color to backgroundColor*/
				DOM.style[cssName] = cssVal;
				return this;
			}
		}
	},
	this.attr = function(attrName,attrVal){
		/*$(dom).attr({"":"","":""})->$(dom).attr("","")->$(dom).attr("")*/
		if(typeof(attrName) === "object"){
			for(var v in attrName){
				DOM.setAttribute(v,attrName[v]);
			}
			return this;
		}
		else{
			if(attrName && !attrVal){
				return DOM.getAttribute(attrName);
			}
			else{
				DOM.setAttribute(attrName,attrVal);
				return this;
			}
		}
	},
	this.val = function(val){
		/*$(dom).val()*/
		if(val || typeof(val) === "string"){/*val("")*/
			DOM.value = val;
			return this;
		}
		else{
			return DOM.value;
		}
	},
	this.html = function(_val){
		/*$(dom).html("")->$(dom).html()->*/
		var val = typeof(_val) == "number" ? _val.toString() : _val;
		if(val){
			DOM.innerHTML = val;
			return this;
		}
		else{
			if(DOM.length){
				return DOM[0].innerHTML;
			}
			else{
				return DOM.innerHTML;
			}
		}
	},
	this.prev = function(){
		return new B(DOM.previousElementSibling);
	},
	this.next = function(){
		return new B(DOM.nextElementSibling);
	},
	this.addClass = function(cls){
		/*$(dom).addClass("")*/
		var clsSome = cls.indexOf(" ") ? true : false;/*addClass("a b c")*/
		var _l = this.length();
		if( _l == 1){
			if(DOM.length){
				if(!clsSome){
					DOM[0].classList.add(cls);
				}
				else{
					var current_className = DOM[0].className;
					if(current_className.indexOf(cls) == -1){
						DOM[0].className = current_className + " " + cls;
					}
				}
			}
			else{
				if(!clsSome){
					DOM.classList.add(cls);
				}
				else{
					var current_className = DOM.className;
					if(current_className.indexOf(cls) == -1){
						DOM.className = current_className + " " + cls;
					}
				}
			}
			return this;
		}
		else if(_l > 1){
			if(!clsSome){
				for(var i = _l; i--;){
					DOM[i].classList.add(cls);
				}
			}
			else{
				for(var i = _l; i--;){
					var current_className = DOM[i].className;
					if(current_className.indexOf(cls) == -1){
						DOM[i].className = current_className + " " + cls;
					}
				}
			}
			return DOM[_l - 1];
		}
	},
	this.removeClass = function(cls){
		/*$(dom).removeClass("")*/
		var clsSome = cls.indexOf(" ") ? true : false;/*removeClass("a b c")*/
		var _l = this.length();
		if(_l == 1){
			if(DOM.length){/*class*/
				if(!clsSome){
					DOM[0].classList.remove(cls);
				}
				else{
					var current_className = DOM[0].className;
					if(current_className.indexOf(cls) != -1){
						DOM[0].className = current_className.replace(cls,"");
					}
				}
			}
			else{/*id*/
				if(!clsSome){
					DOM.classList.remove(cls);
				}
				else{
					var current_className = DOM.className;
					if(current_className.indexOf(cls) != -1){
						DOM.className = current_className.replace(cls,"");
					}
				}
			}
			return this;
		}
		else if(_l > 1){
			if(!clsSome){
				for(var i = _l; i--;){
					DOM[i].classList.remove(cls);
				}
			}
			else{
				for(var i = _l; i--;){
					var current_className = DOM[i].className;
					if(current_className.indexOf(cls) != -1){
						DOM[i].className = current_className.replace(cls,"");
					}
				}
			}
			return DOM[_l - 1];
		}
	},
	this.clearClass = function(){
		/*$(dom).clearClass()*/
		var _l = DOM.length;
		if(_l){
			for(var i = _l; i--;){
				DOM[i].className = "";
			}
			return DOM[_l - 1];
		}
		else{
			DOM.className = "";
			return this;
		}
	}
	this.hasClass = function(cls){
		/*if( $(dom).hasClass("") )*/
		return DOM.classList.contains(cls);
	},
	this.show = function(){
		/*$(dom).show()*/
		DOM.style.display = "block";
		return this;
	},
	this.hide = function(){
		/*$(dom).hide()*/
		DOM.style.display = "none";
		return this;
	},
	this.remove = function(){
		/*$(dom).remove()*/
		DOM.parentNode.removeChild(DOM);
	},
	this.trigger = function(type){
		/*$(dom).trigger("touchend")*/
		var _event = document.createEvent("Event");
		_event.initEvent(type,true,true);
		DOM.dispatchEvent(_event);
		return this;
	},
	this.bind = function(type,fun){
		/*$(dom).bind("click",function(){})*/
		/*if(!DOM) return false;*/
		if(DOM.length){/*class*/
			if(DOM.length == 1){
				DOM[0].addEventListener(type,function(){
					fun.call(this);
				},false)
			}
			else{
				var _l = this.length();
				for(var i = _l; i--;){
					DOM[i].addEventListener(type,function(){
						fun.call(this);
					},false)
				}
				return DOM[_l - 1];
			}
		}
		else{/*id || window.length == 0*/
			if(DOM.innerHTML || DOM === window || DOM.value || DOM.tagName){/*tagName for empty element*/
				DOM.addEventListener(type,function(){
					fun.call(this);
				},false)
			}
			else{
				return null;
			}
		}			
		return this;
		/*
		if(type === "tap"){
			DOM.addEventListener("touchstart",function(){
				event.preventDefault();
			},false)
			DOM.addEventListener("touchend",function(){
				event.preventDefault();
				fun.call(this);
			},false)
		}
		*/
	},
	this.unbind = function(type,fun){
		/*$(dom).unbind("click",fun)*/
		DOM.removeEventListener(type,fun,false);
		return this;
	},
	this.width = function(){
		/*$(dom).width()*/
		return DOM.offsetWidth;
	},
	this.height = function(){
		/*$(dom).height()*/
		return DOM.offsetHeight;
	},
	this.offset = function(){
		/*$(dom).offset().top*/
		return {
			top : DOM.offsetTop,
			left : DOM.offsetLeft
		}
	},
	this.find = function(options){
		/*$(dom).find("p")*/
		return new B(DOM.querySelectorAll(options));
	}
	this.append = function(ele){
		if(typeof(ele) === "string"){
			DOM.innerHTML += ele;
		}
		else{
			DOM.appendChild(ele);
		}
		return this;
	}
	/*以下为动效*/
	this.fadeIn = function(second,callback,fadeOut){
		/*$(DOM).fadeIn(200,function(){ alert("ok"); })*/
		var t = this;
		var _second;
		var _second_callback = false;
		if(typeof(second) === "function"){
			_second = 400;
			_second_callback = true;
		}
		else{
			_second = second > 400 ? second : 400;
		}

		if(fadeOut){
			t.css("webkitTransition","opacity "+ _second +"ms ease");
			setTimeout(function(){
				t.css("opacity",0.1);
				var transEndOut = function(){
					/*console.log(t.attr("id")+"out");*/
					$(this).hide();
					_second_callback ? second.call(this) : (callback && callback.call(this));
					DOM.removeEventListener("webkitTransitionEnd",transEndOut,false);
				}
				DOM.addEventListener("webkitTransitionEnd",transEndOut,false);
			},100)
		}
		else{
			t.css({"opacity":0,"display":"block","webkitTransition":"opacity "+ _second +"ms ease"});
			setTimeout(function(){
				t.css("opacity",1);
				var transEndIn = function(){
					/*console.log(t.attr("id")+"in");*/
					_second_callback ? second.call(this) : (callback && callback.call(this));
					DOM.removeEventListener("webkitTransitionEnd",transEndIn,false);
				}
				DOM.addEventListener("webkitTransitionEnd",transEndIn,false);
			},100)
		}
	},
	this.fadeOut = function(second,callback){
		this.fadeIn(second,callback,true);
	},
	this.animate = function(params,dur,callback,eas,delay){
		/*
		检测浏览器类型 webkit moz o IE
		left,right,top,bottom
		fadeIn,fadeOut,
		*/
		var dummyStyle = document.createElement("div").style;
		var prefix = (function () {
			var prefixs = "t,webkitT,MozT,msT,OT".split(","), t, i = 0, l = prefixs.length;
			for ( ; i < l; i++ ) {
				t = prefixs[i] + "ransform";
				if ( t in dummyStyle ) {
					return prefixs[i].substr(0, prefixs[i].length - 1);
				}
			}
			return false;
		}());
		var cssPrefix = prefix ? "-" + prefix.toLowerCase() + "-" : "";/*-webkit-  webkitTransition = cssPrefix + 'transform',1s,linear*/
		var transEnd = (function(){
			if (!prefix) return false;
			var transitionEnd = {
					''			: 'transitionend',
					'webkit'	: 'webkitTransitionEnd',
					'Moz'		: 'transitionend',
					'O'			: 'otransitionend',
					'ms'		: 'MSTransitionEnd'
				};
			return transitionEnd[prefix];
		}());
		var prefixStyle = function(style){/*style = transform  return = webkitTransform*/
			if (!prefix) return style;
			style = style.charAt(0).toUpperCase() + style.substr(1);
			return prefix + style;
		}
		var	transform = prefixStyle('transform'),
			transitionProperty = prefixStyle('transitionProperty'),
			transitionDuration = prefixStyle('transitionDuration'),
			transitionTimingFunction = prefixStyle('transitionTimingFunction'),
			transitionDelay = prefixStyle('transitionDelay');
			/*transformOrigin = prefixStyle('transformOrigin'),*/
		
		var paramArray = new Array();
		for(var param in params){
			paramArray.push(param);
		}
		/*
		需要变换的属性 width height font-size      left right=transform translateX top bottom=translateY 放大 缩小=scale 旋转=rotate
		translate的属性都不影响周边 都是浮着改变
		left top jquery也是不影响周边 而且不给父级加position属性
		*/
		var transEndFun = function(e){
			callback ? callback() : "";
			e.target.removeEventListener(transEnd,transEndFun,false);
		}
		this.css({
				transitionProperty		:	paramArray.join(","),
				transitionDuration		:	dur ? dur/1000 + "s" : ".2s",
				transitionTimingFunction:	eas ? eas : "ease",
				transitionDelay			:	delay ? delay/1000 + "s" : "0s",
		}).dom.addEventListener(transEnd,transEndFun,false);
		
		/*设置CSS 此时已经有了动画参数 根据参数的长度*/
		var iCss = 0, param_l = paramArray.length;
		for(; iCss < param_l; iCss++){
			var i = paramArray[iCss];
			this.css(i,params[i]);
		}
		return this;
	}
}

var M = {
	baseUrl : "/Dropbox/work_file/koudai/weidian_H5", /*sony*/
	/*
	baseUrl : "/vshop/2/H5", //WD
	baseUrl : "/test/koudai", //iamhoubiao.com
	baseUrl : "/work_file/koudai", //home
	*/
	h5Port : "http://wd.koudai.com/vshop/2/H5",
	pubPort : "http://wd.koudai.com/vshop/2/public",
	version : 201312101758,
	doc : document,
	win : window,
	w : document.body.offsetWidth,
	h : document.body.offsetHeight,
	/*
	jsonp : function(href,_callback){
		var a = "jsonpcallback_" + new Date().getTime() + "_" + Math.random().toString().substr(2);
		window[a] = function(json){
			window[a] = undefined;
			_callback ? _callback(json) : "";
		}
		M.loadScript(href + (href.indexOf("?") == -1 ? "?callback=" : "&callback=") + a);
	},
	*/
	jsonp : function(href,_callback,_err){
		var date_start = new Date();/*局部*/
		var _t = date_start.getTime() + "_" + Math.random().toString().substr(2);/*后缀防重复*/
		var a = "jsonpcallback_" + _t;/*全局 避免重复*/
		var b = "interval_" + _t;/*全局 避免重复 循环处理*/
		window[a] = function(json){
			window[a] = undefined;
			_callback && _callback(json);
		}
		window[b] = setInterval(function(){
			if(new Date() - date_start > 3000){
				clearInterval(window[b]);
				_err && _err();
				//console.log("-------------------" + href + "网络不给力，一会再试试吧");
			}
		},100);
		M.loadScript(href + (href.indexOf("?") == -1 ? "?callback=" : "&callback=") + a,function(){
			//如果地址不对 不会触发onload事件 也就不考虑了
			//如果地址对 并且 已经加载了 那就是已经返回值了
			clearInterval(window[b]);
			//console.log("-------------------" + href + "is onload");
		});
	},
	get : function(href,callback,error_callback){
		var ajax = new XMLHttpRequest();
		ajax.open("GET",href,true);
		ajax.send();
		var date_start = new Date();
		var ajax_notice = setInterval(function(){
			if( new Date() - date_start > 10000){
				alert("网络不给力，一会再试试吧");
				error_callback && error_callback();
			}
		},100);
		ajax.onreadystatechange = function(){
			if(ajax.readyState == 4){
				clearInterval(ajax_notice);
				switch (ajax.status){
					case 200:
					callback(ajax.responseText);
					break;
					case 404:
					alert("404--URL地址未找到");
					ajax_error();
					break;
					case 500:
					alert("500--服务器错误");
					ajax_error();
					break;
				}
			}
		}
		function ajax_error(){
			ajax.abort();
			error_callback && error_callback();
		}
	},
	lazyLoad : function(){/*原生 非B*/
		var img = M.doc.getElementsByClassName("lazy_load"), img_l = img.length;
		if(img_l){
			var img_arr = [];
			var lazy_src = M.baseUrl + "/images/default_img.png";
			for(var i = 0; i < img_l; i++){
				(function(i){
					var z = i, that = img[z], src = that.getAttribute("data-src"), thatClass = that.className;
					that.src = lazy_src; 
					img_arr[z] = new Image();
					img_arr[z].src = src;
					img_arr[z].onload = function(){
						that.src = src;
						that.className = thatClass.replace("lazy_load","");
					}
				}(i));
			}
		}
	},
	loadScript : function(url,callback){
		var script = document.createElement("script");
		if(script.readyState){
			script.onreadystatechange = function(){
				if(script.readyState == "loaded" || script.readyState == "complete"){ script.onreadystatechange = null; callback && callback(); }
			}
		}
		else{ script.onload = function(){ callback && callback(); } }
		script.src = (url.indexOf("?") > 0) ? (url +"&ver="+ M.version) : (url +"?ver="+ M.version);
		var _s = document.getElementsByTagName("script")[0];
		_s.parentNode.insertBefore(script,_s);
	},
	json : function(data){
		return JSON.parse(data);
	},
	urlQuery : function(name){
		var href = location.search;
		href = href.replace(/#[^&]*$/,'');
		var a = href.substr(href.indexOf(name));
		var b = new Array();
		if(a.indexOf("&") == -1){
			b = a.split("=");
		}
		else{
			b = a.substr(0,a.indexOf("&")).split("=");
		}
		return b[1];
	},
	getCookie : function(name){
		if(localStorage){
			return localStorage.getItem(name) ? localStorage.getItem(name) : (sessionStorage.getItem(name) ? sessionStorage.getItem(name) : "");
			/*
			if(name == "WD_hide_dis"){
				return sessionStorage.getItem(name) == null ? "" : sessionStorage.getItem(name);
			}
			else{
				return localStorage.getItem(name) == null ? "" : localStorage.getItem(name);
			}
			*/
		}
		else{
			var cookie_start = document.cookie.indexOf(name);
			var cookie_end = document.cookie.indexOf(";", cookie_start);
			return cookie_start == -1 ? "" : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
		}
	},
	setCookie : function(name,value,isSession){
		if(localStorage){
			isSession ? sessionStorage.setItem(name,value) : localStorage.setItem(name,value);			
			/*
			if(name == "WD_hide_dis"){
				console.log("isSession")
				sessionStorage.setItem(name,value);
			}
			else{
				console.log("isLocal")
				localStorage.setItem(name,value);
			}
			*/
		}
		else{
			var expires = new Date();
			expires.setTime(expires.getTime() + 2592000000);
			isSession ? document.cookie = escape(name) + '=' + escape(value) + ('/') + ('') + ('') : document.cookie = escape(name) + '=' + escape(value) + (expires ? '; expires=' + expires.toGMTString() : '') + ('/') + ('') + ('');
			/*
			if(name == "WD_hide_dis"){
				document.cookie = escape(name) + '=' + escape(value) + ('/') + ('') + ('');
			}
			else{
				document.cookie = escape(name) + '=' + escape(value) + (expires ? '; expires=' + expires.toGMTString() : '') + ('/') + ('') + ('');
			}
			*/
		}
	},
	delCookie : function(name){
		if(localStorage){
			localStorage.removeItem(name);
		}
		else{
			document.cookie = name+"=;expires="+(new Date(0)).toGMTString();
		}
	},
	clearCookie : function(){
		if(localStorage){
			localStorage.clear();
		}
		else{
			var keys = document.cookie.match(/[^ =;]+(?=\=)/g); 
			if (keys) {
				var l = keys.length;
				for (var i = l; i--;) 
				document.cookie = keys[i]+'=0;expires='+ new Date(0).toUTCString() 
			} 
		}
	},
	isWeixin : function(){
		return navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ? 1 : 0;
		/*
		if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1){
			return true;
		}
		else{
			return false;
		}
		*/
	},
	init : function(){
		window.scroll(0,0);
	}
}
$(window).bind("load",function(){
	M.init();
})