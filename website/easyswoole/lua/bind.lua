--
-- Created by IntelliJ IDEA.
-- User: luffyzhao
-- Date: 2018/12/22
-- Time: 14:44
-- To change this template use File | Settings | File Templates.
--

local fd = KEYS[1];
local uid = KEYS[2];
-- websocket fd和用户映射关系
local key = KEYS[3];
-- websocket 用户和fd映射关系
local key2 = KEYS[4];
-- fd和身份对应关系
local key3 = KEYS[5];
-- 用户身份
local identifying = KEYS[6];

redis.call('hSet', key3, fd, identifying);

redis.call('hSet', key..identifying, fd, uid);

redis.call('hSet', key2..identifying, uid, fd);

return nil;