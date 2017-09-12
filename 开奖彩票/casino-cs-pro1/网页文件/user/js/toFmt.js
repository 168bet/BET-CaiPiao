// JS Object: ToFmt 
// Author: David Mosley, E-mail: David.Mosley@fundp.ac.be or davmos@fcmail.com
// August 1998.
// Contains a limited set of formatting routines for
// use in JavaScript scripts.
// Feel free to use this code in your scripts. I would be grateful if you
// could keep this header intact. 
// Please let me know if you find the code useful.
// Please report any bugs you find or improvements you make to the script. 
// The code has been tested, but no guarantee can be made of it functioning
// correctly. Use is entirely at your own risk.
// 
// Summary of methods
// fmt00(): Tags leading zero onto numbers 0 - 9.
// Particularly useful for displaying results from Date methods.
//
// fmtF(w,d): formats in a style similar to Fortran's Fw.d, where w is the
// width of the field and d is the number of figures after the decimal
// point. 
// The result is aligned to the right of the field.  The default
// padding character is a space " ". This can be modified using the 
// setSpacer(string) method of ToFmt. 
// If the result will not fit in the field , the field will be returned
// containing w asterisks.
//
// fmtE(w,d): formats in a style similar to Fortran's Ew.d, where w is the
// width of the field and d is the number of figures after the decimal
// point. 
// The result is aligned to the right of the field.  The default
// padding character is a space " ". This can be modified using the 
// setSpacer(string) method of ToFmt. 
// If the result will not fit in the field , the field will be returned
// containing w asterisks.
//
// fmtI(w): formats in a style similar to Fortran's Iw, where w is the
// width of the field.
// Floating point values are truncated (rounded down) for integer
// representation.
// The result is aligned to the right of the field.  The default
// padding character is a space " ". This can be modified using the 
// setSpacer(string) method of ToFmt. 
// If the result will not fit in the field , the field will be returned
// containing w asterisks.

function ToFmt(x){
 this.x=x;
 this.fmt00 = fmt00;
 this.fmtF = fmtF;
 this.fmtE=fmtE;
 this.fmtI=fmtI;
 this.spacer=" ";
 this.setSpacer=setSpacer;
}

function fmt00(){
 // fmt00: Tags leading zero onto numbers 0 - 9.
 // Particularly useful for displaying results from Date methods.
 //
 if (parseInt(this.x) < 0) var neg = true;
 if (Math.abs(parseInt(this.x)) < 10){
  this.x = "0"+ Math.abs(this.x);
 }
 if (neg) this.x = "-"+this.x;
 return this.x;
}

function fmtF(w,d){

 // fmtF: formats in a style similar to Fortran's Fw.d, where w is the
 // width of the field and d is the number of figures after the decimal
 // point. 
 // The result is aligned to the right of the field.  The default
 // padding character is a space " ". This can be modified using the 
 // setSpacer(string) method of ToFmt. 
 // If the result will not fit in the field , the field will be returned
 // containing w asterisks.
 var width=w;
 var dpls=d;
 var lt1=false;
 var len=this.x.toString().length;
 var junk;
 var res="";
// First check for valid format request
 if ( width < (dpls+2)){
  window.alert("Illegal format specified : w = " + d +
               " w = " + d +
                "\nUsage: [ToFmt].fmtF(w,d)" +
                "\nWidth (w) of field must be greater or equal to the number " +
                "\nof digits to the right of the decimal point (d) + 2");
  junk = filljunk(width);
  return junk;
 }
// Work with absolute value
 var absx=Math.abs(this.x);
// Nasty fix to deal with numbers < 1 and problems with leading zeros!
 if ((absx < 1) && (absx > 0)){
  lt1 = true;
  absx+=10;
 }
// Get postion of decimal point
 var pt_pos = absx.toString().indexOf(".");
 if ( pt_pos == -1){
  res+= absx;
  res+= ".";
  for (var i = 0; i < dpls; i++){
   res += 0;
  }  
 }
 else{
  res = Math.round(absx * Math.pow(10,dpls));
  res=res.toString();
  if (res.length == 
      Math.round(Math.floor(absx * Math.pow(10,dpls))).toString().length){ 
   res = res.substring(0,pt_pos) + "." + 
         res.substring(pt_pos,res.length);
  }
  else{
   pt_pos++;
   res = res.substring(0,pt_pos) + "." + 
          res.substring(pt_pos,res.length);
  } 
// Remove leading 1 from  numbers < 1 (Nasty fix!)
  if (lt1) {
   res=res.substring(1,res.length);
  }
 }
 // Final formatting statements
 // Reinsert - sign for negative numbers
 if (this.x < 0)res = "-"+res;
 // Check whether the result fits in the width of the field specified
 if (res.length > width){
  res=filljunk(width);
 }
 // If necessary, pad from the left with the spacer string
 else if (res.length < width){
  var res_bl="";
  for (var i = 0; i < (width - res.length); i++){
   res_bl += this.spacer ;
  } 
  res = res_bl + res;
 }
 return res;
}

