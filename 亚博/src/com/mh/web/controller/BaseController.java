package com.mh.web.controller;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.validation.Validator;
import org.springframework.web.bind.ServletRequestUtils;

import com.mh.commons.conf.CommonConstant;
import com.mh.commons.orm.Page;
import com.mh.commons.utils.DateUtil;
import com.mh.web.login.UserContext;
import com.mh.web.servlet.MySessionContext;


/**
 * Controller基类，其它Controller可以直接继承这个Controller，集成一些公共基础功能。
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-6 下午1:54:06<br/>
 */
@SuppressWarnings("all")
public abstract class BaseController {
	
	protected Logger logger = LoggerFactory.getLogger(getClass());
	
	@Autowired
	protected Validator springValidator;
	
	public String[] searchDateTime;

	/**
	 * 请求参数page，pagesize设置到page对象并返回
	 * @param request
	 * @return
	 */
 
	protected Page newPage(HttpServletRequest request){
		Page page = new Page();
		page.setPageSize(ServletRequestUtils.getIntParameter(request, CommonConstant.PAGE_SIZE, CommonConstant.DEFAULT_PAGE_SIZE));
		page.setPageNo(ServletRequestUtils.getIntParameter(request, CommonConstant.PAGE_NO, CommonConstant.DEFAULT_PAGE_NO));
		page.setOrderBy(ServletRequestUtils.getStringParameter(request, CommonConstant.ORDER_BY, ""));
		page.setOrderBy(ServletRequestUtils.getStringParameter(request, CommonConstant.ORDER, ""));
		
		return page;
	}
	
	/**
	 * 获取用户上下文信息
	 * @param request
	 * @return
	 */
	public UserContext getUserContext(HttpServletRequest request){
		UserContext uc = null;
		if(MySessionContext.getSession(request.getSession().getId())!=null){
			uc = (UserContext)request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
			if(uc != null && uc.getUserId() != null){
				
				return uc;
			}
		}
 
		return uc;
	}
	
	/**
	 * 获取URL
	 * 方法描述: TODO</br> 
	 * @param request
	 * @return  
	 * String
	 */
	public String getUserLoginDomain(HttpServletRequest request) {
		String path = request.getContextPath();
		String basePath = request.getServerName() + ":" + request.getServerPort() + path + "/";
		if (basePath.endsWith(":80/")) {
			basePath = basePath.substring(0, basePath.indexOf(":80/"));
		}
		return basePath;
	}
	
	public String getWebDomain(HttpServletRequest request) {
		String path = request.getContextPath();
		String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
		if (basePath.endsWith(":80/")) {
			basePath = basePath.substring(0, basePath.indexOf(":80/")) + "/";
		}
		return basePath;
	}
	
	public String getRootWebDomain_(HttpServletRequest request) {
		String path = request.getContextPath();
		String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path;
		if (basePath.endsWith(":80/")) {
			basePath = basePath.substring(0, basePath.indexOf(":80/"));
		}
		return basePath;
	}
	
	public boolean isLegal(String str){
		if(StringUtils.isBlank(str)) return true;
		str =  str.trim();
		for(int i=0; i<str.length(); i++){
			if(CommonConstant.LEGAL_CHAR.indexOf(str.charAt(i)) == -1){
				return false;
			}
		}
		return true;
	}
	
	public void initSearchDateTime(HttpServletRequest request) {
		searchDateTime = new String[] { DateUtil.todayBegin(), DateUtil.todayEnd(), DateUtil.yesterdayBegin(), DateUtil.yesterdayEnd(), DateUtil.weekBegin(), DateUtil.weekEnd(),
				DateUtil.monthBegin(), DateUtil.monthEnd(), DateUtil.preMonthBegin(), DateUtil.preMonthEnd() };
		
		request.setAttribute("searchDateTime", searchDateTime);
	}
	
	/**
	 * 服务返回数据
	 * @Description: 
	 * @param  字符串格式
	 * @return void
	 * @author Andy
	 * @date 2015-10-2
	 */
	protected void responseSendMessage(HttpServletResponse response,String message) {
		response.setHeader("content-type", "text/html;charset=UTF-8");
		PrintWriter print=null;
		try {
			print=response.getWriter();
			print.print(message);
		} catch (Exception e) {
			// TODO: handle exception
			logger.error("返回数据:"+message);
			logger.error("服务器响应错误:"+e);
		}finally{
			if(null!=print){
				print.flush();
				print.close();
			}
		}
	}
	
	public void sendErrorMsg(HttpServletResponse response,String msg,String url){
		response.setHeader("content-type", "text/html;charset=UTF-8");
		PrintWriter out = null;
		try {
			out = response.getWriter();
		} catch (IOException e) {
			e.printStackTrace();
		} finally{
			out.print("<script>alert('"+msg+"');window.location.href='"+url+"';</script>");
			if(null != out){
				out.flush();
				out.close();
			}
		}
	}
	
	
	

}
