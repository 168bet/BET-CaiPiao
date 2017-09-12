package com.mh.web.controller;

import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.codec.digest.DigestUtils;
import org.apache.commons.lang.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.alibaba.fastjson.JSONObject;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.constants.WebConstants;
import com.mh.commons.utils.AesUtil;
import com.mh.commons.utils.ComUtil;
import com.mh.commons.utils.CommonUtils;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.IPSeeker;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.TWebBankHuikuan;
import com.mh.entity.TWebThirdPay;
import com.mh.entity.TWebThirdPayKj;
import com.mh.entity.WebUser;
import com.mh.service.PayCenterService;
import com.mh.service.WebUserService;
import com.mh.web.login.UserContext;
import com.mh.web.util.CheckDeviceUtil;

@Controller
@RequestMapping("/pay")
public class PayCenterController extends BaseController{
	@Resource
	private PayCenterService payCenterService;
	
	@Autowired
	private WebUserService webUserService;
	
	
	
	/**
	 * 点击充值，组装数据，订单生成，信息入库，跳转支付中心支付
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/doPayCenterData")
	public void doPayCenterData(HttpServletRequest request, HttpServletResponse response){
	
		try {
			UserContext user=super.getUserContext(request);
			JSONObject json=new JSONObject();
			
			Date now = new Date();
			DecimalFormat currentNumberFormat = new DecimalFormat("#0.00");
			SimpleDateFormat f = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
 
			String money=request.getParameter("money");//订单金额
			String bank_code=request.getParameter("bank_code");
			String payId = request.getParameter("payId");
	 
			String billno= ComUtil.getOnliePayOrder();//订单编号
			
			if(StringUtils.isEmpty(money)){
				logger.error("入款金额不能为空!");
				ServletUtils.outPrintFail(request, response,"入款金额不能为空!");
				return;
			}
			
			
			if(!CommonUtils.isDouble(money)){
				logger.error("入款金额格式不正确!");
	 
				ServletUtils.outPrintFail(request, response,"入款金额格式不正确!");
				return;
			}
			
			
			
			String payType="";//支付商家区分标识
			//String billno=getOnliePayOrder();//订单编号
			String key="";//第三方支付对应key.
			String thirdCode="";//商户号
			String thirdSecode="";//附加商户code（附加商户唯一标识）
		
			if(null==payId){
				logger.error("异常请求，没有对应支付方式，支付ID为空!");
				ServletUtils.outPrintFail(request, response,"没有对应支付方式，支付ID为空!");
				return;
			}
 
			double _money = Double.valueOf(money);
			TWebThirdPay pay = this.payCenterService.findTWebThirdPayById(Integer.valueOf(payId));
			if(pay==null){
				logger.error("支付方式不存在!");
				ServletUtils.outPrintFail(request, response,"支付方式不存在!");
				return;
			}
			if(_money<pay.getThirdMinEdu()){
				logger.error("存款金额不能低于"+pay.getThirdMinEdu());
 
				ServletUtils.outPrintFail(request, response,"存款金额不能低于"+pay.getThirdMinEdu());
				return;
			}
			
			if(_money>pay.getThirdMaxEdu()){
				logger.error("存款金额不能大于"+pay.getThirdMaxEdu());
				ServletUtils.outPrintFail(request, response,"存款金额不能大于"+pay.getThirdMaxEdu());
				return;
			}
 
			
			key=pay.getThirdKey();
			thirdCode=pay.getThirdCode();
			String pay_url=pay.getThirdUrl()+"/payhc/payCenter_payHandleCenter.action";
			payType=pay.getThirdType();
			
			
			String path = request.getContextPath();
			String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path;
			
			String domain=basePath;//当前网站域名
			String amount = currentNumberFormat.format(Double.parseDouble(money));// 金额
			
			String remark = "订单[" + billno + "]金额" + amount + "提交时间" + f.format(now);// 备注
			String clientIp=IPSeeker.getIpAddress(request);
			/***组装订单信息入库 start***/
			TWebBankHuikuan bankHk=new TWebBankHuikuan();
			bankHk=this.getBankHuikuanData(bankHk);
			bankHk.setPayNo(pay.getPayNo()==null?"":pay.getPayNo());
			bankHk.setHkOrder(billno);// 汇款编号和第三方付款一样
			bankHk.setUserName(user.getUserName());
			bankHk.setHkMoney(Double.valueOf(amount));
			bankHk.setHkIp(clientIp);
			bankHk.setRemark(remark);
			if(WebConstants.PAY_HUANXUN_TYPE.equals(payType)){//环讯支付
				bankHk.setHkCompanyBank("环讯支付");
				bankHk.setHkType("环讯支付");
				
			}else if(WebConstants.PAY_HUANXUNV304_TYPE.equals(payType)){
				bankHk.setHkCompanyBank("环讯支付V0.3.4");
				bankHk.setHkType("环讯支付V0.3.4");
				thirdSecode=pay.getThirdSecode();
				json.put("thirdSecode", thirdSecode);
				
			}else if(WebConstants.PAY_DINPAY_TYPE.equals(payType)){//快汇宝支付
				bankHk.setHkCompanyBank("快汇宝支付");
				bankHk.setHkType("快汇宝支付");
				json.put("bank_code", bank_code);
			
			}else if(WebConstants.PAY_DINPAYRSA_TYPE.equals(payType)){//新快汇宝支付
				bankHk.setHkCompanyBank("新快汇宝支付");
				bankHk.setHkType("新快汇宝支付");
				json.put("bank_code", bank_code);
			}else if(WebConstants.PAY_MOBAO_TYPE.equals(payType)){//摩宝支付
				bankHk.setHkCompanyBank("摩宝支付");
				bankHk.setHkType("摩汇宝支付");
				json.put("bank_code", bank_code);
				
			}else if(WebConstants.PAY_BAOPAY_TYPE.equals(payType)){//宝付支付
				bankHk.setHkCompanyBank("宝付支付");
				bankHk.setHkType("宝付支付");

				json.put("bank_code", bank_code);
				thirdSecode=pay.getThirdSecode();
				json.put("thirdSecode", thirdSecode);
				
			}else if(WebConstants.PAY_YOMPAY_TYPE.equals(payType)){//优付支付
				bankHk.setHkCompanyBank("优付支付");
				bankHk.setHkType("优付支付");
				json.put("bank_code", bank_code);
				
			}else if(WebConstants.PAY_V9PAY_TYPE.equals(payType)){//银宝支付
				bankHk.setHkCompanyBank("银宝支付");
				bankHk.setHkType("银宝支付");
				
				json.put("bank_code", bank_code);
				
			}
			this.payCenterService.saveBankHuikuan(bankHk);
			/***组装订单信息入库 end***/
			String webMark=CommonConstant.resCommMap.get("web_pay_mark");
			String webKey=CommonConstant.resCommMap.get("web_pay_key");
			StringBuffer sbf=new StringBuffer();
			sbf.append(webMark);
			sbf.append(webKey);
			sbf.append(billno);
			sbf.append(amount);
			
