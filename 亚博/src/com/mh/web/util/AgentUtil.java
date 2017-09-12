/**   
* 文件名称: AgentUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-8 下午4:56:32<br/>
*/  
package com.mh.web.util;

import java.text.ParseException;
import java.util.Date;
import java.util.Map;

import com.alibaba.fastjson.JSONArray;
import com.mh.commons.utils.DateUtil;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-8 下午4:56:32<br/>
 */
public class AgentUtil {
	
	
	public static JSONArray getAgentArray(String beginTimeStr,String endTimeStr,Map<String,Object> dataMap){
		if(beginTimeStr.equals(endTimeStr)){
			return getAgentDayArray(dataMap);
		}else{
			return getAgentMoreDayArray(beginTimeStr,endTimeStr,dataMap);
		}
	}
	
	
	public static JSONArray getAgentMoreDayArray(String beginTimeStr,String endTimeStr,Map<String,Object> dataMap){
		JSONArray jsonArray = new JSONArray();
		Date beginTime = null;
		Date endTime = null;
		try {
			beginTime = DateUtil.parse(beginTimeStr, DateUtil.YEAR_MONTH_DAY_PATTERN_MIDLINE);
			endTime = DateUtil.parse(endTimeStr, DateUtil.YEAR_MONTH_DAY_PATTERN_MIDLINE);
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		int days = DateUtil.beforeDays(beginTime, endTime);
 
		for(int i=0;i<days;i++){
			Date date = DateUtil.addDay(beginTime, i);
			String dateStr = DateUtil.format(date,  DateUtil.YEAR_MONTH_DAY_PATTERN_MIDLINE);
			
			JSONArray dayArray = new JSONArray();
		 
			double val =0;
			if(dataMap.get(dateStr)!=null){
 
				val = Double.valueOf(dataMap.get(dateStr).toString());
			}
			dayArray.add(i);
			dayArray.add(val);
			jsonArray.add(dayArray);
		}
		
		return jsonArray;
	}
	
	
	public static JSONArray getAgentDayArray(Map<String,Object> dataMap){
		JSONArray jsonArray = new JSONArray();
		
		for(int i=0;i<24;i++){
			JSONArray dayArray = new JSONArray();
			String day = String.valueOf(i);
			if(i<10){
				day = "0"+i;
			}
			double val =0;
			if(dataMap.get(day)!=null){
				val = Double.valueOf(dataMap.get(day).toString());
			}
			dayArray.add(i);
			dayArray.add(val);
			jsonArray.add(dayArray);
		}
		
		return jsonArray;
	}

}
