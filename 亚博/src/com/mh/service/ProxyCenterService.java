package com.mh.service;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public interface ProxyCenterService {
	void proxyCenter(HttpServletRequest request,HttpServletResponse response) throws Exception;
}
