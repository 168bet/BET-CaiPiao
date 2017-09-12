/**
 * Created by Administrator on 2016/6/27.
 */
(function($) {
    footerAuto();
    essenceAuto();
})(jQuery);

function checkSession(btn, selectBtn, session) {
    btn.on("click", function() {
        $("#selectDiv").show();
    });
    selectBtn.on("click", function() {
        var str = $(this).text();
        var competition_id = $(this).data('competition'),
            format = $(this).data('format'),
            current = $(this).data('current');
        session.text(str);
        $("#selectDiv").hide();
        $.ajax({
            data: {
                competitionid: competition_id,
                format: format,
                current: current
            },
            url: APP_PATH + 'index.php?m=content&c=index&a=ajax_schedule',
            type: 'post',
            dataType: 'json',
            success: function(result) {
                if (result.status) {
                    var ul = $('.matchBox').find('ul').empty();
                    $(result.schedule).each(function() {
                        var match_item = $('<li class="match-item"></li>'),
                            match_hd = $('<div class="match-hd clearfix"></div>'),
                            match_bd = $('<div class="match-bd clearfix"></div>'),
                            match_fd = $('<div class="match-fd clearfix"></div>'),
                            fl = $('<div class="fl"></div>'),
                            fr = $('<div class="fr"></div>'),
                            vs = $('<em class="middle">VS</em>'),
                            home_photo = $('<a href="' + this.home_url + '" target="_blank"></a>').append('<img src="' + this.home_photo + '" class="team-photo">'),
                            away_photo = $('<a href="' + this.away_url + '" target="_blank"></a>').append('<img src="' + this.away_photo + '" class="team-photo">'),
                            home_name = $('<a href="' + this.home_url + '" target="_blank"></a>').append('<span>' + this.home_short_name + '</span>'),
                            away_name = $('<a href="' + this.away_url + '" target="_blank"></a>').append('<span>' + this.away_short_name + '</span>'),
                            game_url = $('<a href="' + this.game_url + '" class="fl">分析</a>'),
                            live_url = this.is_live ? $('<a href="' + this.live_url + '" class="fr">直播</a>') : '',
                            match_time = $('<div class="matchTime"></div>'),
                            date = $('<span class="fl">' + this.date + '</span>'),
                            status = $('<span class="fr">' + this.status + '</span>');
                        fl.append(home_photo, home_name);
                        fr.append(away_photo, away_name);
                        match_hd.append(fl, fr, vs);
                        match_bd.append(live_url, game_url);
                        match_time.append(date, status);
                        match_fd.append(match_time);
                        match_item.append(match_hd, match_bd, match_fd);
                        ul.append(match_item);
                    });
                }

                silde_matchBar({
                    sideBox: $("#match"),
                    speed: 1, //滚动个数
                    showNum: 8 //显示的li数目
                });
            }
        });


    })

}
//标题切换
function sildeTile(elem) {
    elem.find('.collection_>li').mouseenter(function() {
        $(this).find('.pic-title').animate({
            bottom: "0px"
        });
    })
    elem.find('.collection_>li').mouseleave(function() {
        $(this).find('.pic-title').animate({
            bottom: "-2.5em"
        })
    })
}
//tab切换
function tabList(table) {
    $('[role="presentation"]').on("click", function() {
        var $this = $(this);
        $this.addClass("current").siblings().removeClass("current");
        var parents = $this.parents('[role="tabList"]');
        if (parents) {
            parents.next().find('[role="tabpanel"]').eq($this.index()).addClass('current').siblings().removeClass('current');
        }
        if (table) {
            table.next().find('[role="streak"]').eq($this.index()).addClass('current').siblings().removeClass('current');
        }
    })
}
//榜单移入移出效果
function hoverFunc(elem) {
    elem.find("td").mouseenter(function() {
        $(this).parent().addClass("active").siblings().removeClass("active");
    });
}
//表格条纹效果
function streak(elem, num) {
    elem.find('tr').removeClass('streak');
    if (num) {
        elem.find("tr:even").addClass("streak");
        return
    }
    elem.find("tr:odd").addClass("streak");
}
//比分表格头固定
function tabFixed(elem, scrollT) {
    var parent = elem.parent();
    var scrollTop = $(document).scrollTop();
    var $width = parent.width();
    var $left = parent.offset().left;
    if (scrollTop >= scrollT) {
        elem.css({
            position: "fixed",
            width: $width,
            top: "0px",
            left: $left,
            zIndex: 10
        });
    } else {
        elem.css({
            position: "static",
            width: "100%",
            top: "auto",
            left: "auto",
            zIndex: "auto"
        });
    }
    $(window).resize(function() {
        $width = parent.width();
        $left = parent.offset().left;
        elem.css({
            width: $width,
            left: $left
        })
    });
}

