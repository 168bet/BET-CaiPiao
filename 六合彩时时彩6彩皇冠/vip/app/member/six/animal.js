function res()
{ myform.reset();
  document.all.check.value="";
  
}
function n2(num)
{
if(num==1)
{
b11.style.background=c;
b23.style.background=c;
b35.style.background=c;
b47.style.background=c;
}else
{
b11.style.background=b;
b23.style.background=b;
b35.style.background=b;
b47.style.background=b;	
}
}
function h3(num)
{
if(num==1)
{
b10.style.background=c;
b22.style.background=c;
b34.style.background=c;
b46.style.background=c;
}else
{
b10.style.background=b;
b22.style.background=b;
b34.style.background=b;
b46.style.background=b;
}
}
function t4(num)
{
if(num==1)
{
b09.style.background=c;
b21.style.background=c;
b33.style.background=c;
b45.style.background=c;
}else
{
b09.style.background=b;
b21.style.background=b;
b33.style.background=b;
b45.style.background=b;
}
}
function l5(num)
{
if(num==1)
{
b08.style.background=c;
b20.style.background=c;
b32.style.background=c;
b44.style.background=c;
}else
{
b08.style.background=b;
b20.style.background=b;
b32.style.background=b;
b44.style.background=b;
}
}
function c6(num)
{
if(num==1)
{
b07.style.background=c;
b19.style.background=c;
b31.style.background=c;
b43.style.background=c;
}else
{
b07.style.background=b;
b19.style.background=b;
b31.style.background=b;
b43.style.background=b;
}
}
function m7(num)
{
if(num==1)
{
b06.style.background=c;
b18.style.background=c;
b30.style.background=c;
b42.style.background=c;
}else
{
b06.style.background=b;
b18.style.background=b;
b30.style.background=b;
b42.style.background=b;
}
}
function y8(num)
{
if(num==1)
{
b05.style.background=c;
b17.style.background=c;
b29.style.background=c;
b41.style.background=c;
}else
{
b05.style.background=b;
b17.style.background=b;
b29.style.background=b;
b41.style.background=b;}
}
function h9(num)
{
if(num==1)
{
 b04.style.background=c;
b16.style.background=c;
b28.style.background=c;
b40.style.background=c;
}else
{
b04.style.background=b;
b16.style.background=b;
b28.style.background=b;
b40.style.background=b;
}
}
function j10(num)
{
if(num==1)
{
 b03.style.background=c;
b15.style.background=c;
b27.style.background=c;
b39.style.background=c;
}else
{
 b03.style.background=b;
b15.style.background=b;
b27.style.background=b;
b39.style.background=b;
}
}
function g11(num)
{
if(num==1)
{
 b02.style.background=c;
b14.style.background=c;
b26.style.background=c;
b38.style.background=c;
}else
{
b02.style.background=b;
b14.style.background=b;
b26.style.background=b;
b38.style.background=b;
}
}
function z12(num)
{
if(num==1)
{
b01.style.background=c;
b13.style.background=c;
b25.style.background=c;
b37.style.background=c;
b49.style.background=c;
}else
{
b01.style.background=b;
b13.style.background=b;
b25.style.background=b;
b37.style.background=b;
b49.style.background=b;
}
}
function s1(num)
{
if(num==1)
{
b12.style.background=c;
b24.style.background=c;
b36.style.background=c;
b48.style.background=c;
}else
{
b12.style.background=b;
b24.style.background=b;
b36.style.background=b;
b48.style.background=b;
}
}
function suma()
{ 
  
nums=myform.s1.value+myform.n2.value+myform.h3.value+myform.t4.value+myform.l5.value+myform.c6.value+myform.m7.value+myform.y8.value+myform.h9.value+myform.j10.value+myform.g11.value+myform.z12.value;
myform.check.value=nums;
}
function sanimal(arr,menu,num)
{
 if(arr==c)
 {
 menu.style.background=b;
 if(num==1)
 { 
  myform.s1.value="";
  s1(2);
  suma();
 }
 if(num==2)
 {
  myform.n2.value="";
  n2(2);
  suma();
 }
 if(num==3)
 { 
  h3(2);
  myform.h3.value="";
  suma();
 }
 if(num==4)
 { 
  t4(2);
  myform.t4.value="";
  suma();
 }
  if(num==5)
 { 
  l5(2);
  myform.l5.value="";
  suma();
 }
  if(num==6)
 { 
  c6(2);
  myform.c6.value="";
  suma();
 }
  if(num==7)
 { 
  m7(2);
  myform.m7.value="";
  suma();
 }
  if(num==8)
 { 
  y8(2);
  myform.y8.value="";
  suma();
 }
  if(num==9)
 { 
  h9(2);
  myform.h9.value="";
  suma();
 }
  if(num==10)
 { 
  j10(2);
  myform.j10.value="";
  suma();
 }
  if(num==11)
 { 
  g11(2);
  myform.g11.value="";
  suma();
 }
  if(num==12)
 { 
  z12(2);
  myform.z12.value="";
  suma();
 }
}else
 {
   menu.style.background=c;
   if(num==1)
   { 
    myform.s1.value="12,24,36,48,";
    s1(1);
	suma();
   }
   if(num==2)
   {
	myform.n2.value="11,23,35,47,";
	n2(1);
	suma();
   }
   if(num==3)
   {
	myform.h3.value="10,22,34,46,";
	h3(1);
	suma();
   }
   if(num==4)
   {
	myform.t4.value="09,21,33,45,";
	t4(1);
	suma();
   }
   if(num==5)
   {
	myform.l5.value="08,20,32,44,";
	l5(1);
	suma();
   }
   if(num==6)
   {
	myform.c6.value="07,19,31,43,";
	c6(1);
	suma();
   }
   if(num==7)
   {
	myform.m7.value="06,18,30,42,";
	m7(1);
	suma();
   }
   if(num==8)
   {
	myform.y8.value="05,17,29,41,";
	y8(1);
	suma();
   }
    if(num==9)
   {
	myform.h9.value="04,16,28,40,";
	h9(1);
	suma();
   }
    if(num==10)
   {
	myform.j10.value="03,15,27,39,";
	j10(1);
	suma();
   }
    if(num==11)
   {
	myform.g11.value="02,14,26,38,";
	g11(1);
	suma();
   }
    if(num==12)
   {
	myform.z12.value="01,13,25,37,49,";
	z12(1);
	suma();
   }
 }
}

