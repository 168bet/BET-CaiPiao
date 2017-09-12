$(function () {
    var abs=$('.article-subhead'),
        absH=abs.height()+22;/**  borderT+borderB+padding=22**/
    if(!!absH){

        if(parseInt(absH)>43){

            abs.css({
                textAlign:"left"
            })
        }
    }

});