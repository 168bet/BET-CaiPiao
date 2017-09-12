/**   
* 文件名称: WebUserWithdrawService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-2 下午2:10:39<br/>
*/  
package com.mh.service;

import java.util.Map;

import com.mh.commons.orm.Page;
import com.mh.entity.WebUserWithdraw;

/** 
 * 类描述: TODO<br/>出款流水Service
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-2 下午2:10:39<br/>
 */
public interface WebUserWithdrawService {
	
	/**
	 * 统计会员代理取款列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebUserWithdrawTjList(WebUserWithdraw userWithdraw);
	
	
	/**
	 * 统计会员代理取款
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public double getWebUserWithdrawTj(WebUserWithdraw userWithdraw);
	
	/**
	 * 获取出款流水列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param userWithdraw
	 * @return  
	 * Page
	 */
	public Page getWebUserWithdrawList(Page page,WebUserWithdraw userWithdraw);
	
	/**
	 * 统计用户的出款次数
	 * 方法描述: TODO</br>
	 * 创建人: zoro<br/> 
	 * @param userWithdraw
	 * @return  
	 * Map<String,Integer>
	 */
	public Map<String, Integer> countWithdrawSuccessTimes(WebUserWithdraw userWithdraw);
	
	
	public boolean saveWebUserWithdraw(WebUserWithdraw userWithdraw);

	
}
