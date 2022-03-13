<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ProductCategories]].
 *
 * @see \common\models\ProductCategories
 */
class ProductCategoriesQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[isActive]]=1');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProductCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProductCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
