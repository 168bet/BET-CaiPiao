/**   
* 文件名称: WebUserLog.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 下午3:09:28<br/>
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
 * 类描述: TODO<br/>用户登录记录表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午3:09:28<br/>
 */
 @Entity
 @Table(name = "t_web_user_log")
public class WebUserLog implements Serializable {

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
		
		@Column(name = "log_web_flag")
		private String logWebFlag;//网站标识
		
		@Column(name = "log_web_user_name")
		private String logWebUserName;//帐号
		
		@Column(name = "log_web_domain")
		private String logWebDomain;//登录域名
		
		@Column(name = "log_address")
		private String logAddress;//登录地址
		
		@Temporal(TemporalType.TIMESTAMP)
		@Column(name = "create_time")
		private Date createTime;//创建时间
		
		@Column(name = "log_web_name")
		private String logWebName;//网站名称

		public Integer getId() {
			return id;
		}

		public void setId(Integer id) {
			this.id = id;
		}

		public String getLogWebFlag() {
			return logWebFlag;
		}

		public void setLogWebFlag(String logWebFlag) {
			this.logWebFlag = logWebFlag;
		}

		public String getLogWebUserName() {
			return logWebUserName;
		}

		public void setLogWebUserName(String logWebUserName) {
			this.logWebUserName = logWebUserName;
		}

		public String getLogWebDomain() {
			return logWebDomain;
		}

		public void setLogWebDomain(String logWebDomain) {
			this.logWebDomain = logWebDomain;
		}

		public String getLogAddress() {
			return logAddress;
		}

		public void setLogAddress(String logAddress) {
			this.logAddress = logAddress;
		}

		public Date getCreateTime() {
			return createTime;
		}

		public void setCreateTime(Date createTime) {
			this.createTime = createTime;
		}

		public String getLogWebName() {
			return logWebName;
		}

		public void setLogWebName(String logWebName) {
			this.logWebName = logWebName;
		}

		public static long getSerialversionuid() {
			return serialVersionUID;
		}
		
}
