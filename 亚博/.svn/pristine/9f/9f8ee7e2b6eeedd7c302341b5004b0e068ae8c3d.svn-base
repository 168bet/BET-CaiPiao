package com.mh.web.login;

import com.mh.exceptions.NotLoginException;

/**
 * 上下文线程绑定器
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-25 上午9:50:33<br/>
 */
public class UserContextHolder {
	private static ThreadLocal<UserContext> holder = new ThreadLocal<UserContext>();
	
	private UserContextHolder(){}
	
	public static void set(UserContext userContext) {
		if(userContext != null)
			holder.set(userContext);
	}
	
	public static UserContext getUserContext(){
		UserContext uc = holder.get();
		
		if(uc == null)
			throw new NotLoginException("用户未登入");
		return uc;
	}
	
}
