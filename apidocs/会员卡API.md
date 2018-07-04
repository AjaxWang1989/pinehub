# 会员卡定制与投放
1. 会员卡定制接口

    + route：host+/member/card
    + method: POST
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | score     | int    | Y | 积分数量 |
         | type | int | Y | 积分类型 0-通用 9 - 关注 10 - 订单消费达到额度 11-订单数达到一定数量|
         | expires_at| date | N | 过期时间
         | notice_user | boolean | Y | 是否通知用户|
         | rule | json | Y | order_count - 订单数 order_amount - 订单额度 focus-关注
         
    + return data: