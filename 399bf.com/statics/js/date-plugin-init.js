(function(){
    $('#date-plugn').datePlugn({
        limit: 1,
        callback: function (data)
        {
            window.location.href = url + 'date=' + data;
        }
    });

    $('#calenBtn').click(function(){
        $('#date-plugn').toggle();
    });
})();