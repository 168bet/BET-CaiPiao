<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "include/address.mem.php";
require ("include/config.inc.php");
$str   = time();
$uid   = $_REQUEST['uid'];
$langx = $_REQUEST['langx'];
if ($langx==''){
	$langx="zh-cn";	
}

if($uid=='' || $userid==0){
	$sql = "SELECT * FROM `web_member_data` WHERE id=0 ";
	//echo $sql;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['Oid']=='' || empty($row['Oid']) || $row['Oid']=='logout'){
	    $str = time('s');
	    $uid=strtolower(substr(md5($str),0,10).substr(md5($row['UserName']),0,10).'ra'.rand(0,9));
	    $ip_addr=get_ip();
	    $credit=$row['Credit'];
		$money=$
	    $date=date("Y-m-d");
	    $todaydate=strtotime(date("Y-m-d"));
	    $editdate=strtotime($row['EditDate']);
	    $time=($todaydate-$editdate)/86400;
		$datetime=strtotime(date("Y-m-d H:i:s"));
		$onlinetime=strtotime($row['OnlineTime']);
		if ($datetime-$onlinetime>1){
			if ($row['LoginDate']!=$date and $row['Pay_Type']==0){//判断是现金投注还是信用额度投注，若是现金不回归额度。若是信用回归额度
			   $sql="update web_member_data set Oid='$uid',LoginDate='$date', Money='$credit',LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where id=0 and Status<=1";
			}else{
			   $sql="update web_member_data set Oid='$uid',LoginDate='$date', LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where id=0 and Status<=1";
			}		
			   mysql_query($sql) or die ("error!");
		}
	}else{
		$uid=$row['Oid'];
	}
}

if($userid>0){
$sql = "select * from web_member_data where Oid='$uid' and Status<=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$Status=$row['Status'];

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$mid=$row['ID'];
	$memname=$row['UserName'];
	
	$loginname=$row['LoginName'];
	$langx=$row['Language'];
	$logindate=date("Y-m-d");
	$datetime=date('Y-m-d h:i:s');
	if ($row['LoginDate']!=$logindate){
		$credit=$row['Credit'];
		$sql="update web_member_data set LoginTime='$datetime', Money='$credit' where UserName='$memname' and Pay_Type=0";
		mysql_query($sql) or die ("error!");
	}else{
		$credit=$row['Money'];
	}
}

}
$paysql = "select Address from web_payment_data where Switch=1";
$payresult = mysql_query($paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];
?>
 <?
 if($userid>0){
  $mysql = "select * from web_notices where (type=1 or id in (select notice_id from web_notices_to where notice_to=$mid) or (type=3 and addpople = '".$mid."') or (type=4 and reply_to_uid='".$mid."')) and (view_ids not like '%{".$memname."}%' or  view_ids is null)";
  $r = mysql_query($mysql);
  $noread = mysql_num_rows($r);
 $mysql = "select * from web_notices where (type=1 or id in (select notice_id from web_notices_to where notice_to=$mid) or (type=3 and addpople = '".$mid."') or (type=4 and reply_to_uid='".$mid."')) and (view_ids  like '%{".$memname."}%' and  view_ids is not null)";
 
  $r = mysql_query($mysql);
  $readed = mysql_num_rows($r);
 }
 ?>
