# php redis 队列 文档 

# 使用方法


    use drcayman/queue/Lite;
    $config =['scheme'=>'tcp','host' => '127.0.0.1','port' => 6379,'database' => 15];
    $lite = new Lite($config);
    $lite->rPush($key,$data,$timeout = 0,$task_time = 0);//添加队列 返回队列条数 
    $lite->lPop($key);//取出队列
    $lite->llen($key);//获取队列剩余条数

# redis 连接参数

scheme [string - default: tcp]

Specifies the protocol used to communicate with an instance of Redis. Internally the client uses the connection class associated to the specified connection scheme. By default Predis supports tcp (TCP/IP), unix (UNIX domain sockets) or http (HTTP protocol through Webdis).

host [string - default: 127.0.0.1]

IP or hostname of the target server. This is ignored when connecting to Redis using UNIX domain sockets.

port [integer - default: 6379]

TCP/IP port of the target server. This is ignored when connecting to Redis using UNIX domain sockets.

path [string - default: not set]

Path of the UNIX domain socket file used when connecting to Redis using UNIX domain sockets.

database [integer - default: not set]

Accepts a numeric value that is used by Predis to automatically select a logical database with the SELECT command.

password [string - default: not set]

Accepts a value used to authenticate with a Redis server protected by password with the AUTH command.

async [boolean - default: false]

Specifies if connections to the server is estabilished in a non-blocking way (that is, the client is not blocked while the underlying resource performs the actual connection).

persistent [boolean - default: false]

Specifies if the underlying connection resource should be left open when a script ends its lifecycle.

timeout [float - default: 5.0]

Timeout (expressed in seconds) used to connect to a Redis server after which an exception is thrown.

read_write_timeout [float - default: not set]

Timeout (expressed in seconds) used when performing read or write operations on the underlying network resource after which an exception is thrown. The default value actually depends on the underlying platform but usually it is 60 seconds.

alias [string - default: not set]

Identifies a connection by providing a mnemonic alias. This is mostly useful with aggregated connections such as client-side sharding (cluster) or master/slave replication.

weight [integer - default: not set]

Specifies a weight used to balance the distribution of keys asymmetrically across multiple servers when using client-side sharding (cluster).

iterable_multibulk [boolean - default: false]

When set to true Predis returns multibulk from Redis as iterator instances instead of plain simple PHP arrays.

throw_errors [boolean - default: true]

When set to true server errors generated by Redis are translated to PHP exceptions, otherwise they are returned as normal PHP objects.




