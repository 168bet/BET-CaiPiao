function SelectType(LT) { 
	s_LT=LT;
	if (LT==1){ 
        document.getElementById("Type_List").innerHTML='<a href="#this" id="sGame_sm" class="on">兩面盤</a> | <a href="#this" id="sGame_1" rel="sGame.php">第一球</a> | <a href="#this"  id="sGame_2" rel="sGame.php">第二球</a> | <a  href="#this" id="sGame_3" rel="sGame.php">第三球</a> | <a  href="#this"  id="sGame_4" rel="sGame.php">第四球</a> | <a href="#this"  id="sGame_5" rel="sGame.php">第五球</a> | <a  href="#this"  id="sGame_6" rel="sGame.php">第六球</a> | <a  href="#this"  id="sGame_7" rel="sGame.php">第七球</a> | <a href="#this"  id="sGame_8" rel="sGame.php">第八球</a> | <a  href="#this" id="sGame_zm">正碼</a>  | <a  href="#this" id="sGame_k">連碼</a>'; 
	} else if (LT==2){ 
	
        document.getElementById("Type_List").innerHTML='<a href="#this" id=sGame_sz_cq class="on">整合</a> | <a href="#this" id=sGame_cq_1 rel="sGame_cq.php">第一球</a> | <a href="#this" id=sGame_cq_2 rel="sGame_cq.php">第二球</a> | <a href="#this" id=sGame_cq_3 rel="sGame_cq.php">第三球</a> | <a href="#this" id=sGame_cq_4 rel="sGame_cq.php">第四球</a> | <a href="#this" id=sGame_cq_5 rel="sGame_cq.php">第五球</a>';
         
	}else if (LT==3){
		 
        document.getElementById("Type_List").innerHTML='<a href="#this" onclick=goMain("userlib/sGame_sm_gx.php?g=g9") class="on">兩面盤</a> | <a href="#this" onclick=goMain("userlib/sGame_sz_gx.php?g=g9")>数字盤</a> | <a href="#this" onclick=goMain("userlib/sGame_gx.php?g=g5")>特码</a> | <a href="#this" onclick=goMain("userlib/sGame_gx.php?g=g1")>第一球</a> | <a href="#this" onclick=goMain("userlib/sGame_gx.php?g=g2")>第二球</a> | <a  href="#this" onclick=goMain("userlib/sGame_gx.php?g=g3")>第三球</a> | <a  href="#this" onclick=goMain("userlib/sGame_gx.php?g=g4")>第四球</a> | <a  href="#this" onclick=goMain("userlib/sGame_l_gx.php?g=k1")>龍虎</a> | <a  href="#this" onclick=goMain("userlib/sGame_k_gx.php?g=k2")>連碼</a>';
        
		
	}else if (LT==5){
		 
		$("#Type_List").html('<a  href="#this" id="sGame_sm_nc" class="on" >兩面盤</a> | <a  href="#this" id="sGame_nc_1" rel="sGame_nc.php">第一球</a> | <a  href="#this" id="sGame_nc_2" rel="sGame_nc.php">第二球</a> | <a  href="#this" id="sGame_nc_3" rel="sGame_nc.php">第三球</a> | <a  href="#this" id="sGame_nc_4" rel="sGame_nc.php">第四球</a> | <a  href="#this" id="sGame_nc_5" rel="sGame_nc.php">第五球</a> | <a  href="#this" id="sGame_nc_6" rel="sGame_nc.php">第六球</a> | <a  href="#this" id="sGame_nc_7" rel="sGame_nc.php">第七球</a> | <a  href="#this" id="sGame_nc_8" rel="sGame_nc.php">第八球</a> | <a  href="#this" id="sGame_nc_zm">正碼</a>  | <a  href="#this"  id="sGame_nc_k">連碼</a>');
        
	}else if(LT==6){ 
        document.getElementById("Type_List").innerHTML='<a href="#this" id="sgame_sm_pk" class="on"  >兩面盤</a> | <a href="#this" id="sGame_pk_3" class="w5em">1~5名</a> | <a  href="#this" id="sGame_pk_7" class="w5em">6~10名</a>  | <a href="#this" id="sgame_pk" class="w5em " >冠亞軍組合</a> |';
        
	}else if(LT==7){
		 
		 
		document.getElementById("Type_List").innerHTML='<a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g7") class="on">特碼</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g1") >正碼一</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g2") >正碼二</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g3") >正碼三</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g4") >正碼四</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g5") >正碼五</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g6") >正碼六</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc.php?g=g8") >正碼</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_bo.php?g=g9") >半波</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_bo.php?g=g10") >五行</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_bo.php?g=g11") >特碼生肖</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_bo.php?g=g12") >一肖</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_wei.php?g=g13") >特尾</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_wei.php?g=g14") >尾數</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_bo.php?g=g15") >特碼頭</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_l.php?g=g17") >連碼</a> | <a href="#this" onclick=goMain("userlib/sGame_lhc_x.php?g=g18") >合肖</a>';
       
	} else if (LT==8){
		 
        document.getElementById("Type_List").innerHTML='<a href="#this" onclick=goMain("userlib/sGame_sm_xj.php?g=g10") class="on">兩面盤</a> | <a href="#this" onclick=goMain("userlib/sGame_sz_xj.php?g=g9")>数字盤</a> | <a href="#this" onclick=goMain("userlib/sGame_xj.php?g=g1")>第一球</a> | <a href="#this" onclick=goMain("userlib/sGame_xj.php?g=g2")>第二球</a> | <a href="#this" onclick=goMain("userlib/sGame_xj.php?g=g3")>第三球</a> | <a href="#this" onclick=goMain("userlib/sGame_xj.php?g=g4")>第四球</a> | <a href="#this" onclick=goMain("userlib/sGame_xj.php?g=g5")>第五球</a>';
        
	}else if (LT==9){
		 
        document.getElementById("Type_List").innerHTML='<a class="on w5em" href="#this" id="sGame_jstb"  >大小骰寶</a>';
        
	}
	$("#Type_List a").click(function(){
		$('#Type_List a').removeClass('on');
		$(this).addClass('on');
		loadPage( $(this).attr('id'),$(this).attr('rel') );
	});
}
$('#klc_sys').bind('click',function(){
	$("#Type_List").attr('abbr','gd');
	if( htmlCollect['gd']!=null && htmlCollect['gd']!="" ){
		$('.header-op').find('a').removeClass('switch-on');
		$('#klc_sys').addClass('switch-on');
		SelectType(1);
		$("#Type_List a").first().trigger('click');
	}else{
		showXZLoading();
		$.get('htmlCollect.php?gameType=gd',function(data){
			htmlCollect['gd']=data;  
			$('.header-op').find('a').removeClass('switch-on');
			$('#klc_sys').addClass('switch-on');
			SelectType(1);
			$("#Type_List a").first().trigger('click');
			hideLoading();
		})
	} 
})
$('#ssc_sys').bind('click',function(){
	$("#Type_List").attr('abbr','cq');
	if( htmlCollect['cq']!=null && htmlCollect['cq']!="" ){
		 
		$('.header-op').find('a').removeClass('switch-on');
		$('#ssc_sys').addClass('switch-on');
		SelectType(2);	
		$("#Type_List a").first().trigger('click');
	}else{
		showXZLoading();
		$.get('htmlCollect.php?gameType=cq',function(data){
			htmlCollect['cq']=data;  
			$('.header-op').find('a').removeClass('switch-on');
			$('#ssc_sys').addClass('switch-on');
			SelectType(2);	
			$("#Type_List a").first().trigger('click');
			hideLoading();
		})
	}
})
$('#pk10_sys').bind('click',function(){
	$("#Type_List").attr('abbr','pk10');
	
	if( htmlCollect['pk10']!=null && htmlCollect['pk10'].replace(/(^\s*)|(\s*$)/g, "")!="" ){
		$('.header-op').find('a').removeClass('switch-on');
		$('#pk10_sys').addClass('switch-on');
		SelectType(6);	 
		$("#Type_List a").first().trigger('click');
	}else{
		showXZLoading();
		$.get('htmlCollect.php?gameType=pk10',function(data){
			htmlCollect['pk10']=data;  	 
			$('.header-op').find('a').removeClass('switch-on');
			$('#pk10_sys').addClass('switch-on');
			SelectType(6);	 
			$("#Type_List a").first().trigger('click');
			hideLoading();
		})
	}
})
$('#nc_sys').bind('click',function(){
	$("#Type_List").attr('abbr','nc');
	if( htmlCollect['nc']!=null && htmlCollect['nc']!="" ){
		$('.header-op').find('a').removeClass('switch-on');
		$('#nc_sys').addClass('switch-on');
		SelectType(5);	
		$("#Type_List a").first().trigger('click');
	}else{
		showXZLoading();
		$.get('htmlCollect.php?gameType=nc',function(data){ 
			htmlCollect['nc']=data;  	
			$('.header-op').find('a').removeClass('switch-on');
			$('#nc_sys').addClass('switch-on');
			SelectType(5);	
			$("#Type_List a").first().trigger('click');
			hideLoading();
		})
	}
})
$('#ks_sys').bind('click',function(){
	$("#Type_List").attr('abbr','ks');
	if( htmlCollect['ks']!=null && htmlCollect['ks']!="" ){
		$('.header-op').find('a').removeClass('switch-on');
		$('#ks_sys').addClass('switch-on');
		SelectType(9);	
		$("#Type_List a").first().trigger('click');
	}else{
		showXZLoading();
		$.get('htmlCollect.php?gameType=ks&rns='+new Date(),function(data){ 
			htmlCollect['ks']=data;  	
			$('.header-op').find('a').removeClass('switch-on');
			$('#ks_sys').addClass('switch-on');
			SelectType(9);	
			$("#Type_List a").first().trigger('click');
			hideLoading();
		})
	}
	 
})

