/**   
* 文件名称: OrderServiceImpl.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午1:20:49<br/>
*/  
package com.mh.service.impl;

import java.util.Date;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import app.xb.cmbase.model.CpConfig;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.conf.CpConfigCache;
import com.mh.commons.orm.Page;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.IPSeeker;
import com.mh.commons.utils.MathUtil;
import com.mh.commons.utils.OrderNoUtils;
import com.mh.dao.CpOrderDao;
import com.mh.dao.WebAccountsDao;
import com.mh.dao.WebUserDao;
import com.mh.entity.CpOrder;
import com.mh.entity.CpParameter;
import com.mh.entity.CpTomResults;
import com.mh.entity.WebUser;
import com.mh.service.CpOrderService;
import com.mh.service.GameResultsService;
import com.mh.web.login.UserContext;

@SuppressWarnings("all")
@Service
public class CpOrderServiceImpl implements CpOrderService{
	
	@Autowired
	private CpOrderDao cpOrderDao;
	@Autowired
	private WebUserDao webUserDao;
	@Autowired
	private GameResultsService gameResultsService;
	@Autowired
	private WebAccountsDao webAccountsDao;
	
	
	/**
	 * 统计订单列表
	 * 方法描述: TODO</br> 
	 * @param gameOrder
	 * @return  
	 * Map<String,Double>
	 */
	public Map<String,Object> getOrderTjList(CpOrder gameOrder){
		return this.cpOrderDao.getOrderTjList(gameOrder);
	}
	
	
	/**
	 * 统计下注金额
	 * 方法描述: TODO</br> 
	 * @param gameOrder
	 * @return  
	 * double
	 */
	public double getOrderTjXzje(CpOrder gameOrder){
		return this.cpOrderDao.getOrderTjXzje(gameOrder);
	}
	
	/**
	 * 根据订单号查询订单
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param orderNo
	 * @return  
	 * CpOrder
	 */
	public CpOrder getOrderByOrderNo(String userName,String orderNo){
		return this.cpOrderDao.getOrderByOrderNo(userName, orderNo);
	}
	
	
	/**
	 * 更新订单
	 * 方法描述: TODO</br> 
	 * @param request
	 * @return  
	 * boolean
	 */
	public void updateOrder(HttpServletRequest request, String gameCode,
			String jsonData, String orderFlag){
		 
		try {
			if ("normal".equals(orderFlag)) {//常规订单
				 this.updateNormalOrder(request, gameCode, jsonData);
			}
//			else if("cl".equals(orderFlag)){//串连订单
//				orderList = this.updateClOrder(request, gameCode, jsonData);
//			}else if("mul".equals(orderFlag)){//组合订单
//				orderList = this.updateMulOrder(request, gameCode, jsonData);
//			}else if("lm".equals(orderFlag)){//连码订单
//				orderList = this.updateLmOrder(request, gameCode, jsonData);
//			}else if("group".equals(orderFlag)){//时时彩 福彩3d pl3
//				orderList = this.updateGroupOrder(request, gameCode, jsonData);
//			}else if("yzgg".equals(orderFlag)){//一字过关
//				orderList = this.updateYzggOrder(request, gameCode, jsonData);
//			}
			/*int resultCode = this.webAccountsDao.saveShareadOrder(orderList);//shared订单
			if(resultCode != 200){
				throw new RuntimeException("注单提交失败");
			}*/
		} catch (Exception e) {
			e.printStackTrace();
			throw new RuntimeException("注单提交失败");
		}
	}
	
