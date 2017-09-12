package com.mh.commons.constants;

import java.util.HashMap;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;

public class AgConstants {
	private static Map<String, String> gameType;// 游戏类型
	private static Map<String, String> flagType;// 结算类型
	private static Map<String, String> platformType;//平台类型

	public static String gameFlag(String flag) {
		return flagType.get(flag);
	}

	public static String playType(String type) {
		// return playType.get(type);
		return"";
	}
	
	public static String platformType(String type) {
		String game = platformType.get(type);
		if (StringUtils.isBlank(game)) {
			game ="其他";
		}
		return game;
	}

	public static String gameType(String type) {
		String game = gameType.get(type);
		if (StringUtils.isBlank(game)) {
			game ="其他";
		}
		return game;
	}

	static {
		gameType = new HashMap<String, String>();
		gameType.put("BAC", "百家乐");
		gameType.put("CBAC", "包桌百家乐");
		gameType.put("LINK", "连环百家乐");
		gameType.put("DT", "龙虎");
		gameType.put("SHB", "骰宝");
		gameType.put("ROU", "轮盘");
		gameType.put("FT", "番摊");
		gameType.put("LBAC", "竞咪百家乐");
		gameType.put("ULPK", "终极德州扑克");
		gameType.put("SBAC", "保險百家樂");
		gameType.put("SL1", "巴西世界杯(Slot小游戏)");
		gameType.put("SL2", "疯狂水果店(Slot小游戏)");
		gameType.put("SL3", "3D 水族馆(Slot小游戏)");
		gameType.put("PK_J", "视频扑克-杰克高手(Slot小游戏)");
		gameType.put("SL4", "极速赛车(Slot小游戏)");
		gameType.put("PKBJ", "新视频扑克-杰克高手");
		gameType.put("FRU", "水果拉霸(H5)");
		gameType.put("HUNTER", "捕鱼王");
		gameType.put("SLM1", "美女沙排(沙滩排球)");
		gameType.put("SLM2", "运财羊(新年运财羊)");
		gameType.put("SLM3", "武圣传");
		gameType.put("SC01", "幸运老虎机");
		gameType.put("TGLW", "极速幸运轮");
		gameType.put("SLM4", "武则天");
		gameType.put("TGCW", "赌场战争");
		gameType.put("SB01", "太空漫游");
		gameType.put("SB02", "复古花园");
		gameType.put("SB03", "关东煮");
		gameType.put("SB04", "牧场咖啡");
		gameType.put("SB05", "甜一甜屋");
		gameType.put("SB06", "日本武士");
		gameType.put("SB07", "象棋老虎机");
		gameType.put("SB08", "麻将老虎机");
		gameType.put("SB09", "西洋棋老虎机");
		gameType.put("SB10", "开心农场");
		gameType.put("SB11", "夏日营地");
		gameType.put("SB12", "海底漫游");
		gameType.put("SB13", "鬼马小丑");
		gameType.put("SB14", "机动乐园");
		gameType.put("SB15", "惊吓鬼屋");
		gameType.put("SB16", "疯狂马戏团");
		gameType.put("SB17", "海洋剧场");
		gameType.put("SB18", "水上乐园");
		gameType.put("SB25", "土地神");
		gameType.put("SB26", "布袋和尚");
		gameType.put("SB27", "正财神");
		gameType.put("SB28", "武财神");
		gameType.put("SB29", "偏财神");
		gameType.put("SB19", "空中战争");
		gameType.put("SB20", "摇滚狂迷");
		gameType.put("SB21", "越野机车");
		gameType.put("SB22", "埃及奥秘");
		gameType.put("SB23", "欢乐时光");
		gameType.put("SB24", "侏罗纪");
		gameType.put("AV01", "性感女仆(H5)");
		gameType.put("XG01", "龙珠(H5)");
		gameType.put("XG02", "幸运 8(H5)");
		gameType.put("XG03", "闪亮女郎(H5)");
		gameType.put("XG04", "金鱼(H5)");
		gameType.put("XG05", "中国新年(H5)");
		gameType.put("XG06", "海盗王(H5)");
		gameType.put("XG07", "鲜果狂热(H5)");
		gameType.put("XG08", "小熊猫(H5)");
		gameType.put("XG09", "大豪客(H5)");
		gameType.put("SB30", "灵猴献瑞");
		gameType.put("SB31", "天空守护者");
		gameType.put("XG10", "龙舟竞渡(H5)");
		gameType.put("PKBD", "百搭二王");
		gameType.put("PKBB", "红利百搭");
		gameType.put("SB32", "齐天大圣");
		gameType.put("SB33", "糖果碰碰乐");
		gameType.put("SB34", "冰河世界");
		gameType.put("FRU2", "水果拉霸 2");
		gameType.put("TG01", "21 点 (电子游戏)(H5)");
		gameType.put("TG02", "百家乐 (电子游戏)(H5)");
		gameType.put("TG03", "轮盘 (电子游戏)(H5)");
		gameType.put("SB35", "欧洲列强争霸");
		gameType.put("SB36", "捕鱼王者");
		gameType.put("SB37", "上海百乐门");
		gameType.put("SB38", "竞技狂热");
		gameType.put("SB39", "太空水果");
		gameType.put("SB40", "秦始皇");
		gameType.put("TA01", "多手二十一点 0,5-5");
		gameType.put("TA02", "多手二十一点 1-40");
		gameType.put("TA03", "多手二十一点 5-500");
		gameType.put("TA04", "1 手二十一点 0,5-5");
		gameType.put("TA05", "1 手二十一点 1-40");
		gameType.put("TA06", "1 手二十一点 5-500");
		gameType.put("TA07", "Hi-Lo 0,1-1");
		gameType.put("TA08", "Hi-Lo 1-10");
		gameType.put("TA09", "Hi-Lo 10-100");
		gameType.put("TA0A", "5 手 Hi-Lo 0,1-10");
		gameType.put("TA0B", "5 手 Hi-Lo 1-100");
		gameType.put("TA0C", "3 手 Hi-Lo 1-500");
		gameType.put("TA0F", "轮盘 1-500");
		gameType.put("TA0G", "轮盘 0,1-50");
		gameType.put("TA0Z", "5 手杰克高手");
		gameType.put("TA10", "5 手百搭小丑");
		gameType.put("TA11", "5 手百搭二王");
		gameType.put("TA12", "1 手杰克高手");
		gameType.put("TA13", "10 手杰克高手");
		gameType.put("TA14", "25 手杰克高手");
		gameType.put("TA15", "50 手杰克高手");
		gameType.put("TA17", "1 手百搭小丑");
		gameType.put("TA18", "10 手百搭小丑");
		gameType.put("TA19", "25 手百搭小丑");
		gameType.put("TA1A", "50 手百搭小丑");
		gameType.put("TA1C", "1 手百搭二王");
		gameType.put("TA1D", "10 手百搭二王");
		gameType.put("TA1E", "25 手百搭二王");
		gameType.put("TA1F", "50 手百搭二王");
		gameType.put("27", "江苏快三");
		gameType.put("24", "重庆时时彩");
		gameType.put("13", "中国福彩 3D");
		gameType.put("25", "北京快乐 8");
		gameType.put("26", "湖南快乐十分");
		gameType.put("29", "十一运夺金");
		gameType.put("23", "江西时时彩");
		gameType.put("DZPK", "德州撲克");
		gameType.put("GDMJ", "廣東麻將");
		gameType.put("FIFA", "体育");
		
		

		flagType = new HashMap<String, String>();
		flagType.put("1","已结算");
		flagType.put("0","未结算");
		flagType.put("-1","重置试玩额度");
		flagType.put("-2","注单被篡改");
		flagType.put("-8","取消指定局注单");
		flagType.put("-9","取消注单");

		
		platformType = new HashMap<String, String>();
		platformType.put("AGIN", "AG国际厅");
		platformType.put("AG", "AG旗舰厅极速版");
		platformType.put("DSP", "AG实地厅");
		platformType.put("IPM", "IPM");
		platformType.put("BBIN", "BBIN宝盈集团");
		platformType.put("MG", "MG");
		platformType.put("SABAH", "沙巴体育");
		platformType.put("HG", "HG");
		platformType.put("PT", "PY");
		platformType.put("OG", "东方游戏");
		platformType.put("UGS", "UGS");
		platformType.put("HUNTER", "捕鱼王");
		platformType.put("AGTEX", "棋牌大厅");
		platformType.put("HB", "HB");
		platformType.put("XTD", "XTD新天地");
		platformType.put("PNG", "PNG");
		platformType.put("NYX", "NYX");
		platformType.put("ENDO", "ENDO");
		platformType.put("BG", "BG");
		platformType.put("XIN", "XIN");
		platformType.put("YOPLAY", "YoPlay");
		platformType.put("TTG", "TTG");
	}
}
