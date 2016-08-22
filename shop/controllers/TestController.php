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


}