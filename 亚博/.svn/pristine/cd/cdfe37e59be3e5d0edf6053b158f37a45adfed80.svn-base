package com.mh.entity;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Transient;

@Entity
@Table(name = "t_web_dama")
public class TWebDama {

	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)//自增长
	@Column(name = "ID",nullable = false)
	private Integer id;

	@Column(name = "user_name")
	private String userName;
	
	@Column(name = "dm_begin_time")
	private Date dmBeginTime;
	 
	@Column(name = "dm_multiple")
	private Double dmMultiple;
	
	@Column(name = "dm_ori_money")
	private Double dmOriMoney;
	
	@Column(name = "dm_after_multiple")
	private Double dmAfterMultiple;

	@Column(name = "dm_content")
	private String dmContent;
	
	@Column(name = "status")
	private Integer status;

	@Column(name = "sys_user_name")
	private String sysUserName;

	@Column(name = "create_time")
	private Date createTime;
	
	@Column(name = "modify_time")
	private Date modifyTime;
	
	@Column(name = "remark")
	private String remark;

	@Column(name = "dm_send_money")
	private Double dmSendMoney;

	@Column(name = "dm_ratio")
	private Double dmRatio;
	
	@Column(name = "dm_req_dm")
	private Double dmReqDm;
	
	@Transient
	private Double curUserDama;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public Date getDmBeginTime() {
		return dmBeginTime;
	}

	public void setDmBeginTime(Date dmBeginTime) {
		this.dmBeginTime = dmBeginTime;
	}

	public Double getDmMultiple() {
		return dmMultiple;
	}

	public void setDmMultiple(Double dmMultiple) {
		this.dmMultiple = dmMultiple;
	}

	public Double getDmOriMoney() {
		return dmOriMoney;
	}

	public void setDmOriMoney(Double dmOriMoney) {
		this.dmOriMoney = dmOriMoney;
	}

	public Double getDmAfterMultiple() {
		return dmAfterMultiple;
	}

	public void setDmAfterMultiple(Double dmAfterMultiple) {
		this.dmAfterMultiple = dmAfterMultiple;
	}

	public String getDmContent() {
		return dmContent;
	}

	public void setDmContent(String dmContent) {
		this.dmContent = dmContent;
	}

	public Integer getStatus() {
		return status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	public String getSysUserName() {
		return sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}

	public Date getCreateTime() {
		return createTime;
	}

	public void setCreateTime(Date createTime) {
		this.createTime = createTime;
	}

	public Date getModifyTime() {
		return modifyTime;
	}

	public void setModifyTime(Date modifyTime) {
		this.modifyTime = modifyTime;
	}

	public String getRemark() {
		return remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	public Double getDmSendMoney() {
		return dmSendMoney;
	}

	public void setDmSendMoney(Double dmSendMoney) {
		this.dmSendMoney = dmSendMoney;
	}

	public Double getDmRatio() {
		return dmRatio;
	}

	public void setDmRatio(Double dmRatio) {
		this.dmRatio = dmRatio;
	}

	public Double getDmReqDm() {
		return dmReqDm;
	}

	public void setDmReqDm(Double dmReqDm) {
		this.dmReqDm = dmReqDm;
	}

	public Double getCurUserDama() {
		return curUserDama;
	}

	public void setCurUserDama(Double curUserDama) {
		this.curUserDama = curUserDama;
	}
	
}