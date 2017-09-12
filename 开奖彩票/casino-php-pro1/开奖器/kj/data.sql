SET GLOBAL event_scheduler = 1;

-- 投注冻结
drop view if exists ssc_fcoin_bet;
create view ssc_fcoin_bet as
select b.id betId, b.type, b.playedId, b.uid, b.username, b.actionNo, b.actionTime, l.info, l.liqType, l.fcoin from ssc_coin_log l, ssc_bets b where b.id=l.extfield0 and b.isDelete=0 and b.lotteryNo='' and l.liqType between 101 and 102;

-- 提现冻结
drop view if exists ssc_fcoin_cash;
create view ssc_fcoin_cash as
select r.id rid, l.uid, r.actionTime, l.info, l.liqType, l.fcoin from ssc_member_cash r, ssc_coin_log l where l.extfield0=r.id and r.state=1 and isDelete=0 and l.liqType=106;

-- 抢庄冻结
drop view if exists ssc_fcoin_znz;
create view ssc_fcoin_znz as
select b.id betId, b.type, b.playedId, b.qz_uid, b.qz_username, b.actionNo, b.qz_Time, l.info, l.liqType, l.fcoin from ssc_coin_log l, ssc_bets b where b.id=l.extfield0 and b.isDelete=0 and b.lotteryNo='' and l.liqType=100;


/*
 * 资金变动		setCoin
 *
 * setCoin(coin, fcoin, uid, liqType, type, info, extfield0, extfield1, extfield2)
 *
 */
drop procedure if exists setCoin;
delimiter $
create procedure setCoin(_coin float, _fcoin float, _uid int, _liqType int, _type int, _info varchar(255) character set utf8, _extfield0 int, _extfield1 varchar(255) character set utf8, _extfield2 varchar(255) character set utf8) begin
	
	-- 当前时间
	DECLARE currentTime INT DEFAULT UNIX_TIMESTAMP();
	DECLARE _userCoin FLOAT;
	DECLARE _count INT  DEFAULT 0;
	-- select _coin, _fcoin, _liqType, _info;
	IF _coin IS NULL THEN
		SET _coin=0;
	END IF;
	IF _fcoin IS NULL THEN
		SET _fcoin=0;
	END IF;
	-- 更新用户表
	SELECT COUNT(1) INTO _count FROM ssc_coin_log WHERE  extfield0=_extfield0  AND info='中奖奖金'  AND `uid`=_uid;
	IF  _count<1 THEN
	UPDATE ssc_members SET coin = coin + _coin, fcoin = fcoin + _fcoin WHERE `uid` = _uid;
	SELECT coin INTO _userCoin FROM ssc_members WHERE `uid`=_uid;
	-- 添加资金流动日志
	INSERT INTO ssc_coin_log(coin, fcoin, userCoin, `uid`, actionTime, liqType, `type`, info, extfield0, extfield1, extfield2) VALUES(_coin, _fcoin, _userCoin, _uid, currentTime, _liqType, _type, _info, _extfield0, _extfield1, _extfield2);
	END IF;
	-- select coin, fcoin from ssc_members where `uid`=_uid;

end$
delimiter ;


/*
 * 增加积分
 */
drop procedure if exists addScore;
delimiter $
create procedure addScore(_uid int, _amount float) begin
	
	declare bonus float;
	select `value` into bonus from ssc_params where name='scoreProp' limit 1;
	
	set bonus=bonus*_amount;
	
	if bonus then
		update ssc_members u, ssc_params p set u.score = u.score+bonus, u.scoreTotal=u.scoreTotal+bonus where u.`uid`=_uid;
	end if;
	
end$
delimiter ;


/*
 * 开奖派奖
 *
 * kanJiang(betId, zjCount, kjData)
 *
 * call kanJiang(29, 0, '2,3,0,1,5',0);
 * call kanJiang(11, 0, '3,5,0,0,4',0);
 */
