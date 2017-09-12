package com.mh.commons.conf;


import org.jconfig.Category;
import org.jconfig.Configuration;
import org.jconfig.handler.XMLFileHandler;
import org.springframework.core.io.ClassPathResource;
import org.springframework.core.io.Resource;

/**
 * 
 * @ClassName: SystemConfig 
 * @Description: 读取配置文件 conf/system_config.xml
 * @author Victor.Chen chenld_fzu@163.com
 * @date 2012-3-25 上午10:21:25 
 *
 */
public class SystemConfig {
	private static Configuration configuration ;
	private static String SYSTEM_CONFIG = "system";
	private static String SYSTEM_CONFIG_PATH = "conf/system_config.xml";
	
	static{
		try{
			Resource resource = new ClassPathResource(SYSTEM_CONFIG_PATH);
			XMLFileHandler ish = new XMLFileHandler();
			configuration = ish.load(resource.getFile(), SYSTEM_CONFIG);
		}catch(Exception ex){
			ex.printStackTrace();
		}
	}
	
	private SystemConfig(){}
	
	/**
	 * 读取属性值
	 * @param key
	 * @param defaultValue
	 * @param category
	 * @return
	 */
	public static String getProperty(String key, String defaultValue, String category){
		return configuration.getProperty(key, defaultValue, category);
	}
	
	/**
	 * 读取属性值, value值用逗号分隔
	 * @param key
	 * @param defaultValue
	 * @param category
	 * @return
	 */
	public static String[] getArray(String key, String[] defaultValue, String category){
		return configuration.getArray(key, defaultValue, category);
	}
	
	/**
	 * 读取布尔值
	 * @param key
	 * @param defaultValue
	 * @param category
	 * @return
	 */
	public static boolean getBooleanProperty(String key, boolean defaultValue, String category){
		return configuration.getBooleanProperty(key, defaultValue, category);
	}
	
	/**
	 * 取得Category实例
	 * @param category
	 * @return
	 */
	public static Category getCategory(String category){
		return configuration.getCategory(category);
	}
}
