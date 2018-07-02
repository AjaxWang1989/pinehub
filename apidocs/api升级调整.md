# 关于本次开发中优化应用程序api参数解析流程，作出一下调整
- 添加应用程序的概念
- 管理后台在对应用程序管理时先要选择app应用，缓存appid
- 所有接口提交时添加selected_appid参数（http header里面添加或者在query参数中添加）