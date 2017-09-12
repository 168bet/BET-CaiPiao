package com.mh.commons.utils;

public class HtmlUtils {
	/**
	 * 将字符串src中的子字符串fnd全部替换为新子字符串rep.<br>
	 * 功能相当于java sdk 1.4的String.replaceAll方法.<br>
	 * 不同之处在于查找时不是使用正则表达式而是普通字符串.
	 */
	public static String replaceAll(String src, String fnd, String rep)
			throws Exception {
		if (src == null || src.equals(""))
			return "";

		String dst = src;

		int idx = dst.indexOf(fnd);

		while (idx >= 0) {
			dst = dst.substring(0, idx) + rep
					+ dst.substring(idx + fnd.length(), dst.length());
			idx = dst.indexOf(fnd, idx + rep.length());
		}

		return dst;
	}

	/**
	 * 转换为HTML编码.<br>
	 */
	public static String htmlEncoder(String src) throws Exception {
		if (src == null || src.equals(""))
			return "";

		String dst = src;
		dst = replaceAll(dst, "<", "&lt;");
		dst = replaceAll(dst, ">", "&rt;");
		dst = replaceAll(dst, "\"", "&quot;");
		dst = replaceAll(dst, "’", "&#03Array;");

		return dst;
	}

	/**
	 * 反转换.<br>
	 */
	public static String htmlDecoder(String src) throws Exception {
		if (src == null || src.equals(""))
			return "";

		String dst = src;
		dst = replaceAll(dst, "&lt;", "<");
		dst = replaceAll(dst, "&rt;", ">");
		dst = replaceAll(dst, "&quot;", "\"");
		dst = replaceAll(dst, "&#03Array;", "’");

		return dst;
	}
}
