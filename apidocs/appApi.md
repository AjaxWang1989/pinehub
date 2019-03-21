# 应用创建与管理相关接口 
 1. 应用logo上传接口
     + url: host + /app/logo/{driver?}
     + http方法: POST
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
2. 创建应用
     + url: host + /app
     + http方法: POST
     + 参数:
     
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | logo | string | Y | logo url |
         | name  | string | N | 名称 |
         
     + http返回: 
     
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | data   |   array | { } |
         | message | string | 错误说明 ,出现错误才会出现 |
         | status_code | string | 错误码（一般是http标准码） |
         
         注释：
         
             1. json实例
     ```json
       {
         "data" : {
             "id" : "XXX",
             "name": "xxxxx",
             "logo": "xxxx",
             "wechat_app_id": "XX",
             "mini_app_id": "xxxx",
             "secret": "XXXX"
         }
       }
     ```
     
3. 更新应用
     + url: host + /app/{id}
     + http方法: PUT
     + 参数:
     
         | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
         | :------: | :-------: | :------: | :----:|
         | logo | string | Y | logo url |
         | name  | string | N | 名称 |
         
     + http返回: 
     
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | data   |   array | { } |
         | message | string | 错误说明 ,出现错误才会出现 |
         | status_code | string | 错误码（一般是http标准码） |
         
         注释：
         
             1. json实例
     ```json
       {
         "data" : {
             "id" : "XXX",
             "name": "xxxxx",
             "logo": "xxxx",
             "wechat_app_id": "XX",
             "mini_app_id": "xxxx",
             "secret": "XXXX"
         }
       }
     ```     
     
3. 展示应用
     + url: host + /app/{id}
     + http方法: GET
     + 参数:
     
        无参数
         
     + http返回: 
     
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | data   |   array | { } |
         | message | string | 错误说明 ,出现错误才会出现 |
         | status_code | string | 错误码（一般是http标准码） |
         
         注释：
         
             1. json实例
     ```json
       {
         "data" : {
             "id" : "XXX",
             "name": "xxxxx",
             "logo": "xxxx",
             "wechat_app_id": "XX",
             "mini_app_id": "xxxx",
             "secret": "XXXX"
         }
       }
     ```   
     
 4. 删除应用
      + url: host + /app/{id}
      + http方法: DELETE
      + 参数:
      
         无参数
          
      + http返回: 
      
          | 数据名称 | 数据类型 | 说明 |
          | :-------: | :------: | :---: |
          | data   |   array | { } |
          | message | string | 错误说明 ,出现错误才会出现 |
          | status_code | string | 错误码（一般是http标准码） |
          
          注释：
          
              1. json实例
      ```json
        {
          "data" : {
              "delete_count" : "XXX"
          }
        }
      
      ``` 
5. 获取应用列表
    + url: host + /apps
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
        
            1. 可搜索字段name(like) 
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
   | name | string |  |
   | logo | string |    |
   | wechat_app_id | string| |
   | mini_app_id| string | |
   |secret | string| |
   
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
   
       