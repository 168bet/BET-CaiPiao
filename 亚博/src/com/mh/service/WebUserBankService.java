package com.mh.service;

import java.util.List;

import com.mh.entity.TWebUserBank;

public interface WebUserBankService {

	public void saveUserBankCard(TWebUserBank bank);

	public List<TWebUserBank> getBankList(String userName);

	public TWebUserBank getMasterCard(String userName);

	public TWebUserBank getBankCardById(Integer id);

	public boolean isExistBankCard(String bankCard);

}
