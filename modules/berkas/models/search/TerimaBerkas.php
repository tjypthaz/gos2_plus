<?php

namespace app\modules\berkas\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\berkas\models\TerimaBerkas as TerimaBerkasModel;

/**
 * TerimaBerkas represents the model behind the search form of `app\modules\berkas\models\TerimaBerkas`.
 */
class TerimaBerkas extends TerimaBerkasModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'TERIMA', 'KASUS_KHUSUS', 'INFORMED_CONSENT','noRm', 'RESUME_MEDIS', 'OLEH', 'STATUS'], 'integer'],
            [['NOPEN', 'TGL_TERIMA', 'KETERANGAN', 'TGL_KEMBALI', 'RUANGAN_KEMBALI'], 'safe'],
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
        $query = TerimaBerkasModel::find()->where(['terima_berkas.STATUS' => '1']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['ID' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->leftJoin('pendaftaran.pendaftaran','terima_berkas.NOPEN = pendaftaran.NOMOR');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'TERIMA' => $this->TERIMA,
            'KASUS_KHUSUS' => $this->KASUS_KHUSUS,
            'INFORMED_CONSENT' => $this->INFORMED_CONSENT,
            'RESUME_MEDIS' => $this->RESUME_MEDIS,
            'TGL_KEMBALI' => $this->TGL_KEMBALI,
            'OLEH' => $this->OLEH,
            //'STATUS' => $this->STATUS,
            'pendaftaran.NORM' => $this->noRm
        ]);




        $query->andFilterWhere(['like', 'NOPEN', $this->NOPEN])
            ->andFilterWhere(['like', 'TGL_TERIMA', $this->TGL_TERIMA])
            ->andFilterWhere(['like', 'KETERANGAN', $this->KETERANGAN])
            ->andFilterWhere(['like', 'RUANGAN_KEMBALI', $this->RUANGAN_KEMBALI]);

        return $dataProvider;
    }
}
