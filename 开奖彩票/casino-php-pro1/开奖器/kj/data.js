var played={}, mysql=require('mysql'),
http=require('http'),
url=require('url'),
crypto=require('crypto'),
querystring=require('querystring'),
config=require('./config.js'),
calc=require('./kj-data/kj-calc-time.js'),
exec=require('child_process').exec,
execPath=process.argv.join(" "),
parse=require('./kj-data/parse-calc-count.js');
require('./String-ext.js');

// 抛出未知出错时处理
process.on('uncaughtException', function(e){
	console.log(e.stack);
});

// 自动重启
if(config.restartTime){
	setTimeout(function(exec, execPath){
		exec(execPath);
		process.exit(0);
	}, config.restartTime * 3600 * 1000, exec, execPath);
}

var timers={};		// 任务记时器列表
var encrypt_key='cc40bfe6d972ce96fe3a47d0f7342cb0';

http.request=(function(_request){
	return function(options,callback){
		var timeout=options['timeout'],
			timeoutEventId;
		var req=_request(options,function(res){
			res.on('end',function(){
				clearTimeout(timeoutEventId);
				//console.log('response end...');
			});
			
			res.on('close',function(){
				clearTimeout(timeoutEventId);
				//console.log('response close...');
			});
			
			res.on('abort',function(){
				//console.log('abort...');
			});
			
			callback(res);
		});
		
		//超时
		req.on('timeout',function(){
			//req.res && req.res.abort();
			//req.abort();
			req.end();
		});
		
		//如果存在超时
		timeout && (timeoutEventId=setTimeout(function(){
			req.emit('timeout',{message:'have been timeout...'});
		},timeout));
		return req;
	};
})(http.request);

//console.log(config);
getPlayedFun(runTask);

//{{{
function getPlayedFun(cb){
	try{
		var client=createMySQLClient();
	}catch(err){
		log(err);
		return;
	}
	
	client.query("select id, ruleFun from ssc_played", function(err, data){
		if(err){
			log('读取玩法配置出错：'+err.message);
		}else{
			data.forEach(function(v){
				played[v.id]=v.ruleFun;
			});
			
			if(cb) cb();
		}
	});
	
	client.end();
}

function runTask(){
	if(config.cp.length) config.cp.forEach(function(conf){
		timers[conf.name]={};
		timers[conf.name][conf.timer]={timer:null, option:conf};
		try{
			if(conf.enable) run(conf);
		}catch(err){
			//timers[conf.name][conf.timer].timer=setTimeout(run, config.errorSleepTime*1000, conf);
			restartTask(conf, config.errorSleepTime);
		}
	});	
}

function restartTask(conf, sleep, flag){
	
	if(sleep<=0) sleep=config.errorSleepTime;
	
	if(!timers[conf.name]) timers[conf.name]={};
	if(!timers[conf.name][conf.timer]) timers[conf.name][conf.timer]={timer:null,option:conf};
	
	if(flag){
		var opt;
		for(var t in timers[conf.name]){
			opt=timers[conf.name][t].option;
			clearTimeout(timers[opt.name][opt.timer].timer);
			timers[opt.name][opt.timer].timer=setTimeout(run, sleep*1000, opt);
			log('休眠'+sleep+'秒后从'+opt.source+'采集'+opt.title+'数据...');
		}
	}else{
		clearTimeout(timers[conf.name][conf.timer].timer);
		timers[conf.name][conf.timer].timer=setTimeout(run, sleep*1000, conf);
		log('休眠'+sleep+'秒后从'+conf.source+'采集'+conf.title+'数据...');
	}
}

