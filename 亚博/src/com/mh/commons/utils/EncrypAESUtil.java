/**   
* 文件名称: EncrypAESUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-6-4 下午2:24:13<br/>
*/  
package com.mh.commons.utils;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-6-4 下午2:24:13<br/>
 */
 
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.Security;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.KeyGenerator;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.SecretKey;
@SuppressWarnings("all")
public class EncrypAESUtil {
	
	//KeyGenerator 提供对称密钥生成器的功能，支持各种算法
	private KeyGenerator keygen;
	//SecretKey 负责保存对称密钥
	private SecretKey deskey;
	//Cipher负责完成加密或解密工作
	private Cipher c;
	//该字节数组负责保存加密的结果
	private byte[] cipherByte;
	
	public EncrypAESUtil() throws NoSuchAlgorithmException, NoSuchPaddingException{
		Security.addProvider(new com.sun.crypto.provider.SunJCE());
		//实例化支持DES算法的密钥生成器(算法名称命名需按规定，否则抛出异常)
		keygen = KeyGenerator.getInstance("AES");
		//生成密钥
		deskey = keygen.generateKey();
		//生成Cipher对象,指定其支持的DES算法
		c = Cipher.getInstance("AES");
	}
	
	/**
	 * 对字符串加密
	 * 
	 * @param str
	 * @return
	 * @throws InvalidKeyException
	 * @throws IllegalBlockSizeException
	 * @throws BadPaddingException
	 */
	public byte[] Encrytor(String str) throws InvalidKeyException,
			IllegalBlockSizeException, BadPaddingException {
		// 根据密钥，对Cipher对象进行初始化，ENCRYPT_MODE表示加密模式
		c.init(Cipher.ENCRYPT_MODE, deskey);
		byte[] src = str.getBytes();
		// 加密，结果保存进cipherByte
		cipherByte = c.doFinal(src);
		return cipherByte;
	}

	/**
	 * 对字符串解密
	 * 
	 * @param buff
	 * @return
	 * @throws InvalidKeyException
	 * @throws IllegalBlockSizeException
	 * @throws BadPaddingException
	 */
	public byte[] Decryptor(byte[] buff) throws InvalidKeyException,
			IllegalBlockSizeException, BadPaddingException {
		// 根据密钥，对Cipher对象进行初始化，DECRYPT_MODE表示加密模式
		c.init(Cipher.DECRYPT_MODE, deskey);
		cipherByte = c.doFinal(buff);
		return cipherByte;
	}

	/**
	 * @param args
	 * @throws NoSuchPaddingException 
	 * @throws NoSuchAlgorithmException 
	 * @throws BadPaddingException 
	 * @throws IllegalBlockSizeException 
	 * @throws InvalidKeyException 
	 */
	public static void main(String[] args) throws Exception {
		EncrypAESUtil de1 = new EncrypAESUtil();
		String msg ="YNGBOU_A1HELLO12|oirv9p|gtsro3d";
		byte[] encontent = de1.Encrytor(msg);
		byte[] decontent = de1.Decryptor(encontent);
		
		String decStr = new String(encontent);
		decStr = DesUtil.encrypt(decStr, "1234555444");
		
		System.out.println("明文是:" + msg);
		System.out.println("加密后:" + decStr);
		
		String add = DesUtil.decrypt(decStr, "1234555444");
		
		
		System.out.println("解密后:" + new String(decontent));
	}

}

