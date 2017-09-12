/**   
* 文件名称: OrderDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午1:16:09<br/>
*/  
package com.mh.dao;

import java.sql.CallableStatement;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.CallableStatementCallback;
import org.springframework.jdbc.core.CallableStatementCreator;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.CpParameter;
import com.mh.entity.WebAccounts;

@SuppressWarnings("all")
@Repository
public class WebAccountDao extends BaseDao<WebAccounts,Integer>{
	
	
	
	/**
	 * 账号明细列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param bean
	 * @return  
	 * Page
	 */
	public Page getWebAccountList(Page page,WebAccounts webAccount){
		List<Object> list = new ArrayList<Object>();
		
		String sql = "SELECT t.user_name AS userName,t.act_opt_money AS actOptMoney,t.act_result_money AS actResultMoney" +
				",t.act_opt_type AS actOptType,t.act_order AS actOrder,t.remark " +
				",date_format(t.create_time,'%Y-%m-%d %H:%i:%s') as createTime " +
				"from t_web_account t where 1=1 ";
		
		if(StringUtils.isNotEmpty(webAccount.getActOptType())){
			sql += " and t.act_opt_type =? ";
			list.add((webAccount.getActOptType()));
		}
		
		if(StringUtils.isNotEmpty(webAccount.getUserName())){
			sql += " and t.user_name=? ";
			list.add(webAccount.getUserName());
		}
		
		if (StringUtils.isNotBlank(webAccount.getBeginTimeStr()) && StringUtils.isNotBlank(webAccount.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(webAccount.getBeginTimeStr());
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(webAccount.getEndTimeStr());
		}else if (StringUtils.isNotBlank(webAccount.getBeginTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(webAccount.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(webAccount.getEndTimeStr())) {
			sql += " and date_format(t.create_time,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(webAccount.getEndTimeStr());
		}
		
		if(StringUtils.isNotBlank(webAccount.getActOrder())){
			sql += " AND  t.act_order=? ";
			list.add(webAccount.getActOrder());
		}
		sql += " order by t.create_time desc ";
		
		return this.findPageBySql(page,sql,list.toArray());
	}
	
	
	public List<Map<String, Object>> getactOpttype(){
		String sql="SELECT code_show_name as typeName,code_value as typeCode FROM t_sys_code WHERE code_type IN (?,?,?,?)";
		return this.getJdbcTemplate().queryForList(sql, new String[]{"huikuan","withdraw","edu","bet"});
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
	
}
