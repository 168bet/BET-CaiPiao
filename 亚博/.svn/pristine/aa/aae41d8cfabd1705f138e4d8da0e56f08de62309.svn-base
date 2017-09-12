/**   
* 文件名称: ActivityInfo.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-9-16 上午4:03:22<br/>
*/  
package com.mh.entity;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

/** 
 * 
 * 活动信息表
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-9-16 上午4:03:22<br/>
 */

@Entity
@Table(name = "t_web_flat_info")
public class TWebFlatInfo implements java.io.Serializable {

	private static final long serialVersionUID = 1L;

	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)//自增长
	@Column(name = "ID",nullable = false)
    private Integer id;
	@Column(name = "flat_type")
	private String flatType;
	@Column(name = "flat")
	private String flat;
	@Column(name = "flat_name")
	private String flatName;
	@Column(name = "flat_des")
	private String flatDes;
	@Column(name = "flat_url")
	private String flatUrl;
	@Column(name = "flat_status")
	private String flatStatus;
	@Column(name = "flat_index")
	private String flatIndex;
	
	
	public Integer getId() {
		return id;
	}
	public void setId(Integer id) {
		this.id = id;
	}
	public String getFlatType() {
		return flatType;
	}
	public void setFlatType(String flatType) {
		this.flatType = flatType;
	}
	public String getFlat() {
		return flat;
	}
	public void setFlat(String flat) {
		this.flat = flat;
	}
	public String getFlatName() {
		return flatName;
	}
	public void setFlatName(String flatName) {
		this.flatName = flatName;
	}
	public String getFlatDes() {
		return flatDes;
	}
	public void setFlatDes(String flatDes) {
		this.flatDes = flatDes;
	}
	public String getFlatUrl() {
		return flatUrl;
	}
	public void setFlatUrl(String flatUrl) {
		this.flatUrl = flatUrl;
	}
	public String getFlatStatus() {
		return flatStatus;
	}
	public void setFlatStatus(String flatStatus) {
		this.flatStatus = flatStatus;
	}
	public String getFlatIndex() {
		return flatIndex;
	}
	public void setFlatIndex(String flatIndex) {
		this.flatIndex = flatIndex;
	}

}
