 1. 素材预览

    + url: host + /material/view?material_src={path}
    + http方法: GET
    + 参数:
        
        material_src:素材路径
        
    + http返回: 
    
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | message | string | 操作说明或者错误说明 |
         | status_code | int | 错误码 |
         
 2. 素材预览

    + url: host + /material/{material_id}
    + http方法: GET
    + 参数:
        
        material_id:素材id
        
    + http返回: 
    
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | message | string | 操作说明或者错误说明 |
         | status_code | int | 错误码 |
         
 3. 支付二维码

    + url: host + /shop/{id}/payment-qrcode
    + http方法: GET
    + 参数:
        
        id:店铺id
        
    + http返回: 
    
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | message | string | 操作说明或者错误说明 |
         | status_code | int | 错误码 |
         
 3. 微信参数二维码

    + url: host + /shop/{id}/official-account-qrcode
    + http方法: GET
    + 参数:
        
        id:店铺id
        
    + http返回: 
    
         | 数据名称 | 数据类型 | 说明 |
         | :-------: | :------: | :---: |
         | message | string | 操作说明或者错误说明 |
         | status_code | int | 错误码 |