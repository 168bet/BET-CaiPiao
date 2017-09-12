/**   
* 文件名称: SportBetMatchNoViableException.java<br/>
* 版本号: V1.0<br/>   
* 创建人: zoro<br/>  
* 创建时间 : 2015-9-13 上午5:22:14<br/>
*/  
package com.mh.exceptions;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-9-13 上午5:22:14<br/>
 */
public class SportBetMatchNoViableException extends Exception {

	/** 
	 * @Fields serialVersionUID: TODO 
	 */ 
	private static final long serialVersionUID = 1L;
	
	
	/**
	 * 用户未登入系统
	 */
	public SportBetMatchNoViableException(String message, Exception cause) {
		super(message, cause);
	}

	/**
	 * 用户未登入系统
	 */
	public SportBetMatchNoViableException(String message) {
		super(message);
	}

}
