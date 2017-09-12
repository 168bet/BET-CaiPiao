package com.mh.client;

import javax.servlet.http.HttpServletRequest;

import org.apache.log4j.Logger;
import org.springframework.stereotype.Component;
import org.springframework.web.bind.ServletRequestUtils;

import com.mh.commons.conf.CommonConstant;
import com.mh.commons.orm.Page;
import com.mh.web.login.UserContext;
import com.mh.web.servlet.MySessionContext;
@Component
public class BaseFlatInfo {
	
	protected Logger logger = Logger.getLogger(getClass());
	
	/**
	 * 获取登录用户
	 * @param request
	 * @return
	 */
	protected UserContext getUserContext(HttpServletRequest request){
		UserContext uc = null;
		if(MySessionContext.getSession(request.getSession().getId())!=null){
			uc = (UserContext)request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
			if(uc != null && uc.getUserId() != null){
				
				return uc;
			}
		}
		return uc;
	}
	
	protected String getWebDomain(HttpServletRequest request) {
		String path = request.getContextPath();
		String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
		if (basePath.endsWith(":80/")) {
			basePath = basePath.substring(0, basePath.indexOf(":80/")) + "/";
		}
		return basePath;
	}
	
	protected Page newPage(HttpServletRequest request){
		Page page = new Page();
		page.setPageSize(ServletRequestUtils.getIntParameter(request, CommonConstant.PAGE_SIZE, CommonConstant.DEFAULT_PAGE_SIZE));
		page.setPageNo(ServletRequestUtils.getIntParameter(request, CommonConstant.PAGE_NO, CommonConstant.DEFAULT_PAGE_NO));
		page.setOrderBy(ServletRequestUtils.getStringParameter(request, CommonConstant.ORDER_BY, ""));
		page.setOrderBy(ServletRequestUtils.getStringParameter(request, CommonConstant.ORDER, ""));
		
		return page;
	}
}
