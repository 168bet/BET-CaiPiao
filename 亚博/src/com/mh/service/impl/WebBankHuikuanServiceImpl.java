package com.mh.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.commons.orm.Page;
import com.mh.dao.WebBankHuikuanDao;
import com.mh.entity.TWebThirdPay;
import com.mh.entity.WebBank;
import com.mh.entity.WebBankHuikuan;
import com.mh.service.WebBankHuikuanService;
@Service
public class WebBankHuikuanServiceImpl implements WebBankHuikuanService{
	@Autowired
	private WebBankHuikuanDao webBankHuikuanDao;
	
	
	/**
	 * 统计代理会员存款列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebBankHuikuanTjList(WebBankHuikuan huikuan){
		return this.webBankHuikuanDao.getWebBankHuikuanTjList(huikuan);
	}
	
	
	/**
	 * 统计代理会员存款
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public double getWebBankHuikuanTj(WebBankHuikuan huikuan){
		return this.webBankHuikuanDao.getWebBankHuikuanTj(huikuan);
	}
	
	
	
	public Page getWebBankHuikuanList(Page page,WebBankHuikuan huikuan) {
		return webBankHuikuanDao.getWebBankHuikuanList(page,huikuan);
	}
	
	/**
	 * 获取银行列表
	 * 方法描述: TODO</br> 
	 * @param userTypeId
	 * @return  
	 * List<WebBank>
	 */
	public List<WebBank> getWebBankList(Integer userTypeId){
		return this.webBankHuikuanDao.getWebBankList(userTypeId);
	}
	
	
	/**
	 * 获取第三方支付列表
	 * 方法描述: TODO</br> 
	 * @param userTypeId
	 * @return  
	 * List<WebBank>
	 */
	public List<TWebThirdPay> getWebThirdPayList(Integer userTypeId){
		return this.webBankHuikuanDao.getWebThirdPayList(userTypeId);
	}
	
	public void saveWebBankHuikuan(WebBankHuikuan huikuan){
		
		this.webBankHuikuanDao.saveOrUpdate(huikuan);
	}
	
	/**
	 * 统计汇款
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param startTimeStr
	 * @param endTimeStr
	 * @return  
	 * int
	 */
	public Map<String, Integer> getWebBankHuikuanTj(String userName,String currDateStr){
		return this.webBankHuikuanDao.getWebBankHuikuanTj(userName, currDateStr);
	}


}
