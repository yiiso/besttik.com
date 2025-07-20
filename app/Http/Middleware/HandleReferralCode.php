<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleReferralCode
{
    public function handle(Request $request, Closure $next)
    {
        // 检查URL中是否有推荐码
        if ($request->has('ref') && $request->get('ref')) {
            $referralCode = $request->get('ref');
            
            // 将推荐码存储到session中，以便注册时使用
            session(['referral_code' => $referralCode]);
        }

        return $next($request);
    }
}