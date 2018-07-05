<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>扫码支付</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport"/>
        <link rel="stylesheet" type="text/css"  href="https://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css">
    </head>
    <body>
        <div class="warp">
            {{--@if($success)--}}
                {{--<a href="#" class="weui-btn weui-btn_primary">授  权 成 功</a>--}}
            {{--@else--}}
                {{--<a href="{{ $authUrl }}" class="weui-btn weui-btn_primary">授  权</a>--}}
            {{--@endif--}}

        </div>
        <script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
        <script>
            $(function () {
                @if(!$success)
                    console.log('{!! $authUrl !!}')
                    window.location.href="{!! $authUrl !!}";
                @endif
            });
        </script>
    </body>
</html>