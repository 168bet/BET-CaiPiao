/**   
 * 文件名称: ResultsService.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: alex<br/>  
 * 创建时间 : 2015-6-4 上午10:41:47<br/>
 */
package com.mh.service;

import java.util.List;
import java.util.Map;

import com.mh.commons.orm.Page;
import com.mh.entity.TWebBankHuikuan;
import com.mh.entity.TWebDama;
import com.mh.entity.WebRecords;
import com.mh.entity.WebUserWithdraw;

/**
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-4 上午10:41:47<br/>
 */
@SuppressWarnings("all")
public interface WebRecordService {

	/**
	 * 
	 * 查询财务记录 方法描述: TODO</br>
	 * 
	 * @param page
	 * @param records
	 * @return Page
	 */
	public Page findFinancePage(Page page, WebRecords records);

	public List<TWebBankHuikuan> getHuiKuan(WebRecords records);

	public List<WebUserWithdraw> getWithdrawList(WebRecords records);


	/**
	 * 游戏平台报表 方法描述: TODO</br> 创建人: zoro<br/>
	 * 
	 * @param records
	 * @return List<Map<String,Object>>
	 */
	public List<Map<String, Object>> btReport(WebRecords records);

	public List<Map<String, Object>> btReportUser(WebRecords records);


	public TWebDama findWebDama(TWebDama dama);

}
