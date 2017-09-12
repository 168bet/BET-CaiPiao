/**   
* 文件名称: WebTrendService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-13 上午1:46:44<br/>
*/  
package com.mh.service;

import java.util.Map;

/**
 * 走势图Service接口 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-13 上午1:46:44<br/>
 */
public interface WebTrendService {
	
	/**
	 * 获取开奖结果
	 * 方法描述: TODO</br> 
	 * @param params
	 * @return  
	 * List<Object[]>
	 */
	public Map<String,Object> getResultsList(Map<String,String> params);
	

}
