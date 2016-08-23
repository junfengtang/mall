<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Category;
use app\models\Cart;
use app\models\User;
use app\models\Product;
use Yii;

class TestController extends Controller
{
 public function actionIndex()
 {
 	//echo "tangjunfeng";
 	$cache = Yii::$app->cache;
 //	$cache->add('key1','helloworld');
 	$cache -> delete('key1');
 	var_dump($cache->get('key1'));
 }
 public function actionInfo()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
        'message' => 'hello world',
        'code' => 100,
    ];
}


}