# 微信素材管理接口
1. 添加临时素材
    + url: host + /wechat/media/temporary?app_id={appid}
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | app_id | string | Y | 微信公众号appid或者小程序appid，wx开头的十八字符串|
        | file_field | string | Y | 文件字段的名称（input的name字段） |
        | input的name字段 | stream(文件流) | http文件上传数据流 |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
             "type":"TYPE",
             "media_id":"MEDIA_ID",
             "created_at":123456789
        }
    }
    ```
          
2.  永久图文素材
    + url: host + /wechat/material/article?app_id={appid}
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :-----: | :-----: | :---------: | :---: |
        | title	| string | Y |	标题 |
        | thumb_media_id | string |	Y	| 图文消息的封面图片素材id（必须是永久mediaID）|
        | author | string | N | 作者 |
        | digest | string |	N | 图文消息的摘要，仅有单图<br>文消息才有摘要，多图文此处为空。如果<br>本字段为没有填写，则默认抓取正文前64个字。
        | show_cover_pic |	boolean | Y | 是否显示封面，0为false，<br>即不显示，1为true，即显示|
        | content | string | Y | 图文消息的具体内容，支持HTML标签，<br>必须少于2万字符，小于1M，且此处会去除JS,<br>涉及图片url必须来源 "上传图文消息内的图片获<br>取URL"接口获取。外部图片url将被过滤。
        | content_source_url | string | Y | 图文消息的原文地址，即点击“阅读原文”后的URL
        | need_open_comment（新增字段）| boolean/int | Y | 是否打开评论，0不打开，1打开 |
        | only_fans_can_comment（新增字段）| boolean/int | Y |		是否粉丝才可评论，0所有人可评论，1粉丝才可评论 |
            
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
   | type | string |   素材类型 |
   | media_id | string | 素材id |
   
        2. json 实例：
        
   ```json
   {
       "data":{
               "type": "news",
               "app_id": "wx1231234567891230",
               "media_id": "1324234"
               
           }
   }
   ```
            
3. 上传永久性图片、视频、音频素材

    + url: host + /wechat/{type}/material?app_id={appId}
    + http方法: POST
    + 参数:
    
        type: image、video、voice
        
       | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
       | :------: | :-------: | :------: | :----:|
       | app_id | string | Y | 微信公众号appid或者小程序appid，wx开头的十八字符串|
       | file_field | string | Y | 文件字段的名称（input的name字段） |
       | input的name字段 | stream(文件流) | http文件上传数据流 |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {url} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
             "url": "xxxxx"
           } 
    }
    ```
