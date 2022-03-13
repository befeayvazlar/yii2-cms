<?php

namespace backend\controllers;

use common\models\ProductCategories;
use backend\models\search\ProductCategoriesSearch;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductCategoriesController implements the CRUD actions for ProductCategories model.
 */
class ProductCategoriesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'update', 'delete', 'is-active-setter'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ProductCategories models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new ProductCategoriesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // set default sorting
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        // set default pageSize
        $dataProvider->pagination->pageSize = 10;

        $model = new ProductCategories();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Creates a new ProductCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductCategories();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                Yii::$app->getSession()->setFlash('success',[
                    'type' => 'success',
                    'title' => Html::encode('Success'),
                    'message' => Html::encode('Product Category successfully created.'),

                ]);

                return $this->redirect(['product-categories/']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $category_id Category ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($category_id, $page = null)
    {
        $model = $this->findModel($category_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'category_id' => $model->category_id]);

            Yii::$app->getSession()->setFlash('success',[
                'type' => 'success',
                'title' => Html::encode('Success'),
                'message' => Html::encode('Product Category successfully updated.'),

            ]);

            return $this->redirect(['index', 'page' => $page]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionIsActiveSetter($category_id){

        if (Yii::$app->request->isAjax) {

            $productCategory = ProductCategories::findOne(['category_id' => $category_id]);

            if($productCategory->isActive === 1){
                $isActive = 0;
                $productCategory->isActive = $isActive;
                $productCategory->save(false);
            }else{
                $isActive = 1;
                $productCategory->isActive = $isActive;
                $productCategory->save(false);
            }

        }else{
            $isActive = "Ajax failed";
        }

        // return Json
        return \yii\helpers\Json::encode($isActive);

    }

    /**
     * Deletes an existing ProductCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $category_id Category ID
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($category_id)
    {

        if (Yii::$app->request->isAjax) {

            if ($category_id) {

                $this->findModel($category_id)->delete();

                return true;

            }
        }
        else{
            return false;
        }

        return false;

    }

    /**
     * Finds the ProductCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $category_id Category ID
     * @return ProductCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($category_id)
    {
        if (($model = ProductCategories::findOne(['category_id' => $category_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
