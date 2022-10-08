<?php

namespace App\Controllers;

use App\Validator\UserListValid;
use App\Vos\UserList;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use LaravelVo\Controller\BaseController;

class UserController extends BaseController
{
    /**
     * @param UserList $list
     * @return array
     * @author: zyb
     * @time: 2022/9/1 10:51:16
     */
    public function getList(UserList $list): array
    {
        // $user = Auth::user();
        (new UserListValid())->check($list, 'list');
        $paginator = User::query()
            ->when(!empty($list->getName()), function (Builder $query) use ($list) {
                $query->where('name', 'like', "%{$list->getName()}%");
            })
            ->when(!empty($list->getEmail()), function (Builder $query) use ($list) {
                $query->where('email', 'like', "%{$list->getEmail()}%");
            })
            ->when(!empty($list->getGender()), function (Builder $query) use ($list) {
                $query->where('gender', $list->getGender());
            })
            ->when(($sort = $list->getSort()) !== null, function (Builder $query) use ($sort) {
                $query->orderBy($sort['key'], $sort['order']);
            })
            ->paginate($list->getPerPage());
        return [
            'code' => 20000,
            'msg'  => '操作成功',
            'data' => $paginator,
        ];
    }
}