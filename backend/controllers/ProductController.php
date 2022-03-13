<?php

namespace backend\controllers;

use common\models\Product;
use backend\models\search\ProductSearch;
use common\models\ProductImage;
use Imagine\Image\Box;
use Yii;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\imagine\Image;
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
                            'actions' => ['index', 'view', 'update', 'create', 'delete', 'image', 'image-upload', 'image-reflesh-list', 'image-delete', 'delete-all-image', 'is-active-setter', 'is-cover-setter'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'image-upload' => ['POST'],
                        'image-delete' => ['POST'],
                        'delete-all-image' => ['POST'],
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
    public function actionIndex($pageSize = 10)
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $pageSize);

        // set default sorting
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        // set default pageSize
        //$dataProvider->pagination->pageSize = 10;


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pageSize' => $pageSize
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

                Yii::$app->getSession()->setFlash('success',[
                    'type' => 'success',
                    'message' => Html::encode('Ürün başarılı olarak eklendi.'),
                    'title' => Html::encode('İşlem Başarılı'),
                ]);

                return $this->redirect(['image', 'product_id' => $model->product_id]);
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
            return $this->redirect(['image', 'product_id' => $model->product_id]);
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

        $productImageCount = ProductImage::find()->andWhere(['product_id' => $product_id])->count();

        $dataProvider = new ActiveDataProvider([
            'query' => ProductImage::find()->andWhere(['product_id' => $product_id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        return $this->render('image', [
            'model' => $model,
            'productImageCount' => $productImageCount,
            'dataProvider' => $dataProvider
        ]);

    }

    /**
     * Upload Dropzone by Product ID Images an existing Product model.
     * @param string $product_id Product ID
     * @return string
     */
    public function actionImageUpload($product_id)
    {

        $productImage = new ProductImage();

        $productImage->file = UploadedFile::getInstancesByName('file');

        if ($productImage->file) {
            foreach ($productImage->file as $file) {

                $thumbnailPath = Yii::getAlias('@frontend/web/storage/product/thumbs/'. $product_id. '/'. $file->baseName . '-' . $product_id . '.' . $file->extension);
                $coverPath = Yii::getAlias('@frontend/web/storage/product/342x215/'. $product_id. '/'. $file->baseName . '-' . $product_id . '.' . $file->extension);
                $largePath = Yii::getAlias('@frontend/web/storage/product/1080x426/'. $product_id. '/'. $file->baseName . '-' . $product_id . '.' . $file->extension);
                if (!is_dir(dirname($thumbnailPath))) {
                    FileHelper::createDirectory(dirname($thumbnailPath));
                }

                if (!is_dir(dirname($coverPath))) {
                    FileHelper::createDirectory(dirname($coverPath));
                }

                if (!is_dir(dirname($largePath))) {
                    FileHelper::createDirectory(dirname($largePath));
                }

                $productImage = new ProductImage();
                $productImage->product_id = $product_id;
                $productImage->img_url = $product_id. '/'. $file->baseName . '-' . $product_id . '.' . $file->extension;
                $productImage->rank = 0;
                $productImage->isCover = 0;
                $productImage->isActive = 1;
                //$productImage->created_at = time();
                //$productImage->updated_at = time();
                $productImage->created_by = Yii::$app->user->id;
                $productImage->updated_by = Yii::$app->user->id;

                if ($productImage->save(false)) {
                    $file->saveAs($thumbnailPath);

                    $thumbnail = Image::getImagine()->open($thumbnailPath)->thumbnail(new Box(150, 150));
                    $cover = Image::getImagine()->open($thumbnailPath)->thumbnail(new Box(342, 215));
                    $large = Image::getImagine()->open($thumbnailPath)->thumbnail(new Box(1080, 426));
                    $thumbnail->save();
                    $cover->save($coverPath);
                    $large->save($largePath);

                } else {
                    return 'Upload Error!';
                }
            }
            //return 'Upload Successfully and Save Database';

            $model = $this->findModel($product_id);

            $dataProvider = new ActiveDataProvider([
                'query' => ProductImage::find()->andWhere(['product_id' => $product_id])->orderBy('created_at DESC'),
                'pagination' => [
                    'pageSize' => 10
                ],
            ]);

            return $this->renderAjax('_image_list', [
                'model' => $model,
                'dataProvider' => $dataProvider
            ]);

        } else {
            return 'File is does not exist';
        }

    }

    public function actionImageRefleshList($product_id) {

        $model = $this->findModel($product_id);

        $dataProvider = new ActiveDataProvider([
            'query' => ProductImage::find()->andWhere(['product_id' => $product_id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        return $this->renderAjax('_image_list', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);

    }

    /**
     * @param integer $id ID
     * @throws \yii\db\StaleObjectException
     * @throws \yii\base\ErrorException
     */
    public function actionImageDelete($id){

        if (Yii::$app->request->isAjax) {

            if ($id) {

                $productImage = ProductImage::findOne(['id' => $id]);
                $productImage->delete();

                $this->afterImageDelete($productImage->img_url);

                //return $this->redirect(['image', 'product_id' => $productImage->product_id]);
                return true;
            }

        }
        else{
            return false;
        }

        return false;

    }

    /**
     * @throws \yii\base\ErrorException
     */
    public function actionDeleteAllImage($product_id){

        if($product_id){
            ProductImage::deleteAll(['product_id'=> $product_id]);

            $this->afterDeleteAllImage($product_id);

            return $this->redirect(['image', 'product_id' => $product_id]);
        }
        else{
            return 'Error';
        }
    }

    public function actionIsActiveSetter($id){

        if (Yii::$app->request->isAjax) {

            $productImage = ProductImage::findOne(['id' => $id]);


            if($productImage->isActive === 1){
                $isActive = 0;
                $productImage->isActive = $isActive;
                $productImage->save(false);
            }else{
                $isActive = 1;
                $productImage->isActive = $isActive;
                $productImage->save(false);
            }

        }else{
            $isActive = "Ajax failed";
        }

        // return Json
        return \yii\helpers\Json::encode($isActive);

    }

    public function actionIsCoverSetter($id, $product_id)
    {

        if (Yii::$app->request->isAjax) {

            if ($id && $product_id) {

                $productCover = ProductImage::findOne([
                    'id' => $id,
                    'product_id' => $product_id
                ]);

                $productCover->isCover = 1;
                $productCover->save(false);

                $productCoverNotSet = ProductImage::find()->andWhere(['!=', 'id', $id])->andWhere(['product_id' => $product_id])->all();

                foreach ($productCoverNotSet as $cover) {
                    $cover->isCover = 0;
                    $cover->save(false);
                }
                $response = 'islem basarili';
            }

            /*echo $id . '</br>';

            echo '<pre>';
            var_dump($productCoverNotSet);
            echo '</pre>';*/

        }

        else {
            $response = "Ajax failed";
        }

        // return Json
        return \yii\helpers\Json::encode($response);

    }


    /**
     * Deletes an existing Product model.
     * @param string $product_id Product ID
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\ErrorException
     */
    public function actionDelete($product_id)
    {

        if (Yii::$app->request->isAjax) {

            if ($product_id) {

                $this->findModel($product_id)->delete();

                ProductImage::deleteAll(['product_id'=> $product_id]);

                $this->afterDeleteAllImage($product_id);

                return true;

                //return $this->redirect(['index']);

            }
        }
        else{
            return false;
        }

        return false;
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

    /**
     * @throws \yii\base\ErrorException
     */
    protected function afterImageDelete($img_url){
        $size = [
            'thumbs' => 'thumbs',
            '342x215' => '342x215',
            '1080x426' => '1080x426'
        ];

        if($img_url){

            $thumbsDir = Yii::getAlias('@frontend/web/storage/product/'.$size['thumbs'].'/'). dirname($img_url);
            $thumbsPath = Yii::getAlias('@frontend/web/storage/product/'.$size['thumbs'].'/'). $img_url;
            //FileHelper::removeDirectory($thumbsDir);

            $img342x215_Dir = Yii::getAlias('@frontend/web/storage/product/'.$size['342x215'].'/'). dirname($img_url);
            $img342x215_Path = Yii::getAlias('@frontend/web/storage/product/'.$size['342x215'].'/'). $img_url;
            //FileHelper::removeDirectory($img342x215_Dir);

            $img1080x426_Dir = Yii::getAlias('@frontend/web/storage/product/'.$size['1080x426'].'/'). dirname($img_url);
            $img1080x426_Path = Yii::getAlias('@frontend/web/storage/product/'.$size['1080x426'].'/'). $img_url;
            //FileHelper::removeDirectory($img1080x426_Dir);

            if (file_exists($thumbsPath) && file_exists($img342x215_Path) && file_exists($img1080x426_Path)) {
                unlink($thumbsPath);
                unlink($img342x215_Path);
                unlink($img1080x426_Path);
            }

            $thumbsFilesPath = FileHelper::findFiles($thumbsDir);
            $img342x215FilesPath = FileHelper::findFiles($img342x215_Dir);
            $img1080x426FilesPath = FileHelper::findFiles($img1080x426_Dir);

            if((count($thumbsFilesPath) === 0) && (count($img342x215FilesPath)=== 0) && (count($img1080x426FilesPath)=== 0)){
                FileHelper::removeDirectory($thumbsDir);
                FileHelper::removeDirectory($img342x215_Dir);
                FileHelper::removeDirectory($img1080x426_Dir);
            }
        }
    }

    /**
     * @throws \yii\base\ErrorException
     */
    protected function afterDeleteAllImage($product_id){

        $size = [
            'thumbs' => 'thumbs',
            '342x215' => '342x215',
            '1080x426' => '1080x426'
        ];

        if($product_id) {

            $thumbsDir = Yii::getAlias('@frontend/web/storage/product/' . $size['thumbs'] . '/') . $product_id;
            $img342x215_Dir = Yii::getAlias('@frontend/web/storage/product/' . $size['342x215'] . '/') . $product_id;
            $img1080x426_Dir = Yii::getAlias('@frontend/web/storage/product/' . $size['1080x426'] . '/') . $product_id;

            FileHelper::removeDirectory($thumbsDir);
            FileHelper::removeDirectory($img342x215_Dir);
            FileHelper::removeDirectory($img1080x426_Dir);
        }

    }

}
