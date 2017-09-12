namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class sub : Page
    {
        public string gTime = "";
        public string isclose = "";
        public string kaisai = "";
        public string kygltable = "";
        public int lenb = 0;
        public string msg = "";
        public string qishu = "";
        public string reload = "500000";

        private void AHHTContent()
        {
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            string[] textArray = "一, 二,三,四,五,六".Split(new char[] { ',' });
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = null;
            reader = base2.ExecuteReader("SELECT top 1 * FROM Ball_BF1  ORDER BY balltime DESC");
            if (reader.Read())
            {
                for (int i = 1; i < 7; i++)
                {
                    if (reader["num" + i.ToString()].ToString() != "")
                    {
                        object kygltable = this.kygltable;
                        this.kygltable = string.Concat(new object[] { kygltable, "result['", this.lenb, "'] = '", reader["num" + i.ToString()].ToString(), "'\n" });
                        this.lenb++;
                    }
                }
                if (reader["tema"].ToString() != "")
                {
                    object obj3 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj3, "result['", this.lenb, "'] = '", reader["tema"].ToString(), "'\n" });
                    this.lenb++;
                }
            }
            if (this.lenb < 7)
            {
                this.reload = "1000";
            }
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
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                if (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                    this.qishu = reader["qishu"].ToString().Trim();
                    this.kaisai = reader["kaisai"].ToString().Trim();
                    this.isclose = reader["isclose"].ToString();
                }
                reader.Close();
                base2.Dispose();
                this.AHHTContent();
                this.DataBind();
            }
        }
    }
}

