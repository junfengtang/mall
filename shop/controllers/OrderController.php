<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\Order;
use app\models\OrderDetail;
use app\models\User;
use app\models\Product;
use app\models\Cart;

class OrderController extends CommonController
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

	public function actionAdd()
	{
		if (Yii::$app->session['isLogin']!=1) {
			return $this->redirect(['member/auth']);
		}
		$transaction = Yii::$app->db->beginTransaction();
		try {
			if (Yii::$app->request->isPost) {
				$post = Yii::$app->request->post();
				$ordermodel = new Order;
				$ordermodel->scenario = 'add';
				$usermodel = User::find()->where('username = :name or useremail = :email', [':name' => Yii::$app->session['loginname'], ':email' => Yii::$app->session['loginname']])->one();
				if (!$usermodel) {
					throw new \Exception();
				}
				$userid = $usermodel->userid;
				$ordermodel->userid = $userid;
				$ordermodel->status = Order::CREATEORDER;
				$ordermodel->createtime = time();
				if (!$ordermodel->save()) {
					throw new \Exception();
				}
				$orderid = $ordermodel->getPrimaryKey();
				foreach ($post['OrderDetail'] as $product) {
					$model = new OrderDetail;
					$product['orderid'] = $orderid;
					$product['createtime'] = time();
					$data['OrderDetail'] = $product;
					if (!$model->add($data)) {
						throw new \Exception();
					}
					Cart::deleteAll('productid=:pid',[':pid'=>$product['productid']]);
					Product::updateAllCounters(['num'=>-$product['productnum']],'productid=:pid',[':pid'=>$product['productid']]);
				}
			}
			$transaction->commit();
		} catch (\Exception $e) {
			$transaction->rollback();
			return $this->redirect(['cart/index']);
		}
		return $this->redirect(['order/check','orderid' => $orderid]);
	}
	
	
	
}