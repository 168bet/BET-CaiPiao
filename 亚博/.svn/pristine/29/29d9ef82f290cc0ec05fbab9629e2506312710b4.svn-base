/**   
 * 文件名称: WebFinanceController.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: alex<br/>  
 * 创建时间 : 2015-7-2 上午10:08:05<br/>
 */
package com.mh.web.controller;

import java.io.IOException;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.ModelAndView;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mh.commons.cache.MemCachedUtil;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.conf.CpConfigCache;
import com.mh.commons.constants.WebConstants;
import com.mh.commons.orm.Page;
import com.mh.commons.utils.ComUtil;
import com.mh.commons.utils.CommonUtils;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.DesUtil;
import com.mh.commons.utils.IPSeeker;
import com.mh.commons.utils.OrderNoUtils;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.TWebUserBank;
import com.mh.entity.WebBankCode;
import com.mh.entity.WebBankHuikuan;
import com.mh.entity.WebConfig;
import com.mh.entity.WebKjPay;
import com.mh.entity.WebRecords;
import com.mh.entity.WebUser;
import com.mh.entity.WebUserType;
import com.mh.entity.WebUserWithdraw;
import com.mh.service.WebBankHuikuanService;
import com.mh.service.WebConfigService;
import com.mh.service.WebKjPayService;
import com.mh.service.WebRecordService;
import com.mh.service.WebUserBankService;
import com.mh.service.WebUserService;
import com.mh.service.WebUserTypeService;
import com.mh.service.WebUserWithdrawService;
import com.mh.web.login.UserContext;

/**
 * 类描述: TODO<br/>
 * 财务管理 创建人: TODO alex<br/>
 * 创建时间: 2015-7-2 上午10:08:05<br/>
 */
@SuppressWarnings("all")
@Controller
@RequestMapping("/member")
public class WebFinanceController extends BaseController {

	@Autowired
	private WebUserService webUserService;

	@Autowired
	private WebBankHuikuanService webBankHuikuanService;

	@Autowired
	private WebUserWithdrawService webUserWithdrawService;

	@Autowired
	private WebConfigService webConfigService;

	@Autowired
	private WebRecordService webRecordService;

	@Autowired
	private WebKjPayService webPayPicService;

	@Autowired
	private WebUserTypeService webUserTypeService;

	@Autowired
	private WebUserBankService webUserBankService;

	/**
	 * 查询财务记录 方法描述: TODO</br>
	 * 
	 * @param request
	 * @param response
	 * @param records
	 * @return ModelAndView
	 */
	@SuppressWarnings("rawtypes")
	@RequestMapping("/goList")
	public ModelAndView goList(HttpServletRequest request, HttpServletResponse response, WebRecords records) {
		String code = request.getParameter("code");

		String flatName = request.getParameter("flatName");
		if (!StringUtils.isEmpty(code)) {
			records.setCode(code);
		} else {
			records.setCode("withdrawHistory");
		}
		UserContext uc = this.getUserContext(request);
		records.setUserName(uc.getUserName());
		Date currDate = DateUtil.currentDate();
		String currDateStr = DateUtil.format(currDate, "yyyy-MM-dd");
		if (StringUtils.isEmpty(records.getStartTime())) {
			Date nextDate = DateUtil.addDay(currDate, -30);
			String nextDateStr = DateUtil.format(nextDate, "yyyy-MM-dd");
			records.setStartTime(nextDateStr);
		}

		if (StringUtils.isEmpty(records.getEndTime())) {
			records.setEndTime(currDateStr);
		}

		Page page = this.newPage(request);

		webRecordService.findFinancePage(page, records);

		return new ModelAndView("member/account/" + code).addObject(CommonConstant.PAGE_KEY, page).addObject("records", records).addObject("flatParms", null).addObject("flatName", flatName);
	}

	/**
	 * 跳转到账户充值页面 方法描述: TODO</br>
	 * 
	 * @param request
	 * @param response
	 * @return ModelAndView
	 */
	@RequestMapping("/payInfo")
	public ModelAndView payInfo(HttpServletRequest request, HttpServletResponse response) {
		return new ModelAndView("member/account/pay_info");
	}

