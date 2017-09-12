/**   
* 文件名称: CpChaseball.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-10 下午4:28:35<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.List;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.CpChaseball;

/** 
 * 追号记录Dao接口
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-10 下午4:28:35<br/>
 */

@Repository
public class CpChaseballDao  extends BaseDao<CpChaseball,Integer>{
	
	/**
	 * 追号记录
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param cpChaseball
	 * @return  
	 * Page
	 */
	public Page findPage(Page page, CpChaseball cpChaseball) {
		List<Object> list = new ArrayList<Object>();

		String sql = "SELECT t.id,t.billno,t.game_type_name,t.cp_type_name,t.cp_cate_name,t.begin_qs,t.total_qs,t.finish_qs,t.bet_money,t.finish_money,t.cancel_money,DATE_FORMAT(t.create_time,'%Y-%m-%d %H:%i:%s') AS create_time,t.status FROM cp_chaseball t where 1=1 ";
		if(!StringUtils.isEmpty(cpChaseball.getUserName())){
			sql += " and t.user_name=? ";
			list.add(cpChaseball.getUserName().replaceAll(" ", "").replaceAll("'", "''").trim());
		}
		
		if(!StringUtils.isEmpty(cpChaseball.getBillno())){
			sql += " and t.billno = ? ";
			list.add(cpChaseball.getBillno().replaceAll(" ", "").replaceAll("'", "''").trim());
		}
	 
 
		if (StringUtils.isNotBlank(cpChaseball.getGameTypeCode())) {
			sql += " and t.game_type_code=? ";
			list.add(cpChaseball.getGameTypeCode());
		}
		
		
		if (cpChaseball.getStatus()!= null && cpChaseball.getStatus()!=-1) {
			sql += " and t.status=? ";
			list.add(cpChaseball.getStatus());
		}
		
		/** 美东时间 **/
		if (StringUtils.isNotBlank(cpChaseball.getBeginTimeStr()) && StringUtils.isNotBlank(cpChaseball.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(cpChaseball.getBeginTimeStr());
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(cpChaseball.getEndTimeStr());
		}else if (StringUtils.isNotBlank(cpChaseball.getBeginTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(cpChaseball.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(cpChaseball.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(cpChaseball.getEndTimeStr());
		}

		 
		
		sql+=" order by t.create_time desc,id desc ";
		return findPageBySql(page, sql, list.toArray());
	}
	
}
