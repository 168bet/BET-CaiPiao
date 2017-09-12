<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class live_game_goal_stats_model extends model {
    public $table_name = '';
    private $data = false;
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'live_game_goal_stats';
        parent::__construct();
    }

    /*
     * goal字段数据处理
     */
    public function goal_info($id = false)
    {
        if ($id) {
            $this->data = $this->get_one('`gameid`=' . $id);
        }

        if (! $id && ! $this->data) {
            return false;
        }

        $goal_info = $this->data['goal'] ? json_decode($this->data['goal'], true) : false;
        if ($goal_info !== false) {
            //事件对应的样式
            $class_arr = array(
                0 => 'goal',
                1 => 'point',
                2 => 'own-goal',
                3 => 'yellowCard',
                4 => 'redCard',
                5 => 'yr-merge'
            );
            $result = array();
            foreach ($goal_info as $goal) {
                $goal['Class'] = $class_arr[$goal['Event']];
                //加时
                if ($goal['Minute'] > 90) {
                    $goal['Overtime'] = '+' . ($goal['Minute'] - 90);
                    $goal['Minute'] = 90;
                }
                $result[] = $goal;
            }
        }

        return isset($result) ? $result : $goal_info;
    }

    /**
     * 获取比赛事件(即时比分)
     */
    public function events($gameid = 0)
    {
        if ($gameid) {
            $retval = $this->get_one("`gameid`=$gameid", '`goal`');
            if (empty($retval['goal'])) return false;
        }

        $goal_info = $retval['goal'] ? json_decode($retval['goal'], true) : false;
        if ($goal_info !== false) {
            //事件对应的样式
            $class_arr = array(
                0 => 'hasGoal',
                1 => 'penalty',
                2 => 'oolong',
                3 => 'yellowCard',
                4 => 'redCard',
                5 => 'yellowCard2'
            );
            $result = array();
            foreach ($goal_info as $goal) {
                $goal['Class'] = $class_arr[$goal['Event']];
                //加时
                if ($goal['Minute'] > 90) {
                    $goal['Overtime'] = '+' . ($goal['Minute'] - 90);
                    $goal['Minute'] = 90;
                }
                $result[] = $goal;
            }
        }

        return isset($result) ? $result : $goal_info;
    }

    /*
     * stat字段数据处理
     */
    public function stat_info($id = false)
    {
        if ($id) {
            $this->data = $this->get_one('`gameid`=' . $id);
        }

        if (! $id && ! $this->data) {
            return false;
        }

        $stat_info = $this->data['stat'] ? json_decode($this->data['stat'], true) : false;

        return $stat_info;
    }

    /**
     * substitutes数据处理
     */
    public function substitution_info($id = false)
    {
        if ($id) {
            $this->data = $this->get_one('`gameid`=' . $id);
        }

        if (! $id && ! $this->data) {
            return false;
        }

        $substitution_info = $this->data['substitutes'] ? json_decode($this->data['substitutes'], true) : false;

        return $substitution_info;
    }

}
?>