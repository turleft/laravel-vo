<?php
/**
 *
 * Created by PhpStorm.
 * author zyb
 * time   2022/9/2 14:47:32
 */


namespace App\Vos;

use LaravelVo\Vos\Vo;

class BaseList extends Vo
{
    private $page = 1;
    private $perPage = 10;
    private $sort;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    /**
     * @return array|null
     * @author: zyb
     * @time: 2022/9/1 11:09:43
     */
    public function getSort(): ?array
    {
        $sortStr = $this->sort ?? '-created_at';
        if (strpos($sortStr, '-') === 0) {
            return [
                'key'   => substr($sortStr, 1),
                'order' => 'desc'
            ];
        }
        if (strpos($sortStr, '+') === 0) {
            return [
                'key'   => substr($sortStr, 1),
                'order' => 'asc'
            ];
        }
        return null;
    }


    /**
     * @param mixed $sort
     */
    public function setSort($sort): void
    {
        $this->sort = $sort;
    }
}
