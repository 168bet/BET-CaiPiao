<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_sys_class('format', '', 0);
pc_base::load_app_func('global','wap');
pc_base::load_app_func('global','content');
class index {
        //比赛状态
    private $arr_status = [
        0 => '未开始',
        1 => '上',
        2 => '中',
        3 => '下',
        4 => '完',
        5 => '断',
        6 => '取',
        7 => '加',
        8 => '加',
        9 => '加',
        10 => '完',
        11 => '点',
        12 => '全',
        13 => '延',
        14 => '斩',
        15 => '待',
        16 => '金',
        17 => '未开始'
    ];
	function __construct() {		
		$this->db = pc_base::load_model('content_model');
		$this->siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
		param::set_cookie('siteid',$this->siteid);	
		$this->wap_site = getcache('wap_site','wap');
		$this->types = getcache('wap_type','wap');
		$this->wap = $this->wap_site[$this->siteid];
		define('WAP_SITEURL', $this->wap['domain'] ? $this->wap['domain'].'index.php?m=wap&c=index&siteid='.$this->siteid : APP_PATH.'index.php?m=wap&siteid='.$this->siteid);
		if($this->wap['status']!=1) exit(L('wap_close_status'));
	}
	
	//展示首页
	public function init() {
		$WAP = $this->wap;
                $TYPE = $this->types;
                $WAP_SETTING = string2array($WAP['setting']);
                $GLOBALS['siteid'] = $siteid = max($this->siteid, 1);
                $template = $WAP_SETTING['index_template'] ? $WAP_SETTING['index_template'] : 'index';
        //                seo
                $SEO['title'] = '竞彩比分直播_足彩竞猜网首页';
                $SEO['keyword'] = '竞猜网首页';
                $SEO['description'] = '399彩迷网为彩民提供最新的足球比分直播、竞彩比分直播、篮球比分直播、足球赛事比分数据，最准的足彩竞猜、竞彩竞猜推荐，399彩迷网致力于为广大彩迷提供最具参考价值的专业分析、精准预测和数据情报！';
                $this->game_db = pc_base::load_model("game_model");
                //即时比分赛事时间范围
                $starttime = SYS_TIME - 12 * 60 * 60; //开始时间
                $endtime = SYS_TIME + 36 * 60 * 60;  //结束时间
                //  //比赛状态数组
                $arr_status = $this->arr_status;
                //获取即时比分赛事
                $live_game_sql = "SELECT
                                g.gameid,
                                g.competitionid,
                                g.competitionshortname,
                                g.competitioncolor,
                                g.date,
                                g.hometeamid,
                                g.homeshortname,
                                g.awayteamid,
                                g.awayshortname,
                                g.neutral,
                                g.homerank,
                                g.awayrank,
                                d.homescore,
                                d.awayscore,
                                d.half,
                                d.tstarttime,
                                d.status,
                                d.homeredcard,
                                d.awayredcard,
                                d.homeyellowcard,
                                d.awayyellowcard,
                                s.stat
                            FROM ft_live_game g
                            LEFT JOIN ft_live_game_data d ON g.gameid = d.gameid
                            LEFT JOIN ft_live_game_goal_stats s ON g.gameid=s.gameid
                             WHERE 1=1 AND g.date > $starttime AND g.date < $endtime
                            ORDER BY g.date ASC";
        $this->game_db->query($live_game_sql);
        $live_game_data = $this->game_db->fetch_array();
        //将gameid作为$live_game_data的key
        //生成以competitionid为key，competitionshortname为value的数组$competitions
        if (count($live_game_data)) {
            foreach ($live_game_data as &$_data) {
                //状态文本
                $_data['status_text'] = $this->arr_status[$_data['status']];
                //上、下半场时间处理
                switch ($_data['status']) {
                    case 1:
                        $time = $_data['tstarttime'] ? ceil((time() - $_data['tstarttime']) / 60) : ceil((time() - $_data['date']) / 60);
                        $_data['status_text'] = ($time > 45 ? '45+' : $time) . '\'';
                        break;
                    case 3:
                        //下半场如果超过90分钟，改为显示90+
                        $time = $_data['tstarttime'] ? ceil((45 * 60 + time() - $_data['tstarttime']) / 60) : ceil((time() - $_data['date']) / 60);
                        $_data['status_text'] = ($time > 90 ? '90+' : $time) . '\'';
                        break;
                    default:
                        break;
                }
                //角球
                if ($_data['stat']) {
                    $stat = json_decode($_data['stat'], true);
                    foreach ($stat as $stats) {
                        if ($stats['Name'] == '角球次数') {
                            $_data['homecorner'] = $stats['Home'];
                            $_data['awaycorner'] = $stats['Away'];
                        }
                    }
                }
            }

            $data_list = array();
            foreach ($live_game_data as $id => $data) {
                //未开始
                if (in_array($data['status'], array(0, 17))) {
                    $data_list['ready'][$id] = $data;
                    //结束
                } elseif (in_array($data['status'], array(4, 13, 14, 15))) {
                    $data_list['end'][$id] = $data;
                    //正在进行
                } else {
                    $data_list['start'][$id] = $data;
                }
            }
        }
        $live_game_data = empty($data_list['start']) ? $data_list['ready']:array_merge($data_list['start'],$data_list['ready']);
        include template('wap', $template);
    }

