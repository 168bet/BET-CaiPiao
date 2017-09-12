namespace newball.odds.subadmin
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class mgrConfig : Page
    {
        protected HtmlInputHidden configid;
        protected TextBox content;
        protected DropDownList kaipan;
        protected TextBox kaisai;
        protected DropDownList le;
        protected TextBox qishu;
        protected Button submitbutton;
        protected HtmlTable tableconfig;
        protected HtmlTable tabletitle;
        protected TextBox Textbox1;
        protected TextBox TextBox2;
        protected TextBox TUpdateTime;

        private void dealsaveadd()
        {
            string sql = "INSERT INTO affiche (le,content,updatetime,tupdatetime,kaisai,qishu,isclose) VALUES ('" + this.le.SelectedValue + "', '" + this.content.Text.Trim().Replace("'", " ") + "', '" + DateTime.Now.ToString() + "', '" + this.TUpdateTime.Text.Trim().ToString() + "', '" + this.kaisai.Text.Trim().Replace("'", " ") + "','" + this.qishu.Text.Trim().Replace("'", " ") + "','" + this.kaipan.SelectedValue.ToString() + "')";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.JumpPage("新增公告成功", "mgrconfiglist.aspx");
        }

        private void dealsavechg()
        {
            string sql = "UPDATE affiche SET le = '" + this.le.SelectedValue + "',content = '" + this.content.Text.Trim().Replace("'", " ") + "',updatetime = '" + DateTime.Now.ToString() + "',tupdatetime = '" + this.TUpdateTime.Text.Trim().ToString() + "',kaisai= '" + this.kaisai.Text.Trim().Replace("'", " ") + "',qishu= '" + this.qishu.Text.Trim().Replace("'", " ") + "',isclose='" + this.kaipan.SelectedValue.ToString() + "'  WHERE id = '" + this.configid.Value + "'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.JumpPage("修改公告成功", "mgrconfiglist.aspx");
        }

        private void InitializeComponent()
        {
            this.submitbutton.Click += new EventHandler(this.submitbutton_Click);
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
            if ((this.Session.Contents["classid"] == null) || (this.Session.Contents["classid"].ToString().Trim() != "1"))
            {
                if (this.Session.Contents["adminclassid"] != null)
                {
                    if ((this.Session.Contents["adminclassid"].ToString().Trim() == "5") || (this.Session.Contents["adminclassid"].ToString().Trim() == "1"))
                    {
                        goto Label_00DF;
                    }
                    MyFunc.goToLoginPage();
                    base.Response.End();
                }
                else
                {
                    MyFunc.goToLoginPage();
                    base.Response.End();
                }
                return;
            }
        Label_00DF:
            if (!base.IsPostBack)
            {
                if (base.Request.QueryString["id"] != null)
                {
                    this.setstartvalue(base.Request.QueryString["id"].ToString().Trim());
                }
                else
                {
                    this.kaisai.Text = DateTime.Now.ToString();
                }
            }
        }

        private void setstartvalue(string varconfigid)
        {
            string sql = "SELECT * FROM affiche WHERE id='" + varconfigid + "'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                this.tabletitle.Rows[0].Cells[0].InnerHtml = "&nbsp;公告管理&nbsp;&gt;&gt;修改&nbsp;--&nbsp; <a href='mgrconfiglist.aspx'>返回上页</a>";
                this.tableconfig.Rows[0].Cells[0].InnerHtml = "修改网站公告";
                this.submitbutton.Text = "修 改";
                this.configid.Value = varconfigid;
                this.le.SelectedIndex = int.Parse(reader["le"].ToString()) - 1;
                this.content.Text = reader["content"].ToString().Trim();
                this.TUpdateTime.Text = reader["tupdatetime"].ToString();
                this.kaisai.Text = reader["kaisai"].ToString().Trim();
                this.qishu.Text = reader["qishu"].ToString().Trim();
                this.kaipan.SelectedIndex = int.Parse(reader["isclose"].ToString());
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
        }

        private void submitbutton_Click(object sender, EventArgs e)
        {
            if (this.configid.Value != "")
            {
                this.dealsavechg();
            }
            else
            {
                this.dealsaveadd();
            }
        }
    }
}