//比分悬浮层全选切换
function checkAll(elem) {
    var checkboxs = $(elem).parents('.form-item').find('[type="checkbox"]');
    checkboxs.each(function(index) {
        checkboxs[index].checked = true;
    })
}

function clearCheck(elem) {
    var checkboxs = $(elem).parents('.form-item').find('[type="checkbox"]');
    checkboxs.each(function(index) {
        checkboxs[index].checked = false;
    })
}
//比分悬浮层
function showDiolog(elem) {
    elem.on("click", ".path-select", function() {
        $("#Diolog").show();
        if ($(this).data("id")) {
            var $id = $(this).data("id");
            $("#" + $id).show().siblings().hide();
        }
    })
}
//比分悬浮层tab切换
function tabDiolog() {
    $("#Diolog").on("change", "form [type='radio']", function() {
        var form = $(this).parents('.form-item');
        var checkboxs = form.find("[type='checkbox']");
        checkboxs.each(function(index) {
            checkboxs[index].checked = false;
        })
        form.find("#" + $(this).get(0).value).show().siblings().hide();
    })
}

function hideDiolog() {
    $("#Diolog").on("click", "[role='button']", function() {
        $("#Diolog").hide();
        clearCheck($(this));
    })
}
//banner
function banner(elem) {
    var bd = elem.find(".banner-bd"),
        fd = elem.find(".banner-fd"),
        link = bd.children("a"),
        img = link.find("img"),
        title = bd.find(".banner-title h1 a"),
        title_ = bd.find(".banner-title p a"),
        index = bd.find(".banner-index"),
        count = bd.find(".count"),
        li = fd.find("li"),
        activeLi = fd.find(".active"),
        activeImg, linkStr, titleStr, titleInfoStr;

    function setData(IMG) {
        linkStr = IMG.data('link');
        titleStr = IMG.data("title");
        titleInfoStr = IMG.data("titleInfo");
    }

    function effect(LI) {
        var index_ = LI.index(),
            activeImg = LI.find('img');


        setData(activeImg);
        auto(activeImg, linkStr, titleStr, titleInfoStr, index_ + 1);

        img.css("display", "none").fadeIn(500);
        LI.addClass('active').siblings().removeClass('active');
    }

    function auto(activeImg, linkStr, titleStr, titleInfoStr, indexStr) {
        var src = activeImg.attr('src');
        img.attr("src", src);
        link.attr("href", linkStr);
        title.text(titleStr).attr("href", linkStr);
        title_.text(titleInfoStr).attr("href", linkStr);
        index.text(indexStr);
    }

    activeImg = activeLi.find('img');
    setData(activeImg);
    count.text(li.length);
    auto(activeImg, linkStr, titleStr, titleInfoStr, activeLi.index() + 1);


    var isMouseIn = false;

    elem.on('mouseenter', '.banner-bd,.banner-fd li', function() {
        effect($(this));
        isMouseIn = true;

        $(this).mouseleave(function() {
            isMouseIn = false;
        })
    });

    //定时器
    setInterval(function() {
        //判断鼠标是否移入，未移入则执行
        if (!isMouseIn) {
            var $nextLi = fd.find("li.active").next();
            if (!$nextLi.get(0)) {
                $nextLi = li.first();
            }
            effect($nextLi);
        }
    }, 3000)


}

