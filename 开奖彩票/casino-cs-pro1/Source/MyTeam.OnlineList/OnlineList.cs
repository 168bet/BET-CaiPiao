namespace MyTeam.OnlineList
{
    using newball;
    using System;
    using System.Web;
    using System.Configuration;

    public class OnlineList
    {
        private static int OnlineTimeOut = int.Parse(ConfigurationSettings.AppSettings["OnlineTimeOut"]);

        private static void AddUser(string username, string sessid, string updatetime, string ip, string classid, string place)
        {
            lock (Global.OnlineList.SyncRoot)
            {
                int idx = FindUser(username);
                if (idx > -1)
                {
                    UpdateUser(idx, username, sessid, updatetime, ip, classid);
                }
                else
                {
                    idx = FindFirstUser();
                    Global.OnlineList[Global.ListCount][0] = username;
                    Global.OnlineList[Global.ListCount][1] = sessid;
                    Global.OnlineList[Global.ListCount][2] = updatetime;
                    Global.OnlineList[Global.ListCount][3] = ip;
                    Global.OnlineList[Global.ListCount][4] = classid;
                    Global.OnlineList[Global.ListCount][5] = "0";
                    Global.OnlineList[Global.ListCount][6] = "主页面";
                    Global.OnlineList[Global.ListCount][7] = place;
                    Global.ListCount++;
                }
            }
        }

        public static int CountUser()
        {
            int num = 0;
            lock (Global.OnlineList.SyncRoot)
            {
                for (int i = 0; i < 0x3e8; i++)
                {
                    if (Global.OnlineList[i][0] == null)
                    {
                        return num;
                    }
                    if (Global.OnlineList[i][5] == "0")
                    {
                        num++;
                    }
                }
            }
            return num;
        }

        private static void DelUser()
        {
            lock (Global.OnlineList.SyncRoot)
            {
                for (int i = 0; i < 0x3e8; i++)
                {
                    if (Global.OnlineList[i][2] == null)
                    {
                        break;
                    }
                    if (DateTime.Parse(Global.OnlineList[i][2]).AddMinutes((double) OnlineTimeOut) < DateTime.Now)
                    {
                        Global.OnlineList[i][5] = "1";
                    }
                }
            }
        }

        public static void DelUser(string username)
        {
            if (username != "")
            {
                lock (Global.OnlineList.SyncRoot)
                {
                    int index = FindUser(username);
                    if (index > -1)
                    {
                        Global.OnlineList[index][5] = "1";
                    }
                }
            }
        }

        private static int FindFirstUser()
        {
            lock (Global.OnlineList.SyncRoot)
            {
                for (int i = 0; i < 0x3e8; i++)
                {
                    if ((Global.OnlineList[i][0] == null) || (Global.OnlineList[i][5] == "1"))
                    {
                        return i;
                    }
                }
            }
            return -1;
        }

        private static int FindUser(string username)
        {
            int num = -1;
            lock (Global.OnlineList.SyncRoot)
            {
                if (username == "")
                {
                    return num;
                }
                for (int i = 0; i < 0x3e8; i++)
                {
                    if (username == Global.OnlineList[i][0])
                    {
                        return i;
                    }
                }
            }
            return num;
        }

        private static int FindUser(string username, string session)
        {
            int index = -1;
            lock (Global.OnlineList.SyncRoot)
            {
                index = FindUser(username);
                if ((index <= -1) || ((Global.OnlineList[index][1] == session) && (Global.OnlineList[index][5] != "1")))
                {
                    return index;
                }
                return -1;
            }
        }

        private static string GetCurPosition()
        {
            string text2 = HttpContext.Current.Request.Url.ToString().ToLower();
            int num = text2.LastIndexOf("/");
            int num2 = text2.LastIndexOf(".aspx");
            int length = text2.Length;
            if (((length > 1) && (length > (num + 1))) && (num2 > num))
            {
                switch (text2.Substring(num - 2, (num2 - num) + 7).ToString().Trim())
                {
                    case "in/main.aspx":
                        return "登入0-空白主页面";

                    case "in/frmindex.aspx":
                        return "登入0-空白主页面";

                    case "in/balljs.aspx":
                        return "登入0-结算-处理中";

                    case "in/balljsframe.aspx":
                        return "登入0-结算-列表";

                    case "in/chgpwd.aspx":
                        return "登入0-更改密码";

                    case "in/gamefen.aspx":
                        return "登入0-结算-比分";

                    case "in/gdadd.aspx":
                        return "登入0-股东管理-新增";

                    case "in/gdlist.aspx":
                        return "登入0-股东管理-列表";

                    case "in/gdlist_reportlist.aspx":
                        return "登入0-股东-注单统计列表";

                    case "in/gdlist_reportcontent.aspx":
                        return "登入0-股东-注单统计内容";

                    case "in/gdmsg.aspx":
                        return "登入0-股东管理-名细";

                    case "in/list.aspx":
                        return "登入0-定单修改";

                    case "in/mgrconfig.aspx":
                        return "登入0-公告-处理";

                    case "in/mgrconfiglist.aspx":
                        return "登入0-公告-列表";

                    case "in/mgrgame.aspx":
                        return "登入0-结算-列表";

                    case "in/orderlist.aspx":
                        return "登入0-定单-列表";

                    case "in/searchorder.aspx":
                        return "登入0-定单-查询";

                    case "in/userlist.aspx":
                        return "登入0-会员-列表";

                    case "in/userlist_reportlist.aspx":
                        return "登入0-会员-注单统计列表";

                    case "in/userlist_reportcontent.aspx":
                        return "登入0-会员-注单统计内容";

                    case "in/usermsg.aspx":
                        return "登入0-会员-详情";

                    case "in/userset.aspx":
                        return "登入0-会员-设定";

                    case "in/mgronline.aspx":
                        return "登入0-在线-列表";

                    case "in/mgronlinemsg.aspx":
                        return "登入0-在线-日志";

                    case "gd/main.aspx":
                        return "登入1(股东)-空白主页面";

                    case "gd/frmindex.aspx":
                        return "登入1(股东)-空白主页面";

                    case "gd/addsubuser.aspx":
                        return "登入1(股东)-子帐户-新增";

                    case "gd/chgpwd.aspx":
                        return "登入1(股东)-更改密码";

                    case "gd/dlsadd.aspx":
                        return "登入1(股东)-代理商-新增";

                    case "gd/dlslist.aspx":
                        return "登入1(股东)-代理商-列表";

                    case "gd/dlslist_reportlist.aspx":
                        return "登入1(股东)-代理商-注单统计列表";

                    case "gd/dlslist_reportcontent.aspx":
                        return "登入1(股东)-代理商-注单统计内容";

                    case "gd/dlsmsg.aspx":
                        return "登入1(股东)-代理商-详情";

                    case "gd/dlsset.aspx":
                        return "登入1(股东)-代理商-设定";

                    case "gd/football_bd.aspx":
                        return "登入1(股东)-足球-波胆";

                    case "gd/football_bdgg.aspx":
                        return "登入1(股东)-足球-波胆过关";

                    case "gd/football_bqc.aspx":
                        return "登入1(股东)-足球-半全场";

                    case "gd/football_bz.aspx":
                        return "登入1(股东)-二全中";

                    case "gd/football_d.aspx":
                        return "登入1(股东)-足球-让球";

                    case "gd/football_g.aspx":
                        return "登入1(股东)-足球-滚球";

                    case "gd/football_other.aspx":
                        return "登入1(股东)-总和大小";

                    case "gd/football_rqgg.aspx":
                        return "登入1(股东)-足球-滚球过关";

                    case "gd/football_rqsbc.aspx":
                        return "登入1(股东)-足球-让球上半场";

                    case "gd/football_sbgg.aspx":
                        return "登入1(股东)-足球-上半过关";

                    case "gd/football_select.aspx":
                        return "登入1(股东)-足球-选择联赛";

                    case "gd/football_ys.aspx":
                        return "登入1(股东)-足球-已开赛";

                    case "gd/report.aspx":
                        return "登入1(股东)-报表-查询";

                    case "gd/reportshow.aspx":
                        return "登入1(股东)-报表-列表";

                    case "gd/reportpartshownext.aspx":
                        return "登入1(股东)-报表-分帐明细";

                    case "gd/reportshowdls.aspx":
                        return "登入1(股东)-报表-代理商明细";

                    case "gd/reportshowend.aspx":
                        return "登入1(股东)-报表-明细清单";

                    case "gd/reportShowNoJs.aspx":
                        return "登入1(股东)-报表-未结算注单";

                    case "gd/tzinfo.aspx":
                        return "登入1(股东)-足球-统计明细";

                    case "gd/useradd.aspx":
                        return "登入1(股东)-会员-新增";

                    case "gd/usermsg.aspx":
                        return "登入1(股东)-会员-详情";

                    case "gd/userlist.aspx":
                        return "登入1(股东)-会员-列表";

                    case "gd/userset.aspx":
                        return "登入1(股东)-会员-设定";

                    case "gd/userset_reportlist.aspx":
                        return "登入1(股东)-会员-注单统计列表";

                    case "gd/userset_reportcontent.aspx":
                        return "登入1(股东)-会员-注单统计内容";

                    case "gd/zdladd.aspx":
                        return "登入1(股东)-总代理-新增";

                    case "gd/zdlmsg.aspx":
                        return "登入1(股东)-总代理-详情";

                    case "gd/zdllist.aspx":
                        return "登入1(股东)-总代理-列表";

                    case "gd/zdllist_reportlist.aspx":
                        return "登入1(股东)-总代理-注单统计列表";

                    case "gd/zdllist_reportcontent.aspx":
                        return "登入1(股东)-总理商-注单统计内容";

                    case "gd/zdlset.aspx":
                        return "登入1(股东)-总代理-设定";

                    case "dl/main.aspx":
                        return "登入2(总代理)-空白主页面";

                    case "dl/frmindex.aspx":
                        return "登入2(总代理)-空白主页面";

                    case "dl/addsubuser.aspx":
                        return "登入2(总代理)-子帐户-新增";

                    case "dl/chgpwd.aspx":
                        return "登入2(总代理)-更改密码";

                    case "dl/dlsadd.aspx":
                        return "登入2(总代理)-代理商-新增";

                    case "dl/dlslist.aspx":
                        return "登入2(总代理)-代理商-列表";

                    case "dl/dlslist_reportlist.aspx":
                        return "登入2(总代理)-代理商-注单统计列表";

                    case "dl/dlslist_reportcontent.aspx":
                        return "登入2(总代理)-代理商-注单统计内容";

                    case "dl/dlsmsg.aspx":
                        return "登入2(总代理)-代理商-详情";

                    case "dl/dlsset.aspx":
                        return "登入2(总代理)-代理商-设定";

                    case "dl/football_bd.aspx":
                        return "登入2(总代理)-足球-波胆";

                    case "dl/football_bdgg.aspx":
                        return "登入2(总代理)-足球-波胆过关";

                    case "dl/football_bqc.aspx":
                        return "登入2(总代理)-足球-半全场";

                    case "dl/football_bz.aspx":
                        return "登入2(总代理)-二全中";

                    case "dl/football_d.aspx":
                        return "登入2(总代理)-足球-让球";

                    case "dl/football_g.aspx":
                        return "登入2(总代理)-足球-滚球";

                    case "dl/football_other.aspx":
                        return "登入2(总代理)-总和大小";

                    case "dl/football_rqgg.aspx":
                        return "登入2(总代理)-足球-滚球过关";

                    case "dl/football_rqsbc.aspx":
                        return "登入2(总代理)-足球-让球上半场";

                    case "dl/football_sbgg.aspx":
                        return "登入2(总代理)-足球-上半过关";

                    case "dl/football_select.aspx":
                        return "登入2(总代理)-足球-选择联赛";

                    case "dl/football_ys.aspx":
                        return "登入2(总代理)-足球-已开赛";

                    case "dl/mysetting.aspx":
                        return "登入2(总代理)-我的设定";

                    case "dl/report.aspx":
                        return "登入2(总代理)-报表-查询";

                    case "dl/reportshow.aspx":
                        return "登入2(总代理)-报表-列表";

                    case "dl/reportpartshownext.aspx":
                        return "登入2(总代理)-报表-分帐明细";

                    case "dl/reportshowdls.aspx":
                        return "登入2(总代理)-报表-代理商明细";

                    case "dl/reportshowend.aspx":
                        return "登入2(总代理)-报表-明细清单";

                    case "dl/reportShowNoJs.aspx":
                        return "登入2(总代理)-报表-未结算注单";

                    case "dl/tzinfo.aspx":
                        return "登入2(总代理)-足球-统计明细";

                    case "dl/useradd.aspx":
                        return "登入2(总代理)-会员-新增";

                    case "dl/usermsg.aspx":
                        return "登入2(总代理)-会员-详情";

                    case "dl/userlist.aspx":
                        return "登入2(总代理)-会员-列表";

                    case "dl/userset.aspx":
                        return "登入2(总代理)-会员-设定";

                    case "dl/userset_reportlist.aspx":
                        return "登入2(总代理)-会员-注单统计列表";

                    case "dl/userset_reportcontent.aspx":
                        return "登入2(总代理)-会员-注单统计内容";

                    case "ls/agencemsg.aspx":
                        return "登入3(代理商)-空白主页面";

                    case "ls/frmindex.aspx":
                        return "登入3(代理商)-空白主页面";

                    case "ls/mgronlinemsg.aspx":
                        return "登入3(代理商)-子帐户";

                    case "ls/adduser.aspx":
                        return "登入3(代理商)-新增会员";

                    case "ls/chgpwd.aspx":
                        return "登入3(代理商)-更改密码";

                    case "ls/edituser.aspx":
                        return "登入3(代理商)-编辑帐户";

                    case "ls/football_bd.aspx":
                        return "登入3(代理商)-足球-波胆";

                    case "ls/football_bdgg.aspx":
                        return "登入3(代理商)-足球-波胆过关";

                    case "ls/football_bqc.aspx":
                        return "登入3(代理商)-足球-半全场";

                    case "ls/football_bz.aspx":
                        return "登入3(代理商)-二全中";

                    case "ls/football_d.aspx":
                        return "登入3(代理商)-足球-让球";

                    case "ls/football_g.aspx":
                        return "登入3(代理商)-足球-滚球";

                    case "ls/football_other.aspx":
                        return "登入3(代理商)-总和大小";

                    case "ls/football_rqgg.aspx":
                        return "登入3(代理商)-足球-滚球过关";

                    case "ls/football_rqsbc.aspx":
                        return "登入3(代理商)-足球-让球上半场";

                    case "ls/football_sbgg.aspx":
                        return "登入3(代理商)-足球-上半过关";

                    case "ls/football_select.aspx":
                        return "登入3(代理商)-足球-选择联赛";

                    case "ls/football_ys.aspx":
                        return "登入3(代理商)-足球-已开赛";

                    case "ls/mgruser.aspx":
                        return "登入3(代理商)-会员列表";

                    case "ls/mgruser_reportlist.aspx":
                        return "登入3(代理商)-会员-注单统计列表";

                    case "ls/mgruser_reportcontent.aspx":
                        return "登入3(代理商)-会员-注单统计内容";

                    case "ls/mysetting.aspx":
                        return "登入3(代理商)-我的设定";

                    case "ls/report.aspx":
                        return "登入3(代理商)-报表-查询";

                    case "ls/reportshow.aspx":
                        return "登入3(代理商)-报表-列表";

                    case "ls/reportpartshownext.aspx":
                        return "登入3(代理商)-报表-分帐明细";

                    case "ls/reportshownext.aspx":
                        return "登入3(代理商)-报表-总帐明细";

                    case "ls/reportShowNoJs.aspx":
                        return "登入3(代理商)-报表-未结算注单";

                    case "ls/system800.aspx":
                        return "登入3(代理商)-800系统";

                    case "ls/system800add.aspx":
                        return "登入3(代理商)-800系统-新增";

                    case "ls/tzinfo.aspx":
                        return "登入3(代理商)-足球-统计明细";

                    case "er/password.aspx":
                        return "前台(会员)-更改密码";
                }
            }
            return "未知位置";
        }

        public static string[][] GetOnlineList()
        {
            lock (Global.OnlineList.SyncRoot)
            {
                int num = CountUser();
                int index = 0;
                string[][] textArray = new string[num][];
                for (int i = 0; i < 0x3e8; i++)
                {
                    if (Global.OnlineList[i][0] == null)
                    {
                        break;
                    }
                    if (Global.OnlineList[i][5] == "0")
                    {
                        textArray[index] = new string[] { Global.OnlineList[i][0], Global.OnlineList[i][1], Global.OnlineList[i][2], Global.OnlineList[i][3], Global.OnlineList[i][4], Global.OnlineList[i][5], Global.OnlineList[i][6], Global.OnlineList[i][7] };
                        index++;
                    }
                }
                return textArray;
            }
        }

        private static string GetUserIp()
        {
            string text = "";
            if (HttpContext.Current.Request.ServerVariables["HTTP_X_FORWARDED_FOR"] != null)
            {
                text = HttpContext.Current.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim();
            }
            return (text + "|" + HttpContext.Current.Request.UserHostAddress.ToString().Trim());
        }

        public static bool isUserLogin(byte deep)
        {
            DelUser();
            int idx = -1;
            bool flag = false;
            string ip = GetUserIp();
            if (deep == 0)
            {
                idx = FindUser(HttpContext.Current.Session["username"].ToString().Trim(), HttpContext.Current.Session.Contents["sessid"].ToString().Trim());
                if (idx < 0)
                {
                    flag = false;
                }
                else
                {
                    UpdateUser(idx, HttpContext.Current.Session["username"].ToString().Trim(), HttpContext.Current.Session.Contents["sessid"].ToString().Trim(), DateTime.Now.ToString(), ip, HttpContext.Current.Session.Contents["classid"].ToString().Trim());
                    flag = true;
                }
            }
            if (deep == 1)
            {
                idx = FindUser(HttpContext.Current.Session["adminusername"].ToString().Trim(), HttpContext.Current.Session.Contents["adminsessid"].ToString().Trim());
                if (idx < 0)
                {
                    flag = false;
                }
                else
                {
                    UpdateUser(idx, HttpContext.Current.Session["adminusername"].ToString().Trim(), HttpContext.Current.Session.Contents["adminsessid"].ToString().Trim(), DateTime.Now.ToString(), ip, HttpContext.Current.Session.Contents["adminclassid"].ToString().Trim());
                    flag = true;
                }
            }
            if (deep != 2)
            {
                return flag;
            }
            idx = FindUser(HttpContext.Current.Session["adminsubname"].ToString().Trim(), HttpContext.Current.Session.Contents["adminsubsessid"].ToString().Trim());
            if (idx < 0)
            {
                return false;
            }
            UpdateUser(idx, HttpContext.Current.Session["adminsubname"].ToString().Trim(), HttpContext.Current.Session.Contents["adminsubsessid"].ToString().Trim(), DateTime.Now.ToString(), ip, HttpContext.Current.Session.Contents["adminsubclassid"].ToString());
            return true;
        }

        public static bool isUserLogin(string username, string sessid, string updatetime, string ip, string classid)
        {
            DelUser();
            int idx = FindUser(username, sessid);
            if (idx < 0)
            {
                return false;
            }
            UpdateUser(idx, username, sessid, updatetime, ip, classid);
            return true;
        }

        public static void NewUserLogin(string username, string sessid, string updatetime, string ip, string classid, string place)
        {
            AddUser(username, sessid, updatetime, ip, classid, place);
            DelUser();
        }

        public static void TickClassidDown(string ClassStr)
        {
            lock (Global.OnlineList.SyncRoot)
            {
                for (int i = 0; i < 0x3e8; i++)
                {
                    if ((Global.OnlineList[i][4] != null) && (ClassStr.IndexOf("," + Global.OnlineList[i][4].Trim() + ",") > 0))
                    {
                        Global.OnlineList[i][5] = "1";
                    }
                }
            }
        }

        private static void UpdateUser(string username, string sessid, string updatetime, string ip, string classid)
        {
            int index = FindUser(username);
            Global.OnlineList[index][0] = username;
            Global.OnlineList[index][1] = sessid;
            Global.OnlineList[index][2] = updatetime;
            Global.OnlineList[index][3] = ip;
            Global.OnlineList[index][4] = classid;
            Global.OnlineList[index][5] = "0";
            Global.OnlineList[index][6] = GetCurPosition();
        }

        private static void UpdateUser(int idx, string username, string sessid, string updatetime, string ip, string classid)
        {
            Global.OnlineList[idx][0] = username;
            Global.OnlineList[idx][1] = sessid;
            Global.OnlineList[idx][2] = updatetime;
            Global.OnlineList[idx][3] = ip;
            Global.OnlineList[idx][4] = classid;
            Global.OnlineList[idx][5] = "0";
            Global.OnlineList[idx][6] = GetCurPosition();
        }
    }
}

