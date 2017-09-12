<?php
/**
 * sportsdt.com 足球数据接口
 */

final class football_api
{
    /**
     * @var string 协议
     */
    private static $scheme = 'http://';

    /**
     * @var string 主机域名
     */
    private static $host = 'feed.sportsdt.com';

    /**
     * @var int 端口
     */
    private static $port = 80;

    /**
     * @var string 请求文件
     */
    private static $file = '/soccer/';

    /**
     * @var string 授权参数
     */
    private static $from = 'from=xiansu';

    /**
     * 获取 api url
     *
     * @return string api url
     */
    private static function _api_url()
    {
        return self::$scheme.     // 协议
               self::$host.':'.   // 主机域名
               self::$port.       // 端口
               self::$file.'?'.   // 请求文件
               self::$from;       // 授权参数
    }

    /**
     * http get 请求
     *
     * @param string $api_url 请求地址
     * @return array 返回的数据
     */
    private static function _http_get($api_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);
        return json_decode($return, true);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //// 文字直播

    /**
     * 获取赛程文字直播比赛标识
     *
     * @method get 提交方式
     * @return array 返回的数据
     */
    public static function getwlivedatelistId()
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getwlivedatelistId';
        return self::_http_get($api_url);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //// 比赛信息

    /**
     * 赛程赛果列表
     * 根据日期获取赛程赛果列表
     *
     * @param string $date 比赛日期
     * @method get 提交方式
     * @return array 返回的数据
     */
    public static function getschedulebydate($date)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getschedulebydate';
        if(!empty($date)) $api_url .= '&date='.$date;
        return self::_http_get($api_url);
    }

    /**
     * 即时比分列表
     * 获取当前7M即时比分比赛列表
     *
     * @method get 提交方式
     * @return array
     */
    public static function getlivegame()
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getlivegame';
        return self::_http_get($api_url);
    }

    /**
     * 实时比分数据信息
     * 获取即时比分实时数据信息
     *
     * @method get 提交方式
     * @return array
     */
    public static function getlivedata()
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getlivedata';
        return self::_http_get($api_url);
    }

    /**
     * 比赛基本信息
     *
     * @param int $gameid 7m比赛编号
     * @method get 提交方式
     * @return array
     */
    public static function getgameinfo($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getgameinfo';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 比赛预测、阵容
     * 获取比赛预测、阵容预测数据
     *
     * @param int $gameid 7m比赛编号
     * @method get 提交方式
     * @return array
     */
    public static function getgameprediction($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getgameprediction';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 比赛往绩数据
     *
     * @param int $gameid 7m比赛编号
     * @method get 提交方式
     * @return array
     */
    public static function getgameanalyse($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getgameanalyse';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 进球名单
     * 获取某一场比赛的进球情况、数据统计、球员替换
     *
     * @param int $gameid 7m比赛编号
     * @method get 提交方式
     * @return array
     */
    public static function getgamegoaldata($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getgamegoaldata';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 近期取消、延期、腰斩的赛事
     *
     * @method get 提交方式
     * @return array
     */
    public static function getrevocatorygame()
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getrevocatorygame';
        return self::_http_get($api_url);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //// 足球球队

    /**
     * 球队基本资料信息
     *
     * @param int $teamid 7m球队编号
     * @method get 提交方式
     * @return array
     */
    public static function getteaminfo($teamid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getteaminfo';
        if(!empty($teamid)) $api_url .= '&teamid='.$teamid;
        return self::_http_get($api_url);
    }

    /**
     * 球队近两年塞绩、未来赛程、历史统计数据
     *
     * @param int $teamid 7m球队编号
     * @method get 提交方式
     * @return array
     */
    public static function getteamstats($teamid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getteamstats';
        if(!empty($teamid)) $api_url .= '&teamid='.$teamid;
        return self::_http_get($api_url);
    }

    /**
     * 球队列表及对应体彩名称
     *
     * @param int $teamid 7m球队编号，0为获取全部列表
     * @method get 提交方式
     * @return array
     */
    public static function getteam_lotteryname($teamid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getteam_lotteryname';
        if(!empty($teamid) || $teamid == 0) $api_url .= '&teamid='.$teamid;
        return self::_http_get($api_url);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //// 足球球员

    /**
     * 球员基本资料信息
     *
     * @param int $playerid 7m球员编号
     * @method get 提交方式
     * @return array
     */
    public static function getplayerinfo($playerid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getplayerinfo';
        if(!empty($playerid)) $api_url .= '&playerid='.$playerid;
        return self::_http_get($api_url);
    }

    /**
     * 球员比赛技术统计
     * 获取球员个人近两年比赛数据统计
     *
     * @param int $playerid 7m球员编号
     * @method get 提交方式
     * @return array
     */
    public static function getplayerstats($playerid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getplayerstats';
        if(!empty($playerid)) $api_url .= '&playerid='.$playerid;
        return self::_http_get($api_url);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //// 足球赛事

    /**
     * 赛事基本信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitioninfo($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitioninfo';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 赛程
     * 获取赛程列表
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionschedule($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionschedule';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 积分排名
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionstanding($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionstanding';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 盘路统计
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionoddsway($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionoddsway';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 射手榜
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionshooter($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionshooter';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 波胆分布统计
     * 获取某个赛事的波胆分布统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitioncorrectscore($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitioncorrectscore';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 最先入秋、失球统计
     * 获取某个赛事的最先入球、失球统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionfgetmiss($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionfgetmiss';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 进球时间分布统计
     * 获取某个赛事的进球时间分布统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitiongoaltime($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitiongoaltime';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 攻守统计
     * 获取某个赛事的进攻与防守统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitiongetmiss($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitiongetmiss';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 最常见赛果统计
     * 获取某个赛事中各种赛果的统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionfrequentresults($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionfrequentresults';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 半全场统计
     * 获取某个赛事中半场与全场的胜平负统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionhfstat($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionhfstat';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 上/下半场入球较多统计
     * 获取某个赛事中上/下半场入球较多的次数统计
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionhsscores($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionhsscores';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 入球总数及单双数统计
     * 获取某个赛事中全场入球总数统计与全场单双数统计
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionoddeven($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionoddeven';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 上、下盘全场入球统计
     * 获取某个赛事中上、下盘全场入球总数统计
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionoverunder($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionoverunder';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 球队总入球数统计
     * 获取某个赛事各支球队的总入球数统计信息
     *
     * @param int $competitionid 7m赛事编号
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionteamscores($competitionid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionteamscores';
        if(!empty($competitionid)) $api_url .= '&competitionid='.$competitionid;
        return self::_http_get($api_url);
    }

    /**
     * 资料库首页
     * 获取所有赛事名称列表
     *
     * @method get 提交方式
     * @return array
     */
    public static function getcompetitionlist()
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getcompetitionlist';
        return self::_http_get($api_url);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //// 足球指数

    /**
     * 亚盘指数单场
     * 获取单场的亚盘指数
     *
     * @param int $gameid 球队编号
     * @method get 提交方式
     * @return array
     */
    public static function getahoddsinfo($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getahoddsinfo';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 大小球指数单场
     * 获取单场的大小球指数
     *
     * @param int $gameid 球队编号
     * @method get 提交方式
     * @return array
     */
    public static function getouoddsinfo($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getouoddsinfo';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 欧盘指数单场
     * 获取单场的大小球指数
     *
     * @param int $gameid 球队编号
     * @method get 提交方式
     * @return array
     */
    public static function gethdaoddsinfo($gameid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=gethdaoddsinfo';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        return self::_http_get($api_url);
    }

    /**
     * 欧盘指数变化历史
     * 获取单场的欧盘指数单公司赔率变化历史
     *
     * @param int $gameid 球队编号
     * @param int $pid 公司编号
     * @method get 提交方式
     * @return array
     */
    public static function gethdaoddslog($gameid,$pid)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=gethdaoddslog';
        if(!empty($gameid)) $api_url .= '&gameid='.$gameid;
        if(!empty($pid)) $api_url .= '&pid='.$pid;
        return self::_http_get($api_url);
    }

    /**
     * 亚盘指数列表
     * 获取亚盘指数的列表
     *
     * @param int $t 1表示即时，2表示历史
     * @param int $pid 公司编号
     * @param string $date 历史日期（t=2的时候传）
     * @method get 提交方式
     * @return array
     */
    public static function getahoddslist($t,$pid,$date)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getahoddslist';
        if(!empty($t)) $api_url .= '&t='.$t;
        if(!empty($pid)) $api_url .= '&pid='.$pid;
        if(!empty($date)) $api_url .= '&date='.$date;
        return self::_http_get($api_url);
    }

    /**
     * 大小球指数列表
     * 获取大小球指数的列表
     *
     * @param int $t 1表示即时，2表示历史
     * @param int $pid 公司编号
     * @param string $date 历史日期（t=2的时候传）
     * @method get 提交方式
     * @return array
     */
    public static function getouoddslist($t,$pid,$date)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=getouoddslist';
        if(!empty($t)) $api_url .= '&t='.$t;
        if(!empty($pid)) $api_url .= '&pid='.$pid;
        if(!empty($date)) $api_url .= '&date='.$date;
        return self::_http_get($api_url);
    }

    /**
     * 欧盘指数列表
     *
     * @param int $t 1表示即时，2表示历史
     * @param int $pid 公司编号
     * @param string $date 历史日期（t=2的时候传）
     * @method get 提交方式
     * @return array
     */
    public static function gethdaoddslist($t,$pid,$date)
    {
        $api_url = self::_api_url();
        $api_url .= '&type=gethdaoddslist';
        if(!empty($t)) $api_url .= '&t='.$t;
        if(!empty($pid)) $api_url .= '&pid='.$pid;
        if(!empty($date)) $api_url .= '&date='.$date;
        return self::_http_get($api_url);
    }


}