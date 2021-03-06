<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>扫码支付</title>
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
        .empty {
            height: 20px;
        }
        .warp .content {
            height: 58%;
            width: 94%;
            margin: 0 auto;
            background-color: #fff;
        }
        .warp .header {
            display: flex;
            justify-content: center;
            align-items: center;
            height:auto;
            padding:1rem 2rem;
            background-color: #fbfbfb;
        }
        .header .info {
            height: 100%;
        }
        .header .avatar {
            margin-right: 1rem;
        }
        .header .avatar img{
            display: block;
        }
        .header .info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .header .info .name .shop {
            padding: 0.2rem 0.4rem;
            margin-right: 0.4rem;
            font-size: 1.2rem;
            border-radius: 10%;
            width: auto;
            text-align: center;
            background-color: #c8c8c8;
            color: #fff;
        }
        .header .title {
            font-size: 1.8rem;
            color: #000;
        }
        .header .name {
            line-height: 24px;
            font-size: 1.5rem;
            color: #666;
        }
        .content .payment {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            height: 65%;
            padding:0rem 2rem;
        }
        .payment .title {
            font-size: 2rem;
            color: #424242;
        }
        .payment .input-money {
            height: 80px;
            line-height: 80px;
            width: auto;
            display: inline-block;
            background: none;
            border: none;
            -webkit-appearance: none;
            outline: none;
            font-size: 5rem;
            text-indent: 20px;
        }
        .payment .input-area {
            width: 100%;
            display: flex;
            /*flex-direction: row;*/
            justify-content: flex-start;
            align-items: center;
        }
        .payment .input-area div:first-child {
            display: inline-block;
            line-height: 80px;
            font-family: PingFang SC;
            font-size: 4rem;
        }
        .payment .btn {
            height: 50px;
            width: 100%;
            color: #fff;
            font-size: 20px;
            border:none;
            outline: none;
            border-radius: 4px;
            background-color: #18a5ea;
        }
        html,body {
            height: 100%;
            overflow: hidden;
        }
        .layer-content {
            position: absolute;
            left: 50%;
            bottom: 0px;
            width: 100%;
            height: auto;
            z-index: 12;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
        }
        .form_edit {
            width: 100%;
            background: #D1D4DD;
            padding-top: 1.4%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            align-content: flex-start;
        }
        .form_edit> div {
            margin-bottom: 1.4%;
            width: 32%;
            height: 45px;
            text-align: center;
            color: #333;
            line-height:45px;
            font-size: 2rem;
            background-color: #fff;
            border-radius: 5px;
        }
        .form_edit> div:last-child {
            background-color: #f2f2f2;
        }
        .cursor{
            height: 6rem;
            display: inline-block;
            border-left:0.2rem solid #18a5ea;
            border-radius: 0.1rem;
            margin-left: 2rem;
        }
        .avatar{
            width:5rem;
        }
        .clearfix {
            *zoom: 1;
        }
        #remove{
            line-height: 45px;
        }
        .line {
            /*position: absolute;
            bottom: 0;*/
            width: 100%;
            height: 0.1rem;
            background-color: #cccccc;
        }
        .tie {
            color: #999;
            font-size: 1.1rem;
            text-align: center;
        }
        .active{
            opacity: 0.5;
        }
    </style>
</head>
<body>
<div class="warp">
    <div class="empty"></div>
    <div class="content">
        <div class="header">
            <div class="avatar">
                <img class="user-avatar" width="100%" src="{{ url('images/logo_ali.png') }}">
            </div>
            <div class="info">
                @if (isset($shop))
                    <p class="title">福年来早餐车</p>
                    <p class="name"><span class="shop">商家</span></p>
                    <p>NO.{{ $shop['code'] }}</p>
                @else
                    <p class="title">福年来扫码支付</p>
                @endif
            </div>
        </div>
        <div class="payment">
            <div class="input-area">
                <div>¥</div>
                <div class="input-money"></div>
                <div class="cursor"></div>
                <!--<input class="input-money" name="money" autofocus type="number" pattern="[0-9]*" maxlength="7">-->
            </div>
            <div class="line"></div>
            <p class="tie">京抖云提供技术支持</p>
            <button class="btn active" disabled="true">确认付款</button>
        </div>
    </div>
</div>
<div class="layer-content">
    <div class="form_edit clearfix">
        <div class="num">1</div>
        <div class="num">2</div>
        <div class="num">3</div>
        <div class="num">4</div>
        <div class="num">5</div>
        <div class="num">6</div>
        <div class="num">7</div>
        <div class="num">8</div>
        <div class="num">9</div>
        <div class="num" style="line-height: 40px;">.</div>
        <div class="num">0</div>
        <div id="remove"><img src="{{ url('images/Delete@2x.png') }}" alt="" width="20%"/></div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script src="https://gw.alipayobjects.com/as/g/h5-lib/alipayjsapi/3.1.1/alipayjsapi.min.js"></script>
