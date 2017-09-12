// 彩票开奖配置
exports.cp=[

	{
		title:'重庆时时彩',
		source:'360彩票',
		name:'cqssc',
		enable:true,
		timer:'cqssc_360',
		option: {
			host: 'cp.360.cn',
			timeout: 30000,
			path: '/ssccq/',
			headers: {'User-Agent': 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)'},
		},
		parse: function(str) {
			try{
				return getFrom360CP(str, 1); //後面的type為代碼
			} catch(err) {
				throw('重庆时时彩解析数据不正确');
			}
		},
	},
	{
		title:'重庆时时彩',
		source:'百度乐彩',
		name:'cqssc',
		enable:true,
		timer:'cqssc_baidu',
		option: {
			host: 'baidu.lecai.com',
			timeout: 30000,
			path: '/lottery/ajax_latestdrawn.php?lottery_type=200',
			headers: {
				'Accept': 'application/json, text/javascript, */*; q=0.01',
				'Referer': 'http://baidu.lecai.com/lottery/draw/view/200',
				'User-Agent': 'Mozilla/5.0 (Windows NT 5.1; rv:49.0) Gecko/20100101 Firefox/49.0',
				'X-Requested-With': 'XMLHttpRequest',
			},
		},
		parse: function(str) {
			try {
				var data = JSON.parse(str);
				if (typeof data.data[0].result.result[0].data === 'object') {
					var time = data.data[0].time_endticket;
					var number = data.data[0].phase;
					var data = data.data[0].result.result[0].data.join(',');
					var numone=number.substr(0,8);
					var numtwo=number.substr(8,3);
					number=numone+"-"+numtwo;
					return {
						type: 1,
						time: time,
						number: number,
						data: data,
						correct:true,
					};
				}
			} catch(err) {
				throw('重庆时时彩解析数据不正确');
			}
		},
	},

	{
		title:'新疆时时彩',
		source:'新疆福利彩票网',
		name:'xjssc',
		enable:true,
		timer:'xjssc',
		option:{
			host:"www.xjflcp.com",
			timeout:30000,
			path: '/game/sscAnnounce',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				return getFromXJFLCPWeb(str,12);
			}catch(err){
				throw('新疆时时彩解析数据不正确');
			}
		}
	},
	{
		title:'新疆时时彩',
		source:'168KAI',
		name:'xjssc',
		enable:true,
		timer:'xjssc',
		option:{
			host:"api.1680210.com",
			timeout:30000,
			path: '/CQShiCai/getBaseCQShiCaiList.do?date=&lotCode=10004',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
					var strlen=250;
					str=str.substr(str.indexOf('errorCode'), strlen);
					var m;
					var reg=/preDrawCode\D*([\d\,]*)\D*\d*\,\"preDrawTime\D*([\d\-\:\ ]*)\"\,\"preDrawIssue\D*(\d{8})(\d{2})/;
					if(m=str.match(reg)){
						return {
							type:12,
							time:m[2],
							number:m[3]+"-"+m[4],
							data:m[1],
							correct:true,
						};
					}
			}catch(err){
				throw('新疆时时彩解析数据不正确');
			}
		}
	},

	{
		title:'福彩3D',
		source:'500万彩票网',
		name:'fc3d',
		enable:true,
		timer:'fc3d',
		option:{
			host:"www.500.com",
			timeout:30000,
			path: '/static/info/kaijiang/xml/sd/list10.xml',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,300);
				var m;
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)" trycode="[\d\,]*?" tryinfo="" \/>/;
				if(m=str.match(reg)){
					return {
						type:9,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('福彩3D解析数据不正确');
			}
		}
	},

	{
		title:'排列3',
		source:'500万彩票网',
		name:'pai3',
		enable:true,
		timer:'pai3',
		option:{
			host:"www.500.com",
			timeout:30000,
			path: '/static/info/kaijiang/xml/pls/list10.xml',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,300);
				var m;
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/;
				if(m=str.match(reg)){
					return {
						type:10,
						time:m[3],
						number:20+m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('排3解析数据不正确');
			}
		}
	},

	{
		title:'广东11选5',
		source:'360彩票',
		name:'gd11x5',
		enable:true,
		timer:'gd11x5_360',
		option:{
			host:"cp.360.cn",
			timeout:30000,
			path: '/gd11/',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				return getFrom360CP(str,6); //後面的type為代碼
			}catch(err){
				throw('广东11选5解析数据不正确');
			}
		}
	},
	{
		title:'广东11选5',
		source:'百度乐彩',
		name:'gd11x5',
		enable:true,
		timer:'gd11x5_baidu',
		option:{
			host:"baidu.lecai.com",
			timeout:30000,
			path: '/lottery/draw/view/23?phase=15082462&agentId=5563',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				var exp_data = /var latest_draw_result = {"red":\[([0-9\[\]\,\s"]+)\]/;
				var exp_phase = /var latest_draw_phase = '(\d+)';/;
				var exp_time = /var latest_draw_time = '([0-9\-\:\s]+)';/;
				var m_data = str.match(exp_data);
				var m_phase = str.match(exp_phase);
				var m_time = str.match(exp_time);
				if(m_data && m_phase && m_time){
					var phasea=m_phase[1].substr(0,6);
					var phaseb=m_phase[1].substr(6,2);
					m_phase[1]=phasea+"-0"+phaseb;
					return {
						type:6,
						time:m_time[1],
						number:'20' + m_phase[1],
						data:m_data[1].replace(/"/g, '')
					};
				}
			}catch(err){
				throw('广东11选5解析数据不正确');
			}
		}
	},
	{
		title:'广东11选5',
		source:'168KAI',
		name:'gd11x5',
		enable:true,
		timer:'gd11x5',
		option:{
			host:"api.1680210.com",
			timeout:30000,
			path: '/ElevenFive/getElevenFiveList.do?date=&lotCode=10006',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
					var strlen=290;
					str=str.substr(str.indexOf('errorCode'), strlen);
					var m;var i;
					var reg=/preDrawCode\D*([\d\,]*)\D*\d*\,\"preDrawTime\D*([\d\-\:\ ]*)\"\,\"preDrawIssue\D*(\d{8})(\d{2})/;
					if(m=str.match(reg)){
						return {
							type:6,
							time:m[2],
							number:m[3]+"-0"+m[4],
							data:m[1],
							correct:true,
						};
					}
			}catch(err){
				throw('广东11选5解析数据不正确');
			}
		}
	},

	{
		title:'江西11选5',
		source:'360彩票',
		name:'jx11x5',
		enable:true,
		timer:'jx11x5_360',
		option:{
			host:"cp.360.cn",
			timeout:30000,
			path: '/dlcjx/',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				return getFrom360CP(str,16); //後面的type為代碼
			}catch(err){
				throw('江西11选5解析数据不正确');
			}
		}
	},
	{
		title:'江西11选5',
		source:'百度乐彩',
		name:'jx11x5',
		enable:true,
		timer:'jx11x5_baidu',
		option:{
			host:"baidu.lecai.com",
			timeout:30000,
			path: '/lottery/draw/view/22?phase=2015082464&agentId=5563',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				var exp_data = /var latest_draw_result = {"red":\[([0-9\[\]\,\s"]+)\]/;
				var exp_phase = /var latest_draw_phase = '(\d+)';/;
				var exp_time = /var latest_draw_time = '([0-9\-\:\s]+)';/;
				var m_data = str.match(exp_data);
				var m_phase = str.match(exp_phase);
				var m_time = str.match(exp_time);
				if(m_data && m_phase && m_time){
					var phaseone=m_phase[1].substr(0,8);
					var phasetwo=m_phase[1].substr(8,2);
					m_phase[1]=phaseone+"-0"+phasetwo;
					return {
						type:16,
						time:m_time[1],
						number:m_phase[1],
						data:m_data[1].replace(/"/g, '')
					};
				}
			}catch(err){
				throw('江西11选5解析数据不正确');
			}
		}
	},
	{
		title:'江西11选5',
		source:'168KAI',
		name:'jx11x5',
		enable:true,
		timer:'jx11x5',
		option:{
			host:"api.1680210.com",
			timeout:30000,
			path: '/ElevenFive/getElevenFiveList.do?date=&lotCode=10015',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
					var strlen=290;
					str=str.substr(str.indexOf('errorCode'), strlen);
					var m;var i;
					var reg=/preDrawCode\D*([\d\,]*)\D*\d*\,\"preDrawTime\D*([\d\-\:\ ]*)\"\,\"preDrawIssue\D*(\d{8})(\d{2})/;
					if(m=str.match(reg)){
						return {
							type:16,
							time:m[2],
							number:m[3]+"-0"+m[4],
							data:m[1],
							correct:true,
						};
					}
			}catch(err){
				throw('江西11选5解析数据不正确');
			}
		}
	},

	{
		title:'山东11选5',
		source:'360彩票网',
		name:'sd11x5',
		enable:true,
		timer:'sd11x5_360',
		option:{
			host:"cp.360.cn",
			timeout:30000,
			path: '/yun11/',
			headers:{
				"User-Agent": "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; Sleipnir/2.9.8) "
			}
		},
		parse:function(str){
			try{
				return getFrom360sd11x5(str,7);
			}catch(err){
				throw('山东11选5解析数据不正确');
			}
		}
	},
	{
		title:'山东11选5',
		source:'百度乐彩',
		name:'sd11x5',
		enable:true,
		timer:'sd11x5_baidu',
		option:{
			host:"baidu.lecai.com",
			timeout:30000,
			path: '/lottery/ajax_latestdrawn.php?lottery_type=20',
			headers: {
				'Accept': 'application/json, text/javascript, */*; q=0.01',
				'Referer': 'http://baidu.lecai.com/lottery/draw/view/20?phase=15082465&agentId=5622',
				'User-Agent': 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)',
				'X-Requested-With': 'XMLHttpRequest',
			},
		},
		parse:function(str){
			try {
				var data = JSON.parse(str);
				if (typeof data.data[0].result.result[0].data === 'object') {
					var time = data.data[0].time_endticket;
					var number = data.data[0].phase;
					var data = data.data[0].result.result[0].data.join(',');
					var stra=number.substr(0,6);
					var strb=number.substr(6,2);
					var number=stra+"-0"+strb;
					return {
						type: 7,
						time: time,
						number: number.substr(0, 2) !== '20' ? '20' + number : number,
						data: data,
					};
				}
			} catch(err) {
				throw('山东11选5解析数据不正确');
			}
		}
	},
	{
		title:'山东11运夺金',
		source:'168KAI',
		name:'sd11x5',
		enable:true,
		timer:'sd11x5',
		option:{
			host:"api.1680210.com",
			timeout:30000,
			path: '/ElevenFive/getElevenFiveInfo.do?issue=&lotCode=10008',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
					var strlen=320;
					str=str.substr(str.indexOf('errorCode'), strlen);
					var m;var i;
					var reg=/preDrawCode\D*([\d\,]*)\D*\d*\D*[\d\-\:\ ]*\"\,\"preDrawTime\D*([\d\-\:\ ]*)\D*[\d\-]*\D*\d*\,\"preDrawIssue\D*(\d{6})(\d{2})/;
					if(m=str.match(reg)){
						return {
							type:7,
							time:m[2],
							number:"20"+m[3]+"-0"+m[4],
							data:m[1],
							correct:true,
						};
					}
			}catch(err){
				throw('山东11运夺金解析数据不正确');
			}
		}
	},

	{
		title:'北京PK10',
		source:'北京福彩网',
		name:'bjpk10',
		enable:true,
		timer:'bjpk10',
		option:{
			host:"www.bwlc.net",
			timeout:30000,
			path: '/bulletin/prevtrax.html',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
					var strlen=166;
					str=str.substr(str.indexOf('<th width="30%">开奖公告</th>'), strlen);
					var m;
					var reg=/<tr\D*(\d*)\D*([\d\,]*)\D*([\d\-\:\s]*)/;
					if(m=str.match(reg)){
						return {
							type:20,
							time:m[3],
							number:m[1],
							data:m[2],
							correct:true,
						};
					}
			}catch(err){
				throw('北京PK10解析数据不正确');
			}
		}
	},
	{
		title:'北京PK10',
		source:'百度乐彩',
		name:'bjpk10',
		enable:true,
		timer:'bjpk10',
		option:{
			host:"baidu.lecai.com",
			timeout:30000,
			path: '/lottery/draw/view/557?phase=503062&agentId=5563',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
				var exp_data = /var latest_draw_result = {"red":\[([0-9\[\]\,\s"]+)\]/;
				var exp_phase = /var latest_draw_phase = '(\d+)';/;
				var exp_time = /var latest_draw_time = '([0-9\-\:\s]+)';/;
				var m_data = str.match(exp_data);
				var m_phase = str.match(exp_phase);
				var m_time = str.match(exp_time);
				if(m_data && m_phase && m_time){
					return {
						type:20,
						time:m_time[1],
						number:m_phase[1],
						data:m_data[1].replace(/"/g, ''),
						correct:true,
					};
				}
			}catch(err){
				throw('北京PK10解析数据不正确');
			}
		}
	},
	{
		title:'北京PK10',
		source:'168KAI',
		name:'bjpk10',
		enable:true,
		timer:'bjpk10',
		option:{
			host:"api.1680210.com",
			timeout:30000,
			path: '/pks/getPksHistoryList.do?date=&lotCode=10001',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		parse:function(str){
			try{
					var strlen=298;
					str=str.substr(str.indexOf('errorCode'), strlen);
					var m;var i;
					var reg=/preDrawCode\D*([\d\,]*)\D*\d*\,\"preDrawTime\D*([\d\-\:\ ]*)\"\,\"preDrawIssue\D*(\d*)/;
					if(m=str.match(reg)){
						return {
							type:20,
							time:m[2],
							number:m[3],
							data:m[1],
							correct:true,
						};
					}
			}catch(err){
				throw('北京PK10解析数据不正确');
			}
		}
	},

	{
		title:'分分彩',
		source:'ffc',
		name:'ffc',
		enable:true,
		timer:'ffc',
		option:{
			host:"23.88.124.21",
			timeout:50000,
			path: '/index.php/xyylcp/xml3',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) "
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,200);
				var reg=/<row expect="([\d\-]+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/;
				var m;
				if(m=str.match(reg)){
					return {
						type:5,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('分分彩解析数据不正确');
			}
		}
	},
	{
		title:'两分彩',
		source:'lfc',
		name:'lfc',
		enable:true,
		timer:'lfc',
		option:{
			host:"23.88.124.21",
			timeout:50000,
			path: '/index.php/xyylcp/xml2',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) "
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,200);
				var reg=/<row expect="([\d\-]+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/;
				var m;
				if(m=str.match(reg)){
					return {
						type:26,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('两分彩解析数据不正确');
			}
		}
	},
	{
		title:'五分彩',
		source:'qtllc',
		name:'qtllc',
		enable:true,
		timer:'qtllc',

		option:{
			host:"23.88.124.21",
			timeout:50000,
			path: '/index.php/xyylcp/xml',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) "
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,200);
				var reg=/<row expect="([\d\-]+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/;
				var m;
				if(m=str.match(reg)){
					return {
						type:14,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('五分彩解析数据不正确');
			}
		}
	}

];

// 出错时等待 15
exports.errorSleepTime=15;

// 重启时间间隔，以小时为单位，0为不重启
//exports.restartTime=0.4;
exports.restartTime=1;

exports.submit={

	host:'localhost:8080',
	path:'/admin/778899.php/dataSource/kj'
}

exports.dbinfo={
	host:'localhost',
	user:'root',
    	password:'',// password:'gA~!@Ghangfjsx',
	database:'wanjinyule'
}

global.log=function(log){
	var date=new Date();
	console.log('['+date.toDateString() +' '+ date.toLocaleTimeString()+'] '+log)
}

function getFromXJFLCPWeb(str, type){
	// 2016-09-25 原本從list中取，但有跨日後tlist中的資料變成隔日後0085就取不到
	str=str.substr(str.indexOf('<div class="con_left con_left2" style="position:relative;"'), 500).replace(/[\r\n\t]+/g,'');
	// 2016-09-21 沒有時間，所以自建
	var myDate = new Date();
	var year = myDate.getFullYear();       //年
    var month = myDate.getMonth() + 1;     //月
    var day = myDate.getDate();            //日
	if(month < 10) month="0"+month;
	if(day < 10) day="0"+day;
	var mytime=year + "-" + month + "-" + day + " " +myDate.toLocaleTimeString();
	var reg=/[\s\S]*?<span>[\w\W\s\S](\d+)[\w\W\s\S]<\/span>[\s\S\w\W].*?<div[\s\S\w\W]*?kj_ball kj_ball_new">((?:[\s\S]*?<i>\d+<\/i>){5})[\s\S]*?<\/div>/,
	match=str.match(reg);
	if(!match) { log('解析新疆数据数据不正确' + str) };
	if(!match) throw new Error('数据不正确');
	if(match.length >1){
		try{
			var rule=match[1].replace(/ /,'').replace(/^(\d{8})(\d{2})$/, '$10$2');
			var numa=rule.substr(0,8);
			var numb=rule.substr(9,2);
			rule=numa+"-"+numb;
			var data={
				type:type,
				time:mytime, // 改為自行定義
				number:rule,
				correct:true // 20160921 告知不用處理
			}
			reg=/<i.*?>(\d+)<\/i>/g;
			data.data=match[2].match(reg).map(function(v){
				var reg=/<i.*?>(\d+)<\/i>/;
				return v.match(reg)[1];
			}).join(',');
			return data;
		}catch(err){
			throw('解析新疆数据失败');
		}
	}
}


function getFromCaileleWeb(str, type, slen){
	if(!slen) slen=500;
	str=str.substr(str.indexOf('<span class="cz_name">'),slen);
	//console.log(str);
	var reg=/<td.*?>(\d+)<\/td>[\s\S]*?<td.*?>([\d\- \:]+)<\/td>[\s\S]*?<td.*?>((?:[\s\S]*?<span class="red_ball">\d+<\/span>){3,5})\s*<\/td>/,
	match=str.match(reg);
	if(match.length>1){

		if(match[1].length==7) match[1]='2014'+match[1].replace(/(\d{4})(\d{3})/,'$1-$2');
		if(match[1].length==8){
			if(parseInt(type)!=11){
				match[1]='20'+match[1].replace(/(\d{6})(\d{2})/,'$1-0$2');
			}else{match[1]='20'+match[1].replace(/(\d{6})(\d{2})/,'$1-$2');}
		}
		if(match[1].length==9) match[1]='20'+match[1].replace(/(\d{6})(\d{2})/,'$1-$2');
		if(match[1].length==10) match[1]=match[1].replace(/(\d{8})(\d{2})/,'$1-0$2');
		var mynumber=match[1].replace(/(\d{8})(\d{3})/,'$1-$2');
	try{
		var data={
			type:type,
			time:match[2],
			number:mynumber
		}
		reg=/<div.*>(\d+)<\/div>/g;
		data.data=match[3].match(reg).map(function(v){
			var reg=/<div.*>(\d+)<\/div>/;
			return v.match(reg)[1];
		}).join(',');

		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
   }
}

function getFrom360CP(str, type){
	str=str.substr(str.indexOf('<em class="red" id="open_issue">'),380);
	//console.log(str);
	var reg=/[\s\S]*?(\d+)<\/em>[\s\S].*?<ul id="open_code_list">((?:[\s\S]*?<li class=".*?">\d+<\/li>){3,5})[\s\S]*?<\/ul>/,
	match=str.match(reg);
	var myDate = new Date();
	var year = myDate.getFullYear();       //年
    var month = myDate.getMonth() + 1;     //月
    var day = myDate.getDate();            //日
	if(month < 10) month="0"+month;
	if(day < 10) day="0"+day;
	var mytime=year + "-" + month + "-" + day + " " +myDate.toLocaleTimeString();
	//console.log(match);
	if(match.length>1){
		if(match[1].length==7) match[1]=year+match[1].replace(/(\d{8})(\d{3})/,'$1$2'); // 时时彩
		if(match[1].length==6) {match[1]=year+match[1].replace(/(\d{4})(\d{2})/,'$1$2');var numa=match[1].substr(0,8);var numb=match[1].substr(8,2);match[1]=numa+"0"+numb;} // 广东11选5
		if(match[1].length==9) match[1]='20'+match[1].replace(/(\d{6})(\d{2})/,'$1$2');
		if(match[1].length==10) match[1]=match[1].replace(/(\d{8})(\d{2})/,'$1$2');
		var mynumber=match[1].replace(/(\d{8})(\d{3})/,'$1$2');
		var numfront=mynumber.substr(0,8);
		var numend=mynumber.substr(8,3);
		mynumber=numfront+"-"+numend;
		try{
			var data={
				type:type,
				time:mytime,
				number:mynumber
			}
			reg=/<li class=".*?">(\d+)<\/li>/g;
			data.data=match[2].match(reg).map(function(v){
				var reg=/<li class=".*?">(\d+)<\/li>/;
				return v.match(reg)[1];
			}).join(',');
			//console.log(data);
			data.correct=true; // 20160921 告知不用處理
			return data;
		}catch(err){
			throw('解析数据失败');
		}
	}
}

function getFrom360CPK3(str, type){

	str=str.substr(str.indexOf('<em class="red" id="open_issue">'),380);
	//console.log(str);
	var reg=/[\s\S]*?(\d+)<\/em>[\s\S].*?<ul id="open_code_list">((?:[\s\S]*?<li class=".*?">\d+<\/li>){3,5})[\s\S]*?<\/ul>/,
	match=str.match(reg);
	var myDate = new Date();
	var year = myDate.getFullYear();       //年
    var month = myDate.getMonth() + 1;     //月
    var day = myDate.getDate();            //日
	if(month < 10) month="0"+month;
	if(day < 10) day="0"+day;
	var mytime=year + "-" + month + "-" + day + " " +myDate.toLocaleTimeString();
	//console.log(match);
	match[1]=match[1].replace(/(\d{4})(\d{2})/,'$1$2');

		try{
			var data={
				type:type,
				time:mytime,
				number:match[1]
			}

			reg=/<li class=".*?">(\d+)<\/li>/g;
			data.data=match[2].match(reg).map(function(v){
				var reg=/<li class=".*?">(\d+)<\/li>/;
				return v.match(reg)[1];
			}).join(',');

			//console.log(data);
			return data;
		}catch(err){
			throw('解析数据失败');
		}
}

function getFromPK10(str, type){
	str=str.substr(str.indexOf('<td class="winnumLeft">'),350).replace(/[\r\n]+/g,'');
	var reg=/<td class=".*?">(\d+)<\/td>[\s\S]*?<td>(.*)<\/td>[\s\S]*?<td class=".*?">([\d\:\- ]+?)<\/td>[\s\S]*?<\/tr>/,
	match=str.match(reg);
	if(!match) throw new Error('数据不正确');
	var myDate = new Date();
	var year = myDate.getFullYear();
	var mytime=year + "-" + match[3];
	try{
		var data={
			type:type,
			time:mytime,
			number:match[1],
			data:match[2]
		};
		return data;
	}catch(err){
		throw('解析数据失败');
	}

}

function getFromK8(str, type){

	str=str.substr(str.indexOf('<div class="lott_cont">'),450).replace(/[\r\n]+/g,'');
    //console.log(str);
	var reg=/<tr class=".*?">[\s\S]*?<td>(\d+)<\/td>[\s\S]*?<td>(.*)<\/td>[\s\S]*?<td>(.*)<\/td>[\s\S]*?<td>([\d\:\- ]+?)<\/td>[\s\S]*?<\/tr>/,
	match=str.match(reg);
	if(!match) throw new Error('数据不正确');
	//console.log(match);
	try{
		var data={
			type:type,
			time:match[4],
			number:match[1],
			data:match[2]+'|'+match[3]
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}

}


function getFromCJCPWeb(str, type){

	//console.log(str);
	str=str.substr(str.indexOf('<table class="qgkj_table">'),1200);

	//console.log(str);

	var reg=/<tr>[\s\S]*?<td class=".*">(\d+).*?<\/td>[\s\S]*?<td class=".*">([\d\- \:]+)<\/td>[\s\S]*?<td class=".*">((?:[\s\S]*?<input type="button" value="\d+" class=".*?" \/>){3,5})[\s\S]*?<\/td>/,
	match=str.match(reg);

	//console.log(match);

	if(!match) throw new Error('数据不正确');
	try{
		var data={
			type:type,
			time:match[2],
			number:match[1].replace(/(\d{8})(\d{2})/,'$1-0$2')
		}

		reg=/<input type="button" value="(\d+)" class=".*?" \/>/g;
		data.data=match[3].match(reg).map(function(v){
			var reg=/<input type="button" value="(\d+)" class=".*?" \/>/;
			return v.match(reg)[1];
		}).join(',');

		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}

}

function getFromCaileleWeb_1(str, type){
	str=str.substr(str.indexOf('<tbody id="openPanel">'), 120).replace(/[\r\n]+/g,'');

	var reg=/<tr.*?>[\s\S]*?<td.*?>(\d+)<\/td>[\s\S]*?<td.*?>([\d\:\- ]+?)<\/td>[\s\S]*?<td.*?>([\d\,]+?)<\/td>[\s\S]*?<\/tr>/,
	match=str.match(reg);
	if(!match) throw new Error('数据不正确');
	//console.log(match);
	var number,_number,number2;
	var d = new Date();
	var y = d.getFullYear();
	if(match[1].length==9 || match[1].length==8){number='20'+match[1];}else if(match[1].length==7){number='2014'+match[1];}else{number=match[1];}
	_number=number;
	if(number.length==11){number2=number.replace(/^(\d{8})(\d{3})$/, '$1-$2');}else{number2=number.replace(/^(\d{8})(\d{2})$/, '$1-0$2');_number=number.replace(/^(\d{8})(\d{2})$/, '$10$2');}
	try{
		var data={
			type:type,
			time:_number.replace(/^(\d{4})(\d{2})(\d{2})\d{3}/, '$1-$2-$3 ')+match[2],
			number:number2,
			data:match[3]
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}

function getFrom360sd11x5(str, type){

	str=str.substr(str.indexOf('<em class="red" id="open_issue">'),380);
	//console.log(str);
	var reg=/[\s\S]*?(\d+)<\/em>[\s\S].*?<ul id="open_code_list">((?:[\s\S]*?<li class=".*?">\d+<\/li>){3,5})[\s\S]*?<\/ul>/,
	match=str.match(reg);
	var myDate = new Date();
	var year = myDate.getFullYear();       //年
    var month = myDate.getMonth() + 1;     //月
    var day = myDate.getDate();            //日
	if(month < 10) month="0"+month;
	if(day < 10) day="0"+day;
	var mytime=year + "-" + month + "-" + day + " " +myDate.toLocaleTimeString();
	//console.log(mytime);
	//console.log(match);

	if(!match) throw new Error('数据不正确');
	try{
		var rule=match[1].replace(/(\d{4})(\d{2})/,'$1$2');
		var ruleone=rule.substr(0,4);
		var ruletwo=rule.substr(4,2);
		rule=ruleone+"-0"+ruletwo;
		var data={
			type:type,
			time:mytime,
			number:year+rule
		}

		reg=/<li class=".*?">(\d+)<\/li>/g;
		data.data=match[2].match(reg).map(function(v){
			var reg=/<li class=".*?">(\d+)<\/li>/;
			return v.match(reg)[1];
		}).join(',');

		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}

function getFromCaileleWeb_2(str, type){

	str=str.substr(str.indexOf('<tbody id="openPanel">'), 500).replace(/[\r\n]+/g,'');
	//console.log(str);
	var reg=/<tr>[\s\S]*?<td>(\d+)<\/td>[\s\S]*?<td>([\d\:\- ]+?)<\/td>[\s\S]*?<td>([\d\,]+?)<\/td>[\s\S]*?<\/tr>/,
	match=str.match(reg);
	if(!match) throw new Error('数据不正确');
	//console.log(match);
	var number,_number,number2;
	var d = new Date();
	var y = d.getFullYear();
	if(match[1].length==9 || match[1].length==8){number='20'+match[1];}else if(match[1].length==7){number='2014'+match[1];}else{number=match[1];}
	_number=number;
	if(number.length==11){number2=number.replace(/^(\d{8})(\d{3})$/, '$1-$2');}else{number2=number.replace(/^(\d{8})(\d{2})$/, '$1-0$2');_number=number.replace(/^(\d{8})(\d{2})$/, '$10$2');}
	try{
		var data={
			type:type,
			time:_number.replace(/^(\d{4})(\d{2})(\d{2})\d{3}/, '$1-$2-$3 ')+match[2],
			number:number2,
			data:match[3]
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}

function getFromfrgcsc(str, type){
	str=str.substr(str.indexOf('<th>开奖号码</th>'),380);
	//console.log(str);
	//var reg=/<th>[\s\S]*?<\/th>[\s\S]*?<\/tr>[\s\S]*?<\/thead>[\s\S]*?<tbody>[\s\S]*?<tr>[\s\S]*?<td>(\d+)<\/td>[\s\S]*?<td>([\d\,]+?)<\/td>[\s\S]*?<\/tr>/,
	var reg=/<th>[\s\S]*?<\/th>[\s\S]*?<\/tr>[\s\S]*?<\/thead>[\s\S]*?<tbody>[\s\S]*?<tr>[\s\S]*?<td>([\d+\-]+?)<\/td>[\s\S]*?<td>([\d\,]+?)<\/td>[\s\S]*?<\/tr>/,
	match=str.match(reg);
	//console.log(match);
	var myDate = new Date();
	var year = myDate.getFullYear();       //年
    var month = myDate.getMonth() + 1;     //月
    var day = myDate.getDate();            //日
	if(month < 10) month="0"+month;
	if(day < 10) day="0"+day;
	var mytime=year + "-" + month + "-" + day + " " +myDate.toLocaleTimeString();
	//console.log(match);
		var mynumber=match[1].replace(/(\d{8})(\d{3})/,'$1-$2');
		try{
			var data={
				type:type,
				time:mytime,
				number:mynumber,
				data:match[2]
			}
			return data;
		}catch(err){
			throw('解析数据失败');
		}
}