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
 * TWebThirdPayKj entity. @author MyEclipse Persistence Tools
 */
@Entity
@Table(name = "t_web_third_pay_kj")
public class TWebThirdPayKj implements java.io.Serializable {

	// Fields

	private Integer id;
	private String payName;
	private Integer payType;
	private String payValue;
	private String thirdPayType;
	private Integer thirdPayId;
	private Integer payMinEdu;
	private Integer payMaxEdu;
	private Integer status;
	private Date modifyTime;

	// Constructors

	/** default constructor */
	public TWebThirdPayKj() {
	}

	/** minimal constructor */
	public TWebThirdPayKj(String payName, Integer payType) {
		this.payName = payName;
		this.payType = payType;
	}

	/** full constructor */
	public TWebThirdPayKj(String payName, Integer payType, String payValue,
			String thirdPayType, Integer thirdPayId, Integer status,
			Timestamp modifyTime) {
		this.payName = payName;
		this.payType = payType;
		this.payValue = payValue;
		this.thirdPayType = thirdPayType;
		this.thirdPayId = thirdPayId;
		this.status = status;
		this.modifyTime = modifyTime;
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

	@Column(name = "pay_name", nullable = false, length = 50)
	public String getPayName() {
		return this.payName;
	}

	public void setPayName(String payName) {
		this.payName = payName;
	}

	@Column(name = "pay_type", nullable = false)
	public Integer getPayType() {
		return this.payType;
	}

	public void setPayType(Integer payType) {
		this.payType = payType;
	}

	@Column(name = "pay_value", length = 50)
	public String getPayValue() {
		return this.payValue;
	}

	public void setPayValue(String payValue) {
		this.payValue = payValue;
	}

	@Column(name = "third_pay_type", length = 50)
	public String getThirdPayType() {
		return this.thirdPayType;
	}

	public void setThirdPayType(String thirdPayType) {
		this.thirdPayType = thirdPayType;
	}

	@Column(name = "third_pay_id")
	public Integer getThirdPayId() {
		return this.thirdPayId;
	}

	public void setThirdPayId(Integer thirdPayId) {
		this.thirdPayId = thirdPayId;
	}
	
	
	@Column(name = "pay_min_edu")
	public Integer getPayMinEdu() {
		return payMinEdu;
	}

	public void setPayMinEdu(Integer payMinEdu) {
		this.payMinEdu = payMinEdu;
	}

	@Column(name = "pay_max_edu")
	public Integer getPayMaxEdu() {
		return payMaxEdu;
	}

	public void setPayMaxEdu(Integer payMaxEdu) {
		this.payMaxEdu = payMaxEdu;
	}

	@Column(name = "status")
	public Integer getStatus() {
		return this.status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time", length = 19)
	public Date getModifyTime() {
		return this.modifyTime;
	}

	public void setModifyTime(Date modifyTime) {
		this.modifyTime = modifyTime;
	}
	
	

}