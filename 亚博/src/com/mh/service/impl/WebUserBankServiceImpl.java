package com.mh.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.mh.dao.WebUserBankDao;
import com.mh.entity.TWebUserBank;
import com.mh.service.WebUserBankService;

@Service
public class WebUserBankServiceImpl implements WebUserBankService {

	@Autowired
	private WebUserBankDao webUserBankDao;

	@Override
	public void saveUserBankCard(TWebUserBank bank) {
		this.webUserBankDao.save(bank);
	}

	@Override
	public List<TWebUserBank> getBankList(String userName) {
		return this.webUserBankDao.getBankList(userName);
	}

	@Override
	public TWebUserBank getMasterCard(String userName) {
		return this.webUserBankDao.getMasterCard(userName);
	}

	@Override
	public TWebUserBank getBankCardById(Integer id) {
		return this.webUserBankDao.getBankCardById(id);
	}

	@Override
	public boolean isExistBankCard(String bankCard) {
		return this.webUserBankDao.isExistBankCard(bankCard);
	}
	
	

}
