function refreshVerify() {
    $("#CheckCode").attr("src", "/user/createvalidatecode?r=" + Math.random());
    //src = "/user/createvalidatecode?r=" + Math.random();
}


/*用户相关操作Js库*/
var user = {
    //网站地址
    siteurl: "",
    //CMS地址
    cmsurl: "",
    //RES资源站点地址
    resurl: "",
    //用户属性、信息
    info: {
        isVip: false,
        vipLevel: "0",
        vipNext: { 0: 500, 1: 500, 2: 1000, 3: 2000, 4: 4000, 5: 8000, 6: 12000, 7: 16000, 8: 20000, 9: 20000, max: 20000 },
        accountNext: [0, 25, 55, 75, 99],
        isAuthentication: false,
        growthl: 0,
        accountl: 0,
        //现金金额=充值+奖金+佣金+名家
        balance: 0,
        //红包金额
        rbbalance: 0,
        isAlipay: false,
        isGoldAlipay: false,
        displayName: "",
        userId: "",
        isNeedBetPwd: false,
        isQQ: false,
        Figureurl: "",
        unReadMail: 0,
        doudou: 0,
        MaxLevelName: "",
        reset: function () {
            this.isVip = false;
            this.vipLevel = "0";
            this.balance = 0;
            this.rbbalance = 0;
            this.isAlipay = false;
            this.isGoldAlipay = false;
            this.displayName = "";
            this.userId = "";
            this.isNeedBetPwd = false;
            this.isQQ = false;
            this.Figureurl = "";
            this.unReadMail = 0;
        }
    },
    //登录回调函数
    LoginCallBack: function () {
    },
    //刷新用户信息
    refresh: function (callback) {
        $.post(user.siteurl + "/user/info",{'r':Math.random().toFixed(5)},function(data){
            if (data.IsSuccess) {
                user.info.isVip = data.isVip;
                user.info.vipLevel = data.vipLevel;
                user.info.isAuthentication = data.isAuthentication;
                user.info.growthl = data.growthl;
                user.info.accountl = data.accountl;
                user.info.balance = data.balance;
                user.info.isAlipay = data.isAlipay;
                user.info.isGoldAlipay = data.isGoldAlipay;
                user.info.displayName = data.displayName;
                user.info.userId = data.userId;
                user.info.isNeedBetPwd = data.isNeedBetPwd;
                user.info.rbbalance = data.rbbalance;
                user.info.isQQ = data.isQQ;
                user.info.Figureurl = data.Figureurl;
                user.info.unReadMail = data.unReadMail;
                user.info.MaxLevelName = data.MaxLevelName;
            } else {
                user.info.reset();
            }
            if (callback != null && typeof (callback) == "function") {
                callback();
            }
        });
        /*$.getJSON(user.siteurl + "/user/info?r=" + Math.random().toFixed(5), function (data) {
            if (data.IsSuccess) {
                user.info.isVip = data.isVip;
                user.info.vipLevel = data.vipLevel;
                user.info.isAuthentication = data.isAuthentication;
                user.info.growthl = data.growthl;
                user.info.accountl = data.accountl;
                user.info.balance = data.balance;
                user.info.isAlipay = data.isAlipay;
                user.info.isGoldAlipay = data.isGoldAlipay;
                user.info.displayName = data.displayName;
                user.info.userId = data.userId;
                user.info.isNeedBetPwd = data.isNeedBetPwd;
                user.info.rbbalance = data.rbbalance;
                user.info.isQQ = data.isQQ;
                user.info.Figureurl = data.Figureurl;
                user.info.unReadMail = data.unReadMail;
                user.info.MaxLevelName = data.MaxLevelName;
            } else {
                user.info.reset();
            }
            if (callback != null && typeof (callback) == "function") {
                callback();
            }

        });*/
    },
    //判断用户是否已登录
    isLogin: function (callback) {

        var url = user.siteurl + "/user/islogin";
        $.post(url,{'r':Math.random()},function(res){
            callback(res);
        });
        /*var url = user.siteurl + "/user/islogin?r=" + Math.random();
        $.get(url, function (res) {
            callback(res);
        });*/
    },
    //登录后如果刷新页面，则user.info里面的东西没有保存,所以重新请求一回
    reloadUser: function () {
        var url = user.siteurl + "/user/reloaduser" ;
        $.post(url,{'r':Math.random()},function(response){
            if (response.IsSuccess) {
                user.info.isVip = response.isVip;
                user.info.vipLevel = response.vipLevel;
                user.info.isAuthentication = response.isAuthentication;
                user.info.balance = response.balance;
                user.info.isAlipay = response.isAlipay;
                user.info.isGoldAlipay = response.isGoldAlipay;
                user.info.displayName = response.displayName;
                user.info.userId = response.userId;
                user.info.isNeedBetPwd = response.isNeedBetPwd;
                user.info.rbbalance = response.rbbalance;
                user.info.isQQ = response.isQQ;
                user.info.Figureurl = response.Figureurl;
                user.info.unReadMail = response.unReadMail;
                user.info.doudou = response.doudou;
                user.info.MaxLevelName = response.MaxLevelName
            }
        });
        /*var url = user.siteurl + "/user/reloaduser?r=" + Math.random();
        $.get(url, function (response) {
            if (response.IsSuccess) {
                user.info.isVip = response.isVip;
                user.info.vipLevel = response.vipLevel;
                user.info.isAuthentication = response.isAuthentication;
                user.info.balance = response.balance;
                user.info.isAlipay = response.isAlipay;
                user.info.isGoldAlipay = response.isGoldAlipay;
                user.info.displayName = response.displayName;
                user.info.userId = response.userId;
                user.info.isNeedBetPwd = response.isNeedBetPwd;
                user.info.rbbalance = response.rbbalance;
                user.info.isQQ = response.isQQ;
                user.info.Figureurl = response.Figureurl;
                user.info.unReadMail = response.unReadMail;
                user.info.doudou = response.doudou;
                user.info.MaxLevelName = response.MaxLevelName
            }
        });*/

    },
    //用户退出登录
    logOut: function () {
        $.post(user.siteurl + "/user/LogOutUser?r=" + Math.random(), function (result) {
            if (result.IsSuccess) {
                user.refresh();
                location.reload();
                //window.location.href = "/home/default";
            } else {
                Box.alert(result.Message);
            }
        });
    }
};
user.reloadUser();
$(function () {
    if ($.cookie("Login_userName")) {
        $('#username').val($.cookie("Login_userName"));
        $("#check_save_pwd").prop("checked", 1);
    }
    if ($.cookie("Login_passWord")) {
        $('#password').val($.cookie("Login_passWord"));
        $("#check_save_pwd").prop("checked", 1);
    }
    $(".payment").click(function () {
        if ($(this).hasClass("payment_disabled")) return Box.alert("暂不能注册");
        var geetest = $("#hidGeetest").val();
        var url = "/user/LoacalUserRegister";
        var userName = $("#iName").val();
        var pwd = $("#iCode").val();
        if (!userName) {
            return Box.alert("请输入用户名");
        }
        if (!pwd) {
            return Box.alert("请输入密码");
        }
        var data = { userName: userName, passWord: pwd };

        if (geetest == "Default") {
            var code = $("#verifycode").val();
            if (!code) {
                return Box.alert("请输入验证码");
            }
            data = { userName: userName, passWord: pwd, code: code };
            $.post(url, data, function (response) {
                if (response.IsSuccess) {
                    Box.tx("注册成功");
                    //                location.href = "register_succeed?userid=" + userName;
                    location.href = "/user/registervalidamobile?r=" + Math.random() + "&UserId=test";
                } else {
                    Box.alert(response.Message);
                    return "";
                }
            });
        }
        else {
            if (o) {
                o.refresh();
            }
            show(popEle);
        }
    });
    $('#loginBtn').bind('click', function () {
        if (o) {
            o.refresh();
        }
        show(popEle);
    });

    $('.reg').bind('click', function () {
        location.replace('/user/register');
    });
    //    var user_name = localStorage.getItem("username");
    //    !!user_name && $('#username').val(user_name);
    $('.pdLfrt09 .relative input').keyup(function () {
        if ($(this).val().length > 0) {
            $(this).parent().find('.error').show();
        } else {
            $(this).parent().find('.error').hide();
        }
    });
    $('.error').click(function () {
        $(this).parent().find('input').val('');
        $(this).hide();
    });
    var user = $("#user").val();
    if (user == "") {
        location.href = "/User/login";
    }
    $(".zhuceOpen2").bind("click",
	function () {
	    $(this).hide();
	    $(".zhuceOpen").show();
	    $("#iCode").attr("type", "text")
	});
    $(".zhuceOpen").bind("click",
        function () {
            $(this).hide();
            $(".zhuceOpen2").show();
            $("#iCode").attr("type", "password")
        });
});
/*注册密码框禁止输入汉字*/
function check(str) {
    var temp = ""
    for (var i = 0; i < str.length; i++)
        if (str.charCodeAt(i) > 0 && str.charCodeAt(i) < 255)
            temp += str.charAt(i)
    return temp
}

