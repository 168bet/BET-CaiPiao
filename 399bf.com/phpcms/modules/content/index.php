<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_app_func('global','sportsdata');
pc_base::load_app_func('global','content');

class index
{
	private $db;

	function __construct()
    {
		$this->db = pc_base::load_model('content_model');
		$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');
		$this->qxc_db = pc_base::load_model('qxc_model');
		$this->xglhc_db = pc_base::load_model('xglhc_model');
		$this->gdklsf_db = pc_base::load_model('gdklsf_model');
		$this->bjpks_db = pc_base::load_model('bjpks_model');
		$this->cqssc_db = pc_base::load_model('cqssc_model');
		$this->class_db = pc_base::load_model('class_model');
	}

	//首页
	public function init()
    {
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$SEO['title'] = '竞彩比分直播_足彩竞猜网首页';
		$SEO['description'] = '399彩迷网为彩民提供最新的足球比分直播、竞彩比分直播、篮球比分直播、足球赛事比分数据，最准的足彩竞猜、竞彩竞猜推荐，399彩迷网致力于为广大彩迷提供最具参考价值的专业分析、精准预测和数据情报！';
		$sitelist  = getcache('sitelist','commons');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');

		$this->game_db = pc_base::load_model("game_model");

		//开始时间
		$start_time = SYS_TIME - 2 * 60 * 60;
		//结束时间
		$end_time = SYS_TIME + 36 * 60 * 60;

		//即时比赛
		$live_game_sql = 'SELECT a.gameid,
								 a.competitionid,
								 a.competitionshortname,
						  		 a.hometeamid,
						  		 a.homeshortname,
						  		 a.awayteamid,
						  		 a.awayshortname,
						  		 a.date,
						  		 b.homescore,
						  		 b.awayscore,
						  		 b.status,
						  		 c.goal
						  FROM `ft_live_game` a LEFT JOIN `ft_live_game_data` b ON a.gameid=b.gameid LEFT JOIN `ft_live_game_goal_stats` c ON a.gameid=c.gameid
						  WHERE b.status IN (1,2,3) AND a.date>' . $start_time . ' AND a.date<' . $end_time . '
						  ORDER BY a.date DESC
						  LIMIT 3;';
		$this->game_db->query($live_game_sql);
		$live_game_data = $this->game_db->fetch_array(MYSQLI_ASSOC);

		//如果即时比赛少于三条，补充未开始比赛至三条
		if (count($live_game_data) < 3) {
			$pad_num = intval(3 - count($live_game_data));
			$live_game_ids = array_column($live_game_data, 'gameid');
			$pad_where = 'a.date>' . time() . ' AND a.date<' . $end_time;
			$pad_where .= count($live_game_ids) ? ' AND a.gameid NOT IN (' . join(',', $live_game_ids) . ')' : '';
			$pad_sql = 'SELECT a.gameid,
							   a.competitionid,
							   a.competitionshortname,
						  	   a.hometeamid,
						  	   a.homeshortname,
						  	   a.awayteamid,
						  	   a.awayshortname,
						  	   a.date,
						  	   b.homescore,
						  	   b.awayscore,
						  	   b.status,
						  	   c.goal
						FROM `ft_live_game` a LEFT JOIN `ft_live_game_data` b ON a.gameid=b.gameid LEFT JOIN `ft_live_game_goal_stats` c ON a.gameid=c.gameid
						WHERE ' . $pad_where . '
						ORDER BY a.date ASC
						LIMIT ' . $pad_num . ';';
			$this->game_db->query($pad_sql);
			$pad_data = $this->game_db->fetch_array(MYSQLI_ASSOC);
			$live_game_data = array_merge($live_game_data, $pad_data);
		}

		if (count($live_game_data)) {
			foreach ($live_game_data as $key => $value) {
				$goal = end(json_decode($value['goal'], true));
				$live_game_data[$key]['minute'] = $goal['Minute'];
			}
		}
//
//		//焦点赛事 足球
//		$now = SYS_TIME;
//		$ready_status = '0,17';
//		$competition_ids = '92,85,34,39,93,152,139,149';
//		$live_sql = "SELECT l.gameid,
//							l.competitionid,
//							l.competitionshortname,
//							l.hometeamid,
//							l.homeshortname,
//							l.awayteamid,
//							l.awayshortname,
//							l.date,
//							s.round,
//							s.group,
//							s.period,
//							w.islive
//					 FROM ft_game l
//					 LEFT JOIN ft_competition_schedule s ON l.gameid=s.gameid
//					 LEFT JOIN ft_wlive_list w ON l.gameid=w.gameid
//					 WHERE 1=1 AND l.date > $now AND l.status IN (" . $ready_status . ") AND l.competitionid IN (" . $competition_ids . ")
//					 ORDER BY l.date ASC
//					 LIMIT 15";
//
//		$this->game_db->query($live_sql);
//		$temp = $this->game_db->fetch_array();
//		foreach ($temp as $row) {
//			$live_info[$row['gameid']] = $row;
//		}
//
//		$this->schedule_db = pc_base::load_model('schedule_model');
//
//		//焦点赛事 篮球
//		$sql = "SELECT scheduleid,
//							sclassid,
//							sclassname_cn,
//							sclasscolor,
//							hometeamid,
//							homename_cn,
//							guestteamid,
//							guestname_cn,
//							date
//					 FROM bt_schedule
//					 WHERE 1=1 AND date > $now AND status = 0  AND sclassid IN (1, 5, 7)
//					 ORDER BY date ASC
//					 LIMIT 15";
//
//		$this->schedule_db->query($sql);
//		$bt_live_info = $this->schedule_db->fetch_array(MYSQLI_ASSOC);

		$event_info = array();
		//足球资料库
		$ft_competition_ids = array(92,85,34,39,93,152,139);
		$competition_db = pc_base::load_model('competition_model');
		$competition_info = $competition_db->select('`competitionid` IN (' . join(',', $ft_competition_ids) . ')', '`competitionid`, `shortname` AS `name`');
		if (count($competition_info)) {
			foreach ($competition_info as $value) {
				$value['url'] = APP_PATH . 'competition/' . $value['competitionid'] . '/schedule/';
				$value['img'] = PHOTO_PATH . 'competition/' . $value['competitionid'] . '.jpg';
				$value['class'] = 'competition-photo';
				$event_info[] = $value;
			}
		}

		//篮球资料库
		$bt_sclass_ids = array(1,5);
		$sclass_db = pc_base::load_model('sclass_model');
		$sclass_info = $sclass_db->select('`sclassid` IN (' . join(',', $bt_sclass_ids) . ')', '`sclassid`, `name_s` AS `name`');
		if (count($sclass_info)) {
			foreach ($sclass_info as $value) {
				$value['url'] = APP_PATH . 'sclass/' . $value['sclassid'] . '/schedule/';
				$value['img'] = BT_SCLASS_PATH . $value['sclassid'] . '.jpg';
				$value['class'] = 'bt-competition-photo';
				$event_info[] = $value;
			}
		}

		//最新指数
		$company_ids = array(3000271,3000181,400000);
		$where = "a.date > '$start_time' AND a.date < '$end_time'";
		$live_game_odds_sql = 'SELECT a.gameid,
									  IF(a.competitionshortname<>"",a.competitionshortname,a.competitionname) AS `competitionname`,
									  IF(a.homeshortname<>"",a.homeshortname,a.homename) AS `homename`,
									  IF(a.awayshortname<>"",a.awayshortname,a.awayname) AS `awayname`,
									  a.date,
									  IFNULL(b.homescore, 0) AS homescore,
									  IFNULL(b.awayscore, 0) AS awayscore
							   FROM ft_live_game a
							   INNER JOIN ft_live_game_data b ON a.gameid=b.gameid
							   INNER JOIN ft_odds_asia c ON a.gameid=c.gameid
							   INNER JOIN ft_odds_euro d ON a.gameid=d.gameid
							   INNER JOIN ft_odds_ou e ON a.gameid=e.gameid
							   WHERE ' . $where . '
							   ORDER BY a.date DESC
							   LIMIT 1';
		$this->game_db->query($live_game_odds_sql);
		$live_game_odds_data = $this->game_db->fetch_array(MYSQLI_ASSOC)[0];

		if ($live_game_odds_data) {
			//亚盘
			$asia_where = '`gameid`=' . $live_game_odds_data['gameid'] . ' AND `companyid` IN (' . join(',', $company_ids) . ')';
			$odds_asia_db = pc_base::load_model('odds_asia_model');
			$odds_asia_info = $odds_asia_db->select($asia_where, '`companyid`,`companyname`,`gameid`,`up`,`down`,`give`', '', 'oddsdate DESC');
			if (count($odds_asia_info)) {
				foreach ($odds_asia_info as $odds) {
					$live_game_odds_data['odds']['asia'][$odds['companyid']]['up'] = $odds['up'];
					$live_game_odds_data['odds']['asia'][$odds['companyid']]['down'] = $odds['down'];
					$live_game_odds_data['odds']['asia'][$odds['companyid']]['give'] = get_handicap($odds['give']);
				}
			}

			//欧赔
			$aisa2euro = asia2euro();           //亚指公司映射到欧指公司
			$euro2asia = array_flip($aisa2euro); //欧指公司映射到亚指公司
			$cid2cname = cid2cname();           //亚指公司编号映射到公司名
			//获取对应的欧指公司的$euro_company_condition
			$euro_option_cid = array();
			foreach ($company_ids as $cid) {
				$euro_option_cid[] = $aisa2euro[$cid];
			}
			$euro_where = '`gameid`=' . $live_game_odds_data['gameid'] . ' AND `companyid` IN (' . join(',', $euro_option_cid) . ')';
			$odds_euro_db = pc_base::load_model('odds_euro_model');
			$odds_euro_info = $odds_euro_db->select($euro_where, '`companyid`,`companyname`,`homewin`,`awaywin`,`draw`');
			if (count($odds_euro_info)) {
				foreach ($odds_euro_info as $odds) {
					$cid = $euro2asia[$odds['companyid']];
					$live_game_odds_data['odds']['euro'][$cid]['homewin'] = $odds['homewin'];
					$live_game_odds_data['odds']['euro'][$cid]['draw'] = $odds['draw'];
					$live_game_odds_data['odds']['euro'][$cid]['awaywin'] = $odds['awaywin'];
				}
			}

			//大小球
			$ou_where = '`gameid`=' . $live_game_odds_data['gameid'] . ' AND `companyid` IN (' . join(',', $company_ids) . ')';
			$odds_ou_db = pc_base::load_model('odds_ou_model');
			$odds_ou_info = $odds_ou_db->select($ou_where, '`companyid`,`companyname`,`gameid`,`big`,`total`,`small`', '', 'oddsdate DESC');
			if (count($odds_ou_info)) {
				foreach ($odds_ou_info as $odds) {
					$live_game_odds_data['odds']['ou'][$odds['companyid']]['big'] = rtrim0($odds['big']);
					$live_game_odds_data['odds']['ou'][$odds['companyid']]['total'] = handicap_ou($odds['total']);
					$live_game_odds_data['odds']['ou'][$odds['companyid']]['small'] = rtrim0($odds['small']);
				}
			}
		}

		//股票大盘数据
		$dapan_data = get_dapan_data();

		//热门赛事竞猜
//		$ready_or_start_status = '0,1,2,3,5,6,7,8,9,11,12,17';
//		$hot_guess_field = '`gameid`,`competitionid`,`competitionshortname`,`hometeamid`,`homeshortname`,`awayteamid`,`awayshortname`,`date`';
//		$hot_guess = $this->game_db->get_one('`status` IN (' . $ready_or_start_status . ') AND `competitionid` IN (' . $competition_ids . ')', $hot_guess_field, '`date` DESC');

		//彩票信息
		$lottery_info = array(
			'qxc' => '七星彩',
			'xglhc' => '香港开奖',
			'gdklsf' => '广东快乐十分',
			'bjpks' => '北京赛车PK10',
			'cqssc' => '重庆时时彩'
		);

		$class_tmp = $this->class_db->select();
//		$type_arr = array(
//			1 => '福彩',
//			2 => '体彩',
//			3 => '赛马会'
//		);
		foreach ($class_tmp as $value) {
			if ($value['pinyin'] === 'xglhc') continue; //暂时注释香港开奖
			$db = $value['pinyin'] . '_db';
			$lottery[$value['pinyin']] = $this->{$db}->get_one('', '`id`,`numbers`,`uptime`', '`uptime` DESC');
		}

		include template('content','index',$default_style);
	}

