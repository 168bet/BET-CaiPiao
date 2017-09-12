/**   
* 文件名称: GameResultsService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-6 下午3:47:19<br/>
*/  
package com.mh.service;

import java.util.List;

import com.mh.entity.CpHistoryResults;
import com.mh.entity.CpTomResults;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-6 下午3:47:19<br/>
 */
public interface GameResultsService {
	
	/**
	 * 獲取排期列表
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param limit
	 * @return  
	 * List<CpTomResults>
	 */
	public List<CpTomResults> getTomResultList(String gameCode,int limit);
	
	
	/**
	 * 獲取下一期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return  
	 * CpTomResults
	 */
	public CpTomResults getTomResults(String gameCode);
	
	
	/**
	 * 根据代码和期数获取下一期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param qs
	 * @return  
	 * CpTomResults
	 */
	public CpTomResults getTomQsCache(String gameCode,String qs);
	
	/**
	 * 獲取開獎結果
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return  
	 * List<CpHistoryResults>
	 */
	public List<CpHistoryResults> getHistoryResultsList(String gameCode,int limit);

}
