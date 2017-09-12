<%@ Page language="c#" Codebehind="football_guodan.aspx.cs" AutoEventWireup="false" Inherits="newball.zdl.football_guodan" %>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN' > 
<html>
<head>
<meta name='GENERATOR' Content='Microsoft Visual Studio .NET 7.1'>
<meta name='CODE_LANGUAGE' Content='C#'>
<meta name=vs_defaultClientScript content='JavaScript'>
<meta name=vs_targetSchema content='http://schemas.microsoft.com/intellisense/ie5'>
<meta http-equiv=refresh content='-1'>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<link href='css/css.css' rel='stylesheet' type='text/css'>
<link rel=stylesheet href=css/control_main.css type=text/css>
</head>
<script language="javascript">
function CountGold()
{  
   if ( !isNumericOrEmpty(document.all.amount.value))
     alert("请输入数字!!");
   document.all.odds0.innerHTML=document.all.amount.value;
}
function isNumericOrEmpty (str)
	{
		return isCcy(str) || isEmpty(str);
	}
	function isCcy( strNum ) {

		var intCounter=0 , intLoop, intStartPos;

		strNum = jtrim(strNum);
		if (strNum == '') return false; // Not number
		if (strNum == '.') return false; // Not number

		for (intLoop = 0; intLoop < strNum.length; intLoop++) { // One . only
			if (strNum.charAt(intLoop) == ".") intCounter++;
			if (intCounter > 1) return false;
		}


		for (intLoop = 0; intLoop < strNum.length; intLoop++) { // 0-9, . only
			if (((strNum.charAt(intLoop) < "0") || (strNum.charAt(intLoop) > "9")) &&
					(strNum.charAt(intLoop) != ".")	)
				return false;
		}

		intStartPos = strNum.indexOf("."); // four decimal only
		if (intStartPos != -1){
			if ((strNum.length - (intStartPos  + 1 )) > 4)
				return false;
		}
		return true; // value is 0
	}
	function isEmpty (str)
	{
		return jtrim(str).length==0;
	}
	function jtrim (str)
	{
		while (str.charAt(0)==" ") str=str.substr(1, str.length-1);
		while (str.charAt(str.length-1)==" ") str=str.substr(0, str.length-1);
		return str;
	}
	var gt = 0;
    var Difft = 0;
	var sTime='<%#sTime%>';	
	function time_reload()
	{
	
	// parent.main.countdown_num.innerHTML=cd;	
		
		if (sTime != ''&&sTime != 'N'&&sTime>0)
		 {			
			closeM.style.display = "block";			
			gt = eval(sTime);			
			if (Difft != gt)
			{
				Difft = gt;
				close_msg.innerHTML = Difft;
			}
			else
			{
				if (close_msg.innerHTML!='&nbsp;')
				{
					if (eval(close_msg.innerHTML) < 1) { 
						cd=0;
						sTime = 'N';
					}else{
						close_msg.innerHTML = close_msg.innerHTML -1;
					}
				}
				else
				{
					close_msg.innerHTML = Difft;
				}
			  }
			}
			else
			{
					if (close_msg.innerHTML != '&nbsp;') close_msg.innerHTML = '&nbsp;';
					if (closeM.style.display != "none") closeM.style.display = "none";
			}
	
	       setTimeout("time_reload()",1000);
	}
	<%#time_reload%>	
</script>
