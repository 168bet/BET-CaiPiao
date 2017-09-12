/**   
* 文件名称: OrderDao.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-5 下午1:16:09<br/>
*/  
package com.mh.dao;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

import org.apache.commons.collections.CollectionUtils;
import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import app.xb.cmbase.model.CpGame;

import com.mh.commons.cache.MemCachedUtil;
import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.entity.CpOrder;

@SuppressWarnings("all")
@Repository
public class CpOrderDao extends BaseDao<CpOrder,Integer>{
	
	
	/**
	 * 根据订单号查询订单
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param orderNo
	 * @return  
	 * CpOrder
	 */
	public CpOrder getOrderByOrderNo(String userName,String orderNo){
		String hql = "from CpOrder where userName=? and xzdh=? ";
		List<CpOrder> orderList = this.getHibernateTemplate().find(hql, new Object[]{userName,orderNo});
		CpOrder order = null;
		if(orderList!=null && orderList.size()>0){
			order = orderList.get(0);
			
		}
		return order;
	}
	
	
	/**
	 * 统计下注金额
	 * 方法描述: TODO</br> 
	 * @param gameOrder
	 * @return  
	 * double
	 */
	public double getOrderTjXzje(CpOrder gameOrder){
		String sql = " SELECT SUM(t1.XZJE) AS xzje FROM cp_order t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name " +
				"where 1=1 and t1.SFJS='1' ";
		List<Object> list = new ArrayList<Object>();
		if(StringUtils.isNotBlank(gameOrder.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(gameOrder.getRelativePath());
		}
		if (StringUtils.isNotBlank(gameOrder.getBeginTimeStr()) && StringUtils.isNotBlank(gameOrder.getEndTimeStr())) {
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') >= ?";
			list.add(gameOrder.getBeginTimeStr());
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') <= ?";
			list.add(gameOrder.getEndTimeStr());
		}else if (StringUtils.isNotBlank(gameOrder.getBeginTimeStr())) {
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') >= ?";
			list.add(gameOrder.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(gameOrder.getEndTimeStr())) {
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') <= ?";
			list.add(gameOrder.getEndTimeStr());
		}
		double betMoney =0;
		List<Map<String,Object>> valList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		if(valList!=null && valList.size()>0){
			Map<String,Object> valMap = valList.get(0);
			if(valMap.get("xzje")!=null){
				betMoney = Double.valueOf(valMap.get("xzje").toString());
			}
		}
		return betMoney;
		
	}
	
	/**
	 * 统计订单列表
	 * 方法描述: TODO</br> 
	 * @param gameOrder
	 * @return  
	 * Map<String,Double>
	 */
	public Map<String,Object> getOrderTjList(CpOrder gameOrder){
		
		
		String sql = " SELECT date_format(t1.xzsj,'%Y-%m-%d') as xzsj,SUM(t1.XZJE) AS xzje FROM cp_order t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name " +
				"where 1=1 and t1.SFJS='1' ";
		if(gameOrder.getBeginTimeStr().equals(gameOrder.getEndTimeStr())){
			sql = " SELECT date_format(t1.xzsj,'%H') as xzsj,SUM(t1.XZJE) AS xzje FROM cp_order t1 LEFT JOIN t_web_user t2 ON t1.USER_NAME=t2.user_name " +
					"where 1=1 and t1.SFJS='1' ";
			
		}
		
		List<Object> list = new ArrayList<Object>();
		if(StringUtils.isNotBlank(gameOrder.getRelativePath())){
			sql += " and t2.relative_path like ? ";
			list.add(gameOrder.getRelativePath());
		}
		if (StringUtils.isNotBlank(gameOrder.getBeginTimeStr()) && StringUtils.isNotBlank(gameOrder.getEndTimeStr())) {
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') >= ?";
			list.add(gameOrder.getBeginTimeStr());
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') <= ?";
			list.add(gameOrder.getEndTimeStr());
		}else if (StringUtils.isNotBlank(gameOrder.getBeginTimeStr())) {
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') >= ?";
			list.add(gameOrder.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(gameOrder.getEndTimeStr())) {
			sql += " and date_format(t1.xzsj,'%Y-%m-%d') <= ?";
			list.add(gameOrder.getEndTimeStr());
		}
		
		if(gameOrder.getBeginTimeStr().equals(gameOrder.getEndTimeStr())){
			sql += "    GROUP BY DATE_FORMAT(t1.xzsj, '%H') ";
		}else{
			sql += "    GROUP BY DATE_FORMAT(t1.xzsj, '%Y-%m-%d') ";
		}
		
		
		List<Map<String,Object>> dataList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		Map<String,Object> valMap = new TreeMap<String,Object>();
		for(int i=0;i<dataList.size();i++){
			Map<String,Object> dataMap = dataList.get(i);
			double val = 0;
			if(dataMap.get("xzje")!=null){
				val = Double.valueOf(dataMap.get("xzje").toString());
			}
			valMap.put(dataMap.get("xzsj").toString(), val);
		}
		return valMap;
		
	}
	
	
	
	/**
	 * 订单列表
	 * 方法描述: TODO</br> 
	 * @param page
	 * @param bean
	 * @return  
	 * Page
	 */
	public Page getOrderList(Page page,CpOrder gameOrder){
		List<Object> list = new ArrayList<Object>();
 
		
		String sql = "SELECT t.XZDH AS orderNo,t.XZSJ AS betTime,t.QS AS qs,t.GAME_TYPE_NAME AS gameName,t.CP_CATE_NAME AS itemName," +
				" t.NUMBER AS betNumber,t.PL AS pl, t.XZJE AS betIncome,t.KYJE AS kyje,t.ZGJE AS zgje,t.OPEN_TIME AS openTime," +
				" (CASE t.ORDER_STATUS WHEN '赢' THEN '已中奖' WHEN '输' THEN '未中奖' WHEN '未结算' THEN '等待开奖' ELSE '已取消' END) AS orderStatus " +
				" ,t.KJJG as openNumber, t.BACK_WATER_STATUS as backWaterStatus,t.BACK_WATER_MONEY as backWaterMoney,t.WIN_MONEY as winMoney," +
				" t.BET_USR_WIN AS betUsrWin FROM cp_order t where 1=1 ";
		
		if(StringUtils.isNotEmpty(gameOrder.getGameTypeCode())){
			sql += " and t.GAME_TYPE_CODE =? ";
			list.add(gameOrder.getGameTypeCode().toUpperCase());
		}
		
		if(StringUtils.isNotEmpty(gameOrder.getUserName())){
			sql += " and t.USER_NAME=? ";
			list.add(gameOrder.getUserName());
		}
 
		
		if (StringUtils.isNotBlank(gameOrder.getBeginTimeStr()) && StringUtils.isNotBlank(gameOrder.getEndTimeStr())) {
			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(gameOrder.getBeginTimeStr());
			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(gameOrder.getEndTimeStr());
		}else if (StringUtils.isNotBlank(gameOrder.getBeginTimeStr())) {
			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') >= ?";
			list.add(gameOrder.getBeginTimeStr());
		}else if (StringUtils.isNotBlank(gameOrder.getEndTimeStr())) {
			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') <= ?";
			list.add(gameOrder.getEndTimeStr());
		}
		
		//status -1全部  0等待开奖 1未中奖  2已中奖
		if (StringUtils.isNotBlank(gameOrder.getStatus()) && !"-1".equals(gameOrder.getStatus())){
			if("0".equals(gameOrder.getStatus())){
				sql += " and t.SFJS='0' ";
 
			}else if("1".equals(gameOrder.getStatus())){				
				sql += " and t.SFJS='1' and ORDER_STATUS='输' ";
			}else if("2".equals(gameOrder.getStatus())){
				
				sql += " and t.SFJS='1' and ORDER_STATUS='赢' ";
	 
				
			}
			
			
		}
				
  
		if(StringUtils.isNotBlank(gameOrder.getXzdh())){
			sql += " AND  t.XZDH=? ";
			list.add(gameOrder.getXzdh());
		}
		sql += " ORDER BY t.XZSJ DESC ";
		return this.findPageBySql(page,sql,list.toArray());
	}
	
	
	
	
	public List<Map<String, Object>> getCpGameCodeList(){
		List<CpGame> gameList = (List<CpGame>)MemCachedUtil.get("_game");
		List<Map<String, Object>> list=new ArrayList<Map<String, Object>>();
		if(CollectionUtils.isNotEmpty(gameList)){
			for (CpGame cpGame : gameList) {
				Map<String,Object> m=new HashMap<String,Object>();
				m.put("gameName", cpGame.getGameTypeName());
				m.put("gameCode", cpGame.getGameTypeCode());
				list.add(m);
			}
			return list;
		}else{
			String sql=" SELECT id,game_type_name as gameName ,GAME_TYPE_CODE as gameCode FROM cp_game ";
			return this.getJdbcTemplate().queryForList(sql);
		}
	}
	/**
	 * 中奖名单列表
	 * 方法描述: TODO</br> 
	 * @return  
	 * List<Map<String,Object>>
	 */
	public List<Map<String,Object>> getWinningList(){
		String sql = "select t.GAME_TYPE_NAME as gameName,t.CP_TYPE_CODE as itemName,t.USER_NAME as userName,round(KYJE,3) as kyje " +
				"from cp_order t where SFJS='1' and ORDER_STATUS='赢' order by t.CREATE_TIME desc ";
		
		return this.getJdbcTemplate().queryForList(sql);
	}
	
	/**
	 * 用户号码限额统计
	 * @param order
	 * @return
	 */
	public List<CpOrder> getUserSingleCreditForNumber(CpOrder order){
		
		if(StringUtils.isEmpty(order.getUserName())){
			return null;
		}
		List<Object> list = new ArrayList<Object>();
		StringBuffer hql = new StringBuffer(" from CpOrder where 1 = 1");
		hql.append(" AND userName = ?");
		list.add(order.getUserName());
		hql.append(" AND sfjs = ?");
		list.add(String.valueOf(0));
		if(StringUtils.isNotEmpty(order.getQs())){
			hql.append(" AND qs = ?");
			list.add(order.getQs());
		}
		if(StringUtils.isNotEmpty(order.getGameTypeCode())){
			hql.append(" AND gameTypeCode = ?");
			list.add(order.getGameTypeCode());
		}
		if(StringUtils.isNotEmpty(order.getCpTypeCode())){
			hql.append(" AND cpTypeCode = ?");
			list.add(order.getCpTypeCode());
		}
		if(StringUtils.isNotEmpty(order.getCpCateCode())){
			hql.append(" AND cpCateCode = ?");
			list.add(order.getCpCateCode());
		}
		if(StringUtils.isNotEmpty(order.getXzlxCode())){
			hql.append(" AND xzlxCode = ?");
			list.add(order.getXzlxCode());
		}
		if(StringUtils.isNotEmpty(order.getXzzuCode())){
			hql.append(" AND xzzuCode = ?");
			list.add(order.getXzzuCode());
		}
		if(StringUtils.isNotEmpty(order.getNumber())){
			hql.append(" AND NUMBER = ?");
			list.add(order.getNumber());
		}
		List<CpOrder> resOrder = this.getHibernateTemplate().find(hql.toString(), list.toArray());
		return resOrder;
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
		List<Object> list = new ArrayList<Object>();
		StringBuffer buffer = new StringBuffer();
		buffer.append("from CpOrder where  1=1 ");
		if(StringUtils.isNotEmpty(bean.getGameTypeCode())){
			buffer.append(" and gameTypeCode =? ");
			list.add(bean.getGameTypeCode());
		}
		if(StringUtils.isNotEmpty(bean.getQs())){
			buffer.append(" and qs=? ");
			list.add(bean.getQs());
		}
		if(StringUtils.isNotEmpty(bean.getUserName())){
			buffer.append(" and userName=? ");
			list.add(bean.getUserName());
		}
//		if (StringUtils.isNotBlank(bean.getBeginTimeStr()) && StringUtils.isNotBlank(bean.getEndTimeStr())) {
//			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') >= ?";
//			list.add(bean.getBeginTimeStr());
//			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') <= ?";
//			list.add(bean.getEndTimeStr());
//		}else if (StringUtils.isNotBlank(bean.getBeginTimeStr())) {
//			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') >= ?";
//			list.add(bean.getBeginTimeStr());
//		}else if (StringUtils.isNotBlank(bean.getEndTimeStr())) {
//			sql += " and date_format(t.xzsj,'%Y-%m-%d %H:%i:%s') <= ?";
//			list.add(bean.getEndTimeStr());
//		}
		
		
		
		if(StringUtils.isNotBlank(bean.getOrderStatus())){
			buffer.append(" and  sfjs=? ");
			list.add(bean.getOrderStatus());
		}
		
		buffer.append(" ORDER BY sfjs DESC, qs DESC ");
		
		return this.find(buffer.toString(), list.toArray());
	}
	/**
	 * 当期盘口限额统计
	 * @param order
	 * @return
	 */
	public Map<String, Object> getUserSingleCredit(CpOrder order){
		if(StringUtils.isEmpty(order.getUserName())){
			return null;
		}
		StringBuffer sql = new StringBuffer("SELECT SUM(XZJE) AS XZJE FROM CP_ORDER WHERE 1 = 1 ");
		List<Object> list = new ArrayList<Object>();
		sql.append(" AND USER_NAME = ?");
		list.add(order.getUserName());
		sql.append(" AND SFJS = ?");
		list.add(0);
		if(StringUtils.isNotEmpty(order.getQs())){
			sql.append(" AND QS = ?");
			list.add(order.getQs());
		}
		if(StringUtils.isNotEmpty(order.getGameTypeCode())){
			sql.append(" AND GAME_TYPE_CODE = ?");
			list.add(order.getGameTypeCode());
		}
		if(StringUtils.isNotEmpty(order.getCpTypeCode())){
			sql.append(" AND CP_TYPE_CODE = ?");
			list.add(order.getCpTypeCode());
		}
		Map<String, Object> valMap = this.getJdbcTemplate().queryForMap(sql.toString() , list.toArray());
		return valMap;
	}
	/**
	 * 统计注单
	 * 方法描述: TODO</br> 
	 * @param userName
	 * @param qs
	 * @return  
	 * Map<String,Object>
	 */
	public Map<String,Object> getBetOrderTj(String userName,String qs){
		List<Object> list = new ArrayList<Object>();
		String sql = "SELECT ROUND(SUM(XZJE),3) AS xzje,ROUND(SUM(WIN_MONEY),3) AS winMoney,ROUND(SUM(BET_USR_WIN),3) AS betUsrWin " +
				"FROM cp_order WHERE SFJS<>'2'  ";
		if(!StringUtils.isBlank(userName)){
			sql += " and USER_NAME=? ";
			list.add(userName);
		}
		if(!StringUtils.isBlank(qs)){
			sql += " and QS=? ";
			list.add(qs);
		}
		List<Map<String,Object>> valList = this.getJdbcTemplate().queryForList(sql, list.toArray());
		Map<String,Object> valMap = new HashMap<String,Object>();
		double xzje=0,winMoney=0,betUsrWin=0;
		if(valList!=null && valList.size()>0){
			Map<String,Object> map = valList.get(0);
			xzje = (map.get("xzje")==null?0:Double.valueOf(map.get("xzje").toString()));
			winMoney = (map.get("winMoney")==null?0:Double.valueOf(map.get("winMoney").toString()));
			betUsrWin = (map.get("betUsrWin") == null?0:Double.valueOf(map.get("betUsrWin").toString()));
		}
		valMap.put("xzje", xzje);
		valMap.put("winMoney", winMoney);
		valMap.put("betUsrWin", betUsrWin);
		
 
		return valMap;
	 
	}
}
