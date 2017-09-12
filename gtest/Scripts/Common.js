$(function () {
    $(".pages a").attr("disabled", "");
    $(":text").attr("autocomplete", "off");
});

var Base = {};

Base.addCreate = function (args) {
    var modeID = document.getElementById(args.id);
    if (modeID != null)
        modeID.parentNode.removeChild(modeID);
    var create = document.createElement(args.mode);
    create.id = args.id;
    create.className = args.className || "";
    document.body.appendChild(create);
    return create;
};

Base.simulationRadio = function (args) {
    $("." + args.obj.className).attr("src", args.imgKey);
    args.obj.src = args.imgVal;
};

Base.patrn = {
    Number: /^[0-9]+$/,
    Decimal: /^[0-9]+(\.[0-9]+)?$/,
    DateTime: /^(\d{1,2})(-|\/)(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/,
    DateTimes: /^(\d{4})(-|\/)(\d{1,2})(-|\/)(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/
};

Base.isFloat = function (sInt) {
    var s = sInt.toString();
    if (s.indexOf(".") > 0) {
        var a = s.split(".")[1];
        return parseFloat(s).toFixed(a.length <= 2 ? a.length : 3);
    }
    return sInt;
};
Base.ForDight = function (Dight, How) {
    Dight = Math.round(Dight * Math.pow(10, How)) / Math.pow(10, How);
    return Dight;
}
Base.back = function (url) {
    location.href = url;
};

Base.ajax = function (args, callBack) {
    var url = "/Xml/HandlerDate.ashx";
    $.get(url, {
        id: args.id,
        lockid: args.lockid || null,
        hid: args.hid || null,
        userName: args.userName || null,
        ratingId: args.ratingId || null,
        t: +new Date()
    }, function (data) {
        callBack(data);
    }, args.type);
};

Base.settime = function (time) {
    var MinutesRound = Math.floor(time / 60);
    //var SecondsRound = Math.round(time - (60 * MinutesRound));
    var SecondsRound = Math.floor(time - (60 * MinutesRound));
    var Minutes = MinutesRound.toString().length <= 1 ? "0" + MinutesRound : MinutesRound;
    var Seconds = SecondsRound.toString().length <= 1 ? "0" + SecondsRound : SecondsRound;
    var strtime = Minutes + ":" + Seconds;
    return strtime;
}

Base.encodeRebate = function (value) {
    switch (value) {
        case "水全退到底": return 0;
		case "賺取3": return 3;
		case "賺取2.5": return 2.5;
        case "賺取2.0": return 2.0;
		case "賺取1.9": return 1.9;
		case "賺取1.8": return 1.8;
        case "賺取1.7": return 1.7;
		case "賺取1.6": return 1.6;
        case "賺取1.5": return 1.5;
		case "賺取1.4": return 1.4;
        case "賺取1.3": return 1.3;
		case "賺取1.2": return 1.2;
		case "賺取1.1": return 1.1;
        case "賺取1.0": return 1.0;
        case "賺取0.9": return 0.9;
		case "賺取0.8": return 0.8;
        case "賺取0.7": return 0.7;
		case "賺取0.6": return 0.6;
        case "賺取0.5": return 0.5;
        case "賺取0.4": return 0.4;		
        case "賺取0.3": return 0.3;
        case "賺取0.2": return 0.2;		
        case "賺取0.1": return 0.1;
        case "賺取所有退水": return 100;
    }
}