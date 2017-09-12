/**   
* 文件名称: Xy28Util.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-10-12 下午4:22:12<br/>
*/  
package com.mh.commons.utils;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-10-12 下午4:22:12<br/>
 */
public class Xy28Util {
	
	//小单
	public static int[] smallSingleArr = new int[]{1,3,5,7,9,11,13};
	//小双
	public static int[] smallDoubleArr = new int[]{0,2,4,6,8,10,12};
	//大单
	public static int[] bigSingleArr = new int[]{15,17,19,21,23,25,27};
	//大双
	public static int[] bigDoubleArr = new int[]{14,16,18,20,22,24,26};
	
	//极小
	public static int[] fastSmallArr = new int[]{0,1,2,3,4,5};
	//极大
	public static int[] fastBigArr = new int[]{22,23,24,25,26,27};
	//
	public static int[] greenArr = new int[] {1,4,7,10,16,19,22,25};
	
	public static int[] blueArr = new int[]{2,5,8,11,17,20,23,26};
	
	public static int[] redArr = new int[]{3,6,9,12,15,18,21,24};
	
	/**
	 * 获取大小单双
	 * 方法描述: TODO</br> 
	 * @param code
	 * @return  
	 * String
	 */
	public static String getDxds(int code){
		StringBuffer buff = new StringBuffer("");
		buff.append(getDx(code));
		buff.append(getDs(code));
		return buff.toString();
	}
	
	/**
	 * 色波
	 * 方法描述: TODO</br> 
	 * @param code
	 * @return  
	 * String
	 */
	public static String getColorBall(int code){
		for(int i=0;i<greenArr.length;i++){
			if(greenArr[i]==code){
				return "绿波";
			}
		}
		for(int i=0;i<blueArr.length;i++){
			if(blueArr[i]==code){
				return "蓝波";
			}
		}
		for(int i=0;i<redArr.length;i++){
			if(redArr[i]==code){
				return "红波";
			}
		}
		return "无";
	}
	
	/**
	 * 极大小
	 * 方法描述: TODO</br> 
	 * @param code
	 * @return  
	 * String
	 */
	public static String getFastValue(int code){
		for(int i=0;i<fastSmallArr.length;i++){
			if(fastSmallArr[i]==code){
				return "极小";
			}
		}
		for(int i=0;i<fastBigArr.length;i++){
			if(fastBigArr[i]==code){
				return "极大";
			}
		}
		return "无极值";
		
	}
	
	/**
	 * 豹子
	 * 方法描述: TODO</br> 
	 * @param code1
	 * @param code2
	 * @param code3
	 * @return  
	 * String
	 */
	public static String getBaozi(int code1,int code2,int code3){
		if(code1==code2 && code2==code3){
			return "豹子";
		}
		 
		return "无豹子";
		
	}
	
	
	
	/**
	 * 大小
	 * 小于14为小.大于等于14为大
	 * 方法描述: TODO</br> 
	 * @param result
	 * @return  
	 * String
	 */
	public static String getDx(int result){
		if(result<14){
			return "小";
		}else{
			return "大";
		}
	}
	
	/**
	 * 单双
	 * 
	 * 方法描述: TODO</br> 
	 * @param result
	 * @return  
	 * String
	 */
	public static String getDs(int result){
		if(result%2==0){
			return "双";
		}else{
			return "单";
		}
	}

}
