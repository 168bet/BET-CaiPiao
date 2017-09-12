/*
 *Author:weige Q: 1617634
 *Date: 2014-7-24
 */

var jczq_kj = {
		initail: function(){
			jczq_kj.content();
			jQuery('.date').attr('class','date');
			jQuery('#txtBirthday').parent().attr('class','');
			jQuery('html').attr('class','');
			jQuery('body').attr('class','');
			jQuery('#delete_parent').parent().attr('class','');
			jczq_kj.bind();
		},
		bind: function(){
			//右上角菜单显示或隐藏
			$("#pullIco").click(function(){
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
			$('#txtBirthday').change(function(){
				$('.loading').show();
				$('#content div.sfcTitle').hide();
				$('#content section').html('');
				jczq_kj.content($(this).val());
			});
		},
		content:function(d){
			var data;
			if(d){
				var dd = d.split('/');
				dd = dd[2].substr(-2)+''+dd[0]+''+dd[1];
				data = {
						gid : '70',
						did : dd
				};
			}else{
				data = {
						gid : '70'
				};
			}
			$.ajax({
				url:'/trade/list.go',
				data: data,
				type:'POST',
				DataType:'xml',
				success:function(xml){
					$('.loading').hide();
					var R = $(xml).find('rows');
					var did = R.attr('did');//开奖结果的时间
					var r = R.find('row');
					
					var html = '';
					if(r.length ==0){
						D.tx('亲，木有赛事哦！');
						html = '';
					}
					$('#content div.sfcTitle').html(did+'&nbsp;&nbsp;'+r.length+'场比赛');
					$('#content div.sfcTitle').show();
					r.each(function(){
						var pid = $(this).attr('pid');//期次编号
						var mid = $(this).attr('mid');//比赛场次
						var mn = $(this).attr('mn');//主队名称
						var sn = $(this).attr('sn');//客队名称
						var ms = $_Y.getInt($(this).attr('ms'));//主队进球数
						var ss = $_Y.getInt($(this).attr('ss'));//客队进球数
						var zclose = $(this).attr('zclose');// (北单 竞彩足球没有该字段)
						var mname = $(this).attr('mname');//联赛名称
						var mt = $(this).attr('mt');//比赛结束时间
						var hms = $_Y.getInt($(this).attr('hms'));//半场主队进球数 (北单 竞彩足球没有该字段)
						var hss = $_Y.getInt($(this).attr('hss'));//半场客队进球数 (北单 竞彩足球没有该字段)
						var lose = $_Y.getInt($(this).attr('lose'));//让球数 (北单没有该字段)
						var cid = $(this).attr('cid');//场次名称  (北单没有该字段)
						var end_time = mt.substr(5,11);//截止时间
						
						var sum = ms+ss;
						var z,rz,tag,c;
						if(parseInt(ms)>parseInt(ss)){//主>客
							z = '<span class="red">主胜</span>';
						}else if(parseInt(ms)==parseInt(ss)){
							z = '<span class="blue">平</span>';
						}else{
							z = '<span class="green">主负</span>';
						}
						if((parseInt(ms)+parseInt(lose))>parseInt(ss)){
							rz = '<span class="red jclqsf">让主胜</span>';
						}else if((parseInt(ms)+parseInt(lose))==parseInt(ss)){
							rz = '<span class="blue jclqsf">让平</span>';
						}else{
							rz = '<span class="green jclqsf">让主负</span>';
						}
						var str = jczq_kj.createModel(hms, hss, ms, ss);
						
						html+='<ul class="sfcxs">';
						html+='<li><em>'+cid.substr(-3)+'</em><p>'+mname.substr(0,4)+'</p><cite>'+end_time+'</cite></li>';
						html+='<li>';
						html+='<p class="spfzpkNum"><span>(主)'+mn+'</span><span class="spfvs">'+ms+':'+ss+'</span><span>'+sn+'(客)</span></p>';
						html+='<div>';
						html+='<p><span>胜平负</span><span>让球('+lose+')</span><span>总进球</span><span>半全场</span></p>';
						html+='<p>'+z+''+rz+'<span>'+sum+'</span><span>'+str+'</span></p>';
						html+='</div>';
						html+='</li>';
						html+='</ul>';
					});
					$('#content section').html(html);
				}
			});
		},
		createModel:function(hb,mb,hq,mq){
			var str = "";
			if(hb>mb && hq>mq){
				str+='<em class="red">胜</em>';
				str+='<em class="red">胜</em>';
			}else if(hb>mb && hq==mq){
				str+='<em class="red">胜</em>';
				str+='<em class="blue">平</em>';
			}else if(hb>mb && hq<mq){
				str+='<em class="red">胜</em>';
				str+='<em class="green">负</em>';
			}else if(hb<mb && hq<mq){
				str+='<em class="green">负</em>';
				str+='<em class="green">负</em>';
			}else if(hb<mb && hq==mq){
				str+='<em class="green">负</em>';
				str+='<em class="blue">平</em>';
			}else if(hb<mb && hq>mq){
				str+='<em class="green">负</em>';
				str+='<em class="red">胜</em>';
			}else if(hb==mb && hq>mq){
				str+='<em class="blue">平</em>';
				str+='<em class="red">胜</em>';
			}else if(hb==mb && hq<mq){
				str+='<em class="blue">平</em>';
				str+='<em class="green">负</em>';
			}else if(hb==mb && hq==mq){
				str+='<em class="blue">平</em>';
				str+='<em class="blue">平</em>';
			}
			return str;
		}
};
$(function(){
	jczq_kj.initail();
});