package com.mh.dao;

import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import org.springframework.jdbc.core.BatchPreparedStatementSetter;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.WebUserQuestion;

@SuppressWarnings("all")
@Repository
public class WebUserQuestionDao extends BaseDao<WebUserQuestion,Integer>{
	
	public int setQuestion(String userName ,List<String> fieldList , final Map<String , String> map , String dateTime){
		StringBuffer str = new StringBuffer(" ");
		String sql = null;
		for(int i = 0 ; i < fieldList.size() ; i++){
			str.append(fieldList.get(i));
			if(i + 1 < fieldList.size()){
				str.append(",");
			}
		}
		sql = "insert into t_web_user_question("+str.toString()+" ) values('"+userName+"',?,?,'"+dateTime+"','"+dateTime+"')";
		int[] i = this.getJdbcTemplate().batchUpdate(sql, new BatchPreparedStatementSetter(){
			public int getBatchSize() {
				int ii = map.size();
				return ii;
			}

			@Override
			public void setValues(PreparedStatement ps, int ii)
					throws SQLException {
				Iterator iter = map.entrySet().iterator();
				Map.Entry entry = null;
				while(iter.hasNext()){
					entry = (Map.Entry) iter.next();
				}
				ps.setString(1,(String) entry.getKey());
				ps.setString(2, (String) entry.getValue());
				if(map.size() > 1){
					map.remove(entry.getKey());
				}
				
			}
		});
		return i.length;

	}
	
	
	public List<WebUserQuestion> findUserName(String userName){
		String hql = "from WebUserQuestion where userName = ?";
		List<WebUserQuestion> list = this.getHibernateTemplate().find(hql, new Object[]{userName});
		if(list == null || list.size() <= 0){
			System.out.println(list.size());
			return null;
		}
		return list;
		
	}
	
	
	
	public List<WebUserQuestion> findWebUserQuestion(List<String> list){
		String hql = "from WebUserQuestion where user_name = ? AND (question = ? OR question = ?)";
		List<WebUserQuestion> listWebUserQuestion = this.getHibernateTemplate().find(hql, list.toArray());
		if(listWebUserQuestion == null || list.size() <= 0 ){
			return null;
		}
		return listWebUserQuestion;
	}
	
	
	
	public int updateQuestion(List<Object[]> batchArgs){
		String sql = "update  t_web_user_question set question = ? , answer = ? , modify_time=sysdate() where id = ?";
		int[] i = this.getJdbcTemplate().batchUpdate(sql, batchArgs);
		return i.length;

		
	}

}
