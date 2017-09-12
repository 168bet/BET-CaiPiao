<?php
/**
 * 会员前台管理中心、账号管理、收藏操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class index extends foreground {

	private $times_db;

    //比赛状态数组
    private $arr_status = array(
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
	
	function __construct() {
		parent::__construct();
		$this->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
	}

	public function init()
    {
		$member_info = $this->memberinfo;
		
		//获取头像数组
        $obj_avatar = pc_base::load_app_class('avatar');
		$avatar = $obj_avatar->getavatar(intval($member_info['userid']));

		$group_list = getcache('grouplist');
		$member_info['groupname'] = $group_list[$member_info[groupid]]['name'];
		//竞猜信息
		$sql = 'SELECT a.*
				FROM `v9_guess` a INNER JOIN `v9_guess_game` b ON a.gameid=b.gameid  AND a.type=b.type
				WHERE a.userid=' . $member_info['userid'] . ' AND b.status=0
				ORDER BY a.addtime DESC
				LIMIT 6;';
		$result = $this->db->query($sql);
		$guess = $result->fetch_all(MYSQLI_ASSOC);
		//比赛信息
		if (count($guess)) {
			//足球和篮球
			$game_ids = $game_info = array();
			foreach ($guess as $value) {
				$game_ids[$value['type']][] = $value['gameid'];
			}
			//足球
			if (count($game_ids[1])) {
				$ft_db = pc_base::load_model('game_model');
				$game_info[1] = $ft_db->select('`gameid` IN (' . join(',', $game_ids[1]) . ')', '`gameid`,`hometeamid`,`homeshortname`,`awayteamid`,`awayshortname`,`date`', '', '', '', 'gameid');
			}
			//篮球
			if (count($game_ids[2])) {
				$bt_db = pc_base::load_model('bt_schedule_model');
				$game_info[2] = $bt_db->select('`scheduleid` IN (' . join(',', $game_ids[2]) . ')', '`scheduleid` as `gameid`,`hometeamid`,`homename_cn` as `homeshortname`,`guestteamid` as `awayteamid`,`guestname_cn` as `awayshortname`,`date`', '', '', '', 'gameid');
			}
			//整合数据
			pc_base::load_app_func('global', 'sportsdata');
			//中文日期
			$date_cn = array(
				'(1)'	=>	'一',
				'(2)'	=>	'二',
				'(3)'	=>	'三',
				'(4)'	=>	'四',
				'(5)'	=>	'五',
				'(6)'	=>	'六',
				'(7)'	=>	'日'
			);
			foreach ($guess as &$_value) {
				//将比赛信息合并至竞猜信息
				$_value = array_merge($_value, $game_info[$_value['type']][$_value['gameid']]);
				//获取竞猜结果
				$_value['result'] = guess_result($_value['subtype'], $_value['result']);
				//处理日期
				$_value['date'] = str_replace(array_keys($date_cn), array_values($date_cn), date('星期(N) m-d H:i', $_value['date']));
				//球队logo
				$_value['home_logo'] = $_value['category'] == 1 ? PHOTO_PATH . 'team/' . $_value['hometeamid'] . '.jpg' : BT_TEAM_PATH . $_value['hometeamid'] . '.jpg';
				$_value['away_logo'] = $_value['category'] == 1 ? PHOTO_PATH . 'team/' . $_value['awayteamid'] . '.jpg' : BT_TEAM_PATH . $_value['awayteamid'] . '.jpg';
			}
		}
		include template('member', 'index');
	}
	
	public function register()
    {
		$this->_session_start();
		//获取用户siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		
		//加载用户模块配置
		$member_setting = getcache('member_setting');
		if(!$member_setting['allowregister']) {
			showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
		}
		//加载短信模块配置
 		$sms_setting_arr = getcache('sms','sms');
		$sms_setting = $sms_setting_arr[$siteid];
		header("Cache-control: private");
		if(isset($_POST['dosubmit']))
		{
			if($member_setting['enablcodecheck']=='1')
            {
                //开启验证码
				if ((empty($_SESSION['connectid']) && $_SESSION['code'] != strtolower($_POST['code']) && $_POST['code']!==NULL) || empty($_SESSION['code'])) {
					showmessage(L('code_error'));
				} else {
					$_SESSION['code'] = '';
				}
			}
			
			$userinfo = array();
			$userinfo['encrypt'] = create_randomstr(6);

			$userinfo['username'] = (isset($_POST['username']) && is_username($_POST['username'])) ? $_POST['username'] : '';
			$userinfo['nickname'] = (isset($_POST['nickname']) && is_username($_POST['nickname'])) ? $_POST['nickname'] : '';

			$userinfo['password'] = (isset($_POST['password']) && is_badword($_POST['password'])==false) ? $_POST['password'] : '';
			$userinfo['email'] = (isset($_POST['email']) && is_email($_POST['email'])) ? $_POST['email'] : '';
			$userinfo['modelid'] = isset($_POST['modelid']) ? intval($_POST['modelid']) : 10;
			$userinfo['regip'] = ip();
			$userinfo['point'] = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
			$userinfo['amount'] = $member_setting['defualtamount'] ? $member_setting['defualtamount'] : 0;
			$userinfo['regdate'] = $userinfo['lastdate'] = SYS_TIME;
			$userinfo['siteid'] = $siteid;
			$userinfo['connectid'] = isset($_SESSION['connectid']) ? $_SESSION['connectid'] : '';
			$userinfo['from'] = isset($_SESSION['from']) ? $_SESSION['from'] : '';
			//额外用户信息
			$userinfo['realname'] = (isset($_POST['realname']) && is_username($_POST['realname'])) ? $_POST['realname'] : '';
			$userinfo['tel'] = isset($_POST['tel']) ? $_POST['tel'] : '';
			$userinfo['street'] = (isset($_POST['province']) && !empty($_POST['province'])) ? trim($_POST['province']) . '|' : '';
			$userinfo['street'] .= (isset($_POST['city']) && !empty($_POST['city'])) ? trim($_POST['city']) . '|' : '';
			$userinfo['street'] .= (isset($_POST['area']) && !empty($_POST['area'])) ? trim($_POST['area']) . '|' : '';
			$userinfo['street'] .= (isset($_POST['street']) && !empty($_POST['street'])) ? trim($_POST['street']) : '';
			$userinfo['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : '';

			$validator = pc_base::load_sys_class('validate');
			$validator->check($_POST, [
				'username' => 'required|unique:v9_member',
				'mobile' => 'required|unique:v9_member',
				'email' => 'unique:v9_member',
				'password' => 'required',
				'confirm_password' => 'required|equal:password',
				'agree' => 'accept'
			]);

			if ($validator->is_failed()) {
				$response = array(
					'status' => false,
					'tip' => $validator->tip()
				);
			} else {
				//手机强制验证
				if($member_setting[mobile_checktype]=='1')
				{
					//取用户手机号
					$mobile_verify = $_POST['mobile_verify'] ? intval($_POST['mobile_verify']) : '';
					if($mobile_verify=='') showmessage('请提供正确的手机验证码！', HTTP_REFERER);
					$sms_report_db = pc_base::load_model('sms_report_model');
					$posttime = SYS_TIME-360;
					$where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
					$r = $sms_report_db->get_one($where,'*','id DESC');
					if(!empty($r)){
						$userinfo['mobile'] = $r['mobile'];
					}else{
//						showmessage('未检测到正确的手机号码！', HTTP_REFERER);
						$response = array(
							'status' => true,
							'data' => array(
								'type' => 'error',
								'title' => '失败',
								'text' => '未检测到正确的手机号码',
							)
						);
					}
				}
				elseif($member_setting[mobile_checktype]=='2')
				{
					//获取验证码，直接通过POST，取mobile值
					$userinfo['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : '';
				}
				if($userinfo['mobile']!="")
				{
					if(!preg_match('/^1([0-9]{10})$/',$userinfo['mobile'])) {
//						showmessage('请提供正确的手机号码！', HTTP_REFERER);
						$response = array(
							'status' => true,
							'data' => array(
								'type' => 'error',
								'title' => '失败',
								'text' => '请提供正确的手机号码',
							)
						);
					}
				}
				unset($_SESSION['connectid'], $_SESSION['from']);

				//是否需要邮件验证
				if($member_setting['enablemailcheck'])
				{
					$userinfo['groupid'] = 7;
				}
				//是否需要管理员审核
				elseif($member_setting['registerverify'])
				{
					$modelinfo_str = $userinfo['modelinfo'] = isset($_POST['info']) ? array2string(array_map("safe_replace", new_html_special_chars($_POST['info']))) : '';
					$this->verify_db = pc_base::load_model('member_verify_model');
					//去除新增字段(真实姓名，固定电话，地址)
					unset($userinfo['lastdate'],$userinfo['connectid'],$userinfo['from'],$userinfo['realname'],$userinfo['tel'],$userinfo['street']);
					$userinfo['modelinfo'] = $modelinfo_str;
					$this->verify_db->insert($userinfo);
//					showmessage(L('operation_success'), 'index.php?m=member&c=index&a=register&t=3');
					$response = array(
						'status' => true,
						'data' => array(
							'type' => 'success',
							'title' => '成功',
							'text' => '注册成功,待审核后即可登入',
						)
					);
				}
				else
				{
					//查看当前模型是否开启了短信验证功能
					$model_field_cache = getcache('model_field_'.$userinfo['modelid'],'model');
					if(isset($model_field_cache['mobile']) && $model_field_cache['mobile']['disabled']==0)
					{
						$mobile = $_POST['info']['mobile'];
						if(!preg_match('/^1([0-9]{10})$/',$mobile)) {
							$response = array(
								'status' => true,
								'data' => array(
									'type' => 'error',
									'title' => '失败',
									'text' => '请提供正确的手机号码',
								)
							);
						};
						$sms_report_db = pc_base::load_model('sms_report_model');
						$posttime = SYS_TIME-300;
						$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
						$r = $sms_report_db->get_one($where);
						if(!$r || $r['id_code']!=$_POST['mobile_verify']) {
							$response = array(
								'status' => true,
								'data' => array(
									'type' => 'error',
									'title' => '失败',
									'text' => '短信验证码错误',
								)
							);
						};
					}
					$userinfo['groupid'] = $this->_get_usergroup_bypoint($userinfo['point']);
				}
				//附表信息验证 通过模型获取会员信息
				if($member_setting['choosemodel'])
				{
					require_once CACHE_MODEL_PATH.'member_input.class.php';
					require_once CACHE_MODEL_PATH.'member_update.class.php';
					$member_input = new member_input($userinfo['modelid']);
					$_POST['info'] = array_map('new_html_special_chars',$_POST['info']);
					$user_model_info = $member_input->get($_POST['info']);
				}

				// 将会员信息入库
				$userinfo['password'] = password($userinfo['password'], $userinfo['encrypt']);
				$userid = $this->db->insert($userinfo, 1);
				if($member_setting['choosemodel']) {	//如果开启选择模型
					$user_model_info['userid'] = $userid;
					//插入会员模型数据
					$this->db->set_model($userinfo['modelid']);
					$this->db->insert($user_model_info);
				}

				if($userid > 0)
				{
					//执行登陆操作
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;

					if($userinfo['groupid'] == 7) {
						param::set_cookie('_username', $userinfo['username'], $cookietime);
						param::set_cookie('email', $userinfo['email'], $cookietime);
					} else {
						$phpcms_auth = sys_auth($userid."\t".$userinfo['password'], 'ENCODE', get_auth_key('login'));

						param::set_cookie('auth', $phpcms_auth, $cookietime);
						param::set_cookie('_userid', $userid, $cookietime);
						param::set_cookie('_username', $userinfo['username'], $cookietime);
						param::set_cookie('_nickname', $userinfo['nickname'], $cookietime);
						param::set_cookie('_groupid', $userinfo['groupid'], $cookietime);
						param::set_cookie('cookietime', $_cookietime, $cookietime);
					}
				}
				//如果需要邮箱认证
				if($member_setting['enablemailcheck'])
				{
					pc_base::load_sys_func('mail');
					$code = sys_auth($userid.'|'.microtime(true), 'ENCODE', get_auth_key('email'));
					$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";
					$message = $member_setting['registerverifymessage'];
					$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$userinfo['username'],$userinfo['email'],$password), $message);
					sendmail($userinfo['email'], L('reg_verify_email'), $message);
					//设置当前注册账号COOKIE，为第二步重发邮件所用
					param::set_cookie('_regusername', $userinfo['username'], $cookietime);
					param::set_cookie('_reguserid', $userid, $cookietime);
					param::set_cookie('_reguseruid', $userinfo['phpssouid'], $cookietime);
//					showmessage(L('operation_success'), 'index.php?m=member&c=index&a=register&t=2');
					$response = array(
						'status' => true,
						'data' => array(
							'type' => 'success',
							'title' => '成功',
							'text' => '注册成功,请到邮箱认证',
						)
					);
				}
				else
				{
//					showmessage(L('operation_success'), 'index.php?m=member&c=index&a=init');
					$response = array(
						'status' => true,
						'data' => array(
							'type' => 'success',
							'title' => '成功',
							'text' => '注册成功',
							'url' => APP_PATH . 'index.php?m=member&c=index&a=init'
						)
					);
				}
			}
			exit(json_encode($response));
//			showmessage(L('operation_failure'), HTTP_REFERER);
		}
        else
        {
			if(!empty($_GET['verify']))
            {
				$code = isset($_GET['code']) ? trim($_GET['code']) : showmessage(L('operation_failure'), 'index.php?m=member&c=index');
				$code_res = sys_auth($code, 'DECODE', get_auth_key('email'));
				$code_arr = explode('|', $code_res);
				$userid = isset($code_arr[0]) ? $code_arr[0] : '';
				$userid = is_numeric($userid) ? $userid : showmessage(L('operation_failure'), 'index.php?m=member&c=index');

				$this->db->update(array('groupid'=>$this->_get_usergroup_bypoint()), array('userid'=>$userid));
				showmessage(L('operation_success'), 'index.php?m=member&c=index');
			}
            elseif(!empty($_GET['protocol']))
            {

				include template('member', 'protocol');
			}
            else
            {
				//过滤非当前站点会员模型
				$modellist = getcache('member_model', 'commons');
				foreach($modellist as $k=>$v) {
					if($v['siteid']!=$siteid || $v['disabled']) {
						unset($modellist[$k]);
					}
				}
				if(empty($modellist)) {
					showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
				}
				//是否开启选择会员模型选项
				if($member_setting['choosemodel'])
                {
					$first_model = array_pop(array_reverse($modellist));
					$modelid = isset($_GET['modelid']) && in_array($_GET['modelid'], array_keys($modellist)) ? intval($_GET['modelid']) : $first_model['modelid'];

					if(array_key_exists($modelid, $modellist))
                    {
						//获取会员模型表单
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//万能字段过滤
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}
						
						$formValidator = $member_form->formValidator;
					}
				}
				$description = $modellist[$modelid]['description'];
				
				include template('member', 'register');
			}
		}
	}
 	
	//测试邮件配置
	public function send_newmail()
    {
		$_username = param::get_cookie('_regusername');
		$_userid = param::get_cookie('_reguserid');
		$newemail = $_GET['newemail'];

		if($newemail=='' || !is_email($newemail)){//邮箱为空，直接返回错误
			return '2';
		}
		//验证userid和username是否匹配
		$r = $this->db->get_one(array('userid'=>intval($_userid)));
		if($r[username]!=$_username){
			return '2';
		}
		
		//验证邮箱格式
		pc_base::load_sys_func('mail');
		$code = sys_auth($_userid.'|'.microtime(true), 'ENCODE', get_auth_key('email'));
		$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";
		
		//读取配置获取验证信息
		$member_setting = getcache('member_setting');
		$message = $member_setting['registerverifymessage'];
		$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$_username,$newemail,$password), $message);
		
 		if(sendmail($newemail, L('reg_verify_email'), $message))
        {
			//更新新的邮箱，用来验证
 			$this->db->update(array('email'=>$newemail), array('userid'=>$_userid));
			$return = '1';
		}else{
			$return = '2';
		}
		echo $return;
   	}
	
	public function account_manage()
    {
		$memberinfo = $this->memberinfo;
		//获取头像数组
        $obj_avatar = pc_base::load_app_class('avatar');
		$avatar = $obj_avatar->getavatar($memberinfo['userid']);
        $app_path = pc_base::load_config('system', 'app_path');
	
		$grouplist = getcache('grouplist');
		$member_model = getcache('member_model', 'commons');

		//获取用户模型数据
		$this->db->set_model($this->memberinfo['modelid']);
		$member_modelinfo_arr = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
		$model_info = getcache('model_field_'.$this->memberinfo['modelid'], 'model');
		foreach($model_info as $k=>$v)
        {
			if($v['formtype'] == 'omnipotent') continue;
			if($v['formtype'] == 'image')
            {
				$member_modelinfo[$v['name']] = "<a href='$member_modelinfo_arr[$k]' target='_blank'><img src='$member_modelinfo_arr[$k]' height='40' widht='40' onerror=\"this.src='$app_path/statics/images/member/nophoto.gif'\"></a>";
			}
            elseif($v['formtype'] == 'datetime' && $v['fieldtype'] == 'int')
            {
                //如果为日期字段
				$member_modelinfo[$v['name']] = format::date($member_modelinfo_arr[$k], $v['format'] == 'Y-m-d H:i:s' ? 1 : 0);
			}
            elseif($v['formtype'] == 'images')
            {
				$tmp = string2array($member_modelinfo_arr[$k]);
				$member_modelinfo[$v['name']] = '';
				if(is_array($tmp)) {
					foreach ($tmp as $tv) {
						$member_modelinfo[$v['name']] .= " <a href='$tv[url]' target='_blank'><img src='$tv[url]' height='40' widht='40' onerror=\"this.src='$app_path/statics/images/member/nophoto.gif'\"></a>";
					}
					unset($tmp);
				}
			}
            elseif($v['formtype'] == 'box')
            {
                //box字段，获取字段名称和值的数组
				$tmp = explode("\n",$v['options']);
				if(is_array($tmp))
                {
					foreach($tmp as $boxv)
                    {
						$box_tmp_arr = explode('|', trim($boxv));
						if(is_array($box_tmp_arr) && isset($box_tmp_arr[1]) && isset($box_tmp_arr[0])) {
							$box_tmp[$box_tmp_arr[1]] = $box_tmp_arr[0];
							$tmp_key = intval($member_modelinfo_arr[$k]);
						}
					}
				}
				if(isset($box_tmp[$tmp_key])) {
					$member_modelinfo[$v['name']] = $box_tmp[$tmp_key];
				} else {
					$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
				}
				unset($tmp, $tmp_key, $box_tmp, $box_tmp_arr);
			}
            elseif($v['formtype'] == 'linkage')
            {
                //如果为联动菜单
				$tmp = string2array($v['setting']);
				$tmpid = $tmp['linkageid'];
				$linkagelist = getcache($tmpid, 'linkage');
				$fullname = $this->_get_linkage_fullname($member_modelinfo_arr[$k], $linkagelist);

				$member_modelinfo[$v['name']] = substr($fullname, 0, -1);
				unset($tmp, $tmpid, $linkagelist, $fullname);
			}
            else
            {
				$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
			}
		}

		include template('member', 'account_manage');
	}

	public function account_manage_avatar()
    {
		$memberinfo = $this->memberinfo;

        // 获取应用url，base64_encode编码让二进制数据可以通过非纯8-bit传输层传输
        $app_path = pc_base::load_config('system', 'app_path');
        $upurl = base64_encode($app_path.'index.php?m=member&c=index&a=uploadavatar');

        // 获取头像数组
        $obj_avatar = pc_base::load_app_class('avatar');
        $avatar = $obj_avatar->getavatar(intval($memberinfo['userid']));

        include template('member', 'account_manage_avatar');
	}

	//账户安全
	public function account_manage_security()
	{
		$memberinfo = $this->memberinfo;

		//获取头像数组
		$obj_avatar = pc_base::load_app_class('avatar');
		$avatar = $obj_avatar->getavatar(intval($memberinfo['userid']));

		include template('member', 'account_manage_security');
	}
	
	public function account_manage_info()
    {
		if(isset($_POST['dosubmit']))
        {
			//更新用户信息
			$update_info['nickname'] = isset($_POST['nickname']) && is_username(trim($_POST['nickname'])) ? trim($_POST['nickname']) : '';
			$update_info['nickname'] = safe_replace($update_info['nickname']);
			$update_info['realname'] = (isset($_POST['realname']) && is_username($_POST['realname'])) ? $_POST['realname'] : '';
			$update_info['tel'] = isset($_POST['tel']) ? $_POST['tel'] : '';
			$update_info['street'] = (isset($_POST['province']) && !empty($_POST['province'])) ? trim($_POST['province']) . '|' : '';
			$update_info['street'] .= (isset($_POST['city']) && !empty($_POST['city'])) ? trim($_POST['city']) . '|' : '';
			$update_info['street'] .= (isset($_POST['area']) && !empty($_POST['area'])) ? trim($_POST['area']) . '|' : '';
			$update_info['street'] .= (isset($_POST['street']) && !empty($_POST['street'])) ? trim($_POST['street']) : '';
			$update_info['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : '';
			$update_info['email'] = isset($_POST['email']) ? $_POST['email'] : '';
			//验证
			$validator = pc_base::load_sys_class('validate');
			$validator->check($update_info, [
				'nickname' => 'required|unique:v9_member,nickname,userid,' . $this->memberinfo['userid'],
				'mobile' => 'required|unique:v9_member,mobile,userid,' . $this->memberinfo['userid'],
				'email' => 'required|unique:v9_member,email,userid,' . $this->memberinfo['userid']
			]);
			//如果验证失败返回错误信息，否则新增
			if ($validator->is_failed()) {
				$response = array(
					'status' => false,
					'tip' => $validator->tip()
				);
			} else {
				$this->db->update($update_info, array('userid'=>$this->memberinfo['userid']));
				//更新用户昵称
				if($update_info['nickname'])
				{
					if(!isset($cookietime)) {
						$get_cookietime = param::get_cookie('cookietime');
					}
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					param::set_cookie('_nickname', $update_info['nickname'], $cookietime);
				}
				require_once CACHE_MODEL_PATH.'member_input.class.php';
				require_once CACHE_MODEL_PATH.'member_update.class.php';
				$member_input = new member_input($this->memberinfo['modelid']);
				$modelinfo = $member_input->get($_POST['info']);

				$this->db->set_model($this->memberinfo['modelid']);
				$membermodelinfo = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
				if(!empty($membermodelinfo)) {
					$this->db->update($modelinfo, array('userid'=>$this->memberinfo['userid']));
				} else {
					$modelinfo['userid'] = $this->memberinfo['userid'];
					$this->db->insert($modelinfo);
				}
				$response = array(
					'status' => true,
					'data' => array(
						'type' => 'success',
						'title' => '成功',
						'text' => '修改成功'
					)
				);
			}
			//返回响应
			exit(json_encode($response));
		}
        else
        {
			$member_info = $this->memberinfo;
			// 获取应用url，base64_encode编码让二进制数据可以通过非纯8-bit传输层传输
			$url = base64_encode(APP_PATH.'index.php?m=member&c=index&a=uploadavatar');
			//获取头像数组
			$obj_avatar = pc_base::load_app_class('avatar');
			$avatar = $obj_avatar->getavatar(intval($member_info['userid']));
			//地址
			if (strpos($member_info['street'], '|') !== false) {
				list($province, $city, $area, $street) = explode('|', $member_info['street']);
			} else {
				$street = $member_info['street'];
			}
			//获取会员模型表单
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($this->memberinfo['modelid']);
			$this->db->set_model($this->memberinfo['modelid']);
			
			$membermodelinfo = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
			$forminfos = $forminfos_arr = $member_form->get($membermodelinfo);

			//万能字段过滤
			foreach($forminfos as $field=>$info) {
				if($info['isomnipotent']) {
					unset($forminfos[$field]);
				} else {
					if($info['formtype']=='omnipotent') {
						foreach($forminfos_arr as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
							}
						}
						$forminfos[$field]['form'] = $info['form'];
					}
				}
			}
						
			$formValidator = $member_form->formValidator;

			include template('member', 'account_manage_info');
		}
	}
	
	public function account_manage_password()
    {
		if(isset($_POST['dosubmit']))
        {
			$updateinfo = array();
			if(!is_password($_POST['info']['password'])) {
				showmessage(L('password_format_incorrect'), HTTP_REFERER);
			}
			if($this->memberinfo['password'] != password($_POST['info']['password'], $this->memberinfo['encrypt'])) {
				showmessage(L('old_password_incorrect'), HTTP_REFERER);
			}
			
			//修改会员邮箱
			if($this->memberinfo['email'] != $_POST['info']['email'] && is_email($_POST['info']['email'])) {
				$email = $_POST['info']['email'];
				$updateinfo['email'] = $_POST['info']['email'];
			} else {
				$email = '';
			}
			if(!is_password($_POST['info']['newpassword']) || is_badword($_POST['info']['newpassword'])) {
				showmessage(L('password_format_incorrect'), HTTP_REFERER);
			}
			$newpassword = password($_POST['info']['newpassword'], $this->memberinfo['encrypt']);
			$updateinfo['password'] = $newpassword;
			
			$this->db->update($updateinfo, array('userid'=>$this->memberinfo['userid']));

			showmessage(L('operation_success'), HTTP_REFERER);
		}
        else
        {
			$show_validator = true;
			$memberinfo = $this->memberinfo;
			
			include template('member', 'account_manage_password');
		}
	}

	//更换手机号码
	public function account_change_mobile()
    {
		$memberinfo = $this->memberinfo;
		if(isset($_POST['dosubmit']))
        {
			if(!is_password($_POST['password'])) {
				showmessage(L('password_format_incorrect'), HTTP_REFERER);
			}
			if($this->memberinfo['password'] != password($_POST['password'], $this->memberinfo['encrypt'])) {
				showmessage(L('old_password_incorrect'));
			}
			$sms_report_db = pc_base::load_model('sms_report_model');
			$mobile_verify = $_POST['mobile_verify'];
			$mobile = $_POST['mobile'];
			if($mobile)
            {
				if(!preg_match('/^1([0-9]{10})$/',$mobile)) exit('check phone error');
				$posttime = SYS_TIME-600;
				$where = "`mobile`='$mobile' AND `send_userid`='".$memberinfo['userid']."' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where,'id,id_code','id DESC');
				if($r && $r['id_code']==$mobile_verify) {
					$sms_report_db->update(array('id_code'=>''),$where);
					$this->db->update(array('mobile'=>$mobile),array('userid'=>$memberinfo['userid']));
					showmessage("手机号码更新成功！",'?m=member&c=index&a=account_change_mobile&t=1');
				} else {
					showmessage("短信验证码错误！请重新获取！");
				}
			}else{
				showmessage("短信验证码已过期！请重新获取！");
			}
		} else {
			include template('member', 'account_change_mobile');
		}
	}

	//选择密码找回方式
	public function public_get_password_type() {
		$siteid = intval($_GET['siteid']);
		include template('member', 'get_password_type');
	}

	public function account_manage_upgrade()
    {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		if(empty($grouplist[$memberinfo['groupid']]['allowupgrade'])) {
			showmessage(L('deny_upgrade'), HTTP_REFERER);
		}
		if(isset($_POST['upgrade_type']) && intval($_POST['upgrade_type']) < 0) {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}

		if(isset($_POST['upgrade_date']) && intval($_POST['upgrade_date']) < 0) {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}

		if(isset($_POST['dosubmit']))
        {
			$groupid = isset($_POST['groupid']) ? intval($_POST['groupid']) : showmessage(L('operation_failure'), HTTP_REFERER);
			
			$upgrade_type = isset($_POST['upgrade_type']) ? intval($_POST['upgrade_type']) : showmessage(L('operation_failure'), HTTP_REFERER);
			$upgrade_date = !empty($_POST['upgrade_date']) ? intval($_POST['upgrade_date']) : showmessage(L('operation_failure'), HTTP_REFERER);

			//消费类型，包年、包月、包日，价格
			$typearr = array($grouplist[$groupid]['price_y'], $grouplist[$groupid]['price_m'], $grouplist[$groupid]['price_d']);
			//消费类型，包年、包月、包日，时间
			$typedatearr = array('366', '31', '1');
			//消费的价格
			$cost = $typearr[$upgrade_type]*$upgrade_date;
			//购买时间
			$buydate = $typedatearr[$upgrade_type]*$upgrade_date*86400;
			$overduedate = $memberinfo['overduedate'] > SYS_TIME ? ($memberinfo['overduedate']+$buydate) : (SYS_TIME+$buydate);

			if($memberinfo['amount'] >= $cost) {
				$this->db->update(array('groupid'=>$groupid, 'overduedate'=>$overduedate, 'vip'=>1), array('userid'=>$memberinfo['userid']));
				//消费记录
				pc_base::load_app_class('spend','pay',0);
				spend::amount($cost, L('allowupgrade'), $memberinfo['userid'], $memberinfo['username']);
				showmessage(L('operation_success'), 'index.php?m=member&c=index&a=init');
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}

		}
        else
        {
			
			$groupid = isset($_GET['groupid']) ? intval($_GET['groupid']) : '';
			//获取头像数组
			$avatar = '';
			
			
			$memberinfo['groupname'] = $grouplist[$memberinfo[groupid]]['name'];
			$memberinfo['grouppoint'] = $grouplist[$memberinfo[groupid]]['point'];
			unset($grouplist[$memberinfo['groupid']]);
			include template('member', 'account_manage_upgrade');
		}
	}

	//收货地址
	public function account_manage_address(){
        if (!empty($_POST)) {
            $name      = $_POST['name'];
            $phone     = $_POST['phone'];
            $province  = $_POST['province'];
            $city      = $_POST['city'];
            $area      = $_POST['area'];
            $address   = $_POST['address'];
            $isdefault = $_POST['isdefault'];

            if (empty($name)) {
                return $this->response('名字不能为空');
            }

            if (empty($phone)) {
                return $this->response('电话不能为空');
            }

            if (empty($province) || empty($city) || empty($area)) {
                return $this->response('所在地不能为空');
            }

            if (empty($address)) {
                return $this->response('详细地址不能为空');
            }

            $memberinfo = $this->memberinfo;
            $userId     = $memberinfo['userid'];

            $data = [
                'name'      => $name,
                'phone'     => $phone,
                'province'  => $province,
                'city'      => $city,
                'area'      => $area,
                'address'   => $province . ' ' . $city . ' ' . $area . ' ' . $address,
                'isdefault' => 0,
                'userid'    => $userId,
            ];

            if ($isdefault === 'on') {
                $data['isdefault'] = 1;
            }

            $address_db = pc_base::load_model('address_model');
            $insertId   = $address_db->insert($data, true);

            if ($insertId > 0) {
                return $this->response('保存成功', ['url' => '#'], true);
            }

            return $this->response('保存失败');
        }

        include template('member', 'account_manage_address');
    }

    private function response($msg = '', $data= [], $status = false)
    {
        $resource = [
            'status' => $status,
            'msg'    => (string)$msg,
        ];

        if (!empty($data)) {
            $resource['data'] = $data;
        }

        header('Content-type: application/json; charset=utf-8');
        echo \json_encode($resource);
        return false;
    }
	
	public function login()
    {
        $this->_session_start();

        if (!empty($_POST)) {
            if (!isset($_POST['username'])) {
                return $this->response(L('nameerror'));
            }

            if (!isset($_POST['password'])) {
                return $this->response(L('password_can_not_be_empty'));
            }

            if (!is_password($_POST['password'])) {
                return $this->response('username_password_error');
            }

            $username   = trim($_POST['username']);
            $password   = trim($_POST['password']);

            //查询帐号
            if (email($username)) {
                $paramName = 'email';
            } elseif (mobileNum($username)) {
                $paramName = 'mobile';
            } else {
                $paramName = 'username';
            }
            $r = $this->db->get_one(array($paramName => $username));

            if (!$r) {
                return $this->response(L('username_password_error'));
            }

            //验证用户密码
            $password = md5(md5(trim($password)) . $r['encrypt']);

            if ($r['password'] != $password) {
                return $this->response(L('username_password_error'));
            }

            $userid   = $r['userid'];
            $username = $r['username'];

            $phpcms_auth = sys_auth($userid . "\t" . $password, 'ENCODE', get_auth_key('login'));

            $_cookietime = $_POST['cookietime'] ? 2592000 : 86400;
            $cookietime  = $_cookietime ? SYS_TIME + $_cookietime : 0;

            param::set_cookie('auth', $phpcms_auth, 0);
            param::set_cookie('_username', $username, $cookietime);
            $url = $_POST['referer'];
            return $this->response(L('login_success'), ['url' => $url], true);
        } else {
            $referer = HTTP_REFERER;
            include template('member', 'login');
        }
	}
  	
	public function logout()
    {
        param::set_cookie('auth', '');
        param::set_cookie('_userid', '');
        param::set_cookie('_username', '');
        param::set_cookie('_groupid', '');
        param::set_cookie('_nickname', '');
        param::set_cookie('cookietime', '');
        header('Location: /u/login/');
	}

	public function collect()
    {
        $type   = (int)$_POST['type'];
        $gameId = (int)$_POST['gameid'];
        $title  = isset($_POST['title']) ? trim($_POST['title']) : '';
        $url    = isset($_POST['url']) ? trim($_POST['url']) : '';

        if ($type !== 1 && $type !== 2 && $type !== 3) {
            return $this->response('无效的收藏类别');
        }

        if ($type !== 1 && $gameId <= 0) {
            return $this->response('无效的赛事ID');
        }

        if ($type === 1 && (empty($title) || empty($url))) {
            return $this->response('无效的文章信息');
        }

        $memberinfo = $this->memberinfo;
        $userId     = (int)$memberinfo['userid'];

        $favorite_db = pc_base::load_model('favorite_model');

        $where       = 'userid=' . $userId;
        $collectData = $favorite_db->select($where, '`type`, `url`, `gameid`');

        $flag = 0;

        foreach ($collectData as $item) {
            if ($type === 1) {
                if ($item['url'] == $url) {
                    $flag = 1;
                }
            } else {
                if ($item['gameid'] == $gameId) {
                    $flag = 1;
                }
            }
        }

        $data = [
            'userid'  => $userId,
            'type'    => $type,
            'title'   => $title,
            'url'     => $url,
            'gameid'  => $gameId,
        ];

        if ($flag === 0) {
            $data['adddate'] = time();
            $favorite_db->insert($data);
            return $this->response('收藏成功', ['success'], true);
        }

        $favorite_db->delete($data);
        return $this->response('取消收藏成功', ['cancel'], true);
    }

	//我的收藏
	public function favorite()
    {
        $week = [
            0 => '日',
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
        ];


        $memberinfo = $this->memberinfo;
        $userId     = $memberinfo['userid'];
        $id         = (int)$_GET['id'];

        $favorite_db = pc_base::load_model('favorite_model');

        if ($id > 0) { // 取消收藏
            $favorite_db->delete(array('userid' => $userId, 'id' => intval($_GET['id'])));
            showmessage(L('operation_success'), HTTP_REFERER);
        } else {
            //$page         = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
            //$favoritelist = $favorite_db->listinfo(array('userid' => $userId), 'id DESC', $page, 10);
            $favoritelist = $favorite_db->select('userid=' . $userId);

            $perPage = 50;

            if (!empty($favoritelist)) {
                $gameWhere = to_sqls(array_column($favoritelist, 'gameid'), '', '`gameid`');

                $game_db  = pc_base::load_model('game_model');
                $wlive_db = pc_base::load_model('wlive_model');
                //$gamelist    = $game_db->listinfo($gameWhere . ' AND status=10', 'gameid DESC', $page,$perPage );
                //$pages       = $game_db->pages;
                //$notGamelist = $game_db->listinfo($gameWhere . ' AND status!=10', 'gameid DESC', $page ,$perPage);
                //$notPages    = $game_db->pages;
                //$gamelist    = $game_db->listinfo($gameWhere . ' AND status=10', 'gameid DESC', $page,$perPage );
                $gamelist    = $game_db->select($gameWhere . ' AND status in (4,10)', 'gameid, homescore, awayscore, status, homename, awayname, date, competitionshortname', $perPage, 'gameid DESC');
                $notGamelist = $game_db->select($gameWhere . ' AND status not in (4,10)', 'gameid, homescore, awayscore, status, homename, awayname, date, competitionshortname', $perPage, 'gameid DESC');
                $wlivelist   = $wlive_db->select($gameWhere);

                foreach ($wlivelist as $item) {
                    $wliveData[$item['gameid']] = $item['islive'];
                }

                foreach ($gamelist as $key => $item) {
                    $item['score']        = $item['homescore'] . '-' . $item['awayscore'];
                    $item['time']         = '星期' . $week[date('w', $item['date'])] . ' ' . date('m-d H:i:s', $item['date']);
                    $item['status_cn']    = $this->arr_status[(int)$item['status']];
                    $item['live']         = isset($wliveData[$item['gameid']]) ? $wliveData[$item['gameid']] : 0;
                    $gameData['finish'][] = $item;

                }

                foreach ($notGamelist as $key => $item) {
                    $item['score']            = $item['homescore'] . '-' . $item['awayscore'];
                    $item['time']             = '星期' . $week[date('w', $item['date'])] . ' ' . date('m-d H:i:s', $item['date']);
                    $item['status_cn']        = $this->arr_status[(int)$item['status']];
                    $item['live']             = isset($wliveData[$item['gameid']]) ? $wliveData[$item['gameid']] : 0;
                    $gameData['not_finish'][] = $item;
                }
            }

            include template('member', 'favorite_list');
        }
	}
	
	//我的好友
	public function friend()
    {
		$memberinfo = $this->memberinfo;
		$this->friend_db = pc_base::load_model('friend_model');
		if(isset($_GET['friendid'])) {
			$this->friend_db->delete(array('userid'=>$memberinfo['userid'], 'friendid'=>intval($_GET['friendid'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		}
        else
        {
			//我的好友列表userid
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$friendids = $this->friend_db->listinfo(array('userid'=>$memberinfo['userid']), '', $page, 10);
			$pages = $this->friend_db->pages;
			foreach($friendids as $k=>$v) {
				$friendlist[$k]['friendid'] = $v['friendid'];
				$friendlist[$k]['avatar'] = ''; // 头像获取？
				$friendlist[$k]['is'] = $v['is'];
			}
			include template('member', 'friend_list');
		}
	}
	
	//积分兑换
	public function change_credit()
    {
		$memberinfo = $this->memberinfo;
		//加载用户模块配置
		$member_setting = getcache('member_setting');

		if(isset($_POST['dosubmit']))
        {
			//本系统积分兑换数
			$fromvalue = intval($_POST['fromvalue']);
			//本系统积分类型
			$from = $_POST['from'];
			$toappid_to = explode('_', $_POST['to']);
			//目标系统appid
			$toappid = $toappid_to[0];
			//目标系统积分类型
			$to = $toappid_to[1];
			if($from == 1) {
				if($memberinfo['point'] < $fromvalue) {
					showmessage(L('need_more_point'), HTTP_REFERER);
				}
			} elseif($from == 2) {
				if($memberinfo['amount'] < $fromvalue) {
					showmessage(L('need_more_amount'), HTTP_REFERER);
				}
			} else {
				showmessage(L('credit_setting_error'), HTTP_REFERER);
			}

            if($from == 1) {
                $this->db->update(array('point'=>"-=$fromvalue"), array('userid'=>$memberinfo['userid']));
            } elseif($from == 2) {
                $this->db->update(array('amount'=>"-=$fromvalue"), array('userid'=>$memberinfo['userid']));
            } else {
                showmessage(L('operation_failure'), HTTP_REFERER);
            }

            showmessage(L('operation_success'), HTTP_REFERER);
		}
        elseif(isset($_POST['buy']))
        {
			if(!is_numeric($_POST['money']) || $_POST['money'] < 0) {
				showmessage(L('money_error'), HTTP_REFERER);
			} else {
				$money = intval($_POST['money']);
			}
			
			if($memberinfo['amount'] < $money) {
				showmessage(L('short_of_money'), HTTP_REFERER);
			}
			//此处比率读取用户配置
			$point = $money*$member_setting['rmb_point_rate'];
			$this->db->update(array('point'=>"+=$point"), array('userid'=>$memberinfo['userid']));
			//加入消费记录，同时扣除金钱
			pc_base::load_app_class('spend','pay',0);
			spend::amount($money, L('buy_point'), $memberinfo['userid'], $memberinfo['username']);
			showmessage(L('operation_success'), HTTP_REFERER);
		}
        else
        {
			$credit_list = pc_base::load_config('credit');
			
			include template('member', 'change_credit');
		}
	}
	
	//mini登陆条
	public function mini()
    {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		
		$snda_enable = pc_base::load_config('system', 'snda_enable');
		include template('member', 'mini');
	}

	protected function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}
	
	private function _session_start() {
		$session_storage = 'session_'.pc_base::load_config('system','session_storage');
		pc_base::load_sys_class($session_storage);
	}
	
	//通过linkageid获取名字路径
	protected function _get_linkage_fullname($linkageid,  $linkagelist)
    {
		$fullname = '';
		if($linkagelist['data'][$linkageid]['parentid'] != 0) {
			$fullname = $this->_get_linkage_fullname($linkagelist['data'][$linkageid]['parentid'], $linkagelist);
		}
		//所在地区名称
		$return = $fullname.$linkagelist['data'][$linkageid]['name'].'>';
		return $return;
	}
	
	/**
	 * 根据积分算出用户组
	 * @param $point int 积分数
     * @return $groupid 用户组ID
	 */
	protected function _get_usergroup_bypoint($point=0)
    {
		$groupid = 2;
		if(empty($point)) {
			$member_setting = getcache('member_setting');
			$point = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
		}
		$grouplist = getcache('grouplist');
		
		foreach ($grouplist as $k=>$v) {
			$grouppointlist[$k] = $v['point'];
		}
		arsort($grouppointlist);

		//如果超出用户组积分设置则为积分最高的用户组
		if($point > max($grouppointlist)) {
			$groupid = key($grouppointlist);
		} else {
			foreach ($grouppointlist as $k=>$v) {
				if($point >= $v) {
					$groupid = $tmp_k;
					break;
				}
				$tmp_k = $k;
			}
		}
		return $groupid;
	}
				
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 * @return $status {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	 */
	public function public_checkname_ajax()
    {
		$username = isset($_GET['username']) && trim($_GET['username']) && is_username(trim($_GET['username'])) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}
		$username = safe_replace($username);
		//首先判断会员审核表
		$this->verify_db = pc_base::load_model('member_verify_model');
		if($this->verify_db->get_one(array('username'=>$username))) {
			exit('0');
		}
        // 然后判断会员表(修改用户名的情况暂未考虑)
        if($this->db->get_one(array('username'=>$username))){
            exit('0');
        }
        exit('1');
	
	}
	
	/**
	 * 检查用户昵称
	 * @param string $nickname	昵称
	 * @return $status {0:已存在;1:成功}
	 */
	public function public_checknickname_ajax()
    {
		$nickname = isset($_GET['nickname']) && trim($_GET['nickname']) && is_username(trim($_GET['nickname'])) ? trim($_GET['nickname']) : exit('0');
		if(CHARSET != 'utf-8') {
			$nickname = iconv('utf-8', CHARSET, $nickname);
			$nickname = addslashes($nickname);
		} 
		//首先判断会员审核表
		$this->verify_db = pc_base::load_model('member_verify_model');
		if($this->verify_db->get_one(array('nickname'=>$nickname))) {
			exit('0');
		}
		if(isset($_GET['userid']))
        {
			$userid = intval($_GET['userid']);
			//如果是会员修改，而且NICKNAME和原来优质一致返回1，否则返回0
			$info = get_memberinfo($userid);
			if($info['nickname'] == $nickname){//未改变
				exit('1');
			}else{//已改变，判断是否已有此名
				$where = array('nickname'=>$nickname);
				$res = $this->db->get_one($where);
				if($res) {
					exit('0');
				} else {
					exit('1');
				}
			}
 		}
        else
        {
			$where = array('nickname'=>$nickname);
			$res = $this->db->get_one($where);
			if($res) {
				exit('0');
			} else {
				exit('1');
			}
		} 
	}
	
	/**
	 * 检查邮箱
	 * @param string $email
	 * @return $status {-1:email已经存在;-5:邮箱禁止注册;1:成功}
	 */
	public function public_checkemail_ajax()
    {
        $email = isset($_GET['email']) && trim($_GET['email']) && is_email(trim($_GET['email']))  ? trim($_GET['email']) : exit(0);

        //首先判断会员审核表
        $this->verify_db = pc_base::load_model('member_verify_model');
        if($this->verify_db->get_one(array('email'=>$email))) {
            exit('0');
        }
        // 然后判断会员表(修改邮箱的情况暂未考虑)
        if($this->db->get_one(array('email'=>$email))){
            exit('0');
        }
        exit('1');

    }
	
	//新浪微博登录
	public function public_sina_login()
	{
		define('WB_AKEY', pc_base::load_config('system', 'sina_akey'));
		define('WB_SKEY', pc_base::load_config('system', 'sina_skey'));
		define('WEB_CALLBACK', APP_PATH.'index.php?m=member&c=index&a=public_sina_login&callback=1');
		pc_base::load_app_class('saetv2.ex', '' ,0);
		$this->_session_start();
					
		if(isset($_GET['callback']) && trim($_GET['callback']))
		{
			$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
			if (isset($_REQUEST['code']))
			{
				$keys = array();
				$keys['code'] = $_REQUEST['code'];
				$keys['redirect_uri'] = WEB_CALLBACK;
				try {
					$token = $o->getAccessToken('code', $keys);
				} catch (OAuthException $e) {
				}
			}
			if ($token) {
				$_SESSION['token'] = $token;
			}
			$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token'] );
			$ms  = $c->home_timeline(); // done
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$me = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
			if(CHARSET != 'utf-8') {
				$me['name'] = iconv('utf-8', CHARSET, $me['name']);
				$me['location'] = iconv('utf-8', CHARSET, $me['location']);
				$me['description'] = iconv('utf-8', CHARSET, $me['description']);
				$me['screen_name'] = iconv('utf-8', CHARSET, $me['screen_name']);
			}
			if(!empty($me['id']))
			{
 				//检查connect会员是否绑定，已绑定直接登录，未绑定提示注册/绑定页面
				$where = array('connectid'=>$me['id'], 'from'=>'sina');
				$r = $this->db->get_one($where);
				
				//connect用户已经绑定本站用户
				if(!empty($r))
				{
					//读取本站用户信息，执行登录操作
					$password = $r['password'];
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', get_auth_key('login'));
					
					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success'), $forward);
					
				}
				else
				{
 					//弹出绑定注册页面
					$_SESSION = array();
					$_SESSION['connectid'] = $me['id'];
					$_SESSION['from'] = 'sina';
					$connect_username = $me['name'];
					
					//加载用户模块配置
					$member_setting = getcache('member_setting');
					if(!$member_setting['allowregister']) {
						showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
					}
					
					//获取用户siteid
					$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
					//过滤非当前站点会员模型
					$modellist = getcache('member_model', 'commons');
					foreach($modellist as $k=>$v) {
						if($v['siteid']!=$siteid || $v['disabled']) {
							unset($modellist[$k]);
						}
					}
					if(empty($modellist)) {
						showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
					}
					
					$modelid = 10; //设定默认值
					if(array_key_exists($modelid, $modellist))
                    {
						//获取会员模型表单
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//万能字段过滤
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}
						
						$formValidator = $member_form->formValidator;
					}
					include template('member', 'connect');
				}
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}
		}
		else
		{
			$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
			$aurl = $o->getAuthorizeURL(WEB_CALLBACK);
			include template('member', 'connect_sina');
		}
	}
	
	//盛大通行证登录
	public function public_snda_login()
    {
		define('SNDA_AKEY', pc_base::load_config('system', 'snda_akey'));
		define('SNDA_SKEY', pc_base::load_config('system', 'snda_skey'));
		define('SNDA_CALLBACK', urlencode(APP_PATH.'index.php?m=member&c=index&a=public_snda_login&callback=1'));
		
		pc_base::load_app_class('OauthSDK', '' ,0);
		$this->_session_start();		
		if(isset($_GET['callback']) && trim($_GET['callback']))
        {
					
			$o = new OauthSDK(SNDA_AKEY, SNDA_SKEY, SNDA_CALLBACK);
			$code = $_REQUEST['code'];
			$accesstoken = $o->getAccessToken($code);
		
			if(is_numeric($accesstoken['sdid'])) {
				$userid = $accesstoken['sdid'];
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}

			if(!empty($userid))
            {
				
				//检查connect会员是否绑定，已绑定直接登录，未绑定提示注册/绑定页面
				$where = array('connectid'=>$userid, 'from'=>'snda');
				$r = $this->db->get_one($where);
				
				//connect用户已经绑定本站用户
				if(!empty($r))
                {
					//读取本站用户信息，执行登录操作
					$password = $r['password'];
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', get_auth_key('login'));
					
					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_from', 'snda');
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success'), $forward);
				}
                else
                {
					//弹出绑定注册页面
					$_SESSION = array();
					$_SESSION['connectid'] = $userid;
					$_SESSION['from'] = 'snda';
					$connect_username = $userid;
					include template('member', 'connect');
				}
			}	
		}
        else
        {
			$o = new OauthSDK(SNDA_AKEY, SNDA_SKEY, SNDA_CALLBACK);
			$accesstoken = $o->getSystemToken();		
			$aurl = $o->getAuthorizeURL();
			
			include template('member', 'connect_snda');
		}
		
	}

	/**
	 * QQ号码登录
	 * 该函数为QQ登录回调地址
	 */
	public function public_qq_loginnew()
    {
        $appid = pc_base::load_config('system', 'qq_appid');
        $appkey = pc_base::load_config('system', 'qq_appkey');
        $callback = pc_base::load_config('system', 'qq_callback');
        pc_base::load_app_class('qqapi','',0);
        $info = new qqapi($appid,$appkey,$callback);
        $this->_session_start();
        if(!isset($_GET['code'])){
                 $info->redirect_to_login();
        }
        else
        {
            $code = $_GET['code'];
            $openid = $_SESSION['openid'] = $info->get_openid($code);
            if(!empty($openid))
            {
                $r = $this->db->get_one(array('connectid'=>$openid,'from'=>'qq'));

                 if(!empty($r))
                 {
                    //QQ已存在于数据库，则直接转向登陆操作
                    $password = $r['password'];
                    $userid = $r['userid'];
                    $groupid = $r['groupid'];
                    $username = $r['username'];
                    $nickname = empty($r['nickname']) ? $username : $r['nickname'];
                    $this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
                    if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
                    $_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
                    $cookietime = $_cookietime ? TIME + $_cookietime : 0;
                    $phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', get_auth_key('login'));
                    param::set_cookie('auth', $phpcms_auth, $cookietime);
                    param::set_cookie('_userid', $userid, $cookietime);
                    param::set_cookie('_username', $username, $cookietime);
                    param::set_cookie('_groupid', $groupid, $cookietime);
                    param::set_cookie('cookietime', $_cookietime, $cookietime);
                    param::set_cookie('_nickname', $nickname, $cookietime);
                    $forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
                    showmessage(L('login_success'), $forward);
                }
                else
                {
                    //未存在于数据库中，跳去完善资料页面。页面预置用户名（QQ返回是UTF8编码，如有需要进行转码）
                    $user = $info->get_user_info();
                    $_SESSION['connectid'] = $openid;
                    $_SESSION['from'] = 'qq';
                    if(CHARSET != 'utf-8') {//转编码
                        $connect_username = iconv('utf-8', CHARSET, $user);
                    } else {
                         $connect_username = $user;
                    }
                    include template('member', 'connect');
                }
            }
        }
    }
	
	//QQ微博登录
	public function public_qq_login()
    {
		define('QQ_AKEY', pc_base::load_config('system', 'qq_akey'));
		define('QQ_SKEY', pc_base::load_config('system', 'qq_skey'));
		pc_base::load_app_class('qqoauth', '' ,0);
		$this->_session_start();
		if(isset($_GET['callback']) && trim($_GET['callback']))
        {
			$o = new WeiboOAuth(QQ_AKEY, QQ_SKEY, $_SESSION['keys']['oauth_token'], $_SESSION['keys']['oauth_token_secret']);
			$_SESSION['last_key'] = $o->getAccessToken($_REQUEST['oauth_verifier']);
			
			if(!empty($_SESSION['last_key']['name']))
            {
				//检查connect会员是否绑定，已绑定直接登录，未绑定提示注册/绑定页面
				$where = array('connectid'=>$_REQUEST['openid'], 'from'=>'qq');
				$r = $this->db->get_one($where);
				
				//connect用户已经绑定本站用户
				if(!empty($r))
                {
					//读取本站用户信息，执行登录操作
					$password = $r['password'];
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', get_auth_key('login'));
					
					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_from', 'snda');
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success'), $forward);
				}
                else
                {
					//弹出绑定注册页面
					$_SESSION = array();
					$_SESSION['connectid'] = $_REQUEST['openid'];
					$_SESSION['from'] = 'qq';
					$connect_username = $_SESSION['last_key']['name'];

					//加载用户模块配置
					$member_setting = getcache('member_setting');
					if(!$member_setting['allowregister']) {
						showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
					}
					
					//获取用户siteid
					$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
					//过滤非当前站点会员模型
					$modellist = getcache('member_model', 'commons');
					foreach($modellist as $k=>$v) {
						if($v['siteid']!=$siteid || $v['disabled']) {
							unset($modellist[$k]);
						}
					}
					if(empty($modellist)) {
						showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
					}
					
					$modelid = 10; //设定默认值
					if(array_key_exists($modelid, $modellist)) {
						//获取会员模型表单
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//万能字段过滤
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}
						
						$formValidator = $member_form->formValidator;
					}	
					include template('member', 'connect');
				}
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}
		}
        else
        {
			$oauth_callback = APP_PATH.'index.php?m=member&c=index&a=public_qq_login&callback=1';
			$oauth_nonce = md5(SYS_TIME);
			$oauth_signature_method = 'HMAC-SHA1';
			$oauth_timestamp = SYS_TIME;
			$oauth_version = '1.0';

			$url = "https://open.t.qq.com/cgi-bin/request_token?oauth_callback=$oauth_callback&oauth_consumer_key=".QQ_AKEY."&oauth_nonce=$oauth_nonce&oauth_signature=".QQ_SKEY."&oauth_signature_method=HMAC-SHA1&oauth_timestamp=$oauth_timestamp&oauth_version=$oauth_version"; 
			$o = new WeiboOAuth(QQ_AKEY, QQ_SKEY);
			
			$keys = $o->getRequestToken(array('callback'=>$oauth_callback));
			$_SESSION['keys'] = $keys;
			$aurl = $o->getAuthorizeURL($keys['oauth_token'] ,false , $oauth_callback);
			
			include template('member', 'connect_qq');	
		}

	}

	//通过email方式找回密码
	public function public_forget_password ()
    {
		$email_config = getcache('common', 'commons');
		
		//SMTP MAIL 二种发送模式
 		if($email_config['mail_type'] == '1'){
			if(empty($email_config['mail_user']) || empty($email_config['mail_password'])) {
				showmessage(L('email_config_empty'), HTTP_REFERER);
			}
		}
		$this->_session_start();
		$member_setting = getcache('member_setting');
		if(isset($_POST['dosubmit']))
        {
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			//邮箱验证
			if(!is_email($_POST['email'])){
				showmessage(L('email_error'), HTTP_REFERER);
			}
			$memberinfo = $this->db->get_one(array('email'=>$_POST['email']));
			if(!empty($memberinfo['email'])) {
				$email = $memberinfo['email'];
			} else {
				showmessage(L('email_error'), HTTP_REFERER);
			}
			
			pc_base::load_sys_func('mail');

			$code = sys_auth($memberinfo['userid']."\t".microtime(true), 'ENCODE', get_auth_key('email'));

			$url = APP_PATH."index.php?m=member&c=index&a=public_forget_password&code=$code";
			$message = $member_setting['forgetpassword'];
			$message = str_replace(array('{click}','{url}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url), $message);
			//获取站点名称
			$sitelist = getcache('sitelist', 'commons');
			
			if(isset($sitelist[$memberinfo['siteid']]['name'])) {
				$sitename = $sitelist[$memberinfo['siteid']]['name'];
			} else {
				$sitename = 'PHPCMS_V9_MAIL';
			}
			sendmail($email, L('forgetpassword'), $message, '', '', $sitename);
			showmessage(L('operation_success'), 'index.php?m=member&c=index&a=login');
		}
        elseif($_GET['code'])
        {
			$hour = date('y-m-d h', SYS_TIME);
			$code = sys_auth($_GET['code'], 'DECODE', get_auth_key('email'));
			$code = explode("\t", $code);

			if(is_array($code) && is_numeric($code[0]) && date('y-m-d h', SYS_TIME) == date('y-m-d h', $code[1]))
            {
				//将原本的逻辑替换为显示修改密码界面
				$user_id = $code[0];
				include template('member', 'forget_password_2');

			} else {
				showmessage(L('operation_failure'), 'index.php?m=member&c=index&a=login');
			}

		} else {
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);
			
			include template('member', 'forget_password_1');
		}
	}

	/**
	 * 修改密码逻辑
	 */
	public function public_change_password()
	{
		if ($_POST['dosubmit'] && isset($_POST['user_id'])) {
			//用户信息
			$user_id = $_POST['user_id'];
			$password = $_POST['password'];
			$memberinfo = $this->db->get_one(array('userid'=>$user_id));

			$updateinfo = array();
			$updateinfo['password'] = password($password, $memberinfo['encrypt']);

			$this->db->update($updateinfo, array('userid'=>$user_id));
			$email = $memberinfo['email'];
			//获取站点名称
			$sitelist = getcache('sitelist', 'commons');
			if(isset($sitelist[$memberinfo['siteid']]['name'])) {
				$sitename = $sitelist[$memberinfo['siteid']]['name'];
			} else {
				$sitename = 'PHPCMS_V9_MAIL';
			}
			pc_base::load_sys_func('mail');
			sendmail($email, L('forgetpassword'), "New password:".$password, '', '', $sitename);
			include template('member', 'forget_password_3');
		} else {
			showmessage(L('operation_failure'), 'index.php?m=member&c=index&a=login');
		}
	}
	
	/**
	 * 通过手机修改密码
	 * 方式：用户发送HHPWD afei985#821008 至 1065788 ，PHPCMS进行转发到网站运营者指定的回调地址，在回调地址程序进行密码修改等操作,处理成功时给用户发条短信确认。
	 * 要求：网站中会员系统，mobile做为主表字段，并且唯一（如已经有手机号码，把号码字段转为主表字段中）
	 */
	public function public_changepwd_bymobile()
    {
		$phone = $_REQUEST['phone'];
		$msg = $_REQUEST['msg'];
		$sms_key = $_REQUEST['sms_passwd'];
		$sms_pid = $_REQUEST['sms_pid'];
		if(empty($phone) || empty($msg) || empty($sms_key) || empty($sms_pid)){
			return false;
		}
		if(!preg_match('/^1([0-9]{10})$/',$phone)) {
			return false;
		}
		//判断是否PHPCMS请求的接口
		pc_base::load_app_func('global','sms');
		pc_base::load_app_class('smsapi', 'sms', 0);
		$this->sms_setting_arr = getcache('sms');
		$siteid = $_REQUEST['siteid'] ? $_REQUEST['siteid'] : 1;
		if(!empty($this->sms_setting_arr[$siteid])) {
			$this->sms_setting = $this->sms_setting_arr[$siteid];
		} else {
			$this->sms_setting = array('userid'=>'', 'productid'=>'', 'sms_key'=>'');
		}
		if($sms_key != $this->sms_setting['sms_key'] || $sms_pid != $this->sms_setting['productid']){
			return false;
		}
		//取用户名
		$msg_array = explode("@@",$str);
		$newpwd = $msg_array[1];
		$username = $msg_array[2];
		$array = $this->db->get_one(array('mobile'=>$phone,'username'=>$username));
		if(empty($array)){
			echo 1;
		}else{
			$result = $this->db->update(array('password'=>$newpwd),array('mobile'=>$phone,'username'=>$username));
			if($result){
				//修改成功，发送短信给用户回执
 				//检查短信余额
				if($this->sms_setting['sms_key']) {
					$smsinfo = $this->smsapi->get_smsinfo();
				}
				if($smsinfo['surplus'] < 1) {
 					echo 1;
				}else{
 					$this->smsapi = new smsapi($this->sms_setting['userid'], $this->sms_setting['productid'], $this->sms_setting['sms_key']);
					$content = '你好,'.$username.',你的新密码已经修改成功：'.$newpwd.' ,请妥善保存！';
					$return = $this->smsapi->send_sms($phone, $content, SYS_TIME, CHARSET);
					echo 1;
				}
 			}
		}
	}
	
	//手机短信方式找回密码
	public function public_forget_password_mobile ()
    {
		$step = intval($_POST['step']);
		$step = max($step,1);
		$this->_session_start();
		
		if(isset($_POST['dosubmit']) && $step==2)
        {
		    //处理提交申请，以手机号为准
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			//验证
			if(!is_username($_POST['username'])){
				showmessage(L('username_format_incorrect'), HTTP_REFERER);
			}
			$username = safe_replace($_POST['username']);

			$r = $this->db->get_one(array('username'=>$username),'userid,mobile');
			if($r['mobile']=='') {
				$_SESSION['mobile'] = '';
				$_SESSION['userid'] = '';
				$_SESSION['code'] = '';
				showmessage("该账号没有绑定手机号码，请选择其他方式找回！");
			}
			$_SESSION['mobile'] = $r['mobile'];
			$_SESSION['userid'] = $r['userid'];
			include template('member', 'forget_password_mobile');
		}
        elseif(isset($_POST['dosubmit']) && $step==3)
        {
			$sms_report_db = pc_base::load_model('sms_report_model');
			$mobile_verify = $_POST['mobile_verify'];
			$mobile = $_SESSION['mobile'];
			if($mobile)
            {
				if(!preg_match('/^1([0-9]{10})$/',$mobile)) exit('check phone error');
				pc_base::load_app_func('global','sms');
				$posttime = SYS_TIME-600;
				$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where,'id,id_code','id DESC');
				if($r && $r['id_code']==$mobile_verify)
                {
					$sms_report_db->update(array('id_code'=>''),$where);
					$userid = $_SESSION['userid'];
					$updateinfo = array();
					$password = random(8,"23456789abcdefghkmnrstwxy");
					$encrypt = random(6,"23456789abcdefghkmnrstwxyABCDEFGHKMNRSTWXY");
					$updateinfo['encrypt'] = $encrypt;
					$updateinfo['password'] = password($password, $encrypt);
					
					$this->db->update($updateinfo, array('userid'=>$userid));
					$rs = $this->db->get_one(array('userid'=>$userid),'phpssouid');
					$status = sendsms($mobile, $password, 5);
					if($status!==0) showmessage($status);
					$_SESSION['mobile'] = '';
					$_SESSION['userid'] = '';
					$_SESSION['code'] = '';
					showmessage("密码已重置成功！请查收手机",'?m=member&c=index&a=login');
				} else {
					showmessage("短信验证码错误！请重新获取！");
				}
			}else{
				showmessage("短信验证码已过期！请重新获取！");
			}
		} else {
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);
 			include template('member', 'forget_password_mobile');
		}
	}

	//通过用户名找回密码
	public function public_forget_password_username()
    {
		$step = intval($_POST['step']);
		$step = max($step,1);
		$this->_session_start();
		
		if(isset($_POST['dosubmit']) && $step==2)
        {
		    //处理提交申请，以手机号为准
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			//验证
			if(!is_username($_POST['username'])){
				showmessage(L('username_format_incorrect'), HTTP_REFERER);
			}
			$username = safe_replace($_POST['username']);

			$r = $this->db->get_one(array('username'=>$username),'userid,email');
			if($r['email']=='') {
				$_SESSION['userid'] = '';
				$_SESSION['code'] = '';
				showmessage("该账号没有绑定邮箱，请选择其他方式找回！");
			} else {
				$_SESSION['userid'] = $r['userid'];
				$_SESSION['email'] = $r['email'];
			}
			$_SESSION['emc'] = "";
			$_SESSION['emc_times']=0;
			$email_arr = explode('@',$r['email']);
			include template('member', 'forget_password_username');
		}
        elseif(isset($_POST['dosubmit']) && $step==3)
        {
			$sms_report_db = pc_base::load_model('sms_report_model');
			$mobile_verify = $_POST['mobile_verify'];
			$email = $_SESSION['email'];
			if($email)
            {
				if(!preg_match('/^([a-z0-9_]+)@([a-z0-9_]+).([a-z]{2,6})$/',$email)) exit('check email error');
				if($_SESSION['emc_times']=='' || $_SESSION['emc_times']<=0){
					showmessage("验证次数超过5次,验证码失效，请重新获取邮箱验证码！",HTTP_REFERER,3000);
				}
				$_SESSION['emc_times'] = $_SESSION['emc_times']-1;
				if($_SESSION['emc']!='' && $_POST['email_verify']==$_SESSION['emc'])
                {
					
					$userid = $_SESSION['userid'];
					$updateinfo = array();
					$password = random(8,"23456789abcdefghkmnrstwxy");
					$encrypt = random(6,"23456789abcdefghkmnrstwxyABCDEFGHKMNRSTWXY");
					$updateinfo['encrypt'] = $encrypt;
					$updateinfo['password'] = password($password, $encrypt);
					
					$this->db->update($updateinfo, array('userid'=>$userid));
					$rs = $this->db->get_one(array('userid'=>$userid),'phpssouid');
					$_SESSION['email'] = '';
					$_SESSION['userid'] = '';
					$_SESSION['emc'] = '';
					$_SESSION['code'] = '';
					pc_base::load_sys_func('mail');
					sendmail($email, '密码重置通知', "您在".date('Y-m-d H:i:s')."通过密码找回功能，重置了本站密码。");
					include template('member', 'forget_password_username');
					exit;
				} else {
					showmessage("验证码错误！请重新获取！",HTTP_REFERER,3000);
				}
			} else {
				showmessage("非法请求！");
			}
		} else {
 			include template('member', 'forget_password_username');
		}
	}

	//邮箱获取验证码
	public function public_get_email_verify()
    {
		pc_base::load_sys_func('mail');
		$this->_session_start();
		$code = $_SESSION['emc'] = random(8,"23456789abcdefghkmnrstwxy");
		$_SESSION['emc_times']=5;
		$message = '您的验证码为：'.$code;

		sendmail($_SESSION['email'], '邮箱找回密码验证', $message);
		echo '1';
	}

    /**
     *  上传头像处理
     *  传入头像压缩包，解压到指定文件夹后删除非图片文件
     */
    public function uploadavatar()
    {
        $avatar = pc_base::load_app_class('avatar');
        $avatar->uploadavatar($this->memberinfo['userid']);
    }

	/**
	 * 异步验证是否重复
	 */
	public function public_validate()
	{
		$result = false;
		if (isset($_POST['field']) && ! empty(trim($_POST['field']))) {
			$field = $_POST['field'] ? $_POST['field'] : '';
			$where = '`' . $field . '`="' . $_POST[$field] . '"';
			//更新排除自身验证
			$where .= (isset($_POST['except']) && ! empty($_POST['except'])) ? ' AND `userid` <>' . $_POST['except'] : '';
			$tmp = $this->db->count($where);
			$result = $tmp > 0 ? false : true;
		}
		exit($result);
	}

}
?>