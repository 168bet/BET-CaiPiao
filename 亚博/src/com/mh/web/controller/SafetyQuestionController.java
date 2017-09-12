package com.mh.web.controller;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mh.commons.utils.ServletUtils;
import com.mh.entity.WebUserQuestion;
import com.mh.service.WebUserQuestionService;
import com.mh.web.login.UserContext;


@RequestMapping("/safetyQuestion")
@Controller
public class SafetyQuestionController extends BaseController{
	
	@Autowired
	private WebUserQuestionService webUserQuestionService;
	
	
	
	//设置安全问题
	@RequestMapping("/setSafetyQuestion")
	public void setSafetyQuestion(HttpServletRequest request , HttpServletResponse response){
		UserContext uc = this.getUserContext(request);
		if(uc == null){
			ServletUtils.outPrintFail(request, response, "请登录");
			return;
		}
		try{
			List<WebUserQuestion> list = this.webUserQuestionService.findUserName(uc.getUserName());
			if(list != null && list.size() > 0){
				ServletUtils.outPrintFail(request, response, "已经设置问题");
				return;
			}
			String question1 = request.getParameter("question1");
			String answer1 = request.getParameter("answer1");
			String question2 = request.getParameter("question2");
			String answer2 = request.getParameter("answer2");
			String question3 = request.getParameter("question3");
			String answer3 = request.getParameter("answer3");
			if(question1.equals(question2) || question2.equals(question3) || question1.equals(question3)){
				ServletUtils.outPrintFail(request, response, "设置问题不能重复");
				return;
			}
			if(StringUtils.isBlank(question1) || StringUtils.isBlank(question2) || StringUtils.isBlank(question3)){
				ServletUtils.outPrintFail(request, response, "不能非法修改问题");
				return;
			}
			if(StringUtils.isBlank(answer1) || StringUtils.isBlank(answer2) || StringUtils.isBlank(answer3)){
				ServletUtils.outPrintFail(request, response, "答案不能为空");
				return;
			}
			SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			Date date = new Date();
			System.out.println(sdf.format(date));
			List<String> fieldList = new ArrayList<String>();
			Map<String , String> map = new HashMap<String , String>();
			fieldList.add("user_name");
			fieldList.add("question");
			fieldList.add("answer");
			fieldList.add("create_time");
			fieldList.add("modify_time");
			map.put(question1, answer1);
			map.put(question2, answer2);
			map.put(question3, answer3);
			int i = this.webUserQuestionService.setQuestion(uc.getUserName() , fieldList, map , sdf.format(date));
			if(i > 0){
				ServletUtils.outPrintSuccess(request, response, "设置成功.");
			}else{
				ServletUtils.outPrintFail(request, response, "设置失败.");
			}
		}catch(Exception e){
			logger.error("设置安全问题异常", e);
			ServletUtils.outPrintFail(request, response, "设置安全问题异常");
		}
		
	}
	
	
	
	//验证安全问题
	@RequestMapping("/validateSafetyQuestion")
	public void validateSafetyQuestion(HttpServletRequest request , HttpServletResponse response){
		UserContext uc = this.getUserContext(request);
		if(uc == null){
			ServletUtils.outPrintFail(request, response, "请登录");
			return;
		}
		try{
			String question1 = request.getParameter("question1");
			String answer1 = request.getParameter("answer1");
			String question2 = request.getParameter("question2");
			String answer2 = request.getParameter("answer2");
			List<String> list = new ArrayList<String>();
			list.add(uc.getUserName());
			list.add(question1);
			list.add(question2);
			List<WebUserQuestion> listWebUserQuestion = this.webUserQuestionService.findWebUserQuestion(list);
			
			if(listWebUserQuestion == null || listWebUserQuestion.size() <= 0 ){
				ServletUtils.outPrintFail(request, response, "安全问题未设置");
				return;
			}
			int k = 0;
			for(int i = 0 ; i < listWebUserQuestion.size() ; i++){
				WebUserQuestion webUserQuestion = listWebUserQuestion.get(i);
				if(webUserQuestion.getQuestion().equals(question1) && webUserQuestion.getAnswer().equals(answer1)){
					k++;
				}
				if(webUserQuestion.getQuestion().equals(question2) && webUserQuestion.getAnswer().equals(answer2)){
					k++;
				}
			}
			if(k < 2){
				ServletUtils.outPrintFail(request, response, "验证失败,问题和答案不一致");
				return;
			}
			
			ServletUtils.outPrintSuccess(request, response, "验证成功,进入修改问题答案");
		}catch(Exception e){
			logger.error("验证安全问题异常.", e);
			ServletUtils.outPrintFail(request, response, "验证异常");
		}
		
	}
	
	
	
	//修改安全问题
	@RequestMapping("/updateSafetyQuestion")
	public  void updateSafetyQuestion(HttpServletRequest request , HttpServletResponse response){
		UserContext uc = this.getUserContext(request);
		if(uc == null){
			ServletUtils.outPrintFail(request, response, "请登录");
			return;
		}
		try{
			String question1 = request.getParameter("question1");
			String answer1 = request.getParameter("answer1");
			String question2 = request.getParameter("question2");
			String answer2 = request.getParameter("answer2");
			String question3 = request.getParameter("question3");
			String answer3 = request.getParameter("answer3");
			
			if(StringUtils.isBlank(question1) || StringUtils.isBlank(question2) || StringUtils.isBlank(question3)){
				ServletUtils.outPrintFail(request, response, "不能非法修改问题");
				return;
			}
			if(StringUtils.isBlank(answer1) || StringUtils.isBlank(answer2) || StringUtils.isBlank(answer3)){
				ServletUtils.outPrintFail(request, response, "答案不能为空");
				return;
			}
			
			if(question1.equals(question2) || question2.equals(question3) || question1.equals(question3)){
				ServletUtils.outPrintFail(request, response, "设置问题不能重复");
				return;
			}
			
			List<WebUserQuestion> list = this.webUserQuestionService.findUserName(uc.getUserName());
			List<Object[]> batchArgs = new ArrayList<Object[]>();
			List<Object> list1 = new ArrayList<Object>();
			list1.add(question1);
			list1.add(answer1);
			list1.add(list.get(0).getId());
			batchArgs.add(list1.toArray());
			List<Object> list2 = new ArrayList<Object>();
			list2.add(question2);
			list2.add(answer2);
			list2.add(list.get(1).getId());
			batchArgs.add(list2.toArray());
			List<Object> list3 = new ArrayList<Object>();
			list3.add(question3);
			list3.add(answer3);
			list3.add(list.get(2).getId());
			batchArgs.add(list3.toArray());
			
 
			int i = this.webUserQuestionService.updateQuestion(batchArgs);
			if(i > 0){
				ServletUtils.outPrintSuccess(request, response, "修改成功,问题答案已更新");
				return;
			}
			else{
				ServletUtils.outPrintFail(request, response, "修改失败！稍后请重试");
				return;
			}
		}catch(Exception e){
			logger.error("修改异常", e);
			ServletUtils.outPrintFail(request, response, "修改异常！稍后请重试");
		}
		
	}

	
			
}
