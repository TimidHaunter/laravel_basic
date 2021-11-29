## 开始前的准备
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

## Dingo api
> 如果开发纯api的项目，可以安装dingo api
```shell
composer require dingo/api
```
## 基于Laravel使用ding/api+jwt开发api接口

## MySQL
> mysql -u root -p 123456
字符集 `utf8` 排序规则 `utf8_general_ci`

## docker
> 使用docker搭建lnmp环境，使用的是分容器的搭建方案
框架使用thinkphp，想要连接数据MySQL，一直显示“SQLSTATE[HY000] [2002] Connection refused”
数据库配置host填的是localhost，后面改成了127.0.0.1，都是连接不了
还以为是数据库用户权限问题，新建了一个用户，刷新了权限，结果还是不行
想了好久，原来都是分容器的问题，由于采用了分容器的搭建方案，在php的容器内连接127.0.0.1或者localhost，肯定是连接不了数据库MySQL的
应该把数据库配置host填成MySQL容器名称，我本地的MySQL容器名称为mysql，改成这样就可以连接

## jwt
[文档1](https://learnku.com/docs/dingo-api/2.0.0/Authentication/1449)
[文档2](https://learnku.com/laravel/wikis/25704)

## 访问节流限制
> nginx 也可以做，针对客户端 ip 访问 Nginx 服务器 HttpLimitReqModul
> 限制访问 api 的次数

## api v1 v2 版本
> 有问题，没解决 todo

## api文档
`showDoc`

### api 接口文档模板

##### 接口描述

- 接口模板

##### 请求URL

- ` /api/auth/{type} `

##### 请求方式

- POST 

##### 请求头部

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|Authorization |是  |string |JWT token   |

##### REST 参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|type |是  |string |类型|

#### Query 请求参数 get?参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|keyword |是  |string |关键字|

#### Body 请求参数 post表单参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|keyword |是  |string |关键字|

#### 返回参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|name |是  |string |昵称|
|email |是  |string |邮箱|

#### 返回示例

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






### 数据字典模板

#### 表名

-  users

#### 描述

-  用户表，储存用户信息

#### 字段

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |---|------      |
|uid    |int(10)     |否 |  |             |
|username |varchar(20) |否 |    |   用户名  |
|password |varchar(50) |否   |    |   密码    |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

#### 备注

- 无

## 命令行
> php artisan api:docs --name Example --use-version v2 --output-file /path/to/documentation.md
> php artisan api:routes

## 表单验证
[表单验证](https://learnku.com/docs/laravel/8.5/validation/10378)
> php artisan make:request Auth/RegisterRequest

## 语言包
`resources\lang`
> composer require laravel-lang/lang:~8.0

## 登录
命令行创建的控制器是继承自父类，没办法自动继承我们自己写的基类
> php artisan make:controller Auth/LoginController

## 包
> composer require liyu/dingo-serializer-switch
dingo 返回数据，减少 transformer 包裹层

## 自动加载
> helper.php

```json
"files": [
    "helpers.php"
]
```
composer dump-autoload

## 缓存
默认是文件缓存
`config/cache.php`
```php
<?php
'default' => env('CACHE_DRIVER', 'file'),
```

## postman
> post 默认参数使用 Boby x-www-form-urlencoded

## 观察者
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

