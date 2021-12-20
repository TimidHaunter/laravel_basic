# 开始前的准备
[Laravel文档](https://learnku.com/docs/laravel/8.x)
- 开发环境布置
[dnmp](https://www.awaimai.com/2120.html#42)

- 配置和目录结构
  - 安装laravel
  cd 到当前目录执行以下命令，blog为项目名称
> composer create-project --prefer-dist laravel/laravel blog

- 配置
> 配置文件都在 `config` 文件夹下
需要给 `storage` 和 `bootstrap/cache` 写入权限
应用密钥，随机字符串 `php artisan key:generate`，在 `.env` 文件里 `APP_KEY`

- 目录结构

# composer.json
> composer install
安装composer文件，自动下载

# Dingo api
> 如果开发纯api的项目，可以安装dingo api
```shell
composer require dingo/api
```
# 基于Laravel使用ding/api+jwt开发api接口

# MySQL
> mysql -u root -p 123456
字符集 `utf8` 排序规则 `utf8_general_ci`

# docker
> 使用docker搭建lnmp环境，使用的是分容器的搭建方案
框架使用thinkphp，想要连接数据MySQL，一直显示“SQLSTATE[HY000] [2002] Connection refused”
数据库配置host填的是localhost，后面改成了127.0.0.1，都是连接不了
还以为是数据库用户权限问题，新建了一个用户，刷新了权限，结果还是不行
想了好久，原来都是分容器的问题，由于采用了分容器的搭建方案，在php的容器内连接127.0.0.1或者localhost，肯定是连接不了数据库MySQL的
应该把数据库配置host填成MySQL容器名称，我本地的MySQL容器名称为mysql，改成这样就可以连接

# jwt
[文档1](https://learnku.com/docs/dingo-api/2.0.0/Authentication/1449)
[文档2](https://learnku.com/laravel/wikis/25704)

# 访问节流限制
> nginx 也可以做，针对客户端 ip 访问 Nginx 服务器 HttpLimitReqModul
> 限制访问 api 的次数

# api v1 v2 版本
> 有问题，没解决 todo

# api文档
`showDoc`

## api 接口文档模板

### 接口描述

- 接口模板

### 请求URL

- ` /api/auth/{type} `

### 请求方式

- POST 

### 请求头部

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|Authorization |是  |string |JWT token   |

### REST 参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|type |是  |string |类型|

## Query 请求参数 get?参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|keyword |是  |string |关键字|

## Body 请求参数 post表单参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|keyword |是  |string |关键字|

## 返回参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|name |是  |string |昵称|
|email |是  |string |邮箱|

## 返回示例

- 状态码 200 请求成功

```json
{
    "name": "昵称",
    "email": "邮箱"
}
```

- 状态码 201 成功

- 状态码 422 参数错误

```json
{
    "message": "The given data was invaild.",
    "errors": {
	    "name": [
			"昵称不能为空"
		],
		"email": [
			"邮箱不能为空"
		],
		"password": [
			"密码不能为空"
		]
	},
	"status_code": 422,
}
```

## 数据字典模板

## 表名

-  users

## 描述

-  用户表，储存用户信息

## 字段

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |---|------      |
|uid    |int(10)     |否 |  |             |
|username |varchar(20) |否 |    |   用户名  |
|password |varchar(50) |否   |    |   密码    |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

## 备注

- 无

# 命令行
> php artisan api:docs --name Example --use-version v2 --output-file /path/to/documentation.md
> php artisan api:routes

# 表单验证
[表单验证](https://learnku.com/docs/laravel/8.5/validation/10378)
> php artisan make:request Auth/RegisterRequest

# 语言包
`resources\lang`
> composer require laravel-lang/lang:~8.0

# 登录
命令行创建的控制器是继承自父类，没办法自动继承我们自己写的基类
> php artisan make:controller Auth/LoginController

# 包
> composer require liyu/dingo-serializer-switch
dingo 返回数据，减少 transformer 包裹层

# 自动加载
> helper.php

```json
"files": [
    "helpers.php"
]
```
composer dump-autoload

# 缓存
默认是文件缓存
`config/cache.php`
```php
<?php
'default' => env('CACHE_DRIVER', 'file'),
```

# postman
> post 默认参数使用 Boby x-www-form-urlencoded

# 观察者
(事件，观察者)[https://www.cnblogs.com/mouseleo/p/8668001.html]
> php artisan make:observer CategoryObser --model=Category
在服务容器里注册
`Providers/AppServiceProvider.php`
```php
<?php
public function boot()
{
    // 观察Category模型事件
    Category::observe(CategoryObserver::class);
}
```

# 模型
> php artisan make:model Good -m // 创建模型的同时创建迁移文件
> php artisan make:model Good -mc // 还要创建控制器，但是没有办法指定路径

# 模型关联
> app/Models/Good.php
```php
<?php
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
```

# transformer
在 Transformer 里关联外部数据，比如Good商品只有category_id和user_id，如果需要分类名和用户名需要关联查表。在 Transformer 里可以轻易通过
```php
<?php
    public function includeUser(User $user)
    {
        return $this->item($user->user, new UserTransformer());
    }
```

# Laravel接入阿里OSS
> composer require "iidestiny/laravel-filesystem-oss"

[Web直传](https://help.aliyun.com/document_detail/31927.html?spm=a2c4g.11186623.2.10.5602668eApjlz3#concept-qp2-g4y-5db)

后端接口提供AccessKey一系列参数，并且返回签名，前端用js上传至阿里云OSS

# Mail
> php artisan make:mail OrderPost

`app/Mail/OrderPost.php`

# 邮箱配置
```
# 邮箱配置
MAIL_MAILER=smtp
MAIL_HOST=smtp.163.com
MAIL_PORT=465
MAIL_USERNAME=yintx_129@163.com
# 邮箱第三方授权码
MAIL_PASSWORD=USKZSWBHWWTMWVEZ
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=yintx_129@163.com
# 邮件发送者名称
MAIL_FROM_NAME="天雄超市"
```

# 队列
[队列文档](https://learnku.com/docs/laravel/8.x/queues/9398#connections-vs-queues)

使用数据库队列
> php artisan queue:table
> php artisan migrate

生成一个队列表 jobs，和自带一个 failed_jobs 失败队列表

队列默认配置文件
`config/queue.php`

在 `.env` 文件中可以修改队列驱动，数据库和 Redis
```
# 队列驱动 database 数据库
QUEUE_CONNECTION=database
```

创建队列
运行队列
> php artisan queue:work

# 队列的守护进程
[Docker内部使用Supervisor](https://www.voidking.com/dev-docker-supervisor/)
查看队列守护进程的状态
> sudo supervisorctl status
```shell
/usr/local/software # supervisorctl status
unix:///run/supervisord.sock no such file
```
报错是因为没有开始守护进程

# docker
查看Linux发行版本
```shell
/usr/local/software # cat /etc/issue
Welcome to Alpine Linux 3.12
Kernel \r on an \m (\l)
```
Alpine | apk 包管理工具
CentOS | yum
Ubuntu | apt

Alpine 安装 Supervisor
> apk add --no-cache supervisor

安装 vim
> apk add --update vim

配置守护进程文件
/etc/supervisor.conf
```
[include]
files = /etc/supervisor.d/*.ini
```

```
[program:laravel-worker] 进程名字
process_name=%(program_name)s_%(process_num)02d
command=php /www/laravel_basic/artisan queue:work 命令所在位置
autostart=true
autorestart=true
user=root
numprocs=2 进程数
redirect_stderr=true
stdout_logfile=/www/laravel_basic/storage/logs/worker.log 日志目录
stopwaitsecs=3600

[supervisord]
nodaemon=true 设置supervisor为前台进程

[supervisorctl]



[program:yintian-shop]
process_name=%(program_name)s_%(process_num)02d
command=php /www/laravel_basic/artisan queue:work
autostart=true
autorestart=true
user=root
numprocs=2
redirect_stderr=true
stdout_logfile=/www/laravel_basic/storage/logs/worker.log
stopwaitsecs=3600

[supervisord]
nodaemon=true

[supervisorctl]
```

开启守护进程
> supervisord -c /etc/supervisord.conf


# 事件
把发邮件逻辑放入事件中
[事件文档](https://learnku.com/docs/laravel/8.x/events/9391)

> MySQL 事务

事件和监听器
先在 `app/Providers/EventServiceProvider.php` 中添加监听
```php
<?php
/**
 * The event listener mappings for the application.
 * 应用程序的事件监听器映射
 *
 * @var array
 */
protected $listen = [
    Registered::class => [
        SendEmailVerificationNotification::class,
    ],
    'App\Events\OrderPost' => [
        'App\Listeners\SendEmailToOrderUser',
    ],
];
```
再执行命令
> php artisan event:generate
> Events and listeners generated successfully!

生成事件 `app/Events/OrderPost.php` 和监听者 `app/Listeners/SendEmailToOrderUser.php` 两个文件
监听者监听事件

# 增加字段，迁移文件
> php artisan make:migration add_group_to_category_tables --table=categories

# 数据库，数据迁移文件
`database\seeders`
> php artisan make:seeder MenuSeeder
> php artisan db:seed --class=MenuSeeder

用模型关联插入数据，感觉不好用。不用导出SQL文件。

# 权限限制
Laravel-permission
https://learnku.com/articles/9842/user-role-permission-control-package-laravel-permission-usage-description

> composer require spatie/laravel-permission

生成数据库迁移文件
> php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
> php artisan migrate

permission 控制颗粒度到什么地步

model_has_roles 用户属于那个角色
model_has_permissions 用户拥有那些权限，权限补充
