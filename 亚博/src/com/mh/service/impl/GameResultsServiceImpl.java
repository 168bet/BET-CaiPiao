/**   
* 文件名称: GameResultsServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-6 下午3:47:28<br/>
*/  
package com.mh.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.GameResultsDao;
import com.mh.entity.CpHistoryResults;
import com.mh.entity.CpTomResults;
import com.mh.service.GameResultsService;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-6 下午3:47:28<br/>
 */

@Service
public class GameResultsServiceImpl implements GameResultsService{
	@Autowired
	private GameResultsDao gameResultsDao;
	
	
	/**
	 * 獲取排期列表
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param limit
	 * @return  
	 * List<CpTomResults>
	 */
	@Override
	public List<CpTomResults> getTomResultList(String gameCode,int limit){
		return gameResultsDao.getTomResultList(gameCode, limit);
	}
	
	
	/**
	 * 獲取下一期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return  
	 * CpTomResults
	 */
	@Override
	public CpTomResults getTomResults(String gameCode){
		return this.gameResultsDao.getTomResults(gameCode);
	}
	
	
	/**
	 * 根据代码和期数获取下一期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param qs
	 * @return  
	 * CpTomResults
	 */
	@Override
	public CpTomResults getTomQsCache(String gameCode,String qs){
		return this.gameResultsDao.getTomQsCache(gameCode, qs);
	}
	
	/**
	 * 獲取開獎結果
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return  
	 * List<CpHistoryResults>
	 */
	@Override
	public List<CpHistoryResults> getHistoryResultsList(String gameCode,int limit){
		return this.gameResultsDao.getHistoryResultsList(gameCode,limit);
	}

}
