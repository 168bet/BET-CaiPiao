/*快捷與一般按鈕*/
function dominit(){
	$('#elem_type_div').find('a').bind('click',function(){
		$(this).parent().find('a').removeClass('on');
		$(this).addClass('on');
		doReset();
		$('body').attr('nav',$(this).attr('nav'))
		if( $(this).attr('nav')=='odds' ){ //快捷
			$('.kuaijie').show();
			$('#kuaijie_div').show();
			$('#common_div').hide();
			if(top.fengpan!=null && top.fengpan){
				$('#bulk-amount-input').find('input').attr('disabled','disabled');
			}
			$('.amount').hide();
		}else{
			$('.kuaijie').hide();	
			$('#kuaijie_div').hide();
			$('#common_div').show();
			$('.amount').show();
		}
	})
	/*复位按钮*/
	$('#reset_top,#reset').bind('click',function(){
		doReset();	 
	})  
	/*鼠標移動到td上去的效果*/
	$('td.fontBlue,td.o,td.amount').bind({
		'mouseenter':function(){
			if($(this).attr('class').indexOf('huiseBg')>=0)return;
			$(this).addClass('bc');
			if( $(this).attr('class').indexOf('fontBlue')==0 ){
				$(this).next().attr('class').indexOf('fontBlue')==0 || $(this).next().addClass('bc'); 
				$(this).next().next().attr('class').indexOf('fontBlue')==0 || $(this).next().next().addClass('bc');
			}else if ( $(this).attr('class').indexOf('o')==0 ){
				$(this).prev().addClass('bc');
				$(this).next().attr('class').indexOf('fontBlue')==0 || $(this).next().addClass('bc');
			}else if ( $(this).attr('class').indexOf('amount')==0 ){
				$(this).prev().addClass('bc');
				$(this).prev().prev().addClass('bc');
			}
		},
		'mouseleave':function(){
			if($(this).attr('class').indexOf('huiseBg')>=0)return;
			$(this).removeClass('bc');
			if( $(this).attr('class').indexOf('fontBlue')==0 ){
				$(this).next().removeClass('bc');
				$(this).next().next().removeClass('bc');
			}else if ( $(this).attr('class').indexOf('o')==0 ){
				$(this).prev().removeClass('bc');
				$(this).next().removeClass('bc');
			}else if ( $(this).attr('class').indexOf('amount')==0 ){
				$(this).prev().removeClass('bc');
				$(this).prev().prev().removeClass('bc');
			}
		},
		'click':function(){
			if($(this).attr('class').indexOf('huiseBg')>=0)return;
			if( $('body').attr('nav')=='odds'){ //快捷情况
				if( $(this).attr('class').indexOf('onBg')>=0 ){
					
					$(this).removeClass('onBg');
					if( $(this).attr('class').indexOf('fontBlue')==0 ){
						$(this).next().removeClass('onBg');
						$(this).next().next().removeClass('onBg');
					}else if ( $(this).attr('class').indexOf('o')==0 ){
						$(this).prev().removeClass('onBg');
						$(this).next().removeClass('onBg');
					}else if ( $(this).attr('class').indexOf('amount')==0 ){
						$(this).prev().removeClass('onBg');
						$(this).prev().prev().removeClass('onBg');
					}
					
				}else{
					$(this).addClass('onBg');
					if( $(this).attr('class').indexOf('fontBlue')==0 ){
						$(this).next().attr('class').indexOf('fontBlue')==0 || $(this).next().addClass('onBg'); 
						try{$(this).next().next().attr('class').indexOf('fontBlue')==0 || $(this).next().next().addClass('onBg');}catch(e){}
					}else if ( $(this).attr('class').indexOf('o')==0 ){
						$(this).prev().addClass('onBg');
						try{$(this).next().attr('class').indexOf('fontBlue')==0 || $(this).next().addClass('onBg');}catch(e){}
					}else if ( $(this).attr('class').indexOf('amount')==0 ){
						$(this).prev().addClass('onBg');
						$(this).prev().prev().addClass('onBg');
					}
				}
			}else{  
				
				$obj=false; 
				if( $(this).attr('class').indexOf('fontBlue')==0 ){
					try{
						if( $(this).next()!=null && $(this).next().attr('class').indexOf('amount')==0 ){
							$obj=$(this).next();
							
						}	
					}catch(e){}
					
					try{
						if( $(this).next().next()!=null && $(this).next().next().attr('class').indexOf('amount')==0 ){
							$obj=$(this).next().next();	 
							
						}
					}catch(e){
						 
					} 
					try{
						 
						if( $(this).next().find('span.amount').length>0){
							$obj=$(this).next().find('span.amount');  
						 
						}
					}catch(e){
						 
					}
					 
				}else if( $(this).attr('class').indexOf('o')==0 ){
					
					try{
						if( $(this).next()!=null &&  $(this).next().attr('class').indexOf('amount')==0 ){
							$obj=$(this).next(); 
						}
					}catch(e){}
					try{
						if( $(this).find('span.amount').length<1 &&  $(this).next().find('span.amount').length>0 ){
							$obj=$(this).next().find('span.amount'); 
						}
					}catch(e){}
					 
				}
				if($obj){
					 
					var html = jsFrame.getHtml( $obj );	
					ksXiaZhu(html,this);
				}
			}
		}
	})
	
	$('#sideLeftBack').bind('click',function(){
		 $('.hide-successinfo').hide();
		$('#left_times_title').hide(); 
		$('#newOrder').show();
		$('.playtype').show();	
		$('#successinfo').hide();
	})
	if( $('body').attr('nav')!='' ){
		$('#elem_type_div').find('a[nav='+ $('body').attr('nav')+']').trigger('click');	
	}else{
		$('#elem_type_div').find('a[nav=odds]').trigger('click');		
	}
	
	
	$('.amount').keydown(function(event) { 
		if (event.keyCode == 13) {  
			jsFrame.submitforms( $('#submit_top')[0] ) 
			return false;
		} 
	});
	$('#kuaisuamount_top').keydown(function(event) {  
		if (event.keyCode == 13) {   
			 jsFrame.submitforms( $('#submit_top')[0] ) ; 
			 return false;
		} 
	});
	$('#kuaisuamount').keydown(function(event) { 
		if (event.keyCode == 13) { 
			 jsFrame.submitforms( $('#submit')[0] );
			 return false;
		} 
	});
}