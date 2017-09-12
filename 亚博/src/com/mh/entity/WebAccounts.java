/**   
* 文件名称: WebAccounts.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-28 下午7:23:31<br/>
*/  
package com.mh.entity;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.persistence.Transient;

/** 
 * 类描述: TODO<br/>资金账户流水表
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-28 下午7:23:31<br/>
 */
@Entity
@Table(name = "t_web_account")
public class WebAccounts implements java.io.Serializable {

 
	private static final long serialVersionUID = 1L;

	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;

	@Column(name = "user_name")
	private String userName;//会员帐号

	@Column(name = "act_opt_money")
	private Double actOptMoney;// 操作金额
	
	@Column(name = "act_result_money")
	private Double actResultMoney;//操作后的帐户金额
	
	@Column(name = "act_pro_type")
	private String actProType;//项目类型
	
	@Column(name = "act_opt_type")
	private String actOptType;//财务类型
	
	@Column(name = "act_order")
	private String actOrder;//订单编号（外联）
	
	@Column(name = "sys_user_name")
	private String sysUserName;//操作人
	
	@Column(name = "status")
	private Integer status;//状态
	
	@Column(name = "remark")
	private String remark;//备注
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "gmt_4_time")
	private Date gmt4Time;//修改时间
	
 
	@Column(name = "user_agent")
	private String userAgent;
	
	
	@Transient
	private String beginTimeStr;
	
	@Transient
	private String endTimeStr;
	
	


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


	public Double getActOptMoney() {
		return actOptMoney;
	}


	public void setActOptMoney(Double actOptMoney) {
		this.actOptMoney = actOptMoney;
	}


	public Double getActResultMoney() {
		return actResultMoney;
	}


	public void setActResultMoney(Double actResultMoney) {
		this.actResultMoney = actResultMoney;
	}


	public String getActProType() {
		return actProType;
	}


	public void setActProType(String actProType) {
		this.actProType = actProType;
	}


	public String getActOptType() {
		return actOptType;
	}


	public void setActOptType(String actOptType) {
		this.actOptType = actOptType;
	}


	public String getActOrder() {
		return actOrder;
	}


	public void setActOrder(String actOrder) {
		this.actOrder = actOrder;
	}


	public String getSysUserName() {
		return sysUserName;
	}


	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}


 


	public Integer getStatus() {
		return status;
	}


	public void setStatus(Integer status) {
		this.status = status;
	}


	public String getRemark() {
		return remark;
	}


	public void setRemark(String remark) {
		this.remark = remark;
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


	public Date getGmt4Time() {
		return gmt4Time;
	}


	public void setGmt4Time(Date gmt4Time) {
		this.gmt4Time = gmt4Time;
	}


	public String getUserAgent() {
		return userAgent;
	}


	public void setUserAgent(String userAgent) {
		this.userAgent = userAgent;
	}


	public String getBeginTimeStr() {
		return beginTimeStr;
	}


	public void setBeginTimeStr(String beginTimeStr) {
		this.beginTimeStr = beginTimeStr;
	}


	public String getEndTimeStr() {
		return endTimeStr;
	}


	public void setEndTimeStr(String endTimeStr) {
		this.endTimeStr = endTimeStr;
	}
	
}
