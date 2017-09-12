package com.mh.entity;

import java.sql.Timestamp;
import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

import static javax.persistence.GenerationType.IDENTITY;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * TLinkWebKjPay entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_link_web_kj_pay")
public class TLinkWebKjPay {

	// Fields

	private Integer id;
	private Integer userTypeId;
	private Integer userKjPayType;
	private Integer userKjPayId;
	private Integer status;
	private Date autoUpdateTime;

	// Constructors

	/** default constructor */
	public TLinkWebKjPay() {
	}

	/** full constructor */
	public TLinkWebKjPay(Integer userTypeId, Integer userKjPayType,Integer userKjPayId,
			 Integer status, Timestamp autoUpdateTime) {
		this.userTypeId = userTypeId;
		this.userKjPayType = userKjPayType;
		this.userKjPayId = userKjPayId;
		this.status = status;
		this.autoUpdateTime = autoUpdateTime;
	}

	// Property accessors
	@Id
	@GeneratedValue(strategy = IDENTITY)
	@Column(name = "id", unique = true, nullable = false)
	public Integer getId() {
		return this.id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	@Column(name = "user_type_id")
	public Integer getUserTypeId() {
		return this.userTypeId;
	}

	public void setUserTypeId(Integer userTypeId) {
		this.userTypeId = userTypeId;
	}

	@Column(name = "user_kj_pay_type")
	public Integer getUserKjPayType() {
		return this.userKjPayType;
	}

	public void setUserKjPayType(Integer userKjPayType) {
		this.userKjPayType = userKjPayType;
	}
	
	@Column(name = "user_kj_pay_id")
	public Integer getUserKjPayId() {
		return userKjPayId;
	}

	public void setUserKjPayId(Integer userKjPayId) {
		this.userKjPayId = userKjPayId;
	}

	@Column(name = "status")
	public Integer getStatus() {
		return this.status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "auto_update_time", length = 19)
	public Date getAutoUpdateTime() {
		return this.autoUpdateTime;
	}

	public void setAutoUpdateTime(Date autoUpdateTime) {
		this.autoUpdateTime = autoUpdateTime;
	}

}