<%@ page language="java" import="java.util.*,com.mh.commons.constants.*"
	contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ page import="com.mh.commons.utils.ServletUtils"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %> 
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="mh" uri="http://www.mh.com/framework/tags" %>


<%
	Map<String,String> ctxMap = WebSiteManagerConstants.ctxMap;
	request.setAttribute("ctxMap", ctxMap);
	
	String p = request.getParameter("p");
	if(!"".equals(p) && !"null".equals(p) && p!=null){
		request.getSession().setAttribute("agentNo", p);
 
		String basePath = ServletUtils.getWebDomain(request);
		basePath += "main/register";
		response.setHeader("Location",basePath);
		response.sendRedirect(basePath);
	}
%>
