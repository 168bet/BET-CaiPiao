/**   
* 文件名称: WebWateRecordServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-8 下午4:03:27<br/>
*/  
package com.mh.service.impl;

import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebWateRecordDao;
import com.mh.entity.WebWateRecord;
import com.mh.service.WebWateRecordService;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-8 下午4:03:27<br/>
 */
@Service
public class WebWateRecordServiceImpl implements WebWateRecordService{
	
	@Autowired
	private WebWateRecordDao webWateRecordDao;
	
	/**
	 * 
	 * 方法描述: TODO</br> 
	 * @param webWateRecord
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebUserWithdrawTjList(WebWateRecord webWateRecord){
		return this.webWateRecordDao.getWebUserWithdrawTjList(webWateRecord);
	}
	
	
	
	/**
	 * 
	 * 方法描述: TODO</br> 
	 * @param webWateRecord
	 * @return  
	 * double
	 */
	public double getWebUserWithdrawTj(WebWateRecord webWateRecord){
		return this.webWateRecordDao.getWebUserWithdrawTj(webWateRecord);
	}

}
