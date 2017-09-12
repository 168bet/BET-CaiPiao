/**   
* 文件名称: OrderNoUtils.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-8 下午6:42:07<br/>
*/  
package com.mh.commons.utils;

import java.text.SimpleDateFormat;

import org.apache.commons.lang3.StringUtils;

/** 
 * 类描述: TODO<br/>生成订单号
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-8 下午6:42:07<br/>
 */
public class OrderNoUtils {
	
	private static long orderNum = 0l;  
    private static String dateStr ;  
    
    
    /**
     * 生成订单号 12位
     * 方法描述: TODO</br> 
     * @return  
     * String
     */
    public static synchronized String getOrderNo(String code) {  
        String str = new SimpleDateFormat("yyMMddHHmmssSSS").format(DateUtil.getGMT_4_Date());  
     
        
        if(dateStr==null||!dateStr.equals(str)){  
        	dateStr = str;  
            orderNum  = 0l;  
        }  
        
        
        orderNum ++;  
        long orderNo = Long.parseLong((dateStr)) * 10;  
        orderNo += orderNum;;  
        
        if(StringUtils.isEmpty(code)){
        	return String.valueOf(orderNo);
        }
        return code.toUpperCase()+String.valueOf(orderNo);  
 
    } 

}
