/**   
* 文件名称: WebSpreadLinkService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-2 下午3:03:29<br/>
*/  
package com.mh.service;

import java.util.List;
import java.util.Map;

import com.mh.entity.WebSpreadLink;

/** 
 * 注册链接Service接口
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-2 下午3:03:29<br/>
 */
public interface WebSpreadLinkService {
	
	/**
	 * 更新注册链接信息
	 * 方法描述: TODO</br> 
	 * @param id
	 * @param regCode
	 * @param spreadLink
	 * @return  
	 * int
	 */
	public int updateWebSpreadLink(Integer id,String regCode,String spreadLink,String shortLink);
	
	/**
	 * 更新注册链接状态
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * int
	 */
	public int updateWebSpreadLink(Integer id);
	
	
	/**
	 * 保存更新注册链接
	 * 方法描述: TODO</br> 
	 * @param webSpreadLink  
	 * void
	 */
	public void saveWebSpreadLink(WebSpreadLink  webSpreadLink);
	
	/**
	 * 获取注册链接列表
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getWebSpreadLinkList(String userName);
	
	/**
	 * 根据id查询注册链接信息
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * WebSpreadLink
	 */
	public WebSpreadLink getWebSpreadLinkById(Integer id);

}
