<?php
namespace app\controllers;

use app\controllers\CommonController;
use app\models\Test;

class IndexController extends CommonController
{
    
    public function actionIndex()
    {
      $this->layout= "layout1";
      return $this->render('index');
    }
}