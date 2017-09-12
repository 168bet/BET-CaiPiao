package com.mh.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebGongGaoDao;
import com.mh.entity.WebGongGao;
import com.mh.service.WebGongGaoService;

@Service
public class WebGongGaoServiceImp implements WebGongGaoService{
	
	@Autowired
	private WebGongGaoDao webGongGaoDao;
	
	
	/**
	 * 根据id查询公告信息
	 * 方法描述: TODO</br> 
	 * @param id
	 * @return  
	 * WebGongGao
	 */
	public WebGongGao getWebGongGaoById(Integer id){
		return this.webGongGaoDao.get(id);
	}
	
	
	/**
	 * 获取公告列表
	 * 方法描述: TODO</br> 
	 * @param name
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getGongGaoList(String name){
		return this.webGongGaoDao.getGongGaoList(name);
	}


	@Override
	public List<WebGongGao> findList(String name) {
		return this.webGongGaoDao.findList(name);
	}

}
