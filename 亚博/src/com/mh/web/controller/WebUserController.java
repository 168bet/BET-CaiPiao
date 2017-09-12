package com.mh.web.controller;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.orm.Page;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.DesUtil;
import com.mh.commons.utils.MathUtil;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.CpOrder;
import com.mh.entity.WebBankHuikuan;
import com.mh.entity.WebBindEmail;
import com.mh.entity.WebUser;
import com.mh.entity.WebUserQuestion;
import com.mh.entity.WebUserWithdraw;
import com.mh.entity.WebWateRecord;
import com.mh.service.CpOrderService;
import com.mh.service.WebBankHuikuanService;
import com.mh.service.WebBindEmailService;
import com.mh.service.WebUserQuestionService;
import com.mh.service.WebUserService;
import com.mh.service.WebUserWithdrawService;
import com.mh.service.WebWateRecordService;
import com.mh.web.login.UserContext;
import com.mh.web.util.AgentUtil;
import com.mh.web.util.messageMail;

/**
 * 用户信息Controller
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2016-10-3 上午11:02:35<br/>
 */
@Controller
@RequestMapping("/user")
public class WebUserController extends BaseController{
	
	@Autowired
	private WebUserService webUserService;
	
	@Autowired
	private WebBindEmailService webBindEmailService;
	
	@Autowired
	private WebUserQuestionService  webUserQuestionService;
	
	@Autowired
	private CpOrderService cpOrderService;
	
	@Autowired
	private WebBankHuikuanService webBankHuikuanService;
	
	@Autowired
	private WebUserWithdrawService webUserWithdrawService;
	
