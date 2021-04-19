<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        // 获取今日redis哈希表的名称
        $hash = $this->getHashFromDateSring(Carbon::now()->toDateString());
        // 字段名称, 如: user_1
        $field = $this->getHashField();
        // 当前时间, 如: 2021_01_01 09:59:59
        $now = Carbon::now()->toDateTimeString();
        // 数据写入redis, 字段已存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        // 获取昨日redis哈希表的名称
        $hash = $this->getHashFromDateSring(Carbon::yesterday()->toDateString());
        // 从redis中获取所有哈希表里的数据
        $dates = Redis::hGetAll($hash);

        foreach ($dates as $user_id => $actived_at) {
            // 将user_1转换为1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用户存在时才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储, 既已同步, 即可删除
        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        // 获取今日对应redis哈希表的名称
        $hash = $this->getHashFromDateSring(Carbon::now()->toDateString());
        // 字段名称, 如: user_1
        $field = $this->getHashField();
        // 优先选择redis的数据, 否则使用数据库中的
        $datetime = Redis::hGet($hash, $field) ?: $value;
        // 如果存在, 返回时间对应的Carbon实体
        if ($datetime) {
            return new Carbon($datetime);
        } else { // 否则使用用户的注册时间
            return $this->created_at;
        }
    }

    public function getHashFromDateSring($date)
    {
        // redis哈希表的命名, 如: larabbs_last_actived_at_2021_01_01
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名称, 如: user_1
        return $this->field_prefix . $this->id;
    }
}
