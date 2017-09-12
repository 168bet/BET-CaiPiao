$(function(){
    $(".footer").css({"padding-bottom":"60px","margin-top":"1.6rem"});
    $(".list-container")[0].addEventListener("touchend",function(e){
        if($(".list-container li").last().get(0).offsetTop + parseInt($(".list-container li").last().height()/2)  <= $(".scroll-wrap").scrollTop() + $("body")[0].scrollHeight){
            $.ajax({
                //dataType: "json",
                type: "get",
                url: "/index.php?m=wap&c=index&a=next_lists&catid=" + catid + "&page=" + page,
                beforeSend: function(){
                    $(".scroll-alert").css("display","block");
                },
                success: function(result) {
                        if (result ) {
                            result = JSON.parse(result);
                            if(result.code == "1"){
                                page++;
                                var list = result.lists;
                                $(".scroll-alert").css("display","none");
                                var html = "";
                                for (var i = 0; i < list.length; i++) {
                                    html += '<li>' +
                                        '<a href="' + list[i].url + '" class="item-link item-content pd">' +
                                        '<div class="item-media">' +
                                        '<img src="' + list[i].thumb + '" alt="' + list[i].title + '">' +
                                        '</div>' +
                                        '<div class="item-inner">' +
                                        '<div class="item-title-row">' +
                                        '<div class="item-title">' +
                                        list[i].title
                                        + '</div>' +
                                        '</div>' +
                                        '<div class="item-text">' + list[i].description +
                                        '</div>' +
                                        '<div class="list_desc">' +
                                        '<span class="">' + rightTime(list[i].inputtime) + '</span>' +
                                        '</div>' +
                                        '</div>' +
                                        '</a>' +
                                        '</li>';
                                }
                                $(".list-container").append(html);
                            }else{
                                $(".scroll-alert").text("已经加载全部！").css("background","none");
                                setTimeout(function(){
                                    $(".scroll-alert").css("display","none");
                                },3000);
                            }
                            }
                }
            })
        }
    },false);

    function rightTime(d){
        var date = new Date(parseInt(d));
        var y = date.getFullYear();
        var m = (date.getMonth() + 1 > 9) ? (date.getMonth() + 1) : ("0"+(date.getMonth() + 1));
        var day = date.getDate() > 9 ? date.getDate() : "0" + date.getDate();
        var h = date.getHours() > 9 ? date.getHours() : "0"+ date.getHours();
        var min = date.getMinutes() > 9 ? date.getMinutes() : "0" + date.getMinutes();
        return y + '-' + m + '-' + day + "  " + h + ":" + min;
    }
})