/*
 功能：球队图标，联赛图标替换备用图片地址
 参数：selector，有需要替换地址的类名
 */
function backupImg(selector) {
    window.onload = _backupImg(selector);

    function _backupImg(selector) {
        //图片缓存库
        var temp = [];
        //默认图片
        var default_photo = IMG_PATH + 'default_photo.jpg';
        var origin_src = '';
        $(selector).each(function(index, obj) {
            origin_src = obj.src;
            //如果缓存库中已经有该原地址的替换图，直接替换
            if (temp[origin_src] != undefined) {
                obj.src = temp[origin_src];
            } else {
                var img = new Image();
                img.src = origin_src;
                img.onload = _defaultImg(img, obj);

                function _defaultImg(img, obj) {
                    if (img.complete != true) {
                        obj.src = default_photo;
                        temp[origin_src] = default_photo;
                    }
                }
            }
        });
    }
}

function footerAuto() {
    var screenH = document.documentElement.clientHeight,
        clientH = document.documentElement.scrollHeight,
        $footer = $('#footer');

    //如果文档高度小于浏览器可见高度，则增加类名。
    clientH <= screenH ? $footer.addClass('footerPin') : $footer.removeClass('footerPin');

    window.onresize = function() {
        footerAuto();
    };
}

/*
 大图友好处理
 ps:默认不可见,，加载成功后可见
 */
function imgLoad($imgs) {
    var checkImg = function($img, callBack) {
        var timer = setInterval(function() {
            if ($img[0].complete) {
                callBack();
                clearInterval(timer);
            }
        }, 50)
    };
    $imgs.each(function() {
        var $this = $(this);
        checkImg($this, function() {
            $this.css({
                visibility: "visible"
            })
        });
    })
}

/*
 * 右侧精华推荐
 */
function essenceAuto() {
    try {
        var essence = $("#essence").find("li");
        essence.eq(0).addClass('active');
        essence.each(function() {
            var $this = $(this);
            $this.mouseover(function() {
                $this.addClass('active').siblings().removeClass('active');
            });
        });

    } catch (err) {
        console.log(err);
    }

}
/*
/   比分表格管理组件
 */