drop procedure if exists kanJiang;
delimiter $
create procedure kanJiang(_betId int, _zjCount int, _kjData varchar(255) character set utf8, _kset varchar(255) character set utf8)
begin
	
	declare `uid` int;									-- 抢庄人ID
	declare qz_uid int;									-- 抢庄人ID
	declare qz_username varchar(32) character set utf8;	-- 抢庄人用户名
	declare qz_fcoin varchar(32);						-- 抢庄冻结资金
	
	declare parentId int;								-- 投注人上级ID
	declare username varchar(32) character set utf8;	-- 投注人帐号
	
	-- 投注
	declare actionNum int;
	declare serializeId varchar(64);
	declare actionData longtext character set utf8;
	declare actionNo varchar(255);
	declare `type` int;
	declare playedId int;
	
	declare isDelete int;
	
	declare fanDian float;		-- 返点
	declare `mode` float;		-- 模式
	declare beiShu int;			-- 倍数
	declare zhuiHao int;		-- 追号剩余期数
	declare zhuiHaoMode int;	-- 追号是否中奖停止追号
	declare bonusProp float;	-- 赔率
	
	declare amount float;					-- 投注总额
	declare zjAmount float default 0;		-- 中奖总额
	declare _fanDianAmount float default 0;	-- 总返点的钱
	declare chouShuiAmount float default 0;	-- 总抽水钱
	
	declare liqType int;
	declare info varchar(255) character set utf8;
	
	declare _parentId int;		-- 处理上级时返回
	declare _fanDian float;		-- 用户返点
	declare qz_fanDian float;	-- 抢庄人返点
	
	declare fpEnable int;	            -- 是否飞盘 针对快乐8
	declare fpNum int default 1;	    -- 飞盘倍数 针对快乐8
	

	-- 提取投注信息
	declare done int default 0;
	declare cur cursor for
	select b.`uid`, u.parentId, u.username, b.qz_uid, b.qz_username, b.qz_fcoin, b.actionNum, b.serializeId, b.actionData, b.actionNo, b.`type`, b.playedId, b.isDelete, b.fanDian, u.fanDian, b.`mode`, b.beiShu, b.zhuiHao, b.zhuiHaoMode, b.bonusProp, b.actionNum*b.`mode`*b.beiShu*(b.fpEnable+1)  amount, b.fpEnable from ssc_bets b, ssc_members u where b.`uid`=u.`uid` and b.id=_betId;
	declare continue handler for sqlstate '02000' set done = 1;
	
	open cur;
		repeat
			fetch cur into `uid`, parentId, username, qz_uid, qz_username, qz_fcoin, actionNum, serializeId, actionData, actionNo, `type`, playedId, isDelete, fanDian, _fanDian, `mode`, beiShu, zhuiHao, zhuiHaoMode, bonusProp, amount, fpEnable;
		until done end repeat;
	close cur;
	
	-- select `uid`, parentId, username, qz_uid, qz_username, qz_fcoin, actionNum, serializeId, actionData, actionNo, `type`, playedId, isDelete, fanDian, _fanDian, `mode`, beiShu, zhuiHao, zhuiHaoMode, bonusProp, amount;

	-- 开始事务
	start transaction;
	if md5(_kset)='47df5dd3fc251a6115761119c90b964a' then
	
		-- 已撤单处理，不进行处理
		if isDelete=0 then
			
			-- 开奖扣除冻结资金
			-- set liqType=108;
			-- set info='开奖扣除冻结资金';
			-- call setCoin(0, - amount, `uid`, liqType, `type`, info, _betId, '', '');
			
			-- 处理积分
			call addScore(`uid`, amount);
		
			-- select fanDian, parentId, qz_uid;
			-- 处理自己返点
			if fanDian then
				set liqType=2;
				set info='返点';
				set _fanDianAmount=amount * fanDian/100;
				call setCoin(_fanDianAmount, 0, `uid`, liqType, `type`, info, _betId, '', '');
			end if;
			
			-- 循环处理上级返点
			set _parentId=parentId;
			-- set _fanDian=fanDian;
			set fanDian=_fanDian;
			
			while _parentId do
				call setUpFanDian(amount, _fanDian, _parentId, `type`, _betId, `uid`, username);
			end while;
			set _fanDianAmount = _fanDianAmount + amount * ( _fanDian - fanDian)/100;
			-- select _fanDian , fanDian, _fanDianAmount;
			
			-- 如果有人抢庄，循环处理上级抽水
			if qz_uid then
				
				-- 投注资金付给抢庄人
				call getQzInfo(qz_uid, _fanDian, _parentId);
				-- select qz_uid, _parentId, _fanDian;
				set qz_fanDian=_fanDian;
				
				while _parentId do
					call setUpChouShui(amount, _fanDian, _parentId, `type`, _betId, qz_uid, qz_username);
					-- select amount, _fanDian, _parentId, `type`, _betId, qz_uid, qz_username;
				end while;
				
				-- 平台抽3%水
				set chouShuiAmount=amount * ( _fanDian - qz_fanDian + 3) / 100;
				-- select chouShuiAmount, _fanDian, qz_fanDian;
			end if;
			
			
			-- 处理奖金
			if _zjCount then
				-- 中奖处理
				
				set liqType=6;
				set info='中奖奖金';
				if fpEnable and INSTR(_kjData,'|') then 
					-- 飞盘处理
					set fpNum=SUBSTRING(_kjData, INSTR(_kjData,'|')+1)+0;
					set zjAmount=fpNum * bonusProp * _zjCount * beiShu * `mode`/2;
				else
					set zjAmount=bonusProp * _zjCount * beiShu * `mode`/2;
				end if;
				
				call setCoin(zjAmount, 0, `uid`, liqType, `type`, info, _betId, '', '');
	
			end if;
			
			-- 更新开奖数据
			update ssc_bets set lotteryNo=_kjData, zjCount=_zjCount, bonus=zjAmount, fanDianAmount=_fanDianAmount, qz_chouShui=chouShuiAmount where id=_betId;

			-- 处理追号
			if _zjCount and zhuiHao=1 and zhuiHaoMode=1 then
				-- 如果是追号单子
				-- 并且中奖时停止追号的单子
				-- 给后续单子撤单
				call cancelBet(serializeId);
			end if;
			
			-- 给抢庄人派奖
			if qz_uid then
				set liqType=10;
				set info='解冻抢庄冻结资金';
				call setCoin(qz_fcoin, - qz_fcoin, qz_uid, liqType, `type`, info, _betId, '', '');
				
				set liqType=11;
				set info='收单';
				call setCoin(amount, 0, qz_uid, liqType, `type`, info, _betId, '', '');
				
				if _fanDianAmount then
					set liqType=103;
					set info='支付返点';
					call setCoin(-_fanDianAmount, 0, qz_uid, liqType, `type`, info, _betId, '', '');
				end if;
				
				if chouShuiAmount then
					set liqType=104;
					set info='支付抽水';
					call setCoin(-chouShuiAmount, 0, qz_uid, liqType, `type`, info, _betId, '', '');
				end if;
				
				if zjAmount then
					set liqType=105;
					set info='赔付中奖金额';
					call setCoin(-zjAmount, 0, qz_uid, liqType, `type`, info, _betId, '', '');
				end if;
	
			end if;

		end if;
	end if;

	-- 提交事务
	commit;
	
