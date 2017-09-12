package com.mh.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebKjPayDao;
import com.mh.entity.WebKjPay;
import com.mh.service.WebKjPayService;

@Service
public class WebKjPayServiceImpl implements WebKjPayService {

	@Autowired
	private WebKjPayDao webKjPayDao;
	
 
	public WebKjPay getKjPay(Integer payType,Integer userType){
		return this.webKjPayDao.getKjPay(payType,userType);
	}


 
	public int getPayCount(Integer type) {
		return this.webKjPayDao.getPayCount(type);
	}



	public List<WebKjPay> getKjPayList() {
		return this.webKjPayDao.getKjPayList();
	}

}
