define(["https://unpkg.com/vue/dist/vue"],function (V){
　　　　var add = function (x,y){
		//document.write("aaaa");
　　　　　　return x+y;
　　　　};
	var init = function(x,y){
		var app2 = new V({
			  el: '#app-2',
			  data: {
				message: add(x,y)
			  }
			})
		};
　　　　return {
　　　　　　add: add,
        init:init
　　　　};
　　});