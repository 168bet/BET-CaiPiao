(function(){
    //日历容器
    var calendar=document.getElementById('calendar');
    //月份按钮
    var preMonth=document.getElementById('preMonth');
    var nextMonth=document.getElementById('nextMonth');
    //年文本域
    var yearText=document.getElementById('year');
    //月份文本域
    var monthText=document.getElementById('month');
    //日文本域
    var dayText=document.getElementById('day');
    //星期文本域
    var weekText=document.getElementById('week');

    var now=new Date();
    //年
    var year=now.getFullYear();
    //月
    var month=now.getMonth()+1;
    //日
    var date=now.getDate();
    //星期
    var day=now.getDay();

    var m_days=[31,28+is_leap(year),31,30,31,30,31,31,30,31,30,31];
    var weekArr=['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];

    function init(){
        yearText.innerHTML=year;
        monthText.innerHTML=month+'月';
        dayText.innerHTML=date;
        weekText.innerHTML=weekArr[day];
    }
    init();
    renderDate(month,day);
    //上个月
    preMonth.onclick=function(e){
        window.event? window.event.cancelBubble = true : e.stopPropagation();
        var curMonth=parseInt(document.getElementById('month').innerHTML);
        if(curMonth===1){
            year=year-1;
            curMonth=12;
            resetDate(year,curMonth-1,date);
            //年份切换重新渲染
            var newPreDay=new Date(year,curMonth-1,1);
            day=newPreDay.getDay()-1;
            m_days[1]=28+is_leap(year);
            renderDate(curMonth,day);
        }else{
            curMonth=curMonth-1;
            var newDay=new Date(year,curMonth-1,1);
            day=newDay.getDay()-1;
            resetDate(year,curMonth-1,date);
            renderDate(curMonth,day);
        }
        monthText.innerHTML=curMonth+'月';
    };
    //下个月
    nextMonth.onclick=function(e){
        window.event? window.event.cancelBubble = true : e.stopPropagation();
        var curMonth=parseInt(document.getElementById('month').innerHTML);
        if(curMonth===12){
            year=year+1;
            curMonth=1;
            resetDate(year,curMonth-1,date);
            //年份切换重新渲染
            var newNextDay=new Date(year,curMonth-1,1);
            day=newNextDay.getDay()-1;
            m_days[1]=28+is_leap(year);
            renderDate(curMonth,day);
        }else{
            curMonth=curMonth+1;
            var newDay=new Date(year,curMonth-1,1);
            day=newDay.getDay()-1;
            resetDate(year,curMonth-1,date);
            renderDate(curMonth,day);
        }
        monthText.innerHTML=curMonth+'月';
    };

    //渲染日期
    function renderDate(month,week){
        //每个月的天数
        var days=m_days[month-1];
        //console.log(month,days);
        var sort=1;
        var today=date;
        //第一行起始td位置week
        var startTd=document.getElementsByClassName('dayLine')[0].getElementsByTagName('td')[week];
        //获取每一行
        var tr=document.getElementsByClassName('dayLine');

        //清除td数据
        clearTd();

        for(var i=0;i<tr.length;i++){
            if(i==0){
                for(var j=week+1;j<7;j++){
                    document.getElementsByClassName('dayLine')[0].getElementsByTagName('td')[j].innerHTML='<div class="day-item'+(sort==parseInt(dayText.innerHTML)?' today':'')+'">'+(sort++)+'</div>';
                }
            }else{
                for(var z=0;z<7;z++){
                    if(Boolean(sort>days)){
                        break
                    }
                    document.getElementsByClassName('dayLine')[i].getElementsByTagName('td')[z].innerHTML='<div class="day-item'+(sort==parseInt(dayText.innerHTML)?' today':'')+'">'+(sort++)+'</div>';
                }
            }
        }

        //鼠标事件
        var dayItem=document.getElementsByClassName('day-item');
        var curDayItem=dayItem[date-1];
        for(var i=0;i<dayItem.length;i++){
            dayItem[i].onclick=function(e){
                window.event? window.event.cancelBubble = true : e.stopPropagation();
                this.setAttribute('class','day-item today');
                curDayItem.setAttribute('class','day-item');
                curDayItem=this;
                //改变日
                dayText.innerHTML=this.innerHTML;
                //改变星期
                var changeWeek=new Date(year,month-1,this.innerHTML);
                var curWeek=weekArr[changeWeek.getDay()];
                weekText.innerHTML=curWeek;
                calendar.setAttribute('data-date',resultDate());
            };
        }

    }
    function clearTd(){
        var tr=document.getElementsByClassName('dayLine');
        for(var i=0;i<tr.length;i++){
            for(var j= 0;j<7;j++){
                document.getElementsByClassName('dayLine')[i].getElementsByTagName('td')[j].innerHTML='';
            }
        }
    }

    //月份切换后确定哪一年星期几
    function resetDate(year,month,date){
        var reset=new Date(year,month,date);
        var week=weekArr[reset.getDay()];
        weekText.innerHTML=week;
        yearText.innerHTML=year;
        dayText.innerHTML=reset.getDate();
    }
    function resultDate(){
        var re=/\d+/;
        var date=yearText.innerHTML+'-'+re.exec(monthText.innerHTML)+'-'+dayText.innerHTML;
        return date;
    }

    //判断闰年
    function is_leap(year) {
        return (year%100==0?res=(year%400==0?1:0):res=(year%4==0?1:0));
    }

})();