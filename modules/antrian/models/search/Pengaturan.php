<?php

namespace app\modules\antrian\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\antrian\models\Pengaturan as PengaturanModel;

/**
 * Pengaturan represents the model behind the search form of `app\modules\antrian\models\Pengaturan`.
 */
class Pengaturan extends PengaturanModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'LIMIT_DAFTAR', 'DURASI', 'STATUS', 'BATAS_MAX_HARI', 'BATAS_MAX_HARI_BPJS', 'MATAS_MAX_HARI_KONTROL'], 'integer'],
            [['MULAI', 'BATAS_JAM_AMBIL', 'POS_ANTRIAN', 'UPDATE_TIME'], 'safe'],
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
        $query = PengaturanModel::find();

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
            'LIMIT_DAFTAR' => $this->LIMIT_DAFTAR,
            'DURASI' => $this->DURASI,
            'MULAI' => $this->MULAI,
            'BATAS_JAM_AMBIL' => $this->BATAS_JAM_AMBIL,
            'STATUS' => $this->STATUS,
            'BATAS_MAX_HARI' => $this->BATAS_MAX_HARI,
            'BATAS_MAX_HARI_BPJS' => $this->BATAS_MAX_HARI_BPJS,
            'MATAS_MAX_HARI_KONTROL' => $this->MATAS_MAX_HARI_KONTROL,
            'UPDATE_TIME' => $this->UPDATE_TIME,
        ]);

        $query->andFilterWhere(['like', 'POS_ANTRIAN', $this->POS_ANTRIAN]);

        return $dataProvider;
    }
}
