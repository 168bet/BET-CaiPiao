<?php
/**
 * 后台积分比例设置
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('util', 'content');

class point_setting extends admin {

    private $db;
    private $admin_db;

    function __construct() {
        parent::__construct();
        $this->db = pc_base::load_model('dict_model');
        $this->admin_db = pc_base::load_model('admin_model');
    }

    /**
     * 积分比例管理
     */
    public function manage() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $where = '';
        $type  = $_POST['type'];

        if ($type == 1 && !empty($_POST['keyword'])) {
            $where = 'name=' . $_POST['keyword'];
        }

        $listArr = $this->db->listinfo($where, 'id DESC', $page, 15);
        $pages   = $this->db->pages;

        foreach ($listArr as $k => $v) {
            $list[$k]  = $v;
            $lastUserData         = $this->admin_db->get_one('userid=' . $v['lastuserid']);
            //var_dump($lastUserData);die();
            $list[$k]['lastuser'] = isset($lastUserData['userid']) ? $lastUserData['username'] : '';
        }

        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=point_setting&a=add\', title:\'' . L('dict_add') . '\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('dict_add'));
        include $this->admin_tpl('point_setting_list');
    }

    /**
     * 新增积分比例
     */
    public function add() {
        header("Cache-control: private");
        if (isset($_POST['dosubmit'])) {
            if (empty($_POST['info']['name_cn'])) {
                showmessage(L('name_cn_exist'));
            }

            if (empty($_POST['info']['name_en'])) {
                showmessage(L('name_en_exist'));
            }

            if ((int)$_POST['info']['value'] <= 0) {
                showmessage(L('value_exist'));
            }

            if (empty($_POST['info']['note'])) {
                showmessage(L('note_exist'));
            }

            $info               = $_POST['info'];
            $info['lastdate']   = time();
            $info['lastuserid'] = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
            $this->db->insert($info);

            if ($this->db->insert_id()) {
                showmessage(L('operation_success'), '?m=admin&c=point_setting&a=manage', '', 'add');
            }

            showmessage(L('operation_failure'), HTTP_REFERER);
        } else {
            include $this->admin_tpl('point_setting_add');
        }
    }

    /**
     * 编辑积分比例
     */
    public function edit() {
        if (isset($_POST['dosubmit'])) {
            $id = $_POST['info']['id'];

            if ($id <= 0) {
                showmessage(L('id_exist'));
            }

            if (empty($_POST['info']['name_cn'])) {
                showmessage(L('name_cn_exist'));
            }

            if (empty($_POST['info']['name_en'])) {
                showmessage(L('name_en_exist'));
            }

            if ((int)$_POST['info']['value'] <= 0) {
                showmessage(L('value_exist'));
            }

            if (empty($_POST['info']['note'])) {
                showmessage(L('note_exist'));
            }

            $info               = $_POST['info'];
            $info['lastdate']   = time();
            $info['lastuserid'] = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
            unset($_POST['id']);

            if ($this->db->update($info, array('id' => $id))) {
                showmessage(L('operation_success'), '?m=admin&c=point_setting&a=manage', '', 'edit');
            } else {
                showmessage(L('operation_failure'), HTTP_REFERER);
            }
        } else {
            $id   = isset($_GET['id']) ? $_GET['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
            $data = $this->db->get_one(array('id' => $id));
            include $this->admin_tpl('point_setting_edit');
        }
    }

    /**
     * 删除
     */
    public function delete() {
        $idArr = isset($_POST['id']) ? $_POST['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
        $idArr = array_map('intval', $idArr);
        $where = to_sqls($idArr, '', 'id');

        if ($this->db->delete($where)) {
            showmessage(L('operation_success'), HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'), HTTP_REFERER);
        }
    }

}
