namespace newball.subuser
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class relogin : Page
    {
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
            string[] textArray = base.Request.QueryString["pathstr"].ToString().Split(new char[] { ',' });
            this.Session.Contents["adminuserid"] = textArray[0].ToString().Trim();
            this.Session.Contents["adminsubname"] = textArray[1].ToString().Trim();
            this.Session.Contents["adminsubpass"] = textArray[2].ToString().Trim();
            this.Session.Contents["adminsubsessid"] = textArray[3].ToString().Trim();
            this.Session.Contents["adminsubclassid"] = textArray[4].ToString().Trim();
            this.Session.Contents["lang"] = textArray[5].ToString().Trim();
            this.Session.Contents["adminarrgd"] = textArray[9].ToString().Trim();
            this.Session.Contents["adminsubid"] = textArray[10].ToString().Trim();
            this.Session.Contents["adminusername"] = textArray[1].ToString().Trim();
            switch (int.Parse(this.Session.Contents["lang"].ToString()))
            {
                case 0:
                    this.Session.Contents["team"] = "";
                    break;

                case 1:
                    this.Session.Contents["team"] = "b";
                    break;

                case 2:
                    this.Session.Contents["team"] = "e";
                    break;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = null;
            reader = base2.ExecuteReader("SELECT userid,username,userpass,classid,arrgd FROM agence WHERE userid='" + this.Session.Contents["adminuserid"].ToString() + "' AND classid=0 AND isuseable=1 and userid in (" + MyFunc.GetGongSiID().ToString() + ")");
            if (reader.Read())
            {
                this.Session.Contents["adminarrgd"] = reader["arrgd"].ToString().Trim();
            }
            else
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return;
            }
            reader.Close();
            base2.Dispose();
            MyTeam.OnlineList.OnlineList.NewUserLogin(this.Session.Contents["adminsubname"].ToString(), this.Session.Contents["adminsubsessid"].ToString(), DateTime.Now.ToString(), textArray[8].ToString().Trim(), this.Session.Contents["adminsubclassid"].ToString(), textArray[6].ToString().Trim() + "|" + textArray[7].ToString().Trim());
            base.Response.Redirect("frmindex.aspx");
            base.Response.End();
        }
    }
}