    //展示列表页
	public function lists() {
		$WAP = $this->wap;
		$WAP_SETTING = string2array($WAP['setting']);
		$GLOBALS['siteid'] = $siteid = max($this->siteid,1);
		$catid = (int)$_GET['catid'];
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');

		//导航高亮
		$nav_id = isset($_GET['nav_id']) ? (int)$_GET['nav_id'] : 3;

		if(!isset($CATEGORYS[$catid])) exit(L('parameter_error'));
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);

		//SEO
		$setting = string2array($setting);
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		//重新设置分页title
//		$SEO['title'] .= '_399彩迷';
		$GLOBALS['seo_title'] = $SEO['title'];
		$SEO['title'] = page_title($_REQUEST['page']);
		
		$template = isset($setting['list_template']) ? $setting['list_template'] : 'list';
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = $WAP_SETTING['listnum'] ? intval($WAP_SETTING['listnum']) : 20 ;
		$offset = ($page - 1) * $pagesize;

		#-----------------查询条件-----------------
		$arrChildId = explode(',', $arrchildid);
		if (count($arrChildId) > 1) {
			$where = '`status`=99 AND ' . to_sqls($arrChildId, '', '`catid`');
		} else {
			$where = '`status`=99 AND `catid`=' . $catid;
		}

		$field = '`id`,`catid`,`title`,`thumb`,`keywords`,`description`,`inputtime`,`url`';
		$list = $this->db->select($where, $field, $offset.','.$pagesize,'inputtime DESC');

		foreach ($list as $key => $r) {
			$list[$key]['url'] = url_replace($r['url'], WAP_PATH); //替换wap域名
		}

