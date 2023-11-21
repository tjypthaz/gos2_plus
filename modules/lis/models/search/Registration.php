<?php

namespace app\modules\lis\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lis\models\Registration as RegistrationModel;

/**
 * Registration represents the model behind the search form of `app\modules\lis\models\Registration`.
 */
class Registration extends RegistrationModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patient_id', 'patient_name', 'visit_number', 'order_number', 'order_datetime', 'diagnose_id', 'diagnose_name', 'service_unit_id', 'service_unit_name', 'guarantor_id', 'guarantor_name', 'agreement_name', 'doctor_id', 'doctor_name', 'class_id', 'class_name', 'ward_id', 'ward_name', 'room_id', 'room_name', 'bed_id', 'bed_name', 'reg_user_id', 'reg_user_name', 'lis_reg_no', 'retrieved_dt', 'retrieved_flag'], 'safe'],
            [['agreement_id'], 'integer'],
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
        $query = RegistrationModel::find();

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
        $query->leftJoin(['demographics'],"demographics.patient_id = registration.patient_id");

        // grid filtering conditions
        $query->andFilterWhere([
            'order_datetime' => $this->order_datetime,
            'agreement_id' => $this->agreement_id,
            'retrieved_dt' => $this->retrieved_dt,
        ]);

        $query->andFilterWhere(['like', 'patient_id', $this->patient_id])
            ->andFilterWhere(['like', 'visit_number', $this->visit_number])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'diagnose_id', $this->diagnose_id])
            ->andFilterWhere(['like', 'diagnose_name', $this->diagnose_name])
            ->andFilterWhere(['like', 'service_unit_id', $this->service_unit_id])
            ->andFilterWhere(['like', 'service_unit_name', $this->service_unit_name])
            ->andFilterWhere(['like', 'guarantor_id', $this->guarantor_id])
            ->andFilterWhere(['like', 'guarantor_name', $this->guarantor_name])
            ->andFilterWhere(['like', 'agreement_name', $this->agreement_name])
            ->andFilterWhere(['like', 'doctor_id', $this->doctor_id])
            ->andFilterWhere(['like', 'doctor_name', $this->doctor_name])
            ->andFilterWhere(['like', 'class_id', $this->class_id])
            ->andFilterWhere(['like', 'class_name', $this->class_name])
            ->andFilterWhere(['like', 'ward_id', $this->ward_id])
            ->andFilterWhere(['like', 'ward_name', $this->ward_name])
            ->andFilterWhere(['like', 'room_id', $this->room_id])
            ->andFilterWhere(['like', 'room_name', $this->room_name])
            ->andFilterWhere(['like', 'bed_id', $this->bed_id])
            ->andFilterWhere(['like', 'bed_name', $this->bed_name])
            ->andFilterWhere(['like', 'reg_user_id', $this->reg_user_id])
            ->andFilterWhere(['like', 'reg_user_name', $this->reg_user_name])
            ->andFilterWhere(['like', 'lis_reg_no', $this->lis_reg_no])
            ->andFilterWhere(['like', 'retrieved_flag', $this->retrieved_flag])
            ->andFilterWhere(['like', 'demographics.patient_name', $this->patient_name])
        ->orderBy(['order_datetime' => SORT_DESC]);

        return $dataProvider;
    }
}
