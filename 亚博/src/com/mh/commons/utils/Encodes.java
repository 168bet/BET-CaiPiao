/**
 * Copyright (c) 2005-2012 springside.org.cn
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 */
package com.mh.commons.utils;

import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.security.MessageDigest;

import org.apache.commons.codec.DecoderException;
import org.apache.commons.codec.binary.Base64;
import org.apache.commons.codec.binary.Hex;
import org.apache.commons.lang3.StringEscapeUtils;
import org.apache.commons.lang3.Validate;
import org.springframework.util.Assert;

/**
 * 封装各种格式的编码解码工具类.
 * 
 * 1.Commons-Codec的 hex/base64 编码
 * 2.自行编写的，将long进行base62编码以缩短其长度
 * 3.Commons-Lang的xml/html escape
 * 4.JDK提供的URLEncoder
 * 
 * @author calvin
 */
public class Encodes {
	private static final String ALPHABET = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

	private static final String DEFAULT_URL_ENCODING = "UTF-8";
	private static String ALPHANUMERIC_STR;
	static {
		String numberStr = "0123456789";
		String aphaStr = "abcdefghijklmnopqrstuvwxyz";
		ALPHANUMERIC_STR = numberStr + aphaStr + aphaStr.toUpperCase();
	}

	private Encodes() {
	}

	/**
	 * Hex编码, byte[]->String.
	 */
	public static String encodeHex(byte[] input) {
		return Hex.encodeHexString(input);
	}

	/**
	 * Hex解码, String->byte[].
	 */
	public static byte[] decodeHex(String input) {
		try {
			return Hex.decodeHex(input.toCharArray());
		} catch (DecoderException e) {
			throw new IllegalStateException("Hex Decoder exception", e);
		}
	}

	/**
	 * Base64编码, byte[]->String.
	 */
	public static String encodeBase64(byte[] input) {
		return Base64.encodeBase64String(input);
	}

	/**
	 * Base64编码, URL安全(将Base64中的URL非法字符'+'和'/'转为'-'和'_', 见RFC3548).
	 */
	public static String encodeUrlSafeBase64(byte[] input) {
		return Base64.encodeBase64URLSafeString(input);
	}

	/**
	 * Base64解码, String->byte[].
	 */
	public static byte[] decodeBase64(String input) {
		return Base64.decodeBase64(input);
	}

	/**
	 * Base62(0_9A_Za_z)编码数字, long->String.
	 */
	public static String encodeBase62(long num) {
		return alphabetEncode(num, 62);
	}

	/**
	 * Base62(0_9A_Za_z)解码数字, String->long.
	 */
	public static long decodeBase62(String str) {
		return alphabetDecode(str, 62);
	}

	private static String alphabetEncode(long num, int base) {
		num = Math.abs(num);
		StringBuilder sb = new StringBuilder();
		for (; num > 0; num /= base) {
			sb.append(ALPHABET.charAt((int) (num % base)));
		}

		return sb.toString();
	}

	private static long alphabetDecode(String str, int base) {
		Validate.notBlank(str);

		long result = 0;
		for (int i = 0; i < str.length(); i++) {
			result += ALPHABET.indexOf(str.charAt(i)) * Math.pow(base, i);
		}

		return result;
	}

	/**
	 * Html 转码.
	 */
	public static String escapeHtml(String html) {
		return StringEscapeUtils.escapeHtml4(html);
	}

	/**
	 * Html 解码.
	 */
	public static String unescapeHtml(String htmlEscaped) {
		return StringEscapeUtils.unescapeHtml4(htmlEscaped);
	}

	/**
	 * Xml 转码.
	 */
	public static String escapeXml(String xml) {
		return StringEscapeUtils.escapeXml(xml);
	}

	/**
	 * Xml 解码.
	 */
	public static String unescapeXml(String xmlEscaped) {
		return StringEscapeUtils.unescapeXml(xmlEscaped);
	}

	/**
	 * Csv 转码.
	 */
	public static String escapeCsv(String csv) {
		return StringEscapeUtils.escapeCsv(csv);
	}

	/**
	 * Csv 解码.
	 */
	public static String unescapeCsv(String csvEscaped) {
		return StringEscapeUtils.unescapeCsv(csvEscaped);
	}

	/**
	 * URL 编码, Encode默认为UTF-8. 
	 */
	public static String urlEncode(String part) {
		try {
			return URLEncoder.encode(part, DEFAULT_URL_ENCODING);
		} catch (UnsupportedEncodingException e) {
			throw Exceptions.unchecked(e);
		}
	}

	/**
	 * URL 解码, Encode默认为UTF-8. 
	 */
	public static String urlDecode(String part) {

		try {
			return URLDecoder.decode(part, DEFAULT_URL_ENCODING);
		} catch (UnsupportedEncodingException e) {
			throw Exceptions.unchecked(e);
		}
	}
	
	/**
	 * SHA-1 加密
	 * @param srcStr
	 * @return
	 */
	public static String getSHADigest(String srcStr) {
		return getDigest(srcStr, "SHA-1");
	}

	/**
	 * MD5 加密
	 * @param srcStr
	 * @return
	 */
	public static String getMD5Digest(String srcStr) {
		return getDigest(srcStr, "MD5");
	}

	/**
	 * 获取特定长度的机器码
	 * @param length
	 * @return
	 */
	public static String getRandomStr(int length) {
		int srcStrLen = ALPHANUMERIC_STR.length();
		StringBuffer sb = new StringBuffer();
		for (int i = 0; i < length; ++i) {
			int maxnum = (int) (Math.random() * 1000.0D);
			int result = maxnum % srcStrLen;
			char temp = ALPHANUMERIC_STR.charAt(result);
			sb.append(temp);
		}
		return sb.toString();
	}

	/**
	 * 加密方法
	 * @param srcStr
	 * @param alg
	 * @return
	 */
	private static String getDigest(String srcStr, String alg) {
		Assert.notNull(srcStr);
		Assert.notNull(alg);
		try {
			MessageDigest alga = MessageDigest.getInstance(alg);
			alga.update(srcStr.getBytes());
			byte[] digesta = alga.digest();
			return byte2hex(digesta);
		} catch (Exception e) {
			throw new RuntimeException(e);
		}
	}

	/**
	 * 转码
	 * @param b
	 * @return
	 */
	private static String byte2hex(byte[] b) {
		StringBuffer hs = new StringBuffer();
		String stmp = "";
		for (int n = 0; n < b.length; ++n) {
			stmp = Integer.toHexString(b[n] & 0xFF);
			if (stmp.length() == 1) {
				hs.append("0");
			}
			hs.append(stmp);
		}
		return hs.toString().toUpperCase();
	}


}
