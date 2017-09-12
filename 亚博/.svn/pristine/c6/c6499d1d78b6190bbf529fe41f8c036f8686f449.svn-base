/**   
* 文件名称: WebConfigServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-6 下午4:02:22<br/>
*/  
package com.mh.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebConfigDao;
import com.mh.entity.WebConfig;
import com.mh.service.WebConfigService;

/** 
 * 配置信息
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-6 下午4:02:22<br/>
 */

@Service
public class WebConfigServiceImpl implements WebConfigService{
	
	@Autowired
	private WebConfigDao webConfigDao;

	public List<WebConfig> getWebConfigList(){
		
		return this.webConfigDao.loadAll();
		
	}
	
}
