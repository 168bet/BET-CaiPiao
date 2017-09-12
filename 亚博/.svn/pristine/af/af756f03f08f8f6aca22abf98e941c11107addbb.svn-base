package com.mh.commons.utils;

import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.util.Enumeration;
import java.util.zip.ZipEntry;
import java.util.zip.ZipFile;

/**
 * ZIP工具类
 * @author Victor.Chen
 *
 */
public class ZipUtils {
	
	//解压文件   
	//filepath :要解压的zip文件路径   
	//解压文件后存放的路径   
	public static void unzip(String filepath, String outputfilepath)throws Exception {
		File srcfile = new File(filepath);
		
		if (!srcfile.getName().endsWith(".zip")) {
			throw new Exception(String.format("%s不是zip文件", filepath));
		}
		
		try {
			ZipFile zipFile = new ZipFile(filepath);//加载zip文件      
			System.out.println(zipFile.getName() + "共有文件数" + zipFile.size());//打印zip文件包含的文件数  文件夹也包括在内   
			
			ZipEntry zipentry = null;//声明一个zip文件包含文件单一的实体对象   
			Enumeration<?> e = zipFile.entries();//返回 ZIP文件条目的枚举。   
			while (e.hasMoreElements()) {//测试此枚举是否包含更多的元素。   
				zipentry = (ZipEntry) e.nextElement();
				if (zipentry.isDirectory()) {//是否为文件夹而非文件   

					File file = new File(outputfilepath + zipentry.getName());
					file.mkdir();//创建文件夹                   
				} else {
					InputStream input = zipFile.getInputStream(zipentry);//得到当前文件的文件流   
					File f = new File(outputfilepath + zipentry.getName());//创建当前文件   
					FileOutputStream fout = new FileOutputStream(f);//声明一个输出流   
					byte[] bytes = new byte[1024];//每次读1kb   
					while (input.read(bytes) != -1) {
						fout.write(bytes);//将读到的流输出生成一个新的文件   
					}
					input.close();
					fout.close();
					System.err.println(zipentry.getName() + "解压成功...");
				}

			}
			zipFile.close();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	    public static void main(String[] args) {

		try {
			ZipUtils.unzip("C:\\123\\EOMS2TSCircuitService.zip", "e:\\4324\\");
		} catch (Exception e) {
			// TODO Auto-generated catch block   
			e.printStackTrace();
		}
	} 
}