<?php

namespace app\modules\erm\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\erm\models\IndikatorKeperawatan as IndikatorKeperawatanModel;

/**
 * IndikatorKeperawatan represents the model behind the search form of `app\modules\erm\models\IndikatorKeperawatan`.
 */
class IndikatorKeperawatan extends IndikatorKeperawatanModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JENIS', 'ID', 'STATUS'], 'integer'],
            [['DESKRIPSI'], 'safe'],
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
        $query = IndikatorKeperawatanModel::find();

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
            'JENIS' => $this->JENIS,
            'ID' => $this->ID,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'DESKRIPSI', $this->DESKRIPSI]);

        return $dataProvider;
    }
}
