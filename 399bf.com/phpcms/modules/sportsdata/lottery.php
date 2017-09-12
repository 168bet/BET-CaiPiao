<?php
/**
 * 彩票 caipiaokong.com
 */

defined('IN_PHPCMS') or exit('No permission resources.');
// 模块缓存路径
define('CACHE_SPORTSDATA_PATH', CACHE_PATH . 'caches_sportsdata' . DIRECTORY_SEPARATOR . 'caches_data' . DIRECTORY_SEPARATOR);
// 加载模块全局函数
pc_base::load_app_func('global');

class lottery
{
    //表前缀
    private $prefix = 'cp_';

    //数据库后缀
    private $suffix = '_db';

    //彩票分类
    private $class = [
        'all_fc' => '全国福利彩票',
        'all_tc' => '全国体育彩票',
        'not_all' => '地方彩种',
        'high' => '高频彩种'
    ];

    //地区
    private $area = [
        'all' => '全国',
        'xg' => '香港',
        'gd' => '广东',
        'bj' => '北京',
        'cq' => '重庆'
    ];

    private  $province = [
        '华东六省',
        'bj' => '北京',
        '天津',
        '安徽',
        '福建',
        '湖北',
        '河南',
        '河北',
        '辽宁',
        '山东',
        '云南',
        '贵州',
        '四川',
        '新疆',
        '上海',
        'cq' => '重庆',
        'gd' => '广东',
        '广东深圳',
        '广西',
        '黑龙江',
        '湖南',
        '江苏',
        '内蒙古',
        '山西',
        '浙江',
        '海南',
        'xg' => '香港'
    ];

    private $color = [
        'red'   => ['1','7','13','19','23','29','35','45','2','8','12','18','24','30','34','40','46'],
        'blue'  => ['3','9','15','25','31','37','41','47','4','10','14','20','26','36','42','48'],
        'green' => ['5','11','17','21','27','33','39','43','49','6','16','22','28','32','38','44'],
    ];

    private $colorArr = [
        '1'  => '红色', '7'  => '红色', '13' => '红色', '19' => '红色', '23' => '红色', '29' => '红色', '35' => '红色', '45' => '红色', '2'  => '红色', '8'  => '红色', '12' => '红色', '18' => '红色', '24' => '红色', '30' => '红色', '34' => '红色', '40' => '红色', '46' => '红色',
        '3'  => '蓝色', '9' => '蓝色', '15' => '蓝色', '25' => '蓝色', '31' => '蓝色', '37' => '蓝色', '41' => '蓝色', '47' => '蓝色', '4' => '蓝色', '10' => '蓝色', '14' => '蓝色', '20' => '蓝色', '26' => '蓝色', '36' => '蓝色', '42' => '蓝色', '48' => '蓝色',
        '5'  => '绿色', '11' => '绿色', '17' => '绿色', '21' => '绿色', '27' => '绿色', '33' => '绿色', '39' => '绿色', '43' => '绿色', '49' => '绿色', '6' => '绿色', '16' => '绿色', '22' => '绿色', '28' => '绿色', '32' => '绿色', '38' => '绿色', '44' => '绿色',
    ];

    private $num = [
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
    ];

    function __construct()
    {
        $this->xglhc_db = pc_base::load_model('xglhc_model');
        $this->qxc_db = pc_base::load_model('qxc_model');
        $this->cqssc_db = pc_base::load_model('cqssc_model');
        $this->bjpks_db = pc_base::load_model('bjpks_model');
        $this->gdklsf_db = pc_base::load_model('gdklsf_model');
        $this->class_db = pc_base::load_model('class_model');
    }

