/**   
* 文件名称: CpDayProfit.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-1 上午11:19:05<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.List;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.CpDayProfit;

/** 
 * 
 * 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-1 上午11:19:05<br/>
 */


@Repository
public class CpDayProfitDao extends BaseDao{
	
	
	
	/**
	 * 盈亏列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param cpDayProfit
	 * @return  
	 * Page
	 */
	public Page findPage(Page page, CpDayProfit cpDayProfit) {
		List<Object> list = new ArrayList<Object>();
		String sql = " select t.bet_user_name as betUserName,t.bet_date as betDate,t.bet_income as betIncome,t.deposit_amount as depositAmount, " +
				"t.withdraw_amount AS withdrawAmount,t.win_amonut AS winAmount,t.feeback_amount AS feebackAmount," +
				"ROUND((t.win_amonut-t.bet_income+t.feeback_amount),3) AS profitMargin from cp_day_profit t where 1=1 ";
		
		if(!StringUtils.isEmpty(cpDayProfit.getUserName())){
			sql += " and t.bet_user_name=? ";
			list.add(cpDayProfit.getUserName().replaceAll(" ", "").replaceAll("'", "''").trim());
		}
	 
 
		/** 美东时间 **/
		if (StringUtils.isNotBlank(cpDayProfit.getBeginTimeStr()) && StringUtils.isNotBlank(cpDayProfit.getEndTimeStr())) {
			sql += " and date_format(t.bet_date,'%Y-%m-%d') >= ?";
			list.add(cpDayProfit.getBeginTimeStr());
			sql += " and date_format(t.bet_date,'%Y-%m-%d') <= ?";
			list.add(cpDayProfit.getEndTimeStr());
		}else if (StringUtils.isNotBlank(cpDayProfit.getBeginTimeStr())) {
			sql += " and date_format(t.bet_date,'%Y-%m-%d') >= ?";
			list.add(cpDayProfit.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(cpDayProfit.getEndTimeStr())) {
			sql += " and date_format(t.bet_date,'%Y-%m-%d') <= ?";
			list.add(cpDayProfit.getEndTimeStr());
		}

	 
		
		sql+=" order by t.bet_date desc ";
		return findPageBySql(page, sql, list.toArray());
	}
	
	
	

}
