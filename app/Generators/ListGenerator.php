<?php


namespace App\Generators;


class ListGenerator implements IGenerator
{
    /**
     * @var
     */
    private $list;

    /**
     * @param $list
     */
    public function setList(array $list)
    {
        $this->list = $list;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function generate()
    {
        $list = array_values($this->list);
        return $list[random_int(0, count($list) - 1)];
    }
}