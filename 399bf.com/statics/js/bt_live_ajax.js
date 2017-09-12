(function(){

    //更新比赛信息
    function updateData(){
        var dataItemIn = $('#sorttime [data-inprogress]');
        var dataItemInArr = [];

        //存储已开始id
        for (var j = 0; j < dataItemIn.length; j++) {
            dataItemInArr.push($(dataItemIn).eq(j).data('inprogress'))
        }

        if (dataItemInArr.length > 0) {
            //更新表格内数据
            $.post('/index.php?m=sportsdata&c=basketball&a=schedule_data',{
                schedule_id: dataItemInArr
            },function(data){

                if (!data.status) {
                    return false;
                }
                var tag = $('#audio-btn').prop('checked');
                var audio = $('#audio').get(0);
                var isplay = false;

                $(data.data["in_progress"]).each(function () {
                    var dataId = $('#sorttime [data-inprogress=' + this.scheduleid + ']');
                    for (var key in this) {
                        if (key == 'status') {
                            $(dataId).find('.status').text(this.status + ' ' + this.remaintime);
                        }else if(key=='homescore'||key=='guestscore'){
                            var oldValue = Number($(dataId).find('.'+key).data(key));
                            var newValue = this[key];

                            $(dataId).find('.'+key).data(key, this[key]);

                            if (newValue > oldValue && tag) {
                                isplay = true;
                            }

                            if (newValue > oldValue) {
                                $(dataId).find('.'+key).parent().css('backgroundColor','#ffa21d');
                            }

                            $(dataId).find('.' + key).html(this[key]);

                        }else {
                            $(dataId).find('.' + key).html(this[key]);
                        }
                    }
                });
                if(isplay){
                    audio.play();
                }
                 setTimeout(function(){
                     $('#progress .homescore, #progress .guestscore').parent().css('backgroundColor','#fff');
                 }, 3000);

                //如果进行中的比赛已经结束，放入已经结束表格
                for (var key in data.data['finish_id']) {
                    //防止变为完场后未移除背景色
                    $('#sorttime [data-inprogress=' + data.data['finish_id'][key]['scheduleid'] + ']').find('.homescore,.guestscore').parent().css('backgroundColor','#fff');
                    $('#over').append($('#sorttime [data-inprogress=' + data.data['finish_id'][key]['scheduleid'] + ']').removeAttr('data-inprogress').detach()).find('.table-wrap').last().css('border','1px solid #91ddff');
                    $('#over').find('.time-start').last().removeClass('time-start').addClass('time');
                }
            });
        }

    }

    //更新赔率
    function updateRate(){
        var dataItemIn=$('#sorttime [data-inprogress]');
        var dataItemInArr=[];

        //存储已开始id
        for(var j=0;j<dataItemIn.length;j++){
            dataItemInArr.push($(dataItemIn).eq(j).data('inprogress'))
        }

        if (dataItemInArr.length > 0) {
            //更新赔率数据
            $.post('/index.php?m=sportsdata&c=basketball&a=rate_data', {
                schedule_id: dataItemInArr,
                company_id: $('#company').data('companyid')
            },function(data){

                if (!data.status) {
                    return false;
                }

                $(data.data["in_progress"]).each(function () {
                    var id = this.scheduleid;
                    var preArr = {
                        //让分
                        'letgoal1'   : 'letgoal',
                        'letgoal2'   : 'letgoal',
                        'homeodds'  : 'homeodds',
                        'guestodds' : 'guestodds',
                        //欧赔
                        'homewin'   : 'homewin',
                        'guestwin'  : 'guestwin',
                        //大小
                        'totalscore1' : 'totalscore',
                        'totalscore2' : 'totalscore',
                        'lowodds'     : 'lowodds',
                        'highodds'    : 'highodds'
                    };

                    _updateRate(preArr, this, id);


                });
            });
        }

    }

    //即将开始的比赛
    function change(){
        var dataItemNo = $('#sorttime [data-notstarted]');
        var dataItemNoArr = [];

        //存储未开始id
        for (var i = 0; i < dataItemNo.length; i++) {
            dataItemNoArr.push($(dataItemNo).eq(i).data('notstarted'));
        }
        if(dataItemNoArr.length > 0){
            //判断比赛变动
            $.post('/index.php?m=sportsdata&c=basketball&a=schedule_change', {
                schedule_id: dataItemNoArr,
                company_id: $('#company').data('companyid')
            }, function (data) {

                if(!data.status){
                    return false;
                }

                $(data.data["in_progress_data"]).each(function(){
                    var dataId = $('#sorttime [data-notstarted=' + this.scheduleid + ']');

                    for (var key in this) {
                        if (key == 'status') {
                            $(dataId).find('.status').text(this.status + ' ' + this.remaintime);
                        } else {
                            $(dataId).find('.' + key).html(this[key]);
                        }
                    }

                    $('#progress').append($(dataId).removeAttr('data-notstarted').attr('data-inprogress', this.scheduleid).detach()).find('.table-wrap').last().css('border','1px solid #ffa21d');
                    $('#progress').find('.time').last().removeClass('time').addClass('time-start');
                })
            });
        }
    }

    //按赛事ajax
    function mergeAjax(){
        var dataItemIn = $('#sortevent [data-inprogress]');
        var dataItemInArr = [];

        //存储已开始id
        for (var j = 0; j < dataItemIn.length; j++) {
            dataItemInArr.push($(dataItemIn).eq(j).data('inprogress'))
        }

        var dataItemNo=$('#sortevent [data-notstarted]');
        var dataItemNoArr=[];
        for(var i=0;i<dataItemNo.length;i++){
            dataItemNoArr.push($(dataItemNo).eq(i).data('notstarted'));
        }

        //未开始比赛变为开始
        if(dataItemNoArr.length>0){
            $.post('/index.php?m=sportsdata&c=basketball&a=schedule_change', {
                schedule_id: dataItemNoArr,
                company_id: $('#company').data('companyid')
            }, function (data) {

                if(!data.status){
                    return false;
                }

                $(data.data["in_progress_data"]).each(function(){
                    var dataId = $('#sortevent [data-notstarted=' + this.scheduleid + ']');

                    for (var key in this) {
                        if (key == 'status') {
                            $(dataId).find('.status').text(this.status + ' ' + this.remaintime);
                        } else {
                            $(dataId).find('.' + key).html(this[key]);
                        }
                    }
                    $(dataId).removeAttr('data-notstarted').attr('data-inprogress', this.scheduleid);
                })
            });

        }

        //更新表格内数据
        if(dataItemInArr.length>0){

            $.post('/index.php?m=sportsdata&c=basketball&a=schedule_data',{
                schedule_id: dataItemInArr
            },function(data){

                if (!data.status) {
                    return false;
                }

                $(data.data["in_progress"]).each(function () {
                    var dataId = $('#sortevent [data-inprogress=' + this.scheduleid + ']');

                    for (key in this) {
                        if (key == 'status') {
                            $(dataId).find('.status').text(this.status + ' ' + this.remaintime);
                        } else {
                            $(dataId).find('.' + key).html(this[key]);
                        }
                    }
                });

                //如果进行中的比赛已经结束，放入已经结束表格
                for (var key in data.data['finish_id']) {
                    var container=$('#sclassid_' + data.data['finish_id'][key]['sclassid']);
                    var id=data.data['finish_id'][key]['scheduleid'];
                    $(container).append($(container).find('[data-inprogress=' + id + ']').removeAttr('data-inprogress').attr('data-finished',id).detach());
                }

            });

            //赔率
            $.post('/index.php?m=sportsdata&c=basketball&a=rate_data',{
                schedule_id: dataItemInArr,
                company_id: $('#company').data('companyid')
            },function(data){

                if (!data.status) {
                    return false;
                }

                $(data.data["in_progress"]).each(function () {
                    var id = this.scheduleid;
                    var preArr = {
                        //让分
                        'letgoal3'   : 'letgoal',
                        'letgoal4'   : 'letgoal',
                        'homeodds3'  : 'homeodds',
                        'guestodds3' : 'guestodds',
                        //欧赔
                        'homewin3'   : 'homewin',
                        'guestwin3'  : 'guestwin',
                        //大小
                        'totalscore3' : 'totalscore',
                        'totalscore4' : 'totalscore',
                        'lowodds3'     : 'lowodds',
                        'highodds3'    : 'highodds'
                    };

                    _updateRate(preArr, this, id);


                })
            });
        }
    }

    //模块：更新，判断赔率变化；撤销箭头
    function _updateRate(preArr, that, id){
        var oldValue = null,
            newValue = null,
            copy = null;

        if(preArr === null || preArr === undefined || typeof preArr !== 'object'){
            return false;
        }

        if(that === null || that === undefined || typeof that !== 'object'){
            return false;
        }

        //更新，判断数据变化
        for (var key in preArr) {
            oldValue = Number($('#' + key + id).data(preArr[key]));
            newValue = Number(that[preArr[key]]);

            copy = newValue;
            newValue = Math.abs(newValue);

            $('#' + key + id).data(preArr[key], newValue);

            //让分盘口小于零，客队让分
            if (copy < 0 && (key === 'letgoal1' || key === 'letgoal3')) {
                $('#' + key + id).html('');
                continue;
            }

            //让分盘口大于等于零，主队让分
            if (copy >= 0 && (key === 'letgoal2' || key === 'letgoal4')) {
                $('#' + key + id).html('');
                continue;
            }

            if (oldValue > newValue) {
                $('#' + key + id).addClass('green').html(newValue + '<i class="odds-down"></i>');
            }else if(oldValue<newValue){
                $('#' + key + id).addClass('red').html(newValue + '<i class="odds-up"></i>');
            }
        }

        //撤销箭头
        setTimeout(function(){
            for (var key in preArr) {
                $('#' + key + id).removeClass('red green').children('i').remove();
            }
        }, 3000);

    }

    //按赛事移动完场到底部
    function _moveToBottom() {
        //获取结束id
        var finish = $('#sortevent [data-finished]');

        //遍历节点并挪动位置到底部
        $(finish).each(function ()
        {
            $('#sclassid_' + $(this).data('sclassid')).append($(this).detach());
        });

    }

    //分类控制状态
    var status = 1;
    //按时间按钮
    var stime = $('#stime');
    //按赛事按钮
    var sevent = $('#sevent');
    var timer1 = setInterval(updateData, 1000 * 5);
    var timer2 = setInterval(updateRate, 1000 * 10);
    var timer3 = setInterval(change, 1000 * 10);
    var timer4 = null;

    $(stime).click(function(){
        status = 1;
        var count = 0;
        $('#sorttime').css({'display': 'block'});
        $('#sortevent').css({'display': 'none'});
        $(this).addClass('active');
        $(sevent).removeClass('active');
        clearInterval(timer4);
        timer1 = setInterval(updateData, 1000 * 5);
        timer2 = setInterval(updateRate, 1000 * 10);
        timer3 = setInterval(change, 1000 * 10);
        var dataItem = document.getElementById('sorttime').getElementsByClassName('data-item');
        for (var i = 0; i < dataItem.length; i++) {
            if (dataItem[i].style.display == 'none') {
                count++;
            }
        }
        document.getElementById('hidden').innerHTML = count;
    });

    $(sevent).click(function(){
        status = 2;
        var count = 0;
        $('#sorttime').css({'display': 'none'});
        $('#sortevent').css({'display': 'block'});
        $(this).addClass('active');
        $(stime).removeClass('active');
        timer4 = setInterval(mergeAjax, 1000 * 10);
        clearInterval(timer1);
        clearInterval(timer2);
        clearInterval(timer3);
        var dataItem = document.getElementById('sortevent').getElementsByClassName('data-item');
        for (var i = 0; i < dataItem.length; i++) {
            if (dataItem[i].style.display == 'none') {
                count++;
            }
        }
        //按赛事移动完场到底部
        _moveToBottom();
        document.getElementById('hidden').innerHTML = count;
    });



    //保留选中
    var selected=document.getElementById('selected');
    selected.onclick=function(){
        var dataItem=null,count=0;
        if(status==1){
            dataItem=document.getElementById('sorttime').getElementsByClassName('data-item');
        }else{
            dataItem=document.getElementById('sortevent').getElementsByClassName('data-item');
        }
        for(var i=0;i<dataItem.length;i++){
            if(dataItem[i].getAttribute('data-select')=='false'){
                dataItem[i].style.display='none';
                count++;
            }else{
                dataItem[i].style.display='block';
            }
        }
        document.getElementById('hidden').innerHTML=count;
    };

    //删除选中
    var del=document.getElementById('del');
    del.onclick=function(){
        var dataItem=null,count=0;
        if(status==1){
            dataItem=document.getElementById('sorttime').getElementsByClassName('data-item');
        }else{
            dataItem=document.getElementById('sortevent').getElementsByClassName('data-item');
        }
        for(var i=0;i<dataItem.length;i++){
            if(dataItem[i].getAttribute('data-select')=='true'){
                dataItem[i].style.display='none';
                count++;
            }else{
                dataItem[i].style.display='block';
            }
        }
        document.getElementById('hidden').innerHTML=count;
    };

    //显示全部
    var all=document.getElementById('all');
    all.onclick=function(){
        var dataItem=null;
        if(status==1){
            dataItem=document.getElementById('sorttime').getElementsByClassName('data-item');
        }else{
            dataItem=document.getElementById('sortevent').getElementsByClassName('data-item');
        }
        for(var i=0;i<dataItem.length;i++){
            dataItem[i].style.display='block';
        }
        document.getElementById('hidden').innerHTML=0;
        $('.title').show();
    };


    //全选
    $('[data-action="check-all"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]');
        $(elem).each(function (index) {
            elem[index].checked = true;
        });
    });

    //模糊弹出层确定按钮
    $('[data-action="submit"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]:checked'),
            value = [];
        elem.each(function () {
            value.push(Number($(this).val()));
        });
        var count=0;
        //计算隐藏数
        if (value.length > 0) {
            $('.data-item').each(function () {
                var item = $(this),
                    val = Number(item.data(target));
                if ($.inArray(val, value) < 0) {
                    item.hide();
                    count++;
                } else {
                    item.show();
                }
            });
        } else {
            $('.data-item,.title').show();
        }
        document.getElementById('hidden').innerHTML=Math.ceil(count/2);
    });

    //全不选
    $('[data-action="check-clear"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]');
        $(elem).each(function (index) {
            elem[index].checked = false;
        });
    });
    //设置
    $('#set').click(function(){
        $('#setmenu').toggle();
    })
})();