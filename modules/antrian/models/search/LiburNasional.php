<?php

namespace app\modules\antrian\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\antrian\models\LiburNasional as LiburNasionalModel;

/**
 * LiburNasional represents the model behind the search form of `app\modules\antrian\models\LiburNasional`.
 */
class LiburNasional extends LiburNasionalModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'OLEH', 'STATUS'], 'integer'],
            [['TANGGAL_LIBUR', 'KETERANGAN', 'TANGGAL'], 'safe'],
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
        $query = LiburNasionalModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['TANGGAL_LIBUR' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'TANGGAL_LIBUR' => $this->TANGGAL_LIBUR,
            'TANGGAL' => $this->TANGGAL,
            'OLEH' => $this->OLEH,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KETERANGAN', $this->KETERANGAN]);

        return $dataProvider;
    }
}
