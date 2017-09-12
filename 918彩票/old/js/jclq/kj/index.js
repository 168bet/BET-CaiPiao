/*
 *Author:weige
 *Date: 2014-7-24
 */
var Jclq_kj = {
		initail: function(){
			Jclq_kj.content();
			jQuery('.date').attr('class','date');
			jQuery('#txtBirthday').parent().attr('class','');
			jQuery('html').attr('class','');
			jQuery('body').attr('class','');
			jQuery('#delete_parent').parent().attr('class','');
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
				Jclq_kj.content($(this).val());
			});
		},
		content:function(d){
			var data;
			if(d){
				var dd = d.split('/');
				dd = dd[2].substr(-2)+''+dd[0]+''+dd[1];
				data = {
						gid : '71',
						did : dd
				};
			}else{
				data = {
						gid : '71'
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
					var did = R.attr('did');
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
						var ms = $(this).attr('ms');//主队进球数
						var ss = $(this).attr('ss');//客队进球数
						var zclose = $(this).attr('zclose');// (北单 竞彩足球没有该字段)
						var mname = $(this).attr('mname');//联赛名称
						var mt = $(this).attr('mt');//比赛结束时间
						var hms = $(this).attr('hms');//半场主队进球数 (北单 竞彩足球没有该字段)
						var hss = $(this).attr('hss');//半场客队进球数 (北单 竞彩足球没有该字段)
						var lose = $(this).attr('lose');//让球数 (北单没有该字段)
						var cid = $(this).attr('cid');//场次名称  (北单没有该字段)
						var end_time = mt.substr(5,11);//截止时间
						
						var z,rz,tag,c;
						if(parseInt(ms)>parseInt(ss)){//主>客
							z = '<span class="red">主胜</span>';
						}else{
							z = '<span class="green">主负</span>';
						}
						if((parseInt(ms)+parseFloat(lose))>parseInt(ss)){
							rz = '<span class="red jclqsf">让主胜</span>';
						}else{
							rz = '<span class="green jclqsf">让主负</span>';
						}
						c = parseInt(ms)-parseInt(ss);
						c = ( c>=26&&'26+')||( c>=21&&'21-25')||( c>=16&&'16-20')||( c>=11&&'11-15')||( c>=6&&'6-10')||( c>=1&&'1-5')||
							( c>=-5&&'1-5')||( c>=-10&&'6-10')||( c>=-15&&'11-15')||( c>=-20&&'16-20')||( c>=-25&&'21-25')||'26+';
						if(parseInt(ms)>parseInt(ss)){//主>客
							c = '<span class="red jclqsf">主胜'+c+'</span>';
						}else{
							c = '<span class="green jclqsf">客胜'+c+'</span>';
						}
						tag = ((parseInt(ms)+parseInt(ss))>parseFloat(zclose) && '&gt;')||'&lt;';
						html += '<ul class="sfcxs">';
						html += '<li><em>'+cid.substr(-3)+'</em><p>'+mname.substr(0,4)+'</p><cite>'+end_time+'</cite></li><li>';
						html += '<p class="spfzpkNum"><span>(客)'+sn+'</span><span class="spfvs">'+ss+':'+ms+'</span><span>'+mn+'(主)</span></p>';
						html += '<div>';
						html += '<p><span>胜负</span><span class="jclqsf">让分('+lose+')</span><span>大小分</span><span class="jclqsf">胜分差</span></p>';
						html += '<p>'+z+''+rz+'<span>'+tag+''+zclose+'</span>'+c+'</p>';
						html += '</div>';
						html += '</li></ul>';
					});
					$('#content section').html(html);
				}
			});
		}
};
$(document).ready(function(){
	Jclq_kj.initail();
	Jclq_kj.bind();
});