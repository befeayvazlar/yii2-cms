<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property string $product_id
 * @property string $title
 * @property string|null $description
 * @property int|null $category_id
 * @property string|null $tags
 * @property int|null $rank
 * @property int $isActive
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Product extends \yii\db\ActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                //'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'title', 'isActive', 'description'], 'required'],
            [['description', 'tags'], 'string'],
            [['category_id', 'rank', 'isActive', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['product_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255],
            [['product_id'], 'unique'],
            ['rank', 'default', 'value' => 0],
            ['isActive', 'default', 'value' => self::STATUS_DRAFT],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'title' => 'Title',
            'description' => 'Description',
            'category_id' => 'Category',
            'tags' => 'Tags',
            'rank' => 'Rank',
            'isActive' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getStatusLabels(){
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published',
        ];

    }

    public static function getStatus()
    {
        return array(

            self::STATUS_DRAFT => 'Draft',

            self::STATUS_PUBLISHED => 'Published',

        );
    }


    /**
     * Gets query for [[Product Image]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductImageQuery
     */
    public function getProductImage()
    {
        return $this->hasOne(ProductImage::className(), ['product_id' => 'product_id'])->andWhere(['isCover' => 1]);
    }

    public function getProductImageLink($product_id){

        $productImageLink = ProductImage::find()
            ->alias('pi')
            ->innerJoin(Product::tableName().' p',
                'p.product_id = pi.product_id')
            ->andWhere(['pi.isCover' => 1])
            ->andWhere(['pi.product_id' => $product_id])
            ->one();

        if(!empty($productImageLink->img_url)){
            return ProductImage::formatThumbnailLink($productImageLink->img_url);
        }

        return ProductImage::formatThumbnailLink(null);

    }

    public static function getProductCategories(){
        return ArrayHelper::map(ProductCategories::findAll(['isActive'=> 1]), 'category_id', 'title');
    }

    /**
     * Gets query for [[CategoryId]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductCategoriesQueryQuery
     */
    public function getCategoryId()
    {
        return $this->hasOne(ProductCategories::className(), ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    /**
     * Finds product by product_id
     *
     * @param string $product_id
     * @return static|null
     */
    public function findByProductId($product_id)
    {
        return static::findOne(['product_id' => $product_id]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;

        if($isInsert){
            $this->product_id = Yii::$app->security->generateRandomString(8);
            //$this->title = $this->title;
        }

        $saved = parent::save($runValidation, $attributeNames);
        if(!$saved){
            return false;
        }

        return true;
    }
}
