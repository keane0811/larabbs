<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

return [
    'title' => '站点设置',
    // 访问权限判断
    'permission' => function () {
        // 只允许站长管理站点设置
        return Auth::user()->hasRole('Founder');
    },
    // 站点配置的表单
    'edit_fields' => [
        'site_name' => [
            'title' => '站点名称',
            'type' => 'text',
            'limit' => 50,
        ],
        'contact_email' => [
            'title' => '联系人邮箱',
            'type' => 'text',
            'limit' => 50,
        ],
        'seo_description' => [
            'title' => 'SEO - Dscription',
            'type' => 'textarea',
            'limit' => 250,
        ],
        'seo_keyword' => [
            'title' => 'SEO - Keyword',
            'type' => 'textarea',
            'limit' => 250,
        ],
    ],
    'rules' => [
        'site_name' => 'required|max:50',
        'contact_email' => 'email',
    ],
    'messages' => [
        'site_name.required' => '站点名称不能为空',
        'contact_email.email' => '邮箱格式不正确',
    ],

    // 数据即将保存时触发的钩子, 可以对用户提交的数据做修改
    'before_save' => function (&$data) {
        // 为网站名称加上后缀, 加上判断是为了防止多次添加
        if (strpos($data['site_name'], 'Powered by LaraBBS') === false) {
            $data['site_name'] .= 'Powered by LaraBBS';
        }
    },

    // 可以自定义多个动作, 每个动作为设置页面底部的其他操作区块
    'actions' => [
        // 清空缓存
        'clear_cache' => [
            'title' => '更新系统缓存',
            // 不同状态时页面的提醒
            'messages' => [
                'active' => '正在清空缓存...',
                'success' => '缓存已清空',
                'error' => '清空缓存出错!',
            ],
            // 动作执行代码, 可以修改$data参数更改配置信息
            'action' => function (&$data) {
                Artisan::call('cache clear');
                return true;
            },
        ],
    ],
];
