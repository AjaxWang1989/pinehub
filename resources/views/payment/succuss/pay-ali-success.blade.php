<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>支付完成</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport"/>
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
		}
		.empty {
			height: 20px;
		}
		.warp .content {
			width: 90%;
			margin: 0 auto;
			border-bottom: 0.1rem dashed #ddd;
		}
		.warp .header {
			display: flex;
			justify-content: center;
			align-items: center;
			height:auto;
			padding: 2rem;
		}
		.header .info {
			height: 100%;
		}
		.header .checked {
			margin-right: 1rem;
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
		.warp .word {
			font-size: 1.4rem;
			color: #18a5ea;
			text-align: center;
			margin-top: 2rem;
		}
		.footer {
			position: absolute;
			font-size: 1rem;
			color: #999;
			bottom: 10px;
			left: 50%;
			transform: translateX(-50%);
		}
		.banner {
			margin: 14% auto;
		}
		.banner img {
			width: 100%;
			height: 100%;
		}
		#price {
			font-size: 3rem;
			text-align: center;
			margin-top: 10%;
		}
	</style>
</head>
<body>
	<div class="warp">
		<div class="empty"></div>
		<div class="content">
			<div class="header">
				<div class="checked">
					<img class="icon_checked" width="100%" src="icon_checked_a.png">
				</div>
				<div class="info">
					<p class="title">支付完成</p>
					<p class="name"><span class="shop">商家</span></p>
					<p>No.{{ $shop['code'] }}</p>
				</div>
			</div>
		</div>
		<p id="price">¥23.5</p>
		<p class="word">欢迎您再次消费</p>
		<div class="banner">
			<img src="banner.png">
		</div>
		<p class="footer">京抖云提供技术支持</p>
	</div>
</body>
</html>