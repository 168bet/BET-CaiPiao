/**   
* 文件名称: WebBankHuikuan.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 上午11:14:47<br/>
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
 * 类描述: TODO<br/>汇款申请记录表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 上午11:14:47<br/>
 */
@Entity
@Table(name = "t_web_bank_huikuan")
public class WebBankHuikuan implements Serializable {

	/** 
	 * @Fields serialVersionUID: TODO 
	 */ 
	private static final long serialVersionUID = 1L;
	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;//数据库主键
	
	@Column(name = "hk_order")
	private String hkOrder;//汇款订单号
	
	@Column(name = "user_name")
	private String userName;//帐号名
	
	@Column(name = "hk_type")
	private String hkType;//汇款类型（具体付款）
	
	@Column(name = "hk_online_pay_no")
	private String hkOnlinePayNo;//线上支付支付编号

	@Column(name = "hk_money")
	private Double hkMoney;//汇款金额
	
	@Column(name = "hk_company_bank")
	private String hkCompanyBank;//公司银行卡帐号
	
	@Column(name = "hk_user_bank")
	private String hkUserBank;//客户付款银行名称
	
	@Column(name = "hk_user_name")
	private String hkUserName;//存款姓名

	@Column(name = "hk_ip")
	private String hkIp;//支付电脑ip
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "hk_time")
	private Date hkTime;//入款时间
	
	@Column(name = "hk_status")
	private Integer hkStatus;//付款状态(1审核，0未审核)
	
	@Column(name = "hk_model")
	private Integer hkModel;//线上支付2，银行卡划款1,3 红利赠送\4后台入款\5投注返水\6免费彩金

	@Column(name = "remark")
	private String remark;//备注
	
	@Column(name = "hk_check_status")
	private Integer hkCheckStatus;//审核状态（1通过，0不通过）
	
	@Column(name = "hk_check_sys_user_name")
	private String hkCheckSysUserName;//操作人
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "gmt_4_time")
	private Date gmt4Time;//美东时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "hk_check_time")
	private Date hkCheckTime;//审核时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Column(name = "total_times")
	private Integer totalTimes;//总次数
	
	@Column(name = "day_times")
	private Integer dayTimes;//当天次数
	
	@Column(name = "pay_dama")
	private Integer payDama;//是否打码量再次存款
	
	@Column(name = "pay_default")
	private Integer payDefault;//默认一倍
	
	@Column(name = "hk_youhui")
	private Integer hkYouhui;//存款优惠
	@Column(name = "pay_no")
	private String payNo;//存款账户编号
	
	@Transient
	private String beginTimeStr;
	@Transient
	private String endTimeStr;
	@Transient
	private String status;
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

	public String getHkOrder() {
		return hkOrder;
	}

	public void setHkOrder(String hkOrder) {
		this.hkOrder = hkOrder;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getHkType() {
		return hkType;
	}

	public void setHkType(String hkType) {
		this.hkType = hkType;
	}

	public String getHkOnlinePayNo() {
		return hkOnlinePayNo;
	}

	public void setHkOnlinePayNo(String hkOnlinePayNo) {
		this.hkOnlinePayNo = hkOnlinePayNo;
	}

	public Double getHkMoney() {
		return hkMoney;
	}

	public void setHkMoney(Double hkMoney) {
		this.hkMoney = hkMoney;
	}

	public String getHkCompanyBank() {
		return hkCompanyBank;
	}

	public void setHkCompanyBank(String hkCompanyBank) {
		this.hkCompanyBank = hkCompanyBank;
	}

	public String getHkUserBank() {
		return hkUserBank;
	}

	public void setHkUserBank(String hkUserBank) {
		this.hkUserBank = hkUserBank;
	}

	public String getHkUserName() {
		return hkUserName;
	}

	public void setHkUserName(String hkUserName) {
		this.hkUserName = hkUserName;
	}

	public String getHkIp() {
		return hkIp;
	}

	public void setHkIp(String hkIp) {
		this.hkIp = hkIp;
	}

	public Date getHkTime() {
		return hkTime;
	}

	public void setHkTime(Date hkTime) {
		this.hkTime = hkTime;
	}

	public Integer getHkStatus() {
		return hkStatus;
	}

	public void setHkStatus(Integer hkStatus) {
		this.hkStatus = hkStatus;
	}

	public Integer getHkModel() {
		return hkModel;
	}

	public void setHkModel(Integer hkModel) {
		this.hkModel = hkModel;
	}

	public String getRemark() {
		return remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	public Integer getHkCheckStatus() {
		return hkCheckStatus;
	}

	public void setHkCheckStatus(Integer hkCheckStatus) {
		this.hkCheckStatus = hkCheckStatus;
	}

	public String getHkCheckSysUserName() {
		return hkCheckSysUserName;
	}

	public void setHkCheckSysUserName(String hkCheckSysUserName) {
		this.hkCheckSysUserName = hkCheckSysUserName;
	}

	public Date getGmt4Time() {
		return gmt4Time;
	}

	public void setGmt4Time(Date gmt4Time) {
		this.gmt4Time = gmt4Time;
	}

	public Date getHkCheckTime() {
		return hkCheckTime;
	}

	public void setHkCheckTime(Date hkCheckTime) {
		this.hkCheckTime = hkCheckTime;
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

	public Integer getPayDama() {
		return payDama;
	}

	public void setPayDama(Integer payDama) {
		this.payDama = payDama;
	}

	public Integer getPayDefault() {
		return payDefault;
	}

	public void setPayDefault(Integer payDefault) {
		this.payDefault = payDefault;
	}

	public Integer getHkYouhui() {
		return hkYouhui;
	}

	public void setHkYouhui(Integer hkYouhui) {
		this.hkYouhui = hkYouhui;
	}

	public String getPayNo() {
		return payNo;
	}

	public void setPayNo(String payNo) {
		this.payNo = payNo;
	}

	public String getStatus() {
		return status;
	}

	public void setStatus(String status) {
		this.status = status;
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
