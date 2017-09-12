package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebLineCk entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_line_ck")
public class WebLineCk implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private String lckLogoPic;
	private Integer lckLogoWidth;
	private Integer lckLogoHeight;
	private String lckDomain;
	private String lckMainContent;
	private String lckFootContent;
	private String lckOtherContent;
	private String lckMainDomain;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String sysUserName;

	// Constructors

	/** default constructor */
	public WebLineCk() {
	}

	/** full constructor */
	public WebLineCk(String lckLogoPic, Integer lckLogoWidth,
			Integer lckLogoHeight, String lckDomain, String lckMainContent,
			String lckFootContent, String lckOtherContent,
			String lckMainDomain, Timestamp createTime, Timestamp modifyTime,
			String sysUserName) {
		this.lckLogoPic = lckLogoPic;
		this.lckLogoWidth = lckLogoWidth;
		this.lckLogoHeight = lckLogoHeight;
		this.lckDomain = lckDomain;
		this.lckMainContent = lckMainContent;
		this.lckFootContent = lckFootContent;
		this.lckOtherContent = lckOtherContent;
		this.lckMainDomain = lckMainDomain;
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

	@Column(name = "lck_logo_pic")
	public String getLckLogoPic() {
		return this.lckLogoPic;
	}

	public void setLckLogoPic(String lckLogoPic) {
		this.lckLogoPic = lckLogoPic;
	}

	@Column(name = "lck_logo_width")
	public Integer getLckLogoWidth() {
		return this.lckLogoWidth;
	}

	public void setLckLogoWidth(Integer lckLogoWidth) {
		this.lckLogoWidth = lckLogoWidth;
	}

	@Column(name = "lck_logo_height")
	public Integer getLckLogoHeight() {
		return this.lckLogoHeight;
	}

	public void setLckLogoHeight(Integer lckLogoHeight) {
		this.lckLogoHeight = lckLogoHeight;
	}

	@Column(name = "lck_domain", length = 1024)
	public String getLckDomain() {
		return this.lckDomain;
	}

	public void setLckDomain(String lckDomain) {
		this.lckDomain = lckDomain;
	}

	@Column(name = "lck_main_content", length = 65535)
	public String getLckMainContent() {
		return this.lckMainContent;
	}

	public void setLckMainContent(String lckMainContent) {
		this.lckMainContent = lckMainContent;
	}

	@Column(name = "lck_foot_content", length = 65535)
	public String getLckFootContent() {
		return this.lckFootContent;
	}

	public void setLckFootContent(String lckFootContent) {
		this.lckFootContent = lckFootContent;
	}

	@Column(name = "lck_other_content", length = 65535)
	public String getLckOtherContent() {
		return this.lckOtherContent;
	}

	public void setLckOtherContent(String lckOtherContent) {
		this.lckOtherContent = lckOtherContent;
	}

	@Column(name = "lck_main_domain")
	public String getLckMainDomain() {
		return this.lckMainDomain;
	}

	public void setLckMainDomain(String lckMainDomain) {
		this.lckMainDomain = lckMainDomain;
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