	/**
	 * 方法描述: 在线支付</br> 创建人: zoro<br/>
	 * 
	 * @param request
	 * @param response
	 * @return ModelAndView
	 */
	@RequestMapping("/payOnline")
	public ModelAndView payOnline(HttpServletRequest request, HttpServletResponse response) {
		return new ModelAndView("member/account/pay_online");
	}

	

	/**
	 * 跳转至用户信息
	 * 
	 * @param request
	 * @param response
	 * @return
	 * @throws SQLException
	 * @throws IOException
	 */
	@RequestMapping("/goUserInfo")
	public ModelAndView goUserInfo(HttpServletRequest request, HttpServletResponse response) {
		UserContext uc = this.getUserContext(request);
		WebUser webUser = this.webUserService.findWebrUseByUserName(uc.getUserName());
		String qq = webUser.getUserQq();
		String mail = webUser.getUserMail();
		String mobile = webUser.getUserMobile();
		if (StringUtils.isNotBlank(mail)) {
			String inner = "";
			String[] mails = mail.split("@");
			int length = mails[0].length();
			switch (length) {
			case 2:
			case 3:
				inner = "*" + mails[0].substring(mails[0].length() - 1, mails[0].length());
				break;
			case 4:
			case 5:
			case 6:
				inner = "**" + mails[0].substring(mails[0].length() - 2, mails[0].length());
				break;
			case 7:
				inner = "****" + mails[0].substring(mails[0].length() - 3, mails[0].length());
				break;
			default:
				inner = "*****" + mails[0].substring(mails[0].length() - 4, mails[0].length());
				break;
			}
			webUser.setUserMail(inner + mails[1]);
		}
		if (StringUtils.isNotBlank(qq)) {
			webUser.setUserQq("****" + qq.substring(qq.length() - 4, qq.length()));
		}
		if (StringUtils.isNotBlank(mobile)) {
			webUser.setUserMobile("********" + mobile.substring(mobile.length() - 3, mobile.length()));
		}
		WebUserType userType = webUserTypeService.getUserTypeById(webUser.getUserType());
		ModelAndView model = new ModelAndView("member/account/userinfo");
		return model.addObject("webUser", webUser).addObject("userType", userType);
	}

	/**
	 * 跳转到申请提款页面 方法描述: TODO</br>
	 * 
	 * @param request
	 * @param response
	 * @return ModelAndView
	 */
	@RequestMapping("/goWithdraw")
	public ModelAndView goWithdraw(HttpServletRequest request, HttpServletResponse response) {
		ModelAndView view = new ModelAndView();
		String url = "member/account/withdraw";
		UserContext uc = this.getUserContext(request);
		WebUser user = this.webUserService.findWebrUseByUserName(uc.getUserName());
		// 判断出款银行卡是否设置
		if (null != user && StringUtils.isEmpty(user.getUserBankCard())) {
			url = "member/account/bank_info";
		} else {
			// 判断打码量
			/*
			 * TWebDama webDama = new TWebDama();
			 * webDama.setUserName(uc.getUserName()); webDama =
			 * this.webRecordService.findWebDama(webDama); if(null !=webDama){
			 * WebRecords records = new WebRecords();
			 * records.setUserName(uc.getUserName()); List<Map<String, Object>>
			 * list = webRecordService.btReport(records); double total = 0.0;
			 * for(int i=0;i<list.size();i++){ total = total +
			 * NumberUtils.toDouble
			 * (String.valueOf(list.get(i).get("betIncome")), 0d); }
			 * webDama.setCurUserDama(total); if (total <
			 * webDama.getDmReqDm().doubleValue()) {// 打码量不够 url =
			 * "member/account/dama"; view.addObject("dama", webDama); } }
			 */
		}

		view.addObject("webUser", user);
		view.setViewName(url);
		return view;
	}