function div_close() {
    document.getElementById("L_display_div_01").style.display = "none";
    document.getElementById("L_display_div_02").style.display = "none";
    document.getElementById("register_div").style.display = "none";
    document.getElementById("Login_div").style.display = "block";
    document.getElementById("attestation_div").style.display = "none";
    document.getElementById("attestation_03_div").style.display = "none";
    document.getElementById("attestation_04_div").style.display = "none";
    document.getElementById("attestation_02_div").style.display = "none";
}
function close_() {
    document.getElementById("R_display_div_01").style.display = "none";
    document.getElementById("R_display_div_02").style.display = "none";
    document.getElementById("R_display_div_05").style.display = "block";
    document.getElementById("R_display_div_06").style.display = "block";
    document.getElementById("R_display_div_04_span_01").style.display = "block";
    document.getElementById("R_display_div_04_span_03").style.display = "none";
    document.getElementById("R_display_div_07").style.display = "none";
}
function show_(msg) {
    if (msg == "领取3元彩金") {
        var span_03 = document.getElementById("R_display_div_06").style.display;
        if (span_03 == "none") {
            document.getElementById("R_display_div_04_span_03").style.display = "block";
            document.getElementById("R_display_div_04_span_01").style.display = "none";
            document.getElementById("R_display_div_04_span_02").style.display = "none";
        }
        else {
            document.getElementById("R_display_div_04_span_01").style.display = "block";
            document.getElementById("R_display_div_04_span_02").style.display = "none";
            document.getElementById("R_display_div_04_span_03").style.display = "none";
        }
    }
    else {
        document.getElementById("R_display_div_04_span_02").style.display = "block";
        document.getElementById("R_display_div_04_span_01").style.display = "none";
    }
    document.getElementById("R_display_div_01").style.display = "block";
    document.getElementById("R_display_div_02").style.display = "block";
}
function span_show(id) {
    document.getElementById(id).style.display = "block";
}
function span_close(id) {
    document.getElementById(id).style.display = "none";
}

