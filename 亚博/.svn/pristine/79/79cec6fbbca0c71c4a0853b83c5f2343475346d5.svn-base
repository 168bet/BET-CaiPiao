package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebPanel entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_panel")
public class WebPanel implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private String panelSn;
	private String panelName;
	private String panelContent;
	private Integer status;
	private Integer auth;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String remark;
	private String sysUserName;

	// Constructors

	/** default constructor */
	public WebPanel() {
	}

	/** full constructor */
	public WebPanel(String panelSn, String panelName, String panelContent,
			Integer status, Integer auth, Timestamp createTime,
			Timestamp modifyTime, String remark, String sysUserName) {
		this.panelSn = panelSn;
		this.panelName = panelName;
		this.panelContent = panelContent;
		this.status = status;
		this.auth = auth;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.remark = remark;
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

	@Column(name = "panel_sn", length = 10)
	public String getPanelSn() {
		return this.panelSn;
	}

	public void setPanelSn(String panelSn) {
		this.panelSn = panelSn;
	}

	@Column(name = "panel_name", length = 50)
	public String getPanelName() {
		return this.panelName;
	}

	public void setPanelName(String panelName) {
		this.panelName = panelName;
	}

	@Column(name = "panel_content", length = 65535)
	public String getPanelContent() {
		return this.panelContent;
	}

	public void setPanelContent(String panelContent) {
		this.panelContent = panelContent;
	}

	@Column(name = "status")
	public Integer getStatus() {
		return this.status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	@Column(name = "auth")
	public Integer getAuth() {
		return this.auth;
	}

	public void setAuth(Integer auth) {
		this.auth = auth;
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

}