/*
 *股指配置项文件
 */

// 测试数据
var guzhidata = {
	line1: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 9.2],

	line2: [1.0, 2.2, 1.3, 4.5, 4.3, 5.2, 20.3, 23.4, 23.0, 16.5, 3.0, 3.2],

	bar1: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
}


var guzhi = {

	optionA: {

		title: {
			text: '334',
			subtext: 'Nullam at tortor. \nSuspendisse . ',

			x:15,

			textStyle:{fontSize:30}

		},

		tooltip: {
			trigger: 'axis'
		},

		toolbox: {
			show: false,
			feature: {
				mark: {
					show: true
				},
				dataView: {
					show: true,
					readOnly: false
				},
				magicType: {
					show: true,
					type: ['line', 'bar']
				},
				restore: {
					show: true
				},
				saveAsImage: {
					show: true
				}
			}
		},

		calculable: true,

		legend: {
			show: false,
			data: ['股指', 'A', 'B']
		},

		xAxis: [{
			data: ['6:00AM', ' ', ' ', ' ', ' ', ' ', '12:00PM', ' ', ' ', ' ', ' ', ' ', '6:PM'],
			axisLine: {
				lineStyle: {
					color: '#acbdbf'
				}
			},
			axisLabel:{
				textStyle:{color:'#acbdbf'}
			},
			splitLine: {
				show: false
			},
			axisTick:{
				show:false
			}
		}],
		yAxis: [{
			axisLabel: {
				formatter: '{value} k',
				textStyle:{color:'#acbdbf'}
			},
			axisLine: {
				lineStyle: {
					color: '#c1cece'
				}
			},
			splitLine: {
				lineStyle: {
					type: 'dashed',
					color: '#ccc'
				}
			}
		}, {
			show: false,

		}],

		grid: {
			x:55,
			y:80,
			width:400,

			borderWidth: 0
		},

		series: [

			{
				name: '股指',
				type: 'bar',
				data: guzhidata.bar1,
				itemStyle: {
					normal: {

						color: '#f2f4f4',
						barBorderColor: '#e0e5e6'

					}

				}
			}, {
				name: 'A',
				type: 'line',
				yAxisIndex: 1,
				data: guzhidata.line2,
				itemStyle: {
					normal: {
						color: '#07899d',
						lineStyle: {
							color: '#07899d'
						}
					}

				},
				symbol: 'circle'
			}, {
				name: 'B',
				type: 'line',
				yAxisIndex: 1,
				data: guzhidata.line1,
				itemStyle: {
					normal: {
						color: '#1ed085',
						lineStyle: {
							color: '#1ed085'
						}
					}

				},
				symbol: 'circle'

			}
		]
	}
}