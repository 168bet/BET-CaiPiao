<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class letgoal_detail_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'win007.com';
        $this->table_name = 'letgoal_detail';
        parent::__construct();
    }
}
?>