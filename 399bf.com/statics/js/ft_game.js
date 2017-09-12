
$(document).ready(function(){
    streak($('[role="streak"]'));
    streak($('[role="streak_"]'),true);

    try{
        $(window).returnTop();
    }catch(err){

    }

});