	//内容页
	public function show()
    {
		$catid = intval($_GET['catid']);
		$id = intval($_GET['id']);

		if(!$catid || !$id) showmessage(L('information_does_not_exist'),'blank');
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;

		$page = intval($_GET['page']);
		$page = max($page,1);
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		
		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) showmessage(L('information_does_not_exist'),'blank');
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

		//相关栏目
		$relation_arr = [
			1 => 2, //足彩分析=>足彩预测
			18 => 2, //竞彩足球分析=>足彩预测
			19 => 2, //亚盘分析法=>足彩预测
			20 => 2, //欧赔分析技巧=>足彩预测
			21 => 2, //欧赔和亚盘=>足彩预测
			22 => 2, //竞彩足球怎么玩=>足彩预测
			2 => 3, //足彩预测=>足彩推荐
			24 => 3, //竞彩足球预测=>足彩推荐
			25 => 3, //胜负彩14场专家预测=>足彩推荐
			3 => 6, //足彩推荐=>竞彩体育资讯
			27 => 6, //今日强胆推荐=>竞彩体育资讯
			28 => 30, //五大联赛=>世界足坛
			29 => 30, //中国足坛=>世界足坛
			30 => 29  //世界足坛=>中国足坛
		];
		$relation_catid = isset($relation_arr[$catid]) ? $relation_arr[$catid] : $catid;

		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		#-------------- 新增 获取‘猜你喜欢’栏目内容 -----------------
		if(!empty($keywords)){
		   $contentArr = get_keywords_relation_content($keywords,$siteid,$catid,6);
		}
		
