$(function () {
    //在线客服打开控制
    $(".link_kefu").click(function () {
        var link = $(this).attr("data");
        this.newWindow = window.open(link, 'kefutalk', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=570,height=424');
        this.newWindow.focus();
        this.newWindow.opener = window;

        return false
    })
})