(function() {
    var tableTop = $('#fixedTable'), //头部表格
        table = $('[role="streak"]'), //数据表格
        ctrlBar = $('#pathNav'), //控制条
        companyBtn = $('[name="dropDown"]'), //公司按钮
        diolog = $('#Diolog'), //弹出层
        sortBtn = diolog.find('[name="sort"]'), //筛选按钮
        checkbox,
        getCheckAll, setParent, showDropMenu, hideDropMenu, removeFunc, reserveFunc, resetFunc, sortFunc, timer, tr;

    //获取表格全部复选框
    getCheckAll = function() {
        checkbox = [];
        var checkbox_ = [];
        tableTop.find('[type=checkbox]').each(function() {
            checkbox.push($(this)[0]);
        });
        table.find('[type=checkbox]').each(function() {
            checkbox_.push($(this)[0]);
        });

        checkbox = checkbox.concat(checkbox_);
        return checkbox;
    };
    setParent = function(parent) {
        return {
            dropMenu: parent.find('[role=menu]'),
            tr: parent.parents('tr')
        };
    };
    //显示下拉菜单
    showDropMenu = function(parent) {
        clearTimeout(timer);
        setParent(parent).dropMenu.show();
    };
    //隐藏下拉菜单
    hideDropMenu = function(parent) {
        setParent(parent).dropMenu.fadeOut(100);
    };
    //计数
    var num = 0,
        setNum;
    setNum = function(num) {
        var i = 0,
            j = 0,
            length = 0,
            $this;
        $('tr', tableTop).each(function() {
            $this = $(this);
            if ($this.css('display') == "none") {
                j++;
            }
            length++;
        });
        if (length - 2 <= 0) {
            length = 0;
        } else {
            length = length - 2;
        }
        $('tr', table).each(function() {
            $this = $(this);
            if ($this.css('display') == "none") {
                i++;
            }
        });
        i = i + j - length;
        if (num) {
            i = 0;
        }
        ctrlBar.find('.num').text(i);
    };
    //删除选中节点
    removeFunc = function() {
        checkbox = getCheckAll();
        for (var i = 0; i < checkbox.length; i++) {
            tr = setParent($(checkbox[i])).tr;
            var str = tr.css('display');
            if (str != "none" && checkbox[i].checked == true) {
                tr.hide();
            }
        }
        setNum();
    };
    //保留选中节点
    reserveFunc = function() {
        checkbox = getCheckAll();
        for (var i = 0; i < checkbox.length; i++) {
            tr = setParent($(checkbox[i])).tr;
            var str = tr.css('display');
            if (str != "none" && checkbox[i].checked == false) {
                tr.hide();
            }
        }
        setNum();
    };
    //显示隐藏节点
    resetFunc = function() {
        checkbox = getCheckAll();
        for (var i = 0; i < checkbox.length; i++) {
            $(checkbox[i]).parents('tr').show();
        }
        setNum(true);
    };
    //分类筛选
    sortFunc = function(dataStr) {
        var dioCheckbox = diolog.find('[type=checkbox]'),
            dataValue = [];

        dioCheckbox.each(function() {
            var $this = $(this);

            if ($this[0].checked == true) {
                dataValue.push($this.val());
            }
        });

        $(getCheckAll()).each(function() {
            $this = $(this);
            tr = setParent($this).tr;
            for (var i = 0; i < dataValue.length; i++) {
                if (tr.data(dataStr) == dataValue[i]) {
                    tr.show();
                    break
                } else {
                    tr.hide();
                }

            }
        });
        setNum();
    };
    // form action
    setParent(companyBtn).dropMenu.on('click', '[name="companyitem"]', function() {
        var $this = $(this),
            form = setParent(companyBtn).dropMenu.find('form'),
            value = form.find('[name="companyid"]'),
            id;
        id = $this.data('id');
        value.val(id);
        form[0].submit();
    });
    // sort
    sortBtn.click(function() {
        sortFunc($(this).data('string'));
        footerAuto();
    });

    //  action
    companyBtn.mouseenter(function() {
        showDropMenu($(this));
    });
    companyBtn.mouseleave(function() {
        hideDropMenu($(this));
    });
    $('[name="remove"]', ctrlBar).click(function() {
        removeFunc();
        footerAuto();
    });
    $('[name="reserve"]', ctrlBar).click(function() {
        reserveFunc();
        footerAuto();
    });
    $('[name="reset"]', ctrlBar).click(function() {
        resetFunc();
        footerAuto();
    });


})(jQuery);

