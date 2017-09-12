if (navigator.userAgent.toLowerCase().indexOf("android") != -1 ||
    navigator.userAgent.toLowerCase().indexOf("iphone") != -1 ||
    navigator.userAgent.toLowerCase().indexOf("mobile") != -1) {

    if ((navigator.userAgent.indexOf("Gecko") != -1 ||
        navigator.userAgent.indexOf("MQQBrowser") != -1) &&
        navigator.userAgent.toLowerCase().indexOf("pad") == -1) {

        window.location.href = document.URL.replace('http://www', 'http://m');
    }
}

//解析URL
function parseURL(url) {
    var a = document.createElement('a');
    a.href = url;
    return {
        source: url,
        protocol: a.protocol.replace(':', ''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function ()
        {
            var ret = {},
                seg = a.search.replace(/^\?/, '').split('&'),
                len = seg.length, i = 0, s;
            for (; i < len; i++) {
                if (!seg[i]) {
                    continue;
                }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [, ''])[1],
        hash: a.hash.replace('#', ''),
        path: a.pathname.replace(/^([^\/])/, '/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [, ''])[1],
        segments: a.pathname.replace(/^\//, '').split('/')
    };
}

