/**   
* 文件名称: AnimalUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-29 上午11:14:17<br/>
*/  
package com.mh.commons.utils;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

/** 
 * 类描述: TODO<br/>获取生肖对照工具类
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-29 上午11:14:17<br/>
 */

public class AnimalUtil {
	public static int startYear = 1804;
	
	public static String[] animalYear = new String[] { "鼠", "牛", "虎", "兔", "龙", "蛇", "马","羊", "猴", "鸡", "狗", "猪" };

	public static String[] animalSort = new String[12];
	
	public static String[] codeArr = new String[] { "01,13,25,37,49",
		"12,24,36,48",
		"11,23,35,47",
		"10,22,34,46",
		"09,21,33,45",
		"08,20,32,44",
		"07,19,31,43",
		"06,18,30,42",
		"05,17,29,41",
		"04,16,28,40",
		"03,15,27,39","02,14,26,38"};
	//维护每年初一的日期
	public static Map<Integer,String> yearMap = new HashMap<Integer,String>();
	static{
		yearMap.put(2016, "2016-02-08");
		yearMap.put(2017, "2017-01-28");
		yearMap.put(2018, "2018-02-16");
		yearMap.put(2019, "2019-02-05");
		yearMap.put(2020, "2020-01-25");
		yearMap.put(2021, "2021-02-12");
		yearMap.put(2022, "2022-02-01");
		yearMap.put(2023, "2023-01-22");
		yearMap.put(2024, "2024-02-10");
		yearMap.put(2025, "2025-01-29");
		yearMap.put(2026, "2026-02-17");
		yearMap.put(2027, "2027-02-06");
		yearMap.put(2028, "2028-01-26");
		yearMap.put(2029, "2029-02-13");
		yearMap.put(2030, "2030-02-03");
		yearMap.put(2031, "2031-01-23");
		yearMap.put(2032, "2032-02-11");
		yearMap.put(2033, "2033-01-31");
		yearMap.put(2034, "2034-02-19");
		yearMap.put(2035, "2035-02-08");
		yearMap.put(2036, "2036-01-28");
		yearMap.put(2037, "2037-02-15");
		yearMap.put(2038, "2038-02-04");
		yearMap.put(2039, "2039-01-24");
		yearMap.put(2040, "2040-02-12");
	}
	
	/**
	 * 根据年份获取生肖对应的号码
	 * 方法描述: TODO</br> 
	 * @param year
	 * @return  
	 * Map<String,String>
	 */
	public static Map<String,String> getAnimalCode(int year){
		Map<String,String> map = new TreeMap<String,String>();
		int anIndex = getAnimalYearName(year);
		int sortIndex = 0;
		for(int i=anIndex;i<12;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}
		for(int i=0;i<anIndex;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}

		for(int i=0;i<animalSort.length;i++){
			String animal = animalSort[i];
			String codeStr = codeArr[i];
			String[] codeArr =  codeStr.split(",");
			for(String code:codeArr){
				map.put(code, animal);
			}
		}
		return map;
		
	}
	
	public static Map<String,List<String>> getAnimalCodeList(int year){
		Map<String,List<String>> map = new HashMap<String,List<String>>();
		int anIndex = getAnimalYearName(year);
		int sortIndex = 0;
		for(int i=anIndex;i<12;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}
		for(int i=0;i<anIndex;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}

		for(int i=0;i<animalSort.length;i++){
			String animal = animalSort[i];
			String codeStr = codeArr[i];
			List<String> animalList = new ArrayList<String>();
			String[] codeArr =  codeStr.split(",");
			for(String code:codeArr){
				animalList.add(code);
			}
			map.put(animal, animalList);
		}
		return map;
		
	}
	
	
	/**
	 * 获取当年生肖对应的号码
	 * 方法描述: TODO</br> 
	 * @param year
	 * @return  
	 * Map<String,String>
	 */
	public static Map<String,String> getCurrAnimalCode(){
		int currYear = DateUtil.getYear(new Date());
		Map<String,String> map = new TreeMap<String,String>();
		int anIndex = getAnimalYearName(currYear);
		int sortIndex = 0;
		for(int i=anIndex;i<12;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}
		for(int i=0;i<anIndex;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}

		for(int i=0;i<animalSort.length;i++){
			String animal = animalSort[i];
			String codeStr = codeArr[i];
			String[] codeArr =  codeStr.split(",");
			for(String code:codeArr){
				map.put(code, animal);
			}
		}
		return map;
		
	}
	
	public static Map<String,List<String>> getCurrAnimalCodeList(){
		int currYear = DateUtil.getYear(new Date());
		Map<String,List<String>> map = new HashMap<String,List<String>>();
		int anIndex = getAnimalYearName(currYear);
		int sortIndex = 0;
		for(int i=anIndex;i<12;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}
		for(int i=0;i<anIndex;i++){
			animalSort[sortIndex] = animalYear[i];
			sortIndex++;
		}

		for(int i=0;i<animalSort.length;i++){
			String animal = animalSort[i];
			String codeStr = codeArr[i];
			List<String> animalList = new ArrayList<String>();
			String[] codeArr =  codeStr.split(",");
			for(String code:codeArr){
				animalList.add(code);
			}
			map.put(animal, animalList);
		}
		return map;
		
	}
	
	
	private static int subtractYear(int year) {
		int jiaziYear = startYear;
		if (year < jiaziYear) {// 如果年份小于起始的甲子年(startYear = 1804),则起始甲子年往前偏移
			jiaziYear = jiaziYear - (60 + 60 * ((jiaziYear - year) / 60));// 60年一个周期
		}
		return year - jiaziYear;
	}

	private static int getAnimalYearName(int year) {
		if(yearMap.get(year)!=null){
			String dateStr = yearMap.get(year);
			Date currDate = new Date();
			long times1 = currDate.getTime();
			int currYear = DateUtil.getYear(currDate);
			
			Date nextDate = null;
			long times2=0;
			try {
				nextDate = DateUtil.parse(dateStr, "yyyy-MM-dd");
				times2 = nextDate.getTime();
			} catch (ParseException e) {
				e.printStackTrace();
			}
			int nextYear = DateUtil.getYear(nextDate);
			if(currYear==nextYear && times2>times1){
				year = year-1;
			}
		}
		
		int index = subtractYear(year) % 12;
		return index;
	}
}
