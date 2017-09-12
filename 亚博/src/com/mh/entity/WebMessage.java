/**   
* 文件名称: WebMessage.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 下午1:48:18<br/>
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
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午1:48:18<br/>
 */
@Entity
@Table(name = "t_web_message")
public class WebMessage implements Serializable {

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
	
	@Column(name = "msg_type")
	private Integer msgType;//类型（1系统、2会员、3代理）

	@Column(name = "msg_title")
	private String msgTitle;//消息标题
	
	@Column(name = "user_name")
	private String userName;//会员
	
	@Column(name = "msg_content")
	private String msgContent;//消息内容
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;//修改时间
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;//创建时间
	
	@Column(name = "msg_status")
	private Integer msgStatus;//消息状态

	@Column(name = "manager_user_name")
	private String managerUserName;//发送人
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "enable_time")
	private Date enableTime;//有效时间
	
	@Column(name = "read_status")
	private Integer readStatus;//读的状态

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public Integer getMsgType() {
		return msgType;
	}

	public void setMsgType(Integer msgType) {
		this.msgType = msgType;
	}

	public String getMsgTitle() {
		return msgTitle;
	}

	public void setMsgTitle(String msgTitle) {
		this.msgTitle = msgTitle;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getMsgContent() {
		return msgContent;
	}

	public void setMsgContent(String msgContent) {
		this.msgContent = msgContent;
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

	public Integer getMsgStatus() {
		return msgStatus;
	}

	public void setMsgStatus(Integer msgStatus) {
		this.msgStatus = msgStatus;
	}

	public String getManagerUserName() {
		return managerUserName;
	}

	public void setManagerUserName(String managerUserName) {
		this.managerUserName = managerUserName;
	}

	public Date getEnableTime() {
		return enableTime;
	}

	public void setEnableTime(Date enableTime) {
		this.enableTime = enableTime;
	}

	public Integer getReadStatus() {
		return readStatus;
	}

	public void setReadStatus(Integer readStatus) {
		this.readStatus = readStatus;
	}

	public static long getSerialversionuid() {
		return serialVersionUID;
	}
	


}
