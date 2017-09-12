/**   
 * 文件名称: WebRecordsServiceImpl.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: zoro<br/>  
 * 创建时间 : 2015-7-2 下午2:56:27<br/>
 */
package com.mh.service.impl;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.commons.orm.Page;
import com.mh.dao.WebDamaDao;
import com.mh.dao.WebRecordsDao;
import com.mh.entity.TWebBankHuikuan;
import com.mh.entity.TWebDama;
import com.mh.entity.WebRecords;
import com.mh.entity.WebUserWithdraw;
import com.mh.service.WebRecordService;

/**
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-7-2 下午2:56:27<br/>
 */
@SuppressWarnings("all")
@Service
public class WebRecordsServiceImpl implements WebRecordService {

	@Autowired
	private WebRecordsDao webRecordsDao;

	@Autowired
	private WebDamaDao webDamaDao;

	/**
	 * 
	 * 查询财务记录 方法描述: TODO</br>
	 * 
	 * @param page
	 * @param records
	 * @return Page
	 */
	public Page findFinancePage(Page page, WebRecords records) {
		return this.webRecordsDao.findFinancePage(page, records);
	}


	public List<Map<String, Object>> btReport(WebRecords records) {
		List<Map<String, Object>> list1 = webRecordsDao.report(records);
		return list1;
	}

	public TWebDama findWebDama(TWebDama dama) {
		List<TWebDama> damas = this.webDamaDao.findWebDama(dama);
		TWebDama webDama = null;
		if (null != damas && damas.size() > 0) {
			webDama = damas.get(0);
		}
		return webDama;
	}

	public WebRecordsDao getWebRecordsDao() {
		return webRecordsDao;
	}

	public void setWebRecordsDao(WebRecordsDao webRecordsDao) {
		this.webRecordsDao = webRecordsDao;
	}

	public WebDamaDao getWebDamaDao() {
		return webDamaDao;
	}

	public void setWebDamaDao(WebDamaDao webDamaDao) {
		this.webDamaDao = webDamaDao;
	}

	public List<Map<String, Object>> btReportUser(WebRecords records) {
		return this.webRecordsDao.reportUser(records);
	}

	public List<TWebBankHuikuan> getHuiKuan(WebRecords records) {
		return this.webRecordsDao.getHuiKuan(records);
	}

	public List<WebUserWithdraw> getWithdrawList(WebRecords records) {
		// TODO Auto-generated method stub
		return this.webRecordsDao.getWithdrawList(records);
	}



}