htmlCollect['pk10']=$('#layoutright').html();  	
$('#pk10_sys').trigger('click');

$('#skinChange').bind({
	'mouseenter':function(){ $(this).find('.inner').show();},
	'mouseleave':function(){ $(this).find('.inner').hide();}
})
$('#skinChange').find('.inner').find('a').bind('click',function(){
	$('body').attr('class',$(this).attr('skinclass'));
	updateDlgSkin( $(this).attr('skinclass') );
	SetCookie('skinclass',$(this).attr('skinclass')); 
})
$('#lineSelect').bind('click',function(){
	$('#lineSelectBox').show();
	cesu();
})
$('#moreNotice').bind('click',function(){
	var dialog = $.dialog({
		title: '历史公告',
		content: 'url:notice.php?skin='+getSkin(),
		lock : true,
		max : false,
		min : false, 
		width:760, 
		button: [{
			name: '确定',
			callback: function () { 
				return true;
			},
			focus: false
		}]
	}); 						   
})
if(getCookie("skinclass")!=null && (getCookie("skinclass")=="skin_brown" || getCookie("skinclass")=="skin_blue" || getCookie("skinclass")=="skin_red")){
	$('body').attr('class',getCookie("skinclass"));	 
	updateDlgSkin( getCookie("skinclass") );
}
function updateDlgSkin(skin){
	var h = $('#lhgdglink').attr('href');
	h = h.replace('skin_brown',skin).replace('skin_blue',skin).replace('skin_red',skin);
	$('#lhgdglink').attr('href',h)
}
function getSkin(){
	if(getCookie("skinclass")!=null && (getCookie("skinclass")=="skin_brown" || getCookie("skinclass")=="skin_blue" || getCookie("skinclass")=="skin_red")){
		return getCookie("skinclass"); 
	}else{
		return 'skin_brown'; 	
	}
}

function loadPage(id,rel){  
	var key = $("#Type_List").attr('abbr');
	$('#htmlBox').html( htmlCollect[key] );   
	$('#layoutright').html( $('#htmlBox').find('div.'+id).html() );
	$('#htmlBox').html(''); 
	loadJs(id,rel);
	dominit(); 
}
function loadJs(id,rel){
	if(rel!='' && rel!=null){ 
		window.open(rel,'jsFrame'); 
	}else{  
		window.open(id+'.php','jsFrame'); 	
	}
}

function loadMainHtml(url,id){
	showXZLoading();
	$.get(url,function(data){  
		hideLoading(); 
		$('#layoutright').html( data );
		loadJs(id);
	}) 	
}

$('a.ajaxload').bind('click',function(){
	var id = $(this).attr('id');
	loadMainHtml( id+".php?loadhtml=true&gameType="+ $("#Type_List").attr('abbr'),id ); 
	$('.main-nav span').removeClass('on');
	$(this).parent().addClass('on');
})