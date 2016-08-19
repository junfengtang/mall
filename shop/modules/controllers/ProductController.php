<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use yii\data\Pagination;
use app\models\Product;
use app\models\Category;
use crazyfd\qiniu\Qiniu;

class ProductController extends Controller
{

	public function actionList()
	{
		$this->layout = "layout1";
		$model = Product::find();
		$count = $model->count();
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>'10']);
		$products = $model->offset($pager->offset)->limit($pager->limit)->all();
		return $this->render("products",['products'=>$products,'pager'=>$pager]);
	}

	public function actionAdd()
	{
		$this->layout = "layout1";
		$model = new Product;
		$cate = new Category;
		$list = $cate->getOptions();
		unset($list[0]);
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			$pics = $this->upload();
			if (!$pics) {
				$model->addError('cover', '封面不能为空');
			} else {
				$post['Product']['cover'] = $pics['cover'];
				$post['Product']['pics'] = $pics['pics'];
			}
			if ($pics && $model->add($post)) {
				Yii::$app->session->setFlash('success', '添加成功');
			} else {
				Yii::$app->session->setFlash('error', '添加失败');
			}
		}
		return $this->render("add", ['opts' => $list, 'model' => $model]);
	}

	public function actionDel()
	{
		$productid = (int)Yii::$app->request->get('productid');
		if (empty($productid)) {
			$this->redirect(["product/list"]);
		}
		$model = new Product;
		if ($model->deleteAll('productid=:id',[':id'=>$productid])){
			$this->redirect(["product/list"]);
			Yii::$app->session->setFlash('info','删除成功');
		}
	}

	public function actionOn()
	{
		$productid = (int)Yii::$app->request->get('productid');
		if (empty($productid)) {
			$this->redirect(["product/list"]);
		}
		$model = new Product;
		$model->updateAll(['ison'=>'1'],'productid=:id',[':id'=>$productid]);
		return $this->redirect(['product/list']);
	}


	public function actionOff()
	{
		$productid = (int)Yii::$app->request->get('productid');
		if (empty($productid)) {
			$this->redirect(["product/list"]);
		}
		$model = new Product;
		$model->updateAll(['ison'=>'0'],'productid=:id',[':id'=>$productid]);
		return $this->redirect(["product/list"]);
	}

	public function actionMod()
    {
        $this->layout = "layout1";
        $cate = new Category;
        $list = $cate->getOptions();
        unset($list[0]);

        $productid = Yii::$app->request->get("productid");
        $model = Product::find()->where('productid = :id', [':id' => $productid])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $qiniu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
            $post['Product']['cover'] = $model->cover;
            if ($_FILES['Product']['error']['cover'] == 0) {
                $key = uniqid();
                $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
                $post['Product']['cover'] = $qiniu->getLink($key);
                $qiniu->delete(basename($model->cover));

            }
            $pics = [];
            foreach($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
                if ($_FILES['Product']['error']['pics'][$k] > 0) {
                    continue;

                }
                $key = uniqid();
                $qiniu->uploadfile($file, $key);
                $pics[$key] = $qiniu->getlink($key);

            }
            $post['Product']['pics'] = json_encode(array_merge((array)json_decode($model->pics, true), $pics));
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '修改成功');
            }

        }
       // var_dump($model);
        return $this->render('add', ['model' => $model, 'opts' => $list]);

    }

	private function upload()
	{
		if ($_FILES['Product']['error']['cover'] > 0) {
			return false;
		}
		$qiniu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
		$key = uniqid();
		$qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
		$cover = $qiniu->getLink($key);
		$pics = [];
		foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
			if ($_FILES['Product']['error']['pics'][$k] > 0) {
				continue;
			}
			$key = uniqid();
			$qiniu->uploadFile($file, $key);
			$pics[$key] = $qiniu->getLink($key);
		}
		return ['cover' => $cover, 'pics' => json_encode($pics)];
	}





}