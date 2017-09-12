/**   
* 文件名称: WebUserWithdraw.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 下午3:19:47<br/>
*/  
package com.mh.entity;

import java.io.Serializable;
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
 * 类描述: TODO<br/>出款记录表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午3:19:47<br/>
 */
@Entity
@Table(name = "t_web_user_withdraw")
public class WebUserWithdraw implements Serializable {

	/** 
	 * @Fields serialVersionUID: TODO 
	 */ 
	private static final long serialVersionUID = 1L;
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;//数据库主键
	
	@Column(name = "user_order")
	private String userOrder;//编号

	@Column(name = "user_name")
	private String userName;//帐号名
	
	@Column(name = "user_real_name")
	private String userRealName;//取款姓名
	
	@Column(name = "user_withdraw_money")
	private Double userWithdrawMoney;//取款金额
	
	@Column(name = "user_bank_info")
	private String userBankInfo;//银行卡信息
	
	@Column(name = "status")
	private Integer status;//状态（1已审核，0未审核）
	
	@Column(name = "check_status")
	private Integer checkStatus;//审核状态：1审核通过，2审核不通过
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "check_time")
	private Date checkTime;//审核时间
	
	@Column(name = "withdraw_type")
	private Integer withdrawType;//取款类型（11会员取款、12系统扣款）
	
	@Column(name = "check_sys_user_name")
	private String checkSysUserName;//审核人
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Column(name = "remark")
	private String remark;//消息状态

 
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "gmt_4_time")
	private Date gmt4Time;//美东时间
	
	@Column(name = "total_times")
	private Integer totalTimes;//总次数
	
	@Column(name = "day_times")
	private Integer dayTimes;//当天次数
	
	@Column(name = "user_procedure")
	private Double userProcedure;//手续费用
	
	@Column(name = "user_administration")
	private Double userAdministration;//行政费用
	
	@Column(name = "user_cost")
	private Integer userCost;//扣手续费用（1有，0无）
	
	@Column(name = "user_withdraw_real_money")
	private Double userWithdrawRealMoney;//真正出款的钱
	
	@Transient
	private String beginTimeStr;
	@Transient
	private String endTimeStr;

	@Transient
	private String withdrawStatus;
	
	@Transient
	private String relativePath;
	
	
	
	
	


	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
	}

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getUserOrder() {
		return userOrder;
	}

	public void setUserOrder(String userOrder) {
		this.userOrder = userOrder;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getUserRealName() {
		return userRealName;
	}

	public void setUserRealName(String userRealName) {
		this.userRealName = userRealName;
	}

	public Double getUserWithdrawMoney() {
		return userWithdrawMoney;
	}

	public void setUserWithdrawMoney(Double userWithdrawMoney) {
		this.userWithdrawMoney = userWithdrawMoney;
	}

	public String getUserBankInfo() {
		return userBankInfo;
	}

	public void setUserBankInfo(String userBankInfo) {
		this.userBankInfo = userBankInfo;
	}

	public Integer getStatus() {
		return status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	public Integer getCheckStatus() {
		return checkStatus;
	}

	public void setCheckStatus(Integer checkStatus) {
		this.checkStatus = checkStatus;
	}

	public Date getCheckTime() {
		return checkTime;
	}

	public void setCheckTime(Date checkTime) {
		this.checkTime = checkTime;
	}

	public Integer getWithdrawType() {
		return withdrawType;
	}

	public void setWithdrawType(Integer withdrawType) {
		this.withdrawType = withdrawType;
	}

	public String getCheckSysUserName() {
		return checkSysUserName;
	}

	public void setCheckSysUserName(String checkSysUserName) {
		this.checkSysUserName = checkSysUserName;
	}

	public Date getModifyTime() {
		return modifyTime;
	}

	public void setModifyTime(Date modifyTime) {
		this.modifyTime = modifyTime;
	}

	public Date getCreateTime() {
		return createTime;
	}

	public void setCreateTime(Date createTime) {
		this.createTime = createTime;
	}

	public String getRemark() {
		return remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

 

	public Date getGmt4Time() {
		return gmt4Time;
	}

	public void setGmt4Time(Date gmt4Time) {
		this.gmt4Time = gmt4Time;
	}

	public Integer getTotalTimes() {
		return totalTimes;
	}

	public void setTotalTimes(Integer totalTimes) {
		this.totalTimes = totalTimes;
	}

	public Integer getDayTimes() {
		return dayTimes;
	}

	public void setDayTimes(Integer dayTimes) {
		this.dayTimes = dayTimes;
	}

	public Double getUserProcedure() {
		return userProcedure;
	}

	public void setUserProcedure(Double userProcedure) {
		this.userProcedure = userProcedure;
	}

	public Double getUserAdministration() {
		return userAdministration;
	}

	public void setUserAdministration(Double userAdministration) {
		this.userAdministration = userAdministration;
	}

	public Integer getUserCost() {
		return userCost;
	}

	public void setUserCost(Integer userCost) {
		this.userCost = userCost;
	}

	public Double getUserWithdrawRealMoney() {
		return userWithdrawRealMoney;
	}

	public void setUserWithdrawRealMoney(Double userWithdrawRealMoney) {
		this.userWithdrawRealMoney = userWithdrawRealMoney;
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

	public String getWithdrawStatus() {
		return withdrawStatus;
	}

	public void setWithdrawStatus(String withdrawStatus) {
		this.withdrawStatus = withdrawStatus;
	}
	
	
	

}
