$(function(){
	var gid=location.search.getParam("gid");
	var tid=location.search.getParam("tid");
	var flag=location.search.getParam("flag");
	
	
	var istate=new Array();
	istate.push([0,"未完成"]);
	istate.push([1,"已完成"]);
	istate.push([2,"中奖停止"]);
	istate.push([3,"用户手工停止"]);
	
	var iflag=new Array();
	iflag.push([0,"中奖后追号不停止"]);
	iflag.push([1,"中奖后追号停止"]);
	iflag.push([2,"盈利停止"]);
	
	function chk(n){
		var str;
		switch(n){
			case 0:
				str="该方案自动跟单中，请等待";
			break;
			case 1:
				str="认购中";
			break;
			case 2:
				str="已满员";
			break;
			case 3:
				str="系统已撤单";
			break;
			case 4:
				str="发起人已撤单";
			break;
			case 5:
				str="系统已撤单";
			break;
			case -1:
				str="未支付";
			break;
		}
		return str;
	}
	
	$.ajax({
		url:"/user/query.go?flag=39",
		data:"gid="+gid+"&tid="+tid+"&pn=1&ps=100",
		success  : function (xml){
			var R = $(xml).find("Resp");
			
			if($(R).attr("code")==0){
				var r = R.find("row");
				r=r.sort(s);
				var len = r.length;
				
				var r0=$(r[0]);
				var codes = r0.attr("ccodes");
				var ist = parseInt(r0.attr("istate"));
				var czhid = r0.attr("czhid");
				var cadddate = r0.attr("cadddate");
				var ccodes = r0.attr("ccodes");
				var cawardcode = r0.attr("cawardcode");
				var izhflag = r0.attr("izhflag");
				var reason = parseInt(r0.attr("reason"));
				
				var html="";
				html+='<p>'+anyName(gid,$_sys.lot)+'  '+cadddate+ '发起</p>';
				html+='<div class="zhxqList mgTop06">';
				html+='<ul>';
				html+='<li><cite>方案编号</cite><span>'+czhid+'</span></li>';
				html+='<li><cite>方案期数</cite><span>'+len+'期('+checkState(izhflag,iflag)+')</span></li>';
				html+='<li><cite>方案状态</cite><span>'+checkState(reason,istate)+'</span></li>';
				html+='<li>';
				html+='<cite>投注内容</cite>';
				//html+='<span class="red">'+anyCodes(gid,codes)+'</span>';
				html+='<span class="red">'+$_sys.showcode(gid,codes)+'</span>';
				html+='</li>';
				html+='</ul>';
				html+='<div class="zhxqTxt">';
				html+='<p class="gray pdTop06 fontSize092">追号明细</p>';
				var zong = '0';
				r.each(function(){
					var cperiodid = $(this).attr("cperiodid");
					var ccastdate = $(this).attr("ccastdate");
					var icmoney = $(this).attr("icmoney");//当前购买金额
					var awardcode = $(this).attr("awardcode");//开奖号码
					var is = parseInt($(this).attr("istate"));//每条数据状态
					var isreturn = parseInt($(this).attr("isreturn"))
					
					var itax = $(this).attr("itax");//中奖金额
					var zj = itax>0?"已中奖":"未中奖";//税后奖金
					zong = parseInt(zong)+parseInt(icmoney);
					html+='<div class="zhmxList">';
					html+='<p>第'+cperiodid+'期 <em class="gray">'+ccastdate+'</em></p>';
					html+='<p class="zhmx"><cite><i class="weige"></i>/'+icmoney+'元</cite>'+kjCode(gid,awardcode);
					
					if ( is == 0 ) {
						//html += " <li class=\"cm_account_ul11_li7\">未投注</li>";
						if(isreturn<2){
							html+='<em>未投注</em>';
						}else{
							
							html+='<em>未结算</em>';
						}
						
					} else if ( is == 2 || is ==1 ) {
						if (is == 2 ){
							//html += " <li class=\"cm_account_ul11_li7\">已投注</li>";
							if(itax>0){
								html+='<em class="yellow">中奖'+itax+'元</em>';
							}else if(isreturn=="0"){
								html+='<em>未结算</em>';
							}else if(isreturn=="3"&& itax=="0"){
								html+='<em>未中奖</em>';
							}else{
								html+='<em>已投注</em>';
							}
							
						}else{
							//html += " <li class=\"cm_account_ul11_li7\">出票中</li>";
							html+='<em>出票中</em>';
						}						
						//outcount1++;
						//outnum1+=parseFloat(icmoney);						
					} else if ( is == 3 || is== 5) {
						//html += " <li class=\"cm_account_ul11_li7\">系统撤销</li>";
						html+='<em>系统撤销</em>';
					} else if ( is == 4 ) {
						//html += " <li class=\"cm_account_ul11_li7\">用户撤销</li>";
						html+='<em>用户撤销</em>';
					}
					
					if ( isreturn >= 2 && itax == '0') {
						if(is=="3"){
							//html+='<em>未中奖</em>';
						}else{
							//html+='<em>未中奖</em>';
						}
						//html += " <li class=\"cm_account_ul11_li5\">未中奖</li>";
						
					} else if (is != 2 && is == '0') {
						//html += " <li class=\"cm_account_ul11_li5 cm_red\">&nbsp;</li>";
						//html+='<em>&nbsp;</em>';
					}  else if (is == '0') {
						//html += " <li class=\"cm_account_ul11_li5\">未结算</li>";.
						//html+='<em>未结算</em>';
					} else {
						//incount++;
						//innum+=parseFloat(itax);;						
						//html += " <li class=\"cm_account_ul11_li5 cm_red\">"+parseFloat(irmoney).rmb(false)+"</li>";
						//if(is=="2"){
							//html+='<em class="yellow">中奖'+itax+'元</em>';
						//}
						
					}
					
					/***
					if ( istate == 0 ) {
						html += "<li class=\"cm_account_ul11_li9\"><input name=\"did\" type=\"checkbox\" value="+did+" id='checkbox"+i+"'/></li>";
					} else {
						html += "<li class=\"cm_account_ul11_li9\">&nbsp;</li>";
					}
					***/
					
					html+='</p>';
					html+='<p class="gray zhmx"><cite>总额<i class="accountLine"></i>当期</cite><span>开奖号</span><em>状态</em></p>';
					html+='</div>';
					
				});
				
				html+='</div>';
				html+='</div>';
				$(".pd063").html(html);
				$('.pd063 i.weige').html(zong);
			}else if($(R).attr("code")=='2000'){
				$(".pd063").html('等待出票');
			}
			
			
		}
	})
	
	//检查方案状态
	function checkState(k,arr){
		var str="";
		for(var i=0;i<arr.length;i++){
			if(arr[i][0]==k){
				str=arr[i][1]
			}
		}
		
		return str;
	}
	
	//开奖号码
	function kjCode(gid,cawardcode){
		var html="";
		if(cawardcode){
			if(gid=="01"){
					var cawardcodeArr = cawardcode.split("|");
					html+='<span class="red">'+cawardcodeArr[0].replace(/,/g," ")+' <i class="blue">'+cawardcodeArr[1]+'</i></span>'
				
			}else if(gid=="50"){
				var cawardcodeArr = cawardcode.split("|");
				html+='<span class="red">'+cawardcodeArr[0].replace(/,/g," ")+' <i class="blue">'+cawardcodeArr[1].replace(/,/g," ")+'</i></span>'
			}else if(gid=="58"){//快乐扑克
				//var cawardcodeArr = cawardcode.split("|");
				html+='<span class="red">'+code_58(cawardcode)+'</span>'
			}else{
				html+='<span class="red">'+cawardcode+'</span>'
			}
		}else{
			html+='<span>--</span>'
		}
		
		return html;
	}
})


