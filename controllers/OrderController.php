<?php

namespace app\controllers;

use yii;
use yii\rest\Controller;
use app\models\Order;

use app\components\jobs\OrderJob;
use app\models\OrderDetail;

class OrderController extends Controller
{
    public $modelClass = '';

    public function actionIndex() {
        return Order::find()
            ->leftJoin('order_details', 'orders.id = order_details.order_id')
            ->asArray()->all();
    }

    public function actionDetail() {
        $request = Yii::$app->request;
        $id = $request->get('order_id');

        return OrderDetail::find()
            ->select([
                'order_details.*',
                'products.*',
                'merchants.*',
            ])
            ->leftJoin('products', 'products.id = order_details.product_id')
            ->leftJoin('merchants', 'products.merchant_id = merchants.id')
            ->where(['order_id' => $id])->asArray()->all();
    }

    /** 
     * action Execute New Order
     * @param json customer_id and product_list
     * @return object order with pending status
     */
    public function actionNew()
    {
        $request = Yii::$app->request;

        $customerId = $request->post('customer_id');
        $productList = $request->post('product_list');

        $order = Order::createOrder($customerId, $productList);

        // send a job to check availibility of a product when Race Condition
        $id = Yii::$app->queue->push(new OrderJob(['orderId'=>$order->id]));

        return ['order'=>$order, 'queue_id'=>$id];
    }

    /** 
     * action pay the checkout order
     * to sure the order is fixed and real stock will update
     * @param json order id
     * @return object order with 
     */
    public function actionPay()
    {
        $request = Yii::$app->request;
        
        $orderId = $request->post('order_id');

        $paidOrder = Order::pay($orderId);
        
        return $paidOrder;
    }
}
