/**   
* 文件名称: CpChaseballServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-10 下午4:44:24<br/>
*/  
package com.mh.service.impl;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.commons.orm.Page;
import com.mh.dao.CpChaseballDao;
import com.mh.entity.CpChaseball;
import com.mh.service.CpChaseballService;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-10 下午4:44:24<br/>
 */

@Service
public class CpChaseballServiceImpl implements CpChaseballService{
	
	@Autowired
	private CpChaseballDao cpChaseballDao;
	
	
	/**
	 * 追号记录
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param cpChaseball
	 * @return  
	 * Page
	 */
	@Override
	public Page findPage(Page page, CpChaseball cpChaseball){
		return this.cpChaseballDao.findPage(page, cpChaseball);
	}

}
