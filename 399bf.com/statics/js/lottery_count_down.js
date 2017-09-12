    // 倒计时
$('#countdown').ClassyCountdown({

    //结束时间戳
    end: uptime,
    //现在时间戳
    now: time,


    labels: true,
    labelsOptions: {
        lang: {
            days: '天',
            hours: '时',
            minutes: '分',
            seconds: '秒'
        },
        style: 'font-size:12px;font-weight:normal; text-transform:uppercase;color:#bbbbbb'
    },
    style: {
        element: "",
        textResponsive: .5,
        days: {
            gauge: {
                thickness: .2,
                bgColor: "rgba(255,255,255,1)",
                fgColor: "rgb(255, 162, 29)"
            },
            textCSS: 'font-size:14px; font-weight:800; color:#7f7f7f;'
        },
        hours: {
            gauge: {
                thickness: .2,
                bgColor: "rgba(255,255,255,1)",
                fgColor: "rgb(255, 162, 29)"
            },
            textCSS: 'font-size:14px; font-weight:800; color:#7f7f7f;'
        },
        minutes: {
            gauge: {
                thickness: .2,
                bgColor: "rgba(255,255,255,1)",
                fgColor: "rgb(255, 162, 29)"
            },
            textCSS: 'font-size:14px; font-weight:800; color:#7f7f7f;'
        },
        seconds: {
            gauge: {
                thickness: .2,
                bgColor: "rgba(255,255,255,1)",
                fgColor: "rgb(255, 162, 29)"
            },
            textCSS: 'font-size:14px; font-weight:800; color:#7f7f7f;'
        }

    },
    onEndCallback: function() {
        console.log("Time out!");
    }
});