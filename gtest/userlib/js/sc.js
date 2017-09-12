if (top.location == self.location) top.location.href = "/";
document.onkeydown = function(){ 
	if ( event.keyCode==116) { 
		event.keyCode = 0; 
		event.cancelBubble = true; 
		return false; 
	}
}

 function SetCookie(name,value)//����������һ����cookie�����ӣ�һ����ֵ  
{  
    var Days = 30; //�� cookie �������� 30 ��  
    var exp = new Date();    //new Date("December 31, 9998");  
   exp.setTime(exp.getTime() + Days*24*60*60*1000);  
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();  
 }  


function getCookie(name)//ȡcookies����          
 {  
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));  
    if(arr != null) return unescape(arr[2]); return null;  
 }  




function getwin()
	{
		var URL = "../ajax/Default.ajax.php";
		var winResult = $("#sy");
		$.ajax({
			type : "POST",
			url : URL ,
			data : {typeid : "getwin"},
			error : function(XMLHttpRequest, textStatus, errorThrown){
				if (XMLHttpRequest.readyState == 4){
					if (XMLHttpRequest.status == 500){
						getwin();
						return false;
					}
				}
			},
			success:function(data){
				winResult.html(data);
			}
		});
	}
setInterval(getwin, 5000);


