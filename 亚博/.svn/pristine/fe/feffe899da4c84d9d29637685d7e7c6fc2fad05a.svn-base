package com.mh.commons.utils;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class ValidStringUtil {

	/**
	 * 帐号
	 * 
	 * @param userName
	 * @return
	 */
	public static boolean validUserName(String userName) {
		Pattern pattern = Pattern.compile("^[a-z0-9]{4,10}$");
		Matcher m = pattern.matcher(userName);
		return m.find();
	}

	/**
	 * 密码
	 * 
	 * @param password
	 * @return
	 */
	public static boolean validPassword(String password) {
		Pattern pattern = Pattern.compile("^[a-zA-Z0-9]{6,12}$");
		Matcher m = pattern.matcher(password);
		return m.find();
	}

	/**
	 * 姓名:只能是中文，至少一个字
	 * 
	 * @param name
	 * @return
	 */
	public static boolean validName(String name) {
		Pattern pattern = Pattern.compile("^[\u4E00-\u9FA5]{1,10}$");
		Matcher m = pattern.matcher(name);
		return m.find();
	}

	public static boolean validMobile(String mobile) {
		Pattern pattern = Pattern.compile("^1[3456789]\\d{9}$");
		Matcher m = pattern.matcher(mobile);
		return m.find();
	}

	/**
	 * QQ
	 * 
	 * @param qq
	 * @return
	 */
	public static boolean validQQ(String qq) {
		Pattern pattern = Pattern.compile("^\\d{4,15}$");
		Matcher m = pattern.matcher(qq);
		return m.find();
	}

	/**
	 * 取款密码
	 * 
	 * @param qq
	 * @return
	 */
	public static boolean validWithdrawPw(String pw) {
		Pattern pattern = Pattern.compile("^\\d{4}$");
		Matcher m = pattern.matcher(pw);
		return m.find();
	}

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		System.out.println(validUserName("123s"));
		System.out.println(validPassword("2Wsddf"));
		System.out.println(validName("一"));
		System.out.println(validMobile("13676767666"));
		System.out.println(validQQ("7665"));
		System.out.println(validWithdrawPw("1111"));
	}

}
