namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Configuration;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class body_browse : Page
    {
        public string kygltable = "";
        public string quickinput;
        public string quickinput2 = "";
        public string rtype = "";
        public int sgame_num;

        private void ErrorContent()
        {
            MyFunc.goToLoginPage();
        }

        private void fContent()
        {
            this.kygltable = "   <TR>   <TD colSpan=2> <TABLE width=100% border=0 cellspacing=1 cellpadding=0 id=game_table>";
            this.kygltable = this.kygltable + "        <tr class=tr_title_set_cen> <td width=50>十二生肖</td>  <td width=130>号码</td> <td>赔率</td>";
            this.kygltable = this.kygltable + "        <td width=50>十二生肖</td><td width=130>号码</td> <td>赔率</td> </tr> </TABLE></TD> </TR>";
            this.kygltable = this.kygltable + "\t\t\t  <tr>  <td height=10 colspan=2>&nbsp;</td> </tr>";
            this.kygltable = this.kygltable + "    <TR> <TD colSpan=2> <table width=100% border=0 cellspacing=1 cellpadding=0 id=game_table1>";
            this.kygltable = this.kygltable + "  <tr class=tr_title_set_cen><td width=100>色波</td><td>赔率</td><td width=100>色波</td> ";
            this.kygltable = this.kygltable + "<td>赔率</td> <td width=100>色波</td><td>赔率</td>  </tr> </table></TD> </TR> ";
        }

        private void futureContent()
        {
            this.kygltable = " <TR> <TD colSpan=2> <TABLE width=100% border=0 cellspacing=1 cellpadding=0 id=game_table>";
            this.kygltable = this.kygltable + "     <TR class=tr_title_set_cen> <td colspan=2>正码一</td> <td colspan=2>正码二</td>  <td colspan=2>正码三</td>";
            this.kygltable = this.kygltable + "       <td colspan=2>正码四</td>  <td colspan=2>正码五</td> <td colspan=2>正码六</td></TR>";
            this.kygltable = this.kygltable + "     <tr class=list_cen> <td class=ball_td>号码</td>  <td class=list_cen width=40>赔率</td>";
            this.kygltable = this.kygltable + "       <td class=ball_td>号码</td> <td class=list_cen width=40>赔率</td> <td class=ball_td>号码</td>";
            this.kygltable = this.kygltable + "     <td class=list_cen width=40>赔率</td> <td class=ball_td>号码</td> <td class=list_cen width=40>赔率</td>";
            this.kygltable = this.kygltable + "      <td class=ball_td>号码</td>  <td class=list_cen width=40>赔率</td>   <td class=ball_td>号码</td>";
            this.kygltable = this.kygltable + "         <td class=list_cen width=40>赔率</td>   </tr> </TABLE>  </TD> </TR>";
        }

        private void hfContent()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE tztype=21 ORDER BY id asc");
            string[] textArray = new string[12];
            int num = 0;
            while (reader.Read())
            {
                textArray[num++] = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
            }
            reader.Close();
            base2.Dispose();
            this.kygltable = "<tr>  <td height=\"100%\" colspan=\"3\"> <table border='0' cellpadding='0' cellspacing='1' align='bbnet_mem_order' width='508' class='banner_set' ><tr height='20'><td width='90' align='center' bgcolor='85BAE4' class='table-title4'>半波</td> <td width='90' align='center' bgcolor='85BAE4' class='table-title4'>赔率</td> <td width='*' align='center' bgcolor='85BAE4' class='table-title4'>号码</td></tr><tr bgcolor='#ffffff'><td align='center'>红单</td><td align='center' id='odd0'><a href='betting-entry.aspx?m=232,1,17' target='bbnet_mem_order' class='bet_rate_blue' ><span id='odds0'> " + textArray[0] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>1</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>7</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>13</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>19</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>23</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>29</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>35</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>45</b></td> </tr> </table></td></tr><tr bgcolor='#ffffff'><td align='center'>红双</td><td align='center' id='odd1'><a href='betting-entry.aspx?m=233,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds1'>" + textArray[1] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>2</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>8</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>12</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>18</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>24</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>30</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>34</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>40</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>46</b></td> </tr></table></td></tr><tr bgcolor='#ffffff'><td align='center'>红大</td><td align='center' id='odd2'><a href='betting-entry.aspx?m=234,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds2'> " + textArray[2] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>29</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>30</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>34</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>35</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>40</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>45</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>46</b></td></tr></table></td> </tr><tr bgcolor='#ffffff'><td align='center'>红小</td><td align='center' id='odd3'><a href='betting-entry.aspx?m=235,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds3'>" + textArray[3] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'> <tr> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>1</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>2</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>7</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>8</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>12</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>13</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>18</b></td> <td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>19</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>23</b></td><td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>24</b></td></tr></table></td></tr><tr bgcolor='#ffffff'><td align='center'>绿单</td><td align='center' id='odd4'><a href='betting-entry.aspx?m=236,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds4'> " + textArray[4] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>5</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>11</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>17</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>21</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>27</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>33</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>39</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>43</b></td> </tr></table></td> </tr><tr bgcolor='#ffffff'><td align='center'>绿双</td><td align='center' id='odd5'><a href='betting-entry.aspx?m=237,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds5'>" + textArray[5] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'> <tr><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>6</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>16</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>22</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>28</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>32</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>38</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>44</b></td></tr> </table></td></tr><tr bgcolor='#ffffff'><td align='center'>绿大</td><td align='center' id='odd6'><a href='betting-entry.aspx?m=238,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds6'>" + textArray[6] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>27</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>28</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>32</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>33</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>38</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>39</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>43</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>44</b></td></tr></table></td></tr><tr bgcolor='#ffffff'><td align='center'>绿小</td><td align='center' id='odd7'><a href='betting-entry.aspx?m=239,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds7'>" + textArray[7] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>5</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>6</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>11</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>16</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>17</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>21</b></td><td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>22</b></td></tr></table></td></tr><tr bgcolor='#ffffff'><td align='center'>蓝单</td> <td align='center' id='odd8'><a href='betting-entry.aspx?m=240,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds8'>" + textArray[8] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr> <td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>3</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>9</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>15</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>25</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>31</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>37</b></td> <td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>41</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>47</b></td></tr> </table></td></tr><tr bgcolor='#ffffff'><td align='center'>蓝双</td><td align='center' id='odd9'><a href='betting-entry.aspx?m=241,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds9'>" + textArray[9] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>4</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>10</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>14</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>20</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>26</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>36</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>42</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>48</b></td></tr></table></td> </tr><tr bgcolor='#ffffff'><td align='center'>蓝大</td> <td align='center' id='odd10'><a href='betting-entry.aspx?m=242,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds10'>" + textArray[10] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'><tr><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>25</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>26</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>31</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>36</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>37</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>41</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>42</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>47</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>48</b></td></tr></table></td></tr><tr bgcolor='#ffffff'><td align='center'>蓝小</td><td align='center' id='odd11'><a href='betting-entry.aspx?m=243,1,17' target='bbnet_mem_order' class='bet_rate_blue'><span id='odds11'>" + textArray[11] + "</span></a></td><td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'> <tr> <td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>3</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>4</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>9</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>10</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>14</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>15</b></td><td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>20</b></td></tr> </table></td></tr></table></td></tr>";
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                int num = 0;
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,convert(nvarchar,tupdatetime,11) as tupdatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                if (reader.Read())
                {
                    this.sgame_num = int.Parse(reader["qishu"].ToString().Trim());
                    string text = "";
                    if ((base.Request.QueryString["rtype"].Trim() != "SP") && (base.Request.QueryString["rtype"].Trim() != "SPA"))
                    {
                        text = reader["kaisai"].ToString().Trim();
                    }
                    else
                    {
                        text = reader["tupdatetime"].ToString().Trim();
                    }
                    DateTime time = Convert.ToDateTime(text);
                    TimeSpan span = DateTime.Now.Subtract(time);
                    num = ((span.Hours * 0xe10) + (span.Minutes * 60)) + span.Seconds;
                    if (num > 0)
                    {
                        this.sgame_num++;
                    }
                }
                reader.Close();
                base2.Dispose();
                switch (base.Request.QueryString["rtype"].Trim())
                {
                    case "EVEN":
                        this.rContent();
                        this.rtype = "单双大小";
                        break;

                    case "SP":
                        this.vContent();
                        this.rtype = "特别号";
                        break;

                    case "NA":
                        this.reContent();
                        this.rtype = "正码";
                        break;

                    case "NO":
                        this.pdContent();
                        this.rtype = "连码";
                        break;

                    case "CH":
                        this.tContent();
                        this.rtype = "正码过关";
                        break;

                    case "SPA":
                        this.fContent();
                        this.rtype = "生肖色波";
                        break;

                    case "SPB":
                        this.pContent();
                        this.rtype = "一肖";
                        break;

                    case "pr":
                        this.prContent();
                        this.rtype = "六肖";
                        break;

                    case "future":
                        this.futureContent();
                        this.rtype = "正码1-6";
                        break;

                    case "SX":
                        this.sxContent();
                        this.rtype = "六肖";
                        break;

                    case "HF":
                        this.hfContent();
                        this.rtype = "半波";
                        break;

                    default:
                        this.ErrorContent();
                        break;
                }
                this.DataBind();
            }
        }

        private void pContent()
        {
            this.kygltable = "  <TR><TD colSpan=2><TABLE width=100% border=0 cellspacing=1 cellpadding=0 id=game_table>";
            this.kygltable = this.kygltable + " <tr class=tr_title_set_cen> <td width=50>十二生肖</td><td width=130>号码</td> <td>赔率</td>";
            this.kygltable = this.kygltable + " <td width=50>十二生肖</td> <td width=130>号码</td> <td>赔率</td></tr> </TABLE></TD></TR>";
            this.kygltable = this.kygltable + " <tr>   <td height=10 colspan=2>&nbsp;</td> </tr>";
        }

        private void pdContent()
        {
            this.kygltable = "sTime = '159';";
            this.kygltable = this.kygltable + "gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
            this.kygltable = this.kygltable + "pOddsName = Array('特单','特双','特大','特小','合单','合双');";
            this.kygltable = this.kygltable + "pOdds = Array('1.87','1.89','1.88','1.88','1.89','1.87');";
            this.kygltable = this.kygltable + "cOddsName = Array('单','双','大','小');";
            this.kygltable = this.kygltable + "cOdds = Array('1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87');";
            this.kygltable = this.kygltable + "uOddsName = Array('总单','总双','总大','总小');";
            this.kygltable = this.kygltable + "uOdds = Array('1.86','1.86','1.86','1.86','0','0');";
        }

        private void prContent()
        {
            this.kygltable = "sTime = '159';";
            this.kygltable = this.kygltable + "gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
            this.kygltable = this.kygltable + "pOddsName = Array('特单','特双','特大','特小','合单','合双');";
            this.kygltable = this.kygltable + "pOdds = Array('1.87','1.89','1.88','1.88','1.89','1.87');";
            this.kygltable = this.kygltable + "cOddsName = Array('单','双','大','小');";
            this.kygltable = this.kygltable + "cOdds = Array('1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87');";
            this.kygltable = this.kygltable + "uOddsName = Array('总单','总双','总大','总小');";
            this.kygltable = this.kygltable + "uOdds = Array('1.86','1.86','1.86','1.86','0','0');";
        }

        private void rContent()
        {
            this.kygltable = "<TR><TD colSpan=2><TABLE id=game_table cellSpacing=1 cellPadding=0 width=100% \n";
            this.kygltable = this.kygltable + " border=0><TBODY><TR class=tr_title_set_cen><TD>号码</TD>\n";
            this.kygltable = this.kygltable + "    <TD width=60>赔率</TD><TD>号码</TD><TD width=60>赔率</TD>\n";
            this.kygltable = this.kygltable + "        <TD>号码</TD><TD width=60>赔率</TD><TD>号码</TD><TD width=60>赔率</TD></TR></TABLE></TD></TR>\n";
            this.kygltable = this.kygltable + "<TR><TD><TABLE id=game_table cellSpacing=1 cellPadding=0 width=100% border=0></TABLE></TD></TR>\n";
            this.kygltable = this.kygltable + "<TR><TD colSpan=2><TABLE id=game_table cellSpacing=1 cellPadding=0 width=100% border=0>\n";
            this.kygltable = this.kygltable + " <TBODY><TR class=tr_title_set_cen><TD>号码</TD><TD width=60>赔率</TD>\n";
            this.kygltable = this.kygltable + " <TD>号码</TD> <TD width=60>赔率</TD><TD>号码</TD> <TD width=60>赔率</TD>\n";
            this.kygltable = this.kygltable + "        <TD>号码</TD><TD width=60>赔率</TD></TR></TBODY></TABLE></TD></TR>\n";
            this.kygltable = this.kygltable + "<TR> <TD colSpan=2><TABLE id=game_table1 cellSpacing=1 cellPadding=0 width=100%      border=0>\n";
            this.kygltable = this.kygltable + "      <TBODY></TBODY></TABLE></TD></TR>\n";
            this.kygltable = this.kygltable + "<TR> <TD colSpan=2> <TABLE id=game_table cellSpacing=1 cellPadding=0 width=100% border=0>\n";
            this.kygltable = this.kygltable + "      <TBODY><TR class=tr_title_set_cen> <TD colSpan=2>正码一</TD><TD colSpan=2>正码二</TD>\n";
            this.kygltable = this.kygltable + "        <TD colSpan=2>正码三</TD><TD colSpan=2>正码四</TD> <TD colSpan=2>正码五</TD><TD colSpan=2>正码六</TD></TR>\n";
            this.kygltable = this.kygltable + "      <TR class=list_cen><TD class=ball_td>号码</TD><TD class=list_cen width=40>赔率</TD>\n";
            this.kygltable = this.kygltable + "        <TD class=ball_td>号码</TD><TD class=list_cen width=40>赔率</TD>\n";
            this.kygltable = this.kygltable + "        <TD class=ball_td>号码</TD> <TD class=list_cen width=40>赔率</TD>\n";
            this.kygltable = this.kygltable + "        <TD class=ball_td>号码</TD> <TD class=list_cen width=40>赔率</TD>\n";
            this.kygltable = this.kygltable + "        <TD class=ball_td>号码</TD> <TD class=list_cen width=40>赔率</TD>\n";
            this.kygltable = this.kygltable + "       <TD class=ball_td>号码</TD><TD class=list_cen width=40>赔率</TD></TR></TBODY></TABLE></TD></TR>\n";
            this.kygltable = this.kygltable + "<TR> <TD colSpan=2> <TABLE id=game_table2 cellSpacing=1 cellPadding=0 width=100%                 border=0>\n";
            this.kygltable = this.kygltable + "      <TBODY></TBODY></TABLE></TD></TR>\n";
            this.quickinput2 = "<INPUT class=\"select_cen\" onclick=\"parent.parent.body.location='quickinput_ev.aspx'\"\ttype=\"button\" value=\"切换快速模式\" name=\"quickinput\">";
        }

        private void reContent()
        {
            this.kygltable = "<TR><TD colSpan=2> <TABLE id=game_table cellSpacing=1 cellPadding=0 width=100%  border=0>";
            this.kygltable = this.kygltable + "         <TBODY><TR class=tr_title_set_cen><TD>号码</TD> <TD width=50>赔率</TD> <TD>号码</TD>";
            this.kygltable = this.kygltable + "          <TD width=50>赔率</TD> <TD>号码</TD><TD width=50>赔率</TD><TD>号码</TD> <TD width=50>赔率</TD>  ";
            this.kygltable = this.kygltable + "          <TD>号码</TD><TD width=50>赔率</TD></TR></TBODY></TABLE></TD></TR>";
            this.kygltable = this.kygltable + "  <TR><TD colSpan=2><TABLE id=game_table1 cellSpacing=1 cellPadding=0 width=100% border=0>";
            this.kygltable = this.kygltable + "        <TBODY></TBODY></TABLE></TD></TR>";
            this.quickinput = "<SPAN id=\"quickinput\"><INPUT class=\"select_cen\" onclick=\"parent.parent.bbnet_mem_order.location='quickinput.aspx?rtype=NA'\" type=\"button\" value=\"快速输入\" name=\"quickinput\"></SPAN>";
        }

        private void sxContent()
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=230 ORDER BY id asc");
            if (reader.Read())
            {
                text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
            }
            reader.Close();
            reader.Close();
            base2.Dispose();
            this.kygltable = " <form name=\"lt_form\" method=\"post\" action=\"betting-entry.aspx\" target=\"bbnet_mem_order\" onSubmit=\"return SubChk(this);\" onReset=\"return reset_num();\"><input type=\"hidden\" name=\"action\" value=\"sx\"><tr>  <td height=\"100%\" colspan=\"3\"><TABLE class=\"table_title_line\"    cellSpacing=0 cellPadding=0 width=500 border=0 ><TBODY> <TR> <TD height=5 colSpan=2></TD>   </TR>     <tr>  <TD colSpan=2> <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\"> <tr align=\"left\"><td class=\"ball_td2\" width=\"60\" align=\"center\">类别</td>  <td class=\"ball_td2\" width=\"60\" align=\"center\"><input type=\"radio\" name=\"rtype\" value=\"230\">中</td>  <td class=\"ball_td2\" width=\"60\" align=\"center\"><input type=\"radio\" name=\"rtype\" value=\"231\">不中</td>  <td class=\"ball_td2\" width=\"60\" align=\"center\">赔率</td> <td class=\"ball_td3\" width=\"60\" align=\"center\" id='odds1' style='background-color: #C1D7E5;'>" + text + "</td><td width=250>&nbsp;</td> </tr></table></TD></TR> <TR> <TD colSpan=2> <TABLE width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"> <TBODY><tr class=\"tr_title_set_cen\"> <td width=\"50\">六肖</td> <td width=\"130\">号码</td> <td>勾选</td><td width=\"50\">六肖</td> <td width=\"130\">号码</td> <td>勾选</td></tr><tr> <td class=\"tr_title_set_cen\">鼠</td> <td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[0].ToString() + "</td> <td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"0\" onClick=\"SubChkBox(this,this)\"></td> <td class=\"tr_title_set_cen\">牛</td> <td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[1].ToString() + "</td> <td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"1\" onClick=\"SubChkBox(this,this)\"></td></tr><tr><td class=\"tr_title_set_cen\">虎</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[2].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"2\" onClick=\"SubChkBox(this,this)\"></td><td class=\"tr_title_set_cen\">兔</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[3].ToString() + "</td> <td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"3\" onClick=\"SubChkBox(this,this)\"></td> </tr> <tr><td class=\"tr_title_set_cen\">龙</td> <td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[4].ToString() + "</td> <td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"4\" onClick=\"SubChkBox(this,this)\"></td> <td class=\"tr_title_set_cen\">蛇</td> <td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[5].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"5\" onClick=\"SubChkBox(this,this)\"></td></tr><tr> <td class=\"tr_title_set_cen\">马</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[6].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"6\" onClick=\"SubChkBox(this,this)\"></td><td class=\"tr_title_set_cen\">羊</td> <td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[7].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"7\" onClick=\"SubChkBox(this,this)\"></td></tr><tr><td class=\"tr_title_set_cen\">猴</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[8].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"8\" onClick=\"SubChkBox(this,this)\"></td><td class=\"tr_title_set_cen\">鸡</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[9].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"9\" onClick=\"SubChkBox(this,this)\"></td></tr><tr><td class=\"tr_title_set_cen\">狗</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[10].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"10\" onClick=\"SubChkBox(this,this)\"></td><td class=\"tr_title_set_cen\">猪</td><td class=\"ball_td2\">" + ConfigurationSettings.AppSettings["twelveNum"].Split(new char[] { '^' })[11].ToString() + "</td><td class=\"list_cen\"><input type=\"checkbox\" name=\"lt_sx[]\" value=\"11\" onClick=\"SubChkBox(this,this)\"></td></tr></TBODY> </TABLE> </TD></TR><tr> <td height=\"10\" colspan=\"2\">&nbsp;</td></tr><TR> <TD colSpan=2><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"> <!--id=\"game_table1\">--> <tr class=\"tr_title_set_cen\">  \t\t\t\t\t   \t<td width=\"100%\" align=\"center\"><input type=\"submit\" value=\"送出\"><input type=\"reset\" value=\"取消\" onMouseUp=\"return reset();\"></td> </tr></table></TD></tr>   </TBODY> </TABLE></td></tr></form>";
        }

        private void tContent()
        {
            this.kygltable = "sTime = '159';";
            this.kygltable = this.kygltable + "gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
            this.kygltable = this.kygltable + "pOddsName = Array('特单','特双','特大','特小','合单','合双');";
            this.kygltable = this.kygltable + "pOdds = Array('1.87','1.89','1.88','1.88','1.89','1.87');";
            this.kygltable = this.kygltable + "cOddsName = Array('单','双','大','小');";
            this.kygltable = this.kygltable + "cOdds = Array('1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87');";
            this.kygltable = this.kygltable + "uOddsName = Array('总单','总双','总大','总小');";
            this.kygltable = this.kygltable + "uOdds = Array('1.86','1.86','1.86','1.86','0','0');";
        }

        private void vContent()
        {
            this.kygltable = "<TR><TD colSpan=2><TABLE id=game_table cellSpacing=1 cellPadding=0 width=100% border=0>";
            this.kygltable = this.kygltable + "<TBODY><TR class=tr_title_set_cen><TD>号码</TD><TD width=50>赔率</TD><TD>号码</TD><TD width=50>赔率</TD>";
            this.kygltable = this.kygltable + "<TD>号码</TD><TD width=50>赔率</TD><TD>号码</TD><TD width=50>赔率</TD><TD>号码</TD><TD width=50>赔率</TD>";
            this.kygltable = this.kygltable + "</TR></TBODY></TABLE></TD></TR>";
            this.kygltable = this.kygltable + "<TR><TD colSpan=2><TABLE id=game_table1 cellSpacing=1 cellPadding=0 width=100% border=0>";
            this.kygltable = this.kygltable + "<TBODY></TBODY></TABLE></TD></TR>";
            this.quickinput = "<SPAN id=\"quickinput\"><INPUT class=\"select_cen\" onclick=\"parent.parent.bbnet_mem_order.location='quickinput.aspx?rtype=SP'\" type=\"button\" value=\"快速输入\" name=\"quickinput\"></SPAN>";
            this.quickinput2 = "<INPUT class=\"select_cen\" onclick=\"parent.parent.body.location='quickinput2.aspx?btype=SP'\"\ttype=\"button\" value=\"切换快速模式\" name=\"quickinput\">";
        }
    }
}

