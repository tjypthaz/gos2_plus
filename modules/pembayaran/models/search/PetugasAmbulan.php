<?php

namespace app\modules\pembayaran\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pembayaran\models\PetugasAmbulan as PetugasAmbulanModel;

/**
 * PetugasAmbulan represents the model behind the search form of `app\modules\pembayaran\models\PetugasAmbulan`.
 */
class PetugasAmbulan extends PetugasAmbulanModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idTagihanAmbulan', 'idPegawai'], 'integer'],
            [['publish', 'createDate', 'createBy', 'updateDate', 'updateBy'], 'safe'],
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
        $query = PetugasAmbulanModel::find();

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
            'id' => $this->id,
            'idTagihanAmbulan' => $this->idTagihanAmbulan,
            'idPegawai' => $this->idPegawai,
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
        ]);

        $query->andFilterWhere(['like', 'publish', $this->publish])
            ->andFilterWhere(['like', 'createBy', $this->createBy])
            ->andFilterWhere(['like', 'updateBy', $this->updateBy]);

        return $dataProvider;
    }
}
