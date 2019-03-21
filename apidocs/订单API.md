# 订单管理接口

- 订单列表查询接口
        
   + route：host+/orders
   + method: GET
   + auth : YES
   + params:
   
      | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
      | :------: | :-------: | :------: | :----:|
      | begin_at | date | N | 下单时间（开始）|
      | end_at | date | N | 下单结束时间|
      
      search 字段可取值 status,=;pay_type,=;type,=;buyer_user_id,=;buyer.mobile,=;code,=

   + return data:
   ```json
    {
        "data":[
            {
                  "id": 1,
                  "transaction_id": "123123",
                  "order_items":[
                      {
                          "name": "收拾收拾",
                          "merchandise_id": 1,
                          "sku_product_id": 1,
                          "main_image": "23123",
                          "sell_price": 9,
                          "quality": 1,
                          "code": "123123",
                          "total_amount": 10,
                          "payment_amount": 10,
                          "discount_amount": 0,
                          "status": 10,
                          "shop":{"id": 1, "name": "sdfa"}
                      }
                  ],
                  "code": "132123",
                  "buyer":{
                      "id": 1,
                      "nickname": null,
                      "mobile": "18790908768"
                  },
                  "payment_amount": 10,
                  "paid_at":{
                      "date": "2018-04-18 09:45:12.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                  },
                  "pay_type": "WECHAT_PAY",
                  "status": 10,
                  "type": 0,
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
                
- 订单退款接口
    
    + route：host+/order/{id}/refund
    + method: POST
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | reason     | string   | N | 退款原因 |
         | type | int | N | 退款类型 0-退款 1-退货 3-|
    
    + return data:
    
- 订单关闭接口
    
    + route：host+/order/{id}/cancel
    + method: PUT
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | reason     | string   | N | 退款原因 |
    
    + return data:
    
- 订单发货接口
        
    + route：host+/order/{id}/sent
    + method: PUT
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | post_type | int   | Y | 退款原因 | 0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运|
         | post_no   | string | Y | 快递单号 |
         | post_name | string | Y | 快递公司 |
    
    + return data:
    ```json
        {
            "data":{
                "id": 1,
                "order_item":[
                    {
                        "name": "收拾收拾",
                        "merchandise_id": 1,
                        "sku_product_id": 1,
                        "main_image": "23123",
                        "sell_price": 9,
                        "quality": 1,
                        "origin_price": 10,
                        "cost_price": 6,
                        "code": "123123",
                        "total_amount": 10,
                        "payment_amount": 10,
                        "discount_amount": 0,
                        "signed_at": null,
                        "consigned_at": null,
                        "status": 10,
                        "shop":{"id": 1, "name": "sdfa"},
                        "merchandise_stock_num": 1000,
                        "sku_product_stock_num": 100
                    }
                ],
                "code": "132123",
                "buyer":{
                    "id": 1,
                    "nickname": null,
                    "mobile": "18790908768"
                },
                "total_amount": 10,
                "payment_amount": 10,
                "discount_amount": 0,
                "paid_at":{
                    "date": "2018-04-18 09:45:12.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "pay_type": "WECHAT_PAY",
                "status": 10,
                "cancellation": 0,
                "signed_at": null,
                "consigned_at": null,
                "post_no": null,
                "post_code": null,
                "post_name": null,
                "receiver_city": "qweqe",
                "receiver_district": "qweqw",
                "receiver_address": "qweqw",
                "type": 0,
                "transaction_id": "123123",
                "created_at":{
                    "date": "2018-01-01 10:10:10.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updated_at": null
            }
        }

    ```
            
- 订单备注接口