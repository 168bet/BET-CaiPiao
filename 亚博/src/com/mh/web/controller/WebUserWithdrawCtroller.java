package com.mh.web.controller;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mh.commons.orm.Page;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.WebUserWithdraw;
import com.mh.service.WebUserWithdrawService;
import com.mh.web.login.UserContext;



/**
 * 提现管理
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2016-11-30 下午3:54:33<br/>
 */
@Controller
@RequestMapping("/webUserWithdraw")
public class WebUserWithdrawCtroller extends BaseController{
	@Autowired
	private WebUserWithdrawService webUserWithdrawService;
	
	
	/**
	 * 提现记录列表
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @param cpParameter  
	 * void
	 */
	@RequestMapping("/getWebUserWithdrawList")
	public void getwebUserWithdrawList(HttpServletRequest request,HttpServletResponse response){

		try {
			UserContext uc = this.getUserContext(request);
			
			String beginTimeStr = request.getParameter("beginTimeStr");
			String endTimeStr = request.getParameter("endTimeStr");
			
			String orderNo = request.getParameter("orderNo");
			String status = request.getParameter("status");
			
			WebUserWithdraw userWithdraw = new WebUserWithdraw();
			userWithdraw.setUserName(uc.getUserName());
			if(StringUtils.isNotBlank(status)){
				userWithdraw.setWithdrawStatus(status);
			}
			if(StringUtils.isNotBlank(orderNo)){
				userWithdraw.setUserOrder(orderNo);
			}
	 
			if(StringUtils.isNotBlank(beginTimeStr)){
				userWithdraw.setBeginTimeStr(beginTimeStr);
			}
			if(StringUtils.isNotBlank(endTimeStr)){
				userWithdraw.setEndTimeStr(endTimeStr);
			}
			
			Page page = this.newPage(request);
 
			webUserWithdrawService.getWebUserWithdrawList(page,userWithdraw);
			ServletUtils.outPrintSuccess(request, response, page);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "查询提现记录失败！");
		}
	
	
	}
	
}
