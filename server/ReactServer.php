<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/1
 * Time: 下午3:05
 */

class ReactServer
{
    protected $loop = null;

    protected $socket = null;

    protected $http = null;

    protected $app = null;

    protected $host = '';

    protected $port = '';

    public function __construct(string $host, string $port, \Laravel\Lumen\Application $app)
    {
        $this->loop = \React\EventLoop\Factory::create();
        $this->socket = new \React\Socket\Server($this->loop);
        $this->http = new \React\Http\Server($this->socket);
        $this->app = $app;
    }

    public function run()
    {
        $this->http->on('request', function (\React\Http\Request $request, \React\Http\Response $response) {

        });
        $this->socket->listen($this->port, $this->host);
    }

    protected function handleRequest(\React\Http\Request $request)
    {
    }
}