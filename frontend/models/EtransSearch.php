<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Etrans;

/**
 * EtransSearch represents the model behind the search form of `frontend\models\Etrans`.
 */
class EtransSearch extends Etrans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'trans_from', 'trans_to', 'date'], 'integer'],
            [['amount'], 'number'],
            [['type', 'reason', 'status'], 'safe'],
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
    public function search($params, $page='')
    {
        $query = Etrans::find();

        // add conditions that should always apply here
        
        if($page==='creport') {
            $query->andWhere([
                'type' => 'credit',
                'status' => 'Approved',
            ]);
            $query->andWhere(['or', 
                ['reason' => 'Referral Bonus'],
                ['reason' => 'Binary Bonus'],
            ]);
        }
        else if($page=='preport') {
            $query->andWhere([
                'type' => 'debit',
                'status' => 'Approved',
                'reason' => 'Payout Release'
            ]);
        }
        else if($page=='earned') {
            $query->andWhere([
                'trans_to' => Yii::$app->user->identity->id,
                'type' => 'credit',
                'status' => 'Approved'
            ]);
        }
        else if($page=='released') {
            $query->andWhere([
                'trans_to' => Yii::$app->user->identity->id,
                'type' => 'debit',
                'status' => 'Approved',
                'reason' => 'Payout Release'
            ]);
        }
        else if($page=='history') {
            $query->andWhere([
                'trans_to' => Yii::$app->user->identity->id,
                'status' => 'Approved',
            ]);
        }
        else if($page=='userCom') {
            $query->andWhere([
                'trans_to' => Yii::$app->user->identity->id,
                'type' => 'credit',
                'status' => 'Approved'
            ]);
            $query->andWhere(['or', 
                ['reason' => 'Referral Bonus'],
                ['reason' => 'Binary Bonus'],
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 8
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
            'id' => $this->id,
            'trans_from' => $this->trans_from,
            'trans_to' => $this->trans_to,
            'amount' => $this->amount,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function confirmtrans($params)
    {
        $query = Etrans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
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
            'trans_from' => $this->trans_from,
            'trans_to' => $this->trans_to,
            'amount' => $this->amount,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'status', $this->status]);
        
        $query->andFilterWhere([
            'reason' => 'Payout Release',
            'type' => 'debit',
            'status' => 'Pending'
        ]);

        return $dataProvider;
    }
    
    public function transhistory($params)
    {
        $query = Etrans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
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
            'trans_from' => $this->trans_from,
            'trans_to' => $this->trans_to,
            'amount' => $this->amount,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'status', $this->status]);
        
        $query->andFilterWhere([
            'reason' => 'Fund Transfer',
            'type' => 'credit',
            'status' => 'Approved'
        ]);

        return $dataProvider;
    }
}
