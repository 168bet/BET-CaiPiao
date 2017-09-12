function onmouseovers(obj) {
    $(obj).children("td").toggleClass("backgroundColor");
}
function onmouseouts(obj) {
    $(obj).children("td").removeClass("backgroundColor");
}
function clicks(obj) {
    $(obj).children("td").toggleClass("backgroundColord");
}
function digitOnly(evt, s) {
    if (evt.keyCode == 13) {
        evt.returnValue = s || false;
        return false;
    }
    if (!(evt.keyCode >= 48 && evt.keyCode <= 57)) {
        evt.returnValue = false;
        return false;
    }
    return true;
}
function Alternately(s) {
    var parent = window.parent[0].document;
    $(".alte", parent).removeClass("red");
    $(".s" + s, parent).addClass("red");

}
function GoBack(url) {
    var parent = window.parent.mainFrame.document;
    $(".ins", parent).val("");
    $("#stp", parent).show();
    $("#noStp", parent).hide();
    location.href = url;
}
function HtmlFormat(strData, cacheData) {
    var str = "", a = new Array(), o = [], stratTd = ',<td>', topTd = '</td>,<td>';

    if (strData != undefined && strData != "") {
        for (var i = 0; i < strData.length; i++) {
            if (strData[i] == str) {
                a.push("<br />" + strData[i]);
            } else {
                a.push(i == 0 ? stratTd + strData[i] : topTd + strData[i]);
            }
            str = strData[i];
        }
        a.push("</td>");

        var c = (cacheData += a.join('')).split(',');

        for (var i = c.length - 25; i < c.length; i++) {
            o.push(c[i]);
        }
    } else {

        o = cacheData.split(',');
    }
    return o.join('');
}

function RadioClick() {
    var obj = $(":checkbox").css("display", "").attr("checked", "");
    obj.parent().removeClass("bgc");
    $("#clo").attr("disabled", "");
}
function BoxClick(obj) {
    var inputs = document.getElementsByTagName("input"), radValue, count = 0;
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == "radio" && inputs[i].checked) {
            radValue = inputs[i].value.split(",")[1];
        }
        if (inputs[i].type == "checkbox" && inputs[i].checked) {
            count++;
        }
    }
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox") {
            if (count == parseInt(radValue) && !inputs[i].checked) {
                inputs[i].disabled = "disabled";
            } else {
                inputs[i].disabled = "";
                if (obj.checked == true) {
                    $(obj).parent().addClass("bgc");
                } else {
                    $(obj).parent().removeClass("bgc");
                }
            }
        }
    }
}

function DisplayAcc(obj) {
    $("#htmlcl td").removeClass("start_a");
    $(obj).parent().addClass("start_a");
    var showAcc = $("#showAcc");
    var index = obj.id.replace("dc", "");
    showAcc.html(HtmlFormat(ro[index], _data[1]));
}
function GoSelect(obj) {
    var url = location.href, s = [];
    if (url.indexOf("name") > -1 && url.indexOf("tid") == -1) {
        s = url.split("?");
        url = s[0] + "?" + s[1] + "&tid=" + obj.value;
    } else if (url.indexOf("name") > -1 && url.indexOf("tid") > -1) {
        s = url.split("tid=");
        url = s[0] + "tid=" + obj.value;
    } else {
        s = url.split("aspx");
        url = s[0] + "aspx?tid=" + obj.value;
    }
    location.href = url;
}
function delUser(url) {
    if (confirm("注意！刪除操作請謹慎！！！\n確定刪除號嗎？")) {
        location.href = url;
    }
}
function back(obj, a) {
    var result = document.getElementById("result");
    if (obj.value.length < a) {
        result.innerHTML = "帳號最小長度必須 " + a + "位 或以上！";
        $("#submit").attr("disabled", "disabled");
        obj.focus();
        return;
    } else {
        $("#submit").attr("disabled", "");
        Base.ajax({ id: 3, userName: obj.value }, function (data) {
            if (data != "") {
                result.className = "red";
                result.innerHTML = data;
                $("#submit").attr("disabled", "disabled");
                obj.focus();
            } else {
                result.innerHTML = "選擇帳號可用！！！";
                result.className = "";
                $("#submit").attr("disabled", "");
            }
        });
    }
}
function GONT(obj) {
    var url = location.href.split("?")[0];
    location.href = url + "?name=" + obj.value;
}
function GoChange(obj) {
    Base.ajax({ id: 5, userName: obj.value }, function (data) {
        if (data != "") {
            var a = data.split(',');
            document.getElementById("MaxSuperiorOccupy").value = a[0];
            document.getElementById("DisplaySuperiorOccupy").innerHTML = "最高可設占成 " + a[0] + "%";
            if (document.getElementById("Available") != null) {
                document.getElementById("Available").innerHTML = "上級餘額 " + a[1];
            }
            if (a[2] == "0") {
                $("input[name='AutoShipments']").attr("disabled", "disabled");
                $("#as0").attr("checked", "checked");
            } else {
                $("input[name='AutoShipments']").attr("disabled", "");
                $("#as1").attr("checked", "checked");
            }
            if (a[3] == "0") {
                $("input[name='ManualShipments']").attr("disabled", "disabled");
                $("#ms0").attr("checked", "checked");
            } else {
                $("input[name='ManualShipments']").attr("disabled", "");
                $("#ms1").attr("checked", "checked");
            }
        }
    });
}

