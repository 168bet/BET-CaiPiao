/**   
* 文件名称: CpBjpk10.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-28 下午7:23:31<br/>
*/  
package com.mh.entity;

import javax.persistence.Transient;


/** 
 * 类描述: TODO<br/>幸运28实体类
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-28 下午7:23:31<br/>
 */
 
public class CpXy28Results implements java.io.Serializable {

	private static final long serialVersionUID = 1L;

	private Integer id;

	private String qs;// 期数
	
	private String formatQs;// 格式后期数

	private String kjsj;// 开奖时间
	
	private String gtKjsj;// 美东开奖时间
	
 
	private String kl8Kjjg;// 快乐8开奖结果
	
	private Integer d1q;// 1-6位和值末位
	
	private Integer d2q;// 7-12位和值末位
	
	
	private Integer d3q;//13-18位和值末位
	
	private String xy28Kjjg;// 幸运28开奖结果
	
	private String dx;//大小
	
	private String ds;//单双
	
	private String code;
	
	@Transient
	private String xd;//已下单数
	@Transient
	private String zjrs;//中奖人数
	@Transient
	private String status;//状态
	@Transient
	private String nextDate;//待开奖日期
	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getQs() {
		return qs;
	}

	public void setQs(String qs) {
		this.qs = qs;
	}

	public String getFormatQs() {
		return formatQs;
	}

	public void setFormatQs(String formatQs) {
		this.formatQs = formatQs;
	}
	
	public String getNextDate() {
		return nextDate;
	}

	public void setNextDate(String nextDate) {
		this.nextDate = nextDate;
	}

	public String getKjsj() {
		return kjsj;
	}

	public void setKjsj(String kjsj) {
		this.kjsj = kjsj;
	}

	
	

	public String getXd() {
		return xd;
	}

	public void setXd(String xd) {
		this.xd = xd;
	}

	public String getZjrs() {
		return zjrs;
	}

	public void setZjrs(String zjrs) {
		this.zjrs = zjrs;
	}

	public String getStatus() {
		return status;
	}

	public void setStatus(String status) {
		this.status = status;
	}

	public String getGtKjsj() {
		return gtKjsj;
	}

	public void setGtKjsj(String gtKjsj) {
		this.gtKjsj = gtKjsj;
	}

	

	public String getKl8Kjjg() {
		return kl8Kjjg;
	}

	public void setKl8Kjjg(String kl8Kjjg) {
		this.kl8Kjjg = kl8Kjjg;
	}

	public Integer getD1q() {
		return d1q;
	}

	public void setD1q(Integer d1q) {
		this.d1q = d1q;
	}

	public Integer getD2q() {
		return d2q;
	}

	public void setD2q(Integer d2q) {
		this.d2q = d2q;
	}

	public Integer getD3q() {
		return d3q;
	}

	public void setD3q(Integer d3q) {
		this.d3q = d3q;
	}

	public String getXy28Kjjg() {
		return xy28Kjjg;
	}

	public void setXy28Kjjg(String xy28Kjjg) {
		this.xy28Kjjg = xy28Kjjg;
	}

	public String getDx() {
		return dx;
	}

	public void setDx(String dx) {
		this.dx = dx;
	}

	public String getDs() {
		return ds;
	}

	public void setDs(String ds) {
		this.ds = ds;
	}

	public String getCode() {
		return code;
	}

	public void setCode(String code) {
		this.code = code;
	}
	
	
	
	
}
