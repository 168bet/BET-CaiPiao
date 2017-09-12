package com.mh.web.servlet;

import javax.servlet.http.HttpSession;
import javax.servlet.http.HttpSessionEvent;
import javax.servlet.http.HttpSessionListener;

import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.context.WebApplicationContext;
import org.springframework.web.context.support.WebApplicationContextUtils;


/**
 * session 监听器
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-25 上午10:24:05<br/>
 */
public class MySessionListener implements HttpSessionListener  {
	
    @Override
	public void sessionCreated(HttpSessionEvent httpSessionEvent) {
		MySessionContext.addSession(httpSessionEvent.getSession());
	}

	@Override
	public void sessionDestroyed(HttpSessionEvent httpSessionEvent) {
		HttpSession session = httpSessionEvent.getSession();
		this.updateUser(session);
		MySessionContext.delSession(session);
	}
	
	
	public void updateUser(HttpSession session){
		WebApplicationContext wac = WebApplicationContextUtils.getWebApplicationContext(session.getServletContext());
		JdbcTemplate jdbcTemplate = (JdbcTemplate) wac.getBean("jdbcTemplate");
		String sql = " update t_web_user set user_login_status=?,user_logon_time=SYSDATE() where user_session_id=?";
		jdbcTemplate.update(sql, new Object[]{"0",session.getId()});
		
	}


}