$(function () {
    $("#phone").bind("blur",
        function () {
            var phone = $("#phone").val();
            if (!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))) {
                $("#ph_span").removeClass("span_01_1");
                $("#ph_span").removeClass("span_01_3");
                $("#ph_span").addClass("span_01_2");
                return;
            }
            else {
                $("#ph_span").addClass("span_01_3");
                return;
            }
        })
    //验证手机
    $("#determine").bind("blur", function () {
        var phone = $("#phone").val();
        if (phone == "") {
            $("#ph_span").removeClass("span_01_1");
            $("#ph_span").removeClass("span_01_3");
            $("#ph_span").addClass("span_01_2");
            return;
        }
        var phone = $("#phone").val();
        if (!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))) {
            $("#ph_span").removeClass("span_01_1");
            $("#ph_span").removeClass("span_01_3");
            $("#ph_span").addClass("span_01_2");
            return;
        }
        else {
            $("#ph_span").addClass("span_01_3");
            return;
        }

    });
    $("#txt_realName").bind("blur",
        function () {
            var txt_realName = $("#txt_realName").val();
            if (txt_realName == null || txt_realName == "") {
                $("#xm_span").removeClass("span_01_1");
                $("#xm_span").removeClass("span_01_3");
                $("#xm_span").addClass("span_01_2");
                return;
            }
            else {
                $("#xm_span").addClass("span_01_3");
                return;
            }
        });

    $("#idCardNumber").bind("blur",
        function () {
            var idCardNumber = $("#idCardNumber").val();
            if (!(/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/.test(idCardNumber)) || idCardNumber == "" || idCardNumber == null) {
                $("#sf_span").removeClass("span_01_1");
                $("#sf_span").addClass("span_01_2");
                return;
            }
            else {
                $("#sf_span").addClass("span_01_3");
                return;
            }
        });
    var inter;
    var countdown = 60;
    function settime() {
        document.getElementById("determine").onclick = function () { };
        var again = document.getElementById("determine");
        if (countdown == 0) {
            again.innerHTML = "重新发送";
            $("#determine").css("background-color", "#F6851F");
            countdown = 60;

        } else {
            $("#determine").css("background-color", "#BFBFBF");
            again.innerHTML = "重新发送(" + countdown + ")";
            $("#Yzm").css("display", "block");
            countdown--;
            inter = setTimeout(function () {
                settime();
            }, 1000);
        }
    }
    $("#determine").bind("click",
        function () {
            var phone = $("#phone").val();
            if (countdown == 60) {
                $.post("/member/authmobile_request", { phone: phone }, function (data) {
                    if (data.IsSuccess) {
                        bool = false;
                        settime();
                    }
                    else {
                        Box.alert(data.Msg);
                        bool = false;
                    }
                });
            }
        })
    var type = "";
    $("#linqu").bind("click",
        function () {
            type = "领取";
        })
    $("#chongzhi").bind("click",
        function () {
            type = "充值";
        })
    $("#MS_linqu").bind("click",
        function () {
            type = "马上领取";
        })
    //提交验证码
    $("#submint").bind("click",
        function () {
            var phone = $("#phone").val();
            var IsAuthenticationMobile = $("#IsAuthenticationMobile").val();
            var IsAuthenticationRealName = $("#IsAuthenticationRealName").val();
            var yzm = $("#Yzm").val();
            var realName = $.trim($("#txt_realName").val());
            var id1 = $.trim($("#idCardNumber").val());
            var reg = /^[\u4e00-\u9fa5·]+$/i;
            if (IsAuthenticationMobile != "True" && IsAuthenticationRealName != "True") {
                if (realName == "" || realName == null) {
                    $("#xm_span").removeClass("span_01_1");
                    $("#xm_span").addClass("span_01_2");
                    return false;
                }
                if (id1 == "" || id1 == null) {
                    $("#sf_span").removeClass("span_01_1" || !(/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/.test(idCardNumber)));
                    $("#sf_span").addClass("span_01_2");
                    return false;
                }
                if (phone == "" || phone == null || !(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))) {
                    $("#ph_span").removeClass("span_01_1");
                    $("#ph_span").addClass("span_01_2");
                    return false;
                }
                if (yzm == null || yzm == "") {
                    Box.alert("请输入验证码");
                    return false;
                }
                $.post("/member/authmobile_submit", { yzm: yzm }, function (data) {
                    if (data.IsSuccess) {
                        $.post("/member/authrealname_register", { txt_realName: realName, idCardNumber: id1 }, function (data) {
                            if (data.IsSuccess) {
                                if (type == "领取") {
                                    document.getElementById("R_display_div_05").style.display = "none";
                                    document.getElementById("R_display_div_06").style.display = "none";
                                    document.getElementById("R_display_div_04_span_01").style.display = "none";
                                    document.getElementById("R_display_div_04_span_03").style.display = "block";
                                    document.getElementById("R_display_div_07").style.display = "block";
                                }
                                else if (type == "充值") {
                                    location.href = "../member/recharge";
                                }
                                else {
                                    document.getElementById("attestation_02_div").style.display = "none";
                                    document.getElementById("attestation_03_div").style.display = "block";
                                }
                            }
                            else {
                                Box.alert(data.Msg);
                            }
                        });

                    } else {
                        Box.alert(data.Msg);
                        return;
                    }
                });
            }
            else if (IsAuthenticationMobile == "True" && IsAuthenticationRealName != "True") {
                if (realName == "" || realName == null) {
                    $("#xm_span").removeClass("span_01_1");
                    $("#xm_span").addClass("span_01_2");
                    return false;
                }
                if (id1 == "" || id1 == null) {
                    $("#sf_span").removeClass("span_01_1" || !(/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/.test(idCardNumber)));
                    $("#sf_span").addClass("span_01_2");
                    return false;
                }
                $.post("/member/authrealname_register", { txt_realName: realName, idCardNumber: id1 }, function (data) {
                    if (data.IsSuccess) {
                        if (type == "领取") {
                            document.getElementById("R_display_div_05").style.display = "none";
                            document.getElementById("R_display_div_06").style.display = "none";
                            document.getElementById("R_display_div_04_span_01").style.display = "none";
                            document.getElementById("R_display_div_04_span_03").style.display = "block";
                            document.getElementById("R_display_div_07").style.display = "block";
                        }
                        else if (type == "充值") {
                            location.href = "../member/recharge";
                        }
                        else {
                            document.getElementById("attestation_02_div").style.display = "none";
                            document.getElementById("attestation_03_div").style.display = "block";
                        }
                    }
                    else {
                        Box.alert(data.Msg);
                        //return;
                    }
                });
            }
            else if (IsAuthenticationMobile != "True" && IsAuthenticationRealName == "True") {
                if (phone == "" || phone == null || !(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))) {
                    $("#ph_span").removeClass("span_01_1");
                    $("#ph_span").addClass("span_01_2");
                    return false;
                }
                if (yzm == null || yzm == "") {
                    Box.alert("请输入验证码");
                    return false;
                }
                $.post("/member/authmobile_submit", { yzm: yzm }, function (data) {
                    if (data.IsSuccess) {
                        if (type == "领取") {
                            document.getElementById("R_display_div_05").style.display = "none";
                            document.getElementById("R_display_div_06").style.display = "none";
                            document.getElementById("R_display_div_04_span_01").style.display = "none";
                            document.getElementById("R_display_div_04_span_03").style.display = "block";
                            document.getElementById("R_display_div_07").style.display = "block";
                        }
                        else if (type == "充值") {
                            location.href = "../member/recharge";
                        }
                        else {
                            document.getElementById("attestation_02_div").style.display = "none";
                            document.getElementById("attestation_03_div").style.display = "block";
                        }

                    } else {
                        Box.alert(data.Msg);
                        return;
                    }
                });
            }
            else {
                if (type == "领取") {
                    document.getElementById("R_display_div_05").style.display = "none";
                    document.getElementById("R_display_div_06").style.display = "none";
                    document.getElementById("R_display_div_04_span_01").style.display = "none";
                    document.getElementById("R_display_div_04_span_03").style.display = "block";
                    document.getElementById("R_display_div_07").style.display = "block";
                }
                else if (type == "马上领取") {
                    document.getElementById("attestation_02_div").style.display = "none";
                    document.getElementById("attestation_03_div").style.display = "block";
                }
                else {
                    location.href = "../member/recharge";
                }
            }
        });
})

