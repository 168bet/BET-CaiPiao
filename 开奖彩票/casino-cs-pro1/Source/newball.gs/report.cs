namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class report : Page
    {
        protected DropDownList ballType;
        protected HtmlInputText endTime;
        public string kyglcontent = "";
        protected DropDownList reportType;
        protected Button searchButton;
        protected Label showAlready;
        protected Label showNo;
        protected Label showTime1;
        protected Label showTime2;
        protected HtmlInputText startTime;
        protected DropDownList tzCase;
        protected DropDownList tzType;

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
            if ((!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1)) && (!MyFunc.CheckUserLogin(2) || !MyTeam.OnlineList.OnlineList.isUserLogin(2)))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                if (!this.Page.IsPostBack)
                {
                    this.startTime.Value = DateTime.Today.ToString("yyyy-MM-dd");
                    this.endTime.Value = DateTime.Today.ToString("yyyy-MM-dd");
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    SqlDataReader reader = base2.ExecuteReader("select count(*) as rowcounts from ball_order where gdid in (" + this.Session.Contents["adminarrgd"].ToString().Trim() + "-1) and isjs = 0 and iscancel = 0 and datediff(day,'" + DateTime.Today.ToShortDateString() + "',updatetime) = 0");
                    reader.Read();
                    if (reader["rowcounts"].ToString() == "0")
                    {
                        this.showTime2.Text = "[" + DateTime.Today.ToString("yyyy-MM-dd") + "]";
                        this.showNo.Text = "[全部注单已结算完毕]";
                    }
                    else
                    {
                        this.showTime2.Text = "[" + DateTime.Today.ToString("yyyy-MM-dd") + "]";
                        this.showNo.Text = "[<a href='reportShowNoJs.aspx'><font color=red>" + reader["rowcounts"].ToString() + "注注单未结算</font></a>]";
                    }
                    reader.Close();
                    reader = base2.ExecuteReader("select count(*) as rowcounts from ball_order where gdid in (" + this.Session.Contents["adminarrgd"].ToString().Trim() + "-1) and tzType = '1' AND isjs = 0 and iscancel = 0 and datediff(day,'" + DateTime.Today.ToShortDateString() + "',updatetime) = 0");
                    reader.Read();
                    if (reader["rowcounts"].ToString() != "0")
                    {
                        this.showNo.Text = this.showNo.Text + "[<a href='reportShowNoJs.aspx?tztype=8'><font color=red>特别号</font></a>][<a href='reportShowNoJs.aspx?tztype=all'><font color=red>全部</font></a>]";
                    }
                    reader.Close();
                    reader = base2.ExecuteReader("select * from ball_bf1 order by ballid desc");
                    while (reader.Read())
                    {
                        string kyglcontent = this.kyglcontent;
                        this.kyglcontent = kyglcontent + " <option value=" + Convert.ToDateTime(reader["balltime"]).ToString("yyyy-MM-dd") + "> 第 " + reader["qishu"].ToString() + " 期  " + Convert.ToDateTime(reader["balltime"]).ToString("yyyy-MM-dd") + "</option>";
                    }
                    reader.Close();
                    base2.Dispose();
                }
                else
                {
                    if (base.Request.QueryString["dataday"] != null)
                    {
                        if (base.Request.QueryString["dataday"].ToString() == "1")
                        {
                            this.startTime.Value = DateTime.Today.AddDays(-1).ToString("yyyy-MM-dd");
                            this.endTime.Value = DateTime.Today.AddDays(-1).ToString("yyyy-MM-dd");
                        }
                        else if (base.Request.QueryString["dataday"].ToString() == "7")
                        {
                            this.startTime.Value = DateTime.Today.AddDays(-6).ToString("yyyy-MM-dd");
                            this.endTime.Value = DateTime.Today.ToString("yyyy-MM-dd");
                        }
                        else
                        {
                            int num = Convert.ToInt32(DateTime.Today.DayOfWeek) - 1;
                            if (num == -1)
                            {
                                num = 6;
                            }
                            this.startTime.Value = DateTime.Today.AddDays((double) -num).ToString("yyyy-MM-dd");
                            this.endTime.Value = DateTime.Today.ToString("yyyy-MM-dd");
                        }
                    }
                    try
                    {
                        DateTime.Parse(this.startTime.Value);
                        DateTime.Parse(this.endTime.Value);
                    }
                    catch
                    {
                        MyFunc.showmsg("请输入真确的日期格式！");
                    }
                    this.searchDeal();
                }
                this.DataBind();
            }
        }

        private void searchDeal()
        {
            string path = "reportshow.aspx?search=search";
            path = ((((path + "&startTime=" + this.startTime.Value) + "&endTime=" + this.endTime.Value) + "&reportType=" + this.reportType.SelectedValue) + "&tzCase=" + this.tzCase.SelectedValue) + "&tzType=" + this.tzType.SelectedValue;
            base.Server.Transfer(path);
        }
    }
}

