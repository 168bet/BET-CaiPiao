package com.mh.service;

import java.util.List;
import java.util.Map;

import com.mh.commons.orm.Page;
import com.mh.entity.TWebThirdPay;
import com.mh.entity.WebBank;
import com.mh.entity.WebBankHuikuan;

public interface WebBankHuikuanService {
	
	/**
	 * 统计代理会员存款列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public Map<String,Object> getWebBankHuikuanTjList(WebBankHuikuan huikuan);
	
	
	/**
	 * 统计代理会员存款
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * double
	 */
	public double getWebBankHuikuanTj(WebBankHuikuan huikuan);
	
	/**
	 * 汇款流水列表
	 * 方法描述: TODO</br> 
	 * @param huikuan
	 * @return  
	 * List<WebBankHuikuan>
	 */
	public Page getWebBankHuikuanList(Page page,WebBankHuikuan huikuan);
	
	/**
	 * 获取银行列表
	 * 方法描述: TODO</br> 
	 * @param userTypeId
	 * @return  
	 * List<WebBank>
	 */
	public List<WebBank> getWebBankList(Integer userTypeId);
	
	
	/**
	 * 获取第三方支付列表
	 * 方法描述: TODO</br> 
	 * @param userTypeId
	 * @return  
	 * List<WebBank>
	 */
	public List<TWebThirdPay> getWebThirdPayList(Integer userTypeId);
	
	
	public void saveWebBankHuikuan(WebBankHuikuan huikuan);
	
	/**
	 * 统计汇款
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param startTimeStr
	 * @param endTimeStr
	 * @return  
	 * int
	 */
	public Map<String, Integer> getWebBankHuikuanTj(String userName,String currDateStr);
	
}
