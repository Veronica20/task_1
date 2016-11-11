<?php

/* @var $this yii\web\View */
/* @var $people app\models\People */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\UploadedFile;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row col-md-6">
            <?php $form = ActiveForm::begin(['id' => 'contact-form','options' => ['enctype' => 'multipart/form-data']]); ?>
                 <?= $form->field($people, 'first_name')->textInput(['autofocus' => true]) ?>
                 <?= $form->field($people, 'last_name') ?>
                 <?= $form->field($people, 'keywords') ?>
                 <?= $form->field($people, 'file')->fileInput()?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
