/**   
* 文件名称: IfcUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-25 下午3:03:43<br/>
*/  
package com.mh.commons.utils;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.mh.commons.conf.CommonConstant;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.HttpClientUtil;
import com.mh.entity.CpHistoryResults;
import com.mh.entity.CpTomResults;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-25 下午3:03:43<br/>
 */
public class CpIfcUtil {
	
	private static final Logger logger = LoggerFactory.getLogger(CpIfcUtil.class);
	
	/**
	 * 获取彩票结果
	 * @param params
	 * @return
	 * @throws Exception
	 */
	public static String  getCpHistoryResult(Map<String, String> params){
		String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
		String respJson = HttpClientUtil.post(url + "/cp/agent/api/getHistoryResult", params);
		if(StringUtils.isEmpty(params.get("code"))){
			logger.info("历史开奖记录：返回的报文"+respJson);
		}else{
			logger.info(params.get("code")+"历史开奖:返回报文:"+respJson);
		}
		return respJson;
	}
	
	/**
	 * 获取彩票结果
	 * @param params
	 * @return
	 * @throws Exception
	 */
	public static List<CpHistoryResults>  cpUpNewResult(String gameCode,String rows) throws Exception {
		Map<String, String> params = new HashMap<String,String>();
		params.put("rows", rows);
		params.put("code", gameCode);
		
		String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
		String respJson = HttpClientUtil.post(url + "/cp/agent/api/cpUpNewResult", params);
		if(StringUtils.isEmpty(respJson)){
			logger.error("【"+gameCode+"】查询历史开奖结果接口，报文返回为空");
			return null;
		}
		JSONObject parseObject = JSONObject.fromObject(respJson);
		List<CpHistoryResults> resultsList = null;
		if (StringUtils.equals("000000", parseObject.getString("code"))&&null!=parseObject.get("msInfo")) {
			resultsList = new ArrayList<CpHistoryResults>();
			
			JSONArray jsonArray=(JSONArray)parseObject.get("msInfo");
			CpHistoryResults results = null;
			for(int i=0;i<jsonArray.size();i++){
				results = new CpHistoryResults();
				JSONObject jsonObject = jsonArray.getJSONObject(i);
				results.setQs(jsonObject.getString("qs"));
				results.setKjjg(jsonObject.getString("kjjg"));
				results.setKjsj(jsonObject.getString("kjsj"));
				results.setGtKjsj(jsonObject.getString("gtKjsj"));
				results.setCode(jsonObject.getString("code"));
				resultsList.add(results);
			}
		}
		logger.info(params.get("code")+"上期开奖结果：返回报文:"+respJson);
		return resultsList;
	}

	
	
	
	/**
	 * 获取下一期排期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return
	 * @throws Exception  
	 * CpTomResults
	 */
	public static CpTomResults  getCpNextResult(String gameCode) throws Exception {
		
		// 获取北京时间
		Date currDate = new Date();
		Date bjDate = DateUtil.addHour(currDate, 12);
		String fromDateStr = DateUtil.format(bjDate, "yyyy-MM-dd");
		Map<String, String> map = new HashMap<String, String>();
		map.put("code", gameCode);
		map.put("fromDateStr", fromDateStr);
		String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
		String respJson = HttpClientUtil.post(url + "/cp/agent/api/getQsResult", map);
		JSONObject fromObject = JSONObject.fromObject(respJson);
		if(null==fromObject.get("msInfo")){
			logger.info("【"+gameCode+"】: 下一期没有排期结果!");
			return null;
		}
		
		CpTomResults tomResults = null;
		if (StringUtils.equals("000000", fromObject.getString("code"))&&null!=fromObject.get("msInfo")) {
			tomResults = new CpTomResults();
			JSONArray jsonArray = (JSONArray)fromObject.get("msInfo");
			JSONObject jsonObject = (JSONObject) jsonArray.get(0);
			String formartQs=(String)jsonObject.get("formatQs");
			String kjsj=(String)jsonObject.get("kjsj");
			String gtKjsj = (String)jsonObject.get("gtKjsj");
			tomResults.setKjsj(kjsj);
			tomResults.setGtKjsj(gtKjsj);
			tomResults.setQs(formartQs);
	 
		}
 
		return tomResults;
	}
	
