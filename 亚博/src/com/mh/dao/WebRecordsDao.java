/**   
 * 文件名称: WebRecordsDao.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: zoro<br/>  
 * 创建时间 : 2015-7-2 下午3:03:11<br/>
 */
package com.mh.dao;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.hibernate.HibernateException;
import org.hibernate.Query;
import org.hibernate.SQLQuery;
import org.hibernate.Session;
import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.stereotype.Repository;

import com.mh.commons.constants.WebConstants;
import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.TWebBankHuikuan;
import com.mh.entity.WebEdu;
import com.mh.entity.WebRecords;
import com.mh.entity.WebUserWithdraw;

/**
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-7-2 下午3:03:11<br/>
 */
@SuppressWarnings("all")
@Repository
public class WebRecordsDao extends BaseDao {

	public List<Map<String, Object>> report(WebRecords records) {

		StringBuffer sqlBuff = new StringBuffer();
		sqlBuff.append("SELECT bet_flat AS betFlat, bet_user_agent AS userAgent, ROUND(SUM(bet_in),2) AS betIn, ROUND(SUM(bet_income),2) AS betIncome,");
		sqlBuff.append(" ROUND(SUM(bet_net_win),2) AS betNetWin ,SUM(bet_total) AS betTotal ");
		sqlBuff.append(" FROM t_bet_day_report_agent where 1=1 ");
		sqlBuff.append(appendReportSql4(records));
		sqlBuff.append(" GROUP BY betFlat");

		List<Map<String, Object>> list2 = this.getJdbcTemplate().queryForList(sqlBuff.toString());
		return list2;
	}

	public List<Map<String, Object>> reportUser(WebRecords records) {
		StringBuffer sqlBuff = new StringBuffer();
		sqlBuff.append("SELECT bet_flat AS betFlat,  ROUND(SUM(bet_in),2) AS betIn, ROUND(SUM(bet_income),2) AS betIncome,");
		sqlBuff.append(" ROUND(SUM(bet_net_win),2) AS betNetWin ,SUM(bet_total) AS betTotal ");
		sqlBuff.append(" FROM t_bet_day_report_user where 1=1 ");
		sqlBuff.append(appendReportSql4(records));
		sqlBuff.append(" GROUP BY betFlat");

		List<Map<String, Object>> list2 = this.getJdbcTemplate().queryForList(sqlBuff.toString());
		return list2;
	}

	private String appendReportSql4(WebRecords records) {
		String sql = "";
		if (!StringUtils.isEmpty(records.getStartTime()) && !StringUtils.isEmpty(records.getEndTime())) {
			sql += " and STR_TO_DATE(bet_date,'%Y-%m-%d')>= '" + records.getStartTime() + "' and STR_TO_DATE(bet_date,'%Y-%m-%d') <= '" + records.getEndTime() + "'";
		} else if (!StringUtils.isEmpty(records.getStartTime())) {
			sql += " and STR_TO_DATE(bet_date,'%Y-%m-%d')>= '" + records.getStartTime() + "' ";
		} else if (!StringUtils.isEmpty(records.getEndTime())) {
			sql += " and STR_TO_DATE(bet_date,'%Y-%m-%d') <= '" + records.getEndTime() + "' ";
		}
		if (StringUtils.isNotEmpty(records.getUserAgent())) {
			sql += " AND bet_user_agent = '" + records.getUserAgent() + "'";
		}
		if (StringUtils.isNotEmpty(records.getUserName())) {
			sql += " AND bet_user_name = '" + records.getUserName() + "'";
		}
		return sql;
	}

	/**
	 * 
	 * 查询财务记录 方法描述: TODO</br>
	 * 
	 * @param page
	 * @param records
	 * @return Page
	 */
	public Page findFinancePage(Page page, WebRecords records) {
		List<Object> list = new ArrayList<Object>();
		String sql = "";
		if ("eduHistory".equals(records.getCode())) {
			sql = " select * from  t_web_edu where 1=1 ";
		} else if ("payHistory".equals(records.getCode())) {
			sql = " select * from t_web_bank_huikuan where 1=1 ";
		} else if ("withdrawHistory".equals(records.getCode())) {
			sql = " select * from t_web_user_withdraw where 1=1 ";
		}

		if (StringUtils.isNotEmpty(records.getUserName())) {
			sql += " and user_name = ? ";
			list.add(records.getUserName());
		}
		if (!StringUtils.isEmpty(records.getStartTime()) && !StringUtils.isEmpty(records.getEndTime())) {
			sql += " and STR_TO_DATE(create_time,'%Y-%m-%d')>= ? and STR_TO_DATE(create_time,'%Y-%m-%d') <= ?";
			list.add(records.getStartTime());
			list.add(records.getEndTime());
		} else if (!StringUtils.isEmpty(records.getStartTime())) {
			sql += " and STR_TO_DATE(create_time,'%Y-%m-%d')>= ?  ";
			list.add(records.getStartTime());
		} else if (!StringUtils.isEmpty(records.getEndTime())) {
			sql += " and STR_TO_DATE(create_time,'%Y-%m-%d') <= ?";
			list.add(records.getEndTime());
		}

		if (!StringUtils.isEmpty(records.getHkModel())) {
			sql += " and hk_model =?";
			list.add(records.getHkModel());
		}

		if (!StringUtils.isEmpty(records.getWithdrawType())) {
			sql += " and withdraw_type =?";
			list.add(records.getWithdrawType());
		}

		if (!StringUtils.isEmpty(records.getFlatName())) {
			sql += " and flat_name =?";
			list.add(records.getFlatName());
		}

		if (!StringUtils.isEmpty(records.getEduType())) {
			sql += " and edu_Type=? ";
			list.add(records.getEduType());
		}

		sql += " order by create_time desc ";
		return this.findPageBySql(page, sql, list.toArray());
	}

