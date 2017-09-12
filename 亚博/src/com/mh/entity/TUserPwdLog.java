/**   
* 文件名称: TUserPwdLog.java<br/>
* 版本号: V1.0<br/>   
* 创建人: zoro<br/>  
* 创建时间 : 2015-9-23 上午1:09:11<br/>
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
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-9-23 上午1:09:11<br/>
 */
@Entity
@Table(name = "t_user_pwd_log")
public class TUserPwdLog implements Serializable{

	/** 
	 * @Fields serialVersionUID: TODO 
	 */ 
	private static final long serialVersionUID = 1L;
	
	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;
	
	@Column(name="user_name")
	private String userName;
	
	@Column(name="old_password")
	private String oldPassword;
	
	@Column(name="new_password")
	private String newPassword;
	
	@Column(name="ip")
	private String ip;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "update_time")
	private Date updateTime;
	
	@Column(name="remark")
	private String remark;

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

	public String getOldPassword() {
		return oldPassword;
	}

	public void setOldPassword(String oldPassword) {
		this.oldPassword = oldPassword;
	}

	public String getNewPassword() {
		return newPassword;
	}

	public void setNewPassword(String newPassword) {
		this.newPassword = newPassword;
	}

	public String getIp() {
		return ip;
	}

	public void setIp(String ip) {
		this.ip = ip;
	}

	public Date getUpdateTime() {
		return updateTime;
	}

	public void setUpdateTime(Date updateTime) {
		this.updateTime = updateTime;
	}

	public String getRemark() {
		return remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}
	
}
