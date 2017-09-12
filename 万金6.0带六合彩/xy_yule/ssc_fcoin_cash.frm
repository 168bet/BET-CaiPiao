TYPE=VIEW
query=select `r`.`id` AS `rid`,`l`.`uid` AS `uid`,`r`.`actionTime` AS `actionTime`,`l`.`info` AS `info`,`l`.`liqType` AS `liqType`,`l`.`fcoin` AS `fcoin` from `xy_yule`.`xy_member_cash` `r` join `xy_yule`.`xy_coin_log` `l` where ((`l`.`extfield0` = `r`.`id`) and (`r`.`state` = 1) and (`r`.`isDelete` = 0) and (`l`.`liqType` = 106))
md5=1e643a2bb783c50064e1ae2327ce94e4
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=2015-02-12 05:51:22
create-version=1
source=select r.id rid, l.uid, r.actionTime, l.info, l.liqType, l.fcoin from xy_member_cash r, xy_coin_log l where l.extfield0=r.id and r.state=1 and isDelete=0 and l.liqType=106
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `r`.`id` AS `rid`,`l`.`uid` AS `uid`,`r`.`actionTime` AS `actionTime`,`l`.`info` AS `info`,`l`.`liqType` AS `liqType`,`l`.`fcoin` AS `fcoin` from `xy_yule`.`xy_member_cash` `r` join `xy_yule`.`xy_coin_log` `l` where ((`l`.`extfield0` = `r`.`id`) and (`r`.`state` = 1) and (`r`.`isDelete` = 0) and (`l`.`liqType` = 106))
