/**   
* 文件名称: SysParameterDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-17 下午2:16:24<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.List;

import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.SysParameter;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-17 下午2:16:24<br/>
 */

@Repository
public class SysParameterDao extends BaseDao<SysParameter,Integer>{
	
	
	
	@SuppressWarnings("unchecked")
	public SysParameter getSysParameterByPramName(String paramName){
		String hql = "from SysParameter where paramName=?";
		List<SysParameter> list = this.getHibernateTemplate().find(hql,new Object[]{paramName});
		SysParameter parameter  =null;
		if(list!=null && list.size()>0){
			parameter = list.get(0);
		}
		return parameter;
	}
	
	public List<SysParameter> getSysParameterList(String[] paramName){
		String hql = "from SysParameter where paramName=? ";
		List<SysParameter> alist = new ArrayList<SysParameter>();
		List<SysParameter> list = null;
		Object[] object = paramName;
		for(int i = 0 ; i < object.length ; i++){
			list = this.getHibernateTemplate().find(hql,object[i]);
			alist.add(list.get(0));
			list = null;
		}
		if(alist.size() > 0){
			return alist;
		}
		return null;
		
	}
	
	public void  saveUpdateAll(List<SysParameter> list){
		try{
			String hql = "update SysParameter set paramValue=? where paramName=?";
			String sql = "from SysParameter where paramName=? ";
			List<SysParameter> alist = new ArrayList<SysParameter>();
			List<SysParameter> arr = new ArrayList<SysParameter>();
			for(int i = 0 ; i < list.size() ; i++){
				arr = this.getHibernateTemplate().find(sql,list.get(i).getParamName());
				alist.add(arr.get(0));
				alist.get(i).setParamValue(list.get(i).getParamValue());
				this.getHibernateTemplate().saveOrUpdate(hql , alist.get(i));
				arr = null;
			}
		}catch(Exception e){
			e.printStackTrace();
		
		}
	}

}
