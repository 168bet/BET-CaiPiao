package com.mh.service;

import java.util.List;
import java.util.Map;

import com.mh.entity.WebUserQuestion;


public interface WebUserQuestionService {
	
	public int setQuestion(String userName , List<String> fieldList , Map<String , String> map ,String dateTime);
	
	public List<WebUserQuestion> findUserName(String userName);
	
	public List<WebUserQuestion> findWebUserQuestion(List<String> list);
	
	public int updateQuestion(List<Object[]> batchArgs);
}
