/**   
 * 文件名称: CpBjpk10.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: alex<br/>  
 * 创建时间 : 2015-5-28 下午7:23:31<br/>
 */
package com.mh.entity;

import javax.persistence.Transient;

/**
 * 类描述: TODO<br/>
 * 北京PK10实体类 创建人: TODO alex<br/>
 * 创建时间: 2015-5-28 下午7:23:31<br/>
 */

public class CpBjpk10Results implements java.io.Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	private Integer id;

	private String qs;// 期数

	private String formatQs;// 格式后期数

	private String kjsj;// 开奖时间

	private String gtKjsj;// 美东开奖时间

	private String kjjg;// 开奖结果

	private String gj;// 冠军

	private String yj;// 亚军

	private String jj;// 季军

	private String d4m;// 第四名

	private String d5m;// 第五名

	private String d6m;// 第六名

	private String d7m;// 第七名

	private String d8m;// 第八名

	private String d9m;// 第九名

	private String d10m;// 第十名

	private String gyjhZh;// 冠亚军和的总和

	private String gyjhDx;// 冠亚军和的大小

	private String gyjhDs;// 冠亚军和的单双

	private String gjDx;// 冠军大小

	private String gjDs;// 冠军单双

	private String yjDx;// 亚军大小

	private String yjDs;// 亚军单双

	private String jjDx;// 季军大小

	private String jjDs;// 季军单双

	private String d4mDx;// 第四名大小

	private String d4mDs;// 第四名单双

	private String d5mDx;// 第五名大小

	private String d5mDs;// 第五名单双

	private String d6mDx;// 第六名大小

	private String d6mDs;// 第六名单双

	private String d7mDx;// 第七名大小

	private String d7mDs;// 第七名单双

	private String d8mDx;// 第八名大小

	private String d8mDs;// 第八名单双

	private String d9mDx;// 第九名大小

	private String d9mDs;// 第九名单双

	private String d10mDx;// 第十名大小

	private String d10mDs;// 第十名单双

	private String code;
	@Transient
	private String xd;//已下单数
	@Transient
	private String zjrs;//中奖人数
	@Transient
	private String status;//状态
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

	public String getKjsj() {
		return kjsj;
	}

	public void setKjsj(String kjsj) {
		this.kjsj = kjsj;
	}

	public String getGj() {
		return gj;
	}

	public void setGj(String gj) {
		this.gj = gj;
	}

	public String getYj() {
		return yj;
	}

	public void setYj(String yj) {
		this.yj = yj;
	}

	public String getJj() {
		return jj;
	}

	public void setJj(String jj) {
		this.jj = jj;
	}

	public String getD4m() {
		return d4m;
	}

	public void setD4m(String d4m) {
		this.d4m = d4m;
	}

	public String getD5m() {
		return d5m;
	}

	public void setD5m(String d5m) {
		this.d5m = d5m;
	}

	public String getD6m() {
		return d6m;
	}

	public void setD6m(String d6m) {
		this.d6m = d6m;
	}

	public String getD7m() {
		return d7m;
	}

	public void setD7m(String d7m) {
		this.d7m = d7m;
	}

	public String getD8m() {
		return d8m;
	}

	public void setD8m(String d8m) {
		this.d8m = d8m;
	}

	public String getD9m() {
		return d9m;
	}

	public void setD9m(String d9m) {
		this.d9m = d9m;
	}

	public String getD10m() {
		return d10m;
	}

	public void setD10m(String d10m) {
		this.d10m = d10m;
	}

	public String getGyjhZh() {
		return gyjhZh;
	}

	public void setGyjhZh(String gyjhZh) {
		this.gyjhZh = gyjhZh;
	}

	public String getGyjhDx() {
		return gyjhDx;
	}

	public void setGyjhDx(String gyjhDx) {
		this.gyjhDx = gyjhDx;
	}

	public String getGyjhDs() {
		return gyjhDs;
	}

	public void setGyjhDs(String gyjhDs) {
		this.gyjhDs = gyjhDs;
	}

	public String getGjDx() {
		return gjDx;
	}

	public void setGjDx(String gjDx) {
		this.gjDx = gjDx;
	}

	public String getGjDs() {
		return gjDs;
	}

	public void setGjDs(String gjDs) {
		this.gjDs = gjDs;
	}

	public String getYjDx() {
		return yjDx;
	}

	public void setYjDx(String yjDx) {
		this.yjDx = yjDx;
	}

	public String getYjDs() {
		return yjDs;
	}

	public void setYjDs(String yjDs) {
		this.yjDs = yjDs;
	}

	public String getJjDx() {
		return jjDx;
	}

	public void setJjDx(String jjDx) {
		this.jjDx = jjDx;
	}

	public String getJjDs() {
		return jjDs;
	}

	public void setJjDs(String jjDs) {
		this.jjDs = jjDs;
	}

	public String getD4mDx() {
		return d4mDx;
	}

	public void setD4mDx(String d4mDx) {
		this.d4mDx = d4mDx;
	}

	public String getD4mDs() {
		return d4mDs;
	}

	public void setD4mDs(String d4mDs) {
		this.d4mDs = d4mDs;
	}

	public String getD5mDx() {
		return d5mDx;
	}

	public void setD5mDx(String d5mDx) {
		this.d5mDx = d5mDx;
	}

	public String getD5mDs() {
		return d5mDs;
	}

	public void setD5mDs(String d5mDs) {
		this.d5mDs = d5mDs;
	}

	public String getD6mDx() {
		return d6mDx;
	}

	public void setD6mDx(String d6mDx) {
		this.d6mDx = d6mDx;
	}

	public String getD6mDs() {
		return d6mDs;
	}

	public void setD6mDs(String d6mDs) {
		this.d6mDs = d6mDs;
	}

	public String getD7mDx() {
		return d7mDx;
	}

	public void setD7mDx(String d7mDx) {
		this.d7mDx = d7mDx;
	}

	public String getD7mDs() {
		return d7mDs;
	}

	public void setD7mDs(String d7mDs) {
		this.d7mDs = d7mDs;
	}

	public String getD8mDx() {
		return d8mDx;
	}

	public void setD8mDx(String d8mDx) {
		this.d8mDx = d8mDx;
	}

	public String getD8mDs() {
		return d8mDs;
	}

	public void setD8mDs(String d8mDs) {
		this.d8mDs = d8mDs;
	}

	public String getD9mDx() {
		return d9mDx;
	}

	public void setD9mDx(String d9mDx) {
		this.d9mDx = d9mDx;
	}

	public String getD9mDs() {
		return d9mDs;
	}

	public void setD9mDs(String d9mDs) {
		this.d9mDs = d9mDs;
	}

	public String getD10mDx() {
		return d10mDx;
	}

	public void setD10mDx(String d10mDx) {
		this.d10mDx = d10mDx;
	}

	public String getD10mDs() {
		return d10mDs;
	}

	public void setD10mDs(String d10mDs) {
		this.d10mDs = d10mDs;
	}

	public String getCode() {
		return code;
	}

	public void setCode(String code) {
		this.code = code;
	}

	public String getFormatQs() {
		return formatQs;
	}

	public void setFormatQs(String formatQs) {
		this.formatQs = formatQs;
	}

	public String getGtKjsj() {
		return gtKjsj;
	}

	public void setGtKjsj(String gtKjsj) {
		this.gtKjsj = gtKjsj;
	}

	public String getKjjg() {
		return kjjg;
	}

	public void setKjjg(String kjjg) {
		this.kjjg = kjjg;
	}

}
