package com.mh.web.token;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;


/**
 * token拦截器 
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-28 下午5:23:35<br/>
 */
public class DenyDuplicateFormSubmitInterceptor extends HandlerInterceptorAdapter{
	
	@Autowired
    private FormTokenManager formTokeManager;  
    
    @Override
	public boolean preHandle(HttpServletRequest request, HttpServletResponse response,  
                             Object handler) throws Exception {  
        boolean flag = true;  
        String token = request.getParameter(FormToken.FORM_TOKEN_UNIQ_ID);  
        if (token != null) {  
            if (formTokeManager.hasFormToken(request, token)) {  
            	formTokeManager.destroyToken(request, token);  
            } else {  
                flag = false;  
                //throw new DuplicateFormSubmitException("表单重复提交或失效，令牌[ " + token + " ]");  
            }  
        }else{
        	flag = false; 	
        }
        return flag;  
    }  
    
}
