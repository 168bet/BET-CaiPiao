package com.mh.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.commons.orm.Page;
import com.mh.dao.WebAccountDao;
import com.mh.entity.CpParameter;
import com.mh.entity.WebAccounts;
import com.mh.service.WebAccountService;

@SuppressWarnings("all")
@Service
public class WebAccountServiceImpl implements WebAccountService{
	@Autowired
	private WebAccountDao webAccountDao;
	
	
	
	public Page getWebAccountList(Page page,WebAccounts webAccount) {
		return webAccountDao.getWebAccountList(page,webAccount);
	}
	public List<Map<String, Object>> getactOpttype() {
		return webAccountDao.getactOpttype();
	}
	

}
