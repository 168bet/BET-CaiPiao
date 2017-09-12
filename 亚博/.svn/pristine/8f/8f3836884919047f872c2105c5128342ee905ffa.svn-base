/**   
* 文件名称: SysParameterServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-17 下午2:19:38<br/>
*/  
package com.mh.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.SysParameterDao;
import com.mh.entity.SysParameter;
import com.mh.service.SysParameterService;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-17 下午2:19:38<br/>
 */

@Service
public class SysParameterServiceImpl implements SysParameterService{
	
	@Autowired
	private SysParameterDao sysParameterDao;

	
	public SysParameter getSysParameterByPramName(String paramName){
		return this.sysParameterDao.getSysParameterByPramName(paramName);
	}
	
	public List<SysParameter> getSysParameterList(String[] paramName){
		return this.sysParameterDao.getSysParameterList(paramName);
	}
	
	public void  saveUpdateAll(List<SysParameter> list){
		this.sysParameterDao.saveUpdateAll(list);
	}
	
	
}
