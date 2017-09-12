FastClick.attach(document.body);
var badcode,bbankId;
var o = {
    getParam :function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    },
    showList: function() {
        $.ajax({
            url:'/notcontrol/card/queryRecommendCards.go?adcode=310100&key=2',
            type:'get',
            dataType:'json',
            success: function(data) {
                console.log(data);
                var str ='';
                for(var i=0;i<data.data.list.length;i++){
                    str+="<a href="+data.data.list[i].actionURL+"><img src="+data.data.list[i].picURL+"></a>"
                }
                $('.list_img').html(str)
            }//success
        })//ajax
    },
    bind: function(){
        //#step2
        $('#step2 a').click(function(){
            $(this).addClass("on");
            if($(this).index() !== 3){//成功
                location.href= o.getParam('applyUrl');
            }else{
                $('#step2').hide();
                $('#step3').show();
                o.showList();
            }
        })
        //返回全部银行
        $('.allBank_box a').click(function(){
            $(this).addClass("on");
            location.href = 'http://www.huishuaka.com/5/hskh5/banklist.html'
        })
        //全部 推荐卡片
        $('.list_title a').click(function(){
            $(this).addClass("on");
            location.href='http://www.huishuaka.com/5/hskh5/banklist.html'
        })
    },
    getcityId: function() {
        //判断用户手机android/ios
        try{
            if(/i(os|phone|pad)/i.test(navigator.userAgent)) {
                badcode = HuishuakaIOS.jsGetAdcode();
            } else {
                badcode = window.HuishuakaAndroid.jsGetAdCode();
            }

        }catch(e){}

    },
    init: function(){
        o.bind();
    }
}
o.init()




