			logger.info("==="+sbf.toString());
			String sign=DigestUtils.md5Hex(sbf.toString());
			
			json.put("sign",sign);
			json.put("webMark",webMark);
			json.put("billno", billno);//订单编号
			json.put("thirdCode", thirdCode);
			json.put("key", key);//第三方支付对应key.
			json.put("domain", domain);//当前网站域名
			json.put("amount", amount);//订单金额
			json.put("payType", payType);//支付类型，标识字段，区分支付商家
			json.put("clientIp", clientIp);
			json.put("userName", user.getUserName());
			json.put("remark", pay.getRemark()==null?"":pay.getRemark());
			
			String clientType = CheckDeviceUtil.checkDevice(request);
			if(!StringUtils.equals("pc", clientType)){
				domain += "/m/wap/member";
			}
			json.put("attachJson", billno+"_"+user.getUserName()+"_"+payId+"_"+domain);
			logger.info(json.toString());
			String sendParams=AesUtil.encrypt(json.toString());
 
			JSONObject all = new JSONObject();
			all.put("pay_url", pay_url);
			all.put("sendParams", sendParams);
			ServletUtils.outPrintSuccess(request, response,all);
		} catch (Exception e) {
			ServletUtils.outPrintFail(request, response, "支付中心支付异常");
			logger.error("支付中心支付异常"+e.getMessage());
			e.printStackTrace();
		}
	}
	
	
	
	/**
	 * 快捷支付
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @param modelMap
	 * @return  
	 * ModelAndView
	 */
	@RequestMapping("/doPaykjCenterData")
	public void doPaykjCenterData(HttpServletRequest request, HttpServletResponse response){
		UserContext user=super.getUserContext(request);
 
		JSONObject json=new JSONObject();
		TWebBankHuikuan bankHk=new TWebBankHuikuan();
		Date now = new Date();
		DecimalFormat currentNumberFormat = new DecimalFormat("#0.00");
		SimpleDateFormat f = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		String sendParams="";
		try {
			String money=request.getParameter("money");//订单金额
			String payId = request.getParameter("payId");
		 
			String payType = request.getParameter("payType");
			String choosePayType=request.getParameter("choosePayType");
			String bank_code=request.getParameter("bank_code");
			String billno= ComUtil.getOnliePayOrder();//订单编号
			
 
			//String billno=getOnliePayOrder();//订单编号
			String key="";//第三方支付对应key.
			String thirdCode="";//商户号
			String thirdSecode="";//附加商户code（附加商户唯一标识）
			if(StringUtils.isBlank(payId)){
				ServletUtils.outPrintFail(request, response, "没有对应支付方式，支付ID为空!");
				return;
			}
			TWebThirdPay pay=this.payCenterService.findTWebThirdPayById(Integer.parseInt(payId));
			WebUser webuser = webUserService.findWebrUseByUserName(user.getUserName());
 
			
			TWebThirdPayKj paykj = this.payCenterService.getTWebThirdPayKj(Integer.parseInt(payType), webuser.getUserType());
			if(paykj != null){
				if(Double.parseDouble(money) - paykj.getPayMinEdu() < 0.0 || paykj.getPayMaxEdu()-Double.parseDouble(money)<0.0){
					logger.error("用户名:"+user.getUserName()+"非法支付方式，支付金额!");
				 
					ServletUtils.outPrintFail(request, response,"用户名:"+user.getUserName()+"非法支付方式，支付金额!");
					return;
				}
			}else{
				logger.error("用户名:"+user.getUserName()+"该用户类型下，没有绑定在线支付方式!");
				ServletUtils.outPrintFail(request, response,"用户名:"+user.getUserName()+"该用户类型下，没有绑定在线支付方式!");
				return;
			}
			
			
			key=pay.getThirdKey();
			thirdCode=pay.getThirdCode();
			String pay_url=pay.getThirdUrl()+"/payhc/payCenter_payHandleCenter.action";
			payType=pay.getThirdType();
			
			
			String path = request.getContextPath();
			String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path;
			
			String domain=basePath;//当前网站域名
			String amount = currentNumberFormat.format(Double.parseDouble(money));// 金额
			
			String remark = "订单[" + billno + "]金额" + amount + "提交时间" + f.format(now);// 备注
			String clientIp=IPSeeker.getIpAddress(request);
			/***组装订单信息入库 start***/
			bankHk=this.getBankHuikuanData(bankHk);
			bankHk.setPayNo(pay.getPayNo()==null?"":pay.getPayNo());
			bankHk.setHkOrder(billno);// 汇款编号和第三方付款一样
			bankHk.setUserName(user.getUserName());
			bankHk.setHkMoney(Double.valueOf(amount));
			bankHk.setHkIp(clientIp);
			bankHk.setRemark(remark);
			if(WebConstants.PAY_HUANXUN_TYPE.equals(payType)){//环讯支付
				bankHk.setHkCompanyBank("环讯支付");
				bankHk.setHkType("环讯支付");
				
			}else if(WebConstants.PAY_HUANXUNV304_TYPE.equals(payType)){
				bankHk.setHkCompanyBank("环讯支付V0.3.4");
				bankHk.setHkType("环讯支付V0.3.4");
				thirdSecode=pay.getThirdSecode();
				json.put("thirdSecode", thirdSecode);
				
			}else if(WebConstants.PAY_DINPAY_TYPE.equals(payType)){//快汇宝支付
				bankHk.setHkCompanyBank("快汇宝支付");
				bankHk.setHkType("快汇宝支付");
				json.put("bank_code", bank_code);
			}else if(WebConstants.PAY_DINPAYRSA_TYPE.equals(payType)){//新快汇宝支付
				bankHk.setHkCompanyBank("新快汇宝支付");
				bankHk.setHkType("新快汇宝支付");
				json.put("bank_code", bank_code);
			}else if(WebConstants.PAY_MOBAO_TYPE.equals(payType)){//摩宝支付
				bankHk.setHkCompanyBank("摩宝支付");
				bankHk.setHkType("摩汇宝支付");
				json.put("bank_code", bank_code);
			}else if(WebConstants.PAY_BAOPAY_TYPE.equals(payType)){//宝付支付
				bankHk.setHkCompanyBank("宝付支付");
				bankHk.setHkType("宝付支付");
				json.put("bank_code", bank_code);
				thirdSecode=pay.getThirdSecode();
				json.put("thirdSecode", thirdSecode);
				
			}else if(WebConstants.PAY_YOMPAY_TYPE.equals(payType)){//优付支付
				bankHk.setHkCompanyBank("优付支付");
				bankHk.setHkType("优付支付");
				json.put("bank_code", bank_code);
				
			}else if(WebConstants.PAY_V9PAY_TYPE.equals(payType)){//银宝支付
				bankHk.setHkCompanyBank("银宝支付");
				bankHk.setHkType("银宝支付");
				
				json.put("bank_code", bank_code);
				
			}
			this.payCenterService.saveBankHuikuan(bankHk);
			/***组装订单信息入库 end***/
			String webMark=CommonConstant.resCommMap.get("web_pay_mark");
			String webKey=CommonConstant.resCommMap.get("web_pay_key");
			StringBuffer sbf=new StringBuffer();
			sbf.append(webMark);
			sbf.append(webKey);
			sbf.append(billno);
			sbf.append(amount);
			
			logger.info("==="+sbf.toString());
			String sign=DigestUtils.md5Hex(sbf.toString());
			
			json.put("sign",sign);
			json.put("webMark",webMark);
			json.put("billno", billno);//订单编号
			json.put("thirdCode", thirdCode);
			json.put("key", key);//第三方支付对应key.
			json.put("domain", domain);//当前网站域名
			json.put("amount", amount);//订单金额
			json.put("payType", payType);//支付类型，标识字段，区分支付商家
			json.put("clientIp", clientIp);
			json.put("userName", user.getUserName());
			json.put("remark", pay.getRemark()==null?"":pay.getRemark());
			
			String clientType = CheckDeviceUtil.checkDevice(request);
			if(!StringUtils.equals("pc", clientType)){
				domain += "/m/wap/member";
			}
			
			json.put("attachJson", billno+"_"+user.getUserName()+"_"+payId+"_"+domain);
			
		
			if(StringUtils.isNotBlank(choosePayType)){
				json.put("bank_code", choosePayType);
			}
			
			logger.info(json.toString());
			sendParams=AesUtil.encrypt(json.toString());
 
			JSONObject all = new JSONObject();
			all.put("pay_url", pay_url);
			all.put("sendParams", sendParams);
			ServletUtils.outPrintSuccess(request, response,all);
			
		} catch (Exception e) {
			ServletUtils.outPrintFail(request, response, "支付中心支付异常，用户名:"+user.getUserName());
			logger.error("支付中心支付异常，用户名:"+user.getUserName());
			e.printStackTrace();
		}
 
	}
	
	/**
	 * 
	 * @Description: 环讯支付信息基本参数
	 * @param    
	 * @return TWebBankHuikuan  
	 * @throws
	 * @author Andy
	 * @date 2015-6-8
	 */
	public static String getHuanxunPayParams(){
		
		return "";
	}
	/**
	 * 
	 * @Description: 快汇宝支付信息基本参数
	 * @param    
	 * @return TWebBankHuikuan  
	 * @throws
	 * @author Andy
	 * @date 2015-6-8
	 */
	public static String getdinPayParams(){
		
		return "";
	}
	public TWebBankHuikuan getBankHuikuanData(TWebBankHuikuan bankHk){
		Date now = new Date();
//		DecimalFormat currentNumberFormat = new DecimalFormat("#0.00");
//		String amount = currentNumberFormat.format(money);// 金额

//		SimpleDateFormat f = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
//		String attach = "订单[" + billno + "]金额" + amount + "提交时间" + f.format(now);// 备注

		bankHk.setCreateTime(now);
		bankHk.setHkTime(now);

		bankHk.setHkStatus(WebConstants.T_WEB_BANK_HUIKUAN_STATUS_0);// 状态设为已入帐
		bankHk.setModifyTime(now);

		bankHk.setHkCheckStatus(WebConstants.T_WEB_BANK_HUIKUAN_CHECKED_STATUS_0);

		bankHk.setHkModel(WebConstants.T_WEB_BANK_HUIKUAN_MODEL_2);// 在线支付
		
		
		bankHk.setGmt4Time(DateUtil.getGMT_4_Date());

		bankHk.setPayDama(0);// 打码再次入款标识
		return bankHk;
	}
	//点击充值，生成订单号
	public static String getOnliePayOrder() {
		SimpleDateFormat f = new SimpleDateFormat("yyMMddHHmmssSSS");
//		Random random = new Random();
		// int rannum = (int) (random.nextDouble() * (99 - 10 + 1)) + 10;//
		// 获取2位随机数
		return f.format(new Date());
	}
	public PayCenterService getPayCenterService() {
		return payCenterService;
	}
	public void setPayCenterService(PayCenterService payCenterService) {
		this.payCenterService = payCenterService;
	}
	
	/**
	 * 
	 * 方法描述:查看支付结果</br>
	 * 创建人: zoro<br/> 
	 * @param request
	 * @param response
	 * @return  
	 * ModelAndView
	 */
	@RequestMapping("/checkPayResult")
	public ModelAndView checkPayResult(HttpServletRequest request, HttpServletResponse response){
		ModelAndView view = new ModelAndView();
		String billno=request.getParameter("billno");//订单编号
		TWebBankHuikuan bankHuikuan = this.payCenterService.loadTWebBankHuikuanForBillno(billno,WebConstants.T_WEB_BANK_HUIKUAN_STATUS_1);
		if(null != bankHuikuan && WebConstants.T_WEB_BANK_HUIKUAN_STATUS_1.equals(bankHuikuan.getHkStatus()) 
					&& WebConstants.T_WEB_USER_WITHDRAW_CHECKED_STATUS_1.equals(bankHuikuan.getHkCheckStatus())){
			
			UserContext uc = this.getUserContext(request);
			WebUser webUser = this.webUserService.findWebrUseByUserName(uc
					.getUserName());
			view.addObject("user", webUser);
			view.addObject("msg","支付成功！");
			view.addObject("success","1");
		}else{
			view.addObject("msg","正在处理中，请稍等片刻！");
			view.addObject("success","0");
		}
		view.setViewName("member/pay/payResult");
		return view;
	}
	
}
