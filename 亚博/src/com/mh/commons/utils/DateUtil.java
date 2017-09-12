package com.mh.commons.utils;

import java.math.BigDecimal;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.ParsePosition;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
@SuppressWarnings("all")
public class DateUtil {
	
	
	private static Log log = LogFactory.getLog(DateUtil.class);
	
	
	public static final String YEAR_MONTH_DAY_PATTERN_MIDLINE = "yyyy-MM-dd";// 年月日模式字符串yyyy-MM-dd

	public static final String YEAR_MONTH_DAY_PATTERN_DOT = "yyyy.MM.dd";// 年月日模式字符串yyyy.MM.dd

	public static final String YEAR_MONTH_DAY_PATTERN_BLANK = "yyyyMMdd";// 年月日模式字符串yyyyMMdd

	public static final String YEAR_MONTH_DAY_PATTERN_SOLIDUS = "yyyy/MM/dd";// 年月日模式字符串yyyy/MM/dd

	public static final String HOUR_MINUTE_SECOND_PATTERN = "HH:mm:ss";// 时分秒模式字符串
	//public static final String HOUR_MINUTE_SECOND_PATTERN = "HH24:mi:ss";// 时分秒模式字符串

	public static final String YMDHMS_PATTERN = "yyyy-MM-dd HH:mm:ss";// 年月日时分秒模式字符串
	//public static final String YMDHMS_PATTERN = "yyyy-MM-dd HH24:mi:ss";// 年月日时分秒模式字符串
	
	public static final String YMDHM_PATTERN = "yyyy-MM-dd HH:mm";// 年月日时分模式字符串
	

	/**
	 * 获得系统当前时间
	 * 
	 * @return Date
	 */
	public static Date currentDate() {
		return new Date(System.currentTimeMillis());
	}

	/**
	 * 获得系统当前时间
	 * 
	 * @return Date
	 */
	public static Timestamp currentTimestamp() {
		return new Timestamp(System.currentTimeMillis());
	}

	/**
	 * solidus 从数据库服务器获取当前时间。
	 * 
	 * @return 返回当前时间
	 * @throws SQLException
	 *             获取数据库时间时发生错误
	 */
	public static Date currentDate(Connection conn) throws SQLException {
		Date result = null;

		PreparedStatement pst = null;
		ResultSet rs = null;
		try {
			pst = conn.prepareStatement("select sysdate from dual");
			rs = pst.executeQuery();
			if (rs.next()) {
				Timestamp ts = rs.getTimestamp(1);
				if (ts != null) {
					result = new Date(ts.getTime());
				}
			}
		} finally {
			if (rs != null) {
				try {
					rs.close();
					rs = null;
				} catch (SQLException sqle) {
					// ignore it
				}
			}
			if (pst != null) {
				try {
					pst.close();
					pst = null;
				} catch (SQLException sqle) { // ignore it}
				}
			}
		}

		return result;
	}

	/**
	 * 从数据库服务器获取当前时间并根据传入的patter转换成字符串形式。
	 * 
	 * @param pattern
	 *            日期pattern
	 * @return 返回当前时间根据传入pattern转换后的字符串
	 * @throws SQLException
	 *             获取数据库时间时发生错误
	 */
	public static String currentDateString(Connection conn, final String pattern)
			throws SQLException {
		return format(currentDate(conn), pattern);
	}

	/**
	 * 从数据库服务器获取当前时间并转换成默认字符串形式（yyyy-MM-dd）。
	 * 
	 * @return 返回当前时间的默认字符串形式（yyyy-MM-dd）
	 * @throws SQLException
	 *             获取数据库时间时发生错误
	 */
	public static String currentDateDefaultString(Connection conn)
			throws SQLException {
		return format(currentDate(conn), YEAR_MONTH_DAY_PATTERN_MIDLINE);
	}

