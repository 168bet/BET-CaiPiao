<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class standings_stats_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'standings_stats';
        parent::__construct();
    }

    /**
     * 联赛积分榜，根据积分统计排名
     * @param $competition_id：联赛编号
     * @param string $type：按类型统计，如果需要全部数据，则传入空值即可
     * @param bool $stat：是否需要统计信息
     * @return array：如果$type有值，返回的数组，以排名为键，以包含了当前排名的球队的数组为值；如果$type为空，则返回的是以类型分组的排名数组；
     */
    public function standings($competition_id, $type = 'total', $stat = false)
    {
        $info = $stat_info = $count = array();
        if ($competition_id) {
            //指定类型
            if ($type) {
                $where = '`competitionid`=' . $competition_id . ' AND `type`="' . $type . '"';
                $raw = $this->select($where);
                if (count($raw)) {
                    //积分排名
                    $score_arr = array_unique(array_column($raw, 'score'));
                    rsort($score_arr);
                    foreach ($raw as $value) {
                        $rank = array_search($value['score'], $score_arr) + 1;
                        $info[$rank][] = $value;
                    }
                    //逆序排名
                    ksort($info);
                }
            } else {
                $where = '`competitionid`=' . $competition_id;
                $raw = $this->select($where);
                if (count($raw)) {
                    //按类型分组
                    $tmp = array();
                    foreach ($raw as $value) {
                        $tmp[$value['type']][] = $value;
                    }
                    //统计排名
                    foreach ($tmp as $key => $group) {
                        //统计
                        if ($stat) {
                            $count[$key]['sum'] = array_sum(array_column($group, 'total'));
                            $count[$key]['goal'] = array_column($group, 'goal');
                            $count[$key]['nongoal'] = array_column($group, 'nongoal');
                            $count[$key]['win'] = array_sum(array_column($group, 'win'));
                            $count[$key]['draw'] = array_sum(array_column($group, 'draw'));
                            $count[$key]['lose'] = array_sum(array_column($group, 'lose'));
                        }
                        //积分排名
                        $score_arr = array_unique(array_column($group, 'score'));
                        rsort($score_arr);
                        foreach ($group as $value) {
                            $rank = array_search($value['score'], $score_arr) + 1;
                            $info[$key][$rank][] = $value;
                        }
                        //分组内部逆序排名
                        ksort($info[$key]);
                    }
                    //统计
                    if ($stat && count($info)) {
                        //开赛，未开赛场次
                        $game_db = pc_base::load_model('game_model');
                        $stat_info['total_game'] = $game_db->count($where);
                        $stat_info['ready_game'] = $game_db->count('`status`=17 AND ' . $where);
                        $stat_info['has_start_game'] = $stat_info['total_game'] - $stat_info['ready_game'];
                        $stat_info['has_start_game_rate'] = round(($stat_info['has_start_game'] / $stat_info['total_game']) * 100, 2) . "%";
                        $stat_info['ready_game_rate'] = round(($stat_info['ready_game'] / $stat_info['total_game']) * 100, 2) . "%";

                        //统计
                        $stat_info['max_goal']['total'] = max($count['total']['goal']);
                        $stat_info['max_goal']['home'] = max($count['home']['goal']);
                        $stat_info['max_goal']['away'] = max($count['away']['goal']);
                        $stat_info['min_goal']['total'] = min($count['total']['goal']);
                        $stat_info['min_goal']['home'] = min($count['home']['goal']);
                        $stat_info['min_goal']['away'] = min($count['away']['goal']);
                        $stat_info['max_nongoal']['total'] = max($count['total']['nongoal']);
                        $stat_info['max_nongoal']['home'] = max($count['home']['nongoal']);
                        $stat_info['max_nongoal']['away'] = max($count['away']['nongoal']);
                        $stat_info['min_nongoal']['total'] = min($count['total']['nongoal']);
                        $stat_info['min_nongoal']['home'] = min($count['home']['nongoal']);
                        $stat_info['min_nongoal']['away'] = min($count['away']['nongoal']);

                        //主场胜出
                        $stat_info['home_win'] = $count['home']['win'];
                        $stat_info['home_win_rate'] = round(($stat_info['home_win'] / $count['home']['sum']) * 100, 2) . "%";

                        //平局(平局只能以主客其中一组数据统计，不能以总统计)
                        $stat_info['draw'] = $count['home']['draw'];
                        $stat_info['draw_rate'] = round(($stat_info['draw'] / $count['home']['sum']) * 100, 2) . "%";

                        //客场胜出
                        $stat_info['away_win'] = $count['away']['win'];
                        $stat_info['away_win_rate'] = round(($stat_info['away_win'] / $count['away']['sum']) * 100, 2) . "%";

                        //总进球数
                        $stat_info['total_goal'] = array_sum($count['total']['goal']);
                        $stat_info['total_goal_per'] = round(($stat_info['total_goal'] / $count['total']['sum']), 2);

                        //主场进球数
                        $stat_info['home_goal'] = array_sum($count['home']['goal']);
                        $stat_info['home_goal_per'] = round(($stat_info['home_goal'] / $count['home']['sum']), 2);

                        //客场进球数
                        $stat_info['away_goal'] = array_sum($count['away']['goal']);
                        $stat_info['away_goal_per'] = round(($stat_info['away_goal'] / $count['away']['sum']), 2);

                        //攻守能力
                        foreach ($info as $key => $group) {
                            foreach ($group as $value) {
                                foreach ($value as $row) {
                                    //最佳攻击力
                                    if ($row['goal'] == $stat_info['max_goal'][$key]) {
                                        $stat_info['best_attack'][$key][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                    }
                                    //最差攻击力
                                    if ($row['goal'] == $stat_info['min_goal'][$key]) {
                                        $stat_info['weak_attack'][$key][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                    }
                                    //最差防守
                                    if ($row['nongoal'] == $stat_info['max_nongoal'][$key]) {
                                        $stat_info['weak_defence'][$key][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                    }
                                    //最佳防守
                                    if ($row['nongoal'] == $stat_info['min_nongoal'][$key]) {
                                        $stat_info['best_defence'][$key][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                    }
                                }
                            }
                        }
                        //开启统计，返回积分榜、统计数据
                        return array($info, $stat_info);
                    }
                }
            }
        }
        //返回数据
        return $info;
    }
}
?>