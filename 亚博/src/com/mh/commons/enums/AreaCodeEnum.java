package com.mh.commons.enums;

/**
 * 
 * Title:ISS <br/>
 * Description: 区域编码<br/>
 * Copyright: Copyright (c) 2011-8-18<br/>
 * Company: HWTT<br/>
 * 
 * @author wangzx
 * @version 1.0
 */
public enum AreaCodeEnum {
	//所对应的字典CODE
	DICT_CODE("ABSTRACT_DICT_CITY_AREA_CODE","城市编码在字典中的编码"),
	
//------------------字典元素CODE--------------
	
	FUJIAN("590","福建"),
	FUZHOU("591","福州"),   
	XIAMEN("592","厦门"),   
	NINGDE("593","宁德"),  
	PUTIAN("594","莆田"), 
	QUANZHOU("595","泉州"),
	ZHANGZHOU("596","漳州"),
	LONGYAN("597","龙岩"),  
	SANMING("598","三明"),  	
	NANPING("599","南平"),
	PINGTAN("589","平潭");  

	private String value;
	private String desc;

	AreaCodeEnum(String value, String desc) {
		this.value = value;
		this.desc = desc;
	}

	public String getValue() {
		return value;
	}

	public String getDesc() {
		return desc;
	}

	public static boolean isValue(Integer value) {
		for (AreaCodeEnum u : AreaCodeEnum.values()) {
			if (value != null && u.getValue().equals(value.toString()))
				return true;
		}
		return false;
	}

	public static boolean isValue(String value) {
		for (AreaCodeEnum u : AreaCodeEnum.values()) {
			if (u.getValue().equals(value))
				return true;
		}
		return false;
	}

	public static AreaCodeEnum valueOf(Integer value) {
		for (AreaCodeEnum ft : AreaCodeEnum.values()) {
			if (value != null && ft.getValue().equals(value.toString()))
				return ft;
		}
		return null;
	}

	@Override
	public String toString() {
		return "AreaCode{" + "value=" + value + "desc=" + desc + '}';
	}

}