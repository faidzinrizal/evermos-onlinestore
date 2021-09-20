<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class Order extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_CHECKOUT = 1; // checkout
    const STATUS_DONE = 2; // paid
    const STATUS_CANCEL = 3;
    public static function tableName()
    {
        return 'orders';
    }

    public function rules() {
        return [
            [
                ['date', 'status',  'customer_id'], 
                'required'
            ],
            [
                ['status_desc'], 
                'safe'
            ],
        ];
    }

    public static function createOrder($customerId, $products) {
        $order = new Order();
        $order->customer_id = $customerId;
        $order->date = date('Y-m-d H:i:s');
        $order->status = self::STATUS_PENDING;
        $order->status_desc = 'On Checking Stock';
        $saved = $order->save();

        if (!$saved) {
            return $order->getErrors();
        }

        $orderDetails = [];
        foreach ($products as $product) {
            $orderDetails[] = [
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ];
        }
        
        $attributes = ['order_id', 'product_id', 'quantity'];
        $saved = Yii::$app->db->createCommand()->batchInsert('order_details',$attributes, $orderDetails)->execute();
        
        if (!$saved) {
            return $saved;
        }

        return $order;
    }

    public function checkoutOrder() {
        $this->status = self::STATUS_CHECKOUT;
        $this->status_desc = 'Checkout. Please do payment.';
        return $this->save();
    }

    public function cancelOrder($reason = 'cancelled') {
        $this->status = self::STATUS_CANCEL;
        $this->status_desc = $reason;
        return $this->save();
    }

    public function payOrder() {
        $this->status = self::STATUS_DONE;
        $this->status_desc = 'Order has been paid. Transaction is done.';
        return $this->save();
    }

    public static function pay($id)
    {
        $order = self::findOne($id);
        $order->payOrder();

        $orderDetails = OrderDetail::find()->where(['order_id'=>$id])->all();
        foreach ($orderDetails as $orderDetail) {
            Product::updateRealStock($orderDetail->product_id, $orderDetail->quantity);
        }

        return $order;
    } 
}