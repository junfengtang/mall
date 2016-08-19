<?php

namespace app\modules\controllers;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use app\models\Profile;
use Yii;

class UserController extends Controller
{

	public function actionUsers()
	{
		$model = User::find()->joinWith('profile');
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['user'];
		$pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
		$users = $model->offset($pager->offset)->limit($pager->limit)->all();
		$this->layout = "layout1";
		return $this->render('users', ['users' => $users, 'pager' => $pager]);
	}

	public function actionReg()
	{
		// 设置视图公共部分，如果不需要公共部分视图，$this->layout设为false
		$this->layout = 'layout1';
		// 创建一个user模型
		$model = new User;
		// 判断是否为post请求，然后将post过来的数据传到model进行处理，下面代码都是套路
		if(Yii::$app->request->isPost){
			// 接收post过来的数据
			$post = Yii::$app->request->post();
			// reg为model处理数据，返回true或者false
			if ($model->reg($post)) {
				// 请求的callback
				Yii::$app->session->setFlash('info','添加用户成功');
			}
		}
		// 请求后处理输入框
		$model->userpass = '';
		$model->repass = '';
		return $this->render("reg",['model'=>$model]);
	}

	public function actionDel()
	{
		try {
			$userid = (int)Yii::$app->request->get('userid');
			if (empty($userid)) {
				throw new \Exception();
			}
			$trans = Yii::$app->db->beginTransaction();
			if ($obj = Profile::find()->where('userid=:user',[':user'=>$userid])->one()) {
				$res = Profile::deleteAll('userid=:user',[':user'=>$userid]);
				if (empty($res)) {
					throw new \Exception();
				}
			}
			if (!User::deleteAll('userid=:user',[':user'=>$userid])) {
				throw new \Exception();
			}	
			 $trans->commit();		
		} catch (\Exception $e) {
			if (Yii::$app->db->getTransaction()) {
				$trans->rollback();
			}
		}
		$this->redirect(['user/users']);
	}






}
