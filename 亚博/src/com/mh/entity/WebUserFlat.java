/**   
* 文件名称: WebUserFlat.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 下午2:51:27<br/>
*/  
package com.mh.entity;

import java.io.Serializable;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Transient;

/** 
 * 类描述: TODO<br/>平台用户表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午2:51:27<br/>
 */

@Entity
@Table(name = "t_web_user_flat")
public class WebUserFlat implements Serializable {

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

	@Column(name = "user_flag")
	private String userFlag;//用户标识（哪个网站的）
	
	@Column(name = "user_name")
	private String userName;

	@Column(name = "mg_user_name")
	private String mgUserName;
	
	@Column(name="mg_id")
	private String mgId;
	
	@Column(name = "mg_password")
	private String mgPassword;
	
	@Column(name = "mg_status")
	private Integer mgStatus;
	
	@Column(name = "bbin_user_name")
	private String bbinUserName;
	
	@Column(name = "bbin_status")
	private Integer bbinStatus;
	
	@Column(name = "jbb_user_name")
	private String jbbUserName;
	
	@Column(name = "jbb_status")
	private Integer jbbStatus;
	
	@Column(name = "ag_user_name")
	private String agUserName;
	
	@Column(name = "ag_status")
	private Integer agStatus;
	
	@Column(name = "ag_password")
	private String agPassword;
	
	@Column(name = "kg_user_name")
	private String kgUserName;
	
	@Column(name = "kg_status")
	private Integer kgStatus;
	
	@Column(name = "ds_user_name")
	private String dsUserName;
	
	@Column(name = "ds_status")
	private Integer dsStatus;
	
	@Column(name = "ds_password")
	private String dsPassword;
	
	@Column(name = "hg_user_name")
	private String hgUserName;
	
	@Column(name = "hg_status")
	private Integer hgStatus;
	
	@Column(name = "hg_password")
	private String hgPassword;
	
	@Column(name = "nt_user_name")
	private String ntUserName;
	
	@Column(name = "nt_status")
	private Integer ntStatus;
	
	@Column(name = "nt_password")
	private String ntPassword;
	
	@Column(name = "pt_user_name")
	private String ptUserName;
	
	@Column(name = "pt_status")
	private Integer ptStatus;
	
	@Column(name = "pt_password")
	private String ptPassword;
	
	@Column(name = "dj_user_name")
	private String djUserName;
	
	@Column(name = "dj_status")
	private Integer djStatus;
	
	@Column(name = "dj_password")
	private String djPassword;
	
	@Column(name = "ab_user_name")
	private String abUserName;
	
	@Column(name = "ab_status")
	private Integer abStatus;
	
	@Column(name = "ab_password")
	private String abPassword;
	
	@Column(name = "og_user_name")
	private String ogUserName;
	
	@Column(name = "og_status")
	private Integer ogStatus;
	
	@Column(name = "og_password")
	private String ogPassword;
	
	@Column(name = "os_user_name")
	private String osUserName;
	
	@Column(name = "os_status")
	private Integer osStatus;
	
	@Column(name = "os_password")
	private String osPassword;
	
	@Column(name = "sb_user_name")
	private String sbUserName;
	
	@Column(name = "sb_status")
	private Integer sbStatus;
	
	@Column(name = "gd_user_name")
	private String gdUserName;
	
	@Column(name = "gd_status")
	private Integer gdStatus;
	
	@Column(name = "user_agent")
	private String userAgent;//所属代理
	
	@Column(name = "mine_agent")
	private String mineAgent;//自己代理号
	
	@Column(name = "ttg_user_name")
	private String ttgUserName;
	
	@Column(name = "ttg_status")
	private Integer ttgStatus;
	
	@Column(name = "sbt_user_name")
	private String sbtUserName;
	
	@Column(name = "sbt_status")
	private Integer sbtStatus;
	
	@Column(name = "newnt_user_name")
	private String newNtUserName;
	@Column(name = "newnt_key")
	private String newNtKey;
	@Column(name = "newnt_status")
	private Integer newNtStatus;
	
	@Transient
	private int returnCode; //返回代码
	@Transient
	private String returnDesc; //返回描述
	@Column(name = "sa_user_name")
	private String saUserName;
	@Column(name = "sa_status")
    private Integer saStatus;
	
	@Column(name = "vg_user_name")
	private String vgUserName;
    
	@Column(name = "vg_status")
    private Integer vgStatus;
	

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getUserFlag() {
		return userFlag;
	}

	public void setUserFlag(String userFlag) {
		this.userFlag = userFlag;
	}

