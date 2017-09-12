/**   
* 文件名称: CheckDeviceUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: zoro<br/>  
* 创建时间 : 2016-2-27 下午10:19:26<br/>
*/  
package com.mh.web.util;

import java.io.IOException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2016-2-27 下午10:19:26<br/>
 */
public class CheckDeviceUtil {
	protected Logger logger = LoggerFactory.getLogger(getClass());
	 // \b 是单词边界(连着的两个(字母字符 与 非字母字符) 之间的逻辑上的间隔),    
    // 字符串在编译时会被转码一次,所以是 "\\b"    
    // \B 是单词内部逻辑间隔(连着的两个字母字符之间的逻辑上的间隔)    
    static String phoneReg = "\\b(ip(hone|od)|android|opera m(ob|in)i"    
            +"|windows (phone|ce)|blackberry"    
            +"|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp"    
            +"|laystation portable)|nokia|fennec|htc[-_]"    
            +"|mobile|up.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\\b";    
    static String tableReg = "\\b(ipad|tablet|(Nexus 7)|up.browser"    
            +"|[1-4][0-9]{2}x[1-4][0-9]{2})\\b";    
      
    //移动设备正则匹配：手机端、平板  
    static Pattern phonePat = Pattern.compile(phoneReg, Pattern.CASE_INSENSITIVE);    
    static Pattern tablePat = Pattern.compile(tableReg, Pattern.CASE_INSENSITIVE);    
        
    /** 
     * 检测是否是移动设备访问 
     *  
     * @Title: check 
     * @Date : 2014-7-7 下午01:29:07 
     * @param userAgent 浏览器标识 
     * @return true:移动设备接入，false:pc端接入 
     */  
    public static boolean check(String userAgent){    
        if(null == userAgent){    
            userAgent = "";    
        }    
        // 匹配    
        Matcher matcherPhone = phonePat.matcher(userAgent);    
        Matcher matcherTable = tablePat.matcher(userAgent);    
        if(matcherPhone.find() || matcherTable.find()){    
            return true;    
        } else {    
            return false;    
        }    
    }
    
    
    /** 
     * 检查访问方式是否为移动端 
     *  
     * @Title: check 
     * @Date : 2014-7-7 下午03:55:19 
     * @param request 
     * @throws IOException  
     */  
    public boolean check(HttpServletRequest request,HttpServletResponse response) throws IOException{  
        boolean isFromMobile=false;  
          
        HttpSession session= request.getSession();  
       //检查是否已经记录访问方式（移动端或pc端）  
        if(null==session.getAttribute("ua")){  
            try{  
                //获取ua，用来判断是否为移动端访问  
                String userAgent = request.getHeader( "USER-AGENT" ).toLowerCase();    
                if(null == userAgent){    
                    userAgent = "";    
                }  
                isFromMobile=CheckDeviceUtil.check(userAgent);  
                //判断是否为移动端访问  
                if(isFromMobile){  
                	logger.info("移动端访问"); 
                    session.setAttribute("ua","mobile");  
                } else {  
                	logger.info("pc端访问");
                    session.setAttribute("ua","pc");  
                }  
            }catch(Exception e){}  
        }else{  
            isFromMobile=session.getAttribute("ua").equals("mobile");  
        }  
          
        return isFromMobile;  
    }
    
    private static boolean isMatcher(String agent, String strReg){
    	 if(null == agent){    
    		 agent = "";    
         }    
         // 匹配   
    	 Pattern phonePat = Pattern.compile(strReg, Pattern.CASE_INSENSITIVE); 
         Matcher matcherPhone = phonePat.matcher(agent);    
         if(matcherPhone.find()){    
             return true;    
         } else {    
             return false;    
         }   
    }
    
    public static String checkDevice(HttpServletRequest request){
    	String device = "";
    	String userAgent = request.getHeader( "User-Agent" ).toLowerCase();    
         if(null == userAgent){    
             userAgent = "";    
         }
         try{
        	 if(isMatcher(userAgent, "\\b(ip(hone|od))\\b")){
        		 device = "iphone";
        	 }else if(isMatcher(userAgent, "\\b(android)\\b")){
        		 device = "android";
        	 }else if(isMatcher(userAgent, "\\b(windows (phone|ce))\\b")){
        		 device = "winPhone";
        	 }else if(userAgent.indexOf("nokia")>-1){
        		 device = "nokia";
        	 }else if(userAgent.indexOf("symbian")>-1){
        		 device = "symbian";
        	 }else if(isMatcher(userAgent, "\\b(ipad)\\b")){
        		 device = "ipad";
        	 }else if(isMatcher(userAgent, "\\b(htc[-_])\\b")){
        		 device = "htc";
        	 }else if(isMatcher(userAgent, "\\b(blackberry)\\b")){
        		 device = "blackberry";
        	 }else if(userAgent.indexOf("huawei")>-1){
        		 device = "huawei";
        	 }else if(userAgent.indexOf("sony")>-1){
        		 device = "sony";
        	 }else if(userAgent.indexOf("meizu")>-1){
        		 device = "meizu";
        	 }else if(userAgent.indexOf("coolpad")>-1){
        		 device = "coolpad";
        	 }else if(isMatcher(userAgent, "\\b(samsung)\\b")){
        		 device = "Samsung";
        	 }else if(check(userAgent)){
        		 device = "mobile";
        	 }else{
        		 device = "pc";
        	 }
         }catch (Exception e) {
			e.printStackTrace();
		}
         return device;
    }
    
    
}
