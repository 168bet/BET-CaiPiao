CP.JC = (function() {
	var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	 //获取彩种类型
	/*全局变量[[*/
    var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//获取彩种
    var lotteryPlayName = ((lotteryType == 'jclq'|| lotteryType == 'jczq') ? 'hh' :'spf');//彩种下面的具体玩法  默认(竞彩/篮彩-混投;北单-胜平负)

    var $item = $('#item');//对阵dom
    var $dom = {
			$dobuy : $('#dobuy'),//代购按钮
			$dohm : $('#dohm'),//发起合买按钮
			$hmSubmit : $('#hmSubmit')//提交合买按钮
		};
    /*]]全局变量*/
	var lotteryInfo = {
			jczq:'竞彩足球',
			jclq:'竞彩篮球',
			bjdc:'足球单场',
			spf:'胜平负',
			rq:'让球',
			bf:'比分',
			jq:'总进球',
			bqc:'半全场',
			sxds:'上下单双',
			hh:'混投',
			rf:'让分',
			dxf:'大小分',
			sf:'胜负',
			sfc:'胜分差'
		};
	var codeHeader = {'spf':'SPF','rq':'RQSPF','bf':'CBF','jq':'JQS','bqc':'BQC','sxds':'SXP','hh':'HH','rf':'RFSF','dxf':'DXF','sf':'SF','sfc':'SFC'};
	var  g = {
        money : 0, //无倍投时的金额 即1倍时的
        bet : 5, //当前选择了多少倍数
        count : 0, //当前选择了多少注
        spArr : [],//每一排选了几个号 用于计算注数
        pass : [],//过关方式 如：[2,3] 表示选了2串1 3串1 
        amount : 0, //当前投注总金额金额  不代表合买应付金额
        hmMoney : 0,//合买应付金额
        bonus : 0,//理论奖金范围
        curChangCi : 0, //已选多少场次
        buyType : 1,//1:自购 2:合买
        codes : '',//投注code
		loty_id : '', //彩种id
		qihao_id : ''//当前期号
    };
    var error = ['至少选择2场比赛', '至少选择1场比赛'];
	var contrast = {
			jczq : {
				spf : {maxPass:8, gid:72, location:{'3':'0','1':'1','0':'2'}},//最大串关
				rq :  {maxPass:8, gid:90, location:{'3':'0','1':'1','0':'2'}},
				bf :  {maxPass:4, gid:91,
					location:{'1:0':'0','2:0':'1','2:1':'2','3:0':'3','3:1':'4','3:2':'5','4:0':'6','4:1':'7','4:2':'8','5:0':'9','5:1':'10','5:2':'11','9:0':'12',
						'0:0':'13','1:1':'14','2:2':'15','3:3':'16','9:9':'17',
						'0:1':'18','0:2':'19','1:2':'20','0:3':'21','1:3':'22','2:3':'23','0:4':'24','1:4':'25','2:4':'26','0:5':'27','1:5':'28','2:5':'29','0:9':'30'}},
				jq :  {maxPass:6,gid:93, location:{'0':'0','1':'1','2':'2','3':'3','4':'4','5':'5','6':'6','7':'7'}},
		        bqc : {maxPass:4, gid:92, location:{'3-3':'0','3-1':'1','3-0':'2','1-3':'3','1-1':'4','1-0':'5','0-3':'6','0-1':'7','0-0':'8'}},
		        hh : {maxPass:4, gid:70},
		        minLength:2,//最小场次
		        maxLength:15,//最多15场
		        maxBs:50000//最大投注倍数
			},
			bjdc : {
				spf : {maxPass:15, gid:85, location:{'3':'2','1':'1','0':'0'}},
				bf :  {maxPass:3, gid:86,
					location:{'1:0':'1','2:0':'2','2:1':'3','3:0':'4','3:1':'5','3:2':'6','4:0':'7','4:1':'8','4:2':'9','9:0':'0',
						'0:0':'11','1:1':'12','2:2':'13','3:3':'14','9:9':'10',
						'0:1':'16','0:2':'17','1:2':'18','0:3':'19','1:3':'20','2:3':'21','0:4':'22','1:4':'23','2:4':'24','0:9':'15'}},
		        jq :  {maxPass:6, gid:89, location:{'0':'0','1':'1','2':'2','3':'3','4':'4','5':'5','6':'6','7':'7'}},
		        bqc : {maxPass:6, gid:87, location:{'3-3':'0','3-1':'1','3-0':'2','1-3':'3','1-1':'4','1-0':'5','0-3':'6','0-1':'7','0-0':'8'}},
		        sxds :{maxPass:6, gid:88, location:{'3':'3','2':'2','1':'1','0':'0'}},
		        minLength:1,//最小场次
				maxLength:15,//最多15场
		        maxBs:50000//最大投注倍数
			},
			jclq : {
				sf :  {maxPass:8, gid:94, location:{'0':'0','3':'1'}},
				rf :  {maxPass:8, gid:95, location:{'0':'0','3':'1'}},
				dxf : {maxPass:8, gid:97, location:{'3':'0','0':'1'}},
				sfc : {maxPass:8, gid:96, location:{'11':'0','12':'1','13':'2','14':'3','15':'4','16':'5','01':'6','02':'7','03':'8','04':'9','05':'10','06':'11'}},
				hh : {maxPass:8, gid:71},
				minLength:2,//最小场次
				maxLength:15,//最多15场
		        maxBs:50000//最大投注倍数
			}
	};
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
    			if(lotteryType == 'jczq'){
    				url = '/data/app/jczq/new_jczq_hh.xml';
    			}else if(lotteryType == 'jclq'){
    				url = '/data/app/jclq/full_jclq_hh.xml';
    			}else{
    				url = '/data/app/bd/new_bd.xml';
    			}
    			$.ajax({
    				url : CP.Data.data+url,
    				type:'GET',
    				dataType:'xml',
    				success:function(xml){
    					var R = $(xml).find('Resp');
    					(lotteryType == 'bjdc') && (g.qihao_id = R.attr('pid'));
    					var rows = R.find('rows');
    					againstData =[];//北单切换玩法的时候重新加载对阵数据
    					rows.each(function (i) {
    						var t = {},t1=[];
    						t.addesc = $(this).attr('addesc');
    						t.desc = $(this).attr('desc');
    						var r = $(this).find('row');
    						r.each(function (a) {
    							var t2 = {};
    							t2.itemid = $(this).attr('itemid');
    							t2.hn = $(this).attr('hn').substr(0,5);//主队
    							t2.gn = $(this).attr('gn').substr(0,5);//客队
    							t2.et = $(this).attr('et');//停售
    							t2.mt = $(this).attr('mt');//比赛
    							t2.mname = $(this).attr('mname');//联赛  名
    							t2.name = $(this).attr('name');//周几
    							t2.cl = $(this).attr('cl');//联赛颜色
    							t2.close = $(this).attr('close');//让球数
    							t2.isale = $(this).attr('isale');//停售
    							if(lotteryType == 'jczq' || lotteryType == 'bjdc'){
    								t2.hm = $(this).attr('hm') || '--';//主队联赛排名
    								t2.gm = $(this).attr('gm') || '--';//客队联赛排名
    								t2.htn = $(this).attr('htn') || '--';//主队战绩
    								t2.gtn = $(this).attr('gtn') || '--';//客队战绩
    								t2.oh = $(this).attr('oh');//平均欧指 主
    								t2.od = $(this).attr('od');//平均欧指 平
    								t2.oa = $(this).attr('oa');//平均欧指 客
    								t2.htid = $(this).attr('htid');//主队编号
    								t2.gtid = $(this).attr('gtid');//客队编号
    								t2.spf_sp = $(this).attr('spf')||'';
    								t2.bf_sp = $(this).attr('cbf')||'';
    								t2.jq_sp = $(this).attr('jqs')||'';
    								t2.bqc_sp = $(this).attr('bqc')||'';
    								t2.sxds_sp = $(this).attr('sxp')||'';
    								t2.history = $(this).attr('history')||'';//历史交锋
    								if (lotteryType == 'bjdc'){
    									t2.ic = $(this).attr('ic');
    								}else{
    									t2.hot = $(this).attr('hot');
    									t2.tco = $(this).attr('tco');
        								t2.tcoscale = $(this).attr('tcoscale');
        								t2.spfscale = $(this).attr('spfscale');
        								t2.rqspfscale = $(this).attr('rqspfscale');
        								t2.rq_sp = $(this).attr('rqspf');//让球胜平负赔率
    								}
    							}else if(lotteryType == 'jclq'){
        							t2.bet3 = $(this).attr('bet3');
        							t2.bet0 = $(this).attr('bet0');
        							t2.zclose = $(this).attr('zclose');//大小分
        							t2.mid = $(this).attr('mid');
        							t2.sf_sp = $(this).attr('sf');
        							t2.rf_sp = $(this).attr('rfsf');
        							t2.dxf_sp = $(this).attr('dxf');
        							t2.sfc_sp = $(this).attr('sfc');//胜分差
    							}
    							
    							if((lotteryType == 'jclq' && (32 & t2.isale) > 0) || (lotteryType == 'jczq' && (32 & t2.isale) > 0) || (lotteryType == 'jczq' && (512 & t2.isale) > 0)){
    								t1.unshift(t2);//向数组开头插入元素
    							}else{
    								t1.push(t2);
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
    			g.loty_id = contrast[lotteryType][lotteryPlayName].gid;
    			/***
    			if(g.loty_id==85){
    				g.bet=1
    				$("#jc_bs").html("1")
    			}
    			***/
    			var _out=[];
    			if(!againstData.length){//对阵列表中是否有数据
    				_out.push('<div style="padding-top:50px;text-align:center;">暂无对阵!</div>');
    			}else{
    				/*兼容篮彩样式[[*/
    				if(lotteryType == 'jclq'){
    					var cl_ = {'sf':'jclqVs','rf':'jclqVs','dxf':'jclqDxf','hh':'',"sfc":""}[lotteryPlayName];//'hh':'jclqhh'
    					$item.attr('class',cl_);
    				}else{
    					$item.removeAttr('class');
    				}
    				/*]]兼容篮彩样式*/
    				for(var i=0,l=againstData.length;i<l;i++){
    					_out.push('<section>');
    					_out.push('<div class="sfcTitle">'+againstData[i].addesc+'<em class="up"></em></div>');
    					_out.push('<div>');
    					var t = againstData[i].info;
    					for(var n=0,t1=t.length;n<t1;n++){
    						var name_ = (lotteryType == 'bjdc' && t[n].itemid.substr(-3) || t[n].name.substr(-3));
    						var sp_ = '';
    						if (lotteryPlayName == 'spf' || lotteryPlayName == 'rq') {//竞彩足球胜平负 北单胜平负     //竞足 让球胜平负
    							if(((16 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'spf') || ((1 & t[n].isale) > 0 && lotteryPlayName == 'rq') || lotteryType == 'bjdc'){
    								sp_ =  (lotteryPlayName=='spf' && t[n].spf_sp.split(',') || t[n].rq_sp.split(','));
        							var rq_ = '';//胜平负默认不显示让球
        							if(lotteryPlayName == 'rq' || (lotteryType == 'bjdc' && lotteryPlayName == 'spf')){
        								if(t[n].close != '0'){
        									rq_ = '<i class="'+(t[n].close.indexOf('-')>=0?'green2':'red')+'">('+(t[n].close.indexOf('-')<0?'+':'')+t[n].close+')</i>';
        								}
        							}
        							_out.push('<ul class="sfcxs" data-id='+t[n].itemid+'>');
        							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><i class="up down"></i></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpk spfzpk2 '+(t[n].hot=='yes'? 'spfzpk3' :'')+'">');
        							if(((512 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'spf') || ((32 & t[n].isale) > 0 && lotteryPlayName == 'rq')){//jczq 单关
        								_out.push('<span class=wang-ball my-data=3 dg=dg><em>'+t[n].hn+''+rq_+'</em><cite>胜</cite></span><span class="spfvs wang-ball" my-data=1 dg=dg><em>VS</em><cite>平</cite></span><span class=wang-ball my-data=0 dg=dg><em>'+t[n].gn+'</em><cite>胜</cite></span></p>');
            							_out.push('<p class="spfpl"><span>赔率'+sp_[lotteryType == 'jczq' ? 0 :2]+'</span><span class="spfvs">赔率'+sp_[1]+'</span><span>赔率'+sp_[lotteryType == 'jczq' ? 2 : 0]+'</span></p></li>');
        								_out.push('<div class="dgtop"></div>');
        							}else{
        								_out.push('<span class=wang-ball my-data=3><em>'+t[n].hn+''+rq_+'</em><cite>胜</cite></span><span class="spfvs wang-ball" my-data=1><em>VS</em><cite>平</cite></span><span class=wang-ball my-data=0><em>'+t[n].gn+'</em><cite>胜</cite></span></p>');
            							_out.push('<p class="spfpl"><span>赔率'+sp_[lotteryType == 'jczq' ? 0 :2]+'</span><span class="spfvs">赔率'+sp_[1]+'</span><span>赔率'+sp_[lotteryType == 'jczq' ? 2 : 0]+'</span></p></li>');
        							}
        							_out.push('</ul>');
    							}
    						}
    						else if(lotteryPlayName == 'bf'||lotteryPlayName == 'bqc') {//竞足 北单 比分 //竞足 北单半全场
    							if(((2 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'bf') || ((4 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'bqc') || lotteryType == 'bjdc'){
    								_out.push('<ul class="sfcxs" data-id='+t[n].itemid+'>');
        							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><i class="up down"></i></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'">');
        							_out.push('<span><em>'+t[n].hn+'</em></span><span class="spfvs"><em>VS</em></span><span><em>'+t[n].gn+'</em></span></p><p class="spfzpk bfpk">');
        							if(((64 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'bf') || ((128 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'bqc')){//jczq 单关
        								_out.push('<span class=wei-ball dg=dg>立即投注</span></p></li>');
            							_out.push('<div class="dgtop"></div>');
        							}else{
        								_out.push('<span class=wei-ball>立即投注</span></p></li>');
        							}
        							_out.push('</ul>');
    							}
    						}
    						else if(lotteryPlayName == 'jq') {//竞足 北单 总进球
    							if((8 & t[n].isale) > 0 || lotteryType == 'bjdc'){
    								sp_ =  t[n].jq_sp.split(',');
        							_out.push('<ul class="sfcxs jqzpk" data-id='+t[n].itemid+'>');
        							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><i class="up down"></i></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'"><span><em>'+t[n].hn+'</em></span><span class="spfvs"><em>VS</em></span><span><em>'+t[n].gn+'</em></span></p>');
        							_out.push('<p class="spfzpk">');
        							
        							if((256 & t[n].isale) > 0 && lotteryType == 'jczq' && lotteryPlayName == 'jq'){//jczq 单关
        								_out.push('<span class=wang-ball my-data=0 dg=dg><b>0</b><cite>'+sp_[0]+'</cite></span><span class=wang-ball my-data=1 dg=dg><b>1</b><cite>'+sp_[1]+'</cite></span>\
        										<span class=wang-ball my-data=2 dg=dg><b>2</b><cite>'+sp_[2]+'</cite></span><span class=wang-ball my-data=3 dg=dg><b>3</b><cite>'+sp_[3]+'</cite></span></p><p class="spfzpk">');
            							_out.push('<span class=wang-ball my-data=4 dg=dg><b>4</b><cite>'+sp_[4]+'</cite></span><span class=wang-ball my-data=5 dg=dg><b>5</b><cite>'+sp_[5]+'</cite></span>');
            							_out.push('<span class=wang-ball my-data=6 dg=dg><b>6</b><cite>'+sp_[6]+'</cite></span><span class=wang-ball my-data=7 dg=dg><b>7+</b><cite>'+sp_[7]+'</cite></span></p>');
            							_out.push('</li>');
            							_out.push('<div class="dgtop"></div>');
        							}else{
        								_out.push('<span class=wang-ball my-data=0><b>0</b><cite>'+sp_[0]+'</cite></span><span class=wang-ball my-data=1><b>1</b><cite>'+sp_[1]+'</cite></span>\
        										<span class=wang-ball my-data=2><b>2</b><cite>'+sp_[2]+'</cite></span><span class=wang-ball my-data=3><b>3</b><cite>'+sp_[3]+'</cite></span></p><p class="spfzpk">');
            							_out.push('<span class=wang-ball my-data=4><b>4</b><cite>'+sp_[4]+'</cite></span><span class=wang-ball my-data=5><b>5</b><cite>'+sp_[5]+'</cite></span>');
            							_out.push('<span class=wang-ball my-data=6><b>6</b><cite>'+sp_[6]+'</cite></span><span class=wang-ball my-data=7><b>7+</b><cite>'+sp_[7]+'</cite></span></p>');
            							_out.push('</li>');
        							}
        							_out.push('</ul>');
    							}
    						}
    						else if(lotteryPlayName == 'sxds') {//北单上下单双
    							sp_ =  t[n].sxds_sp.split(',');
    							_out.push('<ul class="sfcxs jqzpk sxzpk" data-id='+t[n].itemid+'>');
    							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><i class="up down"></i></li>');
    							_out.push('<li>');
    							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'"><span>'+t[n].hn+'</span><span class="spfvs">VS</span><span>'+t[n].gn+'</span></p>');
    							_out.push('<p class="spfzpk">');
    							_out.push('<span class=wang-ball my-data=3><b>上单</b><cite>'+sp_[3]+'</cite></span>');
    							_out.push('<span class=wang-ball my-data=2><b>上双</b><cite>'+sp_[2]+'</cite></span>');
    							_out.push('<span class=wang-ball my-data=1><b>下单</b><cite>'+sp_[1]+'</cite></span>');
    							_out.push('<span class=wang-ball my-data=0><b>下双</b><cite>'+sp_[0]+'</cite></span>');
    							_out.push('</p>');
    							_out.push('</li>');
    							_out.push('</ul>');
    						}
    						else if(lotteryPlayName == 'hh') {//篮彩 竞足混投
    							if(lotteryType == 'jczq'){
    								var rq_ = '<i class="'+(t[n].close.indexOf('-')>=0?'green2':'red')+'">('+(t[n].close.indexOf('-')<0?'+':'')+t[n].close+')</i>';
    								_out.push('<ul class="sfcxs hhzpk" data-id='+t[n].itemid+'>');
        							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><i class="up down"></i></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'"><span><em>'+t[n].hn+rq_+'</em></span><span class="spfvs"><em>VS</em></span><span><em>'+t[n].gn+'</em></span></p>');
        							_out.push('<p class="spfzpk"><em>非让球</em>');
        							sp_ =  t[n].spf_sp.split(',');
        							if((16 & t[n].isale) > 0){//竞彩胜平负开售
        								_out.push('<span class=wang-ball my-data=3>胜 '+sp_[0]+'</span><span class=wang-ball my-data=1>平 '+sp_[1]+'</span><span class=wang-ball my-data=0>胜 '+sp_[2]+'</span>');
        							}else{
        								_out.push('<span>--</span><span>--</span><span>--</span>');
        							}
        							_out.push('</p>');
        							_out.push('<p class="spfzpk"><em class="rq">让球</em>');
        							sp_ =  t[n].rq_sp.split(',');
        							if((1 & t[n].isale) > 0){//竞彩让球开售
        								_out.push('<span class=wang-ball my-data=3>胜 '+sp_[0]+'</span><span class=wang-ball my-data=1>平 '+sp_[1]+'</span><span class=wang-ball my-data=0>胜 '+sp_[2]+'</span>');
        							}else{
        								_out.push('<span>--</span><span>--</span><span>--</span>');
        							}
        							_out.push('</p>');
        							_out.push('<div class="hhmore wei-ball">更多玩法</div>');
        							_out.push('</li>');
        							_out.push('</ul>');
    							}else{
    								rq_ = '<i class="'+(t[n].close.indexOf('-')>=0?'blue':'red')+'">('+t[n].close+')</i>';
    								_out.push('<ul class="sfcxs hhzpk lqhtspan" data-id='+t[n].itemid+'>');
    								_out.push('<li><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite></li>');
    								_out.push('<li>');
    								
    								_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'"><span><em>'+t[n].gn+'</em></span><span class="spfvs"><em>VS</em></span><span><em>'+t[n].hn+rq_+'</em></span></p>');
    								
    								_out.push('<p class="spfzpk"><em class="rq">让分</em>');
    								sp_ =  t[n].rf_sp.split(',');
    								if((32 & t[n].isale) > 0){//让分胜负单关
    									_out.push('<span class=wang-ball my-data=0 dg=dg><b>客胜</b><cite>'+sp_[0]+'</cite></span><span class=wang-ball my-data=3 dg=dg><b>主胜</b><cite>'+sp_[1]+'</cite></span>');
        							}else{
        								_out.push('<span class=wang-ball my-data=0><b>客胜</b><cite>'+sp_[0]+'</cite></span><span class=wang-ball my-data=3><b>主胜</b><cite>'+sp_[1]+'</cite></span>');
        							}
    								_out.push('</p>');
    								_out.push('<p class="spfzpk"><em>猜总分</em>');
    								sp_ =  t[n].dxf_sp.split(',');
    								if((128 & t[n].isale) > 0){//大小分单关
    									_out.push('<span class=wang-ball my-data=3 dg=dg><b>&gt;'+t[n].zclose+'分</b><cite>'+sp_[0]+'</cite></span><span class=wang-ball my-data=0 dg=dg><b>&lt;'+t[n].zclose+'分</b><cite>'+sp_[1]+'</cite></span>');
    								}else{
    									_out.push('<span class=wang-ball my-data=3><b>&gt;'+t[n].zclose+'分</b><cite>'+sp_[0]+'</cite></span><span class=wang-ball my-data=0><b>&lt;'+t[n].zclose+'分</b><cite>'+sp_[1]+'</cite></span>');
    								}
    								_out.push('</p>');
    								_out.push('<div class="hhmore wei-ball">更多玩法</div>');
    								_out.push('</li>');
    								if((128 & t[n].isale) > 0 || (32 & t[n].isale) > 0){//大小分单关
    									_out.push('<div class="dgtop"></div>');
    								}
    								_out.push('</ul>');
    							}
    						}
    						else if(lotteryPlayName == 'sf' || lotteryPlayName == 'rf') {//篮彩胜负 //篮彩让分胜负
    							if((lotteryPlayName == 'sf' && (1 & t[n].isale) > 0) ||(lotteryPlayName == 'rf' && (2 & t[n].isale) > 0)){//过滤掉不开售的
    								var rq_ = '';//胜负默认不显示让球
        							if(lotteryPlayName == 'rf'){
        								rq_ = '<i class="'+(t[n].close.indexOf('-')>=0?'blue':'red')+'">('+t[n].close+')</i>';
        							}
        							sp_ = (lotteryPlayName=='sf' && t[n].sf_sp.split(',') || t[n].rf_sp.split(','));
    								_out.push('<ul class="sfcxs" data-id='+t[n].itemid+'>');
        							_out.push('<li><em>'+name_+'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpk spfzpk2 '+(t[n].hot=='yes'? 'spfzpk3' :'')+'">');
        							if(lotteryPlayName == 'rf' && (32 & t[n].isale) > 0){//让分胜负单关
        								_out.push('<span class=wang-ball my-data=0 dg=dg><em>'+t[n].gn+'</em><cite>胜</cite></span><b>VS</b><span class=wang-ball my-data=3 dg=dg><em>'+t[n].hn+rq_+'</em><cite>胜</cite></span></p>');
        								_out.push('<p class="spfpl"><span>赔率'+sp_[0]+'</span><span>赔率'+sp_[1]+'</span></p></li>');
        								_out.push('<div class="dgtop"></div>');
        							}else{
        								_out.push('<span class=wang-ball my-data=0><em>'+t[n].gn+'</em><cite>胜</cite></span><b>VS</b><span class=wang-ball my-data=3><em>'+t[n].hn+rq_+'</em><cite>胜</cite></span></p>');
        								_out.push('<p class="spfpl"><span>赔率'+sp_[0]+'</span><span>赔率'+sp_[1]+'</span></p></li>');
        							}
        							_out.push('</ul>');
    							}
    						}
    						else if(lotteryPlayName == 'dxf') {//篮彩大小分
    							if((8 & t[n].isale) > 0){
    								sp_ = t[n].dxf_sp.split(',');
									_out.push('<ul class="sfcxs" data-id='+t[n].itemid+'>');
        							_out.push('<li><em>'+name_+'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'"><span><em>'+t[n].gn+'</em></span><span class="spfvs">VS</span><span><em>'+t[n].hn+'</em></span></p>');
        							if((128 & t[n].isale) > 0){//大小分单关
        								_out.push('<p class="spfzpk"><span class=wang-ball my-data=3 dg=dg>总分&gt;'+t[n].zclose+'</span><span class=wang-ball my-data=0 dg=dg>总分&lt;'+t[n].zclose+'</span></p>');
        								_out.push('<p class="spfpl"><span>赔率'+sp_[0]+'</span><span>赔率'+sp_[1]+'</span></p>');
        								_out.push('<div class="dgtop"></div>');
    								}else{
    									_out.push('<p class="spfzpk"><span class=wang-ball my-data=3>总分&gt;'+t[n].zclose+'</span><span class=wang-ball my-data=0>总分&lt;'+t[n].zclose+'</span></p>');
    									_out.push('<p class="spfpl"><span>赔率'+sp_[0]+'</span><span>赔率'+sp_[1]+'</span></p>');
    								}
        							
        							_out.push('</li>');
        							_out.push('</ul>');
    							}
    						}else if(lotteryPlayName == 'sfc'){//竞彩篮球胜分差
    							if((8 & t[n].isale) > 0){
    								_out.push('<ul class="sfcxs sfcli" data-id='+t[n].itemid+'>');
        							_out.push('<li class=wangwei><em>'+ name_ +'</em><p>'+t[n].mname+'</p><cite>'+t[n].et.substr(11,5)+' 截止</cite><!--<i class="up down">--></i></li>');
        							_out.push('<li>');
        							_out.push('<p class="spfzpkNum '+(t[n].hot=='yes'? 'spfzpk3' :'')+'">');
        							_out.push('<span><em>'+t[n].hn+'</em></span><span class="spfvs"><em>VS</em></span><span><em>'+t[n].gn+'</em></span></p><p class="spfzpk bfpk">');
        							
        							if(((64 & t[n].isale) > 0 && lotteryType == 'jclq' && lotteryPlayName == 'sfc')){//jczq 单关
        								_out.push('<span class=wei-ball dg=dg>立即投注</span></p></li>');
            							_out.push('<div class="dgtop"></div>');
        							}else{
        								_out.push('<span class=wei-ball>立即投注</span></p></li>');
        							}
        							
        							//_out.push('<span class=wei-ball>立即投注</span></p></li>');
        							_out.push('</ul>');
    							}
    						}
    						if (lotteryType != 'jclq') {//竞彩篮球木有这玩意
    							var jf = '暂无交锋记录';
    							if(t[n].history){//历史交锋
    								jf = '两队近'+t[n].history.length+'次交锋，'+t[n].hn+'<strong>'+t[n].history+'</strong>';
    							}
        						_out.push('<div class="sfcpl" style="display:none;">');
        						_out.push('<dl><dt>历史交锋</dt><dd style="width:80%; text-align:center">'+jf+'</dd></dl>');
        						if(lotteryType == 'jczq'){
        							var bl = t[n].spfscale.split(',');
        							if(lotteryPlayName == 'hh'){
        								var rbl = t[n].rqspfscale.split(',');
        								var rq = '<em class="'+(t[n].close.indexOf('-')>=0?'green2':'red')+'">'+(t[n].close.indexOf('-')<0?'+':'')+t[n].close+'</em>';
        								_out.push('<dl class="tzbl"><dt>投注比例</dt>\
        										<dd><p><em>0</em><span>'+(bl[0] || '--')+'</span><span>'+(bl[1] || '--')+'</span><span>'+(bl[2] || '--')+'</span></p>\
        										<p>'+rq+'<span>'+(rbl[0] || '--')+'</span><span>'+(rbl[1] || '--')+'</span><span>'+(rbl[2] || '--')+'</span></p></dd></dl>');
        							}else{
            							_out.push('<dl><dt>投注比例</dt><dd>'+(bl[0] || '--')+'</dd><dd>'+(bl[1] || '--')+'</dd><dd>'+(bl[2]||'--')+'</dd></dl>');
        							}
        						}else{
        							_out.push('<dl><dt>联赛排名</dt><dd>'+t[n].hm+'</dd><dd>&nbsp;</dd><dd>'+t[n].gm+'</dd></dl>');
        						}
        						if(lotteryType == 'jczq'){
        							_out.push('<dl class="bfzb blue" type='+17+' qc='+t[n].itemid.substr(0,6)+' itemid='+t[n].itemid+'>详细赛事分析&gt;</dl>');
        						}else{
        							_out.push('<dl class="bfzb blue" type='+17+' qc='+g.qihao_id+' itemid='+t[n].itemid+'>详细赛事分析&gt;</dl>');
        						}
								_out.push('</div>');
    						}
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
    			
    			function sfc(_obj){//胜分差
    				_obj.sort(function(a,b){							
    						return(b - a);	
                        });
    				
    				var arr = [];
    				for(var s in _obj){
    					switch(_obj[s]){
    						case '11':arr.push('客胜1-5');break;
    						case '12':arr.push('客胜6-10');break;
    						case '13':arr.push('客胜11-15');break;
    						case '14':arr.push('客胜16-20');break;
    						case '15':arr.push('客胜21-25');break;
    						case '16':arr.push('客胜26+');break;
    						
    						case '01':arr.push('主胜1-5');break;
    						case '02':arr.push('主胜6-10');break;
    						case '03':arr.push('主胜11-15');break;
    						case '04':arr.push('主胜16-20');break;
    						case '05':arr.push('主胜21-25');break;
    						case '06':arr.push('主胜26+');break;
    					}
    				}
    				return arr;	
    			}	
    			
    			if(lotteryPlayName == 'bf'){
    				arr = bf(obj);	
    			}else if(lotteryPlayName == 'bqc'){
    				arr = bqc(obj);	
    			}else if(lotteryPlayName == 'sfc'){
    				arr = sfc(obj);	
    			}else if(lotteryPlayName == 'hh'){
    				var t=0;
    				for (var i=0, l=obj.length; i<l; i++) {
    					var tt = obj[i]||[];
    					t += tt.length;
    				}
    				return (t>0 && '已选'+t+'项' || '更多玩法');
    			}
    			var str = arr.length;
    			
    			if(lotteryPlayName == 'sfc'){
    				if(str>3){
        				str = '已选'+str+'项';
        			}else{
        				str = '';
        				for(var s in arr){
        					str += '<cite '+Q+'>'+arr[s]+'</cite>'
    					}
        			}
    			}else{
    				if(str>6){
        				str = '已选'+str+'项';
        			}else{
        				str = '';
        				for(var s in arr){
        					var Q = {'胜其它':'class=sqt','平其它':'class=sqt','负其它':'class=sqt'}[arr[s]]||''
        					str += '<cite '+Q+'>'+arr[s]+'</cite>'
    					}
        			}
    			}
    			
    			return str;
    		},
    		container : function (el) {//给$('#tc')层赋值 和点击事件
    			function main(){
					if(g.curChangCi >= contrast[lotteryType].maxLength){
						if(!$(el).is('.cur')){
							alert(lotteryInfo[lotteryPlayName]+'最多选'+contrast[lotteryType].maxLength+'场');return;	
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
					if(lotteryPlayName=='bf'){//比分
						var sp = obj[lotteryPlayName+'_sp'].split(',');
						html='<div class="bftkScroll">\
							<div class="bfTitle clearfix"><p>'+obj.hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+obj.gn+'</p></div>\
							   <div class="bfScroll" style="height:0px" id=tc_c>\
							    <p class="red">'+obj.hn+'&nbsp;胜</p>\
							     <div class="competitions bfcom">';
										if (lotteryType == 'jczq') {
											html += '<span my-data=1:0><strong>1:0</strong><em>'+sp[0]+'</em></span>\
							            	<span my-data=2:0><strong>2:0</strong><em>'+sp[1]+'</em></span>\
							            	<span my-data=2:1><strong>2:1</strong><em>'+sp[2]+'</em></span>\
							            	<span my-data=3:0><strong>3:0</strong><em>'+sp[3]+'</em></span>\
							            	<span my-data=3:1><strong>3:1</strong><em>'+sp[4]+'</em></span>\
							            	<span my-data=3:2><strong>3:2</strong><em>'+sp[5]+'</em></span>\
							            	<span my-data=4:0><strong>4:0</strong><em>'+sp[6]+'</em></span>\
							            	<span my-data=4:1><strong>4:1</strong><em>'+sp[7]+'</em></span>\
							            	<span my-data=4:2><strong>4:2</strong><em>'+sp[8]+'</em></span>\
							                <span my-data=5:0><strong>5:0</strong><em>'+sp[9]+'</em></span>\
							                <span my-data=5:1><strong>5:1</strong><em>'+sp[10]+'</em></span>\
							                <span my-data=5:2><strong>5:2</strong><em>'+sp[11]+'</em></span>\
							            	<span class="bflast" my-data=9:0><strong>胜其它</strong><em>'+sp[12]+'</em></span>';
										} else {//这脑残弄的xml 北单比分sp完全不是正常的顺序
											html += '<span my-data=1:0><strong>1:0</strong><em>'+sp[1]+'</em></span>\
											<span my-data=2:0><strong>2:0</strong><em>'+sp[2]+'</em></span>\
											<span my-data=2:1><strong>2:1</strong><em>'+sp[3]+'</em></span>\
											<span my-data=3:0><strong>3:0</strong><em>'+sp[4]+'</em></span>\
											<span my-data=3:1><strong>3:1</strong><em>'+sp[5]+'</em></span>\
											<span my-data=3:2><strong>3:2</strong><em>'+sp[6]+'</em></span>\
											<span my-data=4:0><strong>4:0</strong><em>'+sp[7]+'</em></span>\
											<span my-data=4:1><strong>4:1</strong><em>'+sp[8]+'</em></span>\
											<span my-data=4:2><strong>4:2</strong><em>'+sp[9]+'</em></span>\
											<span class="bflast" my-data=9:0><strong>胜其它</strong><em>'+sp[0]+'</em></span>';	
										}
										html += '<div class="clear"></div>\
							     </div>\
							  	<p class="blue pdTop06 pdLeft08 pdBot03">打平</p>\
							     <div class="competitions bfcom">';
									     if (lotteryType == 'jczq') {
									    	 html += '<span my-data=0:0><strong>0:0</strong><em>'+sp[13]+'</em></span>\
								            	<span my-data=1:1><strong>1:1</strong><em>'+sp[14]+'</em></span>\
								            	<span my-data=2:2><strong>2:2</strong><em>'+sp[15]+'</em></span>\
								            	<span my-data=3:3><strong>3:3</strong><em>'+sp[16]+'</em></span>\
								            	<span my-data=9:9 class="bflast"><strong>平其它</strong><em>'+sp[17]+'</em></span>';
									     } else {
									    	 html += '<span my-data=0:0><strong>0:0</strong><em>'+sp[11]+'</em></span>\
													<span my-data=1:1><strong>1:1</strong><em>'+sp[12]+'</em></span>\
													<span my-data=2:2><strong>2:2</strong><em>'+sp[13]+'</em></span>\
													<span my-data=3:3><strong>3:3</strong><em>'+sp[14]+'</em></span>\
													<span my-data=9:9 class="bflast"><strong>平其它</strong><em>'+sp[10]+'</em></span>';
									     }
							            	
									     html += '<div class="clear"></div>\
							     </div>\
							  	<p class="green pdTop06 pdLeft08 pdBot03">'+obj.gn+'&nbsp;胜</p>\
							     <div class="competitions bfcom">';
									     if (lotteryType == 'jczq') {
									    	 html += '<span my-data=0:1><strong>0:1</strong><em>'+sp[18]+'</em></span>\
								            	<span my-data=0:2><strong>0:2</strong><em>'+sp[19]+'</em></span>\
								            	<span my-data=1:2><strong>1:2</strong><em>'+sp[20]+'</em></span>\
								            	<span my-data=0:3><strong>0:3</strong><em>'+sp[21]+'</em></span>\
								            	<span my-data=1:3><strong>1:3</strong><em>'+sp[22]+'</em></span>\
								            	<span my-data=2:3><strong>2:3</strong><em>'+sp[23]+'</em></span>\
								            	<span my-data=0:4><strong>0:4</strong><em>'+sp[24]+'</em></span>\
								            	<span my-data=1:4><strong>1:4</strong><em>'+sp[25]+'</em></span>\
								            	<span my-data=2:4><strong>2:4</strong><em>'+sp[26]+'</em></span>\
								                <span my-data=0:5><strong>0:5</strong><em>'+sp[27]+'</em></span>\
								                <span my-data=1:5><strong>1:5</strong><em>'+sp[28]+'</em></span>\
								                <span my-data=2:5><strong>2:5</strong><em>'+sp[29]+'</em></span>\
								            	<span my-data=0:9 class="bflast"><strong>负其它</strong><em>'+sp[30]+'</em></span>';
									     } else {
									    	 html += '<span my-data=0:1><strong>0:1</strong><em>'+sp[16]+'</em></span>\
													<span my-data=0:2><strong>0:2</strong><em>'+sp[17]+'</em></span>\
													<span my-data=1:2><strong>1:2</strong><em>'+sp[18]+'</em></span>\
													<span my-data=0:3><strong>0:3</strong><em>'+sp[19]+'</em></span>\
													<span my-data=1:3><strong>1:3</strong><em>'+sp[20]+'7</em></span>\
													<span my-data=2:3><strong>2:3</strong><em>'+sp[21]+'</em></span>\
													<span my-data=0:4><strong>0:4</strong><em>'+sp[22]+'</em></span>\
													<span my-data=1:4><strong>1:4</strong><em>'+sp[23]+'</em></span>\
													<span my-data=2:4><strong>2:4</strong><em>'+sp[24]+'</em></span>\
													<span my-data=0:9 class="bflast"><strong>负其它</strong><em>'+sp[15]+'</em></span>';
									     }
						            	 html += '<div class="clear"></div>\
							     </div>\
							  </div>\
							    <div class="zfTrue zfTrue2 clearfix"><a href="javascript:;" class="zfqx" id=tc_cancel>取 消</a><a id=tc_ok href="javascript:;">确 定</a></div>\
							</div>';
					} else if (lotteryPlayName=='bqc') {//半全场
						var sp = obj[lotteryPlayName+'_sp'].split(',');
						html='<div class="bfTitle clearfix">\
							<p>'+obj.hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+obj.gn+'</p>\
							</div>\
							<p class="gray mgTop03">［例］胜负：上半场主胜 且 全场主负</p>\
							<div style="margin-top:.4rem" class="competitions bqccom" id=tc_c>\
								<span my-data=3-3><strong>胜胜</strong><em>'+sp[0]+'</em></span>\
								<span my-data=3-1><strong>胜平</strong><em>'+sp[1]+'</em></span>\
								<span my-data=3-0><strong>胜负</strong><em>'+sp[2]+'</em></span>\
								<span my-data=1-3><strong>平胜</strong><em>'+sp[3]+'</em></span>\
								<span my-data=1-1><strong>平平</strong><em>'+sp[4]+'</em></span>\
								<span my-data=1-0><strong>平负</strong><em>'+sp[5]+'</em></span>\
								<span my-data=0-3><strong>负胜</strong><em>'+sp[6]+'</em></span>\
								<span my-data=0-1><strong>负平</strong><em>'+sp[7]+'</em></span>\
								<span my-data=0-0><strong>负负</strong><em>'+sp[8]+'</em></span>\
							<div class="clear"></div>\
							</div>\
							<div class="zfTrue clearfix"><a class="zfqx" href="javascript:;" id=tc_cancel>取 消</a><a id=tc_ok href="javascript:;">确 定</a></div>';
					} else if (lotteryPlayName=='sfc') {//猜比分
						var sp = obj[lotteryPlayName+'_sp'].split(',');
						html='<div class="bfTitle clearfix">\
							<p>'+obj.hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+obj.gn+'</p>\
							</div>\
							<p class="gray mgTop03">［例］主队 胜1-5：完场比分主队高于客队1-5分</p>\
							<div class="bfScroll" style="" id="tc_c">\
								<p class="red">'+obj.hn+'&nbsp;胜</p>\
								<div style="margin-top:.4rem" class="competitions bqccom">\
									<span my-data=11><strong>(1-5)</strong><em>'+sp[0]+'</em></span>\
									<span my-data=12><strong>(6-10)</strong><em>'+sp[1]+'</em></span>\
									<span my-data=13><strong>(11-15)</strong><em>'+sp[2]+'</em></span>\
									<span my-data=14><strong>(16-20)</strong><em>'+sp[3]+'</em></span>\
									<span my-data=15><strong>(21-25)</strong><em>'+sp[4]+'</em></span>\
									<span my-data=16><strong>(26+)</strong><em>'+sp[5]+'</em></span>\
									<div class="clear"></div>\
								</div>\
								<p class="red">'+obj.gn+'&nbsp;胜</p>\
								<div style="margin-top:.4rem" class="competitions bqccom">\
								<span my-data=01><strong>(1-5)</strong><em>'+sp[6]+'</em></span>\
								<span my-data=02><strong>(6-10)</strong><em>'+sp[7]+'</em></span>\
								<span my-data=03><strong>(11-15)</strong><em>'+sp[8]+'</em></span>\
								<span my-data=04><strong>(16-20)</strong><em>'+sp[9]+'</em></span>\
								<span my-data=05><strong>(21-25)</strong><em>'+sp[10]+'</em></span>\
								<span my-data=06><strong>(26+)</strong><em>'+sp[11]+'</em></span>\
								<div class="clear"></div>\
								</div>\
							</div>\
							<div class="zfTrue clearfix"><a class="zfqx" href="javascript:;" id=tc_cancel>取 消</a><a id=tc_ok href="javascript:;">确 定</a></div>';
					}else if (lotteryPlayName == 'hh' && lotteryType=="jczq") {
						var spf_sp = obj['spf_sp'].split(',');
						var rq_sp = obj['rq_sp'].split(',');
						var bf_sp = obj['bf_sp'].split(',');
						var jq_sp = obj['jq_sp'].split(',');
						var bqc_sp = obj['bqc_sp'].split(',');
						html='<div class="bfTitle clearfix"><p>'+obj.hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+obj.gn+'</p></div>\
							<article class="bfScroll hhscroll" style="height:0px" id=tc_c>\
					    <p class="gray">非让球/让球</p>\
					     <div class="competitions hhcom" i=0>';
						if((16 & obj.isale)>0){
							html+='<span my-data=3>主胜<em>'+spf_sp[0]+'</em></span><span my-data=1>平<em>'+spf_sp[1]+'</em></span><span my-data=0>主负<em>'+spf_sp[2]+'</em></span>';
						}else{
							html+='<span>停售</span><span>停售</span><span>停售</span>';
						}
		            	html+='</div>\
		            	<div class="competitions hhcom" i=1 style="border-top:none;">';
		            	if((1 & obj.isale)>0){
		            		html+='<span my-data=3>主<cite class="'+(obj.close.indexOf('-')>=0?'green2':'red')+'">('+(obj.close.indexOf('-')<0?'+':'')+obj.close+')</cite>胜<em>'+rq_sp[0]+'</em></span><span my-data=1>平<em>'+rq_sp[1]+'</em></span><span my-data=0>主负<em>'+rq_sp[2]+'</em></span>';
						}else{
							html+='<span>停售</span><span>停售</span><span>停售</span>';
						}
		            	html+='<div class="clear"></div>\
					     </div>\
					  	<p class="gray">比分</p>\
					    <div class="competitions bfcom" i=2>\
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
					    </div>\
					    <p class="gray">总进球</p>\
					    <div class="competitions bfcom htzjq" i=3>\
					            	<span my-data=0><strong>0球</strong><em>'+jq_sp[0]+'</em></span>\
					            	<span my-data=1><strong>1球</strong><em>'+jq_sp[1]+'</em></span>\
					            	<span my-data=2><strong>2球</strong><em>'+jq_sp[2]+'</em></span>\
					            	<span my-data=3><strong>3球</strong><em>'+jq_sp[3]+'</em></span>\
					            	<span my-data=4><strong>4球</strong><em>'+jq_sp[4]+'</em></span>\
					            	<span my-data=5><strong>5球</strong><em>'+jq_sp[5]+'</em></span>\
					            	<span my-data=6><strong>6球</strong><em>'+jq_sp[6]+'</em></span>\
					            	<span my-data=7><strong>7+球</strong><em>'+jq_sp[7]+'</em></span>\
					                <div class="clear"></div>\
					    </div>\
					    <p class="gray">半全场</p>\
					    <div class="competitions bfcom htcom" i=4>\
					            	<span my-data=3-3><strong>胜胜</strong><em>'+bqc_sp[0]+'</em></span>\
					            	<span my-data=3-1><strong>胜平</strong><em>'+bqc_sp[1]+'</em></span>\
					            	<span my-data=3-0><strong>胜负</strong><em>'+bqc_sp[2]+'</em></span>\
					            	<span my-data=1-3><strong>平胜</strong><em>'+bqc_sp[3]+'</em></span>\
					            	<span my-data=1-1><strong>平平</strong><em>'+bqc_sp[4]+'</em></span>\
					            	<span my-data=1-0><strong>主负</strong><em>'+bqc_sp[5]+'</em></span>\
					            	<span my-data=0-3><strong>负胜</strong><em>'+bqc_sp[6]+'</em></span>\
					            	<span my-data=0-1><strong>负平</strong><em>'+bqc_sp[7]+'</em></span>\
					            	<span my-data=0-0><strong>负负</strong><em>'+bqc_sp[8]+'</em></span>\
					                <div class="clear"></div>\
					    </div></article>\
						<div class="zfTrue zfTrue2 clearfix"><a href="javascript:;" class="zfqx" id=tc_cancel>取 消</a><a id=tc_ok href="javascript:;">确 定</a></div>';
					}else if (lotteryPlayName == 'hh' && lotteryType=="jclq") {
						var sf_sp = obj['sf_sp'].split(',');
						var rf_sp = obj['rf_sp'].split(',');
						var dxf_sp = obj['dxf_sp'].split(',');
						var sfc_sp = obj['sfc_sp'].split(',');
						html='<div class="bfTitle clearfix"><p>'+obj.gn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+obj.hn+'</p></div>\
							<article class="bfScroll hhscroll" style="height:0px" id=tc_c>\
					    <p class="gray">非让分/让分</p>\
					     <div class="competitions hhcom" i=3>';
						/*console.log(obj.isale)*/
						if((5 & obj.isale)>0){
							html+='<span my-data=0>客胜<em>'+sf_sp[0]+'</em></span></span><span my-data=3>主胜<em>'+sf_sp[1]+'</em></span>';
						}else{
							html+='<span>停售</span><span>停售</span>';
						}
		            	html+='</div>\
		            	<div class="competitions hhcom" i=0 style="border-top:none;">';
		            	if((1 & obj.isale)>0){
		            		html+='<span my-data=0>客胜<em>'+rf_sp[0]+'</em></span><span my-data=3>主胜<cite class="'+(obj.close.indexOf('-')>=0?'green2':'red')+'">('+obj.close+')</cite><em>'+rf_sp[1]+'</em></span>';
						}else{
							html+='<span>停售</span><span>停售</span>';
						}
		            	html+='<div class="clear"></div>\
					    </div>\
		            	<p class="gray">总分</p>\
						    <div class="competitions bfcom htzjq" i=1>\
				            	<span my-data=3><strong>总分&gt;'+obj.zclose+'</strong><em>'+dxf_sp[0]+'</em></span>\
				            	<span my-data=0><strong>总分&lt;'+obj.zclose+'</strong><em>'+dxf_sp[1]+'</em></span>\
				                <div class="clear"></div>\
						    </div>\
					  	<p class="red">'+obj.gn+' 胜</p>\
					    <div class="competitions bfcom" i=2>\
					            	<span my-data=11><strong>1-5</strong><em>'+sfc_sp[0]+'</em></span>\
					            	<span my-data=12><strong>6-10</strong><em>'+sfc_sp[1]+'</em></span>\
					            	<span my-data=13><strong>11-15</strong><em>'+sfc_sp[2]+'</em></span>\
					            	<span my-data=14><strong>16-20</strong><em>'+sfc_sp[3]+'</em></span>\
					            	<span my-data=15><strong>21-25</strong><em>'+sfc_sp[4]+'</em></span>\
					            	<span my-data=16><strong>26+</strong><em>'+sfc_sp[5]+'</em></span>\
					                <div class="clear"></div>\
					    </div>\
					    <p class="red">'+obj.hn+' 胜</p>\
				        <div class="competitions bfcom" i=2>\
					            	<span my-data=01><strong>1-5</strong><em>'+sfc_sp[6]+'</em></span>\
					            	<span my-data=02><strong>6-10</strong><em>'+sfc_sp[7]+'</em></span>\
					            	<span my-data=03><strong>11-15</strong><em>'+sfc_sp[8]+'</em></span>\
					            	<span my-data=04><strong>16-20</strong><em>'+sfc_sp[9]+'</em></span>\
					            	<span my-data=05><strong>21-25</strong><em>'+sfc_sp[10]+'</em></span>\
					            	<span my-data=06><strong>26+</strong><em>'+sfc_sp[11]+'</em></span>\
					                <div class="clear"></div>\
					    </div>\
					    </article>\
						<div class="zfTrue zfTrue2 clearfix"><a href="javascript:;" class="zfqx" id=tc_cancel>取 消</a><a id=tc_ok href="javascript:;">确 定</a></div>';
					}
					$("#tc_content").html(html);
					if(lotteryPlayName =='hh' || lotteryPlayName=='bf'){
						var h_ = $(window).height()*.9-$('#tc').height()*2;
						$('#tc_c').css({height:h_+'px'});
						$('#tc').css({top:'5%'});
					} else if (lotteryPlayName=='bqc') {
						var h_ = ($(window).height()-$('#tc').height())/2;
						$('#tc').css({top:h_+'px'});
					}
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
							if(lotteryType=="jczq"){//竞彩足球
								for(var i in d){		
									var div = par.find('div[i="'+i+'"]'); 						
									for(var j in d[i]){							
										div.find('span[my-data="'+d[i][j]+'"]').addClass('cur');	
									}
								}
							}else{//竞彩篮球
								
								for(var i in d){		
									var div = par.find('div[i="'+i+'"]');
									for(var j in d[i]){	
										div.find('span[my-data="'+d[i][j]+'"]').addClass('cur');	
									}
								}
							}
								
						}
					}
					//弹出层选择项点击事件
					$("#tc_content").off().Touch({children:"span[my-data]", fun:function(el) {
						console.log(12)
							if(!obj._selectData){
								if(!obj.selectData){
									obj._selectData = [];	
								}else{
									obj._selectData = CP.Util.CloneObj([],obj.selectData);
								}
							}
							if(lotteryPlayName != 'hh'){
								if ($(el).is(".cur")) {//是否选中状态
									$(el).removeClass("cur");
									obj._selectData.splice($.inArray($(el).attr('my-data'),obj._selectData),1);								
								} else {
									$(el).addClass("cur");
									obj._selectData.push($(el).attr('my-data')); 
								} 
							}else{
								var index = $(el).parent().attr('i');//0
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
						}
					})
					//弹出层确定按钮
					/*
					 * 如果使用touchend或者mouseup
					 * 在本地环境和测试环境 ，当弹层显示时，弹层的取消按钮会与  竞足半全场、比分或竞篮胜分差的 立即投注按钮重合 导致弹层无法关闭
					 * 当将点击事件改为click后，以上的问题不在出现。
					 * 在正式环境线上，不存在以上问题
					 */
					$("#tc_ok").off().bind('click',function(){
						var el = $item.find('ul[data-id="'+itemid+'"]').find(".wei-ball");
						var obj = againstData[index1].info[index2];
						$("#tc,#jczq_mask").hide();
						$("#tc_content").html('');	
						obj.selectData = ((obj._selectData&&obj._selectData.slice(0))||obj.selectData||[]);
						delete obj._selectData;
						
						if((lotteryPlayName!='hh'&&obj.selectData.length>0)||
								(lotteryPlayName=='hh'&&obj.selectData.join().replace(/,/g,'').split(',')[0]!='')){
								el.addClass('cur').html(Against.getSelectText(obj.selectData));
						}else{
							el.removeClass('cur').html({'hh':'更多玩法'}[lotteryPlayName]|| '立即投注');
						}
						if(lotteryPlayName=='hh' && lotteryType=="jczq"){
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
						}else if(lotteryPlayName=='hh' && lotteryType=="jclq"){
							var dom_ = $item.find('ul[data-id="'+itemid+'"]').find(".spfzpk span");
							var Q = {'0':0,'3':1};
							$item.find('ul[data-id="'+itemid+'"]').find(".wang-ball").removeClass('cur');//清除外面的高亮 下面重新计算点亮
							//让分	
								var tt = obj.selectData[0];//让分时数据
								
								for (var t in tt) {
									dom_.eq(Q[tt[t]]).addClass('cur');
								}
								var Q1 = {'3':0,'0':1};
							//大小分选的时候
								var tt = obj.selectData[1];//大小分时数据
								for (var t1 in tt) {
									dom_.eq(Q1[tt[t1]]+2).addClass('cur');
								}
						}
						Against.showTotal();
					})
					
					//弹出层取消按钮
					/*
					 * 如果使用touchend或者mouseup
					 * 在本地环境和测试环境 ，当弹层显示时，弹层的取消按钮会与  竞足半全场、比分或竞篮胜分差的 立即投注按钮重合 导致弹层无法关闭
					 * 当将点击事件改为click后，以上的问题不在出现。
					 * 在正式环境线上，不存在以上问题
					 */
					$("#tc_cancel").off().bind('click',function(event){
						/*var ev = event || window.event;
						ev.stopPropagation();*/
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
                    			if(lotteryPlayName == 'hh'){
                    				var Q2 = _selectData.join(',').split(',');
                    				var Q3 = 0;
                    				for (var n=0, m = Q2.length; n<m; n++) {
                    					if(Q2[n]){Q3++;}
                    				}
                    				!!Q3 && g.spArr.push(Q3);
                    				
                    			}else{
                    				g.spArr.push(_selectData.length);
                    			}
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
            	g.bet = '5';//倍数恢复1倍
            	g.count = 0;//恢复0注
            	g.amount = 0;//总金额
            	Against.showTotal();
            },
          //混投 如果有选比分、进球数、半全场的最大串关
            guoguan : function (xo) {
            	var Q = xo;
            	for (var s in againstData) {//比分 半全场4
    				var ss = againstData[s].info;
    				for (var n = 0, l = ss.length; n<l; n++) {
    					if(ss[n].selectData){
    						if(!!ss[n].selectData[2]){
    							if(ss[n].selectData[2].length){
    								Q = contrast.jczq.bf.maxPass;
            						return Q;
    							}
        					}
    						if(!!ss[n].selectData[4]){
        						if(ss[n].selectData[4].length){
        							Q = contrast.jczq.bqc.maxPass;
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
    								Q = (Q < contrast.jczq.jq.maxPass && Q) || contrast.jczq.jq.maxPass;
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
                				if (lotteryPlayName == 'hh') {
                					if (_selectData.join().replace(/,/g,'').split(',')[0]!='') {
                						if (lotteryType == 'jclq') {
                        					var sprf = [], spdxf = [], spsfc = [], spspf = [] ,Q2 = {};
                        					
                        					if(_selectData[0]){//让分
                        						var Q4 = $.map(_selectData[0], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].rf.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].rf_sp.split(',');
                    							sprf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[1]){//大小分
                        						var Q4 = $.map(_selectData[1], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].dxf.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].dxf_sp.split(',');
                    							spdxf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[2]){//猜比分
                        						var Q4 = $.map(_selectData[2], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].sfc.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].sfc_sp.split(',');
                    							spsfc = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[3]){//胜平负
                        						var Q4 = $.map(_selectData[3], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].sf.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].sf_sp.split(',');
                    							spspf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					
                        					/*sprf_max = sprf.length && Count.division(sprf, true) || 0;
                        					sprf_min = sprf.length && Count.division(sprf) || 0;
                        					spdxf_max = spdxf.length && Count.division(spdxf, true) || 0;
                        					spdxf_min = spdxf.length && Count.division(spdxf) || 0;
                        			        Q2.max = parseFloat(sprf_max)+parseFloat(spdxf_max);
                        			        sprf_min  =  sprf_min || spdxf_min;
                        			        spdxf_min = spdxf_min || sprf_min;
                        					Q2.min = (sprf_min>spdxf_min && spdxf_min || sprf_min);
                        					data.push(Q2);*/
                        					sprf_max = sprf.length && Count.division(sprf, true) || 0;
                        					sprf_min = sprf.length && Count.division(sprf) || 0;
                        					spdxf_max = spdxf.length && Count.division(spdxf, true) || 0;
                        					spdxf_min = spdxf.length && Count.division(spdxf) || 0;
                        					spsfc_max = spsfc.length && Count.division(spsfc, true) || 0;
                        					spsfc_min = spsfc.length && Count.division(spsfc) || 0;
                        					spspf_max = spspf.length && Count.division(spspf, true) || 0;
                        					spspf_min = spspf.length && Count.division(spspf) || 0;
                        			        Q2.max = parseFloat(sprf_max)+parseFloat(spdxf_max)+parseFloat(spsfc_max)+parseFloat(spspf_max);
                        			        var Q8  = [(sprf_min||9999), (spdxf_min||9999), (spsfc_min||9999), (spspf_min||9999)];
                        			        Q2.min = Count.division(Q8);
                        					data.push(Q2);
                        					
                						} else {
                							var spspf = [], sprq = [], spbf = [], spjq = [], spbqc = [], Q2 = {};
                        					if(_selectData[0]){//胜平负
                        						var Q4 = $.map(_selectData[0], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].spf.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].spf_sp.split(',');
                    							spspf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[1]){//让球胜平负
                        						var Q4 = $.map(_selectData[1], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].rq.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].rq_sp.split(',');
                    							sprq = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[2]){//比分
                        						var Q4 = $.map(_selectData[2], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].bf.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].bf_sp.split(',');
                    							spbf = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[3]){//进球
                        						var Q4 = $.map(_selectData[3], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].jq.location;
                    								return Q5[item];
                    							});
                    							var Q7 = Q[Q1].jq_sp.split(',');
                    							spjq = $.map(Q4, function (item) {
                    								return Q7[item];
                    							});
                        					}
                        					if(_selectData[4]){//半全场
                        						var Q4 = $.map(_selectData[4], function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
                    								var Q5 = contrast[lotteryType].bqc.location;
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
                				} else {
                					var sp = [], Q2 = {};
            						var Q4 = $.map(_selectData, function (item) {//得到的Q4是当前排 选中的选项sp的对应位置
        								var Q5 = contrast[lotteryType][lotteryPlayName].location;
        								return Q5[item];
        							});
        							var Q7 = Q[Q1][lotteryPlayName+'_sp'].split(',');
        							sp = $.map(Q4, function (item) {
        								return Q7[item];
        							});
                					Q2.max = Count.division(sp, true);
                					Q2.min = Count.division(sp);
                					data.push(Q2);
                				}
                    		}
                    	}
                    }
                }
				var prix = Count.prix(data, g.pass);
				var Q = (lotteryType == 'bjdc' && 0.65 || 1);
				g.amountMin = (prix.min*g.bet*Q).toFixed(2);
				g.amountMax = (prix.max*g.bet*Q).toFixed(2);
				g.bonus = (g.amountMin == g.amountMax)?g.amountMax:(g.amountMin+'~'+g.amountMax);
            	$('#bonus').html(g.bonus);
            },
            //点击下一步按钮
            next : function () {
            	var Q = parseInt($('#lot_cur_match').html());
            	var dg = false;
            	if(Q>=1){
            		$('#item ul.sfcxs .cur').each(function(){
                		if($(this).attr('dg') == 'dg'){
                			dg = true;
            			}else{
            				dg = false;
            				return false;
        				}
                	});
            	}
            	if(dg){//全部都是单关进来的
            		$('#ggList').find('li').each(function () {
            			($(this).index()<Q) && $(this).show() || $(this).hide();
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
            	}else if(Q< contrast[lotteryType].minLength){
            		alert('至少选择'+contrast[lotteryType].minLength+'场');
            	}else{
            		var Q1 = '';
            		if(lotteryPlayName == 'hh' && Q>4){
            			Q1 = Against.guoguan(Q);
            		}else{
            			Q1 = contrast[lotteryType][lotteryPlayName].maxPass;
            		}
            		Q1 = (Q1>Q && Q) || Q1; //显示多少个串关方式
            		$('#ggList').find('li').each(function () {
            			($(this).index()<Q1) && $(this).show() || $(this).hide();
            			$(this).removeClass('cur');
            		});
            		if(lotteryType == 'bjdc'){
            			g.bet=(lotteryType=="jczq"||lotteryType=="jclq")?"5":"1"
            			g.pass = [Q1];
            			
            			$('#jc_chuan').html(Q1==1 ? '单关' : Q1+'串1');
            			$('#ggList').find('li').eq(Q1-1).addClass('cur');
            		} else {
            			g.pass = [2];
            			$('#ggList').find('li').eq(0).hide();//竞彩木有单关
            			$('#jc_chuan').html('2串1');
            			$('#ggList').find('li').eq(1).addClass('cur');//默认2串1
            		}
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
            	}});
            	$item.Touch({children:'.wang-ball',fun:function(){//投注选项
            		if(g.curChangCi >= contrast[lotteryType].maxLength){
						if(!$(this).parent().parent().find('.cur').length){
							alert(lotteryInfo[lotteryPlayName]+'最多选'+contrast[lotteryType].maxLength+'场');return;	
						}
					}
    				$(this).toggleClass('cur');
    				var _el = $(this).parent().parent().parent();//指向当前的ul标签
                    var arr = [];
                    if (lotteryPlayName != 'hh') {
                    	arr = [].slice.call(_el.find('.cur')).map(function(el){
                        	var xo = $(el).attr('my-data') || '';
    						return xo;
    					});
                	} else {//竞彩足球或篮球混投的时候
            			Q1 = [].slice.call(_el.find('.spfzpk:eq(0) .cur')).map(function(el_){
                        	var xo = $(el_).attr('my-data') || '';
    						return xo;
    					});
            			Q2 = [].slice.call(_el.find('.spfzpk:eq(1) .cur')).map(function(el_){
                        	var xo = $(el_).attr('my-data') || '';
    						return xo;
    					});
            			!!Q1.length && (arr[0] = Q1);//如果是竞彩篮球表示让分
            			!!Q2.length && (arr[1] = Q2);//如果是竞彩篮球表示大小分
                	}
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
								}else {
									obj.selectData = arr;//把投注的号码记录在 selectData里面
								}
							}
						}
					}
					
					
					if (lotteryPlayName == 'hh') {
						
						if(obj.selectData.join().replace(/,/g,'').split(',')[0]!=''){
							_el.find('.wei-ball').html(Against.getSelectText(obj.selectData)).addClass('cur');
						}else{
							_el.find('.wei-ball').html('更多选项').removeClass('cur');
						}
					}
    				Against.showTotal();
            	}});
            	//$item.Touch({children:'.wei-ball',fun:function(){//展开弹层
            	$(".wei-ball").bind("click",function(){
            		el = $(this);
    				Against.container(el);
            	});
            	$item.Touch({children:'.bfzb',fun:function(){//展开弹层
            		var url = {};
            		if(lotteryType == 'jczq'){
            			url = {
                				itemid : $(this).attr('itemid'),
                				type : $(this).attr('type'),
                				qc : $(this).attr('qc')
                		};
            			url = '/jcbf/dzxq.html?'+jQuery.param(url);
            		}else{
            			url = {
                				itemid : $(this).attr('qc')+'_'+$(this).attr('itemid'),
                				type : $(this).attr('type'),
                				qc : $(this).attr('itemid')
                		};
            			url = '/bdbf/dzxq.html?'+jQuery.param(url);
            		}
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
            	var href_ = '';
            	if(lotteryType == 'jczq'){
            		href_ = '#type=url&p=kj/zq.html';
            	}else if(lotteryType == 'jclq'){
            		href_ = '#type=url&p=kj/lq.html';
            	}else{
            		href_ = '#type=url&p=kj/bjdc.html';
            	}
            	TopAnch.init({
    				title:lotteryInfo[lotteryType]+'·'+lotteryInfo[lotteryPlayName],
    				prevShow:true,
    				prevFun:function(){//左侧按钮绑定事件
    					window.location.href = '#type=index';
    				},
    				isScore: {'jclq':false,'jczq':'/jcbf/','bjdc':'/bdbf/'}[lotteryType],
    				menu:[{'name':'选择比赛','url':'javascript:;','cur':true},
    				      //{'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot(contrast[lotteryType][lotteryPlayName].gid, 2),'cur':false},
    				      {'name':'开奖结果','url':href_,'cur':false},
    				      {'name':'玩法帮助','url':'#type=url&p=wf/'+lotteryType+'.html','cur':false}],
    				headerSelect: (lotteryType == 'jczq' ? [{name:'胜平负',fun:o.changePlayType,cur:2},{name:'让球胜平负'},{name:'混投'},{name:'比分'},{name:'总进球'},{name:'半全场'}] :
    					(lotteryType == 'jclq' ? [{name:'胜负',fun:o.changePlayType,cur:3},{name:'让分'},{name:'大小分'},{name:'混投'},{name:'胜分差'}] :
    						[{name:'胜平负',fun:o.changePlayType},{name:'比分'},{name:'总进球'},{name:'半全场'},{name:'上下单双'}])),
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
        	$('#fcHeader').removeClass('h1Down');
			$item.html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em><div style="text-align: center; padding: 10px;">加载对阵中，请稍候</div></div>');
			switch(lotteryType){
				case 'jczq':lotteryPlayName={'0':'spf','1':'rq','2':'hh','3':'bf','4':'jq','5':'bqc'}[index];break;
				case 'jclq':lotteryPlayName={'0':'sf','1':'rf','2':'dxf','3':'hh','4':'sfc',}[index];break;
				case 'bjdc':lotteryPlayName={'0':'spf','1':'bf','2':'jq','3':'bqc','4':'sxds'}[index];break;
			}
			var title = lotteryInfo[lotteryType]+'·'+lotteryInfo[lotteryPlayName];
			$("#lot_title").html(title);
			document.title=title;
			Against.clear();//清空selectData
			Against.render();
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
					bonus:   g.bonus,//奖金范围
					imoneyrange: g.amountMax,//最大奖金
					iminrange: g.amountMin//最小奖金
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
			if(lotteryType=="bjdc"){
				if(g.bet<1){
					info = '抱歉投注倍数必须大于1';
				}else if(g.amount<1){//投注列表没有内容
					info = '请至少选择一注彩票';
				}
			}else{
				if(g.bet<5){
					info = '抱歉，暂时无法投注倍数小于5的方案';
				}else if(g.amount<1){//投注列表没有内容
					info = '请至少选择一注彩票';
				}
			}
			if(info!=''){alert(info);return;}
			g.codes = o.code();//点击自购或发起合买的时候 拼一下投注code值 o.getArgument里面要用到
			if(t){window.location.href = "#type=fun&fun=CP.JC.doHm";}else{o.dopay();}
		},
		/*购买验证]]*/
		
		//codes=SFC|161220301_02/03/06,161220302_01/06|2*1
		
		//SFC|161123313=14/12,161123311=02|2*1
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
            				if (lotteryPlayName == 'hh') {
            					if (_selectData.join().replace(/,/g,'').split(',')[0]!='') {
            						if (lotteryType == 'jczq') {//竞彩足球混投
            							var Q2 = [];
                        				for (var n=0, m = _selectData.length; n<m; n++) {
                        					if(_selectData[n] && _selectData[n].length > 0){
                        						var Q3 = {'0':'SPF','1':'RQSPF','2':'CBF','3':'JQS','4':'BQC'};
                        						Q2.push(Q3[n]+'='+_selectData[n].join('/'));
                        					}
                        				}
                						code.push(Q[Q1].itemid+'>'+Q2.join('+'));
                					} else {//竞彩篮球混投
                						var Q2 = [];
                        				for (var n=0, m = _selectData.length; n<m; n++) {
                        					
                        					if(_selectData[n] && _selectData[n].length > 0){
                        						var Q3 = {'0':'RFSF','1':'DXF','2':'SFC','3':'SF'};
//                        						Q2.push((n==0?'RFSF':'DXF')+'='+_selectData[n].join('/'));
                        						Q2.push(Q3[n]+'='+_selectData[n].join('/'));
                        					}
                        				}
                						code.push(Q[Q1].itemid+'>'+Q2.join('+'));
                						console.log(code);
                					}
            					}
            				} else {
            					/***
            					if(lotteryPlayName=="sfc"){//竞彩篮球胜分差
            						code.push(Q[Q1].itemid+'_'+_selectData.join('/'));
            					}else{
            						code.push(Q[Q1].itemid+'='+_selectData.join('/'));
            					}
            					***/
            					code.push(Q[Q1].itemid+'='+_selectData.join('/'));
            				}
                		}
                	}
                }
            }
			var Q5 = g.pass;
        	Q5 = $.map(Q5, function (item) {return item+'*1';});
			code = codeHeader[lotteryPlayName]+'|'+code.join(',')+'|'+Q5.join(',');
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
				val : (lotteryType=="jczq"||lotteryType=="jclq")?"5":"1",
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
    var grade = function(){
    	var grade = parseInt(localStorage.getItem("grade"))
		if(grade>0){
			$("#dobuy").html("立即预约")
		}
    }
    var init = function() {
    	grade()
    	o.init();
    	o.jc_bind();
    };	
    return {init : init,
    		grade:grade,
    		doHm : o.doHm,
    		changePlayType : o.changePlayType,
    		pageGo: o.pageGo
		};
})();
function resetPage(){//登录或合买的回调函数
	CP.JC.grade();	
	$('#content_home').show();//登录完之后显示投注层
	$('#box_header').addClass('zcHeader');
	CP.JC.pageGo.goBack();
	/*隐藏合买 显示投注界面 [[*/
	$(".jczqNav, #item, #jc_footer, #jczq_mask").show();
	$('#bethm, #jc_hm_footer').hide();
}
$(function(){
	CP.JC.init();	
});