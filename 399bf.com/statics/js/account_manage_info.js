$(document).ready(function () {
    new PCAS("province","city","area", province, city, area);

    //自定义验证规则
    $.validator.addMethod('phone', function(value, elem, param) {

        var phone = /^0?1(3|4|5|7|8)\d{9}$/;

        return this.optional(elem) || (phone.test(value));


    }, '请输入正确的手机号码');

    $.validator.addMethod('telphone', function(value, elem, param) {

        var telphone = /^((0(10|2[1-3]|[3-9]\d{2}))?[1-9]\d{6,7})$/;

        return this.optional(elem) || (telphone.test(value));


    }, '请输入正确的固定电话');

    $.validator.addMethod('zh_char', function(value, elem, param) {

        var zh_char = /([\u4e00-\u9fa5]{2,4})/;

        return this.optional(elem) || (zh_char.test(value));


    }, '请确保地址中有汉字');

    $.validator.addMethod('number', function(value, elem, param) {

        var isnumber = /^[0-9]$/;

        return this.optional(elem) || (isnumber.test(value));


    }, '请输入数字');

    //表单验证
    $('#commentForm').validate({

        degbug: true,

        onkeyup:false,

        rules: rules,

        messages: messages,

        errorClass:'invalid'
    });

    //上传头像flash
    var flashvars = {
        'upurl':url + "&callback=return_avatar&"
    };
    var params = {
        'align':'middle',
        'play':'true',
        'loop':'false',
        'scale':'showall',
        'wmode':'window',
        'devicefont':'true',
        'id':'Main',
        'bgcolor':'#ffffff',
        'name':'Main',
        'allowscriptaccess':'always'
    };
    var attributes = {

    };
    swfobject.embedSWF(APP_PATH + "statics/images/main.swf", "avatar-body", "490", "434", "9.0.0", APP_PATH + "statics/images/expressInstall.swf", flashvars, params, attributes);

    //异步提交
    $('[data-action="ajax-submit"]').on('click', function () {
        var target = $(this).data('target'),
            form = $(target),
            url = $(this).data('url');
        $.ajax({
            url: url,
            data: form.serialize(),
            dataType: 'json',
            type: 'post',
            success: function (result) {
                if (result.status == true) {
                    swal({
                        title: result.data.title,
                        type: result.data.type,
                        text: result.data.text
                    });
                } else {
                    $('label.invalid').remove();
                    ErrorTips.init(result.tip, {
                        placement: 'right',
                        offset: {
                            right: 100
                        }
                    });
                }
            }
        });
    });
});