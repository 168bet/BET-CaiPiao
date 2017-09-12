CP.JCDG = (function() {
	var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	 //获取彩种类型
	/*全局变量[[*/
    var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//彩种
    var lotteryPlayName = 'hh';//混投单关
    var $item = $('#item');//对阵dom
    var $dom = {
			$dobuy : $('#dobuy'),//代购按钮
			$dohm : $('#dohm'),//发起合买按钮
			$hmSubmit : $('#hmSubmit')//提交合买按钮
		};
    /*]]全局变量*/
    
    var jczq  =  {
		spf : {'3':'0','1':'1','0':'2'},
		rq :  {'3':'0','1':'1','0':'2'},
		bf :  {'1:0':'0','2:0':'1','2:1':'2','3:0':'3','3:1':'4','3:2':'5','4:0':'6','4:1':'7','4:2':'8','5:0':'9','5:1':'10','5:2':'11','9:0':'12',
			'0:0':'13','1:1':'14','2:2':'15','3:3':'16','9:9':'17',
			'0:1':'18','0:2':'19','1:2':'20','0:3':'21','1:3':'22','2:3':'23','0:4':'24','1:4':'25','2:4':'26','0:5':'27','1:5':'28','2:5':'29','0:9':'30'},
		jq :  {'0':'0','1':'1','2':'2','3':'3','4':'4','5':'5','6':'6','7':'7'},
        bqc : {'3-3':'0','3-1':'1','3-0':'2','1-3':'3','1-1':'4','1-0':'5','0-3':'6','0-1':'7','0-0':'8'}
	};
	var codeHeader = 'HH';
	var  g = {
        money : 0, //无倍投时的金额 即1倍时的
        bet : 1, //当前选择了多少倍数
        count : 0, //当前选择了多少注
        spArr : [],//每一排选了几个号 用于计算注数
        pass : [],//过关方式 如：[2,3] 表示选了2串1 3串1 
        amount : 0, //当前投注总金额金额  不代表合买应付金额
        hmMoney : 0,//合买应付金额
        bonus : 0,//理论奖金范围
        curChangCi : 0, //已选多少场次
        buyType : 1,//1:自购 2:合买
        codes : '',//投注code
		loty_id : '70', //彩种id
		qihao_id : ''//当前期号
    };
    var error = '至少选择1场比赛';
	//对阵数据
    var againstData =[];

//计算理论奖金
    var Count = {
    		/**
    		 * @description 取数组里面最大或最小的元素
    		 * @param {Array} arr 要遍历的数组
    		 * @param {Boolean} bool 为true?max:min 
    		 * @return {Int}
    		 * @example Count.division([2,3,4],true);return 4
    		 */
    		division: function (arr, bool) {
    			arr.sort(function(a,b){return a-b;});
    			var i = (bool && arr[arr.length-1])||arr[0];
    			return i;
    		},
    		/**
    		 * @description 通过每一排的最大最小sp 和 过关方式 取得理论奖金的最大最小值
    		 * @param {Array} arr 要遍历的数组对象
    		 * @param {Array} guoguan 过关方式
    		 * @return {obj}
    		 * @example Count.prix([{max:'2',min:'1'},{max:'4',min:'2'}],[1,2]);return {max:XX,min:OO}
    		 */
    		prix: function (arr, guoguan) {
    			var gg_ = guoguan,min_pl=[],max_pl=[];
    			arr.map(function(sp) {
					max_pl.push(+sp.max);
					min_pl.push(+sp.min);
    			});
    			if (!max_pl.length || !gg_) {
    				return {
    	                min: 0,
    	                max: 0
    	                };
    			} else {
    	            var pz = Count.max_prize(max_pl, gg_);
    	            var minpz = 1;
    	            	minpz = Count.min_prize(min_pl, gg_);
    	            return {
    	                min: minpz,
    	                max: pz
    	            };   
    			}
    		},
    		/**
    		 * @description 通过每一排的最大sp 和 过关方式 取得理论奖金的最大值
    		 * @param {Array} arr 要遍历的数组对象 里面是每一排最大的sp
    		 * @param {Array} guoguan 过关方式
    		 * @return {Int}
    		 * @example Count.max_prize(['3.1', '2.2', '5.5', '1.9'],[2,3]);return 1234
    		 */
    		max_prize : function(arr, guoguan){
    			var max_prize = 0;
    			var Q = guoguan;
    	        $.each(Q,function(n,value) {
    				var _n = parseInt(value)||1;
	            	var cl = Count.cl(arr, _n);
	            	$.each(cl,function(a,b){
	            		var x=1;
	            		$.each(b,function(c,d){
	            			x *= d;
	            			
	            		});
	            		max_prize += x;
	            	});
    			});
    			max_prize *= 2;
    			return max_prize = (+max_prize).toFixed(8);
    		},
    		/**
    		 * @description 通过每一排的最小sp 和 过关方式 取得理论奖金的最小值
    		 * @param {Array} arr 要遍历的数组对象 里面是每一排最小的sp
    		 * @param {Array} guoguan 过关方式
    		 * @return {Int}
    		 * @example Count.max_prize(['3.1', '2.2', '5.5', '1.9'],[2,3]);return 2
    		 */
    		min_prize: function(arr, guoguan){
    			var min_prize = 0;
    			var Q = guoguan;
    			$.each(Q, function(n,value) {
    				var _n = parseInt(value)||1;
	            	var cl = Count.cl(arr, _n);
	            	$.each(cl,function(a,b){
	            		var x=1;
	            		$.each(b,function(c,d){
	            			x *= d;
	            			
	            		});
	            		if(x<min_prize || min_prize==0){
	                    	min_prize=x;
	                    }
	            	});
    			});
    			min_prize *= 2;
    			return min_prize = (+min_prize).toFixed(8);
    		},
    		/**
    		 * @description 通过每一排的最大或最小sp 和 单个过关方式 取得理论奖金的最大或最小值
    		 * @param {Array} arr 要遍历的数组对象 里面是每一排最小或最大的sp
    		 * @param {String} n 单个过关方式
    		 * @return {Int}
    		 * @example Count.cl(['3.1', '2.2', '5.5', '1.9'],'2');return 2
    		 */
    		cl: function(arr, n, z) { // z is max count
    			var r = [];
    			fn([], arr, n);
    			return r;
    			function fn(t, a, n) {
    				if (n === 0 || z && r.length == z) {
    					return r[r.length] = t
    				}
    				for (var i = 0, l = a.length - n; i <= l; i++) {
    					if (!z || r.length < z) {
    						fn(t.concat(a[i]), a.slice(i + 1), n - 1);
    					}
    				}
    			}
    		}
    	};
    
	//对阵相关操作
    var Against = {
    		/*获取对阵信息*/
    		getData : function () {
    			$.ajax({
    				url : CP.Data.data+'/data/app/jczq/new_jczq_hh.xml',
    				type:'GET',
    				dataType:'xml',
    				success:function(xml){
    					var R = $(xml).find('Resp');
    					var rows = R.find('rows');
    					againstData =[];//北单切换玩法的时候重新加载对阵数据
    					rows.each(function (i) {
    						var t = {},t1=[];
    						t.addesc = $(this).attr('addesc');
    						t.desc = $(this).attr('desc');
    						var r = $(this).find('row');
    						r.each(function (a) {
    							var isale = false;
    							var Stickie = false;
    							var t2 = {};
    							t2.itemid = $(this).attr('itemid');
    							t2.hn = $(this).attr('hn').substr(0,5);//主队
    							t2.gn = $(this).attr('gn').substr(0,5);//客队
    							t2.et = $(this).attr('et');//停售
    							t2.mt = $(this).attr('mt');//比赛
    							t2.mname = $(this).attr('mname');//联赛名
    							t2.name = $(this).attr('name');//周几
    							t2.cl = $(this).attr('cl');//联赛颜色
    							t2.close = $(this).attr('close');//让球数
    							t2.isale = $(this).attr('isale');//停售
								t2.hm = $(this).attr('hm') || '--';//主队联赛排名
								t2.gm = $(this).attr('gm') || '--';//客队联赛排名
								t2.htn = $(this).attr('htn') || '--';//主队战绩
								t2.gtn = $(this).attr('gtn') || '--';//客队战绩
								t2.oh = $(this).attr('oh');//平均欧指 主
								t2.od = $(this).attr('od');//平均欧指 平
								t2.oa = $(this).attr('oa');//平均欧指 客
								t2.htid = $(this).attr('htid');//主队编号
								t2.gtid = $(this).attr('gtid');//客队编号
								t2.spf_sp = '';
								t2.rq_sp = '';
								t2.bf_sp = '';
								t2.jq_sp = '';
								t2.bqc_sp = '';
								if((32 & t2.isale) > 0){
									t2.rq_sp = $(this).attr('rqspf');
									isale = true;
									Stickie = true;
								}
								if((64 & t2.isale) > 0){
									t2.bf_sp = $(this).attr('cbf');
									isale = true;
								}
								if((128 & t2.isale) > 0){
									t2.bqc_sp = $(this).attr('bqc');
									isale = true;
								}
								if((256 & t2.isale) > 0){
									t2.jq_sp = $(this).attr('jqs');
									isale = true;
								}
								if((512 & t2.isale) > 0){
									t2.spf_sp = $(this).attr('spf');
									isale = true;
									Stickie = true;
								}
								t2.history = $(this).attr('history')||'';//历史交锋
								t2.hot = $(this).attr('hot');
								t2.tco = $(this).attr('tco');
								t2.tcoscale = $(this).attr('tcoscale');
								t2.spfscale = $(this).attr('spfscale');
								t2.rqspfscale = $(this).attr('rqspfscale');
								if(isale){
									if(Stickie){
										t1.unshift(t2);
									}else{
										t1.push(t2);
									}
								}
    						});
    						t.info = t1;
    						againstData[i] = t;
    					});
    					Against.render();
    				}
    			});
    		},
    		/*渲染对阵*/
    		render : function () {
    			var _out=[];
    			if(!againstData.length){
    				_out.push('<div style="padding-top:50px;text-align:center;">暂无对阵!</div>');
    			}else{
    				for(var i=0,l=againstData.length;i<l;i++){
    					_out.push('<section>');
    					_out.push('<div class="sfcTitle">'+againstData[i].addesc+'<em class="up"></em></div>');
    					_out.push('<div>');
    					var t = againstData[i].info;
    					for(var n=0,t1=t.length;n<t1;n++){
    						var name_ = t[n].name.substr(-3);
    						var sp_ = '';
    						
    						
    						
							var rq_ = '<i class="'+(t[n].close.indexOf('-')>=0?'green2':'red')+'">('+(t[n].close.indexOf('-')<0?'+':'')+t[n].close+')</i>';
							_out.push('<ul class="sfcxs hhzpk" data-id='+t[n].itemid+'>');
							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><i class="up down"></i></li>');
							_out.push('<li>');
							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'"><span><em>'+t[n].hn+rq_+'</em></span><span class="spfvs"><em>VS</em></span><span><em>'+t[n].gn+'</em></span></p>');
							_out.push('<p class="spfzpk"><em>非让球</em>');
							if(t[n].spf_sp){//竞彩胜平负开售
								sp_ =  t[n].spf_sp.split(',');
								_out.push('<span class=wang-ball my-data=3>胜 '+sp_[0]+'</span><span class=wang-ball my-data=1>平 '+sp_[1]+'</span><span class=wang-ball my-data=0>胜 '+sp_[2]+'</span>');
							}else{
								_out.push('<span>--</span><span>--</span><span>--</span>');
							}
							_out.push('</p>');
							_out.push('<p class="spfzpk"><em class="rq">让球</em>');
							if(t[n].rq_sp){//竞彩让球开售
								sp_ =  t[n].rq_sp.split(',');
								_out.push('<span class=wang-ball my-data=3>胜 '+sp_[0]+'</span><span class=wang-ball my-data=1>平 '+sp_[1]+'</span><span class=wang-ball my-data=0>胜 '+sp_[2]+'</span>');
							}else{
								_out.push('<span>--</span><span>--</span><span>--</span>');
							}
							_out.push('</p>');
							_out.push('<div class="hhmore wei-ball">更多玩法</div>');
							_out.push('</li>');
							_out.push('</ul>');

							var jf = '暂无交锋记录';
							if(t[n].history){//历史交锋
								jf = '两队近'+t[n].history.length+'次交锋，'+t[n].hn+'<strong>'+t[n].history+'</strong>';
							}
    						_out.push('<div class="sfcpl" style="display:none;">');
    						_out.push('<dl><dt>历史交锋</dt><dd style="width:80%; text-align:center">'+jf+'</dd></dl>');
							var bl = t[n].spfscale.split(',');
							var rbl = t[n].rqspfscale.split(',');
							var rq = '<em class="'+(t[n].close.indexOf('-')>=0?'green2':'red')+'">'+(t[n].close.indexOf('-')<0?'+':'')+t[n].close+'</em>';
							_out.push('<dl class="tzbl"><dt>投注比例</dt>\
							<dd><p><em>0</em><span>'+(bl[0] || '--')+'</span><span>'+(bl[1] || '--')+'</span><span>'+(bl[2] || '--')+'</span></p>\
							<p>'+rq+'<span>'+(rbl[0] || '--')+'</span><span>'+(rbl[1] || '--')+'</span><span>'+(rbl[2] || '--')+'</span></p></dd></dl>');
							_out.push('<dl class="bfzb blue" type='+17+' qc='+t[n].itemid.substr(0,6)+' itemid='+t[n].itemid+'>详细赛事分析&gt;</dl>');
							_out.push('</div>');
    					}
    					_out.push('</div>');
    					_out.push('</section>');
    				}
    			}
    			setTimeout(function () {
    				$item.html(_out.join(''));
    				Against.bind();
    			}, 100);
    		},
    		/**
             * 获取选择信息的中文文本
             * @param {Object} obj 为selectData对象
             * @return {String||Array}
             */
    		getSelectText : function(obj){
    			var arr = [];
    			//bf 将selectData值转为中文文本
    			function bf(_obj){
    				var arr = [[],[],[]];
    				for(var s in _obj){
    					if(_obj[s] == '9:0'){
    						arr[0].push('胜其它');
    					}else if(_obj[s] == '9:9'){
    						arr[1].push('平其它');
    					}else if(_obj[s] == '0:9'){
    						arr[2].push('负其它');
    					}else{
    						var w3 = _obj[s];
    						var w1 = w3.charAt(0);
    						var w2 = w3.charAt(2);
    						if(w1>w2){
    							arr[0].push(w3);		
    						}else if(w1==w2){
    							arr[1].push(w3);		
    						}else{
    							arr[2].push(w3);		
    						}
    					}
    				}
    				arr[0] = arr[0].sort();
    				arr[1] = arr[1].sort();
    				arr[2] = arr[2].sort();	
    				var _arr = [];
    				return _arr.concat(arr[0]).concat(arr[1]).concat(arr[2]);	
    			}
    			//bqc 将selectData值转为中文文本
    			function bqc(_obj){
    				_obj.sort(function(a,b){							
    						return(b - a);	
                        });
    				var arr = [];
    				for(var s in _obj){
    					switch(_obj[s]){
    						case '3-3':arr.push('胜胜');break;
    						case '3-1':arr.push('胜平');break;
    						case '3-0':arr.push('胜负');break;
    						case '1-3':arr.push('平胜');break;
    						case '1-1':arr.push('平平');break;
    						case '1-0':arr.push('平负');break;
    						case '0-3':arr.push('负胜');break;
    						case '0-1':arr.push('负平');break;
    						case '0-0':arr.push('负负');break;
    					}
    				}
    				return arr;	
    			}	
    			if(lotteryPlayName == 'bf'){
    				arr = bf(obj);	
    			}else if(lotteryPlayName == 'bqc'){
    				arr = bqc(obj);	
    			}else if(lotteryPlayName == 'hh'){
    				var t=0;
    				for (var i=0, l=obj.length; i<l; i++) {
    					var tt = obj[i]||[];
    					t += tt.length;
    				}
    				return (t>0 && '已选'+t+'项' || '更多玩法');
    			}
    			var str = arr.length;
    			if(str>6){
    				str = '已选'+str+'项';
    			}else{
    				str = '';
    				for(var s in arr){
    					var Q = {'胜其它':'class=sqt','平其它':'class=sqt','负其它':'class=sqt'}[arr[s]]||''
    					str += '<cite '+Q+'>'+arr[s]+'</cite>'
					}
    			}
    			return str;
    		},
    		container : function (el) {//给$('#tc')层赋值 和点击事件
    			function main(){
					if(g.curChangCi >= 15){
						if(!$(el).is('.cur')){
							alert('竞彩混投最多选15场');return;	
						}
					}
					var itemid = el.parent().parent().attr("data-id") || el.parent().parent().parent().attr("data-id");//[混投]||[!混投]
					var json = againstData;	
					var obj,index1,index2;
					//选中行数索引
					for (var i = 0,l=json.length; i < l; i++) {
						var json_info = json[i].info;
						for (var j = 0,ll = json_info.length; j<ll; j++) {
							if (json_info[j].itemid == itemid) {
								obj = json_info[j];
								index1 = i;
								index2 = j;
							}
						}
					}
					var html = '';
					if (true) {//混投
						html='<div class="bfTitle clearfix"><p>'+obj.hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+obj.gn+'</p></div>\
							<article class="bfScroll hhscroll" style="height:0px" id=tc_c>\
					    <p class="gray">非让球/让球</p>\
					     <div class="competitions hhcom" i=0>';
						if(obj['spf_sp']){
							var spf_sp = obj['spf_sp'].split(',');
							html+='<span my-data=3>主胜<em>'+spf_sp[0]+'</em></span><span my-data=1>平<em>'+spf_sp[1]+'</em></span><span my-data=0>主负<em>'+spf_sp[2]+'</em></span>';
						}else{
							html+='<span>停售</span><span>停售</span><span>停售</span>';
						}
		            	html+='</div>\
		            	<div class="competitions hhcom" i=1 style="border-top:none;">';
		            	if(obj['rq_sp']){
		            		var rq_sp = obj['rq_sp'].split(',');
		            		html+='<span my-data=3>主<cite class="'+(obj.close.indexOf('-')>=0?'green2':'red')+'">('+(obj.close.indexOf('-')<0?'+':'')+obj.close+')</cite>胜<em>'+rq_sp[0]+'</em></span><span my-data=1>平<em>'+rq_sp[1]+'</em></span><span my-data=0>主负<em>'+rq_sp[2]+'</em></span>';
						}else{
							html+='<span>停售</span><span>停售</span><span>停售</span>';
						}
		            	html+='<div class="clear"></div>\
					     </div>\
					  	<p class="gray">比分</p>';
		            	if(obj['bf_sp']){
		            		var bf_sp = obj['bf_sp'].split(',');
		            		html += '<div class="competitions bfcom" i=2>\
				            	<span my-data=1:0><strong>1:0</strong><em>'+bf_sp[0]+'</em></span>\
				            	<span my-data=2:0><strong>2:0</strong><em>'+bf_sp[1]+'</em></span>\
				            	<span my-data=2:1><strong>2:1</strong><em>'+bf_sp[2]+'</em></span>\
				            	<span my-data=3:0><strong>3:0</strong><em>'+bf_sp[3]+'</em></span>\
				            	<span my-data=3:1><strong>3:1</strong><em>'+bf_sp[4]+'</em></span>\
				            	<span my-data=3:2><strong>3:2</strong><em>'+bf_sp[5]+'</em></span>\
				            	<span my-data=4:0><strong>4:0</strong><em>'+bf_sp[6]+'</em></span>\
				            	<span my-data=4:1><strong>4:1</strong><em>'+bf_sp[7]+'</em></span>\
				            	<span my-data=4:2><strong>4:2</strong><em>'+bf_sp[8]+'</em></span>\
				                <span my-data=5:0><strong>5:0</strong><em>'+bf_sp[9]+'</em></span>\
				                <span my-data=5:1 style="border-bottom:none"><strong>5:1</strong><em>'+bf_sp[10]+'</em></span>\
				                <span my-data=5:2 style="border-bottom:none"><strong>5:2</strong><em>'+bf_sp[11]+'</em></span>\
				            	<span my-data=9:0 style="border-bottom:none" class="bflast"><strong>胜其它</strong><em>'+bf_sp[12]+'</em></span>\
				                <div class="clear"></div>\
							    </div>\
							    <div class="competitions bfcom" i=2>\
							            	<span my-data=0:0 style="border-bottom:none"><strong>0:0</strong><em>'+bf_sp[13]+'</em></span>\
							            	<span my-data=1:1 style="border-bottom:none"><strong>1:1</strong><em>'+bf_sp[14]+'</em></span>\
							            	<span my-data=2:2 style="border-bottom:none"><strong>2:2</strong><em>'+bf_sp[15]+'</em></span>\
							            	<span my-data=3:3 style="border-bottom:none"><strong>3:3</strong><em>'+bf_sp[16]+'</em></span>\
							            	<span my-data=9:9 style="border-bottom:none" class="bflast"><strong>平其它</strong><em>'+bf_sp[17]+'</em></span>\
				            	<div class="clear"></div></div>\
						        <div class="competitions bfcom" i=2>\
							            	<span my-data=0:1><strong>0:1</strong><em>'+bf_sp[18]+'</em></span>\
							            	<span my-data=0:2><strong>0:2</strong><em>'+bf_sp[19]+'</em></span>\
							            	<span my-data=1:2><strong>1:2</strong><em>'+bf_sp[20]+'</em></span>\
							            	<span my-data=0:3><strong>0:3</strong><em>'+bf_sp[21]+'</em></span>\
							            	<span my-data=1:3><strong>1:3</strong><em>'+bf_sp[22]+'</em></span>\
							            	<span my-data=2:3><strong>2:3</strong><em>'+bf_sp[23]+'</em></span>\
							            	<span my-data=0:4><strong>0:4</strong><em>'+bf_sp[24]+'</em></span>\
							            	<span my-data=1:4><strong>1:4</strong><em>'+bf_sp[25]+'</em></span>\
							            	<span my-data=2:4><strong>2:4</strong><em>'+bf_sp[26]+'</em></span>\
							                <span my-data=0:5><strong>0:5</strong><em>'+bf_sp[27]+'</em></span>\
							                <span my-data=1:5><strong>1:5</strong><em>'+bf_sp[28]+'</em></span>\
							                <span my-data=2:5><strong>2:5</strong><em>'+bf_sp[29]+'</em></span>\
							            	<span my-data=0:9 class="bflast"><strong>负其它</strong><em>'+bf_sp[30]+'</em></span>\
							                <div class="clear"></div>\
							    </div>';
		            	}else{
					    	html += '<div style="padding: 0px 0px 0px 0.8rem;">停售</div>';
					    }
		            	html += '<p class="gray">总进球</p>';
						
		            	if(obj['jq_sp']){
		            		var jq_sp = obj['jq_sp'].split(',');
		            		html += '<div class="competitions bfcom htzjq" i=3>\
				            	<span my-data=0><strong>0球</strong><em>'+jq_sp[0]+'</em></span>\
				            	<span my-data=1><strong>1球</strong><em>'+jq_sp[1]+'</em></span>\
				            	<span my-data=2><strong>2球</strong><em>'+jq_sp[2]+'</em></span>\
				            	<span my-data=3><strong>3球</strong><em>'+jq_sp[3]+'</em></span>\
				            	<span my-data=4><strong>4球</strong><em>'+jq_sp[4]+'</em></span>\
				            	<span my-data=5><strong>5球</strong><em>'+jq_sp[5]+'</em></span>\
				            	<span my-data=6><strong>6球</strong><em>'+jq_sp[6]+'</em></span>\
				            	<span my-data=7><strong>7+球</strong><em>'+jq_sp[7]+'</em></span>\
				                <div class="clear"></div></div>';
				            	
		            	}else{
					    	html += '<div style="padding: 0px 0px 0px 0.8rem;">停售</div>';
					    }
					    
					    html += '<p class="gray">半全场</p>';
					    if(obj['bqc_sp']){
					    	var bqc_sp = obj['bqc_sp'].split(',');
					    	html += '<div class="competitions bfcom htcom" i=4>\
				            	<span my-data=3-3><strong>胜胜</strong><em>'+bqc_sp[0]+'</em></span>\
				            	<span my-data=3-1><strong>胜平</strong><em>'+bqc_sp[1]+'</em></span>\
				            	<span my-data=3-0><strong>胜负</strong><em>'+bqc_sp[2]+'</em></span>\
				            	<span my-data=1-3><strong>平胜</strong><em>'+bqc_sp[3]+'</em></span>\
				            	<span my-data=1-1><strong>平平</strong><em>'+bqc_sp[4]+'</em></span>\
				            	<span my-data=1-0><strong>主负</strong><em>'+bqc_sp[5]+'</em></span>\
				            	<span my-data=0-3><strong>负胜</strong><em>'+bqc_sp[6]+'</em></span>\
				            	<span my-data=0-1><strong>负平</strong><em>'+bqc_sp[7]+'</em></span>\
				            	<span my-data=0-0><strong>负负</strong><em>'+bqc_sp[8]+'</em></span>\
				                <div class="clear"></div></div>';
					    }else{
					    	html += '<div style="padding: 0px 0px 0px 0.8rem;">停售</div>';
					    }
					    
					    html += '</article>\
						<div class="zfTrue zfTrue2 clearfix"><a href="javascript:;" class="zfqx" id=tc_cancel>取 消</a><a id=tc_ok href="javascript:;">确 定</a></div>';
					}
					$("#tc_content").html(html);
					var h_ = $(window).height()*.9-$('#tc').height()*2;
					$('#tc_c').css({height:h_+'px'});
					$('#tc').css({top:'5%'});
					$("#tc").show();
					$("#jczq_mask").show();	
					//遍历selectData增加选项样式
					if(obj.selectData){
						var par = $("#tc_c");
						if(lotteryPlayName != 'hh'){
							for(var i in obj.selectData){
								par.find('span[my-data="'+obj.selectData[i]+'"]').addClass('cur');	
							}
						}else{
							var d = obj.selectData;
							for(var i in d){		
								var div = par.find('div[i="'+i+'"]'); 						
								for(var j in d[i]){							
									div.find('span[my-data="'+d[i][j]+'"]').addClass('cur');	
								}
							}	
						}
					}
					//弹出层选择项点击事件
					$("#tc_content").off().Touch({children:"span[my-data]", fun:function(el) {
							if(!obj._selectData){
								if(!obj.selectData){
									obj._selectData = [];	
								}else{
									obj._selectData = CP.Util.CloneObj([],obj.selectData);
								}
							}
							var index = $(el).parent().attr('i');
							if(!obj._selectData[index]){
								obj._selectData[index] = [];	
							}
							if ($(el).is(".cur")) {//是否选中状态
								$(el).removeClass("cur");
								obj._selectData[index].splice($.inArray($(el).attr('my-data'),obj._selectData[index]),1);								
							} else {
								$(el).addClass("cur");
								obj._selectData[index].push($(el).attr('my-data')); 
							}
						}
					})
					//弹出层确定按钮
					$("#tc_ok").off().bind(end_ev,function(){
						var el = $item.find('ul[data-id="'+itemid+'"]').find(".wei-ball");
						var obj = againstData[index1].info[index2];
						$("#tc,#jczq_mask").hide();
						$("#tc_content").html('');					
						obj.selectData = ((obj._selectData&&obj._selectData.slice(0))||obj.selectData||[]);
						delete obj._selectData;
						if(obj.selectData.join().replace(/,/g,'').split(',')[0]!=''){
								el.addClass('cur').html(Against.getSelectText(obj.selectData));
						}else{
							el.removeClass('cur').html('更多玩法');
						}
						if(lotteryPlayName=='hh'){
							var dom_ = $item.find('ul[data-id="'+itemid+'"]').find(".spfzpk span");
							var Q = {'3':0,'1':1,'0':2};
							$item.find('ul[data-id="'+itemid+'"]').find(".wang-ball").removeClass('cur');//清除外面的高亮 下面重新计算点亮
							//胜平负有选的时候把外面的也点亮
								var tt = obj.selectData[0];
								for (var t in tt) {
									dom_.eq(Q[tt[t]]).addClass('cur');
								}
							//让球胜平负有选的时候
								var tt = obj.selectData[1];
								for (var t1 in tt) {
									dom_.eq(Q[tt[t1]]+3).addClass('cur');
								}
						}
						Against.showTotal();
					})
					//弹出层取消按钮
					$("#tc_cancel").off().bind(end_ev,function(){
						$("#tc,#jczq_mask").hide();
						$("#tc_content").html('');
						delete againstData[index1].info[index2]._selectData;
					});
				}
    			main();
    		},
    		//计算已选多少场次
    		showTotal : function () {//所有玩法都进来
    			g.curChangCi = 0;
    			g.spArr = [];
    			var json = againstData;
    			if (json.length > 0) {
                    for (var i = 0, j = json.length; i < j; i++) {
                    	var Q = json[i].info;
                    	for (var Q1 in Q) {
                    		var _selectData = Q[Q1].selectData || [];
                    		if(_selectData.length){
                    				var Q2 = _selectData.join(',').split(',');
                    				var Q3 = 0;
                    				for (var n=0, m = Q2.length; n<m; n++) {
                    					if(Q2[n]){Q3++;}
                    				}
                    				!!Q3 && g.spArr.push(Q3);
                    		}
                    		//是否选中
                    		var _isSelect = Against.isSelect(_selectData);

                            if (_isSelect) {
                                g.curChangCi++;
                            }
                    	}
                    }
                }
    			$('#lot_cur_match').html(g.curChangCi);
    		},
    		 //是否选中
            isSelect : function(obj) {
    			var _isSelect = false;
				if(lotteryPlayName!='hh'){
					_isSelect = (obj.length>0);
				}else{
					_isSelect = (obj.join().replace(/,/g,'').split(',')[0]!='');	
				}
    			return _isSelect;
            },
            clear : function () {//清空按钮
            	for (var s in againstData) {
    				var ss = againstData[s].info;
    				for (var sss in ss) {
    					delete ss[sss]._selectData;
    					delete ss[sss].selectData;
    				}
    			}
            	$item.find('.cur').each(function () {
            		$(this).removeClass('cur');
            		if($(this).is('.wei-ball')){
            			$(this).html({'hh':'更多玩法'}[lotteryPlayName]|| '立即投注');
            		}
            	});
            	g.bet = '1';//倍数恢复1倍
            	g.count = 0;//恢复0注
            	g.amount = 0;//总金额
            	Against.showTotal();
            },
          //混投 如果有选比分、进球数、半全场的最大串关
            guoguan : function (xo) {//xo 当前选的场次
            	var Q = xo;
            	for (var s in againstData) {//比分 半全场4
    				var ss = againstData[s].info;
    				for (var n = 0, l = ss.length; n<l; n++) {
    					if(ss[n].selectData){
    						if(!!ss[n].selectData[2]){
    							if(ss[n].selectData[2].length){
    								Q = 4;
            						return Q;
    							}
        					}
    						if(!!ss[n].selectData[4]){
        						if(ss[n].selectData[4].length){
        							Q = 4;
            						return Q;
        						}
        					}
    					}
    				}
    			}
            	for (var s in againstData) {//进球 6
    				var ss = againstData[s].info;
    				for (var sss in ss) {
    					if(ss[sss].selectData){
    						if(!!ss[sss].selectData[3]){
    							if(ss[sss].selectData[3].length){
    								Q = (Q < 6 && Q) || 6;
            						return Q;
    							}
        					}
    					}
    				}
    			}
            	Q = (Q<8 && Q) || 8;
            	return Q;
            },
            //计算注数
            getCount : function () {
            	g.count = 0;
            	for (var Q in g.pass) {
            		g.count +=CP.math.N1(g.spArr,g.pass[Q]);
            	}
            	$('#lot_cur_zhushu').html(g.count);
            	g.amount = g.count*2*g.bet;
            	$('#lot_cur_money').html(g.amount);
            	
            	
            	var data = [];
    			var json = againstData;
    			if (json.length > 0) {
                    for (var i = 0, j = json.length; i < j; i++) {
                    	var Q = json[i].info;
                    	for (var Q1 in Q) {
                    		var _selectData = Q[Q1].selectData || [];
                    		if(_selectData.length){
                					if (_selectData.join().replace(/,/g,'').split(',')[0]!='') {
                							var spspf = [], sprq = [], spbf = [], spjq = [], spbqc = [], Q2 = {};
                        					if(_selectData[0]){//胜平负
                        						var Q4 = $.map(_selectData[0], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = jczq.spf;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].spf_sp.split(',');
                    							spspf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[1]){//让球胜平负
                        						var Q4 = $.map(_selectData[1], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = jczq.rq;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].rq_sp.split(',');
                    							sprq = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[2]){//比分
                        						var Q4 = $.map(_selectData[2], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = jczq.bf;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].bf_sp.split(',');
                    							spbf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[3]){//进球
                        						var Q4 = $.map(_selectData[3], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = jczq.jq;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].jq_sp.split(',');
                    							spjq = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[4]){//半全场
                        						var Q4 = $.map(_selectData[4], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = jczq.bqc;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].bqc_sp.split(',');
                    							spbqc = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					spspf_max = spspf.length && Count.division(spspf, true) || 0;
                        					spspf_min = spspf.length && Count.division(spspf) || 0;
                        					sprq_max = sprq.length && Count.division(sprq, true) || 0;
                        					sprq_min = sprq.length && Count.division(sprq) || 0;
                        					spbf_max = spbf.length && Count.division(spbf, true) || 0;
                        					spbf_min = spbf.length && Count.division(spbf) || 0;
                        					spjq_max = spjq.length && Count.division(spjq, true) || 0;
                        					spjq_min = spjq.length && Count.division(spjq) || 0;
                        					spbqc_max = spbqc.length && Count.division(spbqc, true) || 0;
                        					spbqc_min = spbqc.length && Count.division(spbqc) || 0;
                        					
                        			        Q2.max = parseFloat(spspf_max)+parseFloat(sprq_max)+parseFloat(spbf_max)+parseFloat(spjq_max)+parseFloat(spbqc_max);
                        					var Q8  = [(spspf_min||9999), (sprq_min||9999), (spbf_min||9999), (spjq_min||9999), (spbqc_min||9999)];
                        			        Q2.min = Count.division(Q8);
                        					data.push(Q2);
                					}
                    		}
                    	}
                    }
                }
				var prix = Count.prix(data, g.pass);
				var Q = 1;
				g.amountMin = (prix.min*g.bet*Q).toFixed(2);
				g.amountMax = (prix.max*g.bet*Q).toFixed(2);
				g.bonus = (g.amountMin == g.amountMax)?g.amountMax:(g.amountMin+'~'+g.amountMax);
            	$('#bonus').html(g.bonus);
            },
            //点击下一步按钮
            next : function () {
            	var Q = parseInt($('#lot_cur_match').html());
            	if(Q< 1){
            		alert('至少选择1场');
            	}else{
            		var Q1 = '4';
            		if(Q>4){
            			Q1 = Against.guoguan(Q);
            		}
            		Q1 = (Q1>Q && Q) || Q1; //显示多少个串关方式
            		$('#ggList').find('li').each(function () {
            			($(this).index()<Q1) && $(this).show() || $(this).hide();
            			$(this).removeClass('cur');
            		});
            		g.pass = [1];
        			$('#jc_chuan').html('单关');
        			$('#ggList').find('li').eq(0).addClass('cur');
        			$('#jc_chuan_list').removeClass('jczqBlock');
            		$('#jc_bs').val(g.bet);//初始化倍数
            		$('#lot_cur').html(Q);//已选多少场
    				$('#jczq_mask').show();
    				$('#jc_footer').addClass('jc_footer');
    				Against.getCount();
            	}
            	
            },
            bind : function(){
            	$item.off();
            	$item.Touch({children:'.wangwei',fun:function(){//析
            		$(this).parent().next().slideToggle('200');
    				$(this).find('.up').toggleClass('down');
            	}});
            	$item.Touch({children:'.sfcTitle',fun:function(){//按日期显隐比赛
            		$(this).next().slideToggle('200');
    				$(this).find('.up').toggleClass('down');
            	}});0
            	$item.Touch({children:'.wang-ball',fun:function(){//投注选项
            		if(g.curChangCi >= 15){
						if(!$(this).parent().parent().find('.cur').length){
							alert('竞彩混投最多选15场');return;	
						}
					}
    				$(this).toggleClass('cur');
    				var _el = $(this).parent().parent().parent();
                    var arr = [];
        			Q1 = [].slice.call(_el.find('.spfzpk:eq(0) .cur')).map(function(el_){
                    	var xo = $(el_).attr('my-data') || '';
						return xo;
					});
        			Q2 = [].slice.call(_el.find('.spfzpk:eq(1) .cur')).map(function(el_){
                    	var xo = $(el_).attr('my-data') || '';
						return xo;
					});
        			!!Q1.length && (arr[0] = Q1);
        			!!Q2.length && (arr[1] = Q2);
                    var json = againstData, obj;	
                    var itemid = _el.attr("data-id");
					for (var i = 0,l=json.length; i < l; i++) {
						var json_info = json[i].info;
						for (var j = 0,ll = json_info.length; j<ll; j++) {
							if (json_info[j].itemid == itemid) {
								obj = json_info[j];
								if (lotteryPlayName == 'hh' && obj.selectData) {
									obj.selectData[0] = arr[0];//胜平负 （竞彩）  让分胜负（篮彩）
									obj.selectData[1] = arr[1];//让球胜平负 （竞彩） 大小分（篮彩）
								} else {
									obj.selectData = arr;//把投注的号码记录在 selectData里面
								}
							}
						}
					}
					if(obj.selectData.join().replace(/,/g,'').split(',')[0]!=''){
						_el.find('.wei-ball').html(Against.getSelectText(obj.selectData)).addClass('cur');
					}else{
						_el.find('.wei-ball').html('更多选项').removeClass('cur');
					}
    				Against.showTotal();
            	}});
            	$item.Touch({children:'.wei-ball',fun:function(){//展开弹层
            		el = $(this);
    				Against.container(el);
            		
            	}});
            	$item.Touch({children:'.bfzb',fun:function(){//展开弹层
            		var url = {};
        			url = {
            				itemid : $(this).attr('itemid'),
            				type : $(this).attr('type'),
            				qc : $(this).attr('qc')
            		};
        			url = '/jcbf/dzxq.html?'+jQuery.param(url);
            		window.location.href=url;
            	}});
            },
          //初始化对阵相关操作的绑定事件
     		init : function () {
    			Against.getData();
    		}
    }
    
    /* 公用方法 [[ */
    var o = {
		//页面跳转
        pageGo: {
            goBack: function () {
            	TopAnch.init({
    				title:'竞彩足球·混投单关',
    				prevShow:true,
    				prevFun:function(){//左侧按钮绑定事件
    					window.location.href = '#type=index';
    				},
    				isScore: '/jcbf/',
    				menu:[{'name':'选择比赛','url':'javascript:;','cur':true},
    				      {'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot('70', 2),'cur':false},
    				      {'name':'开奖结果','url':'#type=url&p=kj/zq.html','cur':false},
    				      {'name':'玩法帮助','url':'#type=url&p=wf/jczq.html','cur':false}],
    				headerSelect: [{name:'胜平负',fun:o.changePlayType,cur:'1'},{name:'混投单关'}],
    				style:false
    			});
            }
        },
		//初始化函数
        init : function() {
        	o.pageGo.goBack();
             //加载数据
			Against.init();
        },
        changePlayType : function(index){
        	if(index == '0'){
        		window.location.href='/#type=url&p=list/jczq.html';
        	}
		},
		/*认购保底多少[[*/                                                                                                                                                          
		hmDet : function () {
			var rg = parseInt($('#rg').val() || 0);
			var bd = parseInt($('#bd').val() || 0);
			var z = rg+bd;
			g.hmMoney = z;
			$('#hm_m cite:eq(0)').html(rg);//认购
			$('#hm_m cite:eq(1)').html(bd);//保底
			$('#hm_m cite:eq(2)').html(z);//总金额
		},
		/*]]认购保底多少*/
		
		doHm : function(){
			/*显示合买[[*/
			$(".jczqNav, #item, #jc_footer, #jczq_mask").hide();
			$('#bethm, #jc_hm_footer').show();
			/*]]显示合买*/
			/*设置导航左右按钮 [[*/
			TopAnch.init({
				title:'发起合买',
				prevShow:true,
				prevFun:function(){//左侧按钮绑定事件
					window.location.href = '#type=url&p=list/'+lotteryType+'.html';
				},
				isBack:true,
				nextShow:false,
				style:false
			});
			
			$('#hmDet cite').eq(0).html(g.count);//注数
			$('#hmDet cite').eq(1).html(g.bet);//倍数
			$('#hmDet cite').eq(2).html(g.amount);//总金额
			
			$("#rg").val(Math.ceil(g.amount*0.05));
			$("#rg_bl").html(Math.floor(($('#rg').val()/g.amount)*10000)/100+"%");
			$("#bd").removeAttr('disabled');
			$("#bd").val('0');
			$("#bd_bl").html('0%');
			o.hmDet();
		},		
		
		/*获取购买的各种参数 [[*/
		getArgument : function(t){
			var buy = {};
			switch(t){
				/* 1:自购 2:合买  */
				case 1:
					buy = {//投注参数
							payUrl:    '/trade/jcast.go',//投注接口
							gid:       g.loty_id,//彩种id
							pid:       g.qihao_id,//期号
							codes:     g.codes,//投注内容
							muli:      g.bet,//倍数
							countMoney:g.amount,//方案金额
							orderType:'dg'//代购
					};
					break;
				case 2:
					buy = {//投注参数
						payUrl:    '/trade/jcast.go',//投注接口
						gid:       g.loty_id,//彩种id
						pid:       g.qihao_id,//期号
						codes:     g.codes,//投注内容
						muli:      g.bet,//倍数
						desc:      $('#hmDesc').val() || '快乐购彩、欧耶！',//方案宣传
						countMoney:g.amount,//方案金额
						bnum:      $('#rg').val(),//认购
						pnum:      $('#bd').val(),//保底
						oflag:     $('#isPublic .cur').attr('v') || 0,//公开状态
						wrate:     $('#ratio .cur').attr('v') || 5,//提成比例
						orderType:'hm'//代购
					};
					break;
			}
			return buy;
		},
		/*获取购买的各种参数 ]]*/
		
		/*拼凑购买弹窗需要的参数[[*/
		dopay : function(t){
			t ? g.buyType=2 : g.buyType=1;//合买、自购
			var _obj = o.getArgument(g.buyType);
			var cMoney = '';
			t ? cMoney = g.hmMoney : cMoney = g.amount;//应付金额
			var data = {//支付弹框参数
					gid:     g.loty_id,//彩种id
					cMoney:  cMoney,//需支付金额
					payPara: _obj,//jQuery.param(param)
					bonus:   g.bonus//奖金范围
			};
			alert('提交中，请稍后！','loading');
			CP.User.info(function(options){
				!t && $('#jc_close').click();//代购的时候关闭选择过关方式的层
				remove_alert();
				if (options) {jQuery.extend(data, options);}
				CP.Popup.buybox(data);
			});
		},
		/*购买弹窗]]*/
		
		/*购买验证[[*/
		dobuy : function(t){
			var info = '';
			if(g.bet<1){
				info = '请输入倍数';
			}else if(g.amount<1){//投注列表没有内容
				info = '请至少选择一注彩票';
			}
			if(info!=''){alert(info);return;}
			g.codes = o.code();//点击自购或发起合买的时候 拼一下投注code值 o.getArgument里面要用到
			if(t){window.location.href = "#type=fun&fun=CP.JCDG.doHm";}else{o.dopay();}
		},
		/*购买验证]]*/
		
		/*code[[*/
		code : function () {
			var code = [];
			var json = againstData;
			if (json.length > 0) {
                for (var i = 0, j = json.length; i < j; i++) {
                	var Q = json[i].info;
                	for (var Q1 in Q) {
                		var _selectData = Q[Q1].selectData || [];
                		if(_selectData.length){
            					if (_selectData.join().replace(/,/g,'').split(',')[0]!='') {
        							var Q2 = [];
                    				for (var n=0, m = _selectData.length; n<m; n++) {
                    					if(_selectData[n]){
                    						var Q3 = {'0':'SPF','1':'RQSPF','2':'CBF','3':'JQS','4':'BQC'};
                    						Q2.push(Q3[n]+'='+_selectData[n].join('/'));
                    					}
                    				}
            						code.push(Q[Q1].itemid+'>'+Q2.join('+'));
            					}
                		}
                	}
                }
            }
			var Q5 = g.pass;
        	Q5 = $.map(Q5, function (item) {return item+'*1';});
			code = codeHeader+'|'+code.join(',')+'|'+Q5.join(',');
			return code;
		},
		/*]]code*/
		
		jc_bind : function(){//初始化购买相关操作的绑定事件
			$dom.$dobuy.bind(start_ev,function(){o.dobuy();});//代购
			$dom.$dohm.bind(start_ev,function(){o.dobuy('hm');});//发起合买
			$dom.$hmSubmit.bind(start_ev,function(){
				if(parseInt($('#rg').val()) < g.amount*0.05){return;}
				o.dopay('hm');});//提交合买
			$('#jc_next').on(start_ev, 'em', function () {//清空按钮
				Against.clear();
			}).on('click', 'a', function () {//下一步按钮
				$('#jczq_mask').one('click', function () {
    				$('#jczq_mask, #chuan_point').hide();
    				$('#jc_footer').removeClass('jc_footer');
				});
				Against.next();
			});
			$('#jc_close').bind('click', function () {//X按钮
				$('#jc_footer').removeClass('jc_footer');
				$('#jczq_mask').hide();
			});
			$('#jc_chuan').bind(start_ev, function () {//过关方式按钮
				$('#jc_chuan_list').toggleClass('jczqBlock');
			});
			$('#ggList li').bind(start_ev, function () {//选择过关方式
				if($('#ggList').find('.cur').length == 1 && $(this).is('.cur')){
					return
				}
				$(this).toggleClass('cur');
				var arr = [],arr2 = [];
            	arr = [].slice.call($('#ggList').find('.cur')).map(function(el){
                	var xo = $(el).html() || '';
					return xo;
				});
            	g.pass = [].slice.call($('#ggList').find('.cur')).map(function(el){
                	var xo = $(el).attr('v');
					return xo;
				});
            	$('#jc_chuan').html(arr.join(','));
            	Against.getCount();
			});
			$('#chuan_point').bind('click', '.bfb', function () {//关闭串关帮助
				$('#chuan_point').hide();
			});
			$('#chuan_ts').bind(start_ev, function () {//打开串关帮助
				$('#chuan_point').show();
			});
			$('#jc_bs').KeyBoard({
				val : '1',
				max : 99999,
				min : 1,
				num : 1,
				tag : '倍',
				fn  : function(){
					g.bet = parseInt($(this.ts).val()) || 0;
					Against.getCount();//计算金额
				}
			});
			
			/*合买事件[[*/
			$('#rg').on('keyup',function(){//认购 
				var bd_ = parseInt($('#bd').val());
				if($(this).val() >= g.amount){
					$(this).val(g.amount);
					$("#rg_bl").html("100%");
				}else{
					if($(this).val() == ''){
						$("#rg_bl").html("0%");
					}else{
						$("#rg_bl").html(Math.floor((parseInt($('#rg').val())/g.amount)*10000)/100+"%");
					}
				}
				if(!$("#chk").hasClass("nocheck") || parseInt($(this).val())+bd_>g.amount){
					if($(this).val() == ''){
						$('#bd').val(g.amount);
						$("#bd_bl").html('100%');
					}else{
						$('#bd').val(g.amount-parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
					}
				}
				o.hmDet();
			}).on('change',function(){//认购 小于5% 提示
				var t = $(this).val();
				if(t == ''){t=0;}
				if(parseInt(t) < g.amount*0.05){
					alert('认购金额不能小于5%');
					$(this).val(Math.ceil(g.amount*0.05));
					$("#rg_bl").html(Math.floor((parseInt($("#rg").val())/g.amount)*10000)/100+"%");
				}
				if(!$("#chk").hasClass("nocheck")){
					$('#bd').val(g.amount-parseInt($(this).val()));
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
				}
				o.hmDet();
			});
			$('#bd').on('keyup',function(){//保底 
				var rg_ = parseInt($('#rg').val());
				(parseInt($(this).val()) > g.amount-rg_) && $(this).val(g.amount-rg_);
				if($(this).val() == ''){
					$("#bd_bl").html("0%");
				}else{
					$(this).val(parseInt($(this).val()));
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
				}
				o.hmDet();
			}).on('change',function(){//保底等于空
				if($(this).val() == ''){
					$(this).val('0');
					$("#bd_bl").html("0%");
					o.hmDet();
				}
			});
			$('#chk').bind(start_ev,function(){
				var rg_ = parseInt($('#rg').val());
				$(this).toggleClass('nocheck');
				if(!$("#chk").hasClass("nocheck")){//全额保底
					$("#bd").attr('disabled',true);
					$("#bd").val(g.amount-rg_);
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
				}else{
					$("#bd").removeAttr('disabled');
				}
				o.hmDet();
			});
			$('#ratio li,#isPublic li').on(start_ev, function(){//提成   是否公开 点击事件
				!$(this).hasClass('cur') && $(this).toggleClass('cur');
				$(this).siblings().removeClass('cur');
			});
			/*]]合买事件*/
		}
    };
    /* 公用方法 ]] */
    
    var init = function() {
    	o.init();
    	o.jc_bind();
    };	
    return {init : init,
    		doHm : o.doHm,
    		changePlayType : o.changePlayType,
    		pageGo: o.pageGo
		};
})();
function resetPage(){//登录或合买的回调函数
	$('#content_home').show();//登录完之后显示投注层
	$('#box_header').addClass('zcHeader');
	CP.JCDG.pageGo.goBack();
	/*隐藏合买 显示投注界面 [[*/
	$(".jczqNav, #item, #jc_footer, #jczq_mask").show();
	$('#bethm, #jc_hm_footer').hide();
}
$(function(){
	CP.JCDG.init();	
});