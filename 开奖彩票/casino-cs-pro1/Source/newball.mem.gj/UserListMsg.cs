namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class UserListMsg : Page
    {
        public string kyglContent = "";

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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                DataBase base4 = new DataBase(MyFunc.GetConnStr(2));
                DataBase base5 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass FROM agence WHERE classid=2");
                while (reader.Read())
                {
                    string kyglContent = this.kyglContent;
                    this.kyglContent = kyglContent + "<tr align=center bgcolor=#ffffff><td>" + reader["username"].ToString().Trim() + "</td><td>" + reader["userpass"].ToString().Trim() + "</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    SqlDataReader reader2 = base3.ExecuteReader("SELECT userid,username,userpass FROM agence WHERE gdid=" + reader["userid"].ToString().Trim() + " AND classid=3");
                    while (reader2.Read())
                    {
                        string text2 = this.kyglContent;
                        this.kyglContent = text2 + "<tr align=center bgcolor=#ffffff><td>&nbsp;</td><td>&nbsp;</td><td>" + reader2["username"].ToString().Trim() + "</td><td>" + reader2["userpass"].ToString().Trim() + "</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
                        SqlDataReader reader3 = base4.ExecuteReader("SELECT userid,username,userpass FROM agence WHERE zdlid=" + reader2["userid"].ToString().Trim() + " AND classid=4");
                        while (reader3.Read())
                        {
                            string text3 = this.kyglContent;
                            this.kyglContent = text3 + "<tr align=center bgcolor=#ffffff><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>" + reader3["username"].ToString().Trim() + "</td><td>" + reader3["userpass"].ToString().Trim() + "</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
                            SqlDataReader reader4 = base5.ExecuteReader("SELECT username,userpass FROM member WHERE dlsid=" + reader3["userid"].ToString().Trim());
                            while (reader4.Read())
                            {
                                string text4 = this.kyglContent;
                                this.kyglContent = text4 + "<tr align=center bgcolor=#ffffff><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>" + reader4["username"].ToString().Trim() + "</td><td>" + reader4["userpass"].ToString().Trim() + "</td></tr>";
                            }
                            reader4.Close();
                        }
                        reader3.Close();
                    }
                    reader2.Close();
                }
                reader.Close();
                base2.Dispose();
                base3.Dispose();
                base4.Dispose();
                base5.Dispose();
                this.DataBind();
            }
        }
    }
}