		//分割多张图片的描述
		if ($modelid == 3 && isset($pictureurls)) {
			if ($content) {
				$arr_text = explode('[image]', $content);
				//每张图片不同描述
				if (count($arr_text) > 1) {
					foreach ($pictureurls as $key => $pictureurl) {
						$pictureurls[$key]['description'] = trim($arr_text[$key]);
					}
				//多张图片统一描述
				} else {
					foreach ($pictureurls as $key => $pictureurl) {
						$pictureurls[$key]['description'] = trim($content);
					}
				}
				unset($arr_text);
			}
		}

		//检查文章会员组权限
		if($groupids_view && is_array($groupids_view)) {
			$_groupid = param::get_cookie('_groupid');
			$_groupid = intval($_groupid);
			if(!$_groupid) {
				$forward = urlencode(get_url());
				showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
			}
			if(!in_array($_groupid,$groupids_view)) showmessage(L('no_priv'));
		} else {
			//根据栏目访问权限判断权限
			$_priv_data = $this->_category_priv($catid);
			if($_priv_data=='-1') {
				$forward = urlencode(get_url());
				showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
			} elseif($_priv_data=='-2') {
				showmessage(L('no_priv'));
			}
		}
		if(module_exists('comment')) {
			$allow_comment = isset($allow_comment) ? $allow_comment : 1;
		} else {
			$allow_comment = 0;
		}
		//阅读收费 类型
		$paytype = $rs['paytype'];
		$readpoint = $rs['readpoint'];
		$allow_visitor = 1;
		if($readpoint || $this->category_setting['defaultchargepoint']) {
			if(!$readpoint) {
				$readpoint = $this->category_setting['defaultchargepoint'];
				$paytype = $this->category_setting['paytype'];
			}
			
			//检查是否支付过
			$allow_visitor = self::_check_payment($catid.'_'.$id,$paytype);
			if(!$allow_visitor) {
				$http_referer = urlencode(get_url());
				$allow_visitor = sys_auth($catid.'_'.$id.'|'.$readpoint.'|'.$paytype).'&http_referer='.$http_referer;
			} else {
				$allow_visitor = 1;
			}
		}
		//最顶级栏目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
		
