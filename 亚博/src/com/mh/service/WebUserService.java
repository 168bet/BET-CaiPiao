/**   
* 文件名称: LoginService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-2 下午7:16:29<br/>
*/  
package com.mh.service;

import java.util.List;
import java.util.Map;

import com.mh.commons.orm.Page;
import com.mh.entity.WebUser;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-2 下午7:16:29<br/>
 */
public interface WebUserService {
	
	/**
	 * 团队余额
	 * 方法描述: TODO</br> 
	 * @param relativePath
	 * @return  
	 * double
	 */
	public double getTeamUserMoney(String relativePath);
	
	
	
	/**
	 * 团队人数
	 * 方法描述: TODO</br> 
	 * @param relativePath
	 * @return  
	 * int
	 */
	public int getTeamUserTotal(String relativePath);
	
	
	/**
	 * 统计会员数
	 * 方法描述: TODO</br> 
	 * @param webUser
	 * @return  
	 * int
	 */
	public Map<String,Object> getWebUserTotalList(WebUser webUser);
	
	/**
	 * 统计会员数
	 * 方法描述: TODO</br> 
	 * @param webUser
	 * @return  
	 * int
	 */
	public int getWebUserTotal(WebUser webUser);
	
	
	/**
	 * 会员列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param webUser
	 * @return  
	 * Page
	 */
	public Page findPage(Page page, WebUser webUser);
	
	/**
	 * 保存更新用户信息
	 * 方法描述: TODO</br> 
	 * @param webUser  
	 * void
	 */
	public void saveWebUser(WebUser webUser);
	
	/**
	 * 根据用户名查询用户信息
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * WebUser
	 */
	public WebUser findWebrUseByUserName(String userName);
	
	
	/**
	 * 获取用户余额
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * double
	 */
	public double getWebUserMoney(String userName);
 
 
	
	/**
	 * 更新用户信息
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param fieldList
	 * @param valList
	 * @return  
	 * int
	 */
	public int updateWebUser(String userName,List<String> fieldList,List<Object> valList);
 
 
}
