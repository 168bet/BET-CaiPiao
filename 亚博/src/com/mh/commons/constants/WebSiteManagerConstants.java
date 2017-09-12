package com.mh.commons.constants;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.collections.CollectionUtils;

import com.mh.entity.LinkWebPage;
import com.mh.entity.LinkWebPromosType;
import com.mh.entity.WebAgent;
import com.mh.entity.WebCarousel;
import com.mh.entity.WebGongGao;
import com.mh.entity.WebLineCk;
import com.mh.entity.WebPage;
import com.mh.entity.WebPanel;
import com.mh.entity.WebPromos;
import com.mh.entity.WebPromosType;
import com.mh.entity.WebResource;
import com.mh.entity.WebSite;
import com.mh.entity.WebSwitch;
import com.mh.entity.WebWeiHu;

/**
 * 就是要把这些数据放在内存中而已 ClassName: WebSiteManagerConstants
 * 
 * @Description: TODO
 * @author andy
 * @date 2015-7-18
 */
public class WebSiteManagerConstants {

	public static String FTL_PATH="/commons/web/ybb/template/ftl";
	public static String PROMOS_HTML_PATH="/commons/web/ybb/html/promos";
	public static String HELP_HTML_PATH="/commons/web/ybb/html/help";
	
	public static String UPLOAD_FILE_PATH="/commons/web/ybb/upload/file";
	

	
	public static Map<String, Object> SYSPARAMMAP;//网站webParamter表参数
	
	public static WebSite WEBSITE_INFO;//网站基本信息

	public static List<WebCarousel> WEBCAROUSEL_LIST;// 轮播信息
	
	public static List<WebGongGao> WEBGONGGAO_LIST;// 公告信息

	public static WebLineCk WEBLINECK_INFO;// 线路信息

	public static List<WebPage> WEBPAGE_LIST;// 页面信息
	public static Map<String,WebPage> WEBPAGE_ALONE_MAP;//单独页面MAP集合
	public static Map<String,WebPage> WEBPAGE_MOBILE_MAP = new HashMap<String, WebPage>();//手机端底部页面
	public static List<WebPage> WEBPAGE_ALONE_LIST;//单独的页面集合,页面类型为2；
	
	public static Map<Integer, String> WEBPAGE_MAP;// key:活动类型ID
													// value：活动html相对路径

	public static List<WebPanel> WEBPANEL_LIST;// 面板信息

	public static List<WebPromos> WEBPROMOS_LIST;// 活动信息
	public static List<WebPromos> LbWEBPROMOS_LIST;// 轮播活动信息

	public static List<WebPromosType> WEBPROMOSTYPE_LIST;// 所有可用活动类型集合
	public static Map<Integer, String> WEPPROMOS_MAP;// key:活动类型ID
														// value：活动html相对路径

	public static List<WebResource> WEBRESOURCE_LIST;// 资源配置信息
	public static List<WebSwitch> WEBSWITCH_LIST;// 选项配置信息
	public static List<WebWeiHu> WEBWEIHU_LIST;// 维护信息

	public static List<WebAgent> WEBAGENT_LIST;//代理信息
	
	public static List<LinkWebPromosType> LINKWEBPROMOSTYPE_LIST;// 活动关联表
	public static List<LinkWebPage> LINKWEBPAGE_LIST;// 页面关联表

	public static Map<String, String> ctxMap;// 前端页面级别常用数据

	public static void initCtxMap() {
		if (ctxMap == null) {
			ctxMap = new HashMap<String, String>();
		}else{
			ctxMap.clear();
		}
		if (WEBSITE_INFO != null) {
			ctxMap.put("siteName", WEBSITE_INFO.getSiteName());
			ctxMap.put("siteDomain", WEBSITE_INFO.getSiteDomain());
			ctxMap.put("siteQq", WEBSITE_INFO.getSiteQq());
			ctxMap.put("siteTel", WEBSITE_INFO.getSiteTel());
			ctxMap.put("siteMail", WEBSITE_INFO.getSiteMail());
			ctxMap.put("siteMobile", WEBSITE_INFO.getSiteMobile());
			ctxMap.put("siteLine", WEBSITE_INFO.getSiteLine());
			ctxMap.put("siteKeywords", WEBSITE_INFO.getSiteKeywords());
			ctxMap.put("siteDescription", WEBSITE_INFO.getSiteDescription());
			ctxMap.put("siteFooter", WEBSITE_INFO.getSiteFooter());
		}

		if (CollectionUtils.isNotEmpty(WEBSWITCH_LIST)) {
			for (WebSwitch sw : WEBSWITCH_LIST) {
				ctxMap.put(sw.getSwtName(), String.valueOf(sw.getStatus()));
				ctxMap.put(sw.getSwtName()+"_"+String.valueOf(sw.getStatus()),sw.getNeeded());
			}
		}

		if (CollectionUtils.isNotEmpty(WEBWEIHU_LIST)) {
			for (WebWeiHu wh : WEBWEIHU_LIST) {
				ctxMap.put(wh.getWeihuName(), String.valueOf(wh.getStatus()));
				ctxMap.put(wh.getWeihuName()+"_"+String.valueOf(wh.getStatus()), String.valueOf(wh.getWeihuContent()));
			}
		}

		if (CollectionUtils.isNotEmpty(WEBPANEL_LIST)) {
			for (WebPanel p : WEBPANEL_LIST) {
				ctxMap.put(p.getPanelSn(), p.getPanelContent());
			}
		}
		
		if (CollectionUtils.isNotEmpty(WEBAGENT_LIST)) {
			for (WebAgent a : WEBAGENT_LIST) {
				ctxMap.put(a.getAgentNo()+"_"+a.getStatus(), a.getUserName());
			}
		}
		
		if(WEBLINECK_INFO!=null){//线路信息
			ctxMap.put("lckLogoPic", WEBLINECK_INFO.getLckLogoPic());
			ctxMap.put("lckLogoWidth", WEBLINECK_INFO.getLckLogoWidth()+"");
			ctxMap.put("lckLogo_height", WEBLINECK_INFO.getLckLogoHeight()+"");
			ctxMap.put("lckDomain", WEBLINECK_INFO.getLckDomain());
			ctxMap.put("lckMainContent", WEBLINECK_INFO.getLckMainContent());
			ctxMap.put("lckFootContent", WEBLINECK_INFO.getLckFootContent());
			ctxMap.put("lckOtherContent", WEBLINECK_INFO.getLckOtherContent());
			ctxMap.put("lckMainDomain", WEBLINECK_INFO.getLckMainDomain());
		}
	}

}
