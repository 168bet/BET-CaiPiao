<?php
/**
 * 后台商品管理
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('util', 'content');

class product extends admin {

    private $db;
    private $stock_db;
    private $admin_db;

    function __construct() {
        parent::__construct();
        $this->db       = pc_base::load_model('product_model');
        $this->stock_db = pc_base::load_model('product_stock_model');
        $this->admin_db = pc_base::load_model('admin_model');
    }

    /**
     * 商品管理
     */
    public function manage() {
        $page    = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $where   = '';
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $type    = isset($_GET['type']) ? (int)$_GET['type'] : '';

        if ($type === 1 && !empty($keyword)) {
            $where .= 'name="' . $keyword . '"';
        }

        $listArr = $this->db->listinfo($where, 'productid DESC', $page, 15);
        $pages   = $this->db->pages;

        //$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
        //$end_time   = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);

        foreach ($listArr as $k => $v) {
            $list[$k]            = $v;
            $productId           = intval($v['productid']);
            $stockData           = $this->stock_db->get_one('productid=' . $productId);
            $list[$k]['stock']   = isset($stockData['productid']) ? $stockData['stock'] : 0;
            $addUserData         = $this->admin_db->get_one('userid=' . $v['adduserid']);
            $list[$k]['adduser'] = isset($addUserData['username']) ? $addUserData['username'] : '';
            $upUserData          = $this->admin_db->get_one('userid=' . $v['upuserid']);
            $list[$k]['upuser']  = isset($upUserData['username']) ? $upUserData['username'] : '';;
        }

        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=product&a=add\', title:\'' . L('product_add') . '\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('product_add'));
        include $this->admin_tpl('product_list');
    }

    /**
     * 新增商品信息并且生成一条零库存信息
     */
    public function add() {
        header("Cache-control: private");
        if (isset($_POST['dosubmit'])) {
            if (empty($_POST['info']['name'])) {
                showmessage(L('name_exist'));
            }

            if (empty($_POST['info']['price'])) {
                showmessage(L('price_exist'));
            }

            if ((int)$_POST['info']['price'] <= 0) {
                showmessage(L('price_error'));
            }

            if (empty($_POST['info']['picurl'])) {
                showmessage(L('picurl_exist'));
            }

            $info              = $_POST['info'];
            $info['addtime']   = time();
            $info['adduserid'] = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
            $this->db->insert($info);

            if ($productId = $this->db->insert_id()) {
                $this->stock_db->insert([
                    'productid' => $productId,
                    'stock'     => 0,
                ]);

                showmessage(L('operation_success'), '?m=admin&c=product&a=manage', '', 'add');
            }

            showmessage(L('operation_failure'), HTTP_REFERER);
        } else {
            include $this->admin_tpl('product_add');
        }
    }

    /**
     * 编辑商品信息
     */
    public function edit() {
        if (isset($_POST['dosubmit'])) {
            $id = $_POST['info']['productid'];

            if ($id <= 0) {
                showmessage(L('productid_exist'));
            }

            if (empty($_POST['info']['name'])) {
                showmessage(L('name_exist'));
            }

            if (empty($_POST['info']['price'])) {
                showmessage(L('price_exist'));
            }

            if ((int)$_POST['info']['price'] <= 0) {
                showmessage(L('price_error'));
            }

            if (empty($_POST['info']['picurl'])) {
                showmessage(L('picurl_exist'));
            }

            $info             = $_POST['info'];
            $info['uptime']   = time();
            $info['upuserid'] = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
            unset($_POST['productid']);

            if ($this->db->update($info, array('productid' => $id))) {
                showmessage(L('operation_success'), '?m=admin&c=product&a=manage', '', 'edit');
            } else {
                showmessage(L('operation_failure'), HTTP_REFERER);
            }
        } else {
            $id   = isset($_GET['id']) ? $_GET['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
            $data = $this->db->get_one(array('productid' => $id));
            include $this->admin_tpl('product_edit');
        }
    }

    /**
     * 删除商品信息
     */
    public function delete() {
        $idArr = isset($_POST['id']) ? $_POST['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
        $idArr = array_map('intval', $idArr);
        $where = to_sqls($idArr, '', 'productid');

        if ($this->db->delete($where)) {
            $this->stock_db->delete($where);
            showmessage(L('operation_success'), HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'), HTTP_REFERER);
        }
    }

    /**
     * 编辑商品库存
     */
    public function stock_edit() {
        if (isset($_POST['dosubmit'])) {
            $id = $_POST['info']['productid'];

            if ($id <= 0) {
                showmessage(L('productid_exist'));
            }

            $info = $_POST['info'];
            unset($_POST['productid']);

            if ($this->stock_db->update($info, array('productid' => $id))) {
                showmessage(L('operation_success'), '?m=admin&c=product&a=manage', '', 'edit_stock');
            } else {
                showmessage(L('operation_failure'), HTTP_REFERER);
            }
        } else {
            $id   = isset($_GET['id']) ? $_GET['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
            $data = $this->stock_db->get_one(array('productid' => $id));
            include $this->admin_tpl('product_stockedit');
        }
    }

}
