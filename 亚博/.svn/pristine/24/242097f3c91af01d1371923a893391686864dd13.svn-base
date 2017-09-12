package com.mh.commons.cache;

import java.util.Iterator;
import java.util.Map;
import java.util.Set;

import javax.annotation.PostConstruct;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.cache.Cache;
import org.springframework.cache.Cache.ValueWrapper;
import org.springframework.cache.ehcache.EhCacheCacheManager;

@SuppressWarnings("all")
public abstract class SimpleCacheManager implements ICacheManager {
	
	@Autowired
	protected EhCacheCacheManager springCacheManager;
	
	protected Cache springCache;
	
	public abstract String getCacheKey();
	
	public void clear() {
		springCache.clear();
	}

	public Object get(Object key) {
		ValueWrapper valueWrapper = springCache.get(key);
		if(valueWrapper != null)
			return springCache.get(key).get();
		else return null;
	}

	public abstract void initCacheData();

	public void put(Object key, Object value) {
		springCache.put(key, value);
	}

	public void refresh(){
		this.clear();
		this.initCacheData();
	}

	public void evict(Object key) {
		springCache.evict(key);
	}
	
	public void put(Map map){
		Set<Map.Entry> set = map.entrySet();
		for (Iterator<Map.Entry> it = set.iterator(); it.hasNext();) {
			 Map.Entry entry = (Map.Entry) it.next();
			 this.put(entry.getKey(), entry.getValue());
		}
	}
	
	/**
	 * 执行先后顺序: Constructor > @PostConstruct > InitializingBean > init-method
	 */
	@PostConstruct 
	public void initCache(){
		springCache = this.springCacheManager.getCache(getCacheKey());
		if(this.springCache == null)
			throw new RuntimeException("请检查ehcache.xml 中是否配置 name="+getCacheKey());

		initCacheData();
	}	

}
