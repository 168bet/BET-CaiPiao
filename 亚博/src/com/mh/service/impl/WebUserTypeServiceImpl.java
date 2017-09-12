package com.mh.service.impl;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebUserTypeDao;
import com.mh.entity.WebUserType;
import com.mh.service.WebUserTypeService;

@Service
public class WebUserTypeServiceImpl implements WebUserTypeService {
	@Autowired
	private WebUserTypeDao webUserTypeDao;

	@Override
	public WebUserType getUserTypeById(Integer id) {
		return this.webUserTypeDao.get(id);
	}

}
