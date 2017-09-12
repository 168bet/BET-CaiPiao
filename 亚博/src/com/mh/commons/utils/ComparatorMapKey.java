/**   
* 文件名称: ComparatorMapKey.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-7-17 下午4:22:16<br/>
*/  
package com.mh.commons.utils;

import java.util.Comparator;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-7-17 下午4:22:16<br/>
 */
public class ComparatorMapKey<T> implements Comparator<T> {

	@Override
	public int compare(Object o1, Object o2) {
		String u1 = (String) o1;
		String u2 = (String) o2;
		return u1.compareTo(u2);
	}

}
