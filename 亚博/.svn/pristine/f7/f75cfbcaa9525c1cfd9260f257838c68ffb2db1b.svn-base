package com.mh.commons.cache;

import java.text.ParseException;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import com.danga.MemCached.MemCachedClient;
import com.mh.commons.conf.SharedConstants;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.SpringContextHolder;
@SuppressWarnings("all")
public class MemCachedUtil {
	// 创建全局的唯一实例
	
 
	protected static MemCachedClient memcachedClient;
	
	
	static{
		memcachedClient = (MemCachedClient) SpringContextHolder.getBean("memcachedClient");
	}
	
	/**
	 * 彩票
	 * 方法描述: TODO</br> 
	 * @param flag
	 * @throws ParseException  
	 * void
	 */
	public static void setCpNotice(String flag) throws ParseException {
		Map<String, String> voice = new HashMap<String, String>();
		String v = DateUtil.getDateString(new Date());
		voice.put("type", flag + SharedConstants.MEM_CACHE_NOTICE_CP);
		voice.put("value", v);
		
		set(voice.get("type"), voice);
	}
	
	
	
	
	/**
	 * 上线
	 * 方法描述: TODO</br> 
	 * @param flag
	 * @throws ParseException  
	 * void
	 */
	public static void setOnlineNotice(String flag) throws ParseException {
		Map<String, String> voice = new HashMap<String, String>();
		String v = DateUtil.getDateString(new Date());
		voice.put("type", flag + SharedConstants.MEM_CACHE_NOTICE_ONLINE);
		voice.put("value", v);
		
		set(voice.get("type"), voice);
	}

	/**
	 * 出款
	 * 方法描述: TODO</br> 
	 * @param flag
	 * @throws ParseException  
	 * void
	 */
	public static void setWithdrawNotice(String flag) throws ParseException {
 
		Map<String, String> voice = new HashMap<String, String>();
		String v = DateUtil.getDateString(new Date());
		voice.put("type", flag + SharedConstants.MEM_CACHE_NOTICE_WITHDRAW);
		voice.put("value", v);
		
		set(voice.get("type"), voice);
		
	}

	/**
	 * 入款
	 * 方法描述: TODO</br> 
	 * @param flag
	 * @throws ParseException  
	 * void
	 */
	public static void setDepositNotice(String flag) throws ParseException {

		Map<String, String> voice = new HashMap<String, String>();
		String v = DateUtil.getDateString(new Date());
		voice.put("type", flag + SharedConstants.MEM_CACHE_NOTICE_DEPOSIT);
		voice.put("value", v);
		
		set(voice.get("type"), voice);
		
	}
	
	
	/**
	 * 注册
	 * 方法描述: TODO</br> 
	 * @param flag
	 * @throws ParseException  
	 * void
	 */
	public static void setRegisterNotice(String flag) throws ParseException {
 
		Map<String, String> voice = new HashMap<String, String>();
		String v = DateUtil.getDateString(new Date());
		voice.put("type", flag + SharedConstants.MEM_CACHE_NOTICE_REGISTER);
		voice.put("value", v);
		
		set(voice.get("type"), voice);
		
	}
	
	/**
	 * 转换异常
	 * 方法描述: TODO</br> 
	 * @param flag
	 * @throws ParseException  
	 * void
	 */
	public static void setEduNotice(String flag) throws ParseException {
 
		Map<String, String> voice = new HashMap<String, String>();
		String v = DateUtil.getDateString(new Date());
		voice.put("type", flag + SharedConstants.MEM_CACHE_NOTICE_EDU);
		voice.put("value", v);
		
		set(voice.get("type"), voice);
		
	}

 
 

	/**
	 * 添加一个指定的值到缓存中.
	 * 
	 * @param key
	 * @param value
	 * @return
	 */
	public static boolean add(String key, Object value) {
		return memcachedClient.add(key, value);
	}

	public static boolean add(String key, Object value, Date expiry) {
		return memcachedClient.add(key, value, expiry);
	}

	public static boolean replace(String key, Object value) {
		return memcachedClient.replace(key, value);
	}

	public static boolean replace(String key, Object value, Date expiry) {
		return memcachedClient.replace(key, value, expiry);
	}

	public static boolean delete(String key) {
		return memcachedClient.delete(key);
	}

	/**
	 * 根据指定的关键字获取对象.
	 * 
	 * @param key
	 * @return
	 */
	public static Object get(String key) {
		return memcachedClient.get(key);
	}
	
	public static String getString(String key){
		return memcachedClient.get(key) == null ? null : (String)memcachedClient.get(key);
	}
	
	public static Map<String, String> getForMap(String key){
		return memcachedClient.get(key) == null ? null : (Map<String, String>)memcachedClient.get(key);
	}

	public static boolean flushAll() {
		return memcachedClient.flushAll();
	}

	public static boolean set(String key, Object value) {
		return memcachedClient.set(key, value);
	}

	public static boolean set(String key, Object value, Date expiry) {
		return memcachedClient.set(key, value, expiry);
	}
	/**
	 * 获取MemCached上所有的Items
	 * 
	 * @return
	 * @throws Exception
	 */
	public static Map<String, String> getKeysForMap() throws Exception {
		Map<String, String> keylist = new HashMap<String, String>();
		Map<String, Map<String, String>> statsItems = memcachedClient.statsItems();
		Map<String, String> statsItems_sub = null;
		String statsItems_sub_key = null;
		int items_number = 0;
		String server = null;
		Map<String, Map<String, String>> statsCacheDump = null;
		Map<String, String> statsCacheDump_sub = null;
		String statsCacheDumpsub_key = null;
		String statsCacheDumpsub_key_value = null;

		for (Iterator iterator = statsItems.keySet().iterator(); iterator.hasNext();) {
			server = (String) iterator.next();
			statsItems_sub = statsItems.get(server);
			for (Iterator iterator_item = statsItems_sub.keySet().iterator(); iterator_item.hasNext();) {
				statsItems_sub_key = (String) iterator_item.next();
				if (statsItems_sub_key.toUpperCase().startsWith("items:".toUpperCase()) && statsItems_sub_key.toUpperCase().endsWith(":number".toUpperCase())) {
					items_number = Integer.parseInt(statsItems_sub.get(statsItems_sub_key).trim());
					statsCacheDump = memcachedClient.statsCacheDump(new String[] { server }, Integer.parseInt(statsItems_sub_key.split(":")[1].trim()), items_number);
					for (Iterator statsCacheDump_iterator = statsCacheDump.keySet().iterator(); statsCacheDump_iterator.hasNext();) {
						statsCacheDump_sub = statsCacheDump.get(statsCacheDump_iterator.next());
						for (Iterator iterator_keys = statsCacheDump_sub.keySet().iterator(); iterator_keys.hasNext();) {
							statsCacheDumpsub_key = (String) iterator_keys.next();
							statsCacheDumpsub_key_value = statsCacheDump_sub.get(statsCacheDumpsub_key);
							keylist.put(statsCacheDumpsub_key, statsCacheDumpsub_key_value);
						}
					}
				}
			}
		}
		return keylist;

	}
}
