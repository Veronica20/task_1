<?php

namespace app\controllers;

use app\models\People;
use app\models\SearchForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use yii\data\Pagination;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $people = new People();
        if (Yii::$app->request->isPost) {
            $people->setAttributes(Yii::$app->request->post('People'));
            $people->file = UploadedFile::getInstance($people, 'file');
            if ($people->validate()) {
                $fileName = uniqid().$people->file->name;
                $people->file->saveAs( 'uploads/' . $fileName);
                $people->resume = $fileName;
                if ($people->save(false)) {
                    $this->refresh();
                }
            }
        }
        return $this->render('index', [
            'people' => $people,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionSearch()
    {
        $search_form = new SearchForm();
        $search = Yii::$app->request->get('q');
        $models=[];
        if($search){
            $search_form->setAttributes($search);
            if($search_form->validate()){
                $model = People::find();
                if ($search_form->first_name) {
                    $model->orWhere(['like', 'first_name', $search_form->first_name]);
                }
                if ($search_form->last_name) {
                    $model->orWhere(['like', 'last_name', $search_form->last_name]);
                }
                if ($search_form->keywords) {
                    $keywords_arr = explode( ',', $search_form->keywords );
                    foreach ( $keywords_arr as  $keyword){
                        $model->orWhere(['like', 'keywords', trim($keyword)]);
                    }
                }
                $countQuery = clone $model;
                $pages = new Pagination(['totalCount' => $countQuery->count()]);
                $pages->setPageSize(5);
                $models = $model->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();


            }
        }

        return $this->render('search', [
            'search_form' => $search_form,
            'models' => $models,
            'pages' => $models ? $pages : null,
        ]);
    }

    public function actionDownload($name){
        $path = Yii::getAlias('@webroot') . '/uploads/';

        $file = $path . $name;
        var_dump($file, file_exists($file));
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        }
    }
}
