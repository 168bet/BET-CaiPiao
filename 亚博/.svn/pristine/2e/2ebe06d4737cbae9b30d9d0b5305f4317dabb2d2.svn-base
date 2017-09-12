/**   
 * 文件名称: LogonController.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: alex<br/>  
 * 创建时间 : 2015-6-5 下午1:38:51<br/>
 */
package com.mh.web.login;

import java.io.BufferedReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.Enumeration;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.commons.lang3.RandomStringUtils;
import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.alibaba.fastjson.JSONObject;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.utils.CookieUtil;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.DesUtil;
import com.mh.commons.utils.IPSeeker;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.WebUser;
import com.mh.service.WebUserService;
import com.mh.web.controller.BaseController;
import com.mh.web.servlet.MySessionContext;
import com.mh.web.servlet.MyTokenSessionContext;
import com.mh.web.util.CheckDeviceUtil;

/**
 * 类描述: TODO<br/>
 * 用户登入验证Controller 创建人: TODO alex<br/>
 * 创建时间: 2015-6-5 下午1:38:51<br/>
 */
@SuppressWarnings("all")
@Controller
public class LogonController extends BaseController {

	private static final Logger logger = LoggerFactory.getLogger(LogonController.class);

	@Autowired
	private WebUserService webUserService;

	@Autowired(required = false)
	private List<UserContextAccessor> accessores;
	
	


