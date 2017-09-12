<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('util','content');
pc_base::load_app_func('global','sportsdata');
pc_base::load_sys_func('dir');
class html {
	private $siteid,$url,$html_root,$queue,$categorys;
	public function __construct() {
		$this->queue = pc_base::load_model('queue_model');
		define('HTML',true);
		self::set_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->url = pc_base::load_app_class('url', 'content');
		$this->html_root = pc_base::load_config('system','html_root');
		$this->sitelist = getcache('sitelist','commons');
		$this->qxc_db = pc_base::load_model('qxc_model');
		$this->xglhc_db = pc_base::load_model('xglhc_model');
		$this->gdklsf_db = pc_base::load_model('gdklsf_model');
		$this->bjpks_db = pc_base::load_model('bjpks_model');
		$this->cqssc_db = pc_base::load_model('cqssc_model');
		$this->class_db = pc_base::load_model('class_model');
	}

	/**
	 * 生成内容页
	 * @param  $file 文件地址
	 * @param  $data 数据
	 * @param  $array_merge 是否合并
	 * @param  $action 方法
	 * @param  $upgrade 是否是升级数据
	 */
	public function show($file, $data = '', $array_merge = 1,$action = 'add',$upgrade = 0) {
		if($upgrade) $file = '/'.ltrim($file,WEB_PATH);
		$allow_visitor = 1;
		$id = $data['id'];
		if($array_merge) {
			$data = new_stripslashes($data);
			$data = array_merge($data['system'],$data['model']);
		}
		//通过rs获取原始值
		$rs = $data;
		if(isset($data['paginationtype'])) {
			$paginationtype = $data['paginationtype'];
			$maxcharperpage = $data['maxcharperpage'];
		} else {
			$paginationtype = 0;
		}
		$catid = $data['catid'];
		$CATEGORYS = $this->categorys;
		$CAT = $CATEGORYS[$catid];
		$CAT['setting'] = string2array($CAT['setting']);
		define('STYLE',$CAT['setting']['template_list']);

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

		//最顶级栏目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
		
		//$file = '/'.$file;
		//添加到发布点队列
		//当站点为非系统站点
		
		if($this->siteid!=1) {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			$file = $this->html_root.'/'.$site_dir.$file;
		}
		
		$this->queue->add_queue($action,$file,$this->siteid);
		
		$modelid = $CAT['modelid'];
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$output_data = $content_output->get($data);
		extract($output_data);

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

		if(module_exists('comment')) {
			$allow_comment = isset($allow_comment) ? $allow_comment : 1;
		} else {
			$allow_comment = 0;
		}
		$this->db = pc_base::load_model('content_model');
		$this->db->set_model($modelid);
		//上一页
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		//下一页
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99",'*','id ASC');
		
		if(empty($previous_page)) {
			$previous_page = array('title'=>L('first_page','','content'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page','','content').'\');');
		}
		if(empty($next_page)) {
			$next_page = array('title'=>L('last_page','','content'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page','','content').'\');');
		}

		$title = strip_tags($title);
		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$siteid = $this->siteid;
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		//seo关键词重新处理
		$SEO['keyword'] = $data['seo_keywords'];
		
		$ishtml = 1;
		$template = $template ? $template : $CAT['setting']['show_template'];
		
		//分页处理
		$pages = $titles = '';
		if($paginationtype==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
	
		if($paginationtype!=0) {
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
					$upgrade = $upgrade ? '/'.ltrim($file,WEB_PATH) : '';
					$pageurls[$i] = $this->url->show($id, $i, $catid, $data['inputtime'],'','','edit',$upgrade);
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
				//生成分页
				foreach ($pageurls as $page=>$urls) {
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
					$pagefile = $urls[1];
					if($this->siteid!=1) {
						$pagefile = $this->html_root.'/'.$site_dir.$pagefile;
					}
					$this->queue->add_queue($action,$pagefile,$this->siteid);
					$pagefile = PHPCMS_PATH.$pagefile;
					ob_start();
					include template('content', $template);
					$this->createhtml($pagefile);
				}
				return true;
			}
		}
		//分页处理结束
		$file = PHPCMS_PATH.$file;
		ob_start();
		include template('content', $template);
		return $this->createhtml($file);
	}

	/**
	 * 生成栏目列表
	 * @param $catid 栏目id
	 * @param $page 当前页数
	 */
	public function category($catid, $page = 0) {
		$CAT = $this->categorys[$catid];
		@extract($CAT);
		if(!$ishtml) return false;
		if(!$catid) showmessage(L('category_not_exists','content'),'blank');
		$CATEGORYS = $this->categorys;
		if(!isset($CATEGORYS[$catid])) showmessage(L('information_does_not_exist', 'content'),'blank');
		$siteid = $CAT['siteid'];
		$copyjs = '';
		$setting = string2array($setting);
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		define('STYLE',$setting['template_list']);

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

		$page = intval($page);
		$parentdir = $CAT['parentdir'];
		$catdir = $CAT['catdir'];
		//检查是否生成到根目录
		$create_to_html_root = $CAT['sethtml'];
		//$base_file = $parentdir.$catdir.'/';
		//生成地址
		if($CAT['create_to_html_root']) $parentdir = '';
		
		//获取父级的配置，看是否生成静态，如果是动态则直接把父级目录调过来为生成静态目录所用
		$parent_setting = string2array($CATEGORYS[$CAT['parentid']]['setting']);
		if($parent_setting['ishtml']==0 && $setting['ishtml']==1){
			$parentdir = $CATEGORYS[$CAT['parentid']]['catdir'].'/';
		}
		
		$base_file = $this->url->get_list_url($setting['category_ruleid'],$parentdir, $catdir, $catid, $page);
		$base_file = '/'.$base_file;
		
		//非系统站点时，生成到指定目录
		if($this->siteid!=1) {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			if($create_to_html_root) {
				$base_file = '/'.$site_dir.$base_file;
			} else {
				$base_file = '/'.$site_dir.$this->html_root.$base_file;
			}
		} 
		//判断二级域名是否直接绑定到该栏目
		$root_domain = preg_match('/^((http|https):\/\/)([a-z0-9\-\.]+)\/$/',$CAT['url']) ? 1 : 0;
		$count_number = substr_count($CAT['url'], '/');
		$urlrules = getcache('urlrules','commons');
		$urlrules = explode('|',$urlrules[$category_ruleid]);

		if($create_to_html_root) {
			if($this->siteid==1) {
				$file = PHPCMS_PATH.$base_file;
			} else {
				$file = PHPCMS_PATH.substr($this->html_root,1).$base_file;
			}
			//添加到发布点队列
			$this->queue->add_queue('add',$base_file,$this->siteid);
			//评论跨站调用所需的JS文件
			if(substr($base_file, -10)=='index.html' && $count_number==3) {
				$copyjs = 1;
				$this->queue->add_queue('add',$base_file,$this->siteid);
			}
			//URLRULES
			if($CAT['isdomain']) {
				$second_domain = 1;
				foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = $_v;
				}
			} else {
				foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = '/'.$_v;
				}
			}
		} else {
			$file = PHPCMS_PATH.substr($this->html_root,1).$base_file;
			//添加到发布点队列
			$this->queue->add_queue('add',$this->html_root.$base_file,$this->siteid);
			//评论跨站调用所需的JS文件
			if(substr($base_file, -10)=='index.html' && $count_number==3) {
				$copyjs = 1;
				$this->queue->add_queue('add',$this->html_root.$base_file,$this->siteid);
			}		
			//URLRULES
			$htm_prefix = $root_domain ? '' : $this->html_root;
			$htm_prefix = rtrim(WEB_PATH,'/').$htm_prefix;
			if($CAT['isdomain']) {
				$second_domain = 1;
			} else {
				$second_domain = 0;//判断该栏目是否绑定了二级域名或者上级栏目绑定了二级域名，存在的话，重新构造列表页url规则
				foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = $htm_prefix.'/'.$_v;
				}
			}
		}

