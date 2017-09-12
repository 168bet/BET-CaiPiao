/**   
* 文件名称: sysParameter.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-17 下午1:17:40<br/>
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
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-17 下午1:17:40<br/>
 */

@Entity
@Table(name = "t_sys_parameter")
public class SysParameter implements java.io.Serializable {

 
	private static final long serialVersionUID = 1L;


	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "param_id", nullable = false)
	private Integer id;
	
	
	@Column(name = "param_name")
	private String paramName;// 参数名
	
	@Column(name = "param_value")
	private String paramValue;//参数值
	
	@Column(name = "param_contents")
	private String paramContents; 
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "param_create_time")
	private Date createTime;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "param_modify_time")
	private Date modifyTime;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getParamName() {
		return paramName;
	}

	public void setParamName(String paramName) {
		this.paramName = paramName;
	}

	public String getParamValue() {
		return paramValue;
	}

	public void setParamValue(String paramValue) {
		this.paramValue = paramValue;
	}

	public String getParamContents() {
		return paramContents;
	}

	public void setParamContents(String paramContents) {
		this.paramContents = paramContents;
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
