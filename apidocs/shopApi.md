# 店铺管理接口
1. 添加（创建）店铺
   
    + url: host + /shop
    + http方法: POST
    + 参数:
    
        | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
        | :------: | :-------: | :------: | :----:|
        | name | string | N | [ 'string', 'size:32']|
        | user_id | int | N | ['integer', 'exist:user,id']|
        | description | string | N | ['string'] | 
        | country_id | int | Y | ['required', 'integer', 'exist:country,id']|
        | province_id| int | Y | ['required', 'integer', 'exist:province,id']|
        | city_id | int | Y | ['required', 'integer', 'exist:city,id']|
        | county_id | int | Y | ['required', 'integer', 'exist:county,id']|
        | address | string | Y | ['required', 'string'] |
        | lng | float| Y |  ['required', 'numeric']|
        | lat | float| Y |  ['required', 'numeric']|
        | manager_mobile | string | N |['regex:'.MOBILE_PATTERN, 'not_exists:user,mobile']与user_id互斥二选一（特殊必填）|
        | manager_name | string | N | ['string', 'max:16'] 与manager_mobile一起|
        | status | int | Y | ['integer', 'in:0,1,2,3'] |
        
    + http返回: 
    
        | 数据名称 | 数据类型 | 说明 |
        | :-------: | :------: | :---: |
        | data   |   array | {app_id,app_name,app_secret,token, aes_key, type, <br>mode, wechat_bind_app, create_ad, update_at} |
        | message | string | 错误说明 ,出现错误才会出现 |
        | status_code | string | 错误码（一般是http标准码） |
        
        注释：
        
            1. json实例
    ```json
    ```
2. 店铺列表

    + url: host + /shops
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
   
        2. meta附加信息