	public List<WebEdu> getEduList(final WebRecords records) {
		StringBuffer sb = new StringBuffer(" from WebEdu where 1 = 1 and userName = '" + records.getUserName() + "'");
		if (StringUtils.isNotBlank(records.getFlatName()))
			sb.append(" and flatName = '" + records.getFlatName() + "'");

		if (StringUtils.isNotBlank(records.getEduType()))
			sb.append(" and eduType = '" + records.getEduType() + "'");
		if (StringUtils.isNotBlank(records.getStartTime()))
			sb.append(" and STR_TO_DATE(createTime,'%Y-%m-%d')>= '" + records.getStartTime() + "'");
		if (StringUtils.isNotBlank(records.getEndTime()))
			sb.append(" and STR_TO_DATE(createTime,'%Y-%m-%d') <= '" + records.getEndTime() + "'");
		sb.append(" ORDER BY createTime DESC");

		final String sql = sb.toString();
		List<WebEdu> list = this.getHibernateTemplate().execute(new HibernateCallback() {

			public Object doInHibernate(Session session) throws HibernateException, SQLException {
				final Query query = session.createQuery(sql);
				query.setFirstResult(0);
				query.setMaxResults(records.getCount());
				return query.list();
			}
		});
		return list;

	}

	public List<TWebBankHuikuan> getHuiKuan(final WebRecords records) {
		StringBuffer sb = new StringBuffer(" FROM TWebBankHuikuan WHERE 1 = 1");
		sb.append(" AND userName = '" + records.getUserName() + "'");

		if (StringUtils.isNotBlank(records.getHkModel()))
			sb.append(" and hkModel = '" + records.getHkModel() + "'");
		if (StringUtils.isNotBlank(records.getStartTime()))
			sb.append(" and STR_TO_DATE(createTime,'%Y-%m-%d')>= '" + records.getStartTime() + "'");
		if (StringUtils.isNotBlank(records.getEndTime()))
			sb.append(" and STR_TO_DATE(createTime,'%Y-%m-%d') <= '" + records.getEndTime() + "'");
		sb.append(" ORDER BY createTime DESC");

		final String sql = sb.toString();
		List<TWebBankHuikuan> list = this.getHibernateTemplate().execute(new HibernateCallback() {

			public Object doInHibernate(Session session) throws HibernateException, SQLException {
				final Query query = session.createQuery(sql);
				query.setFirstResult(0);
				query.setMaxResults(records.getCount());
				return query.list();
			}
		});
		return list;
	}

	public List<WebUserWithdraw> getWithdrawList(final WebRecords records) {
		StringBuffer sb = new StringBuffer(" from WebUserWithdraw where 1 = 1");
		sb.append(" AND userName = '" + records.getUserName() + "'");
		if (StringUtils.isNotBlank(records.getWithdrawType()))
			sb.append(" and withdrawType = " + records.getWithdrawType() + "");
		if (StringUtils.isNotBlank(records.getStartTime()))
			sb.append(" and STR_TO_DATE(createTime,'%Y-%m-%d')>= '" + records.getStartTime() + "'");
		if (StringUtils.isNotBlank(records.getEndTime()))
			sb.append(" and STR_TO_DATE(createTime,'%Y-%m-%d') <= '" + records.getEndTime() + "'");
		sb.append(" ORDER BY createTime DESC");

		final String sql = sb.toString();
		List<WebUserWithdraw> list = this.getHibernateTemplate().execute(new HibernateCallback() {

			public Object doInHibernate(Session session) throws HibernateException, SQLException {
				final Query query = session.createQuery(sql);
				query.setFirstResult(0);
				query.setMaxResults(records.getCount());
				return query.list();
			}
		});
		return list;
	}

}
