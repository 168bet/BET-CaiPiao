// 彩票开奖配置
exports.cp=[
	
	{
		title:'重庆时时彩',
		source:'网站',
		name:'cqssc',
		enable:true,
		timer:'cqssc',

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/cqssc.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,5);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:1,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('重庆时时彩解析数据不正确');
			}
		}
	},////////////
	
	{
		title:'江西时时彩',
		source:'江西娱乐平台',
		name:'jxssc',
		enable:true,
		timer:'jxssc',
 

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/jxssc.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:3,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('江西时时彩解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{

                                 title:'北京快乐8',
		source:'163',
		name:'bjk8',
		enable:true,
		timer:'bjk8',

		option:{
			host:"caipiao.163.com",
			timeout:30000,
			path: '/award/award_kl8Json.html',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,146).split('","').join(',');
				var reg=/\[\{no:\["([\d\,]+?)"\],fp:(\d+?),pd:"(\d+?)",time:"([\d\:\- ]+?)"/; 
				//[{no:["05,06,07,08,11,20,28,34,37,38,43,48,49,50,51,59,60,61,66,80"],fp:2,pd:"583223",time:"08-13 18:50:00"}
				var m;
			  dat=new Date();
				preYear=dat.getFullYear();
	
				if(m=str.match(reg)){
					return {
						type:24,
						time:preYear+'-'+m[4],
						number:m[3],
						data:m[1]
					};
				}					
			}catch(err){
				throw('北京快乐8解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{

                 title:'吉林快3娱乐平台',
		source:'吉林快3娱乐平台',
		name:'jlk3',
		enable:true,
		timer:'jlk3',
 

		option:{
			host:"127.0.0.1",
			timeout:50000,
			path: '/xml/jlk3.xml?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:30,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('吉林快3解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{

               title:'江苏快三',
		source:'江苏快三平台',
		name:'jsk3',
		enable:true,
		timer:'jsk3',
 

		option:{
			host:"www.cailele.com",
			timeout:50000,
			path: '/static/k3/newlyopenlist.xml?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:25,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('江苏快三解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{   
                title:'天津时时彩',
		source:'天津娱乐平台',
		name:'tjssc',
		enable:true,
		timer:'tjssc',
 

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/tjssc.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:35,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('天津时时彩解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{   
                title:'上海时时乐',
		source:'上海时时乐',
		name:'shssl',
		enable:true,
		timer:'shssl',
 

		option:{
			host:"127.0.0.1",
			timeout:50000,
			path: '/xml/ssl.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:11,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('上海时时乐解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{   
                title:'吉林快3娱乐平台',
		source:'吉林快3娱乐平台',
		name:'jsk3',
		enable:true,
		timer:'jsk3',
 

		option:{
			host:"www.cailele.com",
			timeout:50000,
			path: '/static/jlk3/newlyopenlist.xml?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:30,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('吉林快3解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{
         title:'湖北快3娱乐平台',
		source:'湖北快3娱乐平台',
		name:'hbk3',
		enable:true,
		timer:'hbk3',
 

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/hbks.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:50,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('湖北快3解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{
		 title:'广西快3娱乐平台',
		source:'广西快3娱乐平台',
		name:'gxk3',
		enable:true,
		timer:'gxk3',
 

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/gxks.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:52,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('广西快3解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{
		 title:'内蒙古快3娱乐平台',
		source:'内蒙古快3娱乐平台',
		name:'nmgk3',
		enable:true,
		timer:'nmgk3',
 

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/nmgks.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:51,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('内蒙古快3解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{
		title:'上海快3娱乐平台',
		source:'上海快3娱乐平台',
		name:'shk3',
		enable:true,
		timer:'shk3',
 

		option:{
			host:"cj.16983110.com",
			timeout:50000,
			path: '/xml/shks.php?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:49,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('上海快3解析数据不正确');
			}
		}
	},////////////
	
	//{{{
	{
		title:'新疆时时彩',
		source:'新疆娱乐平台',
		name:'xjssc',
		enable:true,
		timer:'xjssc',

		option:{
			host:"www.xjflcp.com",
			timeout:50000,
			path: '/ssc/',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		
		parse:function(str){
			return getFromXJFLCPWeb(str,12);
		}
	},
	//{{{
	{
		title:'福彩3D',
		source:'福彩3D娱乐平台',
		name:'fc3d',
		enable:true,
		timer:'fc3d',

		option:{
			host:"www.500wan.com",
			timeout:50000,
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
		source:'排列3娱乐平台',
		name:'pai3',
		enable:true,
		timer:'pai3',

		option:{
			host:"www.500wan.com",
			timeout:50000,
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
	//}}}
	
	{
		title:'重庆11选5',
		source:'重庆11选5官网',
		name:'cq11x5',
		enable:true,
		timer:'cq11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/cq11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:15,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('重庆11选5解析数据不正确');
			}
		}
	},////////////
	
	{
                                    title:'天津11选5',
		source:'天津11选5官网',
		name:'tj11x5',
		enable:true,
		timer:'tj11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/tj11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:44,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('天津11选5解析数据不正确');
			}
		}
	},////////////
	
	{
                                    title:'湖北11选5',
		source:'湖北11选5官网',
		name:'hb11x5',
		enable:true,
		timer:'hb11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/hb11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:41,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('湖北11选5解析数据不正确');
			}
		}
	},////////////
	
	{

                                   title:'贵州11选5',
		source:'贵州11选5官网',
		name:'gz11x5',
		enable:true,
		timer:'gz11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/gz11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:40,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('贵州11选5解析数据不正确');
			}
		}
	},////////////
	
	{
                  title:'浙江11选5',
		source:'浙江11选5官网',
		name:'zj11x5',
		enable:true,
		timer:'zj11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/zj11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:45,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('浙江11选5解析数据不正确');
			}
		}
	},////////////
	
	{
                title:'安徽11选5',
		source:'安徽11选5官网',
		name:'ah11x5',
		enable:true,
		timer:'ah11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/ah11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:48,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('安徽11选5解析数据不正确');
			}
		}
	},////////////
	
	{
                 title:'安徽快3',
		source:'安徽快3',
		name:'ahk3',
		enable:true,
		timer:'ahk3',

		option:{
			host:"127.0.0.1",
			timeout:30000,
			path: '/xml/ahk3.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:39,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('安徽快3解析数据不正确');
			}
		}
	},////////////
	
	{
                title:'江苏11选5',
		source:'官网',
		name:'js11x5',
		enable:true,
		timer:'js11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/js11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,7);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:43,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('江苏11选5解析数据不正确');
		        }
		}
	},////////////
	
	{
                 title:'广东快乐十分',
		source:'cailele',
		name:'gdklsf',
		enable:true,
		timer:'gdklsf',

		option:{
			host:"www.cailele.com",
			timeout:50000,
			path: '/lottery/klsf/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				return getFromCaileleWeb_2(str,17);
			}catch(err){
				//throw('广东快乐十分解析数据不正确')
			}
		}
	},////////////
	
	{

                                   title:'重庆快乐10分',
		source:'重庆快乐10分',
		name:'cqklsf',
		enable:true,
		timer:'cqklsf',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/cqklsf.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:18,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('重庆快乐10分解析数据不正确');
			}
		}
	},////////////
	
	{

                                  title:'天津快乐10分',
		source:'天津快乐10分',
		name:'tjklsf',
		enable:true,
		timer:'tjklsf',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/tjklsf.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:46,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('天津快乐10分解析数据不正确');
			}
		}
	},////////////
	
	{

                title:'湖南快乐10分',
		source:'湖南快乐10分',
		name:'hnklsf',
		enable:true,
		timer:'hnklsf',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/hnklsf/newlyopenlist.xml?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:27,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('湖南快乐10分解析数据不正确');
			}
		}
	},////////////
	
	{
                 title:'上海11选5',
		source:'上海11选5官网',
		name:'sh11x5',
		enable:true,
		timer:'sh11x5',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/sh11x5/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:22,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('上海11选5解析数据不正确');
			}
		}
	},////////////
	
	{
                title:'吉林11选5',
		source:'吉林11选5官网',
		name:'jl11x5',
		enable:true,
		timer:'jl11x5',

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/jl11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,15);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:42,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('吉林11选5解析数据不正确');
			}
		}
	},////////////
	
	{
		title:'广东11选5',
		source:'广东娱乐平台',
		name:'gd11x5',
		enable:true,
		timer:'gd11x5',

 

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/gd11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,6);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:6,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				//throw('广东11选5解析数据不正确');
			}
		}
	},
	//}}}

	{
                                  title:'山东11选5',
		source:'山东娱乐平台',
		name:'sd11x5',
		enable:true,
		timer:'sd11x5',

 

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/sd11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,6);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:7,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				//throw('山东11选5解析数据不正确');
			}
		}
	},
	//}}}

	{
		title:'江西11选5',
		source:'江西11选5娱乐平台',
		name:'jx11x5',
		enable:true,
		timer:'jx11x5',
 

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/jx11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,146);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:16,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				//throw('江西多乐彩解析数据不正确');
			}
		}
	},////////
	
	//{{{
	{
                 title:'黑龙江11选5',
		source:'黑龙江11选5平台',
		name:'hlj11x5',
		enable:true,
		timer:'hlj11x5',
 

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/hlj11x5/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,146);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:28,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				//throw('黑龙江11选5解析数据不正确');
			}
		}
	},////////
	
	//{{{
	{
         title:'辽宁11选5',
		source:'辽宁11选5娱乐平台',
		name:'ln11x5',
		enable:true,
		timer:'ln11x5',
 

		option:{
			host:"cj.16983110.com",
			timeout:30000,
			path: '/xml/ln11x5.php/?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,146);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:23,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				//throw('辽宁11选5解析数据不正确');
			}
		}
	},////////
	
	//{{{
	{
		 title:'香港六合彩',
		source:'香港六合彩',
		name:'xglhc',
		enable:true,
		timer:'xglhc',
 

		option:{
			host:"www.14444.net",
			timeout:30000,
			path: '/lotterydata.xml?ac=ssc',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,146);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				var m;
	
				if(m=str.match(reg)){
					return {
						type:59,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				//throw('香港六合彩解析数据不正确');
			}
		}
	},////////
	
	//{{{
	{
		title:'北京PK10',
		source:'北京PK10平台',
		name:'bjpk10',
		enable:true,
		timer:'bjpk10',

		option:{

			host:"www.bwlc.net",
			timeout:50000,
			path: '/bulletin/trax.html',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)"
			}
		},
		
		parse:function(str){
			try{
				return getFromPK10(str,20);
			}catch(err){
				throw('北京PK10解析数据不正确');
			}
		}
	},////////
	
	//{{{
	{
		title:'全天快三',
		source:'qtks',
		name:'qtks',
		enable:true,
		timer:'qtks',

		option:{
			host:"127.0.0.1",
			timeout:50000,
			path: '/index.php/xyylcp/xml5',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) "
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,200);
				
				var reg=/<row expect="([\d\-]+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="20130720017" opencode="4,9,1,2,9" opentime="2013-07-20 01:25:30"/>
				
				var m;
				if(m=str.match(reg)){
					return {
						type:60,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}					
				
			}catch(err){
				throw('全天快三解析数据不正确');
			}
		}
	},
