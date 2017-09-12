/*--------------------------------------------------------------*/
/* 	JavaScript Global Checker v1.1								*/
/*--------------------------------------------------------------*/
/*	First Created	: Eugene KH Lau 14/Jan/2003 		
	Last Modified	: 26/Feb/2003
						o Added CheckThis2 for checker trigger
	Limitation		: Form has to be named as myForm
	Comment			: Oi! Don't copy my source leh!! :P 		*/
/*--------------------------------------------------------------*/

/*-----------------------------------------------------------------*/
/* checkThis(string)
	o Check all boxes with name indexOf(string) */
/*-----------------------------------------------------------------*/
function checkThis(fieldName){
	var len = document.myForm.elements.length;
	var checker = 'default';
	for (var i=0; i<len; i++){
	     var e = document.myForm.elements[i];
             if (e.type == 'checkbox' && e.name.indexOf(fieldName) != -1){
			 	if(checker=='default'){
				 	if(e.checked==true){
						checker = false;
					}else{
						checker = true;
					}
				}
				e.checked = checker;
             }
	}
}

/*-----------------------------------------------------------------*/
/* checkThis2(string, object)
	o For checker trigger where child will follow master's setting */
/*-----------------------------------------------------------------*/
function checkThis2(fieldName,masterCheckbox){
	var len = document.myForm.elements.length;
	for (var i=0; i<len; i++){
	     var e = document.myForm.elements[i];
             if (e.type == 'checkbox' && e.name.indexOf(fieldName) != -1){
             //if(e.type == 'checkbox' && e.name == fieldName)
			 	e.checked = masterCheckbox.checked;
             }
	}
}
/*-----------------------------------------------------------------*/

