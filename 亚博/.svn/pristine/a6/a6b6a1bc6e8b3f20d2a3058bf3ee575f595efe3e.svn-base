/**   
* 文件名称: WebConfig.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 下午1:15:47<br/>
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
 * 类描述: TODO<br/>手续费配置表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午1:15:47<br/>
 */
@Entity
@Table(name = "t_web_config")
public class WebConfig implements Serializable {

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
	
	@Column(name = "conf_bank_ratio")
	private Double confBankRatio;//公司入款优惠比例
	
	@Column(name = "conf_bank_dama")
	private Double confBankDama;//赠送彩金比例（在线支付、公司入款、后台入款）
	
	@Column(name = "conf_bank_dama_mul")
	private String confBankDamaMul;//赠送彩金，要求打码量
	
	@Column(name = "conf_withdraw_times")
	private Integer confWithdrawTimes;//免费取款次数

	@Column(name = "conf_withdraw_ratio")
	private Double confWithdrawRatio;//取款手续费比例
	
	@Column(name = "conf_withdraw_administration")
	private Double confWithdrawAdministration;//取款行政费用
	
	@Column(name = "sys_user_name")
	private String sysUserName;//操作人
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间

	@Column(name = "company_min_pay")
	private Double companyMinPay;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public Double getConfBankRatio() {
		return confBankRatio;
	}

	public void setConfBankRatio(Double confBankRatio) {
		this.confBankRatio = confBankRatio;
	}

	public Double getConfBankDama() {
		return confBankDama;
	}

	public void setConfBankDama(Double confBankDama) {
		this.confBankDama = confBankDama;
	}

	public String getConfBankDamaMul() {
		return confBankDamaMul;
	}

	public void setConfBankDamaMul(String confBankDamaMul) {
		this.confBankDamaMul = confBankDamaMul;
	}

	public Integer getConfWithdrawTimes() {
		return confWithdrawTimes;
	}

	public void setConfWithdrawTimes(Integer confWithdrawTimes) {
		this.confWithdrawTimes = confWithdrawTimes;
	}

	public Double getConfWithdrawRatio() {
		return confWithdrawRatio;
	}

	public void setConfWithdrawRatio(Double confWithdrawRatio) {
		this.confWithdrawRatio = confWithdrawRatio;
	}

	public Double getConfWithdrawAdministration() {
		return confWithdrawAdministration;
	}

	public void setConfWithdrawAdministration(Double confWithdrawAdministration) {
		this.confWithdrawAdministration = confWithdrawAdministration;
	}

	public String getSysUserName() {
		return sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
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

	public Double getCompanyMinPay() {
		return companyMinPay;
	}

	public void setCompanyMinPay(Double companyMinPay) {
		this.companyMinPay = companyMinPay;
	}

	public static long getSerialversionuid() {
		return serialVersionUID;
	}
	
}
