<?
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
?>
<script> 
var msg = '';
var grp_show = 'N';
</script>
<script> 
top.str_input_pwd = "密碼請務必輸入!!";
top.str_input_repwd = "確認密碼請務必輸入!!";
top.str_err_pwd = "密碼確認錯誤,請重新輸入!!";
top.str_pwd_limit = "您的密碼必須至少6個字元長，最多12個字元長，並只能是數字，英文字母等符號，其他的符號都不能使用!!";
top.str_pwd_limit2 = "您的密碼需使用字母加上數字!!";
top.str_pwd_NoChg = "您的密碼未做任何變更!!";
top.str_input_longin_id = "登錄帳號請務必輸入!!";
top.str_longin_limit1 = "登錄帳號最少必須有2個英文大小寫字母和數字(0~9)組合輸入限制(6~12字元)";
top.str_longin_limit2 = "您的登錄帳號需使用字母加上數字!!";
top.str_o="單";
top.str_e="雙";
top.str_checknum="驗證碼錯誤,請重新輸入";
top.str_irish_kiss="和局";
top.dPrivate="私域";
top.dPublic="公有";
top.grep="群組";
top.grepIP="群組IP";
top.IP_list="IP列表";
top.Group="組別";
top.choice="請選擇";
top.account="請輸入帳號!!";
top.password="請輸入密碼!!";
top.S_EM="特早";
top.alldata="全部";
top.webset="資訊網";
top.str_renew="更新";
top.outright="冠軍";
top.financial="金融";
 
//====== Live TV
top.str_FT = "足球";
top.str_BK = "籃球";
top.str_TN = "網球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";
top.str_game_list = "所有球類";
top.str_second = "秒";
top.str_demo = "樣本播放";
top.str_alone = "獨立";
top.str_back = "返回";
top.str_RB = "滾球";
 
 
 
top.str_ShowMyFavorite="我的最愛";
top.str_ShowAllGame="全部賽事";
top.str_delShowLoveI="移出";
</script>
 
<script>
function reload_table() {
	//alert("aaa===>"+grp_show);
	if (grp_show == "Y") {
		var shows = document.getElementById("showlayer").innerHTML; //=== 第二層 div
		var tr_data = document.getElementById("show_tr").innerHTML; //=== 第三層 div
		var AllLayer = ""; //=== 第三層 div
		var layers = "";
		AllLayer=Show_Data(tr_data);
		shows = shows.replace("*SHOWLIST*",AllLayer);
		shows = shows.replace("*WEBSET*",top.webset);
		show_table.innerHTML = shows;	
	}else{
		var no_data = document.getElementById("no_data").innerHTML;
		no_data = no_data.replace("*WEBSET*",top.webset);
		//show_table.innerHTML = document.getElementById("no_data").innerHTML;
		show_table.innerHTML = no_data;
	}
	
}
	
function Show_Data(layers){
	//layers = layers.replace('*MSG*',Chkarray[i][2]);
	layers = layers.replace('*MSG*',msg);
	return layers;
}
 
 
//光棒
var current = null;
function colorTRx(flag){
	if(flag==1 && current!=null){
		current.style.backgroundColor = current._background;
		current.style.color = current._font;
		current = null;
		return;
	}
	if ((self.event.srcElement.parentElement.rowIndex!=0) && (self.event.srcElement.parentElement.tagName=="TR") && (current!=self.event.srcElement.parentElement)) {
		if (current!=null){
			current.style.backgroundColor = current._background;
			current.style.color = current._font;
		}
		self.event.srcElement.parentElement._background = self.event.srcElement.parentElement.style.backgroundColor;
		self.event.srcElement.parentElement._font = self.event.srcElement.parentElement.style.color;
		self.event.srcElement.parentElement.style.backgroundColor = "#F5CE6C";
		self.event.srcElement.parentElement.style.color = "";
		current = self.event.srcElement.parentElement;
	}
}
/*
function chg_layer(value){
	chkgrp = value;
	reload_table();
}
 
 
function chg_selet(){
	var checksel  = "<select name=\"chg_layer\" id=\"chg_layer\" onChange=\"chg_layer(this.value);\"  class=\"za_select\">";
		checksel += "<option value=\"\">"+top.choice+"</option>\n";
		if(prigrp!='0'){
			checksel += "<option value=\"Private\">"+top.dPrivate+"</option>\n";
		}
		checksel += "<option value=\"Public\">"+top.dPublic+"</option>\n";
		checksel +="</select>";
	return checksel ;
}
 
function showOpt(objName, arrName, defVal) {
        var obj = eval("document.getElementById('"+objName+"')");
 
        obj.length = 0;
 
                obj.options[0] = new Option("請選擇", "0", false, false);
                for(var ik=0; ik<arrName.length; ik++) {
                        obj.options[ik+1] = new Option(arrName[ik][1], arrName[ik][0], false, false);
                }
                obj.value = defVal;
}
*/</script>
 
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

 
<style type="text/css"> 
<!--
html, body {
	margin:0;
	padding-top:2px;
	text-align:center;
}
body, td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	border: 6px ridge #FF9900;
	background-color: #FFFFCC;
}
.ip_title {
	text-align: center;
	background-color: #D6A343;
	font-size: 12px;
	padding: 3px;
}
.ip_mem {
	background-color: #FFFFFF;
	text-align: center;
}
.ip_bg {
	background-color: #666666;
}
.ip_title1 {
	height: 30px;
	background-color: #DFCA78;
	width: 100%;
	text-align: center;
}
-->
</style>
</head>
 
<body bgcolor="#FFFFFF" text="#000000" vlink="#0000FF" alink="#0000FF" leftmargin="0" topmargin="0" class="ip_side" onLoad="reload_table();">
<br>
<div id="show_table" ></div>
 
<div id="showlayer" style="display: none;" >
	<table border="0" cellpadding="1" cellspacing="1" class="ip_bg">
		<tr >
			<td class="ip_title" width="240">*WEBSET*</td>
		</tr>
		*SHOWLIST*
	</table>
<div>
	
<!-- 查無資料時 start -->
<div id="no_data" style="display: none;">
	<table border="0" cellpadding="1" cellspacing="1" class="ip_bg">
		<tr >
			<td class="ip_title" width="240">*WEBSET*</td>
		</tr>
	</table>
</div>
<!-- 查無資料時 end -->	
 
<div id="show_tr" style="display: none;">
	<tr onMouseOver="colorTRx(0)" onMouseOut="colorTRx(1)">
	  <td class="ip_mem">*MSG*</td>
	</tr>
</div>
 
 
</body>
</html>

