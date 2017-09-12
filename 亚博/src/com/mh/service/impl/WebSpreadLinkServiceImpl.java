/**   
* 文件名称: WebSpreadLinkServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-2 下午3:04:02<br/>
*/  
package com.mh.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebSpreadLinkDao;
import com.mh.entity.WebSpreadLink;
import com.mh.service.WebSpreadLinkService;

/**
 * 注册链接信息Service接口 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-2 下午3:04:02<br/>
 */
@Service
public class WebSpreadLinkServiceImpl implements WebSpreadLinkService{
	
	@Autowired
	private WebSpreadLinkDao webSpreadLinkDao;
	
	
	/**
	 * 更新注册链接状态
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * int
	 */
	public int updateWebSpreadLink(Integer id){
		return this.webSpreadLinkDao.updateWebSpreadLink(id);
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
		return this.webSpreadLinkDao.updateWebSpreadLink(id, regCode, spreadLink,shortLink);
		
	}
	
	/**
	 * 根据id查询注册链接信息
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * WebSpreadLink
	 */
	public WebSpreadLink getWebSpreadLinkById(Integer id){
		return this.webSpreadLinkDao.get(id);
	}
	
	/**
	 * 保存更新注册链接
	 * 方法描述: TODO</br> 
	 * @param webSpreadLink  
	 * void
	 */
	public void saveWebSpreadLink(WebSpreadLink  webSpreadLink){
		this.webSpreadLinkDao.saveOrUpdate(webSpreadLink);
	}
	
	
	/**
	 * 获取注册链接列表
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getWebSpreadLinkList(String userName){
		return this.webSpreadLinkDao.getWebSpreadLinkList(userName);
	}

}
