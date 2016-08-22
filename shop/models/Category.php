<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{

	public static function tableName()
	{
		return "{{%category}}";
	}

	public function attributeLabels()
	{
		return [
		'parentid'=>'上级分类',
		'title'=>'分类名称',
		'createtime'=>'创建时间',
		];
	}

	public function rules()
	{
		return [
		['parentid','required','message'=>'上级分类不能为空'],
		['title','required','message'=>'标题名称不能为空'],
		['createtime','safe'],
		];
	}

	public function add($data)
	{
		$data['Category']['createtime'] = time();
		if ($this->load($data) && $this->save()) {
			return true;
		}
		return false;
	}

	public function getData()
	{
		// 查询出所有数据
		$cates = self::find()->all();
		// 转换为数组
		$cates = ArrayHelper::toArray($cates);
		return $cates;
	}

	public function getTree($cates,$pid = 0)
	{
		$tree = [];
		foreach ($cates as $cate) {
			if ($cate['parentid'] == $pid) {
				$tree[] = $cate;
				$tree =array_merge($tree,$this->getTree($cates,$cate['cateid']));
			}
		}
		return $tree;
	}

	public function setPrefix($data, $p = "|-----")
	{
		$tree = [];
		$num = 1;
		$prefix = [0 => 1];
		while($val = current($data)) {
			$key = key($data);
			if ($key > 0) {
				if ($data[$key - 1]['parentid'] != $val['parentid']) {
					$num ++;
				}
			}
			if (array_key_exists($val['parentid'], $prefix)) {
				$num = $prefix[$val['parentid']];
			}
			$val['title'] = str_repeat($p, $num).$val['title'];
			$prefix[$val['parentid']] = $num;
			$tree[] = $val;
			next($data);
		}
		return $tree;
	}

	public function getOptions()
	{
		$datas = $this->getData();
		$tree = $this->getTree($datas);
		$tree = $this->setPrefix($tree);
		$options = [];
		foreach ($tree as $cate) {
			$options[$cate['cateid']] = $cate['title'];
		}
		return $options;
	}

	public static function getMenu()
	{
		$top = self::find()->where('parentid = :pid', [":pid" => 0])->limit(11)->orderby('createtime asc')->asArray()->all();
		$data = [];
		foreach((array)$top as $k=>$cate) {
			$cate['children'] = self::find()->where("parentid = :pid", [":pid" => $cate['cateid']])->limit(10)->asArray()->all();
			$data[$k] = $cate;
		}
		return $data;
	}






}