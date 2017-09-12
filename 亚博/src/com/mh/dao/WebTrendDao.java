/**   
* 文件名称: WebTrendDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-13 上午1:47:48<br/>
*/  
package com.mh.dao;



import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.constants.CpCommonConstant;
import com.mh.commons.utils.HttpClientUtil;

/** 
 * 走势图接口
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-13 上午1:47:48<br/>
 */

@Repository
public class WebTrendDao {
	
	
	/**
	 * 获取开奖结果
	 * 方法描述: TODO</br> 
	 * @param params
	 * @return  
	 * List<Object[]>
	 */
	public Map<String,Object> getResultsList(Map<String,String> params){
		String code = params.get("code");
		
		Map<String,Object> valMap = new HashMap<String,Object>();
		
		List<Object[]> objList = new ArrayList<Object[]>();
		String cpRJson = HttpClientUtil.getCpHistoryResult(params); //远程调用开奖结果
		JSONObject parseObject = JSONObject.fromObject(cpRJson);
		if (StringUtils.equals("000000", parseObject.getString("code"))&&null!=parseObject.get("msInfo")) {
			JSONArray jsonArray = (JSONArray) parseObject.get("msInfo");
			
			String totalPages = parseObject.getString("totalPages");
			
			valMap.put("totalPages", totalPages);
			JSONObject jsonObject = null;
			for(int i=0;i<jsonArray.size();i++){
				jsonObject = jsonArray.getJSONObject(i);
				List<Object> valList = new ArrayList<Object>();
				String qs = jsonObject.getString("qs");
				String formatQs = jsonObject.getString("formatQs");
				String gtKjsj = jsonObject.getString("gtKjsj");
				String kjsj = jsonObject.getString("kjsj");
				String kjjg = jsonObject.getString("kjjg");
				int baozi =0;
				if (CpCommonConstant.BJKL8_CODE_PARAM.equals(code)) {
					kjjg = jsonObject.getString("xy28Kjjg");
					int d1q = Integer.valueOf(jsonObject.getString("d1q"));
					int d2q = Integer.valueOf(jsonObject.getString("d2q"));
					int d3q = Integer.valueOf(jsonObject.getString("d3q"));
					if(d1q==d2q && d2q==d3q){
						baozi=1;
					}
					
				} else if(CpCommonConstant.CAKENO_CODE_PARAM.equals(code)){
					kjjg = jsonObject.getString("jndKjjg");
					int d1q = Integer.valueOf(jsonObject.getString("d1q"));
					int d2q = Integer.valueOf(jsonObject.getString("d2q"));
					int d3q = Integer.valueOf(jsonObject.getString("d3q"));
					if(d1q==d2q && d2q==d3q){
						baozi=1;
					}
				}
				valList.add(qs);
				valList.add(formatQs);
				valList.add(gtKjsj);
				valList.add(kjsj);
				valList.add(kjjg);
				valList.add(baozi);
				objList.add(valList.toArray());
			}
		}
		valMap.put("list", objList);
		return valMap;
	}

}
