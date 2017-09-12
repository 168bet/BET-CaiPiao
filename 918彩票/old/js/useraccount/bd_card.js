/*Author: weige 
Date: 2014-4-22*/
var cities ={
		'北京' : ['北京'],
		'上海' : ['上海'],
		'重庆' : ['重庆'],
		'天津' : ['天津'],
		'广东' : ['广州','深圳','韶关','珠海','汕头','佛山','江门','湛江','茂名','肇庆','惠州','梅州','汕尾','河源','阳江','清远','东莞','中山','潮州','揭阳','云浮'],
		'河北' : ['石家庄','唐山','秦皇岛','邯郸','邢台','保定','张家口','承德','沧州','廊坊','衡水'],
		'山西': ['太原','大同','阳泉','长治','晋城','朔州','晋中','运城','忻州','临汾','吕梁', '永济'],
		'内蒙古': ['呼和浩特','包头','乌海','赤峰','通辽','鄂尔多斯','呼伦贝尔','巴彦淖尔','乌兰察布','兴安','锡林郭勒','阿拉善','临河','东胜','集宁','锡林浩特','海拉尔','乌兰浩特'],
		'辽宁' : ['沈阳','大连','鞍山','抚顺','本溪','丹东','锦州','营口','阜新','辽阳','盘锦','铁岭','朝阳','葫芦岛'],
		'吉林' : ['长春','吉林','四平','辽源','通化','白山','松原','白城','延边'],
		'黑龙江' : ['哈尔滨','齐齐哈尔','鸡西','鹤岗','双鸭山','大庆','伊春','佳木斯','七台河','牡丹江','黑河','绥化','大兴安岭'],
		'江苏' : ['南京','无锡','徐州','常州','苏州','南通','连云港','淮安','盐城','扬州','镇江','泰州','宿迁','淮阴','张家港'],
		'浙江' : ['杭州','宁波','温州','嘉兴','湖州','绍兴','金华','衢州','舟山','台州','丽水','温岭'],
		'安徽' : ['合肥','芜湖','蚌埠','淮南','马鞍山','淮北','铜陵','安庆','黄山','滁州','阜阳','宿州','巢湖','六安','亳州','池州','宣城'],
		'福建' : ['福州','厦门','莆田','三明','泉州','漳州','南平','龙岩','宁德'],
		'江西' : ['南昌','景德镇','萍乡','九江','新余','鹰潭','赣州','吉安','宜春','抚州','上饶'],
		'山东' : ['济南','青岛','淄博','枣庄','东营','烟台','潍坊','济宁','泰安','威海','日照','莱芜','临沂','德州','聊城','滨州','菏泽'],
		'河南' : ['郑州','开封','洛阳','平顶山','安阳','鹤壁','新乡','焦作','濮阳','许昌','漯河','三门峡','南阳','商丘','信阳','周口','驻马店','济源'],
		'湖北' : ['武汉','黄石','十堰','宜昌','襄樊','鄂州','荆门','孝感','荆州','黄冈','咸宁','随州','恩施','仙桃','潜江','天门','神农架'],
		'湖南' : ['长沙','株洲','湘潭','衡阳','邵阳','岳阳','常德','张家界','益阳','郴州','永州','怀化','娄底','湘西'],
		'广西' : ['南宁','柳州','桂林','梧州','北海','防城港','钦州','贵港','玉林','百色','贺州','河池','来宾','崇左','桂平'],
		'海南' : ['海口','三亚','五指山','琼海','儋州','文昌','万宁','东方','琼山','临高','陵水','澄迈','定安','屯昌','昌江','白沙','琼中','乐东','保亭','陵水'],
		'四川' : ['成都','自贡','攀枝花','泸州','德阳','绵阳','广元','遂宁','内江','乐山','南充','眉山','宜宾','广安','达州','雅安','巴中','资阳','阿坝','甘孜','凉山','达川','阆中'],
		'贵州' : ['贵阳','六盘水','遵义','安顺','铜仁','黔西南','毕节','黔东南','黔南'],
		'云南' : ['昆明','曲靖','玉溪','保山','昭通','丽江','思茅','临沧','楚雄','红河州','文山','西双版纳','大理','德宏','怒江傈','迪庆','东川','怒江'],
		'西藏' : ['拉萨','昌都','山南','日喀则','那曲','阿里','林芝'],
		'陕西' : ['西安','铜川','宝鸡','咸阳','渭南','延安','汉中','榆林','安康','商洛'],
		'甘肃' : ['兰州','嘉峪关','金昌','白银','天水','武威','张掖','平凉','酒泉','庆阳','定西','陇南','临夏','甘南'],
		'青海' : ['西宁','海东','海北','黄南','海南','果洛','玉树','海西'],
		'宁夏' : ['银川','石嘴山','吴忠','固原','中卫','银南'],
		'新疆' : ['乌鲁木齐','克拉玛依','吐鲁番','哈密','昌吉','博尔塔拉','巴音郭楞','阿克苏','克孜勒苏','喀什','和田','伊犁','塔城','阿勒泰','石河子','阿拉尔','图木舒克','五家渠']
		};


