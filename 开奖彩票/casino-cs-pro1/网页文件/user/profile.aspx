<%@ Page language="c#" Codebehind="profile.aspx.cs" AutoEventWireup="false" Inherits="newball.user.profile" codePage="936"%>


<html>
<head>
<title>mem_data</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
<script language="javascript">
function Go_Chg_pass(){
  window.open("password.aspx","Chg_pass","top=300,left=300,width=255,height=135,status=no");
}
		</script>
</head>

<SCRIPT LANGUAGE="JAVASCRIPT">
if(self == top) location = '/';
</SCRIPT>

<body bgcolor="#000000" leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false">

<FORM NAME="LAYOUTFORM" ACTION="mem_data_act.php" METHOD=POST>
<input type="hidden" name="plays" value="go">


<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top" bgcolor="#E5EAEE" align="center"> 
      <table width="96%" height="96" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="100%" colspan="3">
            <TABLE cellSpacing=1 cellPadding=0 width=500 border=0>
              <TBODY>
                <TR> 
                  <TD><table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height=5></td>
  </tr>
  <tr>
    <td><table width=100% border=0 align="left" cellpadding=2 cellspacing=0>
      <tbody>
        <tr>
          <td width=99% class=td_02 bgcolor="#CCCCCC"><font size=2>
            <marquee scrolldelay=120 class="td_02">
            <span id="Msg"><%# msg %></span>
            </marquee>
          </font>
          </td>
        </tr>
      </tbody>
    </table>
    </td>
  </tr>
  <tr>
    <td height=5></td>
  </tr>
