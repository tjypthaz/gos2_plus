<?php

namespace app\modules\ihs\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ihs\models\TindakanToLoinc as TindakanToLoincModel;

/**
 * TindakanToLoinc represents the model behind the search form of `app\modules\ihs\models\TindakanToLoinc`.
 */
class TindakanToLoinc extends TindakanToLoincModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TINDAKAN', 'LOINC_TERMINOLOGI', 'SPESIMENT', 'KATEGORI', 'STATUS'], 'integer'],
            [['namaTindakan', 'namaLoinc', 'namaSpesimen', 'namaKategori'], 'safe'],
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
        $query = TindakanToLoincModel::find()->alias('tl');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->leftJoin('master.tindakan mt','mt.ID = tl.TINDAKAN');
        $query->leftJoin('`kemkes-ihs`.`type_code_reference` spe','spe.id = tl.SPESIMENT and spe.type = 52');
        $query->leftJoin('`kemkes-ihs`.`type_code_reference` kat','kat.id = tl.KATEGORI and kat.type = 58');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'TINDAKAN' => $this->TINDAKAN,
            'LOINC_TERMINOLOGI' => $this->LOINC_TERMINOLOGI,
            'SPESIMENT' => $this->SPESIMENT,
            'KATEGORI' => $this->KATEGORI,
            'tl.STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'mt.NAMA', $this->namaTindakan])
            ->andFilterWhere(['like', 'spe.display', $this->namaSpesimen])
            ->andFilterWhere(['like', 'kat.display', $this->namaKategori]);

        return $dataProvider;
    }
}
