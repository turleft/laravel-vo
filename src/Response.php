<?php
/**
 * @author: zyb
 * @time: 2022/10/8 16:40:23
 */


namespace LaravelVo;

use Illuminate\Http\JsonResponse;

/**
 * @author: zyb
 * @time: 2022/10/8 16:40:23
 */
class Response
{
    public const SUCCESS = [
        'code' => 200,
        'message' => '操作成功',
    ];
    public const ERROR = [
        'code' => 400,
        'message' => '操作失败',
    ];

    public const WEEKDAYS = [
        '星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六',
    ];
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string 状态码
     */
    protected $code;

    /**
     * @var string 返回信息
     */
    protected $message;

    /**
     * @var object 对象
     */
    protected $data;

    /**
     * @var object 对象
     */
    protected $extra = [];


    /**
     * @param $data
     * @param string $message
     * @param $extra
     * @return JsonResponse
     * @author: zyb
     * @time: 2022/10/8 16:42:57
     */
    public static function success($data = '', string $message = '', $extra = ''): JsonResponse
    {
        $result = new self();
        $result->isSuccess(true)
            ->code(self::SUCCESS['code'])
            ->message(!empty($message) ? $message : self::SUCCESS['message'])
            ->data($data)
            ->extra($extra);
        return $result->send();
    }

    /**
     * @param string $message
     * @param $data
     * @param $extra
     * @return JsonResponse
     * @author: zyb
     * @time: 2022/10/8 16:45:11
     */
    public static function error(string $message = '', $data = '', $extra = ''): JsonResponse
    {
        $result = new self();
        $result->isSuccess(false)
            ->code(self::ERROR['code'])
            ->message(!empty($message) ? $message : self::ERROR['message'])
            ->data($data)
            ->extra($extra);
        return $result->send();
    }

    /**
     * @param $message
     * @param $data
     * @param $extra
     * @return JsonResponse
     * @author: zyb
     * @time: 2022/10/8 16:45:16
     */
    public static function ok($message = '', $data = '', $extra = ''): JsonResponse
    {
        $result = new self();
        $result->isSuccess(true)
            ->code(self::SUCCESS['code'])
            ->message(!empty($message) ? $message : self::SUCCESS['message'])
            ->data($data)
            ->extra($extra);
        return $result->send();
    }

    /**
     * @param $result
     * @return JsonResponse
     * @author: zyb
     * @time: 2022/10/8 16:45:19
     */
    public function send($result = null): JsonResponse
    {
        if ($result) {
            return response()->json($result);
        }
        $result = [
            'code' => $this->code,
            'message' => $this->message,
        ];
        if (is_array($this->data)||!empty($this->data)) {
            $result['data'] = $this->data;
        }
        if (!empty($this->extra)) {
            $result['extra'] = $this->extra;
        }
        return response()->json($result);
    }

    /**
     * @param $success
     * @return $this
     * @author: zyb
     * @time: 2022/10/8 16:45:22
     */
    public function isSuccess($success): self
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @param $code
     * @return $this
     * @author: zyb
     * @time: 2022/10/8 16:45:26
     */
    public function code($code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param $message
     * @return $this
     * @author: zyb
     * @time: 2022/10/8 16:45:28
     */
    public function message($message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     * @author: zyb
     * @time: 2022/10/8 16:45:31
     */
    public function data($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $extra
     * @return $this
     * @author: zyb
     * @time: 2022/10/8 16:45:38
     */
    public function extra($extra): self
    {
        $this->extra = $extra;
        return $this;
    }

}
