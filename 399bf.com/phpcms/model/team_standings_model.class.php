<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class team_standings_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'win007.com';
        $this->table_name = 'team_standings';
        parent::__construct();
    }

    //联赛排名
    public function standings($where)
    {
        $info = array();
        if ($where) {
            $raw = $this->select($where, '*', '', '`totalrank`', '', 'teamid');
            if (count($raw)) {
                //按联盟分类
                foreach ($raw as $value) {
                    $tmp[$value['locationname']][$value['totalrank']] = $value;
                }
                foreach ($tmp as &$_tmp) {
                    ksort($_tmp);
                }
                foreach ($tmp as $type => $data) {
                    foreach ($data as $key => $value) {
                        //整理数据
                        $value['total'] = $value['homewin'] + $value['homeloss'] + $value['guestwin'] + $value['guestloss'];
                        $value['win'] = $value['homewin'] + $value['guestwin'];
                        $value['loss'] = $value['homeloss'] + $value['guestloss'];
                        $value['lossscale'] = $value['winscale'] == '' ? '' : 100 - $value['winscale'];
                        $value['avg']['score'] = round(($value['homescore'] + $value['guestscore']) / $value['total'], 1);
                        $value['avg']['loss'] = round(($value['homelossscore'] + $value['guestlossscore']) / $value['total'], 1);
                        $value['result']['home'] = $value['homewin'] . '-' . $value['homeloss'];
                        $value['result']['guest'] = $value['guestwin'] . '-' . $value['guestloss'];
                        $value['near'] = $value['near10win'] . '-' . $value['near10loss'];
                        $value['status'] = $this->get_state($value['state']);
                        //取联赛第一名的净胜
                        $top = isset($top) ? $top : ($value['win'] - $value['loss']);
                        //胜差
                        $value['disparity'] = round((($top - ($value['win'] - $value['loss'])) / 2), 1);
                        $info[$type][$key] = $value;
                    }
                }
            }
        }
        return $info;
    }

    //转换state字段
    private function get_state($state)
    {
        $suffix = $state > 0 ? '连胜' : '连败';
        return str_replace('-', '', $state) . $suffix;
    }
}
?>