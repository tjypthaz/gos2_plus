<?php

namespace app\modules\erm\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\erm\models\JenisIndikatorKeperawatan as JenisIndikatorKeperawatanModel;

/**
 * JenisIndikatorKeperawatan represents the model behind the search form of `app\modules\erm\models\JenisIndikatorKeperawatan`.
 */
class JenisIndikatorKeperawatan extends JenisIndikatorKeperawatanModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
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
        $query = JenisIndikatorKeperawatanModel::find();

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
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'DESKRIPSI', $this->DESKRIPSI]);

        return $dataProvider;
    }
}
