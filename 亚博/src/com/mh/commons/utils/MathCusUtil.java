/**   
* 文件名称: MathCusUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-22 下午2:36:45<br/>
*/  
package com.mh.commons.utils;

import java.text.DecimalFormat;
import java.util.regex.Pattern;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-22 下午2:36:45<br/>
 */
public class MathCusUtil {

	public static double dobuleTwoPoints(double f) {
		DecimalFormat df = new DecimalFormat("#.00");
		return Double.parseDouble(df.format(f));
	}

	public static String dobuleTwoPointsStr(String f) {
		DecimalFormat df = new DecimalFormat("#.00");
		return df.format(Double.parseDouble(f));
	}

	public static boolean isDouble(String str) {
		String regEx = "\\d+\\.\\d+";
		return Pattern.matches(regEx, str);
	}
}
