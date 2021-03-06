<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ProductImage]].
 *
 * @see \common\models\ProductImage
 */
class ProductImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ProductImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProductImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function isNotActiveCover($id, $product_id){

        return $this->andWhere([['id' => $id]], ['product_id' => $product_id]);

    }

}