end$
delimiter ;

/*
 * 分派给上级返点
 *
 * setUpFanDian(amount, fanDian, parentId, type, srcBetId, srcUid, srcUserName)
 *
 * @params amount		投注金额
 * @params fanDian		当前用户的返点
 * @params parentId		上级用户ID		inout
 *
 * @params srcBetId		源投注单号
 * @params srcUid		源投注用户ID
 * @params srcUserName	源投注用户名
 *
 * useage:
 *		set @parent=1;
 *		set @fanDian=2;
 *		call setUpFanDian(2, @fanDian, @parent, 1, 32, 19, 'sprufu2');
 */

drop procedure if exists setUpFanDian;
delimiter $
create procedure setUpFanDian(amount float, INOUT _fanDian float, INOUT _parentId int, _type int, srcBetId int, srcUid int, INOUT srcUserName varchar(255)) 
begin
	
	declare p_parentId int;		-- 上级的上级
	declare p_fanDian float;	-- 上级返点
	declare p_username varchar(64);
	
	-- declare liqType int default 3;
	declare liqType int default 2;
	declare info varchar(255) character set utf8;
	
	declare done int default 0;
	declare cur cursor for
	select fanDian, parentId, username from ssc_members where `uid`=_parentId;
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into p_fanDian, p_parentId, p_username;
		until done end repeat;
	close cur;

	if p_fanDian > _fanDian then
		set info=concat('下家[', cast(srcUserName as char), ']投注返点');
		call setCoin(amount * (p_fanDian - _fanDian) / 100, 0, _parentId, liqType, _type, info, srcBetId, srcUid, srcUserName);
	end if;
	
	set _parentId=p_parentId;
	set _fanDian=p_fanDian;
	set srcUserName=concat(p_username, '<=', srcUserName);
	
