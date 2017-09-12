<?php
/**
 * 后台足球数据管理
 */

defined('IN_PHPCMS') or exit('No permission resources.');
// 模块缓存路径
define('CACHE_SPORTSDATA_PATH',CACHE_PATH.'caches_sportsdata'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
// 加载模块全局函数
pc_base::load_app_func('global');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form','',0);
pc_base::load_app_func('util');
pc_base::load_sys_class('format','',0);

class football_admin extends admin
{
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

    //指数状态
    private $odds_status_arr = [
        1 => '即时指数',
        2 => '已开赛',
        3 => '历史',
        4 => '早盘'
    ];

    private $db;

    function __construct()
    {
        parent::__construct();
		 $this->db		     = pc_base::load_model('content_model');
		 $this->game_db     = pc_base::load_model('game_model');
		 $this->content_game_db = pc_base::load_model('content_game_model');
    }

    /**
     * 足球比赛管理
     */
    public function manage()
    {

    }

    /**
     * 编辑足球比赛数据
     */
    public function edit()
    {

    }
    //关联赛事数据列表 赛程列表（显示近4天赛程）
   // http://www.399cm.com/index.php?m=admin&c=index
    function connect_games () {
		// 赛程列表（显示近4天赛程）
		$title             = $_GET['title'];
		$id                = $_GET['id'];
		$where             = '';
		
		if(!isset($_POST['dosubmit'])){ // 默认4天赛程数据
			$starttime         = SYS_TIME - 24 * 60 * 60; //开始时间
            $endtime           = SYS_TIME + 2 * 24 * 60 * 60;  //结束时间
            $where             = ' 1=1 AND g.date >'.$starttime.' AND g.date < '.$endtime;
		}  else {
            $arr = $_POST;
            unset($arr['dosubmit']);
            unset($arr['search']);
			$where             = $this->merge_where($arr);
			if(!$where){
				$starttime         = SYS_TIME - 24 * 60 * 60; //开始时间
                $endtime           = SYS_TIME + 2 * 24 * 60 * 60;  //结束时间
                $where             = ' 1=1 AND g.date >'.$starttime.' AND g.date < '.$endtime;
			}
		}
		
		 $live_game_sql = 'SELECT
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
                                g.homescore,
                                g.awayscore,
								g.date
                            FROM ft_game g
                           
                            WHERE '.$where.'
                            ORDER BY g.date ASC ';
            $this->game_db->query($live_game_sql);
            $live_game_data = $this->game_db->fetch_array();
			//关联赛事查询
            $arr         = explode('-', explode('_', $_GET['id'])[1]);
			$catid       = $arr[0];
			$contentid   = $arr[1];
			$siteid      = $arr[2];
            $filed       = 'contentid,gameid,leaguename,homename_s,awayname_s,date';
            $content_data = $this->content_game_db->select('contentid='.$contentid,$filed,'','date','','');
            foreach ($content_data as $key => $val) {
                $content_data_gameid =  $val['gameid'];
            }
            include $this->admin_tpl('connect_games');
	}

	public function merge_where($array) {

			$array  = array_filter($array);
			$where  = '';
			if (empty($array)) return 0;

			foreach ($array as $key => $value) {
				if ('start_time' == $key) {
					$where .= ' g.date > "' . strtotime($value) . '" and ';
				} elseif ('end_time' == $key) {
					$where .= ' g.date < "' . strtotime($value. "+1 day") . '" and ';
				} else {
					$where .= $key . ' like  "%' . $value . '%"  and ';
				}
			}
			$where = substr($where, 0, strlen($where) - 4);
			return $where;
		}


		// 插入关联赛事
		public function insert_conect_info() {
			
			$arr         = explode('-', explode('_', $_GET['id'])[1]);
			$catid       = $arr[0];
			$id          = $arr[1];
			$siteid      = $arr[2];
			$gameids     =  explode('|', $_GET['gamesid']);
			$categorys   = getcache('category_content_'.$siteid,'commons');
			$models      = getcache('model','commons');

			$modelid     = $categorys[$catid]['modelid'];
			
			// 先查询被关联的比赛是否已经有和该文章关联过了
			$gameidwhere = to_sqls($gameids,'','gameid');
			
			$exist_gameids = $this->content_game_db->select($gameidwhere.' and contentid='.$id.' and modelid='.$modelid,'gameid');
			$exist_gameids = $this->explodArr($exist_gameids);	
			$new_gameids = array_diff($gameids,$exist_gameids);
			if(empty($new_gameids)){
				// 说明目前提交的关联都已经保存过了，无需再关联
				echo json_encode(['result'=>0,'message'=>'无需重复关联！']);exit;
			}

			$gameidwhere = to_sqls($new_gameids,'','gameid');		
			$this->db -> set_model($modelid);// 
			$filed       = 'title,thumb,keywords,description,url,inputtime';
			// 被关联文章信息
			$content_data = $this->db->get_one('id='.$id.' and catid ='.$catid ,$filed);
			$content_data['contentid'] = $id;
			$content_data['modelid']   = $modelid;
			$content_data['type']      = 1;
			
			// 被关联的联赛信息
			$competition_sql = 'select '
				               . ' gameid,'
				               . 'competitionid as leagueid,'
				               . 'competitionshortname as leaguename,'
				               . 'hometeamid,hometeamid,'
				               . 'homeshortname as homename_s,'
				               . 'awayshortname as awayname_s,'
				               . 'date'
				               . '  from ft_game '
				               . 'where '.$gameidwhere ;
			$this->game_db->query($competition_sql);
		    $competition_data = $this->game_db->fetch_array(MYSQLI_ASSOC);
			$insertids = array();
			foreach ($competition_data as $value) {
				$value=  array_merge($content_data,$value);
				$insertids[]=  $this->content_game_db->insert($value);
			}	
			
			if($insertids){
				echo json_encode(['result'=>1,'message'=>'关联成功！']); exit;
			}  else {
				echo json_encode(['result'=>0,'message'=>'系统繁忙！']); exit;
			}
			
		}
		//删除所有关联赛程
		public function delete_all_conect_info() {
			
			$arr         = explode('-', explode('_', $_GET['id'])[1]);
			$catid       = $arr[0];
			$id          = $arr[1];
			$siteid      = $arr[2];
			$categorys   = getcache('category_content_'.$siteid,'commons');
			$modelid     = $categorys[$catid]['modelid'];
			$result =  $this->content_game_db->delete('contentid='.$id.' and modelid='.$modelid);
			if($result){
				echo json_encode(['result'=>1,'message'=>'删除成功！']); exit;
			}  else {
				echo json_encode(['result'=>0,'message'=>'系统繁忙，稍后再试！']); exit;
			}
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
	}
