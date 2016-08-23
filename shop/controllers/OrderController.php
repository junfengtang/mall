<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\Order;

class OrderController extends Controller
{
	public function actionIndex()
	{
		$this->layout="layout2";
		return $this->render('index');
	}

	public function actionCheck()
	{
		$this->layout="layout1";
		return $this->render('check');
	}

	public function acrionAdd()
	{
		if (Yii::$app->session['isLogin']!=1) {
			return $this->redirect(['member/auth']);
		}
	}
	
	
	
}