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
	}
}