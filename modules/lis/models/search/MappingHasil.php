<?php

namespace app\modules\lis\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lis\models\MappingHasil as MappingHasilModel;

/**
 * MappingHasil represents the model behind the search form of `app\modules\lis\models\MappingHasil`.
 */
class MappingHasil extends MappingHasilModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'VENDOR_LIS', 'HIS_KODE_TEST', 'PARAMETER_TINDAKAN_LAB'], 'integer'],
            [['LIS_KODE_TEST', 'PREFIX_KODE'], 'safe'],
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
        $query = MappingHasilModel::find();

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
            'ID' => $this->ID,
            'VENDOR_LIS' => $this->VENDOR_LIS,
            'HIS_KODE_TEST' => $this->HIS_KODE_TEST,
            'PARAMETER_TINDAKAN_LAB' => $this->PARAMETER_TINDAKAN_LAB,
        ]);

        $query->andFilterWhere(['like', 'LIS_KODE_TEST', $this->LIS_KODE_TEST])
            ->andFilterWhere(['like', 'PREFIX_KODE', $this->PREFIX_KODE]);

        return $dataProvider;
    }
}
