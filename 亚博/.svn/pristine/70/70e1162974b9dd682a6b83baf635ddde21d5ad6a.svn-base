package com.mh.commons.utils;

import java.math.BigDecimal;
import java.text.DateFormat;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Map;
import java.util.Random;
import java.util.TreeMap;

import org.apache.commons.lang.StringUtils;

import com.mh.commons.utils.ComparatorMapKey;
 
@SuppressWarnings("all")
public class ComUtil {

	public static String getSportsOrder() {
		SimpleDateFormat f = new SimpleDateFormat("yyMMddHHmmssSSS");
		return RandChars(3).toUpperCase() + f.format(new Date()) + getNumr(3);
	}

	public static String RandChars(int length) {
		String chars = "";
		for (int i = 0; i < length; i++) {
			int intValue = (int) (Math.random() * 26 + 97);
			chars = chars + (char) intValue;
		}
		return chars;

	}

	public static String getOnliePayOrder() {
		SimpleDateFormat f = new SimpleDateFormat("yyMMddHHmmssSSS");
		return f.format(new Date());
	}

	public static String getOrder() {
		SimpleDateFormat f = new SimpleDateFormat("yyMMddHHmmssSSS");
		return f.format(new Date());
	}

	public static String getAGBillno() {
		SimpleDateFormat f = new SimpleDateFormat("yyMMddHHmmssSSS");
		Random random = new Random();
		int rannum = (int) (random.nextDouble() * (9 - 1 + 1)) + 1;// 获取1位随机数
		return f.format(new Date()) + rannum;
	}
	
	public static String getSaOutBillNo(String userName){
		SimpleDateFormat f = new SimpleDateFormat("yyyyMMddHHmmss");
		return "OUT" + f.format(new Date()) + userName;
	}
	
	public static String getSaInBillNo(String userName){
		SimpleDateFormat f = new SimpleDateFormat("yyyyMMddHHmmss");
		return "IN" + f.format(new Date()) + userName;
	}
	

	public static String getCurrentDate() {
		SimpleDateFormat f = new SimpleDateFormat("yyyyMMdd");
		return f.format(new Date());
	}

	public static Date getDateByStr(String dateStr) throws ParseException {
		SimpleDateFormat f = new SimpleDateFormat("yyyy-MM-dd");
		return f.parse(dateStr);
	}

	public static String getStrByDate(Date date) throws ParseException {
		SimpleDateFormat f = new SimpleDateFormat("yyyy-MM-dd");
		return f.format(date);
	}

	public static String getDateString(Date date, String format) {
		SimpleDateFormat f = new SimpleDateFormat(format);
		return f.format(date);
	}

	public static String getCharAndNumr(int length) {
		String val = "";
		Random random = new Random();
		for (int i = 0; i < length; i++) {
			String charOrNum = random.nextInt(2) % 2 == 0 ? "char" : "num"; // 输出字母还是数字

			if ("char".equalsIgnoreCase(charOrNum)) // 字符串
			{
				int choice = 97; // 取得大写字母65还是小写字母97
				val += (char) (choice + random.nextInt(26));
			} else if ("num".equalsIgnoreCase(charOrNum)) // 数字
			{
				val += String.valueOf(random.nextInt(10));
			}
		}

		return val;
	}

	public static String getNumr(int length) {
		String val = "";
		Random random = new Random();
		for (int i = 0; i < length; i++) {
			val += String.valueOf(random.nextInt(10));
		}
		return val;
	}

	public static boolean isNotBlank(String str) {
		if (StringUtils.isBlank(str)) {
			return false;
		} else if (StringUtils.equalsIgnoreCase(str, "null")) {
			return false;
		}
		return true;
	}

	public static void sqlFieldAndValue(StringBuffer value, StringBuffer fields, String field, Object o) throws ParseException {
		if (o != null) {
			if (o instanceof Double || o instanceof Integer) {
				fields.append(field).append(",");
				value.append(o.toString()).append(",");
			} else if (o instanceof String && StringUtils.isNotBlank(o.toString()) && !StringUtils.equalsIgnoreCase(o.toString(), "null")) {
				fields.append(field).append(",");
				value.append("'").append(o.toString()).append("',");
			} else if (o instanceof Date) {
				fields.append(field).append(",");
				value.append("'").append(DateUtil.getDateString((Date) o)).append("',");
			}
		}
	}

