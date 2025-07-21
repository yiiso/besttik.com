<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * 显示个人资料页面
     */
    public function show()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    /**
     * 更新个人信息
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile')
            ->with('success', '个人信息更新成功！');
    }

    /**
     * 修改密码
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ], [
            'current_password.required' => '请输入当前密码',
            'password.required' => '请输入新密码',
            'password.confirmed' => '两次输入的密码不一致',
            'password.min' => '密码至少需要8个字符',
            'password.mixed_case' => '密码必须包含大小写字母',
            'password.numbers' => '密码必须包含数字',
            'password.symbols' => '密码必须包含特殊字符',
        ]);

        // 验证当前密码
        if (!Hash::check($request->current_password, $admin->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['当前密码不正确'],
            ]);
        }

        // 检查新密码是否与当前密码相同
        if (Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'password' => ['新密码不能与当前密码相同'],
            ]);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', '密码修改成功！');
    }
}