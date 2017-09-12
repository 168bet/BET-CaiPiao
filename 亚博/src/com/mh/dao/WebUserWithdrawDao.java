/**   
* 文件名称: WebUserWithdrawDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-2 下午2:06:48<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.constants.WebConstants;
import com.mh.commons.orm.Page;
import com.mh.commons.orm.BaseDao;
import com.mh.entity.CpParameter;
import com.mh.entity.WebUserWithdraw;

/** 
 * 类描述: TODO<br/>出款记录Dao
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-2 下午2:06:48<br/>
 */

@SuppressWarnings("all")
@Repository
public class WebUserWithdrawDao  extends BaseDao<WebUserWithdraw,Integer>{
	
	/**
	 * 统计会员代理取款列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebUserWithdrawTjList(WebUserWithdraw userWithdraw){
		List<Object> list = new ArrayList<Object>();
		
		String sql = " SELECT date_format(t1.create_time,'%Y-%m-%d') as create_time,SUM(t1.user_withdraw_money) AS user_withdraw_money FROM t_web_user_withdraw t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name WHERE  t1.status=1 AND t1.check_status=1 ";
		if(userWithdraw.getBeginTimeStr().equals(userWithdraw.getEndTimeStr())){
			sql = " SELECT date_format(t1.create_time,'%H') as create_time,SUM(t1.user_withdraw_money) AS user_withdraw_money FROM t_web_user_withdraw t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name WHERE  t1.status=1 AND t1.check_status=1 ";
		}
		
		
		if(StringUtils.isNotBlank(userWithdraw.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(userWithdraw.getRelativePath());
		}
		
		if (StringUtils.isNotBlank(userWithdraw.getBeginTimeStr()) && StringUtils.isNotBlank(userWithdraw.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(userWithdraw.getBeginTimeStr());
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(userWithdraw.getEndTimeStr());
		}else if (StringUtils.isNotBlank(userWithdraw.getBeginTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(userWithdraw.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(userWithdraw.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(userWithdraw.getEndTimeStr());
		}
		if(userWithdraw.getBeginTimeStr().equals(userWithdraw.getEndTimeStr())){
			sql += "    GROUP BY DATE_FORMAT(t1.create_time, '%H') ";
		}else{
			sql += "    GROUP BY DATE_FORMAT(t1.create_time, '%Y-%m-%d') ";
		}
	
		List<Map<String,Object>> dataList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		Map<String,Object> valMap = new TreeMap<String,Object>();
		for(int i=0;i<dataList.size();i++){
			Map<String,Object> dataMap = dataList.get(i);
			double val = 0;
			if(dataMap.get("user_withdraw_money")!=null){
				val = Double.valueOf(dataMap.get("user_withdraw_money").toString());
			}
			valMap.put(dataMap.get("create_time").toString(), val);
		}
		return valMap;
	}
	
	/**
	 * 统计会员代理取款
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public double getWebUserWithdrawTj(WebUserWithdraw userWithdraw){
		List<Object> list = new ArrayList<Object>();
		
		String sql = " SELECT SUM(t1.user_withdraw_money) AS user_withdraw_money FROM t_web_user_withdraw t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name WHERE  t1.status=1 AND t1.check_status=1 ";
		
		if(StringUtils.isNotBlank(userWithdraw.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(userWithdraw.getRelativePath());
		}
		
		if (StringUtils.isNotBlank(userWithdraw.getBeginTimeStr()) && StringUtils.isNotBlank(userWithdraw.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(userWithdraw.getBeginTimeStr());
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(userWithdraw.getEndTimeStr());
		}else if (StringUtils.isNotBlank(userWithdraw.getBeginTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(userWithdraw.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(userWithdraw.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(userWithdraw.getEndTimeStr());
		}
	
		double withDrawMoney =0;
		List<Map<String,Object>> valList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		if(valList!=null && valList.size()>0){
			Map<String,Object> valMap = valList.get(0);
			if(valMap.get("user_withdraw_money")!=null){
				withDrawMoney = Double.valueOf(valMap.get("user_withdraw_money").toString());
			}
		}
		return withDrawMoney;
	}
	
	
	
	/**
	 * 获取出款流水列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * List<WebUserWithdraw>
	 */
	public Page getWebUserWithdrawList(Page page, WebUserWithdraw userWithdraw){
		List<Object> list = new ArrayList<Object>();
		
		String sql = "SELECT t.user_order AS userOrder,t.user_name AS userName,t.user_withdraw_money AS withdrawMoney  " +
				" ,DATE_FORMAT(t.create_time,'%Y-%m-%d %H:%i:%s') AS createTime,t.status,t.check_status, if(t.withdraw_type='11','会员取款','系统扣款') as withdrawType,t.user_bank_info as userBankInfo  FROM t_web_user_withdraw t WHERE 1=1  ";
		if(!StringUtils.isEmpty(userWithdraw.getUserName())){
			sql += " and  t.user_name=?";
			list.add(userWithdraw.getUserName());
		}
		
		if (StringUtils.isNotBlank(userWithdraw.getBeginTimeStr()) && StringUtils.isNotBlank(userWithdraw.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(userWithdraw.getBeginTimeStr());
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(userWithdraw.getEndTimeStr());
		}else if (StringUtils.isNotBlank(userWithdraw.getBeginTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(userWithdraw.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(userWithdraw.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(userWithdraw.getEndTimeStr());
		}
		
		//-1全部 0等待审核 1审核未通过 2审核通过
		if(!StringUtils.isEmpty(userWithdraw.getWithdrawStatus()) && !"-1".equals(userWithdraw.getWithdrawStatus())){
			if("0".equals(userWithdraw.getWithdrawStatus())){
				sql += " and t.status=0 ";
			}else if("1".equals(userWithdraw.getWithdrawStatus())){
				sql += " and t.status=1 and t.check_status=2  ";
			}else if("2".equals(userWithdraw.getWithdrawStatus())){
				sql += " and t.status=1 and t.check_status=1  ";
			}
	 
		}
		
		if(!StringUtils.isEmpty(userWithdraw.getUserOrder())){
			sql += " and  t.user_order=?";
			list.add(userWithdraw.getUserOrder());
		}
		
		
		sql += " order by t.create_time desc ";
		
		return this.findPageBySql(page,sql,list.toArray());
	}
	
	
	
	
	public Map<String, Integer> countWithdrawSuccessTimes(WebUserWithdraw userWithdraw){
		List<Object> list = new ArrayList<Object>();
		String sql = " SELECT  MAX(total_times) AS totalTimes, MAX(day_times) AS dayTimes FROM t_web_user_withdraw  WHERE 1 = 1 ";
		if(!StringUtils.isEmpty(userWithdraw.getUserName())){
			sql +=" and user_name=? ";
			list.add(userWithdraw.getUserName());
		}
		sql +=" and withdraw_type=? ";
		list.add(WebConstants.T_WEB_MA_TYPE_11);// 会员提款
		
		sql +=" and check_status=? ";
		list.add(WebConstants.T_WEB_USER_WITHDRAW_CHECKED_STATUS_1);// 审核通过
		
		Map<String, Object> resultMap = this.getJdbcTemplate().queryForMap(sql, list.toArray());
		
		int totalTimes = 0;
		if(null!=resultMap && null != resultMap.get("totalTimes")){
			totalTimes  = (Integer)resultMap.get("totalTimes");
		}
		
		if(StringUtils.isNotEmpty(userWithdraw.getBeginTimeStr())){
			sql += " and STR_TO_DATE(create_time,'%Y-%m-%d')=? ";
			list.add(userWithdraw.getBeginTimeStr());
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
