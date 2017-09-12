$(function(){
	var code = location.search.getParam("code");
	var bindcode = code.substring(0,3)+"****"+code.substring(7);
	
	
	$("#hidecode").val(code);
	
	$("#bindphone").text(bindcode);
	
})