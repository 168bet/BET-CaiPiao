package com.mh.entity;

import static javax.persistence.GenerationType.IDENTITY;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name = "t_web_user_bank")
public class TWebUserBank implements java.io.Serializable {

	private static final long serialVersionUID = 1L;
	private Integer id;
	private String userName;
	private String userRealName;
	
	private String bankCode;
	private String bankType;
	private String bankCard;
	private String bankAddress;
	private Integer isEnable;
	private Date createTime;
	private Date modifyTime;
	private String province;
	private String city;
	private String subBranch;
	private Integer isMaster;

	public TWebUserBank() {
	}

	public TWebUserBank(String userName, String userRealName, String bankType, String bankCard, String bankAddress, Integer isEnable, Date createTime, Date modifyTime, String province, String city, String subBranch, Integer isMaster) {
		this.userName = userName;
		this.userRealName = userRealName;
		this.bankType = bankType;
		this.bankCard = bankCard;
		this.bankAddress = bankAddress;
		this.isEnable = isEnable;
		this.createTime = createTime;
		this.modifyTime = modifyTime;
		this.province = province;
		this.city = city;
		this.subBranch = subBranch;
		this.isMaster = isMaster;
	}

	@Id
	@GeneratedValue(strategy = IDENTITY)
	@Column(name = "id", unique = true, nullable = false)
	public Integer getId() {
		return this.id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	@Column(name = "user_name", length = 64)
	public String getUserName() {
		return this.userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	@Column(name = "user_real_name", length = 64)
	public String getUserRealName() {
		return this.userRealName;
	}

	public void setUserRealName(String userRealName) {
		this.userRealName = userRealName;
	}
	
	
	
	@Column(name = "bank_code", length = 32)
	public String getBankCode() {
		return bankCode;
	}

	public void setBankCode(String bankCode) {
		this.bankCode = bankCode;
	}

	@Column(name = "bank_type", length = 64)
	public String getBankType() {
		return this.bankType;
	}

	public void setBankType(String bankType) {
		this.bankType = bankType;
	}

	@Column(name = "bank_card", length = 128)
	public String getBankCard() {
		return this.bankCard;
	}

	public void setBankCard(String bankCard) {
		this.bankCard = bankCard;
	}

	@Column(name = "bank_address", length = 512)
	public String getBankAddress() {
		return this.bankAddress;
	}

	public void setBankAddress(String bankAddress) {
		this.bankAddress = bankAddress;
	}

	@Column(name = "is_enable")
	public Integer getIsEnable() {
		return this.isEnable;
	}

	public void setIsEnable(Integer isEnable) {
		this.isEnable = isEnable;
	}

	@Column(name = "create_time", length = 19)
	public Date getCreateTime() {
		return this.createTime;
	}

	public void setCreateTime(Date createTime) {
		this.createTime = createTime;
	}

	@Column(name = "modify_time", length = 19)
	public Date getModifyTime() {
		return this.modifyTime;
	}

	public void setModifyTime(Date modifyTime) {
		this.modifyTime = modifyTime;
	}

	@Column(name = "province", length = 64)
	public String getProvince() {
		return this.province;
	}

	public void setProvince(String province) {
		this.province = province;
	}

	@Column(name = "city", length = 64)
	public String getCity() {
		return this.city;
	}

	public void setCity(String city) {
		this.city = city;
	}

	@Column(name = "sub_branch", length = 64)
	public String getSubBranch() {
		return this.subBranch;
	}

	public void setSubBranch(String subBranch) {
		this.subBranch = subBranch;
	}

	@Column(name = "is_master")
	public Integer getIsMaster() {
		return this.isMaster;
	}

	public void setIsMaster(Integer isMaster) {
		this.isMaster = isMaster;
	}

}