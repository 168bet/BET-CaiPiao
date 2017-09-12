package com.mh.dao;

import java.math.BigInteger;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

import com.mh.commons.orm.BaseDao;
import com.mh.entity.TWebUserBank;

@Repository
public class WebUserBankDao extends BaseDao<TWebUserBank, Integer> {

	public void saveUserBankCard(TWebUserBank entity) {
		this.getHibernateTemplate().save(entity);
	}

	@SuppressWarnings("unchecked")
	public List<TWebUserBank> getBankList(String userName) {
		List<TWebUserBank> list = new ArrayList<TWebUserBank>();
		String hql = " from TWebUserBank t where t.userName = '" + userName + "' and isEnable=1 ";
		list = this.getHibernateTemplate().find(hql);
		return list;
	}

	@SuppressWarnings("unchecked")
	public TWebUserBank getMasterCard(String userName) {
		String hql = " from TWebUserBank t where t.isMaster = 1 and t.userName = '" + userName + "'";
		List<TWebUserBank> list = this.getHibernateTemplate().find(hql);
		return list.size() > 0 ? list.get(0) : null;
	}

	@SuppressWarnings("unchecked")
	public TWebUserBank getBankCardById(Integer id) {
		String hql = " from TWebUserBank t where t.id = '" + id + "'";
		List<TWebUserBank> list = this.getHibernateTemplate().find(hql);
		return list.size() > 0 ? list.get(0) : null;
	}

	public boolean isExistBankCard(String bankCard) {
		List<Map<String, Object>> list = null;
		if(StringUtils.isNotBlank(bankCard)) {
			list = this.findBySql(" select count(1) as num from t_web_user_bank t where t.bank_card = ? ", new Object[] { bankCard });
		} else {
			list = this.findBySql(" select count(1) as num from t_web_user_bank t ");
		}
		BigInteger num = (BigInteger) list.get(0).get("num");
		return num.intValue() == 0 ? false : true;
	}

}
