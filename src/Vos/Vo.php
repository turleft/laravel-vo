<?php

namespace LaravelVo\Vos;

abstract class Vo
{
    /**
     * 对象转数组
     * @return array
     * @author: zyb
     * @time: 2022/10/8 16:38:17
     */
    public function toArray(): array
    {
        $arr  = [];
        $gets = array_filter(get_class_methods($this), function ($method) {
            return strpos($method, 'get') === 0 ?? $method;
        });
        foreach ($gets as $get) {
            $key       = lcfirst(substr($get, 3));
            $arr[$key] = $this->$get();
        }
        return $arr;
    }
}