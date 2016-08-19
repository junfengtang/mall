<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord
{
  public $repass;
  public $loginname;
  public $rememberMe;
  // 模型对于的表，s省略前缀的写法
  public static function tableName()
  {
    return "{{%user}}";
  }
  // 表单验证的写法，required，unique，email，compare等为一些自带的验证；而像validatePass，则为自定义验证方法
  public function rules()
  {
    return [
    ['loginname', 'required', 'message' => '登录名不能为空', 'on' => ['login']],
    ['username', 'required', 'message' => '用户名不能为空', 'on' => ['reg']],
    ['username','unique','message'=>'用户名已被注册','on'=>['reg']],
    ['useremail', 'required', 'message' => '用户邮箱不能为空', 'on' => ['reg','regbymail']],
    ['useremail', 'email', 'message' => '用户邮箱格式不正确', 'on' => ['reg','regbymail']],
    ['useremail','unique','message'=>'用户邮箱已被注册','on'=>['reg','regbymail']],
    ['userpass', 'required', 'message' => '密码不能为空', 'on' => ['reg','login']],
    ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['reg']],
    ['repass','compare','compareAttribute'=>'userpass','message'=>'两次密码输入不一致','on'=>['reg']],
    ['userpass', 'validatePass', 'on' => ['login']],
    ];
  }

  public function attributeLabels()
  {
    return [
    'username'=>'用户名',
    'useremail'=>'用户邮箱',
    'userpass'=>'用户密码',
    'repass'=>'确认密码',
    'createtime'=>'创建时间',
    'loginname' => '用户名/电子邮箱',
    ];
  }

  public function validatePass()
  {
     if (!$this->hasErrors()) {
            $loginname = "username";
            if (preg_match('/@/', $this->loginname)) {
                $loginname = "useremail";
            }
            $data = self::find()->where($loginname.' = :loginname and userpass = :pass', [':loginname' => $this->loginname, ':pass' => md5($this->userpass)])->one();
            if (is_null($data)) {
                $this->addError("userpass", "用户名或者密码错误");
            }
        }
  }

  public function reg($data, $scenario = 'reg')
  {
    // 注册验证方法，要验证那些字段，到上面rules中进行注册
    $this->scenario = $scenario;
    // 下面的代码也是套路，载入controller传过来的数据，和验证数据；最后进行数据库(save,deleteAll,updateAll等)处理
    if ($this->load($data) && $this->validate()) {
      $this->username = $data['User']['username'];
      $this->userpass = $data['User']['userpass'];
      $this->createtime = time();
      $this->userpass = md5($this->userpass);
      // 存数据库
      if ($this->save(false)) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function login($data)
  {
    $this->scenario = 'login';
    if ($this->load($data) && $this->validate()) {
      $lifetime = $this->rememberMe?24*3600:0;
      $session = Yii::$app->session;
      session_set_cookie_params($lifetime);
      $session['loginname'] = $this->loginname;
      $session['isLogin'] = 1;
      return (bool)$session['isLogin'];
    }
    return false;
  }


  public function getProfile()
  {
    return $this->hasOne(Profile::className(), ['userid' => 'userid']);
  }

  public function regByMail($data)
  {
    $data['User']['username'] = 'imooc_'.uniqid();
    $data['User']['userpass'] = uniqid();
    $this->scenario = 'regbymail';
    if ($this->load($data) && $this->validate()) {
      $mailer = Yii::$app->mailer->compose('regbymail',['username'=>$data['User']['username'],'userpass'=>$data['User']['userpass']]);
      $mailer->setTo($data['User']['useremail']);
      $mailer->setSubject("慕课商城");
      if ($mailer->send() && $this->reg($data,'regbymail')) {
        return true;
      }
    }
    return false;
  }







}