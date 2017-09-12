package com.mh.web.token.impl;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.apache.commons.lang3.RandomStringUtils;
import org.apache.commons.lang3.StringUtils;

import com.google.common.collect.Maps;
import com.mh.web.token.FormToken;
import com.mh.web.token.FormTokenManager;

/**
 * token管理器实现类
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-28 下午5:24:12<br/>
 */
public class FormTokenManagerImpl implements FormTokenManager {

    private static final String SESSION_KEY_OF_FROMS = "_forms_in_session";  
    
    /** 表单最大个数 */  
    private int                 maxFormTokenNum           = 500;  
      
    /** 
     * 销毁一个表单 
     */  
    public void destroyToken(HttpServletRequest request, String token) {  
    	getFormTokens(request).remove(token);  
    }  
    
    /** 
     * 打印表单信息。 
     */  
    public String dumpFormToken(HttpServletRequest request, String token) {  
    	FormToken form = getFormTokens(request).get(token);  
        if (form == null) {  
            return "null";  
        }  
        return form.toString();  
    }  
    
    /** 
     * 判断表单是否存在。如果token为null，直接返回false。 
     * 
     * @see #getForms(HttpServletRequest) 
     */  
    public boolean hasFormToken(HttpServletRequest request, String token) {  
        if (token == null) {  
            return false;  
        }  
        return getFormTokens(request).containsKey(token);  
    }  
      
    /** 
     * 提交表单中, 访问参数是否存在表单Token。 
     */  
    public boolean hasTokenFromSubmit(HttpServletRequest request) {  
        String token = request.getParameter(FormToken.FORM_TOKEN_UNIQ_ID);  
        return StringUtils.isNotBlank(token);  
    }  
    
    /** 
     * 生成一个新的表单，如果目前表单个数大于设定的最大表单数则先删除最早的一个表单。<br> 
     * 新表单用RandomStringUtils.randomAlphanumeric(32)生成Token。 
     * 
     * @return 创建的新表单 
     * @see #removeOldestForm(HttpServletRequest) 
     * @see org.apache.commons.lang.RandomStringUtils#random(int) 
     */  
    public FormToken newFormToken(HttpServletRequest request) {  
    	FormToken formToken = new FormToken(RandomStringUtils.randomAlphanumeric(32));  
        Map<String, FormToken> formTokens = getFormTokens(request);  

        // 如果目前表单个数大于等于最大表单数，那么删除最老的表单，添加新表单。  
        if (formTokens.size() >= maxFormTokenNum) {  
            removeOldestForm(request);  
        }  
        
        formTokens.put(formToken.getToken(), formToken);  
        
        return formToken;  
    }  
    
    /** 
     * 获得目前session中的表单列表。 
     * 
     * @return 返回的Map中以表单的token为键，Form对象为值 
     */  
    @SuppressWarnings("unchecked")  
    protected Map<String, FormToken> getFormTokens(HttpServletRequest request) {  
        Map<String, FormToken> formsInSession = null;  
        HttpSession session = request.getSession();  
        
        formsInSession = (Map<String, FormToken>) session.getAttribute(SESSION_KEY_OF_FROMS);  
        if (formsInSession == null) {  
            formsInSession = Maps.newLinkedHashMap();
            session.setAttribute(SESSION_KEY_OF_FROMS, formsInSession);  
        }  
        
        return formsInSession;  
    }  
    
    /** 
     * 删除最老的Form 
     * 
     * @see #destroyToken(HttpServletRequest, String) 
     */  
    protected void removeOldestForm(HttpServletRequest request) {  
        List<FormToken> forms = new ArrayList<FormToken>(getFormTokens(request).values());  
        if (!forms.isEmpty()) {  
        	FormToken oldestForm = forms.get(0);  
            for (FormToken form : forms) {  
                if (form.getCreateTime().before(oldestForm.getCreateTime())) {  
                    oldestForm = form;  
                }  
            }  
            destroyToken(request, oldestForm.getToken());  
        }  
    }  
    
    
    public void setMaxFormNum(int maxFormNum) {  
        this.maxFormTokenNum = maxFormNum;  
    }
 

}
