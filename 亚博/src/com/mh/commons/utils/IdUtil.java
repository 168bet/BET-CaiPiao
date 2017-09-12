package com.mh.commons.utils;

import java.lang.reflect.Field;
import java.util.ArrayList;
import java.util.List;

import org.apache.commons.lang3.StringUtils;
import org.apache.commons.lang3.reflect.FieldUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@SuppressWarnings("all")
public class IdUtil {
	
	private static final Logger logger = LoggerFactory.getLogger(IdUtil.class);

	/**
	 * 将以多个ID组成的字符串，分割组装成List<Long> 
	 * 默认分割为","
	 * @param ids 多个ID组成的字符串
	 * @return
	 */
	public static List<Long> splitIds(String ids){
		return splitIds(ids, ",");
	}
	
	/**
	 * 将以多个ID组成的字符串，分割组装成List<Long> 
	 * @param ids 多个ID组成的字符串
	 * @param splitStr 分割符
	 * @return
	 */
	public static List<Long> splitIds(String ids, String splitStr){
		if(StringUtils.isBlank(ids))
			return null;
		if(StringUtils.isBlank(splitStr)){
			splitStr = ",";
		}
		String[] idS = ids.split(splitStr);
		List<Long> list = new ArrayList<Long>(idS.length);
		for(String id : idS){
			if(StringUtils.isNotBlank(id))
				try {
					list.add(Long.valueOf(id.trim()));
				} catch (NumberFormatException e) {
					e.printStackTrace();
					logger.error("ID转换成Long类型出错", e);
					throw Exceptions.unchecked("ID转换成Long类型出错", e);
				}
		}
		return list;
	}
	
	/**
	 * 默认 "," 拼接ID列表 为字符串
	 * @param idList ID列表
	 * @return
	 */
	public static String joinIds(List<Long> idList){
		return joinIds(idList, ",");
	}
	
	/**
	 * 以拼接符 拼接ID列表 为字符串
	 * @param idList  ID列表
	 * @param joinStr  拼接符
	 * @return
	 */
	public static String joinIds(List<Long> idList, String joinStr){
		return joinList(idList, joinStr);
	}
	
	/**
	 * 默认 "," 拼接列表 为字符串
	 * @param list
	 * @return
	 */
	@SuppressWarnings(value="unchecked")
	public static String joinList(List list){
		return joinIds(list, ",");
	}
	
	/**
	 * 以拼接符 拼接ID列表 为字符串
	 * @param list
	 * @param joinStr
	 * @return
	 */
	public static String joinList(List list, String joinStr){
		if(list == null || list.size()<1)
			return "";
		if(StringUtils.isBlank(joinStr)){
			joinStr = ",";
		}
		StringBuilder strb = new StringBuilder();
		for(Object obj : list){
			if(obj != null){
				strb.append(",").append(obj.toString());
			}
		}
		if(strb.length() > 0)
			return strb.substring(1);
		return "";
	}
	
	public static String joinEntityList(List<?> list, String attrName) {
		return joinEntityList(list, attrName, ",");
	}
	
	public static String joinEntityList(List<?> list, String attrName, String joinStr) {
		if(list == null || list.size()<1 || StringUtils.isBlank(attrName))
			return null;
		StringBuilder strb = new StringBuilder();
		for(Object obj : list){
			if(obj == null)
				continue;
			Field[] fields =  obj.getClass().getDeclaredFields();
			if(fields != null && fields.length > 0){
				for(Field field : fields){
					if(field.getName().equals(attrName)){
						Object val;
						try {
							val = FieldUtils.readField(field, obj, true);
						} catch (IllegalAccessException e) {
							e.printStackTrace();
							throw new RuntimeException("读取属性 ["+attrName+"] 值出错");
						}
						if(val != null && StringUtils.isNotBlank(val.toString()))
							strb.append(joinStr).append(val.toString().trim());
					}
				}
			}
		}
		if(strb.length() > joinStr.length()){
			return strb.substring(joinStr.length());
		}
		return strb.toString();
	}
	
}
