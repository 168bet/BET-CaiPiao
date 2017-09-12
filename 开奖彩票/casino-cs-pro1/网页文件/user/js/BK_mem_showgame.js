
 function page_show(){
    //===分頁判斷===//
     if(ShowType=='OU' || ShowType=='RE' || ShowType=='V')
   {
	var page_down_show = body_browse.document.getElementById('page_down');
	var page_up_show = body_browse.document.getElementById('page_up');	
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
  if(loading == 'Y') return;
  obj_msg = body_browse.document.getElementById('real_msg');
obj_msg.innerHTML = '<marquee scrolldelay=\"120\" onMouseOver=\'this.stop()\' onMouseOut=\'this.start()\'><a href=\"announcement-page.aspx\" title=\"\" onMouseEnter=\"marquee_str.style.color=\'#FF0000\'\" onMouseLeave=\"marquee_str.style.color=\'#000000\'\"><div id=\"marquee_str\" style=\'color:#000000;font-weight: normal\'>'+msg+'</div></a></marquee>';
  if(ShowType=='OU' || ShowType=='RE' || ShowType=='V')
  {
   hr_info = body_browse.document.getElementById('hr_info');
   if(retime)
    hr_info.innerHTML = retime;
   
   if(body_browse.ReloadTimeID)
    clearInterval(body_browse.ReloadTimeID);
   if (retime_flag == 'Y')
    body_browse.ReloadTimeID = setInterval("body_browse.reload_var()",retime*1000);  
  }
  game_table = body_browse.document.getElementById('game_table');
  game_table1 = body_browse.document.getElementById('game_table1');
  switch(ShowType)
  {
   case 'OU':
    ShowData_OU(game_table,GameBK,gamount);
    break;
    case 'FU':
    ShowData_FU(game_table,GameBK,gamount);
    break;
   case 'RE':
    ShowData_RE(game_table,GameBK,gamount);
    break;
   case 'V':	
    ShowData_V(game_table,GameBK,gamount);
    break;
   case 'PD':
    ShowData_PD(game_table,GameBK,gamount);
    break;
   case 'F':	
    ShowData_F(game_table,GameBK,gamount);
    break;
   case 'EO':
    ShowData_EO(game_table,GameBK,gamount);
    break;
   case 'P':
    ShowData_P(game_table1,GameBK,gamount);
    break;
   case 'PR':
    ShowData_PR(game_table1,GameBK,gamount);
    break;
  }
 }


 //------上半顯示------ 
 function ShowData_V(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';

  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    if(sel_league!=GameData[i][2] && sel_league)continue;
    //判斷聯盟是否相同不同加一列顯示聯盟
    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.colSpan = 5;
      nowTD.className = 'b_hline';
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.rowSpan = 3;
     nowTD.innerHTML = GameData[i][1]+'<BR>';
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.rowSpan = 2;
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'&nbsp;&nbsp;<BR>'+GameData[i][6];
     //獨贏主隊
     nowTD = insertCell();
     nowTD.innerHTML = '<a href=\"betting-entry.aspx?1x2='+GameData[i][0]+',1\" target=\"mem_order\">'+GameData[i][15]+'</A>';
     //讓球主隊
     nowTD = insertCell();

     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     
     if (GameData[i][9] =='' || GameData[i][10] == '' || eval(GameData[i][9]) ==0 || eval(GameData[i][10]) ==0) {
       tmpStr = '&nbsp;';
     }else {
       if(GameData[i][7] == 'H') //強隊是主隊
         tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
       else  //強隊是客隊
         tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
       	 
	 tmpStr += '<td><a href=\"betting-entry.aspx?ahht=1&m='+GameData[i][0]+',1,AHHT\" target=\"mem_order\">'+GameData[i][9]+'</a></td>'+'</tr></table>';
     }
     nowTD.innerHTML = tmpStr;
     
     //大小盤主隊
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
     nowTD.innerHTML = '&nbsp;';
     }else{  
     nowTD.innerHTML = GameData[i][11]+'&nbsp;&nbsp;&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?ahht=1&m='+GameData[i][0]+',1,OUHT\" target=\"mem_order\">'+GameData[i][13]+'</A>&nbsp;';
     }
    }//主隊TR結束
    
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     //獨贏客隊
     nowTD = insertCell();
     nowTD.innerHTML = '<a href=\"betting-entry.aspx?1x2='+GameData[i][0]+',2\" target=\"mem_order\">'+GameData[i][16]+'</A>';
     //讓球客隊
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     if (GameData[i][9] == '' || GameData[i][10] == '' || eval(GameData[i][9]) == 0 || eval(GameData[i][10]) == 0) {
       tmpStr = '&nbsp;';
     }else {
       if(GameData[i][7] == 'C') //強隊是客隊
         tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
       else  //強隊是主隊
        tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
     
	tmpStr += '<td><a href=\"betting-entry.aspx?ahht=1&m='+GameData[i][0]+',2,AHHT\" target=\"mem_order\">'+GameData[i][10]+'</a></td>'+'</tr></table>';
     }
     nowTD.innerHTML = tmpStr;
     //大小盤客隊
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
     nowTD.innerHTML = '&nbsp;';
     }else{
     nowTD.innerHTML = GameData[i][12]+'&nbsp;&nbsp;&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?ahht=1&m='+GameData[i][0]+',2,OUHT\" target=\"mem_order\">'+GameData[i][14]+'</A>&nbsp;';
    }
    }//客隊TR結束

    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = str_even;
     //獨贏和局
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?1x2='+GameData[i][0]+',x\" target=\"mem_order\">'+GameData[i][17]+'</A>';
     nowTD = insertCell();
     nowTD.colSpan = 2;
     nowTD.innerHTML = '&nbsp';
    }//和局TR結束
    
    nowTR = insertRow();
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.colSpan = 5;
     nowTD.height = 1;
    }//分隔線TR
   }
  }//with(obj_table);
 }//顯示單式結束


 function ShowData_OU(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';
  with(obj_table)
  {
   while(rows.length > 1)
    deleteRow(rows.length-1);
   for(i=pagnum_start; i<pagnum_end; i++)
   {
    if(sel_league!=GameData[i][2] && sel_league)continue;
    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.colSpan = 5;
      nowTD.className = 'b_hline';
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.rowSpan = 3;
     nowTD.innerHTML = GameData[i][1]+'<BR>';
     nowTD = nowTR.insertCell();
     nowTD.rowSpan = 2;
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'&nbsp;&nbsp;<BR>'+GameData[i][6];
     nowTD = insertCell();
     nowTD.innerHTML = '<a href=\"betting-entry.aspx?1x2='+GameData[i][0]+',1\" target=\"mem_order\">'+GameData[i][15]+'</A>';
     nowTD = insertCell();

     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     if (GameData[i][9] =='' || GameData[i][10] == '' || eval(GameData[i][9]) ==0 || eval(GameData[i][10]) ==0) {
       tmpStr = '&nbsp;';
     }else {
       if(GameData[i][7] == 'H')
         tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
       else
         tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
       tmpStr += '<td><a href=\"betting-entry.aspx?m='+GameData[i][0]+',1,AH\" target=\"mem_order\">'+GameData[i][9]+'</a></td>'+
               '</tr></table>';
     }          
     nowTD.innerHTML = tmpStr;
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
       nowTD.innerHTML = '&nbsp;';
     }else{  
       nowTD.innerHTML = GameData[i][11]+'&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?m='+GameData[i][0]+',1,OU\" target=\"mem_order\">&nbsp;&nbsp;'+GameData[i][14]+'</A>&nbsp;';
     }
    }
    
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.innerHTML = '<a href=\"betting-entry.aspx?1x2='+GameData[i][0]+',2\" target=\"mem_order\">'+GameData[i][16]+'</A>';
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     if (GameData[i][9] == '' || GameData[i][10] == '' || eval(GameData[i][9]) == 0 || eval(GameData[i][10]) == 0) {
       tmpStr = '&nbsp;';
     }else {
       if(GameData[i][7] == 'C')
         tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
       else
         tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
     }
     tmpStr += '<td><a href=\"betting-entry.aspx?m='+GameData[i][0]+',2,AH\" target=\"mem_order\">'+GameData[i][10]+'</a></td>'+
               '</tr></table>';
     nowTD.innerHTML = tmpStr;
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
       nowTD.innerHTML = '&nbsp;';
     }else{
       nowTD.innerHTML = GameData[i][12]+'&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?m='+GameData[i][0]+',2,OU\" target=\"mem_order\">&nbsp;&nbsp;'+GameData[i][13]+'</A>&nbsp;';
     } 
    }

    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = str_even;
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?1x2='+GameData[i][0]+',x\" target=\"mem_order\">'+GameData[i][17]+'</A>';
     nowTD = insertCell();
     nowTD.colSpan = 2;
     nowTD.innerHTML = '&nbsp';
    }
    
    nowTR = insertRow();
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.colSpan = 5;
     nowTD.height = 1;
    }
   }
  }
 }
 
  function ShowData_FU(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';
  with(obj_table)
  {
   while(rows.length > 1)
    deleteRow(rows.length-1);
   for(i=pagnum_start; i<pagnum_end; i++)
   {
    if(sel_league!=GameData[i][2] && sel_league)continue;
    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.colSpan = 5;
      nowTD.className = 'b_hline';
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1]+'<BR>';
     nowTD = nowTR.insertCell();
     nowTD.rowSpan = 2;
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'&nbsp;&nbsp;<BR>'+GameData[i][6];
    
     nowTD = insertCell();

     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     if (GameData[i][9] =='' || GameData[i][10] == '' || eval(GameData[i][9]) ==0 || eval(GameData[i][10]) ==0) {
       tmpStr = '&nbsp;';
     }else {
       if(GameData[i][7] == 'H')
         tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
       else
         tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
       tmpStr += '<td><a href=\"betting-entry.aspx?m='+GameData[i][0]+',1,EAH\" target=\"mem_order\">'+GameData[i][9]+'</a></td>'+
               '</tr></table>';
     }          
     nowTD.innerHTML = tmpStr;
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
       nowTD.innerHTML = '&nbsp;';
     }else{  
       nowTD.innerHTML = GameData[i][11]+'&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?m='+GameData[i][0]+',1,EOU\" target=\"mem_order\">&nbsp;&nbsp;'+GameData[i][14]+'</A>&nbsp;';
     }
     nowTD = insertCell();
     nowTD.innerHTML = '&nbsp;';
    }
    
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
   
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     if (GameData[i][9] == '' || GameData[i][10] == '' || eval(GameData[i][9]) == 0 || eval(GameData[i][10]) == 0) {
       tmpStr = '&nbsp;';
     }else {
       if(GameData[i][7] == 'C')
         tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
       else
         tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
     }
     tmpStr += '<td><a href=\"betting-entry.aspx?m='+GameData[i][0]+',2,EAH\" target=\"mem_order\">'+GameData[i][10]+'</a></td>'+
               '</tr></table>';
     nowTD.innerHTML = tmpStr;
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
       nowTD.innerHTML = '&nbsp;';
     }else{
       nowTD.innerHTML = GameData[i][12]+'&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?m='+GameData[i][0]+',2,EOU\" target=\"mem_order\">&nbsp;&nbsp;'+GameData[i][13]+'</A>&nbsp;';
     } 
     nowTD = insertCell();
     nowTD.innerHTML = '&nbsp;';
    }

   
    
    nowTR = insertRow();
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.colSpan = 5;
     nowTD.height = 1;
    }
   }
  }
 }

 function ShowData_RE(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';

  with(obj_table)
  {
   while(rows.length > 1)
    deleteRow(rows.length-1);
   for(i=0; i<data_amount; i++)
   {
   	if(sel_league!=GameData[i][2] && sel_league)continue;
    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.className = 'b_hline';
      nowTD.colSpan = 6;
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][18]+':'+GameData[i][19];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5];
     nowTD = insertCell();
            
     if (GameData[i][9] == '' || GameData[i][10] == '' || eval(GameData[i][9]) == 0 || eval(GameData[i][10]) == 0) {
       tmpStr = '&nbsp;';
     }else {
     	tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     	if(GameData[i][7] == 'H')
      		tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
     	else
      		tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
      	
      	tmpStr += '<td><a href=\"betting-entry.aspx?m='+GameData[i][0]+',1,RAH\" target=\"mem_order\">'+GameData[i][9]+'</a></td>'+
               '</tr></table>';
     }
     
     nowTD.innerHTML = tmpStr;
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
       nowTD.innerHTML = '&nbsp;';
     }else{
     nowTD.innerHTML = GameData[i][11]+'&nbsp;&nbsp;&nbsp;&nbsp;'+
		       '<a href=\"betting-entry.aspx?m='+GameData[i][0]+',1,ROU\" target=\"mem_order\">'+GameData[i][14]+'</a>&nbsp;';
	 }
	 
     //滾球單雙
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][21]=='' || GameData[i][23]=='' || eval(GameData[i][21])==0 || eval(GameData[i][23])==0) {
       	nowTD.innerHTML = '&nbsp;';  
     }else{
     	nowTD.innerHTML = GameData[i][20]+'&nbsp;&nbsp;&nbsp;&nbsp;<A href=\"betting-entry.aspx?m='+GameData[i][0]+',1,ROE\" target=\"mem_order\">'+GameData[i][21]+'</A>';  
     }
     
	}
    
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][6];
     nowTD = insertCell();
     
     if (GameData[i][9] == '' || GameData[i][10] == '' || eval(GameData[i][9]) == 0 || eval(GameData[i][10]) == 0) {
       tmpStr = '&nbsp;';
     }else {
     	tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
     	if(GameData[i][7] == 'C')
      		tmpStr += '<tr><td align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
     	else
      		tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp</td>';
      	
     		tmpStr += '<td><a href=\"betting-entry.aspx?m='+GameData[i][0]+',2,RAH\" target=\"mem_order\">'+GameData[i][10]+'</a></td>'+
            		   '</tr></table>';
     }
     nowTD.innerHTML = tmpStr;
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][14]=='' || GameData[i][13]=='' || eval(GameData[i][14])==0 || eval(GameData[i][13])==0) {
       nowTD.innerHTML = '&nbsp;';
     }else{
       nowTD.innerHTML = GameData[i][12]+'&nbsp;&nbsp;&nbsp;&nbsp;'+
		       '<A href=\"betting-entry.aspx?m='+GameData[i][0]+',2,ROU\" target=\"mem_order\">'+GameData[i][13]+'</A>&nbsp;';
     }    
     //滾球單雙
     nowTD = insertCell();
     nowTD.align = 'right';
     if (GameData[i][21]=='' || GameData[i][23]=='' || eval(GameData[i][21])==0 || eval(GameData[i][23])==0 ) {
       	nowTD.innerHTML = '&nbsp;';  
     }else{
     	nowTD.innerHTML = GameData[i][22]+'&nbsp;&nbsp;&nbsp;&nbsp;<A href=\"betting-entry.aspx?m='+GameData[i][0]+',2,ROE\" target=\"mem_order\">'+GameData[i][23]+'</A>';  
     }
    }

    nowTR = insertRow();
    with(nowTR)
    {
     nowTD = insertCell();
    // nowTD.colSpan = 5;
     nowTD.colSpan = 6;
     nowTD.height = 1;
    }
   }
  }
 }
 function ShowData_PD(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';

  with(obj_table)
  {
   while(rows.length > 1)
    deleteRow(rows.length-1);
   for(i=0; i<data_amount; i++)
   {
   if(sel_league!=GameData[i][2] && sel_league)continue;
    flag = false;
    for(j=8; j<=34; j++)
     if(GameData[i][j] == '')
     { flag=true; break; }
    if(flag) continue

    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.colSpan = 18;
      nowTD.className = 'b_hline';
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5];
     nowTD = insertCell(); 
     if(GameData[i][8]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,1_0" target=\"mem_order\">'+GameData[i][8]+'</A>';     	
     }else{
     	nowTD.innerHTML = '';     	     
     }
     nowTD = insertCell();      
     if(GameData[i][9]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,2_0\" target=\"mem_order\">'+GameData[i][9]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }     
     nowTD = insertCell();      
     if(GameData[i][10]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,2_1\" target=\"mem_order\">'+GameData[i][10]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }  
     nowTD = insertCell(); 
     if(GameData[i][11]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,3_0\" target=\"mem_order\">'+GameData[i][11]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     } 
     nowTD = insertCell(); 
     if(GameData[i][12]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,3_1\" target=\"mem_order\">'+GameData[i][12]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     } 
     nowTD = insertCell(); 
     if(GameData[i][13]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,3_2\" target=\"mem_order\">'+GameData[i][13]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }      
     nowTD = insertCell(); 
     if(GameData[i][14]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,4_0\" target=\"mem_order\">'+GameData[i][14]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][15]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,4_1\" target=\"mem_order\">'+GameData[i][15]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][16]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,4_2\" target=\"mem_order\">'+GameData[i][16]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                
     nowTD = insertCell(); 
     if(GameData[i][17]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,4_3\" target=\"mem_order\">'+GameData[i][17]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                     
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
     if(GameData[i][18]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',d,0_0\" target=\"mem_order\">'+GameData[i][18]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                          
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
     if(GameData[i][19]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',d,1_1\" target=\"mem_order\">'+GameData[i][19]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                               
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
     if(GameData[i][20]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',d,2_2\" target=\"mem_order\">'+GameData[i][20]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                                    
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
     if(GameData[i][21]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',d,3_3\" target=\"mem_order\">'+GameData[i][21]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                                         
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
     if(GameData[i][22]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',d,4_4\" target=\"mem_order\">'+GameData[i][22]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                                              
     nowTD = insertCell();  
     if(GameData[i][23]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',h,up5\" target=\"mem_order\">'+GameData[i][23]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                                                   

    }    
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][6];
     nowTD = insertCell(); 
     if(GameData[i][24]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,1_0\" target=\"mem_order\">'+GameData[i][24]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][25]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,2_0\" target=\"mem_order\">'+GameData[i][25]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][26]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,2_1\" target=\"mem_order\">'+GameData[i][26]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][27]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,3_0\" target=\"mem_order\">'+GameData[i][27]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][28]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,3_1\" target=\"mem_order\">'+GameData[i][28]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][29]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,3_2\" target=\"mem_order\">'+GameData[i][29]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                
     nowTD = insertCell();      
     if(GameData[i][30]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,4_0\" target=\"mem_order\">'+GameData[i][30]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][31]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,4_1\" target=\"mem_order\">'+GameData[i][31]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           

     nowTD = insertCell(); 
     if(GameData[i][32]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,4_2\" target=\"mem_order\">'+GameData[i][32]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           
     nowTD = insertCell(); 
     if(GameData[i][33]!="0"){
	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,4_3\" target=\"mem_order\">'+GameData[i][33]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }                
     nowTD = insertCell();  
     if(GameData[i][34]!="0"){
     	nowTD.innerHTML = '<a href=\"betting-entry.aspx?cs='+GameData[i][0]+',a,up5\" target=\"mem_order\">'+GameData[i][34]+'</A>';
     }else{
     	nowTD.innerHTML = '';     	     
     }           

    }
    nowTR = insertRow();
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.colSpan = 18;
     nowTD.height = 1;
    }
   }
  }
 }

 function ShowData_EO(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';

  with(obj_table)
  {
   while(rows.length > 1)
    deleteRow(rows.length-1);
   for(i=0; i<data_amount; i++)
   {
    if(!(GameData[i][8]&&GameData[i][9]) && !(GameData[i][10]&&GameData[i][11]&&GameData[i][12]&&GameData[i][13]))
     continue;
   if(sel_league!=GameData[i][2] && sel_league)continue;
    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.colSpan = 8;
      nowTD.className = 'b_hline';
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?oe=1&m='+GameData[i][0]+',1,OE\" target=\"mem_order\">'+GameData[i][8]+'</A>';
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?oe=1&m='+GameData[i][0]+',2,OE\" target=\"mem_order\">'+GameData[i][9]+'</A>';
     
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?tg='+GameData[i][0]+',01\" target=\"mem_order\">'+GameData[i][10]+'</A>';
     
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?tg='+GameData[i][0]+',23\" target=\"mem_order\">'+GameData[i][11]+'</A>';
     
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?tg='+GameData[i][0]+',456\" target=\"mem_order\">'+GameData[i][12]+'</A>';
     
     nowTD = insertCell();
     nowTD.innerHTML = '<A href=\"betting-entry.aspx?tg='+GameData[i][0]+',7\" target=\"mem_order\">'+GameData[i][13]+'</A>';
    }
   }
  }
 }
 
 function ShowData_F(obj_table,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';

  with(obj_table)
  {
  
   while(rows.length > 1)
    deleteRow(rows.length-1);
  
   for(i=0; i<data_amount; i++)
   {
    if(sel_league!=GameData[i][2] && sel_league)continue;
 
    flag = false;
    for(j=8; j<=16; j++)
     if(GameData[i][j] == '')
     { flag=true; break; }
    if(flag) continue
  
    gdate = GameData[i][1].substr(0,5);
    if(nowLeague != GameData[i][2] || nowDate != gdate)
    {
     nowLeague = GameData[i][2];
     nowDate = gdate;
     nowTR = insertRow();
     with(nowTR)
     {
      nowTD = insertCell();
      nowTD.colSpan = 11;
      nowTD.className = 'b_hline';
      nowTD.innerHTML = GameData[i][2];
     }
    }
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
   
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
    
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5];
   
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][8]!=0){	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',hh\" target=\"mem_order\">'+GameData[i][8]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][9]!=0){	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',hd\" target=\"mem_order\">'+GameData[i][9]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][10]!=0){	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',ha\" target=\"mem_order\">'+GameData[i][10]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][11]!=0){	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',dh\" target=\"mem_order\">'+GameData[i][11]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][12]!=0){	 	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',dd\" target=\"mem_order\">'+GameData[i][12]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][13]!=0){	 	 	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',da\" target=\"mem_order\">'+GameData[i][13]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][14]!=0){	 	 	 	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',ah\" target=\"mem_order\">'+GameData[i][14]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][15]!=0){	 	 	 	 	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',ad\" target=\"mem_order\">'+GameData[i][15]+'</A>';
	 }
     nowTD = insertCell(); 
     nowTD.rowSpan = 2;
	 if(GameData[i][16]!=0){	 	 	 	 	 	 	 	 
	     nowTD.innerHTML = '<a href=\"betting-entry.aspx?ht='+GameData[i][0]+',aa\" target=\"mem_order\">'+GameData[i][16]+'</A>';
	 }
    }
    
    nowTR = insertRow();
    nowTR.className = 'b_cen';
    with(nowTR)
    {
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][6];
    }
    nowTR = insertRow();
    with(nowTR)
    {
     nowTD = insertCell();
     nowTD.colSpan = 11;
     nowTD.height = 1;
    }
   }
  }
 }


 function ShowData_P(obj_div,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';
  var showDate = '';
  var firstFlag = 1;

  gcount = 0;
  gc = 0;
  obj_div.innerHTML = "";
  for(i=0; i<data_amount; i++)
  {
   if(GameData[i][8]=='' || GameData[i][9]=='' || GameData[i][10]=='')
   {
    gc++;
    continue;
   }
    if(sel_league!=GameData[i][2] && sel_league)continue;
   
   gdate = GameData[i][1].substr(0,5);
   if(nowLeague != GameData[i][2] || nowDate != gdate)
   {
    if(nowDate != gdate)
    {
     if(!firstFlag)
     {
      nowTR = obj_table.insertRow();
      nowTR .bgColor = '#FFFFFF';
      nowTR.align = 'center';
      nowTR.height = 30;
      nowTD = nowTR.insertCell();
      nowTD.colSpan = 6;
      if(gcount > 1)
      {
       nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"teamcount\" VALUE=\"'+gcount+'\">'+
                         '<INPUT TYPE=\"HIDDEN\" NAME=\"active\" VALUE=\"1\">'+
                         '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
                         '<input type=SUBMIT name=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"za_button\">&nbsp;&nbsp;&nbsp;';
      }
      nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"za_button\" onClick=\"parent.ShowGameList();\">';
     }
     firstFlag = 0;
     nowDate = gdate;
     showDate = gdate.substr(0,2)+''+gdate.substr(3,2);
     gcount = 0;
     obj_div.innerHTML += '<TABLE ID=\"gtable'+showDate+'\" width=\"524\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"b_tab\">'+
                          '<TR><TD><FORM ID=\"form'+showDate+'\" NAME=\"form'+showDate+'\" ACTION=\"betting-entry.aspx\" METHOD=POST onSubmit=\" reload_var();\" target=\"mem_order\"></TD></TR>'+
                          '</TABLE></FORM>';
     obj_table = body_browse.document.getElementById('gtable'+showDate);
    }

    nowLeague = GameData[i][2];
    nowTR = obj_table.insertRow();
    nowTD = nowTR.insertCell();
    nowTD.className = 'b_hline';
    nowTD.colSpan = 8;
    nowTD.innerHTML = GameData[i][2]+'&nbsp;&nbsp;'+nowDate;
   }

   gcount++;
   nowTR = obj_table.insertRow();
   nowTR.className = 'b_cen';
   with(nowTR)
   {
    nowTD = insertCell();
    nowTD.align = 'center';
    nowTD.width = 40;
    nowTD.innerHTML = '<INPUT type=\"HIDDEN\" NAME=\"game_id'+gcount+'\" VALUE=\"'+GameData[i][0]+'\">'+GameData[i][1].slice(-6,15);
    
    nowTD = nowTR.insertCell();
    nowTD.width = 159;
    nowTD.innerHTML = GameData[i][5];
    
    nowTD = insertCell();
    nowTD.className = 'b_radio';    
    nowTD.width = 55;
    nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"1\" class=\"za_dot\">&nbsp;<b><font color=\"#006600\">'+GameData[i][8]+'</font></b>';
    
    nowTD = insertCell();
    nowTD.className = 'b_pradio';   
    nowTD.width = 56;
    nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"x\" class=\"za_dot\">&nbsp;<b><font color=\"#CC0000\">'+GameData[i][10]+'</font></b>';
    
    nowTD = insertCell();
    nowTD.className = 'b_radio';   
    nowTD.width = 55;
    nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"2\" class=\"za_dot\">&nbsp;<b><font color=\"#006600\">'+GameData[i][9]+'</font></b>';
    
    nowTD = insertCell();
    nowTD.width = 159;
    nowTD.innerHTML = GameData[i][6];
   }
  }
  
  if((data_amount-gc)!=0)
  {
   nowTR = obj_table.insertRow();
   nowTR .bgColor = '#FFFFFF';
   nowTR.align = 'center';
   nowTR.height = 30;
   nowTD = nowTR.insertCell();
   nowTD.colSpan = 6;
   if(gcount > 1)
   {
    nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"req_matchlist\" VALUE=\"'+gcount+'\">'+
                      '<INPUT TYPE=\"HIDDEN\" NAME=\"action\" VALUE=\"kygl1x2parlay\">'+
                      '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
                      '<input type=SUBMIT name=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"za_button\">&nbsp;&nbsp;&nbsp;';
   }
   nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"za_button\" onClick=\"parent.ShowGameList();\">';
  }
 }

 function ShowData_PR(obj_div,GameData,data_amount)
 {
  var nowLeague = '';
  var nowDate = '';
  var firstFlag = 1;

  gcount = 0;
  gc = 0;
  
  obj_div.innerHTML = "";
  
  for(i=0; i<data_amount; i++)
  {
   if(GameData[i][9]=='' || GameData[i][10]=='')
   {
    gc++;
    continue;
   }
    if(sel_league!=GameData[i][2] && sel_league)continue;
   
   gdate = GameData[i][1].substr(0,5);
   if(nowLeague != GameData[i][2] || nowDate != gdate)
   {
    if(nowDate != gdate)
    {
     if(!firstFlag)
     {
      nowTR = obj_table.insertRow();
      nowTR .bgColor = '#FFFFFF';
      nowTR.align = 'center';
      nowTR.height = 30;
      nowTD = nowTR.insertCell();
      nowTD.colSpan = 6;
      if(gcount > 1)
      {
       nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"teamcount\" VALUE=\"'+gcount+'\">'+
                         '<INPUT TYPE=\"HIDDEN\" NAME=\"active\" VALUE=\"1\">'+
                         '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
                         '<input type=SUBMIT name=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"za_button\">&nbsp;&nbsp;&nbsp;';
      }
      nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"za_button\" onClick=\"parent.ShowGameList();\">';
     }
     firstFlag = 0;
     nowDate = gdate;
     showDate = gdate.substr(0,2)+''+gdate.substr(3,2);
     gcount = 0;
     obj_div.innerHTML += '<TABLE ID=\"gtable'+showDate+'\" width=\"524\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"b_tab\">'+
                          '<TR><TD><FORM ID=\"form'+showDate+'\" NAME=\"form'+showDate+'\" ACTION=\"betting-entry.aspx\" METHOD=POST onSubmit=\" reload_var();\" target=\"mem_order\"></TD></TR>'+
                          '</TABLE></FORM>';
     obj_table = body_browse.document.getElementById('gtable'+showDate);
    }

    nowLeague = GameData[i][2];
    nowTR = obj_table.insertRow();
    nowTD = nowTR.insertCell();
    nowTD.className = 'b_hline';
    nowTD.colSpan = 8;
    nowTD.innerHTML = GameData[i][2]+'&nbsp;&nbsp;'+nowDate;
   }

   gcount++;
   nowTR = obj_table.insertRow();
   nowTR.className = 'b_cen';
   with(nowTR)
   {
    nowTD = insertCell();
    nowTD.width = 40;
    nowTD.innerHTML = '<INPUT type=\"HIDDEN\" NAME=\"game_id'+gcount+'\" VALUE=\"'+GameData[i][0]+'\">'+GameData[i][1].slice(-6,15);
    if(GameData[i][7] == 'H')  
    {
     
     nowTD = nowTR.insertCell();
     nowTD.width = 159;
     nowTD.innerHTML = GameData[i][5];
     
     nowTD = insertCell();
     nowTD.className = 'b_radio';
     nowTD.width = 55;
     nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"AH_H\" class=\"za_dot\">&nbsp;<b><font color=\"#006600\">'+GameData[i][9]+'</font></b>';
    }
    else  
    {
     
     nowTD = nowTR.insertCell();
     nowTD.width = 159;
     nowTD.innerHTML = GameData[i][6];
     
     nowTD = insertCell();
     nowTD.className = 'b_radio';
     nowTD.width = 55;
     nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"AH_C\" class=\"za_dot\">&nbsp;<b><font color=\"#006600\">'+GameData[i][10]+'</font></b>';
    }
    
    nowTD = insertCell();
    nowTD.width = 56;
    nowTD.innerHTML = '<b><font color=\"#CC0000\">'+GameData[i][8]+'</font></b>';
    
    if(GameData[i][7] == 'H')  
    {
     nowTD = insertCell();
     nowTD.className = 'b_radio';
     nowTD.width = 55;
     nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"AH_H\" class=\"za_dot\">&nbsp;<b><font color=\"#006600\">'+GameData[i][10]+'</font></b>';
     
     nowTD = insertCell();
     nowTD.width = 159;
     nowTD.innerHTML = GameData[i][6];
    }
    else
    {
     nowTD = insertCell();
     nowTD.className = 'b_radio';
     nowTD.width = 55;
     nowTD.innerHTML = '<input type=\"radio\" name=\"fr_'+GameData[i][0]+'\" value=\"AH_C\" class=\"za_dot_01\">&nbsp;<b><font color=\"#006600\">'+GameData[i][9]+'</font></b>';
     
     nowTD = insertCell();
     nowTD.width = 159;
     nowTD.innerHTML = GameData[i][5];
    }
   }
  }
  
  if((data_amount-gc)!=0)
  {
   nowTR = obj_table.insertRow();
   nowTR .bgColor = '#FFFFFF';
   nowTR.align = 'center';
   nowTR.height = 30;
   nowTD = nowTR.insertCell();
   nowTD.colSpan = 6;
   if(gcount > 1)
   {
    nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"req_ahmatchlist\" VALUE=\"'+gcount+'\">'+
                      '<INPUT TYPE=\"HIDDEN\" NAME=\"action\" VALUE=\"kyglahparlay\">'+
                      '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
                      '<input type=SUBMIT name=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"za_button\">&nbsp;&nbsp;&nbsp;';
   }
   nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"za_button\" onClick=\"parent.ShowGameList();\">';
  }
 }
