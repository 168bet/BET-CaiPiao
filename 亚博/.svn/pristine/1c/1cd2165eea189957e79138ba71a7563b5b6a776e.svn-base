
package com.mh.web.servlet;

import javax.servlet.ServletContext;

import org.springframework.web.context.ServletContextAware;

import com.mh.commons.conf.SystemConfig;

/**
 * 
 * @ClassName: ResourcePathExposer 
 * @Description: TODO(设置WEB层文件路径) 
 * @author alex
 * @date Mar 24, 2012 4:10:30 PM 
 *
 */
public class ResourcePathExposer implements ServletContextAware {
	
	
	
	private ServletContext servletContext;
	private String resourceRoot;
	private String resourceWebRoot;

	public void init() {
		 
		
		resourceRoot = "/resources-" + getVersion() + "/" + getSkin();
		getServletContext().setAttribute("resourceRoot", getServletContext().getContextPath() + resourceRoot);
		getServletContext().setAttribute("ctx", getServletContext().getContextPath());
		resourceWebRoot = "resourceWebRoot";
	}
	
	


	

	public void setServletContext(ServletContext servletContext) {
		this.servletContext = servletContext;
	}

	public String getResourceRoot() {
		return resourceRoot;
	}

	public ServletContext getServletContext() {
		return servletContext;
	}
	
	public String getVersion(){
		return SystemConfig.getProperty("version", "1.0", "resource");
	}
	
	public String getSkin(){
		return SystemConfig.getProperty("skin", "commons", "resource");
	}

	public String getResourceWebRoot() {
		return resourceWebRoot;
	}

	public void setResourceWebRoot(String resourceWebRoot) {
		this.resourceWebRoot = resourceWebRoot;
	}


	
}
