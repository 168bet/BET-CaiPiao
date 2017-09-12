/**   
* 文件名称: WebBankCode.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-1 下午4:09:05<br/>
*/  
package com.mh.entity;

import java.io.Serializable;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

/** 
 * 
 * 银行代码
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-1 下午4:09:05<br/>
 */

@Entity
@Table(name = "t_web_bankcode")
public class WebBankCode  implements Serializable {
	
 
	private static final long serialVersionUID = 1L;

	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "id", nullable = false)
	private Integer id;//数据库主键
	
	@Column(name = "bank_code")
	private String bankCode;//银行代码
	
	
	@Column(name = "bank_name")
	private String bankName;//银行名称
	
	
	@Column(name = "is_enable")
	private Integer isEnable;//是否启用0禁用1启用


	public Integer getId() {
		return id;
	}


	public void setId(Integer id) {
		this.id = id;
	}


	public String getBankCode() {
		return bankCode;
	}


	public void setBankCode(String bankCode) {
		this.bankCode = bankCode;
	}


	public String getBankName() {
		return bankName;
	}


	public void setBankName(String bankName) {
		this.bankName = bankName;
	}


	public Integer getIsEnable() {
		return isEnable;
	}


	public void setIsEnable(Integer isEnable) {
		this.isEnable = isEnable;
	}
	
	
	

}
