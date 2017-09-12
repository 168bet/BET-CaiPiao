package com.mh.web.login;

import javax.imageio.ImageIO;
import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.IOException;
import java.io.OutputStream;
import java.util.Random;

/**
 * 验证码产生器
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-24 下午7:51:19<br/>
 */
public class VerifiedCodeGenerator
{
    /**
     * 图片宽度
     */
    private int imgWidth = 200;
    
    /**
     * 图片高度
     */
    private int imgHeight = 20;
 
    
    public VerifiedCodeGenerator(){
        
    }
    
    
    /**
     * 
     * @param imgHeight
     */
    public void setImgHeight(int imgHeight) {
        this.imgHeight = imgHeight;
    }

    /**
     * 
     * @return
     */
    public int getImgWidth() {
        return imgWidth;
    }

    /**
     * 
     * @param imgWidth
     */
    public void setImgWidth(int imgWidth) {
        this.imgWidth = imgWidth;
    }

    /**
     * 
     * @param str
     * @return
     */
    public BufferedImage createImage(String str){
        
        BufferedImage image = 
            new BufferedImage(imgWidth, imgHeight, BufferedImage.TYPE_INT_RGB);
        
        Graphics g = image.getGraphics();
        
        g.setColor(new Color(225, 225, 225));     
        g.fillRect(0, 0, imgWidth, imgHeight);
        
        g.setColor(new Color(183, 183, 183));
        Random rand = new Random();
        float factor = 0.4f;
        for(int i=0; i<3; i++){
            int startX = (int)Math.floor(rand.nextInt(Integer.MAX_VALUE)%(factor*imgWidth));
            int startY = (int)Math.floor(rand.nextInt(Integer.MAX_VALUE)%(factor*imgHeight));
            int endX = startX + (int)Math.floor(rand.nextInt(Integer.MAX_VALUE)%imgWidth);
            int endY = startY + (int)Math.floor(rand.nextInt(Integer.MAX_VALUE)%imgHeight);
            g.drawLine(startX, startY, endX, endY);
        }
        
        g.setColor(new Color(89, 0, 0));
        g.setFont(new Font("Copperplate Gothic Light", Font.BOLD, 20));
        g.drawString(str, 2, 20);
       
        return image;
    }
    
    /**
     * 输出图片
     *
     * @param out
     * @param formatName
     * @param img
     * @throws IOException
     */
    public void output(OutputStream out, String formatName, BufferedImage img) 
        throws IOException{
        
        ImageIO.write(img, formatName, out);
    }

    /**
     *
     * @return 
     */
    public int getImgHeight() {
        return imgHeight;
    }

}
