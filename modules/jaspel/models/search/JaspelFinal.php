<?php

namespace app\modules\jaspel\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\jaspel\models\JaspelFinal as JaspelFinalModel;

/**
 * JaspelFinal represents the model behind the search form of `app\modules\jaspel\models\JaspelFinal`.
 */
class JaspelFinal extends JaspelFinalModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idJaspel', 'idDokterO', 'idDokterL', 'idPara'], 'integer'],
            [['idRuangan', 'ruangan', 'tindakan', 'namaDokterO', 'namaDokterL', 'jenisPara'], 'safe'],
            [['jpDokterO', 'jpDokterL', 'jpPara', 'jpStruktural', 'jpBlud', 'jpPegawai'], 'number'],
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
        $query = JaspelFinalModel::find();

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
            'idJaspel' => $this->idJaspel,
            'idDokterO' => $this->idDokterO,
            'idDokterL' => $this->idDokterL,
            'idPara' => $this->idPara,
            'jpDokterO' => $this->jpDokterO,
            'jpDokterL' => $this->jpDokterL,
            'jpPara' => $this->jpPara,
            'jpStruktural' => $this->jpStruktural,
            'jpBlud' => $this->jpBlud,
            'jpPegawai' => $this->jpPegawai,
        ]);

        $query->andFilterWhere(['like', 'idRuangan', $this->idRuangan])
            ->andFilterWhere(['like', 'ruangan', $this->ruangan])
            ->andFilterWhere(['like', 'tindakan', $this->tindakan])
            ->andFilterWhere(['like', 'namaDokterO', $this->namaDokterO])
            ->andFilterWhere(['like', 'namaDokterL', $this->namaDokterL])
            ->andFilterWhere(['like', 'jenisPara', $this->jenisPara]);

        return $dataProvider;
    }
}
