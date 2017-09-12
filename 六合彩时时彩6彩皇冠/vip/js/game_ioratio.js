
var AutoRenewID;
var ChkUserTimerID;
var ChkUserTime = 10;
var ReloadTime = 60;
var TimerID = 0;
function onloads(){
	reloadioratio();
}

function unLoad() {
	clearInterval(AutoRenewID);
}

function ResetTimer() {
	document.getElementById("timer_str").innerHTML = ReloadTime+"&nbsp;"+top.str_second;
	AutoRenewID = setInterval("RenewTimerStr()",1000);
}
function RenewTimerStr() {
	document.getElementById("timer_str").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+top.str_second;
	if ((ReloadTime - TimerID) <= 1) {
		TimerID = 0;
		reloadioratio();
	} else {
		TimerID++;
		var tmp = (ReloadTime - TimerID);
		if (tmp < 10) { tmp = "&nbsp;&nbsp;"+tmp; }
		document.getElementById("timer_str").innerHTML = tmp+"&nbsp;"+top.str_second;
	}
}
function reloadioratio(){
	clearInterval(AutoRenewID);
	TimerID = 0;
	reloadPHP.self.location =o_path;
}
function loadioratio(){
	var gtype =parent.Livegtype;
	if(gtype =="FT"){
		table_loadioratio_FT();
	}else if(gtype =="TN"||gtype =="VB"||gtype =="BK"){
		table_loadioratio();
	}else {
		table_loadioratio_FT();
	}
	
	ResetTimer();
	parent.live_game_heigth();
}


