
 function page_show(){
    //===だ耞===//
     if(wtype=='OU' || wtype=='RE' || wtype=='V')
   {
	var page_down_show = main.document.getElementById('page_down');
	var page_up_show = main.document.getElementById('page_up');	
 	if(pages == 1)
	{
			page_up_show.style.display='none';
			page_down_show.style.display='none';
	}
 	if(pages== 2)
	{
			page_up_show.style.display='block';
			page_down_show.style.display='block';
	}	
	}
	//=============//
 }
 
function ShowGameList()
 {
 if(loading_var == 'Y') return;
  obj_msg = main.document.getElementById('real_Msg');
  obj_msg.innerHTML = '<div id=\"marquee_str\" style=\'color:#000000;font-weight: normal\'>'+Msg+'</div>';
  main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
 
 
    show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	
  switch(wtype)
  {
    case 'EVEN':
    ShowData_EVEN();
    break;
    case "SP":	
    ShowData_V(show_table,games_table,games_table1);
    break;
    case 'NA':
    ShowData_NA();
    break;
    case 'NO':
    ShowData_NO();
    break;  
   case 'SPA':
    ShowData_SPA();
    break;
   case 'SPB':	
    ShowData_SPB();
    break;
   case 'EO':
    ShowData_EO(game_table,GameFT,gamount);
    break;
   case 'P':
    ShowData_P(game_table1,GameFT,gamount);
    break;
   case 'PR':
    ShowData_PR(game_table1,GameFT,gamount);
     break;
    case 'SX':    
    ShowData_SX();
     break;
     case 'HF':
    ShowData_HF();
   
  }
 
 }
 function ShowDiffOdds()
 {
 
  switch(wtype)
  {
    case 'EVEN':
    ShowDiffOdds_EVEN();
    break;
    case "SP":	
    ShowDiffOdds_V();
    break;
    case 'NA':
    ShowDiffOdds_NA();
    break;
    case 'NO':
    ShowDiffOdds_NO();
    break;  
   case 'SPA':
    ShowDiffOdds_SPA();
    break;
   case 'SPB':	
    ShowDiffOdds_SPB();
    break;
   case 'EO':
    ShowData_EO(game_table,GameFT,gamount);
    break;
   case 'P':
    ShowDiffOdds_P();
    break;
   case 'PR':
    ShowData_PR(game_table1,GameFT,gamount);
    break;
     case 'SX':    
    ShowDiffOdds_SX();
     break;
     case 'HF':
    ShowDiffOdds_HF();
  }
 
 }



 //------陪ボ------ 
 function ShowData_V(show_table,game_table,game_table1)
 {	
	
	with(games_table){
		while(rows.length > 1)
			deleteRow(rows.length-1);
	}
	with(games_table1){
		while(rows.length >= 1)
			deleteRow(rows.length-1);
	}
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
	
	if (num==0) return;
	
	with(games_table)
	{
		for(i=1; i<=10; i++)
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			with(newTR)
			{
				for (j=0; j<=4; j++)
				{
					var nums = 10*j+i;
					num_str = '';
					
					if (nums==50) continue;
					
					if (nums < 10) {
						num_str = '0'+nums.toString();
					}else{
						num_str = nums.toString();
					}
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.id = 'SP'+num_str+'1_bg';
					newTD.background = "images/ball/"+bcolor[ball_color[nums-1]]+".gif";
					newTD.height=27;
					newTD.innerHTML = "<font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">"+num_str+"</font>";
					
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.id = 'SP'+num_str+'2_bg';
					newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sIds[nums-1]+",1,8\" target=\"bbnet_mem_order\"><span id='SP"+num_str+"'>"+sOdds[nums-1]+"</span></a>";
					
				}
			}
		}
		
		newTR = insertRow();
		with(newTR)
		{
			newTD = insertCell();
			newTD.className = 'table_banner';
			newTD.colSpan = 10;
			newTD.innerHTML = "";
		}
	}
	
	with(games_table1)
	{	
		newTR = insertRow();
		newTR.className = 'list_cen';
		
		with(newTR)
		{
			for (j=0; j<=3; j++)
			{
				// if (num==0) break;
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'SP'+type_array[j]+'1_bg';
				newTD.innerHTML = pOddsName[j];
				
				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'SP'+type_array[j]+'2_bg';
				if (j<2)
				   type=1;
				else
				   type=2;
				newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sPds[j]+",1,"+type+"\" target=\"bbnet_mem_order\"><span id='SP"+type_array[j]+"'>"+pOdds[j]+"</span></a>";
			}
		}
		newTR = insertRow();
		newTR.className = 'list_cen';

		with(newTR)
		{
			for (j=4; j<=5; j++)
			{
				// if (num==0) break;
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'SP'+type_array[j]+'1_bg';
				newTD.innerHTML = pOddsName[j];

				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'SP'+type_array[j]+'2_bg';
				newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sPds[j]+",1,3\" target=\"bbnet_mem_order\"><span id='SP"+type_array[j]+"'>"+pOdds[j]+"</span></a>";
			}
		}
		newTR = insertRow();
		newTR.className = 'list_cen';

		with(newTR)
		{
			for (j=6; j<=8; j++)
			{
				// if (num==0) break;
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'SP'+type_array[j]+'1_bg';
				newTD.innerHTML = pOddsName[j];
				
				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'SP'+type_array[j]+'2_bg';
				newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sPds[j]+",1,17\" target=\"bbnet_mem_order\"><span id='SP"+type_array[j]+"'>"+pOdds[j]+"</span></a>";
			}
		}
	}
	
 }//陪ボ虫Α挡
 function ShowDiffOdds_V() //比较
{	
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	
	//if (gNum != main.sgame_num)
	//{
	//	ReloadOdds();
	//	return;
	//}	
	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	
	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;

	for(var i=0;i<=num-1;i++)
	{
	    if (eval("typeof(main.SP01) != 'undefined'"))
	    {
	    	for(var j=0;j<=57;j++)
	    	{
	    		var oddsType = 's';
	    		rnum = j;
	    		
				if (j < 9) {
					num_str = '0'+(j+1).toString();
				}else{
					if (j >48)
					{
						num_str = type_array[j-49];
						rnum = rnum - 49;
						oddsType = 'p';
					}else{
						num_str = (j+1).toString();
					}
				}
				
				if (eval("typeof(main.SP"+num_str+") == 'undefined'")) {
					reload_f = 1;
				}else{
				
					if (eval(oddsType+'Odds['+rnum+'] != main.SP'+num_str+'.innerHTML'))
					{
						eval('main.SP'+num_str+'.innerHTML = '+oddsType+'Odds['+rnum+']');
						eval("main.SP"+num_str+"1_bg.style.backgroundColor='#FFFFAA'");
						eval("main.SP"+num_str+"2_bg.style.backgroundColor='#FFFFAA'");
						// timer.ding_snd.play();
						flag = 1;
						var optadd = new Option('15','SP'+num_str);
						timer.time_list.options[timer.time_list.length] = optadd;
					}
				
					if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}
				}
			}
	   }else{
	        reload_f = 1;
	        continue;
	    }
	}
	
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}
 function ShowData_EVEN()
 {

	if (gID != '') {
		main.gid.value = gID;
	}
	
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	games_table2 = main.document.getElementById('game_table2');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
	
	
	with(games_table){
		while(rows.length > 1)
			deleteRow(rows.length-1);
	}
	with(games_table1){
		while(rows.length >= 1)
			deleteRow(rows.length-1);
	}
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
	
	if (num==0) return;
		
	with(games_table)
	{	
		newTR = insertRow();
		newTR.className = 'list_cen';
		
		with(newTR)
		{
			for (j=0; j<=3; j++)
			{
				// if (num==0) break;
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'SP'+type_array[j]+'1_bg';
				newTD.innerHTML = pOddsName[j];
				
				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'SP'+type_array[j]+'2_bg';
				if (j<2)
				 { newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+pOddsId[j]+",1,1\" target=\"bbnet_mem_order\"><span id='SP"+type_array[j]+"'>"+pOdds[j]+"</span></a>";}
				else
				 { newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+pOddsId[j]+",1,2\" target=\"bbnet_mem_order\"><span id='SP"+type_array[j]+"'>"+pOdds[j]+"</span></a>";}			
				  
			}
		}
		newTR = insertRow();
		newTR.className = 'list_cen';

		with(newTR)
		{
			for (j=4; j<=5; j++)
			{
				// if (num==0) break;
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'SP'+type_array[j]+'1_bg';
				newTD.innerHTML = pOddsName[j];

				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'SP'+type_array[j]+'2_bg';
				newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+pOddsId[j]+",1,3\" target=\"bbnet_mem_order\"><span id='SP"+type_array[j]+"'>"+pOdds[j]+"</span></a>";
			}
		}
	}
	with(games_table1)
	{
		newTR = insertRow();
		newTR.className = 'list_cen';
		with(newTR)
		{
			for (j=0; j<=3; j++)
			{
				// if (num==0) break;
				
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'NA'+type_array2[j]+'1_bg';
				newTD.innerHTML = uOddsName[j];
				
				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'NA'+type_array2[j]+'2_bg';	
				if (j<2)			
				{newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+uOddsId[j]+",1,4\" target=\"bbnet_mem_order\"><span id='NA"+type_array2[j]+"'>"+uOdds[j]+"</span></a>";}
				else
				{newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+uOddsId[j]+",1,5\" target=\"bbnet_mem_order\"><span id='NA"+type_array2[j]+"'>"+uOdds[j]+"</span></a>";}
				
			}
		}
	}
	with(games_table2)
	{
		while(rows.length >= 1)
			deleteRow(rows.length-1);
	}
	with(games_table2)
	{
		for(i=0; i<=3; i++)
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			with(newTR)
			{
				for (j=0; j<=5; j++)
				{
					num_str = '0'+(j+1).toString();
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.width = 37;
					newTD.id = 'NO'+num_str+'_'+type_array2[i]+'1_bg';
					newTD.innerHTML = cOddsName[i];
					
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.id = 'NO'+num_str+'_'+type_array2[i]+'2_bg';
					if (i<2)
					{newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+cOddsId[(j+(i*6))]+",1,6\" target=\"bbnet_mem_order\"><span id='NO"+num_str+"_"+type_array2[i]+"'>"+cOdds[(j+(i*6))]+"</span></a>";}
					else
					{newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+cOddsId[(j+(i*6))]+",1,7\" target=\"bbnet_mem_order\"><span id='NO"+num_str+"_"+type_array2[i]+"'>"+cOdds[(j+(i*6))]+"</span></a>";}
					
					
					
				}
			}
		}
	}
	
 }
 function ShowDiffOdds_EVEN() //比较
{
	
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	
	
	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	
	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;
   
	for(var i=0;i<=num-1;i++)
	{
	    if (eval("typeof(main.SPODD) != 'undefined'"))
	    { 
	    	for(var j=0;j<=5;j++)
	    	{
	    		rnum = j;
					num_str = type_array[j];
					oddsType = 'p';
				//	alert ("SP"+num_str+"1_bg");	
					if (eval(oddsType+'Odds['+rnum+'] != main.SP'+num_str+'.innerHTML'))
					{
						eval('main.SP'+num_str+'.innerHTML = '+oddsType+'Odds['+rnum+']');
						eval("main.SP"+num_str+"1_bg.style.backgroundColor='#FFFFAA'");
						eval("main.SP"+num_str+"2_bg.style.backgroundColor='#FFFFAA'");
						// timer.ding_snd.play();
						flag = 1;
						var optadd = new Option('15','SP'+num_str);
						timer.time_list.options[timer.time_list.length] = optadd;
					}
				
					if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}
			}
	   }else{
	        reload_f = 1;
	        continue;
	    }
	}
		for(var i=0;i<=num-1;i++)
	{
	for(var j=0;j<=3;j++)
	    	{
	    		rnum = j;
					num_str = type_array[j];
					oddsType = 'u';
				if (eval(oddsType+'Odds['+rnum+'] != main.NA'+num_str+'.innerHTML'))
				{
					eval('main.NA'+num_str+'.innerHTML = '+oddsType+'Odds['+rnum+']');
					eval("main.NA"+num_str+"1_bg.style.backgroundColor='#FFFFAA'");
					eval("main.NA"+num_str+"2_bg.style.backgroundColor='#FFFFAA'");
					// timer.ding_snd.play();
					flag = 1;
					var optadd = new Option('15','NA'+num_str);
					timer.time_list.options[timer.time_list.length] = optadd;
				}
				
				if (flag==1)
				{
					timer.ding.innerHTML = "";
					//timer.ding.innerHTML = "<EMBED NAME='ding_snd' src='ding.au' hidden='true' LOOP='False' AUTOSTART='true'></EMBED>";
				}
			}
	   
	}
	for(var i=0;i<=num-1;i++)
	{
	    if (eval("typeof(main.NO01_ODD) != 'undefined'"))
	    {
			for(i=0; i<=3; i++)	{
				for (j=0; j<=5; j++) {
		    		num_str = '0'+(j+1).toString();
		    	//alert ('NO'+num_str+'_'+type_array2[i]);	
					if (eval('cOdds['+(j+(i*6))+'] != main.NO'+num_str+'_'+type_array2[i]+'.innerHTML'))
					{
						eval('main.NO'+num_str+'_'+type_array2[i]+'.innerHTML = cOdds['+(j+(i*6))+']');
						eval("main.NO"+num_str+'_'+type_array2[i]+"1_bg.style.backgroundColor='#FFFFAA'");
						eval("main.NO"+num_str+'_'+type_array2[i]+"2_bg.style.backgroundColor='#FFFFAA'");
						flag = 1;
						var optadd = new Option('15','NO'+num_str+'_'+type_array[i]);
						timer.time_list.options[timer.time_list.length] = optadd;
					}
				}
			}
							
			if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}
			
	   }else{
	   
	        reload_f = 1;
	        continue;
	    }
	}
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}
  function ShowData_NA()
 {
  	if (gID != '') {
		main.gid.value = gID;
	}
	
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
	
	with(games_table)
	{
		while(rows.length > 1)
			deleteRow(rows.length-1);
	}
	
	with(games_table1)
	{
		while(rows.length >= 1)
			deleteRow(rows.length-1);
	}
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
	
	if (num==0) return;
	
	with(games_table)
	{
		for(i=1; i<=10; i++)
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			with(newTR)
			{
				for (j=0; j<=4; j++)
				{
					var nums = 10*j+i;
					num_str = '';
					
					if (nums==50) continue;
					
					if (nums < 10) {
						num_str = '0'+nums.toString();
					}else{
						num_str = nums.toString();
					}
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.id = 'NA'+num_str+'1_bg';
					newTD.background = "images/ball/"+bcolor[ball_color[nums-1]]+".gif";
					newTD.height=27;
					newTD.innerHTML = "<font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">"+num_str+"</font>";
					
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.id = 'NA'+num_str+'2_bg';
					newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sIds[nums-1]+",1,9\" target=\"bbnet_mem_order\"><span id='NA"+num_str+"'>"+sOdds[nums-1]+"</span></a>";
					
				}
			}
		}
		
		newTR = insertRow();
		with(newTR)
		{
			newTD = insertCell();
			newTD.className = 'table_banner';
			newTD.colSpan = 10;
			newTD.innerHTML = "";
		}
	}
	
	with(games_table1)
	{	
		newTR = insertRow();
		newTR.className = 'list_cen';
		
		with(newTR)
		{
			for (j=0; j<=3; j++)
			{
				// if (num==0) break;
				
				newTD = insertCell();
				newTD.className = 'ball_td';
				newTD.id = 'NA'+type_array[j]+'1_bg';
				newTD.innerHTML = pOddsName[j];
				
				newTD = insertCell();
				newTD.className = 'list_cen';
				newTD.width = 60;
				newTD.id = 'NA'+type_array[j]+'2_bg';
				if (j<2)
				  type=4;
				else
				  type=5;
				newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+pOddsId[j]+",1,"+type+"\" target=\"bbnet_mem_order\"><span id='NA"+type_array[j]+"'>"+pOdds[j]+"</span></a>";
			}
		}
	}
 }
 
 function ShowDiffOdds_NA() //比较
{

	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	
	
	
	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;

	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;

	for(var i=0;i<=num-1;i++)
	{
	    if (eval("typeof(main.NA01) != 'undefined'"))
	    {
	    	for(var j=0;j<=52;j++)
	    	{
	    		var oddsType = 's';
	    		rnum = j;
	    		
				if (j < 9) {
					num_str = '0'+(j+1).toString();
				}else{
					if (j >48)
					{
						num_str = type_array[j-49];
						rnum = rnum - 49;
						oddsType = 'p';
					}else{
						num_str = (j+1).toString();
					}
				}
				
				if (eval(oddsType+'Odds['+rnum+'] != main.NA'+num_str+'.innerHTML'))
				{
					eval('main.NA'+num_str+'.innerHTML = '+oddsType+'Odds['+rnum+']');
					eval("main.NA"+num_str+"1_bg.style.backgroundColor='#FFFFAA'");
					eval("main.NA"+num_str+"2_bg.style.backgroundColor='#FFFFAA'");
					// timer.ding_snd.play();
					flag = 1;
					var optadd = new Option('15','NA'+num_str);
					timer.time_list.options[timer.time_list.length] = optadd;
				}
				
				if (flag==1)
				{
					timer.ding.innerHTML = "";
					timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					//timer.ding.innerHTML = "<EMBED NAME='ding_snd' src='ding.au' hidden='true' LOOP='False' AUTOSTART='true'></EMBED>";
				}
			}
	   }else{
	        reload_f = 1;
	        continue;
	    }
	}
	
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}


 function ShowData_NO()
 {
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
	
	with(games_table)
	{
		while(rows.length > 2)
			deleteRow(rows.length-1);
	}
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
	
	if (num==0) return;
	
	with(games_table)
	{
		for(i=0; i<=6; i++)
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			if (i<2)
			  type=6;
			if (i>1&&i<4)
			   type=7;
			if (i>3)
			  type=10;
	
			with(newTR)
			{
				for (j=0; j<=5; j++)
				{
					num_str = '0'+(j+1).toString();
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.height = '27';
					newTD.id = 'NO'+num_str+'_'+type_array[i]+'1_bg';
					newTD.innerHTML = pOddsName[i];
					
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.id = 'NO'+num_str+'_'+type_array[i]+'2_bg';
					newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+pOddsId[(j+(i*6))]+",1,"+type+"\" target=\"bbnet_mem_order\"><span id='NO"+num_str+"_"+type_array[i]+"'>"+pOdds[(j+(i*6))]+"</span></a>";
					
				}
			}
		}
	}
	
 }
 
 function ShowDiffOdds_NO() //比较
{
	
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	
	
	
	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	main.HKTime.innerHTML = HKtime;

	for(var i=0;i<=num-1;i++)
	{
	    if (eval("typeof(main.NO01_ODD) != 'undefined'"))
	    {
			for(i=0; i<=6; i++)	{
				for (j=0; j<=5; j++) {
		    		num_str = '0'+(j+1).toString();
	    		
					if (eval('pOdds['+(j+(i*6))+'] != main.NO'+num_str+'_'+type_array[i]+'.innerHTML'))
					{
						eval('main.NO'+num_str+'_'+type_array[i]+'.innerHTML = pOdds['+(j+(i*6))+']');
						eval("main.NO"+num_str+'_'+type_array[i]+"1_bg.style.backgroundColor='#FFFFAA'");
						eval("main.NO"+num_str+'_'+type_array[i]+"2_bg.style.backgroundColor='#FFFFAA'");
						flag = 1;
						var optadd = new Option('15','NO'+num_str+'_'+type_array[i]);
						timer.time_list.options[timer.time_list.length] = optadd;
					}
				}
			}
							
			if (flag==1)
			{
				timer.ding.innerHTML = "";
				timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
				//timer.ding.innerHTML = "<EMBED NAME='ding_snd' src='ding.au' hidden='true' LOOP='False' AUTOSTART='true'></EMBED>";
			}
			
	   }else{
	        reload_f = 1;
	        continue;
	    }
	}
	
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}

 function ShowData_SPA()
 {
 	if (gID != '') {
		main.gid.value = gID;
	}
	
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
	
	with(games_table){
		while(rows.length > 1)
			deleteRow(rows.length-1);
	}
	with(games_table1){
		while(rows.length >= 1)
			deleteRow(rows.length-1);
	}
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
	
	if (num==0) return;
	var nums = 0;
	
	with(games_table)
	{
		for(i=0;i<12;i+=2) 
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			with(newTR)
			{
				for(j=0;j<=1;j++) 
				{
					var num_str = j+i;
					nums ++;

					newTD = insertCell();
					newTD.className = 'tr_title_set_cen';
					newTD.id = 'SPA'+zoo_array[num_str]+'1_bg';
					newTD.innerHTML = '<font color=black>'+zoo_array_name[num_str]+'</font>';
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.id = 'SPA'+zoo_array[num_str]+'2_bg';
					newTD.innerHTML = zoo_array_nums[num_str];
					
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.id = 'SPA'+zoo_array[num_str]+'3_bg';
					newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sIds[nums-1]+",1,18\" target=\"bbnet_mem_order\"><span id='SPA"+zoo_array[num_str]+"'>"+sOdds[nums-1]+"</span></a>";
					
				}
			}
		}
	}
	
	with(games_table1)
	{	
		if (cOdds[0] !='' && cOdds[1] !='' && cOdds[2] !='') {
			
			newTR = insertRow();
			newTR.className = 'list_cen';
		
			with(newTR)
			{
				for (j=12; j<=14; j++)
				{
				
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.id = 'SPA'+zoo_array[j]+'1_bg';
					newTD.innerHTML = cOddsName[j-12];
				
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.width = 60;
					newTD.id = 'SPA'+zoo_array[j]+'2_bg';
					newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+cOddsId[j-12]+",1,17\" target=\"bbnet_mem_order\"><span id='SPA"+zoo_array[j]+"'>"+cOdds[j-12]+"</span></a>";
				}
			}
		}
	}
	
 }

