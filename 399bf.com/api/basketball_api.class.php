<?php
/**
 * 球探网篮球接口
 */

final class basketball_api
{
    /**
     * @var string 协议
     */
    private static $scheme = 'http://';

    /**
     * @var string 主机域名
     */
    private static $host = 'interface.win007.com';

    /**
     * @var int 端口
     */
    private static $port = 80;

    /**
     * @var string 路径
     */
    private static $path = '/lq/';

    /**
     * 获取 api url
     *
     * @return string api url
     */
    private static function _api_url()
    {
        return self::$scheme.   // 协议
        self::$host.':'.        // 主机域名
        self::$port.            // 端口
        self::$path;            // 路径
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
        return $return;
    }

    /**
     * 篮球比分接口：当天比赛数据
     *
     * @method get 提交方式
     * @return array 返回的数据
     */
    public static function today()
    {
        $api_url = self::_api_url();
        $api_url .= 'today.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 即时变化的数据
     *
     * @method get 提交方式
     * @return array 返回的数据
     */
    public static function change()
    {
        $api_url = self::_api_url();
        $api_url .= 'change.xml';
        return self::_http_get($api_url);
    }

    /**
     * 赛程赛果
     * <code>
     *  http://interface.win007.com/lq/LqSchedule.aspx?sclassid=1&season=12-13 获取12-13赛季数据
     *  http://interface.win007.com/lq/LqSchedule.aspx?id=12345,123456 获取指定比赛
     * </code>
     *
     * @param string $time 指定时期的比赛数据，时期为 0时到24时计为一天
     * @param int $sclassid 赛事类型ID($sclassid和$season取整个赛季数据)
     * @param string $season 赛季
     * @param string $id 比赛ID
     * @method get 提交方式
     * @return array
     */
    public static function lqschedule($time, $sclassid, $season, $id)
    {
        $api_url = self::_api_url();
        $api_url .= 'LqSchedule.aspx?p=1';
        if (!empty($time)) $api_url .= '&time=' . $time;
        if (!empty($sclassid)) $api_url .= '&sclassid=' . $sclassid;
        if (!empty($season)) $api_url .= '&season=' . $season;
        if (!empty($id)) $api_url .= '&id=' . $id;
        return self::_http_get($api_url);
    }

    /**
     * 联赛、赛事类型
     *
     * @method get 提交方式
     * @return array
     */
    public static function lqleague_xml()
    {
        $api_url = self::_api_url();
        $api_url .= 'LqLeague_Xml.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 球队
     *
     * @method get 提交方式
     * @return array
     */
    public static function lqteam_xml()
    {
        $api_url = self::_api_url();
        $api_url .= 'LqTeam_Xml.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 技术统计
     *
     * @param int $id 比赛ID
     * @method get 提交方式
     * @return array
     */
    public static function lqteahniccount($id)
    {
        $api_url = self::_api_url();
        $api_url .= 'LqTeahnicCount.aspx?p=1';
        if (!empty($id)) $api_url .= '&id=' . $id;
        return self::_http_get($api_url);
    }

    /**
     * 球员
     *
     * @method get 提交方式
     * @return array
     */
    public static function lqplayer_xml()
    {
        $api_url = self::_api_url();
        $api_url .= 'LqPlayer_xml.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 篮球赔率接口
     *
     * @method get 提交方式
     * @return array
     */
    public static function lqodds()
    {
        $api_url = self::_api_url();
        $api_url .= 'LqOdds.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 半场赔率
     *
     * @method get 提交方式
     * @return array
     */
    public static function lqhalfodds()
    {
        $api_url = self::_api_url();
        $api_url .= 'LqHalfOdds.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 小节赔率
     *
     * @method get 提交方式
     * @return array
     */
    public static function partodds()
    {
        $api_url = self::_api_url();
        $api_url .= 'PartOdds.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 赔率变化数据
     *
     * @method get 提交方式
     * @return array
     */
    public static function ch_oddsbsk()
    {
        $api_url = self::_api_url();
        $api_url .= 'ch_oddsBsk.xml';
        return self::_http_get($api_url);
    }

    /**
     * 历史盘口
     *
     * @param string $date 日期
     * @method get 提交方式
     * @return array
     */
    public static function lqhistoryodds($date)
    {
        $api_url = self::_api_url();
        $api_url .= 'LqHistoryOdds.aspx?p=1';
        if (!empty($date)) $api_url .= '&date=' . $date;
        return self::_http_get($api_url);
    }

    /**
     * 百家欧赔接口
     * 说明：不带参数，从现在开始起10天内的所有赔率
     *
     * @param int $day 从现在开始起n天内的所有赔率
     * @param string $date 指定日期的所有赔率
     * @param int $min 近5分钟的变化数据
     * @method get 提交方式
     * @return array
     */
    public static function lx2($day, $date, $min)
    {
        $api_url = self::_api_url();
        $api_url .= '1x2.aspx?p=1';
        if (!empty($day)) $api_url .= '&day=' . $day;
        if (!empty($date)) $api_url .= '&date=' . $date;
        if (!empty($min)) $api_url .= '&min=' . $min;
        return self::_http_get($api_url);
    }

    /**
     * 比赛删除，改时间记录
     * 说明：8小时内的赛程删除、比赛时间修改记录
     *
     * @method get 提交方式
     * @return array
     */
    public static function lqmodifyrecord()
    {
        $api_url = self::_api_url();
        $api_url .= 'lqModifyRecord.aspx';
        return self::_http_get($api_url);
    }

    /**
     * 积分、联盟排名
     * <code>
     *  http://interface.win007.com/lq/LqRankings.aspx?sclassid=1&season=15-16
     * </code>
     *
     * @param int $sclassid 联赛ID
     * @param string $season 赛季
     * @method get 提交方式
     * @return array
     */
    public static function lqrankings($sclassid, $season)
    {
        $api_url = self::_api_url();
        $api_url .= 'LqRankings.aspx?p=1';
        if (!empty($sclassid)) $api_url .= '&sclassid=' . $sclassid;
        if (!empty($season)) $api_url .= '&season=' . $season;
        return self::_http_get($api_url);
    }

    /**
     * 文字直播
     * 说明：一般情况，可以通过“http://interface.win007.com/lq/today.aspx”第34项
     *      与“http://interface.win007.com/lq/change.xml”第14项取得实时直播内容。
     *
     * @param int $id 比赛ID
     * @method get 提交方式
     * @return array
     */
    public static function textlive($id)
    {
        $api_url = self::_api_url();
        $api_url .= 'TextLive.aspx?p=1';
        if(!empty($id)) $api_url .= '&id='.$id;
        return self::_http_get($api_url);
    }

    /**
     * 阵容、伤停、预测、赛前简报
     * 说明：不传参数，返回（-24到+48)小时内比赛的阵容
     *
     * @param int $id 比赛ID
     * @method get 提交方式
     * @return array
     */
    public static function lineup($id)
    {
        $api_url = self::_api_url();
        $api_url .= 'Lineup.aspx?p=1';
        if (!empty($id)) $api_url .= '&id=' . $id;
        return self::_http_get($api_url);
    }

    /**
     * NBA转会记录
     * 说明：不带参数，返回一个月内的转会数据
     * <code>
     *  http://interface.win007.com/lq/Transfer.aspx?day=10
     * </code>
     *
     * @param int $day 返回day天内的转会数据
     * @method get 提交方式
     * @return array
     */
    public static function transfer($day)
    {
        $api_url = self::_api_url();
        $api_url .= 'Transfer.aspx?p=1';
        if (!empty($day)) $api_url .= '&day=' . $day;
        return self::_http_get($api_url);
    }


}
