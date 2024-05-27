<?php

namespace app\modules\jaspel\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\jaspel\models\Kronis as KronisModel;

/**
 * Kronis represents the model behind the search form of `app\modules\jaspel\models\Kronis`.
 */
class Kronis extends KronisModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'publish'], 'integer'],
            [['idReg', 'noSep', 'createBy', 'createDate', 'updateBy', 'updateDate'], 'safe'],
            [['tarifKronis', 'klaimKronis'], 'number'],
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
        $query = KronisModel::find();

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
            'tarifKronis' => $this->tarifKronis,
            'klaimKronis' => $this->klaimKronis,
            'publish' => $this->publish,
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
        ]);

        $query->andFilterWhere(['like', 'idReg', $this->idReg])
            ->andFilterWhere(['like', 'noSep', $this->noSep])
            ->andFilterWhere(['like', 'createBy', $this->createBy])
            ->andFilterWhere(['like', 'updateBy', $this->updateBy]);

        return $dataProvider;
    }
}
