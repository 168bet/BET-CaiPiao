
package app.xb.cmbase.model;


/** 
 * 类描述: TODO<br/>游戏类型实体类
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-26 下午5:29:07<br/>
 */
public class CpGame implements java.io.Serializable {

 

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	private Integer id;
	
	private String bigtypeCode;//游戏大类
	
	private String gameTypeCode;//游戏类型代码
	
	private String gameTypeName;//游戏类型名称
	
	private Integer pxh;//排序号
	
	
	private Integer closeM;//每期关盘为开奖前几分
	
	
	private Integer closeS;//每期关盘为开奖前几秒
	
	private Integer isEnable;//是否启用 0否 1是
	
	private String handicapCode;//页面对应的大盘口
	
	private String handicapName;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
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

	public Integer getPxh() {
		return pxh;
	}

	public void setPxh(Integer pxh) {
		this.pxh = pxh;
	}

	public Integer getIsEnable() {
		return isEnable;
	}

	public void setIsEnable(Integer isEnable) {
		this.isEnable = isEnable;
	}

	public String getBigtypeCode() {
		return bigtypeCode;
	}

	public void setBigtypeCode(String bigtypeCode) {
		this.bigtypeCode = bigtypeCode;
	}

	public Integer getCloseM() {
		return closeM;
	}

	public void setCloseM(Integer closeM) {
		this.closeM = closeM;
	}

	public Integer getCloseS() {
		return closeS;
	}

	public void setCloseS(Integer closeS) {
		this.closeS = closeS;
	}

	public String getHandicapCode() {
		return handicapCode;
	}

	public void setHandicapCode(String handicapCode) {
		this.handicapCode = handicapCode;
	}

	public String getHandicapName() {
		return handicapName;
	}

	public void setHandicapName(String handicapName) {
		this.handicapName = handicapName;
	}	
}
