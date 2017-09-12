/**   
* 文件名称: GameResultsService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-6 下午3:04:27<br/>
*/  
package com.mh.dao;

import java.util.Date;
import java.util.List;

import org.springframework.stereotype.Repository;

import com.mh.commons.cache.CpCacheUtil;
import com.mh.commons.orm.BaseDao;
import com.mh.entity.CpHistoryResults;
import com.mh.entity.CpTomResults;

/** 
 * 
 * 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-6 下午3:04:27<br/>
 */

@Repository
public class GameResultsDao extends BaseDao{
	
	/**
	 * 獲取排期列表
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param limit
	 * @return  
	 * List<CpTomResults>
	 */
	public List<CpTomResults> getTomResultList(String gameCode,int limit){
		
		return CpCacheUtil.getTomCacheList(gameCode, new Date(), limit);
 
	}
	
	/**
	 * 獲取下一期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return  
	 * CpTomResults
	 */
	public CpTomResults getTomResults(String gameCode){
		return CpCacheUtil.getTomCache(gameCode, new Date());
	}
	
	
	/**
	 * 根据代码和期数获取下一期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param qs
	 * @return  
	 * CpTomResults
	 */
	public CpTomResults getTomQsCache(String gameCode,String qs){
		return CpCacheUtil.getTomQsCache(gameCode,qs);
	}
	
	
	/**
	 * 獲取開獎結果
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return  
	 * List<CpHistoryResults>
	 */
	public List<CpHistoryResults> getHistoryResultsList(String gameCode,int limit){
		
		return CpCacheUtil.getResultCache(gameCode,limit);
		
	}
	

}
