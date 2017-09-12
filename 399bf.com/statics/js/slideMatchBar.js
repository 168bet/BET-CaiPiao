/**
 * Created by xiaoxinwu
 */
/*
/   赛事直播条   html结构要求：sideBox和按钮是相邻节点，sideBox子节点是ul
 */
function silde_matchBar(elem) {
    var $ul = elem.sideBox.find('ul'),
        prevBtn = elem.sideBox.find('.tabPrev'),
        nextBtn = elem.sideBox.find('.tabNext'),
        $li,$box,$liW,autoVar,toPrev,toNext;
//  动态获取ul 的 子节点
    autoVar=function($this){
        $li=$this.find('li');
        $liW=parseInt($li.css('width'));
        $box=$this.parent();
    }
//  向上翻动作
    toPrev = function ($UL) {
        autoVar($UL);
        var befLeft = parseInt($UL.css("left"));
        var leftUl = befLeft + elem.speed *$liW ;
        if (leftUl >= 0) {
            leftUl = 0;
        }

        $UL.stop().animate({
            left: leftUl + "px"
        });
    };
//  向下翻动作
    toNext = function ($UL) {
        autoVar($UL);
        var befLeft = parseInt($UL.css("left"));
        var leftUl = befLeft - elem.speed * $liW;
        if (Math.abs(leftUl) >$UL.width() - $box.width()) {
            leftUl = $UL.width() - $box.width();
            leftUl='-'+leftUl;
        }

        $UL.stop().animate({
            left: leftUl + "px"
        });
    };

    $ul.each(function(){
        var $this=$(this);
        autoVar($this);
        $this.css({
            position: "absolute",
            left: "0px",
            width: $li.length*$liW + "px"
        });

    });
//  ACTION
    $ul.mousewheel(function (event, delta) {
        var $this=$(this);
        event.preventDefault();
        delta > 0 ? toPrev($this) : toNext($this);
    })

    if(!!prevBtn||!!nextBtn){
        prevBtn.on("click", function () {
            toPrev($(this).siblings('div').children('ul'));
        });
        nextBtn.on("click", function () {
            toNext($(this).siblings('div').children('ul'));
        });
    }

}