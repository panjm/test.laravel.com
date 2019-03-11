<?php

namespace App\Http\Controllers\Demo;

use App\Models\Sgoods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class MiaoshaController extends Controller
{
    public function __construct()
    {

    }

    /**
     * 第一步将商品存入redis队列中
     * @param Request $request
     * @return
     */
    public function storage(Request $request)
    {
        try{
            // 查询商品队列
//             dd(Redis::keys('goods_store:*'));//查询有哪些队列
            //dd(Redis::lrange('goods_store:18', 0, '-1'));//查询队列的所有元素

            $goods_id = $request->get('goods_id');

            $result = Sgoods::find($goods_id);

            return $result;

        }catch (\Exception $e)
        {

        }


    }
}