	/**
	 * 用户登入
	 * 
	 * @param request
	 * @param response
	 * @throws IOException
	 * @throws Exception
	 */
	@RequestMapping("/login")
	public void login(HttpServletRequest request, HttpServletResponse response){

		Enumeration enumeration = request.getParameterNames();
		while (enumeration.hasMoreElements()) {
			String key = enumeration.nextElement().toString();
			if (!isLegal(key)) {
				ServletUtils.outPrintWithToken(request, response, "包含非法字符");
				return;
			}
			String val = request.getParameter(key);
			if (!isLegal(val)) {
				ServletUtils.outPrintWithToken(request, response, "包含非法字符");
				return;
			}
		}

 
		try {
 
			String loginName = request.getParameter("loginName");
			String password =  request.getParameter("password");

			if (StringUtils.isBlank(loginName)) {
				ServletUtils.outPrintFail(request, response, "请输入用户名");
				logger.info("用户名为空，返回登入界面");
				return;
			}
			if (StringUtils.isBlank(password)) {
				ServletUtils.outPrintFail(request, response, "请输入密码");
				logger.info("密码为空，返回登入界面");
				return;
			}
			try {
				password = DesUtil.encrypt(password, CommonConstant.resCommMap.get("app.client.des.key"));
			} catch (Exception e) {
				e.printStackTrace();
			}
			int userPsTimes =5;

			logger.info("根据用户名={} 密码={} 获取用户对象", loginName, password);
 
			WebUser webUser = this.webUserService.findWebrUseByUserName(loginName);

			List<String> fieldList = new ArrayList<String>();
			List<Object> valList = new ArrayList<Object>();
			Date currDate = new Date();
			if (webUser == null) {
				ServletUtils.outPrintFail(request, response, "帐号不存在!");
				return;
			}
			
 
			if (!CommonConstant.STATUS_USABLE.equals(String.valueOf(webUser.getUserStatus()))) {
				logger.info("用户 ID={} 的状态不可用", webUser.getUserStatus());
				ServletUtils.outPrintFail(request, response, "帐号已被冻结。请联系我们24小时在线客服！");
				return;
			}
			if (!webUser.getUserPassword().equals(password)) {// 密码错误
				String warn = "";

				String lastTimeStr = DateUtil.format(webUser.getModifyTime(), "yyyy-MM-dd");
				String currDateStr = DateUtil.format(new Date(), "yyyy-MM-dd");
				if (!currDateStr.equals(lastTimeStr)) {
					webUser.setUserPsTimes(0);
				}

				int userHasPsTimes = 0;// 密码输入错误的次数
				if (webUser.getUserPsTimes() != null) {
					userHasPsTimes = webUser.getUserPsTimes().intValue();
				}
				userHasPsTimes++;
				if (userHasPsTimes >= userPsTimes) {// 冻结帐号
					webUser.setUserStatus(0);
					warn = "密码输入错误超过限制，冻结被帐号。请联系我们24小时在线客服！";
					fieldList.add("user_status");
					valList.add(0);
				} else {
					warn = "密码输入错误，超过" + userPsTimes + "次将被冻结。目前第" + (userHasPsTimes) + "次";
				}
				fieldList.add("modify_time");
				fieldList.add("user_ps_times");
				valList.add(currDate);
				valList.add(userHasPsTimes);

				this.webUserService.updateWebUser(webUser.getUserName(), fieldList, valList);
				ServletUtils.outPrintFail(request, response, warn);
				logger.info(warn);
				return;
			} else {
				int userHasPsTimes = 0;// 密码输入错误的次数
				if (webUser.getUserPsTimes() != null) {
					userHasPsTimes = webUser.getUserPsTimes().intValue();
				}
				if (userHasPsTimes != 0) {// 清空密码输入错误次数
					fieldList.add("user_ps_times");
					valList.add(0);
					this.webUserService.updateWebUser(webUser.getUserName(), fieldList, valList);
				}
			}
		 

			// 已经登入不在绑定上下文
			if (MySessionContext.getSession(request.getSession().getId()) != null) {
				UserContext uc = (UserContext) request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
				if (uc != null && uc.getUserId() != null) {
					ServletUtils.outPrintSuccess(request, response, "登入成功");
					clearVerify(request);
					logger.info("用户已经登入过，不在绑定用户信息，直接返回主页");
					return;
				}
			}

			if (MySessionContext.getSession(webUser.getUserSessionId()) != null) {
				HttpSession oldSession = MySessionContext.getSession(webUser.getUserSessionId());
				try {
					if (oldSession.getAttribute(CommonConstant.USER_CONTEXT_KEY) != null) {
						// 移除session
						// TODO
						oldSession.removeAttribute(CommonConstant.USER_CONTEXT_KEY);
						// oldSession.removeAttribute(CommonConstant.VERITY_CODE_KEY);
						MySessionContext.delSession(oldSession);
					}
				} catch (Exception e) {
					e.printStackTrace();
				}
			}

			// 新增myTokenSession容器记录
			if (MyTokenSessionContext.hashUserSession(loginName)) {
				MyTokenSessionContext.delMySession(loginName);
			}
			if (MyTokenSessionContext.hasUserClientTokenKey(loginName)) {
				MyTokenSessionContext.delMyClientToken(loginName);
			}
			if (MyTokenSessionContext.sessionUser.containsKey(loginName)) {
				MyTokenSessionContext.sessionUser.remove(loginName);
			}

			try {
				request.getSession().invalidate();// 清除之前的session创建新的
			} catch (Exception e) {
			}

			// 限制同时只能一个登陆
			MySessionContext.addSession(request.getSession());
			MyTokenSessionContext.addMySession(loginName, request.getSession());

			this.doLogon(request, webUser);
			int rows = this.updateUser(webUser, request, response);
			if(rows>0){
				String mop = RandomStringUtils.randomAlphanumeric(16);
				//保存cookie
				int maxAge=24*60*60*1;
				CookieUtil.addCookie(response,CommonConstant.USER_COOKIE_KEY, mop, maxAge);
				JSONObject obj = new JSONObject();
				obj.put("mop", mop);
				obj.put("userName", webUser.getUserName());

				ServletUtils.outPrintSuccess(request, response,obj);
			}else{
				ServletUtils.outPrintFail(request, response, "用户登入失败!");
			}

		} catch (Exception e) {
			e.printStackTrace();
			logger.error("用户登入出现异常: " + e.getMessage(), e);
			ServletUtils.outPrintFail(request, response, "用户登入出现异常!");
		}
 
	}

