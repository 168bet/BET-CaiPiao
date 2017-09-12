package com.mh.exceptions;

public class NotLoginException extends RuntimeException {

	private static final long serialVersionUID = 23231L;
	
	/**
	 * 用户未登入系统
	 */
	public NotLoginException(String message, Exception cause) {
		super(message, cause);
	}

	/**
	 * 用户未登入系统
	 */
	public NotLoginException(String message) {
		super(message);
	}
}
