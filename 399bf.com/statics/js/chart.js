(function($) {

	// 路径配置
	require.config({
		paths: {
			echarts: 'http://echarts.baidu.com/build/dist'
		}
	});

	//使用
	require([

		'echarts',
		'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
		'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载

	], function(ec) {

		var guzhiA = ec.init(document.getElementById('guzhi1'));

		guzhiA.setOption(guzhi.optionA);

		var guzhiB = ec.init(document.getElementById('guzhi2'));

		guzhiB.setOption(guzhi.optionA);
	})

})(jQuery)