	/***
	 * 保存银行卡信息 方法描述: TODO</br> 创建人: zoro<br/>
	 * 
	 * @param request
	 * @param response
	 * @param webUser
	 * @throws Exception
	 *             void
	 */
	@RequestMapping("/saveBackInfo")
	public void saveBackInfo(HttpServletRequest request, HttpServletResponse response, WebUser webUser) {
		try {
			UserContext uc = this.getUserContext(request);
			WebUser ruser = this.webUserService.findWebrUseByUserName(uc.getUserName());
			/*
			 * if(ruser!=null && ruser.getUserBankCard()!=null &&
			 * !"".equals(ruser.getUserBankCard())){
			 * ServletUtils.outPrintFail(request, response, "绑定失败，请联系客服!");
			 * return; }
			 */

			String cryptPassword = DesUtil.encrypt(webUser.getUserWithdrawPassword(), CommonConstant.resCommMap.get("app.money.des.key"));
			String optInfo = "";
			if (!StringUtils.equalsIgnoreCase(cryptPassword, ruser.getUserWithdrawPassword())) {
				ServletUtils.outPrintFail(request, response, "资金密码错误!");
				return;
			} else {
				List<String> fieldList = new ArrayList<String>();
				List<Object> valList = new ArrayList<Object>();
				fieldList.add("user_bank_type");
				fieldList.add("user_bank_address");
				fieldList.add("user_bank_card");
				valList.add(webUser.getUserBankType());
				valList.add(webUser.getUserBankAddress());
				valList.add(webUser.getUserBankCard());
				this.webUserService.updateWebUser(uc.getUserName(), fieldList, valList);
				ServletUtils.outPrintSuccess(request, response, "绑定成功!", optInfo);
			}
		} catch (Exception e) {
			e.printStackTrace();
			logger.error("绑定银行卡失败", e);
			ServletUtils.outPrintFail(request, response, "收款银行信息设置失败.请稍候再试或联系我们客服更新！");
		}
	}

	/***
	 * 绑定银行卡 方法描述: TODO</br> 创建人: zoro<br/>
	 * 
	 * @param request
	 * @param response
	 * @param webUser
	 * @throws Exception
	 *             void
	 */
	@RequestMapping("/bindBankCard")
	public void bindBankCard(HttpServletRequest request, HttpServletResponse response, TWebUserBank bank) {
		try {
			
			if(StringUtils.isBlank(bank.getProvince())){
				ServletUtils.outPrintFail(request, response, "请选择所在省份");
				return;
			}
			if(StringUtils.isBlank(bank.getCity())){
				ServletUtils.outPrintFail(request, response, "请选择所在市");
				return;
			}
			if(StringUtils.isBlank(bank.getSubBranch())){
				ServletUtils.outPrintFail(request, response, "请填写支行名称");
				return;
			}
			if(StringUtils.isBlank(bank.getBankAddress())){
				ServletUtils.outPrintFail(request, response, "请填写银行地址");
				return;
			}
			if(StringUtils.isBlank(bank.getBankAddress())){
				ServletUtils.outPrintFail(request, response, "请填写开户人");
				return;
			}
			if(StringUtils.isBlank(bank.getBankCard())){
				ServletUtils.outPrintFail(request, response, "请填写银行卡号");
				return;
			}
			
			String withDrawPwd = request.getParameter("withDrawPwd");
			if(StringUtils.isBlank(withDrawPwd)){
				ServletUtils.outPrintFail(request, response, "请填写安全密码");
				return;
			}
			
			
			boolean isExist = this.webUserBankService.isExistBankCard(bank.getBankCard());
			if (isExist) {
				ServletUtils.outPrintFail(request, response, "该银行卡号已存在!");
				return;
			}
			Map<String,String> bankCodeMap = new HashMap<String,String>();
			List<WebBankCode> bankCodeList = CpConfigCache.BANK_CODE_LIST;
			WebBankCode webBankCode = null;
			for(int i=0;i<bankCodeList.size();i++){
				webBankCode = bankCodeList.get(i);
				bankCodeMap.put(webBankCode.getBankCode(), webBankCode.getBankName());
			}
			String bankName = "";
			if(bankCodeMap.get(bank.getBankCode())!=null){
				bankName = bankCodeMap.get(bank.getBankCode());
			}
			bank.setBankType(bankName);
			
			
			UserContext uc = this.getUserContext(request);
			WebUser user = this.webUserService.findWebrUseByUserName(uc.getUserName());
			if(user!=null && user.getUserRealName()!=null && !"".equals(user.getUserRealName())){
				if(!user.getUserRealName().equals(bank.getUserRealName())){
					ServletUtils.outPrintFail(request, response, "开户人姓名不一致！");
					return;
				}
			}else{
				List<String> fieldList = new ArrayList<String>();
				fieldList.add("user_real_name");
				List<Object> valList = new ArrayList<Object>();
				valList.add(bank.getUserRealName());
				
				
				this.webUserService.updateWebUser(uc.getUserName(), fieldList, valList);
			}
			
			
			
			String cryptPassword = DesUtil.encrypt(withDrawPwd, CommonConstant.resCommMap.get("app.money.des.key"));
			String optInfo = "";
			if (!StringUtils.equalsIgnoreCase(cryptPassword, user.getUserWithdrawPassword())) {
				ServletUtils.outPrintFail(request, response, "资金密码错误!");
				return;
			} else {
				bank.setIsEnable(1);
				bank.setUserName(uc.getUserName());
				bank.setCreateTime(new Date());
				bank.setModifyTime(new Date());
				this.webUserBankService.saveUserBankCard(bank);
				ServletUtils.outPrintSuccess(request, response, "绑定成功!", optInfo);
			}
		} catch (Exception e) {
			e.printStackTrace();
			logger.error("绑定银行卡失败", e);
			ServletUtils.outPrintFail(request, response, "收款银行信息设置失败.请稍候再试或联系我们客服更新！");
		}
	}

