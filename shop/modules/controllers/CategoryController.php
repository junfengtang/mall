<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\models\Category;

class CategoryController extends Controller
{
	public function actionList()
	{
		$this->layout = 'layout1';
		$model = new Category();
		$list = $model->getOptions($model);	
		return $this->render('cates',['list'=>$list,'model'=>$model]);
	}

	public function actionAdd()
	{
		$this->layout = 'layout1';
		$model = new Category();
		$list = $model->getOptions($model);	
		$list[0] = "请添加顶级分类";
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->add($post)) {
				Yii::$app->session->setFlash('info','添加成功');
			}
		}
		return $this->render('add',['list'=>$list,'model'=>$model]);
	}

	public function actionMod()
	{
		$this->layout = 'layout1';
		$cateid = Yii::$app->request->get('cateid');
		$model = Category::find()->where('cateid=:id',[':id'=>$cateid])->one();
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->load($post)&&$model->save()) {
				Yii::$app->session->setFlash('info','修改成功');
			}
		}
		$list = $model->getOptions();	
		return $this->render('add',['list'=>$list,'model'=>$model]);
	}

	public function actionDel()
	{
		try {
			$cateid = (int)Yii::$app->request->get('cateid');
			$model = new Category;
			if (empty($cateid)) {
				Yii::$app->session->setFlash('info','参数错误');
			}
			$data = $model->find()->where('parentid=:id',[':id'=>$cateid])->one();
			if ($data) {
				Yii::$app->session->setFlash('info','改分类下有子类不能删除');
			}
			if (!$model->deleteAll('cateid=:id',[':id'=>$cateid])) {
				Yii::$app->session->setFlash('info','删除失败');
			}
		} catch (Exception $e) {
			Yii::$app->session->setFlash('info', $e->getMessage());
		}
		return $this->redirect(['category/list']);
	}
	
}
