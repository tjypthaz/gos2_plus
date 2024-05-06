<?php

namespace app\modules\antrian\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\antrian\models\JadwalDokterHfis as JadwalDokterHfisModel;

/**
 * JadwalDokterHfis represents the model behind the search form of `app\modules\antrian\models\JadwalDokterHfis`.
 */
class JadwalDokterHfis extends JadwalDokterHfisModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'HARI', 'KAPASITAS', 'KOUTA_JKN', 'KOUTA_NON_JKN', 'LIBUR', 'STATUS'], 'integer'],
            [['KD_DOKTER', 'NM_DOKTER', 'KD_SUB_SPESIALIS', 'KD_POLI', 'TANGGAL', 'NM_HARI', 'JAM', 'JAM_MULAI', 'JAM_SELESAI', 'INPUT_TIME', 'UPDATE_TIME'], 'safe'],
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
        $query = JadwalDokterHfisModel::find();

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
            'HARI' => $this->HARI,
            'TANGGAL' => $this->TANGGAL,
            'JAM_MULAI' => $this->JAM_MULAI,
            'JAM_SELESAI' => $this->JAM_SELESAI,
            'KAPASITAS' => $this->KAPASITAS,
            'KOUTA_JKN' => $this->KOUTA_JKN,
            'KOUTA_NON_JKN' => $this->KOUTA_NON_JKN,
            'LIBUR' => $this->LIBUR,
            'STATUS' => $this->STATUS,
            'INPUT_TIME' => $this->INPUT_TIME,
            'UPDATE_TIME' => $this->UPDATE_TIME,
        ]);

        $query->andFilterWhere(['like', 'KD_DOKTER', $this->KD_DOKTER])
            ->andFilterWhere(['like', 'NM_DOKTER', $this->NM_DOKTER])
            ->andFilterWhere(['like', 'KD_SUB_SPESIALIS', $this->KD_SUB_SPESIALIS])
            ->andFilterWhere(['like', 'KD_POLI', $this->KD_POLI])
            ->andFilterWhere(['like', 'NM_HARI', $this->NM_HARI])
            ->andFilterWhere(['like', 'JAM', $this->JAM]);

        return $dataProvider;
    }
}
