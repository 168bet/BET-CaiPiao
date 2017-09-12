/**   
* 文件名称: WebDama.java<br/>
* 版本号: V1.0<br/>   
* 创建人: zoro<br/>  
* 创建时间 : 2015-7-6 下午4:25:46<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.List;

import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.TWebDama;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-7-6 下午4:25:46<br/>
 */
@SuppressWarnings("all")
@Repository
public class WebDamaDao extends BaseDao<TWebDama,Integer> {
	
	/***
	 * 打码量查询
	 * 方法描述: TODO</br>
	 * 创建人: zoro<br/> 
	 * @param dama
	 * @return  
	 * List<TWebDama>
	 */
	public List<TWebDama> findWebDama(TWebDama dama){
		List<Object> list = new ArrayList<Object>();
		
		String hql = " from TWebDama where userName=? ";
		list.add(dama.getUserName());
		
		return this.find(hql, list.toArray());
	}
	
	public void saveHibernate(List<TWebDama> dama){
		this.getHibernateTemplate().saveOrUpdateAll(dama);
	}
	
	public void saveJdbcTemplate(List<TWebDama> dama){
		
		for (int i = 0; i < dama.size(); i++) {
			String sql = "insert into t_web_dama(id,user_name) values ('"+dama.get(i).getId()+"','"+dama.get(i).getUserName()+"')";
			this.getJdbcTemplate().execute(sql);
		}
	}
	
}
