package com.mh.dao;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.jdbc.core.simple.ParameterizedBeanPropertyRowMapper;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.WebGongGao;


@SuppressWarnings("all")
@Repository
public class WebGongGaoDao extends BaseDao<WebGongGao,Integer>{
	
	/**
	 * 获取公告列表
	 * 方法描述: TODO</br> 
	 * @param name
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getGongGaoList(String name){
		List<Object> list = new ArrayList<Object>();
		String sql = "SELECT t.id as ggId, t.gg_content AS ggContent,t.gg_name AS ggTitle,DATE_FORMAT(t.create_time,'%Y-%m-%d %H:%i:%s')  AS createTime FROM t_web_gonggao t where 1=1 ";
		if(StringUtils.isNotBlank(name)){
			sql += " and t.gg_name like ? ";
			list.add(name);
		}
		sql += " order by t.create_time desc ";
		
		return this.getJdbcTemplate().queryForList(sql, list.toArray());
		
		
	}
	
	
	
	public List<WebGongGao> findList(String name){
		Class webGongGao = WebGongGao.class;
		String sql = "select * from t_web_gonggao where gg_name = '"+name+"'";
		RowMapper<WebGongGao> rm = ParameterizedBeanPropertyRowMapper.newInstance(WebGongGao.class);
		List<WebGongGao> list = (List<WebGongGao>) this.getJdbcTemplate().query(sql, rm);
		return list;
		
	}

}
