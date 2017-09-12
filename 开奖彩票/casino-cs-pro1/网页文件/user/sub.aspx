<%@ Page language="c#" Codebehind="sub.aspx.cs" AutoEventWireup="false" Inherits="newball.user.sub" codePage="936" %>
<HTML>
	<HEAD>
		<script>
var result = new Array();
var gTime = '2';
var lenb = '<%#lenb%>';
<%#kygltable%>


function starting(){
    gTime --
    setTimeout("gr()",1000);
}
parent.stop(result,lenb,'<%#qishu%>');
function gr(){
    if(lenb < '7'){
        if(gTime > 0){
            starting();
        }else{
            setTimeout("location.reload()",<%#reload%>);
        }
    }
}
		</script>
	</HEAD>
	<body onLoad="gr()">
		<!--<input name="renew" onclick="location.reload()" value='¸üÐÂ' type="button">-->
	</body>
</HTML>
