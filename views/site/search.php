<?php

/* @var $this yii\web\View */
/* @var $search_form app\models\People */
/* @var $model app\models\People */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager ;

?>
<div class="site-about">
    <div class="nya">
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(['id' => 'contact-form','method' => 'get']); ?>
            <?= $form->field($search_form, 'first_name')->textInput(['autofocus' => true]) ?>
            <?= $form->field($search_form, 'last_name') ?>
            <?= $form->field($search_form, 'keywords') ?>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-6">
            <?php  if(!empty($models)) : ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Keywords</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($models as $model) { ?>
                        <tr>
                            <td><?= $model->first_name ?></td>
                            <td><?= $model->last_name ?></td>
                            <td><?= $model->keywords ?></td>
                            <td>
                               <a  href="<?= \yii\helpers\Url::to(['site/download', 'name' => $model->resume ])?>"> <?= $rest = substr( $model->resume , 13);  ?> </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
    //             display pagination
                        echo LinkPager::widget([
                            'pagination' => $pages,
                        ]);
                ?>
            <?php  endif; ?>
        </div>
    </div>
</div>
