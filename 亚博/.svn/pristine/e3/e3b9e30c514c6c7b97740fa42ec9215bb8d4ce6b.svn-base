package com.mh.web.token;

import java.io.Serializable;
import java.util.Date;

import org.apache.commons.lang3.builder.ToStringBuilder;

/**
 * 代表表单token类
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-28 下午5:23:50<br/>
 */
public class FormToken implements Serializable {
	/** 
	 * serialVersionUID 
	 */
	private static final long serialVersionUID = 8796758608626021150L;
	
	public static final String FORM_TOKEN_UNIQ_ID = "_form_token_uniq_id";
	
	/** 表单标识*/
	private String token;
	/** 表单创建时间*/
	private Date createTime;

	/** 
	 * 构造函数 
	 */
	public FormToken(String token) {
		this.token = token;
		this.createTime = new Date();
	}

	public String toString() {
		return ToStringBuilder.reflectionToString(this);
	}

	public String getToken() {
		return token;
	}

	public Date getCreateTime() {
		return createTime;
	}
}
