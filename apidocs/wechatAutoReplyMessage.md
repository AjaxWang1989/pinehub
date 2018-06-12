# 微信公众号自动回复
1. 添加微信公众号自动回复数据
    + url: host + /wechat/auto_reply_message
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | app_id | string | Y | 微信公众号appid或者小程序appid，wx开头的十八字符串|
        | type | string | Y | ('text','image','video','news','voice') '类型'|
        | prefect_match_keywords | array | N |  '全匹配关键字数组' |
        | semi_match_keywords | array | N | 半匹配关键字数组 |
        | content | string | Y | 回复消息内容 |
        
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
            "type": "news",
            "prefect_match_keywords": [],
            "semi_match_keywords": [],
            "content": "",
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
        
2. 获取指定公众号自动回复列表
    + url: host + /wechat/auto_reply_messages?app_id={appid}
    + http方法: GET
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :-----: | :-----: | :---------: | :---: |
        | page  | int | N | 页数默认1 |
        | limit | int | N | 每一页数据条数 默认15 |
            
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
   | id | int | | 
   | focus_reply | boolean | '关注回复' |
   | app_id | string | 微信app ID |
   | type | string | ('text','image','video','news','voice')  '类型'|
   | prefect_match_keywords | array | '全匹配关键字数组' |
   | semi_match_keywords | array | '半匹配关键字数组'|
   | content | string |  '回复消息内容',
   
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
                "type": "news",
                "focus_reply": false,
                "prefect_match_keywords": ["key"], 
                "semi_match_keywords": ["word"], 
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
 3. 修改微信公众号自动回复数据
     + url: host + /wechat/auto_reply_message/{id}
     + http方法: PUT
     + 参数:
     
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:| 
         | type | string | Y | ('text','image','video','news','voice') '类型'|
         | prefect_match_keywords | array | N |  '全匹配关键字数组' |
         | semi_match_keywords | array | N | 半匹配关键字数组 |
         | content | string | Y | 回复消息内容 |
         
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
             "type": "news",
             "prefect_match_keywords": [],
             "semi_match_keywords": [],
             "content": "",
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
