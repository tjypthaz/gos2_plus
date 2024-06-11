<?php

namespace app\modules\ihs\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ihs\models\ParameterHasilToLoinc as ParameterHasilToLoincModel;

/**
 * ParameterHasilToLoinc represents the model behind the search form of `app\modules\ihs\models\ParameterHasilToLoinc`.
 */
class ParameterHasilToLoinc extends ParameterHasilToLoincModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PARAMETER_HASIL', 'LOINC_TERMINOLOGI', 'STATUS'], 'integer'],
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
        $query = ParameterHasilToLoincModel::find();

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
            'PARAMETER_HASIL' => $this->PARAMETER_HASIL,
            'LOINC_TERMINOLOGI' => $this->LOINC_TERMINOLOGI,
            'STATUS' => $this->STATUS,
        ]);

        return $dataProvider;
    }
}
