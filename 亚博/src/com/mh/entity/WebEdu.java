/**   
 * 文件名称: WebEdu.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: Channel<br/>  
 * 创建时间 : 2015-6-30 下午1:26:06<br/>
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
 * 类描述: TODO<br/>
 * 额度转化记录表 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午1:26:06<br/>
 */
@Entity
@Table(name = "t_web_edu")
public class WebEdu implements Serializable {

	/**
	 * @Fields serialVersionUID: TODO
	 */
	private static final long serialVersionUID = 1L;
	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;// 数据库主键

	@Column(name = "flat_name")
	private String flatName;// 平台标识

	@Column(name = "edu_order")
	private String eduOrder;// 会员姓名

	@Column(name = "edu_points")
	private Integer eduPoints;// 转换金额

	@Column(name = "user_name")
	private String userName;// 会员帐号

	@Column(name = "edu_type")
	private Integer eduType;// 转换类型(2-转入,1-转出)

	@Column(name = "edu_status")
	private Integer eduStatus;// 转换状态(1-成功,0-失败)

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "mofidy_time")
	private Date modifyTime;// 修改时间

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;// 创建时间

	@Column(name = "edu_ip")
	private String eduIp;// 用户IP

	@Column(name = "edu_forward")
	private Integer eduForward;// 额度转化方向(11BBIN->主帐号,12MG->主帐号,13AG->主帐号,14188体育->主帐号;21主帐号->BBIN，22主帐号->MG,23主帐号->AG,24主帐号->188体育)

	@Column(name = "edu_forward_remark")
	private String eduForwardRemark;// 额度转化方向备注

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "gmt_4_time")
	private Date gmt4Time;// 美东时间
	
	@Transient
	private String beginDateStr;
	@Transient
	private String endDateStr;
	

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getFlatName() {
		return flatName;
	}

	public void setFlatName(String flatName) {
		this.flatName = flatName;
	}

	public String getEduOrder() {
		return eduOrder;
	}

	public void setEduOrder(String eduOrder) {
		this.eduOrder = eduOrder;
	}

	public Integer getEduPoints() {
		return eduPoints;
	}

	public void setEduPoints(Integer eduPoints) {
		this.eduPoints = eduPoints;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public Integer getEduType() {
		return eduType;
	}

	public void setEduType(Integer eduType) {
		this.eduType = eduType;
	}

	public Integer getEduStatus() {
		return eduStatus;
	}

	public void setEduStatus(Integer eduStatus) {
		this.eduStatus = eduStatus;
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

	public String getEduIp() {
		return eduIp;
	}

	public void setEduIp(String eduIp) {
		this.eduIp = eduIp;
	}

	public Integer getEduForward() {
		return eduForward;
	}

	public void setEduForward(Integer eduForward) {
		this.eduForward = eduForward;
	}

	public String getEduForwardRemark() {
		return eduForwardRemark;
	}

	public void setEduForwardRemark(String eduForwardRemark) {
		this.eduForwardRemark = eduForwardRemark;
	}

	public Date getGmt4Time() {
		return gmt4Time;
	}

	public void setGmt4Time(Date gmt4Time) {
		this.gmt4Time = gmt4Time;
	}

	public String getBeginDateStr() {
		return beginDateStr;
	}

	public void setBeginDateStr(String beginDateStr) {
		this.beginDateStr = beginDateStr;
	}

	public String getEndDateStr() {
		return endDateStr;
	}

	public void setEndDateStr(String endDateStr) {
		this.endDateStr = endDateStr;
	}

 
	
	
	

}