function fmtE(w,d){

 // fmtE: formats in a style similar to Fortran's Ew.d, where w is the
 // width of the field and d is the number of figures after the decimal
 // point. 
 // The result is aligned to the right of the field.  The default
 // padding character is a space " ". This can be modified using the 
 // setSpacer(string) method of ToFmt. 
 // If the result will not fit in the field , the field will be returned
 // containing w asterisks.
 //
 var width=w;
 var dpls=d;
 var e="E+";
 var len=this.x.toString().length;
 var pow10;
 var xp10;
 var junk;
 var res="";
// First check for valid format request
 if ( width < (dpls+5)){
  window.alert("Illegal format specified : w = " + d +
               " w = " + d +
                "\nUsage: [ToFmt].fmtE(w,d)" +
                "\nWidth (w) of field must be greater or equal to the number " +
                "\nof digits to the right of the decimal point (d) + 6");
  junk = filljunk(w);
  return junk;
 }
// Work with absolute value
 var absx=Math.abs(this.x);
// Get postion of decimal point
 var pt_pos = absx.toString().indexOf(".");
// For x=0
 if (absx == 0){
  res +="0.";
  for (var i=0; i< dpls; i++){
   res += "0";
  }
  res  += "E+00";
 }
// For abs(x) >= 1 
 else if (absx >= 1.0){
  pow10=1;
  xp10 = absx;
  while (xp10 >= 1.){
   pow10++;
   xp10 /= 10;
  }
  res = Math.round(xp10 * Math.pow(10,dpls));
  res=res.toString();
  if (res.length == 
      Math.round(Math.floor(xp10 * Math.pow(10,dpls))).toString().length){ 
    pow10--;
  }
  res = "0." + res.substring(0,dpls) + e + (new ToFmt(pow10)).fmt00();
 }
// For abs(x) < 1
 else if (absx < 1.0){
  pow10=1;
  xp10 = absx;
  while (xp10 < 1.){
   pow10--;
   xp10 *= 10;
  }
  res = Math.round(xp10/10 * Math.pow(10,dpls));
  res=res.toString();
  if (res.length != 
      Math.round(Math.floor(xp10/10 * Math.pow(10,dpls))).toString().length){ 
    pow10++;
  }
  if (pow10 < 0) e = "E-";
  res = "0." + res.substring(0,dpls) + e + (new ToFmt(Math.abs(pow10))).fmt00();
 }
 
 if (this.x < 0)res = "-"+res;
 if (res.length > width){
  res=filljunk(width);
 }
 else if (res.length < width){
  var res_bl="";
  for (var i = 0; i < (width - res.length); i++){
   res_bl += this.spacer ;
  } 
  res = res_bl + res;
 }
 return res;
 
}

function fmtI(w){

 // fmtI: formats in a style similar to Fortran's Iw, where w is the
 // width of the field.
 // Floating point values are truncated (rounded down) for integer
 // representation.
 // The result is aligned to the right of the field.  The default
 // padding character is a space " ". This can be modified using the 
 // setSpacer(string) method of ToFmt. 
 // If the result will not fit in the field , the field will be returned
 // containing w asterisks.
 var width=w;
 var lt0=false;
 var len=this.x.toString().length;
 var junk;
 var res="";
// Work with absolute value
 var absx = Math.abs(this.x);

// Test for < 0
 if (parseInt(this.x) < 0){
  lt0 = true;
 }
 res = Math.round(Math.floor((absx))).toString();
 if (lt0){
  res = "-"+res;
 }
 if (res.length > width){
  res=filljunk(width);
 }
 else if (res.length < width){
  var res_bl="";
  for (var i = 0; i < (width - res.length); i++){
   res_bl += this.spacer ;
  } 
  res = res_bl + res;
 }
 return res;
}

function filljunk(lenf){
 // Fills field of length lenf with asterisks
 var str="";
 for (var i=0; i < lenf; i++){
  str +="*";
 }
 return str;
}

function setSpacer(spc){
 var spc;
 this.spacer=spc;
 return this.spacer;
}