function run(conf){
	//console.log(timers);
	if(timers[conf.name][conf.timer].timer) clearTimeout(timers[conf.name][conf.timer].timer);
	//console.log(timers);
	
	log('开始从'+conf.source+'采集'+conf.title+'数据');
	var option=JSON.parse(JSON.stringify(conf.option));
	//option.path+='?'+(new Date()).getTime();
	
	http.request(option, function(res){
		
		var data="";
		res.on("data", function(_data){
			//console.log(_data.toString());
			data+=_data.toString();
		});
		
		res.on("end", function(){

			try{
				try{
					//data=onparse[conf.name](data);
					data=conf.parse(data);
				}catch(err){
					throw('解析'+conf.title+'数据出错：'+err);
				}
				
				//console.log(data);

				try{
					if(data.type=='14' || data.type=='26' || data.type=='5'){
						liRunData(data, conf);
					}else{
						submitData(data, conf);
					}
				}catch(err){
					//console.log(err);
					throw('提交出错：'+err);
				}
				
			}catch(err){
				log('运行出错：%s，休眠%f秒'.format(err, config.errorSleepTime));
				restartTask(conf, config.errorSleepTime);
			}
			
		});
		
		res.on("error", function(err){

			log(err);
			restartTask(conf, config.errorSleepTime);

		});
		
	}).on('timeout', function(err){
		log('从'+conf.source+'采集'+conf.title+'数据超时');
		restartTask(conf, config.errorSleepTime);
	}).on("error", function(err){
		// 一般网络出问题会引起这个错
		
		log(err);
		restartTask(conf, config.errorSleepTime);
		
	}).end();
}

//}}}

function submitData(data, conf){
	log('提交从'+conf.source+'采集的'+conf.title+'第'+data.number+'数据：'+data.data);
	
	try{
		var client=mysql.createClient(config.dbinfo);
	}catch(err){
		throw('连接数据库失败');
	}
	
	data.time=Math.floor((new Date(data.time)).getTime()/1000);
	//alert(110);
	client.query("insert into ssc_data(type, time, number, data) values(?,?,?,?)", [data.type, data.time, data.number, data.data], function(err, result){
		//console.log(err);
		if(err){
			//console.log(err);
			// 普通出错
			if(err.number==1062){
				// 数据已经存在
				// 正常休眠
				//console.log(calc[conf.name]);
				try{
					sleep=calc[conf.name](data);
					//console.log(sleep);
					if(sleep<0) sleep=config.errorSleepTime*1000;
				}catch(err){
					//console.log(err);
					restartTask(conf, config.errorSleepTime);
					return;
				}
				log(conf['title']+'第'+data.number+'期数据已经存在数据');
				//timers[conf.name][conf.timer].timer=setTimeout(run, sleep, conf);
				restartTask(conf, sleep/1000, true);

			}else{
				log('运行出错：'+err.message);
				restartTask(conf, config.errorSleepTime);
			}
		}else if(result){
			// 正常
			try{
				sleep=calc[conf.name](data);
			}catch(err){
				log('解析下期数据出错：'+err);
				restartTask(conf, config.errorSleepTime);
				return;
			}
			log('写入'+conf['title']+'第'+data.number+'期数据成功');
			restartTask(conf, sleep/1000, true);
			setTimeout(calcJ, 500, data);
		}else{
			global.log('未知运行出错');
			restartTask(conf, config.errorSleepTime);
		}
	});
	client.end();
}

function liRunData(data, conf){
	var bjAmount = 0,zjAmount = 0;
	getLiRunLv();
	var client=createMySQLClient();
	client.query("select * from ssc_bets where type=? and actionNo=? and isDelete=0 and lotteryNo=''", [data.type, data.number], function(err, bets){
		if(err){
			log("读取投注出错："+err);
		}else{
			bets.forEach(function(bet){
				var fun;
				try{
					fun=parse[played[bet.playedId]];
					if(typeof fun!='function') throw new Error('算法不是可用的函数');
				}catch(err){
					log('计算玩法[%f]中奖号码算法不可用：%s'.format(bet.playedId, err.message));
					return;
				}
				try{
					var zjCount=fun(bet.actionData, data.data, bet.weiShu)||0;
					bjAmount+=Math.floor(bet.actionNum)*Math.floor(bet.mode)*Math.floor(bet.beiShu);
					zjAmount+=Math.floor(bet.bonusProp)*Math.floor(zjCount)*Math.floor(bet.beiShu)*Math.floor(bet.mode/2);
				}catch(err){
					log('计算中奖号码时出错：'+err);
					return;
				}
			});
				if(bjAmount*Math.abs(1-Math.floor(LiRunLv)/100)<zjAmount){
					restartTask(conf, 1);
				}else{
					submitData(data, conf);
				}
			}
	});
	client.end();
}

