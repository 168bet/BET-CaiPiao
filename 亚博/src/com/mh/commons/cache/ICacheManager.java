package com.mh.commons.cache;

import java.util.Map;


@SuppressWarnings("all")
public interface ICacheManager {
	
	/**
	 * 启动时，从数据库获取所有缓存数据，放入缓存中
	 */
	void initCacheData();
	
	/**
	 * 
	 * @Title: initCache 
	 * @Description: 初始化缓存管理器
	 * @param     设定文件 
	 * @return void    返回类型 
	 * @throws
	 */
	void initCache();
	
	/**
	 * 往本缓中存入一条记录，如果key已存在，则覆盖并返回原值
	 * 参考MAP的put方法
	 * @param key
	 * @param value
	 * @return
	 */
	void put(Object key, Object value);
	
	/**
	 * 根据key获取缓存记录数据
	 * @param key
	 * @return
	 */
	Object get(Object key);
	
	/**
	 * 删除键为KEY的缓存记录
	 * @param key
	 */
	void evict(Object key);
	
	/**
	 * 清除该缓存实例的所有缓存记录
	 */
	void clear();
	
	/**
	 * 重新刷新该缓存记录，通常是clear()和initCacheFormSql()的组合
	 */
	void refresh();
	
	/**
	 * 
	 * @Title: put 
	 * @Description: 将Map映射到缓存中
	 * @param @param map    设定文件 
	 * @return void    返回类型 
	 * @throws
	 */
	public void put(Map map);
}
