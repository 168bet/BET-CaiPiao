<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class game_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'game';
        parent::__construct();
    }

    /**
     * 数据统计页面底部的主客队近100场落后反超统计
     */
    public function anti_kill($home_id, $away_id)
    {
        if ($home_id && $away_id) {
            //主、客队近100场统计
            $temp[$home_id] = $this->select('`status`=4 AND `hometeamid`=' . $home_id . ' OR `awayteamid`=' . $home_id, '`hometeamid`,`awayteamid`,`homescore`,`awayscore`,`half`', 100);
            $temp[$away_id] = $this->select('`status`=4 AND `hometeamid`=' . $away_id . ' OR `awayteamid`=' . $away_id, '`hometeamid`,`awayteamid`,`homescore`,`awayscore`,`half`', 100);
            foreach ($temp as $id => $info) {
                if ($info) {
                    //最终统计结果包含半场落后场次，反超场次，参与统计场次，反超比例
                    $result[$id] = array(
                        'backward' => 0,
                        'anti_kill' => 0,
                        'count' => count($temp[$id])
                    );
                    foreach ($info as $row) {
                        //如果id对应的球队在本条记录中为客队，则调换主客队得分
                        if ($id == $row['hometeamid']) {
                            list($home_half, $away_half) = explode('-', $row['half']);
                            $home_score = $row['homescore'];
                            $away_score = $row['awayscore'];
                        } else {
                            list($away_half, $home_half) = explode('-', $row['half']);
                            $home_score = $row['awayscore'];
                            $away_score = $row['homescore'];
                        }
                        //是否半场落后
                        if ($home_half < $away_half) {
                            $result[$id]['backward'] += 1;
                            //是否反超
                            $result[$id]['anti_kill'] += $home_score > $away_score ? 1 : 0;
                        }
                    }
                    //反超比例
                    $result[$id]['rate'] = round(($result[$id]['anti_kill'] / $result[$id]['backward']) * 100, 2) . '%';
                }
            }

            return isset($result) ? $result : false;
        }

        return false;
    }
}
?>