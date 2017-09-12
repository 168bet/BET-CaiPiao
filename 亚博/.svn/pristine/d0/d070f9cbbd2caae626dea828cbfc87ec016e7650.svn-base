package com.mh.dao;

import java.util.List;

import org.apache.commons.collections.CollectionUtils;
import org.hibernate.SQLQuery;
import org.hibernate.Session;
import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.WebKjPay;

@Repository
public class WebKjPayDao extends BaseDao<WebKjPay, Integer>{
	/**
	 * 支付类型查找
	 * @param type
	 * @return
	 */
	public WebKjPay getKjPay(final Integer payType,final Integer userType){
		String sql = "SELECT  * FROM t_web_kj_pay  WHERE 1 = 1  AND id IN ";
		sql += " (SELECT user_kj_pay_id FROM t_link_web_kj_pay  ";
		sql += " WHERE STATUS = 1  AND user_kj_pay_type = ?  AND user_type_id = ?) ";
		sql += " AND STATUS = 1 ORDER BY id DESC LIMIT 1 ";
 
		final String s = sql;
		List<WebKjPay> list =this.getHibernateTemplate().executeFind(new HibernateCallback() {
			public Object doInHibernate(Session session){
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(s).addEntity(WebKjPay.class);
				sqlQuery.setParameter(0, payType);
				sqlQuery.setParameter(1, userType);
				return sqlQuery.list();
			}
		});
		if(CollectionUtils.isNotEmpty(list)){
			return list.get(0);
		}
		return null;
	}
	
	public List<WebKjPay> getKjPayList(){
		String hql = " from WebKjPay where status = 1";
		return this.getHibernateTemplate().find(hql);
	}
	
	public int getPayCount(Integer type){
		String hql = " from WebKjPay where status = 1 and payType = ?";
		return this.getHibernateTemplate().find(hql,new Object[]{type}).size();
	}
}
