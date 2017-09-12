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
 * 快捷支付
 * @author Administrator
 *
 */
@Entity
@Table(name = "t_web_kj_pay")
public class WebKjPay implements Serializable 
{
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * id
	 */
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "id", nullable = false)
	private Integer id;
	
	/**
	 * 支付类型
	 */
	@Column(name = "pay_type")
	private Integer payType;
	
	
	/**
	 * 收款方昵称
	 */
	@Column(name = "pay_nname")
	private String payNname;
	
	/**
	 * 收款方真实姓名
	 */
	@Column(name = "pay_rname")
	private String payRname;
	
	
	/**
	 * 二维码字节
	 */
	@Column(name = "pay_pic")
	private byte [] img;
	
	@Column(name = "status")
	private Integer status;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;
	
	@Column(name = "pay_no")
	private String payNo;//存款账户编号

	public Integer getStatus() {
		return status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	public Date getModifyTime() {
		return modifyTime;
	}

	public void setModifyTime(Date modifyTime) {
		this.modifyTime = modifyTime;
	}

	public byte[] getImg() {
		return img;
	}

	public void setImg(byte[] img) {
		this.img = img;
	}

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}



	public Integer getPayType() {
		return payType;
	}

	public void setPayType(Integer payType) {
		this.payType = payType;
	}

	public String getPayNname() {
		return payNname;
	}

	public void setPayNname(String payNname) {
		this.payNname = payNname;
	}

	public String getPayRname() {
		return payRname;
	}

	public void setPayRname(String payRname) {
		this.payRname = payRname;
	}

	public String getPayNo() {
		return payNo;
	}

	public void setPayNo(String payNo) {
		this.payNo = payNo;
	}
		
	
	
	
}
