<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class game_stats_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'game_stats';
        parent::__construct();
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
}
?>