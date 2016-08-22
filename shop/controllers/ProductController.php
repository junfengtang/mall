<?php
namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\Product;
use yii\data\Pagination;

class ProductController extends CommonController
{

    public function actionIndex()
    {
        $this->layout="layout2";
        return $this->render("index");
    }
    public function actionDetail()
    {
        $this->layout="layout2";
        $productid = Yii::$app->request->get('productid');
        $product = Product::find()->where('productid=:id',[':id'=>$productid])->asArray()->one();
        return $this->render("detail",['product'=>$product]);
    }
}