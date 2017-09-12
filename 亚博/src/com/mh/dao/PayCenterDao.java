package com.mh.dao;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

import org.apache.commons.collections.CollectionUtils;
import org.hibernate.SQLQuery;
import org.hibernate.Session;
import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.TLinkWebKjPay;
import com.mh.entity.TWebBankHuikuan;
import com.mh.entity.TWebThirdPay;
import com.mh.entity.TWebThirdPayKj;
import com.mh.entity.WebGongGao;
import com.sun.faces.util.CollectionsUtils;
@SuppressWarnings("all")
@Repository
public class PayCenterDao extends BaseDao<TWebThirdPay,Integer>{
	/**
	 * 
	 * @Description: 获取会员类型所绑定的第三方支付信息
	 * @param    
	 * @return List<TWebThirdPay>  
	 * @throws
	 * @author Andy
	 * @date 2015-6-7
	 */
	//select t.* from T_WEB_THIRD_PAY where t.id in (select t1.USER_THIRD_PAY_ID  from T_LINK_WEB_USER_THIRD_PAY t1 where t1.USER_TYPE_ID= ) and t.THIRD_STATUS=1 order by t.id desc
	public List<TWebThirdPay> findTWebThirdPay(Integer usertypeId){
		List<TWebThirdPay> list=new ArrayList<TWebThirdPay>();
		
		StringBuffer sql=new StringBuffer(" from TWebThirdPay t where 1=1 ");
		sql.append(" and t.id in (select t1.userThirdPayId from TLinkWebUserThirdPay t1 where t1.userTypeId="+usertypeId+")");	
		sql.append(" and t.thirdStatus=1 order by t.id desc");
		list=this.getHibernateTemplate().find(sql.toString());
		return list;
	}
	