	/**
	 * 提款方法
	 * 
	 * @param request
	 * @param response
	 * @param code
	 *            void
	 */
	@RequestMapping("/drawMoney")
	public synchronized void drawMoney(HttpServletRequest request, HttpServletResponse response, @RequestParam("money") Double money, @RequestParam("withDrawPwd") String userWithdrawPassword) {
		WebUser user = null;
		
		try {
			boolean isExist = this.webUserBankService.isExistBankCard(null);
			
			UserContext uc = this.getUserContext(request);
			user = this.webUserService.findWebrUseByUserName(uc.getUserName());
			double userMoney = 0;
			if (user != null && user.getUserMoney() != null) {
				userMoney = user.getUserMoney().doubleValue();
			}

			if (!isExist) {
				ServletUtils.outPrintFail(request, response, "请绑定银行卡!");
				return;
			}

			/** 资金密码判断 **/
			String cryptPassword = DesUtil.encrypt(userWithdrawPassword, CommonConstant.resCommMap.get("app.money.des.key"));
			if (!StringUtils.equalsIgnoreCase(cryptPassword, user.getUserWithdrawPassword())) {
				ServletUtils.outPrintFail(request, response, "资金密码错误!");
				return;
			}

			/** 判断取款金额是否超过主帐号余额 **/
			if (money.doubleValue() > userMoney) {
				ServletUtils.outPrintFail(request, response, "提款金额不能大于总帐户余额！");
				return;
			}

			int totalTimes = 1;
			int dayTimes = 1;

			WebUserWithdraw withdraw = new WebUserWithdraw();
			withdraw.setUserName(user.getUserName());
			withdraw.setBeginTimeStr(DateUtil.todayBegin());// 美东时间(今天)

			Map<String, Integer> map = this.webUserWithdrawService.countWithdrawSuccessTimes(withdraw);

			if (null != map.get("totalTimes") && map.get("totalTimes") > 0) {
				totalTimes = map.get("totalTimes") + 1;
			}
			if (null != map.get("dayTimes") && map.get("dayTimes") > 0) {
				dayTimes = map.get("dayTimes") + 1;
			}

			/** 保存取款申請記錄及扣减主帐号金额 **/
			Integer bankId = Integer.valueOf(request.getParameter("bankId"));
			withdraw.setGmt4Time(DateUtil.getGMT_4_Date());
			withdraw.setTotalTimes(totalTimes);
			withdraw.setDayTimes(dayTimes);

		 
			TWebUserBank webUserBank = this.webUserBankService.getBankCardById(bankId);
			if(webUserBank==null){
				ServletUtils.outPrintFail(request, response, "提款银行信息不存在");
				return;
			}

			withdraw.setUserRealName(user.getUserRealName());
			withdraw.setUserBankInfo(webUserBank.getBankType() + "|" + webUserBank.getBankCard() + "|" + webUserBank.getBankAddress());
			withdraw.setUserWithdrawMoney(money);
			withdraw.setStatus(WebConstants.T_WEB_USER_WITHDRAW_STATUS_0);
			withdraw.setCheckStatus(WebConstants.T_WEB_USER_WITHDRAW_CHECKED_STATUS_0);

			Date now = new Date();
			withdraw.setModifyTime(now);
			withdraw.setCreateTime(now);
			withdraw.setUserOrder(OrderNoUtils.getOrderNo(""));
			withdraw.setWithdrawType(WebConstants.T_WEB_MA_TYPE_11);// 会员提款
			withdraw.setGmt4Time(DateUtil.getGMT_4_Date());

			boolean reFlag = this.webUserWithdrawService.saveWebUserWithdraw(withdraw);
			if (reFlag) {
				/** 触发通知 **/
				MemCachedUtil.setWithdrawNotice(user.getUserFlag());
				String optInfo = "提款申请成功！财务部门将在审核过后，将您的提款金额存入您的提款账号中！您也可以到会员中心【提款记录】里查询您的提款状态！";
				ServletUtils.outPrintSuccess(request, response, optInfo);
			} else {
				ServletUtils.outPrintFail(request, response, "您好,提款申请功能维护中，请稍候再试或联系我们客服处理！");
			}
		} catch (Exception e) {
			try {
				MemCachedUtil.setWithdrawNotice(user.getUserFlag());
			} catch (ParseException e1) {
				e1.printStackTrace();
			}
			e.printStackTrace();
			logger.error("提款异常", e);
			ServletUtils.outPrintFail(request, response, "您好,提款申请功能维护中，请稍候再试或联系我们客服处理！");
		}
	}

