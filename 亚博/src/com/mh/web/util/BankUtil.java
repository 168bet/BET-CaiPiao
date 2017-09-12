/**   
* 文件名称: BankUtil.java<br/,"
* 版本号: V1.0<br/,"   
* 创建人: alex<br/,"  
* 创建时间 : 2017-1-25 上午2:28:01<br/,"
*/  
package com.mh.web.util;

import java.util.HashMap;
import java.util.Map;

import com.mh.commons.constants.WebConstants;

/** 
 * 获取第三方银行列表
 * 类描述: TODO 
 * 创建人: TODO alex 
 * 创建时间: 2017-1-25 上午2:28:01
 */
public class BankUtil {

	
	/**
	 * 获取银行map
	 * 方法描述: TODO</br," 
	 * @param payType
	 * @return  
	 * Map<String,String,"
	 */
	public static Map<String,String> getBankMap(String payType){
		Map<String,String> allMap = new HashMap<String,String>();
		
		if(WebConstants.PAY_YOMPAY_TYPE.equals(payType)){//优付支付
			allMap = getYompayMap();
		}else if(WebConstants.PAY_V9PAY_TYPE.equals(payType)){//银宝支付
			allMap = getV9payMap();
			
		}
		
		return allMap;
		
		
	}
 
	
	/**
	 * 优付
	 * 方法描述: TODO</br," 
	 * @return  
	 * Map<String,String,"
	 */
	public static Map<String,String> getYompayMap(){
		Map<String,String> allMap = new HashMap<String,String>();
		
		allMap.put("WEIXIN", "微信扫码支付");
		allMap.put("ALIPLY", "支付宝扫码支付");
		
		allMap.put("ABC", "农业银行");
		allMap.put("BOC", "中国银行");
		allMap.put("BOCOM", "交通银行");
		allMap.put("CCB", "建设银行");
		allMap.put("ICBC", "工商银行");
		allMap.put("PSBC", "邮政储蓄银行");
		allMap.put("CMBC", "招商银行");
		allMap.put("SPDB", "浦发银行");
		allMap.put("CEBBANK","光大银行");
        allMap.put("ECITIC","中信银行");
        allMap.put("PINGAN","平安银行");

        allMap.put("CMBCS","民生银行");
        allMap.put("HXB","华夏银行");
        allMap.put("CGB","广发银行");
        allMap.put("BCCB","北京银行");
        allMap.put("CIB","兴业银行");
		
		
		return allMap;
	}
	
	/**
	 * 银宝支付
	 * 方法描述: TODO</br," 
	 * @return  
	 * Map<String,String,"
	 */
	public static Map<String,String> getV9payMap(){
		
		Map<String,String> allMap = new HashMap<String,String>();
		allMap.put("ICBC","工商银行");
		allMap.put("ABC","农业银行");
		allMap.put("CCB","建设银行");
		allMap.put("BOC","中国银行");
		allMap.put("CMB","招商银行");
		allMap.put("BOCO","交通银行");
		allMap.put("CIB","兴业银行");
		allMap.put("PINGANBANK","平安银行");
		allMap.put("CMBC","民生银行");
		allMap.put("CEB","光大银行");
		allMap.put("PSBS","中国邮政");
		allMap.put("HXB","华夏银行");
		allMap.put("CTTIC","中信银行");
		allMap.put("GDB","广发银行");
		allMap.put("BCCB","北京银行");
		allMap.put("NJCB","南京银行");

		allMap.put("CBHB","渤海银行");
		allMap.put("HKBEA","东亚银行");
		allMap.put("NBCB","宁波银行");
		allMap.put("SHB","上海银行");
		allMap.put("SPDB","上海浦东发展银行");
		allMap.put("BJRCB","北京农村商业银行");
		allMap.put("SRCB","上海农商银行");
		allMap.put("SDB","深圳发展银行");
		allMap.put("CZB","浙江稠州商业银行");
		
		return allMap;
	}
	
}
