package com.mh.web.servlet;

import java.io.InputStream;
import java.util.Properties;

import javax.servlet.ServletConfig;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.orm.hibernate3.HibernateTemplate;
import org.springframework.web.context.WebApplicationContext;
import org.springframework.web.context.support.WebApplicationContextUtils;

import com.mh.commons.conf.CommonConstant;
import com.mh.web.job.CpCacheHelper;

/**
 * 过滤器初始化参数Servlet 类描述: TODO<br/>
 * 修改人: alex<br/>
 * 修改时间: 2015-6-28 下午5:25:05<br/>
 */
public class ResourceInitServlet extends HttpServlet {

	private static final Log logger = LogFactory.getLog(ResourceInitServlet.class);

	private static final long serialVersionUID = 1L;

	public ResourceInitServlet() {
		super();
	}

	@Override
	public void init(ServletConfig config) throws ServletException {
		initProperties(config);// app-base.properties
 
		initCpConfigData(config);
	}
	
	

	private void initCpConfigData(ServletConfig config) {
		WebApplicationContext wac = WebApplicationContextUtils.getWebApplicationContext(config.getServletContext());
		HibernateTemplate hibernateTemplate = (HibernateTemplate) wac.getBean("hibernateTemplate");
		JdbcTemplate jdbcTemplate = (JdbcTemplate) wac.getBean("jdbcTemplate");
		CpCacheHelper helper = new CpCacheHelper(jdbcTemplate, hibernateTemplate);
		helper.initData();
	}

	private void initProperties(ServletConfig config) {
		ServletContext context = config.getServletContext();
		InputStream in = context.getResourceAsStream(config.getInitParameter(CommonConstant.RESOURCE_INIT_PATH));
		Properties property = new Properties();
		try {
			property.load(in);

			Object[] keyObjs = property.keySet().toArray();
			for (Object keyObj : keyObjs) {
				String key = (String) keyObj;
				CommonConstant.resCommMap.put(key, property.getProperty(key));
			}

			logger.info("配置文件初始化成功:" + CommonConstant.resCommMap);
		} catch (Exception e) {
			logger.error("配置文件初始化失败", e);
		} finally {
			if (in != null) {
				try {
					in.close();
				} catch (Exception e) {
				}
			}
		}
	}

	

	@Override
	public void destroy() {
	}
}
