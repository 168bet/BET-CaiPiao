var null_col='';   //表示为原来的背景色(颜色不变)
var over_col='#cccccc';
var click_col='#aadddd';

//颜色处理函数
function light_bar(st,act){
  switch(act){
   case 'ovr':
     if( st.style.backgroundColor==null_col )  st.style.backgroundColor=over_col;
     break;
   
   case 'out':
     if( st.style.backgroundColor==over_col )  st.style.backgroundColor=null_col;
     break;
    
   case 'clk':
     if( st.style.backgroundColor!=click_col ) st.style.backgroundColor=click_col;
     else st.style.backgroundColor=over_col;
     break;
  }
}