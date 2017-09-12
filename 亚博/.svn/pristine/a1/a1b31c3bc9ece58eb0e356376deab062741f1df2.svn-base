/**   
* 文件名称: WebAgentTuiyong.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 上午11:06:53<br/>
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
 * 类描述: TODO<br/>退佣配置表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 上午11:06:53<br/>
 */
@Entity
@Table(name = "t_web_agent_tuiyong")
public class WebAgentTuiyong implements Serializable {

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
		
		@Column(name = "ty_begin")
		private Integer tyBegin;//输赢起始金额

		@Column(name = "ty_end")
		private Integer tyEnd;//输赢结束金额
		
		@Column(name = "ty_valid")
		private String tyValid;//有效会员
		
		@Column(name = "ty_sport")
		private String tySport;//皇冠体育退佣比例
				
		@Column(name = "ty_caipiao")
		private String tyCaipiao;//彩票退佣比例
		
		@Column(name = "ty_ag")
		private Integer tyAg;//AG退佣比例

		@Column(name = "ty_bbin")
		private String tyBbin;//BBIN退佣比例
		
		@Column(name = "ty_jbb")
		private String tyJbb;//188体育

		@Column(name = "ty_mg")
		private String tyMg;//MG退佣比例
		
		@Column(name = "ty_hg")
		private String tyHg;//HG退佣比例
		
		@Column(name = "ty_ds")
		private String tyDs;//DS退佣比例
		
		@Column(name = "ty_nt")
		private String tyNt;//NT退佣比例
		
		@Column(name = "ty_pt")
		private String tyPt;//PT退佣比例
		
		@Column(name="ty_douji")
		private String tyDouji;//斗鸡退佣比例
		
		@Column(name="ty_ab")
		private String tyAb;//AB退水比例
		
		@Column(name="ty_og")
		private String tyOg;//OG退水比例
		
		@Column(name="ty_os")
		private String tyOs;//OS退水比例
		
		@Column(name="ty_sb")
		private String tySb;//SB退水比例
		
		@Column(name="ty_gd")
		private String tyGd;//GD退水比例
		
		@Column(name="ty_ttg")
		private String tyTtg;//TTG退水比例
		
		@Column(name="ty_sbt")
		private String tySbt;//SBT退水比例
		
		@Column(name="ty_sa")
		private String tySa;//SA退水比例
		
		@Column(name = "opt_sys_user")
		private String optSysUser;//操作人
		
		@Temporal(TemporalType.TIMESTAMP)
		@Column(name = "modify_time")
		private Date modifyTime;//修改时间
		
		
		@Temporal(TemporalType.TIMESTAMP)
		@Column(name = "create_time")
		private Date createTime;//创建时间
		
		@Column(name="ty_type")//退佣类型
		private Integer tyType;


		public Integer getId() {
			return id;
		}


		public void setId(Integer id) {
			this.id = id;
		}


		public Integer getTyBegin() {
			return tyBegin;
		}


		public void setTyBegin(Integer tyBegin) {
			this.tyBegin = tyBegin;
		}


		public Integer getTyEnd() {
			return tyEnd;
		}


		public void setTyEnd(Integer tyEnd) {
			this.tyEnd = tyEnd;
		}


		public String getTyValid() {
			return tyValid;
		}


		public void setTyValid(String tyValid) {
			this.tyValid = tyValid;
		}


		public String getTySport() {
			return tySport;
		}


		public void setTySport(String tySport) {
			this.tySport = tySport;
		}


		public String getTyCaipiao() {
			return tyCaipiao;
		}


		public void setTyCaipiao(String tyCaipiao) {
			this.tyCaipiao = tyCaipiao;
		}


		public Integer getTyAg() {
			return tyAg;
		}


		public void setTyAg(Integer tyAg) {
			this.tyAg = tyAg;
		}


		public String getTyBbin() {
			return tyBbin;
		}


		public void setTyBbin(String tyBbin) {
			this.tyBbin = tyBbin;
		}


		public String getTyJbb() {
			return tyJbb;
		}


		public void setTyJbb(String tyJbb) {
			this.tyJbb = tyJbb;
		}


		public String getTyMg() {
			return tyMg;
		}


		public void setTyMg(String tyMg) {
			this.tyMg = tyMg;
		}


		public String getTyHg() {
			return tyHg;
		}


		public void setTyHg(String tyHg) {
			this.tyHg = tyHg;
		}


		public String getTyDs() {
			return tyDs;
		}


		public void setTyDs(String tyDs) {
			this.tyDs = tyDs;
		}


		public String getTyNt() {
			return tyNt;
		}


		public void setTyNt(String tyNt) {
			this.tyNt = tyNt;
		}


		public String getTyPt() {
			return tyPt;
		}


		public void setTyPt(String tyPt) {
			this.tyPt = tyPt;
		}
		
		public String getTyDouji() {
			return tyDouji;
		}


		public void setTyDouji(String tyDouji) {
			this.tyDouji = tyDouji;
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

		public Integer getTyType() {
			return tyType;
		}


		public void setTyType(Integer tyType) {
			this.tyType = tyType;
		}

		public static long getSerialversionuid() {
			return serialVersionUID;
		}


		public String getTyAb() {
			return tyAb;
		}


		public void setTyAb(String tyAb) {
			this.tyAb = tyAb;
		}


		public String getTyOg() {
			return tyOg;
		}


		public void setTyOg(String tyOg) {
			this.tyOg = tyOg;
		}


		public String getTyOs() {
			return tyOs;
		}


		public void setTyOs(String tyOs) {
			this.tyOs = tyOs;
		}


		public String getTySb() {
			return tySb;
		}


		public void setTySb(String tySb) {
			this.tySb = tySb;
		}


		public String getTyGd() {
			return tyGd;
		}


		public void setTyGd(String tyGd) {
			this.tyGd = tyGd;
		}


		public String getTyTtg() {
			return tyTtg;
		}


		public void setTyTtg(String tyTtg) {
			this.tyTtg = tyTtg;
		}


		public String getTySbt() {
			return tySbt;
		}


		public void setTySbt(String tySbt) {
			this.tySbt = tySbt;
		}


		public String getTySa() {
			return tySa;
		}


		public void setTySa(String tySa) {
			this.tySa = tySa;
		}
}
