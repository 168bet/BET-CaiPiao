/**   
* 文件名称: WebSpreadLinkDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-2 下午2:56:38<br/>
*/  
package com.mh.dao;

import java.util.List;
import java.util.Map;

import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.WebSpreadLink;

/** 
 * 
 * 注册链接Dao接口
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-2 下午2:56:38<br/>
 */

@Repository
public class WebSpreadLinkDao  extends BaseDao<WebSpreadLink,Integer>{
	
	
	
	
	/**
	 * 更新注册链接状态
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * int
	 */
	public int updateWebSpreadLink(Integer id){
		String sql = " update t_web_spreadlink t set t.status=-1,modify_time=sysdate() where t.id=? and t.status=0 ";
		return this.getJdbcTemplate().update(sql, new Object[]{id});
	}
	
	
	/**
	 * 更新注册链接信息
	 * 方法描述: TODO</br> 
	 * @param id
	 * @param regCode
	 * @param spreadLink
	 * @return  
	 * int
	 */
	public int updateWebSpreadLink(Integer id,String regCode,String spreadLink,String shortLink){
		String sql = "update t_web_spreadlink t set t.reg_code=?,t.spread_link=?,short_link=?,modify_time=sysdate() where t.id=?";
		return this.getJdbcTemplate().update(sql, new Object[]{regCode,spreadLink,shortLink,id});
	}
	
	/**
	 * 获取注册链接列表
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getWebSpreadLinkList(String userName){
		String sql = "SELECT t.user_name AS userName,t.reg_num AS regNum,t.total AS total,t.pc28_point AS pc28Point,t.cp_point AS cpPoint,t.short_link AS spreadLink" +
				",t.status,t.reg_code as regCode,t.is_agent as isAgent " +
				"FROM t_web_spreadlink t WHERE 1=1 and t.status<>-1 and t.user_name=? order by t.create_time desc ";
		return this.getJdbcTemplate().queryForList(sql,new Object[]{userName});
		
	}

}
