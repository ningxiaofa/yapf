<?php

namespace app\models;

use core\lib\model;

class baseModel extends model implements baseInterface
{
    public $table; // 子类必须定义该属性，并赋值. 如何借助PHP语言本身约束？TBD

    public $primaryKey = 'id';

    //curd操作
    public function all()
    {
        return $this->select($this->table, '*');
    }

    public function getOne($id)
    {
        return $this->get($this->table, '*', [
            'id' => $id
        ]);
    }

    public function getOneByWhere($fields = '*', array $where = [])
    {
        return $this->get($this->table, $fields, $where);
    }

    //下面出现报错!! 具体好的实践写法,TBD
//    public function insert($array)
//    {
//        return parent::insert($this->table, $array);
//    }

    /**
     * 写入[更新/新增]
     * @param $array
     * @return bool|\PDOStatement
     */
    public function save(array $array, array $where = [])
    {
        $id = isset($array[$this->primaryKey]) ? $array[$this->primaryKey]:null;

        if($id){
            if($where){
                return parent::update($this->table, $array, $where)->rowCount();
            }else{
                return parent::update($this->table, $array)->rowCount();
            }
        }else{
            unset($array[$this->primaryKey]);
            return parent::insert($this->table, $array)->rowCount(); //这里parent改为$this亦可
        }
    }

    //更新[根据id进行更新]
    public function setOne($id, array $data)
    {
        return $this->update($this->table, $data, [$this->primaryKey => $id])->rowCount();
    }

    //新增[一条或多条]
    public function add(array $data)
    {
        $this->insert($this->table, $data);
        return $this->id();
    }

    //删除[通过主键id 可以多条删除]
    public function delById($id)
    {
        if(is_array($id)){
            $ret = $this->delete($this->table, [
                "{$this->primaryKey}[IN]" => $id
            ])->rowCount();
        }else{
            $ret = $this->delete($this->table, [
                $this->primaryKey => $id
            ])->rowCount();
        }

        return $ret;
    }

    //删除[where条件]
    public function delByWhere(array $where)
    {
        $ret = $this->delete($this->table, $where)->rowCount();
        return $ret;
    }

}
