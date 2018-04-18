# pinehub-api
## 部署
### nginx配置
### php pool配置（fpm）
### fpm负载均衡

## 客户端http请求需要注意驶向
    - API请求时http header accept application/vnd.pinehub.(版本号根据后台服务器接口版本号一致由服务器定义)+json
    -   json web token api// send the refreshed token back to the client
        $response->headers->set('Authorization', 'Bearer '.$newToken);
        客户端 jwt http请求header设置authoriztion bearer token