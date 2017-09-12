package com.mh.commons.utils;



import javax.servlet.http.HttpServletRequest;



public class IPSeeker {

    /**
     * 据request查询IP并查询地址
     * 
     * @param request
     * @return String IP
     */
    public static String getIpAddress(HttpServletRequest request) {
    	String ip = request.getHeader("x-forwarded-for");
		if (ip == null || ip.length() == 0 || "unknown".equalsIgnoreCase(ip)) {
			ip = request.getHeader("Proxy-Client-IP");
		}
		if (ip == null || ip.length() == 0 || "unknown".equalsIgnoreCase(ip)) {
			ip = request.getHeader("WL-Proxy-Client-IP");
		}
		if (ip == null || ip.length() == 0 || "unknown".equalsIgnoreCase(ip)) {
			ip = request.getRemoteAddr();
		}
		if (ip.indexOf(",") != -1) {
        	String[] ips = ip.split(",");
        	ip = ips[0];
        }
        return ip;
    }
    
    /**
     * 据request查询IP并查询地址
     * 
     * @param request
     * @return String IP
     */
    public static String getIpAddress2(HttpServletRequest request) {
    	String ip = request.getHeader("x-forwarded-for");
		if (ip == null || ip.length() == 0 || "unknown".equalsIgnoreCase(ip)) {
			ip = request.getHeader("Proxy-Client-IP");
		}
		if (ip == null || ip.length() == 0 || "unknown".equalsIgnoreCase(ip)) {
			ip = request.getHeader("WL-Proxy-Client-IP");
		}
		if (ip == null || ip.length() == 0 || "unknown".equalsIgnoreCase(ip)) {
			ip = request.getRemoteAddr();
		}
		if (ip.indexOf(",") != -1) {
        	String[] ips = ip.split(",");
        	ip = ips[0];
        }
        return ip;
    }
}