4. 统计素材
 
    + url: host + /wechat/material/stats?app_id={app_id}
    + http方法: GET
    + 参数:
    
       无参数 
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | voice_count | int | 语音总数量|
        | video_count | int | 视频总数量 |
        | image_count |	int | 图片总数量 |
        | news_count |	int | 图文总数量 |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "voice_count": 10,
             "video_count": 10,
             "image_count": 10,
             "news_count": 10
        }
    }
    ```
    
5. 获取素材列表

    + url: host + /wechat/materials?app_id={appid}
    + http方法: GET
    + 参数:
        
       | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
       | :------: | :-------: | :------: | :----:|
       | type | string | Y | 素材类型 image、video、voice、news |
       | page | int | N | 分页数据页码（默认第一页） |
       | limit | int | N | 分页数据每一页数据条数（默认15）|
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | total_count | int | 素材总数 |
        | item_count | int | 当前页素材数量 |
        | item | array | 素材数据 |
        
        注释：
        
            1. json实例 图文
    ```json 
    {
       "total_count": TOTAL_COUNT,
       "item_count": ITEM_COUNT,
       "item": [{
           "media_id": MEDIA_ID,
           "content": {
               "news_item": [{
                   "title": TITLE,
                   "thumb_media_id": THUMB_MEDIA_ID,
                   "show_cover_pic": SHOW_COVER_PIC(0 / 1),
                   "author": AUTHOR,
                   "digest": DIGEST,
                   "content": CONTENT,
                   "url": URL,
                   "content_source_url": CONTETN_SOURCE_URL
               },
               //多图文消息会在此处有多篇文章
               ]
            },
            "update_time": UPDATE_TIME
        },
        //可能有多个图文消息item结构
      ]
    }

    ```
        2. 图片、视频、音频
    ```json 
    {
       "total_count": TOTAL_COUNT,
       "item_count": ITEM_COUNT,
       "item": [{
           "media_id": MEDIA_ID,
           "name": NAME,
           "update_time": UPDATE_TIME,
           "url":URL
       },
       //可能会有多个素材
       ]
    }
    ```
    
6. 图文素材修改
 
    + url: host + /wechat/material/article/{mediaId}?app_id={app_id}
    + http方法: PUT
    + 参数:
    
       mediaId:素材id
       
       | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
       | :-----: | :-----: | :---------: | :---: |
       | article | array | Y | 图文素材数据 |
       | index | int | N | 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0 |
       
       注释：article数据结构
            
          | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
          | :-----: | :-----: | :---------: | :---: |
          | title	| string | Y |	标题 |
          | thumb_media_id | string | Y | 图文消息的封面图片素材id（必须是永久mediaID）|
          | author | string | N | 作者 |
          | digest | string | N | 图文消息的摘要，仅有单图<br>文消息才有摘要，多图文此处为空。如果<br>本字段为没有填写，则默认抓取正文前64个字。
          | show_cover_pic |	boolean | Y | 是否显示封面，0为false，<br>即不显示，1为true，即显示|
          | content | string | Y | 图文消息的具体内容，支持HTML标签，<br>必须少于2万字符，小于1M，且此处会去除JS,<br>涉及图片url必须来源 "上传图文消息内的图片获<br>取URL"接口获取。外部图片url将被过滤。
          | content_source_url | string | Y | 图文消息的原文地址，即点击“阅读原文”后的URL
          | need_open_comment（新增字段）| boolean/int | N | 是否打开评论，0不打开，1打开 |
          | only_fans_can_comment（新增字段）| boolean/int | N |		是否粉丝才可评论，0所有人可评论，1粉丝才可评论 |
 
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | message | string | 操作说明或者错误说明 |
        | status_code | int | 错误码 |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "messages": "xxxx",
            "status_code": "xxxx"
        }
    }
    ```

7. 获取指定永久性素材

    + url: host + /wechat/material/{mediaId}?app_id={appid}
    + http方法: GET
    + 参数:
        
        mediaId:素材id 
        
    + http返回: 
    
        参考[微信开发文档](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1444738730 ) 
        
        注释：
        
            1. json实例 图文
    ```json 
    {
     "news_item":
     [
         {
         "title":TITLE,
         "thumb_media_id"::THUMB_MEDIA_ID,
         "show_cover_pic":SHOW_COVER_PIC(0/1),
         "author":AUTHOR,
         "digest":DIGEST,
         "content":CONTENT,
         "url":URL,
         "content_source_url":CONTENT_SOURCE_URL
         },
         //多图文消息有多篇文章
      ]
    }
    ```
        2. 图片、视频、音频
    ```json 
    {
      "title":TITLE,
      "description":DESCRIPTION,
      "down_url":DOWN_URL,
    }
    ```
    
8. 获取指定临时性素材

    + url: host + /wechat/material/{mediaId}/temporary?app_id={appid}
    + http方法: GET
    + 参数:
        
        mediaId:素材id 
        
    + http返回: 
    
        参考[微信开发文档](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1444738727) 
        
        注释：
        
            1. json实例 视频
    ```json 
    {
     "video_url":DOWN_URL
    }
    ```

9. 删除指定素材

    + url: host + /wechat/material/{mediaId}?app_id={appid}
    + http方法: DELETE
    + 参数:
        
        mediaId:素材id 
        
    + http返回: 
    
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | message | string | 操作说明或者错误说明 |
         | status_code | int | 错误码 |
        
        注释：
        
            1. json实例
    ```json
    {
        "data": {
            "messages": "xxxx",
            "status_code": "xxxx"
        }
    }
    ```
