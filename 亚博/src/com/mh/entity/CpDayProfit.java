/**   
* 文件名称: CpDayProfit.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-1 上午11:22:47<br/>
*/  
package com.mh.entity;


/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-1 上午11:22:47<br/>
 */

public class CpDayProfit implements java.io.Serializable {
	
	private static final long serialVersionUID = 1L;

	private String userName;
	
	private String beginTimeStr;
	
	private String endTimeStr;

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getBeginTimeStr() {
		return beginTimeStr;
	}

	public void setBeginTimeStr(String beginTimeStr) {
		this.beginTimeStr = beginTimeStr;
	}

	public String getEndTimeStr() {
		return endTimeStr;
	}

	public void setEndTimeStr(String endTimeStr) {
		this.endTimeStr = endTimeStr;
	}
}
