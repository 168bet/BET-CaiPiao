/**   
* 文件名称: GroupSelectUtils.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-10 下午4:57:37<br/>
*/  
package com.mh.web.util;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang.StringUtils;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-10 下午4:57:37<br/>
 */
public class GroupSelectUtils {
	
	public static Map<String,Map<String,Integer>> groupMap = new HashMap<String,Map<String,Integer>>();
	
	static{
		//福彩3D
 
		groupMap.put("FC3D_ZXS_QSW", getZXS(140));//组选三
		groupMap.put("FC3D_ZXL_QSW", getZXL(145));//组选六
		groupMap.put("FC3D_FSZH_QSW", getFCSDPL3FSZH());//复式组合
 
		
		//PL3
		groupMap.put("PL3_ZXS_QSW", getZXS(140));
		groupMap.put("PL3_ZXL_QSW", getZXL(145));
		groupMap.put("PL3_FSZH_QSW", getFCSDPL3FSZH());
 
		
		
		//重庆时时彩 
		//组选三
		groupMap.put("CQSSC_ZXS_QSW", getZXS(138));
		groupMap.put("CQSSC_ZXS_ZSW", getZXS(138));
		groupMap.put("CQSSC_ZXS_HSW", getZXS(138));
		
		//组选六
		groupMap.put("CQSSC_ZXL_QSW", getZXL(130));
		groupMap.put("CQSSC_ZXL_ZSW", getZXL(130));
		groupMap.put("CQSSC_ZXL_HSW", getZXL(130));
		
		//复式组合
		groupMap.put("CQSSC_FSZH_QSW", getSSC());
		groupMap.put("CQSSC_FSZH_ZSW", getSSC());
		groupMap.put("CQSSC_FSZH_HSW", getSSC());
		
		//江西时时彩
		//组选三
		groupMap.put("JXSSC_ZXS_QSW", getZXS(138));
		groupMap.put("JXSSC_ZXS_ZSW", getZXS(138));
		groupMap.put("JXSSC_ZXS_HSW", getZXS(138));
		//组选六
		groupMap.put("JXSSC_ZXL_QSW", getZXL(130));
		groupMap.put("JXSSC_ZXL_ZSW", getZXL(130));
		groupMap.put("JXSSC_ZXL_HSW", getZXL(130));
		//复式组合
		groupMap.put("JXSSC_FSZH_QSW", getSSC());
		groupMap.put("JXSSC_FSZH_ZSW", getSSC());
		groupMap.put("JXSSC_FSZH_HSW", getSSC());
		
		//天津时时彩
		//组选三
		groupMap.put("TJSSC_ZXS_QSW", getZXS(138));
		groupMap.put("TJSSC_ZXS_ZSW", getZXS(138));
		groupMap.put("TJSSC_ZXS_HSW", getZXS(138));
		//组选六
		groupMap.put("TJSSC_ZXL_QSW", getZXL(130));
		groupMap.put("TJSSC_ZXL_ZSW", getZXL(130));
		groupMap.put("TJSSC_ZXL_HSW", getZXL(130));
		//复式组合
		groupMap.put("TJSSC_FSZH_QSW", getSSC());
		groupMap.put("TJSSC_FSZH_ZSW", getSSC());
		groupMap.put("TJSSC_FSZH_HSW", getSSC());
		
		
		//新疆时时彩
		//组选三
		groupMap.put("XJSSC_ZXS_QSW", getZXS(138));
		groupMap.put("XJSSC_ZXS_ZSW", getZXS(138));
		groupMap.put("XJSSC_ZXS_HSW", getZXS(138));
		//组选六
		groupMap.put("XJSSC_ZXL_QSW", getZXL(130));
		groupMap.put("XJSSC_ZXL_ZSW", getZXL(130));
		groupMap.put("XJSSC_ZXL_HSW", getZXL(130));
		//复式组合
		groupMap.put("XJSSC_FSZH_QSW", getSSC());
		groupMap.put("XJSSC_FSZH_ZSW", getSSC());
		groupMap.put("XJSSC_FSZH_HSW", getSSC());
	}
	
	
	/**
	 * 福彩3D复式组合
	 * 方法描述: TODO</br> 
	 * @return  
	 * Map<String,Integer>
	 */
	public static Map<String,Integer> getFCSDPL3FSZH() {
		int[] intArr = new int[]{800, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 800, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 800, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				800, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 800, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 800, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 800, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				800, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 800, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820, 820,
				820, 820, 820, 820, 820, 820, 800};
			
		Map<String,Integer> map = new HashMap<String,Integer>();
		for(int i=0;i<intArr.length;i++){
			map.put(i+"", intArr[i]);
		}
		return map;
		
	}
	
	
	/**
	 * 时时彩概率
	 * 方法描述: TODO</br> 
	 * @return  
	 * Map<String,Integer>
	 */
	public static Map<String,Integer> getSSC() {
		int[] intArr = new int[]{800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800, 800,
				800, 800, 800, 800, 800, 800, 800};
			
		Map<String,Integer> map = new HashMap<String,Integer>();
		for(int i=0;i<intArr.length;i++){
			map.put(i+"", intArr[i]);
		}
		return map;
		
	}

 
	