</table>      
</TD>
                </TR>
              </TBODY>
              <TBODY>
                <TR> 
                  <TD height=20>
                  <table class=table_banner cellSpacing=0 cellPadding=0 width="500" border=0>
                    <tr>
                    <td>
                    <TABLE class=banner_set height=24 cellSpacing=0 cellPadding=0 width="100%" border=0>
                      <TBODY>
                        <tr>				
				<td width="107">会员资料</td>
				<td ><input type="button" name="Submit3232" value="修改密码" class="za_button" onClick="Go_Chg_pass();">
				</td>				
			</tr>
                      </TBODY>
                    </TABLE>
                      </td>
                    </tr>
                  </table>
                    </TD>
                </TR>
              </TBODY>
            </TABLE>
            <br>
            <TABLE id="TABLE1" runat="server" border=1 style="WIDTH: 500px; HEIGHT: 139px">
				<TBODY>
					<TR >
						<TH width="55" style="WIDTH: 55px" class=list_lef>
							会员帐号</TH>
						<TD width="115" style='TEXT-ALIGN: left; ALIGN: center'><FONT face="宋体" style="TEXT-ALIGN: left"></FONT></TD>
					</TR>
					<TR >
						<TH style="WIDTH: 55px" class=list_lef>
							会员名称</TH>
						<TD style='TEXT-ALIGN: left; ALIGN: center'><FONT face="宋体"></FONT></TD>
					</TR>
					<TR >
						<TH style="WIDTH: 55px" class=list_lef>
							水位盘口</TH>
						<TD align="left" style="TEXT-ALIGN: left"><div align="left"><FONT face="宋体"></FONT></div>
						</TD>
					</TR>
					<TR >
						<TH style="WIDTH: 55px" class=list_lef>
							现金,信用</TH>
						<TD align="left" style="TEXT-ALIGN: left"><div align="left"><FONT face="宋体"></FONT></div>
						</TD>
					</TR>
					<TR >
						<TH style="WIDTH: 55px" class=list_lef>
							信用额度</TH>
						<TD style="TEXT-ALIGN: left"><div align="left"><FONT face="宋体"></FONT></div>
						</TD>
					</TR>
					<TR >
						<TH style="WIDTH: 55px" class=list_lef>
							信用馀额</TH>
						<TD align="left" style="TEXT-ALIGN: left"><div align="left"><FONT face="宋体"></FONT></div>
						</TD>
					</TR>
				</TBODY>
			</TABLE>
            <br>
            <TABLE width="500" border=1 align="left" id="TABLE2" runat="server">
              <TBODY>
                <TR> 
                  <TD colSpan=4 align="center" class=list_lef>六合彩</TD>
                </TR>
                <TR align=middle> 
                  <TD bgColor=#E0CA86 width="127">
                    <div align="center"><FONT width="33%">项目</FONT></div>
                  </TD>
				  <TD bgColor=#E0CA86>
                    <div align="center">退水设定 W/L</div></TD>
                  <TD style="TEXT-ALIGN: center" bgColor=#E0CA86> 单项(号)限额
                  </TD>
                  <td bgColor=#E0CA86>
                    <div align="center">单注限额</div>
                  </td>
                </TR>
				 <TR> 
                  <TD class=list_lef>特别号</TD>
				  <TD align="right">13</TD>
				
                  <TD align="right">20000</TD>
                  <TD align="right">20000</TD>
                </TR>
				<TR> 
                  <TD class=list_lef>特别号单双</TD>
				   <TD align="right">2.5</TD>
				
                  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>特别号大小</TD>
				  <TD align="right">2.5</TD>
			
                  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>特别号合数单双</TD>
				  <TD align="right">2</TD>
			
                  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>

                <TR> 
                  <TD class=list_lef>正码</TD>
				  <TD align="right">11.5</TD>
				
                  <TD align="right">100000</TD>
                  <TD align="right">10000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>总和单双</TD>
				   <TD align="right">1.75</TD>
			
                  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>
               <TR> 
                  <TD class=list_lef>总和大小</TD>
				  <TD align="right">1.75</TD>
				
                  <TD align="right">200000</TD>
                  <TD align="right">50000   </TD> </TR>
				
                <TR> 
                  <TD class=list_lef>二全中</TD>
				  <TD align="right">15</TD>
				
                  <TD align="right">30000</TD>
                  <TD align="right">3000</TD>
                </TR>

                <TR> 
                  <TD class=list_lef>三全中</TD>
				  <TD align="right">15</TD>
				
                  <TD align="right">30000</TD>
                  <TD align="right">3000</TD>
                </TR>

				 <TR> 
                  <TD class=list_lef>三中二</TD>
				  <TD align="right">15</TD>
				
                  <TD align="right">30000</TD>
                  <TD align="right">3000</TD>
                </TR>
				
				 <TR> 
                  <TD class=list_lef>二中特</TD>
				  <TD align="right">15</TD>
			
                  <TD align="right">30000</TD>
                  <TD align="right">3000</TD>
                </TR>
				
				 <TR> 
                  <TD class=list_lef>特串</TD>
				  <TD align="right">15</TD>
		
                  <TD align="right">30000</TD>
                  <TD align="right">3000</TD>
                </TR>
				
                <TR> 
                  <TD class=list_lef>正码过关</TD>
				  <TD align="right">12</TD>
			
                  <TD align="right">30000</TD>
                  <TD align="right">3000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>色波</TD>
				  <TD align="right">2</TD>
			
                  <TD align="right">100000</TD>
                  <TD align="right">10000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>生肖</TD>
				  <TD align="right">10</TD>
			
                  <TD align="right">100000</TD>
                  <TD align="right">10000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>正码1-6单双</TD>
                  <TD align="right">1.75</TD>
			
				  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>正码1-6大小</TD>
				  <TD align="right">1.75</TD>
			
                  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>正码1-6色波</TD>
				  <TD align="right">2</TD>
		
                  <TD align="right">100000</TD>
                  <TD align="right">10000</TD>
                </TR>
				
				<TR> 
                  <TD class=list_lef>一肖</TD>
				  <TD align="right">1.75</TD>
		
                  <TD align="right">200000</TD>
                  <TD align="right">50000</TD>
                </TR>

				<TR>
				  <TD class=list_lef>六肖</TD>
				  <TD align="right">1.75</TD>
				  <TD align="right">200000</TD>
				  <TD align="right">50000</TD>
				</TR>

              </TBODY>
            </TABLE>
                    </td>
        </tr>
      </table>
      <table><tr><td align=center><%# System.Configuration.ConfigurationSettings.AppSettings["CopyRight"] %></td></tr></table>
              
      
    </td>
  </tr>
</table>
</body>
</html>