		include template('wap', $template);
	}
            //异步获取即时比分
    public function ajax_live_game_data()
    {
        if ($_POST['gameids']) {
            $state = true;
            $where = 'a.gameid IN (' . join(',', $_POST['gameids']) . ')';
            $model = pc_base::load_model('live_game_data_model');
            //比赛状态数组
            $status_list = $this->status_arr;
            //即时比分数据
            $sql = 'SELECT a.*,
                           b.date,
                           c.stat
                    FROM ft_live_game_data a
                    LEFT JOIN ft_live_game b ON a.gameid=b.gameid
                    LEFT JOIN ft_live_game_goal_stats c ON a.gameid=c.gameid
                    WHERE ' . $where . ';';

            $model->query($sql);
            $info = $model->fetch_array();

            foreach ($info as &$value) {
                //上、下半场时间处理
                switch ($value['status']) {
                    case 1:
                        //下半场如果超过45分钟，改为显示45+
                        $time = $value['tstarttime'] ? ceil((time() - $value['tstarttime']) / 60) : ceil((time() - $value['date']) / 60);
                        $value['text'] = ($time > 45 ? '45+' : $time) . '\'';
                        $value['state_tag'] = true;
                        $value['run_tag'] = true;
                        break;
                    case 3:
                        //下半场如果超过90分钟，改为显示90+
                        $time = $value['tstarttime'] ? ceil((45 * 60 + time() - $value['tstarttime']) / 60) : ceil((time() - $value['date']) / 60);
                        $value['text'] = ($time > 90 ? '90+' : $time) . '\'';
                        $value['state_tag'] = true;
                        $value['run_tag'] = true;
                        break;
                    default:
                        //完场比赛标志
                        if (in_array($value['status'], array(4, 10))) {
                            $value['is_over'] = true;
                        }
                        //其他状态直接显示，不计算时间
                        $value['text'] = array_key_exists($value['status'], $status_list) ? $status_list[$value['status']] : '';
                        $value['state_tag'] = false;
                        $value['run_tag'] = $value['status'] == 2 ? true : false;
                        break;
                }

                //角球
                if ($value['stat']) {
                    $stat = json_decode($value['stat'], true);
                    foreach ($stat as $stats) {
                        if ($stats['Name'] == '角球次数') {
                            $value['homecorner'] = $stats['Home'];
                            $value['awaycorner'] = $stats['Away'];
                        }
                    }
                }
            }

            $result = array(
                'state' => $state,
                'data' => $info
            );
        } else {
            $state = false;
            $result = array(
                'state' => $state
            );
        }

        exit(json_encode($result));
    }
	
    //展示内容页
	public function show() {
		$WAP = $this->wap;
		$WAP_SETTING = string2array($WAP['setting']);
		$TYPE = $this->types;
		$GLOBALS['siteid'] = $siteid = max($this->siteid,1);
		$typeid = $type_tmp = intval($_GET['typeid']);	
		$catid = $_GET['catid'];
		$id = intval($_GET['id']);
		if(!$catid || !$id) exit(L('parameter_error'));
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		$page = intval($_GET['page']);
		$page = max($page,1);

		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) exit(L('information_does_not_exist','','content'));
		$this->category = $CAT = $CATEGORYS[$catid];
		$this->category_setting = $CAT['setting'] = string2array($this->category['setting']);
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		if(!$r || $r['status'] != 99) showmessage(L('info_does_not_exists'),'blank');
		$this->db->table_name = $tablename.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;
                
		//再次重新赋值，以数据库为准
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];
		
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
                #-------------- 新增 获取‘猜你喜欢’栏目内容 -----------------
		if(!empty($keywords)){
		   $contentArr = get_keywords_relation_content($keywords,$siteid,$catid,3);
		}
		$pics = $pictureurls;

		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		//seo关键词重新处理
		$SEO['keyword'] = $data['seo_keywords'];