	/**
	 * 退出登入
	 * 
	 * @param request
	 * @param response
	 */
	@RequestMapping("/loginOut")
	public void loginOut(HttpServletRequest request, HttpServletResponse response) {
		try {

			if (MySessionContext.getSession(request.getSession().getId()) != null) {
				UserContext uc = (UserContext) request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
				if (uc != null && uc.getUserId() != null) {
					logger.info("用户{} 退出登入", uc.getUserId());
				}
				MySessionContext.getSession(request.getSession().getId()).removeAttribute(CommonConstant.USER_CONTEXT_KEY);
				MySessionContext.getSession(request.getSession().getId()).removeAttribute(CommonConstant.VERITY_CODE_KEY);
			}
			MySessionContext.delSession(request.getSession());
			request.getSession().invalidate();
			ServletUtils.outPrintSuccess(request, response);

		} catch (RuntimeException e) {
			logger.error("用户退出登入异常: " + e.getMessage(), e);
			ServletUtils.outPrintFail(request, response, "用户退出登入出现异常");
		}
	}

	/**
	 * 验证用户是否登录 方法描述: TODO</br>
	 * 
	 * @param request
	 * @param response
	 *            void
	 */
	@RequestMapping("/valid/checkUserLogin")
	public void checkUserLogin(HttpServletRequest request, HttpServletResponse response) {
		try {
			if (MySessionContext.getSession(request.getSession().getId()) != null) {
				UserContext uc = (UserContext) request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
				if (uc != null && uc.getUserId() != null) {
					ServletUtils.outPrintSuccess(request, response, "用户已登录");
					return;
				}
			}
			ServletUtils.outPrintFail(request, response, "用户未登陆");
		} catch (RuntimeException e) {
			logger.error("用户退出登入异常: " + e.getMessage(), e);
			ServletUtils.outPrintFail(request, response, "验证登录异常");
		}
	}

	/**
	 * 
	 * 功能说明: 登入操作
	 * 
	 * @param request
	 * @param userId
	 *            void
	 * 
	 */
	public void doLogon(HttpServletRequest request, WebUser user) {
		if (user == null)
			throw new IllegalArgumentException("用户不能为空");
		UserContext uc = (UserContext) request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
		if (uc != null && uc.getUserId().equals(user.getId()))
			return;
		bind(user, request);
	}

	/**
	 * 更新用户登入信息
	 * 
	 * @param user
	 * @param request
	 */
	private int updateUser(WebUser user, HttpServletRequest request, HttpServletResponse response) {
		logger.info("更新用户登入信息");

		// user.setUserLastLoginIp(IPSeeker.getIpAddress(request));//
		// 本次登录IP登录下来，供下次查看
		// user.setUserLastLoginDomain(this.getUserLoginDomain(request));//
		// 本次登录的域名
		// user.setUserLastLoginTime(new Date());// 本次登录时间记录下来，供下次查看
		// user.setUserLoginTimes(user.getUserLoginTimes() + 1);
		// user.setModifyTime(new Date());
		// user.setUserPsTimes(0);
		// user.setUserSessionId(request.getSession().getId());
		// user.setUserLoginStatus("1");
		// user.setUserLogonTime(new Date());

		List<String> fieldList = new ArrayList<String>();
		List<Object> valList = new ArrayList<Object>();
		Date currDate = new Date();
		fieldList.add("user_last_login_ip");
		fieldList.add("user_last_login_domain");
		fieldList.add("user_last_login_time");
		fieldList.add("user_login_times");
		fieldList.add("modify_time");
		fieldList.add("user_ps_times");
		fieldList.add("user_session_id");
		fieldList.add("login_device");

		valList.add(IPSeeker.getIpAddress(request));
		valList.add(this.getUserLoginDomain(request));
		valList.add(currDate);
		valList.add((user.getUserLoginTimes()==null?0:user.getUserLoginTimes()) + 1);
		valList.add(currDate);
		valList.add(0);
		valList.add(request.getSession().getId());
		valList.add(CheckDeviceUtil.checkDevice(request));
		int rows = this.webUserService.updateWebUser(user.getUserName(), fieldList, valList);
		return rows;

	}