    //开奖信息
    public function info() {
        $id     = $_GET['id'] ? $_GET['id'] : 1;
        $pinyin = $_GET['pinyin'] ? $_GET['pinyin'] : '';

        if (!empty($pinyin)) {
            $pinyinArr = [
                'qxc'    => 1,
                'xglhc'  => 2,
                'gdklsf' => 3,
                'bjpks'  => 4,
                'cqssc'  => 5,
            ];

            $id = $pinyinArr[$pinyin];
        }

        $number = $_GET['number'];
        $date = $_GET['date'];

        $class     = $this->class_db->select();
        $classMenu = [];

        foreach ($class as $item) {

            if ($item['pinyin'] === 'xglhc') continue; //暂时注释香港开奖

            $data['id']   = $item['id'];
            $data['name'] = $item['name'];

            if ($id == $item['id']) {
                $lotteryName   = $item['pinyin'] . "_db";
                $lotteryNameCn = $item['name'];
                $lotteryTime   = $item['time'];
                $lotteryIsHigh = $item['ishigh'];
                $lotteryPinyin = $item['pinyin'];
                //seo
                $SEO['title'] = $lotteryNameCn . (strpos($lotteryNameCn, '开奖') ? '_399彩迷' : '开奖_399彩迷');
            }

            if ($item['ishigh'] == 1) {
                $classMenu[3]['data'][] = $data;
                $classMenu[3]['name']   = '高频彩种';
                continue;
            }

            if ($item['area'] == 'all') {
                if ($classMenu['type'] == 1) {
                    $classMenu[0]['data'][] = $data;
                    $classMenu[0]['name']   = '全国福利彩票';
                } elseif ($item['type'] == 2) {
                    $classMenu[1]['data'][] = $data;
                    $classMenu[1]['name']   = '全国体育彩票';
                }
            } else {
                //$areaData[][] = $data;
                $classMenu[2]['data'][$this->province[$item['area']]][] = $data;
                $classMenu[2]['name']                                   = '地方彩种';
            }
        }

        $lottery['special'] = [];

        // 高频指定日期数据
        if (!!$lotteryIsHigh) { // 高频彩种
            // 高频 日期
            $todayDate = date('Y-m-d');
            $today = strtotime($todayDate);

            if (empty($date)) {
                $date = $todayDate;
            }

            $selectTime = strtotime($date);

            for($i=0; $i<20; ++$i) {
                $selectDate[] = date('Y-m-d', $today - $i*86400);
            }

            unset($selectDate[array_search($date, $selectDate)]);

            #----------------------------------------------
            $where = 'uptime>=' . $selectTime . ' AND uptime<' . ($selectTime + 86400);

            // 当天数据
            $lotteryAll = $this->$lotteryName->select($where, 'id,numbers,uptime', '200', 'id DESC');

            foreach ($lotteryAll as $key => $item) {
                $lotteryAll[$key]['date'] = date('Y-m-d H:i:s', $item['uptime']);
                $lotteryAll[$key]['numbers_arr'] = explode(',', $item['numbers']);
            }

            // 当期数据
            $lottery                = $this->$lotteryName->get_one('uptime>=' . $selectTime . ' AND uptime<' . ($selectTime+86400), '*', 'id DESC');
            $lottery['over_time']   = date('Y.m.d', $lottery['uptime'] + 60 * 86400);
            $lottery['update']      = date('Y.m.d', $lottery['uptime']);
            $lottery['numbers_arr'] = explode(',', $lottery['numbers']);

            if($id == 3) { // 广东快乐十分
                $totalNum = array_sum($lottery['numbers_arr']);
                $units    = $totalNum % 10;

                $lottery['total'] = [
                    'total_num' => $totalNum,
                    'odd_even'  => $this->oddOrEven($totalNum),
                    'big_small' => $this->bigOrSmall($totalNum,2),
                    'mantissa'  => $this->bigOrSmall($units,1),
                ];
                $lottery['longhu'] = [
                    'first'  => $this->longHu($lottery['numbers_arr'][0], $lottery['numbers_arr'][7]),
                    'second' => $this->longHu($lottery['numbers_arr'][1], $lottery['numbers_arr'][6]),
                    'third'  => $this->longHu($lottery['numbers_arr'][2], $lottery['numbers_arr'][5]),
                    'fourth' => $this->longHu($lottery['numbers_arr'][3], $lottery['numbers_arr'][4]),
                ];

                // 3-广东快乐十分 每天 每10分钟开奖1期 每天9:00-23:00 9:10第一场 23:00最后一场
                $date     = date('Y-m-d', $lottery['uptime']);
                $lastTime = strtotime($date . ' 23:00');

                if ($lottery['uptime'] < $lastTime) {
                    $lottery['lottery_time'] = $lottery['uptime'] + 600;
                } else {
                    $date                    = date('Y-m-d', $lottery['uptime'] + 86400);
                    $lottery['lottery_time'] = strtotime($date . ' 09:13');
                }
            } elseif($id == 4) { // 北京赛车
                $sum = $lottery['numbers_arr'][0] + $lottery['numbers_arr'][1];
                $lottery['total'] = [
                    'total_num' => $sum,
                    'odd_even'  => $this->oddOrEven($sum),
                    'big_small' => $this->bigOrSmall($sum,3),
                ];
                $lottery['longhu'] = [
                    'first'  => $this->longHu($lottery['numbers_arr'][0], $lottery['numbers_arr'][9]),
                    'second' => $this->longHu($lottery['numbers_arr'][1], $lottery['numbers_arr'][8]),
                    'third'  => $this->longHu($lottery['numbers_arr'][2], $lottery['numbers_arr'][7]),
                    'fourth' => $this->longHu($lottery['numbers_arr'][3], $lottery['numbers_arr'][6]),
                    'fifth'  => $this->longHu($lottery['numbers_arr'][4], $lottery['numbers_arr'][5]),
                ];

                // 4-北京赛车PK10 5分钟一次 9:08左右开始
                $date     = date('Y-m-d', $lottery['uptime']);
                $lastTime = strtotime($date . ' 23:55');

                if ($lottery['uptime'] < $lastTime) {
                    $lottery['lottery_time'] = $lottery['uptime'] + 300;
                } else {
                    $date                    = date('Y-m-d', $lottery['uptime'] + 86400);
                    $lottery['lottery_time'] = strtotime($date . ' 09:08');
                }
                // 5-重庆时时彩
            } elseif($id == 5) { // 重庆时时彩
                $totalNum = array_sum($lottery['numbers_arr']);
                $lottery['total'] = [
                    'total_num' => $totalNum,
                    'odd_even'  => $this->oddOrEven($totalNum),
                    'big_small' => $this->bigOrSmall($totalNum,4),
                ];
                $lottery['longhu'] = [
                    'first'  => $this->longHu($lottery['numbers_arr'][0], $lottery['numbers_arr'][4]),
                ];

                $date     = date('Y-m-d', $lottery['uptime']);
                $lastTime = strtotime($date . ' 01:55');
                $earlyTime = strtotime($date . ' 00:00');
                $firstTime = strtotime($date . ' 10:00');

                if ($lottery['uptime'] < $lastTime && $lottery['uptime'] >= $earlyTime) { // 0:00 ->01:55
                    $lottery['lottery_time'] = $lottery['uptime'] + 300;
                } elseif($lottery['uptime'] >= $firstTime) { // 10点后
                    $lottery['lottery_time'] = $lottery['uptime'] + 600;
                } else {
                    $lottery['lottery_time'] = strtotime($date . ' 10:01');
                }
            }

            include template('sportsdata', 'cp_info_high');
        } else {
            $where = '';

            if (!empty($number)) {
                $where .= 'id=' . $number;
            }

            // 当期数据
            $lottery                = $this->$lotteryName->get_one($where, '*', 'id DESC');
            $lottery['over_time']   = date('Y.m.d', $lottery['uptime'] + 60 * 86400);
            $lottery['update']      = date('Y.m.d', $lottery['uptime']);
            $lottery['numbers_arr'] = explode(',', $lottery['numbers']);

            $hkNumberColor = $this->color;

            if ($id == 1) { // 七星彩表格
                foreach ($lottery['numbers_arr'] as $key => $item) {
                    $data = [
                        'key' => $this->num[$key+1],
                        'odd_even'  => $this->oddOrEven($item),
                        'big_small' => $this->bigOrSmall($item, 1)
                    ];
                    $lottery['qxc'][] = $data;
                }

                // 1-七星彩开奖信息（每周二、五、日开奖) 20:30开奖. 但真实数据写入时间延迟大, 暂定20:40为数据已写入时间
                if(time() % 86400 < 74400) {
                    $nextDay = [
                        0,2,0,3,3,0,2
                    ];
                } else {
                    $nextDay = [
                        2,2,3,3,3,2,2
                    ];
                }

                $week = (int)date('w');
                $day = $nextDay[$week];
                //var_dump($lottery['uptime'], $week, $day);die();
                $date     = date('Y-m-d', $lottery['uptime'] + 86400*$day);
                $lottery['lottery_time'] = strtotime($date . ' 20:40'); // 20:30
            }

            if($id == 2) { // 香港彩票->特码
                $lottery['special'] = [6];
                $specialNum = $lottery['numbers_arr'][6];

                $lottery['numbers_arr'][6] = '+'; // 特码前+号
                $lottery['numbers_arr'][7] = $specialNum;

                $lottery['special_num'] = [
                    'special_num' => $specialNum,
                    'animals'     => '',
                    'fowl_wild'   => '',
                    'odd_even'    => $this->oddOrEven($specialNum),
                    'big_small'   => $this->bigOrSmall($specialNum),
                    'color'       => $this->colorArr[$specialNum],
                ];
                $totalNum = array_sum($lottery['numbers_arr']);
                $lottery['total'] = [
                    'total_num'   => $totalNum,
                    'odd_even'    => $this->oddOrEven($totalNum),
                    'big_small'   => $this->bigOrSmall(floor($totalNum/7)),
                ];
            }

            // 往期彩票期数
            $lotteryIds = $this->$lotteryName->select('', 'id', '20', 'id DESC');
            $lotteryIds = array_column($lotteryIds, 'id');
            unset($lotteryIds[array_search($lottery['id'], $lotteryIds)]);

            include template('sportsdata', 'cp_info');
        }

    }

