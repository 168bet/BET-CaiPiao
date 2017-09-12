package com.mh.commons.utils;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Set;

import org.apache.commons.httpclient.DefaultHttpMethodRetryHandler;
import org.apache.commons.httpclient.HttpClient;
import org.apache.commons.httpclient.HttpStatus;
import org.apache.commons.httpclient.MultiThreadedHttpConnectionManager;
import org.apache.commons.httpclient.NameValuePair;
import org.apache.commons.httpclient.methods.GetMethod;
import org.apache.commons.httpclient.methods.PostMethod;
import org.apache.commons.httpclient.params.HttpMethodParams;
import org.apache.commons.lang.StringUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import com.mh.commons.conf.CommonConstant;



@SuppressWarnings("all")
public class HttpClientUtil {

	private static final Log logger = LogFactory.getLog(HttpClientUtil.class);
	
	
	private static MultiThreadedHttpConnectionManager connectionManager = new MultiThreadedHttpConnectionManager();
	private static final int MAX_IDLE_TIME_OUT = 60000;
	private static final int MAX_CONNECTION_TIME_OUT = 50000;
	private static final int MAX_SOCKET_TIME_OUT = 60000;
	
	/**
	 * 
	 * @param url
	 * @return 如果异常则返回null
	 */
	public static String get(String url) {
		String string = null;
		logger.info("请求的URL："+url);
		HttpClient client = new HttpClient(connectionManager);
		
		client.getHttpConnectionManager().getParams().setConnectionTimeout(MAX_CONNECTION_TIME_OUT);
		client.getHttpConnectionManager().getParams().setSoTimeout(MAX_SOCKET_TIME_OUT);
		
		GetMethod method = getGetMethod(url);
		method.getParams().setParameter(HttpMethodParams.HTTP_CONTENT_CHARSET, "utf-8");
		method.getParams().setParameter("http.method.retry-handler", new DefaultHttpMethodRetryHandler());
		StringBuffer sbuff = new StringBuffer("");
		InputStream in = null;
		try {
			int status = client.executeMethod(method);
			if (HttpStatus.SC_OK == status){
				in = method.getResponseBodyAsStream();
				BufferedReader reader = new BufferedReader(new InputStreamReader(in,"UTF-8"));
				String inputLine = null;
				while ((inputLine = reader.readLine()) != null) {
					sbuff.append(inputLine);
				}
				string = sbuff.toString();
				logger.info("返回报文："+string);
			}
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			if (method != null) {
				method.releaseConnection();
			}
			if(in!=null){
				try {
					in.close();
				} catch (IOException e) {

				}
			}
			connectionManager.closeIdleConnections(MAX_IDLE_TIME_OUT);  //释放连接，为了避免产生大量CLOSE_WAIT：
		}
		return string;
	}
	
	
	
	/**
	 * POST请求
	 * @param url
	 * @param params
	 * @return
	 */
	public static String post(String url, Map<String, String> params) {
		HttpClient client = new HttpClient(connectionManager);
		
		
		client.getHttpConnectionManager().getParams().setConnectionTimeout(MAX_CONNECTION_TIME_OUT);
		client.getHttpConnectionManager().getParams().setSoTimeout(MAX_SOCKET_TIME_OUT);

		StringBuffer sbuff = new StringBuffer("");
		InputStream in = null;
		PostMethod postMethod = null;
		try{
//			logger.info("请求的url："+url);
			postMethod = getPostMethod(url);
			postMethod.getParams().setParameter(HttpMethodParams.HTTP_CONTENT_CHARSET,"utf-8");
			postMethod.getParams().setParameter("http.method.retry-handler", new DefaultHttpMethodRetryHandler());
			Set entrySet = params.entrySet();
			int dataLength = entrySet.size();
			NameValuePair[] pairArr = new NameValuePair[dataLength];
			int i = 0;
			for (Iterator itor = entrySet.iterator(); itor.hasNext();) {
				Map.Entry entry = (Map.Entry) itor.next();
				String key = entry.getKey().toString();
				String value = (String)entry.getValue();
				pairArr[i++] = new NameValuePair(key, value);
			} 
	
			postMethod.setRequestBody(pairArr);
			int statusCode = client.executeMethod(postMethod);
			logger.info("返回码："+statusCode);
			if(statusCode == HttpStatus.SC_OK){
				in = postMethod.getResponseBodyAsStream();
				BufferedReader reader = new BufferedReader(new InputStreamReader(in, "UTF-8"));
				String inputLine = null;
				while ((inputLine = reader.readLine()) != null) {
					sbuff.append(inputLine);
				}
				in.close();
			}
		}catch(Exception e){
			e.printStackTrace();
		}finally{
			if(postMethod!=null){
				postMethod.releaseConnection();  
			}
			if(in!=null){
				try {
					in.close();
				} catch (IOException e) {

				}
			}
			connectionManager.closeIdleConnections(MAX_IDLE_TIME_OUT);  //释放连接，为了避免产生大量CLOSE_WAIT：
		}
		return sbuff.toString();
	}
	
	
	private static PostMethod getPostMethod(String url) {
		PostMethod method = new PostMethod(url);
		method.setRequestHeader("Content-Type", "*; charset=UTF-8");
		method.addRequestHeader("uid", CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_UID));
		method.addRequestHeader("udd",  CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_UDD));
		method.addRequestHeader("des", CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_DES));
		/*
		 * method.addRequestHeader("uid", uid); method.addRequestHeader("udd",
		 * udd); method.addRequestHeader("des", des);
		 */
		return method;
	}

	private static GetMethod getGetMethod(String url) {
		GetMethod method = new GetMethod(url);
		method.setRequestHeader("Content-Type", "*; charset=UTF-8");
		method.addRequestHeader("uid", CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_UID));
		method.addRequestHeader("udd",  CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_UDD));
		method.addRequestHeader("des", CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_DES));
		return method;
	}
	
	
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
	
	public static void main(String[] args) throws Exception {
		Map<String, String> params = new HashMap<String,String>();
		params.put("code", "BJKL8");
 
		params.put("bTime", "2016-12-11");
		params.put("eTime", "2016-12-13");
		params.put("pageNo", "1");// 第几页
		params.put("pageSize", "20");// 每页显示多少条
		
		
		String str = HttpClientUtil.post("http://192.168.0.239:8881/interface/cp/agent/api/getHistoryResult", params);
		System.out.println(str);
	}
	
	
	/**
	 * 获取彩票结果
	 * @param params
	 * @return
	 * @throws Exception
	 */
	public static String  getAllNewResult(Map<String, String> params){
		String url = CommonConstant.resCommMap.get(CommonConstant.INTERFACE_AUT_URL);
		String respJson = HttpClientUtil.post(url + "/cp/agent/api/getAllNewResult", params);
		if(StringUtils.isEmpty(params.get("code"))){
			logger.info("历史开奖记录：返回的报文"+respJson);
		}else{
			logger.info(params.get("code")+"历史开奖:返回报文:"+respJson);
		}
		return respJson;
	}
 
}