package app.xb.cmbase.model;


/**
 * 类描述: TODO<br/>
 * 彩票类型实体类 创建人: TODO Channal<br/>
 * 创建时间: 2015-5-26 下午5:29:07<br/>
 */
public class CpType implements java.io.Serializable {
 
	private static final long serialVersionUID = 1L;

	private Integer id;

	private String bigtypeCode;// 游戏大类代码

	private String cpTypeCode;// 彩票类型代码

	private String cpTypeName;// 彩票类型代码
	
//	private String gameTypeCode;
//	
//	private String gameTypeName;
	
	private Integer gminSingle;//单注最低金额
	
	private Integer gmaxSingle;//单注限额
	
	private Integer singleCredit;//单号限额
	
	private Integer groupType;// 排序号

	private Integer pxh;// 排序号
	
	private Integer isEnable;
	
	private String p;	//对应页面p标签value

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}
 
	public String getBigtypeCode() {
		return bigtypeCode;
	}

	public void setBigtypeCode(String bigtypeCode) {
		this.bigtypeCode = bigtypeCode;
	}

	public String getCpTypeName() {
		return cpTypeName;
	}

	public void setCpTypeName(String cpTypeName) {
		this.cpTypeName = cpTypeName;
	}

	public String getCpTypeCode() {
		return cpTypeCode;
	}

	public void setCpTypeCode(String cpTypeCode) {
		this.cpTypeCode = cpTypeCode;
	}

	public Integer getPxh() {
		return pxh;
	}

	public void setPxh(Integer pxh) {
		this.pxh = pxh;
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

	public int getGroupType() {
		return groupType;
	}

	public void setGroupType(Integer groupType) {
		this.groupType = groupType;
	}

	public Integer getIsEnable() {
		return isEnable;
	}

	public void setIsEnable(Integer isEnable) {
		this.isEnable = isEnable;
	}

	public String getP() {
		return p;
	}

	public void setP(String p) {
		this.p = p;
	}

//	public String getGameTypeCode() {
//		return gameTypeCode;
//	}
//
//	public void setGameTypeCode(String gameTypeCode) {
//		this.gameTypeCode = gameTypeCode;
//	}
//
//	public String getGameTypeName() {
//		return gameTypeName;
//	}
//
//	public void setGameTypeName(String gameTypeName) {
//		this.gameTypeName = gameTypeName;
//	}
}