function ShowDiffOdds_SPA() //比较
{
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	

	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	
	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;

	for(var i=0;i<=num-1;i++)
	{
	    if (eval("typeof(main.SPAA1) != 'undefined'"))
	    {
	    	for(var j=0;j<=14;j++)
	    	{
	    		num_str = zoo_array[j];
	    		var oddsType = 's';
	    		rnum = j;
	    		
				if (j > 11) {
					rnum = rnum - 12;
					oddsType = 'c';
					if (cOdds[0] =='' || cOdds[1] =='' || cOdds[2] =='') continue;
				}
				
				if (eval("typeof(main.SPA"+num_str+") == 'undefined'")) {
					reload_f = 1;
				}else{
				
					if (eval(oddsType+'Odds['+rnum+'] != main.SPA'+num_str+'.innerHTML'))
					{
						eval('main.SPA'+num_str+'.innerHTML = '+oddsType+'Odds['+rnum+']');
						eval("main.SPA"+num_str+"1_bg.style.backgroundColor='#FFFFAA'");
						eval("main.SPA"+num_str+"2_bg.style.backgroundColor='#FFFFAA'");
						if (j<=11) eval("main.SPA"+num_str+"3_bg.style.backgroundColor='#FFFFAA'");
						// timer.ding_snd.play();
						flag = 1;
						var optadd = new Option('15','SPA'+num_str);
						timer.time_list.options[timer.time_list.length] = optadd;
					}
				
					if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
						//timer.ding.innerHTML = "<EMBED src='ding.au' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}
				}
			}
	   }else{
	        reload_f = 1;
	        continue;
	    }
	}
	
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}

 function ShowData_SPB()
 {
 	if (gID != '') {
		main.gid.value = gID;
	}
	
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
	
	with(games_table){
		while(rows.length > 1)
			deleteRow(rows.length-1);
	}
	
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
	
	if (num==0) return;
	var nums = 0;
	
	with(games_table)
	{
		for(i=0;i<12;i+=2) 
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			with(newTR)
			{
				for(j=0;j<=1;j++) 
				{
					var num_str = j+i;
					nums ++;

					newTD = insertCell();
					newTD.className = 'tr_title_set_cen';
					newTD.id = 'SPB'+zoo_array[num_str]+'1_bg';
					newTD.innerHTML = '<font color=black>'+zoo_array_name[num_str]+'</font>';
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					newTD.id = 'SPB'+zoo_array[num_str]+'2_bg';
					newTD.innerHTML = zoo_array_nums[num_str];
					
					newTD = insertCell();
					newTD.className = 'list_cen';
					newTD.id = 'SPB'+zoo_array[num_str]+'3_bg';
					newTD.innerHTML = "<a href=\"betting-entry.aspx?m="+sIds[nums-1]+",1,19\" target=\"bbnet_mem_order\"><span id='SPB"+zoo_array[num_str]+"'>"+sOdds[nums-1]+"</span></a>";
					
				}
			}
		}
	}
	
	
	
 }
 function ShowDiffOdds_SPB() //比较
{
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	

	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	
	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;

	for(var i=0;i<=num-1;i++)
	{
	   if (eval("typeof(main.SPBB1) != 'undefined'"))
	    {
	    	for(var j=0;j<=14;j++)
	    	{
	    		num_str = zoo_array[j];
	    		var oddsType = 's';
	    		rnum = j;
	    		
				if (j > 11) {
					rnum = rnum - 12;
					oddsType = 'c';
					if (cOdds[0] =='' || cOdds[1] =='' || cOdds[2] =='') continue;
				}
				
				if (eval("typeof(main.SPB"+num_str+") == 'undefined'")) {
					reload_f = 1;
				}else{
				
					if (eval(oddsType+'Odds['+rnum+'] != main.SPB'+num_str+'.innerHTML'))
					{
						eval('main.SPB'+num_str+'.innerHTML = '+oddsType+'Odds['+rnum+']');
						eval("main.SPB"+num_str+"1_bg.style.backgroundColor='#FFFFAA'");
						eval("main.SPB"+num_str+"2_bg.style.backgroundColor='#FFFFAA'");
						if (j<=11) eval("main.SPB"+num_str+"3_bg.style.backgroundColor='#FFFFAA'");
						// timer.ding_snd.play();
						flag = 1;
						var optadd = new Option('15','SPA'+num_str);
						timer.time_list.options[timer.time_list.length] = optadd;
					}
				
					if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
						//timer.ding.innerHTML = "<EMBED src='ding.au' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}
				}
			}
	   }else{
	        reload_f = 1;
	        continue;
	    }
	}
	
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}
function ShowData_SX()//六肖
 {
 	if (gID != '') {
		main.gid.value = gID;
	}
	
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;
	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}

}
function ShowDiffOdds_SX() //比较
{
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	

	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	
	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;
	
   if (typeof(main.odds1) != 'undefined')
	    {
	   	        
			if (eval("pOdds[0]!= main.odds1.innerHTML"))
					{
						eval('main.odds1.innerHTML = pOdds[0]');
						eval("main.odds1.style.backgroundColor='#FFFFAA'");
											
						// timer.ding_snd.play();
						flag = 1;
						//var optadd = new Option('15','odds1');
						//timer.time_list.options[timer.time_list.length] = optadd;
					}else
					{
					  eval("main.odds1.style.backgroundColor='#C1D7E5'");
					}
					
				
					if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
						//timer.ding.innerHTML = "<EMBED src='ding.au' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}				
			
	 }else{
	        reload_f = 1;	        
	    }
		
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}

