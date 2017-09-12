package com.mh.dao;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.WebBindEmail;


@SuppressWarnings("all")
@Repository
public class WebBindEmailDao extends BaseDao<WebBindEmail,Integer>{
	
	public int addEntity(List<Object> list){
		String sql = "insert into t_web_bind_email(user_name,is_enable,user_email,create_time) values(?,?,?,?)";
		int i = this.getJdbcTemplate().update(sql, list.toArray());
		return i;
	}
	
	public int updateBindEmail(List<Object> list){
		String sql = "update t_web_bind_email set user_email=? ,is_enable=? , modify_time = ? where user_name = ?";
		int i = this.getJdbcTemplate().update(sql, list.toArray());
		return i;
	}
	
	public WebBindEmail selectWebBindEmail(String userName){//t_web_bind_email表的每个用户只能一条数据
		String hql = "from WebBindEmail where userName=?";
		List<WebBindEmail> list =  this.getHibernateTemplate().find(hql,new Object[]{userName});
		WebBindEmail BindEmail = null;
		if(list!=null&&list.size()>0){
			BindEmail = list.get(0);
		}
		return BindEmail;
	}
	
	

}
