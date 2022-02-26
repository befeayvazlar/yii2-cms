<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%product_images}}".
 *
 * @property int $id
 * @property string $product_id
 * @property string|null $img_url
 * @property int|null $rank
 * @property int $isActive
 * @property int $isCover
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Product $product
 * @property User $updatedBy
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /** @var UploadedFile[]
     */
    public $file;

    /**
     * @var UploadedFile
     */
    public $thumbnail;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_images}}';
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
            [['product_id', 'isActive', 'isCover'], 'required'],
            [['rank', 'isActive', 'isCover', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['product_id'], 'string', 'max' => 16],
            [['img_url'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'product_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'img_url' => 'Img Url',
            'rank' => 'Rank',
            'isActive' => 'Is Active',
            'isCover' => 'Is Cover',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
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
     * @return \common\models\query\ProductImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductImageQuery(get_called_class());
    }
}
