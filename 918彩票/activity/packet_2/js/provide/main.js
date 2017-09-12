/***
require.config({
　　　　paths: {
　　　　　　"jquery": "/rt/js/jquery-1.9.1.min",
　　　　　　"vue": "https://unpkg.com/vue/dist/vue",
		"aa":"/rt/js/provide/index"
　　　　}
　　});
***/
require(["/activity/packet_2/js/jquery-1.9.1.min.js","/activity/packet_2/js/index.js"],function($_,aa){
	aa.init();
})