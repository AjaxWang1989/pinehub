# 微信公众号或者小程序管理接口文档
1. 添加微信公众号或者小程序配置
    + url: host + /wechat/config
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | app_id | string | Y | 微信公众号appid或者小程序appid，wx开头的十八字符串|
        | app_name | string | Y | 小程序或者公众号名称 长度限制255位|
        | app_secret | string | Y | 微信公众号或者小程序secret，32位字符串 |
        | mode | string | Y | 微信公众号模式，取之位editor，developer|
        | type | string | Y | app类型，小程序，公众号，三方应用，<br>取值wechat_mini_program,wechat_official_account,<br>wechat_open_platform|
        | token | string | N | 公众号开发者token,32位字符串，<br>mode为developer时必填|
        | aes_key | string | N | 微信开发者aes key，43位字符串，<br>mode为developer时必填|
        | wechat_bind_app | string | N | 微信绑定程序，取值greenKey，takeOut |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id,app_name,app_secret,token, aes_key, type, <br>mode, wechat_bind_app, create_ad, update_at} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "id": 1,
            "app_id": "wx1231234567891230",
            "app_name": "mmmss",
            "app_secret": "12345678912345678901203020301256",
            "token": "12345678912345678901203020301256",
            "aes_key": "12345678912345678901203020301256xcdfghjklnb",
            "type": "wechat_mini_program",
            "mode": "editor",
            "created_at": {
                "date": "2018-06-08 09:38:35.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-06-09 02:16:23.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    }
    ```
        
2. 获取公众号或者小程序配置列表
    + url: host + /wechat/configs
    + http方法: GET
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :-----: | :-----: | :---------: | :---: |
        | page  | int | N | 页数默认1 |
        | limit | int | N | 每一页数据条数 默认15 |
        | search | string | N | 查询字段search=John或者search=name:John Doe;<br>email:john@gmail.com，第二种是表示多字段多值查询 |
        | searchField | string | N| 查询字段以及匹配方式,与search配合使用。<br>search=John&searchField=name:=;nickname:like;|
        | searchJoin | string | N | 查询条件是and还是or查询 |
        | sortedBy | string | N | 排序字段，取值desc 降序，asc 升序|
        | orderBy | string | N | 1、orderBy=id按id排<br>2、orderBy=posts&#124;title,posts关联title作为排序字段<br>3、orderBy=posts:custom_id&#124;posts.title，<br>关联字段posts的custom_id,排序字段posts的title|
        
        注释：
        
            1. 可搜索字段app_id(like) mode(=) type(=) wechat_bind_app(=)
            2. like表示模糊匹配 = 表示全匹配
            3. mode，type，wechat_bind_app参考接口（1）
            
    + http返回: 
        
      | 数据名称 | 数据类型 | 说明 |
      | :-------: | :------: | :---: |
      | data   |   array | 列表数组 |
      | meta | array | 分页信息,其他附加信息 |
      | message | string | 错误说明 ,出现错误才会出现 |
      | status_code | string | 错误码（一般是http标准码） |
          
    注释：
    
        1. data数组元素
                
   | 数据名称 | 类型 | 说明 |
   | :----:| :---: | :---: |
   | app_id | string | 微信公众号或者小程序appid |
   | app_name | string | 微信小程序名称 |
   | mode   | string | 模式 |
   | type | string | 应用类型 |
   |wechat_bind_app| string | 绑定应用 |
   
        2. meta附加信息
         
   ```json
     {
        "meta":{
           "pagination":{
                "total": 5,
                "count": 5,
                "per_page": 15,
                "current_page": 1,
                "total_pages": 1,
                "links":[]
           }
         }
      }
   ```
   
        3. json 实例：
        
   ```json
   {
       "data": [
           {
               "id": 1,
               "app_id": "wx1231234567891230",
               "app_name": "mmmss",
               "mode": "editor",
               "type": "wechat_mini_program",
               "wechat_bind_app": "sac",
               "created_at": {
                   "date": "2018-06-08 09:38:35.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               },
               "updated_at": {
                   "date": "2018-06-09 02:16:23.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               }
           },
           {
               "id": 2,
               "app_id": "wx1231234567891230",
               "app_name": "kjlaklsfd",
               "mode": "editor",
               "type": "wechat_official_account",
               "wechat_bind_app": "greenKey",
               "created_at": {
                   "date": "2018-06-08 09:55:05.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               },
               "updated_at": {
                   "date": "2018-06-09 02:16:38.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               }
           },
           {
               "id": 3,
               "app_id": "wx1231234567891230",
               "app_name": null,
               "mode": "developer",
               "type": "wechat_official_account",
               "wechat_bind_app": "greenKey",
               "created_at": {
                   "date": "2018-06-08 09:56:28.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               },
               "updated_at": {
                   "date": "2018-06-08 09:56:28.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               }
           },
           {
               "id": 4,
               "app_id": "wx1231234567891230",
               "app_name": null,
               "mode": "developer",
               "type": "wechat_official_account",
               "wechat_bind_app": "greenKey",
               "created_at": {
                   "date": "2018-06-08 09:56:55.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               },
               "updated_at": {
                   "date": "2018-06-08 09:56:55.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               }
           },
           {
               "id": 5,
               "app_id": "wx1111111111111111",
               "app_name": null,
               "mode": "editor",
               "type": "wechat_official_account",
               "wechat_bind_app": "takeOut",
               "created_at": {
                   "date": "2018-06-08 10:43:36.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               },
               "updated_at": {
                   "date": "2018-06-08 10:43:36.000000",
                   "timezone_type": 3,
                   "timezone": "UTC"
               }
           }
       ],
       "meta": {
           "pagination": {
               "total": 5,
               "count": 5,
               "per_page": 15,
               "current_page": 1,
               "total_pages": 1,
               "links": [
               ]
           }
       }
   }
   ```
            
3. 获取指定公众号或者小程序信息

    + url: host + /wechat/config/{id}
    + http方法: GET
    + 参数:
    
       无参数 
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id,app_name,app_secret,token, aes_key, type, <br>mode, wechat_bind_app, create_ad, update_at} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "id": 1,
            "app_id": "wx1231234567891230",
            "app_name": "mmmss",
            "app_secret": "12345678912345678901203020301256",
            "token": "12345678912345678901203020301256",
            "aes_key": "12345678912345678901203020301256xcdfghjklnb",
            "type": "wechat_mini_program",
            "mode": "editor",
            "created_at": {
                "date": "2018-06-08 09:38:35.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-06-09 02:16:23.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    }
    ```
4. 修改指定公众号或者小程序信息
 
    + url: host + /wechat/config/{id}
    + http方法: PUT
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:| 
        | app_name | string | N | 小程序或者公众号名称 长度限制255位|
        | app_secret | string | N | 微信公众号或者小程序secret，32位字符串 |
        | mode | string | N | 微信公众号模式，取之位editor，developer|
        | type | string | N | app类型，小程序，公众号，三方应用，<br>取值wechat_mini_program,wechat_official_account,<br>wechat_open_platform|
        | token | string | N | 公众号开发者token,32位字符串，<br>mode为developer时必填|
        | aes_key | string | N | 微信开发者aes key，43位字符串，<br>mode为developer时必填|
        | wechat_bind_app | string | N | 微信绑定程序，取值greenKey，takeOut |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id,app_name,app_secret,token, aes_key, type, <br>mode, wechat_bind_app, create_ad, update_at} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "id": 1,
            "app_id": "wx1231234567891230",
            "app_name": "mmmss",
            "app_secret": "12345678912345678901203020301256",
            "token": "12345678912345678901203020301256",
            "aes_key": "12345678912345678901203020301256xcdfghjklnb",
            "type": "wechat_mini_program",
            "mode": "editor",
            "created_at": {
                "date": "2018-06-08 09:38:35.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-06-09 02:16:23.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    }
    ```
    
 5. 删除配置信息
 
     + url: host + /wechat/config/{id}
     + http方法: DELETE
     + 参数:
     
        无参数
         
     + http返回: 
     
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | deleted   |   int | 删除数量 |
         | message | string | 错误说明 ,出现错误才会出现 |
         | status_code | string | 错误码（一般是http标准码） |
         
         注释：
         
             1. json实例
     ```json
     {
         "data": {
             "deleted": 1,
             "message": "XXXX"
         }
     }
     ```
     
   6. 批量删除配置信息
   
       + url: host + /wechat/configs
       + http方法: DELETE
       + 参数:
       
          | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
          | :------: | :-------: | :------: | :----:| 
          | ids | array | Y | id数组 | 
           
       + http返回: 
       
           | 数据名称 | 数据类型 | 说明 |
           | :-------: | :------: | :---: |
           | deleted   |   int | 删除数量 |
           | message | string | 错误说明 ,出现错误才会出现 |
           | status_code | string | 错误码（一般是http标准码） |
           
           注释：
           
               1. json实例
       ```json
       {
           "data": {
               "deleted": 1,
               "message": "XXXX"
           }
       }
       ```