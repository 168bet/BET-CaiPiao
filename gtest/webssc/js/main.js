String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, '');
}  
function SetCookie(name,value) 
{  
	var Days = 30;  
	var exp = new Date();    
	exp.setTime(exp.getTime() + Days*24*60*60*1000);  
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();  
}  
function getCookie(name) 
{  
	var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));  
	if(arr != null) return unescape(arr[2]); return null;  
}  


function getinfo2()
{
	$.ajax({
		type : "POST",
		url : '/function/Refresh.php',
		data:"gameType="+ $("#Type_List").attr('abbr'),
		error : function(XMLHttpRequest, textStatus, errorThrown){
			if (XMLHttpRequest.readyState == 4){
				if (XMLHttpRequest.status == 500){
					getinfo2();
					return false;
				}
			}
		},
		success:function(data){ 
			var datestr=data.split('{SPLIT}');
			$("#total_amount").html('<em>'+datestr[3]+'</em>');
			$("#re_credit").html('<em>'+datestr[2]+'</em>');
			$("#credit").html('<em>'+datestr[1]+'</em>');
			$("#pls").html('<em>'+datestr[0]+'</em>');
			$("#newOrder").find('.t_td_text').remove();
			$("#newOrder").find('tbody').append(datestr[4]);
		}
	}); 
}
getinfo2();
setInterval(getinfo2, 3000); 
function ksXiaZhu(html,e){ 
	html="<p>"+html+"</p>"; 
	var xx= $(e).offset().left; 
	var yy= $(e).offset().top; 
	var dialog = $.dialog({ 
		title: '快速下注',
		content: html,
		lock : false,
		left : xx-20, 
		top : yy,
		max : false,
		min : false, 
		width:300,
		drag:false,
		button: [{
			name: '确定',
			callback: function () { 
				jsFrame.kuaisuXiaZhu();
			},
			focus: false
		},{
			name: '取消',
			callback:function(){
				return true;
			},
			focus:false
		} 
		]
	}); 
	$('#kuashuorder')[0].focus();
	$('#kuashuorder').keydown(function(event) { 
		if (event.keyCode == 13) { 
			 jsFrame.kuaisuXiaZhu();
			 dialog.close();
			 return false;
		} 
	});
}

function showAlert(html,callback){
	var c = $.dialog({
		title: '用户提示',
		content: html,
		lock : true, 
		max : false,
		min : false,   
		button: [{
			name: '确定',
			callback: function () { 
				if(callback==null){return true;}else{return callback();}
			},
			focus: false
		}]
	}); 	
}

function showQueRen(html,fcallback,cansu){
	 
	var q = $.dialog({
		title: '下注明细(请确认注单)',
		content: html,
		lock : true, 
		max : false,
		min : false,   
		width: 500,
		button: [{
			name: '确定',
			callback: function () { 
				return fcallback(cansu); 
			},
			focus: true
		},{
			name: '取消',
			callback: function () { 
				return true;
			},
			focus: false	
		}]
	}); 
	$('#xzTableBox').focus();
	$('#xzTableBox').keydown(function(event) { 
		if (event.keyCode == 13) {  
			 fcallback(cansu);
			 q.close();
			 return false;
		} 
	});
	 
} 
function doReset(){
	$('td.amount,span.amount').find('input').val('');
	$('.fontBlue,.o,.amount').removeClass('bc').removeClass('onBg'); 	
	$('#kuaisuamount,#kuaisuamount_top').val('');
}
/*
显示正在投注框
*/
function showXZLoading(){
	$('#loadWaiting').show();
	 
} 
function hideLoading(){
	$('#loadWaiting').hide();	
}

function getSelectedCollect(){
	var objArr = new Array();
	$('td.onBg').each(function(){
		if( $(this).attr('scope')!="" ){ 
			objArr.push( this );	
		}						   
	})	
	return objArr;
}

function getSelectedCollect_zh(){
	var objArr = new Array();
	$('td.onBg').each(function(){
		if( $(this).find('span.amount').length>0 ){ 
			objArr.push( $(this).find('span.amount')[0] );	
		}						   
	})	
	return objArr;
}

function yzOrderMoney(money){
	if(money==''){
		showAlert("您输入类型不正确或没有输入实际金额！");
		return false;	
	} 
	money=parseInt(money);
	var mixmoney = parseInt($("#mix").val()); //最低下注金額
	if(money<mixmoney){
		showAlert("你输入的金额低于单注最低("+mixmoney+")的限制！");
        return false;
	}	
}