//ccodes="02,03,10,14,25,29|13:1:1"
//cawardcode="04,06,08,18,25,28|16"



//根据id判断是哪个彩种
function anyName(gid,arr){
	for(var i=0;i<arr.length;i++){
		if(arr[i][0]==gid){
			var str = arr[i][1];
			return str;
		}
	}
}

//投注内容
function anyCodes(gid,str){
	alert(str)
	var html="";
	if(gid=="01"||gid=="50"){
		if(str){
			if(str.indexOf(";")>0){
				//var codeStr = str.substring(0,str.indexOf(":"))
				var codeArr = str.split(";")
				for(var j=0;j<codeArr.length;j++){
					var codeStr = codeArr[j];
					var redblueCodeArr = codeStr.split("|")
					var redCode=redblueCodeArr[0].replace(/,/g," ")
					var blueCode=redblueCodeArr[1]
					blueCode=blueCode.substring(0,blueCode.indexOf(":"))
					html+='<p>'+redCode+'<em class="blue"> '+blueCode+'</em></p>'
				}
			}else{
				var codeArr = str.split("|");
				var redCode=codeArr[0].replace(/,/g," ");
				var blueCode=codeArr[1];
				var length=blueCode.indexOf(":");
				blueCode=blueCode.substring(0,length)
				html+='<p>'+redCode+'<em class="blue"> '+blueCode+'</em></p>'
			}
			//return html;
		}
	}else if(gid=="54"){
		if(str){
			if(str.indexOf(";")>0){
				var codeArr = str.split(";")
				for(var j=0;j<codeArr.length;j++){
					var codeStr = codeArr[j];
					codeStr=codeStr.substring(0,blueCode.indexOf(":"))
					codeStr=codeStr.replace(/,/g," ")
					html+='<p>'+redCode+'<em class="blue"> '+codeStr+'</em></p>'
				}
			}else{
				var st = str.substring(0,str.indexOf(":"))
				st=st.replace(/,/g," ")
				html+='<p>'+st+'</p>';
			}
		}
			
	}else{
		if(str){
			if(str.indexOf(";")>0){
				var codeArr = str.split(";")
				for(var j=0;j<codeArr.length;j++){
					var codeStr = codeArr[j];
					codeStr=codeStr.substring(0,blueCode.indexOf(":"))
					codeStr=codeStr.replace(/,/g," ")
					html+='<p>'+redCode+'<em class="blue"> '+codeStr+'</em></p>'
				}
			}else{
				var st = str.substring(0,str.indexOf(":"))
				st=st.replace(/,/g," ")
				html+='<p>'+st+'</p>';
			}
		}
	}
	return html;
}



