package com.mh.commons.utils;

import java.util.List;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.alibaba.fastjson.JSON;

public class JackUtil {
	protected static Logger logger = LoggerFactory.getLogger(JackUtil.class);
	/**
	 * json反序列化java对象
	 * @param json
	 * @param objClass
	 * @return
	 */
	public static Object toBean(String json,Class<?> objClass){
		if(StringUtils.isEmpty(json)){
			throw new NullPointerException("json数据为空....");
		}
		//logger.info("缓存JSON:" + json);
		Object obj = JSON.parseObject(json, objClass);
		/*Object obj = null;
		ObjectMapper mapper = new ObjectMapper();
		try {
			obj = mapper.readValue(json, objClass);
		} catch (JsonParseException e) {
			e.printStackTrace();
		} catch (JsonMappingException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}*/
		return obj;
	}
	
	/**
	 * json反序列化集合  List
	 * @param mapper
	 * @param json
	 * @param objClass
	 * @return
	 */
	public static List<?> toList(String json,Class<?> objClass){
		if(StringUtils.isEmpty(json)){
			throw new NullPointerException("json数据为空....");
		}
		//List<?> list = null;
		//logger.info("缓存JSON:" + json);
		List<?> list = JSON.parseArray(json, objClass);
		/*ObjectMapper mapper = new ObjectMapper();
		try {
			list = mapper.readValue(json, getCollectionType(mapper, List.class,objClass));
		} catch (JsonParseException e) {
			e.printStackTrace();
		} catch (JsonMappingException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}*/
		return list;
	}
	
	
	/*public static JavaType getCollectionType(ObjectMapper mapper, Class<?> collectionClass, Class<?>... elementClasses) {
		return mapper.getTypeFactory().constructParametricType(collectionClass, elementClasses);
	}*/
}
