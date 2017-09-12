$(function(){
    streak($('[role="streak"]'));
    showDiolog($("#pathNav"));
    hideDiolog();
    $(window).scroll(function(){
        tabFixed($("#fixedTable"),413);
    });
});