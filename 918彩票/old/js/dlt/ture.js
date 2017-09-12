var Dlt_t={
		sum:"",
		//初始化信息
		init_info:function(){
			var callbacks = $.Callbacks();
			callbacks.add(Dlt_t.loadCont);
			callbacks.add(Dlt_t.loadFun);
			callbacks.add(Dlt_t.bindEvent);
			callbacks.fire();
		},
		//加载内容
		loadCont:function(){
			this.sum=new Array();
			var html="";
			var dlt = localStorage.getItem("dlt");
			if(!dlt) return;
			
			var dltArr = dlt.split("#");
			var len=dltArr.length;
			for(var i=0;i<len;i++){
				var arr = dltArr[i].split("|");
				if(arr.length==2){
					var redValue = arr[0].replace(/,/g," ");
					var blueValue = arr[1].replace(/,/g," ");
					var rArr = arr[0].split(",");
					var bArr = arr[1].split(",");
					var n = CC.count_Money(rArr,bArr);
					var m = n*2;
					html += '<div class="ssqtzNum">';
					html += '<cite class="errorBg"><em class="error2"></em></cite>';
					html += '<span><em>'+redValue+'</em><cite>'+blueValue+'</cite></span>';
					html += '<p>普通投注&nbsp;&nbsp;&nbsp;'+n+'注'+m+'元</p>';
					html += '</div>';
					this.sum.push(n);
				}
			}
			$(".ssqNum").html(html);
			Dlt_t.loadMoney();
			//删除单个的项
			$(".error2").bind("click",function(){
				$(this).parents("div.ssqtzNum").remove();
				var str = Dlt_t.joinValue();
				localStorage.setItem("dlt",str);
				Dlt_t.loadMoney();
			});
		},
		loadFun:function(){
			if($_Y.getInt($("input[name='qs']").val())==0){
				$(".zjStop").hide();
			}else if($_Y.getInt($("input[name='qs']").val())>1){
				if($_Y.getInt($("input[name='qs']").val())<=154){
					$(".fqhm").attr("disabled",true);
					$(".fqhm").addClass("fqhmGray");
					$(".fqhm").removeClass("fqhm");
					$(".zjStop").show();
					$(".ssqzh").show();
				}else{
					D.alert("最多只能追154期",function(){
						$("input[name='qs']").val("154");
						$(".ssqzh").show();
						$(".fqhm").attr("disabled",true);
						Dlt_t.loadMoney();
					});
				}
				
			}else if($_Y.getInt($("input[name='qs']").val())==1){
				$("#fqhm").attr("disabled",false);
				$("#fqhm").removeClass("fqhmGray");
				$("#fqhm").addClass("fqhm");
				$(".zjStop").hide();
				$(".ssqzh").hide();
			}
			Dlt_t.loadMoney();
		},
		//绑定事件
		bindEvent:function(){
			//倍数变化的时候钱数变化
			$("input[name='bs']").bind("keyup",function(){
				var val = $(this).val();
				var reg = /^\d*$/;
				if( !reg.test(val)){
		            $(this).val("1");
		        }
				if(val.indexOf("0")==0){
					 $(this).val("1");
				}
				if($_Y.getInt($("input[name='bs']").val())>999){
					D.alert("最多只能投999倍",function(){
						$("input[name='bs']").val("999");
						Dlt_t.loadMoney();
					});
				}
				Dlt_t.loadMoney();
			});
			//期数变化的时候钱数变化
			$("input[name='qs']").bind("keyup",function(){

				var val = $(this).val();
				var reg = /^\d*$/;
				if(!reg.test(val)){
		            $(this).val("1");
		        }
				if(val.indexOf("0")==0){
					 $(this).val("1");
					 $(".fqhm").removeClass("fqhmGray");
				}
				
				if($_Y.getInt($("input[name='qs']").val())==0){
					$(".zjStop").hide();
				}else if($_Y.getInt($("input[name='qs']").val())>1){
					if($_Y.getInt($("input[name='qs']").val())<=154){
						$("#fqhm").attr("disabled",true);
						$("#fqhm").addClass("fqhmGray");
						$(".zjStop").show();
						$(".ssqzh").show();
					}else{
						D.alert("最多只能追154期",function(){
							$("input[name='qs']").val("154");
							$(".ssqzh").show();
							$(".fqhm").attr("disabled",true);
							Dlt_t.loadMoney();
						});
					}
				}else if($_Y.getInt($("input[name='qs']").val())==1){
					$("#fqhm").attr("disabled",false);
					$("#fqhm").removeClass("fqhmGray");
					$("#fqhm").addClass("fqhm");
					$(".zjStop").hide();
					$(".ssqzh").hide();
				}
				Dlt_t.loadMoney();
			});
			//清空列表
			$("#clearAll").bind("click",function(){
				localStorage.removeItem("dlt");
				$(".ssqNum").html("");
				D.tx("请至少选择一注进行投注")
				Dlt_t.loadMoney();
			});
			//期数增加
			$(".qplus").bind("click",function(){
				$(".ssqzh li").removeClass("cur");
				var p = $_Y.getInt($("input[name='qs']").val());
				p++;
				$("input[name='qs']").val(p);
				Dlt_t.loadMoney();
				if($("input[name='qs']").val()==1){
					$(".zjStop").hide();
					$(".ssqzh").hide();
					$(".fqhm").attr("disabled",false);
					$(".fqhm").removeClass("fqhmGray");
				}else if($("input[name='qs']").val()>1 && $("input[name='qs']").val()<155){
					$(".zjStop").show();
					$(".ssqzh").show();
					$(".fqhm").attr("disabled",true);
					$(".fqhm").addClass("fqhmGray");
				}else{
					D.tx("最多只能追154期",function(){
						$("input[name='qs']").val("154");
						$(".ssqzh").show();
						Dlt_t.loadMoney();
					});
				}
			});
			//期数减少
			$(".qminus").bind("click",function(){
				$(".ssqzh li").removeClass("cur");
				var p = $_Y.getInt($("input[name='qs']").val());
				p--;
				if(p<1){
					p=1;
					$("#fqhm").removeClass("fqhmGray");
				}
				$("input[name='qs']").val(p);
				Dlt_t.loadMoney();
				if($("input[name='qs']").val()==1){
					$(".zjStop").hide();
					$(".ssqzh").hide();
					$("#fqhm").removeClass("fqhmGray");
					$("#fqhm").removeAttr("disabled");
				}else{
					$(".zjStop").show();
					$(".ssqzh").show();
					$("#fqhm").attr("disabled",true);
				}
			});
			//倍数增加
			$(".bplus").bind("click",function(){
				var b = $_Y.getInt($("input[name='bs']").val());
				b++;
				$("input[name='bs']").val(b);
				if($_Y.getInt($("input[name='bs']").val())>999){
					D.alert("最多只能投999倍",function(){
						$("input[name='bs']").val("999");
						Dlt_t.loadMoney();
					});
				}
				Dlt_t.loadMoney();
			});
			//倍数减少
			$(".bminus").bind("click",function(){
				var b = $_Y.getInt($("input[name='bs']").val());
				b--;
				if(b<1){
					b=1;
				}
				$("input[name='bs']").val(b);
				Dlt_t.loadMoney();
			});
			//机选一注方法
			$("#jxbtn").bind("click",function(){
				CC.machineSelect();//机选方法
				
				var dlt = localStorage.getItem("dlt");
				if(!dlt){
					dlt="";
					var jxred = $("#Red_BallValue").val();
					var tjxred = jxred.replace(/,/g," ");
					tjxred = $.trim(tjxred);
					
					var jxblue = $("#Blue_BallValue").val();
					var tjxblue = jxblue.replace(/,/g," ");//将字符串中所有的","用空格代替
					tjxblue = $.trim(tjxblue);
					
					var tmpstr = dlt+"#"+jxred+"|"+jxblue;
					localStorage.setItem("dlt",tmpstr.substring(1, tmpstr.length));
				}else{
					var jxred = $("#Red_BallValue").val();
					var tjxred = jxred.replace(/,/g," ");
					tjxred = $.trim(tjxred);
					
					var jxblue = $("#Blue_BallValue").val();
					var tjxblue = jxblue.replace(/,/g," ");//将字符串中所有的","用空格代替
					tjxblue = $.trim(tjxblue);
					
					var tmpstr = dlt+"#"+jxred+"|"+jxblue;
					localStorage.setItem("dlt",tmpstr);
				}
				
				
				var obdiv = '<div class="ssqtzNum"><cite class="errorBg"><em class="error2"></em></cite><span><em>'+tjxred+'</em><cite>'+tjxblue+'</cite></span><p>普通投注&nbsp;&nbsp;&nbsp;1注2元</p></div>';
				$(".ssqNum").append(obdiv);
				//机选后重新计算总钱数
				Dlt_t.loadMoney();
				//删除单个的项
				$(".error2").bind("click",function(){
					$(this).parents("div.ssqtzNum").remove();
					var str = Dlt_t.joinValue();
					localStorage.setItem("dlt",str);
					Dlt_t.loadMoney();
				});
			});
			//追号的期数选择
			$(".ssqzh li").bind("click",function(){
				$(this).toggleClass("cur");
				$(this).siblings().removeClass("cur");
				var q = $(this).attr("q");
				$("input[name='qs']").val(q);
				Dlt_t.loadMoney();
				if($("input[name='qs']").val()==1){
					$(".zjStop").hide();
					$(".fqhm").attr("disabled",false);
					$(".fqhm").removeClass("fqhmGray");
				}else{
					$(".zjStop").show();
					$(".fqhm").attr("disabled",true);
					$(".fqhm").addClass("fqhmGray");
				}
			});
			//投注列表的确认按钮功能
			var bk=0;//认购
			//提交
			
			$("#pay").bind("click",function(){
					var q,b,z,j,bk,zflag,playId;
					q = $_Y.getInt($("input[name='qs']").val());
					b = $_Y.getInt($("input[name='bs']").val());
					z = parseInt($('#count_Notes').html());
					j = parseInt($('#count_Money').html());
					playId = $("#PlayID").val();
					
					if(q == '' || q == '0' || q == null){
						D.tx('亲，请正确填写期数');
						return;
					}else if(b == '' || b == '0' || b == null){
						D.tx('亲，请正确填写倍数');
						return;
					}else if(z <=0){
						D.tx('亲，你还没选号码');
						return;
					}else if(j>200000){
						D.tx("您的购买金额不能超过20万");
						return false;
					}else if(q>154){
						D.tx("最多只能追154期");					
					}else if(b>999){
						D.tx("最大购买999倍");
					}else{
						/*
						 * notes:  注数
						 * issue: 期数
						 * multiple:     倍数
						 * pid:     当前期号
						 * countMoney: 总金额
						 * pattern:     0自购   1合买 2追号
						 * gid  :  彩种id
						 * zflag:  0中奖不停止   1中奖停止 
						 */
						bk = 0;
						if(q>1){
							bk = 2;
							var zflag = $(".zjStop em").hasClass("check")?1:0;
							window.location.href = '#class=url&xo=trade/defrayal.html&notes='+z+'&multiple='+b+'&issue='+q+'&countMoney='+j+'&pattern='+bk+'&zflag='+zflag+'&gid='+playId;
						}else{
							window.location.href = '#class=url&xo=trade/defrayal.html&notes='+z+'&multiple='+b+'&issue='+q+'&countMoney='+j+'&pattern='+bk+'&gid='+playId;
						}
					}
				});
			//发起合买
			$(".fqhm").bind("click",function(){
					var q,b,z,j,playId;
					q = $_Y.getInt($("input[name='qs']").val());
					b = $_Y.getInt($("input[name='bs']").val());
					z = parseInt($('#count_Notes').html());
					j = parseInt($('#count_Money').html());
					playId = $("#PlayID").val();
					if(q == '' || q == '0' || q == null){
						D.tx('亲，请正确填写期数');
						return;
					}else if(b == '' || b == '0' || b == null){
						D.tx('亲，请正确填写倍数');
						return;
					}else if(z <=0){
						D.tx('亲，你还没选号码');
						return;
					}else{
						/*
						 * notes:  注数
						 * multiple:     倍数
						 * pid:     当前期号
						 * countMoney: 总金额
						 * pattern:     0自购  1合买 2追号
						 * gid  :  彩种id
						 */
						location.href = '#class=url&xo=trade/fqhm.html&notes='+z+'&multiple='+b+'&countMoney='+j+'&gid='+playId;
					}
			});
			var zflag = 1;
			$(".zjStop em").bind("click",function(){
				//var zflag = $(".zjStop em").hasClass("check")?1:0;
				if($(this).hasClass("check")){
					$(this).removeClass("check");
					$(this).addClass("nocheck");
					zflag=0;
				}else{
					$(this).removeClass("nocheck");
					$(this).addClass("check");
					zflag=1;
				}
			});
			
		},
		//根据项连接值,将其设置到local对象中
		joinValue:function(){
			var arr = [];
			var str = "";
			var tmp = $(".ssqNum").find("div.ssqtzNum");
			tmp.each(function(){
				var r = $(this).find("span em").html();
				r = r.split(" ").join(",");
				var b = $(this).find("span cite").html();
				b = b.split(" ").join(",");
				arr.push(r+"|"+b);
			});
			str = arr.join("#");
			return str;
		},
		//计算总金钱数,总注数
		loadMoney:function(){
			this.sum=new Array();
			var dlt = localStorage.getItem("dlt");
			if(!dlt){
				$("#count_Notes").html(0);
				$("#count_Money").html(0);
				return;
			} 
			
			var dltArr = dlt.split("#");
			var len=dltArr.length;
			for(var i=0;i<len;i++){
				var arr = dltArr[i].split("|");
				var rArr = arr[0].split(",");
				var bArr = arr[1].split(",");
				var n = CC.count_Money(rArr,bArr);
				var m = n*2;
				this.sum.push(n);
			}
			var count = CC.sumCount(this.sum);
			var money = CC.sumMoney(this.sum);
			$("#count_Notes").html(count);
			$("#count_Money").html(money);
		}
}

