/**   
* 文件名称: WebAgentPoundage.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 上午10:49:03<br/>
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
 * 类描述: TODO<br/>代理手续费配置表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 上午10:49:03<br/>
 */
@Entity
@Table(name = "t_web_agent_poundage")
public class WebAgentPoundage implements java.io.Serializable {

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
	
	@Column(name = "pd_xz")
	private String pdXz;//行政费用比例
	
	@Column(name = "pd_in")
	private String pdIn;//入款手续费比例
	
	@Column(name = "pd_in_max")
	private String pdInMax;//入款手续费上限
	
	@Column(name = "pd_out")
	private Integer pdOut;//出款手续费比例

	@Column(name = "pd_out_max")
	private String pdOutMax;//出款手续费上限
	
	@Column(name = "pd_activity")
	private String pdActivity;//活动赠送
	
	@Column(name = "opt_sys_user")
	private String optSysUser;//操作人
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间


	public Integer getId() {
		return id;
	}


	public void setId(Integer id) {
		this.id = id;
	}


	public String getPdXz() {
		return pdXz;
	}


	public void setPdXz(String pdXz) {
		this.pdXz = pdXz;
	}


	public String getPdIn() {
		return pdIn;
	}


	public void setPdIn(String pdIn) {
		this.pdIn = pdIn;
	}


	public String getPdInMax() {
		return pdInMax;
	}


	public void setPdInMax(String pdInMax) {
		this.pdInMax = pdInMax;
	}


	public Integer getPdOut() {
		return pdOut;
	}


	public void setPdOut(Integer pdOut) {
		this.pdOut = pdOut;
	}


	public String getPdOutMax() {
		return pdOutMax;
	}


	public void setPdOutMax(String pdOutMax) {
		this.pdOutMax = pdOutMax;
	}


	public String getPdActivity() {
		return pdActivity;
	}


	public void setPdActivity(String pdActivity) {
		this.pdActivity = pdActivity;
	}


	public String getOptSysUser() {
		return optSysUser;
	}


	public void setOptSysUser(String optSysUser) {
		this.optSysUser = optSysUser;
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


	public static long getSerialversionuid() {
		return serialVersionUID;
	}
	
	
}
