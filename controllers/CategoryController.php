<?php

namespace kittyfamous\webmanager\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use kittyfamous\webmanager\models\Category;


class CategoryController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['tree','create','update','move','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actionTree()
    {
        return $this->render('tree');
    }

    public function actionCreate(){
        $model=new Category;
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                if($model->parent==0){
                    $model->root = 1;
                    $model->saveNode();
                }else if($model->parent){
                    $root=$this->findModel($model->parent);
                    $model->appendTo($root);
                }
                return $this->render('tree');
            }
        }
//        else{
//            echo 'failed';
//        }
        else{
            return $this->render('create',[
                'model'=>$model
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent = $model->parent()->one();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveNode();
            if($model->parent==0 && !$model->isRoot()){
                $model->moveAsRoot();
            }elseif($model->parent!=0 && $model->parent != $parent->id){
                $root=$this->findModel($model->parent);
                $model->moveAsLast($root);
            }
            return $this->render('tree');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionMove($id,$updown){
        $model=$this->findModel($id);

        if($updown=='down'){
            $sibling=$model->next()->one();
            if(isset($sibling)){
                $model->moveAfter($sibling);
                return $this->redirect(['tree']);
            }
            return $this->redirect(['tree']);
        }
        if($updown=='up'){
            $sibling=$model->prev()->one();
            if(isset($sibling)){
                $model->moveBefore($sibling);
                return $this->redirect(['tree']);
            }
            return $this->redirect(['tree']);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->deleteNode();

        return $this->redirect(['tree']);
    }

    protected function findModel($id){
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}