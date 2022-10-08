<?php
/**
 *
 * Created by PhpStorm.
 * author zyb
 * time   2022/9/2 14:47:32
 */


namespace LaravelVo\Validator;


use LaravelVo\Response;
use LaravelVo\Vos\Vo;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

abstract class Valid extends Validator
{
    //所有的验证都可以写在这个数组里面
    protected $rule;
    //所有的验证信息提示都可以写在这个数组里面
    protected $message;
    //验证场景
    protected $scene;

    /**
     * 重写验证场景
     * @param $data
     * @param $scene
     * @return array
     */
    public function check($data, $scene): array
    {
        $input     = $this->getInput($data, $scene);
        $rules     = $this->getRules($scene);
        $messages  = $this->getMessage($rules);
        $validator = Validator::make($input, $rules, $messages);

        //返回错误信息
        if ($validator->fails()) {
            //返回错误信息
            throw (new HttpResponseException(response()->json(['code' => Response::ERROR['code'], 'message' => $validator->errors()->first()], 200)));
        }
        return $input;
    }

    /**
     * 获取验证数据
     * @param $inputs
     * @param $scene
     * @return array
     * @author: zyb
     * @time: 2022/9/2 14:47:32
     */
    public function getInput($inputs, $scene): array
    {
        if ($inputs instanceof Vo) {
            $inputs = $inputs->toArray();
        }
        $input = [];
        foreach ($this->scene[$scene] as $v) {
            if (array_key_exists($v, $inputs)) {
                $input[$v] = $inputs[$v];
            }
        }
        return $input;
    }

    /**
     * 获取验证规则
     * @param $scene
     * @return mixed
     */
    public function getRules($scene): array
    {
        $rules = [];
        if ($this->scene[$scene]) {
            foreach ($this->scene[$scene] as $field) {
                if (array_key_exists($field, $this->rule)) {
                    $rules[$field] = $this->rule[$field];
                }
            }
        }
        return $rules;
    }


    /***
     * 返回验证message
     * @param $rules
     * @return array
     */
    public function getMessage($rules): array
    {
        $message = [];
        foreach ($rules as $key => $v) {
            $arr = explode('|', $v);
            foreach ($arr as $k => $val) {
                if (strpos($val, ':')) {
                    unset($arr[$k]);
                    $arr[] = substr($val, 0, strpos($val, ':'));
                }

            }
            foreach ($arr as $value) {
                if (array_key_exists($key . '.' . $value, $this->message)) {
                    $message[$key . '.' . $value] = $this->message[$key . '.' . $value];
                }
            }
        }
        return $message;
    }
}
