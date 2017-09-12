package com.mh.exceptions;

public class ForbidVisitException extends RuntimeException {
	private static final long serialVersionUID = 1L;
	
	/**
	 * 禁止访问
	 */
	public ForbidVisitException(String message, Exception cause) {
		super(message, cause);
	}

	/**
	 * 禁止访问
	 */
	public ForbidVisitException(String message) {
		super(message);
	}
}