		$template = $template ? $template : $CAT['setting']['show_template'];
		if(!$template) $template = 'show';
		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		//seo关键词重新处理
		$SEO['keyword'] = $data['seo_keywords'];

		define('STYLE',$CAT['setting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';
		if($rs['paginationtype']==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0)
        {
			//手动分页
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = pc_base::load_app_class('url', 'content');
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->show($id, $i, $catid, $rs['inputtime']);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
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
				if($titles) {
					list($title, $content) = explode('[/page]', $content);
					$content = trim($content);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
				}
			}
		}
		$this->db->table_name = $tablename;
		//上一页
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		//下一页
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99",'*','id ASC');

		if(empty($previous_page)) {
			$previous_page = array('title'=>L('first_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page').'\');');
		}

		if(empty($next_page)) {
			$next_page = array('title'=>L('last_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page').'\');');
		}
		
		include template('content',$template);
	}

	//列表页
	public function lists()
    {
		//检索包含关键词的列表
		$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
		$catid = $_GET['catid'] = intval($_GET['catid']);
		$_priv_data = $this->_category_priv($catid);
		if($_priv_data=='-1') {
			$forward = urlencode(get_url());
			showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
		} elseif($_priv_data=='-2') {
			showmessage(L('no_priv'));
		}
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;

		if(!$catid) showmessage(L('category_not_exists'),'blank');
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		if(!isset($CATEGORYS[$catid])) showmessage(L('category_not_exists'),'blank');
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$setting = string2array($setting);
		//SEO
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		//重新设置分页title
		$GLOBALS['seo_title'] = $SEO['title'];
		$SEO['title'] = page_title($_REQUEST['page']);
		define('STYLE',$setting['template_list']);
		$page = intval($_GET['page']);

		$template = $setting['category_template'] ? $setting['category_template'] : 'category';
		$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';

		//相关栏目
		$relation_arr = [
			1 => 3, //足彩分析=>足彩推荐
			18 => 3, //竞彩足球分析=>足彩推荐
			19 => 3, //亚盘分析法=>足彩推荐
			20 => 3, //欧赔分析技巧=>足彩推荐
			21 => 3, //欧赔和亚盘=>足彩推荐
			22 => 3, //竞彩足球怎么玩=>足彩推荐
			2 => 1, //足彩预测=>足彩分析
			24 => 1, //竞彩足球预测=>足彩分析
			25 => 1, //胜负彩14场专家预测=>足彩分析
			3 => 2, //足彩推荐=>足彩预测
			27 => 2, //今日强胆推荐=>足彩预测
			6 => 2, //竞彩体育资讯=>足彩预测
			28 => 2, //五大联赛=>足彩预测
			29 => 2, //中国足坛=>足彩预测
			30 => 2  //世界足坛=>足彩预测
		];
		$relation_catid = isset($relation_arr[$catid]) ? $relation_arr[$catid] : $catid;

		if($type==0)
        {
			//$template = $child ? $template : $template_list;
			$template = $template_list;
			$arrparentid = explode(',', $arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
			$array_child = array();
			$self_array = explode(',', $arrchildid);
			//获取一级栏目ids
			foreach ($self_array as $arr) {
				if($arr!=$catid && $CATEGORYS[$arr][parentid]==$catid) {
					$array_child[] = $arr;
				}
			}
			$arrchildid = implode(',', $array_child);
			//URL规则
			$urlrules = getcache('urlrules','commons');
			$urlrules = str_replace('|', '~',$urlrules[$category_ruleid]);
			$tmp_urls = explode('~',$urlrules);
			$tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
			preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
			if(!empty($_urls[1])) {
				foreach($_urls[1] as $_v) {
					$GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
				}
			}
			//url规则
			$urlrules = $keywords ? '/{$catdir}/{$keywords}/{$page}/' : '/{$catdir}/{$page}/';
			define('URLRULE', $urlrules);
			$GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
			$GLOBALS['URL_ARRAY']['catdir'] = $catdir;
			$GLOBALS['URL_ARRAY']['catid'] = $catid;
			$GLOBALS['URL_ARRAY']['keywords'] = $keywords;
			include template('content',$template);
		}
        else
        {
		    //单网页
			$this->page_db = pc_base::load_model('page_model');
			$r = $this->page_db->get_one(array('catid'=>$catid));
			if($r) extract($r);
			$template = $setting['page_template'] ? $setting['page_template'] : 'page';
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $setting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$setting['meta_description'],$keywords);
			include template('content',$template);
		}
	}

