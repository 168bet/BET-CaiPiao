package com.mh.commons.utils;

import java.awt.Color;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.image.BufferedImage;
import java.io.IOException;
import java.io.OutputStream;
import java.util.Random;

import javax.imageio.ImageIO;
import javax.servlet.http.HttpServletResponse;



/**
 * 文件名称：RandImgCreater.java 描 述：验证码图片
 */
public class RandImgCreater {
	private static final String CODE_LIST = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789";
	private HttpServletResponse response = null;
	private static final int HEIGHT = 20;
	private static final int FONT_NUM = 7;
	private int width = 0;
	private int iNum = 0;
	private String codeList = "";
	private boolean drawBgFlag = false;

	private int rBg = 0;
	private int gBg = 0;
	private int bBg = 0;

	/**
	 * 构造函数
	 * 
	 * @param response
	 */
	public RandImgCreater(HttpServletResponse response) {
		this.response = response;
		this.width = 13 * FONT_NUM + 12;
		this.iNum = FONT_NUM;
		this.codeList = CODE_LIST;
	}

	/**
	 * 构造函数
	 * 
	 * @param response
	 * @param iNum
	 * @param codeList
	 */
	public RandImgCreater(HttpServletResponse response, int iNum,
			String codeList) {
		this.response = response;
		this.width = 13 * iNum + 12;
		this.iNum = iNum;
		this.codeList = codeList;
	}