    /**
     * 判断龙虎
     */
    private function longHu($num1, $num2) {
        if ((int)$num1 > (int)$num2) {
            return '龙';
        }

        return '虎';
    }

    /**
     * 判断单双
     */
    private function oddOrEven($number) {
        $number = (int)$number;

        if ($number % 2 === 0) {
            return '双';
        }

        return '单';
    }

    /**
     * 判断大小
     */
    private function bigOrSmall($number, $key=0) {
        $numArr = [25, 5, 85, 12, 23];
        $goalNum = $numArr[$key];
        $number = (int)$number;

        if ($number >= $goalNum) {
            return '大';
        }

        return '小';
    }

    //历史数据
    public function history()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pinyin = isset($_GET['pinyin']) ? $_GET['pinyin'] : 'qxc';
        $db = $pinyin . $this->suffix;

        $area = $this->area;

        $class_name = $this->class;

        //彩票分类、基本信息
        list($class, $info) = $this->get_class($pinyin);

        //历史数据
        $history_data = $this->{$db}->listinfo('', '`uptime` DESC', $page, 20);
        $pages = $this->{$db}->pages;

        foreach ($history_data as &$r) {
            $r['numbers'] = explode(',', $r['numbers']);

            if ($pinyin === 'xglhc') { //香港开奖
                $color = 'circle';

                foreach ($r['numbers'] as $k => $v) {
                    if (in_array($v, $this->color['red'])) { //红波
                        $color .= ' red';
                    } else if (in_array($v, $this->color['blue'])) { //蓝波
                        $color .= ' blue';
                    } else { //绿波
                        $color .= ' green';
                    }

                    if ($k === 6) {
                        $r['numbers'][$k + 1] = ['number' => $v, 'color' => $color];
                    } else {
                        $r['numbers'][$k] = ['number' => $v, 'color' => $color];
                    }

                    //添加符号“+”
                    if ($k === 5) {
                        $r['numbers'][$k+1] = ['number' => '+', 'color' => ''];
                    }
                }

            } elseif ($pinyin === 'qxc') { //七星彩
                foreach ($r['numbers'] as $k => $v) {
                    $color = 'circle';

                    if ($k > 3) {
                        $color .= ' blue';
                    }

                    $r['numbers'][$k] = ['number' => $v, 'color' => $color];
                }

            } elseif ($pinyin === 'gdklsf') { //广东快乐十分
                foreach ($r['numbers'] as $k => $v) {
                    $r['numbers'][$k] = ['number' => $v, 'color' => 'circle blue'];
                }

            } else {
                foreach ($r['numbers'] as $k => $v) {
                    $r['numbers'][$k] = ['number' => $v, 'color' => 'circle'];
                }
            }

        }

