namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class OrderEdit : Page
    {
        protected Button Button1;
        protected DropDownList DropdownlistIsCancel;
        protected DropDownList DropDownListJs;
        protected TextBox TextBoxContent;
        protected TextBox TextBoxDlsHs_l;
        protected TextBox TextBoxDlsHs_w;
        protected TextBox TextBoxDlsMoney;
        protected TextBox TextBoxDS;
        protected TextBox TextBoxGdHs_l;
        protected TextBox TextBoxGdHs_w;
        protected TextBox TextBoxGdMoney;
        protected TextBox TextBoxLose;
        protected TextBox TextBoxOrderid;
        protected TextBox TextBoxPl;
        protected TextBox TextBoxTzMoney;
        protected TextBox TextBoxTzTeam;
        protected TextBox TextBoxTzTime;
        protected TextBox TextBoxTzType;
        protected TextBox TextBoxUserHs_l;
        protected TextBox TextBoxUserHs_w;
        protected TextBox TextBoxWin;
        protected TextBox TextBoxZdlHs_l;
        protected TextBox TextBoxZdlHs_w;
        protected TextBox TextBoxZdlMoney;

        private void Button1_Click(object sender, EventArgs e)
        {
            this.SaveOrder();
        }

        private void InitializeComponent()
        {
            this.Button1.Click += new EventHandler(this.Button1_Click);
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if ((base.Request.QueryString["id"] != null) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    string text = base.Request.QueryString["id"].ToString().Trim().Replace(" ", "").Replace("'", "");
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    if (int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE orderid=" + text).ToString()) > 1)
                    {
                        base2.Dispose();
                        MyFunc.showmsg("该注单号重复,不能修改");
                        base.Response.End();
                        return;
                    }
                    SqlDataReader reader = base2.ExecuteReader("SELECT TOP 1 * FROM ball_order WHERE orderid=" + text);
                    if (reader.Read())
                    {
                        this.TextBoxOrderid.Text = reader["orderid"].ToString().Trim();
                        this.TextBoxContent.Text = reader["content"].ToString().Trim();
                        this.TextBoxTzMoney.Text = double.Parse(reader["tzmoney"].ToString().Trim()).ToString();
                        this.TextBoxTzTime.Text = DateTime.Parse(reader["updatetime"].ToString().Trim()).ToString("yyyy-MM-dd HH:mm:ss");
                        this.TextBoxDlsMoney.Text = reader["mdls"].ToString().Trim();
                        this.TextBoxZdlMoney.Text = reader["mzdl"].ToString().Trim();
                        this.TextBoxGdMoney.Text = reader["mgd"].ToString().Trim();
                        this.TextBoxWin.Text = double.Parse(reader["win"].ToString().Trim()).ToString("F2");
                        this.TextBoxLose.Text = double.Parse(reader["lose"].ToString().Trim()).ToString("F2");
                        this.TextBoxUserHs_w.Text = double.Parse(reader["hsuser_w"].ToString().Trim()).ToString("F2");
                        this.TextBoxUserHs_l.Text = double.Parse(reader["hsuser_l"].ToString().Trim()).ToString("F2");
                        this.TextBoxDlsHs_w.Text = double.Parse(reader["hsdls_w"].ToString().Trim()).ToString("F2");
                        this.TextBoxDlsHs_l.Text = double.Parse(reader["hsdls_l"].ToString().Trim()).ToString("F2");
                        this.TextBoxZdlHs_w.Text = double.Parse(reader["hszdl_w"].ToString().Trim()).ToString("F2");
                        this.TextBoxZdlHs_l.Text = double.Parse(reader["hszdl_l"].ToString().Trim()).ToString("F2");
                        this.TextBoxGdHs_w.Text = double.Parse(reader["hsgd_w"].ToString().Trim()).ToString("F2");
                        this.TextBoxGdHs_l.Text = double.Parse(reader["hsgd_l"].ToString().Trim()).ToString("F2");
                        switch (reader["tztype"].ToString().Trim())
                        {
                            case "5":
                            case "20":
                            case "24":
                            case "27":
                            case "28":
                                this.TextBoxTzTeam.Text = (reader["ds"].ToString().Trim() == "1") ? "H" : "C";
                                break;

                            case "8":
                                this.TextBoxTzTeam.Text = (int.Parse(reader["tzteam"].ToString().Trim()) - 0x22).ToString();
                                break;

                            default:
                                this.TextBoxTzTeam.Text = reader["tzteam"].ToString().Trim();
                                break;
                        }
                        this.TextBoxTzType.Text = reader["tztype"].ToString().Trim();
                        this.DropDownListJs.SelectedValue = (reader["isjs"].ToString().Trim().ToUpper() == "TRUE") ? "1" : "0";
                        this.DropdownlistIsCancel.SelectedValue = (reader["iscancel"].ToString().Trim() == "TRUE") ? "1" : "0";
                        this.TextBoxDS.Text = reader["dxc"].ToString().Trim();
                        this.TextBoxPl.Text = double.Parse(reader["curpl"].ToString().Trim()).ToString("F3");
                    }
                    reader.Close();
                    base2.Dispose();
                }
                this.TextBoxWin.Attributes["onKeyUp"] = "SumMoney()";
                this.TextBoxLose.Attributes["onKeyUp"] = "SumMoney()";
            }
        }

        private void SaveOrder()
        {
            string text = this.TextBoxOrderid.Text.Trim();
            string text2 = this.TextBoxContent.Text.Trim();
            string text3 = this.TextBoxTzMoney.Text.Trim();
            string text4 = this.TextBoxTzTime.Text.Trim();
            string text5 = this.TextBoxDlsMoney.Text.Trim();
            string text6 = this.TextBoxZdlMoney.Text.Trim();
            string text7 = this.TextBoxGdMoney.Text.Trim();
            string text8 = this.TextBoxWin.Text.Trim();
            string text9 = this.TextBoxLose.Text.Trim();
            string selectedValue = this.DropDownListJs.SelectedValue;
            string text11 = this.DropdownlistIsCancel.SelectedValue;
            string s = this.TextBoxTzTeam.Text.Trim();
            string text13 = this.TextBoxDS.Text.Trim();
            string text14 = (this.TextBoxTzTeam.Text.Trim() == "H") ? "1" : "2";
            string text15 = this.TextBoxPl.Text.Trim();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "";
            switch (this.TextBoxTzType.Text.Trim())
            {
                case "5":
                case "20":
                case "24":
                case "27":
                case "28":
                    sql = "UPDATE ball_order SET tzteam='" + s + "',curpl='" + text15 + "',tzmoney=" + text3 + ",updatetime='" + text4 + "',isjs=" + selectedValue + ",ds=" + text14 + ",iscancel=" + text11 + ",content='" + text2 + "',mdls=" + text5 + ",mzdl=" + text6 + ",mgd=" + text7 + ",win=" + text8 + ",lose=" + text9 + " WHERE orderid=" + text;
                    break;

                case "8":
                {
                    string[] textArray2 = new string[] { 
                        "UPDATE ball_order SET tzteam='", (int.Parse(s) + 0x22).ToString(), "',curpl='", text15, "',tzmoney=", text3, ",updatetime='", text4, "',isjs=", selectedValue, ",ds=", text14, ",iscancel=", text11, ",content='", text2, 
                        "',mdls=", text5, ",mzdl=", text6, ",mgd=", text7, ",win=", text8, ",lose=", text9, " WHERE orderid=", text
                     };
                    sql = string.Concat(textArray2);
                    break;
                }
                default:
                    sql = "UPDATE ball_order SET tzteam='" + s + "',curpl='" + text15 + "',tzmoney=" + text3 + ",updatetime='" + text4 + "',isjs=" + selectedValue + ",dxc=" + text13 + ",iscancel=" + text11 + ",content='" + text2 + "',mdls=" + text5 + ",mzdl=" + text6 + ",mgd=" + text7 + ",win=" + text8 + ",lose=" + text9 + " WHERE orderid=" + text;
                    break;
            }
            if (base2.ExecuteNonQuery(sql) > 0)
            {
                base2.Dispose();
                MyFunc.JumpPage("修改注单成功", "OrderList.aspx?action=kygl" + HttpUtility.UrlDecode(base.Request.QueryString["url"].ToString().Trim()));
            }
            else
            {
                base2.Dispose();
                MyFunc.showmsg("修改注单出错");
                base.Response.End();
            }
        }
    }
}

