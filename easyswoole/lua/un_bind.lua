--
-- Created by IntelliJ IDEA.
-- User: luffyzhao
-- Date: 2018/12/22
-- Time: 14:44
-- To change this template use File | Settings | File Templates.
--

local fd = KEYS[1];
-- fd和用户映射关系
local key = KEYS[2];
-- 用户和fd映射关系
local key2 = KEYS[3];
-- fd和身份对应关系
local key3 = KEYS[4];

local identifying = redis.call('hGet', key3, fd);
local uid = redis.call('hGet', key..identifying, fd);

redis.call('hDel', key..identifying, fd);
redis.call('hDel', key2..identifying, uid);
redis.call('hDel', key3, fd);

return nil;

