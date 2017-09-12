namespace MyTeam.basket
{
    using System;
    using System.Text;
    using System.Web;

    public class basketball
    {
        private static string getMethodMenu(string strMethod)
        {
            StringBuilder builder = new StringBuilder();
            if (strMethod == "d")
            {
                builder.Append("&nbsp;<font style=background-color=#0099FF><a href=basketball_d.aspx?method=d target=body_show>让球</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;<a href=basketball_d.aspx?method=d target=body_show>让球</A>&nbsp;");
            }
            if (strMethod == "s")
            {
                builder.Append("&nbsp;<font style=background-color=#0099FF><a href=basketball_s.aspx?method=s target=body_show>上半</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;<a href=basketball_s.aspx?method=s target=body_show>上半</A>&nbsp;");
            }
            if (strMethod == "rqgg")
            {
                builder.Append("&nbsp;<font style=background-color=#0099FF><a href=basketball_rqgg.aspx?method=rqgg target=body_show>让球过关</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;<a href=basketball_rqgg.aspx?method=rqgg target=body_show>让球过关</A>&nbsp;");
            }
            if (strMethod == "ys")
            {
                builder.Append("&nbsp;<font style=background-color=#0099FF><a href=basketball_ys.aspx?method=ys target=body_show>已开赛</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;<a href=basketball_ys.aspx?method=ys target=body_show>已开赛</A>&nbsp;");
            }
            return builder.ToString();
        }

        private static string GetPath(string strMethod)
        {
            string text = "";
            string str = strMethod;
            if (str == null)
            {
                return text;
            }
            str = string.IsInterned(str);
            if (str == "d")
            {
                return "basketball_d.aspx";
            }
            if (str == "s")
            {
                return "basketball_s.aspx";
            }
            if (str != "rqgg")
            {
                return text;
            }
            return "basketball_rqgg.aspx";
        }

        private static string getSelectABCD(string ltype, string strMethod)
        {
            string text = "&nbsp; 线上操盘:<select id='ltype' name='ltype' onChange='document.forms[0].submit()'>";
            if (ltype == "A")
            {
                text = text + "<option value='A' selected>六合彩A</option>";
            }
            else
            {
                text = text + "<option value='A'>六合彩A</option>";
            }
            if (ltype == "B")
            {
                text = text + "<option value='B' selected>六合彩B</option>";
            }
            else
            {
                text = text + "<option value='B'>六合彩B</option>";
            }
            if ((ltype == "C") || (ltype == ""))
            {
                text = text + "<option value='C' selected>六合彩C</option>";
            }
            else
            {
                text = text + "<option value='C'>六合彩C</option>";
            }
            if (ltype == "D")
            {
                text = text + "<option value='D' selected>六合彩D</option>";
            }
            else
            {
                text = text + "<option value='D'>六合彩D</option>";
            }
            return (text + "</select>");
        }

        private static string getSelectRetime(string retime)
        {
            string text = "<select id='retime' name='retime' onChange='document.forms[0].submit()'> ";
            if (retime == "-1")
            {
                text = text + "<option value='-1' selected>不更新</option>";
            }
            else
            {
                text = text + "<option value='-1'>不更新</option>";
            }
            if (retime == "180")
            {
                text = text + "<option value='180' selected>180秒</option>";
            }
            else
            {
                text = text + "<option value='180'>180秒</option>";
            }
            return (text + "</select>");
        }

        private static string GetSelectZD()
        {
            string text = "注单:<select id='selectZD' name='selectZD' onChange='document.forms[0].submit();'>";
            if ((HttpContext.Current.Session["sessionSelectZD"] != null) && (HttpContext.Current.Session["sessionSelectZD"].ToString() == "有单"))
            {
                text = text + "<option value='有单' selected>有单</option>";
            }
            else
            {
                text = text + "<option value='有单'>有单</option>";
            }
            if ((HttpContext.Current.Session["sessionSelectZD"] != null) && (HttpContext.Current.Session["sessionSelectZD"].ToString() == "全部"))
            {
                text = text + "<option value='全部' selected>全部</option>";
            }
            else
            {
                text = text + "<option value='全部'>全部</option>";
            }
            return (text + "</select>");
        }

        private static string GetStaticCS()
        {
            string text = "成数:<select id='staticCS' name='staticCS' onChange='document.forms[0].submit();'>";
            if ((HttpContext.Current.Session["sessionSelectStaticCS"] != null) && (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部"))
            {
                text = text + "<option value='全部' selected>全部</option>";
            }
            else
            {
                text = text + "<option value='全部'>全部</option>";
            }
            if ((HttpContext.Current.Session["sessionSelectStaticCS"] != null) && (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "自己成数"))
            {
                text = text + "<option value='自己成数' selected>自己成数</option>";
            }
            else
            {
                text = text + "<option value='自己成数'>自己成数</option>";
            }
            return (text + "</select>");
        }

        private static string pintingAgenceGdMenu(string ltype, string retime, string strMethod)
        {
            string text3 = (("<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN' > \n<html>\n<head>\n<meta name='GENERATOR' Content='Microsoft Visual Studio .NET 7.1'>\n<meta name='CODE_LANGUAGE' Content='C#'>\n<meta name=vs_defaultClientScript content='JavaScript'>\n<meta name=vs_targetSchema content='http://schemas.microsoft.com/intellisense/ie5'>\n" + "<meta http-equiv=refresh content='" + retime + "'>\n<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>\n<link href='css/css.css' rel='stylesheet' type='text/css'>\n") + "</head>\n<body topmargin=2 leftmargin=0>\n<form name=topMenu id=topMenu method=post runat=server><table width='800' border='0' cellspacing='0' cellpadding='0'>\n<tr>") + "<td>\n<table border='0' cellspacing='0' cellpadding='0' >\n<tr><td>" + getSelectABCD(ltype, strMethod) + "</td>";
            return ((text3 + "<td> - 刷新:" + getSelectRetime(retime) + "</td><td id='dt_now'> - " + GetStaticCS() + " - " + GetSelectZD() + "&nbsp;-</td>") + "<td style = 'border:1px #888888 solid; background-color: #bbbbbb;'>" + getMethodMenu(strMethod) + "</td></tr></table></td></tr>\n</table>\n");
        }

        public static void TopMenuProcess(string varMethod, double abcadd)
        {
            string ltype = "C";
            string retime = "-1";
            string strMethod = varMethod;
            if (HttpContext.Current.Request.Form["selectZD"] != null)
            {
                HttpContext.Current.Session["sessionSelectZD"] = HttpContext.Current.Request.Form["selectZD"].ToString();
            }
            else if (HttpContext.Current.Session["sessionSelectZD"] == null)
            {
                HttpContext.Current.Session["sessionSelectZD"] = "无有单";
            }
            if (HttpContext.Current.Request.Form["staticCS"] != null)
            {
                HttpContext.Current.Session["sessionSelectStaticCS"] = HttpContext.Current.Request.Form["staticCS"].ToString();
            }
            else if (HttpContext.Current.Session["sessionSelectStaticCS"] == null)
            {
                HttpContext.Current.Session["sessionSelectStaticCS"] = "全部";
            }
            if (HttpContext.Current.Request.Form["ltype"] != null)
            {
                ltype = HttpContext.Current.Request.Form["ltype"].ToString().Trim();
                HttpContext.Current.Session["basketball_b_ltype"] = ltype;
            }
            else if (HttpContext.Current.Session["basketball_b_ltype"] != null)
            {
                ltype = HttpContext.Current.Session["basketball_b_ltype"].ToString().Trim();
            }
            if (HttpContext.Current.Request.Form["retime"] != null)
            {
                retime = HttpContext.Current.Request.Form["retime"].ToString().Trim();
                HttpContext.Current.Session["basketball_b_retime"] = retime;
            }
            else if (HttpContext.Current.Session["basketball_b_retime"] != null)
            {
                retime = HttpContext.Current.Session["basketball_b_retime"].ToString().Trim();
            }
            if (ltype.ToUpper() == "A")
            {
                abcadd = 0.01;
            }
            if (ltype.ToUpper() == "B")
            {
                abcadd = 0.03;
            }
            if (ltype.ToUpper() == "D")
            {
                abcadd = -0.015;
            }
            string s = pintingAgenceGdMenu(ltype, retime, strMethod);
            HttpContext.Current.Response.Write(s);
        }
    }
}

