<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class goaltime_stats_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'goaltime_stats';
        parent::__construct();
    }

    public function goal_time_stats($competitionid, $teamid)
    {
        if ($competitionid && $teamid) {
            $where = is_array($teamid) ? '`competitionid`=' . $competitionid . ' AND `teamid` IN (' . join(',', $teamid) . ')' : '`competitionid`=' . $competitionid . ' AND `teamid`=' . $teamid;
            $data = $this->select($where);

            if ($data) {
                $result = array();
                foreach ($data as $value) {
                    //按球队、类型分组
                    $result[$value['teamid']][$value['type']] = array(
                        //将五组数据整理为四组数据，覆盖整场比赛时间
                        $value['minute1_10'] + $value['minute11_20'],
                        $value['minute21_30'] + $value['minute31_40'] + $value['minute41_45'],
                        $value['minute46_55'] + $value['minute56_65'],
                        $value['minute66_75'] + $value['minute76_85'] + $value['minute86_90'],
                    );
                }
            }

            return isset($result) ? $result : $data;
        }

        return false;
    }
}
?>