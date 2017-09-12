package com.mh.service.impl;

import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.commons.orm.Page;
import com.mh.dao.LotteryCenterDao;
import com.mh.service.LotteryCenterService;
@Service
public class LotteryCenterServiceImpl implements LotteryCenterService{
	@Autowired
	private LotteryCenterDao lotteryCenterDao;
	@Override
	public Page getAllGameTypeNewResultList(Page page,Map<String, String> map) {
		
		return lotteryCenterDao.getAllGameTypeNewResultList(page,map);
	}
	
}
