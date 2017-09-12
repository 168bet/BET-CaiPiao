/**   
* 文件名称: TrendUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-13 上午4:25:39<br/>
*/  
package com.mh.web.util;

import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mh.commons.constants.CpCommonConstant;

/** 
 * 走势图工具类
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-13 上午4:25:39<br/>
 */
public class TrendUtil {
	
	
	/**
	 * 获取走势图
	 * 方法描述: TODO</br> 
	 * @param code
	 * @param dataList
	 * @return  
	 * JSONObject
	 */
	public static JSONObject getTrend(String code,List<Object[]> dataList){
		
		if (CpCommonConstant.CAKENO_CODE_PARAM.equals(code) || CpCommonConstant.BJKL8_CODE_PARAM.equals(code)) {
			return getXy28Trend(dataList);
		}
		return null;
	}
	
	/**
	 * 获取幸运28的走势图
	 * 方法描述: TODO</br> 
	 * @param dataList
	 * @return  
	 * JSONObject
	 */
	public static JSONObject getXy28Trend(List<Object[]> dataList){
//		valList.add(qs);
//		valList.add(formatQs);
//		valList.add(gtKjsj);
//		valList.add(kjsj);
//		valList.add(kjjg);
		
		
		JSONObject all = new JSONObject();
		
		String[] sumArr = new String[]{"0","1","2","3","4","5","6","7","8","9","10","11","12","13"
				,"14","15","16","17","18","19","20","21","22","23","24","25","26","27","单","双","中","边","大","小","极","豹"};
		Map<String,Integer> sumMap = new HashMap<String,Integer>();
		for(int i=0;i<sumArr.length;i++){
			sumMap.put(sumArr[i], 0);
		}
		
		JSONArray jsonArray  = new JSONArray();
		for(int i=0;i<dataList.size();i++){
			JSONObject obj = new JSONObject();
			Object[] objArr = dataList.get(i);
			String qs = objArr[0].toString();
			String kjjg =  objArr[4].toString();
			String baozi = objArr[5].toString();
			obj.put("qs", qs);
			obj.put("number", kjjg);
			int _oc = Integer.valueOf(kjjg);
			
			String _ocStr = String.valueOf(_oc);
 
			int total = sumMap.get(_ocStr);
			if(sumMap.containsKey(_ocStr)){
				total++;
			}
			sumMap.put(_ocStr, total);
			
			String dsKey = "";
			if(_oc%2==0){
				obj.put("ds", "双");
				dsKey = "双";
			}else{
				obj.put("ds", "单");
				dsKey = "单";
			}
			int total2 = sumMap.get(dsKey);
			if(sumMap.containsKey(dsKey)){
				total2++;
			}
			sumMap.put(dsKey, total2);
			
			
			
			String zbKey = "";
			if(_oc>=10&&_oc<=17){
				obj.put("zb", "中");
				zbKey = "中";
			}else{
				obj.put("zb", "边");
				zbKey = "边";
			}
			int total3 = sumMap.get(zbKey);
			if(sumMap.containsKey(zbKey)){
				total3++;
			}
			sumMap.put(zbKey, total3);
			
			
			
			String dxKey = "";
			if(_oc>13){
				obj.put("dx", "大");
				dxKey = "大";
			}else{
				obj.put("dx", "小");
				dxKey = "小";
			}
			int total4 = sumMap.get(dxKey);
			if(sumMap.containsKey(dxKey)){
				total4++;
			}
			sumMap.put(dxKey, total4);
			
			
			
			int[] fastBigArr = new int[]{22,23,24,25,26,27};
			int[] fastSmallArr = new int[]{0,1,2,3,4,5};
			List<int[]> jdList = Arrays.asList(fastBigArr);
			List<int[]> jxList = Arrays.asList(fastSmallArr);
			String jzKey = "";
			if(jdList.contains(_oc)){
				obj.put("jz", "大");
				jzKey = "极";
			}else if(jxList.contains(_oc)){
				obj.put("jz", "小");
				jzKey = "极";
			}else{
				obj.put("jz", "");
			}
			if(!"".equals(jzKey)){
				
				int total5 = sumMap.get(jzKey);
				if(sumMap.containsKey(jzKey)){
					total5++;
				}
				sumMap.put(jzKey, total5);
			}
			
			
			String bzKey = "";
			if("1".equals(baozi)){
				obj.put("bz", "豹");
				bzKey = "豹";
			}else{
				obj.put("bz", "");
			}
			if(!"".equals(bzKey)){
				
				int total6 = sumMap.get(bzKey);
				if(sumMap.containsKey(bzKey)){
					total6++;
				}
				sumMap.put(bzKey, total6);
			}

			jsonArray.add(obj);
		}
		JSONArray sumArray  = getArraySum(sumArr,sumMap);
		
		all.put("data", jsonArray);
		all.put("sum", sumArray);

		return all;

	}
	
	
	
	public static JSONArray getArraySum(String[] sumArr,Map<String,Integer> sumMap){
		
		JSONArray sumArray  = new JSONArray();
		for(int i=0;i<sumArr.length;i++){
			if(sumMap.get(sumArr[i])!=null){
				sumArray.add(sumMap.get(sumArr[i]));
			}
		}
	
		return sumArray;
		
	}
	
	

}
