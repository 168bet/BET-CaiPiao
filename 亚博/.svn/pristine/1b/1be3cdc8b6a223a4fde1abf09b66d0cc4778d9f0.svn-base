/**   
* 文件名称: UserContext.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午1:37:20<br/>
*/  
package com.mh.web.login;

import java.io.Serializable;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

/** 
 * 类描述: TODO<br/>系统登入用户上下文保存器
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-5 下午1:37:20<br/>
 */
public class UserContext implements Serializable {

 
	private static final long serialVersionUID = 1L;
	
	private Integer userId;
	private String userName;
	private Date lastLogonTime;
	private String ip;
	private Integer userType;
	private String sessionId;
	
	private Integer userMemberType;
	
	private Double userMoney;
	
	private boolean isAdmin;
	
	private String relativePath;
	
	private String userAgent;
	
	private Integer isTest;
	
 
	
	//jar外部用户绑定数据
	private Map<String, Object> customDatas = new HashMap<String, Object>();

	public Integer getUserId() {
		return userId;
	}

	public void setUserId(Integer userId) {
		this.userId = userId;
	}

 

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public Date getLastLogonTime() {
		return lastLogonTime;
	}

	public void setLastLogonTime(Date lastLogonTime) {
		this.lastLogonTime = lastLogonTime;
	}

 
	public Map<String, Object> getCustomDatas() {
		return customDatas;
	}

	public void setCustomDatas(Map<String, Object> customDatas) {
		this.customDatas = customDatas;
	}

	public Integer getUserType() {
		return userType;
	}

	public void setUserType(Integer userType) {
		this.userType = userType;
	}

	public String getSessionId() {
		return sessionId;
	}

	public void setSessionId(String sessionId) {
		this.sessionId = sessionId;
	}

	public String getIp() {
		return ip;
	}

	public void setIp(String ip) {
		this.ip = ip;
	}

	public Integer getUserMemberType() {
		return userMemberType;
	}

	public void setUserMemberType(Integer userMemberType) {
		this.userMemberType = userMemberType;
	}

	public Double getUserMoney() {
		return userMoney;
	}

	public void setUserMoney(Double userMoney) {
		this.userMoney = userMoney;
	}

	public boolean isAdmin() {
		return isAdmin;
	}

	public void setAdmin(boolean isAdmin) {
		this.isAdmin = isAdmin;
	}

	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
	}

	public String getUserAgent() {
		return userAgent;
	}

	public void setUserAgent(String userAgent) {
		this.userAgent = userAgent;
	}

	public Integer getIsTest() {
		return isTest;
	}

	public void setIsTest(Integer isTest) {
		this.isTest = isTest;
	}
	
	
	
	
}
