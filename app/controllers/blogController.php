<?php

namespace app\controllers;

use core\kernel;
use app\models\blogModel;
use core\common\session;

class blogController extends kernel
{
    public function list()
    {
        $model = new blogModel();
        // $userInfo = (new session)::get('userinfo');
        // $rows = $model->all(['created_user' => $userInfo['id']]);
        $rows = $model->all();

        return success($rows);
    }

    public function detail()
    {
        $blogId = (int)getUrlParams('id');
        if (empty($blogId)) return fail('blog id does not exist');

        $model = new blogModel();
        $row = $model->getOneByWhere('*', [
            'id' => $blogId
        ]);

        if (empty($row)) {
            return success($row, 'blog does not exist');
        }

        // Increase view count
        $this->_increaseViewCount($model, $row['id'], ++$row['viewed_count']);

        return success($row);
    }

    protected function _increaseViewCount(&$model, $id, $count)
    {
        // 方案优化:
        // 1. 执行 SQL 自增语句
        // 2. 使用 redis 自增函数
        $model->setOne((int)$id, [
            'viewed_count' => (int)$count
        ]);
    }

    /**
     * Delete
     */
    public function delete()
    {
        $id = (int)getParams('id');
        if (empty($id)) return fail('id not exits');

        $model = new blogModel();
        $row = $model->getOne($id);
        if(empty($row)){
            return fail('blog does not exist', 404);
        }
        if($row['created_user'] != (new session())::get('userinfo')['id']){
            return fail('You have no permission', 403);
        }
        // var_dump($row);
        // exit('123');
        $count = $model->delById($id);

        return success(['row' => $count], 'delete success');
    }

    /**
     * Add/Update
     */
    public function save()
    {
        // Judge whether is logined
        if (!(new session())::get('userinfo')) {
            return fail('user does not login');
        }

        $params = getParams();
        $msg = $this->_validate($params);
        if ($msg) return fail($msg);

        $model = new blogModel();
        $data = $model->fillData($params);
        if (empty($data)) {
            return fail('Save fail');
        }
        if (empty($params['id'])) {
            // Add
            $id = $model->add($data);
           
            if($id <= 0){
                return fail('Add fail');
            }
            return success(['id' => (int)($id)], 'Add success');
        } else {
            // Update
            unset($data['created_user']);
            unset($data['created_at']);
            $count = $model->setOne($params['id'], $data);
            return success(['count' => $count], 'Update success');
        }
    }

    protected function _validate($params)
    {
        $msg = '';

        if (empty($params['title']) || empty($params['content'])) $msg = 'title/content can not be empty';

        return $msg;
    }
}
