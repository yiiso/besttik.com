<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * 用户登录
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ], [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min_length')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'message' => __('messages.login_success'),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => __('messages.invalid_credentials')
        ], 401);
    }

    /**
     * 用户注册
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.unique' => __('messages.email_exists'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min_length'),
            'password.confirmed' => __('messages.password_confirmation_failed')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        // 从邮箱地址生成用户名
        $emailParts = explode('@', $request->email);
        $username = $emailParts[0];

        $user = User::create([
            'name' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.register_success'),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }

    /**
     * 用户退出登录
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.logout_success')
        ]);
    }

    /**
     * Google OAuth 登录重定向
     */
    public function redirectToGoogle()
    {
        $originalUrl = request()->target ?? '/';
        try {
            // 检查Google OAuth配置
            $clientId = env('GOOGLE_CLIENT_ID');
            $clientSecret = env('GOOGLE_CLIENT_SECRET');

            if (!$clientId || !$clientSecret) {
                // 如果没有配置OAuth，返回到首页并显示提示信息
                return redirect('/')->with('error', 'Google登录功能需要配置。请在.env文件中设置GOOGLE_CLIENT_ID和GOOGLE_CLIENT_SECRET，并在Google Cloud Console中配置OAuth应用。详情请参考GOOGLE_OAUTH_SETUP.md文件。');
            }


            // 生成随机字符串作为 CSRF 令牌（增强安全性）
            $csrfToken = Str::random(32);

            // 将原始 URL 和 CSRF 令牌存入 state（用 JSON 编码，便于解析）
            $stateData = [
                'csrf_token' => $csrfToken,
                'original_url' => $originalUrl // 关键：保存登录前的地址
            ];
            $state = base64_encode(json_encode($stateData)); // 编码后作为 state 参数

            // 存储 CSRF 令牌到 session，用于回调时验证
            session(['google_login_csrf' => $csrfToken]);


            // 构建Google OAuth URL
            $params = [
                'client_id' => $clientId,
                'redirect_uri' => url('/auth/google/callback'),
                'scope' => 'openid profile email',
                'response_type' => 'code',
                'state' => $state,
                'access_type' => 'online',
                'prompt' => 'select_account'
            ];

            $googleAuthUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);

            Log::info('Google OAuth redirect URL: ' . $googleAuthUrl);

            return redirect($googleAuthUrl);

        } catch (\Exception $e) {
            Log::error('Google OAuth redirect error: ' . $e->getMessage());
            return redirect($originalUrl)->with('error', 'Google登录初始化失败: ' . $e->getMessage());
        }
    }

    /**
     * Google OAuth 登录回调
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $code = $request->get('code');
            $state = $request->get('state');
            $error = $request->get('error');

            // 检查是否有错误
            if ($error) {
                return redirect('/')->with('error', 'Google登录被取消或失败');
            }

            if (!$code) {
                return redirect('/')->with('error', 'Google登录失败：未获取到授权码');
            }

            // 1. 获取 Google 返回的 state 参数
            $state = $request->input('state');
            if (!$state) {
                return redirect('/')->with('error', '登录失败：缺少状态参数');
            }

            // 2. 解码并验证 state 数据
            $stateData = json_decode(base64_decode($state), true);
            if (!$stateData || !isset($stateData['csrf_token'], $stateData['original_url'])) {
                return redirect('/')->with('error', '登录失败：状态参数无效');
            }

            // 3. 验证 CSRF 令牌（防伪造）
            if ($stateData['csrf_token'] !== session('google_login_csrf')) {
                return redirect('/')->with('error', '登录失败：安全验证失败');
            }


            // 5. 登录成功后，跳转回原始 URL
            $originalUrl = $stateData['original_url'];

            Log::info('original_url'.$originalUrl);

            // 清除session中的state
            session()->forget('google_login_csrf');

            // 获取访问令牌
            $tokenResponse = $this->getGoogleAccessToken($code);

            if (!$tokenResponse || !isset($tokenResponse['access_token'])) {
                Log::error('Google token response: ', $tokenResponse ?? []);
                return redirect($originalUrl)->with('error', 'Google登录失败：无法获取访问令牌');
            }

            // 获取用户信息
            $userInfo = $this->getGoogleUserInfo($tokenResponse['access_token']);

            if (!$userInfo || !isset($userInfo['email'])) {
                Log::error('Google user info: ', $userInfo ?? []);
                return redirect($originalUrl)->with('error', 'Google登录失败：无法获取用户信息');
            }

            // 查找或创建用户
            $user = $this->findOrCreateGoogleUser($userInfo);

            Auth::login($user);

            return redirect($originalUrl)->with('success', '登录成功！');

        } catch (\Exception $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Google登录失败: ' . $e->getMessage());
        }
    }

    /**
     * 获取Google访问令牌
     */
    private function getGoogleAccessToken($code)
    {
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = route('auth.google.callback');

        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
        ]);

        return $response->json();
    }

    /**
     * 获取Google用户信息
     */
    private function getGoogleUserInfo($accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://www.googleapis.com/oauth2/v2/userinfo');

        return $response->json();
    }

    /**
     * 查找或创建Google用户
     */
    private function findOrCreateGoogleUser($googleUser)
    {
        // 首先尝试通过邮箱查找现有用户
        $user = User::where('email', $googleUser['email'])->first();

        if ($user) {
            // 如果用户存在但没有Google ID，则更新
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser['id'],
                    'avatar' => $googleUser['picture'] ?? null,
                ]);
            }
            return $user;
        }

        // 创建新用户
        return User::create([
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
            'google_id' => $googleUser['id'],
            'avatar' => $googleUser['picture'] ?? null,
            'email_verified_at' => now(), // Google用户邮箱已验证
            'password' => Hash::make(Str::random(32)), // 随机密码
        ]);
    }
}
