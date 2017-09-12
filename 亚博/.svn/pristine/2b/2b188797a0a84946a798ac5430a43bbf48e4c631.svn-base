/**   
* 文件名称: WebBank.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 上午11:10:11<br/>
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

/** 
 * 类描述: TODO<br/>公司入款银行卡记录表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 上午11:10:11<br/>
 */
@Entity
@Table(name = "t_web_bank")
public class WebBank implements Serializable {

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
	
	@Column(name = "bank_type")
	private String bankType;//银行卡类型
	
	@Column(name = "bank_card")
	private String bankCard;//银行卡卡号
	
	@Column(name = "bank_user")
	private String bankUser;//银行卡户名
	
	@Column(name = "bank_code")
	private String bankCode;//银行代码

	@Column(name = "bank_address")
	private String bankAddress;//开户行地址
	
	@Column(name = "bank_status")
	private Integer bankStatus;//启动标识（1启动、0关闭）
	
	@Column(name = "remark")
	private String remark;//备注

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Column(name = "pay_no")
	private String payNo;//存款账户编号

	public Integer getId() {
		return id;
	}


	public void setId(Integer id) {
		this.id = id;
	}


	public String getBankType() {
		return bankType;
	}


	public void setBankType(String bankType) {
		this.bankType = bankType;
	}


	public String getBankCard() {
		return bankCard;
	}


	public void setBankCard(String bankCard) {
		this.bankCard = bankCard;
	}


	public String getBankUser() {
		return bankUser;
	}


	public void setBankUser(String bankUser) {
		this.bankUser = bankUser;
	}


	public String getBankCode() {
		return bankCode;
	}


	public void setBankCode(String bankCode) {
		this.bankCode = bankCode;
	}


	public String getBankAddress() {
		return bankAddress;
	}


	public void setBankAddress(String bankAddress) {
		this.bankAddress = bankAddress;
	}


	public Integer getBankStatus() {
		return bankStatus;
	}


	public void setBankStatus(Integer bankStatus) {
		this.bankStatus = bankStatus;
	}


	public String getRemark() {
		return remark;
	}


	public void setRemark(String remark) {
		this.remark = remark;
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


	public String getPayNo() {
		return payNo;
	}


	public void setPayNo(String payNo) {
		this.payNo = payNo;
	}
	
}
