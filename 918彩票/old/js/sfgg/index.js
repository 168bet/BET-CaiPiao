var PollNum = localStorage.getItem('sfgg_PollNum');
var sfgg_pk=[["足球","球"],["篮球","分"],["冰球","球"],["网球","盘"],["羽毛球","局"],["排球","局"],["橄榄球","分"],["曲棍球","球"],["乒乓球","局"],["沙滩排球","局"],["手球","球"],["水球","球"]];
var Sfgg = {
		initial: function(){
			Sfgg.add_C();//初始化添加对阵内容
			Sfgg.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/bd/sfgg.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					D.load(close);
					var R = $(xml).find('Resp');
					var pid = R.attr('pid');
					$('#expect').val(pid);//北单当前场次期号
					var rs = R.find('rows');
					
						var html ='';
						
						var PollNum_t = [],PollNum_c = [];//t 编号  c 投注内容
						if(PollNum){
							var PollNum1 = PollNum.split('|')[0].split(',');
							for(var n = 0; n<PollNum1.length; n++){
								PollNum_t[n] = PollNum1[n].split('=')[0];
								PollNum_c[n] = PollNum1[n].split('=')[1];
							}
						}
					if(rs.length>0){
						rs.each(function(aa){
							var adddesc = $(this).attr('adddesc');
							var r = $(this).find('row');
							
						//	mt_ = desc.substring(0,14);
							html += '<section class="jclqVs"><div class="sfcTitle">'+adddesc+'&nbsp;'+r.length+'场比赛';

							if(aa == 0 || PollNum){//第一个 或者编辑过来的显示
								html += '<em class="up"></em></div><div>';
							}else{
								html += '<em class="up"></em></div><div>';
							}
							r.each(function(){
								var itemid = $(this).attr('itemid');
								var mid = $(this).attr('mid');
								var hn = $(this).attr('hn');//主队
								var gn = $(this).attr('gn');//客队
								var et = $(this).attr('et');//停售
								var mt = $(this).attr('mt');//比赛
								var mname = $(this).attr('mname');//联赛名
								mname=mname.substr(0,4);
								var ccup = $(this).attr('ccup');//联赛名
								var cl = $(this).attr('cl');//联赛颜色
								var close = $(this).attr('close');//让分
								if(!(close.substr(0,1)=="-"))							
								close='<i class="green">('+"+"+close+"&nbsp"+dist(sfgg_pk,ccup)+')</i>';
								else
								close='<i class="green">('+close+"&nbsp"+dist(sfgg_pk,ccup)+')</i>';	
								
								
								
								var name = $(this).attr('name');//周二301
								var sp3 = $(this).attr('sp3');//胜负赔率 1.65,1.75
								var sp0 = $(this).attr('sp0');//胜负赔率 1.65,1.75
								var isale = $(this).attr('isale');//开售状态
								var end_time = et.substr(11,5);//停售时间
								if(mname == 'WNBA'){
									hn = Count.n(hn);
									gn = Count.n(gn);
								}else{
									hn = hn.substr(0,5);
									gn = gn.substr(0,5);
								}
								
								if(PollNum && PollNum_t.indexOf(itemid)>=0){
									var pc = PollNum_c[PollNum_t.indexOf(itemid)];
									pc = pc.split('/');
									//html += '<ul class="sfcxs" t="'+itemid+'" p="'+rfsf+'" v="y" c="'+pc+'">';
									html += '<ul class="sfcxs" t="'+itemid+'" sp3="'+sp3+'" sp0="'+sp0+'" v="y" c="'+pc+'">';
								}else{
									//html += '<ul class="sfcxs" t="'+itemid+'" p="'+rfsf+'">';
									//html += '<ul class="sfcxs" t="'+itemid+'" p="'+rfsf+'">';
									html += '<ul class="sfcxs" t="'+itemid+'" sp3="'+sp3+'" sp0="'+sp0+'">';
								}
								
								//html += '<ul class="sfcxs" t="'+itemid+'" sp3="'+sp3+'" sp0="'+sp0+'">';
								html += '<li><em>'+itemid+'&nbsp;'+ccup.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite></li>';
								html += '<li><p class="spfzpk spfzpk2">';
								
								//html += '<span v="3" sp="'+sp3+'"><em>'+hn+'</em><cite><i>('+close+'分)</i>&nbsp;胜</cite></span><b>VS</b><span v="0" sp="'+sp0+'"><em>'+gn+'</em><cite>胜</cite></span>';
								if(PollNum && PollNum_t.indexOf(itemid)>=0){
									var pc = PollNum_c[PollNum_t.indexOf(itemid)];
									html += '<span v="3" sp="'+sp3+'" '+(pc.indexOf('3')>=0?'class="cur"':'')+'><em>'+hn+'</em><cite><i>'+close+'</i>&nbsp;胜</cite></span><b>VS</b><span v="0" sp="'+sp0+'" '+(pc.indexOf('0')>=0?'class="cur"':'')+'><em>'+gn+'</em><cite>胜</cite></span>';
								}else{
									//html += '<span v="0" sp="'+k_sf+'"><em>'+gn+'</em><cite>胜</cite></span><b>VS</b><span v="3" sp="'+z_sf+'"><em>'+hn+'<i>('+close+')</i></em><cite>胜</cite></span>';
									html += '<span v="3" sp="'+sp3+'"><em>'+hn+'</em><cite><i>'+close+'</i>&nbsp;胜</cite></span><b>VS</b><span v="0" sp="'+sp0+'"><em>'+gn+'</em><cite>胜</cite></span>';
								}
								html += '</p><p class="spfpl"><span>赔率'+sp3+'</span><span>赔率'+sp0+'</span></p>';
								html += '</li></ul>';
							});
							html +='</div></section>';
						});
						
						jQuery('#content_').html(html);
						
						Sfgg.my_play();
						Sfgg.bind_delay();//必须有对阵之后的绑定事件
					}else{
						D.tx('暂无比赛');
					}
				}
			});
			
			
		},
		bind_delay: function(){
			$('.sfcTitle').Touch(function(){//星期
				$(this).find('em').toggleClass('down');
				//$(this).next().slideToggle(300);
				$(this).next().toggle();
			});
			$('#content_').find('ul.sfcxs p.spfzpk span').Touch(function(){
				var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
				var  n_ = 20;
				if(c_ >= n_ && !$(this).parent().find('.cur').length){
					D.tx('最多选'+n_+'场'+"比赛");
					return;
				}
				
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
				Sfgg.my_play();
			});
		},
		
		//	SF|148=3,149=0,150=3|3*1
		// SF|148=3,149=3/0,150=3|3*1
		my_play: function(){//已选多少场比赛
			var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
			jQuery('#c_').html(c_);
		},
		bind_: function(){
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
				jQuery('#content_ ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
				
				localStorage.removeItem('jclq_sf_PollNum');
				Sfgg.my_play();
			});
			jQuery('#isOk_').click(function(e){
				if(parseInt($('#c_').html())>2){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var dz = $(this).find('li:eq(1) p:eq(0)').html();
						var sp = $(this).find('li:eq(1) p:eq(1)').html();
						var code = $(this).attr('c');
						var sp3 = $(this).attr('sp3');
						var sp0 = $(this).attr('sp0');
						
		                c += '<li t="'+$(this).attr('t')+'" c="'+code+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpk spfzpk2">'+dz+'</div>';
		                c += '<div class="spfpl">'+sp+'</div>';
		                c += '</li>';
					});
					
					localStorage.setItem('sfgg_SelectNum',c);
					localStorage.removeItem('sfgg_PollNum');
					window.location.href='#class=url&xo=sfgg/ture.html&pid='+$('#expect').val();
				}else{
					D.tx('请至少选择3场比赛');
				}
			});
			
		}
}
function dist(arr,str){
	var tmp="";
	for(var i=0;i<arr.length;i++){
		if(arr[i][0]==str){
			tmp=arr[i][1];
		}
	}
	return tmp;
}
Sfgg.initial();