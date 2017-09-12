package com.mh.service;

import com.mh.entity.WebUserType;

public interface WebUserTypeService 
{
	/**
	 * 根据类型id获取用户类型信息
	 * @param id
	 * @return
	 */
	public WebUserType getUserTypeById(Integer id);
}