<html>
<head>
<title>welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css"> 
body,td,th {font-size: 13px;}
.time_text{
    float:right;
    position: relative;
    top:2px;
    right:0px;
}
#est_bg{
    background-color:#FFFFFF;
    width:208px;
    height:20px;
    line-height:20px;
    /* For IE 5-7 */
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);
    /* For IE 8 */
    -MS-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
        /* Firefox */
    -moz-opacity:0.8;              
        /* Moz + FF */ 
    opacity: 0.8;  
    font-size: 12px;
    color: #224c05;
    text-align: center;
}
a:link { TEXT-DECORATION:none; color: #000; line-height:25px;font-size:13px;}
a:visited { COLOR: #000; text-decoration: none; line-height:25px;font-size:13px;}
a:active { COLOR: #FF8F19; TEXT-DECORATION: none; line-height:25px;font-size:13px;}
a:hover { COLOR: #FF8F19; TEXT-DECORATION: none; line-height:25px;font-size:13px;}
</style>
<SCRIPT LANGUAGE="JavaScript">
function createXMLHttpRequest(http) {
  if(window.ActiveXObject) {
    eval(http+" = new ActiveXObject(\"Microsoft.XMLHTTP\")");
  }
  else if(window.XMLHttpRequest) {
    eval(http+" = new XMLHttpRequest()");
  }
}
function money(){
    createXMLHttpRequest("cHttp");
    cHttp.onreadystatechange = cChange;
    cHttp.open("post", "money.php?uid=<?=$uid ?>&check=1", true);
    cHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
    cHttp.send(null);
function cChange(){
    if (cHttp.readyState == 4) {
        if (cHttp.status == 200){
            var cDoc = cHttp.responseText;
            document.getElementById("money").innerHTML=cDoc;
        }
    }  
}
setTimeout("money();",3000);  
}
</SCRIPT>
<script type="text/javascript">
function chk_acc(){
    if(document.all.username.value==""){
        alert('请输入帐号！');
        document.all.username.focus();
        return false;
    }
    if(document.all.username.value=="帐号:"){
        alert('请输入帐号！');
        document.all.username.focus();
        return false;
    }
    if(document.all.password.value==""){
        alert('请输入密码！');
        document.all.password.focus();
        return false;
    }
    if(document.all.password.value=="password:"){
        alert('请输入密码！');
        document.all.password.focus();
        return false;
    }
    if(document.all.code.value==""){
        alert('请输入验证码！');
        document.all.code.focus();
        return false;
    }
    if(document.all.code.value=="验证码:"){
        alert('请输入验证码！');
        document.all.code.focus();
        return false;
    }
    return true;
}

function change_pic(){
document.getElementById("pic").innerHTML="<img src='mkcode.php?code=<?=$uid ?>" + Math.round(Math.random()*10) + "' width=40 height=20 border='0' onclick='change_pic()' alt='( 点选此处产生新验证码 )'/>";
}
function be_login(){
	alert('您必需登陆后才能执行此操作！');
	//return false;	
}
</script>
<script language="javascript">
var current = <?=time() ?>000 || 0;
/**
* 即時時間顯示
**/
function dispTime(){
    current += 1000;
    var dateObj = new Date(current);
    var Y = dateObj.getFullYear();
    var Mh = dateObj.getMonth() + 1;
    if(Mh > 12) Mh = 01;
    if(Mh < 10) Mh = '0'+Mh;
    var D = dateObj.getDate()  < 10 ? '0'+dateObj.getDate():dateObj.getDate();
    var H = dateObj.getHours() < 10 ? '0'+dateObj.getHours():dateObj.getHours();
    var M = dateObj.getMinutes() < 10 ? '0'+dateObj.getMinutes():dateObj.getMinutes();
    var S = dateObj.getSeconds() < 10 ? '0'+dateObj.getSeconds():dateObj.getSeconds();
    document.getElementById('EST_reciprocal').innerHTML = Y+'/'+Mh+'/'+D+' - '+H+':'+M+':'+S;
}
    var timerID = setInterval("dispTime()",1000);
</script>
<script type="text/javascript" src="/js/jquery.js"></script>
<SCRIPT language="JavaScript" src="/js/header.js"></SCRIPT>
<script language="Javascript">
document.oncontextmenu=new Function("event.returnValue=false");
document.onselectstart=new Function("event.returnValue=false");
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="1002" border="0" cellpadding="0" cellspacing="0" background="/images/logo.gif">
    <tr>
        <td width="284" height="134" rowspan="3"></td>
        <td width="740" height="82">
        <table width="740" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="240" height="20" align="right"><div id="est_bg" class="time_text">美东时间：<span id="EST_reciprocal"></span></div></td>
              <td width="171">&nbsp;</td>
              <td width="329"><img src="/images/246x16xlanx.jpg.pagespeed.ic.knck25hKvu.gif" width="246" height="16"></td>
          </tr>
          <? if($userid<=0){ ?>
            <tr>
              <td height="50" align="right">
              </td>
              <td colspan="2">
                            <table width="315" border="0" align="center" cellpadding="0" cellspacing="0">
                <form name="LoginForm" action="login.php" method="post" onSubmit="return chk_acc();">
                   <input type=HIDDEN name="uid" value="<?=$uid ?>">
                   <input type=HIDDEN name="langx" value="zh-cn">
                <tr>
                  <td width="125" height="26"><input name="username" type="text" class="input1" id="username" style="WIDTH: 115px; COLOR: #438e00; HEIGHT: 22px" onFocus="if(this.value=='帐号:'){this.value='';}" onBlur="if(this.value==''){this.value='帐号:';}" value="帐号:" maxlength="15"/></td>
                  <td colspan="2"><input name="password" type="password" class="input1" id="password" style="WIDTH: 115px; COLOR: #438e00; HEIGHT: 22px" onFocus="if(this.value=='password:'){this.value='';}" onBlur="if(this.value==''){this.value='password:';}" value="password:" maxlength="15"/></td>
                  <td width="60">&nbsp;</td>
              </tr>
                <tr>
                  <td height="22"><input name="code" type="text" class="input1" id="code" style="WIDTH: 115px; COLOR: #438e00; HEIGHT: 22px" title="( 点选此处产生新验证码)" onFocus="change_pic(); if(this.value=='验证码:'){this.value='';}" onBlur="if(this.value==''){this.value='验证码:';}" value="验证码:" maxlength="4"/></td>
                  <td width="58" id='pic'></td>
                  <td width="72"><input name="imageField" type="image" src="/images/xlogin.jpg.pagespeed.ic.JuvJQT0cbh.jpg" width="56" height="22"></td>
                  <td><a href="reg.php" target="body">免费注册</a></td>
              </tr>
              </form>
            </table>
              </td>
          </tr>
          <? }else{ ?>
                     <tr>
              <td height="50" align="right">
                            <A href="account/mem_data.php?uid=<?=$uid ?>&langx=zh-cn" target="body"><img src="/images/h_01.jpg" width="67" height="24" border="0"></A>
              <A href="today/today_wagers.php?uid=<?=$uid ?>&langx=zh-cn" target="body"><img src="/images/h_02.jpg" width="67" height="24" border="0"></A>
              <A href="history/history_data.php?uid=<?=$uid ?>&langx=zh-cn" target="body"><img src="/images/h_03.jpg" width="67" height="24" border="0"></A>
                       </td>
              <td colspan="2">
                          <table width="460" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="460" align="center">
                  &nbsp;&nbsp;<img src="/images/003.gif" width="16" height="16"/>&nbsp;帐户名称&nbsp;:&nbsp;<B><font color=#990000><?=$memname ?></font></B>&nbsp;&nbsp;&nbsp;<img src="/images/004.gif" width="16" height="16"/>&nbsp;帐户余额&nbsp;:&nbsp;<B><font color=#990000><span id="money"><?= $credit?></span><a href='#' onclick="cChange();">[刷新]</a></font></B>&nbsp;&nbsp;<img src="/images/005.gif" width="16" height="16"/>&nbsp;交易货币&nbsp;:&nbsp;<B><font color=#990000>RMB</font></B>&nbsp;&nbsp;<a href="logout.php?uid=<?=$uid ?>&amp;langx=zh-cn" target="_top">[&nbsp;<B>登出</B>&nbsp;]</a>
                  </td>
                </tr>
            </table>
                       </td>
          </tr>
          <? } ?>
          
          </table>
        </td>
    </tr>
    <tr>
        <td width="740" height="30" align="right">
        <table width="705" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td><a href="body.php?uid=<?=$uid ?>&langx=<?=$langx ?>" target="body"><img src="/images/002.jpg" width="71" height="30" border="0"></a></td>
                <td><a href="/app/member/FT_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3&showtype=3" target="body"><img src="/images/66x30xtop_02.jpg.pagespeed.ic.ceLnPvEyzV.jpg" width="66" height="30" border="0"></a></td>
                <td><a href="reg.php" target="body"><img src="/images/66x30xtop_03.jpg.pagespeed.ic.8qJMeqpl4M.jpg" width="66" height="30" border="0"></a></td>
                <td><a <? if($userid>0){ ?>href="<?=$address?>/register.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname?>" target="body"<? }else{ ?> href="javascript:void(0);" onClick="be_login();"<? } ?>><img src="/images/66x30xtop_04.jpg.pagespeed.ic.2eEXLh-HnC.jpg" width="66" height="30" border="0"></a></td>
                <td><a <? if($userid>0){ ?>href="YeePay/withdrawal.php?uid=<?=$uid ?>&langx=<?=$langx ?>&username=<?=$memname?>" target="body"<? }else{ ?> href="javascript:void(0);" onClick="be_login();"<? } ?>><img src="/images/66x30xtop_05.jpg.pagespeed.ic.OH7FHql-NS.jpg" width="66" height="30" border="0"></a></td>
                <td><a <? if($userid>0){ ?>href="YeePay/record.php?uid=<?=$uid ?>&langx=<?=$langx ?>&username=<?=$memname?>" target="body"<? }else{ ?> href="javascript:void(0);" onClick="be_login();"<? } ?>><img src="/images/66x30xtop_06.jpg.pagespeed.ic.t3ObeGQ5Ng.jpg" width="66" height="30" border="0"></a></td>
                <td><a href="index_data/affiled.php?uid=<?=$uid ?>&langx=<?=$langx ?>" target="body"><img src="/images/66x30xtop_07.jpg.pagespeed.ic.aw2agFPR0b.jpg" width="66" height="30" border="0"></a></td>
                <td><a href="index_data/psites.php?uid=<?=$uid ?>&langx=<?=$langx ?>" target="body"><img src="/images/66x30xtop_08.jpg.pagespeed.ic.wz1doz8_4T.jpg" width="66" height="30" border="0"></a></td>
                <td><a href="http://www.83suncity.cm/game.aspx" target="body"><img src="/images/66x30xtop_09.jpg.pagespeed.ic.daiH2bK--Q.jpg" width="66" height="30" border="0"></a></td>
                <td><a href="http://webchat.tq.cn/sendmain.jsp?action=chat&admiuin=9249649&uin=9249649&ltype=1&sort=0&lasttalkuin=9249649&chattype=5&isnoshowuser=0&uingroup=9249649&rand=13265849891392414&comtimes=3&iscallback=1&agentid=0&isAgent=0&page=http://www.hg0088vip.com/app/member/&localurl=http://www.hg0088vip.com/app/member/header.php?uid=268aeca0dad41d8cd98fra0*langx=zh-cn&spage=http://www.hg0088vip.com/app/member/" target="_blank"><img src="/images/top_10zx.jpg" width="66" height="30" border="0"></a></td>
            </tr>
        </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<table width="1002" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height="20" background="/images/bg_02.gif">&nbsp;</td>
    </tr>
</table>
<table width="1002" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height="90" background="/images/banner.jpg">&nbsp;</td>
    </tr>
</table>
 <?
 if($userid>0){
 ?>

<script language="javascript" type="text/javascript">
function writeflashhtml(){ 
   // document.getElementById('SoundPlayer').innerHTML ="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' width='1' height='1' id='image1'><param name='movie' value='../images/Ring.swf'><param name='quality' value='high'><param name=\"wmode\" value=\"transparent\" /></object>";
}

function CLASS_MSN_MESSAGE(id,width,height,caption,title,message,target,action){   
    this.id = id;  
    this.title = title;  
    this.caption = caption;  
    this.message = message;  
    this.target = target;  
    this.action = action;  
    this.width = width?width:200;  
    this.height = height?height:120;  
    this.timeout= 150;  
    this.speed = 20; 
    this.step = 1; 
    this.right = screen.width -1;  
    this.bottom = screen.height; 
    this.left = this.right - this.width; 
    this.top = this.bottom - this.height; 
    this.timer = 0; 
    this.pause = false;
    this.close = false;
    this.autoHide = true;
}  
  
/*?藏消息方法*/  
CLASS_MSN_MESSAGE.prototype.hide = function(){  
    if(this.onunload()){  
        var offset  = this.height>this.bottom-this.top?this.height:this.bottom-this.top; 
        var me  = this;   
        if(this.timer>0){   
            window.clearInterval(me.timer);  
        }  
        var fun = function(){  
            if(me.pause==false||me.close){
                var x = me.left; 
                var y = 0; 
                var width = me.width; 
                var height = 0; 
                if(me.offset>0){ 
                    height = me.offset; 
                } 
     
                y = me.bottom - height; 
     
                if(y>=me.bottom){ 
                    window.clearInterval(me.timer);  
                    me.Pop.hide();  
                } else { 
                    me.offset = me.offset - me.step;  
                } 
                me.Pop.show(x,y,width,height);    
            }             
        }  
        this.timer = window.setInterval(fun,this.speed)      
    }  
}  
  
/* 消息卸?事件，可以重?  */  
CLASS_MSN_MESSAGE.prototype.onunload = function() {  
    return true;  
}  
/* 消息命令事件，要??自己的?接，?重?它 */  
CLASS_MSN_MESSAGE.prototype.oncommand = function(){  
    //this.close = true;
    this.hide();  
   
    var fs = document.getElementsByTagName('iframe');

 
    for(var i=0;i<fs.length;i++) {
    	fs[1].src = "notices.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>";
    	//alert(fs[i].src);
    }
	//window.open("/Member/Bet_login/SendinforBack.aspx?" + Math.round(Math.random()*1000000),"mainFrame");
   
}

/*消息?示方法  */  
CLASS_MSN_MESSAGE.prototype.show = function(){  
    var oPopup = window.createPopup(); //IE5.5+  
    
    this.Pop = oPopup;  
  
    var w = this.width;  
    var h = this.height;  
  
    var str = "<div id='msgbox' style='background-image:url(images/news.gif); background-repeat:no-repeat; width: " + w + "px; height: " + h + "px; font-size:12px;'>" 
    str+="<div style='height:21px; width:300px;'><div class='new_top_in'  style=' float:right; padding-right:10px; padding-top:8px;'><img id='btSysClose' style='cursor:pointer' src='images/news-menu1.gif' width='23' height='22' /></div>"
    str+="</div>"
    str+="<div style='height:95px;width:300px; text-align:center; cursor:pointer;'>"
    str+="<div style='width:250px; margin:auto; padding-top:15px; text-align:left;'>" + this.title + "，<span style='color: #E90004;cursor:pointer;'id='btCommand'>" + this.message + "</span>"
    str+="</div>"
    str+="</div>"
    str+="<div style='float:right; padding-right:20px; padding-top:47px;'><img src='images/news_foot.gif' id='btecommand2' width='89' height='22' border='0' style='cursor:pointer;' alt='' />"
    str+="</div>"
        str += "</div>"  
  
    oPopup.document.body.innerHTML = str; 

    
    this.offset  = 0; 
    var me  = this;  

    oPopup.document.body.onmouseover = function(){me.pause=true;}
    oPopup.document.body.onmouseout = function(){me.pause=false;}

    var fun = function(){  
        var x  = me.left; 
        var y  = 0; 
        var width = me.width; 
        var height = me.height; 

            if(me.offset>me.height){ 
                height = me.height; 
            } else { 
                height = me.offset; 
            } 

        y  = me.bottom - me.offset; 
        if(y<=me.top){ 
            me.timeout--; 
            if(me.timeout==0){ 
                window.clearInterval(me.timer);  
                if(me.autoHide){
                    me.hide(); 
                }
            } 
        } else { 
            me.offset = me.offset + me.step; 
        } 
        me.Pop.show(x,y,width,height);    
    }  
  
    this.timer = window.setInterval(fun,this.speed)      

    var btClose = oPopup.document.getElementById("btSysClose");  
  
    btClose.onclick = function(){  
        me.close = true;
        me.hide();  
        
    }  
  
    var btCommand = oPopup.document.getElementById("btCommand");  
    btCommand.onclick = function(){  
        me.oncommand();
        me.close = true;
        me.hide();  
    } 
    
    var btCommand2 = oPopup.document.getElementById("btecommand2");  
    btCommand2.onclick = function(){  
        me.oncommand();
        me.close = true;
        me.hide();  
    }       
}  

/*?置速度方法 */ 
CLASS_MSN_MESSAGE.prototype.speed = function(s){ 
    var t = 20; 
    try { 
        t = praseInt(s); 
    } catch(e){} 
    this.speed = t; 
} 
/*?置步?方法 */ 
CLASS_MSN_MESSAGE.prototype.step = function(s){ 
    var t = 1; 
    try { 
        t = praseInt(s); 
    } catch(e){} 
    this.step = t; 
} 
  
CLASS_MSN_MESSAGE.prototype.rect = function(left,right,top,bottom){ 
    try { 
        this.left   = left   !=null?left  :this.right-this.width; 
        this.right  = right  !=null?right :this.left +this.width; 
        this.bottom = bottom !=null?(bottom>screen.height?screen.height:bottom):screen.height; 
        this.top    = top    !=null?top   :this.bottom - this.height; 
    } catch(e){} 
}

    var s=<?=intval($noread)?>;
    if(s>=1){
        var MSG1 = new CLASS_MSN_MESSAGE("aa",300,200,"短消息提示：","您有<span style='color: #E90004'>"+s+"</span>條新消息","請點擊查看");  
            MSG1.rect(null,null,null,screen.height-50); 
            MSG1.speed    = 20; 
            MSG1.step    = 5; 
           // writeflashhtml(); 
            MSG1.show();
            
    }else{
       window.onerror = function(){}
    } 
</script>
<?
 }
?>
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
top.str_HCN = new Array("主","客","無");

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


top.strRtypeSP = new Array();
top.strRtypeSP["PGF"]="最先進球";
top.strRtypeSP["OSF"]="最先越位";
top.strRtypeSP["STF"]="最先替補球員";
top.strRtypeSP["CNF"]="第一顆角球";
top.strRtypeSP["CDF"]="第一張卡";
top.strRtypeSP["RCF"]="會進球";
top.strRtypeSP["YCF"]="第一張黃卡";
top.strRtypeSP["GAF"]="有失球";
top.strRtypeSP["PGL"]="最後進球";
top.strRtypeSP["OSL"]="最後越位";
top.strRtypeSP["STL"]="最後替補球員";
top.strRtypeSP["CNL"]="最後一顆角球";
top.strRtypeSP["CDL"]="最後一張卡";
top.strRtypeSP["RCL"]="不會進球";
top.strRtypeSP["YCL"]="最後一張黃卡";
top.strRtypeSP["GAL"]="沒有失球";
top.strRtypeSP["PG"]="最先/最後進球球隊";
top.strRtypeSP["OS"]="最先/最後越位球隊";
top.strRtypeSP["ST"]="最先/最後替補球員球隊";
top.strRtypeSP["CN"]="第一顆/最後一顆角球";
top.strRtypeSP["CD"]="第一張/最後一張卡";
top.strRtypeSP["RC"]="會進球/不會進球";
top.strRtypeSP["YC"]="第一張/最後一張黃卡";
top.strRtypeSP["GA"]="有失球/沒有失球";


top.strOver="大";
top.strUnder="小";
top.strOdd="單";
top.strEven="雙";


//下注警語
top.message001="請輸入下注金額!!";
top.message002="只能輸入數字!!";
top.message003="下注金額不可小於最低下注金額!!";
top.message004="對不起,本場有下注金額最高: ";
top.message005=" 元限制!!";
top.message006="下注金額不可大於單注限額!!";
top.message007="下注金額已超過單場最高限額!!";
top.message008="本場累計下注共: ";
top.message009="\n下注金額已超過單場限額!!";
top.message010="下注金額不可大於可用額度!!";
top.message011="可贏金額：";
top.message012="<br>是否確定下注?";
top.message013="是否確定下注?<br>";
top.message014='未輸入下注金額!!!';
top.message015="下注金額僅能輸入數字!!";
top.message016="\n\n是否確定下注?";
top.message017="串1";
top.message018="隊聯碰";
top.message019="您必須選擇至少";
top.message020="個隊伍,否則不能下注!!";
top.message021="不接受";
top.message022="串過關投注!!";
top.message023="請輸入欲下注金額!!";
top.message024="已超過某場次之過關注單限額!!";
top.message025="下注金額不可大於信用額度!!";
top.message026="請選擇下注隊伍!!";
top.message027="單式投注請至單式下注頁面下注!!";
top.message028="僅接受";
top.message029="串投注!!";
</script>
<script language="javascript"> 
<!--
/*屏蔽所有的js错误*/
function killerrors() { 
return true; 
} 
window.onerror = killerrors; 
//-->
</script>
</body>
</html>