	/**
	 * 绑定用户上下文数据到session中
	 * 
	 * @param user
	 * @param request
	 */
	private void bind(WebUser user, HttpServletRequest request) {
		if (null == user)
			throw new RuntimeException("待载入缓存的用户对象为空错误！");
		logger.info("用户登入验证通过，开始绑定用户到Session中");

		UserContext uc = new UserContext();
		try {
			uc.setUserId(user.getId());
			uc.setUserName(user.getUserName());
			uc.setLastLogonTime(user.getUserLastLoginTime());
			uc.setIp(user.getUserLastLoginIp());
			uc.setUserType(user.getUserType());
			uc.setUserMemberType(user.getUserType());
			uc.setUserMoney(user.getUserMoney());
			uc.setUserAgent(user.getUserAgent());
			uc.setRelativePath(user.getRelativePath());
			uc.setIsTest(user.getIsTest());
			// 绑定用户权限到用户上下文
			this.bindCustomDatas(uc);
		} catch (RuntimeException e) {
			logger.error("绑定用户上下文数据出现异常：", e);
			throw new RuntimeException(e);
		}

		logger.info("绑定用户到Session中结束");
		uc.setSessionId(request.getSession().getId());
		MySessionContext.getSession(request.getSession().getId()).setAttribute(CommonConstant.USER_CONTEXT_KEY, uc);
	}

	/**
	 * 绑定jar包外部用户定义数据到Session
	 * 
	 * @param uc
	 */
	private void bindCustomDatas(UserContext uc) {
		if (this.accessores != null && this.accessores.size() > 0) {
			for (UserContextAccessor accessor : accessores) {
				if (accessor != null)
					accessor.addCustomDatas(uc);
			}
		}
	}

	/**
	 * 检查验证码是否正确
	 * 
	 * @param request
	 * @param response
	 * @return
	 */
	private boolean checkVerify(HttpServletRequest request, HttpServletResponse response) {
		// 验证码
		String verifycode = request.getParameter("verifycode");
		if (StringUtils.isBlank(verifycode)) {
			ServletUtils.outPrintWithToken(request, response, "请输入验证码");
			return false;
		}

		Object code = null;
		if (MySessionContext.getSession(request.getSession().getId()) != null) {
			code = MySessionContext.getSession(request.getSession().getId()).getAttribute(CommonConstant.VERITY_CODE_KEY);
		}

		if (code == null) {
			ServletUtils.outPrintWithToken(request, response, "登入超时，请重新登入");
			logger.info("Session 中没有验证码信息 返回页面 重新获取验证码");
			return false;
		}

		if (!verifycode.equalsIgnoreCase(code.toString())) {
			ServletUtils.outPrintWithToken(request, response, "验证码错误");
			return false;
		}
		return true;
	}

	/**
	 * 清除验证码
	 * 
	 * @param request
	 */
	private void clearVerify(HttpServletRequest request) {
		logger.info("清除Session中验证码");

		MySessionContext.getSession(request.getSession().getId()).removeAttribute(CommonConstant.VERITY_CODE_KEY);
		request.getSession().removeAttribute(CommonConstant.VERITY_CODE_KEY);
	}
	
	public static void main(String[] args) {
		String str = "loginName=nihaoma&password=123qwe";
		String loginName = StringUtils.substringBetween(str, "loginName=", "&");
		String password = StringUtils.substringAfter(str, "&password=");
		System.out.println(password);
		
	}

}