	/**
	 * 获取第三方支付列表
	 * 
	 * @param request
	 * @param response
	 */
	@RequestMapping("/getThreePayList")
	public void getThreePayList(HttpServletRequest request, HttpServletResponse response) {
		try {
			List<WebKjPay> webKjPay = this.webPayPicService.getKjPayList();
			for (WebKjPay webKjPay2 : webKjPay) {
				webKjPay2.setImg(null);
			}
			ServletUtils.outPrintSuccess(request, response, "", webKjPay);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "获取第三方支付列表失败");
		}
	}

	/**
	 * 获取用户银行卡列表
	 * 
	 * @param request
	 * @param response
	 */
	@RequestMapping("/getUserBankList")
	public void getUserBankList(HttpServletRequest request, HttpServletResponse response) {
		try {
			UserContext uc = this.getUserContext(request);
			List<TWebUserBank> bankList = this.webUserBankService.getBankList(uc.getUserName());
			JSONArray jsonArray = new JSONArray();
			
			TWebUserBank userBank = null;
			JSONObject jsonObject = null;
			for(int i=0;i<bankList.size();i++){
				userBank = bankList.get(i);
				String bankCard = userBank.getBankCard();
				
				
				jsonObject = new JSONObject();
				jsonObject.put("id", userBank.getId());
				jsonObject.put("bankType", userBank.getBankType());
				jsonObject.put("bankCode", userBank.getBankCode());
				jsonObject.put("userRealName", CommonUtils.getStartString(userBank.getUserRealName()));
				jsonObject.put("bankCard",CommonUtils.getFormatBankCard(bankCard));
				jsonObject.put("createTime", DateUtil.formatDate(userBank.getCreateTime(), DateUtil.YMDHMS_PATTERN));
				
				jsonArray.add(jsonObject);
			}
			
			
			ServletUtils.outPrintSuccess(request, response, "获取用户银行卡列表成功", jsonArray);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "获取用户银行卡列表失败");
		}
	}

	/**
	 * 获取用户用户主银行卡
	 * 
	 * @param request
	 * @param response
	 */
	@RequestMapping("/getMasterCard")
	public void getMasterCard(HttpServletRequest request, HttpServletResponse response) {
		try {
			UserContext uc = this.getUserContext(request);
			TWebUserBank bank = this.webUserBankService.getMasterCard(uc.getUserName());
			ServletUtils.outPrintSuccess(request, response, "获取入款账户列表成功", bank);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "获取取用户用户主银行卡失败");
		}
	}

	/**
	 * 支付 方法描述: TODO</br>
	 * 
	 * @param request
	 * @param response
	 *            void
	 */
	@RequestMapping("/doBankPay")
	public void doBankPay(HttpServletRequest request, HttpServletResponse response, WebBankHuikuan bankHk) {
		try {
			/** 最低入款判断 **/
			List<WebConfig> configList = this.webConfigService.getWebConfigList();
			String mobile = request.getParameter("mobile");
			if (StringUtils.isNotEmpty(mobile)) {
				bankHk.setHkCompanyBank(bankHk.getHkCompanyBank() + "(M)");
			}
			WebConfig webConfig = null;
			if (configList != null & configList.size() > 0) {
				webConfig = configList.get(0);
				Double hkMoney = bankHk.getHkMoney();
				if (hkMoney == null || hkMoney <= 0) {
					ServletUtils.outPrintFail(request, response, "请正确输入金额");
					return;
				}
				double minPay = webConfig.getCompanyMinPay();
				if (hkMoney < minPay) {
					ServletUtils.outPrintFail(request, response, "公司入款最低" + minPay + "元！");
					return;
				}
			}

			if (StringUtils.isEmpty(bankHk.getHkCompanyBank()) || StringUtils.isEmpty(bankHk.getHkType()) || StringUtils.isEmpty(bankHk.getHkUserName()) || StringUtils.isEmpty(bankHk.getHkUserName().trim())) {
				ServletUtils.outPrintFail(request, response, "请完善您入款的信息！");
				return;
			}

			UserContext uc = this.getUserContext(request);
			WebUser user = this.webUserService.findWebrUseByUserName(uc.getUserName());
			Date currDate = DateUtil.currentDate();
			String currDateStr = DateUtil.format(currDate, "yyyy-MM-dd");
			Map<String, Integer> map = this.webBankHuikuanService.getWebBankHuikuanTj(uc.getUserName(), currDateStr);
			int totalTimes = map.get("totalTimes") + 1;
			int dayTimes = map.get("dayTimes") + 1;
			bankHk.setGmt4Time(DateUtil.getGMT_4_Date());// 美东当前时间
			bankHk.setTotalTimes(totalTimes);// 总次数
			bankHk.setDayTimes(dayTimes);// 日次数
			bankHk.setHkOrder(ComUtil.getOnliePayOrder());
			bankHk.setHkStatus(WebConstants.T_WEB_BANK_HUIKUAN_STATUS_0);// 订单状态为：未审核
			bankHk.setHkCheckStatus(WebConstants.T_WEB_BANK_HUIKUAN_CHECKED_STATUS_0);// 通过状态：初始状态
			bankHk.setCreateTime(currDate);
			bankHk.setModifyTime(currDate);
			bankHk.setUserName(uc.getUserName());
			bankHk.setHkIp(IPSeeker.getIpAddress(request));
			bankHk.setHkModel(WebConstants.T_WEB_BANK_HUIKUAN_MODEL_1);// 银行卡划款
			bankHk.setHkCompanyBank(StringUtils.trim(bankHk.getHkCompanyBank()));
			Date now = new Date();
			try {
				SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
				bankHk.setHkTime(new Date());
			} catch (Exception e) {
				bankHk.setHkTime(now);
			}

			this.webBankHuikuanService.saveWebBankHuikuan(bankHk);
			// bankHk.setPayDama(NumberUtils.toInt(getParameter("key"), 0));//
			// 打码再次入款标识

			/** 触发通知 **/
			MemCachedUtil.setDepositNotice(user.getUserFlag());

			ServletUtils.outPrintSuccess(request, response, "您的汇款订单已提交，请等待我们的审核，谢谢！");
		} catch (Exception e) {
			e.printStackTrace();
			logger.error("汇款订单提交异常: " + e.getMessage(), e);
			ServletUtils.outPrintFail(request, response, "您的汇款订单提交出了点状况，请稍候再提交或者联系我们客服帮助！");
		}
	}

	

	/**
	 * 获取用户可提现余额
	 * @param request
	 * @param response
	 */
	@RequestMapping("/availableBalance")
	public void availableBalance(HttpServletRequest request, HttpServletResponse response) {
		UserContext uc = this.getUserContext(request);
		WebUser user = this.webUserService.findWebrUseByUserName(uc.getUserName());
		ServletUtils.outPrintSuccess(request, response, "", user.getUserMoney());
	}

}
