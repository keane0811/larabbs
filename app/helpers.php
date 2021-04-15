<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function category_nav_active($category_id)
{
    return active_class(if_route('categories.show') && if_route_param('category', $category_id));
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r\n|n+/', ' ', strip_tags($value)));

    return Str::limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);
    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';
    // 使用站点URL拼接全量URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名, 如: App\Models\User
    $full_class_name = get_class($model);
    // 获取基础类名, 如: 传参App\Models\User会得到User
    $class_name = class_basename($full_class_name);
    // 蛇形命名
    $snake_case_name = Str::snake($class_name);
    // 获取子串的复数形式
    return Str::plural($snake_case_name);
}
