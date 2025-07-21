<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminLoginThrottleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $throttleService;

    public function __construct(AdminLoginThrottleService $throttleService)
    {
        $this->throttleService = $throttleService;
    }

    /**
     * 显示登录页面
     */
    public function showLogin(Request $request)
    {
        $ip = $request->ip();
        $email = $request->old('email', '');
        
        // 检查是否被锁定
        if ($email && $this->throttleService->isLocked($email, $ip)) {
            $lockoutInfo = $this->throttleService->getLockoutInfo($email, $ip);
            return view('admin.login', compact('lockoutInfo'));
        }
        
        // 获取当前尝试次数信息
        $attemptInfo = null;
        if ($email) {
            $attempts = $this->throttleService->getAttempts($email, $ip);
            if ($attempts['ip_attempts'] > 0 || $attempts['email_attempts'] > 0) {
                $attemptInfo = $attempts;
            }
        }
        
        return view('admin.login', compact('attemptInfo'));
    }

    /**
     * 处理登录请求
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $ip = $request->ip();

        // 检查是否被锁定
        if ($this->throttleService->isLocked($email, $ip)) {
            $lockoutInfo = $this->throttleService->getLockoutInfo($email, $ip);
            $remainingTime = $this->formatTime($lockoutInfo['remaining_time']);
            
            throw ValidationException::withMessages([
                'email' => ["登录已被锁定，请在 {$remainingTime} 后重试。原因：{$lockoutInfo['reason']}"],
            ]);
        }

        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true; // 只允许激活的管理员登录

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            // 登录成功，清除尝试记录
            $this->throttleService->clearAttempts($email, $ip);
            
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }

        // 登录失败，记录尝试
        $this->throttleService->recordFailedAttempt($email, $ip);
        
        // 获取剩余尝试次数
        $attempts = $this->throttleService->getAttempts($email, $ip);
        $remainingAttempts = $attempts['remaining_attempts'];
        
        $errorMessage = '邮箱或密码错误';
        if ($remainingAttempts > 0) {
            $errorMessage .= "，还可尝试 {$remainingAttempts} 次";
        } else {
            $errorMessage .= '，账户已被锁定15分钟';
        }

        throw ValidationException::withMessages([
            'email' => [$errorMessage],
        ]);
    }

    /**
     * 退出登录
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    /**
     * 格式化时间显示
     */
    private function formatTime(int $seconds): string
    {
        if ($seconds <= 0) {
            return '0秒';
        }
        
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes > 0) {
            return $remainingSeconds > 0 ? "{$minutes}分{$remainingSeconds}秒" : "{$minutes}分钟";
        }
        
        return "{$remainingSeconds}秒";
    }

    /**
     * 管理员解锁接口（紧急情况使用）
     */
    public function unlock(Request $request)
    {
        // 这里可以添加额外的验证，比如超级管理员权限
        $request->validate([
            'email' => 'required|email',
            'ip' => 'required|ip',
        ]);

        $this->throttleService->unlock($request->input('email'), $request->input('ip'));
        
        return response()->json(['message' => '解锁成功']);
    }

    /**
     * 获取登录尝试统计
     */
    public function getLoginStats()
    {
        $stats = $this->throttleService->getTodayFailedAttempts();
        return response()->json($stats);
    }
}