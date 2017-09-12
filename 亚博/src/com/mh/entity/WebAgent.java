/**   
* 文件名称: WebAgent.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 上午10:24:04<br/>
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
 * 类描述: TODO<br/>代理表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 上午10:24:04<br/>
 */
@Entity
@Table(name = "t_web_agent")
public class WebAgent implements java.io.Serializable {

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
	
	@Column(name = "agent_no")
	private String agentNo;//代ID
	
	@Column(name = "user_name")
	private String userName;//会员编号
	
	@Column(name = "user_real_name")
	private String userRealName;//会员姓名
	
	@Column(name = "status")
	private Integer status;//状态

	@Column(name = "agent_url")
	private String agentUrl;//推广地址
	
	@Column(name = "agent_domain")
	private String agentDomain;//推广域名
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Column(name = "count")
	private Integer count;//会员数

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "settledTime")
	private Date settledTime;//已结算日期
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "gmt4_time")
	private Date gmt4Time;//美东时间
	
	@Column(name = "agent_mail")
	private String agentMail;//邮箱
	
	@Column(name = "remark")
	private String remark;//备注
	
	@Column(name = "content")
	private String content;//申请理由
	
	@Column(name = "pre_agent_no")
	private String preAgentNo;//上层代理ID
	
	@Column(name = "sys_user_name")
	private String sysUserName;//操作者
	
	@Column(name = "check_status")
	private Integer checkStatus;//审核状态
	
	@Column(name = "agent_type")
	private Integer agentType;//1退佣类型2退水类型
	
	
	@Transient
	private String beginTimeStr;
	@Transient
	private String endTimeStr;
	@Transient
	private String platName;
	

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getAgentNo() {
		return agentNo;
	}

	public void setAgentNo(String agentNo) {
		this.agentNo = agentNo;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getUserRealName() {
		return userRealName;
	}

	public void setUserRealName(String userRealName) {
		this.userRealName = userRealName;
	}

	public Integer getStatus() {
		return status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	public String getAgentUrl() {
		return agentUrl;
	}

	public void setAgentUrl(String agentUrl) {
		this.agentUrl = agentUrl;
	}

	public String getAgentDomain() {
		return agentDomain;
	}

	public void setAgentDomain(String agentDomain) {
		this.agentDomain = agentDomain;
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

	public Integer getCount() {
		return count;
	}

	public void setCount(Integer count) {
		this.count = count;
	}

	public Date getSettledTime() {
		return settledTime;
	}

	public void setSettledTime(Date settledTime) {
		this.settledTime = settledTime;
	}

	public Date getGmt4Time() {
		return gmt4Time;
	}

	public void setGmt4Time(Date gmt4Time) {
		this.gmt4Time = gmt4Time;
	}

	public String getAgentMail() {
		return agentMail;
	}

	public void setAgentMail(String agentMail) {
		this.agentMail = agentMail;
	}

	public String getRemark() {
		return remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	public String getContent() {
		return content;
	}

	public void setContent(String content) {
		this.content = content;
	}

	public String getPreAgentNo() {
		return preAgentNo;
	}

	public void setPreAgentNo(String preAgentNo) {
		this.preAgentNo = preAgentNo;
	}

	public String getSysUserName() {
		return sysUserName;
	}

	public void setSysUserName(String sysUserName) {
		this.sysUserName = sysUserName;
	}

	public Integer getCheckStatus() {
		return checkStatus;
	}

	public void setCheckStatus(Integer checkStatus) {
		this.checkStatus = checkStatus;
	}

	public Integer getAgentType() {
		return agentType;
	}

	public void setAgentType(Integer agentType) {
		this.agentType = agentType;
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

	public String getPlatName() {
		return platName;
	}

	public void setPlatName(String platName) {
		this.platName = platName;
	}

	
	
}
