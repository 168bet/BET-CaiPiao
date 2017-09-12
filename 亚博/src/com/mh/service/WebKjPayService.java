package com.mh.service;

import java.util.List;

import com.mh.entity.WebKjPay;

public interface WebKjPayService {
	
	public WebKjPay getKjPay(Integer payType,Integer userType);
	
	public List<WebKjPay> getKjPayList();
	
	public int getPayCount(Integer type);
}
