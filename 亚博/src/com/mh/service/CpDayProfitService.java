/**   
* 文件名称: CpDayProfitService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-1 下午2:26:42<br/>
*/  
package com.mh.service;

import com.mh.commons.orm.Page;
import com.mh.entity.CpDayProfit;

/** 
 * 盈亏报表Service接口
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-1 下午2:26:42<br/>
 */
public interface CpDayProfitService {
	
	
	
	/**
	 * 盈亏列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param cpDayProfit
	 * @return  
	 * Page
	 */
	public Page findPage(Page page, CpDayProfit cpDayProfit);

}
