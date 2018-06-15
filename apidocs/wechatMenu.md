# 微信菜单接口
1. 添加菜单
    + url: host + /wechat/menu
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | app_id | string | Y | 微信公众号appid或者小程序appid，wx开头的十八字符串|
        | menus | array | Y | 菜单数据 |
        | name  | string | N | 菜单名称 |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id,menus } |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "id": 1,
            "app_id": "wx1231234567891230",
            "menus":{
                 "button":[
                   {    
                       "type":"click",
                       "name":"今日歌曲",
                       "key":"V1001_TODAY_MUSIC"
                    },
                    {
                       "name":"菜单",
                       "sub_button":[
                    {    
                        "type":"view",
                        "name":"搜索",
                        "url":"http://www.soso.com/"
                     },
                     {
                          "type":"miniprogram",
                          "name":"wxa",
                          "url":"http://mp.weixin.qq.com",
                          "appid":"wx286b93c14bbf93aa",
                          "pagepath":"pages/lunar/index"
                      },
                     {
                        "type":"click",
                        "name":"赞一下我们",
                        "key":"V1001_GOOD"
                     }]
                }]
            }, 
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
        2. menus
    ```json
    {
         "button":[
           {    
               "type":"click",
               "name":"今日歌曲",
               "key":"V1001_TODAY_MUSIC"
            },
            {
               "name":"菜单",
               "sub_button":[
            {    
                "type":"view",
                "name":"搜索",
                "url":"http://www.soso.com/"
             },
             {
                  "type":"miniprogram",
                  "name":"wxa",
                  "url":"http://mp.weixin.qq.com",
                  "appid":"wx286b93c14bbf93aa",
                  "pagepath": "pages/lunar/index"
              },
             {
                "type":"click",
                "name":"赞一下我们",
                "key":"V1001_GOOD"
             }]
        }]
    }
    ```
        
2. 获取菜单列表
    + url: host + /wechat/menus
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
        
            1. 可搜索字段app_id(like) 
            2. like表示模糊匹配 = 表示全匹配
            
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
   | menus | array |   菜单信息 |
   
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
               "menus": {
                     "button":[
                       {    
                           "type":"click",
                           "name":"今日歌曲",
                           "key":"V1001_TODAY_MUSIC"
                        },
                        {
                           "name":"菜单",
                           "sub_button":[
                               {    
                                  "type":"view",
                                  "name":"搜索",
                                   "url":"http://www.soso.com/"
                                },
                                {
                                   "type":"miniprogram",
                                   "name":"wxa",
                                   "url":"http://mp.weixin.qq.com",
                                   "appid":"wx286b93c14bbf93aa",
                                   "pagepath":"pages/lunar/index"
                                },
                               {
                                    "type":"click",
                                    "name":"赞一下我们",
                                    "key":"V1001_GOOD"
                               }
                            ]
                        }
                     ]
                }, 
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
            
3. 获取指定微信菜单信息

    + url: host + /wechat/menu/{id}
    + http方法: GET
    + 参数:
    
       无参数 
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id, menus, create_ad, update_at} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "id": 1,
            "app_id": "wx1231234567891230",
            "menus": {
                "button":[
                    {    
                        "type":"click",
                        "name":"今日歌曲",
                        "key":"V1001_TODAY_MUSIC"
                     },
                     {
                        "name":"菜单",
                        "sub_button":[
                            {    
                               "type":"view",
                               "name":"搜索",
                                "url":"http://www.soso.com/"
                             },
                             {
                                "type":"miniprogram",
                                "name":"wxa",
                                "url":"http://mp.weixin.qq.com",
                                "appid":"wx286b93c14bbf93aa",
                                "pagepath":"pages/lunar/index"
                             },
                            {
                                 "type":"click",
                                 "name":"赞一下我们",
                                 "key":"V1001_GOOD"
                            }
                         ]
                     }
                 ]
            },
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
4. 修改指定微信菜单
 
    + url: host + /wechat/menu/{id}
    + http方法: PUT
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:| 
        | menus | array | N | 菜单数据 |
        | name | string | N | 菜单名称 |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id, menus, create_ad, update_at} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "id": 1,
            "app_id": "wx1231234567891230",
            "menus": {
                "button":[
                    {    
                        "type":"click",
                        "name":"今日歌曲",
                        "key":"V1001_TODAY_MUSIC"
                     },
                     {
                        "name":"菜单",
                        "sub_button":[
                            {    
                               "type":"view",
                               "name":"搜索",
                                "url":"http://www.soso.com/"
                             },
                             {
                                "type":"miniprogram",
                                "name":"wxa",
                                "url":"http://mp.weixin.qq.com",
                                "appid":"wx286b93c14bbf93aa",
                                "pagepath":"pages/lunar/index"
                             },
                            {
                                 "type":"click",
                                 "name":"赞一下我们",
                                 "key":"V1001_GOOD"
                            }
                         ]
                     }
                 ]
            },
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
    
5. 菜单数据发布到微信公众号

    + url: host + /wechat/menu/{id}/sync
    + http方法: GET
    + 参数:
        
        无参数
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | message | string | 同步结果 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "message": "XXXXX"
        }
    }
    ```
 
 6. 删除微信菜单
 
     + url: host + /wechat/menu/{id}
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
     
7. 批量删除微信菜单
   
       + url: host + /wechat/menus
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