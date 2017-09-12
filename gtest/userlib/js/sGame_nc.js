$(function () {
	action();
	$("#dp").attr("action","./inc/DataProcessingnc.php?t="+encodeURI($("#tys").html()));
	
	//POST提交表單
	$("#submits").click(function () {
		var suc = true;
		$.ajax ({type:"post",url:URL,dataType:"text",async:false,data:{typeid:"postodds"},success : function (data) {
				suc = postodds (data);
            }
		});
		return suc;
	});
	
	$("#sub").click(function () {
		var value = "", count = 0;
		$("#lm").attr("action","fn9.php?v="+$("#o").html());
		$(":radio").each(function () {
			if ($(this).attr("checked")) {value = $(this).val();}
		});
		$(":checkbox").each(function () {
			if ($(this).attr("checked")) {count++;}
		});
		if (value == "") {alert("請選擇類型!!!"); return false;}
		switch (value) {
			case "t1" : if (count < 1) {alert("蔬菜单选、至少勾選1种蔬菜!!!");return false};break;
			case "t2" : if (count < 1) {alert("动物单选、至少勾選1种动物!!!");return false};break;
			case "t3" : if (count < 2) {alert("幸运二、至少勾選2個號碼!!!");return false};break;
			case "t4" : if (count < 2) {alert("连连中、至少勾選2個號碼!!!");return false};break;
			case "t5" : if (count < 2) {alert("背靠背、至少勾選2個號碼!!!");return false};break;
			case "t6" : if (count < 3) {alert("幸运三、至少勾選3個號碼!!!");return false};break;
			case "t7" : if (count < 4) {alert("幸运四、至少勾選4個號碼!!!");return false};break;
			case "t8" : if (count < 5) {alert("幸运五、至少勾選5個號碼!!!");return false};break;
		}
	});
	
	$("#rn").click(function () {
		rm ();
	});
	
	$(":checkbox").click(function () {
		$(":radio").each(function () {
			if ($(this).attr("checked")) {
				check($(this).val());
			}
		});
	});
	
	function rm (){
		var box = $(":checkbox");
		box.css("display","inline");
		box.attr("checked","");
		box.attr("disabled","");
		$(".v").css("background","#fff");
	}
	
	function check(value) {
		alert('ddd');
		var c = 0;
		var che = $(":checkbox")
		che.each(function () {
			if ($(this).attr("checked")) {
				c++;
				$("."+$(this).attr("id")).css("background","yellow");
			} else {
				$("."+$(this).attr("id")).css("background","#fff");
			}
		});
		
		if ( value == "t3" || value == "t4" || value == "t5" || value == "t6") {
			if (c >=8) {atts (che,"disabled");} else {atts (che,"");}
		} else if (value == "t7" || value == "t8") {
			if (c >=6) {atts (che,"disabled");} else {atts (che,"");}
		}
	}
	function atts (che,value) {
		che.each(function () {
			if (!$(this).attr("checked")) {
				$(this).attr("disabled",value);
			}
		});
	}
});

function cRadio ($this) 
{
	//alert($this.value);
	var box = $(":checkbox");
	
	box.css("display","inline");
	box.attr("checked","");
	box.attr("disabled","");

	if($this.value=='t1'){
		var discheck1= $("#t19");
		discheck1.css("display","inline");
		discheck1.attr("checked","");
		discheck1.attr("disabled","disabled");
		var discheck2= $("#t20");
		discheck2.css("display","inline");
		discheck2.attr("checked","");
		discheck2.attr("disabled","disabled");
	}
	
	if($this.value=='t2'){
		box.css("display","inline");
		box.attr("checked","");
		box.attr("disabled","disabled");
		
		var discheck1= $("#t19");
		discheck1.css("display","inline");
		discheck1.attr("checked","");
		discheck1.attr("disabled","");
		var discheck2= $("#t20");
		discheck2.css("display","inline");
		discheck2.attr("checked","");
		discheck2.attr("disabled","");
	}
	$(".v").css("background","#fff");
	$(".qw").attr("disabled","").css("color","#006600");
}

function getResult ($this)
{
	$(".nv_a").addClass("nv").removeClass("nv_a");
	$($this).removeClass("nv").addClass("nv_a");
	var rowHtml = new Array();
	var data = stringByInt ($($this).html());
	//alert(data);
	for (var k in data)
	{
		rowHtml.push(data[k]);
	}
	$("#z_cl").html(rowHtml.join(''));
	$(".z_cl:even").addClass("hhg");
}