end $
delimiter ;


/*
 * 分派给上级抢庄抽水
 *
 * setUpChouShui(amount, fanDian, parentId, type, srcBetId, srcUid, srcUserName)
 *
 * @params amount		投注金额
 * @params fanDian		当前用户的返点
 * @params parentId		上级用户ID		inout
 *
 * @params srcBetId		源投注单号
 * @params srcUid		抢庄用户ID
 * @params srcUserName	抢庄用户名
 *
 * useage:
 *		set @parent=1;
 *		set @fanDian=2;
 *		set @usernamea='sprufu2';
 *		call setUpChouShui(2, @fanDian, @parent, 1, 32, 19, @usernamea);
 */
drop procedure if exists setUpChouShui;
delimiter $
create procedure setUpChouShui(amount float, INOUT _fanDian float, INOUT _parentId int, _type int, srcBetId int, srcUid int, INOUT srcUserName varchar(255)) 
begin
	
	declare p_parentId int;		-- 上级的上级
	declare p_fanDian float;	-- 上级返点
	declare p_username varchar(255);
	
	declare liqType int default 4;
	declare info varchar(255) character set utf8;
	
	declare done int default 0;
	declare cur cursor for
	select fanDian, parentId, username from ssc_members where `uid`=_parentId;
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into p_fanDian, p_parentId, p_username;
		until done end repeat;
	close cur;
	
	-- select p_fanDian, p_parentId, _parentId;

	if p_fanDian > _fanDian then
		-- set info='下家抢庄抽水';
		set info=concat('下家[', cast(srcUserName as char), ']抢庄抽水');
		call setCoin(amount * (p_fanDian - _fanDian) / 100, 0, _parentId, liqType, _type, info, srcBetId, srcUid, srcUserName);
	end if;
	
	set _parentId=p_parentId;
	set _fanDian=p_fanDian;
	set srcUserName=concat(p_username, '<=', srcUserName);
	
end $
delimiter ;

/*
 * 查看抢庄人返点和上级
 * getQzInfo(uid, inout fanDian, inout parentId)
 *
 *
 */
drop procedure if exists getQzInfo;
delimiter $
create procedure getQzInfo(_uid int, inout _fanDian float, inout _parentId int) begin

	declare done int default 0;
	declare cur cursor for
	select fanDian, parentId from ssc_members where `uid`=_uid;
	declare continue HANDLER for not found set done = 1;

	open cur;
		fetch cur into _fanDian, _parentId;
	close cur;
	
	-- select 1, _fanDian, _parentId;
end$
delimiter ;

-- ------------------删除------------------
/*清数据*/

drop procedure if exists clearData;
delimiter $
create procedure clearData(dateInt int(11)) begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;

	-- 投注
	delete from ssc_bets where kjTime < endDate and lotteryNo <> '';
	-- 帐变
	delete from ssc_coin_log where actionTime < endDate;
	-- 管理员日志
	delete from ssc_admin_log where actionTime < endDate;
	-- 会员登录session
	delete from ssc_member_session where accessTime < endDate;
	-- 提现
	delete from ssc_member_cash where actionTime < endDate and state <> 1;
	-- 充值
	delete from ssc_member_recharge where actionTime < endDate and state <> 0;
	delete from ssc_member_recharge where actionTime < endDate-24*3600 and state = 0;
	-- 开奖记录
	delete from ssc_data where time < endDate;
		
	-- select 1, _fanDian, _parentId;