function refreshVerify() {
    document.getElementById("CheckCode").src = "/user/createvalidatecode?r=" + Math.random();
}


var initGeetest = (function (window, document) {
    var random = function () {
        return parseInt(Math.random() * 10000) + (new Date()).valueOf();
    };
    var callbacks = [];
    var status = "loading";
    // 加载Geetest库
    var cb = "geetest_" + random();
    window[cb] = function () {
        status = "loaded";
        window[cb] = undefined;
        try {
            delete window[cb];
        } catch (e) {
        }
        for (var i = 0, len = callbacks.length; i < len; i = i + 1) {
            callbacks[i]();
        }
    };
    var s = document.createElement("script");
    s.onerror = function () {
        status = "fail";
        for (var i = 0, len = callbacks.length; i < len; i = i + 1) {
            callbacks[i]();
        }
    };
    s.src = (location.protocol === "https:" ? "https:" : "http:") + "//api.geetest.com/get.php?callback=" + cb;
    document.getElementsByTagName("head")[0].appendChild(s);
    return function (config, callback) {
        var protocol = config.https ? "https://" : "http://";
        var initGeetest = function () {
            callback(new window.Geetest(config));
        };
        var backendDown = function () {
            var s = document.createElement("script");
            s.id = "gt_lib";
            s.src = protocol + "static.geetest.com/js/geetest.0.0.0.js";
            s.charset = "UTF-8";
            s.type = "text/javascript";
            head.appendChild(s);
            s.onload = s.onreadystatechange = function () {
                if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
                    initGeetest();
                    s.onload = s.onreadystatechange = null;
                }
            };
        };
        if (status === "loaded") {
            // Geetest对象已经存在，则直接初始化
            initGeetest();
        } else if (status === "fail") {
            // 无法动态获取Geetest库，则去获取geetest.0.0.0.js
            backendDown();
        } else if (status === "loading") {
            // 之前已经去加载Geetest库了，将回调加入callbacks，等Geetest库好后去回调
            callbacks.push(function () {
                if (status === "fail") {
                    backendDown();
                } else {
                    initGeetest();
                }
            });
        } else {
        }
    };
} (window, document));
var popEle = document.getElementById("pop");

