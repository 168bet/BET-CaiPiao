package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebSwitch entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_switch")
public class WebSwitch implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String swtName;
	private String swtTitle;
	private Integer status;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String remark;
	private String sysUserName;
	private String needed;

	// Constructors

	/** default constructor */
	public WebSwitch() {
	}

	/** full constructor */
	public WebSwitch(String swtTitle, Integer status, Timestamp createTime,
			Timestamp modifyTime, String remark, String sysUserName) {
		this.swtTitle = swtTitle;
		this.status = status;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.remark = remark;
		this.sysUserName = sysUserName;
	}

	// Property accessors
	@Id
	@GeneratedValue
	@Column(name = "swt_name", unique = true, nullable = false, length = 50)
	public String getSwtName() {
		return this.swtName;
	}

	public void setSwtName(String swtName) {
		this.swtName = swtName;
	}

	@Column(name = "swt_title", length = 50)
	public String getSwtTitle() {
		return this.swtTitle;
	}

	public void setSwtTitle(String swtTitle) {
		this.swtTitle = swtTitle;
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

	@Column(name = "remark")
	public String getRemark() {
		return this.remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	@Column(name = "sys_user_name", length = 50)
	public String getSysUserName() {
		return this.sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}

	@Column(name = "needed", length = 11)
	public String getNeeded() {
		return needed;
	}

	public void setNeeded(String needed) {
		this.needed = needed;
	}
	
	
	

}