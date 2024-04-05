<?php

namespace app\modules\pembayaran\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pembayaran\models\H2h as H2hModel;

/**
 * H2h represents the model behind the search form of `app\modules\pembayaran\models\H2h`.
 */
class H2h extends H2hModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'noRm'], 'integer'],
            [['idTagihan', 'status', 'publish', 'createBy', 'createDate', 'updateBy', 'updateDate'], 'safe'],
            [['totalTagihan', 'bayar'], 'number'],
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
        $query = H2hModel::find();

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
            'noRm' => $this->noRm,
            'totalTagihan' => $this->totalTagihan,
            'bayar' => $this->bayar,
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
        ]);

        $query->andFilterWhere(['like', 'idTagihan', $this->idTagihan])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'publish', $this->publish])
            ->andFilterWhere(['like', 'createBy', $this->createBy])
            ->andFilterWhere(['like', 'updateBy', $this->updateBy]);

        return $dataProvider;
    }
}