function leftre()
{
 var arr="yes,"+this.myform.check.value;
 var rmb=document.myform.txtrmb.value;
 if(rmb<1)
 {  alert('金额传送最低为1 ');
 }else
 { 
for(var i=1;i<=49;i++){
	if (i<10){var ssr="t0"+i;}else{var ssr="t"+i;}
	document.all[ssr].value="";	
	}


 
 
 if(arr.indexOf("01",0)>0)
   { 
     var ads=document.myform.t01.value;
	 if(ads=="") ads=0;
     document.myform.t01.value=parseFloat(rmb);
    }
      if(arr.indexOf("02",0)>0)
   { 
     var ads=document.myform.t02.value;
	 if(ads=="") ads=0;
     document.myform.t02.value=parseFloat(rmb);
    }
      if(arr.indexOf("03",0)>0)
   { 
     var ads=document.myform.t03.value;
	 if(ads=="") ads=0;
     document.myform.t03.value=parseFloat(rmb);
    }
      if(arr.indexOf("04",0)>0)
   { 
     var ads=document.myform.t04.value;
	 if(ads=="") ads=0;
     document.myform.t04.value=parseFloat(rmb);
    }
      if(arr.indexOf("05",0)>0)
   { 
     var ads=document.myform.t05.value;
	 if(ads=="") ads=0;
     document.myform.t05.value=parseFloat(rmb);
    }
      if(arr.indexOf("06",0)>0)
   { 
     var ads=document.myform.t06.value;
	 if(ads=="") ads=0;
     document.myform.t06.value=parseFloat(rmb);
    }
      if(arr.indexOf("07",0)>0)
   { 
     var ads=document.myform.t07.value;
	 if(ads=="") ads=0;
     document.myform.t07.value=parseFloat(rmb);
    }
      if(arr.indexOf("08",0)>0)
   { 
     var ads=document.myform.t08.value;
	 if(ads=="") ads=0;
     document.myform.t08.value=parseFloat(rmb);
    }
      if(arr.indexOf("09",0)>0)
   { 
     var ads=document.myform.t09.value;
	 if(ads=="") ads=0;
     document.myform.t09.value=parseFloat(rmb);
    }
      if(arr.indexOf("10",0)>0)
   { 
     var ads=document.myform.t10.value;
	 if(ads=="") ads=0;
     document.myform.t10.value=parseFloat(rmb);
    }
      if(arr.indexOf("11",0)>0)
   { 
     var ads=document.myform.t11.value;
	 if(ads=="") ads=0;
     document.myform.t11.value=parseFloat(rmb);
    }
      if(arr.indexOf("12",0)>0)
   { 
     var ads=document.myform.t12.value;
	 if(ads=="") ads=0;
     document.myform.t12.value=parseFloat(rmb);
    }
      if(arr.indexOf("13",0)>0)
   { 
     var ads=document.myform.t13.value;
	 if(ads=="") ads=0;
     document.myform.t13.value=parseFloat(rmb);
    }
      if(arr.indexOf("14",0)>0)
   { 
     var ads=document.myform.t14.value;
	 if(ads=="") ads=0;
     document.myform.t14.value=parseFloat(rmb);
    }
      if(arr.indexOf("15",0)>0)
   { 
     var ads=document.myform.t15.value;
	 if(ads=="") ads=0;
     document.myform.t15.value=parseFloat(rmb);
    }
      if(arr.indexOf("16",0)>0)
   { 
     var ads=document.myform.t16.value;
	 if(ads=="") ads=0;
     document.myform.t16.value=parseFloat(rmb);
    }
      if(arr.indexOf("17",0)>0)
   { 
     var ads=document.myform.t17.value;
	 if(ads=="") ads=0;
     document.myform.t17.value=parseFloat(rmb);
    }
      if(arr.indexOf("18",0)>0)
   { 
     var ads=document.myform.t18.value;
	 if(ads=="") ads=0;
     document.myform.t18.value=parseFloat(rmb);
    }
      if(arr.indexOf("19",0)>0)
   { 
     var ads=document.myform.t19.value;
	 if(ads=="") ads=0;
     document.myform.t19.value=parseFloat(rmb);
    }
      if(arr.indexOf("20",0)>0)
   { 
     var ads=document.myform.t20.value;
	 if(ads=="") ads=0;
     document.myform.t20.value=parseFloat(rmb);
    }
      if(arr.indexOf("21",0)>0)
   { 
     var ads=document.myform.t21.value;
	 if(ads=="") ads=0;
     document.myform.t21.value=parseFloat(rmb);
    }
      if(arr.indexOf("22",0)>0)
   { 
     var ads=document.myform.t22.value;
	 if(ads=="") ads=0;
     document.myform.t22.value=parseFloat(rmb);
    }
      if(arr.indexOf("23",0)>0)
   { 
     var ads=document.myform.t23.value;
	 if(ads=="") ads=0;
     document.myform.t23.value=parseFloat(rmb);
    }
      if(arr.indexOf("24",0)>0)
   { 
     var ads=document.myform.t24.value;
	 if(ads=="") ads=0;
     document.myform.t24.value=parseFloat(rmb);
    }
      if(arr.indexOf("25",0)>0)
   { 
     var ads=document.myform.t25.value;
	 if(ads=="") ads=0;
     document.myform.t25.value=parseFloat(rmb);
    }
      if(arr.indexOf("26",0)>0)
   { 
     var ads=document.myform.t26.value;
	 if(ads=="") ads=0;
     document.myform.t26.value=parseFloat(rmb);
    }
      if(arr.indexOf("27",0)>0)
   { 
     var ads=document.myform.t27.value;
	 if(ads=="") ads=0;
     document.myform.t27.value=parseFloat(rmb);
    }
      if(arr.indexOf("28",0)>0)
   { 
     var ads=document.myform.t28.value;
	 if(ads=="") ads=0;
     document.myform.t28.value=parseFloat(rmb);
    }
      if(arr.indexOf("29",0)>0)
   { 
     var ads=document.myform.t29.value;
	 if(ads=="") ads=0;
     document.myform.t29.value=parseFloat(rmb);
    }
      if(arr.indexOf("30",0)>0)
   { 
     var ads=document.myform.t30.value;
	 if(ads=="") ads=0;
     document.myform.t30.value=parseFloat(rmb);
    }
      if(arr.indexOf("31",0)>0)
   { 
     var ads=document.myform.t31.value;
	 if(ads=="") ads=0;
     document.myform.t31.value=parseFloat(rmb);
    }
      if(arr.indexOf("32",0)>0)
   { 
     var ads=document.myform.t32.value;
	 if(ads=="") ads=0;
     document.myform.t32.value=parseFloat(rmb);
    }
      if(arr.indexOf("33",0)>0)
   { 
     var ads=document.myform.t33.value;
	 if(ads=="") ads=0;
     document.myform.t33.value=parseFloat(rmb);
    }
      if(arr.indexOf("34",0)>0)
   { 
     var ads=document.myform.t34.value;
	 if(ads=="") ads=0;
     document.myform.t34.value=parseFloat(rmb);
    }
      if(arr.indexOf("35",0)>0)
   { 
     var ads=document.myform.t35.value;
	 if(ads=="") ads=0;
     document.myform.t35.value=parseFloat(rmb);
    }
      if(arr.indexOf("36",0)>0)
   { 
     var ads=document.myform.t36.value;
	 if(ads=="") ads=0;
     document.myform.t36.value=parseFloat(rmb);
    }
      if(arr.indexOf("37",0)>0)
   { 
     var ads=document.myform.t37.value;
	 if(ads=="") ads=0;
     document.myform.t37.value=parseFloat(rmb);
    }
      if(arr.indexOf("38",0)>0)
   { 
     var ads=document.myform.t38.value;
	 if(ads=="") ads=0;
     document.myform.t38.value=parseFloat(rmb);
    }
      if(arr.indexOf("39",0)>0)
   { 
     var ads=document.myform.t39.value;
	 if(ads=="") ads=0;
     document.myform.t39.value=parseFloat(rmb);
    }
      if(arr.indexOf("40",0)>0)
   { 
     var ads=document.myform.t40.value;
	 if(ads=="") ads=0;
     document.myform.t40.value=parseFloat(rmb);
    }
      if(arr.indexOf("41",0)>0)
   { 
     var ads=document.myform.t41.value;
	 if(ads=="") ads=0;
     document.myform.t41.value=parseFloat(rmb);
    }
      if(arr.indexOf("42",0)>0)
   { 
     var ads=document.myform.t42.value;
	 if(ads=="") ads=0;
     document.myform.t42.value=parseFloat(rmb);
    }
      if(arr.indexOf("43",0)>0)
   { 
     var ads=document.myform.t43.value;
	 if(ads=="") ads=0;
     document.myform.t43.value=parseFloat(rmb);
    }
      if(arr.indexOf("44",0)>0)
   { 
     var ads=document.myform.t44.value;
	 if(ads=="") ads=0;
     document.myform.t44.value=parseFloat(rmb);
    }
      if(arr.indexOf("45",0)>0)
   { 
     var ads=document.myform.t45.value;
	 if(ads=="") ads=0;
     document.myform.t45.value=parseFloat(rmb);
    }
      if(arr.indexOf("46",0)>0)
   { 
     var ads=document.myform.t46.value;
	 if(ads=="") ads=0;
     document.myform.t46.value=parseFloat(rmb);
    }
      if(arr.indexOf("47",0)>0)
   { 
     var ads=document.myform.t47.value;
	 if(ads=="") ads=0;
     document.myform.t47.value=parseFloat(rmb);
    }
      if(arr.indexOf("48",0)>0)
   { 
     var ads=document.myform.t48.value;
	 if(ads=="") ads=0;
     document.myform.t48.value=parseFloat(rmb);
    }
      if(arr.indexOf("49",0)>0)
   { 
     var ads=document.myform.t49.value;
	 if(ads=="") ads=0;
     document.myform.t49.value=parseFloat(rmb);
    }
    }
	if(this.myform.check.value!="")
	{
	 myform.submit();
	}else alert('请选择要下注的号码!');
}
function allps()
{
var ss=b;
b01.style.background=ss;
b02.style.background=ss;
b03.style.background=ss;
b04.style.background=ss;
b05.style.background=ss;
b06.style.background=ss;
b07.style.background=ss;
b08.style.background=ss;
b09.style.background=ss;
b10.style.background=ss;
b11.style.background=ss;
b12.style.background=ss;
b13.style.background=ss;
b14.style.background=ss;
b15.style.background=ss;
b16.style.background=ss;
b17.style.background=ss;
b18.style.background=ss;
b19.style.background=ss;
b20.style.background=ss;
b21.style.background=ss;
b22.style.background=ss;
b23.style.background=ss;
b24.style.background=ss;
b25.style.background=ss;
b26.style.background=ss;
b27.style.background=ss;
b28.style.background=ss;
b29.style.background=ss;
b30.style.background=ss;
b31.style.background=ss;
b32.style.background=ss;
b33.style.background=ss;
b34.style.background=ss;
b35.style.background=ss;
b36.style.background=ss;
b37.style.background=ss;
b38.style.background=ss;
b39.style.background=ss;
b40.style.background=ss;
b41.style.background=ss;
b42.style.background=ss;
b43.style.background=ss;
b44.style.background=ss;
b45.style.background=ss;
b46.style.background=ss;
b47.style.background=ss;
b48.style.background=ss;
b49.style.background=ss;
}