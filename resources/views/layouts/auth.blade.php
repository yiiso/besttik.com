<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>@yield('title', '管理员登录')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/mobile-admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    @yield('content')
    
    @stack('scripts')
</body>
</html>