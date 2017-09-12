function doAjaxSave(url,data){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url:url,
        type:'post',
        dataType:'json',
        data:data,
        success:function(data){
            $("#btn-enter").removeAttr('disabled');
            if(data.status==1){
                alert('提交成功');
                window.location.reload(true);
                if(data.urlRedirect){
                    window.location.href=data.urlRedirect;
                }
            }else if(data.status==0){
                if(data.msg){
                    alert(data.msg);
                }else{
                    alert('提交失败');
                }
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $("#btn-enter").removeAttr('disabled');
            alert('提交失败,失败原因：'+errorThrown);
        }
    })
}