function table_loadioratio_FT(){
	var tmp_table =table_FT.innerHTML;
	var tmp_tr =tr_ioratio.innerHTML;
	var tmp_ior =td_ioratio.innerHTML;
	var gdata="";
	var hgdata="";
	var gtype =parent.Livegtype;
	var MH ='';var MC ='';var MN ='';
	var REH ='';var REC ='';
	var ROUH ='';var ROUC ='';
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	var gamenum =0;
	for (var i = 0; i < GameData.length; i++) {
		
		if(liveTV=="Y"){
			if(gidmstr.indexOf(","+GameData[i][0]+",")== -1)continue;
		}
		gamenum =i+1;
		tmp_table = tmp_table.replace("*LEAGUE*",GameData[i][2]);
		tmp_table = tmp_table.replace("*TEAM*",GameData[i][5]+"<BR>"+GameData[i][6]);
		R_ior  = get_other_ioratio(odd_f_type, GameData[i][9], GameData[i][10] , show_ior);
		OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
		HR_ior = get_other_ioratio(odd_f_type, GameData[i][23], GameData[i][24] , show_ior);
		HOU_ior= get_other_ioratio(odd_f_type, GameData[i][27], GameData[i][28] , show_ior);
		if ((GameData[i][33]*1) <= 0 || (GameData[i][34]*1) <= 0) {
			GameData[i][33]='';
			GameData[i][34]='';
			GameData[i][35]='';
		}
		if ((GameData[i][36]*1) <= 0 || (GameData[i][37]*1) <= 0) {
			GameData[i][36]='';
			GameData[i][37]='';
			GameData[i][38]='';
		}
		gdata += tmp_tr;
		hgdata += tmp_tr;
		MH = ((GameData[i][33]*1) > 0)? '<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,33)+'>'+GameData[i][33]+'</font></A>&nbsp;':'&nbsp' ;
		MC = ((GameData[i][34]*1) > 0)? '<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,34)+'>'+GameData[i][34]+'</font></A>&nbsp;' :'&nbsp';
		MN = ((GameData[i][33]*1) > 0&&(GameData[i][34]*1) > 0&&(GameData[i][35]*1) > 0)? '<A href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rm.php?gid='+GameData[i][0]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+str_even+'\"><font '+checkRatio_font(i,35)+'>'+GameData[i][35]+'</font></A>&nbsp;':'&nbsp';
		REH = tmp_ior;
		REC = tmp_ior;
		ROUH = tmp_ior;
		ROUC = tmp_ior;
		REH = REH.replace("*RATIO*",(GameData[i][7] == 'H')? '<font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</font>':'&nbsp;');
		REC = REC.replace("*RATIO*",(GameData[i][7] == 'C')? '<font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</font>':'&nbsp;');
		REH = REH.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,9)+'>'+R_ior[0]+'</font></a>');
		REC = REC.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,10)+'>'+R_ior[1]+'</font></a>');
		ROUH = ROUH.replace("*RATIO*",'<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>');
		ROUC = ROUC.replace("*RATIO*",'<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>');
		ROUH = ROUH.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strbig+'\"><font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</font></A>&nbsp;');
		ROUC = ROUC.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\'title=\"'+title_strsmall+'\"><font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</font></A>&nbsp;');
		
		gdata =gdata.replace("*MH*",MH);
		gdata =gdata.replace("*MC*",MC);
		gdata =gdata.replace("*MN*",MN);
		gdata =gdata.replace("*REH*",REH);
		gdata =gdata.replace("*REC*",REC);
		gdata =gdata.replace("*ROUH*",ROUH);
		gdata =gdata.replace("*ROUC*",ROUC);
		
		MH = ((GameData[i][36]*1) > 0)?'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,36)+'>'+GameData[i][36]+'</A></font>&nbsp;':'&nbsp';
		MC = ((GameData[i][37]*1) > 0)?'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,37)+'>'+GameData[i][37]+'</A></font>&nbsp;':'&nbsp';
		MN = ((GameData[i][36]*1) > 0&&(GameData[i][37]*1) > 0&&(GameData[i][38]*1) > 0)?'<A href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrm.php?gid='+GameData[i][20]+'&uid='+uid+'&type=N&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+str_even+'\"><font '+checkRatio_font(i,38)+'>'+GameData[i][38]+'</A></font>&nbsp;':'&nbsp';
		REH = tmp_ior;
		REC = tmp_ior;
		ROUH = tmp_ior;
		ROUC = tmp_ior;
		REH = REH.replace("*RATIO*",(GameData[i][21] == 'H')?'<font '+checkRatio_font(i,22)+'>'+GameData[i][22]+'</font>':'&nbsp;');
		REC = REC.replace("*RATIO*",(GameData[i][21] == 'C')?'<font '+checkRatio_font(i,22)+'>'+GameData[i][22]+'</font>':'&nbsp;');
		REH = REH.replace("*IOR*",'<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hre.php?gid='+GameData[i][20]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\'   title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,23)+'>'+HR_ior[0]+'</a>');
		REC = REC.replace("*IOR*",'<a href="javascript:void(0);"  onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hre.php?gid='+GameData[i][20]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\'   title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,24)+'>'+HR_ior[1]+'</a>');
		ROUH = ROUH.replace("*RATIO*",GameData[i][25]);
		ROUC = ROUC.replace("*RATIO*",GameData[i][26]);
		ROUH = ROUH.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrou.php?gid='+GameData[i][20]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strbig+'\"><font '+checkRatio_font(i,28)+'>'+HOU_ior[1]+'</font></A>&nbsp;');
		ROUC = ROUC.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_hrou.php?gid='+GameData[i][20]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strsmall+'\"><font '+checkRatio_font(i,27)+'>'+HOU_ior[0]+'</font></A>&nbsp;');
		hgdata =hgdata.replace("*MH*",MH);
		hgdata =hgdata.replace("*MC*",MC);
		hgdata =hgdata.replace("*MN*",MN);
		hgdata =hgdata.replace("*REH*",REH);
		hgdata =hgdata.replace("*REC*",REC);
		hgdata =hgdata.replace("*ROUH*",ROUH);
		hgdata =hgdata.replace("*ROUC*",ROUC);
	}

	tmp_table = tmp_table.replace("*GAMEDATA*",gdata);
	tmp_table = tmp_table.replace("*HGAMEDATA*",hgdata);
	tmp_table = tmp_table.replace("*SELECT_MEM*",getoddf());
	if(gamenum ==0){
		if( gidmstr=="" ){
		 	right_div.innerHTML =td_none.innerHTML;
		}else{
			right_div.innerHTML =td_nogame.innerHTML;
		}
	}else{	
		right_div.innerHTML =tmp_table;
		odd_f_type =document.getElementById("gameoddf").value ;
	}	

	

}

