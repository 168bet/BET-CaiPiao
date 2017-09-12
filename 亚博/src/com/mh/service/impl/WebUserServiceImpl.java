/**   
* 文件名称: LoginServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-2 下午7:16:40<br/>
*/  
package com.mh.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.commons.orm.Page;
import com.mh.dao.WebUserDao;
import com.mh.entity.WebUser;
import com.mh.service.WebUserService;

@Service
public class WebUserServiceImpl implements WebUserService{
	
 
	@Autowired
	private WebUserDao webUserDao;
	
	
	/**
	 * 团队余额
	 * 方法描述: TODO</br> 
	 * @param relativePath
	 * @return  
	 * double
	 */
	public double getTeamUserMoney(String relativePath){
		return this.webUserDao.getTeamUserMoney(relativePath);
	}
	
	
	
	/**
	 * 团队人数
	 * 方法描述: TODO</br> 
	 * @param relativePath
	 * @return  
	 * int
	 */
	public int getTeamUserTotal(String relativePath){
		return this.webUserDao.getTeamUserTotal(relativePath);
	}
	
	
	/**
	 * 统计会员数
	 * 方法描述: TODO</br> 
	 * @param webUser
	 * @return  
	 * int
	 */
	public Map<String,Object> getWebUserTotalList(WebUser webUser){
		return webUserDao.getWebUserTotalList(webUser);
	}
	
	/**
	 * 统计会员数
	 * 方法描述: TODO</br> 
	 * @param webUser
	 * @return  
	 * int
	 */
	public int getWebUserTotal(WebUser webUser){
		return this.webUserDao.getWebUserTotal(webUser);
	}
	
	
	
 
	
	
	/**
	 * 会员列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param webUser
	 * @return  
	 * Page
	 */
	public Page findPage(Page page, WebUser webUser){
		return this.webUserDao.findPage(page, webUser);
	}
	
	
	/**
	 * 保存更新用户信息
	 * 方法描述: TODO</br> 
	 * @param webUser  
	 * void
	 */
	public void saveWebUser(WebUser webUser){
		this.webUserDao.saveOrUpdate(webUser);
	}

	
	 
	/**
	 * 更新用户信息
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * WebUser
	 */
	public int updateWebUser(String userName,List<String> fieldList,List<Object> valList){
 
		return  this.webUserDao.updateWebUser(userName,fieldList,valList);
	}
	
	
	
	
	
	/**
	 * 根据用户名查询用户信息
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * WebUser
	 */
	public WebUser findWebrUseByUserName(String userName){
		return this.webUserDao.findWebrUseByUserName(userName);
	}





	/**
	 * 查询用户余额
	 */
	public double getWebUserMoney(String userName) {
		 
		return this.webUserDao.getWebUserMoney(userName);
	}
	
	
}
