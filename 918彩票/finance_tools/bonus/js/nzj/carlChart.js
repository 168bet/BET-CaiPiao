/**
 * create by carl 20160122
 */
;(function(window){
	var CarlChart = {
		drawPie: function(ctx,option, data){
			var w = ctx.canvas.width;//canvas width;
			var h = ctx.canvas.height;//canvas height;
			ctx.clearRect(0, 0, w, h); // clear canvas
			
			var options = {
					font: option.font || "10px serif",//注释字体
					lineLength: option.lineLength || 20,//直线长度
					r: option.r || Math.ceil(h/4)//半径
			};
			
			var valueSum = 0;//总量，用于计算百分比
			for(var i = 0; i < data.length; i++){
				var d = data[i];
				valueSum += Number(d.value);
			}
			
			var radius = options.r;//半径
			var arcc = {x: w/2, y: h/2};//圆心
			
			
			var start = 1;//初始值
			var duration = 20;//持续时间
			var angleStart = 0;//弧度
			var angleEnd = 0;//弧度
			var _run = function(){
				var a1=0;//弧度
				var a2=0;//弧度
				ctx.clearRect(0, 0, w, h); // clear canvas
				ctx.save();
				ctx.translate(arcc.x,arcc.y);//平移画布坐标
				for(var i = 0; i < data.length; i++){
					var d = data[i];
					angleStart = angleEnd;
					angleEnd = angleStart + Math.PI * 2 * d.value/valueSum ;//弧度
					a1 = a2;
					ctx.fillStyle = d.color;
					ctx.strokeStyle = '#fff';
					ctx.lineWidth = 2;
					//开始画弧度
					ctx.beginPath();
					ctx.moveTo(0, 0);//移动到圆心
					a2 = (a1 + start/duration * Math.PI * 2 * d.value/valueSum);
					
				  	ctx.arc(0, 0,radius,a1 - Math.PI/2, a2 - Math.PI/2);
				  	ctx.closePath();
					ctx.fill();
					ctx.stroke();
					
					ctx.strokeStyle = d.color;
					if(start >= duration){//状态圆满后加注释
						//开始画注释指引线条
						ctx.beginPath();
						var a = ((angleEnd-angleStart)/2 + angleStart - Math.PI/2);//弧度
						var x = radius * Math.cos(a);
						var y = radius * Math.sin(a);
						var lineLength = options.lineLength;
						var lx = x > 0 ? x + lineLength : x - lineLength;
						var ly = y > 0 ? y + 5 : y - 5;
						ctx.moveTo(x, y);
						ctx.lineTo(lx, ly);
						ctx.closePath();
						ctx.stroke();
						//开始写注释
						ctx.fillStyle = 'black';
						ctx.font = options.font;
						ctx.textAlign = x > 0 ? "left" : 'end';
						var txVal = d.label + '('+(100*d.value/valueSum).toFixed(2)+'%)';
						ctx.fillText(txVal , x > 0 ? lx + 5 : lx - 5, ly - Math.ceil(parseInt(options.font)/2));
						txVal = d.value + ' ' + d.unit;
						ctx.fillText(txVal, x > 0 ? lx + 5 : lx - 5 , ly + Math.ceil(parseInt(options.font)/2));
					}
				};
				start ++;
				ctx.restore();
				if(start <= duration){
					setTimeout(_run,20);
				}
			}
			_run();
		}
	};
	window.CarlChart = CarlChart;
})(window);