function table_loadioratio(){
	var gamenum =0;
	var gtype =parent.Livegtype;
	var tmp_table =document.getElementById("table_"+gtype).innerHTML;
	var tmp_tr =tr_ioratio2.innerHTML;
	var tmp_ior =td_ioratio.innerHTML;
	var gdata="";
	var hgdata="";
	var sgdata="";
	var REH ='';var REC ='';
	var ROUH ='';var ROUC ='';
	var R_ior =Array();
	var OU_ior =Array();
	var HR_ior =Array();
	var HOU_ior =Array();
	var gnum ="";
	var tmpgnum ="";
	var tmp ="";
	for (var i = 0; i < GameData.length; i++) {
		if(liveTV=="Y"){
			if(gidmstr.indexOf(","+GameData[i][0]+",")== -1)continue;
		}
		gamenum =i+1;
		if(gnum ==""||GameData[i][3].indexOf(gnum)== -1){
			gnum = GameData[i][3];
		}
		tmpgnum = GameData[i][3].replace(gnum,"");
		tmp_table = tmp_table.replace("*LEAGUE*",GameData[i][2]);
		tmp_table = tmp_table.replace("*TEAM*",GameData[i][5]+"<BR>"+GameData[i][6]);
		R_ior  = get_other_ioratio(odd_f_type, GameData[i][9], GameData[i][10] , show_ior);
		OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
		HR_ior = get_other_ioratio(odd_f_type, GameData[i][23], GameData[i][24] , show_ior);
		HOU_ior= get_other_ioratio(odd_f_type, GameData[i][27], GameData[i][28] , show_ior);
		
		REH = tmp_ior;
		REC = tmp_ior;
		ROUH = tmp_ior;
		ROUC = tmp_ior;
		REH = REH.replace("*RATIO*",(GameData[i][7] == 'H')? '<font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</font>':'&nbsp;');
		REC = REC.replace("*RATIO*",(GameData[i][7] == 'C')? '<font '+checkRatio_font(i,8)+'>'+GameData[i][8]+'</font>':'&nbsp;');
		REH = REH.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][5]+'\"><font '+checkRatio_font(i,9)+'>'+R_ior[0]+'</font></a>');
		REC = REC.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_re.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+GameData[i][6]+'\"><font '+checkRatio_font(i,10)+'>'+R_ior[1]+'</font></a>');
		ROUH = ROUH.replace("*RATIO*",'<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>');
		ROUC = ROUC.replace("*RATIO*",'<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>');
		ROUH = ROUH.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=C&gnum='+GameData[i][4]+'&odd_f_type='+odd_f_type+'\")\' title=\"'+title_strbig+'\"><font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</font></A>&nbsp;');
		ROUC = ROUC.replace("*IOR*",'<a href="javascript:void(0);" onClick=\'gethref(\"../'+gtype+'_order/'+gtype+'_order_rou.php?gid='+GameData[i][0]+'&uid='+uid+'&type=H&gnum='+GameData[i][3]+'&odd_f_type='+odd_f_type+'\")\'title=\"'+title_strsmall+'\"><font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</font></A>&nbsp;');
		tmp = tmp_tr;
		tmp =tmp.replace("*REH*",REH);
		tmp =tmp.replace("*REC*",REC);
		tmp =tmp.replace("*ROUH*",ROUH);
		tmp =tmp.replace("*ROUC*",ROUC);
		if(tmpgnum ==""){
			gdata+=tmp;
		}else if(tmpgnum =="8"){
			hgdata+=tmp;
		}else if(tmpgnum =="9"){
			sgdata+=tmp;
		}
		
	}


	tmp_table = tmp_table.replace("*GAMEDATA*",gdata);
	tmp_table = tmp_table.replace("*HGAMEDATA*",hgdata);
	tmp_table = tmp_table.replace("*SGAMEDATA*",sgdata);
	tmp_table = tmp_table.replace("*SELECT_MEM*",getoddf());
	if(gamenum ==0){
		if( gidmstr=="" ){
                        right_div.innerHTML =td_none.innerHTML;
                }else{
                        right_div.innerHTML =td_nogame.innerHTML;
                }
	}else{	
		right_div.innerHTML =tmp_table;
		odd_f_type =document.getElementById("gameoddf").value ;
	}

	
}


function gethref(tmlURL){
	parent.mem_order.location =tmlURL+"&live=Live";
}


function getoddf(){
	var tmp_opt="";
	var seloddf="";
	for (i = 0; i < Format.length; i++) {
		//沒盤口選擇時，預設為H(香港變盤)
		if((odd_f_str.indexOf(Format[i][0])!=(-1))&&Format[i][2]=="Y"){
			seloddf =(Format[i][0]==odd_f_type)?"selected":"";
			tmp_opt+= "<option value='"+Format[i][0]+"' "+seloddf+">"+Format[i][1]+"</option>\n";
		}
	}
	tmp_opt = "<select id=\"gameoddf\" name=\"gameoddf\" onChange=\"reloadoddf()\" class=\"select\">\n"+tmp_opt+"</select>";
	return tmp_opt; 
	
}



function reloadoddf(){
	odd_f_type =document.getElementById("gameoddf").value ;
	reloadioratio();
}
