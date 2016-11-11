<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "people".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $keywords
 * @property string $resume
 */
class People extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;

    public static function tableName()
    {
        return 'people';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keywords'], 'string'],
            [['file','first_name', 'last_name'], 'required'],
            [['file'],'file','extensions' => 'docx, doc, txt, pdf'],
            [['first_name', 'last_name', 'resume'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'keywords' => 'Keywords',
            'resume' => 'Resume',
        ];
    }
}
