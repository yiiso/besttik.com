<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * 显示忘记密码页面
     */
    public function showForgotForm()
    {
        return view('admin.passwords.forgot');
    }

    /**
     * 发送密码重置邮件
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ], [
            'email.required' => '请输入邮箱地址',
            'email.email' => '请输入有效的邮箱地址',
            'email.exists' => '该邮箱地址不存在',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        
        if (!$admin->is_active) {
            throw ValidationException::withMessages([
                'email' => ['该管理员账户已被禁用'],
            ]);
        }

        // 检查是否在短时间内重复请求
        $recentRequest = DB::table('admin_password_resets')
            ->where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subMinutes(1))
            ->first();

        if ($recentRequest) {
            throw ValidationException::withMessages([
                'email' => ['请等待1分钟后再次尝试'],
            ]);
        }

        // 生成重置令牌
        $token = Str::random(64);

        // 删除旧的重置记录
        DB::table('admin_password_resets')
            ->where('email', $request->email)
            ->delete();

        // 创建新的重置记录
        DB::table('admin_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        // 发送邮件
        $this->sendResetEmail($admin, $token);

        return back()->with('status', '密码重置链接已发送到您的邮箱，请查收！');
    }

    /**
     * 显示重置密码页面
     */
    public function showResetForm(Request $request, $token)
    {
        return view('admin.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * 重置密码
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'token.required' => '重置令牌无效',
            'email.required' => '请输入邮箱地址',
            'email.email' => '请输入有效的邮箱地址',
            'email.exists' => '该邮箱地址不存在',
            'password.required' => '请输入新密码',
            'password.confirmed' => '两次输入的密码不一致',
            'password.min' => '密码至少需要8个字符',
        ]);

        // 验证重置令牌
        $resetRecord = DB::table('admin_password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            throw ValidationException::withMessages([
                'email' => ['重置令牌无效或已过期'],
            ]);
        }

        // 检查令牌是否过期（24小时）
        if (Carbon::parse($resetRecord->created_at)->setTimezone('Asia/Shanghai')->addHours(24)->isPast()) {
            DB::table('admin_password_resets')
                ->where('email', $request->email)
                ->delete();
                
            throw ValidationException::withMessages([
                'email' => ['重置令牌已过期，请重新申请'],
            ]);
        }

        // 更新密码
        $admin = Admin::where('email', $request->email)->first();
        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        // 删除重置记录
        DB::table('admin_password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('admin.login')
            ->with('status', '密码重置成功，请使用新密码登录！');
    }

    /**
     * 发送重置邮件
     */
    private function sendResetEmail($admin, $token)
    {
        $resetUrl = route('admin.password.reset', [
            'token' => $token,
            'email' => $admin->email,
        ]);

        // 这里使用简单的邮件发送，实际项目中建议使用邮件模板
        try {
            Mail::raw("
亲爱的 {$admin->name}：

您好！我们收到了您的密码重置请求。

请点击以下链接重置您的密码：
{$resetUrl}

此链接将在24小时后过期。

如果您没有请求重置密码，请忽略此邮件。

谢谢！
管理团队
            ", function ($message) use ($admin) {
                $message->to($admin->email, $admin->name)
                        ->subject('管理员密码重置');
            });
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => ['邮件发送失败，请稍后重试'],
            ]);
        }
    }
}