<script>
    function ready(callback) {
        if (window.AlipayJSBridge) {
            callback && callback();
        } else {
            document.addEventListener('AlipayJSBridgeReady', callback, false);
        }
    }
    ready(function() {
        //alert('ali bridge ready');
    });

    const PAYMENT_SUCCESS = 9000;
    const NETWORK_ERROR_NOT_RECIVED = 6004;
    const SERVER_TIME_OUT_NOT_RECIVED = 8000;

    const WALLET_CANCEL_PAY = 7001;
    const NETWORK_ERROR_CANCEL_PAY = 6002;
    const USER_CANCEL_PAY = 6001;
    const PAYMENT_FAILED = 4000;

    $(function(){
        FastClick.attach(document.body);
        setInterval(function(){
            if($('.cursor').css("display")=="inline-block" || $('.cursor').css("display")=="block"){
                $('.cursor').css("display","none")
            }else{
                $('.cursor').css("display","inline-block")
            }
        }, 800);

        //填写信息
        // 监听#div内容变化，改变支付按钮的颜色
        $('.input-money').bind('DOMNodeInserted', function(){
            console.log($(".input-money")[0].innerHTML)
            if($(".input-money")[0].innerHTML!="" || $(".input-money")[0].innerHTML>'0'){
                $('.btn').removeClass('active');
                $('.btn').attr('disabled', false);
            }else{
                $('.btn').addClass('active');
                $('.btn').attr('disabled', true);
            }
        })
        $('#div').trigger('DOMNodeInserted');

        $('.shuru').click(function(e){
            $('.layer-content').animate({
                bottom: 0
            }, 200)
            e.stopPropagation();
        })
        $('.wrap').click(function(){
            $('.layer-content').animate({
                bottom: '-200px'
            }, 200)
        })

        $('.form_edit .num').click(function(){
            var oDiv = $(".input-money")[0];
//					var oDiv = document.getElementsByClassName("input-money")[0];
            var arr=[];
            if(oDiv.innerHTML){
                arr=oDiv.innerHTML.split("")
            }
            if(oDiv.innerHTML.length<7){
                if(!oDiv.innerHTML && (this.innerHTML=="." || this.innerHTML=="0")){
                    oDiv.innerHTML +="0."
                }else if(arr.length && arr.some(item=>(item=="."))){
                    if(this.innerHTML=="."){
                        return
                    }else{
                        if(oDiv.innerHTML.substring(oDiv.innerHTML.indexOf(".")).length<=2){
                            oDiv.innerHTML += this.innerHTML;
                        }
                    }
                }else{
                    oDiv.innerHTML += this.innerHTML;
                }
            }

        });
        $('#remove').click(function(){
            var oDiv = $(".input-money")[0];
//					var oDiv = document.getElementsByClassName("input-money")[0];
            var oDivHtml = oDiv.innerHTML;

            oDiv.innerHTML = oDivHtml.substring(0,oDivHtml.length-1);
            if(oDiv.innerHTML==''){
                $('.btn').addClass('active');
                $('.btn').attr('disabled', true);
            }
        });
        $('.btn').click(function(){
            var amount =  parseFloat($(".input-money")[0].innerHTML);
            $.ajax({
                url:"{{ $paymentApi }}",
                type:"POST",
                headers:{
                    accept: "{{ $accept }}",
                },
                data:{'total_amount': amount, 'discount_amount': 0, 'payment_amount': amount},
                beforeSend: function(){
                    AlipayJSBridge.call('showLoading', {
                        text: '支付中······',
                    });
                },
                success:function(data) {
                    //location.href = data.data.redirect;
                    console.log(JSON.stringify(data.data));
                    // alert(JSON.stringify(data.data));
                    AlipayJSBridge.call('hideLoading');
                    if(!!data.data && !!data.data.trade_no){
                        AlipayJSBridge.call("tradePay", {
                            tradeNO: data.data.trade_no
                        }, function(result) {
                           switch (result.resultCode){
                               case PAYMENT_SUCCESS: {

                                   break;
                               }
                               case SERVER_TIME_OUT_NOT_RECIVED:{

                                   break;
                               }
                               case NETWORK_ERROR_NOT_RECIVED:{

                                   break;
                               }
                               case NETWORK_ERROR_CANCEL_PAY:
                               case WALLET_CANCEL_PAY:
                               case USER_CANCEL_PAY:
                               case PAYMENT_FAILED:{
                                   break
                               }
                               default:{
                                   break;
                               }
                           }
                        });
                    }
                },
                error: function(error){
                    AlipayJSBridge.call('hideLoading');
                    alert(error);
                }
            });
        });
    });
</script>
</body>
</html>