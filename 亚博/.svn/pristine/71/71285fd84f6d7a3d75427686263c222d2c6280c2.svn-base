/**   
* 文件名称: WebWateRecordDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-8 下午3:26:28<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.WebWateRecord;

/** 
 * 返水Dao接口
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-8 下午3:26:28<br/>
 */

@Repository
public class WebWateRecordDao extends BaseDao<WebWateRecord,Integer>{
	
	
	

	/**
	 * 
	 * 方法描述: TODO</br> 
	 * @param webWateRecord
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebUserWithdrawTjList(WebWateRecord webWateRecord){
		List<Object> list = new ArrayList<Object>();
		
		String sql = " SELECT date_format(t1.create_time,'%Y-%m-%d') as create_time,SUM(t1.back_money) AS back_money FROM t_web_water_record t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name WHERE  1=1 ";
		if(webWateRecord.getBeginTimeStr().equals(webWateRecord.getEndTimeStr())){
			sql = " SELECT  date_format(t1.create_time,'%H') as create_time,SUM(t1.back_money) AS back_money FROM t_web_water_record t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name WHERE  1=1 ";
			
		}
		
		
		if(StringUtils.isNotBlank(webWateRecord.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(webWateRecord.getRelativePath());
		}
		
		if (StringUtils.isNotBlank(webWateRecord.getBeginTimeStr()) && StringUtils.isNotBlank(webWateRecord.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(webWateRecord.getBeginTimeStr());
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(webWateRecord.getEndTimeStr());
		}else if (StringUtils.isNotBlank(webWateRecord.getBeginTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(webWateRecord.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(webWateRecord.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(webWateRecord.getEndTimeStr());
		}
		
		if(webWateRecord.getBeginTimeStr().equals(webWateRecord.getEndTimeStr())){
			sql += "    GROUP BY DATE_FORMAT(t1.create_time, '%H') ";
		}else{
			sql += "    GROUP BY DATE_FORMAT(t1.create_time, '%Y-%m-%d') ";
		}
	
		List<Map<String,Object>> dataList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		Map<String,Object> valMap = new TreeMap<String,Object>();
		for(int i=0;i<dataList.size();i++){
			Map<String,Object> dataMap = dataList.get(i);
			double val = 0;
			if(dataMap.get("back_money")!=null){
				val = Double.valueOf(dataMap.get("back_money").toString());
			}
			valMap.put(dataMap.get("create_time").toString(), val);
		}
		return valMap;
	}
	
	/**
	 * 
	 * 方法描述: TODO</br> 
	 * @param webWateRecord
	 * @return  
	 * double
	 */
	public double getWebUserWithdrawTj(WebWateRecord webWateRecord){
		List<Object> list = new ArrayList<Object>();
		
		String sql = " SELECT SUM(t1.back_money) AS back_money FROM t_web_water_record t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name WHERE  1=1 ";
		
		if(StringUtils.isNotBlank(webWateRecord.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(webWateRecord.getRelativePath());
		}
		
		if (StringUtils.isNotBlank(webWateRecord.getBeginTimeStr()) && StringUtils.isNotBlank(webWateRecord.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(webWateRecord.getBeginTimeStr());
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(webWateRecord.getEndTimeStr());
		}else if (StringUtils.isNotBlank(webWateRecord.getBeginTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') >= ?";
			list.add(webWateRecord.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(webWateRecord.getEndTimeStr())) {
			sql += " and date_format(t1.create_time,'%Y-%m-%d') <= ?";
			list.add(webWateRecord.getEndTimeStr());
		}
	
		double backMoney =0;
		List<Map<String,Object>> valList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		if(valList!=null && valList.size()>0){
			Map<String,Object> valMap = valList.get(0);
			if(valMap.get("back_money")!=null){
				backMoney = Double.valueOf(valMap.get("back_money").toString());
			}
		}
		return backMoney;
	}
	

}