CC={
		count_Money:function(r,b) {
		    var varcount = CC.count_Notes(r,b);
		    if (varcount > 0) {
		       return varcount;
		    }
		},
		//普通计算注数
		count_Notes:function(r,b) {
			var varNotes = 0;
		        if (r!= "" && b!= "") {
		            var rebcount = r.length;
		            var bluecount = b.length;
		            varNotes = CC.count(rebcount,5) * CC.count(bluecount,2);
		            
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
		sumCount:function(m){
			var tmp=0;
			for(var i=0;i<m.length;i++){
				tmp+=$_Y.getInt(m[i]);
			}
			return tmp;
		},
		sumMoney:function(m){
			var bs = $_Y.getInt($("input[name='bs']").val());
			var qs = $_Y.getInt($("input[name='qs']").val());
			var sum = this.sumCount(m)*bs*qs*2
			return sum;
		},
		//机选号码方法
		machineSelect:function() {
				//机选红球
		        var selectlength_r = '5';//双色球红球必选6个
		        var maxlength_r = '35';//双色球红球有33个
		        var redNum = this.Random(maxlength_r);//打乱顺序之后的33个红球
		        for (var i = 0; i < maxlength_r; i++)
		        	$("#xzhq .ssqBall cite").eq(i).removeClass("redBall");
		        

		        $("#Red_BallValue").attr("value", "");
		        var redvalue = "";
		        for (var i = 0; i < selectlength_r; i++) {
		            $("#xzhq .ssqBall cite").eq(redNum[i]-1).attr("class", "redBall");
		            redvalue += ((redNum[i] < 10 ? "0" + redNum[i].toString() : redNum[i]) + ",");
		        }

		        if (redvalue != "") {
		        	redvalue = this.reSort(redvalue.substring(0, redvalue.length - 1));
		            $("#Red_BallValue").attr("value", redvalue);
		        }
		       //机选篮球
		        var selectlength_b = '2';
		        var maxlength_b = 12;
		        var blueNum = this.Random(maxlength_b);
		        for (var i = 0; i < maxlength_b; i++)
		        	$("#xzlq .ssqBall cite").eq(i).removeClass("blueBall");

		        $("#Blue_BallValue").attr("value", "");
		        var bluevalue = "";
		        for (var i = 0; i < selectlength_b; i++) {
		        	$("#xzlq .ssqBall cite").eq(blueNum[i]-1).attr("class", "blueBall");
		            bluevalue += ((blueNum[i] < 10 ? "0" + blueNum[i].toString() : blueNum[i]) + ",");
		        }
		        if (bluevalue != "") {
		        	bluevalue = this.reSort(bluevalue.substring(0, bluevalue.length - 1));
		            $("#Blue_BallValue").attr("value", bluevalue);
		        }
		    //count_Money();
		},

		//生成随机数
		Random:function(count) {
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
		},
		//数组排序 升序
		sortIntArrayAsc:function(a, b) {
		  if (isNaN(a) || isNaN(b)) return a.localeCompare(b);
		  else return parseInt(a) - parseInt(b);
		},

		//重新排序
		reSort:function(s_numberList) {
		    var newNum = "";
		    var arr = new Array();
		    for (var j = 0; j < s_numberList.split(',').length; j++)
		        arr[j] = parseInt(s_numberList.split(',')[j], 10);

		    arr.sort(CC.sortIntArrayAsc);
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
		                D.alert("单注单个号码不能重复两次");
		                return "";
		            }
		        }
		    }
		    return newNum;
		}
}
Dlt_t.init_info();