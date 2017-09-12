package com.mh.web.controller;

import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import com.alibaba.fastjson.JSONObject;
import com.mh.commons.utils.DateUtil;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.WebGongGao;
import com.mh.service.WebGongGaoService;


/**
 * 公告Controller
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2016-12-11 下午10:23:33<br/>
 */
@RequestMapping("/announcement")
@Controller
public class AnnouncementController{
	
	protected Logger logger = LoggerFactory.getLogger(getClass());
	
	@Autowired
	private WebGongGaoService  webGongGaoService;
	
	
	/**
	 * 获取公告详情
	 * 方法描述: TODO</br> 
	 * @param ggId
	 * @param request
	 * @param response  
	 * void
	 */
	@RequestMapping("/detail/{ggId}")
	public void lottoGetGameInfo(@PathVariable(value = "ggId") Integer ggId,HttpServletRequest request, HttpServletResponse response) {
		try {
			JSONObject jsonObject = new JSONObject();
			WebGongGao webGongGao = this.webGongGaoService.getWebGongGaoById(ggId);
			jsonObject.put("ggTitle", webGongGao.getGgName());
			jsonObject.put("ggContent", webGongGao.getGgContent());
			jsonObject.put("createTime", DateUtil.formatDate(webGongGao.getCreateTime(), DateUtil.YMDHMS_PATTERN));
			
			
			ServletUtils.outPrintSuccess(request, response,jsonObject);
		}catch(Exception e){
			logger.error("公告异常", e);
			ServletUtils.outPrintFail(request, response, "公告异常.");
		}
	
	}
	
	/**
	 * 获取公告列表
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @throws Exception  
	 * void
	 */
	@RequestMapping("/goList")
	public void goList(HttpServletRequest request , HttpServletResponse response){
		try{
			List<Map<String,Object>> dataList = this.webGongGaoService.getGongGaoList("");
			
			
			ServletUtils.outPrintSuccess(request, response,dataList);
		}catch(Exception e){
			logger.error("公告异常", e);
			ServletUtils.outPrintFail(request, response, "公告异常.");
		}
	}
	

}
