<?php

namespace app\modules\erm\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\erm\models\MappingIntervensiIndikator as MappingIntervensiIndikatorModel;

/**
 * MappingIntervensiIndikator represents the model behind the search form of `app\modules\erm\models\MappingIntervensiIndikator`.
 */
class MappingIntervensiIndikator extends MappingIntervensiIndikatorModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'JENIS', 'INTERVENSI', 'STATUS'], 'integer'],
            [['INDIKATOR'], 'save'],
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
        $query = MappingIntervensiIndikatorModel::find();

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
            'INTERVENSI' => $this->INTERVENSI,
            'STATUS' => $this->STATUS,
        ]);

        return $dataProvider;
    }
}
