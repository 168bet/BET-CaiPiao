package com.mh.entity;

// default package

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * LinkWebPage entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_link_web_page")
public class LinkWebPage implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private String pgSn;
	private String childPgSn;

	// Constructors

	/** default constructor */
	public LinkWebPage() {
	}

	/** full constructor */
	public LinkWebPage(String pgSn, String childPgSn) {
		this.pgSn = pgSn;
		this.childPgSn = childPgSn;
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

	@Column(name = "pg_sn", length = 50)
	public String getPgSn() {
		return this.pgSn;
	}

	public void setPgSn(String pgSn) {
		this.pgSn = pgSn;
	}

	@Column(name = "child_pg_sn", length = 50)
	public String getChildPgSn() {
		return this.childPgSn;
	}

	public void setChildPgSn(String childPgSn) {
		this.childPgSn = childPgSn;
	}

}