var amend = location.search.getParam('amend');
$(function(){
	$('#khbank').val('0');
	if(amend == 'y'){
		$('#kahao').parent().hide();
		$('#kahao').parent().prev().hide();
		$("#bdCard").show();
		$("#success").hide();
		WW.revise();
	}else{
		WW.initial();
	}
	$(".zhuceOpen2").bind("click",function(){
		$(this).hide();
		$(".zhuceOpen").show();
		$("#mima").attr("type","text");
	});
	
	$(".zhuceOpen").bind("click",function(){
		$(this).hide();
		$(".zhuceOpen2").show();
		$("#mima").attr("type","password");
	});
	
	$("#kahao").bind("keyup",function(){
		this.value=this.value.replace(/\D/g,''); //只能输数字
	    this.value =this.value.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");//四位数字一空格
	});
});
var WW = {
	initial :function(){
		$('#ibank em').html('请选择银行');
		$('#spve em').html('上海');
		$('#icity em').html('上海');
		checkLogin(function(){
			$.ajax({
				url : $_user.url.card,
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if (code == "0") {	
						var r= R.find("row");
						var code = r.attr("code");//开户行
						var name = r.attr("name");//支行名称
						var prov = r.attr("prov");//省
						var city = r.attr("city");//市
						var card = r.attr("card");//卡号
						if(card ==""){
							$("#bdCard").show();
							$("#success").hide();
						}else{
							$('#success p').eq(0).html('<span class="gray">银行卡号</span>'+card);
							$('#success p').eq(1).html('<span class="gray">开 户 行</span>'+$('li[value='+code+']', "#banks").html());
							$('#success p').eq(2).html('<span class="gray">开 户 地</span>'+prov+city);
							$('#success p').eq(3).html('<span class="gray">开户支行</span>'+name);
							$("#bdCard").hide();
							$("#success").show();
						}
					}else{
						D.alert(desc);
					}
				},
				error : function() {
					D.alert('您所请求的页面有异常！');
					return false;
				}
			});
		});
 	},
 	revise:function(){
// 		var buynum = '';
//		$("#zhihang").on("blur", function(e) {
//			var value = $(this).val();
//			if (value == "" && e.type != "blur") {
//				
//			} else {
//				if ((/[^\u4E00-\u9FA5]/g).test(value)) {
//					$("#zhihang").val(buynum);
//				}else{
//					buynum = value;
//				}
//			}
//		}); 
 		checkLogin(function(){
			$.ajax({
				url : $_user.url.card,
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if (code == "0") {	
						var r= R.find("row");
						var code = r.attr("code");//开户行
						var name = r.attr("name");//支行名称
						var prov = r.attr("prov");//省
						var city = r.attr("city");//市
						$('#khbank').val(code);
						if(name !=""){
							$('#zhihang').val(name);
							$('#ibank em').html($('li[value='+code+']', "#banks").html());
							$('#spve em').html(prov);
							WW.changecitybyprovince(prov);
							$('#icity em').html(city);
							
						}
					}else{
						D.alert(desc);
					}
				},
				error : function() {
					D.alert('您所请求的页面有异常！');
					return false;
				}
			});
		});
 	},
 	changecitybyprovince:function(province){
 		var len = 0,city=[];
 		if(province.length>0){
    		city = cities[province];
    		len = city.length;
 		}
 		var ret = '';
 		for(var i=0;i<len;i++){
 			
 			ret += '<li class="'+(i==0? "cur" :"")+'" >'+city[i]+'</li>';
 		}
 		$('#icity em').html(city[0]);
 		$("#city ul").html(ret);
 		
 	}
};
function sBank(){//银行
	$('#banks').show();
	$('#zhezhao').show();
	$('#banks').css({left:parseInt((document.documentElement.clientWidth-$("#banks").width())/2),top:parseInt((document.documentElement.clientHeight-$("#banks").height())/2)});

	$('#banks li').click(function(){
		$('#banks li').attr('class','');
		$(this).attr('class','cur');
		$('#ibank em').html($(this).html());
		$('#banks').hide();
		$('#zhezhao').hide();
		$('#khbank').val($(this).attr('value'));
	});
}
function spve(){//生
	$('#pve').show();
	$('#zhezhao').show();
	$('#pve').css({left:parseInt((document.documentElement.clientWidth-$("#pve").width())/2),top:parseInt((document.documentElement.clientHeight-$("#pve").height())/2)});

	$('#pve li').click(function(){
		$('#pve li').attr('class','');
		$(this).attr('class','cur');
		$('#spve em').html($(this).html());
		$('#pve').hide();
		$('#zhezhao').hide();
		WW.changecitybyprovince($(this).html());
	});
}
function icity(){//市
	$('#city').show();
	$('#zhezhao').show();
	$('#city').css({left:parseInt((document.documentElement.clientWidth-$("#city").width())/2),top:parseInt((document.documentElement.clientHeight-$("#city").height())/2)});

	$('#city li').click(function(){
		$('#city li').attr('class','');
		$(this).attr('class','cur');
		$('#icity em').html($(this).html());
		$('#city').hide();
		$('#zhezhao').hide();
	});
}
function isOk(){
	var zhihang = $("#zhihang").val();
	var kahao = $.trim($('#kahao').val().replace(/\s+/g,""));
	if($("#khbank").val()=='0'){
		D.alert('请选择开户银行');
		return false;
	}else if(zhihang == ""){
		D.alert('请填写开户支行');
		return false;
	}else if(zhihang.indexOf('支行') == '-1'){
		D.alert('支行不符合规范',function(){
			$("#zhihang").focus();
		});
		return false;
	}else if(kahao == "" && amend != 'y'){
		D.alert('请填写银行卡号');
		return false;
	}else if(kahao.length<14 && amend != 'y'){
		D.alert('银行卡号不能少于14位');
		return false;
	}else if($("#mima").val()==""){
		D.alert('请输入密码');
		return false;
	}else{
		var bankCode = $("#khbank").val();
		var bankName = $("#zhihang").val();
		var upwd = $("#mima").val();
		var cityid = $.trim($("#icity em").html());
		var provid = $.trim($("#spve em").html());
		var data = "";
		if(amend != 'y'){
			data = $_user.key.bankCode + "=" + encodeURIComponent(bankCode)
			+ "&" + $_user.key.bankCard + "=" + encodeURIComponent(kahao)
			+ "&" + $_user.key.provid + "=" + encodeURIComponent(provid)
			+ "&" + $_user.key.cityid + "=" + encodeURIComponent(cityid.replace())
			+ "&" + $_user.key.bankName + "=" + encodeURIComponent(bankName)
			+ "&" + $_user.key.upwd + "=" + encodeURIComponent(upwd)
			+ "&rnd=" + Math.random();
		}else{
			data = $_user.key.bankCode + "=" + encodeURIComponent(bankCode)
			+ "&tid=1"
			+ "&" + $_user.key.provid + "=" + encodeURIComponent(provid)
			+ "&" + $_user.key.cityid + "=" + encodeURIComponent(cityid.replace())
			+ "&" + $_user.key.bankName + "=" + encodeURIComponent(bankName)
			+ "&" + $_user.key.upwd + "=" + encodeURIComponent(upwd)
			+ "&rnd=" + Math.random();
		}
		
		$.ajax({
			url : $_user.modify.card,
			type : "POST",
			dataType : "xml",
			data : data,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					D.alert('银行卡绑定成功',function(){
						window.location.href='/useraccount/setup/bcardbin.html';
					});
					
				} else {
					D.alert(desc);
				}
			},
			error : function() {
				D.alert('您所请求的页面有异常！');
				return false;
			}
		});	
	}
}