	public String getMgUserName() {
		return mgUserName;
	}

	public void setMgUserName(String mgUserName) {
		this.mgUserName = mgUserName;
	}
	
	public String getMgId() {
		return mgId;
	}

	public void setMgId(String mgId) {
		this.mgId = mgId;
	}

	public String getMgPassword() {
		return mgPassword;
	}

	public void setMgPassword(String mgPassword) {
		this.mgPassword = mgPassword;
	}

	public Integer getMgStatus() {
		return mgStatus;
	}

	public void setMgStatus(Integer mgStatus) {
		this.mgStatus = mgStatus;
	}

	public String getBbinUserName() {
		return bbinUserName;
	}

	public void setBbinUserName(String bbinUserName) {
		this.bbinUserName = bbinUserName;
	}

	public Integer getBbinStatus() {
		return bbinStatus;
	}

	public void setBbinStatus(Integer bbinStatus) {
		this.bbinStatus = bbinStatus;
	}

	public String getJbbUserName() {
		return jbbUserName;
	}

	public void setJbbUserName(String jbbUserName) {
		this.jbbUserName = jbbUserName;
	}

	public Integer getJbbStatus() {
		return jbbStatus;
	}

	public void setJbbStatus(Integer jbbStatus) {
		this.jbbStatus = jbbStatus;
	}

	public String getAgUserName() {
		return agUserName;
	}

	public void setAgUserName(String agUserName) {
		this.agUserName = agUserName;
	}

	public Integer getAgStatus() {
		return agStatus;
	}

	public void setAgStatus(Integer agStatus) {
		this.agStatus = agStatus;
	}

	public String getAgPassword() {
		return agPassword;
	}

	public void setAgPassword(String agPassword) {
		this.agPassword = agPassword;
	}

	public String getKgUserName() {
		return kgUserName;
	}

	public void setKgUserName(String kgUserName) {
		this.kgUserName = kgUserName;
	}

	public Integer getKgStatus() {
		return kgStatus;
	}

	public void setKgStatus(Integer kgStatus) {
		this.kgStatus = kgStatus;
	}

	public String getDsUserName() {
		return dsUserName;
	}

	public void setDsUserName(String dsUserName) {
		this.dsUserName = dsUserName;
	}

	public Integer getDsStatus() {
		return dsStatus;
	}

	public void setDsStatus(Integer dsStatus) {
		this.dsStatus = dsStatus;
	}

	public String getDsPassword() {
		return dsPassword;
	}

	public void setDsPassword(String dsPassword) {
		this.dsPassword = dsPassword;
	}

	public String getHgUserName() {
		return hgUserName;
	}

	public void setHgUserName(String hgUserName) {
		this.hgUserName = hgUserName;
	}

	public Integer getHgStatus() {
		return hgStatus;
	}

	public void setHgStatus(Integer hgStatus) {
		this.hgStatus = hgStatus;
	}

	public String getHgPassword() {
		return hgPassword;
	}

	public void setHgPassword(String hgPassword) {
		this.hgPassword = hgPassword;
	}

	public String getNtUserName() {
		return ntUserName;
	}

	public void setNtUserName(String ntUserName) {
		this.ntUserName = ntUserName;
	}

	public Integer getNtStatus() {
		return ntStatus;
	}

	public void setNtStatus(Integer ntStatus) {
		this.ntStatus = ntStatus;
	}

	public String getNtPassword() {
		return ntPassword;
	}

	public void setNtPassword(String ntPassword) {
		this.ntPassword = ntPassword;
	}

	public String getPtUserName() {
		return ptUserName;
	}

	public void setPtUserName(String ptUserName) {
		this.ptUserName = ptUserName;
	}

	public Integer getPtStatus() {
		return ptStatus;
	}

	public void setPtStatus(Integer ptStatus) {
		this.ptStatus = ptStatus;
	}

	public String getPtPassword() {
		return ptPassword;
	}

	public void setPtPassword(String ptPassword) {
		this.ptPassword = ptPassword;
	}
	
	public String getDjUserName() {
		return djUserName;
	}

	public void setDjUserName(String djUserName) {
		this.djUserName = djUserName;
	}

	public Integer getDjStatus() {
		return djStatus;
	}

	public void setDjStatus(Integer djStatus) {
		this.djStatus = djStatus;
	}

	public String getDjPassword() {
		return djPassword;
	}

	public void setDjPassword(String djPassword) {
		this.djPassword = djPassword;
	}
	

	public String getAbUserName() {
		return abUserName;
	}