//投注号码 
$_sys.showcode = function (lotid,ccodes){
	var sarr = new Array();
	var str="";
	var html="";
	var codes = ccodes.split(";");
	for ( var i = 0; i < codes.length; i++) {
		if(lotid==90 ||lotid==91 ||lotid==92 ||lotid==93 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89){
			tmpCode = codes[i].split("|");
			html += '[' + $_sys.getplayname(lotid, lotid, lotid) + ']|' + tmpCode[1]+'|'+tmpCode[2].replaceAll("\\*","串");
		}else{
			tmpCode = codes[i].split(":");
			pm = tmpCode[1];
			cm = tmpCode[2];
			if (lotid=="04"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']';
				if($_Y.getInt(pm)==6){
					//大小单双：大用2 表示,小用1 表示,单用5 表示,双用4 表示
					var tc = tmpCode[0].split(",");
					for(var ii=0; ii<tc.length; ii++){
						html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
					}
				}else{
					html +=tmpCode[0];
				}
			}else if (lotid=="20"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']';
				if($_Y.getInt(pm)==11){
					//大小单双：大用2 表示,小用1 表示,单用5 表示,双用4 表示
					var tc = tmpCode[0].split(",");
					for(var ii=0; ii<tc.length; ii++){
						html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
					}
				}else{
					html +=tmpCode[0];
				}
			}else if (lotid=="54" || lotid=="55" || lotid=="03" || lotid=="53" || lotid=="56" || lotid=="57"||lotid=="09"){
				if(tmpCode[0].indexOf('$') != '-1'){
					var arr = tmpCode[0].split('$');
					tmpCode[0] = ' 胆:'+arr[0]+' 拖:'+arr[1];
				}
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']' + tmpCode[0];
			}else if (lotid=="05"||lotid=="06"||lotid=="08"){
				if(pm==2){//（快三）三同号通选在方案详情页面显示号码
					tmpCode[0]='111,222,333,444,555,666';
				}else if(pm==5){
					tmpCode[0]='123,234,345,456';
				}else if(pm=='7'){
					var cod = tmpCode[0].split("|");
					if(cod.length==2){
					var tn = cod[0].split(",");
					var tnstr="";
					if(tn.length>0){
					for(var j=0;j<tn.length;j++){
					tnstr += tn[j]+""+tn[j]+",";
					}
					tnstr = tnstr.substring(0, tnstr.length-1);
					tmpCode[0] = tnstr+"|"+cod[1];
					}
					}
					} 
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']' + tmpCode[0];
			}else if (lotid=="01" || lotid=="50"){
				var oc="";
				//sarr.push(matchopencode(lotid, pm, tmpCode[0], oc));
					
					str = matchopencode(lotid, pm, tmpCode[0], oc);
					html += str.split("|")[0]+"|";
					html += '<i class="blue">'+str.split("|")[1]+'</i>';
				
			}else if (lotid=="58"){//快乐扑克
				var tmp = tmpCode[0];
				switch (pm) {
				case "01":
				case "02":
				case "03":
				case "04":
				case "05":
				case "06":				
					tmp = tmp.replace('11','J').replace('12','Q').replace('13','K').replace('01','A').replace('02','2').replace('03','3').replace('04','4').replace('05','5').replace('06','6').replace('07','7').replace('08','8').replace('09','9');
					break;
				case "07":
				case "08"://同花、顺单选
					tmp = tmp.replace('01','黑桃单选').replace('02','红桃单选').replace('03','梅花单选').replace('04','方片单选');
			
				case "09"://顺子单选
					switch (tmp) {
					case "01":
						tmp = "A12";
						break;
					case "02":
						tmp = "234";
						break;
					case "03":
						tmp = "345";
						break;
					case "04":
						tmp = "456";
						break;
					case "05":
						tmp = "567";
						break;
					case "06":
						tmp = "678";
						break;
					case "07":
						tmp = "789";
						break;
					case "08":
						tmp = "8910";
						break;
					case "09":
						tmp = "910J";
						break;
					case "10":
						tmp = "10JQ";
						break;
					case "11":
						tmp = "JQK";
						break;
					case "12":
						tmp = "QKA";
						break;
					}
					break;
				case "10"://豹子单选
					switch (tmp) {
					case "01":
						tmp = "AAA";
						break;
					case "02":
						tmp = "222";
						break;
					case "03":
						tmp = "333";
						break;
					case "04":
						tmp = "444";
						break;
					case "05":
						tmp = "555";
						break;
					case "06":
						tmp = "666";
						break;
					case "07":
						tmp = "777";
						break;
					case "08":
						tmp = "888";
						break;
					case "09":
						tmp = "999";
						break;
					case "10":
						tmp = "101010";
						break;
					case "11":
						tmp = "JJJ";
						break;
					case "12":
						tmp = "QQQ";
						break;
					case "13":
						tmp = "KKK";
						break;
					}
					break;
				case "11"://对子单选
					switch (tmp) {
					case "01":
						tmp = "AA";
						break;
					case "02":
						tmp = "22";
						break;
					case "03":
						tmp = "33";
						break;
					case "04":
						tmp = "44";
						break;
					case "05":
						tmp = "55";
						break;
					case "06":
						tmp = "66";
						break;
					case "07":
						tmp = "77";
						break;
					case "08":
						tmp = "88";
						break;
					case "09":
						tmp = "99";
						break;
					case "10":
						tmp = "1010";
						break;
					case "11":
						tmp = "JJ";
						break;
					case "12":
						tmp = "QQ";
						break;
					case "13":
						tmp = "KK";
						break;
					}
					break;
				case "12":
					tmp = "同花包选";
					break;
				case "13":
					tmp = "同花顺包选";
					break;
				case "14":
					tmp = "顺子包选";
					break;
				case "15":
					tmp = "豹子包选";
					break;
				case "16":
					tmp = "对子包选";
					break;
				}
				if(tmp.indexOf('$') != '-1'){
					var arr = tmp.split('$');
					tmp = ' 胆:'+arr[0]+' 拖:'+arr[1];
				}
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']&nbsp;' + tmp;
				//html += "--";
			}else{
				html += tmpCode[0];
			}
		}	
		if (i != codes.length - 1) {
			html += '<br/>';
		}
	}
	return html;
};




