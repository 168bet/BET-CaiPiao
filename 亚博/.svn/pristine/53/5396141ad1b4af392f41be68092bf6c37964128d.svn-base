package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebPage entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_page")
public class WebPage implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private String pgSequence;
	private String pgSn;
	private String pgTitle;
	private String pgContent;
	private String pgMetaKeywords;
	private String pgMetaDescription;
	private Integer status;
	private Integer auth;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String sysUserName;
	private String remark;
	private Integer pgType;
	private Integer pgCtype;
	private String pgUrl;

	// Constructors

	/** default constructor */
	public WebPage() {
	}

	/** full constructor */
	public WebPage(String pgSequence, String pgSn, String pgTitle,
			String pgContent, String pgMetaKeywords, String pgMetaDescription,
			Integer status, Integer auth, Timestamp createTime,
			Timestamp modifyTime, String sysUserName, String remark,
			Integer pgType, Integer pgCtype, String pgUrl) {
		this.pgSequence = pgSequence;
		this.pgSn = pgSn;
		this.pgTitle = pgTitle;
		this.pgContent = pgContent;
		this.pgMetaKeywords = pgMetaKeywords;
		this.pgMetaDescription = pgMetaDescription;
		this.status = status;
		this.auth = auth;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.sysUserName = sysUserName;
		this.remark = remark;
		this.pgType = pgType;
		this.pgCtype = pgCtype;
		this.pgUrl = pgUrl;
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

	@Column(name = "pg_sequence", length = 50)
	public String getPgSequence() {
		return this.pgSequence;
	}

	public void setPgSequence(String pgSequence) {
		this.pgSequence = pgSequence;
	}

	@Column(name = "pg_sn", length = 50)
	public String getPgSn() {
		return this.pgSn;
	}

	public void setPgSn(String pgSn) {
		this.pgSn = pgSn;
	}

	@Column(name = "pg_title")
	public String getPgTitle() {
		return this.pgTitle;
	}

	public void setPgTitle(String pgTitle) {
		this.pgTitle = pgTitle;
	}

	@Column(name = "pg_content", length = 65535)
	public String getPgContent() {
		return this.pgContent;
	}

	public void setPgContent(String pgContent) {
		this.pgContent = pgContent;
	}

	@Column(name = "pg_meta_keywords")
	public String getPgMetaKeywords() {
		return this.pgMetaKeywords;
	}

	public void setPgMetaKeywords(String pgMetaKeywords) {
		this.pgMetaKeywords = pgMetaKeywords;
	}

	@Column(name = "pg_meta_description", length = 500)
	public String getPgMetaDescription() {
		return this.pgMetaDescription;
	}

	public void setPgMetaDescription(String pgMetaDescription) {
		this.pgMetaDescription = pgMetaDescription;
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

	@Column(name = "sys_user_name", length = 50)
	public String getSysUserName() {
		return this.sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}

	@Column(name = "remark")
	public String getRemark() {
		return this.remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	@Column(name = "pg_type")
	public Integer getPgType() {
		return this.pgType;
	}

	public void setPgType(Integer pgType) {
		this.pgType = pgType;
	}

	@Column(name = "pg_ctype")
	public Integer getPgCtype() {
		return this.pgCtype;
	}

	public void setPgCtype(Integer pgCtype) {
		this.pgCtype = pgCtype;
	}

	@Column(name = "pg_url")
	public String getPgUrl() {
		return this.pgUrl;
	}

	public void setPgUrl(String pgUrl) {
		this.pgUrl = pgUrl;
	}

}