	public void setAbUserName(String abUserName) {
		this.abUserName = abUserName;
	}

	public Integer getAbStatus() {
		return abStatus;
	}

	public void setAbStatus(Integer abStatus) {
		this.abStatus = abStatus;
	}

	public String getAbPassword() {
		return abPassword;
	}

	public void setAbPassword(String abPassword) {
		this.abPassword = abPassword;
	}

	public String getOgUserName() {
		return ogUserName;
	}

	public void setOgUserName(String ogUserName) {
		this.ogUserName = ogUserName;
	}

	public Integer getOgStatus() {
		return ogStatus;
	}

	public void setOgStatus(Integer ogStatus) {
		this.ogStatus = ogStatus;
	}

	public String getOgPassword() {
		return ogPassword;
	}

	public void setOgPassword(String ogPassword) {
		this.ogPassword = ogPassword;
	}
	

	public String getOsUserName() {
		return osUserName;
	}

	public void setOsUserName(String osUserName) {
		this.osUserName = osUserName;
	}

	public Integer getOsStatus() {
		return osStatus;
	}

	public void setOsStatus(Integer osStatus) {
		this.osStatus = osStatus;
	}

	public String getOsPassword() {
		return osPassword;
	}

	public void setOsPassword(String osPassword) {
		this.osPassword = osPassword;
	}
	
	public String getSbUserName() {
		return sbUserName;
	}

	public void setSbUserName(String sbUserName) {
		this.sbUserName = sbUserName;
	}

	public Integer getSbStatus() {
		return sbStatus;
	}

	public void setSbStatus(Integer sbStatus) {
		this.sbStatus = sbStatus;
	}

	public String getGdUserName() {
		return gdUserName;
	}

	public void setGdUserName(String gdUserName) {
		this.gdUserName = gdUserName;
	}

	public Integer getGdStatus() {
		return gdStatus;
	}

	public void setGdStatus(Integer gdStatus) {
		this.gdStatus = gdStatus;
	}

	public String getUserAgent() {
		return userAgent;
	}

	public void setUserAgent(String userAgent) {
		this.userAgent = userAgent;
	}

	public String getMineAgent() {
		return mineAgent;
	}

	public void setMineAgent(String mineAgent) {
		this.mineAgent = mineAgent;
	}

	public static long getSerialversionuid() {
		return serialVersionUID;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public int getReturnCode() {
		return returnCode;
	}

	public void setReturnCode(int returnCode) {
		this.returnCode = returnCode;
	}

	public String getReturnDesc() {
		return returnDesc;
	}

	public void setReturnDesc(String returnDesc) {
		this.returnDesc = returnDesc;
	}

	public String getTtgUserName() {
		return ttgUserName;
	}

	public void setTtgUserName(String ttgUserName) {
		this.ttgUserName = ttgUserName;
	}

	public Integer getTtgStatus() {
		return ttgStatus;
	}

	public void setTtgStatus(Integer ttgStatus) {
		this.ttgStatus = ttgStatus;
	}

	public String getSbtUserName() {
		return sbtUserName;
	}

	public void setSbtUserName(String sbtUserName) {
		this.sbtUserName = sbtUserName;
	}

	public Integer getSbtStatus() {
		return sbtStatus;
	}

	public void setSbtStatus(Integer sbtStatus) {
		this.sbtStatus = sbtStatus;
	}

	public String getNewNtUserName() {
		return newNtUserName;
	}

	public void setNewNtUserName(String newNtUserName) {
		this.newNtUserName = newNtUserName;
	}

	public String getNewNtKey() {
		return newNtKey;
	}

	public void setNewNtKey(String newNtKey) {
		this.newNtKey = newNtKey;
	}

	public Integer getNewNtStatus() {
		return newNtStatus;
	}

	public void setNewNtStatus(Integer newNtStatus) {
		this.newNtStatus = newNtStatus;
	}

	public String getSaUserName() {
		return saUserName;
	}

	public void setSaUserName(String saUserName) {
		this.saUserName = saUserName;
	}

	public Integer getSaStatus() {
		return saStatus;
	}

	public void setSaStatus(Integer saStatus) {
		this.saStatus = saStatus;
	}

	public String getVgUserName() {
		return vgUserName;
	}

	public void setVgUserName(String vgUserName) {
		this.vgUserName = vgUserName;
	}

	public Integer getVgStatus() {
		return vgStatus;
	}

	public void setVgStatus(Integer vgStatus) {
		this.vgStatus = vgStatus;
	}
	
}
