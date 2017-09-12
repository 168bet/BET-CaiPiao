package com.mh.commons.utils;

import java.awt.Graphics;
import java.awt.Image;
import java.awt.Toolkit;
import java.awt.image.BufferedImage;
import java.awt.image.CropImageFilter;
import java.awt.image.FilteredImageSource;
import java.awt.image.ImageFilter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;

import javax.imageio.ImageIO;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.sun.image.codec.jpeg.JPEGCodec;
import com.sun.image.codec.jpeg.JPEGImageEncoder;

@SuppressWarnings("all")
public class ImageUtil {
	
	private static final Logger logger = LoggerFactory.getLogger(ImageUtil.class);

	public static boolean abscut(String fromPath, String toPath, int x, int y, int destWidth, int destHeight) {
        try {
            BufferedImage bi = ImageIO.read(new File(fromPath));
            int srcWidth = bi.getWidth(); // 源图宽度
            int srcHeight = bi.getHeight(); // 源图高度
           
            System.out.println("srcWidth= " + srcWidth + "\tsrcHeight= "+ srcHeight);
            
            if (srcWidth >= destWidth && srcHeight >= destHeight) {
                //Image image = bi.getScaledInstance(finalWidth, finalHeight,Image.SCALE_DEFAULT);//获取缩放后的图片大小
            	ImageFilter cropFilter = new CropImageFilter(x, y, destWidth, destHeight);
                Image img = Toolkit.getDefaultToolkit().createImage(
                        new FilteredImageSource(bi.getSource(), cropFilter));
                BufferedImage tag = new BufferedImage(destWidth, destHeight,
                        BufferedImage.TYPE_INT_RGB);
                Graphics g = tag.getGraphics();
                g.drawImage(img, 0, 0, null); // 绘制截取后的图
                g.dispose();
                // 输出为文件
                ImageIO.write(tag, "jpg", new File(toPath));
            }
        } catch (Exception e) {
        	logger.error("切割图片出错", e);
            return false;
        }
        return true;
    }
    
 
    
    
	// 图片处理
	public static boolean compressPic(String fromPath, String toPath, double radioX, double radioY) {
		try {
			// 获得源文件
			File file = new File(fromPath);
			if (!file.exists()) {
				return false;
			}
			Image img = ImageIO.read(file);
			// 判断图片格式是否正确
			if (img.getWidth(null) == -1) {
				System.out.println(" can't read,retry!" + "<BR>");
				return false;
			} else {
				int newWidth;
				int newHeight;
				newWidth = (int) (((double) img.getWidth(null)) * radioX);
				newHeight = (int) (((double) img.getHeight(null)) * radioY);
				BufferedImage tag = new BufferedImage((int) newWidth,
						(int) newHeight, BufferedImage.TYPE_INT_RGB);

				/*
				 * Image.SCALE_SMOOTH 的缩略算法 生成缩略图片的平滑度的 . * 优先级比速度高 生成的图片质量比较好
				 * 但速度慢
				 */
				tag.getGraphics().drawImage(
						img.getScaledInstance(newWidth, newHeight,
								Image.SCALE_SMOOTH), 0, 0, null);
				FileOutputStream out = new FileOutputStream(toPath);
				// JPEGImageEncoder可适用于其他图片类型的转换
				JPEGImageEncoder encoder = JPEGCodec.createJPEGEncoder(out);
				encoder.encode(tag);
				out.close();
			}
		} catch (IOException e) {
			logger.error("压缩图片出错", e);
		}
		return true;
	}
 
	
}
