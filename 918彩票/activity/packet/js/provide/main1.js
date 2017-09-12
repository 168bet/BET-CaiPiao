/***
require.config({
　　　　paths: {
　　　　　　"jquery": "/rt/js/jquery-1.9.1.min",
　　　　　　"vue": "https://unpkg.com/vue/dist/vue",
		"aa":"/rt/js/provide/index"
　　　　}
　　});
***/
require(["/activity/packet/js/jquery-1.9.1.min.js","/activity/packet/js/state.js"],function($_,aa){
	aa.init();
})