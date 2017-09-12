/**   
* 文件名称: WebTestUser.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-8-26 下午1:39:00<br/>
*/  
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

/** 
 * 
 * 试用账号
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-8-26 下午1:39:00<br/>
 */


@Entity
@Table(name = "t_web_test_user")
public class WebTestUser implements java.io.Serializable {

	
 
	private static final long serialVersionUID = 1L;

	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;

	@Column(name = "user_name")
	private String userName;
	
	
	@Column(name = "user_password")
	private String userPassword;
	
	

	@Column(name = "flat_user_name")
	private String flatUserName;
	
	
	@Column(name = "flat_password")
	private String flatPassword;
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "user_last_login_time")
	private Date userLastLoginTime;//创建时间
	
	@Column(name = "user_last_login_ip")
	private String userLastLoginIp;
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间

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

	public String getUserPassword() {
		return userPassword;
	}

	public void setUserPassword(String userPassword) {
		this.userPassword = userPassword;
	}

	public String getFlatUserName() {
		return flatUserName;
	}

	public void setFlatUserName(String flatUserName) {
		this.flatUserName = flatUserName;
	}

	public String getFlatPassword() {
		return flatPassword;
	}

	public void setFlatPassword(String flatPassword) {
		this.flatPassword = flatPassword;
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
	
	
	
	
}
