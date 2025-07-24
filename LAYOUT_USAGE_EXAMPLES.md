# 后台布局使用示例

## 使用 admin.blade.php 布局创建新页面

### 基础用法
```php
@extends('layouts.admin')

@section('title', '页面标题')
@section('mobile-title', '移动端标题')

@section('content')
    <!-- 页面内容 -->
    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">页面标题</h2>
        <p class="text-gray-600">页面描述</p>
    </div>
    
    <!-- 其他内容 -->
@endsection
```

### 添加页面专用脚本
```php
@extends('layouts.admin')

@section('title', '用户管理')
@section('mobile-title', '用户管理')

@push('head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <!-- 页面内容 -->
@endsection

@push('scripts')
<script>
    // 页面专用JavaScript代码
    console.log('页面加载完成');
</script>
@endpush
```

### 添加页面专用样式
```php
@extends('layouts.admin')

@section('title', '系统设置')

@push('styles')
<style>
    .custom-component {
        background: #f3f4f6;
        padding: 1rem;
    }
</style>
@endpush

@section('content')
    <div class="custom-component">
        <!-- 使用自定义样式的内容 -->
    </div>
@endsection
```

## 使用 auth.blade.php 布局创建认证页面

### 基础用法
```php
@extends('layouts.auth')

@section('title', '重置密码')

@section('content')
<div class="max-w-md w-full bg-white rounded-lg shadow-md p-4 sm:p-6">
    <div class="text-center mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">重置密码</h1>
        <p class="text-gray-600 mt-2 text-sm sm:text-base">请输入新密码</p>
    </div>

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <!-- 表单内容 -->
    </form>
</div>
@endsection
```

## 布局文件的关键特性

### admin.blade.php 提供的功能

#### 1. 自动导航高亮
布局会根据当前路由自动高亮对应的导航项：
```php
<a href="{{ route('admin.dashboard') }}" 
   class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900' }}">
    仪表板
</a>
```

#### 2. 移动端导航切换
内置JavaScript函数处理移动端菜单：
```javascript
function toggleMobileNav() {
    const mobileNav = document.querySelector('.mobile-nav');
    mobileNav.classList.toggle('show');
}
```

#### 3. 响应式设计
CSS媒体查询自动切换桌面端和移动端布局：
```css
@media (max-width: 768px) {
    .mobile-nav-toggle { display: block; }
    .desktop-nav { display: none; }
}
```

### 内容区域结构
```html
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @yield('content')
</div>
```

### 脚本和样式栈
```html
@stack('head-scripts')  <!-- 头部脚本 -->
@stack('styles')        <!-- 自定义样式 -->
@stack('scripts')       <!-- 底部脚本 -->
```

## 最佳实践

### 1. 页面标题设置
```php
@section('title', '完整页面标题 - 运营管理后台')
@section('mobile-title', '简短标题')  // 移动端显示
```

### 2. 脚本加载顺序
- `@push('head-scripts')`: 需要在页面加载前执行的脚本
- `@push('scripts')`: 页面加载后执行的脚本

### 3. 样式组织
- 全局样式放在布局文件中
- 页面专用样式使用 `@push('styles')`
- 组件样式放在独立的CSS文件中

### 4. 移动端优化
- 使用响应式类名：`text-xl sm:text-2xl`
- 按钮全宽设计：`w-full sm:w-auto`
- 间距调整：`gap-3 sm:gap-4`

## 添加新导航项

如需添加新的导航项，只需修改 `layouts/admin.blade.php` 文件：

```php
<!-- 桌面端导航 -->
<a href="{{ route('admin.new-page') }}" 
   class="{{ request()->routeIs('admin.new-page*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
    新页面
</a>

<!-- 移动端导航 -->
<a href="{{ route('admin.new-page') }}" 
   class="{{ request()->routeIs('admin.new-page*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-4 py-3 rounded-md text-sm font-medium block">
    新页面
</a>
```

这样所有使用该布局的页面都会自动获得新的导航项。