## laravel6 cms  

#### 创建.env
复制同级文件.env.example,重命名为.env
修改数据库配置、APP_URL、APP_KEY、APP_NAME等参数
#### 数据库添加
创建数据库配置内的数据库，在artisan文件的同级目录下执行
###### 迁移数据库表
##### php artisan migrate
###### 添加默认数据
##### php artisan db:seed --class=DatabaseSeeder

#### 修改后台模板文件配置(需要装npm)
同级目录admin-template/.env.development、admin-template/.env.production、admin-template/.env.staging配置
###### http://域名 + 后台接口前缀(.env文件内的ADMIN_PREFIX值) + api 
VUE_APP_BASE_API =
###### http://域名
VUE_APP_BASE_URL =
###### 页面默认标题
VUE_APP_PAGE_TITLE = 'ccforever'
###### 长链接地址 ws://域名:端口(config/worker.php文件内的留言配置配置的端口)
VUE_APP_BASE_WS =

#### 打包后台模板
进入admin-template文件夹执行
##### 安装需要的扩展
###### npm install
##### 打包后台模板文件
###### npm run build:prod
#### 后台模板文件引入项目中
打包完成后生成dist文件夹，压缩dist文件夹内容，放到项目域名根目录(也可以放到别的目录下需要修改index.html内的文件路径和tinymce文件夹必须放在域名根目录下)下解压缩即可