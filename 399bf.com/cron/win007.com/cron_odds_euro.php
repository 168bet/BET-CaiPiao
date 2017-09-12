<?php
/*+-----------------------------------------
  | 百家欧赔
  |
  | http://interface.win007.com/lq/1x2.aspx
  | 参数：
  | 不带参数：从现在开始起10天内的所有赔率
  | 参数：?day=n, 从现在开始起n天内的所有赔率
  | 参数：?date=yyyy-MM-dd  指定日期的所有赔率
  | 参数：?min=5  近5分钟的变化数据
  +------------------------------------------*/

require_once 'global.func.php';
require_once 'conn.php';

$day = isset($argv[1]) ? intval($argv[1]) : 0;
$date = isset($argv[2]) ? strval($argv[2]) : '';
$min = isset($argv[3]) ? intval($argv[3]) : 0;

$method = 'method=lx2';
$day && $method = 'method=lx2&p2=&p3=&p1=' . $day;
$date && $method = 'method=lx2&p1=&p3=&p2=' . $date;
$min && $method = 'method=lx2&p1=&p2=&p3=' . $min;

$xml = http_get(PROXY_URL . $method, 3);

if ($xml->count()) { //有赛事

    foreach ($xml->children() as $child) {

        if ($child->odds->count()) { //有指数

            foreach ($child->odds->children() as $c) {
                do_task(array_merge((array)strval($child->id), explode(',', $c)));
            }
        }
    }
} else {

    exit(json_encode(['error' => '返回数据为空.']));
}

$mysqli->close();

/**
 * 将记录写入表`bt_europeodds`及`bt_europeodds_detail`
 * @param array $data
 */
function do_task(array $data)
{
    $scheduleid = $data[0];                                     //比赛id
    $companyid = $data[1];                                      //公司id
    $homewin_f = $data[3];                                      //初盘主胜
    $guestwin_f = $data[4];                                     //初盘客胜
    $homewin = $data[5];                                        //主胜
    $guestwin = $data[6];                                       //客胜
    $homerate_f = win_rate($homewin_f, $guestwin_f);            //初盘主胜率
    $guestrate_f = win_rate($guestwin_f, $homewin_f);           //初盘主胜率
    $returnrate_f = return_rate($homerate_f, $homewin_f);       //初盘返回率
    $homerate = win_rate($homewin, $guestwin);                  //初盘主胜率
    $guestrate = win_rate($guestwin, $homewin);                 //初盘主胜率
    $returnrate = return_rate($homerate, $homewin);             //初盘返回率
    $modifytime = strtotime($data[7]);

    //写入表`bt_europeodds`
    $r = get_one('`bt_europeodds`', '`scheduleid`=' . $scheduleid . ' AND `companyid`=' . $companyid);

    if ($r) {
        if ((int)$r['modifytime'] < $modifytime) { //比较赔率更新时间
            $update_sql = "UPDATE `bt_europeodds`
                            SET `scheduleid` = $scheduleid,
                                `companyid` = $companyid,
                                `homewin_f` = $homewin_f,
                                `guestwin_f` = $guestwin_f,
                                `homewin` = $homewin,
                                `guestwin` = $guestwin,
                                `probability_h0` = $homerate_f,
                                `probability_g0` = $guestrate_f,
                                `probability_t0` = $returnrate_f,
                                `probability_h1` = $homerate,
                                `probability_g1` = $guestrate,
                                `probability_t1` = $returnrate,
                                `modifytime` = $modifytime
                            WHERE `scheduleid` = $scheduleid AND `companyid` = $companyid";

            $GLOBALS['mysqli']->query($update_sql);
        }
    } else {
        $insert_sql = "INSERT INTO `bt_europeodds` VALUES (
                    $scheduleid,
                    $companyid,
                    $homewin_f,
                    $guestwin_f,
                    $homewin,
                    $guestwin,
                    $homerate_f,
                    $guestrate_f,
                    $returnrate_f,
                    $homerate,
                    $guestrate,
                    $returnrate,
                    $modifytime
                )";

        $GLOBALS['mysqli']->query($insert_sql);
    }

    //写入表`bt_europeodds_detail`
    $r = get_one('`bt_europeodds_detail`', '`scheduleid`=' . $scheduleid . ' AND `companyid`=' . $companyid, '*', '`modifytime` DESC');

    $insert_sql = "INSERT INTO `bt_europeodds_detail` VALUES (
                    $scheduleid,
                    $companyid,
                    $homewin,
                    $guestwin,
                    $homerate,
                    $guestrate,
                    $returnrate,
                    $modifytime
                )";

    //执行插入操作的情况：
    // 1、表`bt_europeodds_detail`中无记录
    // 2、有记录，赔率更新时间更新且赔率发生变化
    if (!$r || ((int)$r['modifytime'] < $modifytime && !is_same($data, $r))) {

        $GLOBALS['mysqli']->query($insert_sql);
    }

}

/**
 * 获取一条记录
 * @param $where
 * @param $field
 * @param $table
 * @param $order
 * @return array|bool
 */
function get_one($table, $where, $field = '*', $order = '')
{
    $sql = 'SELECT ' . $field .
        ' FROM ' . $table .
        ' WHERE ' . $where .
        ($order ? ' ORDER BY ' . $order : '') .
        ' LIMIT 1';

    $rst = $GLOBALS['mysqli']->query($sql);

    if (!$rst)
        return false;

    return $rst->fetch_assoc();
}


/**
 * 计算公式：
 * 主队胜率=(float)Math.Round(1/(1+主胜赔率/客胜赔率)*100,2);
 * 客队胜率=(float)Math.Round(1/(1+客胜赔率/主胜赔率)*100,2);
 * @param $dividend
 * @param $divisor
 * @return float
 */
function win_rate($dividend, $divisor)
{
    return round(1 / (1 + $dividend / $divisor) * 100, 2);
}

/**
 * 计算公式：
 * 返 回 率=(float)Math.Round(主胜胜率*主队赔率,2);
 * @param $winrate
 * @param $win
 * @return float
 */
function return_rate($winrate, $win)
{
    return round($winrate * $win, 2);
}

/**
 * 检查赔率是否有变化
 * @param array $new
 * @param array $old
 * @return bool
 */
function is_same(array $new, array $old)
{
    if ($new[5] != $old['homewin']) return false;  //比较主胜赔率
    if ($new[6] != $old['guestwin']) return false; //比较客胜赔率
    return true;
}









