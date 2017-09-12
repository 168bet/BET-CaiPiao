package com.mh.web.servlet;

import java.util.Collection;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

import javax.servlet.http.HttpSession;

/**
 * session上下文
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-25 上午10:23:37<br/>
 */
public class MySessionContext {
    private static Map<String, HttpSession> mymap = new ConcurrentHashMap<String, HttpSession>();

    public static void addSession(HttpSession session) {
        if (session != null) {
            mymap.put(session.getId(), session);
        }
    }

    public static void delSession(HttpSession session) {
        if (session != null) {
            mymap.remove(session.getId());
        }
    }

    public static HttpSession getSession(String jsessionid) {
        if (jsessionid == null) 
        	return null;
        return mymap.get(jsessionid);
    }
    
    public static Collection<HttpSession> getAllHttpSessions(){
    	return mymap.values();
    }

}
