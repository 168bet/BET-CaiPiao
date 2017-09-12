/**   
* 文件名称: WebAccountsDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午6:45:26<br/>
*/  
package com.mh.dao;

import java.sql.CallableStatement;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.CallableStatementCallback;
import org.springframework.jdbc.core.CallableStatementCreator;
import org.springframework.stereotype.Repository;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.mh.commons.constants.WebConstants;
import com.mh.commons.orm.BaseDao;
import com.mh.commons.utils.CpIfcUtil;
import com.mh.entity.CpOrder;
import com.mh.entity.WebAccounts;

/** 
 * 类描述: TODO<br/>资金账户流水Dao
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-5 下午6:45:26<br/>
 */

@Repository
public class WebAccountsDao extends BaseDao<WebAccounts,Integer>{
	
	
	/**
	 * 批量更新
	 * 方法描述: TODO</br> 
	 * @param list  
	 * void
	 */
	public void saveOrUpdateAllAccountsRecord(List<WebAccounts> list){
		this.getHibernateTemplate().saveOrUpdateAll(list);
	}
	/**
	 * @Description: 记录资金流水
	 * @param  WebAccounts
	 * @return 
	 * @throws
	 * @author Andy
	 * @date 2015-6-9
	 */
	public void saveWebAccounts(WebAccounts entity){
		this.getHibernateTemplate().save(entity);
	}
	
	public Map<String, Object> reportUserInOut(String userName, String inOptType, String outOptType){
		StringBuffer buffer = new StringBuffer();
		buffer.append("SELECT a.inMoney AS inMoney, b.outMoney AS outMoney FROM( ");
		buffer.append("		SELECT ROUND(SUM(act_opt_money), 2) AS inMoney FROM t_web_account WHERE FIND_IN_SET(act_opt_type, '"+inOptType+"') AND user_name = '"+userName+"' ");
		buffer.append("		 )a ,");
		buffer.append("		(SELECT ROUND(SUM(act_opt_money), 2) AS outMoney FROM  t_web_account WHERE FIND_IN_SET(act_opt_type, '"+outOptType+"') AND user_name = '"+userName+"' "); 
		buffer.append(" 	)b ");
		 
		return this.getJdbcTemplate().queryForMap(buffer.toString());
	}
	
	
	public Map<String, Object> reportUserProcedure(String userName){
		StringBuffer buffer = new StringBuffer();
		buffer.append(" SELECT SUM(user_procedure) AS pcost,SUM(user_administration) AS acost FROM t_web_user_withdraw ");
		buffer.append(" WHERE user_name='"+userName+"' ");
		buffer.append(" AND check_status=" + WebConstants.T_WEB_USER_WITHDRAW_CHECKED_STATUS_1);
		buffer.append(" AND status=" + WebConstants.T_WEB_USER_WITHDRAW_STATUS_1);
		buffer.append(" AND user_cost=" + WebConstants.T_WEB_WITHDRAW_COST_1);
		return this.getJdbcTemplate().queryForMap(buffer.toString());
	}
	
	
	
	/**
	 * 资金流水批量处理
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param proType
	 * @param optType
	 * @param changeMoney
	 * @param remark
	 * @param optName
	 * @param orderNo
	 * @return  
	 * int
	 */
	@SuppressWarnings({"unchecked", "rawtypes" })
	public int updateWebAccount(final String userName,final String proType,final String optType,final Double changeMoney,
			final String remark,final String optName,final String orderNo){
		int row=0;
		try{
			 
			row = (Integer) this.getJdbcTemplate().execute(
					new CallableStatementCreator() {
						@Override
						public CallableStatement createCallableStatement(
								Connection con) throws SQLException {
							String storedProc = "{call account_sync(?,?,?,?,?,?,?,?)}";// 调用的sql
							CallableStatement cs = con.prepareCall(storedProc);
							cs.setString(1, userName);// 设置输入参数的值
							cs.setString(2, proType);
							cs.setString(3, optType);
							cs.setDouble(4, changeMoney);
							cs.setString(5, orderNo);
							cs.setString(6, optName);
							cs.setString(7, remark);
							cs.registerOutParameter(8,java.sql.Types.INTEGER);// 注册输出参数的类型
							return cs;
						}
					}, new CallableStatementCallback() {
						@Override
						public Object doInCallableStatement(CallableStatement cs)
								throws SQLException, DataAccessException {
							cs.execute();
							return cs.getInt(8);// 获取输出参数的值
						}
					}); 
		}catch(RuntimeException e){
			row=0;
			e.printStackTrace();
		}
		return row;
	}
	
	/**
	 * 彩票shared订单 200成功  400失败
	 * @param orderList
	 * @return
	 */
	public int saveShareadOrder(List<CpOrder> orderList){
		int resultCode = 200;
		try {
			Map<String, String> params = new HashMap<String, String>();
			params.put("json", JSON.toJSONString(orderList));
			resultCode = CpIfcUtil.saveSharedOrder(params);
		} catch (Exception e) {
			resultCode = 400;
			e.printStackTrace();
		}
		return resultCode;
	}

}