//比分悬浮窗
function alert_score(obj) {
    var target_tr = $(obj).parents('tr'),
        game_id = target_tr.data('gameId'),
        company_id = $('[name="companyid"]').val();

    //请求数据
    $.ajax({
        data: {
            gameid: game_id,
            companyid: company_id
        },
        url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_event_stats',
        type: 'post',
        dataType: 'json',
        success: function(result) {

            if (result.state) {

                var fhandicap = result.fhandicap;
                var titleText = '初盘参考:' + fhandicap;
                var data = result.data;
                var box = $('<div id="scoreDialog"></div>'),
                    table = $('<table width="100%"></table>'),
                    title = $("<tr>" + "<th colspan='5'>" + titleText + "</th>" + "</tr>");

                table.append(title);
                for (var i in data) {
                    //主队
                    var tr = $("<tr></tr>");

                    if (data[i].Type == "1") {
                        console.log(1)
                        tr.html("<td width='10%'><span class='blockBG " + data[i].Class + "'></span></td>" +
                            "<td width='35%'>" + data[i].Pname + "</td>" +
                            "<td class='minute' width='10%'>" + data[i].Minute + "<span class='status_'></span>' " + "</td>" +
                            "<td width='35%'>&nbsp;</td>" +
                            "<td width='10%'>&nbsp;</td>");
                        //客队
                    } else {
                        console.log(2)
                        tr.html("<td width='10%'>&nbsp;</td>" +
                            "<td width='35%'>&nbsp;</td>" +
                            "<td class='minute' width='10%'>" + data[i].Minute + "<span class='status_'></span>' " + "</td>" +
                            "<td width='35%'>" + data[i].Pname + "</td>" +
                            "<td width='10%'><span class='blockBG " + data[i].Class + "'></span></td>");
                    }

                    table.append(tr);

                }

                box.append(table);
                $(obj).parents('td').append(box);
            }
        }
    });
}

//赛事右侧浮动条
function SideBar_match() {
    console.log(1);

    this.pos = 'left';
    this.titleItem = {
        'yc':'交往战绩',
        'sc':'历史战线',
        'pl':'以往盘路',
        'pm':'排名统计',
        'ds':'单双统计',
        'jq':'进球统计',
        'jz':'交往战绩',
        'wj':'以往战绩'
    };


}

SideBar_match.prototype = {
    init: function(){

        this.createSideBar();
        this.event();

    },
    createSideBar: function(){
        var $Bar = $("<div class='sideNav'></div>"),
            titleItem = this.titleItem;

        for(var key in titleItem){
            //  循环创建锚节点及锚
            var $Link = $("<a></a>");


            $Link.text(titleItem[key])
                .attr("href", "#" + key)
                .appendTo($Bar);
        }

        $('section.main-body>.container,[name="body"]').append($Bar);

        var oL = this.pos == 'left' ? $('div.container').offset().left + $('div.container').innerWidth() + 20 : $('div.container').offset().left - 40;
        $Bar.get(0).style.left = oL + 'px';

        $Bar.find('a').css({
            display: "block",
            padding: "0 15px",
            textAlign: "center",
            color: "white",
            height: "40px",
            lineHeight: "40px",
        });
        $Bar.find('a').on('click',function(){
            $(this).addClass('active')
        });
        $Bar.css({
            position: "fixed",
            top: 0,
            bottom: 0,
            margin: "auto",
            height: $Bar.height(),
            backgroundColor: "#ffa21d",
            fontSize: "14px",
            borderRadius:'10px',
            overflow:'hidden',
            zIndex: 999
        });
    },
    event: function(){

        var self = this;
        var sideBarIt = $('.sideNav').find('a');

        var active = {
            'color': '#ffa21d',
            'background-color': '#ffffff'
        };
        var normal = {
            'color': '#ffffff',
            'background-color': '#ffa21d'
        };

        $(window).scroll(function(){
             var scrollTop = $(document).scrollTop() + 30;

            $('.score-item').each(function(){
                var item = $(this),
                    offsetT = item.offset().top,
                    h = item.outerHeight();

                //console.log(scrollTop,offsetT,h)
                var range = scrollTop >= offsetT && scrollTop < offsetT + h ? true : false;

                //console.log(item.get(0).id,scrollTop >= offsetT,scrollTop < offsetT + h)
                if(range){
                    //console.log('range is ' + item.get(0).id);
                    $('[href="#'+item.get(0).id+'"]').css(active).siblings().css(normal)
                }



            });

        });

        sideBarIt.click(function(){
            $(this).css(active).siblings().css(normal);
        })
    }




};
