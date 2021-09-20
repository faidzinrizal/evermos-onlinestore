<?php
 
namespace app\components\jobs;
 
use yii\base\BaseObject;
use yii\queue\JobInterface;
use app\models\Product;
use app\models\Order;
use app\models\OrderDetail;
 
class OrderJob extends BaseObject implements JobInterface
{
    public $orderId;
    public function execute($queue)
    {
        $order = Order::findOne($this->orderId);
        $orderDetails = OrderDetail::find()->where(['order_id'=>$this->orderId])->all();
        // check product stock (stock - ordered stock)
        foreach ($orderDetails as $orderDetail) {
            $isAvailable = Product::checkStock($orderDetail['product_id'], $orderDetail['quantity']);

            if (!$isAvailable) break;
        }

        if ($isAvailable) {
            $order->checkoutOrder();
            foreach ($orderDetails as $orderDetail) {
                Product::updateOrderedStock($orderDetail['product_id'], $orderDetail['quantity']);
            }
        } else {
            $order->cancelOrder('some products not available');
        }

        $orderId = $this->orderId;
        return "Job for order #$orderId is done.";
    }
}