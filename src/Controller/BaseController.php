<?php

namespace LaravelVo\Controller;

use LaravelVo\Vos\Vo;
use Illuminate\Container\Container;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 基础控制器
 * @author: zyb
 * @time: 2022/10/8 16:52:38
 */
class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 重写
     * Execute an action on the controller.
     *
     * @param string $method
     * @param array $parameters
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function callAction($method, $parameters)
    {
        $container = Container::getInstance();
        $request   = $container->get(Request::class);
        $all       = $request->all();
        foreach ($parameters as $parameter) {
            if ($parameter instanceof Vo) {
                foreach ($all as $key => $value) {
                    $set = 'set' . ucfirst($this->underline2hump($key));
                    if (method_exists($parameter, $set)) {
                        $parameter->$set($value);
                    }
                }
            }
        }
        return $this->{$method}(...array_values($parameters));
    }

    protected function underline2hump($source, bool $isUcFirst = false): string
    {
        $str = trim($source);
        if (false === strpos($str, '_')) {
            return $str;
        }
        $arr = explode('_', $str);
        $str = $arr[0];
        for ($i = 1, $iMax = count($arr); $i < $iMax; ++$i) {
            $str .= ucfirst($arr[$i]);
        }
        if ($isUcFirst) {
            return ucfirst($str);
        }
        return lcfirst($str);
    }
}
