(function (a, b, c) {
	var d = !!b.ActiveXObject,
	e = d && !b.XMLHttpRequest,
	f = function () {},
	g = 0,
	h = /^url:/,
	i,
	j,
	k = "JDG" + (new Date).getTime(),
	l = b.document,
	m,
	n = function (a, b, c) {
		var d = a.length;
		for (; b < d; b++) {
			c = l.querySelector ? a[b].src: a[b].getAttribute("src", 4);
			if (c.substr(c.lastIndexOf("/")).indexOf("lhgdialog") !== -1) break
		} 
		return c = c.split("?"),
		m = c[1],
		c[0].substr(0, c[0].lastIndexOf("/") + 1)
	} (l.getElementsByTagName("script"), 0),
	o = function (a) {
		if (m) { 
			var b = m.split("&"),
			c = 0,
			d = b.length,
			e;
			for (; c < d; c++) {
				e = b[c].split("=");
				if (a === e[0]) return e[1]
			}
		}
		return null
	},
	p = o("skin") || "skin_brown",
	q,
	r = function (a) {
		try {
			q = a.top.document,
			q.getElementsByTagName
		} catch(b) {
			return q = a.document,
			a
		}
		return o("self") === "true" || q.getElementsByTagName("frameset").length > 0 ? (q = a.document, a) : a.top
	} (b),
	s = q.documentElement,
	t = a(q),
	u = a(r),
	v = a(q.getElementsByTagName("html")[0]);
	if (q.compatMode === "BackCompat") {
		alert("\u9519\u8bef: \u9875\u9762\u6587\u6863\u7c7b\u578b(DOCTYPE)\u672a\u58f0\u660e!");
		return
	}
	try {
		q.execCommand("BackgroundImageCache", !1, !0)
	} catch(w) {} (function (a) {
		if (!a) {
			var b = q.getElementsByTagName("head")[0],
			c = q.createElement("link"); 
			c.href = n + "skins/" + p + ".css",
			c.rel = "stylesheet",
			c.id = "lhgdglink",
			b.insertBefore(c, b.firstChild) 
		}
	})(q.getElementById("lhgdglink"));
	var x = function (a, b, d) {
		a = a || {},
		typeof a == "string" && (a = {
			content: a
		});
		var e, f = x.setting;
		for (var h in f) a[h] === c && (a[h] = f[h]);
		return a.id = a.id || k + g,
		e = x.list[a.id],
		e ? e.zindex().focus() : (a.button = a.button || [], a.ok = b || a.ok, a.cancel = d || a.cancel, a.ok && a.button.push({
			name: a.okVal,
			callback: a.ok,
			focus: !0
		}), a.cancel && a.button.push({
			name: a.cancelVal,
			callback: a.cancel
		}), x.setting.zIndex = a.zIndex, g++, x.list[a.id] = i ? i._init(a) : new x.fn._init(a))
	};
	x.fn = x.prototype = {
		constructor: x,
		_init: function (a) {
			var c = this,
			d, e = a.content,
			f = h.test(e),
			g = a.icon;
			return c.config = a,
			c.DOM = d = c.DOM || c._getDOM(),
			c.opener = b,
			g && !f ? (a.min = !1, a.max = !1, d.icon[0].style.display = "", d.icon_bg[0].src = a.path + "skins/icons/" + g) : d.icon[0].style.display = "none",
			d.wrap[0].style.display = "block",
			d.wrap.addClass(a.skin),
			d.rb[0].style.cursor = a.resize ? "se-resize": "auto",
			d.title[0].style.cursor = a.drag ? "move": "auto",
			d.max[0].style.display = a.max ? "inline-block": "none",
			d.min[0].style.display = a.min ? "inline-block": "none",
			d.close[0].style.display = a.cancel === !1 ? "none": "inline-block",
			d.content[0].style.padding = a.padding,
			c.title(a.title).content(e, !0, f).button(a.button).size(a.width, a.height).position(a.left, a.top).time(a.time)[a.show ? "show": "hide"](!0).zindex().focus(),
			a.lock && c.lock(),
			c._addEvent(),
			c._ie6PngFix(),
			i = null,
			!f && a.init && a.init.call(c, b),
			c
		},
		title: function (a) {
			if (a === c) return this;
			var b = this.DOM,
			d = b.border,
			e = b.title[0],
			f = "ui_state_tips";
			return a === !1 ? (e.style.display = "none", e.innerHTML = "", d.addClass(f)) : (e.style.display = "", e.innerHTML = a, d.removeClass(f)),
			this
		},
		content: function (a, b, d) {
			if (a === c) return this;
			var e = this,
			f = e.DOM,
			g = f.wrap[0],
			h = g.offsetWidth,
			i = g.offsetHeight,
			j = parseInt(g.style.left),
			k = parseInt(g.style.top),
			l = g.style.width,
			m = f.content,
			n = x.setting.content;
			return d ? (m[0].innerHTML = n, e._iframe(a.split("url:")[1])) : m.html(a),
			b || (h = g.offsetWidth - h, i = g.offsetHeight - i, j -= h / 2, k -= i / 2, g.style.left = Math.max(j, 0) + "px", g.style.top = Math.max(k, 0) + "px", l && l !== "auto" && (g.style.width = g.offsetWidth + "px"), e._autoPositionType()),
			e._ie6SelectFix(),
			e
		},
		button: function () {
			var b = this,
			c = arguments,
			d = b.DOM.buttons[0],
			e = "ui_state_highlight",
			f = b._listeners = b._listeners || {},
			g = a.isArray(c[0]) ? c[0] : [].slice.call(c);
			return a.each(g, function (c, g) {
				var h = g.name,
				i = !f[h],
				j = i ? q.createElement("input") : f[h].elem;
				f[h] || (f[h] = {}),
				g.callback && (f[h].callback = g.callback),
				g.focus && (b._focus && b._focus.removeClass(e), b._focus = a(j).addClass(e), b.focus()),
				j[k + "callback"] = h,
				j.disabled = !!g.disabled,
				i && (j.type = "button", j.value = h, f[h].elem = j, d.appendChild(j))
			}),
			d.style.display = g.length ? "": "none",
			b._ie6SelectFix(),
			b
		},
		size: function (a, b) {
			var c = this,
			d = c.DOM,
			e = d.wrap[0],
			f = e.style,
			g = d.main[0].style;
			return a && (f.width = "auto", typeof a == "number" ? g.width = a + "px": typeof a == "string" && (g.width = a), a !== "auto" && (f.width = e.offsetWidth + "px")),
			b && (typeof b == "number" ? g.height = b + "px": typeof b == "string" && (g.height = b)),
			c._ie6SelectFix(),
			c
		},
		position: function (a, b) {
			var d = this,
			f = d.config,
			g = d.DOM.wrap[0],
			h = e ? !1 : f.fixed,
			i = e && f.fixed,
			j = t.scrollLeft(),
			k = t.scrollTop(),
			l = h ? 0 : j,
			m = h ? 0 : k,
			n = u.width(),
			o = u.height(),
			p = g.offsetWidth,
			q = g.offsetHeight,
			r = g.style;
			if (a || a === 0) d._left = a.toString().indexOf("%") !== -1 ? a: null,
			a = d._toNumber(a, n - p),
			typeof a == "number" ? (a = i ? a += j: a + l, r.left = Math.max(a, l) + "px") : typeof a == "string" && (r.left = a);
			if (b || b === 0) d._top = b.toString().indexOf("%") !== -1 ? b: null,
			b = d._toNumber(b, o - q),
			typeof b == "number" ? (b = i ? b += k: b + m, r.top = Math.max(b, m) + "px") : typeof b == "string" && (r.top = b);
			return a !== c && b !== c && d._autoPositionType(),
			d
		},
		show: function (b) {
			return this.DOM.wrap[0].style.visibility = "visible",
			!b && this._lock && (a("#ldg_lockmask", q)[0].style.display = ""),
			this
		},
		hide: function (b) {
			return this.DOM.wrap[0].style.visibility = "hidden",
			!b && this._lock && (a("#ldg_lockmask", q)[0].style.display = "none"),
			this
		},
		close: function () {
			var c = this,
			d = c.DOM,
			e = d.wrap,
			f = x.list,
			g = c.config.close;
			c.time();
			if (c.iframe) {
				if (typeof g == "function" && g.call(c, c.iframe.contentWindow, b) === !1) return c;
				a(c.iframe).unbind("load", c._fmLoad).attr("src", "about:blank").remove(),
				d.content.removeClass("ui_state_full"),
				c._frmTimer && clearTimeout(c._frmTimer)
			} else if (typeof g == "function" && g.call(c, b) === !1) return c;
			c.unlock(),
			c._minState && (d.main[0].style.display = "", d.buttons[0].style.display = "", d.dialog[0].style.width = ""),
			c._maxState && (v.removeClass("ui_lock_scroll"), d.res[0].style.display = "none"),
			e[0].className = d.wrap[0].style.cssText = "",
			e[0].style.display = "none",
			d.border.removeClass("ui_state_focus"),
			d.title[0].innerHTML = "",
			d.content.html(""),
			d.buttons[0].innerHTML = "",
			x.focus === c && (x.focus = null),
			delete f[c.config.id],
			c._removeEvent(),
			c.hide(!0)._setAbsolute();
			for (var h in c) c.hasOwnProperty(h) && h !== "DOM" && delete c[h];
			return i ? e.remove() : i = c,
			c
		},
		time: function (a, b) {
			var c = this,
			d = c.config.cancelVal,
			e = c._timer;
			return e && clearTimeout(e),
			b && b.call(c),
			a && (c._timer = setTimeout(function () {
				c._click(d)
			},
			1e3 * a)),
			c
		},
		reload: function (c, d) {
			c = c || b;
			try {
				c.location.href = d ? d: c.location.href
			} catch(e) {
				d = this.iframe.src,
				a(this.iframe).attr("src", d)
			}
			return this
		},
		zindex: function () {
			var a = this,
			b = a.DOM,
			c = a._load,
			d = x.focus,
			e = x.setting.zIndex++;
			return b.wrap[0].style.zIndex = e,
			d && d.DOM.border.removeClass("ui_state_focus"),
			x.focus = a,
			b.border.addClass("ui_state_focus"),
			c && c.style.zIndex && (c.style.display = "none"),
			d && d !== a && d.iframe && (d._load.style.display = ""),
			a
		},
		focus: function () {
			try {
				elemFocus = this._focus && this._focus[0] || this.DOM.close[0],
				elemFocus && elemFocus.focus()
			} catch(a) {}
			return this
		},
		lock: function () {
			var b = this,
			c, d = x.setting.zIndex - 1,
			f = b.config,
			g = a("#ldg_lockmask", q)[0],
			h = g ? g.style: "",
			i = e ? "absolute": "fixed";
			return g || (c = '<iframe src="about:blank" style="width:100%;height:100%;position:absolute;top:0;left:0;z-index:-1;filter:alpha(opacity=0)"></iframe>', g = q.createElement("div"), g.id = "ldg_lockmask", g.style.cssText = "position:" + i + ";left:0;top:0;width:100%;height:100%;overflow:hidden;background:" + f.background + ";", a(g).css({
				opacity: f.opacity
			}), h = g.style, e && (g.innerHTML = c), q.body.appendChild(g)),
			i === "absolute" && (h.width = u.width(), h.height = u.height(), h.top = t.scrollTop(), h.left = t.scrollLeft(), b._setFixed(g)),
			h.zIndex = d,
			h.display = "",
			b.zindex(),
			b.DOM.border.addClass("ui_state_lock"),
			b._lock = !0,
			b
		},
		unlock: function () {
			var b = this,
			c = b.config,
			d = a("#ldg_lockmask", q)[0];
			if (d && b._lock) {
				if (c.parent && c.parent._lock) {
					var e = c.parent.DOM.wrap[0].style.zIndex;
					d.style.zIndex = parseInt(e, 10) - 1
				} else d.style.display = "none";
				b.DOM.border.removeClass("ui_state_lock")
			}
			return b
		},
		max: function () {
			if (!this.config.max) return this;
			var a = this,
			b, c = a.DOM,
			d = c.wrap[0].style,
			e = c.main[0].style,
			f = c.rb[0].style,
			g = c.title[0].style,
			h = a.config,
			i = t.scrollTop(),
			j = t.scrollLeft();
			return a._maxState ? (v.removeClass("ui_lock_scroll"), d.top = a._or.t, d.left = a._or.l, a.size(a._or.w, a._or.h)._autoPositionType(), h.drag = a._or.d, h.resize = a._or.r, f.cursor = a._or.rc, g.cursor = a._or.tc, c.res[0].style.display = "none", c.max[0].style.display = "inline-block", delete a._or, a._maxState = !1) : (v.addClass("ui_lock_scroll"), a._minState && a.min(), a._or = {
				t: d.top,
				l: d.left,
				w: e.width,
				h: e.height,
				d: h.drag,
				r: h.resize,
				rc: f.cursor,
				tc: g.cursor
			},
			d.top = i + "px", d.left = j + "px", b = a._maxSize(), a.size(b.w, b.h)._setAbsolute(), h.drag = !1, h.resize = !1, f.cursor = "auto", g.cursor = "auto", c.max[0].style.display = "none", c.res[0].style.display = "inline-block", a._maxState = !0),
			a
		},
		_maxSize: function () {
			var a = this,
			b = a.DOM,
			c = b.wrap[0],
			d = b.main[0],
			e,
			f;
			return e = u.width() - c.offsetWidth + d.offsetWidth,
			f = u.height() - c.offsetHeight + d.offsetHeight,
			{
				w: e,
				h: f
			}
		},
		min: function () {
			if (!this.config.min) return this;
			var a = this,
			b = a.DOM,
			c = b.main[0].style,
			d = b.buttons[0].style,
			e = b.dialog[0].style,
			f = b.rb[0].style.cursor,
			g = a.config.resize;
			return a._minState ? (c.display = "", d.display = a._minRz.btn, e.width = "", g = a._minRz, f.cursor = a._minRz.rzs ? "se-resize": "auto", delete a._minRz, a._minState = !1) : (a._maxState && a.max(), a._minRz = {
				rzs: g,
				btn: d.display
			},
			c.display = "none", d.display = "none", e.width = c.width, f.cursor = "auto", g = !1, a._minState = !0),
			a._ie6SelectFix(),
			a
		},
		get: function (a, b) {
			return x.list[a] ? b === 1 ? x.list[a] : x.list[a].iwin || null: null
		},
		_iframe: function (b) {
			var c = this,
			d, f, g, h, i, j, k, l = c.DOM.content,
			m = c.config,
			n = c._load = a(".ui_loading", l[0])[0],
			o = "position:absolute;left:-9999em;border:none 0;background:transparent",
			p = "width:100%;height:100%;border:none 0;";
			if (m.cache === !1) {
				var s = (new Date).getTime(),
				t = b.replace(/([?&])_=[^&]*/, "$1_=" + s);
				b = t + (t === b ? (/\?/.test(b) ? "&": "?") + "_=" + s: "")
			}
			d = c.iframe = q.createElement("iframe"),
			d.name = m.id,
			d.style.cssText = o,
			d.setAttribute("frameborder", 0, 0),
			f = a(d),
			l[0].appendChild(d),
			c._frmTimer = setTimeout(function () {
				f.attr("src", b)
			},
			1);
			var u = c._fmLoad = function () {
				l.addClass("ui_state_full");
				var b = c.DOM,
				f, o = b.lt[0].offsetHeight,
				q = b.main[0].style;
				n.style.cssText = "display:none;position:absolute;background:#FFF;opacity:0;filter:alpha(opacity=0);z-index:1;width:" + q.width + ";height:" + q.height + ";";
				try {
					g = c.iwin = d.contentWindow,
					h = a(g.document),
					i = a(g.document.body)
				} catch(s) {
					d.style.cssText = p;
					return
				}
				j = m.width === "auto" ? h.width() + (e ? 0 : parseInt(i.css("marginLeft"))) : m.width,
				k = m.height === "auto" ? h.height() : m.height,
				setTimeout(function () {
					d.style.cssText = p
				},
				0),
				c._maxState || c.size(j, k).position(m.left, m.top),
				n.style.width = q.width,
				n.style.height = q.height,
				m.init && m.init.call(c, g, r)
			};
			c.iframe.api = c,
			f.bind("load", u)
		},
		_getDOM: function () {
			var b = q.createElement("div"),
			c = q.body;
			b.style.cssText = "position:absolute;visibility:hidden;",
			b.innerHTML = x.templates,
			c.insertBefore(b, c.firstChild);
			var d, e = 0,
			f = {
				wrap: a(b)
			},
			g = b.getElementsByTagName("*"),
			h = g.length;
			for (; e < h; e++) d = g[e].className.split("ui_")[1],
			d && (f[d] = a(g[e]));
			return f
		},
		_toNumber: function (a, b) {
			return ! a && a !== 0 || typeof a == "number" ? a: (a.indexOf("%") !== -1 && (a = parseInt(b * a.split("%")[0] / 100)), a)
		},
		_ie6PngFix: e ?
		function () {
			var a = 0,
			b, c, d, e, f = x.setting.path + "/skins/",
			g = this.DOM.wrap[0].getElementsByTagName("*");
			for (; a < g.length; a++) b = g[a],
			c = b.currentStyle.png,
			c && (d = f + c, e = b.runtimeStyle, e.backgroundImage = "none", e.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + d + "',sizingMethod='scale')")
		}: f,
		_ie6SelectFix: e ?
		function () {
			var a = this.DOM.wrap,
			b = a[0],
			c = k + "iframeMask",
			d = a[c],
			e = b.offsetWidth,
			f = b.offsetHeight;
			e += "px",
			f += "px",
			d ? (d.style.width = e, d.style.height = f) : (d = b.appendChild(q.createElement("iframe")), a[c] = d, d.src = "about:blank", d.style.cssText = "position:absolute;z-index:-1;left:0;top:0;filter:alpha(opacity=0);width:" + e + ";height:" + f)
		}: f,
		_autoPositionType: function () {
			this[this.config.fixed ? "_setFixed": "_setAbsolute"]()
		},
		_setFixed: function (a) {
			var b = a ? a.style: this.DOM.wrap[0].style;
			if (e) {
				var c = t.scrollLeft(),
				d = t.scrollTop(),
				f = parseInt(b.left) - c,
				g = parseInt(b.top) - d,
				h = "this.ownerDocument.documentElement";
				this._setAbsolute(),
				b.setExpression("left", h + ".scrollLeft +" + f),
				b.setExpression("top", h + ".scrollTop +" + g)
			} else b.position = "fixed"
		},
		_setAbsolute: function () {
			var a = this.DOM.wrap[0].style;
			e && (a.removeExpression("left"), a.removeExpression("top")),
			a.position = "absolute"
		},
		_click: function (a) {
			var c = this,
			d = c._listeners[a] && c._listeners[a].callback;
			return typeof d != "function" || d.call(c, b) !== !1 ? c.close() : c
		},
		_reset: function (b) {
			var c, d = this,
			f = u.width(),
			g = u.height(),
			h = d._winSize || f * g,
			i = d._lockDocW || f,
			j = d._left,
			k = d._top;
			if (b) {
				d._lock && e && a("#ldg_lockmask", q).css({
					width: f + "px",
					height: g + "px"
				}),
				newWidth = d._lockDocW = f,
				c = d._winSize = f * g;
				if (h === c) return
			}
			if (d._maxState) {
				var l = d._maxSize();
				d.size(l.w, l.h)
			}
			if (b && Math.abs(i - newWidth) === 17) return;
			(j || k) && d.position(j, k)
		},
		_addEvent: function () {
			var a, b = this,
			c = b.config,
			e = b.DOM;
			b._winResize = function () {
				a && clearTimeout(a),
				a = setTimeout(function () {
					b._reset(d)
				},
				140)
			},
			u.bind("resize", b._winResize),
			e.wrap.bind("click", function (a) {
				var d = a.target,
				f;
				if (d.disabled) return ! 1;
				if (d === e.close[0]) return b._click(c.cancelVal),
				!1;
				if (d === e.max[0] || d === e.res[0] || d === e.max_b[0] || d === e.res_b[0] || d === e.res_t[0]) return b.max(),
				!1;
				if (d === e.min[0] || d === e.min_b[0]) return b.min(),
				!1;
				f = d[k + "callback"],
				f && b._click(f)
			}).bind("mousedown", function (a) {
				b.zindex();
				var d = a.target;
				if (c.drag !== !1 && d === e.title[0] || c.resize !== !1 && d === e.rb[0]) return y(a),
				!1
			}),
			c.max && e.title.bind("dblclick", function () {
				return b.max(),
				!1
			})
		},
		_removeEvent: function () {
			var a = this,
			b = a.DOM;
			b.wrap.unbind(),
			b.title.unbind(),
			u.unbind("resize", a._winResize)
		}
	},
	x.fn._init.prototype = x.fn,
	a.fn.dialog = function () {
		var a = arguments;
		return this.bind("click", function () {
			return x.apply(this, a),
			!1
		}),
		this
	},
	x.focus = null,
	x.list = {},
	j = function (a) {
		var b = a.target,
		c = x.focus,
		d = a.keyCode;
		if (!c || !c.config.esc) return;
		d === 27 && c._click(c.config.cancelVal)
	},
	t.bind("keydown", j),
	r != b && a(b).bind("unload", function () {
		var b = x.list;
		for (var c in b) b[c] && b[c].close();
		i && i.DOM.wrap.remove(),
		t.unbind("keydown", j),
		delete x[k + "_data"],
		a("#ldg_lockmask", q)[0] && a("#ldg_lockmask", q).remove(),
		a("#ldg_dragmask", q)[0] && a("#ldg_dragmask", q).remove()
	}),
	x[k + "_data"] = {},
	x.data = function (a, b) {
		var d = x[k + "_data"];
		if (b !== c) d[a] = b;
		else return d[a];
		return d
	},
	x.removeDate = function (a) {
		var b = x[k + "_data"];
		b && b[a] && delete b[a]
	},
	a(function () {
		setTimeout(function () {
			if (g) return;
			x({
				left: "-9999em",
				time: 9,
				fixed: !1,
				lock: !1
			})
		},
		150),
		e &&
		function () {
			var b = "backgroundAttachment";
			v.css(b) !== "fixed" && a(q.body).css(b) !== "fixed" && v.css({
				zoom: 1,
				backgroundImage: "url(about:blank)",
				backgroundAttachment: "fixed"
			})
		} (),
		x.setting.extendDrag &&
		function (a) {
			var b = q.createElement("div"),
			c = b.style,
			d = e ? "absolute": "fixed";
			b.id = "ldg_dragmask",
			c.cssText = "display:none;position:" + d + ";left:0;top:0;width:100%;height:100%;" + "cursor:move;filter:alpha(opacity=0);opacity:0;background:#FFF;pointer-events:none;",
			q.body.appendChild(b),
			a._start = a.start,
			a._end = a.end,
			a.start = function () {
				var b = x.focus,
				e = b.DOM.main[0],
				f = b.iframe;
				a._start.apply(this, arguments),
				c.display = "block",
				c.zIndex = x.setting.zIndex + 3,
				d === "absolute" && (c.width = "100%", c.height = u.height() + "px", c.left = t.scrollLeft() + "px", c.top = t.scrollTop() + "px"),
				f && e.offsetWidth * e.offsetHeight > 307200 && (e.style.visibility = "hidden")
			},
			a.end = function () {
				var b = x.focus;
				a._end.apply(this, arguments),
				c.display = "none",
				b && (b.DOM.main[0].style.visibility = "visible")
			}
		} (x.dragEvent)
	});
	var y, z = "setCapture" in s,
	A = "onlosecapture" in s;
	x.dragEvent = {
		onstart: f,
		start: function (a) {
			var b = x.dragEvent;
			return t.bind("mousemove", b.move).bind("mouseup", b.end),
			b._sClientX = a.clientX,
			b._sClientY = a.clientY,
			b.onstart(a.clientX, a.clientY),
			!1
		},
		onmove: f,
		move: function (a) {
			var b = x.dragEvent;
			return b.onmove(a.clientX - b._sClientX, a.clientY - b._sClientY),
			!1
		},
		onend: f,
		end: function (a) {
			var b = x.dragEvent;
			return t.unbind("mousemove", b.move).unbind("mouseup", b.end),
			b.onend(a.clientX, a.clientY),
			!1
		}
	},
	y = function (b) {
		var c, d, f, g, h, i, j = x.focus,
		k = j.config,
		l = j.DOM,
		m = l.wrap[0],
		n = l.title,
		o = l.main[0],
		p = x.dragEvent,
		s = "getSelection" in r ?
		function () {
			r.getSelection().removeAllRanges()
		}: function () {
			try {
				q.selection.empty()
			} catch(a) {}
		};
		p.onstart = function (a, b) {
			i ? (d = o.offsetWidth, f = o.offsetHeight) : (g = m.offsetLeft, h = m.offsetTop),
			t.bind("dblclick", p.end),
			!e && A ? n.bind("losecapture", p.end) : u.bind("blur", p.end),
			z && n[0].setCapture(),
			l.border.addClass("ui_state_drag"),
			j.focus()
		},
		p.onmove = function (b, e) {
			if (i) {
				var l = m.style,
				n = o.style,
				p = b + d,
				q = e + f;
				l.width = "auto",
				k.width = n.width = Math.max(0, p) + "px",
				l.width = m.offsetWidth + "px",
				k.height = n.height = Math.max(0, q) + "px",
				j._ie6SelectFix(),
				j._load && a(j._load).css({
					width: n.width,
					height: n.height
				})
			} else {
				var n = m.style,
				r = b + g,
				t = e + h;
				k.left = Math.max(c.minX, Math.min(c.maxX, r)),
				k.top = Math.max(c.minY, Math.min(c.maxY, t)),
				n.left = k.left + "px",
				n.top = k.top + "px"
			}
			s()
		},
		p.onend = function (a, b) {
			t.unbind("dblclick", p.end),
			!e && A ? n.unbind("losecapture", p.end) : u.unbind("blur", p.end),
			z && n[0].releaseCapture(),
			e && j._autoPositionType(),
			l.border.removeClass("ui_state_drag")
		},
		i = b.target === l.rb[0] ? !0 : !1,
		c = function () {
			var a = m.style.position === "fixed",
			b = m.offsetWidth,
			c = n[0].offsetHeight || 20,
			d = u.width(),
			e = u.height(),
			f = a ? 0 : t.scrollLeft(),
			g = a ? 0 : t.scrollTop();
			return maxX = d - b + f,
			maxY = e - c + g,
			{
				minX: f,
				minY: g,
				maxX: maxX,
				maxY: maxY
			}
		} (),
		p.start(b)
	},
	x.templates = '<table class="ui_border"><tbody><tr><td class="ui_lt"></td><td class="ui_t"></td><td class="ui_rt"></td></tr><tr><td class="ui_l"></td><td class="ui_c"><div class="ui_inner"><table class="ui_dialog"><tbody><tr><td colspan="2"><div class="ui_title_bar"><div class="ui_title" unselectable="on"></div><div class="ui_title_buttons"><a class="ui_min" href="javascript:void(0);" title="\u6700\u5c0f\u5316"><b class="ui_min_b"></b></a><a class="ui_max" href="javascript:void(0);" title="\u6700\u5927\u5316"><b class="ui_max_b"></b></a><a class="ui_res" href="javascript:void(0);" title="\u8fd8\u539f"><b class="ui_res_b"></b><b class="ui_res_t"></b></a><a class="ui_close" href="javascript:void(0);" title="\u5173\u95ed(esc\u952e)">\u00d7</a></div></div></td></tr><tr><td class="ui_icon"><img src="" class="ui_icon_bg"/></td><td class="ui_main"><div class="ui_content"></div></td></tr><tr><td colspan="2"><div class="ui_buttons"></div></td></tr></tbody></table></div></td><td class="ui_r"></td></tr><tr><td class="ui_lb"></td><td class="ui_b"></td><td class="ui_rb"></td></tr></tbody></table>',
	x.setting = {
		content: '<div class="ui_loading"><span>loading...</span></div>',
		title: "\u89c6\u7a97 ",
		button: null,
		ok: null,
		cancel: null,
		init: null,
		close: null,
		okVal: "\u786e\u5b9a",
		cancelVal: "\u53d6\u6d88",
		skin: "",
		esc: !0,
		show: !0,
		width: "auto",
		height: "auto",
		icon: null,
		path: n,
		lock: !1,
		parent: null,
		background: "#DCE2F1",
		opacity: .6,
		padding: "10px",
		fixed: !1,
		left: "50%",
		top: "38.2%",
		max: !0,
		min: !0,
		zIndex: 1976,
		resize: !0,
		drag: !0,
		cache: !0,
		extendDrag: !1
	},
	b.lhgdialog = a.dialog = x
})(this.jQuery || this.lhgcore, this),
function (a, b, c) {
	var d = function () {
		return b.setting.zIndex
	};
	b.alert = function (a, c, e) {
		return b({
			title: "\u8b66\u544a",
			id: "Alert",
			zIndex: d(),
			icon: "alert.gif",
			fixed: !0,
			lock: !0,
			content: a,
			ok: !0,
			resize: !1,
			close: c,
			parent: e || null
		})
	},
	b.confirm = function (a, c, e, f) {
		return b({
			title: "\u786e\u8ba4",
			id: "confirm.gif",
			zIndex: d(),
			icon: "confirm.gif",
			fixed: !0,
			lock: !0,
			content: a,
			resize: !1,
			parent: f || null,
			ok: function (a) {
				return c.call(this, a)
			},
			cancel: function (a) {
				return e && e.call(this, a)
			}
		})
	},
	b.prompt = function (a, c, e, f) {
		e = e || "";
		var g;
		return b({
			title: "\u63d0\u95ee",
			id: "Prompt",
			zIndex: d(),
			icon: "prompt.gif",
			fixed: !0,
			lock: !0,
			parent: f || null,
			content: ['<div style="margin-bottom:5px;font-size:12px">', a, "</div>", "<div>", '<input value="', e, '" style="width:18em;padding:6px 4px" />', "</div>"].join(""),
			init: function () {
				g = this.DOM.content[0].getElementsByTagName("input")[0],
				g.select(),
				g.focus()
			},
			ok: function (a) {
				return c && c.call(this, g.value, a)
			},
			cancel: !0
		})
	},
	b.tips = function (a, c, e, f) {
		var g = e ?
		function () {
			this.DOM.icon_bg[0].src = this.config.path + "skins/icons/" + e,
			this.DOM.icon[0].style.display = "",
			f && (this.config.close = f)
		}: function () {
			this.DOM.icon[0].style.display = "none"
		};
		return b({
			id: "Tips",
			zIndex: d(),
			title: !1,
			cancel: !1,
			fixed: !0,
			lock: !1,
			resize: !1,
			close: f
		}).content(a).time(c || 1.5, g)
	}
} (this.jQuery || this.lhgcore, this.lhgdialog)