package com.mh.exceptions;

public class DuplicateFormSubmitException extends RuntimeException {
	private static final long serialVersionUID = 1L;
	
	/**
	 * 重复提交
	 * @param message the message
	 * @param cause the cause
	 */
	public DuplicateFormSubmitException(String message, Exception cause) {
		super(message, cause);
	}

	/**
	 * 重复提交
	 * @param message the message
	 */
	public DuplicateFormSubmitException(String message) {
		super(message);
	}

}
