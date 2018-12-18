laravel-admin 帮助中心
======

#### 安装 wang-editor

[https://github.com/laravel-admin-extensions/wangEditor](https://github.com/laravel-admin-extensions/wangEditor)

#### 安装 light-box

[https://github.com/SmallRuralDog/light-box](https://github.com/SmallRuralDog/light-box)


#### 安装 help-center

```$xslt
composer require smallruraldog/help-center
```

#### 发布资源
```
php artisan vendor:publish --provider=SmallRuralDog\HelpCenter\HelpCenterServiceProvider
```
#### 执行安装/更新命令
```
php artisan help-center:install
php artisan help-center:update
```

### 发布菜单
```$xslt
php artisan admin:import help-center
```

> 注意：更新版本时可能需要重新发布资源，具体可看更新文档

#### 使用说明
```php
//获取帮助文档
HelpCenter::getDocs();

//获取用户工单列表
HelpCenter::getWorkOrders($user);

//获取用户某工单详情
HelpCenter::getWorkOrderInfo($user,$id);

/**
 * 添加工单
 * @param string $content
 * @param array $images
 * @param User $user
 * @param int $p_id
 */
HelpCenter::addWorkOrder($content, $up_images, $user, $p_id);//添加工单
```

#### 后端演示
![image](https://user-images.githubusercontent.com/5151848/50128218-24b6c180-02af-11e9-8d2d-e7dd240585b4.png)
![image](https://user-images.githubusercontent.com/5151848/50128260-487a0780-02af-11e9-8834-14ffcdb8d878.png)

#### 前端案例（需要自己实现）
![image](https://user-images.githubusercontent.com/5151848/50128298-6c3d4d80-02af-11e9-8af4-e50152c76126.png)
![image](https://user-images.githubusercontent.com/5151848/50128317-7eb78700-02af-11e9-9bec-0f846f11d3e2.png)
![image](https://user-images.githubusercontent.com/5151848/50128333-8e36d000-02af-11e9-9ad2-782181bb37cb.png)
![image](https://user-images.githubusercontent.com/5151848/50128347-a3abfa00-02af-11e9-962a-f7f7875eb180.png)


#### License

Licensed under The [MIT License (MIT). ](https://github.com/SmallRuralDog/help-center/blob/master/LICENSE)