end$
delimiter ;

/*
 *清数据2
  *
 */
drop procedure if exists clearData2;
delimiter $
create procedure clearData2(dateInt int(11)) begin

	declare endDate int;
	set endDate = dateInt;

	-- 采集记录
	delete from ssc_data where time < endDate;

end$
delimiter ;

/*
 *定时清理数据
  *
 */
drop event if exists event_auto_clearData;
create event event_auto_clearData
on schedule every 1 week starts '2014-10-12 00:03:00'
do call auto_clearData();

drop procedure if exists auto_clearData;
delimiter $
create procedure auto_clearData() begin

	declare endDate int;
	set endDate = UNIX_TIMESTAMP(now())-7*24*3600;

	-- 采集记录
	delete from ssc_data where time < endDate;
	-- 会员登录session
	delete from ssc_member_session where accessTime < endDate;
	-- 投注
	delete from ssc_bets where kjTime < endDate and lotteryNo <> '';
	-- 管理员日志
	delete from ssc_admin_log where actionTime < endDate;

end$
delimiter ;

/*
 *删除用户
  *
 */
-- call delUser(uid);

drop procedure if exists delUser;
delimiter $
create procedure delUser(_uid int) begin
	-- 投注
	delete from ssc_bets where `uid`=_uid;
	-- 帐变
	delete from ssc_coin_log where `uid`=_uid;
	-- 管理员日志
	delete from ssc_admin_log where `uid`=_uid;
	-- 会员登录session
	delete from ssc_member_session where `uid`=_uid;
	-- 提现
	delete from ssc_member_cash where `uid`=_uid;
	-- 充值
	delete from ssc_member_recharge where `uid`=_uid;
	-- 银行
	delete from ssc_member_bank where `uid`=_uid;
	-- 用户
	delete from ssc_members where `uid`=_uid;
	-- 推广链接
	delete from ssc_links where `uid`=_uid;
end$
delimiter ;


/*
 *批量删除用户
  *
 */
-- call delUsers(100,7);

drop procedure if exists delUsers;
delimiter $
create procedure delUsers(_coin float(10,2), _date int) begin
	declare uid_del int;
	declare done int default 0;
	declare cur cursor for
	select distinct u.uid from ssc_members u, ssc_member_session s where u.uid=s.uid and u.coin<_coin and s.accessTime<_date and not exists(select u1.`uid` from ssc_members u1 where u1.parentId=u.`uid`)
union 
  select distinct u2.uid from ssc_members u2 where u2.coin<_coin and u2.regTime<_date and not exists (select s1.uid from ssc_member_session s1 where s1.uid=u2.uid);
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into uid_del;
			if not done then 
				call delUser(uid_del);
			end if;
		until done end repeat;
	close cur;
end$
delimiter ;

-- --------------------------删除end-----------------

-- ---------------------------佣金开始--------------------------
drop event if exists event_conCom;
create event event_conCom
on schedule every 5 minute starts '2012-08-10 00:03:00'
do call consumptionCommission();

/*
 * 消费佣金
 *
 */
drop procedure if exists consumptionCommission;
delimiter $
create procedure consumptionCommission() begin

	declare baseAmount float;
	declare baseAmount2 float;
	declare parentAmount float;
	declare superParentAmount float;

	call readConComSet(baseAmount, baseAmount2, parentAmount, superParentAmount);
	-- select baseAmount, baseAmount2, parentAmount, superParentAmount;

	if baseAmount>0 then
		call conComAll(baseAmount, parentAmount, 1);
	end if;
	if baseAmount2>0 then
		call conComAll(baseAmount2, superParentAmount, 2);
	end if;

end $
delimiter ;

/*
 * 计算消费佣金，需要传递消费佣金配置参数
 */
