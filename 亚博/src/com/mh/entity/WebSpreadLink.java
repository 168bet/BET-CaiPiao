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
@Entity
@Table(name = "t_web_spreadlink")
public class WebSpreadLink implements java.io.Serializable{
	private static final long serialVersionUID = 1L;
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;
	
	
	@Column(name = "user_name")
	private String userName;
	//上级账号
	@Column(name = "parent_no")
	private String parentNo;
	//注册人数
	@Column(name = "reg_num")
	private Integer regNum;
	//可用点数
	@Column(name = "total")
	private Integer total;
	//是否代理 0会员1代理
	@Column(name = "is_agent")
	private Integer isAgent;
	//PC28返点
	@Column(name = "pc28_point")
	private Double pc28Point;
	//彩票返点
	@Column(name = "cp_point")
	private Double cpPoint;
	//使用状态 0未使用1已使用-1撤销
	@Column(name = "status")
	private Integer status;
	//创建时间
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	
	//推广链接
	@Column(name = "spread_link")
	private String spreadLink;
	
	
	@Column(name = "short_link")
	private String shortLink;
	
	//有效时间
	@Column(name = "effect_time")
	private  String effectTime;
	//注册代码
	@Column(name = "reg_code")
	private String regCode;
	
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
	public String getParentNo() {
		return parentNo;
	}
	public void setParentNo(String parentNo) {
		this.parentNo = parentNo;
	}
	public Integer getRegNum() {
		return regNum;
	}
	public void setRegNum(Integer regNum) {
		this.regNum = regNum;
	}
	public Integer getTotal() {
		return total;
	}
	public void setTotal(Integer total) {
		this.total = total;
	}
	public Integer getIsAgent() {
		return isAgent;
	}
	public void setIsAgent(Integer isAgent) {
		this.isAgent = isAgent;
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
	public Date getCreateTime() {
		return createTime;
	}
	public void setCreateTime(Date createTime) {
		this.createTime = createTime;
	}
	public String getSpreadLink() {
		return spreadLink;
	}
	public void setSpreadLink(String spreadLink) {
		this.spreadLink = spreadLink;
	}
	public String getEffectTime() {
		return effectTime;
	}
	public void setEffectTime(String effectTime) {
		this.effectTime = effectTime;
	}
	public String getRegCode() {
		return regCode;
	}
	public void setRegCode(String regCode) {
		this.regCode = regCode;
	}
	
	
	
	public String getShortLink() {
		return shortLink;
	}
	public void setShortLink(String shortLink) {
		this.shortLink = shortLink;
	}
	public String toString() {
		return "webSpreadLink [id=" + id + ", userName=" + userName
				+ ", parentNo=" + parentNo + ", regNum=" + regNum + ", total="
				+ total + ", isAgent=" + isAgent + ", pc28Point=" + pc28Point
				+ ", cpPoint=" + cpPoint + ", status=" + status
				+ ", createTime=" + createTime + ", modifyTime=" + modifyTime
				+ ", spreadLink=" + spreadLink + ", effectTime=" + effectTime
				+ ", regCode=" + regCode + "]";
	}
	
	
}
