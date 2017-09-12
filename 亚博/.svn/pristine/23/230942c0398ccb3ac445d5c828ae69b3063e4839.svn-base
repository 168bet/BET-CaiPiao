package com.mh.entity;


import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * WebSite entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_site")
public class WebSite implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private String siteName;
	private String siteKeywords;
	private String siteDescription;
	private String siteDomain;
	private String siteGundong;
	private String siteFooter;
	private String siteQq;
	private String siteTel;
	private String siteMail;
	private String siteReserveDomain;
	private String siteMobile;
	private String siteLine;

	// Constructors

	/** default constructor */
	public WebSite() {
	}

	/** full constructor */
	public WebSite(String siteName, String siteKeywords,
			String siteDescription, String siteDomain, String siteGundong,
			String siteFooter, String siteQq, String siteTel, String siteMail,
			String siteReserveDomain, String siteMobile, String siteLine) {
		this.siteName = siteName;
		this.siteKeywords = siteKeywords;
		this.siteDescription = siteDescription;
		this.siteDomain = siteDomain;
		this.siteGundong = siteGundong;
		this.siteFooter = siteFooter;
		this.siteQq = siteQq;
		this.siteTel = siteTel;
		this.siteMail = siteMail;
		this.siteReserveDomain = siteReserveDomain;
		this.siteMobile = siteMobile;
		this.siteLine = siteLine;
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

	@Column(name = "site_name", length = 50)
	public String getSiteName() {
		return this.siteName;
	}

	public void setSiteName(String siteName) {
		this.siteName = siteName;
	}

	@Column(name = "site_keywords", length = 100)
	public String getSiteKeywords() {
		return this.siteKeywords;
	}

	public void setSiteKeywords(String siteKeywords) {
		this.siteKeywords = siteKeywords;
	}

	@Column(name = "site_description")
	public String getSiteDescription() {
		return this.siteDescription;
	}

	public void setSiteDescription(String siteDescription) {
		this.siteDescription = siteDescription;
	}

	@Column(name = "site_domain", length = 50)
	public String getSiteDomain() {
		return this.siteDomain;
	}

	public void setSiteDomain(String siteDomain) {
		this.siteDomain = siteDomain;
	}

	@Column(name = "site_gundong", length = 500)
	public String getSiteGundong() {
		return this.siteGundong;
	}

	public void setSiteGundong(String siteGundong) {
		this.siteGundong = siteGundong;
	}

	@Column(name = "site_footer", length = 65535)
	public String getSiteFooter() {
		return this.siteFooter;
	}

	public void setSiteFooter(String siteFooter) {
		this.siteFooter = siteFooter;
	}

	@Column(name = "site_qq", length = 50)
	public String getSiteQq() {
		return this.siteQq;
	}

	public void setSiteQq(String siteQq) {
		this.siteQq = siteQq;
	}

	@Column(name = "site_tel", length = 50)
	public String getSiteTel() {
		return this.siteTel;
	}

	public void setSiteTel(String siteTel) {
		this.siteTel = siteTel;
	}

	@Column(name = "site_mail", length = 50)
	public String getSiteMail() {
		return this.siteMail;
	}

	public void setSiteMail(String siteMail) {
		this.siteMail = siteMail;
	}

	@Column(name = "site_reserve_domain", length = 1024)
	public String getSiteReserveDomain() {
		return this.siteReserveDomain;
	}

	public void setSiteReserveDomain(String siteReserveDomain) {
		this.siteReserveDomain = siteReserveDomain;
	}

	@Column(name = "site_mobile", length = 50)
	public String getSiteMobile() {
		return this.siteMobile;
	}

	public void setSiteMobile(String siteMobile) {
		this.siteMobile = siteMobile;
	}

	@Column(name = "site_line", length = 50)
	public String getSiteLine() {
		return this.siteLine;
	}

	public void setSiteLine(String siteLine) {
		this.siteLine = siteLine;
	}

}