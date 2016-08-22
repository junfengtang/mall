<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\bootstrap\Alert;
?>
<meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>"/>
<style>.span8 div{ display:inline; } .help-block-error { color:red; display:inline; }</style>
<link rel="stylesheet" href="assets/admin/css/compiled/new-user.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加商品</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                    <?php if( Yii::$app->getSession()->hasFlash('success') ) {
                        echo Alert::widget([
                            'options' => [
                                'class' => 'alert-success', //这里是提示框的class
                            ],
                            'body' => Yii::$app->getSession()->getFlash('success'), //消息体
                        ]);
                    }
                        if( Yii::$app->getSession()->hasFlash('error') ) {
                        echo Alert::widget([
                            'options' => [
                                'class' => 'alert-error',
                            ],
                            'body' => Yii::$app->getSession()->getFlash('error'),
                        ]);
                         }
                    ?>
                        <form id="w0" class="new_user_form inline-input" action="/index.php?r=admin%2Fproduct%2Fadd" method="post" enctype="multipart/form-data">
                           <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                            <div class="form-group field-cates required">
                                <div class="span12 field-box">
                                    <label class="control-label" for="cates">分类名称</label>
                                    <select id="cates" class="form-control" name="Product[cateid]">
                                    <?php foreach($opts as $lis=>$val):?>
                                        <option value="<?php echo $lis;?>"><?php echo $val;?></option>
                                    <?php endforeach; ?>
                                        </select>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-title required">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-title">商品名称</label>
                                    <input type="text" id="product-title" class="span9" name="Product[title]" value="<?php echo $model->title;?>">
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-wysi required">
                                <div class="span12 field-box">
                                    <label class="control-label" for="wysi">商品描述</label>
                                    <textarea id="wysi" class="span9 wysihtml5" name="Product[descr]" style="margin-left:120px">
                                        <?php echo $model->descr;?>
                                    </textarea>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-price required">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-price">商品价格</label>
                                    <input type="text" id="product-price" class="span9" name="Product[price]" value="<?php echo $model->price;?>"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-ishot">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-ishot">是否热卖</label>
                                    <div id="product-ishot" class="span8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[ishot]" value="0">不热卖</label></div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[ishot]" value="1">热卖</label></div>
                                    </div>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-issale">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-issale">是否促销</label>
                                    <div id="product-issale" class="span8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[issale]" value="0">不促销</label></div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[issale]" value="1">促销</label></div>
                                    </div>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-saleprice">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-saleprice">促销价格</label>
                                    <input type="text" id="product-saleprice" class="span9" name="Product[saleprice]" value="<?php echo $model->saleprice;?>"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-num">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-num">库存</label>
                                    <input type="text" id="product-num" class="span9" name="Product[num]" value="<?php echo $model->num;?>"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-ison">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-ison">是否上架</label>
                                    <div id="product-ison" class="span8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[ison]" value="0">下架</label></div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[ison]" value="1">上架</label></div>
                                    </div>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-istui">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-istui">是否推荐</label>
                                    <div id="product-istui" class="span8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[istui]" value="0">不推荐</label></div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Product[istui]" value="1">推荐</label></div>
                                    </div>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-cover required">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-cover">图片封面</label>
                                    <input type="hidden" name="Product[cover]" value="">
                                    <input type="file" id="product-cover" class="span9" name="Product[cover]"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-product-pics">
                                <div class="span12 field-box">
                                    <label class="control-label" for="product-pics">商品图片</label>
                                    <input type="hidden" name="Product[pics][]" value="">
                                    <input type="file" id="product-pics" class="span9" name="Product[pics][]" multiple></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <hr>
                            <input type='button' id="addpic" value='增加一个'>
                            <div class="span11 field-box actions">
                                <?php echo Html::submitButton('提交', ['class' => 'btn-glow primary']); ?>
                                    <span>OR</span>
                                    <?php echo Html::resetButton('取消', ['class' => 'reset']); ?>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填入要添加的商品信息,包括商品名称,描述,图片等</div>
                    <h6>商城用户说明</h6>
                    <p>可以在前台进行购物</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->	