//		$SEO['title'] .= '_399彩迷';

		$typeid = $type_tmp;

	    if(strpos($content, '[/page]')!==false) {
			$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
		} elseif (strpos($content, '[page]')!==false) {
			$content = str_replace('[page]', '', $content);
		}

		//根据设置字节数对文章加入分页标记
		//if($maxcharperpage < 10) $maxcharperpage = $WAP_SETTING['c_num'];
		//$contentpage = pc_base::load_app_class('contentpage','content');
		//$content = $contentpage->get_data($content,$maxcharperpage);
		$isshow = 1;
		if($pictureurls) {
			$pictureurl = pic_pages($pictureurls);
			$isshow = 0;			
			//进行图片分页处理		
			$PIC_POS = strpos($pictureurl, '[page]');
			if($PIC_POS !== false) {
				$this->url = pc_base::load_app_class('wap_url', 'wap');
				$pictureurls = array_filter(explode('[page]', $pictureurl));
				$pagenumber = count($pictureurls);
				if (strpos($pictureurl, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->show($id, $i, $catid, $typeid);
				}
				$END_POS = strpos($pictureurl, '[/page]');
				if($END_POS !== false) {
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $pictureurl, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				
				//当不存在 [/page]时，则使用下面分页
				$pages = content_pages($pagenumber,$page, $pageurls, 0);
				//判断[page]出现的位置是否在第一位 
				if($CONTENT_POS<7) {
					$pictureurl = $pictureurls[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$pictureurl = $title.'[/page]'.$pictureurls[$page-1];
					} else {
						$pictureurl = $pictureurls[$page-1];
					}
				}		
			}			
		}

		//进行自动分页处理		
		$CONTENT_POS = strpos($content, '[page]');
		if($CONTENT_POS !== false) {
			$this->url = pc_base::load_app_class('wap_url', 'wap');
			$contents = array_filter(explode('[page]', $content));
			$pagenumber = count($contents);
			if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
				$pagenumber--;
			}
			for($i=1; $i<=$pagenumber; $i++) {
				$pageurls[$i] = $this->url->show($id, $i, $catid, $typeid);
			}
			$END_POS = strpos($content, '[/page]');
			if($END_POS !== false) {
				if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
					foreach($m[1] as $k=>$v) {
						$p = $k+1;
						$titles[$p]['title'] = strip_tags($v);
						$titles[$p]['url'] = $pageurls[$p][0];
					}
				}
			}
			
			//当不存在 [/page]时，则使用下面分页
			$pages = content_pages($pagenumber,$page, $pageurls);
			//判断[page]出现的位置是否在第一位 
			if($CONTENT_POS<7) {
				$content = $contents[$page];
			} else {
				if ($page==1 && !empty($titles)) {
					$content = $title.'[/page]'.$contents[$page-1];
				} else {
					$content = $contents[$page-1];
				}
			}
			if($_GET['remains']=='true') {
		        $content = $pages ='';
		        for($i=$page;$i<=$pagenumber;$i++) {
		            $content .=$contents[$i-1];
		        }
	    	}			
		}
				
		//$content = content_strip(wml_strip($content));
		//$template = $WAP_SETTING['show_template'] ? $WAP_SETTING['show_template'] : 'show';
		$template = $this->category_setting['show_template'];
		include template('wap', $template);
	}
	
	//提交评论
	function comment() {
		$WAP = $this->wap;
		$TYPE = $this->types;		
		if($_POST['dosumbit']) {
			$comment = pc_base::load_app_class('comment','comment');
			pc_base::load_app_func('global','comment');
			$username = $this->wap['sitename'].L('phpcms_friends');
			$userid = param::get_cookie('_userid');		
			$catid = intval($_POST['catid']);		
			$typeid = intval($_POST['typeid']);		
			$contentid = intval($_POST['id']);		
			$msg = trim($_POST['msg']);
			$commentid = remove_xss(safe_replace(trim($_POST['commentid'])));
			$title = $_POST['title'];
			$url = $_POST['url'];	
			
			//通过API接口调用数据的标题、URL地址
			if (!$data = get_comment_api($commentid)) {
				exit(L('parameter_error'));
			} else {
				$title = $data['title'];
				$url = $data['url'];
				unset($data);
			} 		
			$data = array('userid'=>$userid, 'username'=>$username, 'content'=>$msg);
			$comment->add($commentid, $this->siteid, $data, $id, $title, $url);
			echo '<script type="text/javaScript" src="'.JS_PATH.'jquery.min.js"></script><script language="JavaScript" src="'.JS_PATH.'admin_common.js"></script>';
			echo L('wap_guestbook').'<br/><a href="'.show_url($catid,$contentid,$typeid).'">'.L('wap_goback').'</a><script language=javascript>setTimeout("redirect(\''.HTTP_REFERER.'\');",3000);</script>';
		}
	}
	
	//评论列表页
	function comment_list() {
		$WAP = $this->wap;
		$TYPE = $this->types;		
		$comment = pc_base::load_app_class('comment','comment');
		pc_base::load_app_func('global','comment');	
		$typeid  = intval($_GET['typeid']);	
		$GLOBALS['siteid'] = max($this->siteid,1);
		$commentid = isset($_GET['commentid']) && trim(addslashes(urldecode($_GET['commentid']))) ? trim(addslashes(urldecode($_GET['commentid']))) : exit(L('illegal_parameters'));
		if(!preg_match("/^[a-z0-9_\-]+$/i",$commentid)) exit(L('illegal_parameters'));
		list($modules, $contentid, $siteid) = decode_commentid($commentid);	
		list($module, $catid) = explode('_', $modules);
		$comment_setting_db = pc_base::load_model('comment_setting_model');
		$setting = $comment_setting_db->get_one(array('siteid'=>$this->siteid));	
		
		//通过API接口调用数据的标题、URL地址
		if (!$data = get_comment_api($commentid)) {
			exit(L('illegal_parameters'));
		} else {
			$title = $data['title'];
			$url = $data['url'];
			unset($data);
		}
					
		include template('wap', 'comment_list');
	}
	
	//导航页
	function maps() {
		$WAP = $this->wap;
		$TYPE = $this->types;
		$WAP_SETTING = string2array($WAP['setting']);	
		$GLOBALS['siteid'] = max($this->siteid,1);	
		include template('wap', 'maps');
	}
	
	//展示大图
	function big_image() {
		$WAP = $this->wap;
		$TYPE = $this->types;
		$WAP_SETTING = string2array($WAP['setting']);
		$GLOBALS['siteid'] = max($this->siteid,1);		
		$url=base64_decode(trim($_GET['url']));
		$url = str_replace(array('"',"'",'(',')',' '),'',$url);
		if(!preg_match('/(jpg|png|gif|bmp)$/i',fileext($url))) exit('img src error');
		$width = $_GET['w'] ?  trim(intval($_GET['w'])) : 320 ;
		$new_url = thumb($url,$width,0);
		include template('wap', 'big_image');
	}
        
	/**
	* 情报中心 图文列表信息 实现下一页功能  返回json 数据
	* 请求路径： http://域名/index.php?m=wap&c=index&a=next_lists&typeid=1&page=1
	* @param int $catid  栏目id
	* @param int $page	第几页
	* @return Array json数据
	*/
	function next_lists()
	{
		$WAP = $this->wap;
		$WAP_SETTING = string2array($WAP['setting']);

		$catid = (int)$_GET['catid'];

		$siteids = getcache('category_content', 'commons');
		$siteid = $siteids[$catid];

		$CATEGORYS = getcache('category_content_' . $siteid, 'commons');
		if (!isset($CATEGORYS[$catid])) exit(L('parameter_error'));
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);

		$MODEL = getcache('model', 'commons');
		$modelid = $CAT['modelid'];
		$tablename = $this->db->table_name = $this->db->db_tablepre . $MODEL[$modelid]['tablename'];
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = $WAP_SETTING['listnum'] ? intval($WAP_SETTING['listnum']) : 20;
		$offset = ($page - 1) * $pagesize;

		#-----------------sql-----------------
		$arrChildId = explode(',', $arrchildid);
		if (count($arrChildId) > 1) {
			$where = '`status`=99 AND ' . to_sqls($arrChildId, '', '`catid`');
		} else {
			$where = '`status`=99 AND `catid`=' . $catid;
		}

		$field = '`id`,`catid`,`title`,`thumb`,`keywords`,`description`,`inputtime`,`url`';
		$list = $this->db->select($where, $field, $offset . ',' . $pagesize, 'inputtime DESC');

		foreach ($list as $key => $r) {
			$list[$key]['url'] = url_replace($r['url'], WAP_PATH); //替换wap域名
			$list[$key]['thumb'] = get_thumb($r['thumb'], 350); //获取350x350尺寸缩略图
		}

		#---------------- 返回数据 ------------------
		if (!empty($list)) {
			$data['code'] = 1;
			$data['message'] = '请求成功！';
		} else {
			$data['code'] = 0;
			$data['message'] = '暂无更多信息！';
		}
		$data['lists'] = $list;
		exit(json_encode($data));
	}

	
	

}