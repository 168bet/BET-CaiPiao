/**
 * Created by Administrator on 2016/9/9.
 */
$(function(){
    laydate({
        elem: '#date',
        //min: laydate.now(), //-1代表昨天，-2代表前天，以此类推
        max: laydate.now(-1) //+1代表明天，+2代表后天，以此类推
    });
});