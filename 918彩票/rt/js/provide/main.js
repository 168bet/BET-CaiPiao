/***
require.config({
　　　　paths: {
　　　　　　"jquery": "/rt/js/jquery-1.9.1.min",
　　　　　　"vue": "https://unpkg.com/vue/dist/vue",
		"aa":"/rt/js/provide/index"
　　　　}
　　});
***/
require(["/rt/js/jquery-1.9.1.min.js","/rt/js/provide/index.js"],function($_,aa){
	aa.init(1,2);
})