	/**
	 * 福彩3D 组选三 概率
	 * 方法描述: TODO</br> 
	 * @return  
	 * List<String>
	 */
	public static Map<String,Integer> getZXS(int num) {
		Map<String,Integer>  map = new HashMap<String,Integer>();
		map.put("01",num);
		map.put("02",num);
		map.put("03",num);
		map.put("04",num);
		map.put("05",num);
		map.put("06",num);
		map.put("07",num);
		map.put("08",num);
		map.put("09",num);
		map.put("12",num);
		map.put("13",num);
		map.put("14",num);
		map.put("15",num);
		map.put("16",num);
		map.put("17",num);
		map.put("18",num);
		map.put("19",num);
		map.put("23",num);
		map.put("24",num);
		map.put("25",num);
		map.put("26",num);
		map.put("27",num);
		map.put("28",num);
		map.put("29",num);
		map.put("34",num);
		map.put("35",num);
		map.put("36",num);
		map.put("37",num);
		map.put("38",num);
		map.put("39",num);
		map.put("45",num);
		map.put("46",num);
		map.put("47",num);
		map.put("48",num);
		map.put("49",num);
		map.put("56",num);
		map.put("57",num);
		map.put("58",num);
		map.put("59",num);
		map.put("67",num);
		map.put("68",num);
		map.put("69",num);
		map.put("78",num);
		map.put("79",num);
		map.put("89",num);
		return map;
		
	}
	
	/**
	 * 福彩3D组选六
	 * 方法描述: TODO</br> 
	 * @return  
	 * Map<String,Integer>
	 */
	public static Map<String,Integer> getZXL(int num) {
		Map<String,Integer>  map = new HashMap<String,Integer>();
		map.put("12",num);
		map.put("13",num);
		map.put("14",num);
		map.put("15",num);
		map.put("16",num);
		map.put("17",num);
		map.put("18",num);
		map.put("19",num);
		map.put("23",num);
		map.put("24",num);
		map.put("25",num);
		map.put("26",num);
		map.put("27",num);
		map.put("28",num);
		map.put("29",num);
		map.put("34",num);
		map.put("35",num);
		map.put("36",num);
		map.put("37",num);
		map.put("38",num);
		map.put("39",num);
		map.put("45",num);
		map.put("46",num);
		map.put("47",num);
		map.put("48",num);
		map.put("49",num);
		map.put("56",num);
		map.put("57",num);
		map.put("58",num);
		map.put("59",num);
		map.put("67",num);
		map.put("68",num);
		map.put("69",num);
		map.put("78",num);
		map.put("79",num);
		map.put("89",num);
		map.put("123",num);
		map.put("124",num);
		map.put("125",num);
		map.put("126",num);
		map.put("127",num);
		map.put("128",num);
		map.put("129",num);
		map.put("134",num);
		map.put("135",num);
		map.put("136",num);
		map.put("137",num);
		map.put("138",num);
		map.put("139",num);
		map.put("145",num);
		map.put("146",num);
		map.put("147",num);
		map.put("148",num);
		map.put("149",num);
		map.put("156",num);
		map.put("157",num);
		map.put("158",num);
		map.put("159",num);
		map.put("167",num);
		map.put("168",num);
		map.put("169",num);
		map.put("178",num);
		map.put("179",num);
		map.put("189",num);
		map.put("234",num);
		map.put("235",num);
		map.put("236",num);
		map.put("237",num);
		map.put("238",num);
		map.put("239",num);
		map.put("245",num);
		map.put("246",num);
		map.put("247",num);
		map.put("248",num);
		map.put("249",num);
		map.put("256",num);
		map.put("257",num);
		map.put("258",num);
		map.put("259",num);
		map.put("267",num);
		map.put("268",num);
		map.put("269",num);
		map.put("278",num);
		map.put("279",num);
		map.put("289",num);
		map.put("345",num);
		map.put("346",num);
		map.put("347",num);
		map.put("348",num);
		map.put("349",num);
		map.put("356",num);
		map.put("357",num);
		map.put("358",num);
		map.put("359",num);
		map.put("367",num);
		map.put("368",num);
		map.put("369",num);
		map.put("378",num);
		map.put("379",num);
		map.put("389",num);
		map.put("456",num);
		map.put("457",num);
		map.put("458",num);
		map.put("459",num);
		map.put("467",num);
		map.put("468",num);
		map.put("469",num);
		map.put("478",num);
		map.put("479",num);
		map.put("489",num);
		map.put("567",num);
		map.put("568",num);
		map.put("569",num);
		map.put("578",num);
		map.put("579",num);
		map.put("589",num);
		map.put("678",num);
		map.put("679",num);
		map.put("689",num);
		map.put("789",num);
		
		return map;
		
	}
	
	
 
	
	
