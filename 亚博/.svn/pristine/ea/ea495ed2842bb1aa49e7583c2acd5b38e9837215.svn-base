/**   
* 文件名称: RegLinkUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2016-12-2 下午3:27:06<br/>
*/  
package com.mh.web.util;

import org.apache.commons.lang3.StringUtils;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.mh.commons.conf.CommonConstant;
import com.mh.commons.utils.HttpClientUtil;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2016-12-2 下午3:27:06<br/>
 */
public class RegLinkUtil {
	
	
	
	

	
	
	public static String generateSinaUrl(String resisterUrl){
		String url = CommonConstant.resCommMap.get(CommonConstant.SINA_API_URL);
 
		url += "?url=" + resisterUrl;
		String respJson= HttpClientUtil.get(url);
		if(StringUtils.isNotBlank(respJson)){
			JSONObject jsonObject = JSON.parseObject(respJson);
			if(jsonObject.getString("url")!=null){
				return jsonObject.getString("url");
			}
		}
		return resisterUrl;
	}

}