	//列表页 包含所有资讯
	public function lists_model()
	{
		//检索包含关键词的列表
		$keywords 	= isset($_GET['keywords']) ? $_GET['keywords'] : '';
		$page 		= intval($_GET['page']);
		$modelid 	= 1;

		//url规则
		$urlrule = $keywords ? APP_PATH . 'news/{$keywords}/~' . APP_PATH . 'news/{$keywords}/{$page}/' : APP_PATH . 'news/~' . APP_PATH . 'news/{$page}/';

		include template('content', 'list_model');
	}
	
	//JSON 输出
	public function json_list()
    {
		if($_GET['type']=='keyword' && $_GET['modelid'] && $_GET['keywords'])
        {
		    //根据关键字搜索
			$modelid = intval($_GET['modelid']);
			$id = intval($_GET['id']);

			$MODEL = getcache('model','commons');
			if(isset($MODEL[$modelid])) {
				$keywords = safe_replace(new_html_special_chars($_GET['keywords']));
				$keywords = addslashes(iconv('utf-8','gbk',$keywords));
				$this->db->set_model($modelid);
				$result = $this->db->select("keywords LIKE '%$keywords%'",'id,title,url',10);
				if(!empty($result)) {
					$data = array();
					foreach($result as $rs) {
						if($rs['id']==$id) continue;
						if(CHARSET=='gbk') {
							foreach($rs as $key=>$r) {
								$rs[$key] = iconv('gbk','utf-8',$r);
							}
						}
						$data[] = $rs;
					}
					if(count($data)==0) exit('0');
					echo json_encode($data);
				} else {
					//没有数据
					exit('0');
				}
			}
		}

	}
	
