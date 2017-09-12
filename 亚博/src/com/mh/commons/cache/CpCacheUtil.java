/**   
* 文件名称: CpCacheUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-5-17 上午3:56:57<br/>
*/  
package com.mh.commons.cache;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.mh.commons.conf.CacheConstant;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.utils.DateUtil;
import com.mh.entity.CpHistoryResults;
import com.mh.entity.CpTomResults;

/** 
 * 彩票缓存
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-5-17 上午3:56:57<br/>
 */
@SuppressWarnings("all")
public class CpCacheUtil {
	
	private static Logger logger = LoggerFactory.getLogger(CpCacheUtil.class);
	
	
	/**
	 * 判断开奖结果是否存在
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param qs
	 * @return  
	 * boolean
	 */
	public static boolean isExistsOpenResults(String gameCode,String qs){
		String key=CacheConstant.CACHE_RESULT_CODE+gameCode.toLowerCase();
		if(MemCachedUtil.get(key)==null){
			logger.error(gameCode+"开奖结果缓存:"+key+"为空！");
			return false;
		}
		
		Map<String,String> resultsMap = new LinkedHashMap<String,String>();
		List<Object[]> valList=(List<Object[]>) MemCachedUtil.get(key);
		for(int i=0;i<valList.size();i++){
			Object[] objArr = valList.get(i);
//			String qs =  String.valueOf(objArr[1]);
			String formatQs = String.valueOf(objArr[2]);
			resultsMap.put(formatQs, formatQs);
		}
		if(resultsMap.get(qs)!=null){
			return true;
		}
		return false;
	}
	
	
	/**
	 * 开奖结果缓存
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param batchArgs  
	 * void
	 */
	public static List<CpHistoryResults> getResultCache(String gameCode,int rows){
		String key=CacheConstant.CACHE_RESULT_CODE+gameCode.toLowerCase();
		if(MemCachedUtil.get(key)==null){
			logger.error(gameCode+"开奖结果缓存:"+key+"为空！");
			return null;
		}
		List<Object[]> valList=(List<Object[]>) MemCachedUtil.get(key);
		List<CpHistoryResults> resultsList = new ArrayList<CpHistoryResults>();
		CpHistoryResults historyResults=null;
		int len = valList.size();
		if(len>rows){
			len=rows;
		}
		for(int i=0;i<len;i++){
			historyResults = new CpHistoryResults();
			Object[] objArr = valList.get(i);
//			String qs =  String.valueOf(objArr[1]);
			String formatQs = String.valueOf(objArr[2]);
			String kjsj = String.valueOf(objArr[3]);
			String gtkjsj = String.valueOf(objArr[4]);
			String opencode = String.valueOf(objArr[5]);
			opencode = opencode.replaceAll("\\+", ",");
			historyResults.setCode(gameCode);
			historyResults.setQs(formatQs);
			historyResults.setKjsj(kjsj);
			historyResults.setGtKjsj(gtkjsj);
			historyResults.setKjjg(opencode);
			resultsList.add(historyResults);
		}
		return resultsList;
		
	}
	
	
	/**
	 * 开奖结果缓存
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param batchArgs  
	 * void
	 */
	public static List<CpHistoryResults> getResultCache(String gameCode){
		String key=CacheConstant.CACHE_RESULT_CODE+gameCode.toLowerCase();
		if(MemCachedUtil.get(key)==null){
			logger.error(gameCode+"开奖结果缓存:"+key+"为空！");
			return null;
		}
		List<Object[]> valList=(List<Object[]>) MemCachedUtil.get(key);
		List<CpHistoryResults> resultsList = new ArrayList<CpHistoryResults>();
		CpHistoryResults historyResults=null;
		for(int i=0;i<valList.size();i++){
			historyResults = new CpHistoryResults();
			Object[] objArr = valList.get(i);
//			String qs =  String.valueOf(objArr[1]);
			String formatQs = String.valueOf(objArr[2]);
			String kjsj = String.valueOf(objArr[3]);
			String gtkjsj = String.valueOf(objArr[4]);
			String opencode = String.valueOf(objArr[5]);
			opencode = opencode.replaceAll("\\+", ",");
			historyResults.setCode(gameCode);
			historyResults.setQs(formatQs);
			historyResults.setKjsj(kjsj);
			historyResults.setGtKjsj(gtkjsj);
			historyResults.setKjjg(opencode);
			resultsList.add(historyResults);
		}
		return resultsList;
		
	}
	
