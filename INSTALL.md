# composer.json
> composer install
安装composer文件，自动下载

# .env
复制`.env.example`为`.env`
```shell
##MySQL配置
DB_CONNECTION=mysql
##主机地址，因为使用的docker，可以直接使用容器名
DB_HOST=mysql
DB_PORT=3306
##需要提前创建好数据库名称，方便数据迁移
DB_DATABASE=ec
DB_USERNAME=root
DB_PASSWORD=123456

##API配置
API_PREFIX=null
API_DOMAIN=dev.ec.com
##END
```

# 生成应用密钥，随机字符串APP_KEY
在 `.env` 文件里 `APP_KEY`
```shell
php artisan key:generate
```

# 创建缓存日志文件夹
```shell
##修改文件的权限
chmod 777 laravel.log
##修改文件夹下所有文件的权限
chmod -R a+r Documents
```

# 创建数据库
```shell
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
##只创建表
php artisan migrate
##创建表，并且填充数据
php artisan migrate:refresh --seed
```

# 查看api列表
```shell
php artisan api:routes
```
