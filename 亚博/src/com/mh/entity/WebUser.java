/**   
* 文件名称: WebUser.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-28 下午7:23:31<br/>
*/  
package com.mh.entity;

import java.text.DecimalFormat;
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
 * 类描述: TODO<br/>用户账户表
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-28 下午7:23:31<br/>
 */
@Entity
@Table(name = "t_web_user")

public class WebUser implements java.io.Serializable {

 
	private static final long serialVersionUID = 1L;
	

	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;

	@Column(name = "user_flag")
	private String userFlag;//用户标识（哪个网站的）

	@Column(name = "user_name")
	private String userName;
	
	@Column(name = "user_byname")
	private String userByName;
	
	@Column(name = "user_password")
	private String userPassword;
	
	@Column(name = "user_status")
	private Integer userStatus;
	
	@Column(name = "user_type")
	private Integer userType;
	
	@Column(name = "user_money")
	private Double userMoney;
	
	@Column(name = "user_remark")
	private String userRemark;
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "user_last_login_time")
	private Date userLastLoginTime;//创建时间
	
	@Column(name = "user_last_login_ip")
	private String userLastLoginIp;
	
	
	@Column(name = "user_login_times")
	private Integer userLoginTimes;
	
	
	@Column(name = "user_real_name")
	private String userRealName;	
	
	@Column(name = "user_bank_type")
	private String userBankType;
	
	@Column(name = "user_bank_card")
	private String userBankCard;
	
	@Column(name = "user_bank_address")
	private String userBankAddress;
	
	@Column(name = "user_withdraw_password")
	private String userWithdrawPassword;
	
	@Column(name = "user_mobile")
	private String userMobile;
	
	@Column(name = "user_qq")
	private String userQq;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	
	@Column(name = "sys_user_name")
	private String sysUserName;
	
	@Column(name = "user_ps_times")
	private Integer userPsTimes;
	
	@Column(name = "user_agent")
	private String userAgent;
	
	@Column(name = "mine_agent")
	private String mineAgent;
	
	
	@Column(name = "user_mail")
	private String userMail;
	
	@Column(name = "user_last_login_domain")
	private String userLastLoginDomain;
	
	@Column(name = "user_session_id")
	private String userSessionId;
	
	@Column(name = "bet_flat")
	private String betFlat;//游戏平台（ag\bbin\mg\hg\pt\nt\ds\huangguan\caipiao\douji）
	
	@Column(name = "regist_ip")
	private String registIp;
	
	@Column(name="regist_device")
	private String registDevice;
	
	@Column(name="login_device")
	private String loginDevice;
	
	
	@Column(name="mail_status")
	private Integer mailStatus;
	
	//PC28返点
	@Column(name="pc28_point")
	private Double pc28Point;
	//彩票返点
	@Column(name="cp_point")
	private Double cpPoint;
	
	//代理集合
	@Column(name="relative_path")
	private String relativePath;
	//是否测试账号 0否1是
	@Column(name="is_test")
	private Integer isTest;
	
	//上次的用户密码
	@Column(name="last_user_password")
	private String lastUserPassword;
	
	//上次修改密码的时间
	@Column(name="last_update_pwd_time")
	private Date lastUpdatePwdTime;
	
	
	
	@Transient
	private Double totalMoney;
	
	/**
	 * 会员生日
	 */
	@Temporal(TemporalType.DATE)
	@Column(name = "user_birthday")
	private Date birthday;
	
	
	@Transient
	private String userTypeLevel;//会员等级
	
	@Transient
	private String customerName;
	
	@Transient
	private String toMoney;
	
	@Transient
	private String fromMoney;
	
	@Transient
	private String loginTime;
	
	@Transient
	private String beginTimeStr;
	
	@Transient
	private String endTimeStr;
	

	
	public Date getBirthday() {
		return birthday;
	}

	public void setBirthday(Date birthday) {
		this.birthday = birthday;
	}

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}
	
	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
	}

	public String getUserFlag() {
		return userFlag;
	}

	public void setUserFlag(String userFlag) {
		this.userFlag = userFlag;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getUserByName() {
		return userByName;
	}

	public void setUserByName(String userByName) {
		this.userByName = userByName;
	}

	public String getUserPassword() {
		return userPassword;
	}

	public void setUserPassword(String userPassword) {
		this.userPassword = userPassword;
	}

	public Integer getUserStatus() {
		return userStatus;
	}

	public void setUserStatus(Integer userStatus) {
		this.userStatus = userStatus;
	}

	public Integer getUserType() {
		return userType;
	}

	public void setUserType(Integer userType) {
		this.userType = userType;
	}

	public Double getUserMoney() {
		DecimalFormat df1 = new DecimalFormat("####.00");
		
		return Double.valueOf(df1.format(userMoney));
	}

	public void setUserMoney(Double userMoney) {
		this.userMoney = userMoney;
	}

	public String getUserRemark() {
		return userRemark;
	}

	public void setUserRemark(String userRemark) {
		this.userRemark = userRemark;
	}

	public Date getUserLastLoginTime() {
		return userLastLoginTime;
	}

	public void setUserLastLoginTime(Date userLastLoginTime) {
		this.userLastLoginTime = userLastLoginTime;
	}

	public String getUserLastLoginIp() {
		return userLastLoginIp;
	}

	public void setUserLastLoginIp(String userLastLoginIp) {
		this.userLastLoginIp = userLastLoginIp;
	}

	public Integer getUserLoginTimes() {
		return userLoginTimes;
	}

	public void setUserLoginTimes(Integer userLoginTimes) {
		this.userLoginTimes = userLoginTimes;
	}

	public String getUserRealName() {
		return userRealName;
	}

	public void setUserRealName(String userRealName) {
		this.userRealName = userRealName;
	}

	public String getUserBankType() {
		return userBankType;
	}

	public void setUserBankType(String userBankType) {
		this.userBankType = userBankType;
	}

	public String getUserBankCard() {
		return userBankCard;
	}

	public void setUserBankCard(String userBankCard) {
		this.userBankCard = userBankCard;
	}

	public String getUserBankAddress() {
		return userBankAddress;
	}

	public void setUserBankAddress(String userBankAddress) {
		this.userBankAddress = userBankAddress;
	}

 

	public String getUserWithdrawPassword() {
		return userWithdrawPassword;
	}

	public void setUserWithdrawPassword(String userWithdrawPassword) {
		this.userWithdrawPassword = userWithdrawPassword;
	}

	public String getUserMobile() {
		return userMobile;
	}

	public void setUserMobile(String userMobile) {
		this.userMobile = userMobile;
	}

	public String getUserQq() {
		return userQq;
	}

	public void setUserQq(String userQq) {
		this.userQq = userQq;
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

	public String getSysUserName() {
		return sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}

	public Integer getUserPsTimes() {
		return userPsTimes;
	}

	public void setUserPsTimes(Integer userPsTimes) {
		this.userPsTimes = userPsTimes;
	}

	public String getUserAgent() {
		return userAgent;
	}

	public void setUserAgent(String userAgent) {
		this.userAgent = userAgent;
	}

	public String getMineAgent() {
		return mineAgent;
	}

	public void setMineAgent(String mineAgent) {
		this.mineAgent = mineAgent;
	}

	public String getUserMail() {
		return userMail;
	}

	public void setUserMail(String userMail) {
		this.userMail = userMail;
	}

	public String getUserLastLoginDomain() {
		return userLastLoginDomain;
	}

	public void setUserLastLoginDomain(String userLastLoginDomain) {
		this.userLastLoginDomain = userLastLoginDomain;
	}

	public String getUserSessionId() {
		return userSessionId;
	}

	public void setUserSessionId(String userSessionId) {
		this.userSessionId = userSessionId;
	}

	public Double getTotalMoney() {
		return totalMoney;
	}

	public void setTotalMoney(Double totalMoney) {
		this.totalMoney = totalMoney;
	}

	public String getBetFlat() {
		return betFlat;
	}

	public void setBetFlat(String betFlat) {
		this.betFlat = betFlat;
	}

	public String getRegistIp() {
		return registIp;
	}

	public void setRegistIp(String registIp) {
		this.registIp = registIp;
	}

	public String getRegistDevice() {
		return registDevice;
	}

	public void setRegistDevice(String registDevice) {
		this.registDevice = registDevice;
	}

	public String getLoginDevice() {
		return loginDevice;
	}

	public void setLoginDevice(String loginDevice) {
		this.loginDevice = loginDevice;
	}
	
	public Integer getMailStatus() {
		return mailStatus;
	}

	public void setMailStatus(Integer mailStatus) {
		this.mailStatus = mailStatus;
	}

	public String getUserTypeLevel() {
		return userTypeLevel;
	}

	public void setUserTypeLevel(String userTypeLevel) {
		this.userTypeLevel = userTypeLevel;
	}

	public Double getPc28Point() {
		return pc28Point;
	}

	public void setPc28Point(Double pc28Point) {
		this.pc28Point = pc28Point;
	}

	public Double getCpPoint() {
		return cpPoint;
	}

	public void setCpPoint(Double cpPoint) {
		this.cpPoint = cpPoint;
	}

	public Integer getIsTest() {
		return isTest;
	}

	public void setIsTest(Integer isTest) {
		this.isTest = isTest;
	}

	public String getLastUserPassword() {
		return lastUserPassword;
	}

	public void setLastUserPassword(String lastUserPassword) {
		this.lastUserPassword = lastUserPassword;
	}

	public Date getLastUpdatePwdTime() {
		return lastUpdatePwdTime;
	}

	public void setLastUpdatePwdTime(Date lastUpdatePwdTime) {
		this.lastUpdatePwdTime = lastUpdatePwdTime;
	}

	public String getCustomerName() {
		return customerName;
	}

	public void setCustomerName(String customerName) {
		this.customerName = customerName;
	}

	public String getToMoney() {
		return toMoney;
	}

	public void setToMoney(String toMoney) {
		this.toMoney = toMoney;
	}

	public String getFromMoney() {
		return fromMoney;
	}

	public void setFromMoney(String fromMoney) {
		this.fromMoney = fromMoney;
	}

	public String getLoginTime() {
		return loginTime;
	}

	public void setLoginTime(String loginTime) {
		this.loginTime = loginTime;
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
