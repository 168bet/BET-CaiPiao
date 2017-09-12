/**   
* 文件名称: CpChaseballController.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-10 下午4:46:26<br/>
*/  
package com.mh.web.controller;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mh.commons.orm.Page;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.CpChaseball;
import com.mh.service.CpChaseballService;
import com.mh.web.login.UserContext;

/** 
 * 追号记录Controller
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-10 下午4:46:26<br/>
 */

@Controller
@RequestMapping("/chaseball")
public class CpChaseballController extends BaseController{
	
	@Autowired
	private CpChaseballService cpChaseballService;
	
	/**
	 * 追号记录
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/goChaseballList")
	public void getCpGameCodeList(HttpServletRequest request,HttpServletResponse response){
		try{
			String gameCode = request.getParameter("gameCode");
			String status = request.getParameter("status");
			String billno = request.getParameter("billno");
			
			String beginTimeStr = request.getParameter("beginTimeStr");
			String endTimeStr = request.getParameter("endTimeStr");
			
			Page page = newPage(request);
			CpChaseball cpChaseball = new CpChaseball();
			UserContext uc = this.getUserContext(request);
			cpChaseball.setUserName(uc.getUserName());
			if(StringUtils.isNotBlank(gameCode)){
				cpChaseball.setGameTypeCode(gameCode);
			}
			if(StringUtils.isNotBlank(billno)){
				cpChaseball.setBillno(billno);
			}
			if(StringUtils.isNotBlank(beginTimeStr)){
				cpChaseball.setBeginTimeStr(beginTimeStr);
			}
			if(StringUtils.isNotBlank(endTimeStr)){
				cpChaseball.setEndTimeStr(endTimeStr);
			}
			if(StringUtils.isNotBlank(status) && !"-1".equals(status)){
				cpChaseball.setStatus(Integer.valueOf(status));
			}
			
			
			this.cpChaseballService.findPage(page, cpChaseball);
			ServletUtils.outPrintSuccess(request, response, page);
			
			cpChaseball = null;
		}catch(Exception e){
			logger.error("获取追号记录查询失败",e);
			ServletUtils.outPrintFail(request, response, "获取追号记录查询失败");
		}
	}
			
			

}
