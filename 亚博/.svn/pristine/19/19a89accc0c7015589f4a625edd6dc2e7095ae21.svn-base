package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebPromosType entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_promos_type")
public class WebPromosType implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private String pmsTypeName;
	private Integer pmsTypeIndex;
	private String pmsTypeTitle;
	private Integer status;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String sysUserName;

	// Constructors

	/** default constructor */
	public WebPromosType() {
	}

	/** full constructor */
	public WebPromosType(String pmsTypeName, Integer pmsTypeIndex,
			String pmsTypeTitle, Integer status, Timestamp createTime,
			Timestamp modifyTime, String sysUserName) {
		this.pmsTypeName = pmsTypeName;
		this.pmsTypeIndex = pmsTypeIndex;
		this.pmsTypeTitle = pmsTypeTitle;
		this.status = status;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.sysUserName = sysUserName;
	}

	// Property accessors
	@Id
	@GeneratedValue
	@Column(name = "id", unique = true, nullable = false)
	public Integer getId() {
		return this.id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	@Column(name = "pms_type_name", length = 50)
	public String getPmsTypeName() {
		return this.pmsTypeName;
	}

	public void setPmsTypeName(String pmsTypeName) {
		this.pmsTypeName = pmsTypeName;
	}

	@Column(name = "pms_type_index")
	public Integer getPmsTypeIndex() {
		return this.pmsTypeIndex;
	}

	public void setPmsTypeIndex(Integer pmsTypeIndex) {
		this.pmsTypeIndex = pmsTypeIndex;
	}

	@Column(name = "pms_type_title")
	public String getPmsTypeTitle() {
		return this.pmsTypeTitle;
	}

	public void setPmsTypeTitle(String pmsTypeTitle) {
		this.pmsTypeTitle = pmsTypeTitle;
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