	/**
	 * 检查支付状态
	 */
	protected function _check_payment($flag,$paytype)
    {
		$_userid = $this->_userid;
		$_username = $this->_username;
		if(!$_userid) return false;
		pc_base::load_app_class('spend','pay',0);
		$setting = $this->category_setting;
		$repeatchargedays = intval($setting['repeatchargedays']);
		if($repeatchargedays) {
			$fromtime = SYS_TIME - 86400 * $repeatchargedays;
			$r = spend::spend_time($_userid,$fromtime,$flag);
			if($r['id']) return true;
		}
		return false;
	}
	
	/**
	 * 检查阅读权限
	 */
	protected function _category_priv($catid)
    {
		$catid = intval($catid);
		if(!$catid) return '-2';
		$_groupid = $this->_groupid;
		$_groupid = intval($_groupid);
		if($_groupid==0) $_groupid = 8;
		$this->category_priv_db = pc_base::load_model('category_priv_model');
		$result = $this->category_priv_db->select(array('catid'=>$catid,'is_admin'=>0,'action'=>'visit'));
		if($result) {
			if(!$_groupid) return '-1';
			foreach($result as $r) {
				if($r['roleid'] == $_groupid) return '1';
			}
			return '-2';
		} else {
			return '1';
		}
	 }

	//意甲频道	add by lxt 2016.07.21
	public function seriea ()
	{
		//意甲频道
		$catid = 16;

		$this->category_data($catid);
	}

	//英超频道	add by lxt 2016.05.11
	public function premierleague ()
	{
		//英超频道
		$catid = 14;

		$this->category_data($catid);
	}

	//西甲频道
	public function laliga()
	{
		//西甲频道
		$catid = 15;

		$this->category_data($catid);
	}

	/**
	 * 中超频道
	 */
	public function csl()
	{
		// 中超频道
		$catid = 9;

		$this->category_data($catid);
	}

	//德甲频道	add by lxt 2016.07.21
	public function bundesliga()
	{
		//德甲频道
		$catid = 17;

		$this->category_data($catid);
	}

	//法甲频道	add by lxt 2016.07.21
	public function ligue1()
	{
		//德甲频道
		$catid = 18;

		$this->category_data($catid);
	}

	/*
	 * 欧冠频道	add by lxt 2016.09.19
	 */
	public function ucl()
	{
		//欧冠栏目
		$catid = 13;

		$this->category_data($catid);
	}

    //欧洲杯频道
	public function euro()
	{
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$sitelist  = getcache('sitelist','commons');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');

		//欧洲杯分组	add by lxt 2016.05.24
		$groups = array(
			'A组' => array(
				'法国',
				'罗马尼亚',
				'阿尔巴尼亚',
				'瑞士'
			),
			'B组' => array(
				'英格兰',
				'俄罗斯',
				'威尔士',
				'斯洛伐克'
			),
			'C组' => array(
				'德国',
				'乌克兰',
				'波兰',
				'北爱尔兰'
			),
			'D组' => array(
				'西班牙',
				'捷克',
				'土耳其',
				'克罗地亚'
			),
			'E组' => array(
				'比利时',
				'意大利',
				'爱尔兰',
				'瑞典'
			),
			'F组' => array(
				'葡萄牙',
				'冰岛',
				'奥地利',
				'匈牙利'
			)
		);

		include template('content','hy_category_euro',$default_style);
	}

