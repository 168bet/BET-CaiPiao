package com.mh.commons.converters;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.springframework.core.convert.converter.Converter;

/**
 * 
 * @ClassName: CustomerConverter 
 * @Description: 测试校验器, 优先级低于定义注解的@DateTimeFormat
 * @author Victor.Chen chenld_fzu@163.com
 * @date 2012-3-29 下午08:25:22 
 * 移动端注册日期格式
 */
public class String2DateTimeConverter3 implements Converter<String, Date> {
    public Date convert(String source) {
        SimpleDateFormat dateFormat = new SimpleDateFormat("MM/dd/yyyy");
        dateFormat.setLenient(false);
        try {
            return dateFormat.parse(source);
        } catch (ParseException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }        
        return null;
    }
}
