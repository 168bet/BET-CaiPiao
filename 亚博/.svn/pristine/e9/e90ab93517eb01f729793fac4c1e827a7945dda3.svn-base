/**   
 * 文件名称: ExcelDataUtils.java<br/>
 * 版本号: V1.0<br/>   
 * 创建人: zoro<br/>  
 * 创建时间 : 2015-9-26 上午3:22:57<br/>
 */
package com.mh.commons.utils;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import org.apache.poi.hssf.usermodel.HSSFSheet;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Row;

/**
 * 类描述: TODO<br/>
 * 创建人: TODO zoro<br/>
 * 创建时间: 2015-9-26 上午3:22:57<br/>
 */
public class ExcelDataUtils {

	public static List<Object[]> readExcel(String excelFile) {
		FileInputStream in = null;
		HSSFWorkbook book = null;
		List<Object[]> list = new ArrayList<Object[]>();
		try {
			in = new FileInputStream(excelFile);
			book = new HSSFWorkbook(in);

			HSSFSheet sheet = book.getSheetAt(0);

			// 解析内容行
			int index = 1;
			for (int i = 2; i <= sheet.getLastRowNum(); i++) {
				Row rown = sheet.getRow(i);
				Iterator<Cell> cellbody = rown.cellIterator();// 行的所有列
				// 遍历一行的列
				List<Object> colList = new ArrayList<Object>();
				System.out.println("============第" + i);
				for (int j = 0; j < 6; j++) {
					Cell cell = cellbody.next();
					String value = cell.getStringCellValue();

					if (j == 5) {
						if ("NO".equals(value)) {
							colList.add(0);
						} else {
							colList.add(1);
						}
					} else {
						colList.add(value);
					}

					System.out.println("" + value);
				}
				colList.add(1);
				colList.add(index);
				colList.add("");

				list.add(colList.toArray());
				index++;
			}

		} catch (FileNotFoundException e) {
			e.printStackTrace();

		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		return list;
	}

	public static void main(String[] args) {
		// String filePath = "E:\\33.xls";
		// List<Object[]> list = readExcel(filePath);
		// for(int i=0;i<list.size();i++){
		// Object[] objArr = list.get(i);
		// StringBuffer buff = new StringBuffer("");
		// for(int j=0;j<objArr.length;j++){
		// if(j>0){
		// buff.append("-----");
		// }
		// buff.append(objArr[j].toString());
		// }
		// System.out.println(buff.toString());
		// }

		String filePath = "D:\\workspace\\yabo1\\WebContent\\commons\\web\\ybb\\common\\images\\pt";
		File root = new File(filePath);
		File[] files = root.listFiles();
		for(File file:files){ 
			System.out.println(file.getName());
		}
	}

}
