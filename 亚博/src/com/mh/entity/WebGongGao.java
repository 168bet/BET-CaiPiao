package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

/**
 * WebGongGao entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_gonggao")
public class WebGongGao implements java.io.Serializable {

	// Fields

 
	private static final long serialVersionUID = 1L;
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;
	
	@Column(name = "gg_content")
	private String ggContent;
	
	@Column(name = "gg_status")
	private Integer ggStatus;
	
	@Column(name = "gg_name")
	private String ggName;
	
	@Column(name = "manager_user_name")
	private String managerUserName;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Timestamp createTime;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Timestamp modifyTime;

	// Constructors

	/** default constructor */
	public WebGongGao() {
	}

	/** full constructor */
	public WebGongGao(String ggContent, Integer ggStatus, String ggName,
			String managerUserName, Timestamp createTime, Timestamp modifyTime) {
		this.ggContent = ggContent;
		this.ggStatus = ggStatus;
		this.ggName = ggName;
		this.managerUserName = managerUserName;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
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

	@Column(name = "gg_content", length = 65535)
	public String getGgContent() {
		return this.ggContent;
	}

	public void setGgContent(String ggContent) {
		this.ggContent = ggContent;
	}

	@Column(name = "gg_status")
	public Integer getGgStatus() {
		return this.ggStatus;
	}

	public void setGgStatus(Integer ggStatus) {
		this.ggStatus = ggStatus;
	}

	@Column(name = "gg_name", length = 50)
	public String getGgName() {
		return this.ggName;
	}

	public void setGgName(String ggName) {
		this.ggName = ggName;
	}

	@Column(name = "manager_user_name", length = 50)
	public String getManagerUserName() {
		return this.managerUserName;
	}

	public void setManagerUserName(String managerUserName) {
		this.managerUserName = managerUserName;
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

}