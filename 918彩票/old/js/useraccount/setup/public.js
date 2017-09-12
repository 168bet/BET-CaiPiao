$(function(){
	$(".myRecord").html("");
	$.ajax({
        url: "/news/appgonggao/appgonggaolist.xml",
        success:function (data){
        	var R = $(data).find("Resp");
        	var r = $(R).find("row")
        	var c = R.attr('code');
        	var html="";
        	if(c == '0'){
        		if(r){
	    			r.each(function(){
	    				var ntitle=$(this).attr("ntitle");
	    				var arcurl=$(this).attr("arcurl");
	    				var ndate=parseInt($(this).attr("ndate")); 
	    				var date = new Date(ndate*1000);
	    				var m = date.getMonth()+1;
	    				if(m<10){
	    					m="0"+m
	    				}
	    				
	    				var d = date.getDate();
	    				
	    				var str = m+"-"+d;
	   					 html+='<a href="'+arcurl+'">';
	   					 html+='<p class="fontSize09">'+ntitle+'</p>';
	   					 html+='<p class="gray fontSize07">'+str+'</p>';
	   					 html+='<i class="hmArrow"></i>';
	   					 html+='</a>';
	    			})
	    			$(".myRecord").html(html);
        		}else{
        			html="";
        			$(".myRecord").html(html);
        		}
        		
        	}else{
        		//alert(desc);
        	}
        }
	})
})