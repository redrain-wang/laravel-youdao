    
### composer安装
        
    composer require redrain/laravel-youdao
    
### 添加ServiceProvider

    Redrain\YouDao\YouDaoServiceProvider::class,
    
### 发布配置文件

    php artisan vendor:publish
    

### 配置

• 发布配置文件后在config文件夹里面会生成youdao.php 修改里面的两个key为自己的即可