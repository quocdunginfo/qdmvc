<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRootSetup extends QdRoot
{
    public function delete()
    {
        $this->pushValidateError('', 'Không thể xóa Setup Record');
        return false;
    }

    public function save($validate = true, $location='')
    {
        if($this->is_new_record())
        {
            if($this->GET()!=null)
            {
                $this->pushValidateError('', 'Setup Page không cho phép thêm mới');
                return false;
            }
        }
        return parent::save($validate, $location);
    }

    public function on_before_create()
    {
        $this->id = 1;
        parent::on_before_create();
    }
}