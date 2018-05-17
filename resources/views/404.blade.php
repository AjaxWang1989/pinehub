<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>404</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
            font-size: 62.5%;
            font-family: "Helvetica Neue", Helvetica, Arial, "PingFang SC", "Hiragino Sans GB", "Heiti SC", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
            -webkit-font-smoothing: antialiased;

        }
        .warp {
            width: 100%;
            height: 100vh;
            background-color: #ebebeb;
        }
        .warp .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 94%;
            margin: 0 auto;
            text-align: center;
        }
        .warp .content img {
            margin-top: 40px;
            width: 24rem;
        }
        .warp .content .text {
            display: flex;
            margin: 20px auto 0;
            flex-direction: column;
            align-items: flex-start;
        }
        .warp .content h2 {
            font-weight: 500;
            font-size: 4rem;
            color: #333;
        }
        .warp .content p {
            color: #666;
            font-size: 1.4rem;
        }
        .warp .content button {
            width: 42%;
            height: 3.8rem;
            margin-top: 20px;
            border: 0.1rem solid #18a5ea;
            border-radius: 0.6rem;
            color: #18a5ea;
            font-size: 1.8rem;
            background-color: #ebebeb;
        }
        .warp .content footer {
            position: absolute;
            font-size: 1rem;
            color: #999;
            bottom: 10px;
        }
    </style>
</head>
<body>
<div class="warp">
    <div class="content">
        <img src="{{ url('images/icon_404.png') }}" alt="">
        <div class="text">
            <h2>404</h2>
            <p>抱歉你访问的页面不存在</p>
        </div>
        <!--<button>返回首页</button>-->
    </div>
    {{--<footer>京抖云提供技术支持</footer>--}}
</div>
</body>
</html>