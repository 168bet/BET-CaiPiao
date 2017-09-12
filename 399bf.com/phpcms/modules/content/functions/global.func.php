<?php

    /*
     * 相关资讯，调取同频道、同标签
     * @param $CAT 栏目信息
     * @param $id 文章id 作过滤处理
     * @param $keywords 标签
     * @param $num 文章条数
     * @return array
     */
    function getRelationList($CAT, $keywords, $id, $num = 7)
    {
        #--------------同频道----------------
        $db = pc_base::load_model('content_model');
        $db->set_model($CAT['modelid']);

        $arrChildId = explode(',', $CAT['arrchildid']);
        if (count($arrChildId) > 1) {
            $sql = '`status`=99 AND `thumb`<>"" AND ' . to_sqls($arrChildId, '', '`catid`');
        } else {
            $sql = '`status`=99 AND `thumb`<>"" AND `catid`=' . $CAT['catid'];
        }

        $field = '`title`,`thumb`,`url`,`description`,`keywords`,`inputtime`,`id`';
        $list = $db->select($sql, $field, $num, '`inputtime` DESC', '', 'id');

        //过滤当前文章
        if ($list[$id]) {
            unset($list[$id]);
        }

        #----------------同标签-----------------
        if (!$keywords) {
            return $list;
        }

        //标签
        $keyword_db = pc_base::load_model('keyword_model');
        if (count($keywords) > 1) {
            $sql = '`siteid`=' . $CAT['siteid'] . ' AND ' . to_sqls($keywords, '', '`keyword`');
        } else {
            $sql = '`siteid`=' . $CAT['siteid'] . ' AND `keyword`="' . $keywords[0] . '"';
        }
        $tagList = $keyword_db->select($sql, 'id');

        if (!$tagList) {
            return $list;
        }

        //包含标签的内容id
        $keyword_data_db = pc_base::load_model('keyword_data_model');
        if (count($tagList) > 1) {
            $sql = '`siteid`=' . $CAT['siteid'] . ' AND ' . to_sqls(array_column($tagList, 'id'), '', '`tagid`');
        } else {
            $sql = '`siteid`=' . $CAT['siteid'] . ' AND `tagid`=' . $tagList[0]['id'];
        }
        $contentIdList = $keyword_data_db->select($sql, '`contentid`', $num, '`id` DESC');
        $contentIdList = array_unique($contentIdList);

        if (!$contentIdList) {
            return $list;
        }

        //包含标签的内容 过滤当前文章
        $contentList = [];
        foreach ($contentIdList as $value) {
            list($contentid, $modelid) = explode('-', $value['contentid']);
            if ($modelid == $CAT['modelid'] && $contentid == $id) {
                continue;
            }
            $db->set_model($modelid);
            $res = $db->get_one(['id' => $contentid], $field);
            if ($res) $contentList[] = $res;
        }

        if(!$contentList){
            return $list;
        }

        $list = array_merge($list, $contentList);
        shuffle($list);

        if (count($list) <= $num) {
            return $list;
        }

        $tempList = array_chunk($list, $num);
        return $tempList[0];
    }

        /**
	 *  通过标签，获取与标签对应相关的文章，即"猜你喜欢"一栏
	 *  该方法是为了获取文章详情页面，猜你喜欢栏目的内容 ，根据标签（keywords）找到对应的相关文章$keywords
	 * @param array  $keywords  标签数组
	 * @return array 相关文章数组
	 */
	 function get_keywords_relation_content($keywords,$siteid,$catid,$num) {
         
	    $keyword_db          = pc_base::load_model("keyword_model");
	    $keyword_data_db     = pc_base::load_model("keyword_data_model");
	    $db                  = pc_base::load_model('content_model');
       
	    $where               = to_sqls($keywords,'','keyword');
	    $keyword_ids         = $keyword_db->select($where);
	    
	    if(empty($keyword_ids)){ // 如果标签不存在
		return NULL;
	    }
	    $keywordId_where     = to_sqls(array_column($keyword_ids,'id'),'','tagid');
	    $data                = $keyword_data_db ->select($keywordId_where);
	    
	    // 获取模型类型数组
	    $model_arr           = getcache('model', 'commons');
	    // $data 数组中的contentid 存放的格式是：例如：1-2（ 文章id - 模型id）
	    // $contentIdArr 数组，用于存储以模型id为key 的二维数组，一级数组存放已过滤掉相同的文章id ，并已模型id分类，存入各自对应的模型id中
	    foreach ($data as $value) {

		$arr = explode('-', $value['contentid']); //$arr[0] :文章id  $arr[1]:模型id
		// 思路：希望将模型id相同的部分的文章id放入各自对应的数组中，并以模型id作为key
		// 如果key已经存在，就将文章id放到这个数组中
		if (!in_array($arr[0], $contentIdArr[$arr[1]])) { // 对于文章id ，过滤掉文章id相同的
		    $contentIdArr[$arr[1]][] = $arr[0];
		}
	    }

	    $contentArr = NULL;
	    $categorys = getcache('category_content_'.$siteid,'commons');
	    $cur_modelid = $categorys[$catid]['modelid'];
	    
	    // key 模型id $db->set_model($CAT['modelid']);
	    foreach ($contentIdArr as $key => $value) {
                $db->set_model($key);
		$add_where = '';
		if($cur_modelid == $key){ // 过滤当前模型下的当前文章
		    $add_where = '  id !='.$_GET['id'].' and  '; 
		}
		$whereidstr    = $add_where.'  id in (' . join(',', $value) . ') and  thumb != "" ';
		$filed         =' id ,catid,title,thumb,keywords,description,url,inputtime,seo_keywords';
		$contentArr[]  = $db->select($whereidstr,$data =$filed, '', $order ='`inputtime` DESC');
	    }
		
	    $contentArr    = explodArr($contentArr);
		shuffle($contentArr);
		$contentArr = array_slice($contentArr, 0,$num);
	    return $contentArr;
    }


       /**
        * 拆分数组
        * @param type $contentArr
        * @return array
        */
	function explodArr($contentArr) {

	    $newArr = array();
	    foreach ($contentArr as $key => $val) {
	       foreach ($val as $k => $v) {
		$newArr[] = $v;
	       }
	    }
	    return $newArr;
       }