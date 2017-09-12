/**   
* 文件名称: GameCenterController.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-6 上午11:07:27<br/>
*/  
package com.mh.web.controller;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import app.xb.cmbase.model.CpConfig;
import app.xb.cmbase.model.CpGame;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.conf.CpConfigCache;
import com.mh.commons.orm.Page;
import com.mh.commons.utils.CityUtil;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.MathUtil;
import com.mh.commons.utils.ServletUtils;
import com.mh.commons.utils.Xy28Util;
import com.mh.entity.CpDayProfit;
import com.mh.entity.CpHistoryResults;
import com.mh.entity.CpTomResults;
import com.mh.entity.WebBankCode;
import com.mh.service.CpDayProfitService;
import com.mh.service.CpOrderService;
import com.mh.service.GameResultsService;
import com.mh.web.login.UserContext;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-6 上午11:07:27<br/>
 */

@Controller
@RequestMapping("/game")
public class GameCenterController extends BaseController{
	
	@Autowired
	private GameResultsService gameResultsService;
	
	@Autowired
	private CpOrderService cpOrderService;
	
	
	@Autowired
	private CpDayProfitService cpDayProfitService;

	
	
	/**
	 * 个人盈亏
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/selfProfit")
	public void selfProfit(HttpServletRequest request, HttpServletResponse response) {
		try{
			
			String beginTimeStr = request.getParameter("beginTimeStr");
			String endTimeStr = request.getParameter("endTimeStr");
			CpDayProfit cpDayProfit = new CpDayProfit();
			if(StringUtils.isNotBlank(beginTimeStr)){
				cpDayProfit.setBeginTimeStr(beginTimeStr);
			}
			if(StringUtils.isNotBlank(endTimeStr)){
				cpDayProfit.setEndTimeStr(endTimeStr);
			}
			
			Page page = this.newPage(request);
			UserContext uc = this.getUserContext(request);
			
			cpDayProfit.setUserName(uc.getUserName());
			
			this.cpDayProfitService.findPage(page, cpDayProfit);
			
			ServletUtils.outPrintSuccess(request, response, page);
		}catch(Exception e){
			logger.error("获取个人盈亏报表失败",e);
			ServletUtils.outPrintFail(request, response, "获取个人盈亏报表失败！");
		}
		
	}
	
	/**
	 * 最新开奖期数
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/recent-issues")
	public void RecentIssuesAction(HttpServletRequest request, HttpServletResponse response) {
		String gameCode = request.getParameter("gameCode");
 
		try{
			Date currDate = new Date();
			List<CpHistoryResults> resultsList = this.gameResultsService.getHistoryResultsList(gameCode, 5);
			CpTomResults nextResults = this.gameResultsService.getTomResults(gameCode);
 
			CpGame game =CpConfigCache.GAME_OBJ_CACHE_MAP.get(gameCode);
			int betAdvanceTime = CpConfigCache.gameCloseMap.get(gameCode);
			JSONObject data = new JSONObject();
			Date openTime = DateUtil.parse(nextResults.getKjsj(), DateUtil.YMDHMS_PATTERN);
			
			CpHistoryResults lastResults = resultsList.get(0);
			String lastNumber = lastResults.getQs();
			String lottreyBalls = "";
//			if(lastResults.getQs().equals(lastNumber)){
				lottreyBalls = lastResults.getKjjg();
//			}
			if(CommonConstant.BJKL8_CODE_PARAM.equals(gameCode) || CommonConstant.CAKENO_CODE_PARAM.equals(gameCode)){
				String[] codeArr = lottreyBalls.split(",");
				int total = 0;
				for(String _code:codeArr){
					total += Integer.valueOf(_code);
				}
				JSONObject ballObj = new JSONObject();
				ballObj.put("dxds", Xy28Util.getDxds(total));
				ballObj.put("sb", Xy28Util.getColorBall(total));
				ballObj.put("fast", Xy28Util.getFastValue(total));
				ballObj.put("baozi", Xy28Util.getBaozi(Integer.valueOf(codeArr[0]),Integer.valueOf(codeArr[1]),Integer.valueOf(codeArr[2])));
			
				data.put("bol", ballObj);
			}
			
			
			openTime = DateUtil.addSecond(openTime, -betAdvanceTime);			
			data.put("betAdvanceTime", betAdvanceTime);
			data.put("currentTime", currDate.getTime()/1000);
			data.put("currentNumber", nextResults.getQs());
			data.put("currentLotteryTime", openTime.getTime()/1000);
 
			data.put("downTimeLeft", (openTime.getTime()-currDate.getTime())/1000);
			data.put("gameCnName", game.getGameTypeName());
			data.put("gameEnName",game.getGameTypeCode());
	
			data.put("lastNumber",lastNumber);
			data.put("lotteryBalls",lottreyBalls);
			data.put("traceMaxTimes", 120);
			JSONArray gameNumbers = new JSONArray();
			
			if(CommonConstant.BJKL8_CODE_PARAM.equals(gameCode) || CommonConstant.CAKENO_CODE_PARAM.equals(gameCode)){
				List<CpTomResults>  tomList = this.gameResultsService.getTomResultList(gameCode, 5);
				CpTomResults tomResults = null;
				if(tomList!=null && tomList.size()>0){
					for(int i=0;i<tomList.size();i++){
						tomResults = tomList.get(i);
						openTime = DateUtil.parse(tomResults.getKjsj(), DateUtil.YMDHMS_PATTERN);
						JSONObject obj = new JSONObject();
						obj.put("number", tomResults.getQs());
						obj.put("time", openTime.getTime()/1000);
						gameNumbers.add(obj);
					}
				}
				data.put("gameNumbers", gameNumbers);
			}
			
			JSONArray resultsNumbers = new JSONArray();
			if(resultsList!=null && resultsList.size()>0){
				CpHistoryResults results = null;
				JSONObject obj = null;
				for(int i=0;i<resultsList.size();i++){
					results = resultsList.get(i);
					openTime = DateUtil.parse(results.getKjsj(), DateUtil.YMDHMS_PATTERN);
					String opencode = results.getKjjg();
					obj = new JSONObject();
					if(CommonConstant.BJKL8_CODE_PARAM.equals(gameCode) || CommonConstant.CAKENO_CODE_PARAM.equals(gameCode)){
						String[] codeArr = opencode.split(",");
						int total = 0;
						for(String _code:codeArr){
							total += Integer.valueOf(_code);
						}
						obj.put("tm", total);
					}
					obj.put("number", results.getQs());
					obj.put("time", openTime.getTime()/1000);
					obj.put("opencode",opencode);
					resultsNumbers.add(obj);
				}
			}
			data.put("resultsNumbers", resultsNumbers);
			UserContext uc = this.getUserContext(request);
			
			Map<String,Object> lostWin = null;
			if(uc!=null && uc.getUserName()!=null){
				lostWin = this.cpOrderService.getBetOrderTj(uc.getUserName(), lastResults.getQs());
			}else{
				lostWin = new HashMap<String,Object>();
				lostWin.put("xzje", 0);
				lostWin.put("winMoney", 0);
				lostWin.put("betUsrWin", 0);
			}
			data.put("lostWin", lostWin);
			
			
			ServletUtils.outPrintSuccess(request, response, data);
			
	 
		}catch(Exception e){
			ServletUtils.outPrintFail(request, response, "获取最新开奖结果失败");
			logger.error("获取最新开奖结果失败",e);
		}
		
		
	}
	
	/**
	 * 获取地市
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @param paramMap  
	 * void
	 */
	@RequestMapping(value="/area",method=RequestMethod.GET)
	public void getCity(HttpServletRequest request, HttpServletResponse response){
		
		String provinces = request.getParameter("provinces");
		if(StringUtils.isEmpty(provinces)){
 
			List<String> list = CityUtil.getProviceList();
			ServletUtils.outPrintSuccess(request, response, list);
		}else{
			Map<String,List<String>> provinceMap =  CityUtil.getCityMap();
			List<String> list = provinceMap.get(provinces);
			ServletUtils.outPrintSuccess(request, response, list);
		}
		
		
		
	}
	
	
	@RequestMapping(value="/bankcode",method=RequestMethod.GET)
	public void getBankCode(HttpServletRequest request, HttpServletResponse response){
		
		JSONArray jsonArray = new JSONArray();
		List<WebBankCode> bankCodeList = CpConfigCache.BANK_CODE_LIST;
		WebBankCode webBankCode = null;
		JSONObject jsonObject = null;
		for(int i=0;i<bankCodeList.size();i++){
			jsonObject = new JSONObject();
			webBankCode = bankCodeList.get(i);
			jsonObject.put("bankCode", webBankCode.getBankCode());
			jsonObject.put("bankName", webBankCode.getBankName());
			
			jsonArray.add(jsonObject);
		}
		
		ServletUtils.outPrintSuccess(request, response, jsonArray);
		
	}
	
	

	/**
	 * 赔率
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/server")
	public void server(HttpServletRequest request, HttpServletResponse response) {
		String code = request.getParameter("code");
		String code2 = request.getParameter("code2");
		String code3=request.getParameter("code3");
		String code4=request.getParameter("code4");
		String key = "";
		if(!StringUtils.isEmpty(code3) && !StringUtils.isEmpty(code4)){
			key = code2+"-"+code3+"-"+code4;
		}
		 
		List<CpConfig> configList = CpConfigCache.RATE_CACHE_KEY.get(code + "-" + code2);
		List<Object> dataList = new ArrayList<Object>();
		for (CpConfig data : configList) {
			Map<String, Object> map = new HashMap<String, Object>();
			String number = data.getNumber();
			map.put("id", data.getUid());
			map.put("number", number);
			map.put("pl", MathUtil.round(data.getPl(), 2));
			String uid = data.getUid();
			if(!"".equals(key)){
				if(uid.contains(key)){
					dataList.add(map);
				}
			}else{
				dataList.add(map);
			}
		}
		ServletUtils.outPrintSuccess(request, response, dataList);
	}
	
}
