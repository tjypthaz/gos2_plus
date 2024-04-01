<?php

namespace app\modules\pembayaran\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pembayaran\models\TagihanAmbulan as TagihanAmbulanModel;

/**
 * TagihanAmbulan represents the model behind the search form of `app\modules\pembayaran\models\TagihanAmbulan`.
 */
class TagihanAmbulan extends TagihanAmbulanModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idJenisAmbulan', 'idTagihan', 'noRm', 'kilometer'], 'integer'],
            [['tanggal', 'namaPasien', 'status', 'publish', 'createDate', 'createBy', 'updateDate', 'updateBy'], 'safe'],
            [['jasaSarana', 'jasaPelayanan', 'tarif'], 'number'],
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
        $query = TagihanAmbulanModel::find();

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
            'idJenisAmbulan' => $this->idJenisAmbulan,
            'idTagihan' => $this->idTagihan,
            'tanggal' => $this->tanggal,
            'noRm' => $this->noRm,
            'kilometer' => $this->kilometer,
            'jasaSarana' => $this->jasaSarana,
            'jasaPelayanan' => $this->jasaPelayanan,
            'tarif' => $this->tarif,
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
        ]);

        $query->andFilterWhere(['like', 'namaPasien', $this->namaPasien])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'publish', $this->publish])
            ->andFilterWhere(['like', 'createBy', $this->createBy])
            ->andFilterWhere(['like', 'updateBy', $this->updateBy]);

        return $dataProvider;
    }
}