	public TWebThirdPayKj getTWebThirdPayKj(final Integer payType,final Integer userType){
		List<TWebThirdPayKj> list=new ArrayList<TWebThirdPayKj>();
		/*String sql = "SELECT * FROM t_web_third_pay_kj WHERE 1 = 1 AND third_pay_id IN(";
		sql += " SELECT id FROM t_web_third_pay WHERE 1 = 1 AND id IN(";
		sql += " SELECT third_pay_id FROM t_web_third_pay_kj WHERE id IN (SELECT user_third_pay_kj_id FROM t_link_web_third_pay_kj WHERE 1 = 1 AND STATUS = 1";
		sql += " AND user_type_id = ? AND user_pay_type = ?))";
		sql += " AND third_status = 1) AND pay_type = ? AND STATUS = 1";
		sql += " ORDER BY id DESC limit 1";*/
		String sql = "SELECT * FROM t_web_third_pay_kj k1";
		sql += " JOIN t_link_web_third_pay_kj k2 ON k1.id = k2.user_third_pay_kj_id";
		sql += " JOIN t_web_third_pay k3 ON k1.third_pay_id = k3.id";
		sql += " WHERE 1 = 1 AND k1.status = 1 AND k2.status = 1 AND k3.third_status = 1";
		sql += " AND k2.user_pay_type = ? AND k2.user_type_id = ?";
		sql += " ORDER BY k1.id DESC LIMIT 1";
		final String s = sql;
		list =this.getHibernateTemplate().executeFind(new HibernateCallback() {
			public Object doInHibernate(Session session){
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(s).addEntity(TWebThirdPayKj.class);
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
	
	public List<TLinkWebKjPay> getTWebKjPay(final Integer usertype,final Integer payType){
		/*List<Object> list = new ArrayList<Object>();
		StringBuffer sql=new StringBuffer(" from TLinkWebKjPay t where 1=1 ");
		sql.append(" and t.userKjPayId in (select id from WebKjPay where status = 1)");
		sql.append(" and t.status = 1");
		sql.append(" and t.userTypeId = ?");
		list.add(usertype);
		if(null != payType){
			sql.append(" and userKjPayId = ?");
			list.add(payType);
		}
		return this.getHibernateTemplate().find(sql.toString(),list.toArray());*/
		String sql = "SELECT * FROM t_link_web_kj_pay kjpay ";
		sql += " LEFT JOIN t_web_kj_pay pay ON kjpay.user_kj_pay_id = pay.id WHERE 1 = 1 ";
		sql += " AND pay.status = 1 AND kjpay.status = 1 AND kjpay.user_type_id = ? AND kjpay.user_kj_pay_type = ? ORDER BY kjpay.id DESC LIMIT 1";
		final String s = sql;
		List<TLinkWebKjPay> list =this.getHibernateTemplate().executeFind(new HibernateCallback() {
			public Object doInHibernate(Session session){
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(s).addEntity(TLinkWebKjPay.class);
				sqlQuery.setParameter(0, usertype);
				sqlQuery.setParameter(1, payType);
				return sqlQuery.list();
			}
		});
		return list;
	}
	
	
	public TWebThirdPay findTWebThirdPayById(int id) {
		String hql=" from TWebThirdPay t where 1=1 and t.id="+id;
		List<TWebThirdPay> list=this.getHibernateTemplate().find(hql);
		return list.size()>0?list.get(0):null;
	}
	
	/**
	 * 
	 * @Description: 第三方支付订单信息入库
	 * @param    
	 * @return void  
	 * @throws
	 * @author Andy
	 * @date 2015-6-7
	 */
	public void saveBankHuikuan(TWebBankHuikuan entity){
		this.getHibernateTemplate().save(entity);
	}
	/**
	 * 
	 * @Description: 根据订单号查找订单支付信息
	 * @param    
	 * @return TWebBankHuikuan  
	 * @throws
	 * @author Andy
	 * @date 2015-6-9
	 */
	public TWebBankHuikuan loadTWebBankHuikuanForBillno(String billno,int hkStatus){
		List<TWebBankHuikuan> list=new ArrayList<TWebBankHuikuan>();
		String hql=" from TWebBankHuikuan t where 1=1 and t.hkOrder=? and t.hkStatus=?";
		list=this.getHibernateTemplate().find(hql,new Object[]{billno,hkStatus});
		return list.size()>0?list.get(0):null;
	}
 
	
	
	/**
	 * @Description: 修改银行汇款记录信息
	 * @param    
	 * @return int
	 * @author Andy
	 * @date 2015-6-10
	 */
	public int updateTWebBankHuikuanForPay(TWebBankHuikuan info,String order,int checkStatus,int status,String userName){
		/*StringBuffer hql=new StringBuffer("update TWebBankHuikuan ");
		StringBuffer setBuf=new StringBuffer(" set ");
		setBuf.append("hkCheckStatus=?");
		setBuf.append(",hkStatus=?");
		setBuf.append(",hkCheckTime=?");
		setBuf.append(",modifyTime=?");
		setBuf.append(",remark=?");
		setBuf.append(",hkOnlinePayNo=?");
		hql.append(setBuf.toString());
		
		StringBuffer whereBuf=new StringBuffer(" where 1=1 ");
		whereBuf.append(" and hkOrder=?");
		whereBuf.append(" and hkCheckStatus=?");
		whereBuf.append(" and hkStatus=?");
		whereBuf.append(" and userName=?");
		hql.append(whereBuf.toString());
		
		List<Object> list=new ArrayList<Object>();
		list.add(info.getHkCheckStatus());
		list.add(info.getHkStatus());
		list.add(info.getHkCheckTime());
		list.add(info.getModifyTime());
		list.add(info.getRemark());
		list.add(info.getHkOnlinePayNo());
		
		list.add(order);
		list.add(checkStatus);
		list.add(status);
		list.add(userName);
		
		return executeUpdateForAndy(hql.toString(), list.toArray());*/
		
		String sql = "update T_WEB_BANK_HUIKUAN set hk_check_status=?,hk_status=?,hk_check_time=?,modify_time=?,remark=?,hk_online_pay_no=?  ";
		 
		sql += "  where hk_order=? and hk_check_status=? and hk_status=? and user_name=? ";
		List<Object> list=new ArrayList<Object>();
		list.add(info.getHkCheckStatus());
		list.add(info.getHkStatus());
		list.add(info.getHkCheckTime());
		list.add(info.getModifyTime());
		list.add(info.getRemark());
		list.add(info.getHkOnlinePayNo());
		
		list.add(order);
		list.add(checkStatus);
		list.add(status);
		list.add(userName);
		return this.getJdbcTemplate().update(sql, list.toArray());
	}
	
}
