# 微信公众号或者小程序管理接口文档
1. 添加微信公众号或者小程序配置
    + url: host + /wechat/config
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | app_id | string | Y | 微信公众号appid或者小程序appid，wx开头的十八字符串|
        | app_secret | string | Y | 微信公众号或者小程序secret，32位字符串 |
        | mode | string | Y | 微信公众号模式，取之位editor，developer|
        | type | string | Y | app类型，小程序，公众号，三方应用，<br>取值wechat_mini_program,wechat_office_account,<br>wechat_open_platform|
        | token | string | N | 公众号开发者token,32位字符串，<br>mode为developer时必填|
        | aes_key | string | N | 微信开发者aes key，43位字符串，<br>mode为developer时必填|
        | wechat_bind_app | string | N | 微信绑定程序，取值greenKey，takeOut |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {message:"XXXXX"} |
        | message | string | 错误说明 |
        | status_code| string | 错误码（一般是http标准码） |
        
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