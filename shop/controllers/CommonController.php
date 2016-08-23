<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Category;
use app\models\Cart;
use app\models\User;
use app\models\Product;
use Yii;

class CommonController extends Controller
{
	public function init()
	{
		$menu = Category::getMenu();
		$this->view->params['menu'] = $menu;

		$tui = Product::find()->where('istui = "1" and ison = "1"')->orderby('createtime desc')->limit(3)->all();
		$new = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(3)->all();
		$hot = Product::find()->where('ishot = "1" and ison = "1"')->orderby('createtime desc')->limit(3)->all();
		$sale = Product::find()->where('issale = "1" and ison = "1"')->orderby('createtime desc')->limit(3)->all();
		$this->view->params['tui'] = (array)$tui;
		$this->view->params['new'] = (array)$new;
		$this->view->params['hot'] = (array)$hot;
		$this->view->params['sale'] = (array)$sale;


	}
}