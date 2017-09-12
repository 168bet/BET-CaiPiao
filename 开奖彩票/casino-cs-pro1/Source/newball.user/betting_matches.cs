namespace newball.user
{
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;

    public class betting_matches : Page
    {
        public string kygltable;

        private void ErrorContent()
        {
            MyFunc.goToLoginPage();
        }

        private void fContent()
        {
            this.kygltable = this.kygltable + "var zoo_array_name = Array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');";
            this.kygltable = this.kygltable + "var zoo_array_nums = Array(" + MyFunc.twelveNumUI + ");";
            this.kygltable = this.kygltable + "var zoo_array = Array(\"A1\",\"A2\",\"A3\",\"A4\",\"A5\",\"A6\",\"A7\",\"A8\",\"A9\",\"AA\",\"AB\",\"AC\",\"R\",\"G\",\"B\");";
        }

        private void futureContent()
        {
            this.kygltable = "var\ttype_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\",\"R\",\"G\",\"B\");";
        }

        private void hfContent()
        {
            this.kygltable = "var\ttype_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\",\"R\",\"G\",\"B\");";
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
                switch (base.Request.QueryString["rtype"].Trim())
                {
                    case "EVEN":
                        this.rContent();
                        break;

                    case "SP":
                        this.vContent();
                        break;

                    case "NA":
                        this.reContent();
                        break;

                    case "pd":
                        this.pdContent();
                        break;

                    case "CH":
                        this.tContent();
                        break;

                    case "SPA":
                        this.fContent();
                        break;

                    case "SPB":
                        this.pContent();
                        break;

                    case "pr":
                        this.prContent();
                        break;

                    case "future":
                        this.futureContent();
                        break;

                    case "SX":
                        this.sxContent();
                        break;

                    case "HF":
                        this.hfContent();
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
            this.kygltable = this.kygltable + "var zoo_array_name = Array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');";
            this.kygltable = this.kygltable + "var zoo_array_nums = Array(" + MyFunc.twelveNumUI + ");";
            this.kygltable = this.kygltable + "var zoo_array = Array(\"B1\",\"B2\",\"B3\",\"B4\",\"B5\",\"B6\",\"B7\",\"B8\",\"B9\",\"BA\",\"BB\",\"BC\");";
        }

        private void pdContent()
        {
            this.kygltable = this.kygltable + "var zoo_array_name = Array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');";
            this.kygltable = this.kygltable + "var zoo_array_nums = Array(" + MyFunc.twelveNumUI + ");";
            this.kygltable = this.kygltable + "var zoo_array = Array(\"B1\",\"B2\",\"B3\",\"B4\",\"B5\",\"B6\",\"B7\",\"B8\",\"B9\",\"BA\",\"BB\",\"BC\");";
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
            this.kygltable = "var type_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\",\"SODD\",\"SEVEN\");\n";
            this.kygltable = this.kygltable + "var type_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\",\"SODD\",\"SEVEN\");\n";
            this.kygltable = this.kygltable + "var type_array2 = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\");";
        }

        private void reContent()
        {
            this.kygltable = "var type_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\");";
        }

        private void sxContent()
        {
            this.kygltable = "var\ttype_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\",\"R\",\"G\",\"B\");";
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
            this.kygltable = "var type_array = Array(\"ODD\",\"EVEN\",\"OVER\",\"UNDER\",\"SODD\",\"SEVEN\",\"RODD\",\"GEVEN\",\"BODD\");";
        }
    }
}

