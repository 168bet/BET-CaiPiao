package com.mh.entity;

// default package

import java.sql.Timestamp;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebCarousel entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_carousel")
public class WebCarousel implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String crsName;
	private String crsTitle;
	private Integer crsIndex;
	private String crsPic;
	private String crsUrl;
	private String crsContent;
	private Integer status;
	private Timestamp createTime;
	private Timestamp modifyTime;
	private String sysUserName;
	private Integer crsTime;
	private Integer crsType;

	// Constructors

	/** default constructor */
	public WebCarousel() {
	}

	/** minimal constructor */
	public WebCarousel(String crsPic) {
		this.crsPic = crsPic;
	}

	/** full constructor */
	public WebCarousel(String crsTitle, Integer crsIndex, String crsPic,
			String crsUrl, String crsContent, Integer status,
			Timestamp createTime, Timestamp modifyTime, String sysUserName,
			Integer crsTime,Integer crsType) {
		this.crsTitle = crsTitle;
		this.crsIndex = crsIndex;
		this.crsPic = crsPic;
		this.crsUrl = crsUrl;
		this.crsContent = crsContent;
		this.status = status;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.sysUserName = sysUserName;
		this.crsTime = crsTime;
		this.crsType = crsType;
	}

	// Property accessors
	@Id
	@GeneratedValue
	@Column(name = "crs_name", unique = true, nullable = false, length = 50)
	public String getCrsName() {
		return this.crsName;
	}

	public void setCrsName(String crsName) {
		this.crsName = crsName;
	}

	@Column(name = "crs_title", length = 50)
	public String getCrsTitle() {
		return this.crsTitle;
	}

	public void setCrsTitle(String crsTitle) {
		this.crsTitle = crsTitle;
	}

	@Column(name = "crs_index")
	public Integer getCrsIndex() {
		return this.crsIndex;
	}

	public void setCrsIndex(Integer crsIndex) {
		this.crsIndex = crsIndex;
	}

	@Column(name = "crs_pic", nullable = false)
	public String getCrsPic() {
		return this.crsPic;
	}

	public void setCrsPic(String crsPic) {
		this.crsPic = crsPic;
	}

	@Column(name = "crs_url")
	public String getCrsUrl() {
		return this.crsUrl;
	}

	public void setCrsUrl(String crsUrl) {
		this.crsUrl = crsUrl;
	}

	@Column(name = "crs_content")
	public String getCrsContent() {
		return this.crsContent;
	}

	public void setCrsContent(String crsContent) {
		this.crsContent = crsContent;
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

	@Column(name = "crs_time")
	public Integer getCrsTime() {
		return this.crsTime;
	}

	public void setCrsTime(Integer crsTime) {
		this.crsTime = crsTime;
	}
	@Column(name = "crs_type")
	public Integer getCrsType() {
		return crsType;
	}

	public void setCrsType(Integer crsType) {
		this.crsType = crsType;
	}
	
	

}