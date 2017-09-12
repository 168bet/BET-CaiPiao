<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_func('global','wap');
class tag {
    private $db;
    function __construct() {
        $this->db = pc_base::load_model('content_model');
        $this->keyword_db = pc_base::load_model('keyword_model');
        $this->siteid = get_siteid();
    }

    /**
     * 按照模型搜索
     */
    public function lists() {

        $tag = safe_replace(addslashes($_GET['tag']));
        $keyword_data_db = pc_base::load_model('keyword_data_model');
        //获取标签id
        $r = $this->keyword_db->get_one(array('keyword'=>$tag, 'siteid'=>$this->siteid), 'id');
        if (!$r['id']) showmessage('不存在此关键字！');
        $tagid = intval($r['id']);

        $page = max($_GET['page'], 1);
        $pagesize = 9;
        $where = '`tagid`=\''.$tagid.'\' AND `siteid`='.$this->siteid;
        $infos = $keyword_data_db->listinfo($where, '`id` DESC', $page, $pagesize, '', 10,
            WAP_PATH.'tag/{$tag}/~'.WAP_PATH.'tag/{$tag}/{$page}/', array('tag' => $tag));
        //$pages = $keyword_data_db->pages;
        //$total = $keyword_data_db->number;
        if (is_array($infos)) {
            $datas = array();
            $hits_ids = array();
            $this->category = getcache('category_content_' . $this->siteid, 'commons');
            foreach ($infos as $info) {
                list($contentid, $modelid) = explode('-', $info['contentid']);
                $this->db->set_model($modelid);
                $hits_ids[] = $hits_id = "'c-" . $modelid . "-" . $contentid . "'";
                $res = $this->db->get_one(array('id'=>$contentid), 'title, description, url, inputtime, style, thumb, keywords');
                //如果文章被删除，则跳过
                if (!$res) continue;
                //替换wap域名
                $res['url'] = url_replace($res['url'], WAP_PATH);
                $datas[$hits_id] = $res;
            }

            //读取hits表的views字段
            /*if (count($hits_ids)) {
                $db_config = pc_base::load_config('database');
                $table_name = $db_config['default']['tablepre'] . 'hits';
                $ids = join(',', $hits_ids);
                $sql = 'SELECT `hitsid`,`views` FROM ' . $table_name . ' WHERE `hitsid` IN (' . $ids . ')';
                $hits = $this->db->query($sql);
                $hits_info = $hits->fetch_all(MYSQLI_ASSOC);
                if (!empty($hits_info)) {
                    foreach ($hits_info as $value) {
                        $key = "'" . $value['hitsid'] . "'";
                        if (isset($datas[$key])) $datas[$key] = array_merge($value, $datas[$key]);
                    }
                }
            }*/
        }

        $SEO = seo($this->siteid, '', $tag);
        include template('wap','tag_list');
    }
}