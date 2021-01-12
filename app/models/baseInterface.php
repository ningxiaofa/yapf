<?php

namespace app\models;

interface baseInterface {
    // public $table;

    // public $primaryKey;

    //curd操作
    public function all();

    public function getOne($id);

    /**
     * 写入[更新/新增]
     * @param $array
     * @return bool|\PDOStatement
     */
    public function save(array $array, array $where = []);

    //更新[根据id进行更新]
    public function setOne($id, array $data);

    //新增[一条或多条]
    public function add(array $data);

    //删除[通过主键id 可以多条删除]
    public function delById($id);

    //删除[where条件]
    public function delByWhere(array $where);
}