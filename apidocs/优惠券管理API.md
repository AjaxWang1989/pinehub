# 优惠券管理

   1. 代制折扣券
        
   + route：host+/discount/ticket
   + method: POST
   + auth : YES
   + params:

     | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
     | :------: | :-------: | :------: | :----:|
     | ticket_info | array   | Y | 优惠券信息（参考微信优惠券创建接口） |
     | sync | boolean | Y | 是否同步到微信|
     | end_at| date | Y | 过期时间
     | begin_at | date | Y | 开始时间 |
 
   + return data:
   ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{
                "discount": 10,
                "base_info":{
                    "sku":{
                      "quantity": 50000000
                    },
                    "color": "Color010",
                    "title": "海底捞会员卡",
                    "notice": "使用时向服务员出示此券",
                    "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
                    "code_type": "CODE_TYPE_TEXT",
                    "date_info":{"type": "DATE_TYPE_PERMANENT"},
                    "get_limit": 3,
                    "brand_name": "海底捞",
                    "custom_url": "http://weixin.qq.com",
                    "description": "不可与其他优惠同享",
                    "promotion_url": "http://www.qq.com",
                    "service_phone": "020-88888888",
                    "can_give_friend": true,
                    "custom_url_name": "立即使用",
                    "use_custom_code": false,
                    "location_id_list":[123, 12321],
                    "need_push_on_view": true,
                    "promotion_url_name": "营销入口1",
                    "custom_url_sub_title": "6个汉字tips"
                },
                "bonus_rule":{
                    "reduce_money": 100,
                    "increase_bonus": 1,
                    "cost_bonus_unit": 5,
                    "cost_money_unit": 100,
                    "max_reduce_bonus": 50,
                    "max_increase_bonus": 200,
                    "init_increase_bonus": 10,
                    "least_money_to_use_bonus": 1000
                },
                "prerogative": "test_prerogative",
                "activate_url": "http://www.qq.com",
                "custom_cell1":{
                    "url": "http://www.xxx.com",
                    "name": "使用入口2",
                    "tips": "激活后显示"
                },
                "supply_bonus": true,
                "advanced_info":{
                "abstract":{
                    "abstract": "微信餐厅推出多种新季菜品，期待您的光临",
                    "icon_url_list":["http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw / 0 "…]
                },
                "time_limit":[
                {
                    "type": "MONDAY",
                    "end_hour": 10,
                    "begin_hour": 0,
                    "end_minute": 59,
                    "begin_minute": 10
                },
                {
                  "type": "HOLIDAY"
                }
                ],
                "use_condition":{
                    "accept_category": "鞋类",
                    "reject_category": "阿迪达斯",
                    "can_use_with_other_discount": true
                },
                "text_image_list":[
                {
                    "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                },
                {
                    "text": "此菜品迎合大众口味，老少皆宜，营养均衡",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sj piby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                }
                ],
                "business_service":[
                    "BIZ_SERVICE_FREE_WIFI",
                    "BIZ_SERVICE_WITH_PET",
                    "BIZ_SERVICE_FREE_PARK",
                    "BIZ_SERVICE_DELIVER"
                ]
                },
                "auto_activate": true,
                "custom_field1":{
                    "url": "http://www.qq.com",
                    "name_type": "FIELD_NAME_TYPE_LEVEL"
                },
                "supply_balance": false,
                "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/"
            },
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
```
                
  2. 代制现金券
    
 + route：host+/coupon/ticket
 + method: POST
 + auth : YES
 + params:

 | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
 | :------: | :-------: | :------: | :----:|
 | ticket_info | array   | Y | 优惠券信息（参考微信优惠券创建接口） |
 | sync | boolean | Y | 是否同步到微信|
 | end_at| date | Y | 过期时间
 | begin_at | date | Y | 开始时间 |

 + return data:
   ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{
                "discount": 10,
                "base_info":{
                    "sku":{
                      "quantity": 50000000
                    },
                    "color": "Color010",
                    "title": "海底捞会员卡",
                    "notice": "使用时向服务员出示此券",
                    "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
                    "code_type": "CODE_TYPE_TEXT",
                    "date_info":{"type": "DATE_TYPE_PERMANENT"},
                    "get_limit": 3,
                    "brand_name": "海底捞",
                    "custom_url": "http://weixin.qq.com",
                    "description": "不可与其他优惠同享",
                    "promotion_url": "http://www.qq.com",
                    "service_phone": "020-88888888",
                    "can_give_friend": true,
                    "custom_url_name": "立即使用",
                    "use_custom_code": false,
                    "location_id_list":[123, 12321],
                    "need_push_on_view": true,
                    "promotion_url_name": "营销入口1",
                    "custom_url_sub_title": "6个汉字tips"
                },
                "bonus_rule":{
                    "reduce_money": 100,
                    "increase_bonus": 1,
                    "cost_bonus_unit": 5,
                    "cost_money_unit": 100,
                    "max_reduce_bonus": 50,
                    "max_increase_bonus": 200,
                    "init_increase_bonus": 10,
                    "least_money_to_use_bonus": 1000
                },
                "prerogative": "test_prerogative",
                "activate_url": "http://www.qq.com",
                "custom_cell1":{
                    "url": "http://www.xxx.com",
                    "name": "使用入口2",
                    "tips": "激活后显示"
                },
                "supply_bonus": true,
                "advanced_info":{
                "abstract":{
                    "abstract": "微信餐厅推出多种新季菜品，期待您的光临",
                    "icon_url_list":["http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw / 0 "…]
                },
                "time_limit":[
                {
                    "type": "MONDAY",
                    "end_hour": 10,
                    "begin_hour": 0,
                    "end_minute": 59,
                    "begin_minute": 10
                },
                {
                  "type": "HOLIDAY"
                }
                ],
                "use_condition":{
                    "accept_category": "鞋类",
                    "reject_category": "阿迪达斯",
                    "can_use_with_other_discount": true
                },
                "text_image_list":[
                {
                    "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                },
                {
                    "text": "此菜品迎合大众口味，老少皆宜，营养均衡",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sj piby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                }
                ],
                "business_service":[
                    "BIZ_SERVICE_FREE_WIFI",
                    "BIZ_SERVICE_WITH_PET",
                    "BIZ_SERVICE_FREE_PARK",
                    "BIZ_SERVICE_DELIVER"
                ]
                },
                "auto_activate": true,
                "custom_field1":{
                    "url": "http://www.qq.com",
                    "name_type": "FIELD_NAME_TYPE_LEVEL"
                },
                "supply_balance": false,
                "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/"
            },
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
    ```
   
   
   3. 代制团购券
    
   + route：host+/groupon/ticket
   + method: POST
   + auth : YES
   + params:

 | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
 | :------: | :-------: | :------: | :----:|
 | ticket_info | array   | Y | 优惠券信息（参考微信优惠券创建接口） |
 | sync | boolean | Y | 是否同步到微信|
 | end_at| date | Y | 过期时间
 | begin_at | date | Y | 开始时间 |

 + return data:
    ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{
                "discount": 10,
                "base_info":{
                    "sku":{
                      "quantity": 50000000
                    },
                    "color": "Color010",
                    "title": "海底捞会员卡",
                    "notice": "使用时向服务员出示此券",
                    "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
                    "code_type": "CODE_TYPE_TEXT",
                    "date_info":{"type": "DATE_TYPE_PERMANENT"},
                    "get_limit": 3,
                    "brand_name": "海底捞",
                    "custom_url": "http://weixin.qq.com",
                    "description": "不可与其他优惠同享",
                    "promotion_url": "http://www.qq.com",
                    "service_phone": "020-88888888",
                    "can_give_friend": true,
                    "custom_url_name": "立即使用",
                    "use_custom_code": false,
                    "location_id_list":[123, 12321],
                    "need_push_on_view": true,
                    "promotion_url_name": "营销入口1",
                    "custom_url_sub_title": "6个汉字tips"
                },
                "bonus_rule":{
                    "reduce_money": 100,
                    "increase_bonus": 1,
                    "cost_bonus_unit": 5,
                    "cost_money_unit": 100,
                    "max_reduce_bonus": 50,
                    "max_increase_bonus": 200,
                    "init_increase_bonus": 10,
                    "least_money_to_use_bonus": 1000
                },
                "prerogative": "test_prerogative",
                "activate_url": "http://www.qq.com",
                "custom_cell1":{
                    "url": "http://www.xxx.com",
                    "name": "使用入口2",
                    "tips": "激活后显示"
                },
                "supply_bonus": true,
                "advanced_info":{
                "abstract":{
                    "abstract": "微信餐厅推出多种新季菜品，期待您的光临",
                    "icon_url_list":["http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw / 0 "…]
                },
                "time_limit":[
                {
                    "type": "MONDAY",
                    "end_hour": 10,
                    "begin_hour": 0,
                    "end_minute": 59,
                    "begin_minute": 10
                },
                {
                  "type": "HOLIDAY"
                }
                ],
                "use_condition":{
                    "accept_category": "鞋类",
                    "reject_category": "阿迪达斯",
                    "can_use_with_other_discount": true
                },
                "text_image_list":[
                {
                    "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                },
                {
                    "text": "此菜品迎合大众口味，老少皆宜，营养均衡",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sj piby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                }
                ],
                "business_service":[
                    "BIZ_SERVICE_FREE_WIFI",
                    "BIZ_SERVICE_WITH_PET",
                    "BIZ_SERVICE_FREE_PARK",
                    "BIZ_SERVICE_DELIVER"
                ]
                },
                "auto_activate": true,
                "custom_field1":{
                    "url": "http://www.qq.com",
                    "name_type": "FIELD_NAME_TYPE_LEVEL"
                },
                "supply_balance": false,
                "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/"
            },
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
    ```
    
    4. 代制礼品券
    
     + route：host+/gift/ticket
     + method: POST
     + auth : YES
     + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | ticket_info | array   | Y | 优惠券信息（参考微信优惠券创建接口） |
         | sync | boolean | Y | 是否同步到微信|
         | end_at| date | Y | 过期时间
         | begin_at | date | Y | 开始时间 |
     
     + return data:
       ```json
        {
            "data":{
                "id": 1,
                "card_type": "member_card",
                "member_info":{
                    "discount": 10,
                    "base_info":{
                        "sku":{
                          "quantity": 50000000
                        },
                        "color": "Color010",
                        "title": "海底捞会员卡",
                        "notice": "使用时向服务员出示此券",
                        "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
                        "code_type": "CODE_TYPE_TEXT",
                        "date_info":{"type": "DATE_TYPE_PERMANENT"},
                        "get_limit": 3,
                        "brand_name": "海底捞",
                        "custom_url": "http://weixin.qq.com",
                        "description": "不可与其他优惠同享",
                        "promotion_url": "http://www.qq.com",
                        "service_phone": "020-88888888",
                        "can_give_friend": true,
                        "custom_url_name": "立即使用",
                        "use_custom_code": false,
                        "location_id_list":[123, 12321],
                        "need_push_on_view": true,
                        "promotion_url_name": "营销入口1",
                        "custom_url_sub_title": "6个汉字tips"
                    },
                    "bonus_rule":{
                        "reduce_money": 100,
                        "increase_bonus": 1,
                        "cost_bonus_unit": 5,
                        "cost_money_unit": 100,
                        "max_reduce_bonus": 50,
                        "max_increase_bonus": 200,
                        "init_increase_bonus": 10,
                        "least_money_to_use_bonus": 1000
                    },
                    "prerogative": "test_prerogative",
                    "activate_url": "http://www.qq.com",
                    "custom_cell1":{
                        "url": "http://www.xxx.com",
                        "name": "使用入口2",
                        "tips": "激活后显示"
                    },
                    "supply_bonus": true,
                    "advanced_info":{
                    "abstract":{
                        "abstract": "微信餐厅推出多种新季菜品，期待您的光临",
                        "icon_url_list":["http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw / 0 "…]
                    },
                    "time_limit":[
                    {
                        "type": "MONDAY",
                        "end_hour": 10,
                        "begin_hour": 0,
                        "end_minute": 59,
                        "begin_minute": 10
                    },
                    {
                      "type": "HOLIDAY"
                    }
                    ],
                    "use_condition":{
                        "accept_category": "鞋类",
                        "reject_category": "阿迪达斯",
                        "can_use_with_other_discount": true
                    },
                    "text_image_list":[
                    {
                        "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾",
                        "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                    },
                    {
                        "text": "此菜品迎合大众口味，老少皆宜，营养均衡",
                        "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sj piby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                    }
                    ],
                    "business_service":[
                        "BIZ_SERVICE_FREE_WIFI",
                        "BIZ_SERVICE_WITH_PET",
                        "BIZ_SERVICE_FREE_PARK",
                        "BIZ_SERVICE_DELIVER"
                    ]
                    },
                    "auto_activate": true,
                    "custom_field1":{
                        "url": "http://www.qq.com",
                        "name_type": "FIELD_NAME_TYPE_LEVEL"
                    },
                    "supply_balance": false,
                    "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/"
                },
                "app_id": "123456",
                "wechat_app_id": "wx581a7ad7ca810da6",
                "status": 0,
                "sync": 0,
                "created_at": null,
                "updated_at": null
            }
        }
    ```
    
    5. 优惠券列表
    
     + route：host+/tickets
     + method: GET
     + auth : YES
     + params:
    
         搜素：search=ticket_type,=;begin_at,>=;end_at,<;
     
     + return data:
```json
{
    "data":[
        {
            "id": 2,
            "color": "Color010",
            "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/",
            "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
            "card_type": "coupon_card",
            "brand_name": "海底捞",
            "code_type": "CODE_TYPE_TEXT",
            "title": "海底捞会员卡",
            "sku":{"quantity": 50000000},
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "ali_app_id": null,
            "status": 0,
            "sync": 0,
            "begin_at":{
                "date": "2018-01-10 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at":{
                "date": "2019-12-10 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "created_at":{
                "date": "2018-01-01 10:10:10.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
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

6. 更新优惠券
    
 + route：host+/ticket/{id}
 + method: PUT
 + auth : YES
 + params:

 | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
 | :------: | :-------: | :------: | :----:|
 | ticket_type| string | Y | 优惠券类型 |
 | ticket_info | array   | Y | 优惠券信息（参考微信优惠券创建接口） |
 | sync | boolean | Y | 是否同步到微信|
 | end_at| date | Y | 过期时间
 | begin_at | date | Y | 开始时间 |

 + return data:
   ```json
    {
        "data":{
            "id": 1,
            "card_type": "member_card",
            "member_info":{
                "discount": 10,
                "base_info":{
                    "sku":{
                      "quantity": 50000000
                    },
                    "color": "Color010",
                    "title": "海底捞会员卡",
                    "notice": "使用时向服务员出示此券",
                    "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
                    "code_type": "CODE_TYPE_TEXT",
                    "date_info":{"type": "DATE_TYPE_PERMANENT"},
                    "get_limit": 3,
                    "brand_name": "海底捞",
                    "custom_url": "http://weixin.qq.com",
                    "description": "不可与其他优惠同享",
                    "promotion_url": "http://www.qq.com",
                    "service_phone": "020-88888888",
                    "can_give_friend": true,
                    "custom_url_name": "立即使用",
                    "use_custom_code": false,
                    "location_id_list":[123, 12321],
                    "need_push_on_view": true,
                    "promotion_url_name": "营销入口1",
                    "custom_url_sub_title": "6个汉字tips"
                },
                "bonus_rule":{
                    "reduce_money": 100,
                    "increase_bonus": 1,
                    "cost_bonus_unit": 5,
                    "cost_money_unit": 100,
                    "max_reduce_bonus": 50,
                    "max_increase_bonus": 200,
                    "init_increase_bonus": 10,
                    "least_money_to_use_bonus": 1000
                },
                "prerogative": "test_prerogative",
                "activate_url": "http://www.qq.com",
                "custom_cell1":{
                    "url": "http://www.xxx.com",
                    "name": "使用入口2",
                    "tips": "激活后显示"
                },
                "supply_bonus": true,
                "advanced_info":{
                "abstract":{
                    "abstract": "微信餐厅推出多种新季菜品，期待您的光临",
                    "icon_url_list":["http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw / 0 "…]
                },
                "time_limit":[
                {
                    "type": "MONDAY",
                    "end_hour": 10,
                    "begin_hour": 0,
                    "end_minute": 59,
                    "begin_minute": 10
                },
                {
                  "type": "HOLIDAY"
                }
                ],
                "use_condition":{
                    "accept_category": "鞋类",
                    "reject_category": "阿迪达斯",
                    "can_use_with_other_discount": true
                },
                "text_image_list":[
                {
                    "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                },
                {
                    "text": "此菜品迎合大众口味，老少皆宜，营养均衡",
                    "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sj piby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                }
                ],
                "business_service":[
                    "BIZ_SERVICE_FREE_WIFI",
                    "BIZ_SERVICE_WITH_PET",
                    "BIZ_SERVICE_FREE_PARK",
                    "BIZ_SERVICE_DELIVER"
                ]
                },
                "auto_activate": true,
                "custom_field1":{
                    "url": "http://www.qq.com",
                    "name_type": "FIELD_NAME_TYPE_LEVEL"
                },
                "supply_balance": false,
                "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/"
            },
            "app_id": "123456",
            "wechat_app_id": "wx581a7ad7ca810da6",
            "status": 0,
            "sync": 0,
            "created_at": null,
            "updated_at": null
        }
    }
    ```