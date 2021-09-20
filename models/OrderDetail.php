<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class OrderDetail extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_details';
    }

    public function rules() {
        return [
            [
                ['order_id', 'product_id', 'quantity'], 
                'required'
            ],
        ];
    }
}