package com.mh.web.controller;

import java.io.IOException;
import java.io.PrintWriter;
import java.util.Date;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.codec.digest.DigestUtils;
import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.alibaba.fastjson.JSONObject;
import com.mh.commons.cache.MemCachedUtil;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.constants.WebConstants;
import com.mh.commons.utils.AesUtil;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.IPSeeker;
import com.mh.entity.SysParameter;
import com.mh.entity.TWebBankHuikuan;
import com.mh.entity.TWebThirdPay;
import com.mh.service.PayCenterService;
import com.mh.service.SysParameterService;

@Controller
@RequestMapping("/payReturn")
public class PayReturnCenterController extends BaseController{
	@Resource
	private PayCenterService payCenterService;
	@Autowired
	private SysParameterService sysParameterService;
 
	
	private String successMessage="交易成功!";
	private String errorMessage="交易失败!";
	@RequestMapping("/payReturnHandler")
	public void payReturnHandler(HttpServletRequest request, HttpServletResponse response){
		// 入数据库
		TWebBankHuikuan bankHk = new TWebBankHuikuan();
		Date now = new Date();
		JSONObject json=new JSONObject();
		String callInfo="";//回调程序发送过来的参数key
		String billno="";//订单号
		Double amount=0.0;//订单金额
		String thirdBillno="";//第三方支付流水号
		String bankBillno="";//银行返回的交易流水号
		String userName="";//要入款的会员账户
		String attach="";//发送参数
		String webSign="";
//		JSONObject attachJson=new JSONObject();
		String resultMessage="N";//回调是否成功,Y--成功
		
		try {
			
			boolean reFlag = this.getAuthOnlineIp(request);
			if(!reFlag){
				logger.error("支付回调失败，ip鉴权失败！");
				throw new Exception("支付回调失败，ip鉴权失败！");
			}
			
			callInfo=request.getParameter("callInfo");
			json=JSONObject.parseObject(AesUtil.decrypt(callInfo));
			
			
			thirdBillno=json.getString("thirdBillno");
			amount=json.getDouble("amount");
			bankBillno=json.getString("bankBillno");
			billno=json.getString("billno");
			userName=json.getString("userName");
			attach=json.getString("attachJson");
			webSign=json.getString("webSign");
//			String payStatus=json.getString("payStatus");//暂时只有成功才处理回调，所以状态参数预留
			
			bankHk=payCenterService.loadTWebBankHuikuanForBillno(billno,WebConstants.T_WEB_BANK_HUIKUAN_STATUS_0);
			
			/****订单验证****/
			if(null==bankHk || amount-bankHk.getHkMoney()!=0.0 || !userName.equals(bankHk.getUserName())){
				logger.error("用户名:"+userName+"订单号:"+billno+"支付金额："+amount+"支付异常！");
				throw new Exception("支付回调失败，出现异常支付！");
			}
			
			//签名验证
			String[] ats=attach.split("_");
			int payId=Integer.parseInt(ats[2]);
			TWebThirdPay payObj=payCenterService.findTWebThirdPayById(payId);
			String cbsign=callBackSign(payObj.getThirdKey(), billno, userName);
			
			if(!cbsign.equals(webSign)){
				logger.error("回调签名验证失败，交易内容被篡改!订单号:"+billno);
				throw new Exception("回调签名验证失败，交易内容被篡改!订单号:"+billno);
			}else{
				bankHk.setHkTime(now);// 入款时间
				bankHk.setHkCheckTime(now);// 审核时间
				bankHk.setHkOrder(billno);// 汇款编号和第三方付款一样

				bankHk.setModifyTime(now);
				bankHk.setUserName(userName);// 会员名
				bankHk.setHkMoney(amount);
				bankHk.setHkOnlinePayNo(thirdBillno);// 交易流水号
				String remark = "订单[" + billno + "]金额" + amount + "充值成功,支付流水号" + thirdBillno+"银行交易流水号" + bankBillno+"";// 备注
				bankHk.setRemark(remark);
				bankHk.setGmt4Time(DateUtil.getGMT_4_Date());
				boolean result = payCenterService.updateWebUserDeposit(bankHk);
				if(!result){
					logger.error("订单号:"+billno+"支付回调处理业务参数失败!");
				}else{
					resultMessage="Y";
					String userFlag = CommonConstant.resCommMap.get(CommonConstant.WEB_USER_FLAG);
					/** 触发通知 **/
					MemCachedUtil.setOnlineNotice(userFlag);
				}
				
			}
			
			
			
			/***一些旧系统中代码写的,暂时没有地方用到的参数****/
//			bankHk.setHkStatus(1);// 状态设为已入帐
//			bankHk.setHkIp(IpUtil.getClientIpAddr(request));
//			bankHk.setHkCompanyBank("快汇宝支付");
//			bankHk.setHkCheckStatus(WebConstants.T_WEB_BANK_HUIKUAN_CHECKED_STATUS_1);
//			bankHk.setHkModel(WebConstants.T_WEB_BANK_HUIKUAN_MODEL_2);// 在线支付
//			bankHk.setHkType("线上支付");
//			bankHk.setPayDama(NumberUtils.toInt(extra_return_param.split("_")[1], 0));// 是否是打码量再次入款
			/***************************************/
		} catch (Exception e) {
			// TODO: handle exception
			logger.error("订单号:"+billno+"支付回调失败!"+e);
			e.printStackTrace();
		}finally{
			JSONObject jsonMessage=new JSONObject();
			PrintWriter print=null;
			try {
				jsonMessage.put("result", resultMessage);
				print=response.getWriter();
				print.print(jsonMessage.toString());
			} catch (IOException e) {
				logger.error("支付回调返回失败!,订单号:"+billno);
				e.printStackTrace();
			}finally{
				if(null!=print){
					print.flush();
					print.close();
				}
			}
			
		}

	}
 
	
	/**
	 * 同步通知页面
	 */
	@RequestMapping("/payReturnHuanxunPage")
	public ModelAndView payReturnHuanxunPage(HttpServletRequest request, HttpServletResponse response){
		String succ=request.getParameter("succ");
		logger.info("环讯页面通知结果:"+succ);
		String message="";
		if(StringUtils.isNotBlank(succ) && "Y".equals(succ)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message);
		return mv;
	}
	
