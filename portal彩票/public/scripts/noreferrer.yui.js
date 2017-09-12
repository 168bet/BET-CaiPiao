/**
 * @file
 * @author Zhouhua( zhouhua@baidu.com )
 */

(function ($) {
    $.browser = {};
    $.browser.mozilla = false;
    $.browser.webkit = false;
    $.browser.opera = false;
    $.browser.msie = false;

    var nAgt = navigator.userAgent;
    $.browser.name = navigator.appName;
    $.browser.fullVersion = '' + parseFloat(navigator.appVersion);
    $.browser.majorVersion = parseInt(navigator.appVersion, 10);
    var nameOffset;
    var verOffset;
    var ix;

    // In Opera, the true version is after 'Opera' or after 'Version'
    if ((verOffset = nAgt.indexOf('Opera')) !== -1) {
        $.browser.opera = true;
        $.browser.name = 'Opera';
        $.browser.fullVersion = nAgt.substring(verOffset + 6);
        if ((verOffset = nAgt.indexOf('Version')) !== -1) {
            $.browser.fullVersion = nAgt.substring(verOffset + 8);
        }
    }
    // In MSIE, the true version is after 'MSIE' in userAgent
    else if ((verOffset = nAgt.indexOf('MSIE')) !== -1) {
        $.browser.msie = true;
        $.browser.name = 'Microsoft Internet Explorer';
        $.browser.fullVersion = nAgt.substring(verOffset + 5);
    }
    else if ((verOffset = nAgt.indexOf('Trident')) !== -1) {
        $.browser.msie = true;
        $.browser.name = 'Microsoft Internet Explorer';
        $.browser.fullVersion = nAgt.substring(verOffset + 8);
    }
    // In Chrome, the true version is after 'Chrome'
    else if ((verOffset = nAgt.indexOf('Chrome')) !== -1) {
        $.browser.webkit = true;
        $.browser.name = 'Chrome';
        $.browser.fullVersion = nAgt.substring(verOffset + 7);
    }
    // In Safari, the true version is after 'Safari' or after 'Version'
    else if ((verOffset = nAgt.indexOf('Safari')) !== -1) {
        $.browser.webkit = true;
        $.browser.name = 'Safari';
        $.browser.fullVersion = nAgt.substring(verOffset + 7);
        if ((verOffset = nAgt.indexOf('Version')) !== -1) {
            $.browser.fullVersion = nAgt.substring(verOffset + 8);
        }
    }
    // In Firefox, the true version is after 'Firefox'
    else if ((verOffset = nAgt.indexOf('Firefox')) !== -1) {
        $.browser.mozilla = true;
        $.browser.name = 'Firefox';
        $.browser.fullVersion = nAgt.substring(verOffset + 8);
    }
    // In most other browsers, 'name/version' is at the end of userAgent
    else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) <
        (verOffset = nAgt.lastIndexOf('/'))) {
        $.browser.name = nAgt.substring(nameOffset, verOffset);
        $.browser.fullVersion = nAgt.substring(verOffset + 1);
        if ($.browser.name.toLowerCase() === $.browser.name.toUpperCase()) {
            $.browser.name = navigator.appName;
        }
    }
    // trim the fullVersion string at semicolon/space if present
    if ((ix = $.browser.fullVersion.indexOf(';')) !== -1) {
        $.browser.fullVersion = $.browser.fullVersion.substring(0, ix);
    }
    if ((ix = $.browser.fullVersion.indexOf(' ')) !== -1) {
        $.browser.fullVersion = $.browser.fullVersion.substring(0, ix);
    }

    $.browser.majorVersion = parseInt('' + $.browser.fullVersion, 10);
    if (isNaN($.browser.majorVersion)) {
        $.browser.fullVersion = '' + parseFloat(navigator.appVersion);
        $.browser.majorVersion = parseInt(navigator.appVersion, 10);
    }
    $.browser.version = $.browser.majorVersion;

    $.noreferrerReg = function () {
       // debugger;
        //        if ($.browser.webkit) {
        //            return;
        //        }
        $('a[href][rel~=noreferrer], area[href][rel~=noreferrer]').each(function () {
            var e;
            var g;
            var d;
            var f;
            var h;
            var b = this;
            var c = b.href;
            //alert(c);
            //  if ($(b).attr('data-setNoreferrer') == c) {
            //                return;
            //            }
            $(b).attr('data-setNoreferrer', c);
            $.browser.opera ?
            (b.href = 'http://www.no-referer.de/' + c, b.title || (b.title = 'Go to ' + c)) :
            (d = !1, g = function () {
                b.href = 'javascript:void(0)';
            }, f = function () {
                b.href = c;
            }, $(b).bind('mouseout mouseover focus blur', f).mousedown(function (a) {
                a.which === 2 && (d = !0);
            }).blur(function () {
                d = !1;
            }).mouseup(function (a) {
                if (!(a.which ===
                    2 && d)) {
                    return !0;
                }
                g();
                d = !1;
                setTimeout(function () {
                    alert('Middle clicking on this link is disabled to keep the browser from sending a referrer.');
                    f();
                }, 500);
                return !1;
            }), e = '<html><head><meta http-equiv="Refresh" content="0; URL=' + $('<p/>').text(c).html() +
            '" /></head><body></body></html>', $.browser.msie ? $(b).click(function () {
                var a;
                switch (a = this.target || '_self') {
                    case '_self':
                    case window.name:
                        a = window;
                        break;
                    default:
                        a = window.open(null, a);
                }
                a = a.document;
                a.clear();
                a.write(e);
                a.close();
                return !1;
            }) : (h = 'data:text/html;charset=utf-8,' +
            encodeURIComponent(e), $(b).click(function () {
                this.href = h;
                return !0;
            })));
        });
    };
    $.event.add(window, 'load', $.noreferrerReg);
})(jQuery);
