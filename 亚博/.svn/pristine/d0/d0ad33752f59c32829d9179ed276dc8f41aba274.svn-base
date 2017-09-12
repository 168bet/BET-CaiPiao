/**   
* 文件名称: OrderService.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午1:20:13<br/>
*/  
package com.mh.service;

import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import com.mh.commons.orm.Page;
import com.mh.entity.CpOrder;

public interface CpOrderService {
	
	/**
	 * 统计订单列表
	 * 方法描述: TODO</br> 
	 * @param gameOrder
	 * @return  
	 * Map<String,Double>
	 */
	public Map<String,Object> getOrderTjList(CpOrder gameOrder);
	
	
	/**
	 * 统计下注金额
	 * 方法描述: TODO</br> 
	 * @param gameOrder
	 * @return  
	 * double
	 */
	public double getOrderTjXzje(CpOrder gameOrder);
	
	
	/**
	 * 根据订单号查询订单
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param orderNo
	 * @return  
	 * CpOrder
	 */
	public CpOrder getOrderByOrderNo(String userName,String orderNo);
	
	
	/**
	 * 中奖名单列表
	 * 方法描述: TODO</br> 
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getWinningList();
	public List<Map<String, Object>> getCpGameCodeList();

	public Page getOrderList(Page page ,CpOrder gameOrder);
	
	
	/**
	 * 用户号码限额统计
	 * @param order
	 * @return
	 */
	public double getUserSingleCreditForNumber(CpOrder order);
	
	
	/**
	 * 
	 * 方法描述:得到注单集合</br>
	 * 创建人: zoro<br/> 
	 * @param bean
	 * @return  
	 * List<CpOrder>
	 */
	public List<CpOrder> getOrderList(CpOrder bean);
	
	
	/**
	 * 统计注单
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param qs
	 * @return  
	 * Map<String,Object>
	 */
	public Map<String,Object> getBetOrderTj(String userName,String qs);
	
	/**
	 * 当期盘口限额统计
	 * @param order
	 * @return
	 */
	public Double getUserSingleCredit(CpOrder order);
	
	/**
	 * 更新订单
	 * 方法描述: TODO</br> 
	 * @param request
	 * @return  
	 * boolean
	 */
	public void updateOrder(HttpServletRequest request, String gameCode,
			String jsonData, String orderFlag);
	

}