	/**
	 * 同步通知页面
	 */
	@RequestMapping("/payReturnDinpayPage")
	public ModelAndView payReturnDinpayPage(HttpServletRequest request, HttpServletResponse response){
		String succ=request.getParameter("trade_status");
		logger.info("快汇宝页面通知结果:"+succ);
		String message="";
		if(StringUtils.isNotBlank(succ) && "SUCCESS".equals(succ)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message);
		return mv;
	}
	
	/**
	 * 同步通知页面
	 */
	@RequestMapping("/payReturnMobaoPage")
	public ModelAndView payReturnMobaoPage(HttpServletRequest request, HttpServletResponse response){
		String succ=request.getParameter("succ");
		logger.info("mobao页面通知结果:"+succ);
		String message="";
		if(StringUtils.isNotBlank(succ) &&  "Y".equals(succ)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		String attach=request.getParameter("merchParam");
		String[] atsArr = attach.split("_");
		String domainUrl = "";
		if(atsArr.length==4){
			domainUrl = atsArr[3];	
		}
		
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message);
		mv.addObject("domainUrl", domainUrl);
		return mv;
	}
	
	/**
	 * 同步通知页面
	 */
	@RequestMapping("/payReturnBaopayPage")
	public ModelAndView payReturnBaopayPage(HttpServletRequest request, HttpServletResponse response){
		String succ= request.getParameter("Result");//交易是否成功1：成功 0：失败
		logger.info("宝付页面通知结果:"+succ);
		String message="";
		if(StringUtils.isNotBlank(succ) &&  "1".equals(succ)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message);
		return mv;
	}
	
	/**
	 * 同步通知页面
	 */
	@RequestMapping("/payReturnYeepayPage")
	public ModelAndView payReturnYeepayPage(HttpServletRequest request, HttpServletResponse response){
		String succ=request.getParameter("r1_Code");//1--支付成功
		logger.info("易付页面通知结果:"+succ);
		String message="";
		if(StringUtils.isNotBlank(succ) && "1".equals(succ)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		//String domain = this.getWebDomain(request);
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message)
		;
		return mv;
	}
	
	/**
	 * 优付支付回调
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @return  
	 * ModelAndView
	 */
	@RequestMapping("/payReturnYompayPage")
	public ModelAndView payReturnYompayPage(HttpServletRequest request, HttpServletResponse response){
		String succ=request.getParameter("trade_status");
		logger.info("优付支付页面通知结果:"+succ);
		String message="";
		if(StringUtils.isNotBlank(succ) && "success".equals(succ)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		String attach=request.getParameter("trade_params");
		String[] atsArr = attach.split("_");
		String domainUrl = "";
		if(atsArr.length==4){
			domainUrl = atsArr[3];	
		}
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message);
		mv.addObject("domainUrl",domainUrl);
		return mv;
	}
	
	
	/**
	 * 银宝支付回调
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @return  
	 * ModelAndView
	 */
	@RequestMapping("/payReturnv9payPage")
	public ModelAndView payReturnv9payPage(HttpServletRequest request, HttpServletResponse response){
		// 订单结果
		String orderstatus = request.getParameter("orderstatus");
		logger.info("银宝支付页面通知结果:"+orderstatus);
		String message="";
		if(StringUtils.isNotBlank(orderstatus) && "1".equals(orderstatus)){
			message=successMessage;
		}else{
			message=errorMessage;
		}
		String attach=request.getParameter("attach");
		String[] atsArr = attach.split("_");
		String domainUrl = "";
		if(atsArr.length==4){
			domainUrl = atsArr[3];	
		}
		
		ModelAndView mv = new ModelAndView("member/pay/payMessagePage");
		mv.addObject("message", message);
		mv.addObject("domainUrl",domainUrl);
		return mv;
	}
	
	
	/**
	 * 获取鉴权ip地址
	 * 方法描述: TODO</br> 
	 * @return  
	 * List<String>
	 */
	public boolean getAuthOnlineIp(HttpServletRequest request){
		
		SysParameter sysParameter = this.sysParameterService.getSysParameterByPramName(CommonConstant.WEB_USER_ONLINE_AUTH_IP);
		String userIp = "";
		if(sysParameter!=null){
			userIp = sysParameter.getParamValue();
		}
		String authIp = IPSeeker.getIpAddress(request);
		logger.info("访问ip:" + authIp);
		logger.info("配置Ip:" + userIp);
		String[] ipArr = userIp.split(",");
		for(int i=0;i<ipArr.length;i++){
			if(authIp.indexOf(ipArr[i])>0 || authIp.equals(ipArr[i])){
				return true;
			}
		}
		return false;
	}
	
	
	
	//签名
	/**
	 * 回调签名
	 */
	private String callBackSign(String key,String billno,String userName){
		String webKey=CommonConstant.resCommMap.get("web_pay_key");
		
		StringBuffer sbf=new StringBuffer();
		sbf.append(webKey);
		//sbf.append(amount);
		sbf.append(key);
		sbf.append(billno);
		sbf.append(userName);
		
		String sign=DigestUtils.md5Hex(sbf.toString());
		logger.info("webSign=="+sbf.toString());
		return sign;
	}
}
