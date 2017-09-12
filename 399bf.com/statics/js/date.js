/**
 * Created by Administrator on 2016/9/20.
 */
$(function(){
    if (odds_status == 3) {
        //历史日期
        laydate({
            elem: '#history',
            //min: laydate.now(-1), //-1代表昨天，-2代表前天，以此类推
            max: laydate.now(-1) //+1代表明天，+2代表后天，以此类推
        });
    } else if (odds_status == 4) {
        //早盘日期
        laydate({
            elem: '#tomorrow',
            min: laydate.now(1)//-1代表昨天，-2代表前天，以此类推
            //max: laydate.now() //+1代表明天，+2代表后天，以此类推
        });
    }
});