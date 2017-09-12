// JavaScript Document
$(function(){
	$(".tab_ul li").eq(0).click(function(){
		$(this).addClass("cur");
		$(".tab_ul li").eq(1).removeClass("cur");
		$(".team_ul").eq(1).hide();
		$(".team_ul").eq(0).show();
		$(".west_div").show();
		$(".east_div").hide();
	})
	$(".tab_ul li").eq(1).click(function(){
		$(this).addClass("cur");
		$(".tab_ul li").eq(0).removeClass("cur");
		$(".team_ul").eq(0).hide();
		$(".team_ul").eq(1).show();
		$(".east_div").show();
		$(".west_div").hide();
	})
	$(".c1 li a").click(function(){
		$(".c1 div").removeClass("cur")
		$(this).find("div").addClass("cur");
		$(".c1 i").removeClass("cur")
		$(this).find("i").addClass("cur");
	})
	$(".c2 li a").click(function(){
		$(".c2 div").removeClass("cur")
		$(this).find("div").addClass("cur");
		$(".c2 i").removeClass("cur")
		$(this).find("i").addClass("cur");
	})
	$(".c3 li a").click(function(){
		var i = $(this).parent().index();
		$(".c3 div").removeClass("cur")
		$(this).find("div").addClass("cur");
		$(".c3 i").removeClass("cur")
		$(this).find("i").addClass("cur");
		$(".c4 div").removeClass("cur")
		$(".c4 li").eq(i).find('div').addClass("cur");
		$(".c4 i").removeClass("cur")
		$(".c4 li").eq(i).find('i').addClass("cur");
	})
	$(".c4 li a").click(function(){
		var i = $(this).parent().index();
		$(".c4 div").removeClass("cur")
		$(this).find("div").addClass("cur");
		$(".c4 i").removeClass("cur")
		$(this).find("i").addClass("cur");
		$(".c3 div").removeClass("cur")
		$(".c3 li").eq(i).find('div').addClass("cur");
		$(".c3 i").removeClass("cur")
		$(".c3 li").eq(i).find('i').addClass("cur");
	})
	
})



























