<?php

namespace app\controllers;

use yii;
use yii\rest\Controller;

use app\models\Product;

class ProductController extends Controller
{
    public $modelClass = '';

    /**
     * Displays list of products.
     *
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $page = $request->get('page');
        $perPage = $request->get('perpage');
        return Product::findAllProduct(2, $perPage);
    }

}