$_sys.getplayname = function(lotid, playid, castdef) {
	var s = "";	
	var lotid=$_Y.getInt(lotid);
	var playid=$_Y.getInt(playid);
	var castdef=$_Y.getInt(castdef);
	switch (lotid) {
	case 85:
		s = "让球胜平负";
		break;
	case 86:
		s = "比分";
		break;
	case 87:
		s = "半全场";
		break;
	case 88:
		s = "上下单双";
		break;	
	case 89:
		s = "总进球数";
		break;			
	case 90:
		s = "让球胜平负";
		break;
	case 91:
		s = "比分";
		break;
	case 92:
		s = "半全场";
		break;
	case 93:
		s = "总进球数";
		break;
	case 4:
		switch (playid) {
		case 1:
			s = "五星直选";
			break;
		case 3:
			s = "三星直选";
			break;
		case 4:
			s = "两星直选";
			break;
		case 5:
			s = "一星直选";
			break;
		case 6:
			s = "大小单双";
			break;
		case 7:
			s = "二星组选";
			break;
		case 8:
			s = "三星组三";
			break;
		case 9:
			s = "三星组六";
			break;
		case 12:
			s = "五星通选";
			break;
		case 13:
			s = "五星复选";
			break;
		case 15:
			s = "三星复选";
			break;
		case 16:
			s = "两星复选";
			break;
		}
		break;
	case 5:
		switch(playid){
			case 1:
				s = "和值";
				break;
			case 2:
				s = "三同号通选";
				break;
			case 3:
				s = "三同号单选";
				break;
			case 4:
				if(castdef == 5){
					s = "三不同号胆拖";
				}else{
					s = "三不同号";
				}
				break;
			case 5:
				s = "三连号通选";
				break;
			case 6:
				s = "二同号复选";
				break;
			case 7:
				s = "二同号单选";
				break;
			case 8:
				if(castdef == 5){
					s = "二不同号胆拖";
				}else{
					s = "二不同号";
				}
				break;
		}
		break;
	case 6:
		switch(playid){
			case 1:
				s = "和值";
				break;
			case 2:
				s = "三同号通选";
				break;
			case 3:
				s = "三同号单选";
				break;
			case 4:
				if(castdef == 5){
					s = "三不同号胆拖";
				}else{
					s = "三不同号";
				}
				break;
			case 5:
				s = "三连号通选";
				break;
			case 6:
				s = "二同号复选";
				break;
			case 7:
				s = "二同号单选";
				break;
			case 8:
				if(castdef == 5){
					s = "二不同号胆拖";
				}else{
					s = "二不同号";
				}
				break;
		}
		break;
	case 8:
		switch(playid){
			case 1:
				s = "和值";
				break;
			case 2:
				s = "三同号通选";
				break;
			case 3:
				s = "三同号单选";
				break;
			case 4:
				if(castdef == 5){
					s = "三不同号胆拖";
				}else{
					s = "三不同号";
				}
				break;
			case 5:
				s = "三连号通选";
				break;
			case 6:
				s = "二同号复选";
				break;
			case 7:
				s = "二同号单选";
				break;
			case 8:
				if(castdef == 5){
					s = "二不同号胆拖";
				}else{
					s = "二不同号";
				}
				break;
		}
		break;
	case 9:
		switch(playid){
			case 1:
				s = "和值";
				break;
			case 2:
				s = "三同号通选";
				break;
			case 3:
				s = "三同号单选";
				break;
			case 4:
				if(castdef == 5){
					s = "三不同号胆拖";
				}else{
					s = "三不同号";
				}
				break;
			case 5:
				s = "三连号通选";
				break;
			case 6:
				s = "二同号复选";
				break;
			case 7:
				s = "二同号单选";
				break;
			case 8:
				if(castdef == 5){
					s = "二不同号胆拖";
				}else{
					s = "二不同号";
				}
				break;
		}
		break;
	case 20:
		switch (playid) {
		case 1:
			s = "一星";
			break;
		case 2:
			s = "二星";
			break;
		case 3:
			s = "三星";
			break;
		case 4:
			s = "四星";
			break;
		case 5:
			s = "五星";
			break;
		case 6:
			s = "二星组合";
			break;
		case 7:
			s = "三星组合";
			break;
		case 8:
			s = "四星组合";
			break;
		case 9:
			s = "五星组合";
			break;
		case 10:
			if(castdef=="1"){
				s = "二星组选单式";
			}else{
				s = "二星组选包号";
			}
			break;
		case 11:
			s = "大小单双";
			break;
		case 12:
			s = "五星通选";
			break;
		case 13:
			s = "任选一";
			break;
		case 14:
			s = "任选二";
			break;
		case 15:
			if(castdef=="1"){
				s = "三星组三单式";
			}else{
				s = "三星组三包号";
			}
			break;
		case 16:
			if(castdef=="1"){
				s = "三星组六单式";
			}else{
				s = "三星组六包号";
			}
			break;
		}
		break;
	case 50:
		if(playid=="2"){
			s = "追加";
		}else if(playid=="3"){
			s = "生肖乐";
		}
		break;
	case 3:
	case 53://castdef---playid
		switch (castdef) {
		case 1:
		case 2:
		case 3:
		case 5:
			if(playid=="1"){
				s = "直选";
			}else if(playid=="2"){
				s = "组三";
			}else{
				s = "组六";
			}
			break;
		case 4:
			if(playid=="1"){
				s = "直选和值";
			}else if(playid=="2"){
				s = "组三和值";
			}else{
				s = "组六和值";
			}
			break;
		}
		break;
	case 54:
	case 55:
	case 56:
		switch (playid) {
		case 1:
			s = "前一直选";
			break;
		case 2:
			s = "任选二";
			break;
		case 3:
			s = "任选三";
			break;
		case 4:
			s = "任选四";
			break;
		case 5:
			s = "任选五";
			break;
		case 6:
			s = "任选六";
			break;
		case 7:
			s = "任选七";
			break;
		case 8:
			s = "任选八";
			break;
		case 9:
			s = "前二直选";
			break;
		case 10:
			s = "前三直选";
			break;
		case 11:
			s = "前二组选";
			break;
		case 12:
			s = "前三组选";
			break;
		}
		break;
	case 57:
		switch (playid) {
		case 1:
			s = "前一直选";
			break;
		case 2:
			s = "任选二";
			break;
		case 3:
			s = "任选三";
			break;
		case 4:
			s = "任选四";
			break;
		case 5:
			s = "任选五";
			break;
		case 6:
			s = "任选六";
			break;
		case 7:
			s = "任选七";
			break;
		case 8:
			s = "任选八";
			break;
		case 9:
			s = "前二直选";
			break;
		case 10:
			s = "前三直选";
			break;
		case 11:
			s = "前二组选";
			break;
		case 12:
			s = "前三组选";
			break;
		}
		break;
	case 58:
		switch (playid) {
		case 1:
			s = "任选一";
			break;
		case 2:
			if(castdef == 5){
				s = "任选二胆拖";
			}else{
				s = "任选二";
			}
			break;
		case 3:
			if(castdef == 5){
				s = "任选三胆拖";
			}else{
				s = "任选三";
			}
			break;
		case 4:
			if(castdef == 5){
				s = "任选四胆拖";
			}else{
				s = "任选四";
			}
			break;
		case 5:
			if(castdef == 5){
				s = "任选五胆拖";
			}else{
				s = "任选五";
			}
			break;
		case 6:
			if(castdef == 5){
				s = "任选六胆拖";
			}else{
				s = "任选六";
			}
			break;
		case 7:
		case 12:
			s = "同花";
			break;
		case 8:
		case 13:
			s = "同花顺";
			break;
		case 9:
		case 14:
			s = "顺子";
			break;
		case 10:
		case 15:
			s = "豹子";
			break;
		case 11:
		case 16:
			s = "对子";
			break;
		}
		break;
	}
	return s;
};

