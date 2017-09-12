/**   
* 文件名称: LotUtil.java<br/>
* 版本号: V1.0<br/>   
* 创建人: alex<br/>  
* 创建时间 : 2015-5-27 下午6:54:27<br/>
*/  
package com.mh.commons.utils;

/** 
 * 类描述: TODO<br/>
 * 创建人: TODO alex<br/>
 * 创建时间: 2015-5-27 下午6:54:27<br/>
 */
public class LotUtil {

	/**
	 * 福彩3D排列3总和大小
	 * 方法描述: TODO</br>
	 * 创建人: zoro<br/> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getFC3DPL3HeDx(int num){
		if(num>=15){
			return "大";
		}else{
			return "小";
		}
	}

	/**
	 * 判断单双
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	//1、3、5、7、9时为“单”，若为0、2、4、6、8时为“双”
	public static String getDs(int num){
		if(num%2==0){
			return "双";
		}else{
			return "单";
		}
	}
	//5、6、7、8、9时为“大”，若为0、1、2、3、4时为“小”
	public static String getDx(int num){
		if(num>=5){
			return "大";
		}else{
			return "小";
		}
	}
	
	//1、2、3、5、7时为“质数”，若为0、4、6、8、9时为“合数
	public static String getZh(int num){
		if(num==1 || num==2||num==3||num==5||num==7){
			return "质";
		}else{
			return "合";
		}
	}
	
	/**
	 * 判断百拾个
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getFC3DBsgDx(int num){
		//百大小 	开奖结果佰位、拾位或个位数字为5、6、7、8、9时为“大”，若为0、1、2、3、4时为“小”，当投注位数大小与开奖结果的位数大小相符时，即为中奖。
		if(num>4){
			return "大";
		}else{
			return "小";
		}
	}
	
	
	public static String getFC3DBsgZh(int num){
		//百大小 	开奖结果佰位、拾位或个位数字为5、6、7、8、9时为“大”，若为0、1、2、3、4时为“小”，当投注位数大小与开奖结果的位数大小相符时，即为中奖。
		//开奖结果佰位、拾位或个位数字为1、2、3、5、7时为“质数”，若为0、4、6、8、9时为“合数”，当投注位数质合与开奖结果的位数质合相符时，即为中奖。
		//※举例：投注者购买个位质，当期开奖结果如为957（7为质），则视为中奖。
		//百质合
		if(num==1 || num==2||num==3||num==5||num==7){
			return "质";
		}else{
			return "合";
		}
	}
	
	
	public static String getHK6TmDx(String tm){
		int num = Integer.valueOf(tm);
		//特码 大 小：开出之特码大于或等于25为特码大， 小于或等于24为特码小，开出49为和。
		if(num<49){
			if(num>=25){
				return "大";
			}else{
				return "小";
			}
		}else{
			return "和";
		}
	}
	
	public static String getHK6TmDs(String tm){
		int num = Integer.valueOf(tm);
		if(num<49){
			if(num%2==0){
				return "双";
			}else{
				return "单";
			}
		}else{
			return "和";
		}
	}
	
	public static String getHK6ZfDx(int num){
		//总和大小 ： 所有七个开奖号码的分数总和大于或等于175为总分大；分数总和小于或等于174为总分小。 如开奖号码为02、08、17、28、39、46、25，分数总和是165，则总分小。
		if(num>=175){
			return "大";
		}else{
			return "小";
		}
	}
	
	//总和单双 ： 所有七个开奖号码的分数总和是单数叫(总分单)，如分数总和是115、183；分数总和是双数叫(总 分双)，如分数总和是108、162。假如投注组合符合中奖结果，视为中奖，其馀情形视为不中奖 。
	public static String getHK6ZfDs(int num){
		if(num%2==0){
			return "双";
		}else{
			return "单";
		}
	}
	
	//特码和数大小：以特码个位和十位数字之和来判断胜负，和数大于或等于7为大，小于或等于6为小，开出49号为和。
	public static String getHK6HsDx(String tm){
		int num = Integer.valueOf(tm);
		if(num<49){
			int hstotal = 0;
			char[] chArr = tm.toCharArray();
			for(char ch:chArr){
				hstotal += Integer.valueOf(ch+"").intValue();
			}
			if(hstotal>=7){
				return "大";
			}else{
				return "小";
			}
		}else{
			return "和";
		}
	}
	
	//特码和数单双：以特码个位和十位数字之和来判断单双，如01，12，32为和单，02，11，33为和双，开出49号为和。
	public static String getHK6HsDs(String tm){
		int num = Integer.valueOf(tm);
		if(num<49){
			int hstotal = 0;
			char[] chArr = tm.toCharArray();
			for(char ch:chArr){
				hstotal += Integer.valueOf(ch+"").intValue();
			}
			if(hstotal%2==0){
				return "双";
			}else{
				return "单";
			}
		}else{
			return "和";
		}
		
	}
	
	
	public static String getSSCDx(int num){
		//大小：根据相应单项投注的第一球 ~ 第五球开出的球号数字总和值大于或等于 23 为总和大，小于或等于 22 为总和小。
		 
		if(num>=23){
			return "大";
		}else{
			return "小";
		}
		 
	}
	
	public static String getSSCWsDs(int num){
		//开奖结果万位、仟位、佰位、拾位或个位数字为1、3、5、7、9时为“单”，若为0、2、4、6、8时为“双”，当投注位数单双与开奖结果的位数单双相符时，即为中奖
		 
		if(num>=23){
			return "大";
		}else{
			return "小";
		}
		 
	}
	
	//快乐十分
	//龙：第一球中奖号码大于第八球的中奖号码。如第一球开出14第八球开出09。虎：第一球中奖号码小于第八球的中奖号码。如第一球开出09第八球开出14。
	public static String getKLSFLh(int num1,int num2){
		if(num1>num2){
			return "龙";
		}else if(num1<num2){
			return "虎";
		}
		return ""; 
	}
	
	/**
	 * 快乐十分单码大小 开出的号码大于或等于11为大，小于或等于10为小 。
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getKLSFDmDx(int num){
		if(num>=11){
			return "大";
		}else{
			return "小";
		}
		 
	}
	
	/**
	 * 东南西北 
	 * 东：开出之号码为01、05、09、13、17
	 * 南：开出之号码为02、06、10、14、18
	 * 西：开出之号码为03、07、11、15、19
	 * 北：开出之号码为04、08、12、16、20
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getKLSFDxnb(int num){
		if(num==1|| num==5||num==9||num==13||num==17){
			return "东";
		}else if(num==2|| num==6||num==10||num==14||num==18){
			return "南";
		}else if(num==3|| num==7||num==11||num==15||num==19){
			return "西";
		}else if(num==4|| num==8||num==12||num==16||num==20){
			return "北";
		}
		return "";
		 
	}
	
	/**
	 * 中发白
	 * 中：开出之号码为01、02、03、04、05、06、07
	 * 发：开出之号码为08、09、10、11、12、13、14
	 * 白：开出之号码为15、16、17、18、19、20
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getKLSFZfb(int num){
		if(num>=1&&num<=7){
			return "中";
		}else if(num>=8&&num<=14){
			return "发";
		}else if(num>=15&&num<=20){
			return "白";
		}
		return "";
		 
	}
	
	/**冠亚军和大小
	 * 当开奖结果冠军号码与亚军号码的和值大于11为大，投注“和大”则视为中奖；小于11为小，投注“和小”则视为中奖；等于11视为和(不计算输赢)。
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getBJPK10GyjhDx(int num){
		if(num==11){
			return "和";
		}else {
			if(num>11){
				return "大";
			}else{
				return "小";
			} 
		}
		
	}
	/**
	 * 冠亚军和单双
	 * 当开奖结果冠军号码与亚军号码的和值为单数如9、13，投注“和单”则视为中奖；为双数如12、16，投注“和双”则视为中奖；若总和为11，则视为和(不计算输赢)。
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getBJPK10GyjhDs(int num){
		if(num==11){
			return "和";
		}else {
			if(num%2==0){
				return "双";
			}else{
				return "单";
			}
		}
	}
	
 /**
  * 指冠军、亚军、季军、第四、第五、第六、第七、第八、第九、第十名 开出的号码大于或等于6为大，小于或等于5为小 。
  * 方法描述: TODO</br> 
  * @param num
  * @return  
  * String
  */
	public static String getBJPK10ByDx(int num){
 
		if(num>=6){
			return "大";
		}else{
			return "小";
		} 
		 
		
	}
	
	/**
	 * 号码为双数叫双，如4、6；号码为单数叫单，如3、5。
	 * 方法描述: TODO</br> 
	 * @param num
	 * @return  
	 * String
	 */
	public static String getBJPK10ByDs(int num){
		 
		if(num%2==0){
			return "双";
		}else{
			return "单";
		} 
		 
		
	}
}