	private function category_data($catid)
	{
		//联赛编号
		$competitionid = '';
		//默认球队
		$team_ids = array();
		//焦点图
		$focus_id = '';

		switch ($catid) {
			//中超
			case 9:
				$competitionid =  152;
				$focus_id = 42;
				$team_ids = array(
					146,	//山东鲁能
					1011,	//广州恒大
					490,	//北京国安
					1007,	//杭州绿城
				);
				break;
			//欧冠
			case 13:
				$competitionid = 74;
				$focus_id = 54;
				$team_ids = array(
					239,	//曼联
					345,	//皇家马德里
					514,	//巴塞罗那
					500		//拜仁慕尼黑
				);
				break;
			//英超
			case 14:
				$competitionid = 92;
				$focus_id = 31;
				$team_ids = array(
					567,	//阿森纳
					444,	//切尔西
					239,	//曼联
					240,	//曼城
				);
				break;
			//西甲
			case 15:
				$competitionid = 85;
				$focus_id = 36;
				$team_ids = array(
					49,		//塞维利亚
					345,	//皇家马德里
					350,	//巴伦西亚
					514,	//巴塞罗那
				);
				break;
			//意甲
			case 16:
				$competitionid = 34;
				$focus_id = 50;
				$team_ids = array(
					2,		//尤文图斯
					370,	//国际米兰
					600,	//AC米兰
					264,	//罗马
				);
				break;
			//德甲
			case 17:
				$competitionid = 39;
				$focus_id = 51;
				$team_ids = array(
					500,	//拜仁慕尼黑
					319,	//科隆
					409,	//法兰克福
					363,	//汉堡
				);
				break;
			//法甲
			case 18:
				$competitionid = 93;
				$focus_id = 52;
				$team_ids = array(
					517,	//巴黎圣日尔曼
					292,	//里昂
					219,	//摩纳哥
					210,	//尼斯
				);
				break;
			default:
				break;
		}

		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$sitelist  = getcache('sitelist','commons');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');

		// 热门直播
		$hot_sql = get_hot_sql($competitionid);

		//射手榜
		$model = pc_base::load_model("game_model");
		$model->table_name = "ft_shooter_stats";
		$shooter_stats = $model->select("`competitionid`=" . $competitionid, "`rank`,`playerid`,`playername`,`teamname`,`goal`", 7, "`rank`");

		//聚焦球队基本信息，球员信息
		$model->table_name = 'ft_team';
		$team_list = $model->select('`teamid` IN (' . join(',', $team_ids) . ')', '`teamid`,`name`,`shortname`,`players`', '', '', '', 'teamid');

		foreach ($team_list as $id => $row) {
			//球队关键字采用球队全名加球队简称
			$team_list[$id]['keywords'] = trim($row['name'] . ' ' . $row['shortname']);
			//页面只要5个球员数据
			$player = array_slice(json_decode($row['players'], true), 0, 5);
			$team_list[$id]['player'] = $player;
		}

		//积分榜
		$model->table_name = "ft_standings_stats";
		$standings_stats = $model->select("`type`='total' AND `competitionid`=" . $competitionid, "`teamid`,`teamname`,`win`,`draw`,`lose`,`score`", 7, "`score` DESC");

		//球队积分排名
		$team_standings = $model->select("`type`='total' AND `competitionid`=" . $competitionid, "`teamid`,`teamname`,`teamshortname`,`win`,`draw`,`lose`,`score`", "", "`score` DESC");
		foreach ($team_standings as $key => $value) {
			if (in_array($value['teamid'], $team_ids)) {
				$value['rank'] = $key + 1;
				$team_list[$value['teamid']]['standing'] = $value;
			} else{
				continue;
			}
		}

		//球队进球统计
		$model->table_name = "ft_team_stats";
		$team_stats = $model->select("`teamid` IN (" . join(',', $team_ids) . ")", "`teamid`,`fixtures`,`stats`");
		foreach ($team_stats as $row) {
			$stats = json_decode($row['stats'], true);
			//进球数统计
			$goal = array();
			foreach ($stats['Goal'] as $type => $data) {
				$sum = array_sum($data);
				foreach ($data as $value) {
					$rate = round(($value / $sum) * 100, 2) . "%";
					$goal[strtolower($type)]['number'][] = $value;
					$goal[strtolower($type)]['rate'][] = $rate;
				}
			}
			$team_list[$row['teamid']]['goal'] = $goal;
			//总盘路统计
			$odds = array();
			$sum = array_sum($stats['Odds']['Total']);
			foreach ($stats['Odds']['Total'] as $value) {
				$rate = round(($value / $sum) * 100, 2) . "%";
				$odds['number'][] = $value;
				$odds['rate'][] = $rate;
			}
			$team_list[$row['teamid']]['odds'] = $odds;
			//未来赛程
			$fixtures = json_decode($row['fixtures'], true);
			foreach ($fixtures as $data) {
				$fixture = array();
				$fixture['date'] = date('m-d H:i', floor($data['Date'] / 1000));
				$team_ids[] = $fixture['home'] = $data['Id'][2];
				$team_ids[] = $fixture['away'] = $data['Id'][3];
				$team_list[$row['teamid']]['fixture'][] = $fixture;
			}
		}

		//未来赛程中使用的球队编号对应的球队简称
		$model->table_name = "ft_team";
		$team = $model->select("`teamid` IN (" . join(',', $team_ids) . ")", "`teamid`,if(`shortname`<>'',`shortname`,`name`) AS `name`", "", "", "", "teamid");

		//联赛当前赛季开始时间
		$competition_where = '`competitionid`=' . $competitionid;
		$model->table_name = 'ft_competition';
		$competition_info = $model->get_one($competition_where, '`startdate`');
		$competition_where .= $competition_info['startdate'] ? ' AND `date`>=' . $competition_info['startdate'] : '';

		$model->table_name = "ft_competition_schedule";
		//联赛赛制 format字段作为联赛赛制字段，current字段作为当前阶段字段
		$schedule_sql = 'SELECT if(`round`<>"","round",if(`group`<>"","group","period")) AS `format`,
								if(`round`<>"",`round`,if(`group`<>"",`group`,`period`)) AS `current`
						 FROM ft_competition_schedule
						 WHERE ' . $competition_where . '
						 GROUP BY `current`;';
		$model->query($schedule_sql);
		$schedule = $model->fetch_array();

		include template('content', 'category_csl', $default_style);
	}

