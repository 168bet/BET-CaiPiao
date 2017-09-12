/**   
* 文件名称: WebWateRecord.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-7-1 上午9:52:44<br/>
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
 * 类描述: TODO<br/>返水记录表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-7-1 上午9:52:44<br/>
 */
@Entity
@Table(name = "t_web_water")
public class WebWateRecord implements Serializable {

	/** 
	 * @Fields serialVersionUID: TODO 
	 */ 
	private static final long serialVersionUID = 1L;
	
	
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;//数据库主键
	
	@Column(name = "flag_name")
	private String flagName;//平台

	@Column(name = "user_name")
	private String userName;//会员帐号
	

	@Column(name = "water_type")
	private Integer waterType;//返水类型 1投注返点 2上下级返点
	
	@Column(name = "back_money")
	private Double backMoney;//返水的金额

	@Column(name = "sys_user_name")
	private String syUserName;//操作人

	@Column(name = "remark")
	private String remark;//备注
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "gmt_4_time")
	private Date gmt4Time;//美东时间
	
	@Transient
	private String relativePath;
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

	public String getFlagName() {
		return flagName;
	}

	public void setFlagName(String flagName) {
		this.flagName = flagName;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public Double getBackMoney() {
		return backMoney;
	}

	public void setBackMoney(Double backMoney) {
		this.backMoney = backMoney;
	}

	public String getSyUserName() {
		return syUserName;
	}

	public void setSyUserName(String syUserName) {
		this.syUserName = syUserName;
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

	public Date getGmt4Time() {
		return gmt4Time;
	}

	public void setGmt4Time(Date gmt4Time) {
		this.gmt4Time = gmt4Time;
	}

	public Integer getWaterType() {
		return waterType;
	}

	public void setWaterType(Integer waterType) {
		this.waterType = waterType;
	}

	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
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
