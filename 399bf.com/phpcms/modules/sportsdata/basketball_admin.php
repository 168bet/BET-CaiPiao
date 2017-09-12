<?php
/**
 * 后台篮球数据管理
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class basketball_admin extends admin
{

    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = pc_base::load_model('bt_live_schedule_model');
    }

    /**
     * 篮球比赛管理
     */
    public function manage()
    {

    }

    /**
     * 编辑篮球比赛数据
     */
    public function edit()
    {

    }



}