drop procedure if exists conComAll;
delimiter $
create procedure conComAll(baseAmount float, parentAmount float, parentLevel int) begin

	declare conUid int;
	declare conUserName varchar(255);
	declare tjAmount float;
	declare done int default 0;	
	declare dateTime int default unix_timestamp(curdate());

	declare cur cursor for
	select b.uid, b.username, sum(b.`mode` * b.actionNum * b.beiShu * (b.fpEnable+1)) _tjAmount from ssc_bets b where b.kjTime>=dateTime and b.uid not in(select distinct l.extfield0 from ssc_coin_log l where l.liqType=53 and l.actionTime>=dateTime and l.extfield2=parentLevel) group by b.uid having _tjAmount>=baseAmount;
	declare continue HANDLER for not found set done=1;

	-- select baseAmount , parentAmount , parentLevel;
	
	open cur;
		repeat fetch cur into conUid, conUserName, tjAmount;
		-- select conUid, conUserName, tjAmount;
		if not done then
			call conComSingle(conUid, parentAmount, parentLevel);
		end if;
		until done end repeat;
	close cur;

end $
delimiter ;

-- select b.uid, b.username, sum(b.`mode` * b.actionNum * b.beiShu * (b.fpEnable+1)) tjAmount from ssc_bets b where b.kjTime>=1347033600 and b.uid not in(select distinct l.extfield0 from ssc_coin_log l where liqType=53 and l.actionTime>=1347033600) group by b.uid having tjAmount>=500;

/*
 * 处理一条消费达到消费佣金的相关佣金送给
 */
drop procedure if exists conComSingle;
delimiter $
create procedure conComSingle(conUid int, parentAmount float, parentLevel int) begin

	declare parentId int;
	declare superParentId int;
	declare conUserName varchar(255) character set utf8;
	declare p_username varchar(255) character set utf8;

	declare liqType int default 53;
	declare info varchar(255) character set utf8;

	declare done int default 0;
	declare cur cursor for
	select p.uid, p.parentId, p.username, u.username from ssc_members p, ssc_members u where u.parentId=p.uid and u.`uid`=conUid; 
	declare continue HANDLER for not found set done=1;

	open cur;
		repeat fetch cur into parentId, superParentId, p_username, conUserName;
		-- select parentId, superParentId, p_username, conUserName, parentLevel;
		if not done then
			if parentLevel=1 then
				if parentId and parentAmount then
					set info=concat('下级[', conUserName, ']消费佣金');
					call setCoin(parentAmount, 0, parentId, liqType, 0, info, conUid, conUserName, parentLevel);
				end if;
			end if;
			
			if parentLevel=2 then
				if superParentId and parentAmount then
					set info=concat('下级[', conUserName, '<=', p_username, ']消费佣金');
					call setCoin(parentAmount, 0, superParentId, liqType, 0, info, conUid, conUserName, parentLevel);
				end if;
			end if;
		end if;
		until done end repeat;
	close cur;

end $
delimiter ;

/*
 * 读取佣金配置
 * 
 * @params baseAmount		上级基本消费金额，如果为0，表示关闭这个活动
 * @params baseAmount2		上上级基本消费金额，如果为0，表示关闭这个活动
 * @params parentAmount		上级获得的佣金
 * @params superParentAmount上上级获得的佣金
 */
drop procedure if exists readConComSet;
delimiter $
create procedure readConComSet(OUT baseAmount float, OUT baseAmount2 float, OUT parentAmount float, OUT superParentAmount float) begin

	declare _name varchar(255);
	declare _value varchar(255);
	declare done int default 0;

	declare cur cursor for
	select name, `value` from ssc_params where name in('conCommissionBase', 'conCommissionBase2', 'conCommissionParentAmount', 'conCommissionParentAmount2');
	declare continue HANDLER for not found set done=1;

	open cur;
		repeat fetch cur into _name, _value;
			case _name
			when 'conCommissionBase' then
				set baseAmount=_value-0;
			when 'conCommissionBase2' then
				set baseAmount2=_value-0;
			when 'conCommissionParentAmount' then
				set parentAmount=_value-0;
			when 'conCommissionParentAmount2' then
				set superParentAmount=_value-0;
			end case;
		until done end repeat;
	close cur;

