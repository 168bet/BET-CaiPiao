/**   
* 文件名称: WebUserDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午1:04:03<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.conf.CommonConstant;
import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.WebUser;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-5 下午1:04:03<br/>
 */
@SuppressWarnings("all")
@Repository
public class WebUserDao extends BaseDao<WebUser,Integer>{
	
	
	/**
	 * 会员列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param webUser
	 * @return  
	 * Page
	 */
	public Page findPage(Page page, WebUser webUser) {
		List<Object> list = new ArrayList<Object>();

		String sql = "SELECT t.user_name AS userName,IF(t.user_type=0,'会员','代理')  AS userType,t.user_money AS userMoney, " +
				"IFNULL(DATE_FORMAT(t.user_last_login_time,'%Y-%m-%d %H:%i:%s'),'尚未登录') AS userLastLoginTime,t.pc28_point AS pc28Point,t.cp_point AS cpPoint " +
				"FROM t_web_user t WHERE 1=1  ";
		
		if(!StringUtils.isEmpty(webUser.getUserName())){
			sql += " and t.user_name=? ";
			list.add(webUser.getUserName().replaceAll(" ", "").replaceAll("'", "''").trim());
		}
		
		if(!StringUtils.isEmpty(webUser.getUserAgent())){
			sql += " and t.user_agent=? ";
			list.add(webUser.getUserAgent());
		}
		
		
		if (StringUtils.isNotBlank(webUser.getFromMoney()) && StringUtils.isNotBlank(webUser.getToMoney())) {
			sql += " and t.user_money >= ?";
			list.add(webUser.getFromMoney());
			sql += " and t.user_money <= ?";
			list.add(webUser.getToMoney());
		}else if (StringUtils.isNotBlank(webUser.getFromMoney())) {
			sql += " and t.user_money >= ?";
			list.add(webUser.getFromMoney());
		}else if (StringUtils.isNotBlank(webUser.getToMoney())) {
			sql += " and t.user_money <= ?";
			list.add(webUser.getToMoney());
		}
	 
 
		/** 美东时间 **/
		if (StringUtils.isNotBlank(webUser.getBeginTimeStr()) && StringUtils.isNotBlank(webUser.getEndTimeStr())) {
			sql += " and date_format(t.user_last_login_time,'%Y-%m-%d') >= ?";
			list.add(webUser.getBeginTimeStr());
			sql += " and date_format(t.user_last_login_time,'%Y-%m-%d') <= ?";
			list.add(webUser.getEndTimeStr());
		}else if (StringUtils.isNotBlank(webUser.getBeginTimeStr())) {
			sql += " and date_format(t.user_last_login_time,'%Y-%m-%d') >= ?";
			list.add(webUser.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(webUser.getEndTimeStr())) {
			sql += " and date_format(t.user_last_login_time,'%Y-%m-%d') <= ?";
			list.add(webUser.getEndTimeStr());
		}
		
		
		sql+=" order by t.create_time desc  ";
		return findPageBySql(page, sql, list.toArray());
	}
	
	
	

	
	/**
	 * 根据用户名查询用户信息
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * WebUser
	 */
	public WebUser findWebrUseByUserName(String userName){
		String hql = "from WebUser where userName=? ";
		List<WebUser> list = this.getHibernateTemplate().find(hql,new Object[]{userName});
		WebUser webUser = null;
		if(list!=null && list.size()>0){
			webUser = list.get(0);
		}
		return webUser;
	}
	
 
	/**
	 * @Description: 更新用户账户余额
	 * @param  String userName,double money
	 * @return int
	 * @author Andy
	 * @date 2015-6-9
	 */
	public int updateWebUserForMoney(String userName,double money){
		logger.info(userName+"充值金额:"+money);
		String sql=" update t_web_user set user_money=user_money+"+money+" where LOWER(user_name)='"+userName+"' and if(user_money+"+money+">=0,true,false)";
		int rows = this.getJdbcTemplate().update(sql);
		logger.info("执行:"+sql);
		logger.info("返回行数："+rows);
		
		return rows;
		
	}
	
 
	/**
	 * 获取用户余额
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * double
	 */
	public double getWebUserMoney(String userName){
		String sql = "SELECT ROUND(user_money,2) as user_money  FROM t_web_user WHERE LOWER(user_name)=? ";
		List<Map<String,Object>> list = this.getJdbcTemplate().queryForList(sql, new Object[]{userName});
		double userMoney =0;
		if(list!=null && list.size()>0){
			Map<String,Object> map = list.get(0);
			if(map.get("user_money")!=null){
				userMoney = Double.valueOf(map.get("user_money").toString());
			}
		}
		return userMoney;
	}
	
	
	/**
	 * 团队余额
	 * 方法描述: TODO</br> 
	 * @param relativePath
	 * @return  
	 * double
	 */
	public double getTeamUserMoney(String relativePath){
		String sql = " SELECT ROUND(user_money,2) as user_money FROM t_web_user t where t.relative_path like ? ";
		List<Map<String,Object>> list = this.getJdbcTemplate().queryForList(sql, new Object[]{relativePath+"%"});
		double userMoney =0;
		if(list!=null && list.size()>0){
			Map<String,Object> map = list.get(0);
			if(map.get("user_money")!=null){
				userMoney = Double.valueOf(map.get("user_money").toString());
			}
		}
		return userMoney;
		
	}
	
	
	/**
	 * 团队人数
	 * 方法描述: TODO</br> 
	 * @param relativePath
	 * @return  
	 * int
	 */
	public int getTeamUserTotal(String relativePath){
		String sql = " SELECT COUNT(*) AS total FROM t_web_user t where t.relative_path<>'"+relativePath+"' and t.relative_path like ? ";
		return this.getJdbcTemplate().queryForInt(sql, new Object[]{relativePath+"%"});
		
	}
	
	
	/**
	 * 统计会员数
	 * 方法描述: TODO</br> 
	 * @param webUser
	 * @return  
	 * int
	 */
	public int getWebUserTotal(WebUser webUser){
		String sql = " SELECT COUNT(*) AS total FROM t_web_user t where 1=1 ";
		List<Object> list = new ArrayList<Object>();
		if(StringUtils.isNotBlank(webUser.getUserAgent())){
			sql += " and t.user_agent=?";
			list.add(webUser.getUserAgent());
		}
		
		if(StringUtils.isNotBlank(webUser.getRelativePath())){
			sql += " and t.relative_path like ?";
			list.add(webUser.getRelativePath()+"%");
		}
		
		if (StringUtils.isNotBlank(webUser.getBeginTimeStr()) && StringUtils.isNotBlank(webUser.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d') >= ?";
			list.add(webUser.getBeginTimeStr());
			sql += " and date_format(t.create_time,'%Y-%m-%d') <= ?";
			list.add(webUser.getEndTimeStr());
		}else if (StringUtils.isNotBlank(webUser.getBeginTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d') >= ?";
			list.add(webUser.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(webUser.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d') <= ?";
			list.add(webUser.getEndTimeStr());
		}
		return this.getJdbcTemplate().queryForInt(sql, list.toArray());
		
	}
	
	/**
	 * 统计会员数
	 * 方法描述: TODO</br> 
	 * @param webUser
	 * @return  
	 * int
	 */
	public Map<String,Object> getWebUserTotalList(WebUser webUser){
		String sql = " SELECT date_format(t.create_time,'%Y-%m-%d') as create_time,COUNT(*) AS total FROM t_web_user t where 1=1 ";
		if(webUser.getBeginTimeStr().equals(webUser.getEndTimeStr())){
			sql = " SELECT date_format(t.create_time,'%H') as create_time,COUNT(*) AS total FROM t_web_user t where 1=1 ";
		}
		
		List<Object> list = new ArrayList<Object>();
		if(StringUtils.isNotBlank(webUser.getUserAgent())){
			sql += " and t.user_agent=?";
			list.add(webUser.getUserAgent());
		}
		
		if(StringUtils.isNotBlank(webUser.getRelativePath())){
			sql += " and t.relative_path like ?";
			list.add(webUser.getRelativePath()+"%");
		}
		
		if (StringUtils.isNotBlank(webUser.getBeginTimeStr()) && StringUtils.isNotBlank(webUser.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d') >= ?";
			list.add(webUser.getBeginTimeStr());
			sql += " and date_format(t.create_time,'%Y-%m-%d') <= ?";
			list.add(webUser.getEndTimeStr());
		}else if (StringUtils.isNotBlank(webUser.getBeginTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d') >= ?";
			list.add(webUser.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(webUser.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d') <= ?";
			list.add(webUser.getEndTimeStr());
		}
		if(webUser.getBeginTimeStr().equals(webUser.getEndTimeStr())){
			sql += "    GROUP BY DATE_FORMAT(t.create_time, '%H') ";
		}else{
			sql += "    GROUP BY DATE_FORMAT(t.create_time, '%Y-%m-%d') ";
		}
		
		List<Map<String,Object>> dataList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		Map<String,Object> valMap = new TreeMap<String,Object>();
		for(int i=0;i<dataList.size();i++){
			Map<String,Object> dataMap = dataList.get(i);
			int val = 0;
			if(dataMap.get("total")!=null){
				val = Integer.valueOf(dataMap.get("total").toString());
			}
			valMap.put(dataMap.get("create_time").toString(), val);
		}
		return valMap;
		
	}
	
	
 
	/**
	 * @Description: 修改用户密码
	 * @param  String userName,String newPassword
	 * @return int
	 * @author Channel
	 * @date 2015-7-7
	 */
	public int updatePassword(String newPassword,String userName){
		String userFlag = CommonConstant.resCommMap.get(CommonConstant.WEB_USER_FLAG);
		String hql="update WebUser set userPassword=? where LOWER(userName)=? and userFlag=? ";
		Long row=super.executeUpdate(hql,newPassword,userName,userFlag);
		return row.intValue();
	}
	/**
	 * @Description: 修改用户资金密码
	 * @param  String userName,String newUserWithdrawPassword
	 * @return int
	 * @author Channel
	 * @date 2015-7-7
	 */
	public int updateMoneyPassword(String newUserWithdrawPassword,String userName){
		String userFlag = CommonConstant.resCommMap.get(CommonConstant.WEB_USER_FLAG);
		String hql="update WebUser set userWithdrawPassword=? where LOWER(userName)=? and userFlag=? ";
		Long row=super.executeUpdate(hql,newUserWithdrawPassword,userName,userFlag);
		return row.intValue();
	}
	
	
	public int updateWebUser(String userName,List<String> fieldList,List<Object> valList){
		StringBuffer buffer = new StringBuffer("");
		for(int i=0;i<fieldList.size();i++){
			String field=fieldList.get(i);
			if(i>0){
				buffer.append(",");
			}
			buffer.append(field);
			buffer.append("=");
			buffer.append("?");
		}
		String sql = " update t_web_user set "+buffer.toString()+" where user_name='"+userName+"' ";
		System.out.println(sql);
 
		return  this.getJdbcTemplate().update(sql, valList.toArray());
	}
 
	
}
