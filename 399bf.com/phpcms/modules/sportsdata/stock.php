<?php
/**
 * 股票 juhe.cn
 */

defined('IN_PHPCMS') or exit('No permission resources.');
// 模块缓存路径
define('CACHE_SPORTSDATA_PATH', CACHE_PATH . 'caches_sportsdata' . DIRECTORY_SEPARATOR . 'caches_data' . DIRECTORY_SEPARATOR);
// 加载模块全局函数
pc_base::load_app_func('global');
pc_base::load_sys_func('global');

class stock {
    private $appkey = '626088cf5b0d2d65d83474a635a80a4f';

    //股票列表
    public function lists() {
        $menuId     = isset($_GET['menu_id']) ? (int)$_GET['menu_id'] : 1;
        $page       = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $code       = isset($_POST['code']) ? $_POST['code'] : '';
        $menuMapper = [
            1 => '上证A',
            2 => '上证B',
            3 => '深证A',
            4 => '深证B',
            5 => '香港股市',
            6 => '美国股市',
        ];
        $menu       = [
            [
                'menu_id' => 0,
                'name'    => '沪深股市',
                'child'   => [
                    [
                        'menu_id' => 1,
                        'name'    => '上证A',
                    ],
                    [
                        'menu_id' => 2,
                        'name'    => '上证B',
                    ],
                    [
                        'menu_id' => 3,
                        'name'    => '深证A',
                    ],
                    [
                        'menu_id' => 4,
                        'name'    => '深证B',
                    ],
                ],
            ],
            [
                'menu_id' => 0,
                'name'    => '香港股市',
                'child'   => [
                    [
                        'menu_id' => 5,
                        'name'    => '香港股市',
                    ],
                ],
            ],
            [
                'menu_id' => 0,
                'name'    => '美国股市',
                'child'   => [
                    [
                        'menu_id' => 6,
                        'name'    => '美国股市',
                    ],
                ],
            ],
        ];

        //大盘
        $dapan_data = get_dapan_data();

        if (empty($code)) {
            $list  = $this->getStockData($menuId, $page);
            $pages = pages($list['totalCount'], $page, 20);
        } else {
            $list   = $this->getOneStock($code);
            $menuId = $list['menu_id'];
        }

        $menuName = $menuMapper[$menuId];

        include template('sportsdata', 'st_list');
    }

    private function getStockData($number, $page = 1) {
        $apiUrl = 'http://web.juhe.cn:8080/finance/stock/';
        $place  = [
            1 => ['sh', '&stock=a'],
            2 => ['sh', '&stock=b'],
            3 => ['sz', '&stock=a'],
            4 => ['sz', '&stock=b'],
            5 => ['hk', ''],
            6 => ['usa', ''],
        ];

        $url    = sprintf($apiUrl . '%sall?key=' . $this->appkey . '&page=' . $page . '%s', $place[$number][0], $place[$number][1]);
        $return = http_get($url);

        if (!isset($return['error_code']) || $return['error_code'] !== 0) {
            return '';
        }

        if (!isset($return['result']) || empty($return['result'])) {
            return '';
        }

        foreach ($return['result']['data'] as $key => $item) {
            // 变更参数名
            if (isset($item['cname'])) {
                $item['name'] = $item['cname'];
            }

            if (isset($item['lasttrade'])) {
                $item['trade'] = $item['lasttrade'];
            }

            if (isset($item['price'])) {
                $item['trade'] = $item['price'];
            }


            if (isset($item['prevclose'])) {
                $item['settlement'] = $item['prevclose'];
            }

            if (isset($item['diff'])) {
                $item['pricechange'] = $item['diff'];
            }

            if (isset($item['chg'])) { // 美国 涨跌幅
                $item['changepercent'] = $item['chg'];
            }

            if (isset($item['preclose'])) {
                $item['settlement'] = $item['preclose'];
            }

            if ($number === 5) { // 香港
                $item['changepercent'] = round($item['changepercent'], 3);
            }

            $return['result']['data'][$key] = $item;
        }

        return $return['result'];
    }

    private function getOneStock($code) {
        $apiUrl = 'http://web.juhe.cn:8080/finance/stock/';

        $len = strlen($code);

        if ($len === 0) {
            return '';
        }

        $code = strtolower($code);

        if ($len === 8 && strpos($code, 'sh') === 0) {
            $number = 1;
        } elseif ($len === 5 && strpos($code, '0') === 0) {
            $number = 2;
        } else {
            $number = 3;
        }

        $place = [
            1 => ['hs', '&gid=', 1],  // 沪深
            2 => ['hk', '&num=', 5],  // 香港
            3 => ['usa', '&gid=', 6], // 美国
        ];

        $url    = sprintf($apiUrl . '%s?key=' . $this->appkey . '%s' . $code, $place[$number][0], $place[$number][1]);
        $return = http_get($url);
        $result = [];

        if (!isset($return['result']) || empty($return['result'])) {
            $result['menu_id'] = 1;
            return '';
        }

        if ($number === 2) { // 香港 美国
            if (!isset($return['resultcode']) || $return['resultcode'] !== '200') {
                $result['menu_id'] = 1;
                return '';
            }

            $result                = $return['result'][0];
            $data['symbol']        = $result['data']['gid'];
            $data['name']          = $result['data']['name'];
            $data['trade']         = $result['data']['lastestpri'];
            $data['pricechange']   = $result['data']['uppic'];
            $data['changepercent'] = $result['data']['limit'];
            $data['volume']        = $result['data']['traNumber'];
            $data['amount']        = $result['data']['traAmount'];
            $data['settlement']    = $result['data']['formpri'];
            $data['open']          = $result['data']['openpri'];
            $data['high']          = $result['data']['maxpri'];
            $data['low']           = $result['data']['minpri'];
        } elseif ($number === 1) {
            if (!isset($return['error_code']) || $return['error_code'] !== 0) {
                return '';
            }

            $result                = $return['result'][0];
            $data['symbol']        = $result['data']['gid'];
            $data['name']          = $result['data']['name'];
            $data['trade']         = $result['data']['nowPri'];
            $data['pricechange']   = $result['data']['increase'];
            $data['changepercent'] = $result['data']['increPer'];
            $data['volume']        = $result['data']['traNumber'];
            $data['amount']        = $result['data']['traAmount'];
            $data['settlement']    = $result['data']['yestodEndPri'];
            $data['open']          = $result['data']['todayStartPri'];
            $data['high']          = $result['data']['todayMax'];
            $data['low']           = $result['data']['todayMin'];
        } elseif ($number === 3) {
            if (!isset($return['resultcode']) || $return['resultcode'] !== '200') {
                $result['menu_id'] = 1;
                return '';
            }

            $result                = $return['result'][0];
            $data['symbol']        = $result['data']['gid'];
            $data['name']          = $result['data']['name'];
            $data['trade']         = $result['data']['lastestpri'];
            $data['pricechange']   = $result['data']['uppic'];
            $data['changepercent'] = $result['data']['limit'];
            $data['volume']        = $result['data']['traAmount'];
            $data['amount']        = '';
            $data['settlement']    = $result['data']['formpri'];
            $data['open']          = $result['data']['openpri'];
            $data['high']          = $result['data']['maxpri'];
            $data['low']           = $result['data']['minpri'];
        } else {
            return '';
        }

        unset($result['data']);
        $result['data'][]  = $data;
        $result['menu_id'] = $place[$number][2];

        return $result;
    }


}