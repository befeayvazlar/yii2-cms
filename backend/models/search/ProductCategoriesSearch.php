<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductCategories;

/**
 * ProductCategoriesSearch represents the model behind the search form of `common\models\ProductCategories`.
 */
class ProductCategoriesSearch extends ProductCategories
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'isActive', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'safe'],
            [['created_at', 'updated_at'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductCategories::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'isActive' => $this->isActive,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%d/%m/%Y")',
                $this->created_at
            ])
            ->andFilterWhere([
                'like',
                'FROM_UNIXTIME(updated_at, "%d/%m/%Y")',
                $this->updated_at
            ]);

        return $dataProvider;
    }
}
