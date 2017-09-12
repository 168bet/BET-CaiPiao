/**   
* 文件名称: CpResults.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-4 下午1:22:43<br/>
*/  
package com.mh.entity;

import java.util.List;
import java.util.Map;



/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-4 下午1:22:43<br/>
 */
public class CpResults implements java.io.Serializable {
	
	private static final long serialVersionUID = 1L;
	private String bTime;//开始时间
	private String eTime;//结束时间
	private String pageNo;//第几页
	private String pageSize;//每页多条数据
	
	private String code;
	
	private String name;
	
	private String qs;// 期数
	
	private String kjsj;
	
	private String gtKjsj;
	
	private List<String> numberList;

	private String p1;// 平1

	private String p2;// 平2

	private String p4;// 平4

	private String p3;// 平3

	private String p5;// 平5

	private String p6;// 平6
	
	private String p7;// 平7

	private String p8;// 平8
	
	private String p9;// 平9
	
	private String p10;// 平10

	private String tm;// 特码
	
	private String nextQs;
	
	private String nextKjsj;
	
	private String nextGtKjsj;
	
	private String gameTypeCode;// 游戏类型代码

	private String cpTypeCode;// 彩票类型代码
	
	private String zuTypeCode;
	
	private String showKjSj;
	
	
	private String color1;
	private String color2;
	private String color3;
	private String color4;
	private String color5;
	private String color6;
	private String colorTm;
	
	private String ipAddress;
	private String tmsb;
	
	private CpTomResults cpTomResults;
	
	
	private Map<String, String> timeMap;

	public String getQs() {
 
		return qs;
	}

	public void setQs(String qs) {
		this.qs = qs;
	}

	public String getKjsj() {
		return kjsj;
	}

	public void setKjsj(String kjsj) {
		this.kjsj = kjsj;
	}

	public String getP1() {
		return p1;
	}

	public void setP1(String p1) {
		this.p1 = p1;
	}

	public String getP2() {
		return p2;
	}

	public void setP2(String p2) {
		this.p2 = p2;
	}

	public String getP4() {
		return p4;
	}

	public void setP4(String p4) {
		this.p4 = p4;
	}

	public String getP3() {
		return p3;
	}

	public void setP3(String p3) {
		this.p3 = p3;
	}

	public String getP5() {
		return p5;
	}

	public String getbTime() {
		return bTime;
	}

	public void setbTime(String bTime) {
		this.bTime = bTime;
	}

	public String geteTime() {
		return eTime;
	}

	public void seteTime(String eTime) {
		this.eTime = eTime;
	}

	public String getPageNo() {
		return pageNo;
	}

	public void setPageNo(String pageNo) {
		this.pageNo = pageNo;
	}

	public String getPageSize() {
		return pageSize;
	}

	public void setPageSize(String pageSize) {
		this.pageSize = pageSize;
	}

	public void setP5(String p5) {
		this.p5 = p5;
	}

	public String getP6() {
		return p6;
	}

	public void setP6(String p6) {
		this.p6 = p6;
	}

	public String getTm() {
		return tm;
	}

	public void setTm(String tm) {
		this.tm = tm;
	}

	public String getNextQs() {
 
	 
		return nextQs;
		
	}

	public void setNextQs(String nextQs) {
		this.nextQs = nextQs;
	}

	public String getNextKjsj() {
		return nextKjsj;
	}

	public void setNextKjsj(String nextKjsj) {
		this.nextKjsj = nextKjsj;
	}

	public String getP7() {
		return p7;
	}

	public void setP7(String p7) {
		this.p7 = p7;
	}

	public String getP8() {
		return p8;
	}

	public void setP8(String p8) {
		this.p8 = p8;
	}

	public String getGameTypeCode() {
		return gameTypeCode;
	}

	public void setGameTypeCode(String gameTypeCode) {
		this.gameTypeCode = gameTypeCode;
	}

	public String getCpTypeCode() {
		return cpTypeCode;
	}

	public void setCpTypeCode(String cpTypeCode) {
		this.cpTypeCode = cpTypeCode;
	}

	public String getCode() {
		return code;
	}

	public void setCode(String code) {
		this.code = code;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getZuTypeCode() {
		return zuTypeCode;
	}

	public void setZuTypeCode(String zuTypeCode) {
		this.zuTypeCode = zuTypeCode;
	}

	public String getP9() {
		return p9;
	}

	public void setP9(String p9) {
		this.p9 = p9;
	}

	public String getP10() {
		return p10;
	}

	public void setP10(String p10) {
		this.p10 = p10;
	}

	public String getColor1() {
		return color1;
	}

	public void setColor1(String color1) {
		this.color1 = color1;
	}

	public String getColor2() {
		return color2;
	}

	public void setColor2(String color2) {
		this.color2 = color2;
	}

	public String getColor3() {
		return color3;
	}

	public void setColor3(String color3) {
		this.color3 = color3;
	}

	public String getColor4() {
		return color4;
	}

	public void setColor4(String color4) {
		this.color4 = color4;
	}

	public String getColor5() {
		return color5;
	}

	public void setColor5(String color5) {
		this.color5 = color5;
	}

	public String getColor6() {
		return color6;
	}

	public void setColor6(String color6) {
		this.color6 = color6;
	}

	public String getColorTm() {
		return colorTm;
	}

	public void setColorTm(String colorTm) {
		this.colorTm = colorTm;
	}

	public String getNextGtKjsj() {
		return nextGtKjsj;
	}

	public void setNextGtKjsj(String nextGtKjsj) {
		this.nextGtKjsj = nextGtKjsj;
	}

	public String getShowKjSj() {
		return showKjSj;
	}

	public void setShowKjSj(String showKjSj) {
		this.showKjSj = showKjSj;
	}

	public String getGtKjsj() {
		return gtKjsj;
	}

	public void setGtKjsj(String gtKjsj) {
		this.gtKjsj = gtKjsj;
	}

	public List<String> getNumberList() {
		return numberList;
	}

	public void setNumberList(List<String> numberList) {
		this.numberList = numberList;
	}

	public CpTomResults getCpTomResults() {
		return cpTomResults;
	}

	public void setCpTomResults(CpTomResults cpTomResults) {
		this.cpTomResults = cpTomResults;
	}

	public String getIpAddress() {
		return ipAddress;
	}

	public void setIpAddress(String ipAddress) {
		this.ipAddress = ipAddress;
	}

	public String getTmsb() {
		return tmsb;
	}

	public void setTmsb(String tmsb) {
		this.tmsb = tmsb;
	}

	public Map<String, String> getTimeMap() {
		return timeMap;
	}

	public void setTimeMap(Map<String, String> timeMap) {
		this.timeMap = timeMap;
	}
	
	
}
