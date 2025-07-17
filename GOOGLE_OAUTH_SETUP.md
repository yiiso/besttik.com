# Google OAuth 登录配置指南

本文档将指导您如何配置Google OAuth登录功能。

## 1. 创建Google Cloud项目

1. 访问 [Google Cloud Console](https://console.cloud.google.com/)
2. 创建新项目或选择现有项目
3. 启用Google+ API和Google OAuth2 API

## 2. 配置OAuth同意屏幕

1. 在Google Cloud Console中，导航到 "APIs & Services" > "OAuth consent screen"
2. 选择用户类型（内部或外部）
3. 填写应用信息：
   - 应用名称：VideoParser.pro
   - 用户支持电子邮件
   - 应用域名
   - 开发者联系信息

## 3. 创建OAuth 2.0客户端ID

1. 导航到 "APIs & Services" > "Credentials"
2. 点击 "Create Credentials" > "OAuth client ID"
3. 选择应用类型：Web application
4. 配置重定向URI：
   - 开发环境：`http://localhost:8000/auth/google/callback`
   - 生产环境：`https://yourdomain.com/auth/google/callback`

## 4. 配置环境变量

将获得的客户端ID和客户端密钥添加到 `.env` 文件：

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
```

## 5. 运行数据库迁移

执行以下命令添加Google登录所需的数据库字段：

```bash
php artisan migrate
```

## 6. 测试Google登录

1. 启动Laravel开发服务器：`php artisan serve`
2. 访问网站并点击登录按钮
3. 选择"使用Google登录"
4. 完成Google OAuth流程

## 故障排除

### 常见错误

1. **redirect_uri_mismatch**
   - 确保Google Console中配置的重定向URI与应用中的完全匹配
   - 检查协议（http/https）和端口号

2. **invalid_client**
   - 检查客户端ID和客户端密钥是否正确
   - 确保.env文件中的配置正确

3. **access_denied**
   - 用户取消了授权
   - 检查OAuth同意屏幕配置

### 调试技巧

1. 检查Laravel日志：`storage/logs/laravel.log`
2. 启用调试模式：在.env中设置 `APP_DEBUG=true`
3. 使用浏览器开发者工具检查网络请求

## 安全注意事项

1. 不要在代码中硬编码客户端密钥
2. 使用HTTPS（生产环境）
3. 定期轮换客户端密钥
4. 限制OAuth范围权限
5. 验证用户邮箱域名（如需要）

## 可选：使用Laravel Socialite

如果您希望使用Laravel Socialite包来简化Google OAuth集成：

```bash
composer require laravel/socialite
```

然后更新 `config/services.php`：

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('APP_URL') . '/auth/google/callback',
],
```

## 支持

如果您在配置过程中遇到问题，请检查：
1. Google Cloud Console配置
2. Laravel日志文件
3. 网络连接和防火墙设置