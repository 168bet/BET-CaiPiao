package com.mh.commons.utils;

import java.text.ParseException;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;

public class WeekUtil {
	
	/**
	 * 取得当前日期是多少周
	 * 
	 * @param date
	 * @return
	 */
	public static int getWeekOfYear(Date date) {
		Calendar c = new GregorianCalendar();
		c.setFirstDayOfWeek(Calendar.MONDAY);
		c.setMinimalDaysInFirstWeek(7);
		c.setTime(date);
		
		int y =DateUtil.getYear(date);
		Date beginDate = getFirstDayOfWeek(y,0);
		Date endDate = getLastDayOfWeek(y,0);
		long times = date.getTime();
		long times1 = beginDate.getTime();
		long times2 = endDate.getTime();
		if(times>=times1&&times<=times2){
			return 0;
		}		
		return c.get(Calendar.WEEK_OF_YEAR);
	}

	/**
	 * 得到某一年周的总数
	 * 
	 * @param year
	 * @return
	 */
	public static int getMaxWeekNumOfYear(int year) {
		Calendar c = new GregorianCalendar();
		c.set(year, Calendar.DECEMBER, 31, 23, 59, 59);

		return getWeekOfYear(c.getTime());
	}

	/**
	 * 得到某年某周的第一天
	 * 
	 * @param year
	 * @param week
	 * @return
	 */
	public static Date getFirstDayOfWeek(int year, int week) {
		Date date = null;
		if(week==0){
			String dateStr = String.valueOf(year)+"-01-01";
			try {
				date = DateUtil.parse(dateStr, "yyyy-MM-dd");
			} catch (ParseException e) {
				e.printStackTrace();
			}
		}else{			
			Calendar c = new GregorianCalendar();
			c.set(Calendar.YEAR, year);
			c.set(Calendar.MONTH, Calendar.JANUARY);
			c.set(Calendar.DATE, 1);
			Calendar cal = (GregorianCalendar) c.clone();
			cal.add(Calendar.DATE, week * 7);
			date = getFirstDayOfWeek(cal.getTime());
		}

		return date;
	}

	/**
	 * 得到某年某周的最后一天
	 * 
	 * @param year
	 * @param week
	 * @return
	 */
	public static Date getLastDayOfWeek(int year, int week) {
		Date date = null;
		if(week==0){
			Calendar c = new GregorianCalendar();
			c.set(Calendar.YEAR, year);
			c.set(Calendar.MONTH, Calendar.JANUARY);
			c.set(Calendar.DATE, 1);			
			Calendar cal = (GregorianCalendar) c.clone();
			cal.add(Calendar.DATE, 1 * 7);			
			Date lastDate =  getFirstDayOfWeek(cal.getTime());
			date = DateUtil.addDay(lastDate, -1);			
		}else{			
			Calendar c = new GregorianCalendar();
			c.set(Calendar.YEAR, year);
			c.set(Calendar.MONTH, Calendar.JANUARY);
			c.set(Calendar.DATE, 1);			
			Calendar cal = (GregorianCalendar) c.clone();
			cal.add(Calendar.DATE, week * 7);			
			date =  getLastDayOfWeek(cal.getTime());
		}
		return date;
		
	}

	/**
	 * 取得当前日期所在周的第一天
	 * 
	 * @param date
	 * @return
	 */
	public static Date getFirstDayOfWeek(Date date) {
		Calendar c = new GregorianCalendar();
		c.setFirstDayOfWeek(Calendar.MONDAY);
		c.setTime(date);
		c.set(Calendar.DAY_OF_WEEK, c.getFirstDayOfWeek()); // Monday
		return c.getTime();
	}

	/**
	 * 取得当前日期所在周的最后一天
	 * 
	 * @param date
	 * @return
	 */
	public static Date getLastDayOfWeek(Date date) {
		Calendar c = new GregorianCalendar();
		c.setFirstDayOfWeek(Calendar.MONDAY);
		c.setTime(date);
		c.set(Calendar.DAY_OF_WEEK, c.getFirstDayOfWeek() + 6); // Sunday
		return c.getTime();
	}
	
	public static String getWeekOfDate(Date date) {
		String[] weekDays = { "星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六" };
		Calendar cal = Calendar.getInstance();
		cal.setTime(date);
		int w = cal.get(Calendar.DAY_OF_WEEK) - 1;
		if (w < 0)
			w = 0;
		return weekDays[w];
	}
	
	public static String getWeekOfDate(Date date, int days) {
		String[] weekDays = { "星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六" };
		Calendar cal = Calendar.getInstance();
		cal.setTime(date);
		cal.add(Calendar.DATE, days);
		int w = cal.get(Calendar.DAY_OF_WEEK) - 1;
		if (w < 0)
			w = 0;
		return weekDays[w];
	}

	public static void main(String[] args) {
		int year = 2006;
		int week = 1;

		// 以2006-01-02位例
		Calendar c = new GregorianCalendar();
		c.set(2006, Calendar.JANUARY, 2);
		Date d = c.getTime();

		System.out.println("current date = " + d);
		System.out.println("getWeekOfYear = " + getWeekOfYear(d));
		System.out
				.println("getMaxWeekNumOfYear = " + getMaxWeekNumOfYear(year));
		System.out.println("getFirstDayOfWeek = "
				+ getFirstDayOfWeek(year, week));
		System.out
				.println("getLastDayOfWeek = " + getLastDayOfWeek(year, week));
		System.out.println("getFirstDayOfWeek = " + getFirstDayOfWeek(d));
		System.out.println("getLastDayOfWeek = " + getLastDayOfWeek(d));
		
		Date date=null;
		try {
			date = DateUtil.parse("2014-08-01", "yyyy-MM-dd");
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		GregorianCalendar gCalendar = new GregorianCalendar();
		gCalendar .setTime(date );

		int dayOfMonth= gCalendar.getActualMaximum(GregorianCalendar.DAY_OF_MONTH);
		System.out.println(dayOfMonth);
	}

}
