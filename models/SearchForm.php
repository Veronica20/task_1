<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/10/2016
 * Time: 9:20 PM
 */

namespace app\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{
    public $first_name;
    public $last_name;
    public $keywords;

    public function formName()
    {
        return 'q';
    }

    public function beforeValidate()
    {
        if(empty($this->first_name) && empty($this->last_name) && empty($this->keywords)){
            $this->addError('first_name','please write some text');
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keywords'], 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'keywords' => 'Keywords',
        ];
    }

}