var show = function (ele) {
    ele.className = ele.className.replace("hide", "show");
};
var hide = function (ele) {
    ele.className = ele.className.replace("show", "hide");
};

window.init = function (config) {
    initGeetest({
        gt: config.gt,
        challenge: config.challenge,
        product: "embed",
        width: "301px",
        offline: !config.success
    }, function (obj) {
        window.o = obj;
        o.appendTo("#pop");
        o.onReady(function () {
            popEle.firstChild.addEventListener("click", function (e) {
                e.stopPropagation();
            });
        });
        o.onSuccess(function () {
            validate(o, function (result) {
                if (result === "success") {
                    hide(popEle);
                    var type = $("#hidType").val();
                    if (type == "login") {
                        var username = $('#username').val();
                        var password = $('#password').val();
                        var url = "/user/loginuser";
                        var data = { userName: username, passWord: password };
                        $.post(url, data, function (result) {
                            if (result.IsSuccess) {
                                if ($("#check_save_pwd").is(":checked")) {
                                    $.cookie("Login_userName", username, { expires: 7 });
                                    $.cookie("Login_passWord", password, { expires: 7 });
                                } else {
                                    $.cookie("Login_userName", null);
                                    $.cookie("Login_passWord", null);
                                }
                                var bk = document.getElementById("backurl").value;
                                if (bk) {
                                    window.location.href = bk;
                                } else {
                                    window.location.href = "../";
                                }
                            }
                            else {
                                Box.alert(result.Message);
                            }
                        });
                    }
                    else {
                        var url = "/user/LoacalUserRegister";
                        var userName = $("#iName").val();
                        var pwd = $("#iCode").val();
                        data = { userName: userName, passWord: pwd };
                        $.post(url, data, function (response) {
                            if (response.IsSuccess) {
                                Box.tx("注册成功");
                                //                location.href = "register_succeed?userid=" + userName;
                                location.href = "/user/registervalidamobile?r=" + Math.random() + "&UserId=test";
                            } else {
                                Box.alert(response.Message);
                                return "";
                            }
                        });
                    }
                } else {
                    o.refresh();
                }
            });
        });
    });
};

var validate = function (captcha, cb) {
    var values = captcha.getValidate();
    var query = "geetest_challenge=" + values.geetest_challenge + "&geetest_validate=" + values.geetest_validate + "&geetest_seccode=" + values.geetest_seccode + "&callback=handlerResult";
    var script = document.createElement("script");
    script.src = "/user/Checkcaptcha?" + query;
    script.charset = "utf-8";
    document.body.appendChild(script);
    window.handlerResult = cb;
};
var script = document.createElement("script");
script.src = "/user/Getcaptcha?callback=init";
script.charset = "utf-8";
document.body.appendChild(script);