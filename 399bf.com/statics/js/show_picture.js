$(function(){

	/* 商品轮播图（带缩略图的轮播效果）*/
	$(".banner").thumbnailImg({
		large_elem: ".large_box",
		small_elem: ".small_list",
		left_btn: ".left_btn",
		right_btn: ".right_btn"
	});

	//tab自动切换start
	var count = 0;
	var lis = $("#focusInfo li");

	setInterval(function(){
		$("#focusInfo li").each(function(index,item){
			if(item.className == "active"){
				count = index;
			}
		});

		count ++;
		if(count > lis.length - 1){
			count = 0;
		}
		var tabs = $("#focusInfo li").eq(count).find("a").attr("href");
		$("#focusInfo li").removeClass("active");
		$("#focusInfo li").eq(count).addClass("active");
		$(tabs).addClass("active fade in").siblings().removeClass("active fade in");

	},5000);
	//tab自动切换end
});