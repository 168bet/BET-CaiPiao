package com.mh.entity;

 /**
  * 排期实体类
  * 类描述: TODO<br/> 
  * 修改人: alex<br/>
  * 修改时间: 2016-5-5 上午1:40:25<br/>
  */
public class CpTomResults implements java.io.Serializable {
 
	private static final long serialVersionUID = 1L;

	private Integer id;

    private String code;

 
    private String qs;

 
    private String formatQs;

 
    private String kjsj;

 
    private String gtKjsj;
    
    //上一期
    private String preQs;
    
    private String preFormatQs;
    
    private String preKjsj;
    
    private String preGtKjsj;

    private String updateTime;


	public Integer getId() {
		return id;
	}


	public void setId(Integer id) {
		this.id = id;
	}


	public String getCode() {
		return code;
	}


	public void setCode(String code) {
		this.code = code;
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


	public String getKjsj() {
		return kjsj;
	}


	public void setKjsj(String kjsj) {
		this.kjsj = kjsj;
	}


	public String getGtKjsj() {
		return gtKjsj;
	}


	public void setGtKjsj(String gtKjsj) {
		this.gtKjsj = gtKjsj;
	}


	public String getUpdateTime() {
		return updateTime;
	}


	public void setUpdateTime(String updateTime) {
		this.updateTime = updateTime;
	}


	public String getPreKjsj() {
		return preKjsj;
	}


	public void setPreKjsj(String preKjsj) {
		this.preKjsj = preKjsj;
	}


	public String getPreGtKjsj() {
		return preGtKjsj;
	}


	public void setPreGtKjsj(String preGtKjsj) {
		this.preGtKjsj = preGtKjsj;
	}


	public String getPreQs() {
		return preQs;
	}


	public void setPreQs(String preQs) {
		this.preQs = preQs;
	}


	public String getPreFormatQs() {
		return preFormatQs;
	}


	public void setPreFormatQs(String preFormatQs) {
		this.preFormatQs = preFormatQs;
	}
	
	
	

}