        include template('sportsdata', 'cp_history');
    }

    //彩票分类
    private function get_class($pinyin)
    {
        $result = [];
        $info = null;

        $data = $this->class_db->select();

        foreach ($data as $r) {

            if ($r['pinyin'] === 'xglhc') continue; //暂时注释香港开奖

            //当前彩种
            if ($r['pinyin'] == $pinyin) {
                $info = $r;
            }

            //全国福利彩票
            if ($r['area'] == 'all' && $r['type'] == 1) {
                $result['all_fc'][] = $r;
                continue;
            }

            //全国体育彩票
            if ($r['area'] == 'all' && $r['type'] == 2) {
                $result['all_tc'][] = $r;
                continue;
            }

            //地方彩种
            if ($r['area'] != 'all' && $r['ishigh'] == 0) {
                $result['not_all'][$r['area']][] = $r;
                continue;
            }

            //高频彩种
            if ($r['ishigh'] == 1) {
                $result['high'][] = $r;
                continue;
            }
        }

        return [$result, $info];
    }

    //七星彩基本走势
    public function qxc_base() {
        //期号区间
        $begin = isset($_REQUEST['begin']) ? intval($_REQUEST['begin']) : false;
        $end = isset($_REQUEST['end']) ? intval($_REQUEST['end']) : false;
        //查询条件
        $where = $begin ? '`id`>=' . $begin : '';
        $where .= $end ? (strlen($where) ? ' AND `id`<=' . $end : '`id`<=' . $end) : '';
        //数量
        $size = isset($_REQUEST['size']) && intval($_REQUEST['size']) > 0 ? intval($_REQUEST['size']) : (($begin && $end && (($end - $begin) > 0)) ? $this->qxc_db->count($where) : 30);
        //取两倍数量的数据，一半作为遗落统计数据，一半作为展示数据
        $raw = $this->qxc_db->select($where, '*', $size * 2, '`id` DESC');
        $raw = array_chunk($raw, $size);
        //展示数据，正序
        krsort($raw[0]);
        //球号区间
        $_number = 7;
        $_numbers = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $info = $last = $stat = array();
        //历史数据遗漏统计
        if (count($raw[1])) {
            //统计每一位的每个数字
            for ($i = 1; $i <= $_number; $i ++) {
                foreach ($_numbers as $key => $_num) {
                    foreach ($raw[1] as $value) {
                        //如果找到直接退出本次循环，计算下一个数字
                        if ($value['n' . $i] == $_num) {
                            break;
                        }
                        //没有找到则遗漏+1
                        $last[$i][$key] += 1;
                    }
                }
            }
        }
        //处理展示数据
        if (count($raw[0])) {
            foreach ($raw[0] as $index => $value) {
                //上期数据
                $last_trend = isset($info[($index + 1)]) ? $info[($index + 1)]['trend'] : $last;
                $trend = array();
                for ($i = 1; $i <= $_number; $i ++) {
                    foreach ($_numbers as $key => $_num) {
                        if ($value['n' . $i] == $_num) {
                            //遗漏清零
                            $trend[$i][$key] = 0;
                            //出现次数
                            $stat['count'][$i][$key] += 1;
                            //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                            $stat['continue'][$i][$key][] = end($stat['continue'][$i][$key]) < 1 ? 1 : ($last_trend[$i][$key] == 0 ? end($stat['continue'][$i][$key]) + 1 : 1);
                        } else {
                            //遗漏+1
                            $trend[$i][$key] = $last_trend[$i][$key] + 1;
                            //最大遗漏
                            $stat['lost'][$i][$key] = $stat['lost'][$i][$key] < $trend[$i][$key] ? $trend[$i][$key] : $stat['lost'][$i][$key];
                            //出现次数，有可能出现在期号区间内一次都没有开过的情况
                            $stat['count'][$i][$key] = $stat['count'][$i][$key] < 1 ? 0 : $stat['count'][$i][$key];
                            //连出，有可能出现在期号区间内一次都没有开过的情况
                            $stat['continue'][$i][$key][] = end($stat['continue'][$i][$key]) < 1 ? 0 : end($stat['continue'][$i][$key]);
                        }
                    }
                    //最大遗漏重新排序
                    ksort($stat['lost'][$i]);
                }
                $value['trend'] = $trend;
                $info[$index] = $value;
                //期号区间重新处理
                $begin = $begin == false ? $value['id'] : $begin;
                $end = $value['id'];
            }
            //平均遗漏：彩票总期数减去历史中奖次数，得出历史遗漏总值，历史遗漏总值除以历史中奖次等于平均遗漏值
            if (count($stat['count'])) {
                foreach ($stat['count'] as $index => $value) {
                    foreach ($value as $key => $count) {
                        $stat['avg'][$index][$key] = ceil(($size - $count) / $count) ? ceil(($size - $count) / $count) : $size;
                    }
                }
            }
        }

        include template('sportsdata', 'cp_qxc_trend_base');
    }

    //重庆时时彩基本走势
    public function cqssc_base()
    {
        //期号区间
        $begin = isset($_REQUEST['begin']) ? intval($_REQUEST['begin']) : false;
        $end = isset($_REQUEST['end']) ? intval($_REQUEST['end']) : false;
        //查询条件
        $where = $begin ? '`id`>=' . $begin : '';
        $where .= $end ? (strlen($where) ? ' AND `id`<=' . $end : '`id`<=' . $end) : '';
        //数量
        $size = isset($_REQUEST['size']) && intval($_REQUEST['size']) > 0 ? intval($_REQUEST['size']) : (($begin && $end && (($end - $begin) > 0)) ? $this->qxc_db->count($where) : 30);
        //取两倍数量的数据，一半作为遗落统计数据，一半作为展示数据
        $raw = $this->cqssc_db->select($where, '*', $size * 2, '`id` DESC');
        $raw = array_chunk($raw, $size);
        //展示数据，正序
        krsort($raw[0]);
        //球号区间
        $_number = array(3, 4, 5);
        $_numbers = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $type_arr = array(
            1 => '组六',
            2 => '组三',
            3 => '豹子'
        );
        $info = $last = $stat = array();
        //历史数据遗漏统计
        if (count($raw[1])) {
            //补全重庆时时彩的类型
            foreach ($raw[1] as &$_tmp) {
                //重庆时时彩的类型根据个位，十位，百位的号码重复计算：没有重复->组六；两位重复->组三；三位重复->豹子；
                $numbers = array($_tmp['n3'], $_tmp['n4'], $_tmp['n5']);
                $repeat = array_count_values($numbers);
                $_tmp['type'] = max($repeat);
            }
            //统计每一位的每个数字
            foreach ($_number as $i) {
                foreach ($_numbers as $key => $_num) {
                    foreach ($raw[1] as $value) {
                        //如果找到直接退出本次循环，计算下一个数字
                        if ($value['n' . $i] == $_num) {
                            break;
                        }
                        //没有找到则遗漏+1
                        $last[$i][$key] += 1;
                    }
                }
            }
            //统计类型
            foreach ($type_arr as $key => $_type) {
                foreach ($raw[1] as $value) {
                    if ($value['type'] == $_type) {
                        break;
                    }
                    $last['type'][$key] += 1;
                }
            }
        }
        //处理展示数据
        if (count($raw[0])) {
            foreach ($raw[0] as $index => $value) {
                //上期数据
                $last_trend = isset($info[($index + 1)]) ? $info[($index + 1)]['trend'] : $last;
                //补全类型
                $numbers = array($value['n3'], $value['n4'], $value['n5']);
                $repeat = array_count_values($numbers);
                $value['type'] = max($repeat);
                //统计个位，十位，百位
                $trend = array();
                foreach ($_number as $i) {
                    foreach ($_numbers as $key => $_num) {
                        if ($value['n' . $i] == $_num) {
                            //遗漏清零
                            $trend[$i][$key] = 0;
                            //出现次数
                            $stat['count'][$i][$key] += 1;
                            //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                            $stat['continue'][$i][$key][] = end($stat['continue'][$i][$key]) < 1 ? 1 : ($last_trend[$i][$key] == 0 ? end($stat['continue'][$i][$key]) + 1 : 1);
                        } else {
                            //遗漏+1
                            $trend[$i][$key] = $last_trend[$i][$key] + 1;
                            //最大遗漏
                            $stat['lost'][$i][$key] = $stat['lost'][$i][$key] < $trend[$i][$key] ? $trend[$i][$key] : $stat['lost'][$i][$key];
                            //出现次数，有可能出现在期号区间内一次都没有开过的情况
                            $stat['count'][$i][$key] = $stat['count'][$i][$key] < 1 ? 0 : $stat['count'][$i][$key];
                            //连出，有可能出现在期号区间内一次都没有开过的情况
                            $stat['continue'][$i][$key][] = end($stat['continue'][$i][$key]) < 1 ? 0 : end($stat['continue'][$i][$key]);
                        }
                    }
                    //最大遗漏重新排序
                    ksort($stat['lost'][$i]);
                }
                //统计类型
                foreach ($type_arr as $key => $_type) {
                    if ($value['type'] == $key) {
                        //遗漏清零
                        $trend['type'][$key] = 0;
                        //出现次数
                        $stat['count']['type'][$key] += 1;
                        //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                        $stat['continue']['type'][$key][] = end($stat['continue']['type'][$key]) < 1 ? 1 : ($last_trend['type'][$key] == 0 ? end($stat['continue']['type'][$key]) + 1 : 1);
                    } else {
                        //遗漏+1
                        $trend['type'][$key] = $last_trend['type'][$key] + 1;
                        //最大遗漏
                        $stat['lost']['type'][$key] = $stat['lost']['type'][$key] < $trend['type'][$key] ? $trend['type'][$key] : $stat['lost']['type'][$key];
                        //出现次数，有可能出现在期号区间内一次都没有开过的情况
                        $stat['count']['type'][$key] = $stat['count']['type'][$key] < 1 ? 0 : $stat['count']['type'][$key];
                        //连出，有可能出现在期号区间内一次都没有开过的情况
                        $stat['continue']['type'][$key][] = end($stat['continue']['type'][$key]) < 1 ? 0 : end($stat['continue']['type'][$key]);
                    }
                    //最大遗漏重新排序
                    ksort($stat['lost']['type']);
                }
                $value['trend'] = $trend;
                $info[$index] = $value;
                //期号区间重新处理
                $begin = $begin == false ? $value['id'] : $begin;
                $end = $value['id'];
            }
            //平均遗漏：彩票总期数减去历史中奖次数，得出历史遗漏总值，历史遗漏总值除以历史中奖次等于平均遗漏值
            if (count($stat['count'])) {
                foreach ($stat['count'] as $index => $value) {
                    foreach ($value as $key => $count) {
                        $stat['avg'][$index][$key] = ceil(($size - $count) / $count) ? ceil(($size - $count) / $count) : $size;
                    }
                }
            }
        }

        include template('sportsdata', 'cp_cqssc_trend_base');
    }

    //广东快乐十分基本走势
    public function gdklsf_base()
    {
        //期号区间
        $begin = isset($_REQUEST['begin']) ? intval($_REQUEST['begin']) : false;
        $end = isset($_REQUEST['end']) ? intval($_REQUEST['end']) : false;
        //查询条件
        $where = $begin ? '`id`>=' . $begin : '';
        $where .= $end ? (strlen($where) ? ' AND `id`<=' . $end : '`id`<=' . $end) : '';
        //数量
        $size = isset($_REQUEST['size']) && intval($_REQUEST['size']) > 0 ? intval($_REQUEST['size']) : (($begin && $end && (($end - $begin) > 0)) ? $this->qxc_db->count($where) : 30);
        //取两倍数量的数据，一半作为遗落统计数据，一半作为展示数据
        $raw = $this->gdklsf_db->select($where, '*', $size * 2, '`id` DESC');
        $raw = array_chunk($raw, $size);
        //展示数据，正序
        krsort($raw[0]);
        //球号区间
        $_numbers = 20;
        $info = $last = $stat = array();
        //历史数据遗漏统计
        if (count($raw[1])) {
            //统计每个数字
            for ($i = 1; $i <= $_numbers; $i ++) {
                foreach ($raw[1] as $value) {
                    //如果找到直接退出本次循环，计算下一个数字
                    if (in_array($i, explode(',', $value['numbers']))) {
                        break;
                    }
                    //没有找到则遗漏+1
                    $last[$i] += 1;
                }
            }
        }
        //处理展示数据
        if (count($raw[0])) {
            foreach ($raw[0] as $index => $value) {
                //跨度
                $value['numbers'] = explode(',', $value['numbers']);
                $value['span'] = max($value['numbers']) - min($value['numbers']);
                //上期数据
                $last_trend = isset($info[($index + 1)]) ? $info[($index + 1)]['trend'] : $last;
                $trend = $other = array();
                for ($i = 1; $i <= $_numbers; $i ++) {
                    if (in_array($i, $value['numbers'])) {
                        //遗漏清零
                        $trend[$i] = 0;
                        //出现次数
                        $stat['count'][$i] += 1;
                        //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                        $stat['continue'][$i][] = end($stat['continue'][$i]) < 1 ? 1 : ($last_trend[$i] == 0 ? end($stat['continue'][$i]) + 1 : 1);
                        //012路：根据除以3的余数分类
                        $other[($i % 3)][] = $i;
                    } else {
                        //遗漏+1
                        $trend[$i] = $last_trend[$i] + 1;
                        //最大遗漏
                        $stat['lost'][$i] = $stat['lost'][$i] < $trend[$i] ? $trend[$i] : $stat['lost'][$i];
                        //出现次数，有可能出现在期号区间内一次都没有开过的情况
                        $stat['count'][$i] = $stat['count'][$i] < 1 ? 0 : $stat['count'][$i];
                        //连出，有可能出现在期号区间内一次都没有开过的情况
                        $stat['continue'][$i][] = end($stat['continue'][$i]) < 1 ? 0 : end($stat['continue'][$i]);
                    }
                    //最大遗漏重新排序
                    ksort($stat['lost']);
                }
                //遗漏重新排序
                ksort($trend);
                $value['trend'] = $trend;
                $value['other'] = $other;
                $info[$index] = $value;
                //期号区间重新处理
                $begin = $begin == false ? $value['id'] : $begin;
                $end = $value['id'];
            }
            //平均遗漏：彩票总期数减去历史中奖次数，得出历史遗漏总值，历史遗漏总值除以历史中奖次等于平均遗漏值
            if (count($stat['count'])) {
                foreach ($stat['count'] as $index => $value) {
                    $stat['avg'][$index] = ceil(($size - $value) / $value) ? ceil(($size - $value) / $value) : $size;
                }
            }
        }

        include template('sportsdata', 'cp_gdklsf_trend_base');
    }

    //北京pk10基本走势
    public function bjpks_base()
    {
        //期号区间
        $begin = isset($_REQUEST['begin']) ? intval($_REQUEST['begin']) : false;
        $end = isset($_REQUEST['end']) ? intval($_REQUEST['end']) : false;
        //查询条件
        $where = $begin ? '`id`>=' . $begin : '';
        $where .= $end ? (strlen($where) ? ' AND `id`<=' . $end : '`id`<=' . $end) : '';
        //数量
        $size = isset($_REQUEST['size']) && intval($_REQUEST['size']) > 0 ? intval($_REQUEST['size']) : (($begin && $end && (($end - $begin) > 0)) ? $this->qxc_db->count($where) : 30);
        //取两倍数量的数据，一半作为遗落统计数据，一半作为展示数据
        $raw = $this->bjpks_db->select($where, '*', $size * 2, '`id` DESC');
        $raw = array_chunk($raw, $size);
        //展示数据，正序
        krsort($raw[0]);
        //球号区间
        $_number = 3;
        $_numbers = 10;
        $info = $last = $stat = array();
        //历史数据遗漏统计
        if (count($raw[1])) {
            for ($i = 1; $i <= $_number; $i ++) {
                //统计前三名的每个数字
                for ($j = 1; $j <= $_numbers; $j ++) {
                    foreach ($raw[1] as $value) {
                        //如果找到直接退出本次循环，计算下一个数字
                        if ($value['n' . $i] == $j) {
                            break;
                        }
                        //没有找到则遗漏+1
                        $last[$i][$j] += 1;
                    }
                }
            }
            //统计基础分布，取前三位的最小遗漏
            foreach ($last as $lost) {
                foreach ($lost as $key => $value) {
                    $last[0][$key] = isset($last[0][$key]) ? ($last[0][$key] > $value ? $value : $last[0][$key]) : $value;
                }
            }
            //历史遗漏重新排序
            ksort($last);
        }
        //处理展示数据
        if (count($raw[0])) {
            foreach ($raw[0] as $index => $value) {
                //上期数据
                $last_trend = isset($info[($index + 1)]) ? $info[($index + 1)]['trend'] : $last;
                $trend = array();
                for ($i = 1; $i <= $_number; $i ++) {
                    for ($j = 1; $j <= $_numbers; $j ++) {
                        if ($value['n' . $i] == $j) {
                            //遗漏清零
                            $trend[$i][$j] = 0;
                            //出现次数
                            $stat['count'][$i][$j] += 1;
                            //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                            $stat['continue'][$i][$j][] = end($stat['continue'][$i][$j]) < 1 ? 1 : ($last_trend[$i][$j] == 0 ? end($stat['continue'][$i][$j]) + 1 : 1);
                        } else {
                            //遗漏+1
                            $trend[$i][$j] = $last_trend[$i][$j] + 1;
                            //最大遗漏
                            $stat['lost'][$i][$j] = $stat['lost'][$i][$j] < $trend[$i][$j] ? $trend[$i][$j] : $stat['lost'][$i][$j];
                            //出现次数，有可能出现在期号区间内一次都没有开过的情况
                            $stat['count'][$i][$j] = $stat['count'][$i][$j] < 1 ? 0 : $stat['count'][$i][$j];
                            //连出，有可能出现在期号区间内一次都没有开过的情况
                            $stat['continue'][$i][$j][] = end($stat['continue'][$i][$j]) < 1 ? 0 : end($stat['continue'][$i][$j]);
                        }
                    }
                    //最大遗漏重新排序
                    ksort($stat['lost'][$i]);
                }
                //基础分布
                foreach ($trend as $_tmp) {
                    foreach ($_tmp as $key => $num) {
                        //遗漏取前三位的最小值
                        $trend[0][$key] = isset($trend[0][$key]) ? ($trend[0][$key] > $num ? $num : $trend[0][$key]) : $num;
                    }
                }
                //统计基础分布
                foreach ($trend[0] as $key => $num) {
                    //最大遗漏
                    $stat['lost'][0][$key] = $stat['lost'][0][$key] < $num ? $num : $stat['lost'][0][$key];
                    //出现次数
                    $stat['count'][0][$key] += $num == 0 ? 1 : 0;
                    //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                    if ($num == 0) {
                        $stat['continue'][0][$key][] = end($stat['continue'][0][$key]) < 1 ? 1 : ($last_trend[0][$key] == 0 ? end($stat['continue'][0][$key]) + 1 : 1);
                    } else {
                        $stat['continue'][0][$key][] = 0;
                    }
                }
                //遗漏重新排序
                ksort($trend);
                $value['trend'] = $trend;
                $info[$index] = $value;
                //期号区间重新处理
                $begin = $begin == false ? $value['id'] : $begin;
                $end = $value['id'];
            }
            //统计重新排序
            foreach ($stat as $key => $value) {
                ksort($stat[$key]);
            }
            //平均遗漏：彩票总期数减去历史中奖次数，得出历史遗漏总值，历史遗漏总值除以历史中奖次等于平均遗漏值
            if (count($stat['count'])) {
                foreach ($stat['count'] as $index => $value) {
                    foreach ($value as $key => $count) {
                        $stat['avg'][$index][$key] = ceil(($size - $count) / $count) ? ceil(($size - $count) / $count) : $size;
                    }
                }
            }
        }

        include template('sportsdata', 'cp_bjpks_trend_base');
    }

    //香港六合彩基本走势
    public function xglhc_base()
    {
        //期号区间
        $begin = isset($_REQUEST['begin']) ? intval($_REQUEST['begin']) : false;
        $end = isset($_REQUEST['end']) ? intval($_REQUEST['end']) : false;
        //查询条件
        $where = $begin ? '`id`>=' . $begin : '';
        $where .= $end ? (strlen($where) ? ' AND `id`<=' . $end : '`id`<=' . $end) : '';
        //数量
        $size = isset($_REQUEST['size']) && intval($_REQUEST['size']) > 0 ? intval($_REQUEST['size']) : (($begin && $end && (($end - $begin) > 0)) ? $this->qxc_db->count($where) : 30);
        //取两倍数量的数据，一半作为遗落统计数据，一半作为展示数据
        $raw = $this->xglhc_db->select($where, '*', $size * 2, '`id` DESC');
        $raw = array_chunk($raw, $size);
        //展示数据，正序
        krsort($raw[0]);
        //球号区间
        $_numbers = 49;
        $info = $last = $stat = $td_arr = array();
        //历史数据遗漏统计
        if (count($raw[1])) {
            //统计每个数字
            for ($i = 1; $i <= $_numbers; $i ++) {
                //页面布局用
                $td_arr[] = $i;
                foreach ($raw[1] as $value) {
                    //如果找到直接退出本次循环，计算下一个数字
                    if (in_array($i, explode(',', $value['numbers']))) {
                        break;
                    }
                    //没有找到则遗漏+1
                    $last[$i] += 1;
                }
            }
        }
        //处理展示数据
        if (count($raw[0])) {
            foreach ($raw[0] as $index => $value) {
                $value['numbers'] = explode(',', $value['numbers']);
                sort($value['numbers']);
                //上期数据
                $last_trend = isset($info[($index + 1)]) ? $info[($index + 1)]['trend'] : $last;
                $trend = array();
                for ($i = 1; $i <= $_numbers; $i ++) {
                    if (in_array($i, $value['numbers'])) {
                        //遗漏清零
                        $trend[$i] = 0;
                        //出现次数
                        $stat['count'][$i] += 1;
                        //连出，每次数字出现的时候，如果上期也出现了相同的数字，则本次=上期连出+1，否则连出=1，将本次的连出保存到数组中，最后计算最大连出
                        $stat['continue'][$i][] = end($stat['continue'][$i]) < 1 ? 1 : ($last_trend[$i] == 0 ? end($stat['continue'][$i]) + 1 : 1);
                    } else {
                        //遗漏+1
                        $trend[$i] = $last_trend[$i] + 1;
                        //最大遗漏
                        $stat['lost'][$i] = $stat['lost'][$i] < $trend[$i] ? $trend[$i] : $stat['lost'][$i];
                        //出现次数，有可能出现在期号区间内一次都没有开过的情况
                        $stat['count'][$i] = $stat['count'][$i] < 1 ? 0 : $stat['count'][$i];
                        //连出，有可能出现在期号区间内一次都没有开过的情况
                        $stat['continue'][$i][] = end($stat['continue'][$i]) < 1 ? 0 : end($stat['continue'][$i]);
                    }
                    //最大遗漏重新排序
                    ksort($stat['lost'][$i]);
                }
                $value['trend'] = $trend;
                $info[$index] = $value;
                //期号区间重新处理
                $begin = $begin == false ? $value['id'] : $begin;
                $end = $value['id'];
            }
            //平均遗漏：彩票总期数减去历史中奖次数，得出历史遗漏总值，历史遗漏总值除以历史中奖次等于平均遗漏值
            if (count($stat['count'])) {
                foreach ($stat['count'] as $index => $value) {
                    $stat['avg'][$index] = ceil(($size - $value) / $value) ? ceil(($size - $value) / $value) : $size;
                }
            }
        }

        include template('sportsdata', 'cp_xglhc_trend_base');
    }

}