var null_col='';
var over_col='#cccccc';
var click_col='#aadddd';
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