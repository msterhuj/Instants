<?php

namespace Core;

use App\Config;
use Redis;

class Cache {
    public static function get(): Redis {
        $redis = new Redis();
        $redis->connect(Config::REDIS_HOST, Config::REDIS_PORT);
        $redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        return $redis;
    }
}