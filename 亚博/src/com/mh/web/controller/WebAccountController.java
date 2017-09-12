package com.mh.web.controller;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mh.commons.orm.Page;
import com.mh.commons.utils.HttpClientUtil;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.CpParameter;
import com.mh.entity.WebAccounts;
import com.mh.service.WebAccountService;
import com.mh.web.login.UserContext;
/**
 * 我的账户--投注管理---账号明细  
 * @author Administrator
 *
 */
@Controller
@RequestMapping("/webAccount")
public class WebAccountController extends BaseController{
	@Autowired
	private WebAccountService accountService;
	
	
	/**
	 * 账户明细列表
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @param cpParameter  
	 * void
	 */
	@RequestMapping("/getAccountList")
	public void getAccountList(HttpServletRequest request,HttpServletResponse response,CpParameter cpParameter){
		try {
			UserContext uc = this.getUserContext(request);
			
			String beginTimeStr = request.getParameter("beginTimeStr");
			String endTimeStr = request.getParameter("endTimeStr");
			
			String orderNo = request.getParameter("orderNo");
			String actOptType = request.getParameter("actOptType");
			
			String userName = request.getParameter("userName");
			
			
			WebAccounts webAccount = new WebAccounts();
			
			if(StringUtils.isNotBlank(userName)){
				webAccount.setUserName(userName);
			}else{
				webAccount.setUserName(uc.getUserName());
			}
			
 
			if(StringUtils.isNotBlank(orderNo)){
				webAccount.setActOrder(orderNo);
			}
 
			if(StringUtils.isNotBlank(beginTimeStr)){
				webAccount.setBeginTimeStr(beginTimeStr);
			}
			if(StringUtils.isNotBlank(endTimeStr)){
				webAccount.setEndTimeStr(endTimeStr);
			}
			if(StringUtils.isNotBlank(actOptType)){
				webAccount.setActOptType(actOptType);
			}
			
			Page page = this.newPage(request);
 
			
			accountService.getWebAccountList(page,webAccount);
			
			ServletUtils.outPrintSuccess(request, response,  page);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "查询账户明细失败！" );
		}
	}
	
	
	
	
	@RequestMapping("/getactOpttypeList")
	public void getactOpttypeList(HttpServletRequest request,HttpServletResponse response){
		try {
			List<Map<String, Object>> list = accountService.getactOpttype();
			ServletUtils.outPrintSuccess(request, response,list);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "查询财务类型失败！" );
		}
	}
	
	
	public static void main(String[] args) {
		String url="http://127.0.0.1:8080/yabo/webAccount/getactOpttypeList";
		Map<String,String> params=new HashMap<String,String>();
		params.put("beginTime", "2016-05-09 13:25:40");
		params.put("endTime", "2016-05-13 13:25:40");
		params.put("userName", "nihaoma");
		params.put("currentPage", "1");
		params.put("pageLimit", "20");
		String str = HttpClientUtil.post(url, params);
		System.out.println(str);
	}
	

}
