var curTime_ = new Date().getTime();
var a = {
		ssq_tab : $('#ssq_tab')
};
var Xhc = {
		//初始化各种数据的方法
		init_info:function(){
			Xhc.miss();
			Xhc.bindEve();
		},
		bindEve:function(){
			var l = $('.downline').offset().left;
			$('.clearfix li').click(function(){
				var liindex = $('.clearfix li').index(this);
				$(this).addClass('cur').siblings().removeClass('cur');
				$("#pt_buyChoice cite").removeClass("wei_");
				var liWidth = $(this).width();
				$('.downline').stop(false,true).animate({'left' : liindex * liWidth+l + 'px'},300);
				var PlayID = $(this).attr("PlayID");
				if(PlayID==1){
					$("#cpttz").show();
					$("#cdttz").hide();
					Xhc.countMoney();
					Xhc.addColor();
				}else{
					$("#cpttz").hide();
					$("#cdttz").show();
					Xhc.dcountMoney();
					Xhc.addColor();
				}
			});
			$("#shake").click(function(){
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
				$(this).toggleClass("red").toggleClass("gray");
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
				var RedBallValue = Xhc.selectRedBallValue();
				$("#RedBallValue").attr("value",RedBallValue);
				Xhc.countMoney();
				Xhc.addColor();
			});
			
			//选择篮球
			$("#xzlq .ssqBall cite").bind("click",function(){
				$(this).toggleClass("blueBall");
				var BlueBallValue = Xhc.selectBlueBallValue();
				if(BlueBallValue=="NaN"){
					BlueBallValue="";
				}
				$("#BlueBallValue").attr("value",BlueBallValue);
				Xhc.countMoney();
				Xhc.addColor();
			});
			//胆码选择红球
			//选择篮球
			$("#dxzhq cite").bind("click",function(){
				$(this).toggleClass("redBall");
				
				//如果选中的球的个数大于5，则不能继续选择
				if($("#dxzhq cite.redBall").length>5){
					$(this).removeClass("redBall");
					D.alert("最多只能选择5个红球");
				}
				
				//去除重复值
				var tselectredBall = $("#txzhq cite.redBall");
				var dText = $(this).text();//获取当前点击脱码区的值
				for(var k=0;k<tselectredBall.length;k++){
					if(dText==$(tselectredBall[k]).text()){
						$(tselectredBall[k]).removeClass("redBall");
					}
				}
			
				if($("#txzhq cite.redBall").length==0){
					$("#tRedBallValue").val("");
				}else{
					var tRedBallValue = Xhc.tselectRedBallValue();
					$("#tRedBallValue").attr("value",tRedBallValue);
				}
				
				if($("#dxzhq cite.redBall").length==0){
					$("#dRedBallValue").val("");
					//dcountMoney();
				}else{
					var dRedBallValue = Xhc.dselectRedBallValue();
					$("#dRedBallValue").attr("value",dRedBallValue);
				}
				Xhc.dcountMoney();
				Xhc.addColor();
			});
			//将选中的脱码区红球设置为隐藏域中的变量值
			$("#txzhq cite").bind("click",function(){
				$(this).toggleClass("redBall");
				//如果选中红球数大于20不能继续选择
				if($("#txzhq cite.redBall").length>20){
					$(this).removeClass("redBall");
					D.alert("最多只能选择20个红球");
				}
				//去除重复
				var dselectredBall = $("#dxzhq cite.redBall");
				var tText = $(this).text();//获取当前点击脱码区的值
				for(var k=0;k<dselectredBall.length;k++){
					if(tText==$(dselectredBall[k]).text()){
						$(dselectredBall[k]).removeClass("redBall");
					}
				}
				
				if($("#txzhq cite.redBall").length==0){
					$("#tRedBallValue").val("");
				}else{
					var tRedBallValue = Xhc.tselectRedBallValue();
					$("#tRedBallValue").attr("value",tRedBallValue);
				}
				
				
				if($("#dxzhq cite.redBall").length==0){
					$("#dRedBallValue").val("");
				}else{
					var dRedBallValue = Xhc.dselectRedBallValue();
					$("#dRedBallValue").attr("value",dRedBallValue);
				}
				Xhc.dcountMoney();
				Xhc.addColor();
			});
			//将选中的胆拖篮球设置为隐藏域中的变量值
			$("#dtxzlq cite").Touch(function(){
				$(this).toggleClass("blueBall");
				if($("#dtxzlq cite.blueBall").length==0){
					$("#dtBlueBallValue").val("");
				}else{
					var dtBlueBallValue = Xhc.dtselectBlueBallValue();
					$("#dtBlueBallValue").attr("value",dtBlueBallValue);
				}
				Xhc.dcountMoney();
				Xhc.addColor();
			});
			//点击"确认"提交
			$(".ture").bind("click",function(){
				var redValue = $("#RedBallValue").val();
				var blueValue = $("#BlueBallValue").val();
				
				var dredValue = $("#dRedBallValue").val();
				var tblueValue = $("#tRedBallValue").val();
				var dtblueValue = $("#dtBlueBallValue").val();
				
				var nt = $("#countNotes").text();
				var sm = $("#countMoney").text();
				
				var PlayID = a.ssq_tab.find('.cur').attr('PlayID');
				if(PlayID=="1"){
					if(nt==0 || sm==0){
						D.tx("请至少选择6个红球,1个蓝球");
						return false;
					}
					if(redValue && blueValue){
						var redCountArr = redValue.split(",");
						var redCountLen = redCountArr.length;
						
						var blueCountArr = blueValue.split(",");
						var blueCountLen = blueCountArr.length;
						if(redCountLen>5 && blueCountLen>0){
							var k = localStorage.getItem("ssq");
							if(!k){
								localStorage.setItem("ssq", redValue+"|"+blueValue);
							}else{
								localStorage.setItem("ssq", k+"#"+redValue+"|"+blueValue);
							}
							window.location.href="#class=url&xo=ssq/ture.html";
						}else{
							D.tx("请至少选择6个红球,1个蓝球");
						}
					}else{
						D.tx("请至少选择7个红球,1个蓝球");
					}	
				}else{
					if(nt==0 || sm==0){
						D.tx("请至少选择7个红球,1个蓝球");
						return false;
					}
					if(dredValue && tblueValue && dtblueValue){
						var dredCountArr = dredValue.split(",");
						var dredCountLen = dredCountArr.length;
						var tredCountArr = tblueValue.split(",");
						var tredCountLen = tredCountArr.length;
						var dtblueCountArr = dtblueValue.split(",");
						var dtblueCountLen = dtblueCountArr.length;
						var k = localStorage.getItem("ssq");
						if(!k){
							localStorage.setItem("ssq", dredValue+"|"+tblueValue+"|"+dtblueValue);
						}else{
							localStorage.setItem("ssq", k+"#"+dredValue+"|"+tblueValue+"|"+dtblueValue);
						}
						window.location.href="#class=url&xo=ssq/ture.html";
					}else{
						D.tx("请至少选择6个红球,1个篮球");
					}	
				}
			});
			
			$(".ssqdeleted").click(function(){
				Xhc.clean();
			});
		},clean : function () {
			var Pid = a.ssq_tab.find('.cur').attr('PlayID');
			if(Pid=="1"){
				$("#xzhq .ssqBall cite").removeClass("redBall");
				$("#xzlq .ssqBall cite").removeClass("blueBall");
				$("#BlueBallValue").attr("value",'');
				$("#RedBallValue").attr("value",'');
				$("#countNotes").html(0);
		        $("#countMoney").html(0);
				$("#pt_buyChoice cite").removeClass("wei_");
			}else{
				$("#dxzhq cite").removeClass("redBall");
				$("#txzhq cite").removeClass("redBall");
				$("#dtxzlq cite").removeClass("blueBall");
				$("#dtBlueBallValue").attr("value","");
				$("#tRedBallValue").attr("value","");
				$("#dRedBallValue").attr("value","");
				$("#countNotes").html(0);
		        $("#countMoney").html(0);
			}
			Xhc.addColor();
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
				url : '/trade/info.go?gid=01',
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("rows");
					var pid = R.attr('pid');//期次
					pid = pid.substr(-3);
					var atime = R.attr('atime');//开奖时间
					$('.p5kj div').eq(0).html(pid+'期  '+atime.substring(5,16)+'截止 ');
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
							//t +='<li class="last"><span class='+tmp+'><cite></cite>'+st+'</span></li>';
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
			redBall = Xhc.reSort(redBall.substring(0, redBall.length-1));
			return redBall;
		},
		
		//选择篮球的值
		selectBlueBallValue:function(){
			var blueBall="";
			$("#xzlq .ssqBall cite.blueBall").each(function(){
				blueBall+=$(this).text()+",";
			});
			blueBall = Xhc.reSort(blueBall.substring(0, blueBall.length-1));
			return blueBall;
		},
		//选择胆码区红区域的值
		dselectRedBallValue:function(){
			var dredBall="";
			$("#dxzhq cite.redBall").each(function(){
				dredBall+=$(this).text()+",";
				
			});
			dredBall = Xhc.reSort(dredBall.substring(0, dredBall.length-1));
			return dredBall;
		},
		//选择脱码区红球域的值
		tselectRedBallValue:function(){
			var tredBall="";
			$("#txzhq cite.redBall").each(function(){
				tredBall+=$(this).text()+",";
			});
			tredBall = Xhc.reSort(tredBall.substring(0, tredBall.length-1));
			return tredBall;
		},
		//选择胆拖篮球球的值
		dtselectBlueBallValue:function(){
			var dtblueBall="";
			$("#dtxzlq cite.blueBall").each(function(){
				dtblueBall+=$(this).text()+",";
				
				
			});
			dtblueBall = Xhc.reSort(dtblueBall.substring(0, dtblueBall.length - 1));
			return dtblueBall;
		},
		//计算金钱数
		//普通计算金钱
		countMoney:function() {
		    var varcount = Xhc.countNotes();
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
		            varNotes = Xhc.count(rebcount,6) * Xhc.count(bluecount,1);
		            
		        }
		    return varNotes;
		},
		//胆拖计算金钱
		dcountMoney:function() {
			var varcount = Xhc.dtcountNotes();
		    if(varcount > 0) {
		        var varmoney = varcount * 2;
		        $("#countNotes").html(varcount);
		        $("#countMoney").html(varmoney);
		    }else{
		        $("#countNotes").html(0);
		        $("#countMoney").html(0);
		    }
		},
		//胆拖计算注数
		dtcountNotes:function() {
			var varNotes = 0;
			var dRedBallValue = $("#dRedBallValue").attr("value");
			var tRedBallValue = $("#tRedBallValue").attr("value");
			var dtBlueBallValue = $("#dtBlueBallValue").attr("value");
		        if (dRedBallValue != "" && tRedBallValue != "" && dtBlueBallValue != ""){
		            var drebcount = $("#dRedBallValue").attr("value").toString().split(/\,/gi).length;
		            var trebcount = $("#tRedBallValue").attr("value").toString().split(/\,/gi).length;
		            var bluecount = $("#dtBlueBallValue").attr("value").toString().split(/\,/gi).length;
		            if(drebcount + trebcount >=7){
		            	varNotes = Xhc.count(trebcount,6-drebcount) * Xhc.count(bluecount,1);
		            }
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

		    arr.sort(Xhc.sortIntArrayAsc);
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
		}
};
function red_scale(redNum_,selectlength_r){
	$("#xzlq .ssqBall cite").removeClass("cur")
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
    var maxlength_b = 16;
    var blueNum = Random(maxlength_b);
       $("#BlueBallValue").attr("value", "");
       var bluevalue = ""; 
       bluevalue += (blueNum[0] < 10 ? "0" + blueNum[0].toString() : blueNum[0]);
       setTimeout(function(){
    	   $("#xzlq .ssqBall cite").eq(blueNum[0]-1).addClass("blueBall wei_");
	   },100);
       $("#BlueBallValue").attr("value", bluevalue);
       Xhc.countMoney();
       Xhc.addColor();
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
	        var selectlength_r = '6';//双色球红球必选6个
	        var maxlength_r = '33';//双色球红球有33个
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
Xhc.init_info();