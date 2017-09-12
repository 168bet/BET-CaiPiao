package com.mh.entity;

// default package

import java.sql.Timestamp;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebResource entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_resource")
public class WebResource implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String rsName;
	private String rsTitle;
	private String rsUrl;
	private Integer status;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String sysUserName;

	// Constructors

	/** default constructor */
	public WebResource() {
	}

	/** full constructor */
	public WebResource(String rsTitle, String rsUrl, Integer status,
			Timestamp createTime, Timestamp modifyTime, String sysUserName) {
		this.rsTitle = rsTitle;
		this.rsUrl = rsUrl;
		this.status = status;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.sysUserName = sysUserName;
	}

	// Property accessors
	@Id
	@GeneratedValue
	@Column(name = "rs_name", unique = true, nullable = false, length = 50)
	public String getRsName() {
		return this.rsName;
	}

	public void setRsName(String rsName) {
		this.rsName = rsName;
	}

	@Column(name = "rs_title", length = 50)
	public String getRsTitle() {
		return this.rsTitle;
	}

	public void setRsTitle(String rsTitle) {
		this.rsTitle = rsTitle;
	}

	@Column(name = "rs_url")
	public String getRsUrl() {
		return this.rsUrl;
	}

	public void setRsUrl(String rsUrl) {
		this.rsUrl = rsUrl;
	}

	@Column(name = "status")
	public Integer getStatus() {
		return this.status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	@Column(name = "create_time", length = 19)
	public Timestamp getCreateTime() {
		return this.createTime;
	}

	public void setCreateTime(Timestamp createTime) {
		this.createTime = createTime;
	}

	@Column(name = "modify_time", length = 19)
	public Timestamp getModifyTime() {
		return this.modifyTime;
	}

	public void setModifyTime(Timestamp modifyTime) {
		this.modifyTime = modifyTime;
	}

	@Column(name = "sys_user_name", length = 50)
	public String getSysUserName() {
		return this.sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}

}