		if($type==0) {
			$template = $setting['category_template'] ? $setting['category_template'] : 'category';
			$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
			$template = $child ? $template : $template_list;
			$arrparentid = explode(',', $arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
			$array_child = array();
			$self_array = explode(',', $arrchildid);
			foreach ($self_array as $arr) {
				if($arr!=$catid) $array_child[] = $arr;
			}
			$arrchildid = implode(',', $array_child);
			//URL规则
			$urlrules = implode('~', $urlrules);
			
			define('URLRULE', $urlrules);
			//绑定域名时，设置$catdir 为空
			if($root_domain) $parentdir = $catdir = '';
			if($second_domain) {
				$parentdir = '';
				$parentdir = str_replace($catdir.'/', '', $CAT['url']);
			}
			
			$GLOBALS['URL_ARRAY'] = array('categorydir'=>$parentdir, 'catdir'=>$catdir, 'catid'=>$catid);
		} else {
		//单网页
			$datas = $this->page($catid);
			if($datas) extract($datas);
			$template = $setting['page_template'] ? $setting['page_template'] : 'page';
			$parentid = $CATEGORYS[$catid]['parentid'];
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $setting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$setting['meta_description'],$keywords);
		}
		ob_start();
		include template('content',$template);
		return $this->createhtml($file, $copyjs);
	}
	/**
	 * 更新首页
	 */
	public function index() {
		if($this->siteid==1) {
			$file = PHPCMS_PATH.'index.html';
			//添加到发布点队列
			$this->queue->add_queue('edit','/index.html',$this->siteid);
		} else {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			$file = $this->html_root.'/'.$site_dir.'/index.html';
			//添加到发布点队列
			$this->queue->add_queue('edit',$file,$this->siteid);
			$file = PHPCMS_PATH.$file;
		}
		define('SITEID', $this->siteid);
		//SEO
		$SEO = seo($this->siteid);
		$SEO['title'] = '竞彩比分直播_足彩竞猜网首页';
		$SEO['description'] = '399彩迷网为彩民提供最新的足球比分直播、竞彩比分直播、篮球比分直播、足球赛事比分数据，最准的足彩竞猜、竞彩竞猜推荐，399彩迷网致力于为广大彩迷提供最具参考价值的专业分析、精准预测和数据情报！';
		$siteid = $this->siteid;
		$CATEGORYS = $this->categorys;
		$style = $this->sitelist[$siteid]['default_style'];

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

		//焦点赛事
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
//					 WHERE 1=1  AND l.date > $now AND l.status IN (" . $ready_status . ") AND l.competitionid IN (" . $competition_ids . ")
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
//					 WHERE 1=1 AND date > $now AND status = 0 AND sclassid IN (1, 5, 7)
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

		ob_start();
		include template('content','index',$style);
		return $this->createhtml($file, 1);
	}
	/**
	 * 单网页
	 * @param $catid
	 */
	public function page($catid) {
		$this->page_db = pc_base::load_model('page_model');
		$data = $this->page_db->get_one(array('catid'=>$catid));
		return $data;
	}
	/**
	* 写入文件
	* @param $file 文件路径
	* @param $copyjs 是否复制js，跨站调用评论时，需要该js
	*/
	private function createhtml($file, $copyjs = '') {
		$data = ob_get_contents();
		ob_clean();
		$dir = dirname($file);
		if(!is_dir($dir)) {
			mkdir($dir, 0777,1);
		}
		if ($copyjs && !file_exists($dir.'/js.html')) {
			@copy(PC_PATH.'modules/content/templates/js.html', $dir.'/js.html');
		}
		$strlen = file_put_contents($file, $data);
		@chmod($file,0777);
		if(!is_writable($file)) {
			$file = str_replace(PHPCMS_PATH,'',$file);
			showmessage(L('file').'：'.$file.'<br>'.L('not_writable'));
		}
		return $strlen;
	}

	/**
	 * 设置当前站点id
	 */
	private function set_siteid() {
		if(defined('IN_ADMIN')) {
			$this->siteid = $GLOBALS['siteid'] = get_siteid();
		} else {
			if (param::get_cookie('siteid')) {
				$this->siteid = $GLOBALS['siteid'] = param::get_cookie('siteid');
			} else {
				$this->siteid = $GLOBALS['siteid'] = 1;
			}
		}
	}
	/**
	* 生成相关栏目列表、只生成前5页
	* @param $catid
	*/
	public function create_relation_html($catid) {
		for($page = 1; $page < 6; $page++) {
			$this->category($catid,$page);
		}
		//检查当前栏目的父栏目，如果存在则生成
		$arrparentid = $this->categorys[$catid]['arrparentid'];
		if($arrparentid) {
			$arrparentid = explode(',', $arrparentid);
			foreach ($arrparentid as $catid) {
				if($catid) $this->category($catid,1);
			}
		}
	}
}