$(document).ready(function(){
    $("body").addClass("event event-count");
    tabList($("#fixedTable"));
    streak($('[role="streak"]'));
    showDiolog($("#pathNav"));
    hideDiolog();
    $(window).scroll(function(){
        tabFixed($("#fixedTable"),480);
    });
})
