/**   
* 文件名称: RegisterController.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-2 下午1:42:39<br/>
*/  
package com.mh.web.controller;

import java.util.Date;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.mvc.support.RedirectAttributesModelMap;

import com.mh.commons.conf.CommonConstant;
import com.mh.commons.utils.DesUtil;
import com.mh.commons.utils.IPSeeker;
import com.mh.commons.utils.SecurityEncode;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.WebSpreadLink;
import com.mh.entity.WebUser;
import com.mh.service.WebSpreadLinkService;
import com.mh.service.WebUserService;
import com.mh.web.login.UserContext;
import com.mh.web.util.CheckDeviceUtil;
import com.mh.web.util.RegLinkUtil;

/** 
 * 
 * 注册Controller
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-2 下午1:42:39<br/>
 */

@Controller
public class RegisterController extends BaseController {
	
	
	private static final Logger logger = LoggerFactory.getLogger(RegisterController.class);

	@Autowired
	private WebUserService webUserService;
	@Autowired
	private WebSpreadLinkService webSpreadLinkService;
	
	
	/**
	 * 下级链接开户
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/link/register")
	public void linkRegister(HttpServletRequest request, HttpServletResponse response){
		try{
			
			String userType = request.getParameter("userType");
			String cpPoint = request.getParameter("cpPoint");
			String pc28Point = request.getParameter("pc28Point");
			 
			
			if(StringUtils.isEmpty(userType)){
				ServletUtils.outPrintFail(request, response, "请选择会员类别");
				return;
			}
			
			
			if(StringUtils.isBlank(cpPoint)){
				ServletUtils.outPrintFail(request, response, "请选择彩票返点");
				return;
			}
			if(StringUtils.isBlank(pc28Point)){
				ServletUtils.outPrintFail(request, response, "请选择28返点");
				return;
			}
			double _cpPoint = Double.valueOf(cpPoint);
			double _pc28Point = Double.valueOf(pc28Point);
			if(_pc28Point<0){
				ServletUtils.outPrintFail(request, response, "28返点不能小于0");
				return;
			}
			if(_cpPoint<0){
				ServletUtils.outPrintFail(request, response, "彩票返点不能小于0");
				return;
			}
			UserContext uc = this.getUserContext(request);
			WebUser webUser =  this.webUserService.findWebrUseByUserName(uc.getUserName());
			double parentCpPoint = (webUser.getCpPoint()==null?0:webUser.getCpPoint());
			double parent28Point = (webUser.getPc28Point()==null?0:webUser.getPc28Point());
			if(_cpPoint>parentCpPoint){
				ServletUtils.outPrintFail(request, response, "彩票返点不能>上级返点");
				return;
			}
			if(_pc28Point>parent28Point){
				ServletUtils.outPrintFail(request, response, "28返点不能>上级返点");
				return;
			}
			
			WebSpreadLink  webSpreadLink = new WebSpreadLink();
			webSpreadLink.setUserName(uc.getUserName());
			webSpreadLink.setParentNo(webUser.getUserAgent());
			webSpreadLink.setRegNum(0);
			webSpreadLink.setTotal(9999);
			webSpreadLink.setIsAgent(Integer.valueOf(userType));
			webSpreadLink.setPc28Point(_pc28Point);
			webSpreadLink.setCpPoint(_cpPoint);
			webSpreadLink.setStatus(0);
			webSpreadLink.setCreateTime(new Date());
			webSpreadLink.setModifyTime(new Date());
			this.webSpreadLinkService.saveWebSpreadLink(webSpreadLink);
			
			
			
			String desKey = SecurityEncode.encoderByDES(webSpreadLink.getId()+"", SecurityEncode.key);
			webSpreadLink.setRegCode(desKey);
			String webUrl = this.getWebDomain(request);
			
			String  spreadLink = webUrl +"link/register/"+desKey;
			String shortLink = RegLinkUtil.generateSinaUrl(spreadLink);
			webSpreadLink.setShortLink(shortLink);
			webSpreadLink.setSpreadLink(spreadLink);
			int rows = this.webSpreadLinkService.updateWebSpreadLink(webSpreadLink.getId(), desKey, spreadLink,shortLink);
			if(rows>0){
				ServletUtils.outPrintSuccess(request, response,"生成注册链接成功");
			}else{
				ServletUtils.outPrintSuccess(request, response,"生成注册链接失败");
			}

		}catch(Exception e){
			ServletUtils.outPrintSuccess(request, response,"生成注册链接失败");
			logger.error("下级直接开户失败",e);
		}
	}
	
	
	/**
	 * 注册链接开户
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/link/register/{regCode}")
	public String linkRegister(@PathVariable(value = "regCode") String regCode,HttpServletRequest request
			, HttpServletResponse response, RedirectAttributesModelMap modelMap){
		
		modelMap.addFlashAttribute("regCode",regCode);
		String webUrl = this.getWebDomain(request)+"#/register/step-one";
		
		return "redirect:"+webUrl;  
	}
	
	
	/**
	 * 注册链接 列表
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/link/register/list")
	public void linkRegisterList(HttpServletRequest request, HttpServletResponse response){
		try{
			
			UserContext uc = this.getUserContext(request);
			List<Map<String,Object>> dataList = this.webSpreadLinkService.getWebSpreadLinkList(uc.getUserName());
			
			ServletUtils.outPrintSuccess(request, response,dataList);
		}catch(Exception e){
			ServletUtils.outPrintSuccess(request, response,"生成注册链接失败");
			logger.error("下级直接开户失败",e);
		}
	}
	
	/**
	 * 撤销注册链接
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping(value="/link/delete/{code}")
	public void lotteryRegister(@PathVariable(value = "code") String code,HttpServletRequest request, HttpServletResponse response) {
		try{
			String id = SecurityEncode.decoderByDES(code, SecurityEncode.key);
			
			int rows = this.webSpreadLinkService.updateWebSpreadLink(Integer.valueOf(id));
			if(rows>0){
				UserContext uc = this.getUserContext(request);
				List<Map<String,Object>> dataList = this.webSpreadLinkService.getWebSpreadLinkList(uc.getUserName());
				ServletUtils.outPrintSuccess(request, response,dataList);
 
			}else{
				ServletUtils.outPrintFail(request, response, "撤销注册链接失败");
			}
		}catch(Exception e){
			logger.error("撤销注册链接失败",e);
			ServletUtils.outPrintFail(request, response, "撤销注册链接失败");
		}
	}
	
	
	
	/**
	 * 下级直接开户
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/child/register")
	public void agentRegister(HttpServletRequest request, HttpServletResponse response){
		try{
			
			String userType = request.getParameter("userType");
			String userName = request.getParameter("userName");
			String cpPoint = request.getParameter("cpPoint");
			String pc28Point = request.getParameter("pc28Point");
			String password1 = request.getParameter("password1");
			String password2 = request.getParameter("password2");
			
			if(StringUtils.isEmpty(userType)){
				ServletUtils.outPrintFail(request, response, "请选择会员类别");
				return;
			}
			
			if(StringUtils.isEmpty(userName)){
				ServletUtils.outPrintFail(request, response, "请输入登录名称");
				return;
			}
			if(StringUtils.isEmpty(password1)){
				ServletUtils.outPrintFail(request, response, "请输入登录密码");
				return;
			}
			if(StringUtils.isEmpty(password2)){
				ServletUtils.outPrintFail(request, response, "请输入二次确认登录密码");
				return;
			}
			
			if(!password1.equals(password2)){
				ServletUtils.outPrintFail(request, response, "二次密码不一致!");
				return;
			}
			if(StringUtils.isBlank(cpPoint)){
				ServletUtils.outPrintFail(request, response, "请选择彩票返点");
				return;
			}
			if(StringUtils.isBlank(pc28Point)){
				ServletUtils.outPrintFail(request, response, "请选择28返点");
				return;
			}
			double _cpPoint = Double.valueOf(cpPoint);
			double _pc28Point = Double.valueOf(pc28Point);
			if(_pc28Point<0){
				ServletUtils.outPrintFail(request, response, "28返点不能小于0");
				return;
			}
			if(_cpPoint<0){
				ServletUtils.outPrintFail(request, response, "彩票返点不能小于0");
				return;
			}
			
			
			UserContext uc = this.getUserContext(request);
			WebUser temUser = this.webUserService.findWebrUseByUserName(userName);
			if(temUser!=null){
				ServletUtils.outPrintFail(request, response, "登录名称已存在!");
				return;
			}
			String cryptPassword= "";
			String cryptWithdrawPassword= "";
			try {
				cryptPassword = DesUtil.encrypt(password1, CommonConstant.resCommMap.get(CommonConstant.APP_CLIENT_DES_KEY));
				cryptWithdrawPassword = DesUtil.encrypt(password1, CommonConstant.resCommMap.get(CommonConstant.APP_MONEY_DES_KEY));
			} catch (Exception e) {
				e.printStackTrace();
			}
			WebUser parentUser =  this.webUserService.findWebrUseByUserName(uc.getUserName());
			double parentCpPoint = (parentUser.getCpPoint()==null?0:parentUser.getCpPoint());
			double parent28Point = (parentUser.getPc28Point()==null?0:parentUser.getPc28Point());
			if(_cpPoint>parentCpPoint){
				ServletUtils.outPrintFail(request, response, "彩票返点不能>上级返点");
				return;
			}
			if(_pc28Point>parent28Point){
				ServletUtils.outPrintFail(request, response, "28返点不能>上级返点");
				return;
			}
			WebUser webUser = new WebUser();
			webUser.setUserName(userName);
			webUser.setUserFlag(CommonConstant.resCommMap.get(CommonConstant.WEB_USER_FLAG));
			webUser.setUserStatus(1);
			webUser.setUserType(Integer.valueOf(userType));
			webUser.setUserMoney(0d);
			webUser.setUserLoginTimes(0);
			webUser.setUserPassword(cryptPassword);
			webUser.setUserWithdrawPassword(cryptWithdrawPassword);
			webUser.setCreateTime(new Date());
			webUser.setModifyTime(new Date());
			webUser.setUserPsTimes(0);
			webUser.setUserAgent(uc.getUserName());
			webUser.setRegistIp(IPSeeker.getIpAddress(request));
			webUser.setRegistDevice(CheckDeviceUtil.checkDevice(request));
			webUser.setPc28Point(_pc28Point);
			webUser.setCpPoint(_cpPoint);
			webUser.setIsTest(parentUser.getIsTest());
			String relativePath = parentUser.getRelativePath();
			if(parentUser.getRelativePath().lastIndexOf("/")==-1){
				relativePath = relativePath+"/";
			}
			relativePath = relativePath +userName+"/";
			
			webUser.setRelativePath(relativePath);
			this.webUserService.saveWebUser(webUser);
			
			
			ServletUtils.outPrintSuccess(request, response,"下级开户成功");
		}catch(Exception e){
			ServletUtils.outPrintFail(request, response, "下级直接开户失败");
			logger.error("下级直接开户失败",e);
		}
		
		
	}
	
	
	
	/**
	 * 用户注册
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/register")
	public void register(HttpServletRequest request, HttpServletResponse response){
		try{
			String username = request.getParameter("username");
			String password1 = request.getParameter("password1");
			String password2 = request.getParameter("password2");
			String regCode = request.getParameter("regCode");
			
			if(StringUtils.isBlank(username)){
				ServletUtils.outPrintFail(request, response, "请输入注册用户名");
				return;
			}
			if(StringUtils.isBlank(username)){
				ServletUtils.outPrintFail(request, response, "请输入密码");
				return;
			}
			if(!password1.equals(password2)){
				ServletUtils.outPrintFail(request, response, "二次输入密码不一致");
				return;
			}
			
			WebUser webUser = this.webUserService.findWebrUseByUserName(username);
			if(webUser!=null){
				ServletUtils.outPrintFail(request, response, webUser.getUserName()+"已经存在");
				return;
			}
			String cryptPassword= "";
			String cryptWithdrawPassword= "";
			try {
				cryptPassword = DesUtil.encrypt(password1, CommonConstant.resCommMap.get("app.client.des.key"));
				cryptWithdrawPassword = DesUtil.encrypt(password1, CommonConstant.resCommMap.get("app.money.des.key"));
			} catch (Exception e) {
				e.printStackTrace();
			}
			
			webUser = new WebUser();
			webUser.setUserName(username);
			webUser.setUserFlag(CommonConstant.resCommMap.get(CommonConstant.WEB_USER_FLAG));
			webUser.setUserStatus(1);
			webUser.setUserMoney(0d);
			webUser.setUserLoginTimes(0);
			webUser.setUserPassword(cryptPassword);
			webUser.setUserWithdrawPassword(cryptWithdrawPassword);
			webUser.setCreateTime(new Date());
			webUser.setModifyTime(new Date());
			webUser.setUserPsTimes(0);
			String relativePath = "";
			if(StringUtils.isNotBlank(regCode)){
				String id = SecurityEncode.decoderByDES(regCode, SecurityEncode.key);
				WebSpreadLink  webSpreadLink = this.webSpreadLinkService.getWebSpreadLinkById(Integer.valueOf(id));
				if(webSpreadLink==null){
					ServletUtils.outPrintFail(request, response, "注册链接信息不存在");
					return;
				}
				webUser.setCpPoint(webSpreadLink.getCpPoint());
				webUser.setPc28Point(webSpreadLink.getPc28Point());
				webUser.setUserAgent(webSpreadLink.getUserName());
				WebUser user = this.webUserService.findWebrUseByUserName(webSpreadLink.getUserName());
				webUser.setIsTest(user.getIsTest());
				relativePath = user.getRelativePath();
			}else{
				webUser.setCpPoint(0d);
				webUser.setPc28Point(0d);
				webUser.setUserAgent("admin");
				webUser.setIsTest(0);
			}
			webUser.setRegistIp(IPSeeker.getIpAddress(request));
			webUser.setRegistDevice(CheckDeviceUtil.checkDevice(request));
			
			webUser.setRegistIp(IPSeeker.getIpAddress(request));
 
			if(relativePath.lastIndexOf("/")==-1){
				relativePath = relativePath+"/";
			}
			relativePath = relativePath +username+"/";
			
			
			webUser.setRelativePath(relativePath);
			this.webUserService.saveWebUser(webUser);
			ServletUtils.outPrintSuccess(request, response,"用户注册成功");
		}catch(Exception e){
			logger.error("用户注册失败",e);
			ServletUtils.outPrintFail(request, response, "用户注册失败");
		}
		
		
		
	}

}