	/**
	 * 获取批量下一期排期
	 * 方法描述: TODO</br> 
	 * @param codeList
	 * @return  
	 * List<CpTomResults>
	 */
	public static List<CpTomResults> getBatchTomCache(List<String> codeList){
		Date _date = new Date();
		String dateStr="";
		try{
			dateStr = CpIfcUtil.getCurrTime();
			if("".equals(dateStr)){
				dateStr = DateUtil.format(_date, "yyyy-MM-dd HH:mm:ss");
			}
		}catch(Exception e){
			dateStr = DateUtil.format(_date, "yyyy-MM-dd HH:mm:ss");
			e.printStackTrace();
		}finally{
			try {
				_date = DateUtil.parse(dateStr, "yyyy-MM-dd HH:mm:ss");
			} catch (ParseException e1) {
				e1.printStackTrace();
			}
		}
		List<CpTomResults> tomList = new ArrayList<CpTomResults>();
		CpTomResults tom = null;
		for(String _code:codeList){
			tom = getTomCache(_code,_date);
			tomList.add(tom);
		}
		return tomList;
		
	}
	
	
	/**
	 * 獲取前幾期排期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param _date
	 * @param limits
	 * @return  
	 * List<CpTomResults>
	 */
	public static List<CpTomResults> getTomCacheList(String gameCode,Date _date,int limit){
		String key=CacheConstant.CACHE_TOM_CODE+gameCode.toLowerCase();
		if(MemCachedUtil.get(key)==null){
			logger.error(gameCode+"下一期排期缓存:"+key+"为空！");
			return null;
		}
		List<Object[]> valList= (List<Object[]>) MemCachedUtil.get(key);
		int len = valList.size();
		if(len>limit){
			len = limit;
		}
		
		List<CpTomResults> list = new ArrayList<CpTomResults>();
		CpTomResults tomResults = null;
		for(int i=0;i<len;i++){
			Object[] objArr = valList.get(i);
			String code = String.valueOf(objArr[0]);
//			String qs = String.valueOf(objArr[1]);
			String formatQs = String.valueOf(objArr[2]);
			String kjsj = String.valueOf(objArr[3]);
			String gtkjsj = String.valueOf(objArr[4]);
			Date gtKjsjDate = null;
			try {
				gtKjsjDate= DateUtil.parse(gtkjsj, "yyyy-MM-dd HH:mm:ss");
			} catch (ParseException e) {
				e.printStackTrace();
			}
			if(_date.getTime()<gtKjsjDate.getTime()){
				tomResults = new CpTomResults();
				tomResults.setCode(code);
				tomResults.setQs(formatQs);
				tomResults.setFormatQs(formatQs);
//				tomResults.setKjsj(kjsj);
				tomResults.setKjsj(gtkjsj);
				tomResults.setGtKjsj(gtkjsj);
				list.add(tomResults);
			}
			
		}
		return list;
		
	}
	
	
	/**
	 * 下一期结果缓存
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param batchArgs  
	 * void
	 */
	public static CpTomResults getTomCache(String gameCode,Date _date){
	
		String key=CacheConstant.CACHE_TOM_CODE+gameCode.toLowerCase();
		if(MemCachedUtil.get(key)==null){
			logger.error(gameCode+"下一期排期缓存:"+key+"为空！");
			return null;
		}
		List<Object[]> valList= (List<Object[]>) MemCachedUtil.get(key);
		CpTomResults tomResults = null;
		for(int i=0;i<valList.size();i++){
			Object[] objArr = valList.get(i);
			String code = String.valueOf(objArr[0]);
//			String qs = String.valueOf(objArr[1]);
			String formatQs = String.valueOf(objArr[2]);
			String kjsj = String.valueOf(objArr[3]);
			String gtkjsj = String.valueOf(objArr[4]);
			Date gtKjsjDate = null;
			try {
				gtKjsjDate= DateUtil.parse(gtkjsj, "yyyy-MM-dd HH:mm:ss");
			} catch (ParseException e) {
				e.printStackTrace();
			}
	 
			if(_date.getTime()<gtKjsjDate.getTime()){
				tomResults = new CpTomResults();
				tomResults.setCode(code);
				tomResults.setQs(formatQs);
				tomResults.setFormatQs(formatQs);
//				tomResults.setKjsj(kjsj);
				tomResults.setKjsj(gtkjsj);
				tomResults.setGtKjsj(gtkjsj);
				 
				if(i>0){
					objArr=null;
					objArr = valList.get(i-1);
					String preFormatQs = String.valueOf(objArr[2]);
					String preKjsj = String.valueOf(objArr[3]);
					String preGtKjsj = String.valueOf(objArr[4]);
					
					tomResults.setPreQs(preFormatQs);
					tomResults.setPreFormatQs(preFormatQs);
//					tomResults.setPreKjsj(preKjsj);
					tomResults.setPreKjsj(preGtKjsj);
					tomResults.setPreGtKjsj(preGtKjsj);
				}
				 
				return tomResults;
			}
			
		}
		return tomResults;
	}
	
	
	/**
	 * 下一期结果缓存
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @param batchArgs  
	 * void
	 */
	public static CpTomResults getTomQsCache(String gameCode,String openQs){
	
		String key=CacheConstant.CACHE_TOM_CODE+gameCode.toLowerCase();
		if(MemCachedUtil.get(key)==null){
			logger.error(gameCode+"下一期排期缓存:"+key+"为空！");
			return null;
		}
		List<Object[]> valList= (List<Object[]>) MemCachedUtil.get(key);
		CpTomResults tomResults = null;
		for(int i=0;i<valList.size();i++){
			Object[] objArr = valList.get(i);
			String code = String.valueOf(objArr[0]);
			String qs = String.valueOf(objArr[1]);
			String formatQs = String.valueOf(objArr[2]);
			String kjsj = String.valueOf(objArr[3]);
			String gtkjsj = String.valueOf(objArr[4]);
			Date gtKjsjDate = null;
			try {
				gtKjsjDate= DateUtil.parse(gtkjsj, "yyyy-MM-dd HH:mm:ss");
			} catch (ParseException e) {
				e.printStackTrace();
			}
			
			System.out.println(openQs+"================="+qs);
			if(openQs.equals(qs)){
				tomResults = new CpTomResults();
				tomResults.setCode(code);
				tomResults.setQs(formatQs);
				tomResults.setFormatQs(formatQs);
//				tomResults.setKjsj(kjsj);
				tomResults.setKjsj(gtkjsj);
				tomResults.setGtKjsj(gtkjsj);
 
				return tomResults;
			}
			
		}
		return tomResults;
	}
 
}