	/**
	 * 获取给定日期对象的年
	 * 
	 * @param date
	 *            日期对象
	 * @return 年
	 */
	public static int getYear(final Date date) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.YEAR);
	}

	/**
	 * 获取给定日期对象的月
	 * 
	 * @param date
	 *            日期对象
	 * @return 月
	 */
	public static int getMonth(final Date date) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.MONTH) + 1;
	}

	/**
	 * 获取给定日期对象的天
	 * 
	 * @param date
	 *            日期对象
	 * @return 天
	 */
	public static int getDay(final Date date) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.DATE);
	}

	/**
	 * 获取给定日期对象的时
	 * 
	 * @param date
	 *            日期对象
	 * @return 时
	 */
	public static int getHour(final Date date) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.HOUR);
	}

	/**
	 * 获取给定日期对象的分
	 * 
	 * @param date
	 *            日期对象
	 * @return 分
	 */
	public static int getMinute(final Date date) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.MINUTE);
	}

	/**
	 * 获取给定日期对象的秒
	 * 
	 * @param date
	 *            日期对象
	 * @return 秒
	 */
	public static int getSecond(final Date date) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.SECOND);
	}
	
	
	/**
	 * 获取当前月份首日是周几
	 * 
	 */
	public static int getFistDayWeek() {
		Calendar calendar = Calendar.getInstance();
		calendar.set(Calendar.DAY_OF_MONTH, 1);
		return calendar.get(Calendar.DAY_OF_WEEK) - 1;
	}
	
	
	

	/**
	 * 获取传入日期的年和月的Integer形式（yyyyMM）。
	 * 
	 * @param date
	 *            要转换的日期对象
	 * @return 转换后的Integer对象
	 */
	public static Integer getYearMonth(final Date date) {
		return new Integer(format(date, "yyyyMM"));
	}

	/**
	 * 将年月的整数形式（yyyyMM）转换为日期对象返回。
	 * 
	 * @param yearMonth
	 *            年月的整数形式（yyyyMM）
	 * @return 日期类型
	 * @throws ParseException
	 */
	public static Date parseYearMonth(final Integer yearMonth)
			throws ParseException {
		return parse(String.valueOf(yearMonth), "yyyyMM");
	}

	/**
	 * 将年月的字符串（yyyyMM）转换为日期对象返回。
	 * 
	 * @param yearMonth
	 *            年月的字符串（yyyyMM）
	 * @return 日期类型
	 * @throws ParseException
	 */
	public static Date parseYearMonth(final String yearMonth)
			throws ParseException {
		return parse(yearMonth, "yyyyMM");
	}

	/**
	 * 将某个日期增加指定年数，并返回结果。如果传入负数，则为减。
	 * 
	 * @param date
	 *            要操作的日期对象
	 * @param ammount
	 *            要增加年的数目
	 * @return 结果日期对象
	 */
	public static Date addYear(final Date date, final int ammount) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.YEAR, ammount);
		return c.getTime();
	}

	/**
	 * 将某个日期增加指定月数，并返回结果。如果传入负数，则为减。
	 * 
	 * @param date
	 *            要操作的日期对象
	 * @param ammount
	 *            要增加月的数目
	 * @return 结果日期对象
	 */
	public static Date addMonth(final Date date, final int ammount) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.MONTH, ammount);
		return c.getTime();
	}

	/**
	 * 将某个日期增加指定天数，并返回结果。如果传入负数，则为减。
	 * 
	 * @param date
	 *            要操作的日期对象
	 * @param ammount
	 *            要增加天的数目
	 * @return 结果日期对象
	 */
	public static Date addDay(final Date date, final int ammount) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.DATE, ammount);
		return c.getTime();
	}
	
	/**
	 * 将某个日期增加指定天数，并返回结果。如果传入负数，则为减。
	 * 
	 * @param date
	 *            要操作的日期对象
	 * @param ammount
	 *            要增加天的数目
	 * @return 结果日期对象
	 */
	public static Date addSecond(final Date date, final int ammount) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.SECOND, ammount);
		return c.getTime();
	}
	
	/**
	 * 加分钟
	 * 方法描述: TODO</br> 
	 * @param date
	 * @param ammount
	 * @return  
	 * Date
	 */
	public static Date addMinute(final Date date, final int ammount) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.MINUTE, ammount);
		return c.getTime();
	}
	
	
	/**
	 * 添加小时
	 * 方法描述: TODO</br> 
	 * @param date
	 * @param ammount
	 * @return  
	 * Date
	 */
	public static Date addHour(final Date date, final int ammount) {
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.HOUR, ammount);
		return c.getTime();
	}

	/**
	 * 将给定整数形式的年月增加指定月数，并返回结果。如果传入负数，则为减。
	 * 
	 * @param yearMonth
	 *            要操作的年月
	 * @param ammount
	 *            要增加的月数
	 * @return 结果年月
	 * @throws ParseException
	 */
	public static Integer addMonth(final Integer yearMonth, final int ammount)
			throws ParseException {
		return getYearMonth(addMonth(parseYearMonth(yearMonth), ammount));
	}

	/**
	 * 返回给定的beforeDate比afterDate早的年数。如果beforeDate晚于afterDate，则 返回负数。
	 * 
	 * @param beforeDate
	 *            要比较的早的日期
	 * @param afterDate
	 *            要比较的晚的日期
	 * @return beforeDate比afterDate早的年数，负数表示晚。
	 */
	public static int beforeYears(final Date beforeDate, final Date afterDate) {
		Calendar beforeCalendar = Calendar.getInstance();
		beforeCalendar.setTime(beforeDate);
		beforeCalendar.set(Calendar.MONTH, 1);
		beforeCalendar.set(Calendar.DATE, 1);
		beforeCalendar.set(Calendar.HOUR, 0);
		beforeCalendar.set(Calendar.SECOND, 0);
		beforeCalendar.set(Calendar.MINUTE, 0);
		Calendar afterCalendar = Calendar.getInstance();
		afterCalendar.setTime(afterDate);
		afterCalendar.set(Calendar.MONTH, 1);
		afterCalendar.set(Calendar.DATE, 1);
		afterCalendar.set(Calendar.HOUR, 0);
		afterCalendar.set(Calendar.SECOND, 0);
		afterCalendar.set(Calendar.MINUTE, 0);
		boolean positive = true;
		if (beforeDate.after(afterDate))
			positive = false;
		int beforeYears = 0;
		while (true) {
			boolean yearEqual = beforeCalendar.get(Calendar.YEAR) == afterCalendar
					.get(Calendar.YEAR);
			if (yearEqual) {
				break;
			} else {
				if (positive) {
					beforeYears++;
					beforeCalendar.add(Calendar.YEAR, 1);
				} else {
					beforeYears--;
					beforeCalendar.add(Calendar.YEAR, -1);
				}
			}
		}
		return beforeYears;
	}

	/**
	 * 返回给定的beforeDate比afterDate早的月数。如果beforeDate晚于afterDate，则 返回负数。
	 * 
	 * @param beforeDate
	 *            要比较的早的日期
	 * @param afterDate
	 *            要比较的晚的日期
	 * @return beforeDate比afterDate早的月数，负数表示晚。
	 */
	public static int beforeMonths(final Date beforeDate, final Date afterDate) {
		Calendar beforeCalendar = Calendar.getInstance();
		beforeCalendar.setTime(beforeDate);
		beforeCalendar.set(Calendar.DATE, 1);
		beforeCalendar.set(Calendar.HOUR, 0);
		beforeCalendar.set(Calendar.SECOND, 0);
		beforeCalendar.set(Calendar.MINUTE, 0);
		Calendar afterCalendar = Calendar.getInstance();
		afterCalendar.setTime(afterDate);
		afterCalendar.set(Calendar.DATE, 1);
		afterCalendar.set(Calendar.HOUR, 0);
		afterCalendar.set(Calendar.SECOND, 0);
		afterCalendar.set(Calendar.MINUTE, 0);
		boolean positive = true;
		if (beforeDate.after(afterDate))
			positive = false;
		int beforeMonths = 0;
		while (true) {
			boolean yearEqual = beforeCalendar.get(Calendar.YEAR) == afterCalendar
					.get(Calendar.YEAR);
			boolean monthEqual = beforeCalendar.get(Calendar.MONTH) == afterCalendar
					.get(Calendar.MONTH);
			if (yearEqual && monthEqual) {
				break;
			} else {
				if (positive) {
					beforeMonths++;
					beforeCalendar.add(Calendar.MONTH, 1);
				} else {
					beforeMonths--;
					beforeCalendar.add(Calendar.MONTH, -1);
				}
			}
		}
		return beforeMonths;
	}

	/**
	 * 返回给定的beforeDate比afterDate早的天数。如果beforeDate晚于afterDate，则 返回负数。
	 * 
	 * @param beforeDate
	 *            要比较的早的日期
	 * @param afterDate
	 *            要比较的晚的日期
	 * @return beforeDate比afterDate早的天数，负数表示晚。
	 */
	public static int beforeDays(final Date beforeDate, final Date afterDate) {
		Calendar beforeCalendar = Calendar.getInstance();
		beforeCalendar.setTime(beforeDate);
		beforeCalendar.set(Calendar.HOUR, 0);
		beforeCalendar.set(Calendar.SECOND, 0);
		beforeCalendar.set(Calendar.MINUTE, 0);
		Calendar afterCalendar = Calendar.getInstance();
		afterCalendar.setTime(afterDate);
		afterCalendar.set(Calendar.HOUR, 0);
		afterCalendar.set(Calendar.SECOND, 0);
		afterCalendar.set(Calendar.MINUTE, 0);
		boolean positive = true;
		if (beforeDate.after(afterDate))
			positive = false;
		int beforeDays = 0;
		while (true) {
			boolean yearEqual = beforeCalendar.get(Calendar.YEAR) == afterCalendar
					.get(Calendar.YEAR);
			boolean monthEqual = beforeCalendar.get(Calendar.MONTH) == afterCalendar
					.get(Calendar.MONTH);
			boolean dayEqual = beforeCalendar.get(Calendar.DATE) == afterCalendar
					.get(Calendar.DATE);
			if (yearEqual && monthEqual && dayEqual) {
				break;
			} else {
				if (positive) {
					beforeDays++;
					beforeCalendar.add(Calendar.DATE, 1);
				} else {
					beforeDays--;
					beforeCalendar.add(Calendar.DATE, -1);
				}
			}
		}
		return beforeDays;
	}

	/**
	 * 获取beforeDate和afterDate之间相差的完整年数，精确到天。负数表示晚。
	 * 
	 * @param beforeDate
	 *            要比较的早的日期
	 * @param afterDate
	 *            要比较的晚的日期
	 * @return beforeDate比afterDate早的完整年数，负数表示晚。
	 */
	public static int beforeRoundYears(final Date beforeDate,
			final Date afterDate) {
		Date bDate = beforeDate;
		Date aDate = afterDate;
		boolean positive = true;
		if (beforeDate.after(afterDate)) {
			positive = false;
			bDate = afterDate;
			aDate = beforeDate;
		}
		int beforeYears = beforeYears(bDate, aDate);

		int bMonth = getMonth(bDate);
		int aMonth = getMonth(aDate);
		if (aMonth < bMonth) {
			beforeYears--;
		} else if (aMonth == bMonth) {
			int bDay = getDay(bDate);
			int aDay = getDay(aDate);
			if (aDay < bDay) {
				beforeYears--;
			}
		}

		if (positive) {
			return beforeYears;
		} else {
			return new BigDecimal(beforeYears).negate().intValue();
		}
	}

	/**
	 * 获取beforeDate和afterDate之间相差的完整年数，精确到月。负数表示晚。
	 * 
	 * @param beforeDate
	 *            要比较的早的日期
	 * @param afterDate
	 *            要比较的晚的日期
	 * @return beforeDate比afterDate早的完整年数，负数表示晚。
	 */
	public static int beforeRoundAges(final Date beforeDate,
			final Date afterDate) {
		Date bDate = beforeDate;
		Date aDate = afterDate;
		boolean positive = true;
		if (beforeDate.after(afterDate)) {
			positive = false;
			bDate = afterDate;
			aDate = beforeDate;
		}
		int beforeYears = beforeYears(bDate, aDate);

		int bMonth = getMonth(bDate);
		int aMonth = getMonth(aDate);
		if (aMonth < bMonth) {
			beforeYears--;
		}

		if (positive) {
			return beforeYears;
		} else {
			return new BigDecimal(beforeYears).negate().intValue();
		}
	}

	/**
	 * 获取beforeDate和afterDate之间相差的完整月数，精确到天。负数表示晚。
	 * 
	 * @param beforeDate
	 *            要比较的早的日期
	 * @param afterDate
	 *            要比较的晚的日期
	 * @return beforeDate比afterDate早的完整月数，负数表示晚。
	 */
	public static int beforeRoundMonths(final Date beforeDate,
			final Date afterDate) {
		Date bDate = beforeDate;
		Date aDate = afterDate;
		boolean positive = true;
		if (beforeDate.after(afterDate)) {
			positive = false;
			bDate = afterDate;
			aDate = beforeDate;
		}
		int beforeMonths = beforeMonths(bDate, aDate);

		int bDay = getDay(bDate);
		int aDay = getDay(aDate);
		if (aDay < bDay) {
			beforeMonths--;
		}

		if (positive) {
			return beforeMonths;
		} else {
			return new BigDecimal(beforeMonths).negate().intValue();
		}
	}

	/**
	 * 根据传入的年、月、日构造日期对象
	 * 
	 * @param year
	 *            年
	 * @param month
	 *            月
	 * @param date
	 *            日
	 * @return 返回根据传入的年、月、日构造的日期对象
	 */
	public static Date getDate(final int year, final int month, final int date) {
		Calendar c = Calendar.getInstance();
		c.set(year, month, date);
		return c.getTime();
	}

	/**
	 * 根据传入的日期格式化pattern将传入的日期格式化成字符串。
	 * 
	 * @param date
	 *            要格式化的日期对象
	 * @param pattern
	 *            日期格式化pattern
	 * @return 格式化后的日期字符串
	 */
	public static String format(final Date date, final String pattern) {
		DateFormat df = new SimpleDateFormat(pattern);
		return df.format(date);
	}

	/**
	 * 将传入的日期按照默认形势转换成字符串（yyyy-MM-dd HH:mm:ss）
	 * 
	 * @param date
	 *            要格式化的日期对象
	 * @return 格式化后的日期字符串
	 */
	public static String format(final Date date) {
		return format(date, YMDHMS_PATTERN);
	}

	/**
	 * 根据传入的日期格式化patter将传入的字符串转换成日期对象
	 * 
	 * @param dateStr
	 *            要转换的字符串
	 * @param pattern
	 *            日期格式化pattern
	 * @return 转换后的日期对象
	 * @throws ParseException
	 *             如果传入的字符串格式不合法
	 */
	public static Date parse(final String dateStr, final String pattern)
			throws ParseException {
		DateFormat df = new SimpleDateFormat(pattern);

		return df.parse(dateStr);
	}

	public static Date parse(Date date, final String pattern)
			throws ParseException {
		return parse(date.toString(), pattern);
	}

	/**
	 * 将传入的字符串按照默认格式转换为日期对象（yyyy-MM-dd）
	 * 
	 * @param dateStr
	 *            要转换的字符串
	 * @return 转换后的日期对象
	 * @throws ParseException
	 *             如果传入的字符串格式不符合默认格式（如果传入的字符串格式不合法）
	 */
	public static Date parse(final String dateStr) throws ParseException {
		return parse(dateStr, YEAR_MONTH_DAY_PATTERN_MIDLINE);
	}

	/**
	 * 要进行合法性验证的年月数值
	 * 
	 * @param yearMonth
	 *            验证年月数值
	 * @return 年月是否合法
	 */
	public static boolean isYearMonth(final Integer yearMonth) {
		String yearMonthStr = yearMonth.toString();
		return isYearMonth(yearMonthStr);
	}

	/**
	 * 要进行合法性验证的年月字符串
	 * 
	 * @param yearMonthStr
	 *            验证年月字符串
	 * @return 年月是否合法
	 */
	public static boolean isYearMonth(final String yearMonthStr) {
		if (yearMonthStr.length() != 6)
			return false;
		else {
			String yearStr = yearMonthStr.substring(0, 4);
			String monthStr = yearMonthStr.substring(4, 6);
			try {
				int year = Integer.parseInt(yearStr);
				int month = Integer.parseInt(monthStr);
				if (year < 1800 || year > 3000) {
					return false;
				}
				if (month < 1 || month > 12) {
					return false;
				}
				return true;
			} catch (Exception e) {
				return false;
			}
		}
	}

	/**
	 * 获取一个月的最大天数
	 * 
	 * @param date
	 *            要计算月份
	 * @return int 一个月的最大天数
	 */
	public static int getDayOfMonth(final Date date) {
		java.util.Calendar calendarDate = java.util.Calendar.getInstance();
		calendarDate.setTime(date);
		return calendarDate.getActualMaximum(calendarDate.DAY_OF_MONTH);
	}

	/**
	 * 获取从from到to的年月Integer形式值的列表
	 * 
	 * @param from
	 *            从
	 * @param to
	 *            到
	 * @return 年月Integer形式值列表
	 * @throws ParseException
	 */
	public static List getYearMonths(Integer from, Integer to)
			throws ParseException {
		List yearMonths = new ArrayList();
		Date fromDate = parseYearMonth(from);
		Date toDate = parseYearMonth(to);
		if (fromDate.after(toDate))
			throw new IllegalArgumentException(
					"'from' date should before 'to' date!");
		Date tempDate = fromDate;
		while (tempDate.before(toDate)) {
			yearMonths.add(getYearMonth(tempDate));
			tempDate = addMonth(tempDate, 1);
		}
		if (!from.equals(to)) {
			yearMonths.add(to);
		}

		return yearMonths;
	}

	/**
	 * 清除时间字符串的格式信息
	 * 
	 * @param ymd
	 * @return
	 */
	public static String clearFormat(String ymd) throws ParseException {
		Date date = parse(ymd, DateUtil.YEAR_MONTH_DAY_PATTERN_MIDLINE);
		String _ymd = format(date, YEAR_MONTH_DAY_PATTERN_BLANK);
		return _ymd;
	}




	/**
	 * 获取当前时间格式为yyyy-MM-dd串
	 * 
	 * @return
	 */
	public static String getCurrentDateForYYYYMMdd() {
		return format(currentDate());
	}
	
	 /** 
	  * 将java.util.Date 格式转换为字符串格式'yyyy-MM-dd HH:mm:ss'(24小时制)<br>
	  * 如Sat May 11 17:24:21 CST 2002 to '2002-05-11 17:24:21'<br>
	  *  @param  time Date 日期<br>
	  *  @return  String   字符串<br>
	  */ 
	   
	public   static  String dateToString(Date time)  {
		SimpleDateFormat formatter;
	    formatter  =   new  SimpleDateFormat (YEAR_MONTH_DAY_PATTERN_MIDLINE);
	    String ctime  =  formatter.format(time);
	    return  ctime;
	} 
	
	/**
	 * todo:字符串转化为日期
	 * @param dateStr
	 * @return
	 */
	public static Date parseStringToDate(String dateStr) {
		Date date = null;
		SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd");
		try {
			date = df.parse(dateStr);
		} catch (Exception ex) {
			log.error(ex.getMessage(), ex);
		}
		return date;
	}
	
	

	/**
	 * 获取当前时间 格式：yyyy-MM-dd HH:mm:ss
	 * 
	 * @return String
	 */
	public static String getTime() {
		return new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date());
	}
	
	
	
	public static String formatToday(String format) {
		Date date = new Date();
		SimpleDateFormat formatter = new SimpleDateFormat(format);
		String dateStr = formatter.format(date);
		return dateStr;
	}
	
	
	
	public static String formatDate(Date date, String format) {
		SimpleDateFormat formatter = new SimpleDateFormat(format);
		String dateStr = formatter.format(date);
		return dateStr;
	}
	
	
	
	public static boolean isBefore(String strDate, String strDateFormat) {
		Date date = toDate(strDate, strDateFormat);
		Date now = new Date();
		return date.before(now);
	}
	
	private static Date toDate(String strData, String strDateFormat) {
        if (strData == null) {
            return null;
        } else {
            SimpleDateFormat formatter = new SimpleDateFormat(strDateFormat);
            ParsePosition pos = new ParsePosition(0);
            Date dReturn = formatter.parse(strData, pos);
            return dReturn;
        }
    }
	
	
	public static List<String> getYearMonthList(int year){
		SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd");
		List<String> dayList = new ArrayList<String>();
		int currMonth = getMonth(new Date());
		int currYear = getYear(new Date());
		int month=currMonth;
		if(year<currYear){
			month = 12;
		}
		
		for(int i=1;i<=month;i++ ){
			String monthTemp = String.valueOf(i);
			if(i<10){
				monthTemp = "0" +i;
			}
			String dateStr =year+"-"+monthTemp+"-01";
			Date date=null;
			try {
				date = format.parse(dateStr);
			} catch (ParseException e) {
				e.printStackTrace();
			}
			int maxDay = getDayOfMonth(date);
			for(int j=1;j<=maxDay;j++){
				String day = String.valueOf(j);
				if(j<10){
					day = "0"+day;
				}
				String curDateStr = year+"-"+monthTemp+"-"+day;
				
				
				
				dayList.add(curDateStr);
			}
			
		}
		return dayList;
		
	}
	
	
	/**
	 * 获取上下一个月
	 * 方法描述: TODO</br> 
	 * @return  
	 * List<String>
	 */
	public static List<String> getPNMonthList(String gatherDay){
		int num = Integer.valueOf(gatherDay);
		List<String> dayList = new ArrayList<String>();
		SimpleDateFormat ftym = new SimpleDateFormat("yyyy-MM");
		Date currDate = new Date();
		Date preDate = DateUtil.addDay(currDate, -num);
		String preYM = ftym.format(preDate);
		String curYM = ftym.format(currDate);
		int currDay = getDay(currDate);
		int preDay = getDay(preDate);
		if(preYM.equals(curYM)){
			for(int i=currDay-num;i<=currDay;i++){
				String currDayStr = String.valueOf(i);
				if(i<10){
					currDayStr = "0"+currDayStr;
				}
				String currDateStr = curYM +"-"+currDayStr;
				dayList.add(currDateStr);
			}
			
		}else{
			int preMaxDay = getDayOfMonth(preDate);
			for(int i=preDay;i<=preMaxDay;i++){
				String preDayStr = String.valueOf(i);
				if(i<10){
					preDayStr ="0"+preDayStr;
				}
				String preDateStr = preYM +"-"+preDayStr;
				dayList.add(preDateStr);
			}
			
			for(int i=1;i<=currDay;i++){
				String currDayStr = String.valueOf(i);
				if(i<10){
					currDayStr = "0"+currDayStr;
				}
				String currDateStr = curYM +"-"+currDayStr;
				dayList.add(currDateStr);
			}
		}
 
		return dayList;
		
	}
	
	/***
	 * 得到GMT-4美东时间
	 * 方法描述: TODO</br> 
	 * @param format
	 * @return  
	 * String
	 */
	public static String getGMT_4_String(String format) {
		SimpleDateFormat formatter = new SimpleDateFormat(format);
		Calendar cal = Calendar.getInstance();// 获取当前日期
		cal.setTime(new Date());

		//cal.add(Calendar.HOUR, -12);
		return formatter.format(cal.getTime());
	}
	
	public static Date getDateForString(String dateStr) throws ParseException {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		return formatter.parse(dateStr);
	}
	
	/** 时间对象转成标准时间 **/
	public static String getDateString(Date date) throws ParseException {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		return formatter.format(date);
	}
	
	/**
	 * 获取美东时间
	 * 
	 * @return
	 */
	public static Date getGMT_4_Date() {
		Calendar cal = Calendar.getInstance();
		//cal.add(Calendar.HOUR, -12);
		return cal.getTime();
	}
	
	
	/**
	 * 获取相减小时数
	 * 方法描述: TODO</br> 
	 * @param date1
	 * @param date2
	 * @return  
	 * long
	 */
	public static long mulHours(Date date1,Date date2){
		return (date1.getTime()-date2.getTime())/(1000*60*60);
	}
	
	
	/**
	 * 相差分钟
	 * 方法描述: TODO</br> 
	 * @param date1
	 * @param date2
	 * @return  
	 * long
	 */
	public static long mulMinute(Date date1,Date date2){
		
		return (date1.getTime()-date2.getTime())/(1000*60);
	}
	
	public static long mulSecond(Date date1,Date date2){
		return (date1.getTime()-date2.getTime())/1000;
	}
	
	
	
	
	public static String todayBegin() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 00:00:00");
		Calendar c = Calendar.getInstance();
		Date date = getGMT_4_Date();// 当前美东时间
		c.setTime(date);
		return formatter.format(c.getTime());
	}

	public static String todayEnd() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 23:59:59");
		Calendar c = Calendar.getInstance();
		Date date = getGMT_4_Date();// 当前美东时间
		c.setTime(date);
		return formatter.format(c.getTime());
	}
	
	public static String dayBegin(Date date, int days) {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 00:00:00");
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.DATE, days);
		return formatter.format(c.getTime());
	}

	public static String dayEnd(Date date, int days) {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 23:59:59");
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		c.add(Calendar.DATE, days);
		return formatter.format(c.getTime());
	}
	
	
	public static String yesterdayBegin() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 00:00:00");
		Calendar yesterdate = Calendar.getInstance();
		Date date = getGMT_4_Date();
		yesterdate.setTime(date);
		yesterdate.add(Calendar.DATE, -1);
		return formatter.format(yesterdate.getTime());
	}

	public static String yesterdayEnd() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 23:59:59");
		Calendar yesterdate = Calendar.getInstance();
		Date date = getGMT_4_Date();
		yesterdate.setTime(date);
		yesterdate.add(Calendar.DATE, -1);
		return formatter.format(yesterdate.getTime());
	}

	public static String weekBegin() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 00:00:00");
		Calendar c = Calendar.getInstance();

		Date date = getGMT_4_Date();
		c.setTime(date);

		int day_of_week = c.get(Calendar.DAY_OF_WEEK) - 1;
		if (day_of_week == 0)
			day_of_week = 7;
		c.add(Calendar.DATE, -day_of_week + 1);
		return formatter.format(c.getTime());
	}

	public static String weekEnd() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 23:59:59");
		Calendar c = Calendar.getInstance();

		Date date = getGMT_4_Date();
		c.setTime(date);

		int day_of_week = c.get(Calendar.DAY_OF_WEEK) - 1;
		if (day_of_week == 0)
			day_of_week = 7;
		c.add(Calendar.DATE, 7 - day_of_week);
		return formatter.format(c.getTime());
	}

	

	public static String preMonthBegin() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
		Calendar cal = Calendar.getInstance();// 获取当前日期
		Date date = getGMT_4_Date();
		cal.setTime(date);

		cal.add(Calendar.MONTH, -1);
		cal.set(Calendar.DAY_OF_MONTH, 1);// 设置为1号,当前日期既为本月第一天
		return formatter.format(cal.getTime());
	}

	public static String preMonthEnd() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
		Calendar cale = Calendar.getInstance();
		Date date = getGMT_4_Date();
		cale.setTime(date);

		cale.set(Calendar.DAY_OF_MONTH, 0);// 设置为1号,当前日期既为本月第一天
		return formatter.format(cale.getTime());
	}
	
	public static String getDateBeforeDays(Date date, int days) {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
		Calendar cal = Calendar.getInstance();
		cal.setTime(date);
		cal.add(Calendar.DATE, days);
		return formatter.format(cal.getTime());
	}
	
	public static String getGMT_4_YYYMMDD(){
		Date d = getGMT_4_Date();
		SimpleDateFormat formatter = new SimpleDateFormat("yyyyMMdd");
		return formatter.format(d);
	}
	public static String getGMT_8_YYYMMDD(){
		Date d = addHour(getGMT_4_Date(), 12);
		SimpleDateFormat formatter = new SimpleDateFormat("yyyyMMdd");
		return formatter.format(d);
	}
	public static String monthBegin() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
		Calendar c = Calendar.getInstance();
		Date date = getGMT_4_Date();
		c.setTime(date);

		c.add(Calendar.MONTH, 0);
		c.set(Calendar.DAY_OF_MONTH, 1);// 设置为1号,当前日期既为本月第一天
		return formatter.format(c.getTime());
	}

	public static String monthEnd() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
		Calendar c = Calendar.getInstance();
		Date date = getGMT_4_Date();
		c.setTime(date);

		c.set(Calendar.DATE, c.getActualMaximum(Calendar.DATE));
		return formatter.format(c.getTime());
	}
	
	public static String getGMT_4_BeginString(String year, String month) {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 00:00:00");
		Calendar calendar = Calendar.getInstance();
		calendar.set(Integer.valueOf(year), Integer.valueOf(month) - 1, Calendar.DATE);

		calendar.set(Calendar.DAY_OF_MONTH, calendar.getActualMinimum(Calendar.DAY_OF_MONTH));
		return formatter.format(calendar.getTime());
	}

	public static String getGMT_4_EndString(String year, String month) {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd 23:59:59");
		Calendar calendar = Calendar.getInstance();
		calendar.set(Integer.valueOf(year), Integer.valueOf(month) - 1, Calendar.DATE);

		calendar.set(Calendar.DAY_OF_MONTH, calendar.getActualMaximum(Calendar.DAY_OF_MONTH));
		return formatter.format(calendar.getTime());
	}
	
	public static String getGMT_4_YearAndMonth() {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM");

		return formatter.format(getGMT_4_Date());
	}
	/**
	 *  时差，北京时间转美东时间
	 */
	public static Date getCp_GMT_Time(Date gmt8) {
		Calendar cal = Calendar.getInstance();
		cal.setTime(gmt8);
		cal.add(Calendar.HOUR, -12);
		return cal.getTime();
	}
	/**
	 *  美东时间转北京时间
	 */
	public static Date getCp_MD_Time(Date md) {
		Calendar cal = Calendar.getInstance();
		cal.setTime(md);
		cal.add(Calendar.HOUR, 12);
		return cal.getTime();
	}
	
}
