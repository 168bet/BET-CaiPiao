package com.mh.tag;


import javax.servlet.http.HttpServletRequest;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.TagSupport;

import com.mh.commons.utils.SpringContextHolder;
import com.mh.web.token.FormToken;
import com.mh.web.token.FormTokenManager;
import com.mh.web.token.impl.FormTokenManagerImpl;

/**
 * token自定义标签
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-28 下午6:50:07<br/>
 */
public class FormTokenTag extends TagSupport {
	
	private static final long serialVersionUID = 1L;

	@Override
	public int doStartTag() {
		
		FormTokenManager formTokenManager = SpringContextHolder.getBean("formTokenManagerImpl", FormTokenManagerImpl.class);
		HttpServletRequest request = (HttpServletRequest)pageContext.getRequest();
		FormToken formToken = formTokenManager.newFormToken(request);
		
		//jspContext.setAttribute("formToken", formToken);
		StringBuffer strb = new StringBuffer();
		
		strb.append("<input type=\"hidden\" name=\"_form_token_uniq_id\" id=\"_form_token_uniq_id\" value=\"" + formToken.getToken() + "\" />");
		
		JspWriter out = pageContext.getOut();
		try{
			out.print(strb.toString());
		}catch(Exception e){
			e.printStackTrace();
		}
		
		return SKIP_BODY;
	}
}
