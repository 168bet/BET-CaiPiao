/**   
* 文件名称: WebBankHuikuanDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-2 上午11:24:16<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

import org.apache.commons.lang3.StringUtils;
import org.hibernate.SQLQuery;
import org.hibernate.Session;
import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.CpParameter;
import com.mh.entity.TWebThirdPay;
import com.mh.entity.WebBank;
import com.mh.entity.WebBankHuikuan;

/** 
 * 类描述: TODO<br/>汇款流水
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-2 上午11:24:16<br/>
 */
@SuppressWarnings("all")
@Repository
public class WebBankHuikuanDao extends BaseDao<WebBankHuikuan,Integer>{
	
	/**
	 * 统计代理会员存款列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebBankHuikuanTjList(WebBankHuikuan huikuan){

		List<Object> list = new ArrayList<Object>();
		
		String sql ="SELECT date_format(t1.create_time,'%Y-%m-%d') as create_time,SUM(t1.hk_money) AS hk_money FROM t_web_bank_huikuan t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name " +
				" WHERE t1.hk_status=1 AND t1.hk_check_status=1 ";
		
		if(huikuan.getBeginTimeStr().equals(huikuan.getEndTimeStr())){
			sql ="SELECT date_format(t1.create_time,'%H') as create_time ,SUM(t1.hk_money) AS hk_money FROM t_web_bank_huikuan t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name " +
					" WHERE t1.hk_status=1 AND t1.hk_check_status=1 ";
			
		}
		if(StringUtils.isNotBlank(huikuan.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(huikuan.getRelativePath());
		}
		
		
		if (StringUtils.isNotBlank(huikuan.getBeginTimeStr()) && StringUtils.isNotBlank(huikuan.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(huikuan.getBeginTimeStr());
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(huikuan.getEndTimeStr());
		}else if (StringUtils.isNotBlank(huikuan.getBeginTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(huikuan.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(huikuan.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(huikuan.getEndTimeStr());
		}
		
		if(huikuan.getBeginTimeStr().equals(huikuan.getEndTimeStr())){
			sql += "    GROUP BY DATE_FORMAT(t1.create_time, '%H') ";
		}else{
			sql += "    GROUP BY DATE_FORMAT(t1.create_time, '%Y-%m-%d') ";
		}
	 
		List<Map<String,Object>> dataList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		Map<String,Object> valMap = new TreeMap<String,Object>();
		for(int i=0;i<dataList.size();i++){
			Map<String,Object> dataMap = dataList.get(i);
			double val = 0;
			if(dataMap.get("hk_money")!=null){
				val = Double.valueOf(dataMap.get("hk_money").toString());
			}
			valMap.put(dataMap.get("create_time").toString(), val);
		}
		return valMap;
	
	
	}
	
	
	/**
	 * 统计代理会员存款
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public double getWebBankHuikuanTj(WebBankHuikuan huikuan){

		List<Object> list = new ArrayList<Object>();
		
		String sql ="SELECT SUM(t1.hk_money) AS hk_money FROM t_web_bank_huikuan t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name " +
				" WHERE t1.hk_status=1 AND t1.hk_check_status=1 ";
		
		
		if(StringUtils.isNotBlank(huikuan.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(huikuan.getRelativePath());
		}
		
		
		if (StringUtils.isNotBlank(huikuan.getBeginTimeStr()) && StringUtils.isNotBlank(huikuan.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(huikuan.getBeginTimeStr());
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(huikuan.getEndTimeStr());
		}else if (StringUtils.isNotBlank(huikuan.getBeginTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(huikuan.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(huikuan.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(huikuan.getEndTimeStr());
		}
	 
		double hkMoney =0;
		List<Map<String,Object>> valList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		if(valList!=null && valList.size()>0){
			Map<String,Object> valMap = valList.get(0);
			if(valMap.get("hk_money")!=null){
				hkMoney = Double.valueOf(valMap.get("hk_money").toString());
			}
		}
		return hkMoney;
	
	
	}
	
	
	/**
	 * 汇款流水列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * List<WebBankHuikuan>
	 */
	public Page getWebBankHuikuanList(Page page,WebBankHuikuan huikuan){

		List<Object> list = new ArrayList<Object>();
		
		String sql ="SELECT t.hk_order AS hkOrder,t.user_name AS userName,t.hk_type AS hkType,t.hk_money AS hkMoney,t.hk_company_bank AS hkCompayBank, " +
				"date_format(t.hk_time,'%Y-%m-%d %H:%i:%s') as hkTime, if(hk_status=0,'未审核',if(hk_check_status=0,'未通过','通过')) as hkStatus " +
				" FROM t_web_bank_huikuan t WHERE 1=1 ";
		
		if(!StringUtils.isEmpty(huikuan.getUserName())){
			sql += " and  t.user_name=?";
			list.add(huikuan.getUserName());
		}
		
		
		if (StringUtils.isNotBlank(huikuan.getBeginTimeStr()) && StringUtils.isNotBlank(huikuan.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(huikuan.getBeginTimeStr());
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(huikuan.getEndTimeStr());
		}else if (StringUtils.isNotBlank(huikuan.getBeginTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(huikuan.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(huikuan.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(huikuan.getEndTimeStr());
		}
		
 
		//-1全部 0等待审核 1审核未通过 2审核通过
		if(!StringUtils.isEmpty(huikuan.getStatus()) && !"-1".equals(huikuan.getStatus())){
			if("0".equals(huikuan.getStatus())){
				sql += " and t.hk_status=0 ";
			}else if("1".equals(huikuan.getStatus())){
				sql += " and t.hk_status=1 and t.hk_check_status=0  ";
			}else if("2".equals(huikuan.getStatus())){
				sql += " and t.hk_status=1 and t.hk_check_status=1  ";
			}
	 
		}
		
		if(!StringUtils.isEmpty(huikuan.getHkOrder())){
			sql += " and  t.hk_order=?";
			list.add(huikuan.getHkOrder());
		}
		sql += " order by t.create_time desc ";
		
		return this.findPageBySql(page,sql,list.toArray());
	
	
	}
	
	
	/**
	 * 获取银行列表
	 * 方法描述: TODO</br> 
	 * @param userTypeId
	 * @return  
	 * List<WebBank>
	 */
	public List<WebBank> getWebBankList(Integer userTypeId){
		final String sql = "SELECT b.* FROM t_web_bank b,t_link_web_user_bank lb  WHERE lb.user_type_id="+userTypeId.intValue()+" AND lb.user_bank_id=b.id AND b.bank_status = 1  ORDER BY b.id DESC";
		@SuppressWarnings("unchecked")
		List<WebBank> resultList =this.getHibernateTemplate().executeFind(new HibernateCallback() {
			public Object doInHibernate(Session session){
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(sql).addEntity(WebBank.class);
				return sqlQuery.list();
			}
		});
		
		return resultList;
		
	}
	
	
	/**
	 * 获取第三方支付列表
	 * 方法描述: TODO</br> 
	 * @param userTypeId
	 * @return  
	 * List<WebBank>
	 */
	public List<TWebThirdPay> getWebThirdPayList(Integer userTypeId){
		final String sql = "SELECT b.* FROM t_web_third_pay b,t_link_web_user_third_pay lb  WHERE lb.user_type_id="+userTypeId.intValue()+" AND lb.user_third_pay_id=b.id AND b.third_status = 1  ORDER BY b.id DESC";
		List<TWebThirdPay> resultList =this.getHibernateTemplate().executeFind(new HibernateCallback() {
			public Object doInHibernate(Session session){
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(sql).addEntity(TWebThirdPay.class);
				return sqlQuery.list();
			}
		});
		
		return resultList;
		
	}
	
	/**
	 * 统计汇款
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param startTimeStr
	 * @param endTimeStr
	 * @return  
	 * int
	 */
	public Map<String, Integer> getWebBankHuikuanTj(String userName,String currDateStr){
		List<Object> list = new ArrayList<Object>();
		String sql = "SELECT MAX(total_times) AS totalTimes, MAX(day_times) AS dayTimes FROM t_web_bank_huikuan WHERE hk_model=1 and hk_status=1 ";
		if(!StringUtils.isEmpty(userName)){
			sql += " and user_name=? ";
			list.add(userName);
		}
		
		Map<String, Object> resultMap = this.getJdbcTemplate().queryForMap(sql, list.toArray());
		
		int totalTimes = 0;
		if(null!=resultMap && null != resultMap.get("totalTimes")){
			totalTimes  = (Integer)resultMap.get("totalTimes");
		}
		
		if(StringUtils.isNotEmpty(currDateStr)){
			sql += " and STR_TO_DATE(create_time,'%Y-%m-%d')= ? ";
			list.add(currDateStr);
		}
		
		resultMap = this.getJdbcTemplate().queryForMap(sql, list.toArray());
		
		int dayTimes = 0;
		if(null!=resultMap && null != resultMap.get("dayTimes")){
			dayTimes  = (Integer)resultMap.get("dayTimes");
		}
		
		Map<String, Integer> map = new HashMap<String, Integer>();
		map.put("totalTimes", totalTimes);
		map.put("dayTimes", dayTimes);
		
		return map;
		
	}
	
	
	

}