	/**
	 * 多组概率
	 * 方法描述: TODO</br> 
	 * @param bwList
	 * @param swList
	 * @param gwList
	 * @param code
	 * @param type
	 * @return  
	 * List<String>
	 */
	public static List<String> getGroupSelectMoreRate(List<String> bwList,List<String> swList,List<String> gwList,String key){
		List<String> paramList = new ArrayList<String>();
		Map<String,Integer> zrateMap = GroupSelectUtils.groupMap.get(key);
		if(zrateMap==null){
			return null;
		}
		double betRate=0;
		double ItemRate = 0;
		int betCount = 0;
		String tnum = "";
		for (int i = 0; i < bwList.size(); i++) {
			for (int j = 0; j < swList.size(); j++) {
				for (int k = 0; k < gwList.size(); k++) {
					tnum = bwList.get(i) + swList.get(j) + gwList.get(k);
					ItemRate += zrateMap.get(Integer.valueOf(tnum)+"");
 
					betCount++;
				}
			}
		}
 
	 
		
		StringBuffer buff = new StringBuffer("");
		StringBuffer buff2 = new StringBuffer("");
		if (ItemRate > -1 && betCount >= 9) {
			betRate = Math.round(ItemRate / (betCount * betCount) * 100) / 100.0;		
			buff.append("(").append("百").append(StringUtils.join(bwList.toArray(),","));
			buff.append(") x ");
			buff.append("(").append("拾").append(StringUtils.join(swList.toArray(),","));
			buff.append(") x ");
			buff.append("(").append("个").append(StringUtils.join(gwList.toArray(),","));
			buff.append(")");
			
			
			buff2.append(StringUtils.join(bwList.toArray(),","));
			buff2.append("#");
			buff2.append(StringUtils.join(swList.toArray(),","));
			buff2.append("#");
			buff2.append(StringUtils.join(gwList.toArray(),","));
		}
		paramList.add(buff.toString());
		paramList.add(buff2.toString());
		paramList.add(betRate+"");
		
	
		
		return paramList;
		
	}
	
	
	/**
	 * 获取组选三概率
	 * 方法描述: TODO</br> 
	 * @param list
	 * @param code
	 * @param type
	 * @return  
	 * double
	 */
	public static double getGroupSelect3Rate(List<String> list,String key){
		Map<String,Integer> zrateMap = GroupSelectUtils.groupMap.get(key);
		if(zrateMap==null){
			return 0;
		}
		
		int lrate = 0;
		int betCount = 0;
		double betRate=0;
		String tmpstr="";
		for (int i = 0; i < list.size() - 1; i++) {
			for (int k = i + 1; k < list.size(); k++) {
				tmpstr = list.get(i) + list.get(k);
				if(zrateMap.get(tmpstr)!=null ){
					
					int zrate = zrateMap.get(tmpstr);
					betRate += zrate;		
					lrate++;
				}
			}
		}
		betRate = betRate / lrate;
		if (betCount >= 0) {
			betRate = Math.round((betRate / lrate) * 100) / 100.0;
		}
		return betRate;
	}
	
	/**
	 * 福彩3D组选6
	 * 方法描述: TODO</br> 
	 * @param list
	 * @param code
	 * @param type
	 * @return  
	 * double
	 */
	public static double getGroupSelect6Rate(List<String> list,String key){
		Map<String,Integer> zrateMap = GroupSelectUtils.groupMap.get(key);
		if(zrateMap==null){
			return 0;
		}
		
		int lrate = 0;
		int betCount = 0;
		double betRate=0;
		String tmpstr="";
		for (int i = 0; i < list.size() - 2; i++) {
			for (int k = i + 1; k < list.size() - 1; k++) {
				for (int z = k + 1; z < list.size(); z++) {
					tmpstr = list.get(i) + list.get(k)+ list.get(z);
					if(zrateMap.get(Integer.valueOf(tmpstr)+"")!=null){
						int zrate = zrateMap.get(Integer.valueOf(tmpstr)+"");
						betRate += zrate;
						lrate++;
					}
					
				}
			}
		}
		betRate = betRate / lrate;
		if (betCount >= 0) {
			betRate = Math.round((betRate / lrate) * 100) / 100.0;
		}
		return betRate;
	}
	
	public static double choiceRate(List<String> list,String key,int len){
		if(len==3){
			return getGroupSelect3Rate(list,key);
		}else if(len==6){
			return getGroupSelect6Rate(list,key);
		}else{
			
		}
		return 0;
	}
	
 
	
}
