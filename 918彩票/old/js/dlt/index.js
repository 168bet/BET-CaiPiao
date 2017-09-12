var curTime_ = new Date().getTime();
var Dlt = {
		//初始化各种数据的方法
		init_info:function(){
			Dlt.miss();
			Dlt.bindEve();
		},
		bindEve:function(){
			$("#shake").bind("click",function(){
				machineSelect();
			});
			//右上角菜单显示或隐藏
			$("#pullIco").click(function(){
					if($("#pullText").is(':hidden')){
						$("#tm_c").show();
					}else{
						$("#tm_c").hide();
					}
					$(this).parent().toggleClass("pullHover");
					$("#pullText").toggle();
			});
			
			$("#lskj").bind("click",function(){
				$(this).find("em").toggleClass("ssqdown");
				$(".ssqkjlist").slideToggle(200);
			});
			//点击遗漏值的按钮开关
			$("#yl").bind("click",function(){
				$(this).toggleClass("red").toggleClass("gray");;
				$("#xzhq .omitnum").toggle();
				$("#xzlq .omitnum").toggle();
				$("#ylz").toggle();
				$(this).find("em").toggleClass("omitico2");
			});
			//选择红球
			$("#xzhq .ssqBall cite").bind("click",function(){
				$(this).toggleClass("redBall");
				//红球数量大于20
				if($("#xzhq .ssqBall cite.redBall").length>20){
					$(this).removeClass("redBall");
					D.alert("最多只能选择20个红球");
				}
				var RedBallValue = Dlt.selectRedBallValue();
				$("#RedBallValue").attr("value",RedBallValue);
				Dlt.countMoney();
				Dlt.addColor();
			});
			
			//选择篮球
			$("#xzlq .ssqBall cite").bind("click",function(){
				$(this).toggleClass("blueBall");
				var BlueBallValue = Dlt.selectBlueBallValue();
				if(BlueBallValue=="NaN"){
					BlueBallValue="";
				}
				$("#BlueBallValue").attr("value",BlueBallValue);
				Dlt.countMoney();
				Dlt.addColor();
			});
			
			//点击"确认"提交
			$(".ture").bind("click",function(){
				var redValue = $("#RedBallValue").val();
				var blueValue = $("#BlueBallValue").val();
				
				
				var nt = $("#countNotes").text();
				var sm = $("#countMoney").text();
				if(nt==0 || sm==0){
					D.tx("至少选择5个红球,2个篮球");
					return false;
				}
				
				if(redValue && blueValue){
					var redCountArr = redValue.split(",");
					var redCountLen = redCountArr.length;
					
					var blueCountArr = blueValue.split(",");
					var blueCountLen = blueCountArr.length;
					if(redCountLen>4 && blueCountLen>1){
						var k = localStorage.getItem("dlt");
						if(!k){
							localStorage.setItem("dlt", redValue+"|"+blueValue);
						}else{
							localStorage.setItem("dlt", k+"#"+redValue+"|"+blueValue);
						}
						window.location.href="#class=url&xo=dlt/ture.html";
					}else{
						D.tx("请选择正确的投注格式");
					}
				}else{
					D.tx("请选择正确的投注格式");
				}	
			});
			
			$(".ssqdeleted").click(function(){
				Dlt.clean();
			});
		},clean : function () {
			$("#xzhq .ssqBall cite").removeClass("redBall");
			$("#xzlq .ssqBall cite").removeClass("blueBall");
			$("#BlueBallValue").attr("value",BlueBallValue);
			$("#RedBallValue").attr("value",RedBallValue);
			$("#countNotes").html(0);
	        $("#countMoney").html(0);
	        $('.wei_').removeClass("wei_");
			Dlt.addColor();
		},miss:function(){
			var t = '';
			$.ajax({
		        url: "/user/mchklogin.go",
		        type: "POST",
		        success:function (data){
		     	    var R = $(data).find("Resp");
		 			var code = R.attr("code");
		 			if (code == "10001") {
		 				t = '1';
		 			}else{
		 				t = '';
		 			}
		        }
			});
			
			
		
			$.ajax({//红球遗漏
				url : '/trade/info.go?gid=50',
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("rows");
					var pid = R.attr('pid');//期次
					pid = pid.substr(-3);
					var atime = R.attr('atime');//开奖时间
					$('.p5kj div').eq(0).html(pid+'期  '+atime.substring(5,16)+'截止');
					var rowp = R.find("rowp");
					var t = "";
					
					for(var i=0;i<rowp.length;i++){
						if(i<10){
							var tmpid = $(rowp[i]).attr("pid");//期次
							tmpid = tmpid.substr(-3);
							var tn = $(rowp[i]).attr("tn");//中奖信息
							//var tmp = (tn=="10"?"zjbtn":"wzjbtn");
							//var st = (tn=="10"?"中奖":"未中");
							var acode = $(rowp[i]).attr("acode");
							var acodeArr = acode.split("|");
							var acode0 = acodeArr[0].replace(/,/g," ");
							var acode1 = acodeArr[1].replace(/,/g," ");
							t +='<ul>';
							t +='<li class="first">'+tmpid+'期</li>';
							t +='<li><span class="red">'+acode0+'</span>  <span class="blue">'+acode1+'</span></li>';
							if(t){
								if(tn=="10"){
									t +='<li class="last"><span class="zjbtn"><cite></cite>中奖</span></li>';
								}else if(tn=="9"){
									t +='<li class="last"><span class="wzjbtn"><cite></cite>未中</span></li>';
								}else{
									t += "";
								}
							}else{
								t+="";
							}
							
			            	t +='</ul>';
						}
					}
					
					
					$(".ssqkjlist").html(t);
					var r = R.find('row');
					r.each(function() {
						var rhtml = '';
						var bhtml = '';
						var curyl = $(this).attr("curyl");
						var yl = curyl.split(',');
						var color = $(this).attr('color');
						if(color == 'red'){
							for(var j=0;j<yl.length;j++){
								rhtml += '<cite>'+yl[j]+'</cite>';
							}
							$("#xzhq .omitnum").html(rhtml);
						}
						if(color == 'blue'){
							for(var j=0;j<yl.length;j++){
								bhtml += '<cite>'+yl[j]+'</cite>';
							}
							$("#xzlq .omitnum").html(bhtml);
						}
					});
				},
				error : function() {
					return false;
				}
			});
		},
		//选择红球的值
		selectRedBallValue:function(){
			var redBall="";
			$("#xzhq .ssqBall cite.redBall").each(function(){
				redBall+=$(this).text()+",";
				
			});
			redBall = Dlt.reSort(redBall.substring(0, redBall.length-1));
			return redBall;
		},
		
		//选择篮球的值
		selectBlueBallValue:function(){
			var blueBall="";
			$("#xzlq .ssqBall cite.blueBall").each(function(){
				blueBall+=$(this).text()+",";
			});
			blueBall = Dlt.reSort(blueBall.substring(0, blueBall.length-1));
			return blueBall;
		},
		
		//计算金钱数
		//普通计算金钱
		countMoney:function() {
		    var varcount = Dlt.countNotes();
		    if (varcount > 0) {
		        var varmoney = varcount * 2;
		        $("#countNotes").html(varcount);
		        
		        $("#countMoney").html(varmoney);
		    }
		    else {
		        $("#countNotes").html(0);
		        $("#countMoney").html(0);
		    }
		},
		//普通计算注数
		countNotes:function() {
			var varNotes = 0;
			var redValue = $("#RebBallValue").attr("value");
			var blueValue = $("#BlueBallValue").attr("value");
		        if (redValue != "" && blueValue != "") {
		            var rebcount = $("#RedBallValue").attr("value").toString().split(/\,/gi).length;
		            var bluecount = $("#BlueBallValue").attr("value").toString().split(/\,/gi).length;
		            varNotes = Dlt.count(rebcount,5) * Dlt.count(bluecount,2);
		            
		        }
		    return varNotes;
		},
		
		//普通计算注数
		count:function(numlength, more) {
		    var m = 1, n = 1;
		    while (more >= 1) {
		        m *= numlength;
		        n *= more;
		        numlength--;
		        more--;
		    }
		    return m / n;
		},
		//连接红球和篮球的值组成一个local对象的值
		//重新排序
		reSort:function(s_numberList) {
		    var newNum = "";
		    var arr = new Array();
		    for (var j = 0; j < s_numberList.split(',').length; j++)
		        arr[j] = parseInt(s_numberList.split(',')[j], 10);

		    arr.sort(Dlt.sortIntArrayAsc);
		    for (var k = 0; k < arr.length; k++) {
		        if (parseInt(arr[k]) < 10)
		            newNum += "0" + arr[k] + ",";
		        else
		            newNum += arr[k] + ",";
		    }
		    newNum = newNum.substring(0, newNum.length - 1);
		    var item = newNum.split(',');
		    //判断前区是否重复
		    for (var j = 0; j < item.length - 1; j++) {
		        for (var c = j + 1; c < item.length; c++) {
		            if (item.length == c)
		                break;
		            if (item[j] == item[c]) {
		                alert("单注单个号码不能重复两次");
		                return "";
		            }
		        }
		    }
		    return newNum;
		},
		//数组排序 升序
		sortIntArrayAsc:function(a, b) {
		  if (isNaN(a) || isNaN(b)) return a.localeCompare(b);
		  else return parseInt(a) - parseInt(b);
		},
		//数组排序 降序
		sortIntArrayDesc:function(a, b) {
		  if (isNaN(a) || isNaN(b)) return b.localeCompare(a);
		  else return parseInt(b) - parseInt(a);
		},
		addColor:function(){
			var n = $_Y.getInt($("#countNotes").text());
			if(n>0){
				$("#countNotes").addClass("red");
				$("#countNotes").next().addClass("red");
			}else{
				$("#countNotes").removeClass("red");
				$("#countNotes").next().removeClass("red");
			}
		},
		checkLog:function(){
			$.ajax({
		        url: "/user/mchklogin.go",
		        type: "POST",
		        success:function (data){
		     	    var R = $(data).find("Resp");
		 			var code = R.attr("code");
		 			if (code == "10001") {
		 				return 1;
		 			}else{
		 				return 2;
		 			}
		        }
			});
		}
};
function red_scale(redNum_,selectlength_r){
    if(nn<selectlength_r) {
    	var redvalue = "";
    	redvalue += (redNum_[nn] < 10 ? "0" + redNum_[nn].toString() : redNum_[nn]);
    	if (redvalue != "") {
    		if($("#RedBallValue").val() == ''){
    			$("#RedBallValue").val(redvalue);
    		}else{
    			redvalue = $("#RedBallValue").val()+','+redvalue;
    			$("#RedBallValue").val(redvalue);
    		}
        }
	   setTimeout(function(){
		   $("#xzhq .ssqBall cite").eq(redNum_[nn]-1).addClass("redBall wei_");
		   nn++;
		   red_scale(redNum_,selectlength_r);
	   },100);
    }else{
	 //机选篮球
    var maxlength_b = 12;
    var blueNum = Random(maxlength_b);
       $("#BlueBallValue").attr("value", "");
       var bluevalue = ""; 
       bluevalue += (blueNum[0] < 10 ? "0" + blueNum[0].toString() : blueNum[0])+",";
       setTimeout(function(){
    	   $("#xzlq .ssqBall cite").eq(blueNum[0]-1).addClass("blueBall wei_");
	   },100);
       bluevalue += (blueNum[10] < 10 ? "0" + blueNum[10].toString() : blueNum[10]);
       setTimeout(function(){
    	   $("#xzlq .ssqBall cite").eq(blueNum[10]-1).addClass("blueBall wei_");
	   },200);
       bluevalue=bluevalue.split(",").sort(function(a,b){return a-b}).join(",");
       $("#BlueBallValue").attr("value", bluevalue);
       Dlt.countMoney();
       Dlt.addColor();
   }
   
}
//random
function machineSelect() {
	curTime_2 = new Date().getTime();
	if(curTime_2-curTime_ > '1000'){
		try{
			navigator.vibrate(300);
		}catch(e){};
			nn = 0;
			//机选红球
	        var selectlength_r = '5';//双色球红球必选6个
	        var maxlength_r = '35';//双色球红球有33个
	        var redNum = Random(maxlength_r);//打乱顺序之后的33个红球
	    	$("#xzhq .ssqBall cite").removeClass("redBall");
	    	$("#xzlq .ssqBall cite").removeClass("blueBall");
	    	$("#pt_buyChoice cite").removeClass("wei_");
	    	
	        $("#RedBallValue").attr("value", "");
	        var redNum_ = [];
	        for (var i = 0; i < selectlength_r; i++) {
	            redNum_[i] = redNum[i+i*2];
	        }
	       
	        redNum_.sort(function(a,b){return a>b?1:-1;});
	        red_scale(redNum_,parseInt(selectlength_r));
	        curTime_ = new Date().getTime();
	}
}

//生成随机数
function Random(count) {
    var original = new Array; //原始数组 
    //给原始数组original赋值 
	for (var i = 0; i < count; i++) {
        original[i] = i + 1;
    }
    original.sort(function() { return 0.5 - Math.random(); });
    var arrayList = new Array();
    for (var i = 0; i < count; i++) {
        arrayList[i] = original[i];
    }
    return arrayList;
}
Dlt.init_info();