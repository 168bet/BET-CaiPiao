package com.mh.entity;

// default package

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * LinkWebPromosType entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_link_web_promos_type")
public class LinkWebPromosType implements java.io.Serializable {

	// Fields

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Integer id;
	private Integer pmsTypeId;
	private String pmsName;

	// Constructors

	/** default constructor */
	public LinkWebPromosType() {
	}

	/** full constructor */
	public LinkWebPromosType(Integer pmsTypeId, String pmsName) {
		this.pmsTypeId = pmsTypeId;
		this.pmsName = pmsName;
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

	@Column(name = "pms_type_id")
	public Integer getPmsTypeId() {
		return this.pmsTypeId;
	}

	public void setPmsTypeId(Integer pmsTypeId) {
		this.pmsTypeId = pmsTypeId;
	}

	@Column(name = "pms_name", length = 50)
	public String getPmsName() {
		return this.pmsName;
	}

	public void setPmsName(String pmsName) {
		this.pmsName = pmsName;
	}

}