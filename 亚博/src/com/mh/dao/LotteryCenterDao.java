package com.mh.dao;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import com.mh.commons.constants.CpCommonConstant;
import com.mh.commons.orm.BaseDao;
import com.mh.commons.orm.Page;
import com.mh.commons.utils.HttpClientUtil;
import com.mh.entity.CpBjpk10Results;
import com.mh.entity.CpCanada28Results;
import com.mh.entity.CpFc3dypl3Results;
import com.mh.entity.CpHk6Results;
import com.mh.entity.CpKlsfResults;
import com.mh.entity.CpSscResults;
import com.mh.entity.CpTomResults;
import com.mh.entity.CpXy28Results;
import com.mh.service.GameResultsService;

@SuppressWarnings("rawtypes")
@Repository
public class LotteryCenterDao  extends BaseDao{
	private static final Logger logger = LoggerFactory.getLogger(LotteryCenterDao.class);
	@Autowired
	private GameResultsService gameResultsService;
	@SuppressWarnings({ "unchecked", "static-access", "deprecation" })
	public Page getAllGameTypeNewResultList(Page page,Map<String, String> map){
		List<Map<String,Object>> list=new ArrayList<Map<String,Object>>();
		Map<String,Object> typeReMap=new HashMap<String,Object>();
		
		if(StringUtils.isEmpty(map.get("code"))&&StringUtils.isEmpty(map.get("date"))){
			String cpRJson = HttpClientUtil.getAllNewResult(map); //远程调用开奖结果
			JSONObject parseObject = JSONObject.fromObject(cpRJson);
			typeReMap.put("dataJsonStr", parseObject.get("msInfo"));
			list.add(typeReMap);
			page.setResult(list);
			return page;
		}else{
		List<CpTomResults> tomResultList = gameResultsService.getTomResultList(map.get("code"), 5);	
		String cpRJson = HttpClientUtil.getCpHistoryResult(map); //远程调用开奖结果
		JSONObject parseObject = JSONObject.fromObject(cpRJson);
		JSONArray jsonArray=null;
		if (StringUtils.equals("000000", parseObject.getString("code"))&&null!=parseObject.get("msInfo")) {
			jsonArray = (JSONArray) parseObject.get("msInfo");
			String errorMsg = parseObject.get("erroMessage") == null ? "" : (String)parseObject.get("erroMessage") ;
			if (CpCommonConstant.HK_CODE_PARAM.equals(map.get("code"))) {
				List<CpHk6Results> listResult = jsonArray.toList(jsonArray,CpHk6Results.class);
				List<CpHk6Results> canList=new ArrayList<CpHk6Results>();
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpHk6Results can=new CpHk6Results();
					can.setQs(tomResultList.get(i).getQs());
					can.setGtKjsj(tomResultList.get(i).getGtKjsj());
					can.setKjsj(tomResultList.get(i).getKjsj());
					can.setKjjg("等待开奖");
					can.setCode(tomResultList.get(i).getCode());
					can.setFormatQs(tomResultList.get(i).getQs());
					can.setXd(String.valueOf(orderRandom()));
					can.setStatus("投注火爆");
					canList.add(can);
				}
				for (CpHk6Results ssc : listResult) {
					ssc.setStatus("已经开奖");
					ssc.setXd(String.valueOf(orderRandom()));
					ssc.setZjrs(String.valueOf(lotteryRandom()));
					canList.add(ssc);
				}
				listResult.clear();
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : canList);
			} else if (CpCommonConstant.FC3D_CODE_PARAM.equals(map.get("code")) || CpCommonConstant.PL3_CODE_PARAM.equals(map.get("code"))) {
				List<CpFc3dypl3Results> listResult = jsonArray.toList(jsonArray,CpFc3dypl3Results.class);
				List<CpFc3dypl3Results> canList=new ArrayList<CpFc3dypl3Results>();
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpFc3dypl3Results can=new CpFc3dypl3Results();
					can.setQs(tomResultList.get(i).getQs());
					can.setGtKjsj(tomResultList.get(i).getGtKjsj());
					can.setKjsj(tomResultList.get(i).getKjsj());
					can.setKjjg("等待开奖");
					can.setCode(tomResultList.get(i).getCode());
					can.setFormatQs(tomResultList.get(i).getQs());
					can.setXd(String.valueOf(orderRandom()));
					can.setStatus("投注火爆");
					canList.add(can);
				}
				for (CpFc3dypl3Results ssc : listResult) {
					ssc.setStatus("已经开奖");
					ssc.setXd(String.valueOf(orderRandom()));
					ssc.setZjrs(String.valueOf(lotteryRandom()));
					canList.add(ssc);
				}
				listResult.clear();
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : canList);
			} else if (CpCommonConstant.BJPK10_CODE_PARAM.equals(map.get("code"))) {
				List<CpBjpk10Results> listResult = jsonArray.toList(jsonArray,CpBjpk10Results.class);
				List<CpBjpk10Results> canList=new ArrayList<CpBjpk10Results>();
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpBjpk10Results can=new CpBjpk10Results();
					can.setQs(tomResultList.get(i).getQs());
					can.setGtKjsj(tomResultList.get(i).getGtKjsj());
					can.setKjsj(tomResultList.get(i).getKjsj());
					can.setKjjg("等待开奖");
					can.setCode(tomResultList.get(i).getCode());
					can.setFormatQs(tomResultList.get(i).getQs());
					can.setXd(String.valueOf(orderRandom()));
					can.setStatus("投注火爆");
					canList.add(can);
				}
				for (CpBjpk10Results ssc : listResult) {
					ssc.setStatus("已经开奖");
					ssc.setXd(String.valueOf(orderRandom()));
					ssc.setZjrs(String.valueOf(lotteryRandom()));
					canList.add(ssc);
				}
				listResult.clear();
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : canList);
			} else if (CpCommonConstant.TJKLSF_CODE_PARAM.equals(map.get("code")) || CpCommonConstant.GDKLSF_CODE_PARAM.equals(map.get("code"))) {
				List<CpKlsfResults> listResult = jsonArray.toList(jsonArray,CpKlsfResults.class);
				List<CpKlsfResults> canList=new ArrayList<CpKlsfResults>();
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpKlsfResults can=new CpKlsfResults();
					can.setQs(tomResultList.get(i).getQs());
					can.setGtKjsj(tomResultList.get(i).getGtKjsj());
					can.setKjsj(tomResultList.get(i).getKjsj());
					can.setKjjg("等待开奖");
					can.setCode(tomResultList.get(i).getCode());
					can.setFormatQs(tomResultList.get(i).getQs());
					can.setXd(String.valueOf(orderRandom()));
					can.setStatus("投注火爆");
					canList.add(can);
				}
				for (CpKlsfResults ssc : listResult) {
					ssc.setStatus("已经开奖");
					ssc.setXd(String.valueOf(orderRandom()));
					ssc.setZjrs(String.valueOf(lotteryRandom()));
					canList.add(ssc);
				}
				listResult.clear();
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : canList);
			} else if (CpCommonConstant.BJKL8_CODE_PARAM.equals(map.get("code"))) {
				
				List<CpXy28Results> xyList=new ArrayList<CpXy28Results>();
				
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpXy28Results xy=new CpXy28Results();
					xy.setQs(tomResultList.get(i).getQs());
					xy.setGtKjsj(tomResultList.get(i).getGtKjsj());
					xy.setKjsj(tomResultList.get(i).getKjsj());
					xy.setKl8Kjjg("等待开奖");
					xy.setCode(tomResultList.get(i).getCode());
					xy.setFormatQs(tomResultList.get(i).getQs());
					xy.setXd(String.valueOf(orderRandom()));
					xy.setStatus("投注火爆");
					xyList.add(xy);
				}
				
				List<CpXy28Results> listResult = jsonArray.toList(jsonArray, CpXy28Results.class);
				for (CpXy28Results cpXy28Results : listResult) {
					cpXy28Results.setStatus("已经开奖");
					cpXy28Results.setXd(String.valueOf(orderRandom()));
					cpXy28Results.setZjrs(String.valueOf(lotteryRandom()));
					xyList.add(cpXy28Results);
				}
				
				listResult.clear();
				
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : xyList);
			
			} else if (CpCommonConstant.CAKENO_CODE_PARAM.equals(map.get("code"))) {
				
				List<CpCanada28Results> listResult = jsonArray.toList(jsonArray, CpCanada28Results.class);
				List<CpCanada28Results> canList=new ArrayList<CpCanada28Results>();
				
				
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpCanada28Results can=new CpCanada28Results();
					can.setQs(tomResultList.get(i).getQs());
					can.setGtKjsj(tomResultList.get(i).getGtKjsj());
					can.setKjsj(tomResultList.get(i).getKjsj());
					can.setKl8Kjjg("等待开奖");
					can.setCode(tomResultList.get(i).getCode());
					can.setFormatQs(tomResultList.get(i).getQs());
					can.setXd(String.valueOf(orderRandom()));
					can.setStatus("投注火爆");
					canList.add(can);
				}
				
				for (CpCanada28Results cpCanada28Results : listResult) {
					cpCanada28Results.setStatus("已经开奖");
					cpCanada28Results.setXd(String.valueOf(orderRandom()));
					cpCanada28Results.setZjrs(String.valueOf(lotteryRandom()));
					canList.add(cpCanada28Results);
				}
				listResult.clear();
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : canList);
			} else {
				List<CpSscResults> listResult = jsonArray.toList(jsonArray,CpSscResults.class);
				List<CpSscResults> canList=new ArrayList<CpSscResults>();
				for(int i=tomResultList.size()-1;i>=0;i--){
					CpSscResults can=new CpSscResults();
					can.setQs(tomResultList.get(i).getQs());
					can.setGtKjsj(tomResultList.get(i).getGtKjsj());
					can.setKjsj(tomResultList.get(i).getKjsj());
					can.setKjjg("等待开奖");
					can.setCode(tomResultList.get(i).getCode());
					can.setFormatQs(tomResultList.get(i).getQs());
					can.setXd(String.valueOf(orderRandom()));
					can.setStatus("投注火爆");
					canList.add(can);
				}
				for (CpSscResults ssc : listResult) {
					ssc.setStatus("已经开奖");
					ssc.setXd(String.valueOf(orderRandom()));
					ssc.setZjrs(String.valueOf(lotteryRandom()));
					canList.add(ssc);
				}
				listResult.clear();
				page.setResult(StringUtils.isNotEmpty(errorMsg) ? null : canList);
			}
			//page.setPageNo(Integer.valueOf(map.get("pageNo")));
			//page.setPageSize(Integer.valueOf(map.get("pageSize")));
			page.setTotalCount(Integer.valueOf(parseObject.get("totalPages").toString()));
			logger.info(map.get("code") + "开奖结果返回报文--->>" + cpRJson);
		}
		
			return page;
		}
	}
	
	public int orderRandom(){
		Random random=new Random();
		return random.nextInt((100000)*115);
	}
	public int lotteryRandom(){
		Random random=new Random();
		return random.nextInt((100)*3);
	}
	
}
