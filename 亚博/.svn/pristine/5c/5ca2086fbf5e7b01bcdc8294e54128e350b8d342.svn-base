/**   
* 文件名称: WebTrendServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-13 上午1:47:16<br/>
*/  
package com.mh.service.impl;

import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebTrendDao;
import com.mh.service.WebTrendService;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-13 上午1:47:16<br/>
 */

@Service
public class WebTrendServiceImpl implements WebTrendService{
	
	@Autowired
	private WebTrendDao webTrendDao;
	
	/**
	 * 获取开奖结果
	 * 方法描述: TODO</br> 
	 * @param params
	 * @return  
	 * List<Object[]>
	 */
	public Map<String,Object> getResultsList(Map<String,String> params){
		return webTrendDao.getResultsList(params);
	}

}
