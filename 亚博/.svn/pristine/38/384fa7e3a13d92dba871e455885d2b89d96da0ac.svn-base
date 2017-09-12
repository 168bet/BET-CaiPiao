/**   
* 文件名称: WebAgentLog.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-8-29 上午2:40:02<br/>
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
import javax.persistence.Transient;

/** 
 * 
 * 代理日志
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-8-29 上午2:40:02<br/>
 */

@Entity
@Table(name = "t_web_agent_log")
public class WebAgentLog implements java.io.Serializable {
	
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
	
	
	@Column(name = "log_type")
	private String logType;//日志类型(1总代理、2代理线)
	
	@Column(name = "log_name")
	private String logName;//日志类别名称（登录、添加等）
	
	@Column(name = "log_content")
	private String logContent;//日志详情
	
	
	@Column(name = "opt_ip")
	private String optIp;//操作时所在ip
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "opt_time")
	private Date optTime;//操作时间

	
	@Column(name = "opt_user")
	private String optUser;//操作者

	@Column(name = "opt_target")
	private String optTarget;//操作目标
	
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

	public String getLogType() {
		return logType;
	}

	public void setLogType(String logType) {
		this.logType = logType;
	}

	public String getLogName() {
		return logName;
	}

	public void setLogName(String logName) {
		this.logName = logName;
	}

	public String getLogContent() {
		return logContent;
	}

	public void setLogContent(String logContent) {
		this.logContent = logContent;
	}

	public String getOptIp() {
		return optIp;
	}

	public void setOptIp(String optIp) {
		this.optIp = optIp;
	}

	public Date getOptTime() {
		return optTime;
	}

	public void setOptTime(Date optTime) {
		this.optTime = optTime;
	}

	public String getOptUser() {
		return optUser;
	}

	public void setOptUser(String optUser) {
		this.optUser = optUser;
	}

	public String getOptTarget() {
		return optTarget;
	}

	public void setOptTarget(String optTarget) {
		this.optTarget = optTarget;
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
