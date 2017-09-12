/**   
* 文件名称: WebWateRecordService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-8 下午3:55:09<br/>
*/  
package com.mh.service;

import java.util.Map;

import com.mh.entity.WebWateRecord;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-8 下午3:55:09<br/>
 */
public interface WebWateRecordService {
	
	
	/**
	 * 
	 * 方法描述: TODO</br> 
	 * @param webWateRecord
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebUserWithdrawTjList(WebWateRecord webWateRecord);
	
	/**
	 * 
	 * 方法描述: TODO</br> 
	 * @param webWateRecord
	 * @return  
	 * double
	 */
	public double getWebUserWithdrawTj(WebWateRecord webWateRecord);

}
