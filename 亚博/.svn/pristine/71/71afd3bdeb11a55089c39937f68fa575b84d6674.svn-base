package com.mh.entity;

// default package

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebWeiHu entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_weihu")
public class WebWeiHu implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String weihuName;
	private String weihuType;
	private String weihuContent;
	private Integer status;

	// Constructors

	/** default constructor */
	public WebWeiHu() {
	}

	/** full constructor */
	public WebWeiHu(String weihuType, String weihuContent, Integer status) {
		this.weihuType = weihuType;
		this.weihuContent = weihuContent;
		this.status = status;
	}

	// Property accessors
	@Id
	@GeneratedValue
	@Column(name = "weihu_name", unique = true, nullable = false, length = 50)
	public String getWeihuName() {
		return this.weihuName;
	}

	public void setWeihuName(String weihuName) {
		this.weihuName = weihuName;
	}

	@Column(name = "weihu_type", length = 50)
	public String getWeihuType() {
		return this.weihuType;
	}

	public void setWeihuType(String weihuType) {
		this.weihuType = weihuType;
	}

	@Column(name = "weihu_content", length = 65535)
	public String getWeihuContent() {
		return this.weihuContent;
	}

	public void setWeihuContent(String weihuContent) {
		this.weihuContent = weihuContent;
	}

	@Column(name = "status")
	public Integer getStatus() {
		return this.status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

}