<?php

namespace app\modules\pembayaran\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pembayaran\models\JenisAmbulan as JenisAmbulanModel;

/**
 * JenisAmbulan represents the model behind the search form of `app\modules\pembayaran\models\JenisAmbulan`.
 */
class JenisAmbulan extends JenisAmbulanModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jsProp', 'jpProp'], 'integer'],
            [['deskripsi', 'publish', 'createDate', 'createBy', 'updateDate', 'updateBy'], 'safe'],
            [['hargaPerKM'], 'number'],
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
        $query = JenisAmbulanModel::find();

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
            'jsProp' => $this->jsProp,
            'jpProp' => $this->jpProp,
            'hargaPerKM' => $this->hargaPerKM,
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
        ]);

        $query->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'publish', $this->publish])
            ->andFilterWhere(['like', 'createBy', $this->createBy])
            ->andFilterWhere(['like', 'updateBy', $this->updateBy]);

        return $dataProvider;
    }
}
