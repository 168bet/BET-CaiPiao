/**   
 * 文件名称: CpChaseball.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: alex<br/>  
 * 创建时间 : 2016-10-10 下午4:30:26<br/>
 */
package com.mh.entity;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.persistence.Transient;

/**
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-10 下午4:30:26<br/>
 */

@Entity
@Table(name = "cp_chaseball")
public class CpChaseball implements java.io.Serializable {

	private static final long serialVersionUID = 1L;

	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "id", nullable = false)
	private Integer id;

	@Column(name = "user_name")
	private String userName;// 用户名

	@Column(name = "billno")
	private String billno;// 编号

	@Column(name = "parent_no")
	private String parentNo;// 上级代理

	@Column(name = "game_type_code")
	private String gameTypeCode;// 游戏代码

	@Column(name = "game_type_name")
	private String gameTypeName;// 游戏名称

	@Column(name = "cp_type_code")
	private String cpTypeCode;// 选项代码

	@Column(name = "cp_type_name")
	private String cpTypeName;// 选项名称

	@Column(name = "cp_cate_code")
	private String cpCateCode;// 下注类型代码

	@Column(name = "cp_cate_name")
	private String cpCateName;// 下注类型名称

	@Column(name = "order_no")
	private String orderNo;// 订单号

	@Column(name = "bet_number")
	private String betNumber;// 下注号码

	@Column(name = "bet_total")
	private Integer betTotal;// 下注数

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "create_time")
	private Date createTime;// 创建时间

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "modify_time")
	private Date modifyTime;// 修改时间

	@Column(name = "is_bigostop")
	private Integer isBigostop;

	@Column(name = "bet_money")
	private Double betMoney;// 总下注金额

	@Column(name = "finish_money")
	private Double finishMoney;// 完成金额

	@Column(name = "cancel_money")
	private Double cancelMoney;// 取消金额

	@Column(name = "total_qs")
	private Integer totalQs;// 总共期数

	@Column(name = "finish_qs")
	private Integer finishQs;// 完成期数

	@Column(name = "status")
	private Integer status;// 状态状态1追号中2已结束,3已撤单,4已完成

	@Column(name = "relative_path")
	private String relativePath;// 代理编号集合

	@Column(name = "is_test")
	private Integer isTest;// 是否测试0否1是

	@Column(name = "begin_qs")
	private String beginQs;// 追号起始期数

	@Column(name = "end_qs")
	private String endQs;// 追号结束期数

	@Transient
	private String beginTimeStr;

	@Transient
	private String endTimeStr;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getBillno() {
		return billno;
	}

	public void setBillno(String billno) {
		this.billno = billno;
	}

	public String getParentNo() {
		return parentNo;
	}

	public void setParentNo(String parentNo) {
		this.parentNo = parentNo;
	}

	public String getGameTypeCode() {
		return gameTypeCode;
	}

	public void setGameTypeCode(String gameTypeCode) {
		this.gameTypeCode = gameTypeCode;
	}

	public String getGameTypeName() {
		return gameTypeName;
	}

	public void setGameTypeName(String gameTypeName) {
		this.gameTypeName = gameTypeName;
	}

	public String getCpTypeCode() {
		return cpTypeCode;
	}

	public void setCpTypeCode(String cpTypeCode) {
		this.cpTypeCode = cpTypeCode;
	}

	public String getCpTypeName() {
		return cpTypeName;
	}

	public void setCpTypeName(String cpTypeName) {
		this.cpTypeName = cpTypeName;
	}

	public String getCpCateCode() {
		return cpCateCode;
	}

	public void setCpCateCode(String cpCateCode) {
		this.cpCateCode = cpCateCode;
	}

	public String getCpCateName() {
		return cpCateName;
	}

	public void setCpCateName(String cpCateName) {
		this.cpCateName = cpCateName;
	}

	public String getOrderNo() {
		return orderNo;
	}

	public void setOrderNo(String orderNo) {
		this.orderNo = orderNo;
	}

	public String getBetNumber() {
		return betNumber;
	}

	public void setBetNumber(String betNumber) {
		this.betNumber = betNumber;
	}

	public Integer getBetTotal() {
		return betTotal;
	}

	public void setBetTotal(Integer betTotal) {
		this.betTotal = betTotal;
	}

	public Date getCreateTime() {
		return createTime;
	}

	public void setCreateTime(Date createTime) {
		this.createTime = createTime;
	}

	public Date getModifyTime() {
		return modifyTime;
	}

	public void setModifyTime(Date modifyTime) {
		this.modifyTime = modifyTime;
	}

	public Integer getIsBigostop() {
		return isBigostop;
	}

	public void setIsBigostop(Integer isBigostop) {
		this.isBigostop = isBigostop;
	}

	public Double getBetMoney() {
		return betMoney;
	}

	public void setBetMoney(Double betMoney) {
		this.betMoney = betMoney;
	}

	public Double getFinishMoney() {
		return finishMoney;
	}

	public void setFinishMoney(Double finishMoney) {
		this.finishMoney = finishMoney;
	}

	public Double getCancelMoney() {
		return cancelMoney;
	}

	public void setCancelMoney(Double cancelMoney) {
		this.cancelMoney = cancelMoney;
	}

	public Integer getTotalQs() {
		return totalQs;
	}

	public void setTotalQs(Integer totalQs) {
		this.totalQs = totalQs;
	}

	public Integer getFinishQs() {
		return finishQs;
	}

	public void setFinishQs(Integer finishQs) {
		this.finishQs = finishQs;
	}

	public Integer getStatus() {
		return status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
	}

	public Integer getIsTest() {
		return isTest;
	}

	public void setIsTest(Integer isTest) {
		this.isTest = isTest;
	}

	public String getBeginQs() {
		return beginQs;
	}

	public void setBeginQs(String beginQs) {
		this.beginQs = beginQs;
	}

	public String getEndQs() {
		return endQs;
	}

	public void setEndQs(String endQs) {
		this.endQs = endQs;
	}

	public String getBeginTimeStr() {
		return beginTimeStr;
	}

	public void setBeginTimeStr(String beginTimeStr) {
		this.beginTimeStr = beginTimeStr;
	}

	public String getEndTimeStr() {
		return endTimeStr;
	}

	public void setEndTimeStr(String endTimeStr) {
		this.endTimeStr = endTimeStr;
	}

	
	
}