var matchopencode = function (lotid, pm, cd, win){
	var rc = "";
	var wf = $_sys.getplayname(lotid, pm, 0);
	if(lotid=="50"){
		if(pm==3){  //生肖乐
			if(win == '' || win == undefined){
				rc = cd;
			}else{
				rc+= arrmatch(cd, win, "cm_red", ",");
			}
		}else{
			if(win == '' || win == undefined){
				var cdstr = cd.split("|");
				var qq = cdstr[0];
				var hq = cdstr[1];
				if(qq.indexOf("$")!=-1){
					rc+= "[前区胆:" + qq.split("$")[0] +"]";
					rc+= "[前区拖:" + qq.split("$")[1] +"]";
				}else{
					rc+= "[前区:" + qq +"]";
				}
				if(hq.indexOf("$")!=-1){
					rc+= "|[后区胆:" + hq.split("$")[0] +"]";
					rc+= "[后区拖:" + hq.split("$")[1] +"]";
				}else{
					rc+= "|[后区:" + hq +"]";
				}
			}else{
				var w = win.split("|");
				var c = cd.split("|");
				var cl = c[0];
				var cr = c[1];
				var wl = w[0];
				var wr = w[1];
				
				if(cl.indexOf("$")!=-1){
					rc+= "[前区胆:" + arrmatch(cl.split("$")[0], wl, "cm_red", ",") +"]";
					rc+= "[前区拖:" + arrmatch(cl.split("$")[1], wl, "cm_red", ",") +"]";
				}else{
					rc+= "[前区:" + arrmatch(cl, wl, "cm_red", ",") +"]";
				}
				if(cr.indexOf("$")!=-1){
					rc+= "|[后区胆:" + arrmatch(cr.split("$")[0], wr, "opencode_blue", ",") +"]";
					rc+= "[后区拖:" + arrmatch(cr.split("$")[1], wr, "opencode_blue", ",") +"]";
				}else{
					rc+= "|[后区:" + arrmatch(cr, wr, "opencode_blue", ",") +"]";
				}
			}
		}
	}else{
		if(win == '' || win == undefined){
			if(cd.indexOf("$")!=-1){
				var dt = cd.split("|")[0].split("$");
				rc+= "[红胆:" + dt[0] +"]";
				rc+= "[红拖:" + dt[1] +"]";
				rc+= "|" + "[蓝球:" + cd.split("|")[1] +"]";
			}else{
				rc = cd;
			}
		}else{
			var w = win.split("|");
			var c = cd.split("|");
			var cl = c[0];
			var cr = c[1];
			var wl = w[0];
			var wr = w[1];
			if(cl.indexOf("$")!=-1){
				var dan = cl.split("$");
				rc+= "[前胆:" + arrmatch(dan[0], wl, "cm_red", ",") +"]";
				rc+= "[前拖:" + arrmatch(dan[1], wl, "cm_red", ",") +"]";
			}else{
				rc+= arrmatch(cl, wl, "cm_red", ",");
			}
			
			
			rc+= "|";
			if(cr != "" && cr !=undefined && cr !="undefined"){
				rc+= arrmatch(cr, wr, "opencode_blue", ",");
			}
			
		}
	}
	if(wf!=""){
		rc = '[' + wf + ']' + rc;
	}
	
	return rc;
}