<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\User;
use Yii;

class MemberController extends CommonController
{

	public function actionAuth()
	{
		$this->layout = 'layout2';
		$model = new User;
		if (Yii::$app->request->isGet) {
			$url = Yii::$app->request->referrer;
			if (empty($url)) {
				$url = "/";
			}
			Yii::$app->session->setFlash('referrer', $url);
		}
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->login($post)) {
				$this->redirect(['auth']);
				Yii::$app->end();
			}
		}
		return $this->render('auth',['model'=>$model]);
	}

	public function actionLogout()
    {
       Yii::$app->session->removeAll();
       if (!isset(Yii::$app->session['isLogin'])) {
           $this->redirect(['member/auth']);
           Yii::$app->end();
       }
       $this->goback();
    }

	public function actionReg()
	{
		$model = new User;
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if($model->regByMail($post)){
				Yii::$app->session->setFlash('info','添加成功');
			}else{
				Yii::$app->session->setFlash('info','添加失败');
			}
		}
		$this->layout = 'layout2';
		return $this->render('auth',['model'=>$model]);
	}






}