//}}}

//{{{
	{ 
		title:'五分彩',
		source:'qtllc',
		name:'qtllc',
		enable:true,
		timer:'qtllc',

		option:{
			host:"php2.zrd-w.com",
			timeout:50000,
			path: '/xml',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) "
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,200);
				
				var reg=/<row expect="([\d\-]+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="20130720017" opencode="4,9,1,2,9" opentime="2013-07-20 01:25:30"/>
				
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
	},
//}}}

//{{{
	{ 
		title:'两分彩',
		source:'lfc',
		name:'lfc',
		enable:true,
		timer:'lfc',

		option:{
			host:"127.0.0.1",
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
				//<row expect="20130720017" opencode="4,9,1,2,9" opentime="2013-07-20 01:25:30"/>
				
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
//}}}

//{{{
	{
		title:'快速六合彩',
		source:'lhc',
		name:'lhc',
		enable:true,
		timer:'lhc',

		option:{
			host:"127.0.0.1",
			timeout:50000,
			path: '/index.php/xyylcp/xml4',
			headers:{
				"User-Agent": "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) "
			}
		},
		parse:function(str){
			try{
				str=str.substr(0,200);
				
				var reg=/<row expect="([\d\-]+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="20130720017" opencode="12,39,30,27,30,11,15" opentime="2013-07-20 01:25:30"/>
				
				var m;
				if(m=str.match(reg)){
					return {
						type:55,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}					
				
			}catch(err){
				throw('快速六合彩解析数据不正确');
			}
		}
	},
//}}}

//{{{
	{
		title:'分分彩',
		source:'ffc',
		name:'ffc',
		enable:true,
		timer:'ffc',
		option:{
			host:"127.0.0.1",
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
//}}}
	
];

// 出错时等待 15
exports.errorSleepTime=15;

// 重启时间间隔，以小时为单位，0为不重启
//exports.restartTime=0.4;
exports.restartTime=0;

exports.submit={

	host:'127.0.0.1',
	path:'/admin778899.php/dataSource/kj'
}

exports.dbinfo={
	host:'127.0.0.1',
	user:'root',
	password:'root',
	database:'xy_yule'

}

global.log=function(log){
	var date=new Date();
	console.log('['+date.toDateString() +' '+ date.toLocaleTimeString()+'] '+log)
}

function getFromXJFLCPWeb(str, type){
	str=str.substr(str.indexOf('<td><a href="javascript:detatilssc'), 300).replace(/[\r\n]+/g,'');
         
	var reg=/(\d{10}).+(\d{2}\:\d{2}).+<p>([\d ]{9})<\/p>/,
	match=str.match(reg);
	
	if(!match) throw new Error('数据不正确');
	//console.log('期号：%s，开奖时间：%s，开奖数据：%s', match[1], match[2], match[3]);
	
	try{
		var data={
			type:type,
			time:match[1].replace(/^(\d{4})(\d{2})(\d{2})\d{2}/, '$1-$2-$3 ')+match[2],
			number:match[1].replace(/^(\d{8})(\d{2})$/, '$1-$2'),
			data:match[3].split(' ').join(',')
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}


function getFromCaileleWeb(str, type, slen){
	if(!slen) slen=380;
	str=str.substr(str.indexOf('<tr bgcolor="#FFFAF3">'),slen);
	//console.log(str);
	var reg=/<td.*?>(\d+)<\/td>[\s\S]*?<td.*?>([\d\- \:]+)<\/td>[\s\S]*?<td.*?>((?:[\s\S]*?<div class="ball_yellow">\d+<\/div>){3,5})\s*<\/td>/,
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
		
		if(match[1].length==7) match[1]='2014'+match[1].replace(/(\d{4})(\d{3})/,'$1-$2');
		if(match[1].length==8) match[1]='20'+match[1].replace(/(\d{6})(\d{2})/,'$1-0$2');
		if(match[1].length==9) match[1]='20'+match[1].replace(/(\d{6})(\d{2})/,'$1-$2');
		if(match[1].length==10) match[1]=match[1].replace(/(\d{8})(\d{2})/,'$1-0$2');
		var mynumber=match[1].replace(/(\d{8})(\d{3})/,'$1-$2');
		
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
			return data;
		}catch(err){
			throw('解析数据失败');
		}
	}
}

function getFromPK10(str, type){

	str=str.substr(str.indexOf('<div class="lott_cont">'),350).replace(/[\r\n]+/g,'');
    //console.log(str);
	var reg=/<tr class=".*?">[\s\S]*?<td>(\d+)<\/td>[\s\S]*?<td>(.*)<\/td>[\s\S]*?<td>([\d\:\- ]+?)<\/td>[\s\S]*?<\/tr>/,
	match=str.match(reg);
	if(!match) throw new Error('数据不正确');
	//console.log(match);
	try{
		var data={
			type:type,
			time:match[3],
			number:match[1],
			data:match[2]
		};
		//console.log(data);
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
		var data={
			type:type,
			time:mytime,
			number:match[1].replace(/(\d{8})(\d{2})/,'$1-0$2')
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