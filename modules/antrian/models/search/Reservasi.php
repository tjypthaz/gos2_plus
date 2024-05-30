<?php

namespace app\modules\antrian\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\antrian\models\Reservasi as ReservasiModel;

/**
 * Reservasi represents the model behind the search form of `app\modules\antrian\models\Reservasi`.
 */
class Reservasi extends ReservasiModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'TANGGALKUNJUNGAN', 'TANGGAL_REF', 'NIK', 'NAMA', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR', 'ALAMAT', 'INSTANSI_ASAL', 'JK', 'WILAYAH', 'POLI_BPJS', 'REF_POLI_RUJUKAN', 'DOKTER', 'CARABAYAR', 'NO_KARTU_BPJS', 'CONTACT', 'TGL_DAFTAR', 'JAM', 'JAM_PELAYANAN', 'ESTIMASI_PELAYANAN', 'POS_ANTRIAN', 'NO_REF_BPJS', 'REF', 'SEP', 'JAM_PRAKTEK', 'WAKTU_CHECK_IN', 'UPDATE_TIME'], 'safe'],
            [['NORM', 'PEKERJAAN', 'PROFESI', 'POLI', 'JENIS_KUNJUNGAN', 'NO', 'ANTRIAN_POLI', 'NOMOR_ANTRIAN', 'JENIS', 'JADWAL_DOKTER', 'JENIS_REF_BPJS', 'JENIS_REQUEST_BPJS', 'POLI_EKSEKUTIF_BPJS', 'RAWAT_INAP', 'JENIS_APLIKASI', 'STATUS', 'REF_JADWAL', 'LOKET_RESPON', 'VAKSIN_KE'], 'integer'],
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
        $query = ReservasiModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['TANGGAL_REF' => SORT_DESC]
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
            'TANGGALKUNJUNGAN' => $this->TANGGALKUNJUNGAN,
            'TANGGAL_REF' => $this->TANGGAL_REF,
            'NORM' => $this->NORM,
            'TANGGAL_LAHIR' => $this->TANGGAL_LAHIR,
            'PEKERJAAN' => $this->PEKERJAAN,
            'PROFESI' => $this->PROFESI,
            'POLI' => $this->POLI,
            'JENIS_KUNJUNGAN' => $this->JENIS_KUNJUNGAN,
            'TGL_DAFTAR' => $this->TGL_DAFTAR,
            'NO' => $this->NO,
            'ANTRIAN_POLI' => $this->ANTRIAN_POLI,
            'NOMOR_ANTRIAN' => $this->NOMOR_ANTRIAN,
            'JENIS' => $this->JENIS,
            'JADWAL_DOKTER' => $this->JADWAL_DOKTER,
            'JENIS_REF_BPJS' => $this->JENIS_REF_BPJS,
            'JENIS_REQUEST_BPJS' => $this->JENIS_REQUEST_BPJS,
            'POLI_EKSEKUTIF_BPJS' => $this->POLI_EKSEKUTIF_BPJS,
            'RAWAT_INAP' => $this->RAWAT_INAP,
            'JENIS_APLIKASI' => $this->JENIS_APLIKASI,
            'STATUS' => $this->STATUS,
            'REF_JADWAL' => $this->REF_JADWAL,
            'WAKTU_CHECK_IN' => $this->WAKTU_CHECK_IN,
            'LOKET_RESPON' => $this->LOKET_RESPON,
            'UPDATE_TIME' => $this->UPDATE_TIME,
            'VAKSIN_KE' => $this->VAKSIN_KE,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'TEMPAT_LAHIR', $this->TEMPAT_LAHIR])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'INSTANSI_ASAL', $this->INSTANSI_ASAL])
            ->andFilterWhere(['like', 'JK', $this->JK])
            ->andFilterWhere(['like', 'WILAYAH', $this->WILAYAH])
            ->andFilterWhere(['like', 'POLI_BPJS', $this->POLI_BPJS])
            ->andFilterWhere(['like', 'REF_POLI_RUJUKAN', $this->REF_POLI_RUJUKAN])
            ->andFilterWhere(['like', 'DOKTER', $this->DOKTER])
            ->andFilterWhere(['like', 'CARABAYAR', $this->CARABAYAR])
            ->andFilterWhere(['like', 'NO_KARTU_BPJS', $this->NO_KARTU_BPJS])
            ->andFilterWhere(['like', 'CONTACT', $this->CONTACT])
            ->andFilterWhere(['like', 'JAM', $this->JAM])
            ->andFilterWhere(['like', 'JAM_PELAYANAN', $this->JAM_PELAYANAN])
            ->andFilterWhere(['like', 'ESTIMASI_PELAYANAN', $this->ESTIMASI_PELAYANAN])
            ->andFilterWhere(['like', 'POS_ANTRIAN', $this->POS_ANTRIAN])
            ->andFilterWhere(['like', 'NO_REF_BPJS', $this->NO_REF_BPJS])
            ->andFilterWhere(['like', 'REF', $this->REF])
            ->andFilterWhere(['like', 'SEP', $this->SEP])
            ->andFilterWhere(['like', 'JAM_PRAKTEK', $this->JAM_PRAKTEK]);

        return $dataProvider;
    }
}
