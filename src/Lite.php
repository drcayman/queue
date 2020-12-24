<?php

namespace drcayman\queue;
use Predis\Client;

class Lite
{
    /***
     * Lite constructor.
     * @param $config array redis 链接信息
     */
    protected  $client;
    public function __construct($config,$options = null){

        if(!empty($options)){
            $this->client = new Client($config,$options);
        }else{
            $this->client = new Client($config);
        }


    }

    /** 推送队列 后面插入
     *  到达过期队列直接扔掉数据 执行时间 到达执行时间才能取出数据
     * @param string $key  队列名
     * @param  array $data   数据
     * @param int $timeout  过期时间 秒数 0 永不过期
     * @param int $task_time 执行时间 秒数 0 立即执行
     * @return int  返回队列剩余条数
     */
    public function rPush($key,$data,$task_time = 0,$timeout = 0){

        $data =[
            'data'=>$data,
            'timeout'=>$timeout,
            'task_time'=>$task_time+time()
        ];
        return $this->client->rpush($key,[json_encode($data)]);
    }

    /** 推送队列 前面插入
     *  到达过期队列直接扔掉数据 执行时间 到达执行时间才能取出数据
     * @param string $key  队列名
     * @param  array $data   数据
     * @param int $timeout  过期时间 秒数 0 永不过期
     * @param int $task_time 执行时间 秒数 0 立即执行
     * @return int  返回队列剩余条数
     */
    public function lPush($key,$data,$task_time = 0,$timeout = 0){

        $data =[
            'data'=>$data,
            'timeout'=>$timeout,
            'task_time'=>$task_time+time()
        ];
        return $this->client->lpush($key,[json_encode($data)]);
    }

    /** 取出队列
     * @param string $key  队列名
     * @return mixed
     */
    public function lPop($key){
       $data = json_decode($this->client->lpop($key),true);
        if(empty($data)){
            //没数据
            return [];
        }
        if($data['timeout'] > time() or $data['timeout']==0){//不过期 或者在过期时间之内
            if($data['task_time']<=time()){
                return $data['data'];//到达执行时间
            }
            return $this->client->rpush($key,[json_encode($data)]);//未到达执行时间 重新压入队列
        }
        return [];
    }


    /** 获取队列剩余条数
     * @param string $key  队列名
     * @return int 条数
     */
    public function llen($key){

        return $this->client->llen($key);
    }

}