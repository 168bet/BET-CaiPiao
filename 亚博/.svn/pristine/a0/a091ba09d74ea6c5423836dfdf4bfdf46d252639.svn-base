/**   
* 文件名称: MgTokenContext.java<br/>
* 版本号: V1.0<br/>   
* 创建人: zoro<br/>  
* 创建时间 : 2015-11-24 下午7:53:11<br/>
*/  
package com.mh.web.servlet;

import java.util.Collection;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

import javax.servlet.http.HttpSession;

import org.apache.commons.lang.StringUtils;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-11-24 下午7:53:11<br/>
 */
public class MyTokenSessionContext {
	private static Map<String, String> myTokenMap = new ConcurrentHashMap<String, String>();
	private static Map<String, HttpSession> mySessionMap = new ConcurrentHashMap<String, HttpSession>();
	
	public static Map<String, String> sessionUser = new HashMap<String, String>();
	
	public static void addMyClientToken(String token, String userName) {
	    if (token != null) {
	    	myTokenMap.put(token, userName);
	    }
	}
	
	public static void delMyClientToken(String token) {
	    if (StringUtils.isNotBlank(token)) {
	    	myTokenMap.remove(token);
	    }
	}
	
	public static String getMyClientToken(String token) {
	    if (token == null) 
	    	return null;
	    return myTokenMap.get(token);
	}
	
	public static boolean hasUserClientTokenValue(String userName){
		 if (userName == null) 
		    	return false;
		    return myTokenMap.containsKey(userName);
	}
	
	public static boolean hasUserClientTokenKey(String token){
		 if (token == null) 
		    	return false;
		    return myTokenMap.containsValue(token);
	}
	
	public static Collection<String> getAllMyClientUsers(){
		return myTokenMap.values();
	}
	
	public static Collection<String> getAllMyClientTokens(){
		return myTokenMap.keySet();
	}
	
	
	public static void addMySession(String userName, HttpSession session ) {
	    if (userName != null) {
	    	mySessionMap.put(userName, session);
	    }
	}
	
	public static void delMySession(String userName) {
	    if (StringUtils.isNotBlank(userName)) {
	    	mySessionMap.remove(userName);
	    }
	}
	
	public static HttpSession getMySession(String userName) {
	    if (userName == null) 
	    	return null;
	    return mySessionMap.get(userName);
	}
	
	public static boolean hashUserSession(String userName){
		 if (userName == null) 
		    	return false;
		    return mySessionMap.containsKey(userName);
	}
	
	public static Collection<HttpSession> getAllMySession(){
		return mySessionMap.values();
	}
}
