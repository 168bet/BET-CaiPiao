/**
 * Created by Administrator on 2016/10/31.
 */
$(function(){
    //实例化右侧悬浮条
    var sideBar = new SideBar_match();
    sideBar.titleItem = {
        'meet':'交往',
        'lishi':'历史',
        'jinqiu':'进球',
        'yiwangpanlu':'以往',
        'weilai':'未来',
        'zhenrong':'阵容',
        'panlu':'盘路',
        'jifen':'积分'
    };
    sideBar.init();
});