	@Autowired
	private WebWateRecordService webWateRecordService ;
	
	
	/**
	 * 获取代理首页
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/getAgentIndex")
	public void getAgentIndex(HttpServletRequest request,HttpServletResponse response){
		try{
			UserContext uc = this.getUserContext(request);
			
			String beginTimeStr = request.getParameter("beginTimeStr");
			String endTimeStr = request.getParameter("endTimeStr");
			
			JSONObject all = new JSONObject();
			
			JSONObject totalObj = new JSONObject();
			//统计会员数
			WebUser webUser = new WebUser();
			webUser.setRelativePath(uc.getRelativePath());
			if(StringUtils.isNotBlank(beginTimeStr)){
				webUser.setBeginTimeStr(beginTimeStr);
			}
			if(StringUtils.isNotBlank(endTimeStr)){
				webUser.setEndTimeStr(endTimeStr);
			}
			int totalMember = this.webUserService.getWebUserTotal(webUser);
			totalObj.put("newMember", totalMember);
			//统计投注量
			CpOrder gameOrder = new CpOrder();
			gameOrder.setRelativePath(uc.getRelativePath());
			gameOrder.setEndTimeStr(endTimeStr);
			gameOrder.setBeginTimeStr(beginTimeStr);
			double betIncome = this.cpOrderService.getOrderTjXzje(gameOrder);
			totalObj.put("betIncome", betIncome);
			//充值量
			WebBankHuikuan huikuan = new WebBankHuikuan();
			huikuan.setRelativePath(uc.getRelativePath());
			huikuan.setEndTimeStr(endTimeStr);
			huikuan.setBeginTimeStr(beginTimeStr);
			double hkMoney = this.webBankHuikuanService.getWebBankHuikuanTj(huikuan);
			totalObj.put("hkMoney", hkMoney);
			//提现量
			WebUserWithdraw userWithdraw = new WebUserWithdraw();
			userWithdraw.setRelativePath(uc.getRelativePath());
			userWithdraw.setEndTimeStr(endTimeStr);
			userWithdraw.setBeginTimeStr(beginTimeStr);
			double withdrawMoney = this.webUserWithdrawService.getWebUserWithdrawTj(userWithdraw);
			totalObj.put("withdrawMoney", withdrawMoney);
			
			WebWateRecord webWateRecord = new WebWateRecord();
			webWateRecord.setRelativePath(uc.getRelativePath());
			webWateRecord.setEndTimeStr(endTimeStr);
			webWateRecord.setBeginTimeStr(beginTimeStr);
			double backWaterMoney = this.webWateRecordService.getWebUserWithdrawTj(webWateRecord);
			totalObj.put("backWaterMoney", backWaterMoney);
			
			//下注
			Map<String,Object> betMap = this.cpOrderService.getOrderTjList(gameOrder);
			JSONArray betArray = AgentUtil.getAgentArray(beginTimeStr, endTimeStr, betMap);
			all.put("bet", betArray);
			//提现
			Map<String,Object> drawMap = this.webUserWithdrawService.getWebUserWithdrawTjList(userWithdraw);
			JSONArray drawArray = AgentUtil.getAgentArray(beginTimeStr, endTimeStr, drawMap);
			all.put("draw", drawArray);
			//存款
			Map<String,Object> chargeMap = this.webBankHuikuanService.getWebBankHuikuanTjList(huikuan);
			JSONArray chargeArray = AgentUtil.getAgentArray(beginTimeStr, endTimeStr, chargeMap);
			all.put("draw", chargeArray);
			//返水
			Map<String,Object> pointMap = this.webWateRecordService.getWebUserWithdrawTjList(webWateRecord);
			JSONArray pointArray = AgentUtil.getAgentArray(beginTimeStr, endTimeStr, pointMap);
			all.put("point", pointArray);
			//会员数
			Map<String,Object> userMap = this.webUserService.getWebUserTotalList(webUser);
			JSONArray userArray = AgentUtil.getAgentArray(beginTimeStr, endTimeStr, userMap);
			all.put("user", userArray);
			
			all.put("total", totalObj);
			
			//团队人数
			int teamNum = this.webUserService.getTeamUserTotal(uc.getRelativePath());
			//团队余额
			double teamMoney = this.webUserService.getTeamUserMoney(uc.getRelativePath());
			all.put("teamNum", teamNum);
			all.put("teamMoney", teamMoney);
			
			ServletUtils.outPrintSuccess(request, response,all);
		}catch(Exception e){
			logger.error("获取代理首页失败",e);
			ServletUtils.outPrintFail(request, response, "获取代理首页失败");
		}
		
	}
	
	
	/**
	 * 修改返点
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/goBackPoint")
	public void goBackPoint(HttpServletRequest request,HttpServletResponse response){
		try{
	 
			String userName = request.getParameter("userName");
			
			if(StringUtils.isBlank(userName)){
				ServletUtils.outPrintFail(request, response, "返点用户不能为空");
				return;
				
			}
 
			UserContext uc = this.getUserContext(request);
			WebUser parentUser = this.webUserService.findWebrUseByUserName(uc.getUserName());
			double parentCpPoint = (parentUser.getCpPoint()==null?0:parentUser.getCpPoint());
			double parentPc28Point = (parentUser.getPc28Point()==null?0:parentUser.getPc28Point());
			
		
			WebUser childUser = this.webUserService.findWebrUseByUserName(userName);
			double childCpPoint = (childUser.getCpPoint()==null?0:childUser.getCpPoint());
			double childPc28Point = (childUser.getPc28Point()==null?0:childUser.getPc28Point());
		 
			JSONObject all = new JSONObject();
			
			JSONObject cpObj = new JSONObject();
			cpObj.put("name", "彩票返点");
			cpObj.put("point",childCpPoint);
			JSONArray cpArray = this.getBackPercentArray(parentCpPoint, childCpPoint);
			cpObj.put("list",cpArray);
			
			all.put("cp", cpObj);
			
			JSONObject cp28Obj = new JSONObject();
			cp28Obj.put("name", "28返点");
			cp28Obj.put("point",childPc28Point);
			JSONArray cp28Array = this.getBackPercentArray(parentPc28Point, childPc28Point);
			cp28Obj.put("list",cp28Array);
			all.put("pc28", cp28Obj);
			
			ServletUtils.outPrintSuccess(request, response,all);
		}catch(Exception e){
			ServletUtils.outPrintFail(request, response, "修改返点失败");
		}
		
	}
	
	

	
	
	
	/**
	 * 修改返点
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/doBackPoint")
	public void doBackPoint(HttpServletRequest request,HttpServletResponse response){
		try{
			UserContext uc = this.getUserContext(request);
			String pc28Point = request.getParameter("pc28Point");
			String cpPoint = request.getParameter("cpPoint");
			String userName = request.getParameter("userName");
			
			if(StringUtils.isBlank(pc28Point)){
				ServletUtils.outPrintFail(request, response, "28返点不能为空");
				return;
				
			}
			if(StringUtils.isBlank(cpPoint)){
				ServletUtils.outPrintFail(request, response, "彩票返点返点不能为空");
				return;
			}
			
			double _pc28Point = Double.valueOf(pc28Point);
			double _cpPoint = Double.valueOf(cpPoint);
			
			
			WebUser parentUser = this.webUserService.findWebrUseByUserName(uc.getUserName());
			double parentCpPoint = (parentUser.getCpPoint()==null?0:parentUser.getCpPoint());
			double parentPc28Point = (parentUser.getPc28Point()==null?0:parentUser.getPc28Point());
			
		
			WebUser childUser = this.webUserService.findWebrUseByUserName(userName);
			double childCpPoint = (childUser.getCpPoint()==null?0:childUser.getCpPoint());
			double childPc28Point = (childUser.getPc28Point()==null?0:childUser.getPc28Point());
			
			if(_pc28Point>parentPc28Point){
				ServletUtils.outPrintFail(request, response, "28返点不能>上一级返点");
				return;
			}
			if(_cpPoint>parentCpPoint){
				ServletUtils.outPrintFail(request, response, "彩票返点不能>上一级返点");
				return;
			}
			
			if(_pc28Point<childPc28Point){
				ServletUtils.outPrintFail(request, response, "28返点不能<自身返点");
				return;
			}
			if(_cpPoint<childCpPoint){
				ServletUtils.outPrintFail(request, response, "彩票返点不能<自身返点");
				return;
			}
			
			List<String> fieldList = new ArrayList<String>();
			List<Object> valList = new ArrayList<Object>();
			fieldList.add("pc28_point");
			valList.add(_pc28Point);
			
			fieldList.add("cp_point");
			valList.add(_cpPoint);
			fieldList.add("modify_time");
			valList.add(new Date());
			
			int rows = this.webUserService.updateWebUser(userName, fieldList, valList);
			if(rows>0){
				ServletUtils.outPrintSuccess(request, response,"修改返点成功");
				
			}else{
				ServletUtils.outPrintSuccess(request, response,"修改返点失败");
			}
		}catch(Exception e){
			ServletUtils.outPrintFail(request, response, "修改返点失败");
		}
		
	}
	
	
	
	/**
	 * 获取客户列表
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/getMemberList")
	public void getMemberList(HttpServletRequest request,HttpServletResponse response){
		try{
			UserContext uc = this.getUserContext(request);
			String fromMoney = request.getParameter("fromMoney");
			String toMoney = request.getParameter("toMoney");
			String userName = request.getParameter("userName");
			String days = request.getParameter("days");
 
			Page page = this.newPage(request);
			WebUser webUser = new WebUser();
			webUser.setUserAgent(uc.getUserName());
			if(StringUtils.isNotBlank(userName)){
				webUser.setUserName(userName);
			}
			if(StringUtils.isNotBlank(fromMoney)){
				webUser.setFromMoney(fromMoney);
			}
			if(StringUtils.isNotBlank(toMoney)){
				webUser.setToMoney(toMoney);
			}
			if(StringUtils.isNotBlank(days)){
				int _days = Integer.valueOf(days);
				Date currDate = new Date();
				Date beginDate = DateUtil.addDay(currDate, -_days);
				String beginTimeStr = DateUtil.formatDate(beginDate, DateUtil.YEAR_MONTH_DAY_PATTERN_MIDLINE);
				String endTimeStr =  DateUtil.formatDate(currDate, DateUtil.YEAR_MONTH_DAY_PATTERN_MIDLINE);
				webUser.setEndTimeStr(endTimeStr);
				webUser.setBeginTimeStr(beginTimeStr);
			}
			
			
			webUserService.findPage(page, webUser);
			JSONObject jsonObject = new JSONObject();
			jsonObject.put("totalCount", page.getTotalCount());
			jsonObject.put("pageNo", page.getPageNo());
			jsonObject.put("pageSize", page.getPageSize());
			jsonObject.put("totalPages", page.getTotalPages());
			jsonObject.put("result", page.getResult());
			
			ServletUtils.outPrintSuccess(request, response,jsonObject);
		}catch(Exception e){
			ServletUtils.outPrintFail(request, response, "获取客户列表失败");
		}
		
	}
	
	
	
	/**
	 * 修改登录密码
	 * @param request
	 * @param response
	 * @throws Exception
	 */
	@RequestMapping("/doLoginPassword")
	public void doLoginPassword(HttpServletRequest request,HttpServletResponse response){
		try{
			UserContext uc = this.getUserContext(request);
			if(uc==null){
				ServletUtils.outPrintFail(request, response, "用户尚未登录");
				return;
			}
			String oldPwd = request.getParameter("oldPwd");
			String newPwd1 = request.getParameter("newPwd1");
			String newPwd2 = request.getParameter("newPwd2");
			if(!newPwd1.equals(newPwd2)){
				ServletUtils.outPrintFail(request, response, "二次输入新登录密码不一致");
				return;
			}
			WebUser webUser = this.webUserService.findWebrUseByUserName(uc.getUserName());
			String cryptOldPassword = DesUtil.encrypt(oldPwd,CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
			if (!cryptOldPassword.equals(webUser.getUserPassword())) {
				ServletUtils.outPrintFail(request, response, "登录密码错误.");
				return;
			}
			String cryptPassword = DesUtil.encrypt(newPwd1,CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
			if(cryptPassword.equals(webUser.getUserPassword())){
				ServletUtils.outPrintFail(request, response, "修改密码不能与之前密码一致");
				return;
			}
			List<String> fieldList = new ArrayList<String>();
			List<Object> valList = new ArrayList<Object>();
			
			fieldList.add("last_user_password");
			valList.add(webUser.getUserPassword());
			
			fieldList.add("last_update_pwd_time");
			valList.add(new Date());
			
			
			fieldList.add("user_password");
			valList.add(cryptPassword);
			fieldList.add("modify_time");
			valList.add(new Date());
			
			
			int rows = this.webUserService.updateWebUser(uc.getUserName(), fieldList, valList);
			if(rows>0){
				ServletUtils.outPrintSuccess(request, response, "登录密码修改成功.");
			}else{
				ServletUtils.outPrintFail(request, response,"登录密码修改失败.请稍候再试或联系我们客服.");
			}
		}catch(Exception e){
			ServletUtils.outPrintFail(request, response, "修改登录密码错误");
			return;
		} 
	}
	
	
	
	
	/**
	 * 获取用户信息
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @throws Exception  
	 * void
	 */
	@RequestMapping("/getUserInfo")
	public void getUserInfo(HttpServletRequest request,HttpServletResponse response){
		try{
			UserContext uc = this.getUserContext(request);
			if(uc==null){
				ServletUtils.outPrintFail(request, response,"用户尚未登录");
				return;
			}
		
			 
			WebUser webUser = this.webUserService.findWebrUseByUserName(uc.getUserName());
			List<WebUserQuestion> list = this.webUserQuestionService.findUserName(uc.getUserName());
			JSONObject jsonObject = new JSONObject();
			jsonObject.put("userName", webUser.getUserName());
			jsonObject.put("userQq", webUser.getUserQq()==null?"": webUser.getUserQq());
			jsonObject.put("userMobile", webUser.getUserMobile()==null?"":webUser.getUserMobile());
			jsonObject.put("userMoney", webUser.getUserMoney()==null?0:webUser.getUserMoney());
			
			jsonObject.put("userMail", webUser.getUserMail()==null?"":webUser.getUserMail());
			jsonObject.put("isSetQA", list != null && list.size()>0?true:false);
			if(webUser.getBirthday()!=null){
				Calendar cal = Calendar.getInstance();
				cal.setTime(webUser.getBirthday());
				
				JSONObject birthObj = new JSONObject();
				birthObj.put("year", cal.get(Calendar.YEAR));
				birthObj.put("month", cal.get(Calendar.MONTH)+1);
				birthObj.put("day", cal.get(Calendar.DAY_OF_MONTH));
				jsonObject.put("birthday", birthObj);
				
			}
			
			jsonObject.put("userLastLoginTime", webUser.getUserLastLoginTime()==null?0:webUser.getUserLastLoginTime().getTime());
			jsonObject.put("userLastLoginIp", webUser.getUserLastLoginIp()==null?"":webUser.getUserLastLoginIp());
			jsonObject.put("mailStatus", webUser.getMailStatus()==null?0:webUser.getMailStatus());
			jsonObject.put("isTest", webUser.getIsTest()==null?0:webUser.getIsTest());
			jsonObject.put("pc28Point", webUser.getPc28Point()==null?0:webUser.getPc28Point());
			jsonObject.put("cpPoint", webUser.getCpPoint()==null?0:webUser.getCpPoint());
			jsonObject.put("isBandCard", webUser.getUserRealName()==null?0:1);
			
			ServletUtils.outPrintSuccess(request, response, jsonObject);
		 
		}catch(Exception e){
			logger.error("获取用户信息异常",e);
			ServletUtils.outPrintFail(request, response,"获取用户信息异常");
		}
	}
	
	
	
	
	
	/**
	 * 保存用户信息资料
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @throws Exception  
	 * void
	 */
	@RequestMapping("/doPersonalUpdate")
	public void doPersonalUpdate(HttpServletRequest request, HttpServletResponse response) throws Exception{
		
		 
		try{
			UserContext uc = this.getUserContext(request);
	 
			String userQq = request.getParameter("userQq");
			String userMail = request.getParameter("userMail");
			String userMobile = request.getParameter("userMobile");
			String year = request.getParameter("year");
			String month = request.getParameter("month");
			String day = request.getParameter("day");
			
			
			 
			List<String> fieldList = new ArrayList<String>();
			List<Object> valList = new ArrayList<Object>();
			if(!StringUtils.isBlank(userQq)){
				fieldList.add("user_qq");
				valList.add(userQq);
			}
			if(!StringUtils.isBlank(userMail)){
				fieldList.add("user_mail");
				valList.add(userMail);
			}
			if(!StringUtils.isBlank(userMobile)){
				fieldList.add("user_mobile");
				valList.add(userMobile);
			}
			
			
			if(StringUtils.isNumeric(year) && StringUtils.isNumeric(month) && StringUtils.isNumeric(day)){
				SimpleDateFormat sdf = new SimpleDateFormat("yyyy/MM/dd");
				Date birthDay = sdf.parse(year+'/'+month+'/'+day);
				fieldList.add("user_birthday");
				valList.add(birthDay);
			}
			
			int rows = this.webUserService.updateWebUser(uc.getUserName(), fieldList , valList);
			if(rows > 0){
				ServletUtils.outPrintSuccess(request, response, "保存个人资料成功");
			}else{
				ServletUtils.outPrintFail(request, response, "保存个人资料失败");
			}
		}catch(Exception e){
			e.printStackTrace();
			logger.error("个人资料保存异常", e);
			ServletUtils.outPrintFail(request, response, "个人资料保存异常.请稍候再试或联系我们客服.");
		}
		 
	
	}
	

	/**
	 * 修改安全密码
	 * @param request
	 * @param response
	 * @throws Exception
	 */
	@RequestMapping("/doSecurityPassword")
	public void doSecurityPassword(HttpServletRequest request,HttpServletResponse response) throws Exception {
		String oldWithdrawPwd = request.getParameter("oldWithdrawPwd");
		String newWithdrawPwd1 = request.getParameter("newWithdrawPwd1");//新安全密码
		String newWithdrawPwd2 = request.getParameter("newWithdrawPwd2");//确认新密码
		UserContext uc = this.getUserContext(request);
		
		try{
			if(!newWithdrawPwd1.equals(newWithdrawPwd2)){
				ServletUtils.outPrintFail(request, response, "二次输入新安全密码不一致");
				return;
			}
			
			WebUser webUser = this.webUserService.findWebrUseByUserName(uc.getUserName());
			
			String cryptOldPassword = DesUtil.encrypt(oldWithdrawPwd,CommonConstant.resCommMap.get(CommonConstant.APP_MONEY_DES_KEY));
			if (!cryptOldPassword.equals(webUser.getUserPassword())) {
				ServletUtils.outPrintFail(request, response, "新安全密码错误");
				return;
			}
 
			
			List<String> fieldList = new ArrayList<String>();
			List<Object> valList = new ArrayList<Object>();
			fieldList.add("last_withdraw_password");
			valList.add(webUser.getUserWithdrawPassword());
			
			fieldList.add("last_update_withdraw_pwd_time");
			valList.add(new Date());
			
			fieldList.add("user_withdraw_password");
			valList.add(cryptOldPassword);
			fieldList.add("modify_time");
			valList.add(new Date());
			
			
			int rows = this.webUserService.updateWebUser(uc.getUserName(), fieldList, valList);
			if(rows>0){
				ServletUtils.outPrintSuccess(request, response, "登录密码修改成功.");
			}else{
				ServletUtils.outPrintFail(request, response,"登录密码修改失败.请稍候再试或联系我们客服.");
			}
			
			
		} catch (Exception e) {
			e.printStackTrace();
			logger.error("修改资金密码异常",e);
			ServletUtils.outPrintFail(request, response,"资金密码修改失败.请稍候再试或联系我们客服.");
		}
		 
		

	}
	
	
	//绑定邮箱发送
		@RequestMapping("/doBindMail")
		public void doBindMail(HttpServletRequest request,HttpServletResponse response) throws Exception{
			UserContext uc = this.getUserContext(request);
			if(uc != null){
				String bindMail = request.getParameter("mail");
				String userName = uc.getUserName();
				Date sendDate = new Date();
				if(StringUtils.isNotBlank(bindMail))
				{
					String inner = "";
					String[] mails = bindMail.split("@");
					int length = mails[0].length();
					switch (length) 
					{
						case 2:
						case 3:
							inner = "*" + mails[0].substring(mails[0].length() -1 , mails[0].length());
							break;
						case 4:
						case 5:
						case 6:
							inner = "**" + mails[0].substring(mails[0].length() -2 , mails[0].length());
							break;
						case 7:
							inner = "****" + mails[0].substring(mails[0].length() -3 , mails[0].length());
							break;
						default:
							inner = "*****" + mails[0].substring(mails[0].length() -4 , mails[0].length());
							break;
					}
					try{
						SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
						WebBindEmail webBindEmail = this.webBindEmailService.selectWebBindEmail(uc.getUserName());
						List<Object> list = new ArrayList<Object>();
						int i;
						int in = 0;
						if(webBindEmail == null){//添加到临时表
							list.add(uc.getUserName());
							//list.add("admin9999");用来代替上一行作测试使用
							list.add(in);
							list.add(bindMail);
							list.add(format.format(sendDate));
							i = this.webBindEmailService.addEntity(list);
							list = null;
						}
						else if(1 == webBindEmail.getIsEnable()){
							ServletUtils.outPrintFail(request, response, "检测到邮箱已绑定状态");
							return;
						}else{//修改临时表
							list.add(bindMail);
							list.add(format.format(sendDate));
							list.add(uc.getUserName());
							//list.add("admin9999");用来代替上一行作测试使用
							i = this.webBindEmailService.updateBindEmail(list);
							list = null;
						}
						if(i < 0){
							ServletUtils.outPrintFail(request, response, "检测到邮箱失败");
							return;
						}
						String enUserName = DesUtil.encrypt(userName, CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
						String enBindMail = DesUtil.encrypt(bindMail, CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
						String enSendDate = DesUtil.encrypt(sendDate.toLocaleString(), CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
						String path = request.getContextPath();
						String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/user/doUpdateStatus"+ "?&userName="+enUserName+"&mail="+enBindMail+"&enSendDate="+java.net.URLEncoder.encode(enSendDate);
						StringBuffer text = new StringBuffer();
						text.append("HI，亲爱的");
						text.append(userName);
						text.append("用户你好。欢迎使用绑定功能，绑定邮箱后可增强账号安全性以及通过邮箱找回其他安全信息。请点击链接确认绑定邮箱：");
						text.append(basePath);
						text.append("  ");
						text.append("(该链接在24小时内有效，24小时候需要重新获取)");
						text.append("如果上面不是链接形式，请将地址复制到您的浏览器（例如IE）的地址栏再访问");
						text.append("感谢对我们的支持，希望您在平台得到愉悦的游戏体验。如果不是您本人的操作，您的账号可能存在安全风险，请尽快修改密码或联系客服。");
						text.append("请把发件人邮箱");
						text.append(CommonConstant.resCommMap.get("MY_MAIL"));
						text.append("加入白名单,以确保正常及时接收邮件，此为系统邮件请勿回复");
						messageMail  eMail = new messageMail();
						messageMail.main(CommonConstant.resCommMap.get("MY_MAIL"), CommonConstant.resCommMap.get("My_MAILPWD"), bindMail, text);//发送邮件
					}catch(Exception e){
						e.printStackTrace();
						logger.error("发送邮件失败！", e);
						ServletUtils.outPrintFail(request, response, "请查看发送邮件方法");
					}
					String StringMail = inner + mails[1];
					ServletUtils.outPrintSuccess(request, response, "验证邮件已发送至您的邮箱："+StringMail+"请验证邮件，打开邮件后点击链接完成邮箱绑定。您的激活链接在24小时内有效。");
				}else{
					ServletUtils.outPrintFail(request, response, "请输入邮箱");
				}
			}else{
				ServletUtils.outPrintFail(request, response, "请登录");
			}
			
		}
		
		
		
		//对方调用邮箱url接口访问此方法
		@RequestMapping("/doUpdateStatus")
		public void doUpdateStatus(HttpServletRequest request,HttpServletResponse response) throws Exception{
			SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			String utfUserName = request.getParameter("userName");//加密过的用户名
			String uftMail = request.getParameter("mail");//加密过的邮箱名
			String enSendDate = request.getParameter("enSendDate");
			try{
				String Date = DesUtil.decrypt(enSendDate, CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
				Date sendDate = sdf.parse(Date);
				Date nowDate = new Date();
				if((nowDate.getTime() - sendDate.getTime()) < (24*3600000)){
					String userName = DesUtil.decrypt(utfUserName, CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));//解密步骤
					String mail = DesUtil.decrypt(uftMail, CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));//解密步骤
					WebBindEmail webBindEmail = this.webBindEmailService.selectWebBindEmail(userName);
					if(webBindEmail == null || 1 == webBindEmail.getIsEnable()){//临时表  1 已经绑定，0未绑定
						ServletUtils.outPrintFail(request, response, "邮箱已绑定或用户名不存在");
						return;
					}
					int i;
					List<Object> list = new ArrayList<Object>();
					list.add(mail);
					list.add(1);
					list.add(new Date());
					list.add(userName);
					i = this.webBindEmailService.updateBindEmail(list);
					if(i < 0 ){
						ServletUtils.outPrintFail(request, response, "邮箱绑定失败");
						return;
					}
					
					WebUser webUser = this.webUserService.findWebrUseByUserName(userName);
					if(webUser != null && userName != null && webUser.getUserName().equals(userName)){
						if(webUser.getMailStatus() == 0 || webUser.getMailStatus() == null){//查询出来绑定的状态进行判断status   0未绑定    1绑定
							webUser.setMailStatus(1);
							List<String> fieldList = new ArrayList<String>();
							List<Object> valList = new ArrayList<Object>(); 
							fieldList.add("mail_status");//绑定的状态数据库字段
							fieldList.add("user_mail");//邮箱数据库字段
							valList.add(webUser.getMailStatus());
							valList.add(mail);
					 		i = this.webUserService.updateWebUser(userName, fieldList, valList);
					 		if(i > 0){
					 			ServletUtils.outPrintSuccess(request, response, "绑定邮箱成功");
					 		}else{
					 			ServletUtils.outPrintFail(request, response, "绑定邮箱失败");
					 		}
						}else{
							ServletUtils.outPrintFail(request, response, "用户已经绑定,不能重复绑定");
						}
					}else{
						ServletUtils.outPrintFail(request, response, "用户名有问题");
					}
				}else{
					ServletUtils.outPrintFail(request, response, "绑定超时");
				}
			}catch(Exception e){
				e.printStackTrace();
				logger.error("绑定异常", e);
				ServletUtils.outPrintFail(request, response, "绑定邮箱异常");
			}
			
		}
	
		public JSONArray getBackPercentArray(double maxRate,double minRate){
			 
			JSONArray jsonArray = new JSONArray();	 
			double p=minRate;
			while(p<=maxRate){				
				p = p+0.1;
				p=MathUtil.round(p, 1);
	 
				jsonArray.add(p);
			}	 
			return jsonArray;
		}
}
