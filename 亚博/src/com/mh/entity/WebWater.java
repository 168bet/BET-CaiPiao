/**   
* 文件名称: WebWater.java<br/>
* 版本号: V1.0<br/>   
* 创建人: Channel<br/>  
* 创建时间 : 2015-7-1 上午9:35:19<br/>
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
 * 类描述: TODO<br/>返水配置表
 * 创建人: TODO Channel<br/>
 * 创建时间: 2015-7-1 上午9:35:19<br/>
 */
@Entity
@Table(name = "t_web_water")
public class WebWater implements Serializable {

	/** 
	 * @Fields serialVersionUID: TODO 
	 */ 
	private static final long serialVersionUID = 1L;
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;//数据库主键
	
	@Column(name = "wat_name")
	private String watName;//返水名称
	
	@Column(name = "flat_ratio_ag")
	private Double flatRatioAg;
	
	@Column(name = "flat_ratio_mg")
	private Double flatRatioMg;
	
	@Column(name = "flat_ratio_jbb")
	private Double flatRatioJbb;
	
	@Column(name = "flat_ratio_bbin")
	private Double flatRatioBbin;
	
	@Column(name = "flat_ratio_kg")
	private Double flatRatioKg;
	
	@Column(name = "flat_ratio_xtd")
	private Double flatRatioXtd;
	
	@Column(name = "flat_ratio_huanguan")
	private Double flatRatioHuanguan;
	
	@Column(name = "flat_ratio_caipiao")
	private Double flatRatioCaipiao;
	
	@Column(name = "flat_ratio_ds")
	private Double flatRatioDs;
	
	@Column(name = "flat_ratio_hg")
	private Double flatRatioHg;
	
	@Column(name = "flat_ratio_nt")
	private Double flatRatioNt;
	
	@Column(name = "flat_ratio_pt")
	private Double flatRatioPt;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getWatName() {
		return watName;
	}

	public void setWatName(String watName) {
		this.watName = watName;
	}

	public Double getFlatRatioAg() {
		return flatRatioAg;
	}

	public void setFlatRatioAg(Double flatRatioAg) {
		this.flatRatioAg = flatRatioAg;
	}

	public Double getFlatRatioMg() {
		return flatRatioMg;
	}

	public void setFlatRatioMg(Double flatRatioMg) {
		this.flatRatioMg = flatRatioMg;
	}

	public Double getFlatRatioJbb() {
		return flatRatioJbb;
	}

	public void setFlatRatioJbb(Double flatRatioJbb) {
		this.flatRatioJbb = flatRatioJbb;
	}

	public Double getFlatRatioBbin() {
		return flatRatioBbin;
	}

	public void setFlatRatioBbin(Double flatRatioBbin) {
		this.flatRatioBbin = flatRatioBbin;
	}

	public Double getFlatRatioKg() {
		return flatRatioKg;
	}

	public void setFlatRatioKg(Double flatRatioKg) {
		this.flatRatioKg = flatRatioKg;
	}

	public Double getFlatRatioXtd() {
		return flatRatioXtd;
	}

	public void setFlatRatioXtd(Double flatRatioXtd) {
		this.flatRatioXtd = flatRatioXtd;
	}

	public Double getFlatRatioHuanguan() {
		return flatRatioHuanguan;
	}

	public void setFlatRatioHuanguan(Double flatRatioHuanguan) {
		this.flatRatioHuanguan = flatRatioHuanguan;
	}

	public Double getFlatRatioCaipiao() {
		return flatRatioCaipiao;
	}

	public void setFlatRatioCaipiao(Double flatRatioCaipiao) {
		this.flatRatioCaipiao = flatRatioCaipiao;
	}

	public Double getFlatRatioDs() {
		return flatRatioDs;
	}

	public void setFlatRatioDs(Double flatRatioDs) {
		this.flatRatioDs = flatRatioDs;
	}

	public Double getFlatRatioHg() {
		return flatRatioHg;
	}

	public void setFlatRatioHg(Double flatRatioHg) {
		this.flatRatioHg = flatRatioHg;
	}

	public Double getFlatRatioNt() {
		return flatRatioNt;
	}

	public void setFlatRatioNt(Double flatRatioNt) {
		this.flatRatioNt = flatRatioNt;
	}

	public Double getFlatRatioPt() {
		return flatRatioPt;
	}

	public void setFlatRatioPt(Double flatRatioPt) {
		this.flatRatioPt = flatRatioPt;
	}

	public static long getSerialversionuid() {
		return serialVersionUID;
	}
	
}
