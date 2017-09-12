var ZST = (function(){
	var getParam = function(name)
	{
	     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	     var r = window.location.search.substr(1).match(reg);
	     if(r!=null)return  unescape(r[2]); return null;
	}
	
	var odd_even=function(n){
		var str = n%2==0?"偶":"奇"
			return str;
	};
	
	//初始化数据
	var initData=function(){
		var html="";
		$.ajax({
	     	 type: 'GET',
	         //data:data,.
	     	 dataType : "xml",
	         url: '/zst/ssc/wxzx_50.xml',
	         success:function (xml){
	        	 var rows = $(xml).find("rows");
	        	 var row = rows.find("row");
	        	 row.each(function(){
	        		 var pid = $(this).attr("pid");
	        		 var codes = $(this).attr("codes");
	        		 var wan = $(this).attr("wan");
	        		 var qian = $(this).attr("qian");
	        		 var bai = $(this).attr("bai");
	        		 var shi = $(this).attr("shi");
	        		 var ge = $(this).attr("ge");
	        		 pid = pid.substr(-3)
	        		 
	        		 var codesArr = codes.split("");
	        		 var hundreds = codesArr[2];
	        		 var tens = codesArr[3];
	        		 var units = codesArr[4];
	        		 var zu="";
	        		 
	        		 if(hundreds==tens||hundreds==units||tens==units){
	        			 zu="组三"
	        		 }
	        		 
	        		 if(hundreds!=tens&&hundreds!=units&&tens!=units){
	        			 zu="组六"
	        		 }
	        		 
	        		 var txs = "";
	        		 var uxs = "";
	        		 if(tens==0||tens==2||tens==4){
	        			 txs = "小双";
	        		 }
	        		 
	        		 if(tens==1||tens==3){
	        			 txs = "小单";
	        		 }
	        		 
	        		 if(tens==5||tens==7||tens==9){
	        			 txs = "大单";
	        		 }
	        		 
	        		 if(tens==6||tens==8){
	        			 txs = "大双";
	        		 }
	        		 
	        		 if(units==0||units==2||units==4){
	        			 uxs = "小双";
	        		 }
	        		 
	        		 if(units==1||units==3){
	        			 uxs = "小单";
	        		 }
	        		 
	        		 if(units==5||units==7||units==9){
	        			 uxs = "大单";
	        		 }
	        		 
	        		 if(units==6||units==8){
	        			 uxs = "大双";
	        		 }
	 	        	html+='<ul class="clearfix">'
	 	        	html+='<li class="w_18">'+pid+'期</li>'
	 	        	html+='<li class="w_34">'
	 	        		for(var i=0;i<codesArr.length;i++){
	 	        			if(i==codesArr.length-1){
	 	        				html+='<em class="red_color">'+codesArr[codesArr.length-1]+'</em>'
	 	        			}else{
	 	        				html+='<em>'+codesArr[i]+'</em>'
	 	        			}
	 	        		}
	 	        	html+='</li>'
	 	        	html+='<li class="w_16">'+uxs+'</li>'
	 	        	html+='<li class="w_16">'+txs+'</li>'
	 	        	html+='<li class="w_16">'+zu+'</li>'
	 	        	html+='</ul>'
	        	 })
	        	 $(".p_t1").html(html);
	         }
		})
	}
	var bind=function(){
        $(".head_fixed li").click(function(){
            $(this).addClass("cur").siblings("li").removeClass("cur");
            var i=$(this).index();
            $(".tab_content").eq(i).show().siblings(".tab_content").hide();
        })
        $(".number_ul li a").click(function(){
            $(this).toggleClass("cur ball_scale");
        })
	};
	
	
	
	var init = function(){
		initData()
		bind();
	}
	return {
		init :init,
	}
})()

ZST.init()