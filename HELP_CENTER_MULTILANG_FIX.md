# 帮助中心多语言路由修复

## 问题描述
多语言路由 `/zh/help/getting-started` 返回404错误，而普通路由 `/help/getting-started` 正常工作。

## 问题原因
1. **中间件参数处理**: `SetLocale` 中间件会从路由参数中移除 `locale` 参数，但控制器方法的参数签名没有正确处理这种情况。

2. **路由参数错位**: 当中间件移除 `locale` 参数后，剩余的路由参数会传递给控制器，但控制器方法期望的参数顺序与实际传递的不匹配。

## 解决方案

### 1. 修复 SetLocale 中间件
```php
// 修改前
$request->route()->forgetParameter($locale);

// 修改后  
if ($request->route()) {
    $request->route()->forgetParameter('locale');
}
```

### 2. 简化控制器方法
将控制器方法恢复为标准的参数签名，不再处理 `locale` 参数：

```php
// 修改前
public function category($locale = null, $category = null)

// 修改后
public function category($category)
```

### 3. 路由配置保持一致
多语言路由和普通路由使用相同的控制器方法：

```php
// 普通路由
Route::get('/help/{category}', [HelpController::class, 'category']);

// 多语言路由
Route::get('/help/{category}', [HelpController::class, 'category']);
```

## 工作原理

1. **请求处理流程**:
   ```
   /zh/help/getting-started
   ↓
   SetLocale 中间件设置语言为 'zh'
   ↓
   移除 'locale' 参数
   ↓
   路由变为: help/{category}
   ↓
   控制器接收: category = 'getting-started'
   ```

2. **中间件作用**:
   - `DetectLanguage`: 检测浏览器语言并重定向
   - `SetLocale`: 设置应用语言并清理路由参数

## 测试验证

修复后，以下路由都应该正常工作：

- `/help` - 帮助中心首页
- `/help/getting-started` - 入门指南分类
- `/help/getting-started/quick-start` - 快速开始文章
- `/zh/help` - 中文帮助中心首页
- `/zh/help/getting-started` - 中文入门指南分类
- `/zh/help/getting-started/quick-start` - 中文快速开始文章

## 关键修改文件

1. `app/Http/Middleware/SetLocale.php` - 修复参数移除逻辑
2. `app/Http/Controllers/HelpController.php` - 简化方法参数
3. `routes/web.php` - 保持路由配置一致

## 总结

这个修复确保了多语言路由能够正确工作，同时保持了代码的简洁性。中间件负责语言设置和参数清理，控制器专注于业务逻辑处理。