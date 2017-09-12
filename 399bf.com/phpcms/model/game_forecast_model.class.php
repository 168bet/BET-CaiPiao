<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class game_forecast_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'game_forecast';
        parent::__construct();
    }

    ##走势值
    public function value_replace($string)
    {
        if(!isset($string))
        {
            return;
        }
        $string_array=explode(",",$string);
        foreach($string_array as $string_key =>$string_data)
        {
            switch($string_data)
            {
                case W:
                    $string_array[$string_key]="<span class=\"red\">[胜]</span>";
                    break;
                case D:
                    $string_array[$string_key]="<span class=\"blue\">[和]</span>";
                    break;
                default:
                    $string_array[$string_key]="<span class=\"green\">[负]</span>";
            }
        }
        return $string_array;
    }

    ##数值转换
    function object_to_array($obj){
        $_arr = is_object($obj) ? get_object_vars($obj) :$obj;
        foreach ($_arr as $key=>$val){
            $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val):$val;
            $arr[$key] = $val;
        }
        return $arr;
    }

    ##场上位置
    function val_pos($string)
    {
        switch($string)
        {
            case 0:
                $string="守门员";
                break;
            case 1:
                $string="后卫";
                break;
            case 2:
                $string="中场";
                break;
            default:
                $string="前锋";
        }
        return $string;
    }

    /**
     * 获取预测阵容
     */
    public function lineup($id)
    {
        $forecast_info = $this->get_one('`gameid`=' . $id, '`homeplayers` AS `home`,`awayplayers` AS `away`,`hformation`,`aformation`,`forecast`');

        if ($forecast_info) {
            //调用数据库的阵型
            $lineup = array(
                'home' => array(
                    'formation' => $forecast_info['hformation'] ? $forecast_info['hformation'] : false
                ),
                'away' => array(
                    'formation' => $forecast_info['aformation'] ? $forecast_info['aformation'] : false
                )
            );

            //预测字段
            $forecast = $forecast_info['forecast'];
            unset($forecast_info['hformation'], $forecast_info['aformation'], $forecast_info['forecast']);

            //循环遍历主客阵容
            foreach ($forecast_info as $type => $info) {
                $lineup_info = json_decode($info, true);
                foreach ($lineup_info as $value) {
                    //场上位置替换语言包
                    $value['Pos'] = $this->val_pos($value['Pos']);
                    //根据status区分首发球员跟替补（只要不是首发都算在替补中）
                    if ($value['Status'] == 3) {
                        $lineup[$type]['starter'][$value['Id']] = $value;
                    } else {
                        $lineup[$type]['reserve'][$value['Id']] = $value;
                    }
                }
                //如果没有阵型数据，则通过首发阵容计算阵型
                if (! $lineup[$type]['formation']) {
                    $format = array_count_values(array_column($lineup[$type]['starter'], 'Pos'));
                    $lineup[$type]['formation'] = $format['后卫'] . $format['中场'] . $format['前锋'];
                }
            }
            return $lineup;
        }
        return false;
    }

    /**
     * 获取预测阵容(通过status细分)
     */
    public function lineup_by_pos($id)
    {
        $forecast_info = $this->get_one('`gameid`=' . $id, '`homeplayers` AS `home`,`awayplayers` AS `away`,`hformation`,`aformation`,`forecast`');

        if ($forecast_info) {
            //调用数据库的阵型
            $lineup = array(
                'home' => array(
                    'formation' => $forecast_info['hformation'] ? $forecast_info['hformation'] : false
                ),
                'away' => array(
                    'formation' => $forecast_info['aformation'] ? $forecast_info['aformation'] : false
                )
            );

            //预测字段
            $forecast = $forecast_info['forecast'];
            unset($forecast_info['hformation'], $forecast_info['aformation'], $forecast_info['forecast']);

            //循环遍历主客阵容
            foreach ($forecast_info as $type => $info) {
                $lineup_info = json_decode($info, true);
                foreach ($lineup_info as $value) {
                    //用status区分首发跟替补，只用来计算阵型
                    if ($value['Status'] == 3) {
                        $formation[$type]['starter'][$value['Id']] = $value;
                    } else {
                        $formation[$type]['reserve'][$value['Id']] = $value;
                    }
                    //通过pos分组
                    $lineup[$type][$value['Pos']][$value['Id']] = $value;
                }
                //如果没有阵型数据，则通过首发阵容计算阵型
                if (! $lineup[$type]['formation']) {
                    $format = array_count_values(array_column($formation[$type]['starter'], 'Pos'));
                    $lineup[$type]['formation'] = $format['后卫'] . $format['中场'] . $format['前锋'];
                }
            }
            return $lineup;
        }
        return false;
    }

}
?>