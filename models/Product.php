<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'products';
    }

    public static function findAllProduct() {
        return self::find()->all();
    } 

    public static function checkStock($productId, $quantity) {
        $product = self::findOne($productId);

        if ($product) {
            $availableStock = $product->stock - $product->ordered_stock;
            if ($availableStock >= $quantity) return true;

            // return false when stock availibility is not enough
            return false;
        }

        // return false when no product found
        return false;
    }


    public static function updateOrderedStock($productId, $quantity) {
        $product = self::findOne($productId);
        $product->ordered_stock += $quantity;
        return $product->save();
    }

    public static function updateRealStock($productId, $quantity) {
        $product = self::findOne($productId);
        $product->stock -= $quantity;
        $product->ordered_stock -= $quantity;
        return $product->save();
    }
}