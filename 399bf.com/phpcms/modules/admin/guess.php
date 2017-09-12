<?php
/**
 * 后台竞猜管理
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);

class guess extends admin
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = pc_base::load_model('guess_game_model');
    }

    /**
     * 竞猜足球
     */
    public function football_manage()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $status_list = array(
            '0' => '未结算',
            '-1' => '已结算'
        );

        //搜索框
        $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
        $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d H:i:s', SYS_TIME);
        $gameid = isset($_GET['gameid']) ? $_GET['gameid'] : '';
        $status = array_key_exists($_GET['status'], $status_list) ? $_GET['status'] : null;

        $where = '`type`=1' . ($start_time ? ' AND `addtime`>=' . strtotime($start_time) : '')
                            . ($end_time ? ' AND `addtime`<=' . strtotime($end_time) : '')
                            . ($gameid ? ' AND `gameid`=' . $gameid : '')
                            . (!is_null($status) ? ' AND `status`=' . $status : '');

        $guess_list = $this->db->listinfo($where, 'addtime DESC', $page, 15);
        $pages = $this->db->pages;

        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=guess&a=football_add\', title:\''.L('guess_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('guess_add'));
        include $this->admin_tpl('football_guess_list');
    }

    /**
     * 竞猜篮球
     */
    public function basketball_manage()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $status_list = array(
            '0' => '未结算',
            '-1' => '已结算'
        );

        //搜索框
        $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
        $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d H:i:s', SYS_TIME);
        $gameid = isset($_GET['gameid']) ? $_GET['gameid'] : '';
        $status = array_key_exists($_GET['status'], $status_list) ? $_GET['status'] : null;

        $where = '`type`=2' . ($start_time ? ' AND `addtime`>=' . strtotime($start_time) : '')
            . ($end_time ? ' AND `addtime`<=' . strtotime($end_time) : '')
            . ($gameid ? ' AND `gameid`=' . $gameid : '')
            . (!is_null($status) ? ' AND `status`=' . $status : '');

        $guess_list = $this->db->listinfo($where, 'addtime DESC', $page, 15);
        $pages = $this->db->pages;

        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=guess&a=basketball_add\', title:\''.L('guess_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('guess_add'));
        include $this->admin_tpl('basketball_guess_list');
    }

    /**
     * 足球竞猜结算
     */
    public function football_balance()
    {

    }

    /**
     * 篮球竞猜结算
     */
    public function basketball_balance()
    {

    }

    /**
     * 添加竞猜足球比赛
     */
    public function football_add()
    {
        header("Cache-control: private");
        if(isset($_POST['dosubmit']))
        {
            $info = $_POST['info'];

            $info['addtime'] = strtotime($info['addtime']);

            $this->db->insert($info);
            if($this->db->insert_id()){
                showmessage(L('operation_success'),'?m=admin&c=guess&a=football_add', '', 'add');
            }
            showmessage(L('operation_failure'), HTTP_REFERER);
        }
        else
        {
            //状态
            $status_list = array(
                '0' => '未结算',
                '-1' => '已结算'
            );
            //竞猜类型
            $guess_type = 1;

            include $this->admin_tpl('football_guess_add');
        }
    }

    /**
     * 添加竞猜篮球比赛
     */
    public function basketball_add()
    {
        header("Cache-control: private");
        if(isset($_POST['dosubmit']))
        {
            $info = $_POST['info'];

            $info['addtime'] = strtotime($info['addtime']);

            $this->db->insert($info);
            if($this->db->insert_id()){
                showmessage(L('operation_success'),'?m=admin&c=guess&a=basketball_add', '', 'add');
            }
            showmessage(L('operation_failure'), HTTP_REFERER);
        }
        else
        {
            //状态
            $status_list = array(
                '0' => '未结算',
                '-1' => '已结算'
            );
            //竞猜类型
            $guess_type = 2;

            include $this->admin_tpl('basketball_guess_add');
        }
    }

    /*
     * ajax验证比赛id是否存在于数据库中，并且每个gameid只能存在一条竞猜
     * $type 1：足球； 2：篮球；
     */
    public function ajax_check_game_id()
    {
        $gameid = isset($_GET['gameid']) ? $_GET['gameid'] : exit(0);

        $type = isset($_GET['type']) ? $_GET['type'] : 1;

        $game_model = pc_base::load_model($type == 1 ? 'game_model' :'bt_schedule_model');

        switch ($type) {
            case 1:
                $game_where = '`gameid`=' . $gameid;
                $guess_where = $game_where . (isset($_GET['id']) ? ' AND `id`<>' . $_GET['id'] : '');
                break;
            case 2:
                $game_where = '`scheduleid`=' . $gameid;
                $guess_where = '`gameid`=' . $gameid . (isset($_GET['id']) ? ' AND `id`<>' . $_GET['id'] : '');
                break;
            default:
                break;
        }

        if ($game_model->count($game_where) && !$this->db->count($guess_where)) {
            exit('1');
        } else {
            exit('0');
        }
    }

    /**
     * 删除竞猜
     */
    public function guess_delete()
    {
        $ids = isset($_REQUEST['id']) && is_array($_REQUEST['id']) && count($_REQUEST['id']) ? $_REQUEST['id'] : exit(0);

        if ($this->db->delete('`id` IN (' . join(',', $ids) . ')')) {
            showmessage(L('operation_success'), HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'), HTTP_REFERER);
        }
    }

    /*
     * 竞猜编辑
     */
    public function guess_edit()
    {
        header("Cache-control: private");
        if(isset($_POST['dosubmit']))
        {
            $info = $_POST['info'];

            if (isset($_POST['id']) && isset($_POST['type'])) {
                if ($this->db->update($info, '`id`=' . $_POST['id'] . ' AND `type`=' . $_POST['type'])) {
                    showmessage(L('operation_success'), '?m=admin&c=guess&a=' . $_POST['type'] == 1 ? 'football_manage' : 'basketball_manage', '', 'edit');
                } else {
                    showmessage(L('operation_failure'), HTTP_REFERER);
                }
            } else {
                showmessage(L('operation_failure'), HTTP_REFERER);
            }
        }
        else
        {
            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : exit(0);
            $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : exit(0);

            $info = $this->db->get_one('`id`=' . $id . ' AND `type`=' . $type);

            //状态
            $status_list = array(
                '0' => '未结算',
                '-1' => '已结算'
            );

            if ($info) {
                include $this->admin_tpl($type == 1 ? 'football_guess_edit' : 'basketball_guess_edit');
            } else {
                showmessage(L('guess_not_exist'), HTTP_REFERER);
            }
        }
    }

}
