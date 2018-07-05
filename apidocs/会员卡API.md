# 会员卡定制与投放
1. 会员卡定制接口

    + route：host+/member/card
    + method: POST
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | sync     | boolean    | Y | 是否同步到微信 |
         | member_info | array | Y | 会员卡信息参考微信会员卡管理里面的会员卡创建接口|
         
    + return data:
    ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{"discount": 10, "base_info":{"sku":{"quantity": 50000000 }, "color": "Color010"}},
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
    ```
    注释：1、status -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功； 2、sync 0-审核中 1-审核通过 2-审核未通过。

2. 会卡列表（查询）

    + route：host+/member/cards
    + method: GET
    + auth : NO
    + params:
         
         搜索：search=card_type,=
         
    + return data:
    ```json
        {
            "data":[
                {
                    "id": 1,
                    "color": "Color010",
                    "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/",
                    "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
                    "card_type": "member_card",
                    "brand_name": "海底捞",
                    "code_type": "CODE_TYPE_TEXT",
                    "title": "海底捞会员卡",
                    "sku":{"quantity": 50000000},
                    "app_id": "123456",
                    "wechat_app_id": "wx581a7ad7ca810da6",
                    "ali_app_id": null,
                    "status": 0,
                    "sync": 0,
                    "created_at": null,
                    "updated_at": null
                }
            ],
            "meta":{
                "pagination":{
                    "total": 1,
                    "count": 1,
                    "per_page": 15,
                    "current_page": 1,
                    "total_pages": 1,
                    "links":[]
                }
            }
        }
    ```
    注释：1、status -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功； 2、sync 0-审核中 1-审核通过 2-审核未通过。
    
3. 会员卡信息修改接口

    + route：host+/member/card/{id}
    + method: PUT
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | sync     | boolean    | Y | 是否同步到微信 |
         | member_info | array | Y | 会员卡信息参考微信会员卡管理里面的会员卡创建接口|
         
    + return data:
    ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{"discount": 10, "base_info":{"sku":{"quantity": 50000000 }, "color": "Color010"}},
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
    ```
    注释：1、status -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功； 2、sync 0-审核中 1-审核通过 2-审核未通过。
    
    
3. 会员卡信息展示接口

    + route：host+/member/card/{id}
    + method: GET
    + auth : YES
    + params:
    
         无参数
         
    + return data:
    ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{"discount": 10, "base_info":{"sku":{"quantity": 50000000 }, "color": "Color010"}},
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
    ```
    注释：1、status -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功； 2、sync 0-审核中 1-审核通过 2-审核未通过。


    