end $
delimiter ;

/*
 * 佣金结束
 */
/*
 * 追号撤单
 */
drop procedure if exists cancelBet;
delimiter $
create procedure cancelBet(_zhuiHao varchar(255)) begin

	declare amount float;
	declare _uid int;
	declare _id int;
	declare _type int;
	
	declare info varchar(255) character set utf8;
	declare liqType int default 5;
	
	declare done int default 0;
	declare cur cursor for
	select id, `mode` * beiShu * actionNum * (fpEnable+1), `uid`, `type` from ssc_bets where serializeId=_zhuiHao and lotteryNo='' and isDelete=0;
	declare continue HANDLER for not found set done=1;
	
	open cur;
		repeat
			fetch cur into _id, amount, _uid, _type;
			if not done then
				update ssc_bets set isDelete=1 where id=_id;
				set info='追号撤单';
				call setCoin(amount, 0, _uid, liqType, _type, info, _id, '', '');
			end if;
		until done end repeat;
	close cur;

end $
delimiter ;


-- 支付事件
-- CREATE EVENT e_test_insert
-- ON SCHEDULE EVERY 1 SECOND
-- DO INSERT INTO test.aaa VALUES (CURRENT_TIMESTAMP);
delimiter ;
drop event if exists event_pay;
delimiter $
create event event_pay
on schedule every 90 second
do begin
	
	call pro_pay();

end$
delimiter ;


-- 支付事件调用
drop procedure if exists pro_pay;
delimiter $
create procedure pro_pay() begin

	declare _m_id int;					-- 充值ID
	declare _addmoney float(10,2);		-- 充值金额
	declare _h_fee float(10,2);		-- 手续费
	declare _rechargeTime varchar(20);	-- 充值时间
	declare _rechargeId varchar(64);		-- 订单号
	declare _info varchar(64) character set utf8;	-- 充值方式字符串
	
	declare _uid int;
	declare _coin float;
	declare _fcoin float;
	
	declare _r_id int;
	declare _amount float;
	
	declare currentTime int default unix_timestamp();
	declare _liqType int default 1;
	declare info varchar(64) character set utf8 default '自动到账';
	declare done int default 0;
	
	declare isFirstRecharge int;
	
	declare cur cursor for
	select m.id, m.addmoney, m.h_fee, m.o_time, m.u_id, m.memo,		u.`uid`, u.coin, u.fcoin,		r.id, r.amount from ssc_members u, my18_pay m, ssc_member_recharge r where u.`uid`=r.`uid` and r.rechargeId=m.u_id and m.`state`=0 and r.`state`=0 and r.isDelete=0;
	declare continue HANDLER for not found set done = 1;

	start transaction;
		open cur;
			repeat
				fetch cur into _m_id, _addmoney, _h_fee, _rechargeTime, _rechargeId, _info, _uid, _coin, _fcoin, _r_id, _amount;
				
				if not done then
					-- select _r_id;
					-- if _amount=_addmoney then
						call setCoin(_addmoney, 0, _uid, _liqType, 0, info, _r_id, _rechargeId, '');
						if _h_fee>0 then
							call setCoin(_h_fee, 0, _uid, _liqType, 0, '充值手续费', _r_id, _rechargeId, '');
						end if;
						update ssc_member_recharge set rechargeAmount=_addmoney+_h_fee, coin=_coin, fcoin=_fcoin, rechargeTime=currentTime, `state`=2, `info`=info where id=_r_id;
						update my18_pay set `state`=1 where id=_m_id;
						
						-- 每天首次充值上家赠送充值佣金
						call isFirstRechargeCom(_uid, isFirstRecharge);
						if isFirstRecharge then
							call setRechargeCom(_addmoney, _uid, _r_id, _rechargeId);
						end if;
					-- else
						-- update my18_pay set `state`=2 where id=_m_id;
					-- end if;
				end if;
				
			until done end repeat;
		close cur;
	commit;
	
	
end$
delimiter ;

-- 读取充值佣金配置
drop procedure if exists readRechargeComSet;
delimiter $
create procedure readRechargeComSet(OUT baseAmount float, OUT parentAmount float, OUT superParentAmount float) begin

	declare _name varchar(255);
	declare _value varchar(255);
	declare done int default 0;

	declare cur cursor for
	select name, `value` from ssc_params where name in('rechargeCommissionAmount', 'rechargeCommission', 'rechargeCommission2');
	declare continue HANDLER for not found set done=1;

	open cur;
		repeat fetch cur into _name, _value;
			case _name
			when 'rechargeCommissionAmount' then
				set baseAmount=_value-0;
			when 'rechargeCommission' then
				set parentAmount=_value-0;
			when 'rechargeCommission2' then
				set superParentAmount=_value-0;
			end case;
		until done end repeat;
	close cur;

end $
delimiter ;

-- 查找是否当天首次充值
drop procedure if exists isFirstRechargeCom;
delimiter $
create procedure isFirstRechargeCom(_uid int, OUT flag int) begin
	
	declare dateTime int default unix_timestamp(curdate());
	select id into flag from ssc_member_recharge where rechargeTime>dateTime and `uid`=_uid;
	
end $
delimiter ;



-- 处理一条充值佣金
drop procedure if exists setRechargeCom;
delimiter $
create procedure setRechargeCom(_coin float, _uid int, _rechargeId int, _serId int) begin
	
	declare baseAmount float;
	declare parentAmount float;
	declare superParentAmount float;
	
	declare _parentId int;
	declare _surperParentId int;
	
	declare liqType int default 52;
	declare info varchar(255) character set utf8 default '充值佣金';
	
	declare done int default 0;
	declare cur cursor for
	select p.`uid`, p.parentId from ssc_members p, ssc_members u where p.`uid`=u.parentId and u.`uid`=_uid;
	declare continue HANDLER for not found set done=1;
	
	call readRechargeComSet(baseAmount, parentAmount, superParentAmount);
	
	open cur;
		repeat fetch cur into _parentId, _surperParentId;
			if not done then
				if _parentId then
					call setCoin(parentAmount, 0, _parentId, liqType, 0, info, _rechargeId, _serId, '');
				end if;
				
				if _surperParentId then
					call setCoin(superParentAmount, 0, _surperParentId, liqType, 0, info, _rechargeId, _serId, '');
				end if;
			end if;
		until done end repeat;
	close cur;
	
end $
delimiter ;



-- 统计

-- 统计一天的盈亏、投注

drop procedure if exists pro_count;
delimiter $
create procedure pro_count(_date varchar(20)) begin
	
	declare fromTime int;
	declare toTime int;
	
	if not _date then
		set _date=date_add(curdate(), interval -1 day);
	end if;
	
	set toTime=unix_timestamp(_date);
	set fromTime=toTime-24*3600;
	
	insert into ssc_count(`type`, playedId, `date`, betCount, betAmount, zjAmount)
	select `type`, playedId, _date, sum(actionNum), sum(actionNum * beiShu * `mode` * (fpEnable+1)), sum(bonus) from ssc_bets where kjTime between fromTime and toTime and isDelete=0 group by type, playedId
	on duplicate key update betCount=values(betCount), betAmount=values(betAmount), zjAmount=values(zjAmount);


end$
delimiter ;

-- 每天晚上三点自动统计前一天数据
drop event if exists event_count;
create event event_count
on schedule every 1 day starts '2012-08-10 00:03:00'
do call pro_count('');


-- 重新统计
insert into ssc_count(`type`, playedId, `date`, betCount, betAmount, zjAmount)
select `type`, playedId, date_format(from_unixtime(kjTime), '%Y-%m-%d') `date`, sum(actionNum), sum(actionNum * abs(beiShu) * `mode` * (fpEnable+1)), sum(bonus) from ssc_bets where isDelete=0 group by `type`, playedId, `date`
on duplicate key update betCount=values(betCount), betAmount=values(betAmount), zjAmount=values(zjAmount);