function getLiRunLv(){
	var client=createMySQLClient();
	client.query("select value from ssc_params where name='LiRunLv'", function(err, data){
		if(err){
			LiRunLv=0;
		}else{
			data.forEach(function(v){
				LiRunLv=v.value;
			});
		}
	});
	client.end();
}

function requestKj(type,number){
	var option={
		host:config.submit.host,
		path:'%s/%s/%s/%'.format(config.submit.path, type, number)
	}
	http.get(config.submit,function(res){
	
	});
}

function createMySQLClient(){
	try{
		return mysql.createClient(config.dbinfo).on('error', function(err){
			//console.log(err);
			throw('连接数据库失败');
		});
	}catch(err){
		log('连接数据库失败：'+err);
		return false;
	}
}

function calcJ(data, flag){
	var client=createMySQLClient();
	sql="select * from ssc_bets where type=? and actionNo=? and isDelete=0";
	if(flag) sql+=" and lotteryNo=''";
	
	client.query(sql, [data.type, data.number], function(err, bets){
		if(err){
			//console.log(data);
			//console.log(err.sql);
			log("读取投注出错："+err);
		}else{
			var sql, sqls=[];
			sql='call kanJiang(?, ?, ?, ?)';
			
			bets.forEach(function(bet){
				var fun;
				
				try{
					fun=parse[played[bet.playedId]];
					//console.log(played[bet.playedId]);
					if(typeof fun!='function') throw new Error('算法不是可用的函数');
				}catch(err){
					log('计算玩法[%f]中奖号码算法不可用：%s'.format(bet.playedId, err.message));
					return;
				}
				
				try{
					var zjCount=fun(bet.actionData, data.data, bet.weiShu)||0;
				}catch(err){
					log('计算中奖号码时出错：'+err);
					return;
				}
				
				sqls.push(client.format(sql, [bet.id, zjCount, data.data, 'ssc-'+encrypt_key]));

			});
			
			try{
				setPj(sqls, data);
			}catch(err){
				log(err);
			}
		}
	});

	client.end();
}

function setPj(sqls, data){
	if(sqls.length==0) throw('彩种[%f]第%s期没有投注'.format(data.type, data.number));
	
	var client=createMySQLClient();
	if(client==false){
		log('连接数据库出错，休眠%f秒继续...'.format(config.errorSleepTime));
		setTimeout(setPj, config.errorSleepTime*1000, sqls, data);
	}else{
		client.query(sqls.join(';'), function(err,result){
			if(err){
				console.log(err);
			}else{
				log('成功');
			}
		});
		
		client.end();
	}
	
}

// 前台添加数据接口
http.createServer(function(req, res){
	
	log('前台访问'+req.url);
	var data='';
	req.on('data', function(_data){
		data+=_data;
	}).on('end', function(){
		data=querystring.parse(data);
		var msg={},
			hash=crypto.createHash('md5');
		hash.update(data.key);
		
		//console.log(data);
		if(encrypt_key==hash.digest('hex')){
			delete data.key;
			if(req.url=='/data/add'){
				submitDataInput(data);
			}else if(req.url=='/data/kj'){
				//console.log(data);
				calcJ(data, true)
			}
		}else{
			msg.errorCode=1;
			msg.errorMessage='校验不通过';
		}
		
		res.writeHead(200, {"Content-Type": "text/json"});
		res.write(JSON.stringify(msg));
		res.end();
	});
	
}).listen(8800);

function submitDataInput(data){
	log('提交从前台录入第'+data.number+'数据：'+data.data);
	
	try{
		var client=mysql.createClient(config.dbinfo);
	}catch(err){
		throw('连接数据库失败');
	}
	
	data.time=Math.floor((new Date(data.time)).getTime()/1000);
	client.query("insert into ssc_data(type, time, number, data) values(?,?,?,?)", [data.type, data.time, data.number, data.data], function(err, result){
		if(err){
			//console.log(err);
			// 普通出错
			if(err.number==1062){
				// 数据已经存在
				log('第'+data.number+'期数据已经存在数据');

			}else{
				log('运行出错：'+err.message);
			}
		}else if(result){
			// 正常
			log('写入第'+data.number+'期数据成功');

			// 计算奖品
			//setTimeout(requestKj, 500, data.type, data.number);
			setTimeout(calcJ, 500, data);
		}else{
			global.log('未知运行出错');
		}
	});

	client.end();
}








