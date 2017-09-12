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
 * 彩票订单实体类 创建人: TODO Channal<br/>
 * 创建时间: 2015-5-26 下午5:29:07<br/>
 */
@Entity
@Table(name = "CP_ORDER")
public class CpOrder implements java.io.Serializable {

	private static final long serialVersionUID = 1L;

	// 流水号
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	// 自增长
	@Column(name = "ID", nullable = false)
	private Integer id;

	@Column(name = "CFG_ID")
	private String cfgId;// 配置ID,关联彩票配置表

	@Column(name = "XZDH")
	private String xzdh;// 下注单号

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "XZSJ")
	private Date xzsj;// 下注时间

	@Column(name = "QS")
	private String qs;// 期数

	@Column(name = "GAME_TYPE_CODE")
	private String gameTypeCode;// 游戏类型代码

	@Column(name = "GAME_TYPE_NAME")
	private String gameTypeName;// 游戏类型名称

	@Column(name = "CP_TYPE_CODE")
	private String cpTypeCode;// 彩票类型代码

	@Column(name = "CP_TYPE_NAME")
	private String cpTypeName;// 彩票类型名称

	@Column(name = "CP_CATE_CODE")
	private String cpCateCode;// 彩票类别代码

	@Column(name = "CP_CATE_NAME")
	private String cpCateName;

	@Column(name = "XZLX_CODE")
	private String xzlxCode;// 下注类型代码

	@Column(name = "XZLX_NAME")
	private String xzlxName;// 下注类型名称

	@Column(name = "XZZU_CODE")
	private String xzzuCode;// 下注组别代码

	@Column(name = "XZZU_NAME")
	private String xzzuName;// 下注组别名称

	@Column(name = "BZ")
	private String bz;// 备注

	@Column(name = "CONTENT")
	private String content;// 备注

	@Column(name = "NUMBER")
	private String number;// 号码

	@Column(name = "ORDER_STATUS")
	private String orderStatus;// 订单状态

	@Column(name = "XZJE")
	private Double xzje;// 下注金额

	@Column(name = "PL")
	private String pl;// 赔率

	@Column(name = "YJ")
	private Double yj;// 佣金

	@Column(name = "KYJE")
	private Double kyje;// 可赢金额

	@Column(name = "ZGJE")
	private Double zgje;// 总共金额

	@Column(name = "SFJS")
	private String sfjs;// 是否结算 0未结算 1表示已结算

	@Column(name = "USER_IP")
	private String userIp;// 用户IP

	@Column(name = "USER_NAME")
	private String userName;// 创建人ID

	@Column(name = "BACK_WATER_RATE")
	private Double backWaterRate;// 返水比例

	@Column(name = "BACK_WATER_STATUS")
	private Integer backWaterStatus;// 返水状态（0未返水，1已返水）

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "BACK_WATER_TIME")
	private Date backWaterTime;// 返水时间

	@Column(name = "BACK_WATER_MONEY")
	private Double backWaterMoney;// 返水金额

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "OPEN_TIME")
	private Date openTime;// 开奖时间

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "CREATE_TIME")
	private Date createTime;// 创建时间

	@Temporal(TemporalType.TIMESTAMP)
	@Column(name = "MODIFY_TIME")
	private Date modifyTime;// 创建时间

	@Column(name = "HYSF")
	private Double hysf;// 会员收付

	@Column(name = "YXTZ")
	private Double yxtz;// 有效投注。和局为0，反为下注金额

	@Column(name = "KJJG")
	private String kjjg;// 开奖结果

	@Column(name = "USER_AGENT")
	private String userAgent;// 代理账号

	@Column(name = "IS_SYNC")
	private Integer isSync;// 是否同步0否1是
	
	@Column(name = "WIN_MONEY")
	private Double winMoney;//中奖金额
	
	
	@Column(name = "BET_USR_WIN")
	private Double betUsrWin;// 用户赢的金额=中奖金额+返水金额-投注总额
	

	@Transient
	private String endTime;
	@Transient
	private Integer gminSingle;// 单注最低金额
	@Transient
	private Integer gmaxSingle;// 单注限额
	@Transient
	private Integer singleCredit;// 单号限额
	@Transient
	private String desc;
	@Transient
	private String beginTimeStr;
	
	@Transient
	private String endTimeStr;
	@Transient
	private String webFlag;	//网站标识
	@Transient
	private String status;
	
	@Transient
	private String relativePath;
	
	

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getXzdh() {
		return xzdh;
	}

	public void setXzdh(String xzdh) {
		this.xzdh = xzdh;
	}

	public Date getXzsj() {
		return xzsj;
	}

	public void setXzsj(Date xzsj) {
		this.xzsj = xzsj;
	}

	public String getQs() {
		return qs;
	}

	public void setQs(String qs) {
		this.qs = qs;
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

	public String getCfgId() {
		return cfgId;
	}

	public void setCfgId(String cfgId) {
		this.cfgId = cfgId;
	}

	public String getBz() {
		return bz;
	}

	public void setBz(String bz) {
		this.bz = bz;
	}

	public String getNumber() {
		return number;
	}

	public void setNumber(String number) {
		this.number = number;
	}

	public Double getXzje() {
		return xzje;
	}

	public void setXzje(Double xzje) {
		this.xzje = xzje;
	}

	public String getPl() {
		return pl;
	}

	public void setPl(String pl) {
		this.pl = pl;
	}

	public Double getYj() {
		return yj;
	}

	public void setYj(Double yj) {
		this.yj = yj;
	}

	public Double getKyje() {
		return kyje;
	}

	public void setKyje(Double kyje) {
		this.kyje = kyje;
	}

	public String getSfjs() {
		return sfjs;
	}

	public void setSfjs(String sfjs) {
		this.sfjs = sfjs;
	}

	public String getCpTypeCode() {
		return cpTypeCode;
	}

	public void setCpTypeCode(String cpTypeCode) {
		this.cpTypeCode = cpTypeCode;
	}

	public String getCpCateCode() {
		return cpCateCode;
	}

	public void setCpCateCode(String cpCateCode) {
		this.cpCateCode = cpCateCode;
	}

	public Double getZgje() {
		return zgje;
	}

	public void setZgje(Double zgje) {
		this.zgje = zgje;
	}

	public String getUserIp() {
		return userIp;
	}

	public void setUserIp(String userIp) {
		this.userIp = userIp;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getContent() {
		return content;
	}

	public void setContent(String content) {
		this.content = content;
	}

	public String getCpCateName() {
		return cpCateName;
	}

	public void setCpCateName(String cpCateName) {
		this.cpCateName = cpCateName;
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

	public Double getHysf() {
		return hysf;
	}

	public void setHysf(Double hysf) {
		this.hysf = hysf;
	}

	public Double getYxtz() {
		return yxtz;
	}

	public void setYxtz(Double yxtz) {
		this.yxtz = yxtz;
	}

	public String getKjjg() {
		return kjjg;
	}

	public void setKjjg(String kjjg) {
		this.kjjg = kjjg;
	}

	public String getUserAgent() {
		return userAgent;
	}

	public void setUserAgent(String userAgent) {
		this.userAgent = userAgent;
	}

	public Integer getIsSync() {
		return isSync;
	}

	public void setIsSync(Integer isSync) {
		this.isSync = isSync;
	}

	public String getEndTime() {
		return endTime;
	}

	public void setEndTime(String endTime) {
		this.endTime = endTime;
	}

	public Integer getGminSingle() {
		return gminSingle;
	}

	public void setGminSingle(Integer gminSingle) {
		this.gminSingle = gminSingle;
	}

	public Integer getGmaxSingle() {
		return gmaxSingle;
	}

	public void setGmaxSingle(Integer gmaxSingle) {
		this.gmaxSingle = gmaxSingle;
	}

	public Integer getSingleCredit() {
		return singleCredit;
	}

	public void setSingleCredit(Integer singleCredit) {
		this.singleCredit = singleCredit;
	}

	public String getDesc() {
		return desc;
	}

	public void setDesc(String desc) {
		this.desc = desc;
	}

	public String getCpTypeName() {
		return cpTypeName;
	}

	public void setCpTypeName(String cpTypeName) {
		this.cpTypeName = cpTypeName;
	}

	public String getXzlxCode() {
		return xzlxCode;
	}

	public void setXzlxCode(String xzlxCode) {
		this.xzlxCode = xzlxCode;
	}

	public String getXzlxName() {
		return xzlxName;
	}

	public void setXzlxName(String xzlxName) {
		this.xzlxName = xzlxName;
	}

	public String getXzzuCode() {
		return xzzuCode;
	}

	public void setXzzuCode(String xzzuCode) {
		this.xzzuCode = xzzuCode;
	}

	public String getXzzuName() {
		return xzzuName;
	}

	public void setXzzuName(String xzzuName) {
		this.xzzuName = xzzuName;
	}

	public String getOrderStatus() {
		return orderStatus;
	}

	public void setOrderStatus(String orderStatus) {
		this.orderStatus = orderStatus;
	}

	public Double getBackWaterRate() {
		return backWaterRate;
	}

	public void setBackWaterRate(Double backWaterRate) {
		this.backWaterRate = backWaterRate;
	}

	public Integer getBackWaterStatus() {
		return backWaterStatus;
	}

	public void setBackWaterStatus(Integer backWaterStatus) {
		this.backWaterStatus = backWaterStatus;
	}

	public Date getBackWaterTime() {
		return backWaterTime;
	}

	public void setBackWaterTime(Date backWaterTime) {
		this.backWaterTime = backWaterTime;
	}

	public Double getBackWaterMoney() {
		return backWaterMoney;
	}

	public void setBackWaterMoney(Double backWaterMoney) {
		this.backWaterMoney = backWaterMoney;
	}

	public Date getOpenTime() {
		return openTime;
	}

	public void setOpenTime(Date openTime) {
		this.openTime = openTime;
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

	public Double getWinMoney() {
		return winMoney;
	}

	public void setWinMoney(Double winMoney) {
		this.winMoney = winMoney;
	}

	public Double getBetUsrWin() {
		return betUsrWin;
	}

	public void setBetUsrWin(Double betUsrWin) {
		this.betUsrWin = betUsrWin;
	}

	public String getWebFlag() {
		return webFlag;
	}

	public void setWebFlag(String webFlag) {
		this.webFlag = webFlag;
	}

	public String getStatus() {
		return status;
	}

	public void setStatus(String status) {
		this.status = status;
	}

	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
	}
	
	
	
}