function getH(){
	return '<div style="max-height:400px;overflow-y:auto;overflow-x:hidden"><table  ID="xzTableBox" class="t1 dataArea struct_table_center struct_general-table" style="table-layout:fixed;width:450px" cellspacing="0"> '+
		 ' <colgroup>			'+
		  '<col class="col2">	'+
		  '<col class="col3">	'+
		  '<col class="col4">	'+
		  '</colgroup>			'+
		  '<thead>				'+
		  '	<tr>				'+
		  '	  <th><h3 class="">号码</h3></th>	'+
		  '	  <th><h3 class="">赔率</h3></th>	'+
		  '	  <th><h3 class="">金额</h3></th>	'+
		  '	</tr>								'+
		  '</thead>								'+
		  '<tbody>								';	
}
function getB(count,countmoney){
	var names = new Array();
	names.push("</tbody></table>"); 
	names.push('<table class="struct_general-table   struct_table_center orderComputing" cellspacing="0">');
	names.push('  <tbody id="orderComputing">');
	names.push('	<tr>');
	names.push('	  <td class="td_a">组数:<span class="reder" id="groupNum">'+count+'</span></td>');
	names.push('	  <td colspan="2">总金额：<span class="reder" id="totalAmount">'+countmoney+'</span></td>');
	names.push('	</tr>');
	names.push('  </tbody>');
	names.push('</table></div>');
	return names.join("");
}



function count($arr){
	return $arr.length;	
}
 
function subArr ($strArr, $count,$tp) 
{
	$len = 0; //總組數
	$Number = new Array();
	for ($a=0; $a<count($strArr); $a++)
	{
		if ($count == 1)
		{
			$len++;
			$Number.push($strArr[$a]);
			continue;
		}
		$_a = $a+1;
		for ($b=$_a; $b<count($strArr); $b++)
		{
			if ($count == 2)
			{
				$len++;
				$Number.push($strArr[$a]+','+$strArr[$b]);
				continue;
			}
			$_b = $b+1;
			for ($c=$_b; $c<count($strArr); $c++)
			{
				if ($count == 3)
				{
					$len++;
					$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]);
					continue;
				}
				$_c = $c+1;
				for ($d=$_c; $d<count($strArr); $d++)
				{
					if ($count == 4)
					{
						$len++;
						$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]);
						continue;
					}
					$_d = $d+1;
					for ($e=$_d; $e<count($strArr); $e++)
					{
						if ($count == 5)
						{
							$len++;
							$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]);
							continue;
						}
						$_e = $e+1;
						for ($f=$_e; $f<count($strArr); $f++)
						{
							if ($count == 6)
							{
								$len++;
								$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]+','+$strArr[$f]);
								continue;
							}
							$_f=$f+1;
							for ($g=$_f; $g<count($strArr); $g++)
							{
								if ($count == 7)
								{
									$len++;
									$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]+','+$strArr[$f]+','+$strArr[$g]);
									continue;
								}
								$_g=$g+1;
								for ($h=$_g; $h<count($strArr); $h++)
								{
									if ($count == 8)
									{
										$len++;
										$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]+','+$strArr[$f]+','+$strArr[$g]+','+$strArr[$h]);
										continue;
									}
									$_h=$h+1;
									for ($i=$_h; $i<count($strArr); $i++)
									{
										if ($count == 9)
										{
											$len++;
											$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]+','+$strArr[$f]+','+$strArr[$g]+','+$strArr[$h]+','+$strArr[$i]);
											continue;
										}
										$_i=$i+1;
										for ($j=$_i; $j<count($strArr); $j++)
										{
											if ($count == 10)
											{
												$len++;
												$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]+','+$strArr[$f]+','+$strArr[$g]+','+$strArr[$h]+','+$strArr[$i]+','+$strArr[$j]);
												continue;
											}
											$_j=$j+1;
											for ($k=$_j; $k<count($strArr); $k++)
											{
												if ($count == 11)
												{
													$len++;
													$Number.push($strArr[$a]+','+$strArr[$b]+','+$strArr[$c]+','+$strArr[$d]+','+$strArr[$e]+','+$strArr[$f]+','+$strArr[$g]+','+$strArr[$h]+','+$strArr[$i]+','+$strArr[$j]+','+$strArr[$k]);
													continue;
												} 
											}//11層嵌套
										}//10層嵌套
									}//9層嵌套
								}//8層嵌套
							}//7層嵌套
						}//6層嵌套
					}//5層嵌套
				}//4層嵌套
			}//3層嵌套
		}//2層嵌套
	} //1層嵌套
	if($tp==0){
		return $len;	
	}else if($tp==1){
		return $Number;		
	}
}

function doFengPan(){
	$('.fontBlue,.o,.amount').addClass('huiseBg');
	$('.o,.amount').html('');	
}
function doKaiPan(){
	$('.fontBlue,.o,.amount').removeClass('huiseBg'); 
}

