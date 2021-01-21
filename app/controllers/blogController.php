<?php

namespace app\controllers;

use core\kernel;
use app\models\blogModel;

class blogController extends kernel
{
    public function list()
    {
        // TBD
    }

    public function detail()
    {
        // TBD
    }

    /**
     * Delete
     */
    public function delete()
    {
        // TBD
        $id = getQsParams('id');
        if(empty($id)) return fail('id not exits');
    }

    /**
     * Add/Update
     */
    public function save()
    {
        $params = getParams();
        $msg = $this->_validate($params);
        if ($msg) return fail($msg);

        $model = new blogModel();
        $data = $model->fillData($params);
        if (empty($params['id'])) {
            // Add
            $id = $model->add($data);
            return success(['id' => $id], 'Add success');
        } else {
            // Update
            unset($data['updated_at']);
            $count = $model->setOne($params['id'], $data);
            return success(['count' => $count], 'Update success');
        }
    }

    protected function _validate()
    {
        $msg = '';

        if (empty($params['title']) || empty($params['content'])) $msg = 'title/content can not be empty';

        return $msg;
    }
}
