# 店铺管理接口
1. 添加（创建）店铺
   
    + route: host + /shop
    + method: POST
    + params:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | name | string | N | 店铺名称名，长度32|
        | user_id | int | Y | 店主id，特殊必填，当manager_mobile字段填写时，可选|
        | description | string | N | 店铺描述| 
        | country_id | int | Y | 国家ID|
        | province_id| int | Y | 省份ID|
        | city_id | int | Y | 城市id|
        | county_id | int | Y | 区县id|
        | address | string | Y | 店铺地址|
        | lng | float| Y |  纬度 |
        | lat | float| Y |  经度 |
        | manager_mobile | string | N |店主手机与user_id互斥二选一（特殊必填）|
        | manager_name | string | N | 店主姓名与manager_mobile一起|
        | status | int | Y | ['integer', 'in:0,1,2,3'] 状态：0-等待授权 1-营业中 2-休业 3-封锁店铺|
        
    + return data: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array |  |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
        ```json
            {
                "data":{
                    "id": 1,
                    "name": "中国包子",
                    "country": "中国",
                    "province": "安徽",
                    "city": "合肥",
                    "county": "高新区",
                    "address": "柠溪路",
                    "manager": {
                        "id": 1,
                        "nickname": "XXXX",
                        "real_name": "XXXX",
                        "mobile": "XXXXXX",
                        "user_name": "XXXX"
                    },
                    "description": "XXXXXXXXXXXXX",
                    "total_amount": 10000,
                    "today_amount": 100,
                    "total_off_line_amount": 100,
                    "today_off_line_amount": 100,
                    "total_ordering_amount": 100,
                    "today_ordering_amount": 100,
                    "total_order_write_off_amount": 100,
                    "today_order_write_off_amount": 100,
                    "total_ordering_num": 100,
                    "today_ordering_num": 100,
                    "total_order_write_off_num": 100,
                    "today_order_write_off_num": 100,
                    "status": 1,
                    "created_at":{
                        "date": "2018-07-03 01:49:05.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "updated_at":{
                        "date": "2018-07-03 01:49:05.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        ```
2. 店铺列表

    + url: host + /shops
    + http方法: GET
    + 参数:
     
        注释：
        查询参数
        ```
        [
                'name' => 'like',
                'status' => '=',
                'country.name' => 'like',
                'province.name' => 'like',
                'city.name' => 'like',
                'county.name' => 'like',
                'country_id' => '=',
                'city_id' => '=',
                'province_id' => '=',
         ]
         ```
            
    + http返回: 
        
      | 数据名称 | 数据类型 | 说明 |
      | :-------: | :------: | :---: |
      | data   |   array | 列表数组 |
      | meta | array | 分页信息,其他附加信息 |
      | message | string | 错误说明 ,出现错误才会出现 |
      | status_code | string | 错误码（一般是http标准码） |
          
    ```json
    {
        "data":[
        {
            "id": 1,
            "country": "中国",
            "province": "安徽省",
            "city": "合肥市",
            "county": "瑶海区",
            "address": "gwerrqrwerqw",
            "manager": "Miss Angela Conn",
            "total_amount": 0,
            "today_amount": 0,
            "status": 0,
            "created_at":{
                "date": "2018-07-03 01:49:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at":{
                "date": "2018-07-03 01:49:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
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
3. 修改店铺
   
    + url: host + /shop/{id}
    + http方法: PUT
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | name | string | N | 店铺名称名，长度32|
        | user_id | int | N | 店主id，特殊必填，当manager_mobile字段填写时，可选|
        | description | string | N | 店铺描述| 
        | country_id | int | N | 国家ID|
        | province_id| int | N | 省份ID|
        | city_id | int | N | 城市id|
        | county_id | int | N | 区县id|
        | address | string | N | 店铺地址|
        | lng | float| N |  纬度 |
        | lat | float| N |  经度 |
        | manager_mobile | string | N |店主手机与user_id互斥二选一（特殊必填）|
        | manager_name | string | N | 店主姓名与manager_mobile一起|
        | status | int | N | ['integer', 'in:0,1,2,3'] 状态：0-等待授权 1-营业中 2-休业 3-封锁店铺|
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array |  |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
            {
                "data":{
                    "id": 1,
                    "name": "中国包子",
                    "country": "中国",
                    "province": "安徽",
                    "city": "合肥",
                    "county": "高新区",
                    "address": "柠溪路",
                    "manager": {
                        "id": 1,
                        "nickname": "XXXX",
                        "real_name": "XXXX",
                        "mobile": "XXXXXX",
                        "user_name": "XXXX"
                    },
                    "description": "XXXXXXXXXXXXX",
                    "total_amount": 10000,
                    "today_amount": 100,
                    "total_off_line_amount": 100,
                    "today_off_line_amount": 100,
                    "total_ordering_amount": 100,
                    "today_ordering_amount": 100,
                    "total_order_write_off_amount": 100,
                    "today_order_write_off_amount": 100,
                    "total_ordering_num": 100,
                    "today_ordering_num": 100,
                    "total_order_write_off_num": 100,
                    "today_order_write_off_num": 100,
                    "status": 1,
                    "created_at":{
                        "date": "2018-07-03 01:49:05.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "updated_at":{
                        "date": "2018-07-03 01:49:05.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
    ```