	/**
	 * 获取批量下一期排期
	 * 方法描述: TODO</br> 
	 * @param gameCode
	 * @return
	 * @throws Exception  
	 * CpTomResults
	 */
	public static List<CpTomResults>  getCpBatchNextResult(List<String> codeList) throws Exception {
		StringBuffer buff = new StringBuffer("");
		for(int i=0;i<codeList.size();i++){
			if(i>0){
				buff.append(",");
			}
			buff.append(codeList.get(i));
		}
		String codes = buff.toString();
		
		// 获取北京时间
		Date currDate = new Date();
		Date bjDate = DateUtil.addHour(currDate, 12);
		String fromDateStr = DateUtil.format(bjDate, "yyyy-MM-dd");
		Map<String, String> map = new HashMap<String, String>();
		map.put("code", codes);
		map.put("fromDateStr", fromDateStr);
		String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
		String respJson = HttpClientUtil.post(url + "/cp/agent/api/getQsResult", map);
		JSONObject fromObject = JSONObject.fromObject(respJson);
		if(null==fromObject.get("msInfo")){
			logger.info("【"+codes+"】: 下一期没有排期结果!");
			return null;
		}
		
		List<CpTomResults> tomResultsList = null;
		if (StringUtils.equals("000000", fromObject.getString("code"))&&null!=fromObject.get("msInfo")) {
			tomResultsList = new ArrayList<CpTomResults>();
			JSONArray jsonArray = (JSONArray)fromObject.get("msInfo");
			CpTomResults tomResults = null;
			for (int i = 0; i < jsonArray.size(); i++) {
				tomResults = new CpTomResults();
				
				JSONObject jsonObject = (JSONObject) jsonArray.get(i);
				String formartQs=(String)jsonObject.get("formatQs");
				String kjsj=(String)jsonObject.get("kjsj");
				String gtKjsj = (String)jsonObject.get("gtKjsj");
				tomResults.setKjsj(kjsj);
				tomResults.setGtKjsj(gtKjsj);
				tomResults.setQs(formartQs);
				tomResultsList.add(tomResults);
			}
		}
 
		return tomResultsList;
	}
	
	
	public static String getCurrTime(){
		String dateStr = "";
		// 获取远程接口的时间
		try {
			
			
			String timeJson = CpIfcUtil.getSpareTime();
			net.sf.json.JSONObject object = net.sf.json.JSONObject.fromObject(timeJson);
			String bjTime = (String) object.get("now");
			Date time=null;
			try {
				time = DateUtil.parse(bjTime, "yyyy-MM-dd HH:mm:ss");
			} catch (ParseException e) {
				e.printStackTrace();
			}
			Date gtTime = DateUtil.addHour(time, -12);
			dateStr =DateUtil.formatDate(gtTime, "yyyy-MM-dd HH:mm:ss");
		} catch (Exception e) {
			dateStr = "";
			logger.error("获取远程接口时间异常！", e);
		}
		if("".equals(dateStr)){
			dateStr = CpIfcUtil.getCpTime();
			dateStr=StringUtils.replace(dateStr, "\"", "");
		}
		if("".equals(dateStr)){
			dateStr =DateUtil.format(new Date(), "yyyy-MM-dd HH:mm:ss");
		}
		
		return dateStr;
	}
	
	
	
	
	public static String  getCpTime() {
		Map<String, String> params=new HashMap<String,String>();
		String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
		String respJson = HttpClientUtil.post(url + "/cp/agent/api/getTime", params);
//		logger.info("获取接口的时间:返回报文:"+respJson);
		return respJson;
	}
	/**
	 *远程时间备用地址
	 * @return
	 * @throws Exception
	 */
	public static String  getSpareTime(){
		Map<String, String> params=new HashMap<String,String>();
		String url = CommonConstant.resCommMap.get(CommonConstant.APIPLUS_IFC_URL);
		String respJson = HttpClientUtil.post(url, params);
//		logger.info("获取备用时间:返回报文:"+respJson);
		return respJson;
	}
	
	/**
	 * 彩票shared订单
	 * @return 200:成功  400:失败
	 */
	public static int saveSharedOrder(Map<String, String> params){
		try {
			String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
			String respJson = HttpClientUtil.post(url + "/cp/agent/api/cpSaveOrder", params);
			JSONObject json =JSONObject.fromObject(respJson);
			if (StringUtils.equals("000000", json.getString("code"))) {
				return 200;
			}
		} catch (Exception e) {
			logger.error("【彩票】shared订单异常");
			e.printStackTrace();
		}
		return 400;
	}
}
