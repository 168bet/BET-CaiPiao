package com.mh.commons.cache;

import java.io.Serializable;

public class MemCacheVoice implements Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = 719834967507285045L;
	private String type;
	private String value;

	public String getType() {
		return type;
	}

	public void setType(String type) {
		this.type = type;
	}

	public String getValue() {
		return value;
	}

	public void setValue(String value) {
		this.value = value;
	}

}
