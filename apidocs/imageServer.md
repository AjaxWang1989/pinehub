 1. 素材预览

    + url: host + /material/view?material_src={path}
    + http方法: DELETE
    + 参数:
        
        material_src:素材路径
        
    + http返回: 
    
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | message | string | 操作说明或者错误说明 |
         | status_code | int | 错误码 |