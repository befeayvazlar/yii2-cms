<?php

namespace backend\controllers;

use common\models\Product;
use backend\models\search\ProductSearch;
use common\models\ProductImage;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                            'actions' => ['index', 'view', 'update', 'create', 'delete', 'image', 'image-upload'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'image-upload' => ['POST']
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // set default sorting
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        // set default pageSize
        $dataProvider->pagination->pageSize = 2;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $product_id Product ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($product_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'product_id' => $model->product_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $product_id Product ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id)
    {
        $model = $this->findModel($product_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Display by Product ID Image an existing Product model.
     * @param string $product_id Product ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionImage($product_id)
    {
        $model = $this->findModel($product_id);

        return $this->render('image', [
            'model' => $model
        ]);

    }

    /**
     * Upload Dropzone by Product ID Images an existing Product model.
     * @param string $product_id Product ID
     * @return string
     */
    public function actionImageUpload($product_id){

        $productImage = new ProductImage();

        $productImage->file = UploadedFile::getInstancesByName('file');

        if($productImage->file){
                foreach ($productImage->file as $file){

                    $thumbnailPath = Yii::getAlias('@frontend/web/storage/product/thumbs/'.$file->baseName.'-'.$product_id.'.'.$file->extension);
                    if(!is_dir(dirname($thumbnailPath))){
                        FileHelper::createDirectory(dirname($thumbnailPath));
                    }

                    $productImage = new ProductImage();
                    $productImage->product_id = $product_id;
                    $productImage->img_url = $file->baseName.'-'.$product_id.'.'.$file->extension;
                    $productImage->rank = 0;
                    $productImage->isCover = 0;
                    $productImage->isActive = 1;
                    //$productImage->created_at = time();
                    //$productImage->updated_at = time();
                    $productImage->created_by = Yii::$app->user->id;
                    $productImage->updated_by = Yii::$app->user->id;

                    if($productImage->save(false)){
                        $file->saveAs($thumbnailPath);
                    }
                    else{
                        return 'Upload Error!';
                    }
                }
            return 'Upload Successfully and Save Database';
        }
        else{
            return 'File is does not exist';
        }

    }


    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $product_id Product ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($product_id)
    {
        $this->findModel($product_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $product_id Product ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id)
    {
        if (($model = Product::findOne(['product_id' => $product_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
