/**   
* 文件名称: CpCommonConstant.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-4-4 上午10:51:25<br/>
*/  
package com.mh.commons.constants;

import java.util.LinkedHashMap;
import java.util.Map;



/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-4-4 上午10:51:25<br/>
 */
public class CpCommonConstant {

	public static String all_bet = "";
	public static String all="";
	public static StringBuffer buf = new StringBuffer();

	public static Map<String,String> openPanMap = new LinkedHashMap<String,String>();
	static{
		openPanMap.put(CpCommonConstant.CQSSC_CODE_PARAM, "10:00:00");
		openPanMap.put(CpCommonConstant.JXSSC_CODE_PARAM, "10:10:00");
		openPanMap.put(CpCommonConstant.TJSSC_CODE_PARAM, "09:09:00");
		
		openPanMap.put(CpCommonConstant.TJKLSF_CODE_PARAM, "09:04:00");
		openPanMap.put(CpCommonConstant.GDKLSF_CODE_PARAM, "09:10:00");
		
		
		openPanMap.put(CpCommonConstant.BJPK10_CODE_PARAM, "09:06:00");
		openPanMap.put(CpCommonConstant.BJKL8_CODE_PARAM, "09:02:00");
	}
		
	//--------------------------------------------彩票代码-----------------------------------------	
	
	//彩票代码值
	//六合彩
	public static final String HK_CODE_PARAM="HK6";
	public static final String SSC_CODE_PARAM="SSC";
	//福彩3D
	public static final String FC3D_CODE_PARAM="FC3D";
	//排列3
	public static final String PL3_CODE_PARAM="PL3";
	//重庆时时彩
	public static final String CQSSC_CODE_PARAM="CQSSC";
	//江西时时彩
	public static final String JXSSC_CODE_PARAM="JXSSC";
	//天津时时彩
	public static final String	TJSSC_CODE_PARAM="TJSSC";
	//新疆时时彩
	public static final String XJSSC_CODE_PARAM="XJSSC";
	//天津快乐十分
	public static final String TJKLSF_CODE_PARAM="TJKLSF";
	//广东快乐十分
	public static final String GDKLSF_CODE_PARAM="GDKLSF";
	//北京pk拾
	public static final String BJPK10_CODE_PARAM="BJPK10";
	//幸运28
	public static final String BJKL8_CODE_PARAM="BJKL8";

	//加拿大28
	public static final String CAKENO_CODE_PARAM="CAKENO";
	
	public static final String BIGTYPE_SSC= "SSC";
	public static final String BIGTYPE_HK6= "HK6";
	public static final String BIGTYPE_FTC= "FTC";
	public static final String BIGTYPE_PK10= "PK10";
	public static final String BIGTYPE_KLSF= "KLSF";
	public static final String BIGTYPE_KL8= "KL8";
	
	
	public final static String SZ="sz";
	public final static String BSGDW="bsgdw";
	public final static String CP_FC3D_SZ_NUMBER="CP_FC3D_SZ_NUMBER";
 
	public final static int FIVE=5;//福彩3D表头循环
 
	public final static int QIAN=1000;//福彩3D百十个定位循环次数
	//福彩3D百十个定位 拼接UID次数
	public final static int TEN=10;
	public final static int BAI=100;
	public final static int ZERO=0;
	
	public final static String TMSB= "TMSB";
	
	public final static Integer IS_ENABLE = 0;//是否启用 0：停用 1：启用
	
	public static final String CACHE_RESULT_CODE="_result_";
	public static final String CACHE_TOM_CODE = "_tom_";
	
	
}