	public function ajax_schedule()
	{
		$competitionid = $_POST['competitionid'];
		$model = pc_base::load_model('game_model');

		if ($competitionid) {

			//联赛当前赛季开始时间
			$competition_where = "`competitionid`=" . $competitionid;
			$model->table_name = 'ft_competition';
			$competition_info = $model->get_one($competition_where, '`startdate`');
			$competition_where .= $competition_info['startdate'] ? " AND `" . $_POST['format'] . "`='" . $_POST['current'] . "'" . ' AND `date`>=' . $competition_info['startdate'] : " AND `" . $_POST['format'] . "`='" . $_POST['current'] . "'";

			//联赛赛程基本信息
			$model->table_name = "ft_competition_schedule";
			$temp['schedule'] = $model->select($competition_where, "`gameid`,`date`", "", "", "", "gameid");
			$game_ids = array_keys($temp['schedule']);

			//联赛每场比赛状态，主客队信息
			$model->table_name = "ft_game";
			$temp['detail'] = $model->select("`gameid` IN (" . join(',', $game_ids) . ")", "`gameid`,`hometeamid`,`homeshortname`,`awayteamid`,`awayshortname`,`status`", "", "", "", "gameid");

			//是否有直播
			$model->table_name = 'ft_wlive_list';
			$temp['live'] = $model->select('`gameid` IN (' . join(',', $game_ids) . ')', '`gameid`,`islive`', '', '', '', 'gameid');

			//联赛赛程
			$status = array(
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
			);

			$schedule = array();
			foreach ($temp['schedule'] as $key => $value) {
				if (!isset($temp['detail'][$key])) {
					continue;
				}
				$row = array_merge($value, $temp['detail'][$key]);
				$row['date'] = date('m-d H:i', $row['date']);
				$row['home_url'] = APP_PATH . 'team/' . $row['hometeamid'] . '/';
				$row['home_photo'] = PHOTO_PATH . 'team/' . $row['hometeamid'] . '.jpg';
				$row['away_url'] = APP_PATH . 'team/' . $row['awayteamid'] . '/';
				$row['away_photo'] = PHOTO_PATH . 'team/' . $row['awayteamid'] . '.jpg';
				$row['home_short_name'] = str_cut($row['homeshortname'], 10, '..');
				$row['away_short_name'] = str_cut($row['awayshortname'], 10, '..');
				$row['game_url'] = APP_PATH . 'game/' . $row['gameid'] . '/data/';
				$row['live_url'] = APP_PATH . 'game/' . $row['gameid'] . '/live/';
				$row['status'] = $status[$row['status']];
				$row['is_live'] = $temp['live'][$key]['islive'];
				$schedule[] = $row;
			}

			$result = array(
				'status' => true,
				'schedule' => $schedule
			);

		} else {
			$result = array(
				'status' => false
			);
		}

		exit(json_encode($result));
	}

	public function todo()
	{
		include template('content', 'todo');
	}

	/*
	 * 页面初始化时重置sessions保存的最新指数排除的比赛编号，防止sessions过期时间过长，导致用户长时间无法刷新最新指数数据
	 */
	public function ajax_reset_sessions_data()
	{
		session_start();
		if (isset($_POST['field'])) {
			if (isset($_SESSION[$_POST['field']])) {
				unset($_SESSION[$_POST['field']]);
			}
			$response = array(
				'state' => true
			);
		} else {
			$response = array(
				'state' => false
			);
		}

		exit(json_encode($response));
	}
	
	
 
}
?>