function ShowData_HF()
 {
 	if (gID != '') {
		main.gid.value = gID;
	}
	
	show_table = main.document.getElementById('showTable');
	games_table = main.document.getElementById('game_table');
	games_table1 = main.document.getElementById('game_table1');
	
	main.sgame_num = num;
	main.HKTime.innerHTML = HKtime;
	main.gNumber.innerHTML = gNum;
	main.gametime.innerHTML = gTime;	
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}

}
function ShowDiffOdds_HF() //半波
{
	if (Msg != main.real_Msg.innerHTML && Msg != '')
	{
		main.real_Msg.innerHTML = Msg;
	}
	

	if (main.gNumber.innerHTML != gNum) {
		main.gNumber.innerHTML = gNum;
	}
		
	if (main.gametime.innerHTML != gTime) {
		main.gametime.innerHTML = gTime;
	}
	
	var flag = 0;
	
	if (gID != '') {
		main.gid.value = gID;
	}
	
	main.HKTime.innerHTML = HKtime;


    for(var i=0;i<=num-1;i++)
	{
	   if (eval("typeof(main.odd0) != 'undefined'"))
	    {
	   
	    	      if (eval('pOdds['+i+'] != main.odd'+i+'.innerText'))
					{
					
						eval('main.odds'+i+'.innerText = pOdds['+i+']');
						eval("main.odd"+i+".style.backgroundColor='#FFFFAA'");
						
						// timer.ding_snd.play();
						//flag = 1;
						//var optadd = new Option('15','SPA'+num_str);
						//timer.time_list.options[timer.time_list.length] = optadd;
					}
					else
					{
					eval("main.odd"+i+".style.backgroundColor='#FFFFFF'");
					}
					
	    	if (flag==1)
					{
						timer.ding.innerHTML = "";
						timer.ding.innerHTML = "<EMBED src='ding.swf' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
						//timer.ding.innerHTML = "<EMBED src='ding.au' hidden='true' LOOP='false' AUTOSTART='true'></EMBED>";
					}		
			
	   }else{
	        reload_f = 1;
	       
	    }
	}
	
	if (reload_f == 1)
	{
		ReloadOdds();
	}
}
 