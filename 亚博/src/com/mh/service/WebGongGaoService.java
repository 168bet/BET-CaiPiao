package com.mh.service;

import java.util.List;
import java.util.Map;

import com.mh.entity.WebGongGao;

public interface WebGongGaoService {
	
	
	/**
	 * 根据id查询公告信息
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * WebGongGao
	 */
	public WebGongGao getWebGongGaoById(Integer id);
	
	
	/**
	 * 获取公告列表
	 * 方法描述: TODO</br> 
	 * @param name
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getGongGaoList(String name);
	
	
	
	public List<WebGongGao> findList(String title);

}
