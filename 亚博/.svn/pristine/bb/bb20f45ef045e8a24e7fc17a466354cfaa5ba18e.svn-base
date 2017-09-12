package com.mh.web.login;

import org.apache.commons.lang3.StringUtils;

import com.mh.commons.constants.WebSiteManagerConstants;

/**
 * ClassName: LoginHelperHandler
 * 
 * @Description: 不拦截请求 及ip限制或签名认证等等一系列访问条件判断处理
 * @author Andy
 * @date 2015-7-14
 */
public class LoginHelperHandler {

	/**
	 * @Description: TODO
	 * @param
	 * @return boolean
	 * @author Andy
	 * @date 2015-7-19
	 */
	public static boolean uriFilter(String uri, String ip) {
		boolean flag = false;
		if ("/file/webUpload/".equals(uri)) {

			return validIp(ip);
		} else if ("/initWeb/webData/".equals(uri)) {

			return validIp(ip);
		} else if ("/payReturn/payReturnHandler".equals(uri)) {
			return validIp(ip);
		}
		return flag;
	}

	private static boolean validIp(String ip) {
		boolean flag = false;
		String ipStr = WebSiteManagerConstants.SYSPARAMMAP.get("web_login_auth_ip").toString();
		if (StringUtils.isNotBlank(ipStr)) {
			String[] ips = ipStr.split(",");
			for (String str : ips) {
				if (ip.contains(str)) {
					flag = true;
					break;
				}
			}
		}
		return flag;
	}
}
