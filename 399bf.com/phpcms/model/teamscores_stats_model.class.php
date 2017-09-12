<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class teamscores_stats_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'teamscores_stats';
        parent::__construct();
    }
}
?>