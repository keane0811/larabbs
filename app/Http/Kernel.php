<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        // 修正代理服务器后的服务参数
        \App\Http\Middleware\TrustProxies::class,
        // 解决cors跨域问题
        \Fruitcake\Cors\HandleCors::class,
        // 检测应用是否进入维护模式, 见: https://learnku.com/docs/laravel/8.x/configuration#maintenance-mode
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // 检测表单请求的数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // 对所有提交的数据进行php函数trim()处理
        \App\Http\Middleware\TrimStrings::class,
        // 将提交请求参数中空子串转换为null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        // web中间件组, 应用于routes/web.php路由文件, 在RouteServiceProvider中设定
        'web' => [
            // cookie加密解密
            \App\Http\Middleware\EncryptCookies::class,
            // 将cookie添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // 开启会话
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            // 将系统的错误数据注入到视图变量$errors中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // 检测CSRF, 防止跨站请求伪造的安全威胁, 见: https://learnku.com/docs/laravel/8.x/csrf
            \App\Http\Middleware\VerifyCsrfToken::class,
            // 处理路由绑定, 见: https://learnku.com/docs/laravel/8.x/routing#route-model-binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // 强制用户邮箱认证
            \App\Http\Middleware\EnsureEmailIsVerified::class,
            // 记录用户最后活跃时间
            \App\Http\Middleware\RecordLastActivedTime::class,
        ],

        // api中间件组, 应用于routes/api.php路由文件, 在RouteServiceProvider中设定
        'api' => [
            // 使用别名来调用中间件, 见: https://learnku.com/docs/laravel/8.x/middleware#为路由分配中间件
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // 只有登录用户才能访问, 在控制器的构造方法中大量使用
        'auth' => \App\Http\Middleware\Authenticate::class,
        // HTTP Basic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        // 缓存标头
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        // 用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // 只有有课才能访问, 在register和login请求中使用, 只有未登录用户才能访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // 密码确认, 可以在做一些安全级别较高的修改时使用, 如支付前进行密码确认
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        // 签名认证
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        // 访问节流, 类似于1分钟只能请求10次, 一般在api中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // laravel自带的强制用户邮箱认证的中间件
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
