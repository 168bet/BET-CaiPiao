/**   
* 文件名称: DataGatherHelper.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-26 下午7:03:06<br/>
*/  
package com.mh.web.job;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.orm.hibernate3.HibernateTemplate;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-26 下午7:03:06<br/>
 */
public class ResourceDataHelper {

	private static final Logger logger = LoggerFactory.getLogger(ResourceDataHelper.class);
	
	private JdbcTemplate jdbcTemplate;
	
	private HibernateTemplate hibernateTemplate;
	
 
	
	public  synchronized void initData(){
		logger.info("***********初始化配置表开始***********");
		try{
			getBaseData();
		}catch(Exception e){
			logger.info("初始化数据出错...");
			e.printStackTrace();
		}
		logger.info("***********初始化配置表结束***********");
	}
	
	
	/**
	 * 初始化
	 * 方法描述: TODO</br>   
	 * void
	 */
	public  synchronized void getBaseData(){	
	}
	
	public ResourceDataHelper(JdbcTemplate jdbcTemplate,
			HibernateTemplate hibernateTemplate) {
		super();
		this.jdbcTemplate = jdbcTemplate;
		this.hibernateTemplate = hibernateTemplate;
	}

	public JdbcTemplate getJdbcTemplate() {
		return jdbcTemplate;
	}

	public void setJdbcTemplate(JdbcTemplate jdbcTemplate) {
		this.jdbcTemplate = jdbcTemplate;
	}

	public HibernateTemplate getHibernateTemplate() {
		return hibernateTemplate;
	}

	public void setHibernateTemplate(HibernateTemplate hibernateTemplate) {
		this.hibernateTemplate = hibernateTemplate;
	}
	
	
}
