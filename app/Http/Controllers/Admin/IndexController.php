<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    protected $redis;

    public function __construct()
    {
        $this->redis = app('redis.connection');
    }

    public function index()
    {
        // 字符串基本操作
        $this->redis->set('name','PHOME_明'); // 设置key=name value=PHOME_明
        $this->redis->get('name');   //  获取key=name的值

        // set和ge多个 key => value操作
        $data = [
            "width" => "100px",
            "height"  => "98px",
            "top" => "64px",
            "bottom" => "98px"
        ];

        $this->redis->mset($data);   // 存储多个key-value
        $this->redis->mget(array_keys($data));   // 获取多个key对应的value

        // 存放带有失效时间的 key -> value
        $this->redis->setex('sql_name',2,'mysql');  // 2秒後失效

        // 新增操作,不会覆盖已有值
        $this->redis->setnx('title','redis');    //  返回 true ， 添加成功
        $this->redis->setnx('title','laravel');  //  返回 false， 添加失败，因为已经存在键名为 title 的记录
        // return $this->redis->get('title');

        // set的变种，结果返回替换前的值
        $this->redis->getset('title','mysql');
        // return $this->redis->get('title');

        // incrby/incr/decrby/decr 对值的递增和递减
        $this->redis->set('val',10);
        $this->redis->incr('val');        // +1 = 11
        $this->redis->incrby('val',2);    // +2 = 13

        $this->redis->decr('val');        // -1 = 12
        $this->redis->decrby('val',2);    // -2 = 10

        // 检测是否存在值
        $this->redis->exists('val');  // 存在->返回->1  不存在->返回->0

        // 删除
        $this->redis->del('title');

        // type类型检测,字符串返回 string，列表返回 list，set 表返回 set/zset，hash 表返回 hash
        $this->redis->type('val');

        // append 连接到已存在字符串
        $this->redis->get('sql_name');  // 返回：mysql
        $this->redis->append('sql_name','_add_string');  // 返回字符串的长度值：16 ，此时 sql_name=mysql_add_string


        // setrange 部分替换操作, 并返回字符串长度
        $this->redis->setrange('sql_name',10,'admin888');
        // return $this->redis->get('sql_name');

        return $this->redis->info();



    }
}
