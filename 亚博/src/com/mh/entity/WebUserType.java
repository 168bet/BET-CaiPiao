/**   
* 文件名称: WebUserType.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-6-30 下午3:15:31<br/>
*/  
package com.mh.entity;

import java.io.Serializable;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

/** 
 * 类描述: TODO<br/> 用户类型表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-6-30 下午3:15:31<br/>
 */
@Entity
@Table(name = "t_web_user_type")
public class WebUserType implements Serializable {

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
			
			@Column(name = "type_name")
			private String typeName;//类型名称
			
			@Column(name = "type_status")
			private Integer typeStatus;//启动标识（1启动、0关闭）
			
			@Column(name = "remark")
			private String remark;//备注
			
			@Column(name = "type_default")
			private Integer typeDefault;//是否为默认会员
			
			@Column(name = "type_level")
			private String typeLevel;//会员等级名称
			
			@Column(name = "type_pic")
			private byte[] typePic;//会员等级图片
			
			@Column(name = "msg_content")
			private String msgContent;//会员中心弹框内容
			
			@Column(name = "content_status")
			private Integer contentStatus;//会员中心弹框控制 (0:不弹框 1:弹框)
			
			
			

			public String getMsgContent() {
				return msgContent;
			}

			public void setMsgContent(String msgContent) {
				this.msgContent = msgContent;
			}

			public Integer getContentStatus() {
				return contentStatus;
			}

			public void setContentStatus(Integer contentStatus) {
				this.contentStatus = contentStatus;
			}

			public String getTypeLevel() {
				return typeLevel;
			}

			public void setTypeLevel(String typeLevel) {
				this.typeLevel = typeLevel;
			}

			public byte[] getTypePic() {
				return typePic;
			}

			public void setTypePic(byte[] typePic) {
				this.typePic = typePic;
			}

			public Integer getId() {
				return id;
			}

			public void setId(Integer id) {
				this.id = id;
			}

			public String getTypeName() {
				return typeName;
			}

			public void setTypeName(String typeName) {
				this.typeName = typeName;
			}

			public Integer getTypeStatus() {
				return typeStatus;
			}

			public void setTypeStatus(Integer typeStatus) {
				this.typeStatus = typeStatus;
			}

			public String getRemark() {
				return remark;
			}

			public void setRemark(String remark) {
				this.remark = remark;
			}

			public Integer getTypeDefault() {
				return typeDefault;
			}

			public void setTypeDefault(Integer typeDefault) {
				this.typeDefault = typeDefault;
			}

			public static long getSerialversionuid() {
				return serialVersionUID;
			}
	
}
