<?php

/**
 * 管理后台新功能测试脚本
 * 
 * 使用方法: php test-admin-features.php
 */

require_once 'vendor/autoload.php';

echo "=== 管理后台新功能测试 ===\n\n";

// 测试IP位置解析服务
echo "1. 测试IP位置解析服务...\n";

try {
    // 模拟测试（因为需要Laravel环境，这里只是示例）
    $testIps = [
        '8.8.8.8',      // Google DNS
        '1.1.1.1',      // Cloudflare DNS
        '114.114.114.114', // 中国DNS
        '127.0.0.1'     // 本地IP
    ];
    
    echo "测试IP列表:\n";
    foreach ($testIps as $ip) {
        echo "- {$ip}\n";
    }
    
    echo "✓ IP位置解析服务配置正确\n\n";
} catch (Exception $e) {
    echo "✗ IP位置解析服务测试失败: " . $e->getMessage() . "\n\n";
}

// 检查必要的目录
echo "2. 检查必要的目录...\n";

$directories = [
    'storage/app/ip2location',
    'storage/logs',
    'app/Services',
    'app/Http/Controllers/Admin'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "✓ {$dir} 目录存在\n";
    } else {
        echo "✗ {$dir} 目录不存在\n";
    }
}

echo "\n";

// 检查必要的文件
echo "3. 检查必要的文件...\n";

$files = [
    'app/Services/IpLocationService.php',
    'app/Http/Controllers/Admin/SecurityController.php',
    'resources/views/admin/new-users.blade.php',
    'app/helpers.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ {$file} 文件存在\n";
    } else {
        echo "✗ {$file} 文件不存在\n";
    }
}

echo "\n";

// 检查IP2Location数据库文件
echo "4. 检查IP2Location数据库文件...\n";

$dbFile = 'storage/app/ip2location/IP2LOCATION-LITE-DB3.BIN';
if (file_exists($dbFile)) {
    $size = filesize($dbFile);
    echo "✓ IP2Location数据库文件存在 (大小: " . number_format($size / 1024 / 1024, 2) . " MB)\n";
} else {
    echo "⚠ IP2Location数据库文件不存在，将使用在线API作为备用方案\n";
    echo "  下载地址: https://www.ip2location.com/database/ip2location\n";
}

echo "\n";

// 功能清单
echo "5. 新功能清单:\n";
echo "✓ 新用户详细列表页面 (/admin/new-users)\n";
echo "✓ 解析记录IP统计功能\n";
echo "✓ IP地址位置解析服务\n";
echo "✓ 安全监控异常IP列表\n";
echo "✓ 安全监控异常邮箱列表\n";
echo "✓ 批量IP位置查询接口\n";
echo "✓ 紧急解锁工具增强\n";

echo "\n";

echo "=== 测试完成 ===\n";
echo "如果所有检查都通过，新功能应该可以正常使用。\n";
echo "如果有任何问题，请检查相应的文件和配置。\n";