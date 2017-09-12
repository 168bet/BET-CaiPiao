(function () {
    /**
     * 走势图函数
     * @param linkTag   连接标签类
     * @param digits    位数
     * @param container 定位容器
     */
    function Chart(linkTag, digits, container) {
        //需要连接的节点
        this.td = document.getElementsByClassName(linkTag);
        //节点的宽高
        this.tdW = document.getElementsByClassName(linkTag)[0].offsetWidth;
        this.tdH = document.getElementsByClassName(linkTag)[0].offsetHeight;
        //需要传的位数
        this.num = digits;
        this.container = container || 'trend';
        this.init();
    }

    Chart.prototype = {
        'init': function () {
            //调用函数返回归纳后的数组
            var that = this;
            var arr = this.createArr(that.num);
            //调用绘制方法
            for (var key in arr) {
                this.calculate(arr[key]);
            }
        },
        //位数归纳分类函数
        'createArr': function (num) {
            var arr = [];
            var obj = {};
            for (var i = 0; i < num; i++) {
                arr[i] = [];
            }
            for (var i = 0; i < this.td.length; i++) {
                switch (i % num) {
                    case 0:
                        arr[0].push(this.td[i]);
                        break;
                    case 1:
                        arr[1].push(this.td[i]);
                        break;
                    case 2:
                        arr[2].push(this.td[i]);
                        break;
                    case 3:
                        arr[3].push(this.td[i]);
                        break;
                    case 4:
                        arr[4].push(this.td[i]);
                        break;
                    case 5:
                        arr[5].push(this.td[i]);
                        break;
                    case 6:
                        arr[6].push(this.td[i]);
                        break;
                    case 7:
                        arr[7].push(this.td[i]);
                        break;
                    case 8:
                        arr[8].push(this.td[i]);
                        break;
                    case 9:
                        arr[9].push(this.td[i]);
                        break;
                    default:
                        return false;
                }
            }
            for (var i = 0; i < arr.length; i++) {
                obj[i] = arr[i];
            }
            return obj;
        },
        //计算canvas所需参数值
        'calculate': function (obj) {
            var w, h = this.tdH / 2, left, top, start = {}, end = {};
            for (var i = 0; i < obj.length - 1; i++) {
                if (obj[i + 1].offsetLeft) {//为了判断是否是最后一行
                    w = Math.abs(obj[i + 1].offsetLeft - obj[i].offsetLeft);
                    if (obj[i].offsetLeft < obj[i + 1].offsetLeft) {
                        left = obj[i].offsetLeft + this.tdW - 9;
                        top = obj[i].offsetTop + this.tdH - 5;
                        start.x = 0;
                        start.y = 0;
                        end.x = w;
                        end.y = h;
                    } else if (obj[i].offsetLeft > obj[i + 1].offsetLeft) {
                        left = obj[i + 1].offsetLeft + this.tdW - 9;
                        top = obj[i].offsetTop + this.tdH - 5;
                        start.x = 0;
                        start.y = h;
                        end.x = w;
                        end.y = 0;
                    } else {
                        left = obj[i].offsetLeft;
                        top = obj[i].offsetTop + this.tdH - 5;
                        w = this.tdW;
                        start.x = w / 2;
                        start.y = 0;
                        end.x = w / 2;
                        end.y = h;
                    }
                }
                this.create(w, h, left, top, start, end);
            }
        },
        //创建canvas
        'create': function (w, h, left, top, start, end) {
            //表格外部容器
            var container = document.getElementsByClassName(this.container)[0];
            if (container === undefined) {
                return false;
            }
            var canvas = document.createElement('canvas');
            canvas.width = w || 0;
            canvas.height = h;
            canvas.style.cssText = 'position:absolute;left:' + left + 'px;top:' + top + 'px';
            container.appendChild(canvas);
            var ctx = canvas.getContext('2d');
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#747474';
            ctx.moveTo(start.x, start.y);
            ctx.lineTo(end.x, end.y);
            ctx.stroke();
        }
    };
    window['Chart'] = Chart;
})();