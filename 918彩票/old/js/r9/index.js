/*
 * Author:weige
 * Date: 2014-7-28
 */
var curTime_ = new Date().getTime();
var nn = '0';
var r9 = {};
var gid = $('#lotid').val();
var gid_n = {'80':'sfc','81':'r9'}[gid];
var R9 = {
		initial: function(){
			localStorage.removeItem('zc'+gid);
			if(gid == '81'){
				var zc = localStorage.getItem('zc_r9_PollNum');
				if(zc){
					var n = zc.split('|')[0];
					var m = zc.split('|')[1];
					R9.add_C(n,m);
				}else{
					R9.add_C();
				}
			}else{
				R9.add_C();//初始化添加对阵内容
			}
			R9.bind();//初始化的一些绑定事件
			if (window.DeviceMotionEvent) {
			    window.addEventListener('devicemotion',deviceMotionHandler, false);
			}
		},
		add_C: function(c,code){
			var url = '';
			if(c){
				url = '/trade/queryZucai.go?pid='+c;
			}else{
				url = '/trade/queryZucai.go';
			}
			$('.loading').hide();
			D.load();
			$.ajax({
				url:url,
				type:'POST',
				DataType:'XML',
				success: function(xml){
					D.load(close);
					var severtime=new Date(arguments[2].getResponseHeader("Date"));//服务器时间
					severtime = severtime.getFullYear()+'-'+zeroStr(severtime.getMonth()+1,2)+'-'+zeroStr(severtime.getDate(),2);
					var R = $(xml).find('rows');
						var pid = R.attr('pid');//期次
						$('#expect').val(pid);//当前场次期号
					
						var et = R.attr('et');//复试截止时间
						var fet = R.attr('fet');//单式截止时间
						var sale = R.attr('sale');//是否在售
					var rp = R.find('rowp');
						var pids = rp.attr('pids'),dq,ys;//期次 
						dq = pids.split(',')[0],ys = pids.split(',')[1];
						if(!c || code){
							if(code){
								jQuery('.buyTab').html('<li v="'+dq+'" '+(dq==c?'class="cur"':"")+'>当前期'+dq+'</li><li v="'+ys+'" '+(ys==c?'class="cur"':"")+'>预售期'+ys+'</li>')
							}else{
								jQuery('.buyTab').html('<li v="'+dq+'" class="cur">当前期'+dq+'</li><li v="'+ys+'">预售期'+ys+'</li>')
							}
						}
					var et1 = et.substr(11,5);
					var et2 = et.substr(0,10);
					var et3 = et.substr(5,6);
					var datediff = DateDiff(severtime,et2);
					datediff = {'0':'今天','1':'明天','2':'后天'}[datediff]||et3;
					var msg = {'81':'猜中任意9场即中奖','80':'猜中14场一等奖,13场二等奖'}[gid];
					var html = '<div class="sfcTitle clearfix" v="'+sale+'"><span class="left"><em class="red">'+datediff+''+et1+'</em> 截止</span><span class="right" id="msg">'+msg+'</span></div>';
					var r = R.find('row');
					r.each(function(){
						var xid = $(this).attr('xid');	  //编号
						var hn = $(this).attr('hn');      //主队
						var gn = $(this).attr('gn');      //客队
						var mname = $(this).attr('mname');//联赛名称
						var cl = $(this).attr('cl');      //联赛颜色
						var mtime = $(this).attr('mtime');//比赛时间
						var hm = $(this).attr('hm');      //主队联赛排名
						var gm = $(this).attr('gm');      //客队联赛排名
						var htn = $(this).attr('htn');    //主队战绩
						var gtn = $(this).attr('gtn');    //客队战绩
						var oh = $(this).attr('oh');      //平均欧指 主
						var od = $(this).attr('od');      //平均欧指 平
						var oa = $(this).attr('oa');      //平均欧指 客
						var htid = $(this).attr('htid');  //主队编号
						var gtid = $(this).attr('gtid');  //客队编号
						mtime = mtime.substr(5,11);
						
						var oh_,od_,oa_,f;
						if(oh != '' && od != '' && oa != ''){
							f = 1/(1/oh+1/od+1/oa);
							oh_ = Math.round((f/oh)*100);
							od_ = Math.round((f/od)*100);
							oa_ = (100-oh_-od_)+'%';
							oh_ = oh_+'%';
							od_ = od_+'%';
						}else{
							oh_ = '--';
							od_ = '--';
							oa_ = '--';
						}
						
						if(code){
							cc = code.split(',');
							var cc = cc[xid-1];
							if(cc != '#'){
								html += '<ul class="sfcxs" t='+xid+' v="y" c="'+cc.split('')+'">';
								html += '<li><em>'+xid+'</em><p style="color:'+cl+'">'+mname+'</p><cite>'+mtime+'</cite><i class="xzup xzdown"></i></li><li>';
								html += '<p class="spfzpk spfzpk2"><span v="3" '+(cc.indexOf(3)!=-1?'class="cur"':'')+'><em>'+hn+'</em><cite>胜</cite></span><span class="spfvs '+(cc.indexOf(1)!=-1?'cur':'')+'" v="1"><em>VS</em><cite>平</cite></span><span v="0" '+(cc.indexOf(0)!=-1?'class="cur"':'')+'><em>'+gn+'</em><cite>胜</cite></span></p>';
							}else{
								html += '<ul class="sfcxs" t='+xid+'>';
								html += '<li><em>'+xid+'</em><p style="color:'+cl+'">'+mname+'</p><cite>'+mtime+'</cite><i class="xzup xzdown"></i></li><li>';
								html += '<p class="spfzpk spfzpk2"><span v="3"><em>'+hn+'</em><cite>胜</cite></span><span class="spfvs" v="1"><em>VS</em><cite>平</cite></span><span v="0"><em>'+gn+'</em><cite>胜</cite></span></p>';
							}
						}else{
							html += '<ul class="sfcxs" t='+xid+'>';
							html += '<li><em>'+xid+'</em><p style="color:'+cl+'">'+mname+'</p><cite>'+mtime+'</cite><i class="xzup xzdown"></i></li><li>';
							html += '<p class="spfzpk spfzpk2"><span v="3"><em>'+hn+'</em><cite>胜</cite></span><span class="spfvs" v="1"><em>VS</em><cite>平</cite></span><span v="0"><em>'+gn+'</em><cite>胜</cite></span></p>';						
						}
						html += '<p class="spfpl"><span>概率'+oh_+'</span><span class="spfvs">概率'+od_+'</span><span>概率'+oa_+'</span></p>';
						
						html += '</li>';
						html += '</ul>';
						
						html += '<div class="sfcpl" style="display:none;">';
						html += '<dl><dt>平均赔率</dt><dd>'+(oh == ""?"-":oh)+'</dd><dd>'+(od == ""?"-":od)+'</dd><dd>'+(oa == ""?"-":oa)+'</dd></dl>';
						html += '<dl><dt>联赛排名</dt><dd>'+(hm == ""?"-":hm)+'</dd><dd>&nbsp;</dd><dd>'+(gm == ""?"-":gm)+'</dd></dl>';
						html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn == ""?"-":htn)+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn == ""?"-":gtn)+'</dd></dl>';
						html += '</div>';
					});
					jQuery('#content').html(html);
					
					R9.my_play();
					R9.bind_delay();//必须有对阵之后的绑定事件
					code && localStorage.removeItem('zc_r9_PollNum');
				}
			});
			
			
		},
		bind_delay: function(){
			if($('#content div.sfcTitle').attr('v') == '0'){
				 D.alert('当前对阵尚未确定,请稍后购买!');
			}
			jQuery('#content ul').find('li:eq(0)').Touch(function(){
				$(this).parent().next().slideToggle(200);
				$(this).find('i').toggleClass('xzdown');
			});
			$('.sfcpl').Touch(function(){//联赛历史战绩
				$(this).prev().find('li:eq(0) i').toggleClass('xzdown');
				$(this).slideToggle(200);
			});
			jQuery('#content ul.sfcxs p.spfzpk span').Touch(function(){
				$(this).toggleClass('cur');
				
				if($(this).parent().find('span').hasClass('cur')){//当前场次有选择时进来
					var c = '';
					$(this).parent().find('span.cur').each(function(){
						c += $(this).attr('v')+',';
						
					});
					c = c.substring(0, c.length-1);
					$(this).parent().parent().parent().attr('v','y');//ul
					$(this).parent().parent().parent().attr('c',c);
				}else{
					$(this).parent().parent().parent().removeAttr('v');//ul
					$(this).parent().parent().parent().removeAttr('c');//ul
				}
				R9.my_play();
			});
			$('.buyTab li').click(function(){
				if($(this).hasClass('cur') || !$('#content').html()){
					return;
				}
				$(this).addClass('cur').siblings().removeClass('cur');
				
				var v = $(this).attr('v');
				var lr9 = JSON.parse(localStorage.getItem('zc'+gid));
				var f = false;
				for(var p in lr9){
					if(p == v){
						f = true;
					}
				}
				if(f){
					$('#content').html(lr9[v]);
					R9.my_play();
					R9.bind_delay();
				}else{
					$('.loading').show();
					jQuery('#content').html('');
					R9.add_C(v);
				}
			});
		},
		bind: function(){
			//右上角菜单显示或隐藏
			$("#pullIco").Touch(function(){
					if($("#pullText").is(':hidden')){
						$("#tm_c").show();
					}else{
						$("#tm_c").hide();
					}
					$(this).parent().toggleClass("pullHover");
					$("#pullText").toggle();
			});
			$('#tm_c').click(function(){
				$(this).toggle();
				$('#pullIco').parent().toggleClass("pullHover");
				$("#pullText").toggle();
				
			});
			jQuery('#wanfa_').Touch(function(){
				$(this).toggleClass('hmTit');
				$(this).next().toggle();
			});
			jQuery('.deleted').Touch(function(){
				deleted();
			});
			jQuery('#isOk_').click(function(){
				if($('#content div.sfcTitle').attr('v') == '0'){
					 D.alert('当前对阵尚未确定,请稍后购买!');
				}else{
					var n = {'80':'14','81':'9'}[gid];
					if(parseInt($('#c_').html())>=n){
						var c = '';
						jQuery('#content').find('ul[v=y]').each(function(){
							var dz = $(this).find('li:eq(1) p:eq(0)').html();
							var pl = $(this).find('li:eq(1) p:eq(1)').html();
							var code = $(this).attr('c'),t = $(this).attr('t');
			                c += '<li c="'+code+'" v="y" t='+t+'>';
			                c += '<cite class="errorBg"><em class="error2"></em></cite>';
			                c += '<div class="spfzpk spfzpk2">'+dz+'</div>';
			                c += '<div class="spfpl">'+pl+'</div>';
			                c += '</li>';
						});
						localStorage.setItem('zc_'+gid_n+'_SelectNum',c);
						
						var pid = $('.buyTab').find('.cur').attr('v');
						window.location.href = '#class=url&xo='+$_sys.getlotdir(gid).substr(1)+'ture.html&pid='+pid;
					}else{
						D.tx('请选择至少'+n+'场比赛');
					}
				}
			});
		},
		my_play: function(){
			var c_ = $('#content').find('ul[v=y]').length;
			jQuery('#c_').html(c_);
			
			var e = $('.buyTab').find('.cur').attr('v');
			r9[e]=$('#content').html();
			localStorage.setItem('zc'+gid,JSON.stringify(r9));
		}
}
function deleted(){
	jQuery('#content ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
	
	R9.my_play();
}

function DateDiff(sDate1, sDate2) {  //sDate1和sDate2是yyyy-MM-dd格式
	 
    var aDate, oDate1, oDate2, iDays;
    aDate = sDate1.split("-");
    oDate1 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);  //转换为yyyy-MM-dd格式
    aDate = sDate2.split("-");
    oDate2 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);
    iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24); //把相差的毫秒数转换为天数
 
    return iDays;  //返回相差天数
}
R9.initial();