function isMethod(obj) {
    var StintName = document.getElementById("StintName").value;
    var MaxSuperiorOccupy = document.getElementById("MaxSuperiorOccupy").value;
    if (StintName == "") {
        alert("請選擇上級帳號!!!");
        return false;
    }
    if (obj.userName.value == "") {
        alert("請輸入帳號!!!");
        obj.userName.focus();
        return false;
    }
    if (obj.password.value == "") {
        alert("請輸入密碼!!!");
        obj.password.focus();
        return false;
    }
    if (obj.password.value.length < 8 || obj.password.value.length > 20) {
        alert("登錄密碼 請填寫 8 位或以上（最長20位）！");
        obj.password.focus();
        return false;
    }
    if (passowrdSafety(obj.password.value) != true) {
        obj.password.focus();
        return false;
    }
    if (obj.fatherName.value == "") {
        alert("請輸入名稱!!!");
        obj.fatherName.focus();
        return false;
    }
    if (obj.credits.value == "" || obj.credits.value == "0") {
        alert("‘信用額度’請務必輸入!!!");
        obj.credits.focus();
        return false;
    }
    if (document.getElementById("Available") != null) {
        var s = document.getElementById("Available").innerHTML.split(' ')[1];
        if (parseInt(obj.credits.value) > parseInt(s)) {
            alert("上級可用餘額：" + s);
            obj.credits.focus();
            return false;
        }
    }
    if (parseInt(obj.SuperiorOccupy.value) > parseInt(MaxSuperiorOccupy)) {
        alert("‘" + $("#soy").html() + "’不可高於 " + MaxSuperiorOccupy + "% ，請重新設定!!!");
        obj.SuperiorOccupy.focus();
        return false;
    }
    if (obj.StintID != null) {
        if (obj.StintID[1].checked) {
            if (obj.SubordinateOccupy.value == "") {
                alert("請設置‘占成上限’最高比例!!!");
                obj.SubordinateOccupy.focus();
                return false;
            }
            if (obj.SubordinateOccupy.value > 100) {
                alert("‘占成上限’不可高於100% ，請重新設定!!!");
                obj.SubordinateOccupy.focus();
                return false;
            }
        }
    }
    if (confirm("是否確定寫入該帳號嗎？")) {
        obj.submit.disabled = "disabled";
        return true;
    }
    return false;
}

function DeleteUser(url) {
    if (confirm("是否確定刪除該帳號嗎？")) {
        location.href = url;
    }
}
function showFlash(id) {
    var flash = document.getElementById(id);
    if (flash.innerHTML == "") {
        flash.innerHTML = "<embed width=\"0\" height=\"0\" src=\"/Images/c.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />";
        setTimeout(function () { flash.innerHTML = ""; }, 10000);
    }
}