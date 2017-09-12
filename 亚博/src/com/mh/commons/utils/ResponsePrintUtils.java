package com.mh.commons.utils;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.alibaba.fastjson.JSON;
import com.mh.commons.conf.CommonConstant;

/**
 * Http与Servlet工具类.
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-28 下午6:56:52<br/>
 */
public class ResponsePrintUtils {
	private static Logger logger = LoggerFactory.getLogger(ResponsePrintUtils.class);

	//-- Content Type 定义 --//
	public static final String TEXT_TYPE = "text/plain";
	public static final String JSON_TYPE = "application/json";
	public static final String XML_TYPE = "text/xml";
	public static final String HTML_TYPE = "text/html";
	public static final String JS_TYPE = "text/javascript";
	public static final String EXCEL_TYPE = "application/vnd.ms-excel";

	//-- Header 定义 --//
	public static final String AUTHENTICATION_HEADER = "Authorization";

	//-- 常用数值定义 --//
	public static final long ONE_YEAR_SECONDS = 60 * 60 * 24 * 365;
	
	/**
	 * 设置客户端缓存过期时间 的Header.
	 */
	public static void setExpiresHeader(HttpServletResponse response, long expiresSeconds) {
		//Http 1.0 header
		response.setDateHeader("Expires", System.currentTimeMillis() + expiresSeconds * 1000);
		//Http 1.1 header
		response.setHeader("Cache-Control", "private, max-age=" + expiresSeconds);
	}

	/**
	 * 将处理成功结果(默认提示信息）返回给客服端ajax脚本
	 * @param response
	 */
	public static void outPrintSuccess(HttpServletRequest request, HttpServletResponse response) {
		outPrintSuccess(request, response, CommonConstant.DEFAULT_SUCCESS_MSG, null);
	}
	
	/**
	 * 将处理成功结果(用户设置提示信息）返回给客服端ajax脚本
	 * @param response
	 * @param msg
	 */
	public static void outPrintSuccess(HttpServletRequest request, HttpServletResponse response, String msg) {
		outPrintSuccess(request, response, msg, null);
	}
	
	/**
	 * 将处理成功结果(用户返回的数据）返回给客服端ajax脚本
	 * @param response
	 * @param map 用户返回的数据
	 */
	public static void outPrintSuccess(HttpServletRequest request, HttpServletResponse response, Object obj) {
		outPrintSuccess(request, response, "", obj);
	}
	
	
	/**
	 * 将处理失败结果（用户设置失败提示信息,用户返回失败相关数据） 返回给客服端ajax脚本
	 * @param response
	 * @param msg  用户设置失败提示信息
	 * @param map  用户返回失败相关数据
	 */
	public static void outPrintLogoutFail(HttpServletRequest request, HttpServletResponse response, String msg) {
		StringBuilder strb = new StringBuilder("{\"code\":");
		strb.append(403.1)
		.append(",\"msg\":\"").append(null == msg ? "" : msg)
		.append("\"")
		.append("}");
		flushResult(request, response,strb.toString());
	}
	
	/**
	 * 将处理成功结果(用户设置提示信息,用户返回的数据）返回给客服端ajax脚本
	 * @param response
	 * @param msg  用户设置提示信息
	 * @param map  用户返回的数据
	 */
	public static void outPrintSuccess(HttpServletRequest request, HttpServletResponse response, String msg, Object obj) {
		flushResult(request, response, buildRs(true, msg, obj));
	}
	
	/**
	 * 将处理失败结果（用户设置失败提示信息） 返回给客服端ajax脚本
	 * @param response
	 * @param msg  用户设置失败提示信息
	 */
	public static void outPrintFail(HttpServletRequest request, HttpServletResponse response, String msg) {
		outPrintFail(request, response, msg, null);
	}
	
	/**
	 * 将处理失败结果（用户返回失败相关数据） 返回给客服端ajax脚本
	 * @param response
	 * @param map  用户返回失败相关数据
	 */
	public static void outPrintFail(HttpServletRequest request, HttpServletResponse response, Object obj) {
		outPrintFail(request, response, "", obj);
	}
	
	/**
	 * 将处理失败结果（用户设置失败提示信息,用户返回失败相关数据） 返回给客服端ajax脚本
	 * @param response
	 * @param msg  用户设置失败提示信息
	 * @param map  用户返回失败相关数据
	 */
	public static void outPrintFail(HttpServletRequest request, HttpServletResponse response, String msg, Object obj) {
		flushResult(request, response, buildRs(false, msg, obj));
	}
	
	/**
	 * 将用户数据 msg 不进行封装，直接传递给客服端ajax
	 * @param response
	 * @param msg
	 */
	public static void outPrintMsg(HttpServletRequest request, HttpServletResponse response, String msg) {
		flushResult(request, response, msg);
	}
	
	/**
	 * 返回json格式数据
	 * @param response
	 * @param str
	 */
	public static void responseJsonData(HttpServletResponse response, String str){
		setDisableCacheHeader(response);
		response.setHeader("Content-type", JSON_TYPE);  
		response.setCharacterEncoding("utf-8");
		PrintWriter out = null;
		try {
			out = response.getWriter();
			out.print(str);
		} catch (IOException e) {
			e.printStackTrace();
		}finally{
			if(null != out){
				out.flush();
				out.close();
			}
		}
	}
	
	
	
 
	
	/**
	 * 返回信息最后JSON格式
	 * @param success  处理结果是否成功
	 * @param msg  提示信息
	 * @param map  用户数据
	 * @return
	 */
	private static String buildRs(boolean success, String msg, Object obj){
		StringBuilder strb = new StringBuilder("{\"state\":");
		strb.append(success ? 1 : 0)
			.append(",\"msg\":\"").append(null == msg ? "" : msg)
			.append("\",\"data\":").append(null == obj ? "{}" : JSON.toJSONString(obj))
			.append("}");
		
		logger.debug("rs：[ {} ]", strb);
 
		return strb.toString();
	}
	
	/**
	 * 将用户数据返回给相应的客服端请求ajax页面
	 * @param response
	 * @param str
	 */
	private static void flushResult(HttpServletRequest request, HttpServletResponse response, String str){
		setDisableCacheHeader(response);
		response.setHeader("Content-type", JSON_TYPE);  
		response.setCharacterEncoding("UTF-8");
		PrintWriter out = null;
		try {
			out = response.getWriter();
			logger.debug("用户数据返回: [ {} ]",  str);
			
			out.print(str);
			out.flush();
		} catch (IOException e) {
			e.printStackTrace();
		}finally{
			if(null != out){
				out.close();
			}
		}
	}
	
	/**
	 * 设置禁止客户端缓存的Header.
	 */
	public static void setDisableCacheHeader(HttpServletResponse response) {
		//Http 1.0 header
		response.setDateHeader("Expires", 1L);
		response.addHeader("Pragma", "no-cache");
		//Http 1.1 header
		response.setHeader("Cache-Control", "no-cache, no-store, max-age=0");
	}

}