	/**
	 * 更新常规订单
	 * 方法描述: TODO</br> 
	 * @param request
	 * @return  
	 * boolean
	 */
	public void updateNormalOrder(HttpServletRequest request,String gameCode,String jsonData){
		JSONArray jsonArray=JSONArray.parseArray(jsonData);
		UserContext userContext = (UserContext)request.getSession().getAttribute(CommonConstant.USER_CONTEXT_KEY);
		if(userContext==null){
			throw new RuntimeException("用户未登陆异常！");
		}
		String userName = userContext.getUserName();
		WebUser webUser = this.webUserDao.findWebrUseByUserName(userName);
 
		CpTomResults tomResults = this.gameResultsService.getTomResults(gameCode);
 
		for(int i=0;i<jsonArray.size();i++){
			JSONObject json=jsonArray.getJSONObject(i);
			String uid = json.getString("uid");
			String uidKey=gameCode+"-"+json.getString("uid");
			//  右边的快捷下注
			double xzje = json.getDoubleValue("xzje");
			//  左边的特码快捷下注
			double xzjeFast =  json.getDoubleValue("val");
			String number = json.getString("number");
			if( 0.0==xzje && 0.0==xzjeFast ){
				throw new RuntimeException("下注金额为0！");
			}else{
				xzje = ( 0.0==xzje  ? xzjeFast : xzje );
			}
			
			CpConfig config = CpConfigCache.UID_CACHE_KEY.get(uidKey);
			
			Date currDate = DateUtil.currentDate();
			Date gtDate = DateUtil.getGMT_4_Date();
			String orderNo = OrderNoUtils.getOrderNo(gameCode);

			CpOrder order = new CpOrder();

			double rate = config.getPl();
			double zgje = MathUtil.mul(xzje, rate);
			double kyje = MathUtil.sub(zgje, xzje);
	 
			order.setYj(0D);
			order.setKyje(kyje);
			order.setZgje(zgje);
			order.setXzje(xzje);
			order.setPl(String.valueOf(config.getPl()));
			if(!"TM-KL8TM-TMSB".equals(uid)){
				number = config.getNumber();
			}
			order.setNumber(number);
			
			
			order.setCfgId(config.getId()+"");
			order.setGameTypeCode(config.getGameTypeCode());
			order.setGameTypeName(config.getGameTypeName());
			order.setCpTypeCode(config.getCpTypeCode());
			order.setCpTypeName(config.getCpTypeName());
			order.setCpCateCode(config.getCpCateCode());
			order.setCpCateName(config.getCpCateName());
			order.setXzlxCode(config.getXzlxCode());
			order.setXzlxName(config.getXzlxName());
			order.setXzzuCode(config.getXzzuCode());
			order.setXzzuName(config.getXzzuName());
		 
			order.setBackWaterRate(config.getBackWater()==null?0:config.getBackWater());
			order.setQs(tomResults.getFormatQs());
			StringBuffer contentBuffer = new StringBuffer("");
			if(!"TM-KL8TM-TMSB".equals(uid)){
				contentBuffer.append(config.getCpCateName());
			}else{
				contentBuffer.append(config.getNumber());
			}
			
			if (StringUtils.isNotEmpty(config.getXzlxName())) {
				contentBuffer.append("[");
				contentBuffer.append(config.getXzlxName());
				contentBuffer.append("]");
			}
			order.setBz(contentBuffer.toString()+" ： "+number);
			order.setXzsj(gtDate);
			order.setUserIp(IPSeeker.getIpAddress(request));
			order.setSfjs("0");
			order.setXzdh(orderNo);
			order.setCreateTime(currDate);
			order.setModifyTime(currDate);
			order.setIsSync(0);
 
			order.setOrderStatus("未结算");
			order.setBackWaterStatus(0);
			
			contentBuffer.append(" ");
			contentBuffer.append(number);
			contentBuffer.append("@");
			contentBuffer.append("<font color=\"#ff0000\">"+config.getPl()+"</font>");
			order.setContent(contentBuffer.toString());
			order.setUserName(userName);
			order.setIsSync(0);
			order.setUserAgent(webUser.getUserAgent());
			
			StringBuffer buff = new StringBuffer("");
			buff.append(order.getGameTypeName()).append("-").append(order.getCpTypeName());
			int rows1 = this.webAccountsDao.updateWebAccount(userName, CommonConstant.CP_ACT_PRO_TYPE, CommonConstant.CP_BET_OUT, 
					-order.getXzje(), buff.toString()+"，彩票下注", userName, order.getXzdh());
			if(rows1>0){
				this.cpOrderDao.saveOrUpdate(order);
			}else{
				throw new RuntimeException("下注失败！");
			}
		 
		}
		 
	}
	
	
	/**
	 * 中奖名单列表
	 * 方法描述: TODO</br> 
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getWinningList(){
		return this.cpOrderDao.getWinningList();
	}
	
	
	public Page getOrderList(Page page,CpOrder gameOrder) {
		return this.cpOrderDao.getOrderList(page, gameOrder);
	}


	public List<Map<String, Object>> getCpGameCodeList() {
		
		return cpOrderDao.getCpGameCodeList();
	}
	
	
	/**
	 * 用户号码限额统计
	 * @param order
	 * @return
	 */
	public double getUserSingleCreditForNumber(CpOrder order){

	 
		List<CpOrder> list = cpOrderDao.getUserSingleCreditForNumber(order);
		double xzje = 0.0;
		for (CpOrder cpOrder : list) {
			xzje += cpOrder.getXzje();
		}
		return xzje;
		 
	}
	
	/**
	 * 
	 * 方法描述:得到注单集合</br>
	 * 创建人: zoro<br/> 
	 * @param bean
	 * @return  
	 * List<CpOrder>
	 */
	public List<CpOrder> getOrderList(CpOrder bean){
		return this.cpOrderDao.getOrderList(bean);
	}
	
	
	
	/**
	 * 统计注单
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param qs
	 * @return  
	 * Map<String,Object>
	 */
	/*public Map<String,Object> getBetOrderTj(String userName,String qs){
		return  this.cpOrderDao.getBetOrderTj(userName, qs);
	}*/
	public Map<String,Object> getBetOrderTj(String userName,String qs){
		return this.cpOrderDao.getBetOrderTj(userName, qs);
	}
	
	
	/**
	 * 当期盘口限额统计
	 * @param order
	 * @return
	 */
	public Double getUserSingleCredit(CpOrder order){
		 
		double price = 0.0;
		Map<String, Object> valMap = cpOrderDao.getUserSingleCredit(order);
		if(null == valMap || valMap.size() == 0){
			return price;
		}
		return (null == valMap.get("XZJE") ? price : Double.parseDouble(valMap.get("XZJE").toString()));
		 
	}
	
}
