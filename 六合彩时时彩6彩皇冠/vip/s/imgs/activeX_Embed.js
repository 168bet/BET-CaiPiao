// JScript 文件
function Make_FlashPlay(source,id,width,height){
	document.write("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,22,0\" width="+width+" height="+height+" id="+id+"><param name=wmode value=transparent /><param name=movie value="+source+" /><param name=FlashVars value=pageID=0 /><param name=quality value=high /><param name=menu value=false><embed src="+source+" name="+id+" quality=high wmode=transparent type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash\" width="+width+" height="+height+"></embed></object>");
}
