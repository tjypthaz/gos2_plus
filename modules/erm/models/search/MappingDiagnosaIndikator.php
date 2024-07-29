<?php

namespace app\modules\erm\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\erm\models\MappingDiagnosaIndikator as MappingDiagnosaIndikatorModel;

/**
 * MappingDiagnosaIndikator represents the model behind the search form of `app\modules\erm\models\MappingDiagnosaIndikator`.
 */
class MappingDiagnosaIndikator extends MappingDiagnosaIndikatorModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'JENIS', 'DIAGNOSA', 'STATUS'], 'integer'],
            [['INDIKATOR'], 'safe'],
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
        $query = MappingDiagnosaIndikatorModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
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
            'JENIS' => $this->JENIS,
            'INDIKATOR' => $this->INDIKATOR,
            'DIAGNOSA' => $this->DIAGNOSA,
            'STATUS' => $this->STATUS,
        ]);

        return $dataProvider;
    }
}
