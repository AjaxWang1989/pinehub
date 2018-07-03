# 关于本次开发中优化应用程序api参数解析流程，作出一下调整
- 添加应用程序的概念
- 管理后台在对应用程序管理时先要选择app应用，缓存appid
- 所有接口提交时添加selected_appid参数（http header里面添加或者在query参数中添加）
- 关于列表查询接口统一在这里详细解说通用参数于参数规则，在后面文档中查询参数或者过滤等不再单独说，
只做可查询字段的说明。

    | 参数名称 | 参数类型 | 是否必选(Y,N) | 说明 |
    | :-----: | :-----: | :---------: | :---: |
    | page  | int | N | 页数默认1 |
    | limit | int | N | 每一页数据条数 默认15 |
    | search | string | N | 查询字段search=John或者search=name:John Doe;<br>email:john@gmail.com，第二种是表示多字段多值查询 |
    | searchField | string | N| 查询字段以及匹配方式,与search配合使用。<br>search=John&searchField=name:=;nickname:like;|
    | searchJoin | string | N | 查询条件是and还是or查询 |
    | sortedBy | string | N | 排序字段，取值desc 降序，asc 升序|
    | orderBy | string | N | 1、orderBy=id按id排<br>2、orderBy=posts&#124;title,posts关联title作为排序字段<br>3、orderBy=posts:custom_id&#124;posts.title，<br>关联字段posts的custom_id,排序字段posts的title|
        