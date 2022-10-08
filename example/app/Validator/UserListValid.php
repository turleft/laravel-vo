<?php

namespace App\Validator;


use LaravelVo\Validator\Valid;

class UserListValid extends Valid
{
    //所有的验证都可以写在这个数组里面
    protected $rule = [
        'id' => 'required',
        'name' => 'required',
        'page' => 'required',
        'perPage' => 'required',
        'sort' => 'required',
    ];
    //所有的验证信息提示都可以写在这个数组里面
    protected $message = [
        'id.required' => 'id为空',
        'name.required' => '姓名为空',
        'page.required' => '页码为空',
        'perPage.required' => '每页数为空',
        'sort.required' => '排序为空',
    ];

    protected $scene = [
        'list' => [
            'name',
            'page',
            'perPage',
            'sort',
        ],
    ];
}