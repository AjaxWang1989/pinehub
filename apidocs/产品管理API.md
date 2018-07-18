1. 产品分类（分组、品类）列表

    + route：host+/categories
    + method: GET
    + auth : NO
    + params:
    
        搜索条件：name，like;
        
    + return data:
    
        ```json
            {
                "data":[
                   {
                       "id": 1,
                       "name": "",
                       "icon": "",
                       "updated_at": null,
                       "created_at":{
                           "date": "2018-06-22 07:09:10.000000",
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
        
2. 添加品类

    + route：host+/category
    + method: POST
    + auth : YES
    + params:
    
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | name     | string   | Y | 分类名称 |
         | icon | string | N | 分类图标 |
         
    + return data:
    ```json
        {
            "data":{
                "id": 1,
                "name": "",
                "icon": "",
                "created_at":{
                    "date": "2018-06-22 07:09:10.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        }
    ```
3. 商品图片上传 

    + route：host+/merchandise/image/{driver?}
    + method: POST
    + auth : YES
     + 参数:
         driver 可选参数（当不填写时图片上传到服务器文件系统，当填写cloud时上传到云端）
         
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | file_filed | string | N | 前端上传文件时文件数据对应的key值，即html input上传时name对应的数据，默认是file |
         | file_field的取值 | stream | N | 文件流数据(文件长宽比1/1，大小小于2M) | 
         
     + http返回: 
     
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | data   |   array | {id, name, type, path, endpoint, bucket, extension, src, encrypt, encrypt_key, encrypt_method, driver} |
         | message | string | 错误说明 ,出现错误才会出现 |
         | status_code | string | 错误码（一般是http标准码） |
         
         注释：
         
             1. json实例
       ```json
         {
            "data" : {
                "id" : 9,
                "name" : "XXXX.png",
                "type": "image/png",
                "path" : "XXXXX",
                "endpont" : "xxxx",
                "bucket" : "XXXXX",
                "extension" : "XXXX",
                "src" : "XXXXXX",
                "encrypt": 0,
                "encrypt_key" : null,
                "encrypt_method": null,
                "driver": "oss"
            },
            "meta" :{
                
            }
         }
      ```
      
 4. 添加商品
 
     + route：host+/merchandise
     + method: POST
     + auth : YES
     + params:
     
          | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
          | :------: | :-------: | :------: | :----:|
          | categories     | array   | Y | 分类id数组 |
          | name | string | Y | 产品名称 |
          |main_image| string | Y | 主图url|
          |images| array| Y| banner 图数组|
          | preview| string| Y| 简介  |
          | detail | string| Y | 详情 |
          | origin_price| float|Y| 原价|
          | sell_price| float | Y | 售价 |
          | cost_price| float | N | 成本 |
          | factory_price | float| N| 工厂价|
          | stock_num| int |  Y | 库存|
          | status | int | Y | 上下架状态 0-下架 1-上架|
          
     + return data:
     ```json
         {
             "data":{
             }
         }
     ```
     
5. 添加商品
 
     + route：host+/merchandise/{id}
     + method: PUT
     + auth : YES
     + params:
     
          | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
          | :------: | :-------: | :------: | :----:|
          | categories     | array   | Y | 分类id数组 |
          | name | string | Y | 产品名称 |
          |main_image| string | Y | 主图url|
          |images| array| Y| banner 图数组|
          | preview| string| Y| 简介  |
          | detail | string| Y | 详情 |
          | origin_price| float|Y| 原价|
          | sell_price| float | Y | 售价 |
          | cost_price| float | N | 成本 |
          | factory_price | float| N| 工厂价|
          | stock_num| int |  Y | 库存|
          | status | int | Y | 上下架状态 0-下架 1-上架|
          
     + return data:
     ```json
         {
             "data":{
             }
         }
     ```
     
6. 商品列表
 
     + route：host+/merchandises
     + method: GET
     + auth : YES
     + params:     
             
           搜索条件：name,like;code,=;status,=;county,=;
           
     + return data:
     ```json
         {
             "data":{
             }
         }
     ```
     
7. 商品展示
 
     + route：host+/merchandise/{id}
     + method: GET
     + auth : YES
     + params:     
                     
     + return data:
     ```json
         {
             "data":{
             }
         }
     ```