	public static void sqlUpdateValue(StringBuffer update, String field, Object o) throws ParseException {
		if (o != null) {
			if (o instanceof Double || o instanceof Integer) {
				update.append(field).append("=").append(o.toString()).append(",");
			} else if (o instanceof String && StringUtils.isNotBlank(o.toString()) && !StringUtils.equalsIgnoreCase(o.toString(), "null")) {
				update.append(field).append("='").append(o.toString()).append("',");
			} else if (o instanceof Date) {
				update.append(field).append("='").append(DateUtil.getDateString((Date) o)).append("',");
			}
		}
	}

//	public static Map<String, String> sortMapByKey(Map<String, String> map) {
//		if (map == null || map.isEmpty()) {
//			return null;
//		}
//		Map<String, String> sortMap = new TreeMap<String, String>(new ComparatorMapKey());
//		sortMap.putAll(map);
//		return sortMap;
//
//	}

	public static String getMinSecondByMsec(int millisecond) {
		Date date = new Date(millisecond);
		DateFormat df = new SimpleDateFormat("mm:ss");
		return df.format(date);
	}

	public static Date addDateTime(Date date, long millis) {
		return new Date(date.getTime() + millis);
	}

	public static Date minusDateTime(Date date, long millis) {
		return new Date(date.getTime() - millis);
	}

	public static String trim(String str) {
		return str.replace("   ", "").replace("  ", "").replace("	", "").replace(" ", "");
	}

	/** 值不通用太大 **/
	public static double decimalFormat(double value) {
		BigDecimal b = new BigDecimal(value);
		return b.setScale(2, BigDecimal.ROUND_HALF_UP).doubleValue();
	}

	public static String decimalFormat2(double value) {
		DecimalFormat df = new DecimalFormat("#.00");
		return df.format(value);
	}

	/**
	 * 两个Double数相加
	 * 
	 * @param v1
	 * @param v2
	 * @return Double
	 */
	public static Double doubleAdd(Double v1, Double v2) {
		BigDecimal b1 = new BigDecimal(v1.toString());
		BigDecimal b2 = new BigDecimal(v2.toString());
		return b1.add(b2).doubleValue();
	}

	/**
	 * 两个Double数相减
	 * 
	 * @param v1
	 * @param v2
	 * @return Double
	 */
	public static Double doubleSub(Double v1, Double v2) {
		BigDecimal b1 = new BigDecimal(v1.toString());
		BigDecimal b2 = new BigDecimal(v2.toString());
		return b1.subtract(b2).doubleValue();
	}

	/**
	 * 两个Double数相乘
	 * 
	 * @param v1
	 * @param v2
	 * @return Double
	 */
	public static Double doubleMul(Double v1, Double v2) {
		BigDecimal b1 = new BigDecimal(v1.toString());
		BigDecimal b2 = new BigDecimal(v2.toString());
		return b1.multiply(b2).doubleValue();
	}

	/**
	 * 两个Double数相除
	 * 
	 * @param v1
	 * @param v2
	 * @return Double
	 */
	public static Double doubleDiv(Double v1, Double v2) {
		BigDecimal b1 = new BigDecimal(v1.toString());
		BigDecimal b2 = new BigDecimal(v2.toString());
		return b1.divide(b2, 10, BigDecimal.ROUND_HALF_UP).doubleValue();
	}

	/**
	 * 两个Double数相除，并保留scale位小数
	 * 
	 * @param v1
	 * @param v2
	 * @param scale
	 * @return Double
	 */
	public static Double doubleDiv(Double v1, Double v2, int scale) {
		if (scale < 0) {
			throw new IllegalArgumentException("The scale must be a positive integer or zero");
		}
		BigDecimal b1 = new BigDecimal(v1.toString());
		BigDecimal b2 = new BigDecimal(v2.toString());
		return b1.divide(b2, scale, BigDecimal.ROUND_HALF_UP).doubleValue();
	}

	
	public static Double isNullOrBlank(Double dou){
		if(null != dou && !"".equals(dou) ){
			return dou;
		}else{
			return 0.0;
		}
	}
	
	public static Double isNullOrBlank(String str){
		if(null != str && !"".equals(str) ){
			return Double.parseDouble(str);
		}else{
			return 0.0;
		}
	}
	
	public static Map<String, String> sortMapByKey(Map<String, String> map) {
		if (map == null || map.isEmpty()) {
			return null;
		}
		Map<String, String> sortMap = new TreeMap<String, String>(new ComparatorMapKey());
		sortMap.putAll(map);
		return sortMap;

	}
}