	/**
	 * 创建图片
	 * 
	 * @return String
	 */
	public String createRandImage() {
		BufferedImage image = new BufferedImage(width, HEIGHT,
				BufferedImage.TYPE_INT_RGB);

		Graphics g = image.getGraphics();

		Random random = new Random();

		if (drawBgFlag) {
			g.setColor(new Color(rBg, gBg, bBg));
			g.fillRect(0, 0, width, HEIGHT);
		} else {
			g.setColor(getRandColor(200, 250));
			g.fillRect(0, 0, width, HEIGHT);

			for (int i = 0; i < 155; i++) {
				g.setColor(getRandColor(140, 200));
				int x = random.nextInt(width);
				int y = random.nextInt(HEIGHT);
				int xl = random.nextInt(12);
				int yl = random.nextInt(12);
				g.drawLine(x, y, x + xl, y + yl);
			}
		}

		g.setFont(new Font("Times New Roman", Font.PLAIN, 18));

		String sRand = "";
		for (int i = 0; i < iNum; i++) {
			int rand = random.nextInt(codeList.length());
			String strRand = codeList.substring(rand, rand + 1);
			sRand += strRand;
			g.setColor(new Color(20 + random.nextInt(110), 20 + random
					.nextInt(110), 20 + random.nextInt(110)));
			g.drawString(strRand, 13 * i + 6, 16);
		}
		OutputStream os = null;
		try {
			os = response.getOutputStream();
			ImageIO.write(image, "JPEG", os);
			
			os.flush();
			os.close();
			os=null;
		} catch (IOException e) {

		}finally{
			if(os !=null){
				try {
					os.close();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
		g.dispose();
		return sRand;
	}

	/**
	 * 创建图片
	 */
	public String createRandOperImage() {
		BufferedImage image = new BufferedImage(width, HEIGHT, BufferedImage.TYPE_INT_RGB);
		Graphics g = image.getGraphics();
		Random random = new Random();

		if (drawBgFlag) {
			g.setColor(new Color(rBg, gBg, bBg));
			g.fillRect(0, 0, width, HEIGHT);
		} else {
			g.setColor(getRandColor(200, 250));
			g.fillRect(0, 0, width, HEIGHT);
			// 随机产生155条干扰线，使图象中的认证码不易被其它程序探测到
			for (int i = 0; i < 1; i++) {
				g.setColor(getRandColor(140, 200));
				int x = random.nextInt(width);
				int y = random.nextInt(HEIGHT);
				int xl = random.nextInt(12);
				int yl = random.nextInt(12);
				g.drawLine(x, y, x + xl, y + yl);
			}
		}

		// 备选字体
		String[] fontTypes = { "宋体", "新宋体", "黑体", "楷体", "隶书" };
		int fontTypesLength = fontTypes.length;

		// 取随机产生的认证码
		String[] ys = new String[] {"0", "1", "2", "3", "4", "5", "6", "7","8", "9", "10"};
		// 保存生成的字符串
		String sRand = "";
		int tempys = 0;
		int ys1 = random.nextInt(10);
		int ys2 = random.nextInt(10);
		if (ys1 < ys2) {
			tempys = ys1;
			ys1 = ys2;
			ys2 = tempys;
		}
		String[] ysfs = new String[] {"+", "-"};
		String[] ysfs2 = new String[] {"+", "-"};
		int ysfIndex = random.nextInt(ysfs.length);
		int index = random.nextInt(4);
		int ysindex = random.nextInt(2);
		String ysf = "";
		String ys1s = String.valueOf(ys1);
		String ys2s = String.valueOf(ys2);

		// 随机运算数
		switch (index) {
		case 0:
			ys1s = ys[ys1];
			break;
		case 1:
			ys2s = ys[ys2];
			break;
		case 3:
			ys1s = String.valueOf(ys1);
			break;
		case 4:
			ys2s = String.valueOf(ys2);
			break;
		}

		// 随机运算符
		switch (ysindex) {
		case 0:
			ysf = ysfs[ysfIndex];
			break;
		case 1:
			ysf = ysfs2[ysfIndex];
			break;
		}

		// 进行运算
		int val = 0;
		switch (ysfIndex) {
		case 0:
			val = ys1 + ys2;
			break;
		case 1:
			val = ys1 - ys2;
			break;
		case 2:
			val = ys1 * ys2;
			break;
		default:
			break;
		}

		if (ysfIndex == 2) {
			if(val==0 && ys1==0){
				return createRandOperImage();
			}
			if(val==0 && ys2==0){
				return createRandOperImage();
			}
		}
		
		// 等于多少?
		String[] ysfsRe = new String[] { "?", "?" };
		String result = "";
		int ysresult = random.nextInt(2);
		// 随机等于
		switch (ysresult) {
		case 0:
			result = ysfsRe[0];
			break;
		case 1:
			result = ysfsRe[1];
			break;
		}

		String resultRand = "";
		// 算法位置最终返回
		int yspositon = random.nextInt(3);
		// 随机等于
		switch (yspositon) {
		case 0:
			sRand = result + ysf + ys2s + "=" + val;
			resultRand = String.valueOf(ys1);
			break;
		case 1:
			sRand = ys1s + ysf + result + "=" + val;
			resultRand = String.valueOf(ys2);
			break;
		case 2:
			sRand = ys1s + ysf + ys2s + "=" + result;
			resultRand = String.valueOf(val);
			break;
		}

		g.setFont(new Font(fontTypes[random.nextInt(fontTypesLength)],Font.BOLD, 18));
		g.setColor(new Color(20 + random.nextInt(110), 20 + random.nextInt(110), 20 + random.nextInt(110)));
		
		// 将字符画到图片上
		g.drawString(sRand, 6, 16);
		OutputStream  os = null;
		try {
			os = response.getOutputStream();
			ImageIO.write(image, "JPEG", os);
			os.flush();
			os.close();
			os=null;
		} catch (IOException e) {

		}finally{
			if(os !=null){
				try {
					os.close();
				} catch (IOException e) {}
			}
		}
		g.dispose();
		return resultRand;
	}

	/**
	 * 设置背景颜色
	 * 
	 * @param r
	 * @param g
	 * @param b
	 */
	public void setBgColor(int r, int g, int b) {
		drawBgFlag = true;
		this.rBg = r;
		this.gBg = g;
		this.bBg = b;
	}

	/**
	 * 设置随机颜色
	 * 
	 * @param fc
	 * @param bc
	 * @return
	 */
	private Color getRandColor(int fc, int bc) {
		Random random = new Random();
		if (fc > 255)
			fc = 255;
		if (bc > 255)
			bc = 255;
		int r = fc + random.nextInt(bc - fc);
		int g = fc + random.nextInt(bc - fc);
		int b = fc + random.nextInt(bc - fc);
		return new Color(r, g, b);
	}
}